<?php

declare(strict_types=1);

namespace App\Actions\Transaction;

use App\Enums\TransactionPaginateType;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginateTransactionsRecords
{
    public static function run(Request $request, TransactionPaginateType $type): LengthAwarePaginator | false
    {        
        $builder = match($type) {
            TransactionPaginateType::ALL => self::getAll(),
            TransactionPaginateType::PENDING => self::getPending(),
            TransactionPaginateType::GROUPED => self::getGrouped(),
            default => self::getAll(),
        };
        /** @var LengthAwarePaginator */
        $transactions = $builder
                            ->when(
                                $request->input('search'),
                                function(Builder $builder, ?string $search): void {
                                    $builder
                                        ->where(function(Builder $builder) use($search): void {
                                            $builder
                                                ->where('group_id', 'LIKE', '%'.$search.'%')
                                                ->orWhere('description', 'LIKE', '%'.$search.'%');
                                        });
                                }
                            )
                            ->when(
                                $request->input('segment_id'),
                                fn(Builder $builder, ?int $segment_id): Builder => $builder->where('segment_id', $segment_id),
                            )
                            ->paginate((int) ($request->query('items') ?? 20));
        
        if ($transactions->isEmpty() && $request->query('items') && $request->query('page')) {
            return false;
        }

        if ($type === TransactionPaginateType::GROUPED)
            $transactions->setCollection(
                $transactions->getCollection()->map(fn(Transaction $transation) => $transation->makeHidden('segment_name'))
            );

        return $transactions;
    }

    public static function getAll(): Builder
    {
        return Transaction::query()
                    ->orderBy('created_at', 'desc');
    }

    public static function getPending(): Builder
    {
        return Transaction::query()
                    ->orderBy('valid_at')
                    ->where('pending', true);
    }

    public static function getGrouped(): Builder
    {
        return Transaction::query()
                    ->selectRaw(<<<SQL
                        transactions.group_id AS t_group_id,
                        MAX(transactions.created_at) AS last_transaction_date,
                        (SELECT COUNT(id) FROM transactions WHERE group_id = t_group_id) AS count,
                        segments.name
                        SQL
                    )
                    ->join('segments', 'transactions.segment_id', '=', 'segments.id')
                    ->whereNotNull('transactions.group_id')
                    ->groupBy('t_group_id', 'segments.name')
                    ->orderBy('last_transaction_date', 'desc');
    }
}
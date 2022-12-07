<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\TransactionType;
use App\Models\Casts\Currency;
use App\Traits\CanDeleteRestoreModel;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Segment extends Model
{
    use HasFactory, SoftDeletes, CanDeleteRestoreModel;

    protected $fillable = [
        'id',
        'name',
    ];

    protected $appends = [
        'active',
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public static function getAll(bool $with_trashed = false, bool $omit_default = false): Collection
    {
        $builder = $with_trashed ? static::withTrashed() : static::query();
        return $builder
                    ->orderBy('name')
                    ->when(
                        $omit_default,
                        fn(Builder $builder): Builder => $builder->where('id', '!=', 1),
                    )
                    ->get([
                        'id',
                        'name',
                        'deleted_at',
                    ]);
    }

    protected function active(): Attribute
    {
        return new Attribute(
            get: fn(): bool => !((bool) $this->deleted_at),
        );
    }

    public function getFilteredTransactions(array $data): Collection
    {
        $builder = $this->id === 1 ? Transaction::query() : $this->transactions();
        return $builder
                    ->whereBetween(
                        'created_at',
                        [
                            $data['initial_date'],
                            $data['final_date'],
                        ],
                    )
                    ->where('pending', false)
                    ->orderBy('created_at')
                    ->get();
    }

    public function getBalanceAtDate(string|DateTime $date): string
    {
        $builder = $this->id === 1 ? Transaction::query() : $this->transactions();
        $transactions = $builder
                            ->where('created_at', '<', $date)
                            ->where('pending', false)
                            ->get([
                                'amount',
                                'type',
                            ]);
        $balance = (float) $transactions->reduce(
                                function(float $total, Transaction $transaction): float {
                                    return $transaction->type === TransactionType::OUT->value ?
                                        $total -= $transaction->getRawOriginal('amount') :
                                        $total += $transaction->getRawOriginal('amount');
                                },
                                0
                            );
        return Currency::format($balance);
    }

    public static function createAndReturnId(array $data): int
    {
        $segment = self::query()
                        ->create($data);
        return $segment->id;
    }

    public static function getBalances(): array
    {
        $balances = [];
        /** @var self */
        foreach (self::getAll(true) as $segment) {
            $balances[] = [
                'segment_name' => $segment->name,
                'amount' => $segment->getBalanceAtDate(now()),
            ];
        }
        return $balances;
    }
}

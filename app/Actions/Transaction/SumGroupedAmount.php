<?php

declare(strict_types=1);

namespace App\Actions\Transaction;

use App\Enums\TransactionType;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;

class SumGroupedAmount
{
    public static function sum(TransactionType $transaction_type, Collection $transactions): float
    {
        return (float) $transactions->reduce(
            function(float $total, Transaction $transaction) use($transaction_type): float {
                return $transaction->type === $transaction_type->value && !$transaction->pending ?
                            ($total += $transaction->getRawOriginal('amount')) :
                            $total;
            },
            0
        );
    }
}
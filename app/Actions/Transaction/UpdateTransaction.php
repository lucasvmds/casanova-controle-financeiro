<?php

declare(strict_types=1);

namespace App\Actions\Transaction;

use App\Models\Transaction;

class UpdateTransaction
{
    public static function update(Transaction $transaction, array $data): void
    {
        if (!$data['created_at'])
            $data['created_at'] = now();
        $transaction->update($data);
    }
}
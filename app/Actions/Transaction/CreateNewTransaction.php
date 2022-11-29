<?php

declare(strict_types=1);

namespace App\Actions\Transaction;

use App\Models\Transaction;

class CreateNewTransaction
{
    public static function create(array $data): void
    {
        if ($data['created_at']) {
            $data['updated_at'] = $data['created_at'];
        } else {
            unset($data['created_at']);
        }
        Transaction::query()
            ->create($data);
    }
}
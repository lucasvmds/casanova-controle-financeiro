<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\TransactionType;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'description' => ucfirst(fake()->text(40)),
            'type' => fake()->randomElement(TransactionType::cases()),
            'amount' => fake()->numberBetween(0, 999999),
        ];
    }
}

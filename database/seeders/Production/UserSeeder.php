<?php

declare(strict_types=1);

namespace Database\Seeders\Production;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::query()
            ->create([
                'name' => 'Administrador',
                'email' => 'dev@developer',
                'password' => Hash::make('Ab123456789@'),
            ]);
        if (app()->environment() !== 'production') {
            User::factory(20)
                ->create();
        }
    }
}

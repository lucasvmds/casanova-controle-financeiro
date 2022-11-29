<?php

namespace Database\Seeders\Production;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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

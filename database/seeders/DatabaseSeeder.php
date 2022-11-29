<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Seeders\Develop\SegmentSeeder;
use Database\Seeders\Develop\TransactionSeeder;
use Database\Seeders\Production\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $local_seeders = [
            SegmentSeeder::class,
        ];
        
        $this->call([
            UserSeeder::class,
            ...(app()->environment() !== 'production' ? $local_seeders : []),
        ]);
    }
}

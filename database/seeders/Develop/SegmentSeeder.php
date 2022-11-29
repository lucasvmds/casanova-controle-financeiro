<?php

declare(strict_types=1);

namespace Database\Seeders\Develop;

use App\Models\Segment;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SegmentSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        Segment::factory(5)
            ->has(Transaction::factory(10))
            ->create();
    }
}

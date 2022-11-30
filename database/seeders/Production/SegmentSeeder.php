<?php

declare(strict_types=1);

namespace Database\Seeders\Production;

use App\Models\Segment;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SegmentSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        Segment::query()
            ->create([
                'id' => 1,
                'name' => 'Empreendimentos',
            ]);
        
        if (app()->environment() !== 'production')
            Segment::factory(4)
                ->has(Transaction::factory(10))
                ->create();
    }
}

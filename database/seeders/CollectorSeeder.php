<?php

namespace Database\Seeders;

use App\Models\Collector;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CollectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $collectors = [
            ['name' => 'NewsAPI', 'code' => 1],
            ['name' => 'NYNews', 'code' => 2],
            ['name' => 'GUARDIAN', 'code' => 3],
        ];

        foreach ($collectors as $collector) {
            Collector::create($collector);
        }
    }
}

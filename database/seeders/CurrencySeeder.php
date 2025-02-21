<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('currencies')->insert([
            [
                'code' => 'EUR',
                'rate_to_gel' => 2.9,
            ],
            [
                'code' => 'USD',
                'rate_to_gel' => 2.8,
            ],
            [
                'code' => 'GEL',
                'rate_to_gel' => 1,
            ],
        ]);
    }
}

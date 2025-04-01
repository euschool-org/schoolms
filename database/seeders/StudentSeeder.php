<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('students')->insert([
                'name' => 'გიორგი გორგაძე',
                'private_number' => '01010010101',
                'first_parent_email' => 'datigabashvili@gmail.com',
                'first_parent_number' => '558248843',
                'payment_code' => 'ES35911916'
        ]);
    }
}

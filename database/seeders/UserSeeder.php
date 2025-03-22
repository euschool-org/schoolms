<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
            'name' => 'admin2',
            'email' => 'datigabashvili@gmail.com',
            'password' => Hash::make('Legacy200!')
            ],
            [
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('Password123!')
            ]
        ]);
    }
}

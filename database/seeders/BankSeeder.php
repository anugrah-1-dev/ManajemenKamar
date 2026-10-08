<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('banks')->insert([
            [
                'name' => 'BNI',
                'owner' => 'Dayum',
                'number' => '92125215719',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
    public function runMany(): void
    {
        DB::table('banks')->insert([
            [
                'name' => 'BNI',
                'owner' => 'Dayum',
                'number' => '92125215719',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'BRI',
                'owner' => 'Siti',
                'number' => '1234567890',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'BCA',
                'owner' => 'Andi',
                'number' => '9876543210',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mandiri',
                'owner' => 'Rina',
                'number' => '555666777',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}

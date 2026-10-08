<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DeveloperUserSeeder extends Seeder
{
    public function run()
    {
        // Buat user developer
        $developer = User::firstOrCreate([
            'email' => 'DeveloperBrilliant@gmail.com',
        ], [
            'name' => 'developer',
            'password' => bcrypt('devtest!'),
        ]);

        // Buat role developer kalau belum ada
        $role = Role::firstOrCreate(['name' => 'developer', 'guard_name' => 'web']);

        // Assign role developer ke user
        $developer->assignRole($role);
    }
}
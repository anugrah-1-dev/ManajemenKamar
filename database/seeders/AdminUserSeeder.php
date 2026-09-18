<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Buat user admin
        $admin = User::firstOrCreate([
            'email' => 'AdminBriliant@gmail.com',
        ], [
            'name' => 'admin',
            'password' => '$2y$12$BdkciryJxhZGxgVDyG91.esYrE2v80NmSvifm9F51zZWKqOmVs25K', // password sudah di-hash
        ]);
        //pw : admintest!
        // Buat role admin kalau belum ada
        $role = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        // Assign role admin ke user
        $admin->assignRole($role);
    }
}

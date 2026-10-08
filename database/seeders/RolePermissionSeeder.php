<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat permission
        $permissions = [
            'akses admin',
            'akses officer',
            'akses developer',
            'lihat kamar',
            'tambah kamar',
            'ubah kamar',
            'hapus kamar',
            'lihat activity log',
        ];
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        // Buat role dan berikan permission
        $roles = [
            // Admin: boleh lihat, tambah, ubah — TIDAK boleh hapus kamar
            'admin' => ['akses admin', 'lihat kamar', 'tambah kamar', 'ubah kamar'],

            // Officer: dipertahankan seperti sebelumnya
            'officer' => ['akses officer', 'hapus kamar'],

            // Developer: full CRUD kamar + akses activity log
            'developer' => [
                'akses developer',
                'lihat kamar',
                'tambah kamar',
                'ubah kamar',
                'hapus kamar',
                'lihat activity log',
            ],
        ];

        foreach ($roles as $role => $perms) {
            $role = Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
            $role->syncPermissions($perms);
        }
    }
}

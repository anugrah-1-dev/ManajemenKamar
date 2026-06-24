<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call(AdminUserSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(BankSeeder::class);
        $this->call(ProgramOnlineSeeder::class);
        $this->call(ProgramOfflineSeeder::class);
        // $this->call(PendaftaranProgramOnlineSeeder::class);
        $this->call(ProgramCampSeeder::class);
        $this->call(RoomSeeder::class);
        $this->call(ThumbnailSeeder::class);

    }
}

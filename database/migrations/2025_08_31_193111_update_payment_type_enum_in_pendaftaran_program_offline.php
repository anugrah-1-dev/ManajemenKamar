<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah kolom payment_type jadi ENUM dengan tambahan 'qris'
        DB::statement("ALTER TABLE pendaftaran_program_offline
            MODIFY payment_type ENUM('tunai','transfer','qris') NOT NULL");
    }

    public function down(): void
    {
        // Rollback ke awal (tanpa qris)
        DB::statement("ALTER TABLE pendaftaran_program_offline
            MODIFY payment_type ENUM('tunai','transfer') NOT NULL");
    }
};

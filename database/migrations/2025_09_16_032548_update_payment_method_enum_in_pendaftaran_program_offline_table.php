<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Ubah enum dengan menambahkan DP
        DB::statement("ALTER TABLE pendaftaran_program_offline 
            MODIFY payment_method ENUM('full', 'cicilan', 'DP') 
            CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'full'");
    }

    public function down()
    {
        // Kembalikan enum seperti semula (hanya full dan cicilan)
        DB::statement("ALTER TABLE pendaftaran_program_offline 
            MODIFY payment_method ENUM('full', 'cicilan') 
            CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'full'");
    }
};


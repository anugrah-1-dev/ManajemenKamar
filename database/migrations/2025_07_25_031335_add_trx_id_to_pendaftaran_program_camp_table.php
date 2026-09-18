<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Di dalam migration:
        Schema::table('pendaftaran_program_camp', function (Blueprint $table) {
            $table->string('trx_id')->unique()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran_program_camp', function (Blueprint $table) {
            //
        });
    }
};

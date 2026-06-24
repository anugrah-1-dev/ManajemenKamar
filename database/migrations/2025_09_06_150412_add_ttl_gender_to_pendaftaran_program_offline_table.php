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
        Schema::table('pendaftaran_program_offline', function (Blueprint $table) {
            $table->string('tempat_lahir')->nullable()->after('asal_kota');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->enum('gender', ['Laki-laki', 'Perempuan'])->nullable()->after('tanggal_lahir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran_program_offline', function (Blueprint $table) {
            $table->dropColumn(['tempat_lahir', 'tanggal_lahir', 'gender']);
        });
    }
};

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
        Schema::create('pendaftaran_program_camp', function (Blueprint $table) {
            $table->id();

            // Informasi pendaftar
            $table->string('nama_lengkap');
            $table->string('email');
            $table->string('no_hp');
            $table->string('asal_kota');

            $table->foreignId('program_camp_id')->constrained('program_camp')->onDelete('cascade');
            $table->foreignId('period_id')->nullable()->constrained('periods')->onDelete('set null');
            $table->string('durasi_paket'); // Contoh: "perhari", "1bulan"
            $table->string('nama_kamar');   // Nama kamar yang dipilih
            $table->string('bukti_pembayaran')->nullable(); // path upload file
            $table->enum('status', ['pending', 'validasi', 'diterima', 'ditolak'])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_program_camp');
    }
};

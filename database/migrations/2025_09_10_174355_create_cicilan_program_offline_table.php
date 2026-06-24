<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cicilan_program_offline', function (Blueprint $table) {
            $table->id();

            // Foreign key ke pendaftaran_program_offline
            $table->foreignId('pendaftaran_program_offline_id')
                ->constrained('pendaftaran_program_offline')
                ->onDelete('cascade');

            $table->tinyInteger('bulan_ke')->unsigned();
            $table->decimal('jumlah', 15, 3);
            $table->enum('status', ['pending', 'paid', 'overdue'])->default('pending');
            $table->enum('metode_pembayaran', ['transfer', 'qris'])->nullable();
            $table->string('bukti_pembayaran')->nullable();
            $table->date('tanggal_jatuh_tempo');
            $table->date('tanggal_dibayar')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cicilan_program_offline');
    }
};

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
        Schema::create('pendaftaran_program_online', function (Blueprint $table) {
            $table->id();
            $table->string('trx_id')->unique();
            $table->string('nama_lengkap');
            $table->string('email');
            $table->string('no_hp')->nullable();
            $table->string('asal_kota')->nullable();
            $table->unsignedBigInteger('program_id')->nullable();
            $table->unsignedBigInteger('period_id')->nullable();
            $table->text('bukti_pembayaran')->nullable();
            $table->string('status')->default('pending');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('program_id')->references('id')->on('program_online')->onDelete('set null');
            $table->foreign('period_id')->references('id')->on('periods')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_program_online');
    }
};

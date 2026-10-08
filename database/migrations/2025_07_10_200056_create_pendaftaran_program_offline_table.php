<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendaftaranProgramOfflineTable extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftaran_program_offline', function (Blueprint $table) {
            $table->id();
            $table->string('trx_id')->unique();
            $table->string('nama_lengkap');
            $table->string('no_hp')->nullable();
            $table->string('email');
            $table->string('asal_kota')->nullable();
            $table->string('no_wali')->nullable();
            $table->unsignedBigInteger('program_id')->nullable();
            $table->unsignedBigInteger('period_id')->nullable();
            $table->unsignedBigInteger('transport_id')->nullable();
            $table->text('bukti_pembayaran')->nullable();
            $table->string('status')->default('pending');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('program_id')->references('id')->on('program_offline')->onDelete('set null');
            $table->foreign('period_id')->references('id')->on('periods')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_program_offline');
    }
};

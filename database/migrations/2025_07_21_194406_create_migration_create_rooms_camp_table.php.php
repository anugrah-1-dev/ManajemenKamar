<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel program_camp
            $table->foreignId('program_camp_id')
                ->constrained('program_camp')
                ->onDelete('cascade');

            // Nama kamar seperti A-12, B-3, dsb
            $table->string('nomor_kamar')->unique();

            $table->enum('gender', ['putra', 'putri']);

            $table->enum('kategori', ['VVIP', 'VIP', 'Barack']);
            $table->unsignedTinyInteger('kapasitas');

            $table->unsignedTinyInteger('penghuni')->default(0);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rooms');
    }

};

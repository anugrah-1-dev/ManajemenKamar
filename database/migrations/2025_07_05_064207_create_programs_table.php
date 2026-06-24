<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Nama tabel diubah menjadi 'program' (singular)
        Schema::create('program', function (Blueprint $table) {
            $table->id();
            $table->string('judul_konten'); // Sebelumnya content_heading
            $table->text('deskripsi');      // Sebelumnya description
            $table->text('keunggulan');     // Sebelumnya benefits
            $table->string('gambar');       // Sebelumnya image
            $table->boolean('status_aktif_default')->default(false); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program');
    }
};

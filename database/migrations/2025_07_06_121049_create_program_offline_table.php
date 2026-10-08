<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('program_offline', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug')->nullable();
            $table->string('lama_program')->nullable();
            $table->string('kategori')->nullable();
            $table->integer('harga')->nullable();
            $table->longText('features_program')->nullable();
            $table->string('lokasi')->nullable();
            $table->date('jadwal_mulai')->nullable();
            $table->date('jadwal_selesai')->nullable();
            $table->integer('kuota')->nullable();
            $table->boolean('is_active')->default(1);
            $table->text('thumbnail')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_offline');
    }
};

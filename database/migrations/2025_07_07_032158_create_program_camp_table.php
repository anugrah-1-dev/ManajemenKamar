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
        Schema::create('program_camp', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug')->nullable();
            $table->string('kategori')->nullable();
            $table->integer('stok')->nullable();
            $table->integer('harga_perhari')->nullable();
            $table->integer('harga_satu_minggu')->nullable();
            $table->integer('harga_dua_minggu')->nullable();
            $table->integer('harga_tiga_minggu')->nullable();
            $table->integer('harga_satu_bulan')->nullable();
            $table->integer('harga_dua_bulan')->nullable();
            $table->integer('harga_tiga_bulan')->nullable();
            $table->integer('harga_enam_bulan')->nullable();
            $table->integer('harga_satu_tahun')->nullable();
            $table->longText('fasilitas')->nullable();
            $table->text('thumbnail')->nullable();
            $table->softDeletes(); // Kolom deleted_at
            $table->timestamps();  // Kolom created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_camp');
    }
};

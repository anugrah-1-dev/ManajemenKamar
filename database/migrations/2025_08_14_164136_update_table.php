<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('program_camp', function (Blueprint $table) {
            // Hapus kolom thumbnail lama kalau ada
            if (Schema::hasColumn('program_camp', 'thumbnail')) {
                $table->dropColumn('thumbnail');
            }

            // Tambah kolom thumbnail_id
            if (!Schema::hasColumn('program_camp', 'thumbnail_id')) {
                $table->unsignedBigInteger('thumbnail_id')->nullable()->after('fasilitas');

                $table->foreign('thumbnail_id')
                    ->references('id')
                    ->on('thumbnails')
                    ->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('program_camp', function (Blueprint $table) {
            // Hapus relasi & kolom thumbnail_id
            if (Schema::hasColumn('program_camp', 'thumbnail_id')) {
                $table->dropForeign(['thumbnail_id']);
                $table->dropColumn('thumbnail_id');
            }

            // Kembalikan kolom thumbnail lama
            if (!Schema::hasColumn('program_camp', 'thumbnail')) {
                $table->string('thumbnail')->nullable()->after('fasilitas');
            }
        });
    }
};

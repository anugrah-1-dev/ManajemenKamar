<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('program', function (Blueprint $table) {
            // Hapus kolom lama
            $table->dropColumn('judul_konten');
            $table->dropColumn('status_aktif_default');
        });

        Schema::table('program', function (Blueprint $table) {
            // Tambahkan kolom baru
            $table->string('judul')->after('id');
            $table->enum('status', ['aktif', 'nonaktif'])->default('nonaktif')->after('judul');
        });
    }

    public function down(): void
    {
        Schema::table('program', function (Blueprint $table) {
            // Rollback perubahan
            $table->dropColumn(['judul', 'status']);
        });

        Schema::table('program', function (Blueprint $table) {
            $table->string('judul_konten')->after('id');
            $table->boolean('status_aktif_default')->default(false)->after('gambar');
        });
    }
};

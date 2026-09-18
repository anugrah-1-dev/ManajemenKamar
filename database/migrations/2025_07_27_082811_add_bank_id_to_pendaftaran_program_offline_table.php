<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Perintah untuk memodifikasi tabel 'pendaftaran_offline'
        Schema::table('pendaftaran_program_offline', function (Blueprint $table) {
            // Menambahkan kolom 'bank_id' setelah kolom 'transport_id'
            // Kolom ini digunakan untuk menyimpan relasi ke tabel 'banks'
            $table->unsignedBigInteger('bank_id')
                  ->nullable() // Kolom boleh kosong (opsional)
                  ->after('transport_id'); // Posisi kolom

            // Menambahkan foreign key constraint
            // Ini akan menghubungkan 'bank_id' di tabel ini dengan 'id' di tabel 'banks'
            $table->foreign('bank_id')
                  ->references('id')
                  ->on('banks')
                  ->onDelete('set null'); // Jika bank dihapus, kolom ini akan menjadi NULL
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Perintah ini akan dijalankan jika Anda melakukan rollback migrasi
        Schema::table('pendaftaran_program_offline', function (Blueprint $table) {
            // 1. Hapus foreign key terlebih dahulu
            $table->dropForeign(['bank_id']);
            
            // 2. Hapus kolom 'bank_id'
            $table->dropColumn('bank_id');
        });
    }
};

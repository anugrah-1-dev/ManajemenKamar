<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentTypeToPendaftaranProgramOfflineTable extends Migration
{
    /**
     * Menjalankan migrasi.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pendaftaran_program_offline', function (Blueprint $table) {
            // Definisikan nilai-nilai yang diizinkan untuk kolom ENUM.
            // Ini akan memastikan hanya 'tunai' atau 'transfer' yang bisa dimasukkan.
            $allowed_payment_types = ['tunai', 'transfer'];

            // Tambahkan kolom 'payment_type' dengan tipe ENUM.
            // Kolom ini dibuat agar bisa NULL (nullable) dan ditempatkan setelah kolom 'bank_id'.
            $table->enum('payment_type', $allowed_payment_types)
                  ->nullable()
                  ->after('bank_id');
        });
    }

    /**
     * Membatalkan migrasi.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pendaftaran_program_offline', function (Blueprint $table) {
            // Baris ini akan menghapus kolom 'payment_type' jika Anda
            // perlu mengembalikan (rollback) migrasi ini.
            $table->dropColumn('payment_type');
        });
    }
}
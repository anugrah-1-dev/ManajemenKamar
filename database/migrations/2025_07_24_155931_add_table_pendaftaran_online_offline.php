<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Hapus kolom lama (text)
        if (Schema::hasColumn('pendaftaran_program_offline', 'bukti_pembayaran')) {
            Schema::table('pendaftaran_program_offline', function (Blueprint $table) {
                $table->dropColumn('bukti_pembayaran');
            });

            // Tambahkan ulang dengan tipe string (varchar)
            Schema::table('pendaftaran_program_offline', function (Blueprint $table) {
                $table->string('bukti_pembayaran')->nullable()->after('transport_id');
            });
        }

        if (Schema::hasColumn('pendaftaran_program_online', 'bukti_pembayaran')) {
            Schema::table('pendaftaran_program_online', function (Blueprint $table) {
                $table->dropColumn('bukti_pembayaran');
            });

            Schema::table('pendaftaran_program_online', function (Blueprint $table) {
                $table->string('bukti_pembayaran')->nullable()->after('period_id'); 
            });
        }
    }

    public function down(): void
    {
        // Kembalikan ke text
        Schema::table('pendaftaran_program_offline', function (Blueprint $table) {
            $table->dropColumn('bukti_pembayaran');
        });

        Schema::table('pendaftaran_program_offline', function (Blueprint $table) {
            $table->text('bukti_pembayaran')->nullable()->after('transport_id');
        });

        Schema::table('pendaftaran_program_online', function (Blueprint $table) {
            $table->dropColumn('bukti_pembayaran');
        });

        Schema::table('pendaftaran_program_online', function (Blueprint $table) {
            $table->text('bukti_pembayaran')->nullable()->after('period_id'); 
        });
    }
};

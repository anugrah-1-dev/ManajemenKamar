<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftaran_program_online', function (Blueprint $table) {
            // Akomodasi (VIP atau Reguler)
            $table->enum('akomodasi_tipe', ['vip', 'reguler'])
                ->nullable()
                ->after('bukti_pembayaran');

            // Harga akomodasi (default 0, reguler bisa statis misalnya Rp180.000)
            $table->decimal('akomodasi_harga', 15, 3)
                ->default(0)
                ->after('akomodasi_tipe');

            // Subtotal (total sementara termasuk akomodasi, transport, dll.)
            $table->decimal('subtotal', 15, 3)
                ->default(0)
                ->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftaran_program_online', function (Blueprint $table) {
            $table->dropColumn(['akomodasi_tipe', 'akomodasi_harga', 'subtotal']);
        });
    }
};

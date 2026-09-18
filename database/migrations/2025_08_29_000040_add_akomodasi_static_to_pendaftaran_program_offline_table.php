<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftaran_program_offline', function (Blueprint $table) {
            // hanya simpan pilihan reguler / vip
            $table->enum('akomodasi_tipe', ['vip', 'reguler'])->nullable()->after('transport_id');

            // kalau reguler harganya static (misal Rp180.000)
            $table->decimal('akomodasi_harga', 15, 3)->default(0)->after('akomodasi_tipe');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftaran_program_offline', function (Blueprint $table) {
            $table->dropColumn(['akomodasi_tipe', 'akomodasi_harga']);
        });
    }
};

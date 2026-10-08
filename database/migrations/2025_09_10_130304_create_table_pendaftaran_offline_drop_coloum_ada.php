<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftaran_program_offline', function (Blueprint $table) {
            if (Schema::hasColumn('pendaftaran_program_offline', 'remaining_amount')) {
                $table->dropColumn('remaining_amount');
            }
            if (Schema::hasColumn('pendaftaran_program_offline', 'is_fully_paid')) {
                $table->dropColumn('is_fully_paid');
            }
            if (Schema::hasColumn('pendaftaran_program_offline', 'bukti_dp')) {
                $table->dropColumn('bukti_dp');
            }
            if (Schema::hasColumn('pendaftaran_program_offline', 'bukti_pelunasan')) {
                $table->dropColumn('bukti_pelunasan');
            }
            if (Schema::hasColumn('pendaftaran_program_offline', 'dp_paid')) {
                $table->dropColumn('dp_paid');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pendaftaran_program_offline', function (Blueprint $table) {
            // tambahkan kembali kolom jika diperlukan untuk rollback
            $table->string('bukti_dp')->nullable();
            $table->string('bukti_pelunasan')->nullable();
            $table->boolean('dp_paid')->default(false);
            $table->dropColumn('is_fully_paid');
            $table->dropColumn('remaining_amount');
        });
    }
};

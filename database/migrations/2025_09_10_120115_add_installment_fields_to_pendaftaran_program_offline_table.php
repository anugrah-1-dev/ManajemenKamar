<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInstallmentFieldsToPendaftaranProgramOfflineTable extends Migration
{
    public function up()
    {
        Schema::table('pendaftaran_program_offline', function (Blueprint $table) {
            if (!Schema::hasColumn('pendaftaran_program_offline', 'payment_method')) {
                $table->enum('payment_method', ['full', 'cicilan'])->default('full')->after('payment_type');
            }
            if (!Schema::hasColumn('pendaftaran_program_offline', 'dp_amount')) {
                $table->decimal('dp_amount', 15, 2)->default(0)->after('payment_method');
            }
            if (!Schema::hasColumn('pendaftaran_program_offline', 'remaining_amount')) {
                $table->decimal('remaining_amount', 15, 2)->default(0)->after('dp_amount');
            }
            if (!Schema::hasColumn('pendaftaran_program_offline', 'is_fully_paid')) {
                $table->boolean('is_fully_paid')->default(false)->after('remaining_amount');
            }
            if (!Schema::hasColumn('pendaftaran_program_offline', 'bukti_dp')) {
                $table->string('bukti_dp')->nullable()->after('bukti_pembayaran');
            }
            if (!Schema::hasColumn('pendaftaran_program_offline', 'bukti_pelunasan')) {
                $table->string('bukti_pelunasan')->nullable()->after('bukti_dp');
            }
            if (!Schema::hasColumn('pendaftaran_program_offline', 'dp_paid')) {
                $table->boolean('dp_paid')->default(false)->after('bukti_dp');
            }
        });
    }

    public function down()
    {
        Schema::table('pendaftaran_program_offline', function (Blueprint $table) {
            if (Schema::hasColumn('pendaftaran_program_offline', 'payment_method')) {
                $table->dropColumn('payment_method');
            }
            if (Schema::hasColumn('pendaftaran_program_offline', 'dp_amount')) {
                $table->dropColumn('dp_amount');
            }
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
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftaran_program_offline', function (Blueprint $table) {
            if (!Schema::hasColumn('pendaftaran_program_offline', 'period_nhc_id')) {
                $table->unsignedBigInteger('period_nhc_id')->nullable()->after('period_id');

                $table->foreign('period_nhc_id')
                    ->references('id')
                    ->on('periods_nhc')
                    ->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pendaftaran_program_offline', function (Blueprint $table) {
            if (Schema::hasColumn('pendaftaran_program_offline', 'period_nhc_id')) {
                $table->dropForeign(['period_nhc_id']);
                $table->dropColumn('period_nhc_id');
            }
        });
    }
};

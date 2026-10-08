<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('pendaftaran_program_camp', function (Blueprint $table) {
            $table->enum('gender', ['putra', 'putri'])->after('asal_kota');
        });
    }

    public function down()
    {
        Schema::table('pendaftaran_program_camp', function (Blueprint $table) {
            $table->dropColumn('gender');
        });
    }
};

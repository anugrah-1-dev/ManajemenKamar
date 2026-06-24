<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterNamaKamarNullableInPendaftaranProgramCampTable extends Migration
{
    public function up()
    {
        Schema::table('pendaftaran_program_camp', function (Blueprint $table) {
            $table->string('nama_kamar')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('pendaftaran_program_camp', function (Blueprint $table) {
            $table->string('nama_kamar')->nullable(false)->change();
        });
    }
}

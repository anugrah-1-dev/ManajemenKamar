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
        Schema::table('program_offline', function (Blueprint $table) {
            $table->string('program_bahasa', 50)->after('nama'); // setelah kolom nama
        });
    
        Schema::table('program_online', function (Blueprint $table) {
            $table->string('program_bahasa', 50)->after('nama'); // setelah kolom nama
        });
    }
    
    public function down()
    {
        Schema::table('program_offline', function (Blueprint $table) {
            $table->dropColumn('program_bahasa');
        });
    
        Schema::table('program_online', function (Blueprint $table) {
            $table->dropColumn('program_bahasa');
        });
    }
    
};

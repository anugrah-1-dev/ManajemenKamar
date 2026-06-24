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
            $table->enum('payment_type', ['tunai', 'nontunai'])->after('bank_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('pendaftaran_program_camp', function (Blueprint $table) {
            $table->dropColumn('payment_type');
        });
    }
    
};

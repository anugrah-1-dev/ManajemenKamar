<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactPeopleTable extends Migration
{
    public function up(): void
    {
        Schema::create('contact_service', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nomor', 16);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_people');
    }
}

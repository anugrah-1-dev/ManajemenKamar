<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transports', function (Blueprint $table) {
            $table->id(); // primary key, auto increment (BIGINT by default)
            $table->string('name'); // VARCHAR
            $table->integer('price'); // INT
            $table->enum('status', ['active', 'inactive']); // ENUM with allowed values
            $table->timestamps(); // created_at dan updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transportation');
    }
};

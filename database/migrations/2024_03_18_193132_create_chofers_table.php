<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chofers', function (Blueprint $table) {
            $table->id();
            $table->string('dni')->unique();
            $table->string('nombre_apellidos');
            $table->string('telefono');
            $table->string('brevete')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chofers');
    }
};

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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // ej: Básico, Premium
            $table->string('slug')->unique(); // ej: basic, premium
            $table->decimal('price', 8, 2); // Precio mensual
            $table->integer('project_limit')->nullable(); // Límite de proyectos (null para infinito)
            $table->integer('link_limit')->nullable(); // Límite de links por proyecto (null para infinito)
            $table->integer('user_limit')->nullable(); // Límite de usuarios por compañía (null para infinito)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};

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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained();
            $table->timestamp('started_at')->useCurrent(); // Fecha de inicio
            $table->timestamp('ends_at')->nullable(); // Fecha de fin (cuando se cancela o no se renueva)
            $table->timestamp('renews_at')->nullable(); // Fecha de próxima renovación
            $table->string('status')->default('active'); // ej: active, cancelled, ended
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};

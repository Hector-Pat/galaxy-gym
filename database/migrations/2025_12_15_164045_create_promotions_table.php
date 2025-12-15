<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabla de promociones.
     * Representa descuentos asociados a una membresía.
     */
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->text('description')->nullable();

            // Tipo de descuento: porcentaje o monto fijo
            $table->enum('discount_type', ['percentage', 'fixed']);
            $table->decimal('discount_value', 8, 2);

            // Relación opcional con membresías
            $table->foreignId('membership_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // Control de vigencia
            $table->date('starts_at')->nullable();
            $table->date('ends_at')->nullable();

            // Estado lógico
            $table->boolean('active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverso de la migración.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};

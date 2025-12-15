<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Agrega campos de membresía al usuario.
     *
     * - membership_id: referencia al catálogo de membresías
     * - membership_start_date: fecha de inicio real
     * - membership_end_date: fecha de expiración calculada
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Relación con membresías (nullable para usuarios sin membresía)
            $table->foreignId('membership_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            // nullOnDelete() garantiza que si una membresía se elimina,
            // el usuario no queda inconsistente, la asignación simplemente se limpia.

            $table->date('membership_start_date')->nullable();
            $table->date('membership_end_date')->nullable();
        });
    }

    /**
     * Revierte los cambios de la migración.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['membership_id']);
            $table->dropColumn([
                'membership_id',
                'membership_start_date',
                'membership_end_date'
            ]);
        });
    }
};

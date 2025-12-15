<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Agrega la relación con roles y el estado lógico del usuario.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            /**
             * Relación con la tabla roles.
             * Un usuario pertenece a un rol.
             */
            $table->foreignId('role_id')
                ->nullable()
                ->after('id')
                ->constrained('roles');

            /**
             * Estado lógico del usuario (activo / desactivado).
             */
            $table->boolean('active')
                ->default(true)
                ->after('role_id');
        });
    }

    /**
     * Revierte los cambios en la tabla users.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn(['role_id', 'active']);
        });
    }
};

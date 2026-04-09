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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();                    // bigint primary key auto-increment
            
            $table->string('titulo', 120);   // máximo 120 caracteres
            $table->text('descripcion');     // texto largo
            $table->enum('prioridad', ['baja', 'media', 'alta']);
            
            // Foreign key a la tabla de clientes
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')
                  ->references('id')
                  ->on('clientes')
                  ->onDelete('cascade');

            // Campos útiles
            $table->unsignedBigInteger('user_id')->nullable(); // usuario que creó el ticket
            $table->string('estado')->default('abierto');      // abierto, en_proceso, cerrado, etc.

            $table->timestamps();            // created_at y updated_at
            $table->softDeletes();           // deleted_at (eliminación suave)

            // Índices para mejorar rendimiento
            $table->index('prioridad');
            $table->index('created_at');     // para filtros de fecha
            $table->index('titulo');         // para búsqueda LIKE
            $table->index('cliente_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};

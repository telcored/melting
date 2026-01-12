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
    Schema::create('productos', function (Blueprint $table) {
        $table->id();
        $table->string('material');
        $table->decimal('cantidad', 10, 2)->default(0); // peso o unidades
        $table->enum('estado', ['nuevo', 'usado', 'quemado', 'otro'])->default('usado');
        $table->decimal('precio', 10, 2)->default(0);

        // SUGERENCIAS
        $table->string('unidad')->default('kg'); // kg, unidades, litros, etc.
        $table->unsignedBigInteger('categoria_id')->nullable(); // relación opcional
        $table->text('descripcion')->nullable();
        $table->timestamps();

        // FK opcional
        $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};

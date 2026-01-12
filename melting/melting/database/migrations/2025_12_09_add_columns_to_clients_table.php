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
        Schema::table('clients', function (Blueprint $table) {
            $table->string('rut')->nullable();
            $table->string('paterno')->nullable();
            $table->string('materno')->nullable();
            $table->string('direccion')->nullable();
            $table->string('comuna')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['rut', 'paterno', 'materno', 'direccion', 'comuna']);
        });
    }
};

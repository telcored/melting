<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('compras')) {
            return;
        }

        Schema::table('compras', function (Blueprint $table) {
            if (!Schema::hasColumn('compras', 'folio')) {
                $table->string('folio')->nullable()->after('id');
            }
            if (!Schema::hasColumn('compras', 'bodega')) {
                $table->enum('bodega', ['talca', 'chillan'])->default('talca')->after('folio');
            }
            if (!Schema::hasColumn('compras', 'client_id')) {
                $table->unsignedBigInteger('client_id')->nullable()->after('bodega');
            }
            if (!Schema::hasColumn('compras', 'fecha')) {
                $table->date('fecha')->nullable()->after('client_id');
            }
            if (!Schema::hasColumn('compras', 'factura')) {
                $table->string('factura')->nullable()->after('fecha');
            }
            if (!Schema::hasColumn('compras', 'declaracion')) {
                $table->text('declaracion')->nullable()->after('factura');
            }
        });

        // agregar FK si es seguro (client_id existente y coincidente)
        if (Schema::hasColumn('compras', 'client_id') && Schema::hasTable('clients')) {
            try {
                Schema::table('compras', function (Blueprint $table) {
                    $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');
                });
            } catch (\Throwable $e) {
                // ignorar si falla (limpia datos/añade fk manualmente luego)
            }
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('compras')) {
            return;
        }

        Schema::table('compras', function (Blueprint $table) {
            // intentar eliminar FK si existe
            try {
                $table->dropForeign(['client_id']);
            } catch (\Throwable $e) {}

            if (Schema::hasColumn('compras', 'declaracion')) $table->dropColumn('declaracion');
            if (Schema::hasColumn('compras', 'factura')) $table->dropColumn('factura');
            if (Schema::hasColumn('compras', 'fecha')) $table->dropColumn('fecha');
            if (Schema::hasColumn('compras', 'client_id')) $table->dropColumn('client_id');
            if (Schema::hasColumn('compras', 'bodega')) $table->dropColumn('bodega');
            if (Schema::hasColumn('compras', 'folio')) $table->dropColumn('folio');
        });
    }
};
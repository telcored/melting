<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'material',
        'cantidad',
        'estado',
        'precio',
        'unidad',
        'bodega',
        'categoria_id',
        'descripcion'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}

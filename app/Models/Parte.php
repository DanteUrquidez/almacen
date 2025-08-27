<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parte extends Model
{
    protected $table = 'partes';

    protected $fillable = [
        'nombre',
        'descripcion',
        'id_categoria',
        'cantidad',
        'minimo',
        'maximo',
    ];

    // Relación con categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    // Relación con movimientos
    public function movimientos()
    {
        return $this->hasMany(Movimiento::class, 'parte_id');
    }

        public function inventario()
    {
        return $this->hasOne(Inventario::class, 'id_parte');
    }
    public function syncInventario()
    {
        $this->inventario()->updateOrCreate(
            ['id_parte' => $this->id],
            ['stock_actual' => $this->cantidad, 'fecha_actualizacion' => now()]
        );
    }
}
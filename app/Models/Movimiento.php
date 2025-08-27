<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $table = 'movimientos';

    protected $fillable = [
        'parte_id',
        'tipo',
        'cantidad',
        'descripcion',
    ];

    public function parte()
    {
        return $this->belongsTo(Parte::class, 'parte_id');
    }

    public function cajas()
    {
        return $this->hasMany(Caja::class);
    }

    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

}

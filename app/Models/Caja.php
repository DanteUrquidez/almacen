<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer',
        'shipping_date',
        'purchase_order',
        'shipped_from',
        'sold_to',
        'shipped_to',
        'cliente_id',
        'almacen_id',
        'numero',
        'movimiento_id',
    ];

    public function item()
    {
        return $this->hasMany(Item::class)->with('parte');
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function movimiento()
    {
        return $this->belongsTo(Movimiento::class);
    }

    public function partes()
    {
        return $this->belongsToMany(Parte::class, 'items', 'caja_id', 'parte_id');
    }

    public function almacen()
    {
        return $this->hasOneThrough(Almacen::class, Movimiento::class, 'id', 'id', 'movimiento_id', 'almacen_id',
        'nombre',
        'identificador',
        'calle',
        'numero',
        'colonia',
        'ciudad',
        'estado',
        'pais',
        'cp',
        'telefono',
        'web',);
    }

}

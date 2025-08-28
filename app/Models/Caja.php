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
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

}

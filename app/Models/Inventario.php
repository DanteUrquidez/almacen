<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    protected $table = 'inventario';

    protected $fillable = [
        'id_parte',
        'stock_actual',
        'fecha_actualizacion',
    ];

    protected $dates = [
        'fecha_actualizacion',
        'created_at',
        'updated_at',
    ];

    /**
     * Relación con la Parte.
     */
    public function parte()
    {
        return $this->belongsTo(Parte::class, 'id_parte');
    }
}
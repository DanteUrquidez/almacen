<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    use HasFactory;

    protected $table = 'almacenes';

    protected $fillable = [
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
        'web',
    ];

    /**
     * Reglas de validación para crear o actualizar un almacén
     */
    public static function rules($id = null)
    {
        return [
            'nombre'    => 'required|string|max:255',
            'identificador' => 'required|string|max:50',
            'calle'     => 'nullable|string|max:255',
            'numero'    => 'nullable|string|max:50',
            'colonia'   => 'nullable|string|max:255',
            'ciudad'    => 'nullable|string|max:255',
            'estado'    => 'nullable|string|max:255',
            'pais'      => 'nullable|string|max:255',
            'cp'        => 'nullable|string|max:20',
            'telefono'  => 'nullable|string|max:50',
            'web'       => 'nullable|string|max:255',
        ];
    }
}

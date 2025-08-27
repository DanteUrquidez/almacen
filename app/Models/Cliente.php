<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

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
    ];

    public static function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'identificador' => 'nullable|string|max:10',
            'calle' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:50',
            'colonia' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:255',
            'pais' => 'nullable|string|max:255',
            'cp' => 'nullable|string|max:20',
        ];
    }

    public static function messages()
    {
        return [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.max' => 'El campo nombre no debe exceder 255 caracteres.',
            'calle.max' => 'El campo calle no debe exceder 255 caracteres.',
            'numero.max' => 'El campo número no debe exceder 50 caracteres.',
            'colonia.max' => 'El campo colonia no debe exceder 255 caracteres.',
            'ciudad.max' => 'El campo ciudad no debe exceder 255 caracteres.',
            'estado.max' => 'El campo estado no debe exceder 255 caracteres.',
            'pais.max' => 'El campo país no debe exceder 255 caracteres.',
            'cp.max' => 'El campo código postal no debe exceder 20 caracteres.',
        ];
    }

};
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function partes()
    {
        return $this->hasMany(Parte::class, 'id_categoria');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\Relation;

class ProductoInsumo extends Model
{
    protected $table = 'producto_insumo';

    protected $fillable = [
        'id_producto',
        'id_insumo',
        'cantidad',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;

    protected $primaryKey = ['id_producto', 'id_insumo'];
    public $incrementing = false;

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }

    public function insumo()
    {
        return $this->belongsTo(Insumo::class, 'id_insumo');
    }
}
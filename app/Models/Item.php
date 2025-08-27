<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
        protected $fillable = [
            'parte_id',
            'item_no',
            'pkg_size',
            'pkg_weight',
            'cantidad',
            'caja_id',
        ];

        public function caja()
    {
        return $this->belongsTo(Caja::class);
    }

    public function parte()
    {
        return $this->belongsTo(Parte::class);
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventario;
use App\Models\Parte;

class InventarioController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventario::with('parte.categoria');


        if ($request->filled('nombre')) {
            $query->whereHas('parte', function ($q) use ($request) {
                $q->where('nombre', 'LIKE', '%' . $request->nombre . '%');
            });
        }

        $inventario = $query->paginate(10);

        return view('admin.inventario.index', compact('inventario'));
    }
    public function syncInventario()
    {
        $partes = Parte::all();
        foreach ($partes as $parte) {
            Inventario::updateOrCreate(
                ['id_parte' => $parte->id],
                [
                    'stock_actual' => $parte->cantidad,
                    'fecha_actualizacion' => now()
                ]
            );
        }

        return redirect()->route('admin.inventario.index')->with('success', 'Inventario sincronizado correctamente.');
    }
}

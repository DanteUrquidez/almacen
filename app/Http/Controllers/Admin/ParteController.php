<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Parte;
use App\Models\Movimiento;
use Illuminate\Support\Facades\DB;

class ParteController extends Controller
{
    public function index(Request $request)
    {
        $query = Parte::query();

        if ($request->filled('nombre')) {
            $query->where('nombre', 'LIKE', '%' . $request->nombre . '%');
        }

        $partes = $query->paginate(10);

        return view('admin.partes.index', compact('partes'));
    }

    public function create()
    {
        $categorias = DB::table('categorias')->pluck('nombre', 'id');
        return view('admin.partes.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'id_categoria' => 'required|exists:categorias,id',
            'cantidad' => 'nullable|integer|min:0',
            'minimo' => 'nullable|integer|min:0',
            'maximo' => 'nullable|integer|min:0',
        ], [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.max' => 'El campo nombre no debe exceder 255 caracteres.',
            'minimo.min' => 'El mínimo debe ser mayor a 0.',
            'maximo.min' => 'El máximo debe ser mayor a 0.',
        ]);

        $parte = Parte::create($request->all());

        if ($parte->cantidad > 0) {
            \App\Models\Movimiento::create([
                'parte_id' => $parte->id,
                'tipo' => 'entrada',
                'cantidad' => $parte->cantidad,
                'descripcion' => 'Movimiento inicial al crear la parte',
            ]);
        }

        return redirect()->route('admin.partes.index')
                        ->with('success', 'Parte creada correctamente.');
    }


    public function storeMultiple(Request $request)
    {
        $request->validate([
            'partes' => 'required|array',
            'partes.*.nombre' => 'required|string|max:255',
            'partes.*.descripcion' => 'nullable|string',
            'partes.*.id_categoria' => 'required|exists:categorias,id',
            'partes.*.cantidad' => 'nullable|integer|min:0',
            'partes.*.minimo' => 'nullable|integer|min:1',
            'partes.*.maximo' => 'nullable|integer|min:1',
        ]);

        foreach ($request->partes as $parteData) {
            $parte = Parte::create($parteData);

            if ($parte->cantidad > 0) {
                \App\Models\Movimiento::create([
                    'parte_id' => $parte->id,
                    'tipo' => 'entrada',
                    'cantidad' => $parte->cantidad,
                    'descripcion' => 'Movimiento inicial al ingresar la parte',
                ]);
            }
        }

        return redirect()->route('admin.partes.index')
                        ->with('success', 'Partes creadas correctamente.');
    }


    public function edit($id)
    {
        $parte = Parte::findOrFail($id);
        $categorias = DB::table('categorias')->pluck('nombre', 'id');
        return view('admin.partes.edit', compact('parte', 'categorias'));
    }

    public function update(Request $request, Parte $parte)
    {
        $validated = $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'id_categoria'=> 'required|exists:categorias,id',
            'cantidad'    => 'required|integer|min:0',
            'minimo'      => 'nullable|integer|min:1|lt:maximo',
            'maximo'      => 'nullable|integer|min:1',
        ], [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.max'      => 'El campo nombre no debe exceder 255 caracteres.',
            'minimo.lt'       => 'El mínimo debe ser menor que el máximo.',
            'minimo.min'      => 'El mínimo debe ser a 0.',
            'maximo.min'      => 'El máximo debe ser a 0.',
        ]);

        $parte->update($validated);

        return redirect()->route('admin.partes.index')->with('success', 'Parte actualizada correctamente.');
    }

    public function destroy($id)
    {
        $parte = Parte::findOrFail($id);
        $parte->delete();
        return redirect()->route('admin.partes.index')->with('success', 'Parte eliminada correctamente.');
    }
         public function movimientos($id)
    {
        $parte = Parte::findOrFail($id);
        $movimientos = Movimiento::where('parte_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.partes.movimientos', compact('parte', 'movimientos'));
    }

    public function registrarMovimiento(Request $request, $id)
    {
        $parte = Parte::findOrFail($id);

        $validated = $request->validate([
            'tipo'        => 'required|in:entrada,salida',
            'cantidad'    => 'required|integer|min:1',
            'descripcion' => 'nullable|string'
        ]);

        if ($validated['tipo'] === 'entrada') {
            $parte->cantidad += $validated['cantidad'];
        } else {
            if ($parte->cantidad < $validated['cantidad']) {
                return back()->withErrors(['cantidad' => 'No hay suficiente stock para esta salida.']);
            }
            $parte->cantidad -= $validated['cantidad'];
        }
        $parte->save();

        Movimiento::create([
            'parte_id'    => $parte->id,
            'tipo'        => $validated['tipo'],
            'cantidad'    => $validated['cantidad'],
            'descripcion' => $validated['descripcion'] ?? null
        ]);

        return redirect()->route('admin.partes.movimientos', $parte->id)
                        ->with('success', 'Movimiento registrado correctamente.');
    }

    public function entradaRapida($id)
    {
        $parte = Parte::findOrFail($id);
        $parte->cantidad += 1;
        $parte->save();

        Movimiento::create([
            'parte_id' => $parte->id,
            'tipo'     => 'entrada',
            'cantidad' => 1,
            'descripcion' => 'Entrada rápida'
        ]);

        return back()->with('success', 'Entrada rápida registrada.');
    }

    public function salidaRapida($id)
    {
        $parte = Parte::findOrFail($id);

        if ($parte->cantidad < 1) {
            return back()->withErrors(['cantidad' => 'No hay stock suficiente para esta salida.']);
        }

        $parte->cantidad -= 1;
        $parte->save();

        Movimiento::create([
            'parte_id' => $parte->id,
            'tipo'     => 'salida',
            'cantidad' => 1,
            'descripcion' => 'Salida rápida'
        ]);

        return back()->with('success', 'Salida rápida registrada.');
    }

    public function syncInventario()
    {
        $partes = Parte::all();
        foreach ($partes as $parte) {
            $parte->syncInventario();
        }

        return redirect()->route('admin.partes.index')->with('success', 'Inventario sincronizado correctamente.');
    }

}

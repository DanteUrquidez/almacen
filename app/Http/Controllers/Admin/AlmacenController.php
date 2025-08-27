<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Almacen;
use App\Models\Parte;
use App\Models\Cliente;

class AlmacenController extends Controller
{

    public function index(Request $request)
    {
        $query = Almacen::query();

        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        $almacenes = $query->orderBy('nombre')->paginate(10)->appends($request->all());
        return view('admin.almacenes.index', compact('almacenes'));
    }


    public function create()
    {
        $partes = Parte::all();
        $almacenes = Almacen::all();
        $clientes = Cliente::all();

        return view('admin.almacenes.create', compact('partes', 'almacenes', 'clientes'));
    }

   
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'        => 'required|string|max:255',
            'identificador' => 'nullable|string|max:10',
            'calle'         => 'nullable|string|max:255',
            'numero'        => 'nullable|string|max:50',
            'colonia'       => 'nullable|string|max:100',
            'ciudad'        => 'nullable|string|max:100',
            'estado'        => 'nullable|string|max:100',
            'pais'          => 'nullable|string|max:100',
            'cp'            => 'nullable|string|max:10',
            'telefono'      => 'nullable|string|max:50',
            'web'           => 'nullable|string|max:255',
        ]);

        Almacen::create($validated);

        return redirect()->route('admin.almacenes.index')->with('success', 'Almacén creado correctamente.');
    }

    public function storeMultiple(Request $request)
    {
        
        $request->validate([
            'almacenes' => 'required|array',
            'almacenes.*.nombre' => 'required|string|max:255',
            'almacenes.*.identificador' => 'nullable|string|max:50',
            'almacenes.*.calle' => 'nullable|string|max:255',
            'almacenes.*.numero' => 'nullable|string|max:50',
            'almacenes.*.colonia' => 'nullable|string|max:255',
            'almacenes.*.ciudad' => 'nullable|string|max:255',
            'almacenes.*.estado' => 'nullable|string|max:255',
            'almacenes.*.pais' => 'nullable|string|max:255',
            'almacenes.*.cp' => 'nullable|string|max:20',
            'almacenes.*.telefono' => 'nullable|string|max:50',
            'almacenes.*.web' => 'nullable|string|max:255',
        ]);

        foreach ($request->input('almacenes') as $almacenData) {
            Almacen::create([
                'nombre' => $almacenData['nombre'],
                'identificador' => $almacenData['identificador'],
                'calle' => $almacenData['calle'] ?? null,
                'numero' => $almacenData['numero'] ?? null,
                'colonia' => $almacenData['colonia'] ?? null,
                'ciudad' => $almacenData['ciudad'] ?? null,
                'estado' => $almacenData['estado'] ?? null,
                'pais' => $almacenData['pais'] ?? null,
                'cp' => $almacenData['cp'] ?? null,
                'telefono' => $almacenData['telefono'] ?? null,
                'web' => $almacenData['web'] ?? null,
            ]);
        }

        return redirect()->route('admin.almacenes.index')
            ->with('success', 'Almacenes creados correctamente.');
    }


    public function edit(Almacen $almacen)
    {
        return view('admin.almacenes.edit', compact('almacen'));
    }

 
    public function update(Request $request, Almacen $almacen)
    {
        $validated = $request->validate([
            'nombre'        => 'required|string|max:255',
            'identificador' => 'nullable|string|max:10|',
            'calle'         => 'nullable|string|max:255',
            'numero'        => 'nullable|string|max:50',
            'colonia'       => 'nullable|string|max:100',
            'ciudad'        => 'nullable|string|max:100',
            'estado'        => 'nullable|string|max:100',
            'pais'          => 'nullable|string|max:100',
            'cp'            => 'nullable|string|max:10',
            'telefono'      => 'nullable|string|max:50',
            'web'           => 'nullable|string|max:255',
        ]);

        $almacen->update($validated);

        return redirect()->route('admin.almacenes.index')->with('success', 'Almacén actualizado correctamente.');
    }


    public function destroy(Almacen $almacen)
    {
        $almacen->delete();
        return redirect()->route('admin.almacenes.index')->with('success', 'Almacén eliminado correctamente.');
    }
}

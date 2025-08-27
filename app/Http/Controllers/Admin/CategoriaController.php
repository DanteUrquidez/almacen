<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index(Request $request)
    {
        $query = Categoria::query();

        if ($request->filled('nombre')) {
            $query->where('nombre', 'LIKE', '%' . $request->nombre . '%');
        }

        $categorias = $query->paginate(10);

        return view('admin.categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('admin.categorias.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ], [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.max'      => 'El campo nombre no debe exceder 255 caracteres.',
        ]);

        Categoria::create($validated);

        return redirect()->route('admin.categorias.index')->with('success', 'Categoría creada exitosamente');
    }

    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('admin.categorias.edit', compact('categoria'));
    }

    public function update(Request $request, $id)
    {
        $categoria = Categoria::findOrFail($id);

        $validated = $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ], [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.max'      => 'El campo nombre no debe exceder 255 caracteres.',
        ]);

        $categoria->update($validated);

        return redirect()->route('admin.categorias.index')->with('success', 'Categoría actualizada exitosamente');
    }

    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();

        return redirect()->route('admin.categorias.index')->with('success', 'Categoría eliminada correctamente');
    }

    public function storeMultiple(Request $request)
{
    $request->validate([
        'categorias' => 'required|array',
        'categorias.*.nombre' => 'required|string|max:255',
        'categorias.*.descripcion' => 'nullable|string',
    ]);

    foreach ($request->categorias as $categoriaData) {
        \App\Models\Categoria::create($categoriaData);
    }

    return redirect()->route('admin.categorias.index')->with('success', 'Categorías creadas correctamente.');
}
}

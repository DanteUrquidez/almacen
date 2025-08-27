<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    public function index(Request $request)
{
    $query = Cliente::query();

    if ($request->has('nombre') && $request->nombre != '') {
        $query->where('nombre', 'LIKE', '%' . $request->nombre . '%');
    }

    $clientes = $query->orderBy('nombre')->paginate(10)->appends($request->all());

    return view('admin.clientes.index', compact('clientes'));
}


    public function create()
    {
        return view('admin.clientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'identificador' => 'nullable|string|max:10',
            'calle'  => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:50',
            'colonia'=> 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:255',
            'pais'   => 'nullable|string|max:255',
            'cp'     => 'nullable|string|max:20',
        ]);

        $base = $request->identificador_base;

        $ultimoCliente = Cliente::where('identificador', 'like', $base.'%')
            ->orderBy('identificador', 'desc')
            ->first();

        if ($ultimoCliente) {
            $ultimoNumero = intval(substr($ultimoCliente->identificador, -2));
            $nuevoNumero = str_pad($ultimoNumero + 1, 2, '0', STR_PAD_LEFT);
        } else {
            $nuevoNumero = '01';
        }

        $identificadorCompleto = $base . $nuevoNumero;

        $cliente = Cliente::create(array_merge(
            $request->all(),
            ['identificador' => $identificadorCompleto]
        ));

        return redirect()->route('admin.clientes.index')
                        ->with('success', 'Cliente creado correctamente con identificador '.$identificadorCompleto);
    }

    public function edit(Cliente $cliente)
    {
        return view('admin.clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $request->validate(Cliente::rules());

        $cliente->update($request->all());

        return redirect()->route('admin.clientes.index')
                         ->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return redirect()->route('admin.clientes.index')
                         ->with('success', 'Cliente eliminado correctamente.');
    }

    public function storeMultiple(Request $request)
    {
        $request->validate([
            'clientes' => 'required|array',
            'clientes.*.nombre' => 'required|string|max:255',
            'clientes.*.identificador' => 'nullable|string|max:10',
            'clientes.*.calle' => 'nullable|string|max:255',
            'clientes.*.numero' => 'nullable|string|max:50',
            'clientes.*.colonia' => 'nullable|string|max:255',
            'clientes.*.ciudad' => 'nullable|string|max:255',
            'clientes.*.estado' => 'nullable|string|max:255',
            'clientes.*.pais' => 'nullable|string|max:255',
            'clientes.*.cp' => 'nullable|string|max:20',
        ]);

        foreach ($request->clientes as $clienteData) {
            \App\Models\Cliente::create($clienteData);
        }

        return redirect()->route('admin.clientes.index')
                        ->with('success', 'Clientes creados correctamente.');
    }

}

<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Parte;
use App\Models\Movimiento;
use App\Models\Cliente;
use App\Models\Almacen;
use Illuminate\Support\Facades\DB;

class MovimientoController extends Controller
{
    public function index(Request $request)
    {
        $query = Movimiento::with('parte')->orderBy('created_at', 'desc');

        if ($request->filled('tipo') && in_array($request->tipo, ['entrada', 'salida'])) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('parte')) {
            $query->whereHas('parte', function($q) use ($request) {
                $q->where('nombre', 'LIKE', '%' . $request->parte . '%');
            });
        }

        $movimientos = $query->paginate(10)->appends($request->all());

        return view('admin.movimientos.index', compact('movimientos'));
    }

    public function show($id)
    {
        $movimiento = Movimiento::with('parte')->findOrFail($id);
        return view('admin.movimientos.show', compact('movimiento'));
    }

    public function create()
    {
        $almacenes = \App\Models\Almacen::all();
        $clientes  = \App\Models\Cliente::all();
        $partes    = \App\Models\Parte::all();

        return view('admin.movimientos.create', compact('almacenes', 'clientes', 'partes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'parte_id'    => 'required|exists:partes,id',
            'tipo'        => 'required|in:entrada,salida',
            'cantidad'    => 'required|integer|min:1',
            'descripcion' => 'nullable|string'
        ]);

        $parte = Parte::findOrFail($request->parte_id);

        if ($request->tipo === 'entrada') {
            $parte->cantidad += $request->cantidad;
        } else {
            if ($parte->cantidad < $request->cantidad) {
                return back()->withErrors(['cantidad' => 'No hay suficiente stock para esta salida.']);
            }
            $parte->cantidad -= $request->cantidad;
        }
        $parte->save();

        Movimiento::create([
            'parte_id'    => $parte->id,
            'tipo'        => $request->tipo,
            'cantidad'    => $request->cantidad,
            'descripcion' => $request->descripcion
        ]);

        return redirect()->route('admin.movimientos.index')->with('success', 'Movimiento registrado correctamente.');
    }

    public function storeMultiple(Request $request)
    {
        $request->validate([
            'almacen_id' => 'required|exists:almacenes,id',
            'cliente_id' => 'required|exists:clientes,id',
            'movimientos' => 'required|array',
            'movimientos.*.parte_id' => 'required|exists:partes,id',
            'movimientos.*.tipo' => 'required|in:entrada,salida',
            'movimientos.*.cantidad' => 'required|integer|min:1',
            'movimientos.*.descripcion' => 'nullable|string',
        ]);

        $movimientosRegistrados = [];
        foreach ($request->movimientos as $m) {
            $parte = Parte::findOrFail($m['parte_id']);
            if($m['tipo']=='entrada'){
                $parte->cantidad += $m['cantidad'];
            } else {
                if($parte->cantidad < $m['cantidad']){
                    continue;
                }
                $parte->cantidad -= $m['cantidad'];
            }
            $parte->save();

            $movimientosRegistrados[] = Movimiento::create([
                'parte_id' => $m['parte_id'],
                'cliente_id' => $request->cliente_id,
                'almacen_id' => $request->almacen_id,
                'tipo' => $m['tipo'],
                'cantidad' => $m['cantidad'],
                'descripcion' => $m['descripcion'] ?? 'Movimiento masivo',
            ]);
        }
        return redirect()->route('admin.movimientos.index')->with('success','Movimientos masivos registrados correctamente.');
    }

    public function storeMultiplePacking(Request $request)
    {
        $request->validate([
            'buyer' => 'required|string|max:255',
            'shipping_date' => 'required|date',
            'purchase_order' => 'nullable|string|max:255',
            'serial' => 'required|exists:almacenes,id',
            'cliente_id' => 'required|exists:clientes,id',
            'shipped_from' => 'required|string',
            'sold_to' => 'required|string',
            'shipped_to' => 'required|string',
            'cajas' => 'required|array|min:1',
            'cajas.*.items' => 'required|array|min:1',
        ]);

        $movimiento = \App\Models\Movimiento::create([
            'buyer' => $request->buyer,
            'shipping_date' => $request->shipping_date,
            'purchase_order' => $request->purchase_order,
            'serial' => $request->serial,
            'cliente_id' => $request->cliente_id,
            'shipped_from' => $request->shipped_from,
            'sold_to' => $request->sold_to,
            'shipped_to' => $request->shipped_to,
        ]);

        foreach ($request->cajas as $cajaIndex => $caja) {
            $cajaModel = $movimiento->cajas()->create([
                'numero' => $cajaIndex + 1,
            ]);

            foreach ($caja['items'] as $item) {
                $cajaModel->items()->create([
                    'parte_id' => $item['parte_id'],
                    'item_no' => $item['item_no'] ?? null,
                    'pkg_size' => $item['pkg_size'] ?? null,
                    'pkg_weight' => $item['pkg_weight'] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.movimientos.index')
            ->with('success', 'Packing List generado correctamente.');
    }




    public function edit($id)
    {
        $movimiento = Movimiento::findOrFail($id);
        $partes = Parte::all();
        return view('admin.movimientos.edit', compact('movimiento', 'partes'));
    }

    public function update(Request $request, $id)
    {
        $movimiento = Movimiento::findOrFail($id);

        $request->validate([
            'parte_id'    => 'required|exists:partes,id',
            'tipo'        => 'required|in:entrada,salida',
            'cantidad'    => 'required|integer|min:1',
            'descripcion' => 'nullable|string'
        ]);

        $parte = Parte::findOrFail($request->parte_id);
        if ($movimiento->tipo === 'entrada') {
            $movimiento->parte->cantidad -= $movimiento->cantidad;
        } else {
            $movimiento->parte->cantidad += $movimiento->cantidad;
        }
        $movimiento->parte->save();

        if ($request->tipo === 'entrada') {
            $parte->cantidad += $request->cantidad;
        } else {
            if ($parte->cantidad < $request->cantidad) {
                return back()->withErrors(['cantidad' => 'No hay suficiente stock para esta salida.']);
            }
            $parte->cantidad -= $request->cantidad;
        }
        $parte->save();
        $movimiento->update([
            'parte_id'    => $request->parte_id,
            'tipo'        => $request->tipo,
            'cantidad'    => $request->cantidad,
            'descripcion' => $request->descripcion
        ]);

        return redirect()->route('admin.movimientos.index')->with('success', 'Movimiento actualizado correctamente.');
    }

    public function destroy($id)
    {
        $movimiento = Movimiento::findOrFail($id);
        $parte = $movimiento->parte;
        if ($movimiento->tipo === 'entrada') {
            $parte->cantidad -= $movimiento->cantidad;
        } else {
            $parte->cantidad += $movimiento->cantidad;
        }
        $parte->save();

        $movimiento->delete();

        return redirect()->route('admin.movimientos.index')->with('success', 'Movimiento eliminado correctamente.');
    }


}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Caja;
use App\Models\Parte;
use App\Models\Almacen;
use App\Models\Cliente;
use App\Models\Movimiento;
use Barryvdh\DomPDF\Facade\Pdf;

class CajaController extends Controller
{
    /**
     * Listado de cajas
     */
    public function index()
    {
        $cajas = Caja::with(['items.parte', 'movimiento.almacen', 'movimiento.cliente'])
                     ->paginate(15);

        return view('admin.cajas.index', compact('cajas'));
    }

    /**
     * Formulario de creación
     */
    public function create()
    {
        $partes    = Parte::all();
        $almacenes = Almacen::all();
        $clientes  = Cliente::all();

        return view('admin.cajas.create', compact('partes', 'almacenes', 'clientes'));
    }

    /**
     * Guardar nuevas cajas (Packing)
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'buyer'          => 'required|string',
            'shipping_date'  => 'required|date',
            'purchase_order' => 'nullable|string',
            'shipped_from'   => 'required|string',
            'sold_to'        => 'required|string',
            'shipped_to'     => 'nullable|string',
            'cliente_id'     => 'required|exists:clientes,id',
            'serial'         => 'required|exists:almacenes,id',
            'cajas'          => 'required|array|min:1',
            'cajas.*.items'  => 'required|array|min:1',
            'cajas.*.items.*.parte_id' => 'required|exists:partes,id',
            'cajas.*.items.*.item_no'  => 'nullable|string',
            'cajas.*.items.*.pkg_size' => 'nullable|string',
            'cajas.*.items.*.pkg_weight' => 'nullable|string',
            'cajas.*.items.*.cantidad'   => 'nullable|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            // Crear movimiento
            $primeraParteId = $request->cajas[0]['items'][0]['parte_id'] ?? null;
            $movimiento = Movimiento::create([
                'cliente_id'     => $request->cliente_id,
                'almacen_id'     => $request->serial,
                'tipo'           => 'salida',
                'descripcion'    => "Buyer: {$request->buyer}",
                'purchase_order' => $request->purchase_order ?? null,
                'shipping_date'  => $request->shipping_date,
                'shipped_from'   => $request->shipped_from,
                'sold_to'        => $request->sold_to,
                'shipped_to'     => $request->shipped_to,
                'parte_id'       => $primeraParteId,
                'cantidad'       => 1,
            ]);

            // Crear cajas y sus items
            $consecutivo = 1;
            foreach ($request->cajas as $cajaData) {
                $caja = Caja::create([
                    'numero'        => $cajaData['numero'] ?? Caja::max('numero') + 1,
                    'movimiento_id' => $movimiento->id,
                    'buyer'         => $data['buyer'],
                    'shipping_date' => $data['shipping_date'],
                    'purchase_order'=> $data['purchase_order'],
                    'shipped_from'  => $data['shipped_from'],
                    'sold_to'       => $data['sold_to'],
                    'shipped_to'    => $data['shipped_to'],
                    'cliente_id'    => $data['cliente_id'],
                    'almacen_id'    => $data['serial'],
                ]);

                foreach ($cajaData['items'] as $itemData) {
                    $caja->items()->create([
                        'parte_id'   => $itemData['parte_id'],
                        'item_no'    => $itemData['item_no']    ?? null,
                        'pkg_size'   => $itemData['pkg_size']   ?? null,
                        'pkg_weight' => $itemData['pkg_weight'] ?? null,
                        'cantidad'   => $itemData['cantidad']   ?? 1,
                    ]);
                }

                $consecutivo++;
            }

            DB::commit();

            return redirect()->route('admin.cajas.index')
                            ->with('success', 'Caja(s) creada(s) correctamente.');

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()
                        ->withErrors(['store_error' => 'No se pudo guardar el packing: '.$e->getMessage()]);
        }
    }

    /**
     * Formulario de edición
     */
    public function edit(Caja $caja)
    {
        $partes    = Parte::all();
        $almacenes = Almacen::all();
        $clientes  = Cliente::all();

        $caja->load(['items.parte', 'movimiento.cliente', 'movimiento.almacen']);

        return view('admin.cajas.edit', compact('caja', 'partes', 'almacenes', 'clientes'));
    }

    /**
     * Actualizar una caja
     */
    public function update(Request $request, Caja $caja)
    {
        $request->validate([
            'numero'        => 'required|integer',
            'movimiento_id' => 'nullable|exists:movimientos,id',
            'items'                      => 'required|array|min:1',
            'items.*.parte_id'           => 'required|exists:partes,id',
            'items.*.item_no'            => 'nullable|string',
            'items.*.pkg_size'           => 'nullable|string',
            'items.*.pkg_weight'         => 'nullable|string',
            'items.*.cantidad'           => 'nullable|numeric|min:1',
        ]);

        DB::beginTransaction();
        try {
            $caja->update([
                'numero'        => $request->numero,
                'movimiento_id' => $request->movimiento_id ?? $caja->movimiento_id,
            ]);

            // Reemplazar items
            $caja->items()->delete();

            foreach ($request->items as $item) {
                $caja->items()->create([
                    'parte_id'   => $item['parte_id'],
                    'item_no'    => $item['item_no']    ?? null,
                    'pkg_size'   => $item['pkg_size']   ?? null,
                    'pkg_weight' => $item['pkg_weight'] ?? null,
                    'cantidad'   => $item['cantidad']   ?? 1,
                ]);
            }

            DB::commit();

            return redirect()->route('admin.cajas.index')
                             ->with('success', 'Caja actualizada correctamente.');

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()
                         ->withErrors(['update_error' => 'No se pudo actualizar la caja: '.$e->getMessage()]);
        }
    }

    /**
     * Eliminar caja
     */
    public function destroy(Caja $caja)
    {
        $caja->delete();
        return redirect()->route('admin.cajas.index')
                         ->with('success', 'Caja eliminada correctamente.');
    }

    /**
     * Generar PDF en el navegador
     */
    public function generatePdf(Caja $caja)
    {
        $caja->load([
            'cliente',
            'almacen',
            'items.parte'
        ]);

        $pdf = Pdf::loadView('admin.cajas.pdf', compact('caja'))
                ->setPaper('a4', 'portrait');

        return $pdf->stream("PackingList_Caja_{$caja->id}.pdf");
    }
}

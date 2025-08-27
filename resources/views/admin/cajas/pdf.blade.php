<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Packing List - Caja {{ $caja->numero ?? '' }}</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; font-size: 11px; }
        th { background: #f5f5f5; }
        .header-table td { border: none; padding: 2px 6px; vertical-align: top; }
        .company-title { font-size: 18px; font-weight: bold; }
        .packing-title { font-size: 20px; font-weight: bold; text-align: right; }
        .section-title { font-weight: bold; }
        .info-table td { padding: 2px 5px; border: none; }
        .packing-info { color: #d00; font-weight: bold; }
        .signature { margin-top: 30px; }
    </style>
</head>
<body>
    <table class="header-table" width="100%">
        <tr>
            <td width="60%">
                <div class="company-title">CoreBox de México</div>
                <div>
                    <strong>COREBOX DE MEXICO S. DE R.L. DE C.V.</strong><br>
                    {{ $caja->almacen->calle ?? '' }},
                    {{ $caja->almacen->numero ?? '' }},
                    {{ $caja->almacen->colonia ?? '' }}<br>
                    {{ $caja->almacen->ciudad ?? '' }},
                    {{ $caja->almacen->estado ?? '' }},
                    {{ $caja->almacen->pais ?? '' }}.
                    C.P. {{ $caja->almacen->cp ?? '' }}<br>
                    {{ $caja->almacen->telefono ?? '' }}<br>
                    {{ $caja->almacen->web ?? '' }}
                </div>

                <br>
                <div class="section-title">Sold to:</div>
                    <div>
                        <strong>{{ $caja->cliente->nombre ?? '' }}</strong><br>
                        {{ $caja->sold_to ?? '' }}
                    </div>

            <td width="40%" align="right">
                <div class="packing-title">Packing List</div>
                <table class="info-table">
                    <tr>
                        <td class="packing-info">Packing list No.:</td>
                        <td>{{ $caja->numero ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="packing-info">Serial:</td>
                        <td>{{ $caja->almacen->identificador ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="packing-info">Buyer:</td>
                        <td>{{ $caja->buyer ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="packing-info">Purchase order no:</td>
                        <td>{{ $caja->purchase_order ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="packing-info">Shipping date:</td>
                        <td>{{ $caja->shipping_date ? \Carbon\Carbon::parse($caja->shipping_date)->format('d-M-Y') : '' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="info-table" width="100%">
        <tr>
            <td width="50%">
                <div class="section-title">Shipped from:</div>
                    <div>
                        <strong>{{ $almacen->nombre ?? '' }}</strong>
                        ({{ $caja->almacen->identificador ?? '' }})<br>
                        {{ $caja->shipped_from ?? '' }}
                    </div>

            </td>
            <td width="50%">
                <div class="section-title">Shipped to:</div>
                    <div>
                        {{ $caja->shipped_to ?? '' }}
                    </div>

            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>Pkg No.</th>
                <th>Pkg Type</th>
                <th>Pkg size</th>
                <th>Pkg gross weight</th>
                <th>Item No.</th>
                <th>Part No.</th>
                <th>Qty shipped</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach($caja->items as $index => $item)
                <tr>
                    <td>{{ $caja->numero ?? '' }}</td>
                    <td>Box</td>
                    <td>{{ $item->pkg_size ?? '' }}</td>
                    <td>{{ $item->pkg_weight ?? '' }}</td>
                    <td>{{ $item->item_no ?? ($index + 1) }}</td>
                    <td>{{ $item->parte->nombre ?? '' }}</td>
                    <td>{{ $item->cantidad ?? 1 }}</td>
                    <td>{{ $item->parte->descripcion ?? '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signature">
        <div>Shipping instructions:</div>
        <br>
        <div>Received by: ____________________________________________</div>
        <div>Name in print: __________________________________________</div>
        <div>Date: _________________________________________________</div>
    </div>
</body>
</html>

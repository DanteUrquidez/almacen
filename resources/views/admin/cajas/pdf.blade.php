<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Packing List - Caja {{ $caja->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        h1, h2, h3 { color: #0a2e61; }
        .header { text-align: center; margin-bottom: 20px; }
        .section { margin-bottom: 15px; }
        .section h3 { margin-bottom: 5px; border-bottom: 1px solid #ddd; padding-bottom: 3px; }
        .info { margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid #555; }
        th { background: #0a2e61; color: white; padding: 6px; font-size: 11px; }
        td { padding: 5px; font-size: 11px; }
    </style>
</head>
<body>
    <!-- Header de empresa -->
    <div class="header">
        <h2>COREBOX DE MEXICO S. DE R.L. DE C.V.</h2>
        <p>
            Carretera a la Colorada, km 3.5, plaza futura, bodega #11,<br>
            colonia parque industrial, Hermosillo, Sonora, México. C.P. 83299<br>
            +52 (662) 309 38 22
        </p>
    </div>

    <!-- Datos principales -->
    <div class="section">
        <h3>Datos de Envío</h3>
        <p><strong>Buyer:</strong> {{ $caja->buyer }}</p>
        <p><strong>Shipping Date:</strong> {{ \Carbon\Carbon::parse($caja->shipping_date)->format('d-M-Y') }}</p>
        <p><strong>Purchase Order:</strong> {{ $caja->purchase_order ?? 'N/A' }}</p>
    </div>

    <div class="section">
        <div class="info">
            <h3>Shipped From:</h3>
            @if($caja->almacen)
                {{ $caja->almacen->nombre }} ({{ $caja->almacen->identificador }})<br>
                {{ $caja->almacen->calle }} {{ $caja->almacen->numero }}, {{ $caja->almacen->colonia }}<br>
                {{ $caja->almacen->ciudad }}, {{ $caja->almacen->estado }}, {{ $caja->almacen->pais }}.
                C.P. {{ $caja->almacen->cp }}<br>
                {{ $caja->almacen->telefono }} - {{ $caja->almacen->web }}
            @endif
        </div>

        <div class="info">
            <h3>Sold To:</h3>
            @if($caja->cliente)
                {{ $caja->cliente->nombre }}<br>
                {{ $caja->cliente->calle }} {{ $caja->cliente->numero }}, {{ $caja->cliente->colonia }}<br>
                {{ $caja->cliente->ciudad }}, {{ $caja->cliente->estado }}, {{ $caja->cliente->pais }}.
                C.P. {{ $caja->cliente->cp }}
            @endif
        </div>

        <div class="info">
            <h3>Shipped To:</h3>
            {{ $caja->shipped_to ?? $caja->cliente->nombre ?? '' }}
        </div>
    </div>

    <!-- Tabla de items -->
    <div class="section">
        <h3>Detalle de Cajas e Items</h3>
        <table>
            <thead>
                <tr>
                    <th>Pkg No.</th>
                    <th>Pkg Size</th>
                    <th>Pkg Gross Weight</th>
                    <th>Item No.</th>
                    <th>Part No.</th>
                    <th>Qty Shipped</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach($caja->items as $item)
                    <tr>
                        <td>{{ $caja->numero }}</td>
                        <td>{{ $item->pkg_size }}</td>
                        <td>{{ $item->pkg_weight }}</td>
                        <td>{{ $item->item_no }}</td>
                        <td>{{ $item->parte->id }}</td>
                        <td>{{ $item->cantidad }}</td>
                        <td>{{ $item->parte->descripcion }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>

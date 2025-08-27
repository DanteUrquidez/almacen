@extends('layouts.stisla')

@section('title', 'Inventario')

@section('content')
<div class="section">
    <div class="section-header">
        <h1>Inventario</h1>
        <div class="section-header-button ml-auto">
            <a href="{{ route('admin.inventario.sync') }}" class="btn btn-primary btn-sm">Sincronizar Inventario</a>
        </div>
    </div>

    <div class="section-body">
        <form method="GET" action="{{ route('admin.movimientos.index') }}" class="form-inline mb-3">
            <div class="form-group mr-2">
                <select name="tipo" class="form-control">
                    <option value="">Todos</option>
                    <option value="entrada" {{ request('tipo') == 'entrada' ? 'selected' : '' }}>Entrada</option>
                    <option value="salida" {{ request('tipo') == 'salida' ? 'selected' : '' }}>Salida</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </form>


        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Parte</th>
                            <th>Categoría</th>
                            <th>Stock Actual</th>
                            <th>Última Actualización</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inventario as $item)
                        <tr>
                            <td>{{ $item->parte->nombre }}</td>
                            <td>{{ $item->parte->categoria->nombre ?? '-' }}</td>
                            <td 
                                @if($item->parte->cantidad >= $item->parte->maximo)
                                    style="background-color: #d4edda;"
                                @elseif($item->parte->cantidad <= $item->parte->minimo)
                                    style="background-color: #f8d7da;"
                                @endif
                            >
                                {{ $item->parte->cantidad }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($item->fecha_actualizacion)->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.movimientos.index', $item->id_parte) }}" class="btn btn-info btn-sm">Movimientos</a>
                                <a href="{{ route('admin.partes.edit', $item->id_parte) }}" class="btn btn-warning btn-sm">Editar</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No hay registros en inventario</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-center mt-3">
                    {{ $inventario->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

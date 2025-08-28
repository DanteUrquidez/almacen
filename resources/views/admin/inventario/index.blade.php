@extends('layouts.stisla')

@section('title', 'Inventario')

@section('content')
<div class="section">
    <div class="section-header">
        <h1><i class="fas fa-warehouse"></i> Inventario</h1>
        <div class="ml-auto">
            <a href="{{ route('admin.inventario.sync') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-sync-alt"></i> Sincronizar Inventario
            </a>
        </div>
    </div>

    <div class="section-body">

        {{-- Filtros --}}
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.movimientos.index') }}" class="form-inline flex-wrap">
                    <div class="form-group mr-2 mb-2">
                        <select name="tipo" class="form-control">
                            <option value="">Todos</option>
                            <option value="entrada" {{ request('tipo') == 'entrada' ? 'selected' : '' }}>Entrada</option>
                            <option value="salida" {{ request('tipo') == 'salida' ? 'selected' : '' }}>Salida</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                </form>
            </div>
        </div>

        {{-- Tabla de inventario --}}
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Lista de Inventario</h4>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Parte</th>
                            <th>Categoría</th>
                            <th class="text-center">Stock Actual</th>
                            <th>Última Actualización</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inventario as $item)
                            <tr>
                                <td>{{ $item->parte->nombre }}</td>
                                <td>{{ $item->parte->categoria->nombre ?? '-' }}</td>
                                <td class="text-center">
                                    @if($item->parte->cantidad >= $item->parte->maximo)
                                        <span class="badge badge-success">{{ $item->parte->cantidad }}</span>
                                    @elseif($item->parte->cantidad <= $item->parte->minimo)
                                        <span class="badge badge-danger">{{ $item->parte->cantidad }}</span>
                                    @else
                                        <span class="badge badge-warning">{{ $item->parte->cantidad }}</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($item->fecha_actualizacion)->format('d/m/Y') }}</td>
                                <td class="text-center text-nowrap">
                                    <a href="{{ route('admin.movimientos.index', $item->id_parte) }}" 
                                       class="btn btn-info btn-sm" title="Movimientos">
                                        <i class="fas fa-exchange-alt"></i>
                                    </a>
                                    <a href="{{ route('admin.partes.edit', $item->id_parte) }}" 
                                       class="btn btn-warning btn-sm" title="Editar Parte">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="fas fa-boxes fa-2x mb-2"></i><br>
                                    No hay registros en inventario.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Paginación --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $inventario->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection

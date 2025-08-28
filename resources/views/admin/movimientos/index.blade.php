@extends('layouts.stisla')

@section('title', 'Movimientos de Inventario')

@section('content')
<div class="section">
    <div class="section-header">
        <h1><i class="fas fa-exchange-alt"></i> Movimientos</h1>
        <div class="ml-auto">
            <a href="{{ route('admin.movimientos.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Registrar Movimiento
            </a>
        </div>
    </div>

    <div class="section-body">
        {{-- Filtros --}}
        <form method="GET" action="{{ route('admin.movimientos.index') }}" class="mb-4">
            <div class="form-row">
                <div class="col-md-4 mb-2">
                    <input type="text" name="parte" class="form-control" 
                           placeholder="🔎 Buscar por parte"
                           value="{{ request('parte') }}">
                </div>
                <div class="col-md-3 mb-2">
                    <select name="tipo" class="form-control">
                        <option value="">📂 Todos los tipos</option>
                        <option value="entrada" {{ request('tipo')=='entrada' ? 'selected' : '' }}>Entrada</option>
                        <option value="salida" {{ request('tipo')=='salida' ? 'selected' : '' }}>Salida</option>
                    </select>
                </div>
                <div class="col-md-2 mb-2">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                </div>
            </div>
        </form>

        {{-- Alertas --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">×</button>
            </div>
        @endif

        {{-- Tabla --}}
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Historial de Movimientos</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Fecha</th>
                                <th>Parte</th>
                                <th>Tipo</th>
                                <th>Cantidad</th>
                                <th>Descripción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($movimientos as $movimiento)
                                <tr>
                                    <td>{{ $movimiento->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $movimiento->parte->nombre ?? '—' }}</td>
                                    <td>
                                        @if($movimiento->tipo === 'entrada')
                                            <span class="badge badge-success">
                                                <i class="fas fa-arrow-down"></i> Entrada
                                            </span>
                                        @else
                                            <span class="badge badge-danger">
                                                <i class="fas fa-arrow-up"></i> Salida
                                            </span>
                                        @endif
                                    </td>
                                    <td><strong>{{ $movimiento->cantidad }}</strong></td>
                                    <td>{{ $movimiento->descripcion ?? '—' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="fas fa-box-open fa-2x mb-2"></i><br>
                                        No se encontraron movimientos.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Paginación --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $movimientos->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection

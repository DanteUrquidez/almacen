@extends('layouts.stisla')

@section('title', 'Partes')

@section('content')
<div class="section">
    <div class="section-header">
        <h1><i class="fas fa-cogs"></i> Partes</h1>
        <div class="ml-auto">
            <a href="{{ route('admin.partes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nueva Parte
            </a>
        </div>
    </div>

    <div class="section-body">

        {{-- Barra de búsqueda --}}
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.partes.index') }}" class="form-inline flex-wrap">
                    <div class="form-group mr-2 mb-2">
                        <input type="text" name="nombre" class="form-control" placeholder="Buscar por nombre" value="{{ request('nombre') }}">
                    </div>
                    <button type="submit" class="btn btn-primary mr-2 mb-2">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                    <a href="{{ route('admin.partes.index') }}" class="btn btn-secondary mb-2">
                        <i class="fas fa-undo"></i> Limpiar
                    </a>
                </form>
            </div>
        </div>

        {{-- Tabla de partes --}}
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Lista de Partes</h4>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($partes as $parte)
                            <tr>
                                <td>{{ $parte->nombre }}</td>
                                <td>{{ $parte->categoria->nombre ?? '-' }}</td>
                                <td class="text-center">
                                    @if($parte->cantidad >= $parte->maximo)
                                        <span class="badge badge-success">{{ $parte->cantidad }}</span>
                                    @elseif($parte->cantidad <= $parte->minimo)
                                        <span class="badge badge-danger">{{ $parte->cantidad }}</span>
                                    @else
                                        <span class="badge badge-warning">{{ $parte->cantidad }}</span>
                                    @endif
                                </td>
                                <td class="text-center text-nowrap">
                                    <form action="{{ route('admin.partes.entrada-rapida', $parte->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm" title="Entrada rápida">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.partes.salida-rapida', $parte->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm" title="Salida rápida">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </form>

                                    <a href="{{ route('admin.partes.edit', $parte->id) }}" class="btn btn-warning btn-sm" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.partes.movimientos', $parte->id) }}" class="btn btn-info btn-sm" title="Movimientos">
                                        <i class="fas fa-exchange-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <i class="fas fa-box-open fa-2x mb-2"></i><br>
                                    No se encontraron partes registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Paginación --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $partes->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection

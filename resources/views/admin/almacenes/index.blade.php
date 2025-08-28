@extends('layouts.stisla')

@section('title', 'Almacenes')

@section('content')
<div class="section">
    <div class="section-header">
        <h1>Almacenes</h1>
        <div class="ml-auto">
            <a href="{{ route('admin.almacenes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nuevo Almacén
            </a>
        </div>
    </div>

    <div class="section-body">
        {{-- Buscador --}}
        <form method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="nombre" value="{{ request('nombre') }}" 
                       class="form-control" placeholder="🔎 Buscar almacén por nombre...">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Buscar</button>
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
                <h4 class="mb-0">Lista de Almacenes</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Nombre</th>
                                <th>Identificador</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th>Web</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($almacenes as $almacen)
                                <tr>
                                    <td class="font-weight-bold">{{ $almacen->nombre }}</td>
                                    <td><span class="badge badge-info">{{ $almacen->identificador }}</span></td>
                                    <td>
                                        {{ $almacen->calle }} {{ $almacen->numero }},
                                        {{ $almacen->colonia }}, {{ $almacen->ciudad }},
                                        {{ $almacen->estado }}, {{ $almacen->pais }},
                                        C.P. {{ $almacen->cp }}
                                    </td>
                                    <td>{{ $almacen->telefono ?? '—' }}</td>
                                    <td>
                                        @if($almacen->web)
                                            <a href="{{ $almacen->web }}" target="_blank" class="text-primary">
                                                {{ $almacen->web }}
                                            </a>
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.almacenes.edit', $almacen) }}" 
                                           class="btn btn-warning btn-sm">
                                           <i class="fas fa-edit"></i> Editar
                                        </a>
                                        <form action="{{ route('admin.almacenes.destroy', $almacen) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('¿Eliminar este almacén?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="fas fa-warehouse fa-2x mb-2"></i><br>
                                        No hay almacenes registrados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Paginación --}}
        <div class="mt-3">
            {{ $almacenes->links() }}
        </div>
    </div>
</div>
@endsection

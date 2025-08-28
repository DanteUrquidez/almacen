@extends('layouts.stisla')

@section('title', 'Clientes')

@section('content')
<div class="section">
    <div class="section-header">
        <h1><i class="fas fa-users"></i> Clientes</h1>
        <div class="ml-auto">
            <a href="{{ route('admin.clientes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nuevo Cliente
            </a>
        </div>
    </div>

    <div class="section-body">

        {{-- Filtros de búsqueda --}}
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.clientes.index') }}" class="form-inline flex-wrap">
                    <div class="form-group mr-2 mb-2">
                        <input type="text" name="nombre" class="form-control" placeholder="Buscar por nombre" value="{{ request('nombre') }}">
                    </div>
                    <button type="submit" class="btn btn-primary mr-2 mb-2">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                    <a href="{{ route('admin.clientes.index') }}" class="btn btn-secondary mb-2">
                        <i class="fas fa-undo"></i> Limpiar
                    </a>
                </form>
            </div>
        </div>

        {{-- Tabla de clientes --}}
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Lista de Clientes</h4>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Identificador</th>
                            <th>Dirección</th>
                            <th>Ciudad</th>
                            <th>Estado</th>
                            <th>País</th>
                            <th>C.P.</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clientes as $cliente)
                            <tr>
                                <td>{{ $cliente->nombre }}</td>
                                <td>{{ $cliente->identificador }}</td>
                                <td>{{ $cliente->calle }} {{ $cliente->numero }}, {{ $cliente->colonia }}</td>
                                <td>{{ $cliente->ciudad }}</td>
                                <td>{{ $cliente->estado }}</td>
                                <td>{{ $cliente->pais }}</td>
                                <td>{{ $cliente->cp }}</td>
                                <td class="text-center text-nowrap">
                                    <a href="{{ route('admin.clientes.edit', $cliente->id) }}" 
                                       class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <form action="{{ route('admin.clientes.destroy', $cliente) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('¿Seguro que quieres eliminar este cliente?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="fas fa-user-slash fa-2x mb-2"></i><br>
                                    No hay clientes registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Paginación --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $clientes->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection

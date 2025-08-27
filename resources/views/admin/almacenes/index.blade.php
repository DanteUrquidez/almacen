@extends('layouts.stisla')

@section('title', 'Almacenes')

@section('content')
<div class="section">
    <div class="section-header">
        <h1>Almacenes</h1>
        <div class="ml-auto">
            <a href="{{ route('admin.almacenes.create') }}" class="btn btn-primary">Nuevo Almacén</a>
        </div>
    </div>

    <div class="section-body">
        <form method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="nombre" value="{{ request('nombre') }}" class="form-control" placeholder="Buscar por nombre">
                <div class="input-group-append">
                    <button class="btn btn-secondary" type="submit">Buscar</button>
                </div>
            </div>
        </form>

        <div class="card">
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Identificador</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Web</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($almacenes as $almacen)
                            <tr>
                                <td>{{ $almacen->nombre }}</td>
                                <td>{{ $almacen->identificador }}</td>
                                <td>
                                    {{ $almacen->calle }} {{ $almacen->numero }}, {{ $almacen->colonia }}, 
                                    {{ $almacen->ciudad }}, {{ $almacen->estado }}, {{ $almacen->pais }}, {{ $almacen->cp }}
                                </td>
                                <td>{{ $almacen->telefono }}</td>
                                <td>{{ $almacen->web }}</td>
                                <td>
                                    <a href="{{ route('admin.almacenes.edit', $almacen) }}" class="btn btn-warning btn-sm">Editar</a>
                                    <form action="{{ route('admin.almacenes.destroy', $almacen) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este almacén?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No hay almacenes registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-3">
            {{ $almacenes->links() }}
        </div>
    </div>
</div>
@endsection

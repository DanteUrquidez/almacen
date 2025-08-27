@extends('layouts.stisla')

@section('title', 'Clientes')

@section('content')
<div class="section">
    <div class="section-header">
        <h1>Clientes</h1>
        <div class="section-header-button ml-auto">
            <a href="{{ route('admin.clientes.create') }}" class="btn btn-primary">Nuevo Cliente</a>
        </div>
    </div>

    <div class="section-body">

        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.clientes.index') }}" class="form-inline flex-wrap">
                    <div class="form-group mr-2 mb-2">
                        <input type="text" name="nombre" class="form-control" placeholder="Buscar por nombre" value="{{ request('nombre') }}">
                    </div>
                    <button type="submit" class="btn btn-primary mr-2 mb-2">Buscar</button>
                    <a href="{{ route('admin.clientes.index') }}" class="btn btn-secondary mb-2">Limpiar</a>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Identificador</th>
                            <th>Calle</th>
                            <th>Número</th>
                            <th>Colonia</th>
                            <th>Ciudad</th>
                            <th>Estado</th>
                            <th>País</th>
                            <th>C.P.</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clientes as $cliente)
                            <tr>
                                <td>{{ $cliente->nombre }}</td>
                                <td>{{ $cliente->identificador }}</td>
                                <td>{{ $cliente->calle }}</td>
                                <td>{{ $cliente->numero }}</td>
                                <td>{{ $cliente->colonia }}</td>
                                <td>{{ $cliente->ciudad }}</td>
                                <td>{{ $cliente->estado }}</td>
                                <td>{{ $cliente->pais }}</td>
                                <td>{{ $cliente->cp }}</td>
                                <td class="text-nowrap">
                                    <a href="{{ route('admin.clientes.edit', $cliente->id) }}" class="btn btn-warning btn-sm mb-1">Editar</a>
                                    <form action="{{ route('admin.clientes.destroy', $cliente) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm mb-1" onclick="return confirm('¿Seguro que quieres eliminar este cliente?')">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">No hay clientes.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-center mt-3">
                    {{ $clientes->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

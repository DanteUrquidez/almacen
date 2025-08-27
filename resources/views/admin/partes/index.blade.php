@extends('layouts.stisla')

@section('title', 'Partes')

@section('content')
<div class="section">
    <div class="section-header">
        <h1>Partes</h1>
        <div class="section-header-button ml-auto">
            <a href="{{ route('admin.partes.create') }}" class="btn btn-primary">Nueva Parte</a>
        </div>
    </div>

    <div class="section-body">
        <form method="GET" action="{{ route('admin.partes.index') }}" class="form-inline mb-3">
            <div class="form-group mr-2">
                <input type="text" name="nombre" class="form-control" placeholder="Buscar por nombre" value="{{ request('nombre') }}">
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Cantidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($partes as $parte)
                        <tr>
                            <td>{{ $parte->nombre }}</td>
                            <td>{{ $parte->categoria->nombre ?? '-' }}</td>
                            <td 
                                @if($parte->cantidad >= $parte->maximo)
                                    style="background-color: #d4edda;" 
                                @elseif($parte->cantidad <= $parte->minimo)
                                    style="background-color: #f8d7da;" 
                                @endif
                            >
                                {{ $parte->cantidad }}
                            </td>
                            <td>
                                <form action="{{ route('admin.partes.entrada-rapida', $parte->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">+</button>
                                </form>

                                <form action="{{ route('admin.partes.salida-rapida', $parte->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">-</button>
                                </form>

                                <a href="{{ route('admin.partes.edit', $parte->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                <a href="{{ route('admin.partes.movimientos', $parte->id) }}" class="btn btn-info btn-sm">Movimientos</a>
                            </td>

                        </tr>
                        @endforeach

                        @if ($partes->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center">No se encontraron partes.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-3">
                    {{ $partes->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.stisla')

@section('title', 'Movimientos de Inventario')

@section('content')
<div class="section">
    <div class="section-header">
        <h1>Movimientos</h1>
        <div class="section-header-button ml-auto">
            <a href="{{ route('admin.movimientos.create') }}" class="btn btn-primary">Registrar Movimientos</a>
        </div>
    </div>

    <div class="section-body">
        <form method="GET" action="{{ route('admin.movimientos.index') }}" class="form-inline mb-3">
            <div class="form-group mr-2">
                <input type="text" name="parte" class="form-control" placeholder="Buscar por parte" value="{{ request('parte') }}">
            </div>
            <div class="form-group mr-2">
                <select name="tipo" class="form-control">
                    <option value="">Todos los tipos</option>
                    <option value="entrada" {{ request('tipo')=='entrada' ? 'selected' : '' }}>Entrada</option>
                    <option value="salida" {{ request('tipo')=='salida' ? 'selected' : '' }}>Salida</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </form>

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Parte</th>
                            <th>Tipo</th>
                            <th>Cantidad</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($movimientos as $movimiento)
                            <tr>
                                <td>{{ $movimiento->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $movimiento->parte->nombre ?? '-' }}</td>
                                <td>
                                    @if($movimiento->tipo == 'entrada')
                                        <span class="badge badge-success">Entrada</span>
                                    @else
                                        <span class="badge badge-danger">Salida</span>
                                    @endif
                                </td>
                                <td>{{ $movimiento->cantidad }}</td>
                                <td>{{ $movimiento->descripcion ?? '-' }}</td>
                            </tr>
                        @endforeach

                        @if ($movimientos->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center">No se encontraron movimientos.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <div class="d-flex justify-content-center mt-3">
                    {{ $movimientos->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

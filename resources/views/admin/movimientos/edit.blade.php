@extends('layouts.stisla')

@section('title', 'Editar Movimiento')

@section('content')
<div class="section">
    <div class="section-header">
        <h1>Editar Movimiento</h1>
        <div class="section-header-button ml-auto">
            <a href="{{ route('admin.movimientos.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.movimientos.update', $movimiento->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="parte_id">Parte</label>
                        <select name="parte_id" id="parte_id" class="form-control @error('parte_id') is-invalid @enderror">
                            <option value="">Seleccione una parte</option>
                            @foreach($partes as $parte)
                                <option value="{{ $parte->id }}" {{ old('parte_id', $movimiento->parte_id) == $parte->id ? 'selected' : '' }}>
                                    {{ $parte->nombre }} (Cantidad: {{ $parte->cantidad }})
                                </option>
                            @endforeach
                        </select>
                        @error('parte_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tipo">Tipo</label>
                        <select name="tipo" id="tipo" class="form-control @error('tipo') is-invalid @enderror">
                            <option value="entrada" {{ old('tipo', $movimiento->tipo) == 'entrada' ? 'selected' : '' }}>Entrada</option>
                            <option value="salida" {{ old('tipo', $movimiento->tipo) == 'salida' ? 'selected' : '' }}>Salida</option>
                        </select>
                        @error('tipo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <input type="number" name="cantidad" id="cantidad" class="form-control @error('cantidad') is-invalid @enderror" value="{{ old('cantidad', $movimiento->cantidad) }}" min="1">
                        @error('cantidad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción (opcional)</label>
                        <textarea name="descripcion" id="descripcion" class="form-control">{{ old('descripcion', $movimiento->descripcion) }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-warning">Actualizar Movimiento</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

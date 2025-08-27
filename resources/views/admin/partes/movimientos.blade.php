@extends('layouts.stisla')

@section('title', 'Movimientos de Parte')

@section('content')
<div class="section">
  <div class="section-header">
    <h1>Movimientos de: {{ $parte->nombre }}</h1>
  </div>

  <div class="section-body">

    <div class="card mb-4">
      <div class="card-body">
        <form method="POST" action="{{ route('admin.partes.registrar-movimiento', $parte->id) }}">
          @csrf
          <div class="form-row align-items-end">
            <div class="col-md-3 mb-2">
              <label>Tipo</label>
              <select name="tipo" class="form-control @error('tipo') is-invalid @enderror" required>
                <option value="">Seleccione</option>
                <option value="entrada">Entrada</option>
                <option value="salida">Salida</option>
              </select>
              @error('tipo') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-3 mb-2">
              <label>Cantidad</label>
              <input type="number" name="cantidad" class="form-control @error('cantidad') is-invalid @enderror" min="1" required>
              @error('cantidad') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4 mb-2">
              <label>Descripción</label>
              <input type="text" name="descripcion" class="form-control">
            </div>

            <div class="col-md-2 mb-2">
              <button type="submit" class="btn btn-primary btn-block">Registrar</button>
            </div>
          </div>
        </form>

        <a href="{{ route('admin.partes.index') }}" class="btn btn-secondary btn-sm mt-2">Volver al listado</a>
      </div>
    </div>

    <div class="card">
      <div class="card-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>#</th>
              <th>Tipo</th>
              <th>Cantidad</th>
              <th>Descripción</th>
              <th>Fecha</th>
            </tr>
          </thead>
          <tbody>
            @forelse($movimientos as $mov)
            <tr>
              <td>{{ $mov->id }}</td>
              <td>{{ ucfirst($mov->tipo) }}</td>
              <td>{{ $mov->cantidad }}</td>
              <td>{{ $mov->descripcion }}</td>
              <td>{{ $mov->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="text-center">No hay movimientos registrados</td>
            </tr>
            @endforelse
          </tbody>
        </table>

        <div class="d-flex justify-content-center mt-3">
          {{ $movimientos->links('pagination::bootstrap-4') }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@extends('layouts.stisla')

@section('title', 'Editar Parte')

@section('content')
<div class="section">
  <div class="section-header">
    <h1>Editar Parte</h1>
  </div>

  <div class="section-body">
    <div class="card">
      <div class="card-body">
        <form method="POST" action="{{ route('admin.partes.update', $parte->id) }}">
          @csrf
          @method('PUT')

          <div class="form-group">
            <label for="nombre">Nombre</label>
            <input name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                   value="{{ old('nombre', $parte->nombre) }}" required>
            @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $parte->descripcion) }}</textarea>
            @error('descripcion') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label for="id_categoria">Categoría</label>
            <select name="id_categoria" class="form-control @error('id_categoria') is-invalid @enderror" required>
              <option value="">Seleccione una categoría</option>
              @foreach($categorias as $id => $nombre)
                <option value="{{ $id }}" {{ old('id_categoria', $parte->id_categoria) == $id ? 'selected' : '' }}>
                  {{ $nombre }}
                </option>
              @endforeach
            </select>
            @error('id_categoria') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="cantidad">Cantidad</label>
                <input type="number" name="cantidad" class="form-control @error('cantidad') is-invalid @enderror"
                       value="{{ old('cantidad', $parte->cantidad) }}" min="0" required>
                @error('cantidad') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label for="minimo">Mínimo</label>
                <input type="number" name="minimo" class="form-control @error('minimo') is-invalid @enderror"
                       value="{{ old('minimo', $parte->minimo) }}" min="0">
                @error('minimo') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label for="maximo">Máximo</label>
                <input type="number" name="maximo" class="form-control @error('maximo') is-invalid @enderror"
                       value="{{ old('maximo', $parte->maximo) }}" min="0">
                @error('maximo') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>
          </div>

          <button type="submit" class="btn btn-primary">Actualizar</button>
          <a href="{{ route('admin.partes.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

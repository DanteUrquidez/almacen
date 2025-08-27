@extends('layouts.stisla')

@section('title', 'Editar Almacén')

@section('content')
<div class="section">
    <div class="section-header">
        <h1>Editar Almacén</h1>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.categorias.update', $categoria->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                                value="{{ old('nombre', $categoria->nombre) }}" required>
                        @error('nombre') 
                            <div class="invalid-feedback">{{ $message }}</div> 
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <input name="descripcion" class="form-control @error('descripcion') is-invalid @enderror"
                                value="{{ old('descripcion', $categoria->descripcion) }}" required>
                        @error('descripcion') 
                            <div class="invalid-feedback">{{ $message }}</div> 
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                    <a href="{{ route('admin.categorias.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

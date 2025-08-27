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
                <form method="POST" action="{{ route('admin.almacenes.update', $almacen) }}">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nombre">Nombre <span class="text-danger">*</span></label>
                                <input name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                                       value="{{ old('nombre', $almacen->nombre) }}" required>
                                @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="identificador">Identificador <span class="text-danger">*</span></label>
                                <input name="identificador" class="form-control @error('identificador') is-invalid @enderror"
                                       value="{{ old('identificador', $almacen->identificador) }}" required>
                                @error('identificador') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input name="telefono" class="form-control @error('telefono') is-invalid @enderror"
                                       value="{{ old('telefono', $almacen->telefono) }}">
                                @error('telefono') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="web">Sitio Web</label>
                                <input name="web" class="form-control @error('web') is-invalid @enderror"
                                       value="{{ old('web', $almacen->web) }}">
                                @error('web') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="calle">Calle</label>
                                <input name="calle" class="form-control @error('calle') is-invalid @enderror"
                                       value="{{ old('calle', $almacen->calle) }}">
                                @error('calle') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="numero">Número</label>
                                <input name="numero" class="form-control @error('numero') is-invalid @enderror"
                                       value="{{ old('numero', $almacen->numero) }}">
                                @error('numero') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="colonia">Colonia</label>
                                <input name="colonia" class="form-control @error('colonia') is-invalid @enderror"
                                       value="{{ old('colonia', $almacen->colonia) }}">
                                @error('colonia') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="ciudad">Ciudad</label>
                                <input name="ciudad" class="form-control @error('ciudad') is-invalid @enderror"
                                       value="{{ old('ciudad', $almacen->ciudad) }}">
                                @error('ciudad') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="estado">Estado</label>
                                <input name="estado" class="form-control @error('estado') is-invalid @enderror"
                                       value="{{ old('estado', $almacen->estado) }}">
                                @error('estado') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="pais">País</label>
                                <input name="pais" class="form-control @error('pais') is-invalid @enderror"
                                       value="{{ old('pais', $almacen->pais) }}">
                                @error('pais') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cp">Código Postal</label>
                                <input name="cp" class="form-control @error('cp') is-invalid @enderror"
                                       value="{{ old('cp', $almacen->cp) }}">
                                @error('cp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-4 d-flex align-items-end">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Actualizar</button>
                    <a href="{{ route('admin.almacenes.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

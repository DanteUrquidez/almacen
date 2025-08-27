@extends('layouts.stisla')

@section('title', 'Editar Cliente')

@section('content')
<div class="section">
    <div class="section-header">
        <h1>Editar Cliente</h1>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.clientes.update', $cliente) }}">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nombre">Nombre <span class="text-danger">*</span></label>
                                <input name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $cliente->nombre) }}" required>
                                @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="identificador">Identificador <span class="text-danger">*</span></label>
                                <input name="identificador" class="form-control @error('identificador') is-invalid @enderror" value="{{ old('identificador', $cliente->identificador) }}" required>
                                @error('identificador') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="calle">Calle</label>
                                <input name="calle" class="form-control @error('calle') is-invalid @enderror" value="{{ old('calle', $cliente->calle) }}">
                                @error('calle') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="numero">Número</label>
                                <input name="numero" class="form-control @error('numero') is-invalid @enderror" value="{{ old('numero', $cliente->numero) }}">
                                @error('numero') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="colonia">Colonia</label>
                                <input name="colonia" class="form-control @error('colonia') is-invalid @enderror" value="{{ old('colonia', $cliente->colonia) }}">
                                @error('colonia') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="ciudad">Ciudad</label>
                                <input name="ciudad" class="form-control @error('ciudad') is-invalid @enderror" value="{{ old('ciudad', $cliente->ciudad) }}">
                                @error('ciudad') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="estado">Estado</label>
                                <input name="estado" class="form-control @error('estado') is-invalid @enderror" value="{{ old('estado', $cliente->estado) }}">
                                @error('estado') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="pais">País</label>
                                <input name="pais" class="form-control @error('pais') is-invalid @enderror" value="{{ old('pais', $cliente->pais) }}">
                                @error('pais') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cp">Código Postal</label>
                                <input name="cp" class="form-control @error('cp') is-invalid @enderror" value="{{ old('cp', $cliente->cp) }}">
                                @error('cp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        <a href="{{ route('admin.clientes.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

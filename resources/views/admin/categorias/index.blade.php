@extends('layouts.stisla')

@section('title', 'Categorias')

@section('content')
<div class="section">
    <div class="section-header">
        <h1>Categorias</h1>
        <div class="section-header-button ml-auto">
            <a href="{{ route('admin.categorias.create') }}" class="btn btn-primary">Nueva Categoría</a>
        </div>
    </div>

    <div class="section-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-header">
                <h4>Lista de Categorias</h4>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categorias as $categoria)
                            <tr>
                                <td>{{ $categoria->nombre }}</td>
                                <td>{{ $categoria->descripcion }}</td>
                                <td>
                                    <a href="{{ route('admin.categorias.edit', $categoria->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No hay categorias registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                <div class="d-flex justify-content-center mt-3">
                    {{ $categorias->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
        </div>
    </div>
</div>
@endsection

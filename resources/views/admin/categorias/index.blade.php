@extends('layouts.stisla')

@section('title', 'Categorías')

@section('content')
<div class="section">
    <div class="section-header">
        <h1><i class="fas fa-tags"></i> Categorías</h1>
        <div class="ml-auto">
            <a href="{{ route('admin.categorias.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nueva Categoría
            </a>
        </div>
    </div>

    <div class="section-body">
        {{-- Alertas --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">×</button>
            </div>
        @endif

        {{-- Tabla de categorías --}}
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Lista de Categorías</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categorias as $categoria)
                                <tr>
                                    <td>{{ $categoria->nombre }}</td>
                                    <td>{{ $categoria->descripcion ?? '—' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.categorias.edit', $categoria->id) }}" 
                                           class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">
                                        <i class="fas fa-folder-open fa-2x mb-2"></i><br>
                                        No hay categorías registradas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Paginación --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $categorias->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection

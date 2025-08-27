@extends('layouts.stisla')

@section('title', 'Cajas')

@section('content')
<div class="section">
    <div class="section-header">
        <h1>Cajas</h1>
        <div class="section-header-button ml-auto">
            <a href="{{ route('admin.cajas.create') }}" class="btn btn-primary">Nueva Caja</a>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Caja No.</th>
                            <th>Items</th>
                            <th>Movimiento</th>
                            <th>Fecha creación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cajas as $caja)
                            <tr>
                                <td>{{ $caja->numero }}</td>
                                <td>
                                    <ul>
                                        @foreach($caja->items as $item)
                                            <li>
                                                {{ $item->parte->nombre ?? 'Sin Parte' }} -
                                                Item No.: {{ $item->item_no ?? '-' }},
                                                Pkg Size: {{ $item->pkg_size ?? '-' }},
                                                Pkg Weight: {{ $item->pkg_weight ?? '-' }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>{{ $caja->movimiento_id ?? '-' }}</td>
                                <td>{{ $caja->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.cajas.edit', $caja->id) }}" class="btn btn-warning btn-sm mb-1">Editar</a>
                                    <form action="{{ route('admin.cajas.destroy', $caja->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm mb-1" onclick="return confirm('¿Seguro que quieres eliminar esta caja?')">Eliminar</button>
                                    </form>
                                    <a href="{{ route('admin.cajas.pdf', $caja->id) }}" class="btn btn-success btn-sm mb-1" target="_blank">Generar PDF</a>

                                    <!-- Botón de previsualización -->
                                    <button type="button" 
                                            class="btn btn-info btn-sm mb-1" 
                                            data-toggle="modal" 
                                            data-target="#pdfModal{{ $caja->id }}">
                                        Previsualizar PDF
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="pdfModal{{ $caja->id }}" 
                                         tabindex="-1" 
                                         role="dialog" 
                                         aria-labelledby="pdfModalLabel{{ $caja->id }}" 
                                         aria-hidden="true"
                                         data-backdrop="false" 
                                         data-keyboard="true">
                                        <div class="modal-dialog modal-xl" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="pdfModalLabel{{ $caja->id }}">
                                                        Previsualización PDF Caja #{{ $caja->numero }}
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body" style="height:80vh;">
                                                    <iframe src="{{ route('admin.cajas.pdf', $caja->id) }}" 
                                                            frameborder="0" 
                                                            width="100%" 
                                                            height="100%"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No hay cajas registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-3">
                    {{ $cajas->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

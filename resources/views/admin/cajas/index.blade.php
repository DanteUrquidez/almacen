@extends('layouts.stisla')

@section('title', 'Cajas')

@section('content')
<div class="section">
    <div class="section-header">
        <h1>Cajas</h1>
        <div class="section-header-button ml-auto">
            <a href="{{ route('admin.cajas.create') }}" class="btn btn-primary">
                <i class="fas fa-box mr-1"></i> Nueva Caja
            </a>
        </div>
    </div>

    <div class="section-body">

        {{-- Mensaje de éxito --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Tarjetas de estadísticas --}}
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary"><i class="fas fa-box"></i></div>
                    <div class="card-wrap">
                        <div class="card-header"><h4>Total Cajas</h4></div>
                        <div class="card-body">{{ $cajas->total() }}</div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success"><i class="fas fa-cubes"></i></div>
                    <div class="card-wrap">
                        <div class="card-header"><h4>Total Items</h4></div>
                        <div class="card-body">{{ $cajas->sum(fn($c)=>$c->items->count()) }}</div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-info"><i class="fas fa-warehouse"></i></div>
                    <div class="card-wrap">
                        <div class="card-header"><h4>Movimientos</h4></div>
                        <div class="card-body">{{ $cajas->unique('movimiento_id')->count() }}</div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning"><i class="fas fa-calendar"></i></div>
                    <div class="card-wrap">
                        <div class="card-header"><h4>Última creación</h4></div>
                        <div class="card-body">
                            {{ optional($cajas->first())->created_at?->format('d/m/Y') ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabla de cajas --}}
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-list mr-2"></i>Listado de Cajas</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Caja No.</th>
                                <th>Items</th>
                                <th>Movimiento</th>
                                <th>Fecha creación</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cajas as $caja)
                                <tr>
                                    <td><strong>#{{ $caja->numero }}</strong></td>
                                    <td>
                                        <ul class="pl-3 mb-0">
                                            @foreach($caja->items as $item)
                                                <li>
                                                    <span class="badge badge-info">{{ $item->parte->nombre ?? 'Sin Parte' }}</span>
                                                    — Item No.: {{ $item->item_no ?? '-' }},
                                                    Size: {{ $item->pkg_size ?? '-' }},
                                                    Wt: {{ $item->pkg_weight ?? '-' }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>{{ $caja->movimiento_id ?? '-' }}</td>
                                    <td>{{ $caja->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.cajas.edit', $caja->id) }}" 
                                           class="btn btn-warning btn-sm mb-1">
                                           <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.cajas.destroy', $caja->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm mb-1"
                                                onclick="return confirm('¿Seguro que quieres eliminar esta caja?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        <a href="{{ route('admin.cajas.pdf', $caja->id) }}" 
                                           class="btn btn-success btn-sm mb-1" target="_blank">
                                           <i class="fas fa-file-pdf"></i>
                                        </a>
                                        <button type="button" 
                                            class="btn btn-info btn-sm mb-1" 
                                            data-toggle="modal" 
                                            data-target="#pdfModal{{ $caja->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>

                                {{-- Modal PDF --}}
                                <div class="modal fade" id="pdfModal{{ $caja->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Previsualización Caja #{{ $caja->numero }}</h5>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body" style="height:80vh;">
                                                <iframe src="{{ route('admin.cajas.pdf', $caja->id) }}" 
                                                        frameborder="0" width="100%" height="100%"></iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No hay cajas registradas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $cajas->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.stisla')

@section('title', 'Nuevo Almacén')

@section('content')
<div class="section">
    <div class="section-header">
        <h1 class="text-2xl font-bold text-slate-900">Nuevo Almacén</h1>
        <div class="section-header-breadcrumb">
            <a href="{{ route('admin.almacenes.index') }}" class="btn btn-light">
                <i class="fas fa-arrow-left mr-2"></i> Volver al Listado
            </a>
        </div>
    </div>

    <div class="section-body">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="font-semibold text-lg text-slate-800">
                    <i class="fas fa-warehouse mr-2 text-blue-600"></i>
                    Registro de Almacenes
                </h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.almacenes.storeMultiple') }}">
                    @csrf

                    <div id="almacenes-container">
                        <div class="almacen-item border rounded-lg p-4 mb-4 bg-light">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="font-semibold">Nombre <span class="text-danger">*</span></label>
                                        <input name="almacenes[0][nombre]" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="font-semibold">Identificador <span class="text-danger">*</span></label>
                                        <input name="almacenes[0][identificador]" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="font-semibold">Calle</label>
                                        <input name="almacenes[0][calle]" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="font-semibold">Número</label>
                                        <input name="almacenes[0][numero]" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="font-semibold">Colonia</label>
                                        <input name="almacenes[0][colonia]" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="font-semibold">Ciudad</label>
                                        <input name="almacenes[0][ciudad]" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="font-semibold">Estado</label>
                                        <input name="almacenes[0][estado]" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="font-semibold">País</label>
                                        <input name="almacenes[0][pais]" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="font-semibold">Código Postal</label>
                                        <input name="almacenes[0][cp]" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="font-semibold">Teléfono</label>
                                        <input name="almacenes[0][telefono]" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="font-semibold">Web</label>
                                        <input name="almacenes[0][web]" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="text-right">
                                <button type="button" class="btn btn-danger btn-sm remove-almacen d-none">
                                    <i class="fas fa-trash mr-1"></i> Eliminar
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-success" id="add-almacen">
                            <i class="fas fa-plus mr-2"></i> Agregar otro almacén
                        </button>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-2"></i> Guardar Todos
                            </button>
                            <a href="{{ route('admin.almacenes.index') }}" class="btn btn-secondary">
                                Cancelar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let index = 1;

    document.getElementById("add-almacen").addEventListener("click", function () {
        let container = document.getElementById("almacenes-container");
        let firstItem = container.firstElementChild;
        let newItem = firstItem.cloneNode(true);

        newItem.querySelectorAll("input, textarea").forEach(function (input) {
            let oldName = input.getAttribute("name");
            let newName = oldName.replace(/\[\d+\]/, "[" + index + "]");
            input.setAttribute("name", newName);
            input.value = "";
        });

        newItem.querySelector(".remove-almacen").classList.remove("d-none");

        container.appendChild(newItem);
        index++;
    });

    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("remove-almacen")) {
            e.target.closest(".almacen-item").remove();
        }
    });
});
</script>
@endsection

@extends('layouts.stisla')

@section('title', 'Nuevo Almacén')

@section('content')
<div class="section">
    <div class="section-header">
        <h1>Nuevo Almacén</h1>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.almacenes.storeMultiple') }}">
                    @csrf

                    <div id="almacenes-container">
                        <div class="almacen-item border rounded p-3 mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Nombre <span class="text-danger">*</span></label>
                                        <input name="almacenes[0][nombre]" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Identificador <span class="text-danger">*</span></label>
                                        <input name="almacenes[0][identificador]" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Calle</label>
                                        <input name="almacenes[0][calle]" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Número</label>
                                        <input name="almacenes[0][numero]" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Colonia</label>
                                        <input name="almacenes[0][colonia]" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Ciudad</label>
                                        <input name="almacenes[0][ciudad]" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Estado</label>
                                        <input name="almacenes[0][estado]" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>País</label>
                                        <input name="almacenes[0][pais]" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Código Postal</label>
                                        <input name="almacenes[0][cp]" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Teléfono</label>
                                        <input name="almacenes[0][telefono]" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Web</label>
                                        <input name="almacenes[0][web]" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger btn-sm remove-almacen d-none w-100">Eliminar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-success mb-3" id="add-almacen">+ Agregar otro almacén</button>
                    <hr>
                    <button type="submit" class="btn btn-primary">Guardar Todos</button>
                    <a href="{{ route('admin.almacenes.index') }}" class="btn btn-secondary">Cancelar</a>
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

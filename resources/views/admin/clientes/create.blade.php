@extends('layouts.stisla')

@section('title', 'Nuevo Cliente')

@section('content')
<div class="section">
    <div class="section-header">
        <h1>Nuevo Cliente</h1>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.clientes.storeMultiple') }}">
                    @csrf

                    <div id="clientes-container">
                        <div class="cliente-item border rounded p-3 mb-3">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Nombre <span class="text-danger">*</span></label>
                                    <input name="clientes[0][nombre]" class="form-control" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Identificador <span class="text-danger">*</span></label>
                                    <input name="clientes[0][identificador]" class="form-control" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Calle</label>
                                    <input name="clientes[0][calle]" class="form-control">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Número</label>
                                    <input name="clientes[0][numero]" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Colonia</label>
                                    <input name="clientes[0][colonia]" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Ciudad</label>
                                    <input name="clientes[0][ciudad]" class="form-control">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Estado</label>
                                    <input name="clientes[0][estado]" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>País</label>
                                    <input name="clientes[0][pais]" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Código Postal</label>
                                    <input name="clientes[0][cp]" class="form-control">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-12 d-flex justify-content-end">
                                    <button type="button" class="btn btn-danger btn-sm remove-cliente d-none">Eliminar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <button type="button" class="btn btn-success" id="add-cliente">+ Agregar otro cliente</button>
                    </div>

                    <hr>

                    <button type="submit" class="btn btn-primary">Guardar Todos</button>
                    <a href="{{ route('admin.clientes.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let index = 1;

    document.getElementById("add-cliente").addEventListener("click", function () {
        let container = document.getElementById("clientes-container");
        let firstCliente = container.firstElementChild;
        let newCliente = firstCliente.cloneNode(true);

        newCliente.querySelectorAll("input, textarea").forEach(function (input) {
            let oldName = input.getAttribute("name");
            let newName = oldName.replace(/\[\d+\]/, "[" + index + "]");
            input.setAttribute("name", newName);
            input.value = "";
        });

        newCliente.querySelector(".remove-cliente").classList.remove("d-none");

        container.appendChild(newCliente);
        index++;
    });

    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("remove-cliente")) {
            e.target.closest(".cliente-item").remove();
        }
    });
});
</script>
@endsection

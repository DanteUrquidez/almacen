@extends('layouts.stisla')

@section('title', 'Nueva Parte')

@section('content')
<div class="section">
  <div class="section-header">
    <h1>Nueva Parte</h1>
  </div>

  <div class="section-body">
    <div class="card">
      <div class="card-body">
        <form method="POST" action="{{ route('admin.partes.storeMultiple') }}">
          @csrf

          <div id="partes-container">
            <div class="parte-item border rounded p-3 mb-3">
              <div class="form-group">
                <label>Nombre</label>
                <input name="partes[0][nombre]" class="form-control" required>
              </div>

              <div class="form-group">
                <label>Descripción</label>
                <textarea name="partes[0][descripcion]" class="form-control"></textarea>
              </div>

              <div class="form-group">
                <label>Categoría</label>
                <select name="partes[0][id_categoria]" class="form-control" required>
                  <option value="">Seleccione una categoría</option>
                  @foreach ($categorias as $id => $nombre)
                    <option value="{{ $id }}">{{ $nombre }}</option>
                  @endforeach
                </select>
              </div>

              <div class="row">
                <div class="form-group col-md-4">
                  <label>Cantidad</label>
                  <input type="number" name="partes[0][cantidad]" class="form-control" value="0" min="0" required>
                </div>
                <div class="form-group col-md-4">
                  <label>Mínimo</label>
                  <input type="number" name="partes[0][minimo]" class="form-control" value="0" min="0">
                </div>
                <div class="form-group col-md-4">
                  <label>Máximo</label>
                  <input type="number" name="partes[0][maximo]" class="form-control" value="0" min="0">
                </div>
              </div>

              <button type="button" class="btn btn-danger btn-sm remove-parte d-none">Eliminar</button>
            </div>
          </div>

          <button type="button" class="btn btn-success" id="add-parte">+ Agregar otra parte</button>
          <hr>
          <button type="submit" class="btn btn-primary">Guardar Todo</button>
          <a href="{{ route('admin.partes.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
  let index = 1;

  document.getElementById("add-parte").addEventListener("click", function () {
    let container = document.getElementById("partes-container");
    let firstParte = container.firstElementChild;
    let newParte = firstParte.cloneNode(true);

    newParte.querySelectorAll("input, textarea, select").forEach(function (input) {
      let oldName = input.getAttribute("name");
      let newName = oldName.replace(/\[\d+\]/, "[" + index + "]");
      input.setAttribute("name", newName);
      input.value = ""; 
    });

    newParte.querySelector(".remove-parte").classList.remove("d-none");

    container.appendChild(newParte);
    index++;
  });


  document.addEventListener("click", function (e) {
    if (e.target.classList.contains("remove-parte")) {
      e.target.closest(".parte-item").remove();
    }
  });
});
</script>
@endsection

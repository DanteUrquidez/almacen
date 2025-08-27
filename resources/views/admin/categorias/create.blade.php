@extends('layouts.stisla')

@section('title', 'Nueva Categoría')

@section('content')
<div class="section">
  <div class="section-header">
    <h1>Nueva Categoría</h1>
  </div>

  <div class="section-body">
    <div class="card">
      <div class="card-body">
        <form method="POST" action="{{ route('admin.categorias.storeMultiple') }}">
          @csrf

          <div id="categorias-container">
            <div class="categoria-item border rounded p-3 mb-3">
              <div class="form-group">
                <label>Nombre</label>
                <input name="categorias[0][nombre]" class="form-control" required>
              </div>

              <div class="form-group">
                <label>Descripción</label>
                <textarea name="categorias[0][descripcion]" class="form-control"></textarea>
              </div>

              <button type="button" class="btn btn-danger btn-sm remove-categoria d-none">Eliminar</button>
            </div>
          </div>

          <button type="button" class="btn btn-success" id="add-categoria">+ Agregar otra categoría</button>
          <hr>
          <button type="submit" class="btn btn-primary">Guardar Todo</button>
          <a href="{{ route('admin.categorias.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
  let index = 1;

  document.getElementById("add-categoria").addEventListener("click", function () {
    let container = document.getElementById("categorias-container");
    let firstCategoria = container.firstElementChild;
    let newCategoria = firstCategoria.cloneNode(true);

    newCategoria.querySelectorAll("input, textarea").forEach(function (input) {
      let oldName = input.getAttribute("name");
      let newName = oldName.replace(/\[\d+\]/, "[" + index + "]");
      input.setAttribute("name", newName);
      input.value = "";
    });

    newCategoria.querySelector(".remove-categoria").classList.remove("d-none");

    container.appendChild(newCategoria);
    index++;
  });

  document.addEventListener("click", function (e) {
    if (e.target.classList.contains("remove-categoria")) {
      e.target.closest(".categoria-item").remove();
    }
  });
});
</script>
@endsection

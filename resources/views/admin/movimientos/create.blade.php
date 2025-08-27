@extends('layouts.stisla')

@section('title', 'Movimientos Masivos / Packing List')

@section('content')
<div class="section">
    <div class="section-header">
        <h1>Registrar Movimientos Masivos</h1>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.movimientos.storeMultiplePacking') }}">
                    @csrf

                    <div class="mb-4">
                        <h5>Información del envío</h5>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Buyer</label>
                                <input type="text" name="buyer" class="form-control" value="{{ old('buyer') }}" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Shipping Date</label>
                                <input type="date" name="shipping_date" class="form-control" value="{{ old('shipping_date') }}" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Purchase Order No.</label>
                                <input type="text" name="purchase_order" class="form-control" value="{{ old('purchase_order') }}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Shipped From (Almacén)</label>
                                <select name="serial" id="serial" class="form-control" required>
                                    <option value="">Selecciona un almacén</option>
                                    @foreach($almacenes as $almacen)
                                        <option value="{{ $almacen->id }}"
                                            data-direccion="{{ $almacen->calle }}, {{ $almacen->numero }}, {{ $almacen->colonia }}, {{ $almacen->ciudad }}, {{ $almacen->estado }}, {{ $almacen->pais }}, C.P. {{ $almacen->cp }}">
                                            {{ $almacen->nombre }} ({{ $almacen->identificador ?? '' }})
                                        </option>
                                    @endforeach
                                </select>
                                <textarea name="shipped_from" id="shipped_from" class="form-control mt-2" rows="3" readonly>{{ old('shipped_from') }}</textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Sold To (Cliente)</label>
                                <select name="cliente_id" id="cliente_id" class="form-control" required>
                                    <option value="">Selecciona un cliente</option>
                                    @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->id }}"
                                            data-direccion="{{ $cliente->calle }}, {{ $cliente->numero }}, {{ $cliente->colonia }}, {{ $cliente->ciudad }}, {{ $cliente->estado }}, {{ $cliente->pais }}, C.P. {{ $cliente->cp }}">
                                            {{ $cliente->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                <textarea name="sold_to" id="sold_to" class="form-control mt-2" rows="3" readonly>{{ old('sold_to') }}</textarea>

                                <label class="mt-3">Shipped To (Dirección de envío)</label>
                                <textarea name="shipped_to" id="shipped_to" class="form-control" rows="3">{{ old('shipped_to') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div id="cajas-container">
                        <div class="caja-item border rounded p-3 mb-3">
                            <h6 class="mb-3">Caja <span class="caja-numero">1</span></h6>
                            <div class="items-container">
                                <div class="row mb-2 item-row">
                                    <div class="col-md-4">
                                        <label>Item No.</label>
                                        <input type="text" name="cajas[0][items][0][item_no]" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Pkg Size</label>
                                        <input type="text" name="cajas[0][items][0][pkg_size]" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Pkg Gross Weight</label>
                                        <input type="text" name="cajas[0][items][0][pkg_weight]" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3 item-row">
                                    <div class="col-md-4">
                                        <label>Part No.</label>
                                        <select name="cajas[0][items][0][parte_id]" class="form-control parte-select">
                                            @foreach($partes as $parte)
                                                <option value="{{ $parte->id }}">{{ $parte->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Description</label>
                                        <input type="text" class="form-control description-field" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Pkg No.</label>
                                        <input type="text" class="form-control pkg-no" readonly value="1">
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success btn-sm add-item">+ Agregar parte</button>
                            <button type="button" class="btn btn-danger btn-sm remove-caja float-right d-none">Eliminar Caja</button>
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary mb-3" id="add-caja">+ Agregar otra caja</button>
                    <hr>
                    <button type="submit" class="btn btn-success">Generar PDF / Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Autocompletar direcciones
    const serialSelect = document.getElementById('serial');
    const clienteSelect = document.getElementById('cliente_id');

    function actualizarShippedFrom() {
        const selected = serialSelect.options[serialSelect.selectedIndex];
        document.getElementById('shipped_from').value = selected.dataset.direccion || '';
    }

    function actualizarSoldTo() {
        const selected = clienteSelect.options[clienteSelect.selectedIndex];
        document.getElementById('sold_to').value = selected.dataset.direccion || '';
    }

    serialSelect.addEventListener('change', actualizarShippedFrom);
    clienteSelect.addEventListener('change', actualizarSoldTo);

    actualizarShippedFrom();
    actualizarSoldTo();

    // Scripts para cajas y partes
    let cajaIndex = 1;

    function actualizarDescripcionYPkg(cajaDiv) {
        cajaDiv.querySelectorAll('.parte-select').forEach(select => {
            const descInput = select.closest('.row').querySelector('.description-field');
            descInput.value = select.options[select.selectedIndex].text;
        });
        cajaDiv.querySelectorAll('.pkg-no').forEach(input => input.value = cajaDiv.querySelector('.caja-numero').textContent);
    }

    document.getElementById('add-caja').addEventListener('click', function () {
        const container = document.getElementById('cajas-container');
        const firstCaja = container.firstElementChild;
        const newCaja = firstCaja.cloneNode(true);

        newCaja.querySelectorAll('input').forEach(input => input.value = '');
        newCaja.querySelectorAll('select').forEach(select => select.selectedIndex = 0);

        newCaja.querySelector('.caja-numero').textContent = cajaIndex + 1;
        newCaja.querySelector('.remove-caja').classList.remove('d-none');

        newCaja.querySelectorAll('input, select').forEach(el => {
            let name = el.getAttribute('name');
            name = name.replace(/\[\d+\]/, `[${cajaIndex}]`);
            el.setAttribute('name', name);
        });

        container.appendChild(newCaja);
        cajaIndex++;
        actualizarDescripcionYPkg(newCaja);
    });

    document.addEventListener('click', function(e) {
        if(e.target.classList.contains('add-item')) {
            const cajaDiv = e.target.closest('.caja-item');
            const itemsContainer = cajaDiv.querySelector('.items-container');
            const firstItem = itemsContainer.querySelectorAll('.item-row')[0];
            const newItem = firstItem.cloneNode(true);

            newItem.querySelectorAll('input').forEach(input => input.value = '');
            newItem.querySelectorAll('select').forEach(select => select.selectedIndex = 0);

            const cajaNum = Array.from(document.querySelectorAll('.caja-item')).indexOf(cajaDiv);
            const itemIndex = itemsContainer.querySelectorAll('.item-row').length;

            newItem.querySelectorAll('input, select').forEach(el => {
                let name = el.getAttribute('name');
                name = name.replace(/\[\d+\]\[items\]\[\d+\]/, `[${cajaNum}][items][${itemIndex}]`);
                el.setAttribute('name', name);
            });

            itemsContainer.appendChild(newItem);
            actualizarDescripcionYPkg(cajaDiv);
        }

        if(e.target.classList.contains('remove-caja')) {
            e.target.closest('.caja-item').remove();
        }
    });

    document.addEventListener('change', function(e) {
        if(e.target.classList.contains('parte-select')) {
            const select = e.target;
            const descInput = select.closest('.row').querySelector('.description-field');
            descInput.value = select.options[select.selectedIndex].text;
        }
    });
});
</script>
@endsection

@extends('layout.admin')

@section('content')

<h3 class="mt-3">Editar Categoria</h3>
<br>

@if($errors->any())
<div class="alert alert-warning" role="alert">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


<div class="container">

    <h2 class="mb-3">Editar Compra: {{ $compra->folio }}</h2>

    <a href="{{ route('compras.index') }}" class="btn btn-secondary mb-3">Volver</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Error:</strong> Revisa los campos obligatorios.
        </div>
    @endif

    <form action="{{ route('compras.update', $compra->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Datos generales --}}
        <div class="card mb-3">
            <div class="card-header">Datos de la Compra</div>
            <div class="card-body">

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Folio</label>
                        <input type="text" name="folio" class="form-control" value="{{ $compra->folio }}" required>
                    </div>

                    <div class="col-md-4">
                        <label>Fecha</label>
                        <input type="date" name="fecha" class="form-control" value="{{ $compra->fecha }}" required>
                    </div>

                    <div class="col-md-4">
                        <label>Bodega</label>
                        <select name="bodega" class="form-control" required>
                            <option value="talca" {{ $compra->bodega=='talca'?'selected':'' }}>Talca</option>
                            <option value="chillan" {{ $compra->bodega=='chillan'?'selected':'' }}>Chillán</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Cliente</label>
                    <select name="cliente_id" class="form-control" required>
                        @foreach ($clientes as $cli)
                            <option value="{{ $cli->id }}"
                                {{ $compra->cliente_id == $cli->id ? 'selected':'' }}>
                                {{ $cli->name }} - ({{ $cli->company ?? 'Sin empresa' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Factura</label>
                    <input type="text" name="factura" class="form-control"
                           value="{{ $compra->factura }}">
                </div>

                <div class="mb-3">
                    <label>Declaración</label>
                    <textarea name="declaracion" class="form-control">{{ $compra->declaracion }}</textarea>
                </div>

            </div>
        </div>

        {{-- Items --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <span>Ítems de la Compra</span>
                <button type="button" class="btn btn-success btn-sm" id="agregarFila">Agregar Ítem</button>
            </div>

            <div class="card-body p-0">
                <table class="table table-bordered mb-0" id="tablaItems">
                    <thead>
                        <tr>
                            <th>Material</th>
                            <th>Producto (opcional)</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($compra->items as $item)
                            <tr>
                                <td>
                                    <select name="material[]" class="form-control" required>
                                        <option value="">-- Seleccionar Material --</option>
                                        @foreach($productos as $prod)
                                            <option value="{{ $prod->material }}"
                                                {{ $item->material == $prod->material ? 'selected':'' }}>
                                                {{ $prod->material }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td>
                                    <select name="producto_id[]" class="form-control">
                                        <option value="">-- Sin Producto --</option>
                                        @foreach($productos as $prod)
                                            <option value="{{ $prod->id }}"
                                                {{ $item->producto_id == $prod->id ? 'selected':'' }}>
                                                {{ $prod->material }} ({{ $prod->unidad }})
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td>
                                    <input type="number" step="0.01" name="cantidad[]"
                                           class="form-control"
                                           value="{{ $item->cantidad }}" required>
                                </td>

                                <td>
                                    <input type="number" step="0.01" name="precio[]"
                                           class="form-control"
                                           value="{{ $item->precio }}" required>
                                </td>

                                <td class="text-center">
                                    <button type="button" class="btn btn-danger btn-sm eliminarFila">X</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>

        <button class="btn btn-primary mt-3">Guardar Cambios</button>

    </form>
</div>

{{-- Script para agregar/eliminar filas --}}
<script>
const productosData = {!! json_encode($productos) !!};

document.getElementById('agregarFila').addEventListener('click', function () {
    let tabla = document.querySelector('#tablaItems tbody');
    
    let materialesOptions = '<option value="">-- Seleccionar Material --</option>';
    let productosOptions = '<option value="">-- Sin Producto --</option>';
    productosData.forEach(prod => {
        materialesOptions += `<option value="${prod.material}">${prod.material}</option>`;
        productosOptions += `<option value="${prod.id}">${prod.material} (${prod.unidad})</option>`;
    });
    
    let fila = `
        <tr>
            <td>
                <select name="material[]" class="form-control" required>
                    ${materialesOptions}
                </select>
            </td>

            <td>
                <select name="producto_id[]" class="form-control">
                    ${productosOptions}
                </select>
            </td>

            <td><input type="number" step="0.01" name="cantidad[]" class="form-control" required></td>
            <td><input type="number" step="0.01" name="precio[]" class="form-control" required></td>

            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm eliminarFila">X</button>
            </td>
        </tr>
    `;
    tabla.insertAdjacentHTML('beforeend', fila);
});

document.addEventListener('click', function(e){
    if (e.target.classList.contains('eliminarFila')) {
        e.target.closest('tr').remove();
    }
});
</script>






@endsection
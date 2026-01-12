@extends('layout.admin')

@section('content')

<div>
    <br>
    <h2 class="alert-heading">
        <i class="fa-solid fa-cart-arrow-down"></i> Nueva Compra
    </h2>
    <br>
</div>


@if($errors->any())
<div class="alert alert-warning" role="alert">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="row">
    <div class="col-1"></div>
    <div class="col-9">
        <form action="{{ route('compras.store') }}" method="POST">
            @csrf

            <div class="row mb-3">

                <div class="col">
                    <label class="form-label">Folio</label>
                    <input type="text" name="folio" class="form-control" required>
                </div>

                <div class="col">
                    <label class="form-label">Fecha</label>
                    <input type="date" name="fecha" class="form-control" required>
                </div>

                <div class="col">
                    <label class="form-label">Bodega</label>
                    <select name="bodega" class="form-control">
                        <option value="talca">Talca</option>
                        <option value="chillan">Chillán</option>
                    </select>
                </div>
            </div>


            <div class="row mb-3">
                <div class="col-9">
                    <label class="form-label">Cliente</label>
                    <select name="client_id" class="form-control" required>
                        <option value="">-- Seleccionar --</option>
                        @foreach($clientes as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-3">
                    <label class="form-label">Factura</label>
                    <input type="text" name="factura" class="form-control">
                </div>
            </div>


            <!--<h4>Materiales / Ítems</h4>-->

            <table class="table" id="tabla-items">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>
                            <select name="producto_id[]" class="form-control producto-select">
                                <option value="">-- Seleccione --</option>
                                @foreach($productos as $p)
                                <option value="{{ $p->id }}">{{ $p->material }}</option>
                                @endforeach
                            </select>
                        </td>

                        <td><input type="number" step="0.01" name="cantidad[]" class="form-control cantidad"></td>
                        <td><input type="number" step="0.01" name="precio[]" class="form-control precio"></td>
                        <td><input type="text" readonly class="form-control subtotal"></td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm eliminar-item">Eliminar</button>
                        </td>
                    </tr>

                    <!-- Aqui se agregan nuevos items -->
                </tbody>

            </table>

            <button type="button" class="btn btn-success btn-sm" id="agregar-item">Agregar Material</button>


            <br><br>

            <div class="mb-3">
                <label>Declaración</label>
                <textarea name="declaracion" class="form-control"></textarea>
            </div>
            <a class="btn btn-secondary" href="{{ route('compras.index') }}">Regresar</a>
            <button type="submit" class="btn btn-primary">Guardar Compra</button>

        </form>

    </div>

    <script>
        document.getElementById('agregar-item').addEventListener('click', function() {

            let row = `
        <tr>
            <td>
                <select name="producto_id[]" class="form-control producto-select">
                    <option value="">-- Seleccione --</option>
                    @foreach($productos as $p)
                        <option value="{{ $p->id }}">{{ $p->material }}</option>
                    @endforeach
                </select>
            </td>

            <td><input type="number" step="0.01" name="cantidad[]" class="form-control cantidad"></td>
            <td><input type="number" step="0.01" name="precio[]" class="form-control precio"></td>
            <td><input type="text" readonly class="form-control subtotal"></td>
            <td>
                <button type="button" class="btn btn-danger btn-sm eliminar-item">Eliminar</button>
            </td>
        </tr>
    `;

            document.querySelector('#tabla-items tbody').insertAdjacentHTML('beforeend', row);
        });


        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('cantidad') || e.target.classList.contains('precio')) {
                let row = e.target.closest('tr');
                let cantidad = row.querySelector('.cantidad').value;
                let precio = row.querySelector('.precio').value;
                let subtotal = (cantidad * precio).toFixed(2);
                row.querySelector('.subtotal').value = subtotal;
            }
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('eliminar-item')) {
                e.target.closest('tr').remove();
            }
        });
    </script>


</div>



@endsection
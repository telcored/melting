@extends('layout.admin')

@section('content')

<div>
    <br>
    <h2 class="alert-heading">
      <i class="fa-solid fa-box"></i> Nuevo Producto
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
        <form class="row g-3 mb-4" action="{{ route('productos.store') }}" method="post" autocomplete="off">
            @csrf

            <div class="col-md-9">
                <label class="form-label">Material:</label>
                <input class="form-control" type="text" name="material" required>
            </div>

            <div class="col-md-3">
                <label class="form-label">Cantidad:</label>
                <input class="form-control" type="number" step="0.01" name="cantidad" required>
            </div>


            <div class="col-md-6">
                <label class="form-label">Estado:</label>
                <select class="form-select" name="estado">
                    <option value="nuevo">Nuevo</option>
                    <option value="usado" selected>Usado</option>
                    <option value="quemado">Quemado</option>
                    <option value="otro">Otro</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Unidad:</label>
                <input class="form-control" type="text" name="unidad" value="kg" required>
            </div>



            <div class="col-md-6">
                <label class="form-label">Precio:</label>
                <input class="form-control" type="number" step="0.01" name="precio" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Categoría:</label>
                <select class="form-select" name="categoria_id">
                    <option value="">-- Sin categoría --</option>
                    @foreach($categorias as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <label class="form-label">Descripción:</label>

                <textarea class="form-control" name="descripcion"></textarea>
            </div>


            <button class="btn btn-primary" type="submit">Guardar</button>



        </form>

    </div>
</div>






@endsection
@extends('layout.admin')

@section('content')

<h3 class="mt-3">Editar Producto</h3>
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



<div class="row">
    <div class="col-6">
        <form class="row g-3" action="{{ route('productos.update', $producto->id) }}" method="post" autocomplete="off">
            @csrf
            @method('PUT')



            <div class="col-md-6">
                <label class="form-label">Material</label>
                <input type="text" name="material" class="form-control" value="{{ $producto->material }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Cantidad</label>
                <input type="number" step="0.01" name="cantidad" class="form-control" value="{{ $producto->cantidad }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Unidad</label>
                <input type="text" name="unidad" class="form-control" value="{{ $producto->unidad }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Bodega</label>
                <select name="bodega" class="form-control" required>
                    <option value="talca" {{ $producto->bodega == 'talca' ? 'selected' : '' }}>Talca</option>
                    <option value="chillan" {{ $producto->bodega == 'chillan' ? 'selected' : '' }}>Chillán</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Estado</label>
                <select name="estado" class="form-control">
                    <option value="nuevo" {{ $producto->estado == 'nuevo' ? 'selected' : '' }}>Nuevo</option>
                    <option value="usado" {{ $producto->estado == 'usado' ? 'selected' : '' }}>Usado</option>
                    <option value="quemado" {{ $producto->estado == 'quemado' ? 'selected' : '' }}>Quemado</option>
                    <option value="otro" {{ $producto->estado == 'otro' ? 'selected' : '' }}>Otro</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Precio</label>
                <input type="number" step="0.01" name="precio" class="form-control" value="{{ $producto->precio }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Categoría</label>
                <select name="categoria_id" class="form-control">
                    <option value="">-- Sin categoría --</option>
                    @foreach ($categorias as $cat)
                    <option value="{{ $cat->id }}" {{ $producto->categoria_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->nombre }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control">{{ $producto->descripcion }}</textarea>
            </div>

              <div class="col-12">
                <br>
                <a class="btn btn-secondary" href="{{ route('productos.index') }}">Regresar</a>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
</div>



@endsection
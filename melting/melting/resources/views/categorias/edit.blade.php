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




<div class="row">
    <div class="col-6">
        <form class="row g-3" action="{{ route('categorias.update', $categoria->id) }}" method="post" autocomplete="off">
            @csrf
            @method('PUT')

            <div class="col-md-6">
                <label class="form-label" for="nombre">Nombre</label>
                <input class="form-control" type="text" name="nombre" id="nombre" value="{{ $categoria->nombre }}" required>
            </div>


            <div class="col-md-9">
                <label class="form-label" for="descripcion">Descripcion</label>
                <input class="form-control" type="text" name="descripcion" id="descripcion" value="{{ $categoria->descripcion }}">
            </div>

        

            <div class="col-12">
                <br>
                <a class="btn btn-secondary" href="{{ route('categorias.index') }}">Regresar</a>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>

        </form>
    </div>
</div>









@endsection

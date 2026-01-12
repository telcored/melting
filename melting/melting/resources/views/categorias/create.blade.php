@extends('layout.admin')

@section('content')

<div>
    <br>
    <h2 class="alert-heading">
     <i class="fa-solid fa-tag"></i> Nueva Categoria
    </h2>
    <br>
</div>


<div class="row">
    <div class="col-6">
        <form class="row g-3" action="{{ route('categorias.store') }}" method="post" autocomplete="off">
            @csrf
            <div class="col-md-6">
                <label class="form-label" for="nombre">Nombre</label>
                <input class="form-control" type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required>
            </div>

    

            <div class="col-md-9">
                <label class="form-label" for="descripcion">Descripcion</label>
                <input class="form-control" type="text" name="descripcion" id="descripcion" value="{{ old('descripcion') }}">
            </div>

        
            <div class="col-12">
                <a class="btn btn-secondary" href="{{ route('categorias.index') }}">Regresar</a>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>

        </form>

     
    </div>
</div>



@endsection
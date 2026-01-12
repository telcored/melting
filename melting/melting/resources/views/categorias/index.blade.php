@extends('layout.admin')

@section('content')

<div>
    <br>
    <h2 class="alert-heading">
      <i class="fa-solid fa-tags"></i> Categorías
    </h2>
    <br>
</div>


<br>
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif


<a class="btn btn-primary" href="{{ route('categorias.create') }}">Nueva Categoría</a>

<br>
<br>
<table class="table">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Acciones</th>
    </tr>

    @foreach($categorias as $categoria)
    <tr>
        <td>{{ $categoria->id }}</td>
        <td>{{ $categoria->nombre }}</td>
        <td>{{ $categoria->descripcion }}</td>
        <td>
            <a class="btn btn-warning" href="{{ route('categorias.edit', $categoria->id) }}">Editar</a>

            <form method="POST" action="{{ route('categorias.destroy', $categoria->id) }}" style="display:inline;">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger " type="submit">Eliminar</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection
@extends('layout.admin')

@section('content')

<div>
    <br>
    <h2 class="alert-heading">
      <i class="fa-solid fa-boxes-stacked"></i> Productos
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


<a class="btn btn-primary" href="{{ route('productos.create') }}">Nuevo Producto</a>

<br>
<br>


<table class="table">
    <tr>
        <th>ID</th>
        <th>Material</th>
        <th>Cantidad</th>
        <th>Unidad</th>
        <th>Estado</th>

        <th>Categoría</th>
        <th>Precio</th>
        <th>Acciones</th>
    </tr>

    @foreach ($productos as $producto)
    <tr>
        <td>{{ $producto->id }}</td>
        <td>{{ $producto->material }}</td>
        <td>{{ $producto->cantidad }}</td>
        <td>{{ $producto->unidad }}</td>
        <td>{{ $producto->estado }}</td>

        <td>{{ $producto->categoria->nombre ?? '-' }}</td>
        <td>${{ number_format($producto->precio, 0, ',', '.') }}</td>
        <td style="display: flex;">
            <a class="btn btn-warning btn-sm" href="{{ route('productos.edit', $producto->id) }}">Editar</a>

            <form action="{{ route('productos.destroy', $producto->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm " type="submit">Eliminar</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

{{ $productos->links() }}

@endsection
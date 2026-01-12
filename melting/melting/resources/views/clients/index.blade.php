@extends('layout.admin')

@section('content')

<div>
    <br>
    <h2 class="alert-heading">
       <i class="fa-solid fa-user-group"></i> Clientes
    </h2>
    <br>
</div>




@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="row mb-3">
    <div class="col-xl-6 col-md-6">
        <a href="{{ route('clients.create') }}" class="btn btn-primary">Nuevo Cliente</a>
        <!--
        <a class="btn btn-warning" href="{{ route('clients.deleted') }}">Historial</a>
        <a class="btn btn-success" href="{{ route('clients.export') }}">Exporta Excel</a>
        <a class="btn btn-secondary" href="{{ route('clients.form-import') }}">Importar Clientes</a>
        -->
        
    </div>
</div>
<br>

<div class="card">
    <div class="card-body p-0">
        <table class="table">
            <thead class="table-primary">
                <tr>
                    <th>Nombre</th>
                     <th>Rut</th>
                    <th>Correo</th>
                   
                    <th width="220">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach($clients as $client)
                <tr>
                    <td>{{ $client->name }}</td>
                      <td>{{ $client->rut }}</td>
                    <td>{{ $client->email }}</td>
                  
                    <td>
                        <!-- 
                    <a class="btn btn-primary btn-sm" href="{{ route('clients.show', $client->id) }}">Detalles</a>
                    -->
                        <a class="btn btn-warning btn-sm" href="{{ route('clients.edit', $client->id) }}">Editar</a>

                        <form action="{{ route('clients.destroy', $client->id) }}" method="post" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
        {!! $clients->links() !!}
    </div>
</div>

@endsection
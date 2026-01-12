@extends('layout.admin')

@section('content')

<div>
    <br>
    <h2 class="alert-heading">
        <i class="fa-solid fa-user"></i> Editar Cliente
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
    <div class="col-11">
        <form class="row g-3" action="{{ route('clients.update', $client->id) }}" method="post" autocomplete="off">
            @csrf
            @method('PUT')
            <div class="col-md-4">
                <label class="form-label" for="name">Nombre</label>
                <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $client->name) }}" required>
            </div>

            <div class="col-md-3">
                <label class="form-label" for="paterno">Apellido Paterno</label>
                <input class="form-control" type="text" name="paterno" id="paterno" value="{{ old('paterno', $client->paterno) }}" required>
            </div>

            <div class="col-md-3">
                <label class="form-label" for="materno">Apellido Materno</label>
                <input class="form-control" type="text" name="materno" id="materno" value="{{ old('materno', $client->materno) }}" required>
            </div>

               <div class="col-md-4">
                <label class="form-label" for="direccion">Direccion</label>
                <input class="form-control" type="text" name="direccion" id="direccion" value="{{ old('direccion', $client->direccion) }}" required>
            </div>

               <div class="col-md-3">
                <label class="form-label" for="comuna">Comuna</label>
                <input class="form-control" type="text" name="comuna" id="comuna" value="{{ old('comuna', $client->comuna) }}" required>
            </div>

             <div class="col-md-3">
                <label class="form-label" for="rut">Rut</label>
                <input class="form-control" type="text" name="rut" id="rut" value="{{ old('rut', $client->rut) }}">
            </div>

            <div class="col-md-3">
                <label class="form-label" for="email">Correo electrónico</label>
                <input class="form-control" type="email" name="email" id="email" value="{{ old('email', $client->email) }}">
            </div>

            <div class="col-md-2">
                <label class="form-label" for="phone">Teléfono</label>
                <input class="form-control" type="text" name="phone" id="phone" value="{{ old('phone', $client->phone) }}">
            </div>

      

            <div class="col-md-5">
                <label class="form-label" for="notes">Notas</label>
                <textarea class="form-control" name="notes" id="notes" rows="1" style="resize:vertical; height:40px;">{{ old('notes', $client->notes) }}</textarea>
            </div>

            <div class="col-12">
                <br>
                <a class="btn btn-secondary" href="{{ route('clients.index') }}">Regresar</a>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>

        </form>
    </div>
</div>

@endsection
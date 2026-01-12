@extends('layout.admin')

@section('content')


<br>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif








<div class="d-flex justify-content-between align-items-center mb-3">


<div>
    <br>
    <h2 class="alert-heading">
        <i class="fa-solid fa-cart-arrow-down" style="padding-right: 10px;"></i>Compra:  {{ $compra->folio }}
    </h2>
    <br>
</div>

   

    <div>
        <a href="{{ route('compras.index') }}" class="btn btn-secondary">Volver</a>
        <a href="{{ route('compras.edit', $compra->id) }}" class="btn btn-warning">Editar</a>

        <!-- botón imprimir (puede llamar a una ruta que genere PDF) -->
        <a href="{{ route('compras.show', $compra->id) }}?print=1" target="_blank" class="btn btn-info">Imprimir</a>

        <form action="{{ route('compras.destroy', $compra->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta compra?');">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Eliminar</button>
        </form>
    </div>
</div>

{{-- Mensajes --}}
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

{{-- Cabecera compra --}}
<div class="card mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <h5>Datos Compra</h5>
                <p><strong>Folio:</strong> {{ $compra->folio }}</p>
                <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($compra->fecha)->format('d-m-Y') }}</p>
                <p><strong>Bodega:</strong> {{ ucfirst($compra->bodega) }}</p>
                @if($compra->factura)
                <p><strong>Factura:</strong> {{ $compra->factura }}</p>
                @endif
            </div>

            <div class="col-md-4">
                <h5>Cliente</h5>
                @if($compra->cliente)
                <p><strong>Nombre:</strong> {{ $compra->cliente->name }}</p>
                <p><strong>Email:</strong> {{ $compra->cliente->email ?? '-' }}</p>
                <p><strong>Teléfono:</strong> {{ $compra->cliente->phone ?? '-' }}</p>
                @if($compra->cliente->company)
                <p><strong>Empresa:</strong> {{ $compra->cliente->company }}</p>
                @endif
                @else
                <p class="text-muted">Cliente no registrado</p>
                @endif
            </div>

            <div class="col-md-4">
                <h5>Notas</h5>
                <p>{{ $compra->declaracion ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>

{{-- Items --}}
<div class="card">
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Producto / Material</th>
                    <th class="text-end">Cantidad</th>
                    <th class="text-end">Precio unit.</th>
                    <th class="text-end">Subtotal</th>
                </tr>
            </thead>

            <tbody>
                @php $total = 0; @endphp

                @forelse($compra->items as $i => $item)
                @php
                $subtotal = (float)$item->cantidad * (float)$item->precio;
                $total += $subtotal;
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>
                        {{ $item->material }}
                        @if($item->producto)
                        <div class="small text-muted">Producto ID: {{ $item->producto->id }} - {{ $item->producto->material }}</div>
                        @endif
                    </td>
                    <td class="text-end">{{ number_format($item->cantidad, 2, ',', '.') }} {{ $item->producto->unidad ?? '' }}</td>
                    <td class="text-end">${{ number_format($item->precio, 2, ',', '.') }}</td>
                    <td class="text-end">${{ number_format($subtotal, 2, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-3">No hay ítems en esta compra.</td>
                </tr>
                @endforelse
            </tbody>

            <tfoot>
                <tr>
                    <th colspan="4" class="text-end">TOTAL</th>
                    <th class="text-end">${{ number_format($total, 2, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>


@endsection
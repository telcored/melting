@extends('layout.admin')

@section('content')

<div>
    <br>
    <h2 class="alert-heading">
    <i class="fa-solid fa-cart-flatbed"></i> Compras
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
        <a href="{{ route('compras.create') }}" class="btn btn-primary">Nueva Compra</a>

    </div>
</div>
<br>



<div class="card">
    <div class="card-body p-0">
        <table class="table">
            <thead class="table-primary">
                <tr>
                    <th>Folio</th>
                    <th>Cliente</th>
                    <th>Bodega</th>
                    <th>Fecha</th>
                    <th>Factura</th>
                    <th>Total (CLP)</th>
                    <th width="220">Acciones</th>
                </tr>
            </thead>    

            <tbody>
                @forelse($compras as $compra)
                <tr>
                    <td>{{ $compra->folio }}</td>
                    <td>{{ $compra->cliente->name ?? 'Sin cliente' }}</td>
                    <td>{{ ucfirst($compra->bodega) }}</td>
                    <td>{{ $compra->fecha->format('d-m-Y') }}</td>
                    <td>{{ $compra->factura }}</td>

                    <td>
                        {{-- Si el total está en la tabla compras, úsalo --}}
                        @if(isset($compra->total))
                        ${{ number_format($compra->total, 0, ',', '.') }}
                        @else
                        {{-- Si deseas calcular desde los detalles --}}
                        ${{ number_format($compra->items->sum(fn($d) => $d->cantidad * $d->precio), 0, ',', '.') }}
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('compras.show', $compra->id) }}" class="btn btn-sm btn-primary">Ver</a>
                        <a href="{{ route('compras.edit', $compra->id) }}" class="btn btn-sm btn-warning">Editar</a>

                        <form action="{{ route('compras.destroy', $compra->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('¿Seguro que deseas eliminar esta compra?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="6" class="text-center py-3">No hay compras registradas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer">
        {{ $compras->links() }}
    </div>
</div>







@endsection
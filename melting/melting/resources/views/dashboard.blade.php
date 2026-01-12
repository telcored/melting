@extends('layout.admin')

@section('content')

<div>
    <br>
    <h2 class="alert-heading">
        <i class="fa-solid fa-grip"></i> Escritorio
    </h2>
    <br>
</div>

<div class="col-md-6"></div>

<!-- primera fila del dash -->
<div class="row">
    <div class="col-1"></div>

    <div class="col-xl-2 col-md-2">
        <div class="card bg-success text-white mb-4" style="border-radius: 10% / 50%;">
            <div class="card-body" style="text-align:center;">
                <h5>Compras</h5>
                <br>
                {{ $comprasDelMes  }}
                <a class="small text-white stretched-link" href="{{ route('compras.index') }}"></a>

            </div>

        </div>
    </div>

    <div class="col-xl-2 col-md-2">
        <div class="card bg-primary text-white mb-4" style="border-radius: 10% / 50%;">
            <div class="card-body" style="text-align: center;">
                <h5>Kilos Mes</h5>
                <br>
                {{ $kilosDelMes  }}
                <a class="small text-white stretched-link" href="{{ route('compras.index') }}"></a>
            </div>

        </div>
    </div>

    <div class="col-xl-2 col-md-2">
        <div class="card bg-secondary text-white mb-4" style="border-radius: 10% / 50%;">
            <div class="card-body" style="text-align: center;">
                <h5>Costo Mes</h5>
                <br>
                $ {{ number_format($dineroDelMes, 0, ',', '.') }}
                <a class="small text-white stretched-link" href="{{ route('clients.index') }}"></a>
            </div>

        </div>
    </div>

    <div class="col-xl-2 col-md-2">
        <div class="card bg-warning text-dark mb-4" style="border-radius: 10% / 50%;">
            <div class="card-body" style="text-align: center;">
                <h5>IVA Talca Mes</h5>
                <br>
                $ {{ number_format($ivaTalcaMes, 0, ',', '.') }}
                <a class="small text-dark stretched-link" href="{{ route('compras.index') }}"></a>
            </div>

        </div>
    </div>

    <div class="col-xl-2 col-md-2">
        <div class="card bg-warning text-dark mb-4" style="border-radius: 10% / 50%;">
            <div class="card-body" style="text-align: center;">
                <h5>IVA Chillán Mes</h5>
                <br>
                $ {{ number_format($ivaChillanMes, 0, ',', '.') }}
                <a class="small text-dark stretched-link" href="{{ route('compras.index') }}"></a>
            </div>

        </div>
    </div>


</div>

<!-- fila de espacio -->
<div class="row">

</div>

<!-- fila acumulados-->

<div class="row">
    <div class="col-1"></div>

    <div class="col-xl-2 col-md-2">
        <div class="card bg-success text-white mb-4" style="border-radius: 10% / 50%;">
            <div class="card-body" style="text-align: center;">
                <h5>Compras Acumuladas</h5>
                <br>
                {{ $totalComprasAcumuladas  }}
                <a class="small text-white stretched-link" href="{{ route('compras.index') }}"></a>
            </div>

        </div>
    </div>


    <div class="col-xl-2 col-md-2">
        <div class="card bg-primary text-white mb-4" style="border-radius: 10% / 50%;">
            <div class="card-body" style="text-align: center;">
                <h5>Kilos Acumulados</h5>
                <br>
                {{ $totalKilosAcumulados   }}
                <a class="small text-white stretched-link" href="{{ route('compras.index') }}"></a>
            </div>

        </div>
    </div>

    <div class="col-xl-2 col-md-2">
        <div class="card bg-secondary text-white mb-4" style="border-radius: 10% / 50%;">
            <div class="card-body" style="text-align: center;">
                <h5>Costo Acumuladas</h5>
                <br>
                $ {{ number_format($totalDineroAcumulado, 0, ',', '.') }}
                <a class="small text-white stretched-link" href="{{ route('clients.index') }}"></a>
            </div>

        </div>
    </div>

    <div class="col-xl-2 col-md-2">
        <div class="card bg-info text-white mb-4" style="border-radius: 10% / 50%;">
            <div class="card-body" style="text-align: center;">
                <h5>IVA Talca (Acum.)</h5>
                <br>
                $ {{ number_format($ivaTalcaTotal, 0, ',', '.') }}
                <a class="small text-white stretched-link" href="{{ route('compras.index') }}"></a>
            </div>

        </div>
    </div>

    <div class="col-xl-2 col-md-2">
        <div class="card bg-info text-white mb-4" style="border-radius: 10% / 50%;">
            <div class="card-body" style="text-align: center;">
                <h5>IVA Chillán (Acum.)</h5>
                <br>
                $ {{ number_format($ivaChillanTotal, 0, ',', '.') }}
                <a class="small text-white stretched-link" href="{{ route('compras.index') }}"></a>
            </div>

        </div>
    </div>

</div>
<br><br>

<!-- Grafico stock acumulado -->
<div class="row">

    <div class="col-1"></div>

    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
                <h5><i class="fas fa-warehouse" style="padding-right: 2%;"></i> Stock Acumulado por Bodega</h5>
                <div style="position: relative; height: 300px;">
                    <canvas id="myBarChart"></canvas>
                </div>
            </div>
        </div>
    </div>



    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="m-0"><i class="fas fa-history" style="padding-right: 2%;"></i> Últimas 7 Compras</h5>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Folio</th>
                                <th>Cliente</th>
                                <th>Fecha</th>
                                <th>Ver</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ultimasCompras as $compra)
                            <tr>
                                <td>
                                    <strong>{{ $compra->folio }}</strong>
                                </td>
                                <td>
                                    <small>{{ $compra->cliente->name ?? 'Sin cliente' }}</small>
                                </td>
                                <td>
                                    <small>{{ $compra->fecha->format('d/m/Y') }}</small>
                                </td>
                                <td>
                                    <a href="{{ route('compras.show', $compra->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">Sin compras registradas</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('script')

<script src="https://cdn.jsdelivr.net/npm/chart.js" type="text/javascript"></script>

<script>
    const ctx = document.getElementById('myBarChart').getContext('2d');
    const myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($bodegas),
            datasets: [{
                label: 'Kilos Acumulados',
                data: @json($kilosPorBodega),
                backgroundColor: [
                    'rgba(102, 126, 234, 0.8)',
                    'rgba(118, 75, 162, 0.8)',
                    'rgba(240, 147, 251, 0.8)'
                ],
                borderColor: [
                    'rgb(102, 126, 234)',
                    'rgb(118, 75, 162)',
                    'rgb(240, 147, 251)'
                ],
                borderWidth: 2,
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 13,
                            weight: 600
                        },
                        padding: 15
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        font: {
                            size: 12
                        }
                    }
                },
                x: {
                    ticks: {
                        font: {
                            size: 12,
                            weight: 600
                        }
                    }
                }
            }
        }
    });
</script>

@endpush
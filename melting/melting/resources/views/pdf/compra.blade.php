<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Acta de Compra - {{ $compra->folio }}</title>
    <style>
        @page {
            margin: 1.5cm 2cm;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.4;
            background-color: #fff;
        }

        .pagina {
            position: relative;
            width: 100%;
            height: auto;
            min-height: 25cm;
            /* Asegura espacio para el footer sin forzar desborde */
            padding: 5px;
            box-sizing: border-box;
        }

        .salto-pagina {
            page-break-after: always;
        }

        .folio-superior {
            text-align: right;
            font-weight: bold;
            font-size: 15px;
            margin-bottom: 15px;
        }

        .folio-box {
            display: inline-block;
            background-color: #f1f1f1;
            padding: 5px 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .titulo-seccion {
            text-align: center;
            margin-bottom: 25px;
        }

        .titulo {
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
        }

        .subtitulo {
            font-size: 14px;
            margin: 5px 0 0 0;
            text-transform: uppercase;
        }

        .bloque {
            border: 1px solid #ccc;
            padding: 12px;
            margin-bottom: 12px;
            border-radius: 6px;
            background-color: #fafafa;
        }

        .campo {
            margin-bottom: 4px;
        }

        .campo strong {
            text-transform: uppercase;
            color: #555;
            width: 140px;
            display: inline-block;
        }

        /* Contenedor de firmas con tabla para máxima compatibilidad dompdf */
        .tabla-firmas {
            width: 100%;
            margin-top: 50px;
            border: none;
        }

        .tabla-firmas td {
            width: 50%;
            text-align: center;
            border: none;
            padding: 0 20px;
        }

        .linea-firma {
            border-top: 1px solid #000;
            margin-bottom: 5px;
            width: 100%;
        }

        .etiqueta-footer {
            margin-top: 40px;
            text-align: right;
        }

        .footer-box {
            display: inline-block;
            font-weight: bold;
            font-size: 10px;
            border: 1px solid #000;
            background-color: #eaeaea;
            padding: 5px 12px;
            border-radius: 4px;
            text-transform: uppercase;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .items-table th,
        .items-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .items-table th {
            background-color: #eee;
            font-size: 10px;
            text-transform: uppercase;
        }
    </style>
</head>

<body>
    @php
    $copias = [
    'Original Policia de Investigaciones',
    'Vendedor o Empeñante',
    'Establecimiento MM SPA'
    ];
    @endphp

    @foreach($copias as $index => $etiqueta)
    <div class="pagina">
        <div class="folio-superior">
            <div class="folio-box">Folio: {{ $compra->folio }}</div>
        </div>

        <div class="titulo-seccion">
            @if($compra->bodega == 'talca')
            <h1 class="titulo">Brigada Investigaciones de robos Talca</h1>
            @else
            <h1 class="titulo">Brigada Investigaciones de robos Chillán</h1>
            @endif
            <p class="subtitulo">Inspección actas de procedencia</p>
        </div>

        <div class="bloque">
            <div class="campo"><strong>Establecimiento:</strong> Melting Metal SPA</div>
            <div class="campo"><strong>RUT:</strong> 77.821.514-4</div>
            @if($compra->bodega == 'talca')
            <div class="campo"><strong>Dirección:</strong> Chacarillas HJ2 #6</div>
            <div class="campo"><strong>Comuna:</strong> Maule</div>
            @else
            <div class="campo"><strong>Dirección:</strong> Brasil 48</div>
            <div class="campo"><strong>Comuna:</strong> Chillán</div>
            @endif
            <div class="campo"><strong>Código Comprador:</strong> 0001</div>
        </div>

        <div class="bloque">
            <div class="campo"><strong>Apellido Paterno:</strong> {{ $compra->cliente->paterno }}</div>
            <div class="campo"><strong>Apellido Materno:</strong> {{ $compra->cliente->materno }}</div>
            <div class="campo"><strong>Nombres:</strong> {{ $compra->cliente->name }}</div>
            <div class="campo"><strong>RUT:</strong> {{ $compra->cliente->rut }}</div>
            <div class="campo"><strong>Dirección:</strong> {{ $compra->cliente->direccion }}</div>
            <div class="campo"><strong>Comuna:</strong> {{ $compra->cliente->comuna }}</div>
        </div>

        <div class="bloque">
            <strong>Materiales / Productos:</strong>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Cantidad (Kg)</th>
                        <th>Precio Unit.</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($compra->items as $item)
                    <tr>
                        <td>{{ $item->material }}</td>
                        <td>{{ number_format($item->cantidad, 2, ',', '.') }}</td>
                        <td>${{ number_format($item->precio, 0, ',', '.') }}</td>
                        <td>${{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($compra->declaracion)
        <div class="bloque">
            <strong>Declaración:</strong>
            <div style="margin-top: 5px; font-style: italic;">
                {!! nl2br(e($compra->declaracion)) !!}
            </div>
        </div>
        @endif

        <div class="bloque">
            <div class="campo"><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($compra->fecha)->format('d-m-Y') }}</div>
            <div class="campo"><strong>Total Compra:</strong> ${{ number_format($total, 0, ',', '.') }}</div>
        </div>

        <table class="tabla-firmas">
            <tr>
                <td>
                    <div class="linea-firma"></div>
                    <strong>FIRMA VENDEDOR</strong>
                </td>
                <td>
                    <div class="linea-firma"></div>
                    <strong>HUELLA DACTILAR</strong>
                </td>
            </tr>
        </table>

        <div class="etiqueta-footer">
            <div class="footer-box">{{ $etiqueta }}</div>
        </div>
    </div>

    @if(!$loop->last)
    <div class="salto-pagina"></div>
    @endif
    @endforeach
</body>

</html>
<?php
require_once "conexion.php";
require_once "librerias/dompdf/vendor/autoload.php";

use Dompdf\Dompdf;
use Dompdf\Options;

// Obtener el último registro
$stmt = $conn->query("SELECT * FROM actas ORDER BY Folio DESC LIMIT 1");
$acta = $stmt->fetch(PDO::FETCH_ASSOC);

// Etiquetas para cada copia
$copias = ["ORIGINAL", "COPIA CLIENTE", "CEDIBLE"];

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('defaultFont', 'Helvetica');

$dompdf = new Dompdf($options);
$htmlFinal = '';

foreach ($copias as $etiqueta) {
    ob_start();
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Acta de Procedencia</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="estilosActa.css">
        <style>
            body { font-size: 12px; }
            .main-container { page-break-after: always; }
            .etiqueta-copia {
                position: absolute;
                top: 20px;
                right: 20px;
                font-weight: bold;
                font-size: 14px;
                border: 1px solid #000;
                padding: 3px 10px;
            }
        </style>
    </head>
    <body class="container-fluid">
        <div class="main-container">
            <div class="etiqueta-copia"><?= $etiqueta ?></div>

            <div class="folio-box mt-2 mb-2">
                <strong>FOLIO N°:</strong> <?= str_pad($acta['Folio'], 6, '0', STR_PAD_LEFT) ?>
            </div>

            <h2 class="text-center">ACTA DE PROCEDENCIA</h2>

            <div class="border p-3 mb-3">
                <div><strong>Establecimiento:</strong> Melting Metal SPA</div>
                <div><strong>Dirección:</strong> Chacarillas HJ2 #6</div>
                <div><strong>Comuna:</strong> Maule</div>
                <div><strong>Código del Comprador:</strong> ____________</div>
            </div>

            <div class="border p-3 mb-3">
                <h5>Datos del Vendedor o Empeñante</h5>
                <div><strong>Apellido Paterno:</strong> <?= htmlspecialchars($acta['ApellidoPaterno']) ?></div>
                <div><strong>Apellido Materno:</strong> <?= htmlspecialchars($acta['ApellidoMaterno']) ?></div>
                <div><strong>Nombres:</strong> <?= htmlspecialchars($acta['Nombres']) ?></div>
                <div><strong>Dirección:</strong> <?= htmlspecialchars($acta['Direccion']) ?></div>
                <div><strong>Comuna:</strong> <?= htmlspecialchars($acta['Comuna']) ?></div>
                <div><strong>RUT:</strong> <?= htmlspecialchars($acta['RUT']) ?></div>
            </div>

            <div class="border p-3 mb-3">
                <h5>Declaración del Vendedor o Empeñante</h5>
                <p>Declaro <strong>bajo juramento</strong> que las siguientes especies, que en este acto entrego, son de mi propiedad:</p>
                <p><?= nl2br(htmlspecialchars($acta['Declaracion'])) ?></p>
            </div>

            <div class="row mt-4">
                <div class="col-4">
                    <strong>Firma:</strong><br><br><br>
                    ____________________________
                </div>
                <div class="col-4 text-center">
                    <div class="thumb-box border" style="height: 80px;"></div>
                </div>
                <div class="col-4">
                    <div><strong>Fecha:</strong> <?= date("d-m-Y", strtotime($acta['Fecha'])) ?></div>
                    <div><strong>Total:</strong> $ <?= number_format($acta['Total'], 0, ',', '.') ?></div>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
    $htmlFinal .= ob_get_clean();
}

// Cargar contenido y renderizar PDF
$dompdf->loadHtml($htmlFinal);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("Acta_Procedencia_" . $acta['Folio'] . ".pdf", ["Attachment" => false]);
exit;

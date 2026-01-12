<?php
// ===== verPDF.php =====
require_once "conexion.php";
require_once "librerias/dompdf/vendor/autoload.php";

use Dompdf\Dompdf;

$folio = $_GET['folio'] ?? null;
if (!$folio) {
    die("Folio no especificado");
}

$stmt = $conn->prepare("SELECT * FROM actas WHERE Folio = ?");
$stmt->execute([$folio]);
$acta = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$acta) {
    die("Acta no encontrada");
}

$copias = ['Original Policia de Investigaciones', 'Vendedor o Empeñante', 'Establecimiento MM SPA'];
$htmlFinal = '';

foreach ($copias as $index => $etiqueta) {
    $htmlFinal .= "
    <html><head><style>
    body {
        font-family: 'Segoe UI', sans-serif;
        font-size: 12px;
        margin: 0;
        padding: 20px;
        color: #333;
        line-height: 1.5;
        background-color: #fff;
        position: relative;
    }
    .titulo {
        text-align: center;
        font-size: 15px;
        font-weight: bold;
        margin-top: 50px;
        margin-bottom: 30px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .subtitulo {
        text-align: center;
        font-size: 15px;
        font-weight: normal;
        margin-top: 50px;
        margin-bottom: 30px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .bloque {
        border: 1px solid #ccc;
        padding: 14px;
        margin-bottom: 15px;
        border-radius: 5px;
        background-color: #f9f9f9;
    }
    .campo {
        margin-bottom: 6px;
    }
    .firma-huella {
        margin-top: 40px;
        display: table;
        width: 100%;
        table-layout: fixed;
    }
    .firma-huella .col {
        display: table-cell;
        width: 50%;
        text-align: center;
        vertical-align: top;
    }
    .firma-linea {
        border-top: 1px solid #000;
        margin-top: 25px;
        width: 80%;
        margin-left: auto;
        margin-right: auto;
        padding-top: 5px;
    }
    .folio-superior {
        position: absolute;
        top: 5px;
        right: 20px;
        font-weight: bold;
        font-size: 16px;
        background-color: #f1f1f1;
        padding: 1px 12px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }
    .etiqueta-footer {
        position: absolute;
        bottom: 20px;
        right: 20px;
        font-weight: bold;
        font-size: 11px;
        border: 1px solid #000;
        background-color: #eaeaea;
        padding: 4px 10px;
        border-radius: 4px;
    }
    .pagina {
        position: relative;
        height: 100%;
        width: 100%;
        page-break-inside: avoid;
    }
    strong {
        text-transform: uppercase;
    }
    </style></head><body>
    <div class='pagina'>
    <div class='folio-superior'>Folio: {$acta['Folio']}</div>
    <div class='titulo'> Brigada Investigaciones de robos Chillán 
    <P class='subtitulo'>Inspeccion actas de procedencia</P>
    </div>
    

    <div class='bloque'>
        <div class='campo'><strong>Establecimiento:</strong> Melting Metal SPA</div>
         <div class='campo'><strong>RUT:</strong> 77.821.514-4</div>
        <div class='campo'><strong>Dirección:</strong> Brasil 48 </div>
        <div class='campo'><strong>Comuna:</strong> Chillán</div>
        <div class='campo'><strong>Código del Comprador:</strong> 0001</div>
    </div>

    <div class='bloque'>
        <div class='campo'><strong>Apellido Paterno:</strong> {$acta['ApellidoPaterno']}</div>
        <div class='campo'><strong>Apellido Materno:</strong> {$acta['ApellidoMaterno']}</div>
        <div class='campo'><strong>Nombres:</strong> {$acta['Nombres']}</div>
        <div class='campo'><strong>Dirección:</strong> {$acta['Direccion']}</div>
        <div class='campo'><strong>Comuna:</strong> {$acta['Comuna']}</div>
        <div class='campo'><strong>RUT:</strong> {$acta['RUT']}</div>
    </div>

    <div class='bloque'>
        <div><strong>Declaración:</strong></div>
        <div style='margin-top: 5px;'>" . nl2br(htmlspecialchars($acta['Declaracion'])) . "</div>
    </div>

    <div class='bloque'>
        <div class='campo'><strong>Fecha:</strong> " . date('d-m-Y', strtotime($acta['Fecha'])) . "</div>
        <div class='campo'><strong>Total:</strong> $" . number_format($acta['Total'], 0, ',', '.') . "</div>
    </div>
    </br></br>

    <div class='firma-huella'>
        <div class='col'><div class='firma-linea'></div><div>FIRMA</div></div>
        <div class='col'><div class='firma-linea'></div><div>HUELLA DACTILAR</div></div>
    </div>

    <div class='etiqueta-footer'>$etiqueta</div>
    </div>";

    if ($index < count($copias) - 1) {
        $htmlFinal .= "<div style='page-break-before: always;'></div>";
    }
}

$dompdf = new Dompdf();
$dompdf->loadHtml($htmlFinal);
$dompdf->setPaper('A4');
$dompdf->render();
$dompdf->stream("Acta_{$folio}.pdf", ["Attachment" => false]);

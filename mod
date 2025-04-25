<?php
require_once 'config/database.php';
require_once 'lib/TCPDF/tcpdf.php';

// Este es un modelo estático, posteriormente se puede hacer dinámico
// Configuración del PDF en formato factura/ticket
$pdf = new TCPDF('P', 'mm', array(80, 160), true, 'UTF-8', false);
$pdf->SetMargins(5, 5, 5);
$pdf->SetAutoPageBreak(true, 5);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 8);

// Datos estáticos de la empresa (para el modelo)
$empresa = [
    'nombre' => 'ARCHIVO REGIONA PUNO',
    'ruc' => '20601223455',
    'direccion' => 'Av.Ejercito',
    'documento' => 'FACTURA ELECTRÓNICA',
    'numero' => 'F001-000126',
    'fecha' => '25/08/2023'
];

// Datos del cliente (para el modelo)
$cliente = [
    'razon_social' => 'Fernando Abel Coronado',
    'ruc' => '10459519152',
    'direccion' => 'Jr. Los Lirios A-15'
];

// Producto en el modelo
$productos = [
    [
        'codigo' => 'SRV-001',
        'descripcion' => 'Por el servicio de informática',
        'cantidad' => 1,
        'valor_unitario' => 25.00,
        'valor_total' => 25.00
    ]
];

// Totales
$subtotal = 25.00;
$igv = 0.00;
$total = 25.00;

// ------ Generación del contenido ------

// ENCABEZADO
$html = '
<div style="text-align:center; line-height:1.2;">
    <span style="font-size:9pt; font-weight:bold;">' . $empresa['nombre'] . '</span><br>
    <span style="font-size:8pt;">RUC: ' . $empresa['ruc'] . '</span><br>
    <span style="font-size:8pt;">' . $empresa['direccion'] . '</span><br><br>
    <span style="font-size:9pt; font-weight:bold;">' . $empresa['documento'] . '</span><br>
    <span style="font-size:8pt;">No: ' . $empresa['numero'] . '</span><br>
</div>
<hr style="border-top:1px solid #000; margin:3px 0;">
';

// DATOS DEL CLIENTE
$html .= '
<div style="font-size:8pt; line-height:1.3;">
    <b>Nombre:</b> ' . $cliente['razon_social'] . '<br>
    <b>RUC:</b> ' . $cliente['ruc'] . '<br>
    <b>Dirección:</b> ' . $cliente['direccion'] . '<br>
    <b>Fecha Emisión:</b> ' . $empresa['fecha'] . '<br>
</div>
<hr style="border-top:1px solid #000; margin:3px 0;">
';

// TABLA DE PRODUCTOS
$html .= '
<table cellpadding="2" style="width:100%; font-size:8pt; border-collapse:collapse;">
    <tr>
        <th style="border-bottom:1px solid #000; text-align:center; width:15%;">Cantidad</th>
        <th style="border-bottom:1px solid #000; text-align:left; width:55%;">Descripción</th>
        <th style="border-bottom:1px solid #000; text-align:right; width:30%;">Valor Total</th>
    </tr>
';

foreach ($productos as $producto) {
    $html .= '
    <tr>
        <td style="text-align:center;">' . $producto['cantidad'] . '</td>
        <td style="text-align:left;">' . $producto['descripcion'] . '</td>
        <td style="text-align:right;">S/ ' . number_format($producto['valor_total'], 2) . '</td>
    </tr>';
}

$html .= '</table>';

// TOTALES
$html .= '
<table style="width:100%; font-size:8pt; margin-top:10px;">
    <tr>
        <td style="text-align:right; width:50%;"><b>OP. GRAVADAS:</b></td>
        <td style="text-align:right; width:50%;">S/ ' . number_format($subtotal, 2) . '</td>
    </tr>
    <tr>
        <td style="text-align:right;"><b>IGV:</b></td>
        <td style="text-align:right;">S/ ' . number_format($igv, 2) . '</td>
    </tr>
    <tr>
        <td style="text-align:right;"><b>PRECIO VENTA:</b></td>
        <td style="text-align:right;"><b>S/ ' . number_format($total, 2) . '</b></td>
    </tr>
</table>
<hr style="border-top:1px solid #000; margin:3px 0;">
';

// INFORMACIÓN ADICIONAL
$html .= '
<div style="font-size:7pt; line-height:1.2;">
    <p style="margin:2px 0;"><b>Información Adicional</b></p>
    <table style="width:100%; font-size:7pt;">
        <tr>
            <td style="width:50%;"><b>CONDICIÓN DE PAGO:</b></td>
            <td style="width:50%;">Efectivo</td>
        </tr>
        <tr>
            <td><b>VENDEDOR:</b></td>
            <td>Benjamin Aster</td>
        </tr>
    </table>
</div>
<hr style="border-top:1px solid #000; margin:3px 0;">
';

// CÓDIGO QR Y FIRMA DIGITAL
$html .= '
<div style="text-align:center; font-size:7pt;">
    <p style="margin:2px 0;">Consulta tu comprobante en:<br>tudominio.pe/buscar</p>
    <p style="margin:2px 0;">Autorizado mediante Resolución: 034-005-0000123</p>
    <p style="margin:2px 0;">FACTURA ELECTRÓNICA</p>
</div>
';

// Agregar el contenido al PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Generar código QR
$qrContent = "RUC: " . $empresa['ruc'] . "\n" .
             "TIPO: 01\n" .
             "SERIE: " . $empresa['numero'] . "\n" .
             "TOTAL: " . $total . "\n" .
             "FECHA: " . $empresa['fecha'];

$pdf->write2DBarcode($qrContent, 'QRCODE,M', 27, 130, 25, 25);

// Mostrar el PDF
$pdf->Output('factura_electronica.pdf', 'I');
<?php
require_once 'config/database.php';
require_once 'lib/TCPDF/tcpdf.php';

if (!isset($_GET['id'])) {
  die("ID de usuario requerido.");
}

$id = $_GET['id'];

// Obtener el usuario
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
  die("Usuario no encontrado.");
}

// Incrementar número de reporte
$reportNumber = $user['report_count'] + 1;
$stmt = $pdo->prepare("UPDATE users SET report_count = ? WHERE id = ?");
$stmt->execute([$reportNumber, $id]);

// Datos estáticos para el modelo (luego serán dinámicos)
$data = [
  'solicitud_id' => 1001,
  'pago_busqueda' => 5.00,
  'pago_verificacion' => 4.00,
  'cantidad_folio' => 2,
  'pago_folio' => 2.00,
  'cantidad_fotocopia' => 3,
  'pago_fotocopia' => 1.50,
  'cantidad_certificado' => 1, // Nuevo campo agregado
  'pago_certificado' => 3.50, // Nuevo campo agregado  
  'igv' => 0.00,  // IGV en 0 soles como solicitado
  'created_at' => date('Y-m-d'),
  'updated_at' => date('Y-m-d'),
];

$subtotal = $data['pago_busqueda'] + $data['pago_verificacion'] + $data['pago_folio'] + $data['pago_fotocopia'] + $data['pago_certificado'];
$total = $subtotal;

// Crear PDF tipo factura
$pdf = new TCPDF('P', 'mm', array(80, 150), true, 'UTF-8', false);
$pdf->SetMargins(5, 5, 5);
$pdf->SetAutoPageBreak(true, 5);
$pdf->AddPage();

// Logo (ajusta ruta si es necesario)
$logoPath = 'public/img/arp.png';
if (file_exists($logoPath)) {
  $pdf->Image($logoPath, 28, 2, 30);
}

$pdf->Ln(5); // espacio debajo del logo

// Cabecera de la factura - reduciendo espacios
$html = '
  <div style="text-align:center; font-size:1px; line-height:1;">
    <h4 style="text-align:center; margin-top:0; margin-bottom:1px; font-size:10px;">Archivo Regional Puno</h4>
    <p style="text-align:center; font-size:5px; margin:0;">RUC: 20180573012</p>
    <p style="text-align:center; font-size:5px; margin:0;">Ejercito 645, Puno 21002</p>
    
    <b><p style="text-align:center; font-size:10px; margin:0;">No: F001-' . str_pad($reportNumber, 6, '0', STR_PAD_LEFT) . '</p></b>
 
 
    </div>
 <p style="margin:0;">' . date('d/m/Y H:i:s') . '</p> 
  <div style="line-height:1.1;">

<p style="margin:0; font-size:5px;"><b>Datos del Cliente:</b> </p>
  <p style="text-align:center; font-size:5px; margin:0;">N° Solicitud: 1</p>
    <p style="text-align:center; font-size:5px; margin:0;">N° Cliente: 2</p>
    <p style="text-align:center; font-size:5px; margin:0;">DNI: 231232312</p>


    <hr style="border-top:1px solid #000; margin:2px 0;">
';

// Tabla de productos con ítem y mejor uso del espacio
$html .= '
  <table cellpadding="1" style="width:100%;  border-collapse:collapse;">
    <tr style="font-size: 8px; font-weight:bold">
      <th style="text-align:center; width:10%; border-bottom:1px solid #000;">Item</th>
      <th style="text-align:center; width:15%; border-bottom:1px solid #000;">Cant.</th>
      <th style="text-align:left; width:45%; border-bottom:1px solid #000;">Descripción</th>
      <th style="text-align:right; width:30%; border-bottom:1px solid #000;">Valor Total</th>
    </tr>
    <tr style="font-size: 7px">
      <td style="text-align:center;">1</td>
      <td style="text-align:center;">1</td>
      <td style="text-align:left;">Búsqueda</td>
      <td style="text-align:right;">S/ ' . number_format($data['pago_busqueda'], 2) . '</td>
    </tr>
    <tr style="font-size: 7px">
      <td style="text-align:center;">2</td>
      <td style="text-align:center;">1</td>
      <td style="text-align:left;">Verificación</td>
      <td style="text-align:right;">S/ ' . number_format($data['pago_verificacion'], 2) . '</td>
    </tr>
    <tr style="font-size: 7px">
      <td style="text-align:center;">3</td>
      <td style="text-align:center;">' . $data['cantidad_folio'] . '</td>
      <td style="text-align:left;">Folio</td>
      <td style="text-align:right;">S/ ' . number_format($data['pago_folio'], 2) . '</td>
    </tr>
    <tr style="font-size: 7px">
      <td style="text-align:center;">4</td>
      <td style="text-align:center;">' . $data['cantidad_fotocopia'] . '</td>
      <td style="text-align:left;">Fotocopia</td>
      <td style="text-align:right;">S/ ' . number_format($data['pago_fotocopia'], 2) . '</td>
    </tr>
    <tr style="font-size: 7px">
      <td style="text-align:center;">5</td>
      <td style="text-align:center;">' . $data['cantidad_certificado'] . '</td>
      <td style="text-align:left;">Certificado</td>
      <td style="text-align:right;">S/ ' . number_format($data['pago_certificado'], 2) . '</td>
    </tr>
  </table>

  <table style="width:100%; font-size:8px; margin-top:3px;">
  
  <hr style="border-top:1px solid #000; margin:2px 0;">
  <tr>
      <td style="text-align:right; width:60%;"><b>SUBTOTAL:</b></td>
      <td style="text-align:right; width:40%;">S/ ' . number_format($subtotal, 2) . '</td>
    </tr>
    <tr>
      <td style="text-align:right;">IGV:</td>
      <td style="text-align:right;">S/ ' . number_format($data['igv'], 2) . '</td>
    </tr>
    <tr>
      <td style="text-align:right;"><b>TOTAL:</b></td>
      <td style="text-align:right;"><b>S/ ' . number_format($total, 2) . '</b></td>
    </tr>
  </table>
  <hr style="border-top:1px solid #000; margin:2px 0;">
  
  <div style="text-align:center; font-size:7px; margin-top:2px;">
    <p style="margin:0;">Gracias por su preferencia</p>
  </div>

  <p style="margin:0; font-size:5px;"><b>Datos del Remitente:</b> </p>
    <p style="margin:0;font-size:7px;"><b>Nombre:</b> ' . htmlspecialchars($user['name']) . '</p>
    <p style="margin:0;font-size:7px;"><b>Celular:</b> ' . (isset($user['phone']) ? $user['phone'] : '0000000000') . '</p>
    <p style="margin:0;font-size:7px;"><b>Email:</b> ' . (isset($user['email']) ? htmlspecialchars($user['email']) : 'Jr. Los Lirios A-15') . '</p>
  </div>

';

// Agregar contenido al PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Generar QR - ajustando posición para que no se desborde
$qrContent = "ID: " . $user['id'] . 
             "\nNombre: " . $user['name'] . 
             "\nReporte N°: " . $reportNumber .
             "\nTotal: S/ " . number_format($total, 2);
$pdf->write2DBarcode($qrContent, 'QRCODE,H', 48, 35, 25, 25);




// Mostrar el PDF
$pdf->Output('factura_electronica.pdf', 'I');



// Guardar y devolver la ruta del archivo
$folder = 'facturas/';
if (!file_exists($folder)) {
    mkdir($folder, 0777, true); // Crea la carpeta si no existe
}
$filename = 'factura_' . $user['id'] . '_' . $reportNumber . '.pdf';
$fullPath = $folder . $filename;

$pdf->Output($fullPath, 'F');

// Devolver la ruta como respuesta para descarga
echo json_encode(['ruta' => $fullPath]);

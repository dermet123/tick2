<?php
require_once 'config/database.php';
require_once 'lib/TCPDF/tcpdf.php';

// Depuración: Mostrar todos los parámetros GET
// echo "<pre>";
// print_r($_GET);
// echo "</pre>";
// exit;

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
$contador = $user['report_count'] + 1;
$stmt = $pdo->prepare("UPDATE users SET report_count = ? WHERE id = ?");
$stmt->execute([$contador, $id]);

// Datos estáticos para el modelo (luego serán dinámicos)
$data = [
  'solicitud_id' => 1001,
  'pago_busqueda' => 5.00,
  'pago_verificacion' => 4.00,
  'cantidad_folio' => 2,
  'pago_folio' => 2.00,
  'cantidad_fotocopia' => 3,
  'pago_fotocopia' => 1.50,
  'igv' => 0.00,  // IGV en 0 soles como solicitado
  'created_at' => date('Y-m-d'),
  'updated_at' => date('Y-m-d'),
];

$subtotal = $data['pago_busqueda'] + $data['pago_verificacion'] + ($data['cantidad_folio'] * $data['pago_folio']) + ($data['cantidad_folio'] * $data['pago_fotocopia']);
$total = $subtotal;

// Crear PDF tipo factura
$pdf = new TCPDF('P', 'mm', array(80,150), true, 'UTF-8', false);

$pdf->SetMargins(5, 5, 1);

$pdf->SetAutoPageBreak(true, 5);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage();

// Logo (ajusta ruta si es necesario)
$logoRuta = 'public/img/arp.png';
if(file_exists($logoRuta))
{
  $pdf->Image($logoRuta, 25, 2, 33);
}

// espacio debajo del logo
$pdf->Ln(1); // espacio debajo del logo

// Cabecera de la factura - reduciendo espacios

//DinamicoTamaño
$dintamaño = 8;
$estaticotamaño = 5;
$estaticoclien = 7;

//Cabecera Estatica
$html = '
<div style="text-align:center; line-height:1;">
    

    <h4 style="margin-bottom:1px; font-size:' . $dintamaño . 'px; ">RUC: 20180573012</h4>
    <p style="font-size:' . $estaticotamaño . 'px;">Ejercito 645, Puno 21002</p>

    <table style="width: 100%; font-size:' . $dintamaño . 'px;margin: 0; padding: 0;">
      <tr>
        <td style="text-align: left;font-weight:bold">No: F001-' . str_pad($contador, 6, '0', STR_PAD_LEFT) . '</td>
        <td style="text-align: right;">' . date('d/m/Y H:i:s') . '</td>
      </tr>
    </table>
---------------------------------------------------
<p style="font-size:' . $estaticoclien . 'px; text-align:left; font-weight:bold">Datos del Cliente:</p>
<table style="font-size:' . $estaticotamaño . 'px; margin:0 0 2px 0; width:100%; ; ;">
  <tr style="font-size:6px;">
    <td style="padding:0; border-top:1px solid #000;"><b>N° Solicitud:</b></td>
    <td style="padding:0; border-top:1px solid #000;">1</td>
  </tr>
  <tr style="font-size:6px;">
    <td style="padding:0; border-top:1px solid #000;"><b>Cliente:</b></td>
    <td style="padding:0; border-top:1px solid #000;">' . (isset($_GET['client_name']) ? htmlspecialchars($_GET['client_name']) : 'No especificado') . '</td>
  </tr>
  <tr style="font-size:6px;">
    <td style="padding:0;border-bottom:1px solid #000;"><b>DNI:</b></td>
    <td style="padding:0; border-bottom:1px solid #000;">231232312</td>
  </tr>
</table>

<br/>


<p style="font-size:' . $estaticoclien . 'px; text-align:left; font-weight:bold">Derecho de Pago:</p>
<hr style="border-top:1px solid #000; margin:2px 0;">

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
  </table>

  <table style="width:100%; font-size:8px; margin-top:3px;">

  <hr style="border:10px solid #000; margin:5px 0;">
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
  ----------------------------------------------------
  <h3 style="font-size:8px;">Gracias por su Preferencia!!</h3>
  
<p style="font-size:7px; text-align:left; font-weight:bold; margin:0 0 2px 0;">Datos del Remitente:</p>

<div style="width:50%;">

  <table style="font-size:6px; width:50%; border-collapse:collapse;  margin-bottom:2px;">
    <tr>
      <td style="padding:1px 2px; border-top:1px solid #000; width:50%;"><b>Nombre:</b></td>
      <td style="padding:1px 2px; border-top:1px solid #000;">' . htmlspecialchars($user['name']) . '</td>
    </tr>
    <tr>
      <td style="padding:1px 2px; border-top:1px solid #000;"><b>Celular:</b></td>
      <td style="padding:1px 2px; border-top:1px solid #000;">' . (isset($user['phone']) ? $user['phone'] : '0000000000') . '</td>
    </tr>
    <tr>
      <td style="padding:1px 2px; border-bottom:1px solid #000;"><b>Email:</b></td>
      <td style="padding:1px 2px; border-bottom:1px solid #000;">' . (isset($user['email']) ? htmlspecialchars($user['email']) : 'Jr. Los Lirios A-15') . '</td>
    </tr>
  </table>

</div>


';



// Agregar contenido al PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Generar QR - ajustando posición para que no se desborde
$qrContent = "ID: " . $user['id'] . 
             "\nNombre: " . $user['name'] . 
             "\nReporte N°: " . $contador .
             "\nTotal: S/ " . number_format($total, 2);
$pdf->write2DBarcode($qrContent, 'QRCODE,H', 50, 99, 22, 25);




// Mostrar el PDF
$pdf->Output('factura_electronica.pdf', 'I');









// Mostrar el PDF
$pdf->Output('factura_electronica.pdf', 'I');






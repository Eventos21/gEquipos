<?php
function formato_soles($monto) {
    $simbolo_moneda = "bs ";
    $monto_formateado = number_format($monto, 2, '.', ',');
    $monto_formateado = $simbolo_moneda . $monto_formateado;
    return $monto_formateado;
}
ini_set('display_errors', 0);
error_reporting(0);
ob_start();
$compras = CompraData::verid($_GET['tid']);
require_once('tcpdf/tcpdf.php'); 

$pdf = new TCPDF('P', 'mm', array(72, 200), true, 'UTF-8', false); 
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tu Nombre');
$pdf->SetTitle('Ticket de Compra');
$pdf->SetSubject('Ticket');
$pdf->SetKeywords('TCPDF, PDF, ticket, test');

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetMargins(5, 5, 5);
$pdf->AddPage();
// $image_file = 'storage/per/logo.png';
// $pdf->Image($image_file, 50, 2, 10, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
// $pdf->SetY(5);
$pdf->SetFont('helvetica', 'B', 14);
$sucursales1=SucursalData::verid($compras->sucursal);

$html = '<h2 style="color: #333333; text-align: center;">'.$sucursales1->nombre.'</h2>';
$html .= '<p style="color: #555555; text-align: center;">Dirección: '.$sucursales1->direccion.'<br>Telefono: '.$sucursales1->telefono.'</p>';

$html .= '<p style="color: #555555;">Nr. 000'.$compras->id.'<br>Motivo: Compra de productos<br>Fecha y Hora: '.$compras->fecha.'</p>';

$pdf->SetFont('helvetica', '', 8);

$html .= '<style>
            th {
                background-color: #f5f5f5;
                font-weight: bold;
                color: #333333;
                border-bottom: 1px solid #ddd;
            }
            td, th {
                padding: 8px 5px;
                color: #555555;
            }
            table {
                border-collapse: collapse;
            }
        </style>';
$pdf->SetFont('helvetica', '', 6);
$html .= '<table border="0" cellpadding="2" width="100%">';

$html .= '<thead>';
$html .= '<tr>';
$html .= '<th width="45%">Producto</th>';  // Aumentamos el ancho de la columna del producto
$html .= '<th width="20%">Precio U.</th>';  // Reducimos el ancho de las otras columnas
$html .= '<th width="15%">Cant.</th>';
$html .= '<th width="20%">Subtotal</th>';
$html .= '</tr>';
$html .= '</thead>';

$datas=DetalleCompraData::vercontenidos($compras->id);
foreach ($datas as $data) {
$html .= '<tr>';
$html .= '<td width="45%" style="font-size: 5px;">'.$data->productos.'</td>';
$html .= '<td width="20%" style="font-size: 5px;">'.formato_soles($data->precio).'</td>';
$html .= '<td width="15%" style="font-size: 5px;">'.$data->cantidad.'</td>';
$html .= '<td width="20%" style="font-size: 5px;">'.formato_soles($data->precio*$data->cantidad).'</td>';
$html .= '</tr>';
}

$html .= '<tfoot>';
$html .= '<tr>';
$html .= '<td colspan="2" style="border-top: 1px solid #ddd;">Subtotal</td>';
$html .= '<td colspan="2" style="border-top: 1px solid #ddd;">'.formato_soles($compras->subtotal).'</td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td colspan="2">Descuento</td>';
$html .= '<td colspan="2">'.formato_soles($compras->descuento).'</td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td colspan="2" style="border-top: 2px solid #333;">Total</td>';
$html .= '<td colspan="2" style="border-top: 2px solid #333;">'.formato_soles($compras->total).'</td>';
$html .= '</tr>';
$html .= '</tfoot>';

$html .= '</table>';
$html .= '<div style="margin-top: 60px;"></div>';  // Espacio después de la tabla
$html .= '<div style="border-top: 1px dashed #000;"></div>';
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('ticket.pdf', 'I'); 
ob_end_flush(); 
?>
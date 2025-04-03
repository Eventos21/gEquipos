<?php 
require_once('tcpdf/tcpdf.php');
$user = UserData::verid($_SESSION['conticomtc']);
$equipos = EquipoData::verid($_GET['equipo']);
$competicion1 = CompeticionData::verid($equipos->competicion);
$ligas = LigaData::verid($equipos->liga);
$clubes = ClubData::verid($equipos->club);
function formato_soles($monto) {
    $simbolo_moneda = "C$ ";
    $monto_formateado = number_format($monto, 2, '.', ',');
    $monto_formateado = $simbolo_moneda . $monto_formateado;
    return $monto_formateado;
}
$total_gasto = 0;
$utilidad_bruta = 0;
$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Federación Madrileña de Ajedrez');
$pdf->SetTitle('Orden de Fuerza');
$pdf->SetSubject('Orden de fuerza validado');
$pdf->SetKeywords('FMA, orden, fuerza');

$pdf->SetFooterData(PDF_HEADER_TITLE, 0, 'Página {PAGENO} de {NB}', 'Generado el: ' . date('Y-m-d H:i:s'));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetPageOrientation('L');

// Eliminar la línea de la cabecera
$pdf->SetHeaderMargin(0);
$pdf->SetHeaderMargin(0);

$pdf->AddPage();
$y_start = 12; 
$image_file = 'storage/per/logo.png';
if(file_exists($image_file) && is_readable($image_file)){
    $pdf->Image($image_file, 22, 20, 15, 25, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
} else {
    error_log('No se puede encontrar o leer el archivo de logo.');
}

$pdf->SetFont('helvetica', 'B', 12);
$pdf->SetY($y_start + 5);
$startX = 50;
$pdf->SetX($startX);
$pdf->Cell(0, 20, 'RELACIÓN DE LICENCIAS FEDERATIVAS PRESENTADAS EN ORDEN DE FUERZA REGLAMENTARIO', 0, 1, 'L', 0, '', 0, false, 'M', 'M');

$startX = 50; // Establece la misma posición X
$pdf->SetX($startX);
$pdf->Cell(0, 0, 'CAMPEONATO:', 0, 0, 'L', 0, '', 0, false, 'M', 'M'); // Cambia el último argumento de 1 a 0

$startX1 = 84; // Ajusta la posición X
$pdf->SetX($startX1);
$pdf->Cell(0, 0, $ligas->nombre, 0, 0, 'L', 0, '', 0, false, 'M', 'M');
$pdf->SetFont('helvetica', '', 12);
$startX1 = 84; 
$pdf->SetX($startX1);
$pdf->Cell(0, 0, '_________________________________________', 0, 0, 'L', 0, '', 0, false, 'M', 'M');

$pdf->SetFont('helvetica', 'B', 13);
$startX2 = 185; // Ajusta la posición X
$pdf->SetX($startX2);
$pdf->Cell(0, 0, 'TEMPORADA:', 0, 0, 'L', 0, '', 0, false, 'M', 'M');
$pdf->SetFont('helvetica', '', 12);
$startX2 = 218; // Ajusta la posición X
$pdf->SetX($startX2);
$pdf->Cell(0, 0, '____________', 0, 0, 'L', 0, '', 0, false, 'M', 'M');
$pdf->SetFont('helvetica', 'B', 12);
$pdf->SetX($startX2);
$pdf->Cell(0, 25, $ligas->temporadas, 0, 1, 'L', 0, '', 0, false, 'M', 'M');

$pdf->SetX($startX);
$pdf->Cell(0, 0, 'EQUIPO:', 0, 0, 'L', 0, '', 0, false, 'M', 'M');
$pdf->SetFont('helvetica', '', 12);
$startX3 = 70; // Ajusta la posición X
$pdf->SetX($startX3);
$pdf->Cell(0, 0, '___________________________________________________________________________', 0, 0, 'L', 0, '', 0, false, 'M', 'M');
$pdf->SetFont('helvetica', 'B', 12);
$pdf->SetX($startX3);
$pdf->Cell(0, 20, $equipos->nombre, 0, 1, 'L', 0, '', 0, false, 'M', 'M');
$pdf->SetFont('helvetica', 'B', 12);
$startX4 = 200;
$pdf->SetX($startX4);
// $pdf->Cell(0, 0, 'EQUIPO:', 0, 0, 'L', 0, '', 0, false, 'M', 'M');
$pdf->SetFont('helvetica', '', 12);
$startX5 = 220;
$pdf->SetX($startX5);
// $pdf->Cell(0, 0, '____________________', 0, 0, 'L', 0, '', 0, false, 'M', 'M');
$pdf->SetFont('helvetica', 'B', 12);
$pdf->SetX($startX5);
$pdf->SetX($startX5);
// $pdf->Cell(0, 20, $equipos->nombre, 0, 1, 'L', 0, '', 0, false, 'M', 'M');

$pdf->SetX($startX);
$pdf->Cell(0, 0, 'CATEGORÍA:', 0, 0, 'L', 0, '', 0, false, 'M', 'M');
$pdf->SetFont('helvetica', '', 12);
$startX3 = 78; // Ajusta la posición X
$pdf->SetX($startX3);
$pdf->Cell(0, 0, '_________________________________________', 0, 0, 'L', 0, '', 0, false, 'M', 'M');
$pdf->SetFont('helvetica', 'B', 12);
$pdf->SetX($startX3);
$pdf->Cell(0, 0, $competicion1->nombregrupo, 0, 0, 'L', 0, '', 0, false, 'M', 'M');
$pdf->SetFont('helvetica', 'B', 12);
$startX4 = 180;
$pdf->SetX($startX4);
$pdf->Cell(0, 0, 'GRUPO:', 0, 0, 'L', 0, '', 0, false, 'M', 'M');
$pdf->SetFont('helvetica', '', 12);
$startX5 = 200;
$pdf->SetX($startX5);
$pdf->Cell(0, 0, '____________________', 0, 0, 'L', 0, '', 0, false, 'M', 'M');
$pdf->SetFont('helvetica', 'B', 12);
$pdf->SetX($startX5);
$pdf->SetX($startX5);
$pdf->Cell(0, 0, $competicion1->grupo, 0, 1, 'L', 0, '', 0, false, 'M', 'M');

$pdf->Ln(10);
$edad = $ligas->edad;
if (strpos($edad, '-') !== false) {
        // Si la cadena contiene un guion "-", entonces es un rango
        $rango = true;
    } else {
        // Si no contiene un guion "-", entonces es un valor único
        $rango = false;
    }
if ($rango) {
        list($minEdad, $maxEdad) = explode('-', $edad);
        // Convertir los valores a números enteros si es necesario
        $minEdad = intval($minEdad);
        $maxEdad = intval($maxEdad);
        $pdf->SetFont('helvetica', 'B', 12);
        $html = '
            <table border="1" cellpadding="3" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%; font-size: 9px;">
                <thead>
                    <tr>
                        <th class="text-center font-weight-bold" width="60px"><p align="center"><b> COD FMA</b></p></th>
                        <th class="text-center font-weight-bold" width="60px"><p align="center"><b> COD FIDE</b></p></th>
                        <th class="text-center font-weight-bold" width="20px"><p align="center"><b> N</b></p></th>
                        <th class="text-center font-weight-bold" width="392px"><b>APELLIDOS Y NOMBRE</b></th>
                        <th class="text-center font-weight-bold"><p align="center"><b>FECHA DE NACIMIENTO</b></p></th>
                        <th class="text-center font-weight-bold" width="50px"><p align="center"><b> ELO</b></p></th>
                        <th class="text-center font-weight-bold" width="90px"><p align="center"><b> FECHA DE ALTA</b></p></th>
                    </tr>
                </thead>
                <tbody>';
        $pdf->SetFont('helvetica', '', 12);
        $contador = 0;
        $datos = EquipoJugadorData::vercontenido_fecha_rango1($_GET['equipo'], $minEdad, $maxEdad);
        foreach ($datos as $dato) {
            $contador++;
            $html .= ' 
                <tr>
                    <td width="60px"><p align="center">' . $dato->codigofide  . '</p></td>
                    <td width="60px"><p align="center">' . $dato->numlicencia . '</p></td>
                    <td width="20px"><p align="center">' . $contador . '</p></td>
                    <td width="392px">' . $dato->apellido1 . " " . $dato->apellido2 . ", " . $dato->nombre . '</td>
                    <td><p align="center">' . date("d-m-Y", strtotime($dato->nacimiento)) . '</p></td>
                    <td width="50px"><p align="center">' . $dato->elo . '</p></td>
                    <td width="90px"><p align="center">' . date("d-m-Y", strtotime($dato->fecha)) . '</p></td>
                </tr>';
        }
/*        $html .= ' 
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>';*/
        $html .= '</tbody></table>';
        $pdf->writeHTML($html, true, false, true, false, '');


    } else {
        // Si no es un rango, el valor es la edad específica
        $edadEspecifica = intval($edad);
        $pdf->SetFont('helvetica', 'B', 12);
        $html = '
            <table border="1" cellpadding="3" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%; font-size: 9px;">
                <thead>
                    <tr>
                        <th class="text-center font-weight-bold" width="60px"><p align="center"><b> COD FMA</b></p></th>
                        <th class="text-center font-weight-bold" width="60px"><p align="center"><b> COD FIDE</b></p></th>
                        <th class="text-center font-weight-bold" width="20px"><p align="center"><b> N</b></p></th>
                        <th class="text-center font-weight-bold" width="392px"><b>APELLIDOS Y NOMBRE</b></th>
                        <th class="text-center font-weight-bold"><p align="center"><b>FECHA DE NACIMIENTO</b></p></th>
                        <th class="text-center font-weight-bold" width="50px"><p align="center"><b> ELO</b></p></th>
                        <th class="text-center font-weight-bold" width="90px"><p align="center"><b> FECHA DE ALTA</b></p></th>
                    </tr>
                </thead>
                <tbody>';
        $pdf->SetFont('helvetica', '', 12);
        $contador = 0;
        $datos = EquipoJugadorData::vercontenido_fecha_especifica1($_GET['equipo'], $edadEspecifica);
        foreach ($datos as $dato) {
            $contador++;
            $html .= ' 
                <tr>
                    <td width="60px"><p align="center">' . $dato->codigofide  . '</p></td>
                    <td width="60px"><p align="center">' . $dato->numlicencia . '</p></td>
                    <td width="20px"><p align="center">' . $contador . '</p></td>
                    <td width="392px">' . $dato->apellido1 . " " . $dato->apellido2 . ", " . $dato->nombre . '</td>
                    <td><p align="center">' . date("d-m-Y", strtotime($dato->nacimiento)) . '</p></td>
                    <td width="50px"><p align="center">' . $dato->elo . '</p></td>
                    <td width="90px"><p align="center">' . date("d-m-Y", strtotime($dato->fecha)) . '</p></td>
                </tr>';
        }
/*        $html .= ' 
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>';*/
        $html .= '</tbody></table>';
        $pdf->writeHTML($html, true, false, true, false, '');

    }


$newX = 10 ;
$pdf->SetFont('helvetica', '', 10);
$pdf->SetX($newX);
$pdf->Cell(0, 20, 'A efectos de lo establecido en el Reglamento de Competiciones de la Federación Madrileña de Ajedrez', 0, 1, 'L', 0, '', 0, false, 'M', 'M');

$pdf->SetX($newX);
$pdf->Cell(0, 0, 'Capitán:', 0, 0, 'L', 0, '', 0, false, 'M', 'M');
$pdf->SetFont('helvetica', '', 10);
$startX3 = 40; // Ajusta la posición X
$pdf->SetX($startX3);
$pdf->Cell(0, 0, '____________________________________________________________', 0, 0, 'L', 0, '', 0, false, 'M', 'M');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetX($startX3);
$pdf->Cell(0, 0, $equipos->capitanes, 0, 0, 'L', 0, '', 0, false, 'M', 'M');
$pdf->SetFont('helvetica', '', 10);
$startX4 = 170;
$pdf->SetX($startX4);
$pdf->Cell(0, 0, 'Fecha de nacimiento:', 0, 0, 'L', 0, '', 0, false, 'M', 'M');
$pdf->SetFont('helvetica', '', 10);
$startX5 = 210;
$pdf->SetX($startX5);
$pdf->Cell(0, 0, '____________________', 0, 0, 'L', 0, '', 0, false, 'M', 'M');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetX($startX5);
$pdf->SetX($startX5);
$pdf->Cell(0, 15, date("d-m-Y", strtotime($equipos->nacimiento1)), 0, 1, 'L', 0, '', 0, false, 'M', 'M');

$pdf->SetFont('helvetica', '', 10);
$pdf->SetX($newX);
$pdf->Cell(0, 0, 'Subcapitán:', 0, 0, 'L', 0, '', 0, false, 'M', 'M');
$pdf->SetFont('helvetica', '', 10);
$startX3 = 40; // Ajusta la posición X
$pdf->SetX($startX3);
$pdf->Cell(0, 0, '____________________________________________________________', 0, 0, 'L', 0, '', 0, false, 'M', 'M');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetX($startX3);
$pdf->Cell(0, 0, $equipos->subcapitanes, 0, 0, 'L', 0, '', 0, false, 'M', 'M');
$pdf->SetFont('helvetica', '', 10);
$pdf->SetX($startX4);
$pdf->Cell(0, 0, 'Fecha de nacimiento:', 0, 0, 'L', 0, '', 0, false, 'M', 'M');
$pdf->SetFont('helvetica', '', 10);
$pdf->SetX($startX5);
$pdf->Cell(0, 0, '____________________', 0, 0, 'L', 0, '', 0, false, 'M', 'M');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetX($startX5);
$pdf->SetX($startX5);
if ($equipos->subcapitanes != "") {
    $formattedDate = date("d-m-Y", strtotime($equipos->nacimiento2));
} else {
    $formattedDate = "";
}
$pdf->Cell(0, 0, $formattedDate, 0, 1, 'L', 0, '', 0, false, 'M', 'M');


$image_file = 'storage/per/sello.png';
if(file_exists($image_file) && is_readable($image_file)){
    $pdf->Image($image_file, 250, 160, 25, 25, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
} else {
    error_log('No se puede encontrar o leer el archivo de logo.');
}

$nombre_archivo = $equipos->nombre.'.pdf';
$pdf->Output($nombre_archivo, 'I'); ?>
<?php 
if ($_GET['action'] == 'apimiclub') {
    $start = $_REQUEST['start'];
    $length = $_REQUEST['length'];
    $search = $_REQUEST['search']['value'];
    $responsable = $_GET['responsable'];
    
    $contenidoporpagina = ClubData::vercontenidoPaginado1($responsable, $start, $length, $search);
    $totalRegistros = ClubData::totalRegistro1($responsable);
    $totalRegistrosFiltrados = ClubData::totalRegistrosFiltrados1($responsable, $search);
    
    $response = array(
        "draw" => intval($_REQUEST['draw']),
        "recordsTotal" => $totalRegistros,
        "recordsFiltered" => $totalRegistrosFiltrados,
        "data" => $contenidoporpagina
    );
    
    echo json_encode($response);
    exit;
} ?>
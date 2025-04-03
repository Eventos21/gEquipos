<?php 
if ($_GET['action'] == 'apimequipo') {
    $start = $_REQUEST['start'];
    $length = $_REQUEST['length'];
    $search = $_REQUEST['search']['value'];
    $club = $_GET['club'];
    
    $contenidoporpagina = EquipoData::vercontenidoPaginado1($club, $start, $length, $search);
    $totalRegistros = EquipoData::totalRegistro1($club);
    $totalRegistrosFiltrados = EquipoData::totalRegistrosFiltrados1($club, $search);
    
    $response = array(
        "draw" => intval($_REQUEST['draw']),
        "recordsTotal" => $totalRegistros,
        "recordsFiltered" => $totalRegistrosFiltrados,
        "data" => $contenidoporpagina
    );
    
    echo json_encode($response);
    exit;
} ?>
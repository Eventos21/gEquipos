<?php 
if ($_GET['action'] == 'apimequipos') {
    $start = $_REQUEST['start'];
    $length = $_REQUEST['length'];
    $search = $_REQUEST['search']['value'];
    $club = $_GET['club'];
    
    $contenidoporpagina = EquipoData::vercontenidoPaginado3($club, $start, $length, $search);
    $totalRegistros = EquipoData::totalRegistro3($club);
    $totalRegistrosFiltrados = EquipoData::totalRegistrosFiltrados3($club, $search);
    
    $response = array(
        "draw" => intval($_REQUEST['draw']),
        "recordsTotal" => $totalRegistros,
        "recordsFiltered" => $totalRegistrosFiltrados,
        "data" => $contenidoporpagina
    );
    
    echo json_encode($response);
    exit;
} ?>
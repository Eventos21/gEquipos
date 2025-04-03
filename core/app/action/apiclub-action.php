<?php 
if ($_GET['action'] == 'apiclub') {
    $start = $_REQUEST['start'];
    $length = $_REQUEST['length'];
    $search = $_REQUEST['search']['value'];
    
    $contenidoporpagina = ClubData::vercontenidoPaginado($start, $length, $search);
    $totalRegistros = ClubData::totalRegistro();
    $totalRegistrosFiltrados = ClubData::totalRegistrosFiltrados($search);
    
    $response = array(
        "draw" => intval($_REQUEST['draw']),
        "recordsTotal" => $totalRegistros,
        "recordsFiltered" => $totalRegistrosFiltrados,
        "data" => $contenidoporpagina
    );
    
    echo json_encode($response);
    exit;
} ?>
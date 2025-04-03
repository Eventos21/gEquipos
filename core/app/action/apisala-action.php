<?php 
if ($_GET['action'] == 'apisala') {
    $start = $_REQUEST['start'];
    $length = $_REQUEST['length'];
    $search = $_REQUEST['search']['value'];
    
    $contenidoporpagina = SalaData::vercontenidoPaginado($start, $length, $search);
    $totalRegistros = SalaData::totalRegistro();
    $totalRegistrosFiltrados = SalaData::totalRegistrosFiltrados($search);
    
    $response = array(
        "draw" => intval($_REQUEST['draw']),
        "recordsTotal" => $totalRegistros,
        "recordsFiltered" => $totalRegistrosFiltrados,
        "data" => $contenidoporpagina
    );
    
    echo json_encode($response);
    exit;
} ?>
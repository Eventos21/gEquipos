<?php 
if ($_GET['action'] == 'apiliga') {
    $start = $_REQUEST['start'];
    $length = $_REQUEST['length'];
    $search = $_REQUEST['search']['value'];
    
    $contenidoporpagina = LigaData::vercontenidoPaginado($start, $length, $search);
    $totalRegistros = LigaData::totalRegistro();
    $totalRegistrosFiltrados = LigaData::totalRegistrosFiltrados($search);

    $response = array(
        "draw" => intval($_REQUEST['draw']),
        "recordsTotal" => $totalRegistros,
        "recordsFiltered" => $totalRegistrosFiltrados,
        "data" => $contenidoporpagina
    );
    
    echo json_encode($response);
    exit;
} ?>
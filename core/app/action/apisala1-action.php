<?php 
if ($_GET['action'] == 'apisala1') {
    $start = $_REQUEST['start'];
    $length = $_REQUEST['length'];
    $search = $_REQUEST['search']['value'];
    
    $contenidoporpagina = SalaData::vercontenidoPaginado1($start, $length, $search);
    $totalRegistros = SalaData::totalRegistro1();
    $totalRegistrosFiltrados = SalaData::totalRegistrosFiltrados1($search);
    
    $response = array(
        "draw" => intval($_REQUEST['draw']),
        "recordsTotal" => $totalRegistros,
        "recordsFiltered" => $totalRegistrosFiltrados,
        "data" => $contenidoporpagina
    );
    
    echo json_encode($response);
    exit;
} ?>
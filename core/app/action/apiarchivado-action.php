<?php 
if ($_GET['action'] == 'apiarchivado') {
    $start = $_REQUEST['start'];
    $length = $_REQUEST['length'];
    $search = $_REQUEST['search']['value'];
    
    $contenidoporpagina = TemporadaData::vercontenidoPaginado1($start, $length, $search);
    $totalRegistros = TemporadaData::totalRegistro1();
    $totalRegistrosFiltrados = TemporadaData::totalRegistrosFiltrados1($search);

    $response = array(
        "draw" => intval($_REQUEST['draw']),
        "recordsTotal" => $totalRegistros,
        "recordsFiltered" => $totalRegistrosFiltrados,
        "data" => $contenidoporpagina
    );
    
    echo json_encode($response);
    exit;
} ?>
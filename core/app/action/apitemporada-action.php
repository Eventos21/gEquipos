<?php 
if ($_GET['action'] == 'apitemporada') {
    $start = $_REQUEST['start'];
    $length = $_REQUEST['length'];
    $search = $_REQUEST['search']['value'];
    
    $contenidoporpagina = TemporadaData::vercontenidoPaginado($start, $length, $search);
    $totalRegistros = TemporadaData::totalRegistro();
    $totalRegistrosFiltrados = TemporadaData::totalRegistrosFiltrados($search);

    $response = array(
        "draw" => intval($_REQUEST['draw']),
        "recordsTotal" => $totalRegistros,
        "recordsFiltered" => $totalRegistrosFiltrados,
        "data" => $contenidoporpagina
    );
    
    echo json_encode($response);
    exit;
} ?>
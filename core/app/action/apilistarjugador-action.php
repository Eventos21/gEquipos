<?php 
if ($_GET['action'] == 'apilistarjugador') {
    $start = $_REQUEST['start'];
    $length = $_REQUEST['length'];
    $search = $_REQUEST['search']['value'];
    
    $contenidoporpagina = JugadorData::vercontenidoPaginado3($start, $length, $search);
    $totalRegistros = JugadorData::totalRegistro3();
    $totalRegistrosFiltrados = JugadorData::totalRegistrosFiltrados3($search);
    
    $response = array(
        "draw" => intval($_REQUEST['draw']),
        "recordsTotal" => $totalRegistros,
        "recordsFiltered" => $totalRegistrosFiltrados,
        "data" => $contenidoporpagina
    );
    
    echo json_encode($response);
    exit;
} ?>
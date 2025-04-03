<?php 
if ($_GET['action'] == 'apisusclubes') {
    $start = $_REQUEST['start'];
    $length = $_REQUEST['length'];
    $search = $_REQUEST['search']['value'];
    $liga = $_GET['id'];

    
    $contenidoporpagina = ligaUsuarioData::vercontenidoPaginado1($liga, $start, $length, $search);
    $totalRegistros = ligaUsuarioData::totalRegistro1($liga);
    $totalRegistrosFiltrados = ligaUsuarioData::totalRegistrosFiltrados1($liga, $search);
    
    $response = array(
        "draw" => intval($_REQUEST['draw']),
        "recordsTotal" => $totalRegistros,
        "recordsFiltered" => $totalRegistrosFiltrados,
        "data" => $contenidoporpagina
    );
    
    echo json_encode($response);
    exit;
} ?>
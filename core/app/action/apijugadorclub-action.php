<?php 
if ($_GET['action'] == 'apijugadorclub') {
    $start = $_REQUEST['start'];
    $length = $_REQUEST['length'];
    $search = $_REQUEST['search']['value'];
    $club = $_GET['tid'];
    $clubes = ClubData::verid($club);
    $codigo=$clubes->codigo;
    
    $contenidoporpagina = JugadorData::vercontenidoPaginado1($codigo, $start, $length, $search);
    $totalRegistros = JugadorData::totalRegistro1($codigo);
    $totalRegistrosFiltrados = JugadorData::totalRegistrosFiltrados1($codigo, $search);

    $response = array(
        "draw" => intval($_REQUEST['draw']),
        "recordsTotal" => $totalRegistros,
        "recordsFiltered" => $totalRegistrosFiltrados,
        "data" => $contenidoporpagina
    );
    
    echo json_encode($response);
    exit;
} ?>
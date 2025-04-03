<?php 
if ($_GET['action'] == 'apijugadorporclub') {
    $start = $_REQUEST['start'];
    $length = $_REQUEST['length'];
    $search = $_REQUEST['search']['value'];
    $club = $_GET['tid'];
    $liga = $_GET['liga'];
    $clubes = ClubData::verid($club);
    $codigo=$clubes->codigo;
    
    $contenidoporpagina = JugadorData::vercontenidoPaginado2($codigo, $start, $length, $search);
    $totalRegistros = JugadorData::totalRegistro2($codigo);
    $totalRegistrosFiltrados = JugadorData::totalRegistrosFiltrados2($codigo, $search);

    foreach ($contenidoporpagina as $jugador) {
        $jugador->numeroqueparticipa = JugadorData::cantidadvecesparticipa($jugador->id, $liga);
    }
    $response = array(
        "draw" => intval($_REQUEST['draw']),
        "recordsTotal" => $totalRegistros,
        "recordsFiltered" => $totalRegistrosFiltrados,
        "data" => $contenidoporpagina
    );
    
    echo json_encode($response);
    exit;
} ?>
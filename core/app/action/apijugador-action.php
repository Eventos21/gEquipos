<?php 
if ($_GET['action'] == 'apijugador') {
    $start = $_REQUEST['start'];
    $length = $_REQUEST['length'];
    $search = $_REQUEST['search']['value'];
    $liga = $_GET['liga'];
    
    $contenidoporpagina = JugadorData::vercontenidoPaginado($start, $length, $search);
    $totalRegistros = JugadorData::totalRegistro();
    $totalRegistrosFiltrados = JugadorData::totalRegistrosFiltrados($search);

    // Obtener el número de participaciones para cada jugador
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
} 
?>
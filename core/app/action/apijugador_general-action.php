<?php 
$actions = $_GET['actions'];
if ($actions==1) {
   if ($_GET['action'] == 'apijugador_general') {
        $start = $_REQUEST['start'];
        $length = $_REQUEST['length'];
        $search = $_REQUEST['search']['value'];
        $contenidoporpagina = JugadorData::vercontenidoPaginado($start, $length, $search);
        $totalRegistros = JugadorData::totalRegistro();
        $totalRegistrosFiltrados = JugadorData::totalRegistrosFiltrados($search);
        $response = array(
            "draw" => intval($_REQUEST['draw']),
            "recordsTotal" => $totalRegistros,
            "recordsFiltered" => $totalRegistrosFiltrados,
            "data" => $contenidoporpagina
        );
        
        echo json_encode($response);
        exit;
    } 
}
if ($actions==2) {
    if ($_GET['action'] == 'apijugador_general') {
        $start = $_REQUEST['start'];
        $length = $_REQUEST['length'];
        $search = $_REQUEST['search']['value'];
        $jugador = $_GET['usuario'];

        $contenidoporpagina = JugadorData::vercontenidoPaginado4($jugador, $start, $length, $search);
        $totalRegistros = JugadorData::totalRegistro4($jugador);
        $totalRegistrosFiltrados = JugadorData::totalRegistrosFiltrados4($jugador, $search);
        $response = array(
            "draw" => intval($_REQUEST['draw']),
            "recordsTotal" => $totalRegistros,
            "recordsFiltered" => $totalRegistrosFiltrados,
            "data" => $contenidoporpagina
        );
        
        echo json_encode($response);
        exit;
    }
}
?>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
ini_set('display_errors', 0);
error_reporting(0);

if (isset($_GET['action']) && $_GET['action'] == 'apijugadorporclub2') {
    $start  = isset($_GET['start']) ? intval($_GET['start']) : 0;
    $length = isset($_GET['length']) ? intval($_GET['length']) : 10;
    $search = isset($_GET['search']['value']) ? addslashes($_GET['search']['value']) : '';
    
    // En este nuevo endpoint, obtenemos el valor del club desde la sesión
    $club = isset($_SESSION['club']) ? $_SESSION['club'] : '';
    
    // En la tabla jugador, el campo "club" contiene el código alfabético.
    $codigo = $club;
    
    // Utiliza los métodos del modelo que filtren por el código del club
    $contenidoporpagina = JugadorData::vercontenidoPaginado2($codigo, $start, $length, $search);
    $totalRegistros = JugadorData::totalRegistro2($codigo);
    $totalRegistrosFiltrados = JugadorData::totalRegistrosFiltrados2($codigo, $search);
    
    // Si se requiere, puedes calcular datos adicionales para cada jugador aquí.
    
    $draw = isset($_GET['draw']) ? intval($_GET['draw']) : 0;
    $response = array(
         "draw" => $draw,
         "recordsTotal" => intval($totalRegistros),
         "recordsFiltered" => intval($totalRegistrosFiltrados),
         "data" => $contenidoporpagina
    );
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>

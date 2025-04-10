<?php 
if ($_GET['action'] == 'apimequipo') {
    $start = isset($_REQUEST['start']) ? intval($_REQUEST['start']) : 0;
    $length = isset($_REQUEST['length']) ? intval($_REQUEST['length']) : 10;
    $search = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
    $club = isset($_GET['club']) ? $_GET['club'] : 0;
    
    $contenidoporpagina = EquipoData::vercontenidoPaginado1($club, $start, $length, $search);
    $totalRegistros = EquipoData::totalRegistro1($club);
    $totalRegistrosFiltrados = EquipoData::totalRegistrosFiltrados1($club, $search);
    
    $response = array(
        "draw" => isset($_REQUEST['draw']) ? intval($_REQUEST['draw']) : 0,
        "recordsTotal" => $totalRegistros,
        "recordsFiltered" => $totalRegistrosFiltrados,
        "data" => $contenidoporpagina
    );
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>

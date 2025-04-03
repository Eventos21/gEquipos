<?php 
if ($_GET['action'] == 'apiusuarios') {
    $start = $_REQUEST['start'];
    $length = $_REQUEST['length'];
    $search = $_REQUEST['search']['value'];
    
    $contenidoporpagina = UserData::vercontenidoPaginado($start, $length, $search);
    $totalRegistros = UserData::totalRegistro();
    $totalRegistrosFiltrados = UserData::totalRegistrosFiltrados($search);
    
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
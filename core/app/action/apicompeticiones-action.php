<?php 
if ($_GET['action'] == 'apicompeticiones') {
    $start = $_REQUEST['start'];
    $length = $_REQUEST['length'];
    $search = $_REQUEST['search']['value'];
    
    $contenidoporpagina = CompeticionData::vercontenidoPaginado($start, $length, $search);
    $totalRegistros = CompeticionData::totalRegistro();
    $totalRegistrosFiltrados = CompeticionData::totalRegistrosFiltrados($search);
    
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
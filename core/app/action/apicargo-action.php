<?php 
if ($_GET['action'] == 'apicargo') {
    $start = $_REQUEST['start'];
    $length = $_REQUEST['length'];
    $search = $_REQUEST['search']['value'];
    
    $contenidoporpagina = CargoData::vercontenidoPaginado($start, $length, $search);
    $totalRegistros = CargoData::totalRegistro();
    $totalRegistrosFiltrados = CargoData::totalRegistrosFiltrados($search);
    
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
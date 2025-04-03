<?php 
if ($_GET['action'] == 'apiequipo') {
    $start = $_REQUEST['start'];
    $length = $_REQUEST['length'];
    $search = $_REQUEST['search']['value'];
    
    $contenidoporpagina = EquipoData::vercontenidoPaginado($start, $length, $search);
    $totalRegistros = EquipoData::totalRegistro();
    $totalRegistrosFiltrados = EquipoData::totalRegistrosFiltrados($search);
    
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
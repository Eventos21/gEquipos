<?php 
if ($_GET['action'] == 'apifederacion') {
    $start = $_REQUEST['start'];
    $length = $_REQUEST['length'];
    $search = $_REQUEST['search']['value'];
    
    $contenidoporpagina = EquipoData::vercontenidoPaginado2($start, $length, $search);
    $totalRegistros = EquipoData::totalRegistro2();
    $totalRegistrosFiltrados = EquipoData::totalRegistrosFiltrados2($search);
    
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
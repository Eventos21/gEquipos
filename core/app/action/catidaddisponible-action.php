<?php
if (isset($_GET['liga']) && isset($_GET['club'])) {
    $liga = $_GET['liga'];
    $club = $_GET['club'];
    $datos = obtenerDatos($liga, $club);
    
    // Calcula la cantidad de registros
    $registros = count(EquipoData::vercontenidos_por_liga_club($liga, $club));
    
    // Resta la cantidad de registros de la cantidad original
    $datos['cantidad'] -= $registros;
    
    // Devuelve los datos como JSON
    echo json_encode($datos);
} else {
    http_response_code(400);
    echo json_encode(array('error' => 'Parámetros incompletos'));
}

function obtenerDatos($liga, $club) {
    $datos = array();
    $ligaUsuarioData = ligaUsuarioData::verid_lista($liga, $club);
    $datos['cantidad'] = $ligaUsuarioData->cantidad;
    $datos['id'] = $ligaUsuarioData->id;
    return $datos;
}
?>

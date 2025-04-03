<?php
if (isset($_GET['action']) && $_GET['action'] == 'apilistarequipos_liga' && isset($_GET['liga'])) {
    $ligaId = intval($_GET['liga']);
    // $equipos = EquipoData::vercontenidos_por_liga($ligaId);
    $equipos = EquipoData::vercontenidos_por_competicion($ligaId);

    $response = array();
    foreach ($equipos as $equipo) {
        $response[] = array('id' => $equipo->id, 'nombre' => $equipo->nombre);
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
} ?>
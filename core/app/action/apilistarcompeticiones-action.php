<?php
if ($_GET['action'] == 'apilistarcompeticiones') {
    $liga = $_GET['especialidadId'];
    $datos= CompeticionData::vercontenidos_lista($liga);
    echo json_encode($datos);
    exit;
} ?>
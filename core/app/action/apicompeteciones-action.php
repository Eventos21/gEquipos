<?php
if ($_GET['action'] == 'apicompeteciones') {
    $liga = $_GET['especialidadId'];
    $datos= CompeticionData::vercontenidos_lista($liga);
    echo json_encode($datos);
    exit;
} ?>
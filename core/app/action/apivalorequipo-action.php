<?php
if ($_GET['action'] == 'apivalorequipo') {
    $sala = $_GET['sala'];
    $datos = ValorEquipoData::vercontenido_sala($sala);
    echo json_encode($datos);
    exit;
} ?>
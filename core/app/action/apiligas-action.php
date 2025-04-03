<?php
if ($_GET['action'] == 'apiligas') {
    $datos = LigaData::vercontenidos();
    echo json_encode($datos);
    exit;
} ?>
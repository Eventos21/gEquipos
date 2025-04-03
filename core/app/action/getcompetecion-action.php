<?php if ($_GET['action'] == 'getcompetecion') {
    $id = $_GET['id'];
    $datos = CompeticionData::verid($id);
    echo json_encode($datos);
    exit;
} ?>
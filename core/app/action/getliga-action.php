<?php if ($_GET['action'] == 'getliga') {
    $id = $_GET['id'];
    $datos = LigaData::verid($id);
    echo json_encode($datos);
    exit;
} ?>
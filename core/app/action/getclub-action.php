<?php if ($_GET['action'] == 'getclub') {
    $id = $_GET['id'];
    $datos = ClubData::verid($id);
    echo json_encode($datos);
    exit;
} ?>
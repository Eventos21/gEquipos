<?php if ($_GET['action'] == 'getsala') {
    $id = $_GET['id'];
    $datos = SalaData::verid($id);
    echo json_encode($datos);
    exit;
} ?>
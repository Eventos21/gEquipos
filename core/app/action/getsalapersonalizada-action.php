<?php if ($_GET['action'] == 'getsalapersonalizada') {
    $id = $_GET['id'];
    $datos = SalaPersonalizadaData::verid($id);
    echo json_encode($datos);
    exit;
} ?>
<?php if ($_GET['action'] == 'getequipo') {
    $id = $_GET['id'];
    $datos = EquipoData::verid($id);
    echo json_encode($datos);
    exit;
} ?>
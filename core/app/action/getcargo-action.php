<?php if ($_GET['action'] == 'getcargo') {
    $id = $_GET['id'];
    $cargos = CargoData::verid($id);
    echo json_encode($cargos);
    exit;
} ?>
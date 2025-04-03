<?php if ($_GET['action'] == 'gettempora') {
    $id = $_GET['id'];
    $cliente = TemporadaData::verid($id);
    echo json_encode($cliente);
    exit;
} ?>
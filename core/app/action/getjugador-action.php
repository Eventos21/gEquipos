<?php if ($_GET['action'] == 'getjugador') {
    $id = $_GET['id'];
    $cliente = JugadorData::verid($id);
    echo json_encode($cliente);
    exit;
} ?>
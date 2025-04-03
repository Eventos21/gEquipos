<?php if ($_GET['action'] == 'getusuario') {
    $id = $_GET['id'];
    $cliente = UserData::verid($id);
    echo json_encode($cliente);
    exit;
} ?>
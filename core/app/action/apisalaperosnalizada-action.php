<?php
if ($_GET['action'] == 'apisalaperosnalizada') {
    $sala = $_GET['sala'];
    $datos = SalaPersonalizadaData::Listarencuentro($sala);
    echo json_encode($datos);
    exit;
}
?>
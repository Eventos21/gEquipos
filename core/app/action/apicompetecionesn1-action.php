<?php
if ($_GET['action'] == 'apicompetecionesn1') {
    $sala=$_GET['id'];
    $datas = CompetenciasData::vercontenidos1($sala);
    echo json_encode($datas);
    exit;
} ?>
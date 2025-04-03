<?php
if ($_GET['action'] == 'apicompetecionesn') {
    $sala=$_GET['id'];
    $datas = CompetenciasData::vercontenidos($sala);
    echo json_encode($datas);
    exit;
} ?>
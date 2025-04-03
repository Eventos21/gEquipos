<?php
if ($_GET['action'] == 'apitemporadas') {
    $datos = TemporadaData::vercontenidos();
    echo json_encode($datos);
    exit;
} ?>
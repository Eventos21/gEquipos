<?php
if ($_GET['action'] == 'apiusuarioclub') {
    $club=$_GET['club'];
    $cargos = UserData::vercontenido_x_club($club);
    echo json_encode($cargos);
    exit;
} ?>
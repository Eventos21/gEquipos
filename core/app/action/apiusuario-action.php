<?php
if ($_GET['action'] == 'apiusuario') {
    $cargos = UserData::vercontenido();
    echo json_encode($cargos);
    exit;
} ?>
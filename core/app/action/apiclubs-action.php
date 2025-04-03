<?php
if ($_GET['action'] == 'apiclubs') {
    $cargos = ClubData::vercontenido();
    echo json_encode($cargos);
    exit;
}
 ?>
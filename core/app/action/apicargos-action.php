<?php
if ($_GET['action'] == 'apicargos') {
    $cargos = CargoData::vercontenido();
    echo json_encode($cargos);
    exit;
}
 ?>
<?php
if ($_GET['action'] == 'apitipocompeticiones') {
    $cargos = TipoCompeticionData::vercontenido();
    echo json_encode($cargos);
    exit;
}
 ?>
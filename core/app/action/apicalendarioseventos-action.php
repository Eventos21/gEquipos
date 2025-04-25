
<?php
if ($_GET['action'] == 'apicalendarioseventos') {
    $datos = SalaPersonalizadaData::eventoslista();
    $datos1 = CompetenciasData::vercontenidos2();
    $registrosCombinados = array_merge($datos, $datos1);
    echo json_encode($registrosCombinados);
    exit;
} ?>

<?php
if ($_GET['action'] == 'cantidadvecesparticipa') {
    if (!isset($_GET['jugador'])) {
        echo json_encode(array('error' => 'No se proporcionó el ID del jugador.'));
        exit;
    }
    $jugadorId = $_GET['jugador'];
    $participaciones = EquipoJugadorData::cantidadvecesparticipa($jugadorId);
    echo json_encode($participaciones);
    exit;
} ?>

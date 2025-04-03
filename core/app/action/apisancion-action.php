<?php 
if ($_GET['action'] == 'apisancion') {
    $sala = $_GET['sala'];
    $equipo = $_GET['equipo'];

    // Obtener el contenido de sancion para la sala y equipo especificados
    $sancionData = SancionData::verid1($sala, $equipo);

    if ($sancionData) {
        // Si se encuentra, devolver los datos en formato JSON
        header('Content-Type: application/json');
        echo json_encode($sancionData);
    } else {
        // Si no se encuentra, devolver un array vacío
        header('Content-Type: application/json');
        echo json_encode([]);
    }

    exit;
}
?>
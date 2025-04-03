<?php 
if ($_POST['action'] == 'updatesancion') {
    $sala = $_POST['sala'];
    $equipo = $_POST['equipo'];
    $sancion = $_POST['sancion'];

    // Verificar duplicidad
    $existingRecords = SancionData::duplicidad($sala, $equipo);

    if (count($existingRecords) > 0) {
        // Actualizar sanción existente
        $UpdateSancion = new SancionData();
        $UpdateSancion->sala = $sala;
        $UpdateSancion->equipo = $equipo;
        $UpdateSancion->sancion = $sancion;
        $UpdateSancion->actualizar();
        echo json_encode(['status' => 'updated']);
    } else {
        // Registrar nueva sanción
        $newSancion = new SancionData();
        $newSancion->sala = $sala;
        $newSancion->equipo = $equipo;
        $newSancion->sancion = $sancion;
        $newSancion->registro();
        echo json_encode(['status' => 'inserted']);
    }

    exit;
}
 ?>
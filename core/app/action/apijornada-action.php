<?php
if (isset($_GET['action']) && $_GET['action'] == 'apijornada') {
    header('Content-Type: application/json');

    $fecha = isset($_GET['fecha']) ? $_GET['fecha'] : null;
    $fechas = $fecha ? $fecha : date("Y-m-d");
    
    $data = SalaData::vercontenidos3_3($fechas);
    $response = array();
    $competitions = array();

    foreach ($data as $row) {
        if (!isset($competitions[$row->nombregrupo])) {
            $competitions[$row->nombregrupo] = array();
        }

        // Verificar si resultado_a y resultado_b son null y asignarles 0 en ese caso
        $resultado_a = $row->resultado_a === null ? 0 : $row->resultado_a;
        $resultado_b = $row->resultado_b === null ? 0 : $row->resultado_b;

        $competitions[$row->nombregrupo][] = array(
            'nombregrupo' => $row->nombregrupo,
            'competicion' => $row->competicion,
            'sala_codigo' => $row->sala_codigo,
            'equipo_a' => $row->equipo_a,
            'equipo_b' => $row->equipo_b,
            'fecha_encuentro' => $row->fecha_encuentro,
            'estado_a' => $row->estado_a,
            'resultado_a' => $resultado_a,  // Usar la variable modificada
            'estado_b' => $row->estado_b,
            'resultado_b' => $resultado_b,  // Usar la variable modificada
            'competencia_id' => $row->competencia_id,
            'nombrequipo_a' => $row->nombrequipo_a,
            'nombrequipo_b' => $row->nombrequipo_b,
            'aprobacion' => $row->aprobacion,
            'usuario' => $row->usuario,
            'firma_a' => $row->firma_a,
            'observacion_b' => $row->observacion_b,
            'firma_b' => $row->firma_b
        );
    }
    $response = array('data' => $competitions);
    echo json_encode($response);
    exit;
}
?>
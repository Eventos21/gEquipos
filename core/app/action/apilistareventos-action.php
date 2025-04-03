<?php 
if (isset($_GET['action']) && $_GET['action'] == 'apilistareventos') {
    header('Content-Type: application/json');
    $fecha = $_GET['fecha'];

    // Obtener datos del primer modelo
    $data = SalaPersonalizadaData::vercontenidos4($fecha);
    $competitions = array();

    foreach ($data as $row) {
        if (!isset($competitions[$row->nombregrupo])) {
            $competitions[$row->nombregrupo] = array();
        }

        $resultado_a = $row->puntajea ?? 0;
        $resultado_b = $row->puntajeb ?? 0;

        $competitions[$row->nombregrupo][] = array(
            'tipo' => 'SalaPersonalizada', // Identificar el origen
            'nombregrupo' => $row->nombregrupo,
            'sala' => $row->sala,
            'ronda' => $row->ronda,
            'encuentro' => $row->encuentro,
            'equipo_competidor' => $row->equipo_competidor,
            'id_competidor' => $row->id_competidor,
            'equipo_rival' => $row->equipo_rival,
            'id_rival' => $row->id_rival,
            'fecha' => $row->fecha, 
            'resultado_a' => $resultado_a,
            'observaciona' => $row->observaciona,
            'firmaa' => $row->firmaa,
            'resultado_b' => $resultado_b,
            'observacionb' => $row->observacionb,
            'firmab' => $row->firmab,
            'usuario' => $row->usuario,
            'arbitro' => $row->arbitro,
            'observacion_arbitro' => $row->observacion_arbitro,
            'firma_arbitro' => $row->firma_arbitro,
            'observacion_fma' => $row->obervacion_fma,
            'aprobacion' => $row->aprobacion,
            'id' => $row->id,
            'usuarios' => $row->usuarios,
            'equipoa' => $row->equipoa,
            'equipob' => $row->equipob,
            'adicional' => $row->adicional
        );
    }

    // Obtener datos del segundo modelo
    $data1 = SalaData::vercontenidos3_3($fecha);

    foreach ($data1 as $row) {
        if (!isset($competitions[$row->nombregrupo])) {
            $competitions[$row->nombregrupo] = array();
        }

        $resultado_a = $row->resultado_a ?? 0;
        $resultado_b = $row->resultado_b ?? 0;

        $competitions[$row->nombregrupo][] = array(
            'tipo' => 'Sala', // Identificar el origen
            'nombregrupo' => $row->nombregrupo,
            'competicion' => $row->competicion,
            'sala_codigo' => $row->sala_codigo,
            'equipo_a' => $row->equipo_a,
            'equipo_b' => $row->equipo_b,
            'fecha_encuentro' => $row->fecha_encuentro,
            'estado_a' => $row->estado_a,
            'resultado_a' => $resultado_a,
            'estado_b' => $row->estado_b,
            'resultado_b' => $resultado_b,
            'id' => $row->competencia_id,
            'equipoa' => $row->nombrequipo_a,
            'equipob' => $row->nombrequipo_b,
            'aprobacion' => $row->aprobacion,
            'usuarios' => $row->usuario,
            'firma_a' => $row->firma_a,
            'observacion_b' => $row->observacion_b,
            'firma_b' => $row->firma_b,
            'adicional' => $row->adicional
        );
    }

    // Preparar la respuesta en formato JSON
    $response = array('data' => $competitions);
    echo json_encode($response);
    exit;
}
 ?>
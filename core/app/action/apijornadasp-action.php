<?php 
if (isset($_GET['action']) && $_GET['action'] == 'apijornadasp') {
    header('Content-Type: application/json');
    $fecha = $_GET['fecha'];

    // Llamada al modelo para obtener los datos
    $data = SalaPersonalizadaData::vercontenidos5($fecha);
    $competitions = array();

    foreach ($data as $row) {
        // Agrupar por nombre del grupo
        if (!isset($competitions[$row->nombregrupo])) {
            $competitions[$row->nombregrupo] = array();
        }

        // Verificar si resultado_a y resultado_b son null y asignarles 0 en ese caso
        $resultado_a = $row->puntajea ?? 0;
        $resultado_b = $row->puntajeb ?? 0;

        // Agregar los detalles del encuentro al grupo correspondiente
        $competitions[$row->nombregrupo][] = array(
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
            'equipoa' => $row->equipoa,  // Nombre del equipo A
            'equipob' => $row->equipob   // Nombre del equipo B
        );
    }

    // Preparar la respuesta en formato JSON
    $response = array('data' => $competitions);
    echo json_encode($response);
    exit;
}
 ?>
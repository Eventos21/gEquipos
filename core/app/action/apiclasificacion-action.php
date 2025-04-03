<?php
if ($_GET['action'] == 'apiclasificacion') {
    $datas = SalaData::clasificacion3();
$result = [];
$current_sala_id = null;

    foreach ($datas as $data) {
        // Cuando se cambia la sala, agregamos una fila separadora con el encabezado de la Liga/Categoría/Grupo.
        if ($data->sala != $current_sala_id) {
            $current_sala_id = $data->sala;
            $salas = SalaData::verid1($current_sala_id);
            if ($current_sala_id !== null) {
                $result[] = [
                    'sala_sort'    => $current_sala_id, // Clave para ordenar por sala
                    'sala_id'      =>  $salas->nombreligas . ' - ' . $salas->nombregrupo . ' - Grupo: ' . $salas->grupo,
                    'is_separator' => true // Indicador de separador
                ];
            }
        }

    // Obtener los rivales del equipo actual
    $rivales = CompetenciasData::listarrivales($data->sala, $data->equipo);
    $puntos_total_rival = 0;

    // Sumar los puntos de los rivales
    foreach ($rivales as $rival) {
        foreach ($datas as $d) {
            if ($d->equipo == $rival->rival && $d->sala == $data->sala) {
                $puntos_total_rival += ($d->puntos*$rival->total_accion);
                break;
            }
        }
    }

    // Agregar los datos del equipo al resultado
    $result[] = [
        'sala_sort'           => $data->sala, // Clave para ordenar por sala
        'sala_id' => $data->sala,
        'estado' => $data->estado,
        'equipo' => $data->equipo,
        'veces_jugadas' => $data->veces_jugadas,
        'victorias' => $data->victorias,
        'empates' => $data->empates,
        'derrotas' => $data->derrotas,
        'incomparecencias' => $data->incomparecencias,
        'puntos' => $data->puntos, // Puntos del equipo
        'olimpico' => $data->olimpico,
        // 'sonnenborg_berger' => $data->sonnenborg_berger,
        'nomequipoa' => $data->nomequipoa,
        'nomequipob' => $data->nomequipob,
        'nomequipo' => $data->nomequipo,
        'sonnenborg_berger' => number_format(($puntos_total_rival) / 6, 3), // Suma de puntos de los rivales
        'is_separator' => false // No es un separador
    ];
}

    // Ordenar el array $result:
    usort($result, function($a, $b) {
        // Primero, ordenar por 'sala_sort' (ascendente)
        $salaA = isset($a['sala_sort']) ? intval($a['sala_sort']) : 0;
        $salaB = isset($b['sala_sort']) ? intval($b['sala_sort']) : 0;
        if ($salaA != $salaB) {
            return $salaA - $salaB;
        }
        
        // Dentro de la misma sala, colocar el separador primero
        if ((isset($a['is_separator']) && $a['is_separator']) && !(isset($b['is_separator']) && $b['is_separator'])) {
            return -1;
        } elseif ((isset($b['is_separator']) && $b['is_separator']) && !(isset($a['is_separator']) && $a['is_separator'])) {
            return 1;
        }
        
        // Para las filas de clasificación (no separadores), ordenar por:
        // Puntos (descendente), luego Olímpico (descendente), luego Sonnenborn-Berger (descendente)
        $puntos_a = isset($a['puntos']) ? floatval($a['puntos']) : 0;
        $puntos_b = isset($b['puntos']) ? floatval($b['puntos']) : 0;
        if ($puntos_a != $puntos_b) {
            return $puntos_b - $puntos_a;
        }
        $olimpico_a = isset($a['olimpico']) ? floatval($a['olimpico']) : 0;
        $olimpico_b = isset($b['olimpico']) ? floatval($b['olimpico']) : 0;
        if ($olimpico_a != $olimpico_b) {
            return $olimpico_b - $olimpico_a;
        }
        $sb_a = isset($a['sonnenborg_berger']) ? floatval($a['sonnenborg_berger']) : 0;
        $sb_b = isset($b['sonnenborg_berger']) ? floatval($b['sonnenborg_berger']) : 0;
        return $sb_b - $sb_a;
    });


echo json_encode($result);
exit;

}
?>
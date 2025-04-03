<?php
if ($_GET['action'] == 'apiclasificacion') {
    $datas = SalaData::clasificacion3();
$result = [];
$current_sala_id = null;

foreach ($datas as $data) {
    if ($data->sala != $current_sala_id) {
        $current_sala_id = $data->sala;
        $salas = SalaData::verid1($current_sala_id);
        if ($current_sala_id !== null) {
            $result[] = [
                'sala_id' =>  $salas->nombreligas . ' - ' . $salas->nombregrupo . ' - Grupo: ' . $salas->grupo,
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
        'sonnenborg_berger' => $data->sonnenborg_berger,
        'nomequipoa' => $data->nomequipoa,
        'nomequipob' => $data->nomequipob,
        'nomequipo' => $data->nomequipo,
        'sonnenborg_berger' => number_format(($puntos_total_rival) / 6, 3), // Suma de puntos de los rivales
        'is_separator' => false // No es un separador

    ];
}

echo json_encode($result);
exit;

}
?>
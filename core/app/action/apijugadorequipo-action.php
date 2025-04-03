<?php 
if ($_GET['action'] == 'apijugadorequipo') {
    $start = $_REQUEST['start'];
    $length = $_REQUEST['length'];
    $search = $_REQUEST['search']['value'];
    $equipo = $_GET['equipo'];
    $equipos= EquipoData::verid($equipo);
    $ligas = LigaData::verid($equipos->liga);
    $edad = $ligas->edad;
    if (strpos($edad, '-') !== false) {
        // Si la cadena contiene un guion "-", entonces es un rango
        $rango = true;
    } else {
        // Si no contiene un guion "-", entonces es un valor único
        $rango = false;
    }

    // Si es un rango, separar los valores mínimo y máximo
    if ($rango) {
        list($minEdad, $maxEdad) = explode('-', $edad);
        // Convertir los valores a números enteros si es necesario
        $minEdad = intval($minEdad);
        $maxEdad = intval($maxEdad);

        $contenidoporpagina = EquipoJugadorData::vercontenidoPaginado1($equipo,$minEdad,$maxEdad, $start, $length, $search);
        $totalRegistros = EquipoJugadorData::totalRegistro1($equipo,$minEdad,$maxEdad);
        $totalRegistrosFiltrados = EquipoJugadorData::totalRegistrosFiltrados1($equipo,$minEdad,$maxEdad, $search);

    } else {
        // Si no es un rango, el valor es la edad específica
        $edadEspecifica = intval($edad);
        $contenidoporpagina = EquipoJugadorData::vercontenidoPaginado2($equipo,$edadEspecifica, $start, $length, $search);
        $totalRegistros = EquipoJugadorData::totalRegistro2($equipo,$edadEspecifica);
        $totalRegistrosFiltrados = EquipoJugadorData::totalRegistrosFiltrados2($equipo,$edadEspecifica, $search);
    }

    $response = array(
        "draw" => intval($_REQUEST['draw']),
        "recordsTotal" => $totalRegistros,
        "recordsFiltered" => $totalRegistrosFiltrados,
        "data" => $contenidoporpagina
    );
    
    echo json_encode($response);
    exit;
}

 ?>
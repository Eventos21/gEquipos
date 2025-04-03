<?php
require 'excel/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['archivo'])) {
    // Ruta del archivo temporal
    $archivo = $_FILES['archivo']['tmp_name'];

    // Cargar el archivo Excel
    $spreadsheet = IOFactory::load($archivo);
    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

    // Iterar sobre las filas, comenzando desde la segunda fila (índice 1)
    foreach (array_slice($sheetData, 1) as $row) {
        $apellido1 = $row['A'];
        $apellido2 = $row['B'];
        $nombre = $row['C'];
        // $nacimiento = $row['D'];
        $nacimiento = date('Y-m-d', strtotime($row['D']));
        $numlicencia = $row['E'];
        $club = $row['F'];
        $codigofide = $row['G'];
        $elo = $row['H'];

        // Calcular el valor de duplicidad
        $duplicidad = $numlicencia . $apellido1 . $apellido2;

        // Verificar duplicidad
        if (!JugadorData::duplicidad($duplicidad)) {
            // Si no hay duplicidad, registrar el jugador
            $registro = new JugadorData();
            $registro->apellido1 = $apellido1;
            $registro->apellido2 = $apellido2;
            $registro->nombre = $nombre;
            $registro->nacimiento = $nacimiento;
            $registro->numlicencia = $numlicencia;
            $registro->club = $club;
            $registro->codigofide = $codigofide;
            $registro->elo = $elo;
            $registro->duplicidad = $duplicidad;
            $participante = $registro->registro();

            $registro1 = new EquipoJugadorData();
            $registro1->equipo=$_POST['tid'];
            $registro1->jugador=$participante[1];
            $registro1->registro();
        }
    }
    echo "Datos importados y registrados con éxito.";
} ?>
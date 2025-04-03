<?php
$id = $_POST['id'];
$encuentro = $_POST['encuentro'];
$columna_encuentro = null;
$columna_observacion = null;
$columna_firma = null;
$columna_archivo = null;

$descripcion = $_POST['observacion'];
$firma = $_POST['firma'];

$archivos = NULL;
if (isset($_FILES["archivo"]) && $_FILES["archivo"]["error"] == 0) {
        $archivo = $_FILES["archivo"]["name"];
        $target_dir = "storage/archivo/";
        $target_file = $target_dir . basename($archivo);
        if (!move_uploaded_file($_FILES["archivo"]["tmp_name"], $target_file)) {
        }
        $archivos = $archivo;
    } else {
        $archivos = $_POST['archivo1'];
    }
echo "$archivos";
$base = Database::getInstance();
$con = $base->getConnection();
$columnas = [
    'encuentro1_a' => ['observacion1_a', 'firma1_a', 'archivo1_a'],
    'encuentro1_b' => ['observacion1_b', 'firma1_b', 'archivo1_b'],
    'encuentro2_a' => ['observacion2_a', 'firma2_a', 'archivo2_a'],
    'encuentro2_b' => ['observacion2_b', 'firma2_b', 'archivo2_b'],
    'encuentro3_a' => ['observacion3_a', 'firma3_a', 'archivo3_a'],
    'encuentro3_b' => ['observacion3_b', 'firma3_b', 'archivo3_b'],
    'encuentro4_a' => ['observacion4_a', 'firma4_a', 'archivo4_a'],
    'encuentro4_b' => ['observacion4_b', 'firma4_b', 'archivo4_a'],
    'encuentro5_a' => ['observacion5_a', 'firma5_a', 'archivo5_a'],
    'encuentro5_b' => ['observacion5_b', 'firma5_b', 'archivo5_b'],
    'encuentro6_a' => ['observacion6_a', 'firma6_a', 'archivo6_a'],
    'encuentro6_b' => ['observacion6_b', 'firma6_b', 'archivo6_b'],
    'encuentro7_a' => ['observacion7_a', 'firma7_a', 'archivo7_a'],
    'encuentro7_b' => ['observacion7_b', 'firma7_b', 'archivo7_b'],
];

$consulta = "SELECT id, ";
foreach ($columnas as $encuentro_columna => $atributos) {
    $consulta .= "$encuentro_columna, ";
    foreach ($atributos as $atributo) {
        $consulta .= "$atributo, ";
    }
}
$consulta = rtrim($consulta, ', ');
$consulta .= " FROM competencias WHERE id = ?";
$stmt = $con->prepare($consulta);
$stmt->bind_param('i', $id);
$stmt->execute();
$resultado = $stmt->get_result();
$fila = $resultado->fetch_assoc();

if ($fila) {
    $encontrado = false;
    foreach ($columnas as $encuentro_columna => $atributos) {
        if ($fila[$encuentro_columna] == $encuentro) {
            $columna_encuentro = $encuentro_columna;
            $columna_observacion = $atributos[0];
            $columna_firma = $atributos[1];
            $columna_archivo = $atributos[2];
            
            // Actualizar el valor de la columna de observación y firma
            $update_sql = "UPDATE competencias SET $columna_observacion = ?, $columna_firma = ?, $columna_archivo = ?  WHERE id = ?";
            $update_stmt = $con->prepare($update_sql);
            $update_stmt->bind_param('sssi', $descripcion, $firma, $archivos, $id);
            if ($update_stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Valores actualizados correctamente."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error al actualizar los valores: " . $update_stmt->error]);
            }
            $update_stmt->close();

            $encontrado = true;
            break;
        }
    }
    if (!$encontrado) {
        echo json_encode(["status" => "error", "message" => "No se encontró el valor $encuentro en las columnas de encuentros."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "No se encontró el registro con ID $id."]);
}

$stmt->close();
$con->close();
?>
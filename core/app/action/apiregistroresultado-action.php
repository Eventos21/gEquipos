<!-- apiregistrofirmai -->
<?php
$id =$_POST['id'];
$encuentro = $_POST['encuentro'];
$columna_encuentro = null;
$columna_estado = null;
$columna_accion = null;
$resultado1 =$_POST['resultado1'];

$base = Database::getInstance();
$con = $base->getConnection();
$columnas = [
    'encuentro1_a' => ['estado1_a', 'accion1_a'],
    'encuentro1_b' => ['estado1_b', 'accion1_b'],
    'encuentro2_a' => ['estado2_a', 'accion2_a'],
    'encuentro2_b' => ['estado2_b', 'accion2_b'],
    'encuentro3_a' => ['estado3_a', 'accion3_a'],
    'encuentro3_b' => ['estado3_b', 'accion3_b'],
    'encuentro4_a' => ['estado4_a', 'accion4_a'],
    'encuentro4_b' => ['estado4_b', 'accion4_b'],
    'encuentro5_a' => ['estado5_a', 'accion5_a'],
    'encuentro5_b' => ['estado5_b', 'accion5_b'],
    'encuentro6_a' => ['estado6_a', 'accion6_a'],
    'encuentro6_b' => ['estado6_b', 'accion6_b'],
    'encuentro7_a' => ['estado7_a', 'accion7_a'],
    'encuentro7_b' => ['estado7_b', 'accion7_b'],
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
            $columna_estado = $atributos[0];
            $columna_accion = $atributos[1];
            
            // Actualizar el valor de la columna de acción
            $update_sql = "UPDATE competencias SET $columna_accion = ? WHERE id = ?";
            $update_stmt = $con->prepare($update_sql);
            $update_stmt->bind_param('si', $resultado1, $id);
            if ($update_stmt->execute()) {
                echo "El valor de $columna_accion se ha actualizado correctamente a $resultado1 para el ID $id.";
            } else {
                echo "Error al actualizar el valor de $columna_accion: " . $update_stmt->error;
            }
            $update_stmt->close();

            $encontrado = true;
            break;
        }
    }
    if (!$encontrado) {
        echo "No se encontró el valor $encuentro en las columnas de encuentros.";
    }
} else {
    echo "No se encontró el registro con ID $id.";
}

$stmt->close();
$con->close();
?>

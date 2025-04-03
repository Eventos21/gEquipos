<?php
session_start();
$codigoIngresado = $_POST['codigo'];
if(!isset($_COOKIE['verificationCode'])) {
    $_SESSION['error_message1'] = "El tiempo para validar el código ha expirado.";
    header("Location: index.php?view=login");
    exit;
}
if($codigoIngresado != $_COOKIE['verificationCode']) {
    $_SESSION['error_message1'] = "El código ingresado es incorrecto. Intente nuevamente.";
    header("Location: index.php?view=login");
    exit;
}
$_SESSION['conticomtc'] = $_COOKIE['posiblesesion'];
header("Location: index.php?view=index");
exit;
?>



<!-- // Conexión a la base de datos
$base = Database::getInstance();
$con = $base->getConnection();

// Verificar si la conexión es exitosa
if (!$con) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Consulta para obtener los datos de 'id' y 'numlicencia'
$sql = "SELECT id, numlicencia FROM jugador";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    // Procesar cada registro
    while($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $numlicencia = $row['numlicencia'];

        // Si el número de teléfono no está vacío
        if (!empty($numlicencia)) {
            // Generar el hash de la contraseña usando password_hash
            $password_hash = password_hash($numlicencia, PASSWORD_DEFAULT);

            // Actualizar el campo 'password' con el hash generado
            $update_sql = "UPDATE jugador SET password = ? WHERE id = ?";
            $stmt = $con->prepare($update_sql);
            $stmt->bind_param('si', $password_hash, $id);
            $stmt->execute();

            // Verificar si la actualización fue exitosa
            if ($stmt->affected_rows > 0) {
                echo "Contraseña encriptada para el jugador con ID: $id <br>";
            } else {
                echo "Error al actualizar el jugador con ID: $id <br>";
            }

            // Cerrar el statement para evitar errores
            $stmt->close();
        }
    }
} else {
    echo "No se encontraron registros en la tabla 'jugador'.";
}

// Cerrar la conexión
$con->close(); -->
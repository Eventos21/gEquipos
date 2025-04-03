<?php
$base = Database::getInstance();
$con = $base->getConnection();
$query = "SELECT id, numlicencia, telefono FROM jugador WHERE users IS NULL OR users = '' OR password IS NULL OR password = ''";
$result = $con->query($query);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $numlicencia = $row['numlicencia'];
        $telefono = $row['telefono'];
        if (!empty($numlicencia) && !empty($telefono)) {
            $usuario = $numlicencia; 
            $password = password_hash($telefono, PASSWORD_DEFAULT); 
            $updateQuery = "UPDATE jugador SET users = ?, password = ? WHERE id = ?";
            $stmt = $con->prepare($updateQuery);
            $stmt->bind_param("ssi", $usuario, $password, $id);
            
            if ($stmt->execute()) {
                echo "Jugador con ID $id actualizado exitosamente.<br>";
            } else {
                echo "Error al actualizar el jugador con ID $id: " . $stmt->error . "<br>";
            }
            
            $stmt->close();
        } else {
            echo "Datos insuficientes para el jugador con ID $id.<br>";
        }
    }
} else {
    echo "Error en la consulta: " . $con->error;
}
$con->close();
?>

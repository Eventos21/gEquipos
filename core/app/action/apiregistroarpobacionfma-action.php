<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $campo1 = $_POST['val1'];
    $campo2 = $_POST['val2'];
    $campo3 = $_POST['val3'];
    $observacion_fma = isset($_POST['observacion_fma']) ? $_POST['observacion_fma'] : '';
    $aprobacion = isset($_POST['aprobacion']) ? $_POST['aprobacion'] : '';
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $usuario = $_SESSION['conticomtc'];

    $base = Database::getInstance();
    $con = $base->getConnection();

    $update_sql = "UPDATE competencias SET $campo1 = ?, $campo2 = ?, $campo3 = ? WHERE id = ?";
    $update_stmt = $con->prepare($update_sql);
    $update_stmt->bind_param('ssii', $observacion_fma, $aprobacion, $usuario, $id);
    if ($update_stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Valores actualizados correctamente."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al actualizar los valores: " . $update_stmt->error]);
    }
    $update_stmt->close();

    // $model = new CompetenciasData(); // Instancia tu modelo
    // $model->obervacion_fma = $observacion_fma;
    // // $model->
    // $model->aprobacion = $aprobacion;
    // $model->id = $id;
    // $model->validararfma();
    echo json_encode(['status' => 'success']);
}
?>

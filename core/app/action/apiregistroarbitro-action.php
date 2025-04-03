<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $campo1 = $_POST['val1'];
    $campo2 = $_POST['val2'];
    $campo3 = $_POST['val3'];
    $arbitro = isset($_POST['arbitro']) ? $_POST['arbitro'] : '';
    $observacion_arbitro = isset($_POST['observacion_arbitro']) ? $_POST['observacion_arbitro'] : '';
    $firma_arbitro = isset($_POST['firma_arbitro']) ? $_POST['firma_arbitro'] : '';
    $id = isset($_POST['id']) ? $_POST['id'] : '';

    $base = Database::getInstance();
    $con = $base->getConnection();

    $update_sql = "UPDATE competencias SET $campo1 = ?, $campo2 = ?, $campo3 = ? WHERE id = ?";
    $update_stmt = $con->prepare($update_sql);
    $update_stmt->bind_param('sssi', $arbitro, $observacion_arbitro, $firma_arbitro, $id);
    if ($update_stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Valores actualizados correctamente."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al actualizar los valores: " . $update_stmt->error]);
    }
    $update_stmt->close();

    // $model = new CompetenciasData(); // Instancia tu modelo
    // $model->arbitro = $arbitro;
    // $model->observacion_arbitro = $observacion_arbitro;
    // $model->firma_arbitro = $firma_arbitro;
    // $model->id = $id;
    // $model->validararbitro();
    echo json_encode(['status' => 'success']);
}
?>

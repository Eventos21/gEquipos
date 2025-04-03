<?php 
$record_id = $_POST['id'];
    $resultado = $_POST['resultado'];
    $record = ActaData::verid($record_id);
    if ($record) {
        $record->resultado = $resultado;
        $record->actualizar_resultado();
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Record not found']);
    }
 ?>
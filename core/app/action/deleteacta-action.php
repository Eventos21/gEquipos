<?php 
$record_id = $_POST['id'];
    $record = ActaData::verid($record_id);
    if ($record) {
        $record->eliminar();
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Record not found']);
    }
 ?>
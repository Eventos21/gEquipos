<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Decodificar los datos JSON recibidos
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // Verifica si 'order' existe en el array decodificado
    if (isset($data['order']) && is_array($data['order'])) {
        $errores = [];
        $success = true;
        // Recorremos cada item del arreglo 'order' y actualizamos el campo 'orden'
        foreach ($data['order'] as $index => $item) {
            $equipoJugadorData = new EquipoJugadorData();
            $equipoJugadorData->id=$item['id'];
            $equipoJugadorData->orden=$index + 1;
            // $equipoJugadorData->nuevo=1;
            $equipoJugadorData->updatePlayerInfo();
            // if (!$equipoJugadorData->updatePlayerInfo()) {
            //         $errores[] = "Error al actualizar el jugador con ID: " . $item['id'];
            //         $success = false;
            //     }
        }

        $response = [
            'success' => $success,
            'errors' => $errores
        ];

        echo json_encode($response);
    } else {
        // Error: 'order' no fue enviado correctamente
        echo json_encode(['success' => false, 'message' => 'Datos no válidos']);
    }
} ?>
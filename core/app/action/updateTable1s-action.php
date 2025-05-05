<?php 
$sala_personalizada = $_POST['competencia_id'];
$equipo_id = $_POST['equipo_id'];
$datas = ActaData::vercontenidos1($sala_personalizada, $equipo_id);
$contador1 = 1;
foreach ($datas as $data) {
    echo '<tr>
        <td>' . $contador1++ . '</td>
        <td>' . $data->orden . '</td>
        <td>' . $data->codigofide . '</td>
        <td>' . $data->jugadores . '</td>';

    if ($data->jugador == "") {
        echo '<td>
                <select class="resultado-select" data-id="' . $data->id . '">
                    <option value="-" ' . ($data->resultado == '-' ? 'selected' : '') . '>-</option>
                </select>
              </td>'; 
    } else {
        echo '<td>
                <select class="resultado-select" data-id="' . $data->id . '">
                    <option value="">Elegir</option>
                    <option value="1" ' . ($data->resultado == '1' ? 'selected' : '') . '>1</option>
                    <option value="1/2" ' . ($data->resultado == '1/2' ? 'selected' : '') . '>1/2</option>
                    <option value="0" ' . ($data->resultado == '0' ? 'selected' : '') . '>0</option>
                    <option value="+" ' . ($data->resultado == '+' ? 'selected' : '') . '>+</option>
                    <option value="-" ' . ($data->resultado == '-' ? 'selected' : '') . '>-</option>
                </select>
              </td>';
    }

    echo '<td><a class="delete-btn btn btn-danger" data-id="' . $data->id . '">Limpiar</a></td>
    </tr>';
}
?>

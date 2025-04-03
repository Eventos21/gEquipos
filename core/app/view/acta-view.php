<style>
    .btn {
        font-size: 11px; 
        padding: 5px 10px; 
    }
    #customerTable1 th,
    #customerTable1 td,
    #customerTable2 th,
    #customerTable2 td,
    #customerTable3 th,
    #customerTable3 td,
    #customerTable4 th,
    #customerTable4 td {
        font-size: 11px; 
        padding: 5px; 
    }
</style>
<?php
if (isset($_SESSION["conticomtc"]) && isset($_SESSION["typeuser"]) && ($_SESSION["typeuser"] == 1 || $_SESSION["typeuser"] == 2)) {
$u = UserData::verid($_SESSION['conticomtc']);
$id =$_POST['competiciones'];
$encuentro = $_POST['equipo_a'];
$encuentro1 = $_POST['equipo_b'];
$columna_encuentro_a = null;
$columna_estado_a = null;
$columna_accion_a = null;
$columna_observacion_a = null;
$columna_firma_a = null;
$columna_archivo_a = null;
$columna_usuario = null;
$columna_arbitro = null;
$columna_observacion_arbitro = null;
$columna_firma_arbitro = null;
$columna_observacion_fma = null;
$columna_aprobacion = null;

$columna_encuentro_b = null;
$columna_estado_b = null;
$columna_accion_b = null;
$columna_observacion_b = null;
$columna_firma_b = null;
$columna_archivo_b = null;

$base = Database::getInstance();
$con = $base->getConnection();
$columnas = [
    'encuentro1_a' => ['estado1_a', 'accion1_a', 'observacion1_a', 'firma1_a', 'usuario1', 'arbitro1', 'observacion_arbitro1', 'firma_arbitro1', 'obervacion_fma1', 'aprobacion1', 'archivo1_a'],
    'encuentro2_a' => ['estado2_a', 'accion2_a', 'observacion2_a', 'firma2_a', 'usuario2', 'arbitro2', 'observacion_arbitro2', 'firma_arbitro2', 'obervacion_fma2', 'aprobacion2', 'archivo2_a'],
    'encuentro3_a' => ['estado3_a', 'accion3_a', 'observacion3_a', 'firma3_a', 'usuario3', 'arbitro3', 'observacion_arbitro3', 'firma_arbitro3', 'obervacion_fma3', 'aprobacion3', 'archivo3_a'],
    'encuentro4_a' => ['estado4_a', 'accion4_a', 'observacion4_a', 'firma4_a', 'usuario4', 'arbitro4', 'observacion_arbitro4', 'firma_arbitro4', 'obervacion_fma4', 'aprobacion4', 'archivo4_a'],
    'encuentro5_a' => ['estado5_a', 'accion5_a', 'observacion5_a', 'firma5_a', 'usuario5', 'arbitro5', 'observacion_arbitro5', 'firma_arbitro5', 'obervacion_fma5', 'aprobacion5', 'archivo5_a'],
    'encuentro6_a' => ['estado6_a', 'accion6_a', 'observacion6_a', 'firma6_a', 'usuario6', 'arbitro6', 'observacion_arbitro6', 'firma_arbitro6', 'obervacion_fma6', 'aprobacion6', 'archivo6_a'],
    'encuentro7_a' => ['estado7_a', 'accion7_a', 'observacion7_a', 'firma7_a', 'usuario7', 'arbitro7', 'observacion_arbitro7', 'firma_arbitro7', 'obervacion_fma7', 'aprobacion7', 'archivo7_a'],
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
            $columna_encuentro_a = $encuentro_columna;
            $columna_estado_a = $atributos[0];
            $columna_accion_a = $atributos[1];
            $columna_observacion_a = $atributos[2];
            $columna_firma_a = $atributos[3];
            $columna_usuario = $atributos[4];
            $columna_arbitro = $atributos[5];
            $columna_observacion_arbitro = $atributos[6];
            $columna_firma_arbitro = $atributos[7];
            $columna_observacion_fma = $atributos[8];
            $columna_aprobacion = $atributos[9];
            $columna_archivo_a = $atributos[10];
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
// ****************************************************************************
$columnas1 = [
    'encuentro1_b' => ['estado1_b', 'accion1_b', 'observacion1_b', 'firma1_b', 'archivo1_b'],
    'encuentro2_b' => ['estado2_b', 'accion2_b', 'observacion2_b', 'firma2_b', 'archivo2_b'],
    'encuentro3_b' => ['estado3_b', 'accion3_b', 'observacion3_b', 'firma3_b', 'archivo3_b'],
    'encuentro4_b' => ['estado4_b', 'accion4_b', 'observacion4_b', 'firma4_b', 'archivo4_b'],
    'encuentro5_b' => ['estado5_b', 'accion5_b', 'observacion5_b', 'firma5_b', 'archivo5_b'],
    'encuentro6_b' => ['estado6_b', 'accion6_b', 'observacion6_b', 'firma6_b', 'archivo6_b'],
    'encuentro7_b' => ['estado7_b', 'accion7_b', 'observacion7_b', 'firma7_b', 'archivo7_b'],
];
$consulta1 = "SELECT id, ";
foreach ($columnas1 as $encuentro_columna1 => $atributos1) {
    $consulta1 .= "$encuentro_columna1, ";
    foreach ($atributos1 as $atributo1) {
        $consulta1 .= "$atributo1, ";
    }
}
$consulta1 = rtrim($consulta1, ', ');
$consulta1 .= " FROM competencias WHERE id = ?";
$stmt1 = $con->prepare($consulta1);
$stmt1->bind_param('i', $id);
$stmt1->execute();
$resultado1 = $stmt1->get_result();
$fila = $resultado1->fetch_assoc();

if ($fila) {
    $encontrado1 = false;
    foreach ($columnas1 as $encuentro_columna1 => $atributos1) {
        if ($fila[$encuentro_columna1] == $encuentro1) {
            $columna_encuentro_b = $encuentro_columna1;
            $columna_estado_b = $atributos1[0];
            $columna_accion_b = $atributos1[1];
            $columna_observacion_b = $atributos1[2];
            $columna_firma_b = $atributos1[3];
            $columna_archivo_b = $atributos1[4];
            $encontrado1 = true;
            break;
        }
    }
    if (!$encontrado1) {
        echo "No se encontró el valor $encuentro1 en las columnas1 de encuentros.";
    }
} else {
    echo "No se encontró el registro con ID $id.";
}
$stmt1->close();
$competiciones = CompetenciasData::verid($_POST['competiciones']);
$salas = SalaData::verid($competiciones->sala);
$aquipoa = EquipoData::verid($_POST['equipo_a']);
$aquipob = EquipoData::verid($_POST['equipo_b']);
$compet = CompeticionData::verid($salas->competicion);

$query = "SELECT $columna_observacion_a,$columna_firma_a, $columna_usuario, $columna_arbitro, $columna_observacion_arbitro, $columna_firma_arbitro, $columna_observacion_fma, $columna_aprobacion, $columna_observacion_b, $columna_firma_b, $columna_archivo_a, $columna_archivo_b FROM competencias WHERE id = $competiciones->id";
$result = $con->query($query);

$observaciona = '';
$firmaa = '';
$observacionb = '';
$firmab = '';
$arbitro='';
$observacion_arb='';
$firma_ar='';
$observacion_fma='';
$aprobacion='';
$achivoa = '';
$achivob = '';
if ($result && $row = $result->fetch_assoc()) {
    $observaciona = $row[$columna_observacion_a];
    $firmaa = $row[$columna_firma_a];
    $observacionb = $row[$columna_observacion_b];
    $firmab = $row[$columna_firma_b];
    $arbitro = $row[$columna_arbitro];
    $observacion_arb = $row[$columna_observacion_arbitro];
    $firma_ar = $row[$columna_firma_arbitro];
    $observacion_fma = $row[$columna_observacion_fma];
    $aprobacion = $row[$columna_aprobacion];
    $achivoa = $row[$columna_archivo_a];
    $achivob = $row[$columna_archivo_b];
} else {
    // $observaciona = "No se encontró el registro con id = 1.";
}
 ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0 text-white">Acta</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><i class="ri-file-list-3-line text-primary"></i> <span id="id" class="text-muted"><?= $salas->nombreligas; ?> </span></p>
                                    <p><i class="ri-home-2-line text-primary"></i> <span id="sucursales1" class="text-muted"><?= $salas->nombregrupo; ?></span></p>
                                </div>
                                <div class="col-md-4">
                                    <p><i class="ri-file-list-3-line text-primary"></i> <span id="id" class="text-muted"><?= $aquipoa->nombre; ?> VS <?= $aquipob->nombre; ?></span></p>
                                    <!-- <a href="jornada" class="btn btn-outline-primary btn-lg d-flex align-items-center shadow-sm" style="transition: background-color 0.3s, color 0.3s;">
                                        <i class="ri-arrow-go-back-line me-2"></i>
                                        <span>Volver</span>
                                    </a> -->
                                    <a href="jornada" class="btn btn-gradient btn-lg d-flex align-items-center justify-content-center shadow-lg" style="border-radius: 50px; padding: 1px 5px; text-transform: uppercase; font-weight: bold; background: linear-gradient(45deg, #007bff, #00d4ff); color: white; transition: all 0.3s ease;">
                                        <i class="ri-arrow-go-back-line me-2" style="font-size: 20px;"></i>
                                        <span>Volver</span>
                                    </a>

                                </div>
                            </div>
                            <P><span><?= $aquipoa->nombre; ?> </span></P>
                            <div <?php if ($firmaa!="" & $firmaa!="null") { ?> id="modal-body1" <?php }  ?> class="row">
                                <input type="hidden" id="cantidad" value="<?= $compet->cantidajugadores;?>">
                                <div class="col-md-6">
                                    <table id="customerTable1" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%; font-size: 10px;">
                                        <thead>
                                            <tr class="table-primary">
                                                <th>Nº</th>
                                                <th>FIDE</th>
                                                <th>Jugador</th>
                                                <th>Resultado</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $datas = ActaData::vercontenidos($competiciones->id, $_POST['equipo_a']);
                                            $contador1 = 1;
                                            foreach ($datas as $data) { ?>
                                                <tr>
                                                    <td><?php echo $contador1++; ?></td>
                                                    <td><?php echo $data->codigofide; ?></td>
                                                    <td><?php echo $data->jugadores; ?></td>
                                                    <?php if ($data->jugador=="") { ?>
                                                    <td>
                                                        <select class="resultado-select" data-id="<?php echo $data->id; ?>">
                                                            <option value="-" <?php if ($data->resultado == '-') echo 'selected'; ?>>-</option>
                                                        </select>
                                                    </td>
                                                    <?php } else { ?> 
                                                    <td>
                                                        <select class="resultado-select" data-id="<?php echo $data->id; ?>">
                                                            <option value="">Elegir</option>
                                                            <option value="1" <?php if ($data->resultado == '1') echo 'selected'; ?>>1</option>
                                                            <option value="1/2" <?php if ($data->resultado == '1/2') echo 'selected'; ?>>1/2</option>
                                                            <option value="0" <?php if ($data->resultado == '0') echo 'selected'; ?>>0</option>
                                                            <option value="+" <?php if ($data->resultado == '+') echo 'selected'; ?>>+</option>
                                                            <option value="-" <?php if ($data->resultado == '-') echo 'selected'; ?>>-</option>
                                                        </select>
                                                    </td>
                                                    <?php } ?>
                                                    <td><button class="delete-btn btn btn-danger me-2" data-id="<?php echo $data->id; ?>">Limpiar</button></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3"><strong>Total</strong></td>
                                                <td id="resultado-total">0</td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <div style="font-size: 9px;" class="modal-body bg-light p-2 rounded">
                                    <div class="row mb-3">
                                    <form id="firmaForm" enctype="multipart/form-data" method="post">
                                        <div class="col-md-12 mb-3">
                                            <label for="observacion" class="form-label text-primary fw-bold">Observación del Equipo Local</label>
                                            <textarea style="font-size: 9px;" class="form-control" name="observacion"><?= $observaciona;?></textarea>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <label for="firma" class="form-label text-primary fw-bold me-2">Firma del equipo Local</label>
                                            <input style="font-size: 9px;" value="<?= $firmaa;?>" type="text" name="firma" class="form-control w-auto">
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="firma" class="form-label text-primary fw-bold me-2">Acta</label>
                                            <div style="display: flex; align-items: center;">
                                                <input style="font-size: 9px; margin-right: 10px;" type="file" name="archivo" class="form-control w-auto">
                                                <input style="font-size: 9px;" value="<?= $achivoa;?>" type="hidden" name="archivo1" class="form-control w-auto">
                                                <?php if ($achivoa!="") {
                                                    echo "<a href='storage/archivo/$achivoa' download style='font-size: 9px;'>Descargar</a>";
                                                } ?>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-info d-flex justify-content-between pb-0 border-top mt-3">
                                            <input type="hidden" name="id" value="<?php echo $competiciones->id; ?>">
                                            <input type="hidden" name="encuentro" value="<?php echo $_POST['equipo_a']; ?>">
                                            <button type="button" class="btn btn-primary submit-firma-form">Enviar Firma</button>
                                        </div>
                                    </form>
<script>
$(document).ready(function() {
    $('.submit-firma-form').click(function(e) {
        e.preventDefault();

        // Crear un nuevo FormData para capturar todos los datos del formulario, incluyendo archivos
        var formData = new FormData($('#firmaForm')[0]);

        $.ajax({
            url: 'index.php?action=apiregistrofirmai',
            type: 'POST',
            data: formData,
            processData: false, // No procesar los datos, para enviar archivos
            contentType: false, // No establecer el tipo de contenido, para enviar archivos
            success: function(response) {
                console.log('Información actualizada correctamente:', response);
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: 'Información actualizada correctamente.',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload(); // Recargar la página después de que el usuario cierre la alerta
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error('Error al actualizar la firma y observación:', xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al actualizar la firma y observación. Por favor, intenta nuevamente.',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
});
</script>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <table id="customerTable2" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%; font-size: 10px;">
                                        <thead>
                                            <tr class="table-primary">
                                                <th>Nº</th>
                                                <th>FIDE</th>
                                                <th>Jugador</th>
                                                <th>ELO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $datas2 = EquipoJugadorData::vercontenidos($_POST['equipo_a']);
                                            $contador2 = 1;
                                            foreach ($datas2 as $data2) { ?>
                                                <tr>
                                                    <td><?php echo $contador2++; ?></td>
                                                    <td><?php echo $data2->codigofide; ?></td>
                                                    <td>
                                                        <form class="player-form">
                                                            <input type="hidden" name="competencias" value="<?php echo $competiciones->id; ?>">
                                                            <input type="hidden" name="equipo" value="<?php echo $aquipoa->id; ?>">
                                                            <input type="hidden" name="jugador" value="<?php echo $data2->id; ?>">
                                                            <input type="hidden" name="actions" value="52">
                                                            <a  class="btn btn-light me-2 submit-player-form"><?php echo $data2->apellido1 . ' ' . $data2->apellido2 . ' ' . $data2->nombre; ?></a>
                                                        </form>
                                                    </td>
                                                    <td><?php if ($data2->elos=="") { echo $data2->elo; } else { echo $data2->elos; } ?></td>
                                                </tr>
                                            <?php } ?>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <form class="player-form">
                                                            <input type="hidden" name="competencias" value="<?php echo $competiciones->id; ?>">
                                                            <input type="hidden" name="equipo" value="<?php echo $aquipoa->id; ?>">
                                                            <input type="hidden" name="jugador" value="">
                                                            <input type="hidden" name="actions" value="52">
                                                            <button type="button" class="btn btn-light me-2 submit-player-form">Incomparecencia</button>
                                                        </form>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            <div class="d-flex align-items-center justify-content-between">
                                               <p style="text-decoration: underline;">Orden de Fuerza</p>
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#Modal1">Ascender Jugador</button>
                                            </div>
                                        </tbody>
                                    </table>
                                    <p><i>Pinche sobre el jugador que desea incluir en el acta.</i></p>
                                </div>
                                <script>
                                $(document).ready(function() {
                                    // Function to handle form submission for adding a player
                                    $('.submit-player-form').click(function(e) {
                                        e.preventDefault();
                                        var form = $(this).closest('form');
                                        var maxPlayers = parseInt($('#cantidad').val());
                                        var currentPlayers = $('#customerTable1 tbody tr').length;

                                        if (currentPlayers < maxPlayers) {
                                            $.ajax({
                                                url: 'index.php?action=registro',
                                                type: 'POST',
                                                data: form.serialize(),
                                                success: function(response) {
                                                    updateTable1();
                                                },
                                                error: function(xhr, status, error) {
                                                    console.error(xhr.responseText);
                                                }
                                            });
                                        } else {
                                            alert('No se puede agregar más jugadores. Se ha alcanzado el límite.');
                                        }
                                    });

                                    // Function to update the table
                                    function updateTable1() {
                                        $.ajax({
                                            url: 'index.php?action=updateTable1',
                                            type: 'POST',
                                            data: { competencia_id: <?php echo $competiciones->id; ?>, equipo_id: <?php echo $_POST['equipo_a']; ?> },
                                            success: function(response) {
                                                $('#customerTable1 tbody').html(response);
                                                attachHandlers();
                                                calculateTotal();
                                            },
                                            error: function(xhr, status, error) {
                                                console.error(xhr.responseText);
                                            }
                                        });
                                    }

                                    // Function to attach event handlers
                                    function attachHandlers() {
                                        $('.delete-btn').click(function() {
                                            var recordId = $(this).data('id');
                                            $.ajax({
                                                url: 'index.php?action=deleteacta',
                                                type: 'POST',
                                                data: { id: recordId },
                                                success: function(response) {
                                                    var result = JSON.parse(response);
                                                    if (result.status === 'success') {
                                                        updateTable1();
                                                    } else {
                                                        alert(result.message);
                                                    }
                                                },
                                                error: function(xhr, status, error) {
                                                    console.error(xhr.responseText);
                                                }
                                            });
                                        });

                                        $('.resultado-select').change(function() {
                                            var recordId = $(this).data('id');
                                            var resultado = $(this).val();
                                            $.ajax({
                                                url: 'index.php?action=updateresultado',
                                                type: 'POST',
                                                data: { id: recordId, resultado: resultado },
                                                success: function(response) {
                                                    var result = JSON.parse(response);
                                                    if (result.status === 'success') {
                                                        updateTable1();  // Refresh the table after updating the result
                                                    } else {
                                                        alert(result.message);
                                                    }
                                                },
                                                error: function(xhr, status, error) {
                                                    console.error(xhr.responseText);
                                                }
                                            });
                                        });

                                        // Attach event handler to calculate total on change
                                        $('.resultado-select').change(calculateTotal);
                                    }

                                    // Function to calculate the total result
function calculateTotal() {
    var total = 0;
    var allDashes = true; // Variable para verificar si todos los select están en '-'
    var allEmpty = true;  // Variable para verificar si todos los select están vacíos

    $('.resultado-select').each(function() {
        var value = $(this).val();
        if (value === '1') {
            total += 1;
            allDashes = false;
            allEmpty = false;
        } else if (value === '1/2') {
            total += 0.5;
            allDashes = false;
            allEmpty = false;
        } else if (value === '+') {
            total += 1; // Asumiendo que '+' cuenta como 1
            allDashes = false;
            allEmpty = false;
        } else if (value !== '-') {
            allDashes = false;
        }

        if (value !== '') {
            allEmpty = false;
        }
    });

    if (allDashes && !allEmpty) {
        $('#resultado-total').text('-');
        $('#resultados-total').val('-');
    } else {
        var displayTotal = allEmpty ? 0 : total;
        $('#resultado-total').text(displayTotal);
        $('#resultados-total').val(displayTotal);
    }

    // Enviar el resultado al API
    $.ajax({
        url: 'index.php?action=apiregistroresultado',
        type: 'POST',
        data: {
            id: <?php echo $competiciones->id; ?>,
            encuentro: <?php echo $_POST['equipo_a']; ?>,
            resultado1: allDashes && !allEmpty ? '-' : (allEmpty ? 0 : total)
        },
        success: function(response) {
            console.log('Resultado enviado al API:', response);
        },
        error: function(xhr, status, error) {
            console.error('Error al enviar el resultado al API:', xhr.responseText);
        }
    });
}


                                    // Attach event handlers initially
                                    attachHandlers();
                                    calculateTotal(); // Calculate the total initially
                                });
                                </script>
                            </div>
                            <P><span><?= $aquipob->nombre; ?></span></P>
                            <div <?php if ($firmab!="" & $firmab!="null") { ?> id="modal-body1" <?php }  ?> class="row">
                                <div class="col-md-6">
                                    <table id="customerTable3" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%; font-size: 10px;">
                                        <thead>
                                            <tr class="table-primary">
                                                <th>Nº</th>
                                                <th>FIDE</th>
                                                <th>Jugador</th>
                                                <th>Resultado</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $datas = ActaData::vercontenidos($competiciones->id, $_POST['equipo_b']);
                                            $contador1 = 1;
                                            foreach ($datas as $data) { ?>
                                                <tr>
                                                    <td><?php echo $contador1++; ?></td>
                                                    <td><?php echo $data->codigofide; ?></td>
                                                    <td><?php echo $data->jugadores; ?></td>
                                                    <?php if ($data->jugador =="") { ?>
                                                    <td>
                                                        <select class="resultado-select1" data-id="<?php echo $data->id; ?>">
                                                            <option value="-" <?php if ($data->resultado == '-') echo 'selected'; ?>>-</option>
                                                        </select>
                                                    </td>
                                                    <?php } else { ?>
                                                    <td>
                                                        <select class="resultado-select1" data-id="<?php echo $data->id; ?>">
                                                            <option value="">Elegir</option>
                                                            <option value="1" <?php if ($data->resultado == '1') echo 'selected'; ?>>1</option>
                                                            <option value="1/2" <?php if ($data->resultado == '1/2') echo 'selected'; ?>>1/2</option>
                                                            <option value="0" <?php if ($data->resultado == '0') echo 'selected'; ?>>0</option>
                                                            <option value="+" <?php if ($data->resultado == '+') echo 'selected'; ?>>+</option>
                                                            <option value="-" <?php if ($data->resultado == '-') echo 'selected'; ?>>-</option>
                                                        </select>
                                                    </td>
                                                    <?php } ?>
                                                    <td><a class="delete-btn1 btn btn-danger me-2" data-id="<?php echo $data->id; ?>">Limpiar</a></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3"><strong>Total</strong></td>
                                                <td id="resultado-total1">0</td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <div style="font-size: 9px;" class="modal-body bg-light p-2 rounded">
                                        <div class="row mb-3">
                                            <form id="firmaForm1" enctype="multipart/form-data" method="post">
                                                <div class="col-md-12 mb-3">
                                                    <label for="observacion" class="form-label text-primary fw-bold">Observación del Equipo Local</label>
                                                    <textarea style="font-size: 9px;" class="form-control" name="observacion"><?= $observacionb;?></textarea>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <label for="firma" class="form-label text-primary fw-bold me-2">Firma del equipo Local</label>
                                                    <input style="font-size: 9px;" value="<?= $firmab;?>" type="text" name="firma" class="form-control w-auto">
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="firma" class="form-label text-primary fw-bold me-2">Acta</label>
                                                    <div style="display: flex; align-items: center;">
                                                        <input style="font-size: 9px; margin-right: 10px;" type="file" name="archivo" class="form-control w-auto">
                                                        <input style="font-size: 9px;" value="<?= $achivob;?>" type="hidden" name="archivo1" class="form-control w-auto">
                                                        <?php if ($achivob!="") {
                                                            echo "<a href='storage/archivo/$achivob' download  style='font-size: 9px;'>Descargar</a>";
                                                        } ?>
                                                    </div>
                                                </div>
                                                <div class="modal-footer bg-info d-flex justify-content-between pb-0 border-top mt-3">
                                                    <input type="hidden" name="id" value="<?php echo $competiciones->id; ?>">
                                                    <input type="hidden" name="encuentro" value="<?php echo $_POST['equipo_b']; ?>">
                                                    <button type="button" class="btn btn-primary submit-firma-form1">Enviar Firma</button>
                                                </div>
                                            </form>
<script>
$(document).ready(function() {
    $('.submit-firma-form1').click(function(e) {
        e.preventDefault();

        // Crear un nuevo FormData para capturar todos los datos del formulario, incluyendo archivos
        var formData = new FormData($('#firmaForm1')[0]);

        $.ajax({
            url: 'index.php?action=apiregistrofirmai', // Asegúrate de que esta URL apunta al archivo correcto
            type: 'POST',
            data: formData,
            processData: false, // No procesar los datos, para enviar archivos
            contentType: false, // No establecer el tipo de contenido, para enviar archivos
            success: function(response) {
                console.log('Información actualizada correctamente:', response);
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: 'Información actualizada correctamente.',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload(); // Recargar la página después de que el usuario cierre la alerta
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error('Error al actualizar la firma y observación:', xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al actualizar la firma y observación. Por favor, intenta nuevamente.',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
});
</script>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <table id="customerTable4" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%; font-size: 10px;">
                                        <thead>
                                            <tr class="table-primary">
                                                <th>Nº</th>
                                                <th>FIDE</th>
                                                <th>Jugador</th>
                                                <th>ELO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $datas4 = EquipoJugadorData::vercontenidos($_POST['equipo_b']);
                                            $contador2 = 1;
                                            foreach ($datas4 as $data4) { ?>
                                                <tr>
                                                    <td><?php echo $contador2++; ?></td>
                                                    <td><?php echo $data4->codigofide; ?></td>
                                                    <td>
                                                        <form class="player-form">
                                                            <input type="hidden" name="competencias" value="<?php echo $competiciones->id; ?>">
                                                            <input type="hidden" name="equipo" value="<?php echo $aquipob->id; ?>">
                                                            <input type="hidden" name="jugador" value="<?php echo $data4->id; ?>">
                                                            <input type="hidden" name="actions" value="52">
                                                            <button type="button" class="btn btn-light me-2 submit-player-form1"><?php echo $data4->apellido1 . ' ' . $data4->apellido2 . ' ' . $data4->nombre; ?></button>
                                                        </form>
                                                    </td>
                                                    <td><?php if ($data4->elos=="") { echo $data4->elo; } else { echo $data4->elos; } ?></td>
                                                </tr>
                                            <?php } ?>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <form class="player-form">
                                                            <input type="hidden" name="competencias" value="<?php echo $competiciones->id; ?>">
                                                            <input type="hidden" name="equipo" value="<?php echo $aquipob->id; ?>">
                                                            <input type="hidden" name="jugador" value="">
                                                            <input type="hidden" name="actions" value="52">
                                                            <button type="button" class="btn btn-light me-2 submit-player-form1">Incomparecencia</button>
                                                        </form>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            <div class="d-flex align-items-center justify-content-between">
                                               <p style="text-decoration: underline;">Orden de Fuerza</p>
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#Modal2">Ascender Jugador</button>
                                            </div>
                                        </tbody>
                                    </table>
                                    <p><i>Pinche sobre el jugador que desea incluir en el acta.</i></p>
                                </div>
                            </div>
                            <hr>
                            <span>Arbitro</span>
                            <div <?php if ($firma_ar!="") { ?> id="modal-body2" <?php }  ?> class="modal-body bg-light p-3 rounded">
                                <div class="row mb-3">
                                    <form id="firmaForm2" enctype="multipart/form-data" method="post" action="index.php?action=registro">
                                    <div class="col-md-4 mb-3">
                                        <label for="arbitro" class="form-label text-primary fw-bold">Arbitro</label>
                                        <select name="arbitro" class="form-select">
                                            <option value="">Seleccionar</option>
                                            <?php $usuarioss = UserData::vercontenido();
                                            foreach ($usuarioss as $userss) { ?>
                                                <option <?php if ($userss->id==$arbitro) { echo "selected"; } ?> value="<?= $userss->id; ?>"><?= $userss->nombre." ".$userss->apellido; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="observacion_arbitro" class="form-label text-primary fw-bold">Observación del Arbitro</label>
                                        <textarea class="form-control" name="observacion_arbitro"><?= $observacion_arb;?></textarea>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <label for="firma_arbitro" class="form-label text-primary fw-bold me-2">Firma del Arbitro</label>
                                        <input type="text" value="<?= $firma_ar;?>" name="firma_arbitro" class="form-control w-auto">
                                    </div>
                                    <div class="modal-footer bg-info d-flex justify-content-between pb-0 border-top mt-3">
                                        <input type="hidden" name="id" value="<?php echo $competiciones->id; ?>">
                                        <input type="hidden" name="val1" value="<?= $columna_arbitro;?>">
                                        <input type="hidden" name="val2" value="<?= $columna_observacion_arbitro;?>">
                                        <input type="hidden" name="val3" value="<?= $columna_firma_arbitro;?>">
                                        <button type="submit" class="btn btn-primary submit-firma-form2">Enviar Firma</button>
                                    </div>
                                    </form>
<script>
    $(document).ready(function() {
        $('.submit-firma-form2').click(function(e) {
            e.preventDefault();
            // Serializar los datos del formulario
            var formData = $('#firmaForm2').serialize();
            console.log('Datos del formulario:', formData); // Debug: Verificar datos serializados
            $.ajax({
                url: 'index.php?action=apiregistroarbitro', // Asegúrate de que esta URL apunta al archivo correcto
                type: 'POST',
                data: formData,
                success: function(response) {
                    console.log('Información actualizada correctamente:', response);
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: 'Información actualizada correctamente.',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload(); // Recargar la página después de que el usuario cierre la alerta
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error al actualizar la firma y observación:', xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al actualizar la firma y observación. Por favor, intenta nuevamente.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>
                                </div>
                            </div>
                            <hr>
                            <form enctype="multipart/form-data" method="post" id="firmaForm3">
                            <span>Observaciones de F.M.A</span>
                            <div <?php if ($aprobacion=="OK") { ?> id="modal-body3" <?php }  ?> class="modal-body bg-light p-3 rounded">
                                <div class="row mb-3" >
                                    <div class="col-md-12 mb-3">
                                        <label for="observacion_fma" class="form-label text-primary fw-bold">Observaciones</label>
                                        <textarea class="form-control" name="observacion_fma"><?php echo $observacion_fma; ?></textarea>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="aprobacion" class="form-label text-primary fw-bold">OK Acta F.M.A. (S/N)</label>
                                        <select name="aprobacion" class="form-select">
                                            <option value="N" <?= $aprobacion == 'N' ? 'selected' : ''; ?>>N</option>
                                            <option value="OK" <?= $aprobacion == 'OK' ? 'selected' : ''; ?>>OK</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer bg-info d-flex justify-content-between pb-0 border-top mt-3">
                                    <input type="hidden" name="id" value="<?php echo $competiciones->id; ?>">
                                    <input type="hidden" name="val1" value="<?= $columna_observacion_fma;?>">
                                    <input type="hidden" name="val2" value="<?= $columna_aprobacion;?>">
                                    <input type="hidden" name="val3" value="<?= $columna_usuario;?>">
                                    <button type="submit" class="btn btn-primary submit-firma-form3">Enviar Acta</button>
                                </div>
                            </div>
                            </form>
<script>
    $(document).ready(function() {
        $('.submit-firma-form3').click(function(e) {
            e.preventDefault();
            // Serializar los datos del formulario
            var formData = $('#firmaForm3').serialize();
            console.log('Datos del formulario:', formData); // Debug: Verificar datos serializados
            $.ajax({
                url: 'index.php?action=apiregistroarpobacionfma', // Asegúrate de que esta URL apunta al archivo correcto
                type: 'POST',
                data: formData,
                success: function(response) {
                    console.log('Información actualizada correctamente:', response);
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: 'Información actualizada correctamente.',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload(); // Recargar la página después de que el usuario cierre la alerta
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error al actualizar la firma y observación:', xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al actualizar la firma y observación. Por favor, intenta nuevamente.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>
                            <script>
                                $(document).ready(function() {
                                    // Function to handle form submission for adding a player
                                    $('.submit-player-form1').click(function(e) {
                                        e.preventDefault();
                                        
                                        var maxJugadores = parseInt($('#cantidad').val());
                                        var currentJugadores = $('#customerTable3 tbody tr').length;

                                        if (currentJugadores >= maxJugadores) {
                                            alert("No se pueden agregar más jugadores. Se ha alcanzado el límite.");
                                            return;
                                        }

                                        var form = $(this).closest('form');
                                        $.ajax({
                                            url: 'index.php?action=registro',
                                            type: 'POST',
                                            data: form.serialize(),
                                            success: function(response) {
                                                updateTable2();
                                            },
                                            error: function(xhr, status, error) {
                                                console.error(xhr.responseText);
                                            }
                                        });
                                    });

                                    // Function to update the table
                                    function updateTable2() {
                                        $.ajax({
                                            url: 'index.php?action=updateTable2',
                                            type: 'POST',
                                            data: { competencia_id: <?php echo $competiciones->id; ?>, equipo_id: <?php echo $_POST['equipo_b']; ?> },
                                            success: function(response) {
                                                $('#customerTable3 tbody').html(response);
                                                attachHandlers();
                                                calculateTotal1();
                                            },
                                            error: function(xhr, status, error) {
                                                console.error(xhr.responseText);
                                            }
                                        });
                                    }

                                    // Function to attach event handlers
                                    function attachHandlers() {
                                        $('.delete-btn1').click(function() {
                                            var recordId = $(this).data('id');
                                            $.ajax({
                                                url: 'index.php?action=deleteacta',
                                                type: 'POST',
                                                data: { id: recordId },
                                                success: function(response) {
                                                    var result = JSON.parse(response);
                                                    if (result.status === 'success') {
                                                        updateTable2();
                                                    } else {
                                                        alert(result.message);
                                                    }
                                                },
                                                error: function(xhr, status, error) {
                                                    console.error(xhr.responseText);
                                                }
                                            });
                                        });

                                        $('.resultado-select1').change(function() {
                                            var recordId = $(this).data('id');
                                            var resultado = $(this).val();
                                            $.ajax({
                                                url: 'index.php?action=updateresultado',
                                                type: 'POST',
                                                data: { id: recordId, resultado: resultado },
                                                success: function(response) {
                                                    var result = JSON.parse(response);
                                                    if (result.status === 'success') {
                                                        updateTable2();  // Refresh the table after updating the result
                                                    } else {
                                                        alert(result.message);
                                                    }
                                                },
                                                error: function(xhr, status, error) {
                                                    console.error(xhr.responseText);
                                                }
                                            });
                                        });

                                        // Attach event handler to calculate total on change
                                        $('.resultado-select1').change(calculateTotal1);
                                    }
function calculateTotal1() {
    var total = 0;
    var allDashes = true; // Variable para verificar si todos los select están en '-'
    var allEmpty = true;  // Variable para verificar si todos los select están vacíos

    $('.resultado-select1').each(function() {
        var value = $(this).val();
        if (value === '1') {
            total += 1;
            allDashes = false;
            allEmpty = false;
        } else if (value === '1/2') {
            total += 0.5;
            allDashes = false;
            allEmpty = false;
        } else if (value === '+') {
            total += 1; // Asumiendo que '+' cuenta como 1
            allDashes = false;
            allEmpty = false;
        } else if (value !== '-') {
            allDashes = false;
        }

        if (value !== '') {
            allEmpty = false;
        }
    });

    if (allDashes && !allEmpty) {
        $('#resultado-total1').text('-');
        $('#resultados-total1').val('-');
    } else {
        var displayTotal = allEmpty ? 0 : total;
        $('#resultado-total1').text(displayTotal);
        $('#resultados-total1').val(displayTotal);
    }

    // Enviar el resultado al API
    $.ajax({
        url: 'index.php?action=apiregistroresultado',
        type: 'POST',
        data: {
            id: <?php echo $competiciones->id; ?>,
            encuentro: <?php echo $_POST['equipo_b']; ?>,
            resultado1: allDashes && !allEmpty ? '-' : (allEmpty ? 0 : total)
        },
        success: function(response) {
            console.log('Resultado enviado al API:', response);
        },
        error: function(xhr, status, error) {
            console.error('Error al enviar el resultado al API:', xhr.responseText);
        }
    });
}

                                    // // Function to calculate the total result
                                    // function calculateTotal1() {
                                    //     var total = 0;
                                    //     $('.resultado-select1').each(function() {
                                    //         var value = $(this).val();
                                    //         if (value === '1') {
                                    //             total += 1;
                                    //         } else if (value === '1/2') {
                                    //             total += 0.5;
                                    //         } else if (value === '+') {
                                    //             total += 1; // Assuming '+' is counted as 1
                                    //         }
                                    //         // If '-' should also be considered, add logic accordingly
                                    //     });
                                    //     $('#resultado-total1').text(total);
                                    //     // Enviar el resultado al API
                                    //     $.ajax({
                                    //         url: 'index.php?action=apiregistroresultado',
                                    //         type: 'POST',
                                    //         data: {
                                    //             id: <?php echo $competiciones->id; ?>,
                                    //             encuentro: <?php echo $_POST['equipo_b']; ?>,
                                    //             resultado1: total
                                    //         },
                                    //         success: function(response) {
                                    //             console.log('Resultado enviado al API:', response);
                                    //         },
                                    //         error: function(xhr, status, error) {
                                    //             console.error('Error al enviar el resultado al API:', xhr.responseText);
                                    //         }
                                    //     });
                                    // }

                                    // Attach event handlers initially
                                    attachHandlers();
                                    calculateTotal1(); // Calculate the total initially
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let elements3 = document.querySelectorAll("#modal-body3 textarea, #modal-body3 select, #modal-body3 input, #modal-body3 button");
        elements3.forEach(function(element) {
            element.disabled = true;
        });

        let elements2 = document.querySelectorAll("#modal-body2 textarea, #modal-body2 select, #modal-body2 input, #modal-body2 button");
        elements2.forEach(function(element) {
            element.disabled = true;
        });

        let elements1 = document.querySelectorAll("#modal-body1 textarea, #modal-body1 select, #modal-body1 a, #modal-body1 input, #modal-body1 button");
            elements1.forEach(function(element) {
                element.disabled = true;
                // Si es un enlace, prevenir su acción predeterminada
                if (element.tagName === 'A') {
                    element.classList.add('disabled'); // Agregar una clase para cambiar su apariencia
                    element.addEventListener('click', function(event) {
                        event.preventDefault(); // Prevenir la acción predeterminada
                    });
                }
            });
        let elements = document.querySelectorAll("#modal-body textarea, #modal-body select, #modal-body a, #modal-body input, #modal-body button");
            elements.forEach(function(element) {
                element.disabled = true;
                // Si es un enlace, prevenir su acción predeterminada
                if (element.tagName === 'A') {
                    element.classList.add('disabled'); // Agregar una clase para cambiar su apariencia
                    element.addEventListener('click', function(event) {
                        event.preventDefault(); // Prevenir la acción predeterminada
                    });
                }
            });
    });
</script>

<div class="modal fade" id="Modal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-5">
      <div class="modal-header bg-info">
        <h5 class="modal-title text-white" id="exampleModalLabel">Ascender</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body bg-light">
        <table id="customerTable6" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%; font-size: 10px;">
            <thead>
                <tr class="table-primary">
                    <th>FIDE</th>
                    <th>Jugador</th>
                    <th>ELO</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div class="modal-footer bg-info d-flex justify-content-between pb-0">
      <input class="form-control" type="hidden" name="actions" value="22">
      <button type="button" class="btn btn-outline-light me-2" data-bs-dismiss="modal">Cerrar</button>
  </div>
</div>
</div>
</div>
<script>
    $(document).ready(function() {
        var table = $('#customerTable6').DataTable({
            "processing": true,
            "serverSide": true,
            "searchDelay": 500,
            "deferLoading": 0,
            "ajax": {
                "url": "index.php?action=apilistarjugador",
                "data": function (d) {
                    if (d.search.value.length > 0) {
                        return d;
                    } else {
                        return false;
                    }
                }
            },
            "columns": [
                { "data": function(row) {
                        return row.codigofide;
                    }
                },
                { "data": function(row) {
                    return '<form class="player-form"><input type="hidden" name="competencias" value="<?php echo $competiciones->id; ?>"><input type="hidden" name="equipo" value="<?php echo $aquipoa->id; ?>"><input type="hidden" name="jugador" value="'+row.id+'"><input type="hidden" name="actions" value="52"><a href="#" class="btn btn-light me-2 submit-player-form">' + row.apellido1 + ' ' + row.apellido2 + ' ' + row.nombre + '</a></form>';
                    }
                },
                { "data": "elo" }
            ],
            "language": {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });

        // Delegación de eventos para manejar el click en el botón de envío
        $('#customerTable6').on('click', '.submit-player-form', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            var maxPlayers = parseInt($('#cantidad').val());
            var currentPlayers = $('#customerTable1 tbody tr').length;

            if (currentPlayers < maxPlayers) {
                $.ajax({
                    url: 'index.php?action=registro',
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            } else {
                alert('No se puede agregar más jugadores. Se ha alcanzado el límite.');
            }
        });

    });
</script>

<div class="modal fade" id="Modal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-5">
      <div class="modal-header bg-info">
        <h5 class="modal-title text-white" id="exampleModalLabel">Ascender</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body bg-light">
        <table id="customerTable7" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%; font-size: 10px;">
            <thead>
                <tr class="table-primary">
                    <th>FIDE</th>
                    <th>Jugador</th>
                    <th>ELO</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div class="modal-footer bg-info d-flex justify-content-between pb-0">
      <input class="form-control" type="hidden" name="actions" value="22">
      <button type="button" class="btn btn-outline-light me-2" data-bs-dismiss="modal">Cerrar</button>
  </div>
</div>
</div>
</div>
<script>
    $(document).ready(function() {
        var table = $('#customerTable7').DataTable({
            "processing": true,
            "serverSide": true,
            "searchDelay": 500,
            "deferLoading": 0,
            "ajax": {
                "url": "index.php?action=apilistarjugador",
                "data": function (d) {
                    if (d.search.value.length > 0) {
                        return d;
                    } else {
                        return false;
                    }
                }
            },
            "columns": [
                { "data": function(row) {
                        return row.codigofide;
                    }
                },
                { "data": function(row) {
                    return '<form class="player-form"><input type="hidden" name="competencias" value="<?php echo $competiciones->id; ?>"><input type="hidden" name="equipo" value="<?php echo $aquipob->id; ?>"><input type="hidden" name="jugador" value="'+row.id+'"><input type="hidden" name="actions" value="52"><a href="#" class="btn btn-light me-2 submit-player-form1">' + row.apellido1 + ' ' + row.apellido2 + ' ' + row.nombre + '</a></form>';
                    }
                },
                { "data": "elo" }
            ],
            "language": {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });

        // Delegación de eventos para manejar el click en el botón de envío
        $('#customerTable7').on('click', '.submit-player-form1', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            var maxPlayers = parseInt($('#cantidad').val());
            var currentPlayers = $('#customerTable3 tbody tr').length;

            if (currentPlayers < maxPlayers) {
                $.ajax({
                    url: 'index.php?action=registro',
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            } else {
                alert('No se puede agregar más jugadores. Se ha alcanzado el límite.');
            }
        });
    });
</script>
<?php } else {
    header("Location: ./"); 
    exit();
} ?>
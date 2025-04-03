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
<?php  $competiciones = SalaPersonalizadaData::verid2($_POST['tid']);
$salas = SalaData::verid($competiciones->sala);
$compet = CompeticionData::verid($salas->competicion);
$identificador = 0;
$vala = 0;
if ($salas->nombregrupo=="División de Honor") {
    $vala = 1;
}
$identificador = $vala;
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
                                    <p><i class="ri-file-list-3-line text-primary"></i> <span id="id" class="text-muted"><?= $salas->nombreligas; ?></span></p>
                                    <p><i class="ri-home-2-line text-primary"></i> <span id="sucursales1" class="text-muted"><?= $salas->nombregrupo; ?></span></p>
                                </div>
                                <div class="col-md-4">
                                    <p><i class="ri-file-list-3-line text-primary"></i> <span id="id" class="text-muted"><?= $competiciones->equipoa; ?> VS <?= $competiciones->equipob; ?></span></p>
                                    <!-- <a href="jornada" class="btn btn-outline-primary btn-lg d-flex align-items-center shadow-sm" style="transition: background-color 0.3s, color 0.3s;">
                                        <i class="ri-arrow-go-back-line me-2"></i>
                                        <span>Volver</span>
                                    </a> -->
                                    <a href="jornadas" class="btn btn-gradient btn-lg d-flex align-items-center justify-content-center shadow-lg" style="border-radius: 50px; padding: 1px 5px; text-transform: uppercase; font-weight: bold; background: linear-gradient(45deg, #007bff, #00d4ff); color: white; transition: all 0.3s ease;">
                                        <i class="ri-arrow-go-back-line me-2" style="font-size: 20px;"></i>
                                        <span>Volver</span>
                                    </a>

                                </div>
                            </div>
                            <P><span><?= $competiciones->equipoa; ?></span></P>
                            <div <?php if ($competiciones->firmaa!="" & $competiciones->firmaa!="null") { ?> id="modal-body1" <?php }  ?> class="row">
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
                                            $datas = ActaData::vercontenidos1($competiciones->id, $competiciones->id_competidor);
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
        <label for="observaciona" class="form-label text-primary fw-bold">Observación del Equipo Local</label>
        <textarea style="font-size: 9px;" class="form-control" name="observaciona"><?= $competiciones->observaciona; ?></textarea>
    </div>
    <div class="d-flex align-items-center">
        <label for="firma" class="form-label text-primary fw-bold me-2">Firma del equipo Local</label>
        <input style="font-size: 9px;" value="<?= $competiciones->firmaa; ?>" type="text" name="firmaa" class="form-control w-auto">
    </div>
    <div class="col-md-12 mb-3">
        <label for="firma" class="form-label text-primary fw-bold me-2">Acta</label>
        <div style="display: flex; align-items: center;">
            <input style="font-size: 9px; margin-right: 10px;" type="file" name="archivo" class="form-control w-auto">
            <input style="font-size: 9px;" value="<?= $competiciones->archivoa;?>" type="hidden" name="archivo1" class="form-control w-auto">
            <?php if ($competiciones->archivoa!="") {
                echo "<a href='storage/archivo/$competiciones->archivoa' download style='font-size: 9px;'>Descargar</a>";
            } ?>
        </div>
    </div>
    <div class="modal-footer bg-info d-flex justify-content-between pb-0 border-top mt-3">
        <input type="hidden" name="id" value="<?= $competiciones->id; ?>">
        <input type="hidden" name="actions" value="57">
        <button type="button" class="btn btn-primary submit-firma-form">Enviar Firma</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('.submit-firma-form').click(function(e) {
            e.preventDefault();

            // Crear una nueva instancia de FormData y añadir los datos del formulario
            var formData = new FormData($('#firmaForm')[0]);

            $.ajax({
                url: 'index.php?action=registro', // Asegúrate de que esta URL apunta al archivo correcto
                type: 'POST',
                data: formData,
                processData: false, // Necesario para que jQuery no procese los datos
                contentType: false, // Necesario para que jQuery no establezca ningún content-type
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
                                            $datas2 = EquipoJugadorData::vercontenidos($competiciones->id_competidor);
                                            $contador2 = 1;
                                            foreach ($datas2 as $data2) { ?>
                                                <tr>
                                                    <td><?php echo $contador2++; ?></td>
                                                    <td><?php echo $data2->codigofide; ?></td>
                                                    <td>
                                                        <form class="player-form">
                                                            <input type="hidden" name="competencias" value="<?php echo $competiciones->id; ?>">
                                                            <input type="hidden" name="equipo" value="<?php echo $competiciones->id_competidor; ?>">
                                                            <input type="hidden" name="jugador" value="<?php echo $data2->id; ?>">
                                                            <input type="hidden" name="actions" value="63">
                                                            <a  class="btn btn-light me-2 submit-player-form"><?php echo $data2->apellido1 . ' ' . $data2->apellido2 . ', ' . $data2->nombre; ?></a>
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
                                                            <input type="hidden" name="equipo" value="<?php echo $competiciones->id_competidor; ?>">
                                                            <input type="hidden" name="jugador" value="">
                                                            <input type="hidden" name="actions" value="63">
                                                            <button type="button" class="btn btn-light me-2 submit-player-form">Incomparecencia</button>
                                                        </form>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            <p style="text-decoration: underline;">Orden de Fuerza</p>
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
                                            url: 'index.php?action=updateTable1s',
                                            type: 'POST',
                                            data: { competencia_id: <?php echo $competiciones->id; ?>, equipo_id: <?php echo $competiciones->id_competidor; ?> },
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
        url: 'index.php?action=registro',
        type: 'POST',
        data: {
            actions:61,
            id: <?php echo $competiciones->id; ?>,
            encuentro: <?php echo $competiciones->id_competidor; ?>,
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
                            <P><span><?= $competiciones->equipob; ?></span></P>
                            <div <?php if ($competiciones->firmab!="" & $competiciones->firmab!="null") { ?> id="modal-body1" <?php }  ?> class="row">
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
                                            $datas = ActaData::vercontenidos1($competiciones->id, $competiciones->id_rival);
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
        <label for="observacionb" class="form-label text-primary fw-bold">Observación del Equipo Visitante</label>
        <textarea style="font-size: 9px;" class="form-control" name="observacionb"><?= $competiciones->observacionb; ?></textarea>
    </div>
    <div class="d-flex align-items-center">
        <label for="firma" class="form-label text-primary fw-bold me-2">Firma del equipo Visitante</label>
        <input style="font-size: 9px;" value="<?= $competiciones->firmab; ?>" type="text" name="firmab" class="form-control w-auto">
    </div>
    <div class="col-md-12 mb-3">
        <label for="firma" class="form-label text-primary fw-bold me-2">Acta</label>
        <div style="display: flex; align-items: center;">
            <input style="font-size: 9px; margin-right: 10px;" type="file" name="archivo" class="form-control w-auto">
            <input style="font-size: 9px;" value="<?= $competiciones->archivob;?>" type="hidden" name="archivo1" class="form-control w-auto">
            <?php if ($competiciones->archivob!="") {
                echo "<a href='storage/archivo/$competiciones->archivob' download style='font-size: 9px;'>Descargar</a>";
            } ?>
        </div>
    </div>
    <div class="modal-footer bg-info d-flex justify-content-between pb-0 border-top mt-3">
        <input type="hidden" name="id" value="<?= $competiciones->id; ?>">
        <input type="hidden" name="actions" value="58">
        <button type="button" class="btn btn-primary submit-firma-form1">Enviar Firma</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('.submit-firma-form1').click(function(e) {
            e.preventDefault();

            // Crear una nueva instancia de FormData y añadir los datos del formulario
            var formData = new FormData($('#firmaForm1')[0]);

            $.ajax({
                url: 'index.php?action=registro',
                type: 'POST',
                data: formData,
                processData: false, // Necesario para que jQuery no procese los datos
                contentType: false, // Necesario para que jQuery no establezca ningún content-type
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
                                            $datas4 = EquipoJugadorData::vercontenidos($competiciones->id_rival);
                                            $contador2 = 1;
                                            foreach ($datas4 as $data4) { ?>
                                                <tr>
                                                    <td><?php echo $contador2++; ?></td>
                                                    <td><?php echo $data4->codigofide; ?></td>
                                                    <td>
                                                        <form class="player-form">
                                                            <input type="hidden" name="competencias" value="<?php echo $competiciones->id; ?>">
                                                            <input type="hidden" name="equipo" value="<?php echo $competiciones->id_rival; ?>">
                                                            <input type="hidden" name="jugador" value="<?php echo $data4->id; ?>">
                                                            <input type="hidden" name="actions" value="63">
                                                            <button type="button" class="btn btn-light me-2 submit-player-form1"><?php echo $data4->apellido1 . ' ' . $data4->apellido2 . ', ' . $data4->nombre; ?></button>
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
                                                            <input type="hidden" name="equipo" value="<?php echo $competiciones->id_rival; ?>">
                                                            <input type="hidden" name="jugador" value="">
                                                            <input type="hidden" name="actions" value="63">
                                                            <button type="button" class="btn btn-light me-2 submit-player-form1">Incomparecencia</button>
                                                        </form>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            <p style="text-decoration: underline;">Orden de Fuerza</p>
                                        </tbody>
                                    </table>
                                    <p><i>Pinche sobre el jugador que desea incluir en el acta.</i></p>
                                </div>
                            </div>
                            <?php if ($identificador==1) { ?>
                            <hr>
                            <span>Arbitro</span>
                            <div <?php if ($competiciones->firma_arbitro!="") { ?> id="modal-body2" <?php }  ?> class="modal-body bg-light p-3 rounded">
                                <div class="row mb-3">
                                    <form id="firmaForm2" enctype="multipart/form-data" method="post" action="index.php?action=registro">
                                    <div class="col-md-4 mb-3">
                                        <label for="arbitro" class="form-label text-primary fw-bold">Arbitro</label>
                                        <select name="arbitro" class="form-select miSelect1">
                                            <option value="">Seleccionar</option>
                                            <?php $usuarioss = UserData::vercontenido();
                                            foreach ($usuarioss as $userss) { ?>
                                                <option <?php if ($userss->id==$competiciones->arbitro) { echo "selected"; } ?> value="<?= $userss->id; ?>"><?= $userss->nombre." ".$userss->apellido; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="observacion_arbitro" class="form-label text-primary fw-bold">Observación del Arbitro</label>
                                        <textarea class="form-control" name="observacion_arbitro"><?= $competiciones->observacion_arbitro;?></textarea>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <label for="firma_arbitro" class="form-label text-primary fw-bold me-2">Firma del Arbitro</label>
                                        <input type="text" value="<?= $competiciones->firma_arbitro;?>" name="firma_arbitro" class="form-control w-auto">
                                    </div>
                                    <div class="modal-footer bg-info d-flex justify-content-between pb-0 border-top mt-3">
                                        <input type="hidden" name="id" value="<?php echo $competiciones->id; ?>">
                                        <input type="hidden" name="actions" value="59">
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
                url: 'index.php?action=registro', // Asegúrate de que esta URL apunta al archivo correcto
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
                            <?php } ?>
                            <hr>
                            <form enctype="multipart/form-data" method="post" id="firmaForm3">
                            <span>Observaciones de F.M.A</span>
                            <div <?php if ($competiciones->aprobacion=="OK") { ?> id="modal-body3" <?php }  ?> class="modal-body bg-light p-3 rounded">
                                <div class="row mb-3" >
                                    <div class="col-md-12 mb-3">
                                        <label for="obervacion_fma" class="form-label text-primary fw-bold">Observaciones</label>
                                        <textarea class="form-control" name="obervacion_fma"><?php echo $competiciones->obervacion_fma; ?></textarea>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="aprobacion" class="form-label text-primary fw-bold">OK Acta F.M.A. (S/N)</label>
                                        <select name="aprobacion" class="form-select">
                                            <option value="N" <?= $competiciones->aprobacion == 'N' ? 'selected' : ''; ?>>N</option>
                                            <option value="OK" <?= $competiciones->aprobacion == 'OK' ? 'selected' : ''; ?>>OK</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer bg-info d-flex justify-content-between pb-0 border-top mt-3">
                                    <input type="hidden" name="id" value="<?php echo $competiciones->id; ?>">
                                    <input type="hidden" name="actions" value="60">
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
                url: 'index.php?action=registro', // Asegúrate de que esta URL apunta al archivo correcto
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
                                            url: 'index.php?action=updateTable2s',
                                            type: 'POST',
                                            data: { competencia_id: <?php echo $competiciones->id; ?>, equipo_id: <?php echo $competiciones->id_rival; ?> },
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
        url: 'index.php?action=registro',
        type: 'POST',
        data: {
            actions:62,
            id: <?php echo $competiciones->id; ?>,
            encuentro: <?php echo $competiciones->id_rival; ?>,
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
                                    //         url: 'index.php?action=registro',
                                    //         type: 'POST',
                                    //         data: {
                                    //             id: <?php echo $competiciones->id; ?>,
                                    //             encuentro: <?php echo $competiciones->id_rival; ?>,
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
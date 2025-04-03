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
<?php  $competiciones = CompetenciasData::verid($_POST['competiciones']);
$salas = SalaData::verid($competiciones->sala);
$aquipoa = EquipoData::verid($_POST['equipo_a']);
$aquipob = EquipoData::verid($_POST['equipo_b']);
$compet = CompeticionData::verid($salas->competicion); ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <?php if (isset($_SESSION['success_message'])) : ?>
                    <script>
                        Swal.fire({
                            icon: "success",
                            title: "Éxito",
                            text: "<?php echo $_SESSION['success_message']; ?>",
                            timer: 1000,
                            showConfirmButton: true
                        });
                    </script>
                    <?php unset($_SESSION['success_message']); ?>
                <?php endif; ?>
                <?php if (isset($_SESSION['error_message'])) : ?>
                    <script>
                        toastr.error("<?php echo $_SESSION['error_message']; ?>" );
                    </script>
                    <?php unset($_SESSION['error_message']); ?>
                <?php endif; ?>
                <?php if (isset($_SESSION['success_messagea'])) : ?>
                    <script>
                        new Noty({
                            type: "success",
                            text: "<?php echo $_SESSION['success_messagea']; ?>",
                            timeout: 1000
                        }).show();
                    </script>
                    <?php unset($_SESSION['success_messagea']); ?>
                <?php endif; ?>
                <?php if (isset($_SESSION['success_messagea1'])) : ?>
                    <script>
                        new Noty({
                            type: "error",
                            text: "<?php echo $_SESSION['success_messagea1']; ?>",
                            timeout: 1000 
                        }).show();
                    </script>
                    <?php unset($_SESSION['success_messagea1']); ?>
                <?php endif; ?>
                <?php if (isset($_SESSION['eliminado'])) : ?>
                    <script>
                        Swal.fire({
                            icon: "error",
                            title: "Eliminado",
                            text: "<?php echo $_SESSION['eliminado']; ?>",
                            timer: 1000,
                            showConfirmButton: true
                        });
                    </script>
                    <?php unset($_SESSION['eliminado']); ?>
                <?php endif; ?>
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
                                    <p><i class="ri-file-list-3-line text-primary"></i> <span id="id" class="text-muted"><?= $aquipoa->nombre; ?> VS <?= $aquipob->nombre; ?></span></p>
                                    <a href="jornada" class="btn btn-light" ><i class=" ri-arrow-go-back-line align-bottom me-1"></i> Volver</a>
                                </div>
                            </div>
                            <P><span><?= $aquipoa->nombre; ?></span></P>
                            <div <?php if ($_POST['firma_a']!="" & $_POST['firma_a']!="null") { ?> id="modal-body1" <?php }  ?> class="row">
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
                                            <textarea style="font-size: 9px;" class="form-control" name="observacion"><?= $_POST['observacion_a'];?></textarea>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <label for="firma" class="form-label text-primary fw-bold me-2">Firma del equipo Local</label>
                                            <input style="font-size: 9px;" value="<?= $_POST['firma_a'];?>" type="text" name="firma" class="form-control w-auto">
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
                                                // Serializar los datos del formulario
                                                var formData = $('#firmaForm').serialize();
                                                console.log('Datos del formulario:', formData); // Debug: Verificar datos serializados
                                                $.ajax({
                                                    url: 'index.php?action=apiregistrofirmai', // Asegúrate de que esta URL apunta al archivo correcto
                                                    type: 'POST',
                                                    data: formData,
                                                    success: function(response) {
                                                        console.log('Firma y observación actualizadas correctamente:', response);
                                                        alert('Firma y observación actualizadas correctamente.');
                                                    },
                                                    error: function(xhr, status, error) {
                                                        console.error('Error al actualizar la firma y observación:', xhr.responseText);
                                                        alert('Error al actualizar la firma y observación.');
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
                                                    <td><?php echo $data2->elo; ?></td>
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
                                        $('.resultado-select').each(function() {
                                            var value = $(this).val();
                                            if (value === '1') {
                                                total += 1;
                                            } else if (value === '1/2') {
                                                total += 0.5;
                                            } else if (value === '+') {
                                                total += 1; // Assuming '+' is counted as 1
                                            }
                                            // If '-' should also be considered, add logic accordingly
                                        });
                                        $('#resultado-total').text(total);
                                        $('#resultados-total').val(total);
                                        // Enviar el resultado al API
                                        $.ajax({
                                            url: 'index.php?action=apiregistroresultado',
                                            type: 'POST',
                                            data: {
                                                id: <?php echo $competiciones->id; ?>,
                                                encuentro: <?php echo $_POST['equipo_a']; ?>,
                                                resultado1: total
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
                            <div <?php if ($_POST['firma_b']!="" & $_POST['firma_b']!="null") { ?> id="modal-body1" <?php }  ?> class="row">
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
                                                    <textarea style="font-size: 9px;" class="form-control" name="observacion"><?= $_POST['observacion_b'];?></textarea>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <label for="firma" class="form-label text-primary fw-bold me-2">Firma del equipo Local</label>
                                                    <input style="font-size: 9px;" value="<?= $_POST['firma_b'];?>" type="text" name="firma" class="form-control w-auto">
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
                                                        // Serializar los datos del formulario
                                                        var formData = $('#firmaForm1').serialize();
                                                        console.log('Datos del formulario:', formData); // Debug: Verificar datos serializados
                                                        $.ajax({
                                                            url: 'index.php?action=apiregistrofirmai', // Asegúrate de que esta URL apunta al archivo correcto
                                                            type: 'POST',
                                                            data: formData,
                                                            success: function(response) {
                                                                console.log('Firma y observación actualizadas correctamente:', response);
                                                                alert('Firma y observación actualizadas correctamente.');
                                                            },
                                                            error: function(xhr, status, error) {
                                                                console.error('Error al actualizar la firma y observación:', xhr.responseText);
                                                                alert('Error al actualizar la firma y observación.');
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
                                                    <td><?php echo $data4->elo; ?></td>
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
                                            <p style="text-decoration: underline;">Orden de Fuerza</p>
                                        </tbody>
                                    </table>
                                    <p><i>Pinche sobre el jugador que desea incluir en el acta.</i></p>
                                </div>
                            </div>
                            <hr>
                            <span>Arbitro</span>
                            <div <?php if ($competiciones->firma_arbitro!="") { ?> id="modal-body2" <?php }  ?> class="modal-body bg-light p-3 rounded">
                                <div class="row mb-3">
                                    <form id="firmaForm2" enctype="multipart/form-data" method="post" action="index.php?action=registro">
                                    <div class="col-md-4 mb-3">
                                        <label for="arbitro" class="form-label text-primary fw-bold">Arbitro</label>
                                        <select name="arbitro" class="form-select">
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
                                                                console.log('Firma y observación actualizadas correctamente:', response);
                                                                alert('Firma y observación actualizadas correctamente.');
                                                            },
                                                            error: function(xhr, status, error) {
                                                                console.error('Error al actualizar la firma y observación:', xhr.responseText);
                                                                alert('Error al actualizar la firma y observación.');
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
                            <div <?php if ($competiciones->aprobacion=="OK") { ?> id="modal-body3" <?php }  ?> class="modal-body bg-light p-3 rounded">
                                <div class="row mb-3" >
                                    <div class="col-md-12 mb-3">
                                        <label for="observacion_fma" class="form-label text-primary fw-bold">Observaciones</label>
                                        <textarea class="form-control" name="observacion_fma"><?php echo $competiciones->obervacion_fma; ?></textarea>
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
                                                                console.log('Firma y observación actualizadas correctamente:', response);
                                                                alert('Firma y observación actualizadas correctamente.');
                                                            },
                                                            error: function(xhr, status, error) {
                                                                console.error('Error al actualizar la firma y observación:', xhr.responseText);
                                                                alert('Error al actualizar la firma y observación.');
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

                                    // Function to calculate the total result
                                    function calculateTotal1() {
                                        var total = 0;
                                        $('.resultado-select1').each(function() {
                                            var value = $(this).val();
                                            if (value === '1') {
                                                total += 1;
                                            } else if (value === '1/2') {
                                                total += 0.5;
                                            } else if (value === '+') {
                                                total += 1; // Assuming '+' is counted as 1
                                            }
                                            // If '-' should also be considered, add logic accordingly
                                        });
                                        $('#resultado-total1').text(total);
                                        // Enviar el resultado al API
                                        $.ajax({
                                            url: 'index.php?action=apiregistroresultado',
                                            type: 'POST',
                                            data: {
                                                id: <?php echo $competiciones->id; ?>,
                                                encuentro: <?php echo $_POST['equipo_b']; ?>,
                                                resultado1: total
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
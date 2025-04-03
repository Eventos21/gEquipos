<style>
    .btn {
        font-size: 11px; 
        padding: 5px 10px; 
    }
    #customerTable th,
    #customerTable td {
        font-size: 11px; 
        padding: 8px; 
    }
</style>
<?php  $competiciones = CompetenciasData::verid($_POST['competiciones']);
$salas = SalaData::verid($competiciones->sala);
$aquipoa = EquipoData::verid($_POST['equipo_a']);
$aquipob = EquipoData::verid($_POST['equipo_b']); ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <!-- <h1 class="mb-0 font-size-18">Gestión de Clubes</h1> -->
                    </div>
                </div>
            </div>
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
                            <div class="row">
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
                                <button type="button" class="btn btn-light me-2 submit-player-form"><?php echo $data2->apellido1 . ' ' . $data2->apellido2 . ' ' . $data2->nombre; ?></button>
                            </form>
                        </td>
                        <td><?php echo $data2->elo; ?></td>
                    </tr>
                <?php } ?>
                <p style="text-decoration: underline;">Orden de Fuerza</p>
            </tbody>
        </table>
        <p><i>Pinche sobre el jugador que desea incluir en el acta.</i></p>
<script>
$(document).ready(function() {
    // Function to handle form submission for adding a player
    $('.submit-player-form').click(function(e) {
        e.preventDefault();
        var form = $(this).closest('form');
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
    }

    // Attach event handlers initially
    attachHandlers();
    calculateTotal(); // Calculate the total initially
});
</script>

<!--         <script>
$(document).ready(function() {
    $('.submit-player-form').click(function(e) {
        e.preventDefault();
        var form = $(this).closest('form');
        $.ajax({
            url: 'index.php?action=registro',
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                // Procesar la respuesta del servidor
                updateTable1();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    function updateTable1() {
        $.ajax({
            url: 'index.php?action=updateTable1',
            type: 'POST',
            data: { competencia_id: <?php echo $competiciones->id; ?>, equipo_id: <?php echo $_POST['equipo_a']; ?> },
            success: function(response) {
                $('#customerTable1 tbody').html(response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
    function attachDeleteHandlers() {
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
    }
});
</script> -->
    </div>
</div>

                            <P><span><?= $aquipob->nombre; ?></span></P>
                            <div class="row">
                                <div class="col-md-6">
                                    <table id="customerTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%; font-size: 10px;">
                                        <thead>
                                            <tr class="table-primary">
                                                <th>Nº</th>
                                                <th>Código</th>
                                                <th>Jugador</th>
                                                <th>resultado</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $datas1 = EquipoJugadorData::vercontenidos($_POST['equipo_b']);
                                            $contador = 1;
                                            foreach ($datas1 as $data1) { ?>
                                                <tr>
                                                    <td><?= $contador++; ?></td>
                                                    <td><?= $salas->codigo;?></td>
                                                    <td><?= $data1->apellido1.' '.$data1->apellido2.' '.$data1->nombre;?></td>
                                                    <td>
                                                        <select class="" name="resultados">
                                                            <option value="">Elegir</option>
                                                           <option value="1">1</option>
                                                           <option value="1/2">1/2</option>
                                                           <option value="0">0</option>
                                                           <option value="+">+</option>
                                                           <option value="-">-</option>
                                                        </select>
                                                    </td>
                                                    <td><a class="add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#exampleModalLong">Limpiar</a></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModalLong" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-5">
      <div class="modal-header bg-info">
        <h5 class="modal-title text-white" id="exampleModalLabel">Nuevo registro</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form enctype="multipart/form-data" method="POST" class="tablelist-form" autocomplete="off" action="index.php?action=registro">
        <div class="modal-body bg-light">
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label" for="first-name"> Código</label>
                    <?php
                    function generateClassroomCode($length = 10) {
                        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
                        $charactersLength = strlen($characters);
                        $randomString = '';
                        for ($i = 0; $i < $length; $i++) {
                            $randomString .= $characters[rand(0, $charactersLength - 1)];
                        }
                        return $randomString;
                    }
                    $classroomCode = generateClassroomCode();
                    ?>
                    <!-- <div class="classroom-code" id="classroom-code">
                        <?= $classroomCode ?>
                    </div> -->
                    <input type="text" readonly="readonly" class="form-control" name="codigo" value="<?= $classroomCode ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="first-name"> Cantidad de Equipos</label>
                    <input type="text" class="form-control" name="cantidadequipo">
                </div>
                <div class="col-md-12"> 
                    <label class="form-label" for="first-name"> Nombre del Club</label>
                    <input class="form-control" name="nombre" type="text" aria-label="First name" required>
                </div>
                <div class="col-md-12"> 
                    <label class="form-label" for="first-name"> Teléfono</label>
                    <input class="form-control" name="telefono" type="text" aria-label="First name">
                </div>
                <div class="col-md-12"> 
                    <label class="form-label" for="first-name"> Correo</label>
                    <input class="form-control" name="correo" type="email" aria-label="First name">
                </div>
                <div class="col-md-12"> 
                    <label class="form-label" for="first-name"> Dirección</label>
                    <input class="form-control" name="direccion" type="text" aria-label="First name">
                </div>
                <div class="col-md-12"> 
                    <label class="form-label" for="first-name"> Responsable</label>
                    <select class="form-control" name="responsable" required id="select-usuario"></select>
                </div>
            </div>
          </div>
          <div class="modal-footer bg-info d-flex justify-content-between pb-0">
              <input class="form-control" type="hidden" name="actions" value="7">
              <button type="button" class="btn btn-outline-light me-2" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-light">Guardar registro</button>
            </div>
        </form>
        
    </div>
  </div>
</div>
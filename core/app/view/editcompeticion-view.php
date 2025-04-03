<?php $padres = PadreCompeticionData::verid($_GET['tid']);
$totalregistrado = count(CompeticionData::vercontenidos($_GET['tid'])); ?>
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
                            <h5 class="card-title mb-0 text-white">Actualizar datos</h5>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12 border rounded p-3 shadow-sm bg-light">
                                <div class="row align-items-center mb-3">
                                    <div class="col-md-1 text-primary">
                                        <i class="ri-user-line ri-xl"></i>
                                    </div>
                                    <div class="col-md-11">
                                        <p class="text-muted mb-0"><strong>ID:</strong> <?= $padres->id; ?></p>
                                    </div>
                                </div>
                                <div class="row align-items-center mb-3">
                                    <div class="col-md-1 text-primary">
                                        <i class="ri-file-list-3-line ri-xl"></i>
                                    </div>
                                    <div class="col-md-11">
                                        <p class="text-muted mb-0"><strong>Liga:</strong> <?= $padres->nombreliga; ?></p>
                                    </div>
                                </div>
                                <div class="row align-items-center mb-3">
                                    <div class="col-md-1 text-primary">
                                        <i class="ri-bank-line ri-xl"></i>
                                    </div>
                                    <div class="col-md-11">
                                        <p class="text-muted mb-0"><strong>Ascenso:</strong> <?= $padres->tipoascenso; ?></p>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-md-1 text-primary">
                                        <i class="ri-bank-card-line ri-xl"></i>
                                    </div>
                                    <div class="col-md-11">
                                        <p class="text-muted mb-0"><strong>Cantidad de Grupos:</strong> <?= $padres->cantidad; ?></p>
                                        <input type="hidden" id="cantidad" value="<?= $padres->cantidad-$totalregistrado;?>">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <table class="table table-bordered dt-responsive nowrap table-striped align-middle cambios" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Liga</th>
                                        <th>Categoria</th>
                                        <th>Sistema</th>
                                        <th>Ascenso</th>
                                        <th>Rondas</th>
                                        <th>Jugadores</th>
                                        <th>Grupo</th>
                                        <th width="50px">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $datos = CompeticionData::vercontenidos($padres->id);
                                    foreach ($datos as $key => $data) { ?>
                                        <tr>
                                            <td><?= $data->liganombre;?></td>
                                            <td><?= $data->nombregrupo;?></td>
                                            <td><?= $data->tipocompinombre;?></td>
                                            <td><?= $data->tipoascenso;?></td>
                                            <td><?= $data->rondas;?></td>
                                            <td><?= $data->cantidajugadores;?></td>
                                            <td><?= $data->grupo;?></td>
                                            <td><button type="button" class="btn btn-primary btn-sm edit1-btn" data-bs-toggle="modal" data-bs-target="#EditarModal-<?= $data->id; ?>">Editar</button> <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#eliminarmodal-<?= $data->id; ?>">Eliminar</button>
                                            </td>
<div class="modal fade" id="EditarModal-<?= $data->id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content border-5">
          <div class="modal-header bg-info">
            <h5 class="modal-title text-white" id="exampleModalLabel">Actualizar Registro</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form enctype="multipart/form-data" method="post" action="index.php?action=registro">
            <div class="modal-body bg-light">
                <div class="row">
                    <div class="col-md-3"> 
                        <label class="form-label" for="first-name"> Nombre de la Ronda</label>
                        <input class="form-control" name="nombregrupo" value="<?= $data->nombregrupo;?>" type="text" aria-label="First name" required>
                    </div>
                    <div class="col-md-4"> 
                        <label class="form-label" for="first-name"> Tipo de competición</label>
                        <select class="form-select" name="tipocompeticion" id="select-competicion">
                            <option value="">Seleccionar</option>
                            <?php $tipcompe = TipoCompeticionData::vercontenido();
                            foreach ($tipcompe as $tpco) { ?>
                                <option <?php if ($tpco->id==$data->tipocompeticion) { echo "selected"; } ?> value="<?= $tpco->id; ?>"><?= $tpco->nombre; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-4"> 
                        <label class="form-label" for="first-name">Ascenso</label>
                        <select class="form-select" name="tipoascenso" id="tipoascenso1">
                            <option  value="<?= $data->tipoascenso;?>"><?= $data->tipoascenso;?></option>
                            <option  value="Si">Si</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="col-md-3"> 
                        <label class="form-label" for="first-name"> Rondas</label>
                        <input class="form-control" value="<?= $data->rondas;?>" id="rondas1" name="rondas" type="text" aria-label="First name" required>
                    </div>
                    <div class="col-md-2"> 
                        <label class="form-label" for="first-name"> Jugadores</label>
                        <input class="form-control" value="<?= $data->cantidajugadores;?>" id="cantidajugadores1" name="cantidajugadores" type="text" aria-label="First name" required>
                    </div>
                    <div class="col-md-2"> 
                        <label class="form-label" for="first-name"> Grupo</label>
                        <select class="form-select" name="grupo">
                            <option value="<?= $data->grupo;?>"><?= $data->grupo;?></option>
                            <option value="Único">Único</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="F">F</option>
                            <option value="G">G</option>
                            <option value="H">H</option>
                            <option value="I">I</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-info d-flex justify-content-between pb-0">
                <input class="form-control" type="hidden" name="actions" value="44">
                <input class="form-control" type="hidden" name="id" value="<?= $data->id;?>">
                <input class="form-control" type="hidden" name="tid" value="<?= $_GET['tid'];?>">
                <button type="button" class="btn btn-outline-light me-2" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-light me-2">Guardar cambios</button>
            </div>
        </form>
    </div>
</div>
</div>
<!-- Eliminar -->
<div class="modal fade" id="eliminarmodal-<?= $data->id; ?>" tabindex="-1" aria-labelledby="modalEliminarTitulo" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body text-center"> 
        <img src="storage/per/danger.gif" width="20%" alt="Advertencia" class="img-fluid mb-3">
        <h4 class="pb-2">Eliminar</h4>
        <p>¿Estás seguro de eliminar este registro?</p>
        <form class="needs-validation" novalidate method="post" action="index.php?action=registro">
            <input type="hidden" name="actions" value="45">
            <input class="form-control" type="hidden" name="id" value="<?= $data->id;?>">
            <input class="form-control" type="hidden" name="tid" value="<?= $_GET['tid'];?>">
          <div class="modal-footer justify-content-center">
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancelar</button>
            <button class="btn btn-danger" type="submit">Eliminar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <hr>
                            <div class="container mt-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header bg-primary text-white">
                                            <h5 class="card-title text-white">Crear Grupos</h5>
                                        </div>
                                        <form class="needs-validation" novalidate method="post" action="index.php?action=registro">
                                        <div class="card-body">
                                            <input type="hidden" name="contador" id="contador" class="form-control" readonly>
                                            <div class="d-flex mb-3">
                                                <button type="button" class="btn btn-primary mr-2" id="mi-boton" onclick="agregarFila()"><i class="ri ri-add-line"></i></button>
                                            </div>
                                            <table class="table table-bordered" id="tablaprueba">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th width="20px">Item</th>
                                                        <th>Nombre Grupo</th>
                                                        <th>T. Competeción</th>
                                                        <th>Ronda</th>
                                                        <th>Jugadores</th>
                                                        <th>Grupo</th>
                                                        <th width="10px"><i class="ri-delete-bin-5-fill"></i></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="d-flex">
                                            <input class="form-control" type="hidden" name="actions" value="46">
                                            <input class="form-control" type="hidden" name="tid" value="<?= $_GET['tid'];?>">
                                            <button type="submit" class="btn btn-light bg-info d-flex justify-content-between me-2">Guardar cambios</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script type="text/javascript">
                            function agregarFila() {
                                var maxFilas = parseInt(document.getElementById("cantidad").value);
                                var table = document.getElementById("tablaprueba");
                                
                                if (table.rows.length - 1 >= maxFilas) {
                                    alert("No se pueden agregar más filas. El número máximo de grupos faltantes es " + maxFilas);
                                    return;
                                }
                                
                                var newRow = table.insertRow(-1);
                                var cell1 = newRow.insertCell(0);
                                var cell2 = newRow.insertCell(1);
                                var cell3 = newRow.insertCell(2);
                                var cell4 = newRow.insertCell(3);
                                var cell5 = newRow.insertCell(4);
                                var cell6 = newRow.insertCell(5);
                                var cell7 = newRow.insertCell(6);
                                
                                cell1.innerHTML = table.rows.length - 1;
                                cell2.innerHTML = '<input type="text" required class="form-control" name="nombregrupo[]">';
                                
                                var selectTipoCompeticion = '<select required class="form-select" name="tipocompeticion[]">';
                                <?php $tiposcompeticiones = TipoCompeticionData::vercontenido(); ?>
                                <?php foreach ($tiposcompeticiones as $tipco) { ?>
                                    selectTipoCompeticion += '<option <?php if ($tipco->id == 1) { echo "selected"; } ?> value="<?= $tipco->id; ?>"><?= $tipco->nombre; ?></option>';
                                <?php } ?>
                                selectTipoCompeticion += '</select>';
                                cell3.innerHTML = selectTipoCompeticion;
                                
                                cell4.innerHTML = '<input type="text" class="form-control" required name="ronda[]">';
                                cell5.innerHTML = '<input type="text" class="form-control" required name="jugadores[]">';
                                
                                var selectGrupo = '<select class="form-select" name="grupo[]">';
                                selectGrupo += '<option value="Único">Único</option>';
                                selectGrupo += '<option value="A">A</option>';
                                selectGrupo += '<option value="B">B</option>';
                                selectGrupo += '<option value="C">C</option>';
                                selectGrupo += '<option value="D">D</option>';
                                selectGrupo += '<option value="F">F</option>';
                                selectGrupo += '<option value="G">G</option>';
                                selectGrupo += '<option value="H">H</option>';
                                selectGrupo += '<option value="I">I</option>';
                                selectGrupo += '</select>';
                                cell6.innerHTML = selectGrupo;
                                
                                cell7.innerHTML = '<a onclick="eliminarFila(this)"><i class="ri-delete-bin-5-fill"></i></a>';
                                actualizarContador();
                            }

                            function eliminarFila(btn) {
                                var row = btn.parentNode.parentNode;
                                row.parentNode.removeChild(row);
                                actualizarContador();
                            }

                            function actualizarContador() {
                                var table = document.getElementById("tablaprueba");
                                document.getElementById('contador').value = table.rows.length - 1;
                                for (var i = 1; i < table.rows.length; i++) {
                                    table.rows[i].cells[0].innerHTML = i;
                                }
                            }
                        </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
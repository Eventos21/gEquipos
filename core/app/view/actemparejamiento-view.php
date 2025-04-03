<?php
if (isset($_SESSION["conticomtc"]) && isset($_SESSION["typeuser"]) && ($_SESSION["typeuser"] == 1 || $_SESSION["typeuser"] == 2)) { 
 $salas = SalaData::verid($_GET['tid']); ?>
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
                            <h5 class="card-title mb-0 text-white">
                                <i class="fas fa-warehouse me-2"></i>Lista de Jornadas de la Sala
                            </h5>
                            <a href="emparejamientos" class="btn btn-light btn-sm"><i class="fas fa-arrow-left"></i> Retroceder</a>
                        </div>
                        <div class="card-body">
                            <!-- <div class="form-group p-4 bg-white border rounded shadow">
                                
                            </div> -->
                            <table class="cambios table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                <thead>
                                    <tr class="table-primary">
                                        <th>Ronda</th>
                                        <th>Competidor</th>
                                        <th>Valor Nº</th>
                                        <th>Rival</th>
                                        <th>Valor Nº</th>
                                        <th>Fecha</th>
                                        <th width="5px">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $datos = SalaPersonalizadaData::vercontenidos1($salas->id);
                                    foreach ($datos as $data) { ?>
                                        <tr>
                                            <td><?= $data->ronda;?></td>
                                            <td><?= $data->id_competidor;?></td>
                                            <td><?= $data->equipo_competidor;?></td>
                                            <td><?= $data->id_rival;?></td>
                                            <td><?= $data->equipo_rival;?></td>
                                            <td><?= $data->fecha;?></td>
                                            <td><a  data-bs-toggle="modal"  data-bs-target="#EditarModal-<?= $data->id;?>"><i class=" ri-edit-2-fill align-bottom me-1"></i></a> <a data-bs-toggle="modal"  data-bs-target="#eliminarmodal-<?= $data->id;?>"><i class="ri-delete-bin-2-line align-bottom me-1"></i></a></td>
<!-- Modal Editar -->
<div class="modal fade" id="EditarModal-<?= $data->id;?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-5">
      <div class="modal-header bg-info">
        <h5 class="modal-title text-white" id="exampleModalLabel">Actualizar registro</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form enctype="multipart/form-data" method="post" action="index.php?action=registro">
        <div class="modal-body bg-light">
            <div class="row">
                <div class="col-md-12"> 
                    <label class="form-label" for="first-name"> Ronda</label>
                    <input class="form-control" value="<?= $data->ronda;?>" name="ronda" type="text" aria-label="First name" required>
                </div>
                <div class="col-md-12"> 
                    <label class="form-label" for="first-name"> Equipo A <b>Número</b></label>
                    <input class="form-control" value="<?= $data->equipo_competidor;?>" name="equipo_competidor" type="text" aria-label="First name" required>
                </div>
                <div class="col-md-12"> 
                    <label class="form-label" for="first-name"> Equipo B <b>Número</b></label>
                    <input class="form-control" value="<?= $data->equipo_rival;?>" name="equipo_rival" type="text" aria-label="First name" required>
                </div>
                <div class="col-md-12"> 
                    <label class="form-label" for="first-name"> Fecha</label>
                    <input class="form-control" value="<?= $data->fecha;?>" name="fecha" type="date" aria-label="First name" required>
                </div>
            </div>
          </div>
          <div class="modal-footer bg-info d-flex justify-content-between pb-0">
            <input class="form-control" type="hidden" name="actions" value="54">
            <input class="form-control" type="hidden" name="id" value="<?= $data->id;?>">
            <input class="form-control" type="hidden" name="tid" value="<?= $salas->id;?>">
            <button type="button" class="btn btn-outline-light me-2" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-light me-2">Guardar cambios</button>
          </div>
        </form>
    </div>
  </div>
</div>
<!-- Modal Eliminar -->
<div class="modal fade" id="eliminarmodal-<?= $data->id;?>" tabindex="-1" aria-labelledby="modalEliminarTitulo" aria-hidden="true">
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
        <input type="hidden" name="actions" value="55">
        <input class="form-control" type="hidden" name="id" value="<?= $data->id;?>">
        <input class="form-control" type="hidden" name="tid" value="<?= $salas->id;?>">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } else {
    header("Location: ./"); 
    exit();
} ?>
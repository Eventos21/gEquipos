<?php
if (
    isset($_SESSION["conticomtc"]) && 
    isset($_SESSION["typeuser"]) && $_SESSION["typeuser"] == 1 && 
    isset($_SESSION["cargo"]) && $_SESSION["cargo"] == 1
) {
?>
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
                            <h5 class="card-title mb-0 text-white">Lista de registro de Temporadas</h5>
                            <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#exampleModalLong">
                                <i class="ri-add-line align-bottom me-1"></i> Nuevo registro
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="customerTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                <thead>
                                    <tr class="table-primary">
                                        <th>Temporada</th>
                                        <th>Inicia</th>
                                        <th>Finaliza</th>
                                        <!-- <th>Limite</th> -->
                                        <th width="10px"><i class="ri-checkbox-circle-line"></i></th>
                                        <th width="50px">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Datos del club -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Editar -->
<div class="modal fade" id="EditarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <label class="form-label" for="first-name"> Nombre de la temporada</label>
                    <textarea name="nombre" id="nombre" class="form-control"></textarea>
                </div>
                <div class="col-md-5"> 
                    <label class="form-label" for="first-name"> Fecha de inicio</label>
                    <input class="form-control" name="inicio" id="inicio" type="date" aria-label="First name" required>
                </div>
                <div class="col-md-5"> 
                    <label class="form-label" for="first-name"> Fecha final</label>
                    <input class="form-control" name="fin" id="fin" type="date" aria-label="First name" required>
                </div>
                <!-- <div class="col-md-4"> 
                    <label class="form-label" for="first-name"> Limite de entregas</label> -->
                    <input class="form-control" name="limite" id="limite" type="hidden" aria-label="First name">
                <!-- </div> -->
                <div class="col-md-2">
                    <label class="form-check-label" for="customSwitchsizelg">Estado</label>
                    <div class="form-check form-switch form-switch-lg" dir="ltr">
                        <input type="checkbox" name="archivado" class="form-check-input form-control" id="archivado">

                    </div>
                </div>
            </div>
        </div>
          <div class="modal-footer bg-info d-flex justify-content-between pb-0">
            <input class="form-control" type="hidden" name="actions" value="20">
            <input class="form-control" type="hidden" name="id" id="ids">
            <button type="button" class="btn btn-outline-light me-2" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-light me-2">Guardar Cambio</button>
          </div>
        </form>
    </div>
  </div>
</div>
<!-- Modal Eliminar -->
<div class="modal fade" id="eliminarmodal" tabindex="-1" aria-labelledby="modalEliminarTitulo" aria-hidden="true">
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
          <input type="hidden" name="actions" value="21">
          <input type="hidden" name="id" id="id">
          <div class="modal-footer justify-content-center">
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancelar</button>
            <button class="btn btn-danger" type="submit">Eliminar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal de Registro -->
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
                <div class="col-md-12"> 
                    <label class="form-label" for="first-name"> Nombre de la temporada</label>
                    <textarea name="nombre" class="form-control"></textarea>
                </div>
                <div class="col-md-5"> 
                    <label class="form-label" for="first-name"> Fecha de inicio</label>
                    <input class="form-control" name="inicio" type="date" aria-label="First name" required>
                </div>
                <div class="col-md-5"> 
                    <label class="form-label" for="first-name"> Fecha final</label>
                    <input class="form-control" name="fin" type="date" aria-label="First name" required>
                </div>
                <!-- <div class="col-md-4"> 
                    <label class="form-label" for="first-name"> Limite de entregas</label> -->
                    <input class="form-control" name="limite" type="hidden" aria-label="First name">
                <!-- </div> -->
            </div>
        </div>
          <div class="modal-footer bg-info d-flex justify-content-between pb-0">
              <input class="form-control" type="hidden" name="actions" value="19">
              <button type="button" class="btn btn-outline-light me-2" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-light">Guardar registro</button>
            </div>
        </form>
        
    </div>
  </div>
</div>
<script>
    $(document).ready(function() {
        $('#customerTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "index.php?action=apitemporada",
            "columns": [
                { "data": function(row) {
                        return row.nombre ;
                    }
                },
                { 
                    "data": "inicio",
                    "render": function(data, type, row) {
                        return moment(data).format('DD-MM-YYYY');
                    }
                },
                { 
                    "data": "fin",
                    "render": function(data, type, row) {
                        return moment(data).format('DD-MM-YYYY');
                    }
                },
                // { 
                //     "data": "limite",
                //     "render": function(data, type, row) {
                //         return moment(data).format('DD-MM-YYYY');
                //     }
                // },
                { "data": "archivado",
                    "render": function(data, type, row) {
                        if(data == 1) {
                            return '<i class="ri ri-checkbox-circle-line text-success"></i>';
                        } else {
                            return '<i class="ri  ri-close-circle-line text-danger"></i>';
                        }
                    }
                },
                {
                    "data": null,
                    "render": function (data, type, row) {
                        return '<button class="btn btn-primary btn-sm edit-btn" data-id="' + row.id + '"><i class="ri-edit-2-line"></i></button>' + ' ' + 
                                   '<button class="btn btn-danger btn-sm delete-btn" data-id="' + row.id + '"><i class="ri-delete-bin-2-line"></i></button>' + ' ' + '<a href="index.php?action=archivado&tid=' + row.id + '&tid2=1" title="Archivar" class="btn btn-info btn-sm archive-btn"><i class="ri-briefcase-fill"></i></a>';
                    }
                }

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
        $('#customerTable').on('click', '.edit-btn', function() {
            let id = $(this).data('id');
            $.get("index.php?action=gettempora&id=" + id, function(data) {
                $('#nombre').val(data.nombre);
                $('#inicio').val(data.inicio);
                $('#fin').val(data.fin);
                $('#limite').val(data.limite);
                $('#ids').val(data.id);
                if(data.archivado == 1) {
                    $('#archivado').prop('checked', true);
                } else {
                    $('#archivado').prop('checked', false);
                }
                $('#EditarModal').modal('show');
            }, "json");
        });
        $('#customerTable').on('click', '.delete-btn', function() {
            let id = $(this).data('id');
            $('#id').val(id);
            $('#confirm-delete-btn').data('id', id);
            $('#eliminarmodal').modal('show');
        });
    });
</script>
<?php } else {
    header("Location: ./"); 
    exit();
} ?>
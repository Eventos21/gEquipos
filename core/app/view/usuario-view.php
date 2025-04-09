<?php
session_start();
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
                            <h5 class="card-title mb-0 text-white">Lista de registro de administradores del sistema</h5>
                            <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#exampleModalLong">
                                <i class="ri-add-line align-bottom me-1"></i> Nuevo registro
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="customerTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                <thead>
                                    <tr class="table-primary">
                                        <th>Nombres y apellidos</th>
                                        <th>Usuario</th>
                                        <th>Teléfono</th>
                                        <th>Email</th>
                                        <th>Perfil</th>
                                        <th>Club</th>
                                        <th>Estado</th>
                                        <th>Acción</th>
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
                <a href="URL_DE_LA_IMAGEN" target="_blank">
                    <img id="imagen1" alt="">
                </a>
                  <style>#imagen1 {
                      max-width: 20%;
                      height: auto;
                      border: 2px solid #ccc;
                      border-radius: 10px;
                      box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
                      display: block;
                      margin: 0 auto;
                  }
                </style>
                <div class="col-md-6">
                    <label class="form-label" for="first-name"> Rol</label>
                    <select class="form-control" id="cargo" required name="cargo">
                        <option value="">Elegir</option>
                    </select>
                  </div>
                  <div class="col-md-6"> 
                    <label class="form-label" for="first-name"> Club</label>
                    <select class="form-control miSelect1" id="clubs" name="club">
                        <option value="">Elegir</option>
                    </select>
                  </div>
                  <div class="col-md-12"> 
                    <label class="form-label" for="first-name"> Nombre</label>
                    <input class="form-control" name="nombre" id="nombre" type="text" aria-label="First name" required>
                  </div>
                  <div class="col-md-12"> 
                    <label class="form-label" for="first-name"> Apellido</label>
                    <input class="form-control" name="apellido" id="apellido" type="text" aria-label="First name" required>
                  </div>
                  <div class="col-md-6"> 
                    <label class="form-label" for="first-name"> Usuario</label>
                    <input type="text" class="form-control" id="ci" name="ci" required>
                  </div>
                  <div class="col-md-6"> 
                    <label class="form-label" for="first-name"> Teléfono</label>
                    <input class="form-control" name="telefono" id="telefono" type="text" aria-label="First name">
                  </div>
                  <div class="col-md-12"> 
                    <label class="form-label" for="first-name"> Email</label>
                    <input class="form-control" required name="email" id="email" type="email" aria-label="First name">
                  </div>
                  <div class="col-md-4"> 
                    <label class="form-label" for="first-name"> Foto</label>
                    <input class="form-control" name="imagen" type="file" aria-label="First name">
                    <input type="hidden" name="imagen1Campo" id="imagen1Campo" class="form-control" />
                  </div>
                  <div class="col-md-6"> 
                    <label class="form-label" for="first-name"> Fecha de nacimiento</label>
                    <input class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" type="date" aria-label="First name">
                  </div>
                  <div class="col-md-2">
                    <label class="form-check-label" for="customSwitchsizelg">Activo</label>
                    <div class="form-check form-switch form-switch-lg" dir="ltr">
                        <input type="checkbox" name="estado" class="form-check-input" id="customSwitchsizelg">
                    </div>
                  </div>
                  <hr>
                  <div class="col-md-6">
                    <label for="usuario-field">Nuevo usuario:</label>
                    <input type="text" name="usuario" class="form-control" />
                </div>
                <div class="col-md-6">
                    <label for="password-field">Password:</label>
                    <input type="password" name="password" class="form-control" />
                </div>
            </div>
          </div>
          <div class="modal-footer bg-info d-flex justify-content-between pb-0">
            <input class="form-control" type="hidden" name="actions" value="5">
            <input class="form-control" type="hidden" name="id" id="ids">
            <button type="button" class="btn btn-outline-light me-2" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-light me-2">Guardar cambios</button>
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
          <input type="hidden" name="actions" value="6">
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
                <div class="col-md-6">
                    <label class="form-label" for="first-name"> Rol</label>
                    <select class="form-control" id="cargo-fieldd" required name="cargo">
                        <option value="">Elegir</option>
                    </select>
                  </div>
                  <div class="col-md-6"> 
                    <label class="form-label" for="first-name"> Club</label>
                    <select class="form-control miSelect1" id="select-club" name="club">
                        <option value="">Elegir</option>
                    </select>
                  </div>
                  <div class="col-md-12"> 
                    <label class="form-label" for="first-name"> Nombre</label>
                    <input class="form-control" name="nombre" id="validationCustom01" type="text" aria-label="First name" required>
                  </div>
                  <div class="col-md-12"> 
                    <label class="form-label" for="first-name"> Apellido</label>
                    <input class="form-control" name="apellido" id="validationCustom01" type="text" aria-label="First name" required>
                  </div>
                  <div class="col-md-6"> 
                    <label class="form-label" for="first-name"> CI</label>
                    <input type="text" class="form-control" name="ci" required>
                  </div>
                  <div class="col-md-6"> 
                    <label class="form-label" for="first-name"> Teléfono</label>
                    <input class="form-control" name="telefono" type="text" aria-label="First name">
                  </div>
                  <div class="col-md-12"> 
                    <label class="form-label" for="first-name"> Email</label>
                    <input class="form-control" required name="email" type="email" aria-label="First name">
                  </div>
                  <div class="col-md-6"> 
                    <label class="form-label" for="first-name"> Foto</label>
                    <input id="file-upload" class="file-input" name="imagen" type="file" aria-label="Foto">
                    <span class="file-custom"></span>
                  </div>
                  <div class="col-md-6"> 
                    <label class="form-label" for="first-name"> Fecha de nacimiento</label>
                    <input class="form-control" name="fecha_nacimiento" type="date" aria-label="First name">
                  </div>
            </div>
          </div>
          <div class="modal-footer bg-info d-flex justify-content-between pb-0">
              <input class="form-control" type="hidden" name="actions" value="4">
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
            "ajax": "index.php?action=apiusuarios",
            "columns": [
                { "data": function(row) {
                        return row.nombre + ' ' + row.apellido;
                    }
                },
                { "data": "ci" },
                { "data": "telefono" },
                { "data": "email" },
                { "data": "cargos" },
                { "data": "clubs" },
                { "data": "estado",
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
                        return '<button class="btn btn-primary btn-sm edit-btn" data-id="' + row.id + '">Editar</button>' + ' ' 
                        + '<button class="btn btn-danger btn-sm delete-btn" data-id="' + row.id + '">Eliminar</button>';
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
        $('#exampleModalLong').on('show.bs.modal', function() {
            if ($('#cargo-fieldd option').length <= 1) {
                    $.ajax({
                        url: 'index.php?action=apicargos',
                        method: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            data.forEach(function(cargo) {
                                $('#cargo-fieldd').append($('<option>', {
                                    value: cargo.id,
                                    text: cargo.nombre
                                }));
                            });
                        }
                    });
                }
            if ($('#select-club option').length <= 1) {
                    $.ajax({
                        url: 'index.php?action=apiclubs',
                        method: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            data.forEach(function(club) {
                                $('#select-club').append($('<option>', {
                                    value: club.id,
                                    text: club.nombre
                                }));
                            });
                        }
                    });
                }
        });
        $('#customerTable').on('click', '.edit-btn', function() {
            let id = $(this).data('id');
            $.get("index.php?action=getusuario&id=" + id, function(data) {
                $('#nombre').val(data.nombre);
                $('#apellido').val(data.apellido);
                $('#ci').val(data.ci);
                $('#telefono').val(data.telefono);
                $('#email').val(data.email);
                $('#direccion').val(data.direccion);
                $('#fecha_nacimiento').val(data.fecha_nacimiento);
                $('#ids').val(data.id);
               if (data.imagen) {
                    var imagenURL = 'storage/archivo/' + data.imagen;
                    $('#imagen1').attr('src', imagenURL);
                    $('#imagen1Campo').val(data.imagen);
                } else {
                    $('#imagen1').attr('src', 'storage/per/logo.png');
                    $('#imagen1Campo').val(''); 
                }

                if(data.estado == 1) {
                    $('#customSwitchsizelg').prop('checked', true);
                } else {
                    $('#customSwitchsizelg').prop('checked', false);
                }
                $.ajax({
                    url: 'index.php?action=apicargos',
                    method: 'GET',
                    dataType: 'json',
                    success: function(cargos) {
                        $('#cargo').empty();
                        $('#cargo').append($('<option>', {value: '', text: 'Elegir'}));
                        cargos.forEach(function(cargo) {
                            $('#cargo').append($('<option>', {
                                value: cargo.id,
                                text: cargo.nombre
                            }));
                        });
                        $('#cargo').val(data.cargo);
                    }
                });
                // $.ajax({
                //     url: 'index.php?action=apiclubs',
                //     method: 'GET',
                //     dataType: 'json',
                //     data: { usuario_id: data.id },
                //     success: function (sucursales) {
                //         $('#sucursal').empty();
                //         $('#sucursal').append($('<option>', { value: '', text: 'Elegir' }));
                //         if (sucursales.length > 0) {
                //             sucursales.forEach(function (sucursal) {
                //                 $('#sucursal').append($('<option>', {
                //                     value: sucursal.id,
                //                     text: sucursal.nombre,
                //                     selected: (sucursal.selected === "1")
                //                 }));
                //             });
                //         }
                //     }
                // });
                $.ajax({
                    url: 'index.php?action=apiclubs',
                    method: 'GET',
                    dataType: 'json',
                    success: function(cargos) {
                        $('#clubs').empty();
                        $('#clubs').append($('<option>', {value: '', text: 'Elegir'}));
                        cargos.forEach(function(clubs) {
                            $('#clubs').append($('<option>', {
                                value: clubs.id,
                                text: clubs.nombre
                            }));
                        });
                        $('#clubs').val(data.club);
                    }
                });
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
<script>
    flatpickr("#datePicker", {
        plugins: [
            new flatpickr.plugins.monthSelect({shorthand: true, dateFormat: "m.y", altFormat: "F Y", theme: "light"}), // or "dark"
            new flatpickr.plugins.yearSelect({shorthand: true, dateFormat: "Y", altFormat: "Y", theme: "light"}) // or "dark"
        ],
        enableTime: false,
        dateFormat: "Y",
        defaultDate: new Date(),
        onChange: function(selectedDates, dateStr, instance) {
            // Puedes manejar cambios adicionales aquí si es necesario
        }
    });
</script>
<?php } else {
    header("Location: ./"); 
    exit();
} ?>
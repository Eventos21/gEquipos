<?php
if (
    isset($_SESSION["conticomtc"]) && 
    isset($_SESSION["typeuser"]) && $_SESSION["typeuser"] == 1 && 
    isset($_SESSION["cargo"]) && $_SESSION["cargo"] == 1
)  {
    function showAlert($type, $message, $library = 'swal', $title = '', $timer = 1000, $showConfirmButton = true) {
        if ($library === 'swal') {
            echo "<script>
                Swal.fire({
                    icon: '$type',
                    title: '$title',
                    text: '$message',
                    timer: $timer,
                    showConfirmButton: " . ($showConfirmButton ? 'true' : 'false') . "
                });
            </script>";
        } elseif ($library === 'toastr') {
            echo "<script>toastr.$type('$message');</script>";
        } elseif ($library === 'noty') {
            echo "<script>
                new Noty({
                    type: '$type',
                    text: '$message',
                    timeout: $timer
                }).show();
            </script>";
        }
    }
    if (isset($_SESSION['success_message'])) {
        showAlert('success', $_SESSION['success_message'], 'swal', 'Éxito');
        unset($_SESSION['success_message']);
    }
    if (isset($_SESSION['error_message'])) {
        showAlert('error', $_SESSION['error_message'], 'toastr');
        unset($_SESSION['error_message']);
    }
    if (isset($_SESSION['success_messagea'])) {
        showAlert('success', $_SESSION['success_messagea'], 'noty');
        unset($_SESSION['success_messagea']);
    }
    if (isset($_SESSION['success_messagea1'])) {
        showAlert('error', $_SESSION['success_messagea1'], 'noty');
        unset($_SESSION['success_messagea1']);
    }
    if (isset($_SESSION['eliminado'])) {
        showAlert('error', $_SESSION['eliminado'], 'swal', 'Eliminado');
        unset($_SESSION['eliminado']);
    }
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
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white d-flex align-items-center justify-content-end">
                            <h5 class="card-title mb-0 text-white">Lista de registro de Jugadores</h5>
                            <div class="ms-auto">
                                <button type="button" class="btn btn-light me-2 text-primary" data-bs-toggle="modal" data-bs-target="#impotarparticipante">
                                    <i class="ri-add-line align-bottom me-1"></i> Importar
                                </button>
                                <button type="button" class="btn btn-light text-info" data-bs-toggle="modal" data-bs-target="#exampleModalLong">
                                    <i class="ri-add-line align-bottom me-1"></i> Nuevo registro
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="customerTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                <thead>
                                    <tr class="table-primary">
                                        <th>Nombres y apellidos</th>
                                        <th>ID FIDE</th>
                                        <th>Fecha nacimiento</th>
                                        <th>Telefono</th>
                                        <th>Club</th>
                                        <th>Código FMA</th>
                                        <th>Elo</th>
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
                <div class="col-md-6"> 
                    <label class="form-label" for="first-name"> Apellido 1</label>
                    <input class="form-control" name="apellido1" id="apellido1" type="text" aria-label="First name" required>
                  </div>
                  <div class="col-md-6"> 
                    <label class="form-label" for="first-name"> Apellido 2</label>
                    <input class="form-control" name="apellido2" id="apellido2" type="text" aria-label="First name">
                  </div>
                  <div class="col-md-12"> 
                    <label class="form-label" for="first-name"> Nombre</label>
                    <input class="form-control" name="nombre" id="nombre" type="text" aria-label="First name" required>
                  </div>
                  <div class="col-md-6"> 
                    <label class="form-label" for="first-name"> Fecha de nacimiento</label>
                    <input type="date" class="form-control" name="nacimiento" id="nacimiento" placeholder="Seleccione el año">
                  </div>
                  <div class="col-md-6"> 
                    <label class="form-label" for="first-name"> Nº licencia</label>
                    <input class="form-control" name="numlicencia" id="numlicencia" type="text" aria-label="First name" required>
                  </div>
                  <div class="col-md-6"> 
                    <label class="form-label" for="first-name"> Código (Club)</label>
                    <!-- <input class="form-control" name="club" id="club" type="text" aria-label="First name"> -->
                    <select name="club" id="clud" class="form-select"></select>
                  </div>
                  <div class="col-md-6"> 
                    <label class="form-label" for="first-name"> Teléfono</label>
                    <input class="form-control" name="telefono" id="telefono" type="text" aria-label="First name">
                  </div>
                  <div class="col-md-6"> 
                    <label class="form-label" for="first-name"> Código federación</label>
                    <input class="form-control" name="codigofide" id="codigofide" type="text" aria-label="First name">
                  </div>
                  <div class="col-md-6"> 
                    <label class="form-label" for="first-name"> Elo</label>
                    <input class="form-control" name="elo" id="elo" type="text" aria-label="First name">
                  </div>
                  <div class="col-md-2"> 
                    <label class="form-label" for="exampleFormControlTextarea1">Estado</label>
                    <input type="checkbox" name="estado" class="form-check-input" id="estado">
                  </div>
            </div>
          </div>
          <div class="modal-footer bg-info d-flex justify-content-between pb-0">
            <input class="form-control" type="hidden" name="actions" value="29">
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
          <input type="hidden" name="actions" value="12">
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
                    <label class="form-label" for="first-name"> Apellido 1</label>
                    <input class="form-control" name="apellido1" id="validationCustom01" type="text" aria-label="First name" required>
                  </div>
                  <div class="col-md-6"> 
                    <label class="form-label" for="first-name"> Apellido 2</label>
                    <input class="form-control" name="apellido2" id="validationCustom01" type="text" aria-label="First name" required>
                  </div>
                  <div class="col-md-12"> 
                    <label class="form-label" for="first-name"> Nombre</label>
                    <input class="form-control" name="nombre" id="validationCustom01" type="text" aria-label="First name" required>
                  </div>
                  <div class="col-md-6"> 
                    <label class="form-label" for="first-name"> Fecha de nacimiento</label>
                    <input type="date" class="form-control" name="nacimiento" id="datePicker" placeholder="Seleccione el año">
                  </div>
                  <div class="col-md-6"> 
                    <label class="form-label" for="first-name"> Nº licencia</label>
                    <input class="form-control" name="numlicencia" id="validationCustom01" type="text" aria-label="First name" required>
                  </div>
                  <div class="col-md-6"> 
                    <label class="form-label" for="first-name"> Código (Club)</label>
                    <select name="club" id="select-clubs" class="form-select"></select>
                    <!-- <input class="form-control" name="club" id="validationCustom01" type="text" aria-label="First name"> -->
                  </div>
                  <div class="col-md-6"> 
                    <label class="form-label" for="first-name"> Teléfono</label>
                    <input class="form-control" name="telefono" id="validationCustom01" type="text" aria-label="First name">
                  </div>
                  <div class="col-md-6"> 
                    <label class="form-label" for="first-name"> Código federación</label>
                    <input class="form-control" name="codigofide" id="validationCustom01" type="text" aria-label="First name">
                  </div>
                  <div class="col-md-6"> 
                    <label class="form-label" for="first-name"> Elo</label>
                    <input class="form-control" name="elo" id="validationCustom01" type="text" aria-label="First name">
                  </div>
            </div>
          </div>
          <div class="modal-footer bg-info d-flex justify-content-between pb-0">
              <input class="form-control" type="hidden" name="actions" value="28">
              <button type="button" class="btn btn-outline-light me-2" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-light">Guardar registro</button>
            </div>
        </form>
        
    </div>
  </div>
</div>
<div class="modal fade" id="impotarparticipante" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-5">
      <div class="modal-header bg-info">
        <h5 class="modal-title text-white" id="exampleModalLabel">Importar lista de Participantes</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <form enctype="multipart/form-data" method="POST" class="tablelist-form" autocomplete="off" action="index.php?action=registro">
            <div class="modal-body bg-light">
                <div class="mb-4">
                    <label for="formato" class="form-label fs-5 mb-2">Descargar Plantilla</label>
                    <div class="d-flex align-items-center">
                        <a href="storage/per/plantilla1.xlsx" download="Importar jugadores.xlsx">
                            <i style="font-size: 30px;" class="ri-download-cloud-2-line me-6"> </i> 
                        </a> <span class="text-muted fs-6"> Descarga la plantilla para importar tus datos correctamente.</span>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="archivo" class="form-label fs-5 mb-2">Seleccionar Archivo</label>
                    <div class="input-group">
                        <input type="file" name="archivo" class="form-control" required />
                        <label class="input-group-text bg-success text-white" for="archivo">
                            <i class="fa fa-file-upload me-1"></i> Seleccionar
                        </label>
                    </div>
                    <div class="form-text fs-6">Selecciona el archivo que deseas importar.</div>
                </div>
            </div>
          <div class="modal-footer bg-info d-flex justify-content-between pb-0">
              <input class="form-control" type="hidden" name="actions" value="30">
              <button type="button" class="btn btn-outline-light me-2" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-light">Subir registros</button>
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
            "ajax": "index.php?action=apijugador_general&actions=1",
            "columns": [
                { "data": function(row) {
                        return row.nombre + ' ' + row.apellido1 + ' '+ row.apellido2 ;
                    }
                },
                { "data": "numlicencia" },
                {
                    "data": "nacimiento",
                    "render": function(data, type, row) {
                        return moment(data).format('DD-MM-YYYY') + ' (<span style="color: blue;">' + row.edad_completa + '</span> años)';
                    }
                },
                { "data": "telefono" },
                { "data": "club" },
                { "data": "codigofide" },
                { "data": "elo" },
                { "data": "estado",
                    "render": function(data, type, row) {
                        if(data == 1) {
                            return '<i class="ri ri-checkbox-circle-line text-success"></i>';
                        } else {
                            return '<i class="ri  ri-close-circle-line text-danger"></i>';
                        }
                    }
                },
                { "data": null,
                    "render": function (data, type, row) {
                        return `
                            <a class="edit-btn" data-id="${row.id}" title="Editar">
                                <i class="ri-edit-2-fill align-bottom me-1 text-primary"></i>
                            </a> 
                            <a class="delete-btn" data-id="${row.id}" title="Eliminar">
                                <i class="ri-delete-bin-2-line align-bottom me-1 text-danger"></i>
                            </a> 
                            <form class="form-permissions" action="historial" method="POST" style="display:inline;">
                                <input type="hidden" name="tid" value="${row.id}">
                                <button type="submit" class="btn-link" title="Historial" style="border:none; background:none; padding:0; color:#0d6efd;">
                                    <i class="fas fa-history align-bottom me-1"></i>
                                </button>
                            </form>
                        `;
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
          $('#select-clubs').empty();
          $.ajax({
              url: 'index.php?action=apiclubs',
              method: 'GET',
              dataType: 'json',
              success: function(data) {
                  data.forEach(function(facultad) {
                      $('#select-clubs').append($('<option>', {
                          value: facultad.codigo,
                          text: facultad.codigo + ': '+facultad.nombre
                      }));
                  });
              },
              error: function() {
                  console.error("Error al cargar datos de la API");
              }
          });
      });
        $('#customerTable').on('click', '.edit-btn', function() {
            let id = $(this).data('id');
            $.get("index.php?action=getjugador&id=" + id, function(data) {
                $('#apellido1').val(data.apellido1);
                $('#apellido2').val(data.apellido2);
                $('#nombre').val(data.nombre);
                $('#nacimiento').val(data.nacimiento);
                $('#numlicencia').val(data.numlicencia);
                $('#telefono').val(data.telefono);
                $('#club').val(data.club);
                $('#codigofide').val(data.codigofide);
                $('#elo').val(data.elo);
                $('#ids').val(data.id);
                if(data.estado == 1) {
                    $('#estado').prop('checked', true);
                } else {
                    $('#estado').prop('checked', false);
                }
                $.ajax({
                    url: 'index.php?action=apiclubs',
                    method: 'GET',
                    dataType: 'json',
                    success: function(facultades) {
                        $('#clud').empty();
                        $('#clud').append($('<option>', {value: '', text: 'Elegir'}));
                        facultades.forEach(function(clud) {
                            $('#clud').append($('<option>', {
                                value: clud.codigo,
                                text: clud.codigo + ': '+clud.nombre
                            }));
                        });
                        $('#clud').val(data.club);
                    }
                });
                $.ajax({
                    url: 'index.php?action=apimodulo',
                    method: 'GET',
                    dataType: 'json',
                    success: function(apimodulos) {
                        $('#apimodulo').empty();
                        $('#apimodulo').append($('<option>', {value: '', text: 'Elegir'}));
                        apimodulos.forEach(function(apimodulo) {
                            $('#apimodulo').append($('<option>', {
                                value: apimodulo.id,
                                text: apimodulo.nombre
                            }));
                        });
                        $('#apimodulo').val(data.modelocalidad);
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
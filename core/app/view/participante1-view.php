<?php 
if (isset($_SESSION["conticomtc"]) && isset($_SESSION["typeuser"]) && ($_SESSION["typeuser"] == 1 || $_SESSION["typeuser"] == 2)) {
$cantiadess=0;
$equipos = EquipoData::verid($_GET['tid']);
$u = UserData::verid($_SESSION['conticomtc']);
$clubs = ClubData::verid($equipos->club);
$ligas = LigaData::verid($equipos->liga);
$participantes = count(EquipoJugadorData::vercontenidos($_GET['tid']));
$ligausuarios = ligaUsuarioData::verid_lista($ligas->id, $equipos->club);
$ordenequ = EquipoData::verid_orden($_GET['tid'],$equipos->club);
if ($ligausuarios !== null) {
    $cantiadess = $ligausuarios->cantidad;
} else {
    $cantiadess = 0;
}
$maximos = 0;
if ($ordenequ->estado=="Último equipo" && $ligas->codigo=="LFRE") {
    $partidis = 18 - $participantes;  
    $maximos = 18;
} else {
    $partidis = $ligas->maximo - $participantes;  
    $maximos = $ligas->maximo;
}


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
<script>
    $(document).ready(function() {
        if (<?= $partidis; ?> <= 0) {
            $('#buscarJugadorBtn').prop('disabled', true);
            $('button[data-bs-target="#impotarparticipante"]').prop('disabled', true);
            $('button[data-bs-target="#exampleModalLong"]').prop('disabled', true);
        }
    });
</script>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- Sección de título y detalles del club -->
            <div class="col-md-12 mb-4">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-8 text-md-start text-center mb-3 mb-md-0">
                                <img src="storage/per/logo.png" 
                                     class="img-fluid rounded-circle border border-primary mb-3" 
                                     style="width: 90px; height: 90px;" 
                                     alt="Logo del club">
                                <h4 class="fw-semibold text-dark mb-1"><?= $equipos->nombre; ?></h4>
                            </div>
                            <div class="col-md-4 text-md-end text-center">
                                <p class="text-muted mb-1">Liga: <span class="fw-bold text-primary"><?= $ligas->nombre; ?></span></p>
                                <p class="text-muted mb-1">Nº de participantes: 
                                    <span class="fw-bold text-danger">MIN: <?= $ligas->minimo; ?></span> - 
                                    <span class="fw-bold text-dark">MAX: <?= $maximos;?></span>
                                </p>
                                <p class="text-muted mb-1">Edad: <span class="text-secondary"><?= $ligas->edad; ?></span></p>
                                <p class="text-muted mb-1">Orden: <span class="text-secondary"><?= $ligas->orden; ?></span></p>
                                <div class="p-1 my-3 border rounded-3 bg-light">
                                    <p class="text-muted mb-1 fs-6">Orden del Grupo: 
                                        <span class="fw-bold text-secondary"><?= $ordenequ->estado; ?></span>
                                    </p>
                                    <p class="text-muted mb-1 fs-6">Cantidad: 
                                        <span class="fw-bold text-danger"><?= $maximos; ?></span> / 
                                        <span class="fw-bold text-success">Disponible: <?= $partidis; ?></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sección de lista de registro de participantes -->
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between" style="padding: 0.5rem 1rem;">
                            <h5 class="card-title mb-0 text-white">Lista de registro de Participantes</h5>
                            <div class="ms-auto">
                                <a style="border-radius: 50px; padding: 0.375rem 1rem; text-transform: uppercase; font-weight: bold; background: linear-gradient(45deg, #007bff, #00d4ff); color: white; transition: background 0.3s ease;" class="btn btn-light btn-sm" onclick="window.location.href='mequipo'; return false;" onmouseover="window.status=''; return true;" onmouseout="window.status=''; return true;"><i class="ri-arrow-go-back-line"></i> Volver</a>
                                <button type="button" id="buscarJugadorBtn" class="btn btn-light me-2 text-danger btn-sm" data-bs-toggle="modal" data-bs-target="#basededatos">
                                    <i class="ri-add-line align-bottom me-1"></i> Buscar Jugador
                                </button>
                                <button type="button" id="AtualizarOrdens" class="btn btn-light btn-sm me-2 text-danger" data-bs-toggle="modal" data-bs-target="#AtualizarOrden">
                                    <i class="fas fa-exchange-alt align-bottom me-1"></i> Modificar Orden
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="customerTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%; font-size: 12px;">
                                <thead>
                                    <tr class="table-primary text-center">
                                        <th>Nombres y apellidos</th>
                                        <th>ID FIDE</th>
                                        <th>Fecha nacimiento</th>
                                        <th>Teléfono</th>
                                        <th>Club</th>
                                        <th>Código FMA</th>
                                        <th>Elo</th>
                                        <th>Estado</th>
                                        <th><i class="ri-settings-5-line"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Aquí van los datos del club -->
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
                    <input class="form-control" name="apellido2" id="apellido2" type="text" aria-label="First name" required>
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
                    <input class="form-control" name="club" id="club" type="text" aria-label="First name">
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
            <input class="form-control" type="hidden" name="actions" value="11">
            <input class="form-control" type="hidden" name="id" id="ids">
            <input class="form-control" type="hidden" name="tid" value="<?= $_GET['tid'];?>">
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
          <input type="hidden" name="actions" value="66">
          <input type="hidden" name="id" id="id">
          <input class="form-control" type="hidden" name="tid" value="<?= $_GET['tid'];?>">
          <input class="form-control" type="hidden" name="td" value="<?= $_GET['td'];?>">
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
                    <input class="form-control" name="club" id="validationCustom01" type="text" aria-label="First name">
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
              <input class="form-control" type="hidden" name="actions" value="10">
              <input class="form-control" type="hidden" name="tid" value="<?= $_GET['tid'];?>">
              <button type="button" class="btn btn-outline-light me-2" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-light">Guardar registro</button>
            </div>
        </form>
        
    </div>
  </div>
</div>
<div class="modal fade" id="basededatos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info">
        <h5 class="modal-title text-white" id="exampleModalLabel">Jugadores</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <form enctype="multipart/form-data" method="POST" class="tablelist-form" autocomplete="off" action="index.php?action=registro">
            <div class="modal-body bg-light">
                <div class="card-body">
                    <table id="customerTable1" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                        <thead>
                            <tr class="table-primary">
                                <th><input type="checkbox" id="selectAllCheckbox"></th>
                                <th>Nombres y apellidos</th>
                                <th>Nº licencia</th>
                                <th>F. nacimiento</th>
                                <th>Telefono</th>
                                <th>Federac. (Cod)</th>
                                <th>Elo</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Datos del club -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-info d-flex justify-content-between pb-0">
              <input class="form-control" type="hidden" name="actions" value="39">
              <input class="form-control" type="hidden" name="tid" value="<?= $_GET['tid'];?>">
              <input class="form-control" type="hidden" name="td" value="<?= $_GET['td'];?>">
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
            "ajax": "index.php?action=apijugadorequipo&equipo=" + <?= $_GET['tid'];?>,
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
                { "data": function(row) {
                        if (row.elos=="") {
                            return row.elo;
                        } else {
                            return row.elo;
                        }
                    }
                },
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
                        // var editButton = '<button class="btn btn-primary btn-sm edit-btn" data-id="' + row.id + '"><i class="ri-edit-2-fill"></i></button>';
                        var deleteButton = '';
                        if (row.nuevo == 0) {
                            deleteButton = '<button class="btn btn-danger btn-sm delete-btn" data-id="' + row.id1 + '"><i class="ri-delete-bin-2-line"></i></button>';
                        }
                        // if (row.estado == 1) {
                        //     deleteButton = '<button class="btn btn-danger btn-sm delete-btn" data-id="' + row.id1 + '"><i class="ri-delete-bin-2-line"></i></button>';
                        // } else {eliminar
                        //     deleteButton = '<button class="btn btn-danger btn-sm delete-btn" data-id="' + row.id1 + '" disabled><i class="ri-delete-bin-2-line"></i></button>';
                        // }

                        // return editButton + ' ' + deleteButton;
                        return  deleteButton;
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
            },
            "rowCallback": function(row, data) {
                if (data.estadoe == 2 | data.estadoe == 4) {
                    $(row).addClass('bg-light');
                    $('button', row).prop('disabled', true);
                }
            }
        });
        $('#exampleModalLong').on('show.bs.modal', function() {
          $('#select-facultad').empty();
          $.ajax({
              url: 'index.php?action=apiclubs',
              method: 'GET',
              dataType: 'json',
              success: function(data) {
                  data.forEach(function(facultad) {
                      $('#select-facultad').append($('<option>', {
                          value: facultad.id,
                          text: facultad.nombre
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
                                value: clud.id,
                                text: clud.nombre
                            }));
                        });
                        $('#clud').val(data.clud);
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
<script>
$(document).ready(function() {
    $('#basededatos').on('shown.bs.modal', function () {
        if (!$.fn.DataTable.isDataTable('#customerTable1')) {
            $('#customerTable1').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "index.php?action=apijugadorporclub&tid="+<?= $clubs->id; ?>+"&liga="+<?= $ligas->id;?>,
                "columns": [
                    { 
                        "data": "id",
                        "render": function (data, type, row) {
                            var disabled = parseInt(row.numeroqueparticipa) > 0 ? 'disabled' : '';
                            return '<input type="checkbox" class="selectCheckbox" name="jugador[]" value="'+ row.id +'" ' + (parseInt(row.numeroqueparticipa) > 0 ? 'checked' : '') + ' ' + disabled + '>';
                        }
                    },
                    { "data": function(row) {
                        return row.nombre + ' ' + row.apellido1 + ' '+ row.apellido2 ;
                    }},
                    { "data": "numlicencia" },
                    { 
                        "data": "nacimiento",
                        "render": function(data, type, row) {
                            return moment(data).format('DD-MM-YYYY') + ' (<span style="color: blue;">' + row.edad_completa + '</span> años)';
                        }
                    },
                    { "data": "telefono" },
                    { "data": "codigofide" },
                    { "data": "elo" },
                    { 
                        "data": "estado",
                        "render": function(data, type, row) {
                            if(data == 1) {
                                return '<i class="ri ri-checkbox-circle-line text-success"></i>';
                            } else {
                                return '<i class="ri  ri-close-circle-line text-danger"></i>';
                            }
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
                },
            });
        }
    });

    $('#selectAllCheckbox').on('change', function() {
        $('.selectCheckbox:not(:disabled)').prop('checked', $(this).prop('checked'));
    });

    $(document).on('change', '.selectCheckbox', function() {
        var allChecked = true;
        $('.selectCheckbox:not(:disabled)').each(function() {
            if (!$(this).prop('checked')) {
                allChecked = false;
                return false;
            }
        });
        $('#selectAllCheckbox').prop('checked', allChecked);
    });
});
</script>

<div class="modal fade" id="AtualizarOrden" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white" id="exampleModalLabel">Modificar Orden</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-light">
                <div class="card-body">
                    <table id="dynamicTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                        <thead>
                            <tr class="table-primary">
                                <th>Nombres y apellidos</th>
                                <th>Nº licencia</th>
                                <th>F. nacimiento</th>
                                <th>Telefono</th>
                                <th>Club (Cod)</th>
                                <th>Federac. (Cod)</th>
                                <th>Elo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Aquí se cargarán los datos dinámicos -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-info d-flex justify-content-between pb-0">              
                <button type="button" class="btn btn-outline-light me-2" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var tableLoaded = false;
        var ligaOrden = "<?= $ligas->orden; ?>";  // Obtener el valor de 'orden' desde PHP

        // Evento al mostrar el modal
        $('#AtualizarOrden').on('shown.bs.modal', function () {
            if (!tableLoaded) {
                var table = $('#dynamicTable').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "index.php?action=apijugadorequipo&equipo=<?= $_GET['tid']; ?>",
                    "columns": [
                        { "data": function(row) { return row.nombre + ' ' + row.apellido1 + ' ' + row.apellido2; } },
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
                        { "data": "elo" }
                    ],
                    "language": {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrar _MENU_ registros",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ningún dato disponible en esta tabla",
                        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                        "sSearch": "Buscar:",
                        "sLoadingRecords": "Cargando...",
                        "oPaginate": {
                            "sFirst": "Primero",
                            "sLast": "Último",
                            "sNext": "Siguiente",
                            "sPrevious": "Anterior"
                        },
                        "oAria": {
                            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        }
                    },
                    "order": ligaOrden === 'desc' ? [[6, 'desc']] : [],  // Ordenar por ELO descendente si es 'desc'
                    "createdRow": function(row, data, dataIndex) {
                        $(row).attr('data-id', data.id1);
                        $(row).attr('data-jugador', data.id);
                        $(row).attr('data-equipo', data.id2);
                        $(row).attr('data-estado', data.estadoee);
                        $(row).attr('data-duplicidad', data.duplicidadee);
                        $(row).attr('data-fecha', data.fechaee);
                        $(row).attr('data-elo', data.elo);// Agregar el valor del Elo como atributo
                        $(row).attr('data-nuevo', data.nuevo);  
                    }
                }).on('draw.dt', function() {
                    var rows = $('#dynamicTable tbody tr');
                    
                    new Sortable(rows.closest('tbody')[0], {
                        animation: 150,
                        handle: 'tr',
                        ghostClass: 'sortable-ghost',
                        onMove: function(evt) {
                            // Obtener atributos de los elementos arrastrados y objetivo
                            var draggedElo = $(evt.dragged).attr('data-elo');
                            var targetElo = $(evt.related).attr('data-elo');
                            var draggedNuevo = $(evt.dragged).attr('data-nuevo');
                            var targetNuevo = $(evt.related).attr('data-nuevo');
                            
                            if (ligaOrden === 'libre') {
                                // Permitir todos los movimientos si el orden es libre
                                return true;
                            } else {
                                // Solo permitir mover dentro de los mismos ELO
                                if (draggedElo !== targetElo) {
                                    return false;
                                }

                                // Permitir que los "nuevos" (data-nuevo='0') se muevan a cualquier posición dentro de su grupo de ELO
                                if (draggedNuevo === '0') {
                                    return true;
                                }

                                // No permitir el movimiento si no se cumplen las condiciones anteriores
                                return false;
                            }
                        },
                        onEnd: function(evt) {
                            var order = [];
                            $('#dynamicTable tbody tr').each(function() {
                                var row = $(this);
                                order.push({
                                    id: row.data('id'),
                                    jugador: row.data('jugador'),
                                    equipo: row.data('equipo'),
                                    estado: row.data('estado'),
                                    duplicidad: row.data('duplicidad'),
                                    fecha: row.data('fecha')
                                });
                            });

                            // Enviar los datos al servidor mediante fetch
                            fetch('index.php?action=apiguardarorden', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({ order: order }), // Enviar el nuevo orden
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    console.log('Orden actualizado con éxito.');
                                } else {
                                    console.error('Error al actualizar el orden:', data.errors);
                                }
                            })
                            .catch(error => console.error('Error en la solicitud:', error));
                        }
                    });
                });

                tableLoaded = true;
            }
        });

        // Recargar los datos cuando se cierra el modal, en lugar de destruir la tabla
        $('#AtualizarOrden').on('hidden.bs.modal', function () {
            if (tableLoaded) {
                $('#dynamicTable').DataTable().ajax.reload();  // Recargar los datos
            }
        });

        $('#AtualizarOrden').on('hidden.bs.modal', function () {
            location.reload();  // Recargar la página cuando el modal se cierre
        });
    });
</script>
<?php } else {
    header("Location: ./"); 
    exit();
} ?>
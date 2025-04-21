<?php $u = UserData::verid($_SESSION['conticomtc']); ?>
<style>
    /* Estilo para botones */
    .btn {
        font-size: 11px; /* Tamaño de la fuente para botones */
        padding: 5px 10px; /* Espaciado interno de botones */
    }

    /* Estilo para contenido de la tabla */
    #customerTable th,
    #customerTable td {
        font-size: 11px;
        padding-left: 20px; /* Espaciado interno izquierdo */
        padding-right: 8px; /* Espaciado interno derecho */
        padding-top: 8px; /* Espaciado interno superior */
        padding-bottom: 8px; /* Espaciado interno inferior */
    }
</style>
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
                            <h5 class="card-title mb-0 text-white">Lista de registro de Equipos</h5>
                            <?php if ($u->club=="") { ?>
                            <?php } ?>
                        </div>
                        <div class="card-body">
                            <table id="customerTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%; font-size: 10px;">
                                <thead>
                                    <tr class="table-primary">
                                        <th>Equipo</th>
                                        <th>Club</th>
                                        <th>Capitán</th>
                                        <th>Subcapitán</th>
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
                <div class="col-md-10"> 
                    <label class="form-label" for="first-name"> Club</label>
                    <select class="form-control" name="club" id="select-clubb"><option></option></select>
                  </div>
                  <div class="col-md-2">
                    <label class="form-check-label" for="estado">Estado</label>
                    <div class="form-check form-switch form-switch-lg" dir="ltr">
                        <input type="checkbox" name="estado" class="form-check-input" id="estado">
                    </div>
                  </div>
                  <div class="col-md-12"> 
                    <label class="form-label" for="first-name"> Nombre del Equipo</label>
                    <input class="form-control" name="nombre" id="nombre" type="text" aria-label="First name" required>
                  </div>
                  <div class="col-md-8"> 
                    <label class="form-label" for="first-name"> Capitan <b style="color: #A1C2BD;"> |      Marcar si es nuevo: </b> <input style="border: 1px bold;" type="checkbox" id="siesnuevo1" class="form-check-input siesnuevo1"></label>
                    <div class="mostrar1a">
                        <select class="form-control select-usuario1" name="capitan">
                          <option value="">Seleccionar</option>  
                        </select>
                    </div>
                        <div class="mostrar1b" style="display: none;">
                        <input type="text" class="form-control" name="capitan1">
                    </div>
                  </div>
                  <div class="col-md-4"> 
                    <label class="form-label" for="first-name">F. de nacimiento</label>
                    <input class="form-control" name="nacimiento1" id="nacimiento1" type="date" aria-label="First name" required>
                  </div>
                  <div class="col-md-8"> 
                    <label class="form-label" for="first-name"> Subcapitan <b style="color: #A1C2BD;"> |      Marcar si es nuevo: </b> <input style="border: 1px bold;" type="checkbox" id="siesnuevo2" class="form-check-input siesnuevo2"></label>
                    <div class="mostrar2a">
                        <select class="form-control select-usuario2" name="subcapitan">
                          <option value="">Seleccionar</option>  
                        </select>
                    </div>
                        <div class="mostrar2b" style="display: none;">
                        <input type="text" class="form-control" name="subcapitan1">
                    </div>
                  </div>
                  <div class="col-md-4"> 
                    <label class="form-label" for="first-name">F. de nacimiento</label>
                    <input class="form-control" name="nacimiento2" id="nacimiento2" type="date" aria-label="First name" required>
                  </div>
                  <div class="col-md-12"> 
                    <label class="form-label" for="exampleFormControlTextarea1"> Descripción</label>
                    <textarea class="form-control" name="descripcion" id="descripcion" rows="3"></textarea>
                  </div>
            </div>
          </div>
          <div class="modal-footer bg-info d-flex justify-content-between pb-0">
            <input class="form-control" type="hidden" name="actions" value="14">
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
          <input type="hidden" name="actions" value="15">
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
                <label class="form-label" for="first-name"> Club</label>
                <select class="form-control" name="club" id="select-club"><option></option></select>
              </div>
              <div class="col-md-12"> 
                <label class="form-label" for="first-name"> Club</label>
                <select class="form-control" name="equipo" id="select-equipo"><option></option></select>
              </div>
              <div class="col-md-12"> 
                <label class="form-label" for="first-name"> Nombre del Equipo</label>
                <input class="form-control" name="nombre" type="text" aria-label="First name" required>
              </div>
              <div class="col-md-8"> 
                <label class="form-label" for="first-name"> Capitan <b style="color: #A1C2BD;"> |      Marcar si es nuevo: </b> <input style="border: 1px bold;" type="checkbox" id="customSwitchsizelg" class="form-check-input"></label>
                <div class="ver1">
                    <select class="form-control select-usuario" name="capitan">
                      <option value="">Seleccionar</option>  
                    </select>
                </div>
                    <div class="ver2" style="display: none;">
                    <input type="text" class="form-control" name="capitan1">
                </div>
              </div>
              <div class="col-md-4"> 
                <label class="form-label" for="first-name">F. de nacimiento</label>
                <input class="form-control" name="nacimiento1" type="date" aria-label="First name" required>
              </div>
              <div class="col-md-8"> 
                <label class="form-label" for="first-name"> Subcapitan <b style="color: #A1C2BD;"> |      Marcar si es nuevo: </b> <input style="border: 1px bold;" type="checkbox" id="customSwitchsizelg1" class="form-check-input"></label>
                <div class="ver11">
                    <select class="form-control select-usuario" name="subcapitan">
                      <option value="">Seleccionar</option>  
                    </select>
                </div>
                    <div class="ver22" style="display: none;">
                    <input type="text" class="form-control" name="subcapitan1">
                </div>
              </div>
              <div class="col-md-4"> 
                <label class="form-label" for="first-name">F. de nacimiento</label>
                <input class="form-control" name="nacimiento2" type="date" aria-label="First name" required>
              </div>
              <div class="col-md-12"> 
                <label class="form-label" for="exampleFormControlTextarea1"> Descripción</label>
                <textarea class="form-control" name="descripcion" id="exampleFormControlTextarea1" rows="3"></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer bg-info d-flex justify-content-between pb-0">
              <input class="form-control" type="hidden" name="actions" value="13">
              <button type="button" class="btn btn-outline-light me-2" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-light">Guardar registro</button>
            </div>
        </form>
        
    </div>
  </div>
</div>
<!-- Modal de Enviar a la Federación -->
<div class="modal fade" id="Federacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-5">
      <div class="modal-header bg-info">
        <h5 class="modal-title text-white" id="exampleModalLabel">Envío a la FMA</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form enctype="multipart/form-data" method="POST" class="tablelist-form" autocomplete="off" action="index.php?action=registro">
            <div class="modal-body bg-light">
                <p>
                    <lord-icon
                    src="https://cdn.lordicon.com/usownftb.json"
                    trigger="loop"
                    delay="1500"
                    stroke="bold"
                    state="in-reveal"
                    colors="primary:#110a5c,secondary:#e86830"
                    style="width:50px;height:50px">
                    <p align="center"> </lord-icon> <b>Importante</b></p> <p align="justify">Antes de enviar el orden de fuerza del equipo a la Federación, es esencial que tengas en cuenta que asumirás toda la responsabilidad. Una vez que se haya enviado, no habrá posibilidad de detener el proceso hasta que la FMA lo tramite. Por lo tanto, es crucial asegurarse de que la lista esté completa y precisa antes de proceder con el envío.</p>
                </p>
            </div>
          <div class="modal-footer bg-info d-flex justify-content-between pb-0">
              <input class="form-control" type="hidden" name="actions" id="actionsFederacion" value="">
              <input class="form-control" type="hidden" name="id" id="ids1">
              <button type="button" class="btn btn-outline-light me-2" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-light">Enviar</button>
            </div>
        </form>
        
    </div>
  </div>
</div>
<!-- Modal de Respuesta de Federación -->
<div class="modal fade" id="RespuestaFederacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-5">
      <div class="modal-header bg-info">
        <h5 class="modal-title text-white" id="exampleModalLabel"></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form enctype="multipart/form-data" method="POST" class="tablelist-form" autocomplete="off" action="index.php?action=registro">
            <div class="modal-body bg-light">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center mb-4">Respuesta de la FMA</h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <p class="font-weight-bold">Equipo:</p>
                                <p id="nombrej" class="card-text"></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="font-weight-bold">Club:</p>
                                <p id="clubesj" class="card-text"></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="font-weight-bold">Capitán:</p>
                                <p id="capitanesj" class="card-text"></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="font-weight-bold">Fecha de nacimiento:</p>
                                <p id="nacimiento1j" class="card-text"></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="font-weight-bold">Subcapitán:</p>
                                <p id="subcapitanesj" class="card-text"></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="font-weight-bold">Fecha de nacimiento:</p>
                                <p id="nacimiento2j" class="card-text"></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="font-weight-bold">Estado:</p>
                                <p id="estados" class="card-text"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="mensajefederacion" class="form-label">Comentario adjunto</label>
                    <textarea name="mensajefederacion" id="mensajefederacionj" class="form-control" rows="3"></textarea>
                </div>
            </div>
          <div class="modal-footer bg-info d-flex justify-content-between pb-0">
              <button type="button" class="btn btn-outline-light me-2" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </form>
        
    </div>
  </div>
</div>
<script>
    $(document).ready(function() {
        $('#customSwitchsizelg').change(function() {
            if ($(this).is(':checked')) {
                $('.ver1').hide();
                $('.ver2').show();
            } else {
                $('.ver1').show();
                $('.ver2').hide();
            }
        });
        $('#customSwitchsizelg1').change(function() {
            if ($(this).is(':checked')) {
                $('.ver11').hide();
                $('.ver22').show();
            } else {
                $('.ver11').show();
                $('.ver22').hide();
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#customerTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "index.php?action=apiequipo",
            "columns": [
                { "data": function(row) {
                        return row.nombre ;
                    }
                },
                { "data": "clubes" },
                { "data": function(row) {
                        return row.capitanes + ' ' + "<span style='color: blue;'>(" + row.nacimiento1 + ")</span>";
                    }
                },
                { "data": function(row) {
                        return row.subcapitanes + ' ' + "<span style='color: blue;'>(" + row.nacimiento2 + ")</span>";
                    }
                },
                { "data": "estado",
                    "render": function(data, type, row) {
                        if(data == 1) {
                            return '<span class="text-primary">Sin Enviar</span>';
                        }
                        if(data == 2) {
                            return '<span class="text-success">Enviado</span>';
                        }
                        if(data == 3) {
                            return '<button class="btn btn-sm btn-success noinnabilitar jugadores-btn" data-id="' + row.id + '">Aceptado</button>';
                        }
                        if(data == 4) {
                            return '<button class="btn btn-sm btn-danger noinnabilitar jugadores-btn" data-id="' + row.id + '">Rechazado</button>';
                        }
                        if(data == 5) {
                            return '<button class="btn btn-sm btn-warning noinnabilitar jugadores-btn" data-id="' + row.id + '">Observado</button>';
                        }
                        if(data == 6) {
                            return '<button class="btn btn-sm btn-warning noinnabilitar jugadores-btn" data-id="' + row.id + '">Modificado</button>';
                        }
                    }
                },
                { 
                    "data": null,
                    "render": function (data, type, row) { 
                        return '<button title="Enviar a la Federación para su validación" class="btn btn-warning btn-sm federacion-btn" data-id="' + row.id + '"><i class="ri-telegram-fill"></i></button>' + ' ' + '<a href="participante?tid=' + row.id + '" class="btn btn-info btn-sm"><i class="ri-group-fill"></i></a>' + ' ' + '<button title="Actualizar registro" class="btn btn-primary btn-sm edit-btn" data-id="' + row.id + '"><i class="ri-edit-2-fill"></i></button>' + ' ' + '<button title="Eliminar registro" class="btn btn-danger btn-sm delete-btn" data-id="' + row.id + '"><i class="ri-delete-bin-2-line"></i></button>';
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
    if (data.estado == 2 || data.estado == 4) {
        $(row).addClass('bg-light');
        $('button', row).not('.noinnabilitar').prop('disabled', true); // Deshabilitar todos los botones excepto aquellos con la clase 'noinnabilitar'
    }
}

        });
        $('#exampleModalLong').on('show.bs.modal', function() {
          $('#select-club').empty();
          $.ajax({
              url: 'index.php?action=apiclubs',
              method: 'GET',
              dataType: 'json',
              success: function(data) {
                  data.forEach(function(clubes) {
                      $('#select-club').append($('<option>', {
                          value: clubes.id,
                          text: clubes.nombre
                      }));
                  });
              },
              error: function() {
                  console.error("Error al cargar datos de la API");
              }
          });
          $.ajax({
              url: 'index.php?action=apiusuario',
              method: 'GET',
              dataType: 'json',
              success: function(data) {
                  data.forEach(function(usuario) {
                      $('.select-usuario').append($('<option>', {
                          value: usuario.id,
                          text: usuario.nombre + ', ' + usuario.apellido
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
            $.get("index.php?action=getequipo&id=" + id, function(data) {
                $('#categoria').val(data.categoria);
                $('#nombre').val(data.nombre);
                $('#descripcion').val(data.descripcion);
                $('#nacimiento1').val(data.nacimiento1);
                $('#nacimiento2').val(data.nacimiento2);
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
                        $('#select-clubb').empty();
                        $('#select-clubb').append($('<option>', {value: '', text: 'Elegir'}));
                        facultades.forEach(function(club) {
                            $('#select-clubb').append($('<option>', {
                                value: club.id,
                                text: club.nombre
                            }));
                        });
                        $('#select-clubb').val(data.club);
                    }
                });
                // Función para determinar si es un número entero
                function isInteger(value) {
                    return /^\d+$/.test(value);
                }
                 // Mostrar el campo adecuado para el capitan
                if (isInteger(data.capitan)) {
                    $('.mostrar1a').show();
                    $('.mostrar1b').hide();
                    $('.select-usuario1').val(data.capitan);
                } else {
                    $('.mostrar1a').hide();
                    $('.mostrar1b').show();
                    $('input[name="capitan1"]').val(data.capitan);
                }
                // Mostrar el campo adecuado para el subcapitan
                if (isInteger(data.subcapitan)) {
                    $('.mostrar2a').show();
                    $('.mostrar2b').hide();
                    $('.select-usuario2').val(data.subcapitan);
                } else {
                    $('.mostrar2a').hide();
                    $('.mostrar2b').show();
                    $('input[name="subcapitan1"]').val(data.subcapitan);
                }
                // Cambio de evento para el checkbox siesnuevo1
                $('.siesnuevo1').change(function() {
                    if ($(this).is(':checked')) {
                        $('.mostrar1a').hide();
                        $('.mostrar1b').show();
                    } else {
                        $('.mostrar1a').show();
                        $('.mostrar1b').hide();
                    }
                });
                // Cambio de evento para el checkbox siesnuevo2
                $('.siesnuevo2').change(function() {
                    if ($(this).is(':checked')) {
                        $('.mostrar2a').hide();
                        $('.mostrar2b').show();
                    } else {
                        $('.mostrar2a').show();
                        $('.mostrar2b').hide();
                    }
                });
                // Llamada inicial para asegurar que los campos estén configurados correctamente al cargar la página
        // if ($('#siesnuevo1').is(':checked')) {
        //     $('.mostrar1a').hide();
        //     $('.mostrar1b').show();
        // } else {
        //     $('.mostrar1a').show();
        //     $('.mostrar1b').hide();
        // }

        // if ($('#siesnuevo2').is(':checked')) {
        //     $('.mostrar2a').hide();
        //     $('.mostrar2b').show();
        // } else {
        //     $('.mostrar2a').show();
        //     $('.mostrar2b').hide();
        // }
                // Carga de opciones de usuarios
                $.ajax({
                    url: 'index.php?action=apiusuario',
                    method: 'GET',
                    dataType: 'json',
                    success: function(apimodulos) {
                        // Opciones para el capitan
                        $('.select-usuario1').empty();
                        $('.select-usuario1').append($('<option>', {value: '', text: 'Elegir'}));
                        apimodulos.forEach(function(capitan) {
                            $('.select-usuario1').append($('<option>', {
                                value: capitan.id,
                                text: capitan.nombre + ', ' + capitan.apellido
                            }));
                        });
                        // Opciones para el subcapitan
                        $('.select-usuario2').empty();
                        $('.select-usuario2').append($('<option>', {value: '', text: 'Elegir'}));
                        apimodulos.forEach(function(subcapitan) {
                            $('.select-usuario2').append($('<option>', {
                                value: subcapitan.id,
                                text: subcapitan.nombre + ', ' + subcapitan.apellido
                            }));
                        });
                        // Seleccionar valores
                        $('.select-usuario1').val(data.capitan);
                        $('.select-usuario2').val(data.subcapitan);
                    }
                });
                // Mostrar el modal
                $('#EditarModal').modal('show');
            }, "json");
        });
        $('#customerTable').on('click', '.delete-btn', function() {
            let id = $(this).data('id');
            $('#id').val(id);
            $('#confirm-delete-btn').data('id', id);
            $('#eliminarmodal').modal('show');
        });

        $('#customerTable').on('click', '.federacion-btn', function() {
            // 1) Obtén la fila DataTable
            var table = $('#customerTable').DataTable();
            var data  = table.row($(this).closest('tr')).data();

            // 2) Rellena el campo oculto con el ID
            $('#ids1').val(data.id);

            // 3) Decide la acción: si estado == 1 → 33, sino → 330
            var accion = (data.estado == 1) ? 33 : 330;
            $('#actionsFederacion').val(accion);

            // 4) Abre el modal
            $('#Federacion').modal('show');
        });






        $('#customerTable').on('click', '.jugadores-btn', function() {
            let id = $(this).data('id');
            $.get("index.php?action=getequipo&id=" + id, function(data) {
                $('#clubesj').text(data.clubes);
                $('#nombrej').text(data.nombre);
                $('#descripcionj').text(data.descripcion);
                $('#nacimiento1j').text('' + data.nacimiento1);
                // $('#cantidad').text(data.cantidad);
                $('#nacimiento2j').text(data.nacimiento2);
                $('#ids1j').val(data.id);
                $('#capitanesj').text(data.capitanes);
                $('#subcapitanesj').text(data.subcapitanes);
                $('#mensajefederacionj').val(data.mensajefederacion);
                let valorEstado = data.estado;
                $('#estado option').each(function() {
                    if ($(this).val() == valorEstado) {
                        $(this).prop('selected', true);
                    }
                });
                if(data.estado == 1) {
                    $('#estados').text('Sin enviar').css('color', '#f0ad4e'); // Amarillo para 'Sin enviar'
                }
                if(data.estado == 2) {
                    $('#estados').text('Enviado').css('color', '#5bc0de'); // Azul para 'Enviado'
                }
                if(data.estado == 3) {
                    $('#estados').text('Aceptado').css('color', '#5cb85c'); // Verde para 'Aceptado'
                }
                if(data.estado == 4) {
                    $('#estados').text('Rechazado').css('color', '#d9534f'); // Rojo para 'Rechazado'
                }
                if(data.estado == 5) {
                    $('#estados').text('Observado').css('color', '#0275d8'); // Azul claro para 'Observado'
                }
                if(data.estado == 6) {
                    $('#estados').text('Modificado').css('color', '#f0ad4e'); // Amarillo para 'Modificado'
                }

                $('#RespuestaFederacion').modal('show');
            }, "json");
        });


    });
</script>
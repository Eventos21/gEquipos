<?php
if (isset($_SESSION["conticomtc"]) && isset($_SESSION["typeuser"]) && ($_SESSION["typeuser"] == 1 || $_SESSION["typeuser"] == 2)) {
 $u = UserData::verid($_SESSION['conticomtc']); ?>
<style>
    /* Estilo para botones */
    .btn {
        font-size: 9px; /* Tamaño de la fuente para botones */
        padding: 5px 6px; /* Espaciado interno de botones */
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
                            <h5 class="card-title mb-0 text-white">Lista de registro de Ligas</h5>
                            <?php if ($u->club=="") { ?>
                            <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#exampleModalLong">
                                <i class="ri-add-line align-bottom me-1"></i> Nuevo registro
                            </button>
                            <?php } ?>
                        </div>
                        <div class="card-body">
                            <table id="customerTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                <thead>
                                    <tr class="table-primary">
                                        <th>Liga</th>
                                        <th>Temporada</th>
                                        <th>Fecha</th>
                                        <th>F. Trámites</th>
                                        <th>Jugadores</th>
                                        <th>Edad</th>
                                        <!-- <th>Categoria</th>
                                        <th>Grupo</th> -->
                                        <th width="10px">Estado</th>
                                        <?php if ($u->club=="") { ?><th width="50px">Acción</th><?php } ?>
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
                    <label class="form-label" for="first-name"> Liga</label>
                    <select class="form-control miSelect1" name="nombre" id="nombre">
                        <option value="Liga FMA Ajedrez Rápido por Equipos">Liga FMA Ajedrez Rápido por Equipos</option>
                        <option value="Liga FMA Sub-16 por Equipos">Liga FMA Sub-16 por Equipos</option>
                        <option value="Liga FMA Regular por Equipos">Liga FMA Regular por Equipos</option>
                    </select>
                </div>
                <div class="col-md-12"> 
                    <label class="form-label" for="first-name">Temporada</label>
                    <select class="form-control miSelect1" id="temporada" name="temporada"></select>
                </div>
                <div class="col-md-4"> 
                    <label class="form-label" for="first-name"> Fecha de inicio</label>
                    <input class="form-control" id="fechainicio" name="fechainicio" type="date" aria-label="First name" required>
                </div>
                <div class="col-md-4"> 
                    <label class="form-label" for="first-name"> Fecha final</label>
                    <input class="form-control" id="fechafinal" name="fechafinal" type="date" aria-label="First name" required>
                </div>
                <div class="col-md-4"> 
                    <label class="form-label" for="first-name"> Modificación</label>
                    <input class="form-control" id="fechafinalmodificacion" name="fechafinalmodificacion" type="datetime-local" aria-label="First name">
                </div>
                <div class="col-md-4"> 
                    <label class="form-label" for="first-name">Minimo Jugadores</label>
                    <input class="form-control" id="minimo" name="minimo" type="text" aria-label="First name" required>
                </div>
                <div class="col-md-4"> 
                    <label class="form-label" for="first-name">Maximo Jugadores</label>
                    <input class="form-control" id="maximo" name="maximo" type="text" aria-label="First name" required>
                </div>
                <div class="col-md-4"> 
                    <label class="form-label" for="first-name"> Edad</label>
                    <input class="form-control" id="edad" name="edad" type="text" aria-label="First name">
                </div>
                <div class="col-md-12" style="display: none;"> 
                    <label class="form-label" for="first-name">Categoria</label>
                    <input class="form-control" id="categoria" name="categoria" type="text" aria-label="First name">
                </div>
                <div class="col-md-4"> 
                    <label class="form-label" for="first-name">Orden</label>
                    <select name="orden" id="orden" class="form-control">
                        <option value="libre">Libre</option>
                        <option value="desc">Descendente</option>
                    </select>
                </div>
                <div class="col-md-8" style="display: none;"> 
                    <label class="form-label" for="first-name"> Grupo</label>
                    <textarea name="grupo" id="grupo" class="form-control" rows="1"></textarea>
                </div>
                <div class="col-md-4"> 
                    <label class="form-label" for="exampleFormControlTextarea1">Estado</label>
                    <input type="checkbox" name="estado" class="form-check-input" id="estado">
                </div>
            </div>
        </div>
          <div class="modal-footer bg-info d-flex justify-content-between pb-0">
            <input class="form-control" type="hidden" name="actions" value="23">
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
          <input type="hidden" name="actions" value="24">
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
<!-- modal clubes -->
<div class="modal fade" id="ProgramasModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content border-5">
      <div class="modal-header bg-info">
        <h5 class="modal-title text-white" id="exampleModalLabel">Asignar la cantidad de participantes a cada equipo</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form enctype="multipart/form-data" class="tablelist-form" autocomplete="off" method="post" action="index.php?action=registro">
        <div class="modal-body bg-light">
            <table id="fullgrupos" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                <thead class="table-dark">
                    <tr>
                        <th>Club</th>
                        <th>Telefono</th>
                        <th>Correo</th>
                        <th>Cantidad de Equipos</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Cuerpo de la tabla generado por DataTables -->
                </tbody>
            </table>
        </div>
          <div class="modal-footer bg-info d-flex justify-content-between pb-0">
              <input type="hidden" name="id" id="id11">
              <input type="hidden" name="liga" id="liga">
              <input type="hidden" name="actions" value="38">
              <button type="button" class="btn btn-outline-light me-2" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-light" id="actualizar-btn">Guardar registro</button>
            </div>
        </form>
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
                    <label class="form-label" for="first-name"> Liga</label>
                    <select class="form-control miSelect1" name="nombre">
                        <option value="Liga FMA Ajedrez Rápido por Equipos">Liga FMA Ajedrez Rápido por Equipos</option>
                        <option value="Liga FMA Sub-16 por Equipos">Liga FMA Sub-16 por Equipos</option>
                        <option value="Liga FMA Regular por Equipos">Liga FMA Regular por Equipos</option>
                    </select>
                </div>
                <div class="col-md-12"> 
                    <label class="form-label" for="first-name">Temporada</label>
                    <select class="form-control miSelect1" id="temporada-fieldd" name="temporada"></select>
                </div>
                <div class="col-md-4"> 
                    <label class="form-label" for="first-name"> Fecha de inicio</label>
                    <input class="form-control" name="fechainicio" type="date" aria-label="First name" required>
                </div>
                <div class="col-md-4"> 
                    <label class="form-label" for="first-name"> Fecha final</label>
                    <input class="form-control" name="fechafinal" type="date" aria-label="First name" required>
                </div>
                <div class="col-md-4"> 
                    <label class="form-label" for="first-name"> Modificación</label>
                    <input class="form-control" name="fechafinalmodificacion" type="datetime-local" aria-label="First name">
                </div>
                <div class="col-md-4"> 
                    <label class="form-label" for="first-name">Minimo Jugadores</label>
                    <input class="form-control" name="minimo" type="text" aria-label="First name" required>
                </div>
                <div class="col-md-4"> 
                    <label class="form-label" for="first-name">Maximo Jugadores</label>
                    <input class="form-control" name="maximo" type="text" aria-label="First name" required>
                </div>
                <div class="col-md-4"> 
                    <label class="form-label" for="first-name"> Edad</label>
                    <input class="form-control" name="edad" type="text" aria-label="First name">
                </div>
                <div class="col-md-12" style="display: none;"> 
                    <label class="form-label" for="first-name">Categoria</label>
                    <input class="form-control" name="categoria" type="text" aria-label="First name">
                </div>
                <div class="col-md-4"> 
                    <label class="form-label" for="first-name">Orden</label>
                    <select name="orden" class="form-control">
                        <option value="libre">Libre</option>
                        <option value="desc">Descendente</option>
                    </select>
                </div>
                <div class="col-md-8" style="display: none;"> 
                    <label class="form-label" for="first-name"> Grupo</label>
                    <textarea name="grupo" class="form-control" rows="1"></textarea>
                </div>
            </div>
        </div>
          <div class="modal-footer bg-info d-flex justify-content-between pb-0">
              <input class="form-control" type="hidden" name="actions" value="22">
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
            "ajax": "index.php?action=apiliga",
            "columns": [
                { "data": function(row) {
                        return row.nombre ;
                    }
                },
                {   "data": "temporadas" },
                // {
                //     "data": function(row) {
                //         return new Date(row.fechainicio).toLocaleDateString();
                //     }
                // },
                // {
                //     "data": function(row) {
                //         var fechaInicio = new Date(row.fechainicio).toLocaleDateString();
                //         var fechaFinal = new Date(row.fechafinal).toLocaleDateString();
                //         return fechaInicio + " - " + fechaFinal;
                //     }
                // },
                { "data": function(row) {
                        return "<span style='color: blue;'>(" + moment(row.fechainicio).format('DD-MM-YYYY') + ")</span>" + ' - ' + "<span style='color: blue;'>(" + moment(row.fechafinal).format('DD-MM-YYYY') + ")</span>";
                    }
                },
                { 
                    "data": "fechafinalmodificacion",
                    "render": function(data, type, row) {
                        return moment(data).format('DD-MM-YYYY');
                    }
                },
                // {
                //     "data": function(row) {
                //         return new Date(row.fechafinalmodificacion).toLocaleString();
                //     }
                // },
                { "data": function(row) {
                        return row.minimo + " - " + row.maximo ;
                    }
                },

                {   "data": "edad"
                },

                // {   "data": "categoria"
                // },

                // {   "data": "grupo"
                // },
                
                { "data": "estado",
                    "render": function(data, type, row) {
                        if(data == 1) {
                            return '<i class="ri ri-checkbox-circle-line text-success"></i>';
                        } else {
                            return '<i class="ri  ri-close-circle-line text-danger"></i>';
                        }
                    }
                },
                <?php if ($u->club=="") { ?>
                { 
                    "data": null,
                    "render": function (data, type, row) {
                        return '<button class="btn btn-info btn-sm clubes-btn" data-id="' + row.id + '"><i style="font-size: 6px;" class="ri-medal-fill"></i></button>' + ' ' + '<button class="btn btn-primary btn-sm edit-btn" data-id="' + row.id + '">Editar</button>' + ' ' 
                        + '<button class="btn btn-danger btn-sm delete-btn" data-id="' + row.id + '">Eliminar</button>';
                    }
                }   <?php } ?>
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
            if ($('#temporada-fieldd option').length <= 1) {
                    $.ajax({
                        url: 'index.php?action=apitemporadas',
                        method: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            data.forEach(function(temporada) {
                                $('#temporada-fieldd').append($('<option>', {
                                    value: temporada.id,
                                    text: temporada.nombre
                                }));
                            });
                        }
                    });
                }
        });
        $('#customerTable').on('click', '.edit-btn', function() {
            let id = $(this).data('id');
            $.get("index.php?action=getliga&id=" + id, function(data) {
                $('#nombre').val(data.nombre);
                if (data.fechainicio) {
                    $('#fechainicio').val(data.fechainicio.slice(0, 10));
                } else {
                    $('#fechainicio').val(''); 
                }                if (data.fechafinal) {
                    $('#fechafinal').val(data.fechafinal.slice(0, 10));
                } else {
                    $('#fechafinal').val(''); 
                }
                if (data.fechafinalmodificacion) {
                    $('#fechafinalmodificacion').val(data.fechafinalmodificacion.replace(' ', 'T').slice(0, 16));
                } else {
                    $('#fechafinalmodificacion').val(''); 
                }

                $('#minimo').val(data.minimo);
                $('#maximo').val(data.maximo);
                $('#edad').val(data.edad);
                $('#categoria').val(data.categoria);
                // $('#orden').val(data.orden);
                var orden = data.orden;
                    $('#orden').val(orden);
                    if (!orden) {
                        $('#orden').val('libre');
                    } else if (orden === 'desc') {
                        $('#orden').val('desc');
                    }
                $('#grupo').val(data.grupo);
                $('#ids').val(data.id);
                if(data.estado == 1) {
                    $('#estado').prop('checked', true);
                } else {
                    $('#estado').prop('checked', false);
                }
                $.ajax({
                    url: 'index.php?action=apitemporadas',
                    method: 'GET',
                    dataType: 'json',
                    success: function(temporadas) {
                        $('#temporada').empty();
                        $('#temporada').append($('<option>', {value: '', text: 'Elegir'}));
                        temporadas.forEach(function(temporada) {
                            $('#temporada').append($('<option>', {
                                value: temporada.id,
                                text: temporada.nombre
                            }));
                        });
                        $('#temporada').val(data.temporada);
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
        // ************************************************************
        $('#customerTable').on('click', '.clubes-btn', function() {
            let id = $(this).data('id');
            $('#id11').val(id);
            $('#liga').val(id);
            $('#ProgramasModal').modal('show');

            if ($.fn.DataTable.isDataTable('#fullgrupos')) {
                $('#fullgrupos').DataTable().clear().destroy();
            }

            $('#fullgrupos').DataTable({
                "processing": true,
                "serverSide": true,
                "pageLength": 25, // Muestra 25 registros por defecto
                "lengthMenu": [[10, 25, 50, 1000], [10, 25, 50, "Todos"]], // Sólo se permiten estas opciones en el menú
                "ajax": {
                    "url": "index.php?action=apisusclubes&id=" + id,
                    "type": "GET",
                    "dataSrc": "data"
                },
                "columns": [
                    { "data": "nombre" },
                    { "data": null,
                        "render": function(data, type, row) {
                            return '<input type="hidden" class="form-control" name="id_[]" value="' + row.id2 + '">' + row.telefono;
                        }
                    },
                    { "data": null,
                        "render": function(data, type, row) {
                            return '<input type="hidden" class="form-control" name="club_[]" value="' + row.id + '">' + row.correo;
                        }
                    },
                    { "data": null,
                        "render": function(data, type, row) {
                            return '<input type="text" class="form-control" name="cantidad_[]" value="' + row.cantidades + '">';
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
        });
        // $('form.tablelist-form').on('submit', function(e) {
        //     e.preventDefault();
        //     var $form = $(this);
        //     $form.find('input[name="programa_id[]"], input[name="deselected_programa_id[]"], input[name="nivel_programa[]"]').remove();

        //     selectedProgramas.forEach(function(ProgramaId) {
        //         var nivel = $('.nivel-select[data-programa-id="'+ProgramaId+'"]').val();
        //         $form.append('<input type="hidden" name="programa_id[]" value="' + ProgramaId + '">');
        //         $form.append('<input type="hidden" name="nivel_programa[' + ProgramaId + ']" value="' + nivel + '">');
        //     });
        //     deselectedProgramas.forEach(function(ProgramaId) {
        //         $form.append('<input type="hidden" name="deselected_programa_id[]" value="' + ProgramaId + '">');
        //     });
            
        //     this.submit();
        // });
        // ************************************************************
    });
</script>
<?php } else {
    header("Location: ./"); 
    exit();
} ?>
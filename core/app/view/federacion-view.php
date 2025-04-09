<?php
if (
    isset($_SESSION["conticomtc"]) &&
    isset($_SESSION["typeuser"]) && $_SESSION["typeuser"] == 1 &&
    isset($_SESSION["cargo"]) && $_SESSION["cargo"] == 1
) {
    // El usuario tiene acceso: rol administrativo y cargo 1 (Federación)
    $u = UserData::verid($_SESSION['conticomtc']);
?>
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
                            <h5 class="card-title mb-0 text-white">Equipos por gestionar</h5>
                        </div>
                        <div class="card-body">
                            <table id="customerTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%; font-size: 10px;">
                                <thead>
                                    <tr class="table-primary">
                                        <th>Equipo</th>
                                        <th>Liga</th>
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
<!-- Modal de Enviar a la Federación -->
<div class="modal fade" id="Federacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <h4 class="card-title text-center mb-4">Información del Equipo</h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <p class="font-weight-bold">Equipo:</p>
                                <p id="nombre" class="card-text"></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="font-weight-bold">Club:</p>
                                <p id="clubes" class="card-text"></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="font-weight-bold">Capitán:</p>
                                <p id="capitanes" class="card-text"></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="font-weight-bold">Fecha de nacimiento:</p>
                                <p id="nacimiento1" class="card-text"></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="font-weight-bold">Subcapitán:</p>
                                <p id="subcapitanes" class="card-text"></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="font-weight-bold">Fecha de nacimiento:</p>
                                <p id="nacimiento2" class="card-text"></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="font-weight-bold">Estado:</p>
                                <p id="estados" class="card-text"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estado" class="form-label">Gestionar Equipo</label>
                    <select name="estado" id="estado" class="form-select">
                        <option selected disabled hidden>Elegir...</option>
                        <option value="3">Aceptar</option>
                        <option value="4">Rechazar</option>
                        <option value="5">Incluir observación</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="mensajefederacion" class="form-label">¿Quieres añadir algún comentario?</label>
                    <textarea name="mensajefederacion" id="mensajefederacion" class="form-control" rows="3"></textarea>
                </div>
            </div>
          <div class="modal-footer bg-info d-flex justify-content-between pb-0">
              <input class="form-control" type="hidden" name="actions" value="31">
              <input class="form-control" type="hidden" name="id" id="ids1">
              <button type="button" class="btn btn-outline-light me-2" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-light">Enviar</button>
            </div>
        </form>
        
    </div>
  </div>
</div>
<div class="modal fade" id="basededatos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info">
        <h5 class="modal-title text-white" id="exampleModalLabel">Base de datos de Jugadores</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <form enctype="multipart/form-data" method="POST" class="tablelist-form" autocomplete="off" action="index.php?action=registro">
            <div class="modal-body bg-light">
                <div class="card-body">
                    <table id="customerTable1" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                        <thead>
                            <tr class="table-primary">
                                <th>Nombre y apellidos</th>
                                <th>FIDE</th>
                                <th>F. nacimiento</th>
                                <th>Teléfono</th>
                                <th>Club (Cod)</th>
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
            // "ajax": "index.php?action=apiequipo",
            "ajax": "index.php?action=apifederacion",
            "columns": [
                { "data": function(row) {
                        return row.nombre ;
                    }
                },
                { "data": "ligas" },
                { "data": "clubes" },
                { "data": function(row) {
                        return row.capitanes + ' ' + "<span style='color: blue;'>(" + moment(row.nacimiento1).format('DD-MM-YYYY') + ")</span>";
                    }
                },
                { "data": function(row) {
                        return row.subcapitanes + ' <span style="color: blue;">(' + moment(row.nacimiento2).format('DD-MM-YYYY') + ')</span>';
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
                            // return '<button class="btn btn-sm btn-success" data-id="' + row.id + '">Aceptado</button>';
                            return '<span class="text-success">Aceptado</span>';
                        }
                        if(data == 4) {
                            // return '<button class="btn btn-sm btn-danger" data-id="' + row.id + '">Rechazado</button>';
                            return '<span class="text-danger">Rechazado</span>';
                        }
                        if(data == 5) {
                            // return '<button class="btn btn-sm btn-warning" data-id="' + row.id + '">Observado</button>';
                            return '<span class="text-warning">Añadido comentario</span>';
                        }
                    }
                },
                { 
                    "data": null,
                    "render": function (data, type, row) { 
                        return '<button title="Validar el Equipo" class="btn btn-info btn-sm federacion-btn" data-id="' + row.id + '"><i class="ri-checkbox-circle-fill"></i></button>' + ' ' + '<button title="Mostrar la lista de jugadores" class="btn btn-primary btn-sm jugadores-btn" data-id="' + row.id + '"><i class="ri-group-line"></i></button>';
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

        $('#customerTable').on('click', '.federacion-btn', function() {
            let id = $(this).data('id');
            $.get("index.php?action=getequipo&id=" + id, function(data) {
                $('#clubes').text(data.clubes);
                $('#nombre').text(data.nombre);
                $('#descripcion').text(data.descripcion);
                $('#nacimiento1').text('' + moment(data.nacimiento1).format('DD-MM-YYYY'));
                // $('#cantidad').text(data.cantidad);
                $('#nacimiento2').text(moment(data.nacimiento2).format('DD-MM-YYYY'));
                $('#ids1').val(data.id);
                $('#capitanes').text(data.capitanes);
                $('#subcapitanes').text(data.subcapitanes);
                $('#mensajefederacion').val(data.mensajefederacion);
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
                    $('#estados').text('Con comentario').css('color', '#0275d8'); // Azul claro para 'Observado'
                }

                $('#Federacion').modal('show');
            }, "json");
        });
        $(document).ready(function() {
            $('#customerTable').on('click', '.jugadores-btn', function() {
                let id = $(this).data('id');
                $('#customerTable1').DataTable().destroy(); 
                $('#basededatos').one('shown.bs.modal', function () {
                    $('#customerTable1').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": "index.php?action=apijugadorequipo&equipo=" + id,
                        "columns": [
                            { "data": function(row) {
                                return row.nombre + ' ' + row.apellido1 + ' '+ row.apellido2 ;
                            }},
                            { "data": "numlicencia" },
                            // { "data": "nacimiento" },
                            { 
                                "data": "nacimiento",
                                "render": function(data, type, row) {
                                    return moment(data).format('DD-MM-YYYY');
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
                                        return '<i class="ri ri-close-circle-line text-danger"></i>';
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
                        }
                    });
                }).modal('show');
            });
        });
    });
</script>
<?php } else {
    header("Location: ./"); 
    exit();
} ?>
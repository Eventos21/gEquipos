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
                            <h5 class="card-title mb-0 text-white">Lista de registro de Emparejamientos</h5>
                            <div class="d-flex ms-auto">
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="customerTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                <thead>
                                    <tr class="table-primary">
                                        <th>Nº Sala</th>
                                        <th>Liga</th>
                                        <th>Competición</th>
                                        <th width="50px">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Datos del club -->
                                </tbody>
                            </table>
<script>
    $(document).ready(function() {
        $('#customerTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "index.php?action=apisala",
            "columns": [
                { "data": function(row) { return 'Sala: ' + row.codigo; } },
                { "data": "ligas" },
                { "data": "competiciones" },
                { "data": null,
                    "render": function(data, type, row) {
                        let buttons = '<button title="Tabla de distribución" class="btn btn-info btn-sm tabla-btn" data-id="' + row.id + '"><i class="ri-table-2"></i></button>';
                        
                        if (row.nombregrupo.toLowerCase() === 'división de honor') {
                            buttons += ' <button title="Tabla" class="btn btn-primary btn-sm registro1-btn" data-id="' + row.id + '"><i class="ri-edit-2-fill"></i></button>';
                        } else {
                            buttons += ' <button title="Actualizar" class="btn btn-primary btn-sm registro-btn" data-id="' + row.id + '"><i class="ri-edit-2-fill"></i></button>';
                        }
                        return buttons;
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

        // Event listener for the action buttons
        $('#customerTable').on('click', '.tabla-btn', function() {
            let id = $(this).data('id');
            $.get("index.php?action=apivalorequipo&sala=" + id, function(data) {
                $('#id1').val(id);
                $('#id2').val(id);
                const encuentros = [
                    [1, 14, 2, 13, 3, 12, 4, 11, 5, 10, 6, 9, 7, 8],
                    [14, 8, 9, 7, 10, 6, 11, 5, 12, 4, 13, 3, 1, 2],
                    [2, 14, 3, 4, 13, 5, 12, 6, 11, 7, 10, 8, 9, 1],
                    [14, 9, 10, 8, 11, 7, 12, 6, 13, 5, 1, 4, 2, 3],
                    [3, 14, 4, 2, 5, 1, 6, 13, 7, 12, 8, 11, 9, 10],
                    [14, 10, 11, 9, 12, 8, 13, 7, 1, 6, 2, 5, 3, 4],
                    [4, 14, 5, 3, 6, 2, 7, 1, 8, 13, 9, 12, 10, 11],
                    [14, 11, 12, 10, 13, 9, 1, 8, 2, 7, 3, 6, 4, 5],
                    [5, 14, 6, 4, 7, 3, 8, 2, 9, 1, 10, 13, 11, 12],
                    [14, 12, 13, 11, 1, 10, 2, 9, 3, 8, 4, 7, 5, 6],
                    [6, 14, 7, 5, 8, 4, 9, 3, 10, 2, 11, 1, 12, 13],
                    [14, 13, 1, 12, 2, 11, 3, 10, 4, 9, 5, 8, 6, 7],
                    [7, 14, 8, 6, 9, 5, 10, 4, 11, 3, 12, 2, 13, 1]
                ];
                const encuentrosdh = [
                    [1, 8, 2, 7, 3, 6, 4, 5],
                    [8, 5, 6, 4, 7, 3, 1, 2],
                    [2, 8, 3, 1, 4, 7, 5, 6],
                    [8, 6, 7, 5, 1, 4, 2, 3],
                    [3, 8, 4, 2, 5, 1, 6, 7],
                    [8, 7, 1, 6, 2, 5, 3, 4],
                    [4, 8, 5, 3, 6, 2, 7, 1],
                    [8, 1, 7, 2, 6, 3, 5, 4],
                    [5, 8, 4, 6, 3, 7, 2, 1],
                    [8, 2, 1, 3, 7, 4, 6, 5],
                    [6, 8, 5, 7, 4, 1, 3, 2],
                    [8, 3, 2, 4, 1, 5, 7, 6],
                    [7, 8, 6, 1, 5, 2, 4, 3],
                    [8, 4, 3, 5, 2, 6, 1, 7]
                ];

                let tipojuego = {};
                let valores = {};
                let valorequipo = {};
                data.forEach(function(equipo) {
                    valores[equipo.valor] = equipo.nombre;
                    valorequipo[equipo.valor] = equipo.equipo;
                    tipojuego[equipo.nombregrupo] = equipo.nombregrupo;
                });

                if (tipojuego[Object.keys(tipojuego)[0]].toLowerCase() === 'división de honor') {
                    let tbody = $('#tablaCompeticionDH tbody');
                    tbody.empty();

                    for (let i = 0; i < encuentrosdh.length; i++) {
                        let row = `<tr><td>Ronda ${i + 1}</td>`;
                        row += `<td><input type="date" name="fecha_encuentro[]"></td>`;
                        for (let j = 0; j < 8; j += 2) {
                            let valor1 = encuentrosdh[i][j];
                            let valor2 = encuentrosdh[i][j + 1];
                            let equipo1 = valores[valor1] || '-';
                            let equipo2 = valores[valor2] || '-';

                            let valor11 = encuentrosdh[i][j];
                            let valor22 = encuentrosdh[i][j + 1];
                            let equipo11 = valorequipo[valor11] || '-';
                            let equipo22 = valorequipo[valor22] || '-';

                            row += `<td><input type="hidden" name="valor_a[]" value="${equipo11}">${equipo1} - ${equipo2}<input type="hidden" name="valor_b[]" value="${equipo22}"></td>`;
                        }
                        row += `</tr>`;
                        tbody.append(row);
                    }

                    $('#tablacompeticionDHModal').modal('show');
                } else {
                    let tbody = $('#tablaCompeticion tbody');
                    tbody.empty();

                    for (let i = 0; i < encuentros.length; i++) {
                        let row = `<tr><td>Ronda ${i + 1}</td>`;
                        row += `<td><input type="date" name="fecha_encuentro[]"></td>`;
                        for (let j = 0; j < 14; j += 2) {
                            let valor1 = encuentros[i][j];
                            let valor2 = encuentros[i][j + 1];
                            let equipo1 = valores[valor1] || '-';
                            let equipo2 = valores[valor2] || '-';

                            let valor11 = encuentros[i][j];
                            let valor22 = encuentros[i][j + 1];
                            let equipo11 = valorequipo[valor11] || '-';
                            let equipo22 = valorequipo[valor22] || '-';
                            row += `<td><input type="hidden" name="valor_a[]" value="${equipo11}">${equipo1} - ${equipo2}<input type="hidden" name="valor_b[]" value="${equipo22}"></td>`;
                        }

                        row += `</tr>`;
                        tbody.append(row);
                    }
                    $('#tablacompeticionModal').modal('show');
                }
            }, "json");
        });

        $('#customerTable').on('click', '.registro-btn', function() {
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
                    "url": "index.php?action=apicompetecionesn&id=" + id,
                    "type": "GET",
                    "dataSrc": ""
                },
                "paging": false,  // Desactiva la paginación
                "lengthChange": false,  // Desactiva el control de cambiar el número de entradas por página
                "searching": true,  // Activa el buscador
                "info": false,  // Oculta la información de 'Showing 0 to 0 of 0 entries'
                "columns": [
                    { 
                        "data": null, 
                        "render": function (data, type, row, meta) {
                            return meta.row + 1;  // Añade el contador de registros
                        }
                    },
                    { 
                        "data": "fecha_encuentro",
                        "render": function(data) {
                            return '<input style="font-size: 9px" type="date" class="form-control" name="fecha_encuentro_[]" value="' + data + '">';
                        }
                    },
                    { "data": null,
                        "render": function(data, type, row) {
                            return '<input type="hidden" class="form-control" name="id_[]" value="' + row.id + '">' + row.equipo1 + ' - ' + row.equipo2;
                        }
                    },
                    // { "data": function(row) {
                    //         return row.equipo1 + ' - ' + row.equipo2 ;
                    //     }
                    // },
                    { "data": function(row) {
                            return row.equipo3 + ' - ' + row.equipo4 ;
                        }
                    },
                    { "data": function(row) {
                            return row.equipo5 + ' - ' + row.equipo6 ;
                        }
                    },
                    { "data": function(row) {
                            return row.equipo7 + ' - ' + row.equipo8 ;
                        }
                    },
                    { "data": function(row) {
                            return row.equipo9 + ' - ' + row.equipo10 ;
                        }
                    },
                    { "data": function(row) {
                            return row.equipo11 + ' - ' + row.equipo12 ;
                        }
                    },
                    { "data": function(row) {
                            return row.equipo13 + ' - ' + row.equipo14 ;
                        }
                    }
                ]
            });
        });

        $('#customerTable').on('click', '.registro1-btn', function() {
            let id = $(this).data('id');
            $('#id111').val(id);
            $('#liga1').val(id);
            $('#ProgramasModal1').modal('show');

            if ($.fn.DataTable.isDataTable('#fullgrupos1')) {
                $('#fullgrupos1').DataTable().clear().destroy();
            }
            $('#fullgrupos1').DataTable({
                "processing": true,
                "serverSide": true,
                "pageLength": 25, // Muestra 25 registros por defecto
                "lengthMenu": [[10, 25, 50, 1000], [10, 25, 50, "Todos"]], // Sólo se permiten estas opciones en el menú
                "ajax": {
                    "url": "index.php?action=apicompetecionesn1&id=" + id,
                    "type": "GET",
                    "dataSrc": ""
                },
                "paging": false,  // Desactiva la paginación
                "lengthChange": false,  // Desactiva el control de cambiar el número de entradas por página
                "searching": true,  // Activa el buscador
                "info": false,  // Oculta la información de 'Showing 0 to 0 of 0 entries'
                "columns": [
                    { 
                        "data": null, 
                        "render": function (data, type, row, meta) {
                            return meta.row + 1;  // Añade el contador de registros
                        }
                    },
                    { 
                        "data": "fecha_encuentro",
                        "render": function(data) {
                            return '<input style="font-size: 9px" type="date" class="form-control" name="fecha_encuentro_[]" value="' + data + '">';
                        }
                    },
                    { "data": null,
                        "render": function(data, type, row) {
                            return '<input type="hidden" class="form-control" name="id_[]" value="' + row.id + '">' + row.equipo1 + ' - ' + row.equipo2;
                        }
                    },
                    { "data": function(row) {
                            return row.equipo3 + ' - ' + row.equipo4 ;
                        }
                    },
                    { "data": function(row) {
                            return row.equipo5 + ' - ' + row.equipo6 ;
                        }
                    },
                    { "data": function(row) {
                            return row.equipo7 + ' - ' + row.equipo8 ;
                        }
                    }
                ]
            });
        });

    });
</script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .table thead th {
        background-color: #007bff;
        color: #fff;
    }
    .table tbody td {
        vertical-align: middle;
    }
    .table-container {
        margin-top: 20px;
    }
    .search-container {
        margin-bottom: 20px;
    }
</style>
<div class="modal fade" id="tablacompeticionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white" id="exampleModalLabel">Tabla de Competición</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form enctype="multipart/form-data" method="POST" class="tablelist-form" autocomplete="off" action="index.php?action=registro">
            <div class="modal-body bg-light">
                <div class="row">
                    <table id="tablaCompeticion" class="table table-bordered table-hover table-striped align-middle" style="width:100%; font-size: 10px;">
                        <thead>
                            <tr>
                                <th>Ronda</th>
                                <th>Fecha</th>
                                <th>Encuentro 1</th>
                                <th>Encuentro 2</th>
                                <th>Encuentro 3</th>
                                <th>Encuentro 4</th>
                                <th>Encuentro 5</th>
                                <th>Encuentro 6</th>
                                <th>Encuentro 7</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 9px;">
                            <!-- Contenido dinámico -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-info d-flex justify-content-between pb-0">
                <input class="form-control" type="hidden" name="actions" value="49">
                <input class="form-control" type="hidden" name="sala" id="id1">
                <button type="button" class="btn btn-outline-light me-2" data-bs-dismiss="modal">Cerrar</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="tablacompeticionDHModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white" id="exampleModalLabel">Tabla de Competición (DH)</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form enctype="multipart/form-data" method="POST" class="tablelist-form" autocomplete="off" action="index.php?action=registro">
            <div class="modal-body bg-light">
                <div class="row">
                    <table id="tablaCompeticionDH" class="table table-bordered table-hover table-striped align-middle" style="width:100%; font-size: 10px;">
                        <thead>
                            <tr>
                                <th>Ronda</th>
                                <th>Fecha</th>
                                <th>Encuentro 1</th>
                                <th>Encuentro 2</th>
                                <th>Encuentro 3</th>
                                <th>Encuentro 4</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 9px;">
                            <!-- Contenido dinámico -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-info d-flex justify-content-between pb-0">
                <input class="form-control" type="hidden" name="actions" value="50">
                <input class="form-control" type="hidden" name="sala" id="id2">
                <button type="button" class="btn btn-outline-light me-2" data-bs-dismiss="modal">Cerrar</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- modal Competiciones -->
<div class="modal fade" id="ProgramasModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content border-5">
      <div class="modal-header bg-info">
        <h5 class="modal-title text-white" id="exampleModalLabel">Actualizar Fechas</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form enctype="multipart/form-data" class="tablelist-form" autocomplete="off" method="post" action="index.php?action=registro">
        <div class="modal-body bg-light">
            <table id="fullgrupos" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%; font-size: 9px" >
                <thead class="table table-bordered dt-responsive nowrap table-striped align-middle">
                    <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Encuentro 1</th>
                        <th>Encuentro 2</th>
                        <th>Encuentro 3</th>
                        <th>Encuentro 4</th>
                        <th>Encuentro 5</th>
                        <th>Encuentro 6</th>
                        <th>Encuentro 7</th>
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
              <input type="hidden" name="actions" value="51">
              <button type="button" class="btn btn-outline-light me-2" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </form>
    </div>
  </div>
</div>
<!-- modal Competiciones1 -->
<div class="modal fade" id="ProgramasModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content border-5">
      <div class="modal-header bg-info">
        <h5 class="modal-title text-white" id="exampleModalLabel">Actualizar dato</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form enctype="multipart/form-data" class="tablelist-form" autocomplete="off" method="post" action="index.php?action=registro">
        <div class="modal-body bg-light">
            <table id="fullgrupos1" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%; font-size: 9px" >
                <thead class="table table-bordered dt-responsive nowrap table-striped align-middle">
                    <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Encuentro 1</th>
                        <th>Encuentro 2</th>
                        <th>Encuentro 3</th>
                        <th>Encuentro 4</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Cuerpo de la tabla generado por DataTables -->
                </tbody>
            </table>
        </div>
          <div class="modal-footer bg-info d-flex justify-content-between pb-0">
              <input type="hidden" name="id" id="id111">
              <input type="hidden" name="liga" id="liga1">
              <input type="hidden" name="actions" value="51">
              <button type="button" class="btn btn-outline-light me-2" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </form>
    </div>
  </div>
</div>
<!-- nuevo registro  -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
    <div class="modal-content border-5">
      <div class="modal-header bg-info">
        <h5 class="modal-title text-white" id="exampleModalLabel">Asignar su valor a equipos</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form enctype="multipart/form-data" method="POST" class="tablelist-form" autocomplete="off" action="index.php?action=registro">
        <div class="modal-body bg-light">
            <style>
                .liga-div {
                    display: none;
                }
            </style>
            <div class="row">
                <div class="col-md-4">
                    <label class="form-label me-2" for="liga-field">Ligas</label>
                    <!-- <select class="form-select" name="liga" id="cargo-fieldd" required> -->
                    <select class="form-select" name="liga" id="liga-field" required>
                        <option value="">Elegir</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label me-2" for="competicion-field">Competiciones</label>
                    <select class="form-select" name="competicion" id="competicion-field" required>
                        <option value="">Elegir</option>
                    </select>
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="mt-4">
                    <h5 class="fs-14 mb-1">Lista de Equipos</h5>
                    <select multiple="multiple" name="equipo" class="listar_equipos" id="multiselect-optiongroup">
                    </select>
                </div>
                <script>
                    $(document).ready(function() {
                        $.ajax({
                            url: 'index.php?action=apiligas',
                            method: 'GET',
                            dataType: 'json',
                            success: function(response) {
                                $('#liga-field').empty();
                                $('#liga-field').append('<option value="">Seleccionar</option>');
                                $.each(response, function(index, liga) {
                                    $('#liga-field').append('<option value="' + liga.id + '">' + liga.nombre + '</option>');
                                });
                            }
                        });
                        $('#liga-field').change(function() {
                            var especialidadId = $(this).val();
                            if (especialidadId) {
                                $.ajax({
                                    url: 'index.php?action=apilistarcompeticiones&especialidadId=' + especialidadId,
                                    method: 'GET',
                                    dataType: 'json',
                                    success: function(response) {
                                        $('#competicion-field').empty().prop('disabled', false);
                                        $('#competicion-field').append('<option value="">Seleccionar</option>');
                                        $.each(response, function(index, competicion) {
                                            $('#competicion-field').append('<option value="' + competicion.id + '">' + competicion.nombregrupo + ' (' + competicion.grupo + ')' + ' ' + competicion.tipocompinombre + '</option>');
                                        });
                                    }
                                });
                            } else {
                                $('#competicion-field').empty().prop('disabled', true);
                            }
                        });
                    });
                </script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const cargoField = document.getElementById('competicion-field');
                        const equiposSelect = document.getElementById('multiselect-optiongroup');

                        // Inicializar multi.js al cargar la página
                        multi(equiposSelect, {
                            non_selected_header: 'No seleccionado',
                            selected_header: 'Seleccionado'
                        });

                        cargoField.addEventListener('change', function() {
                            const ligaId = this.value;
                            equiposSelect.innerHTML = '<option value="refres">Actualizando...</option>';
                            if (ligaId) {
                                console.log(`Seleccionada la liga con ID: ${ligaId}`); // Depuración
                                const xhr = new XMLHttpRequest();
                                xhr.open('GET', 'index.php?action=apilistarequipos_liga&liga=' + ligaId, true);
                                xhr.onreadystatechange = function() {
                                    if (xhr.readyState === 4) {
                                        if (xhr.status === 200) {
                                            console.log('Respuesta AJAX recibida: ', xhr.responseText); // Depuración
                                            equiposSelect.innerHTML = '';  // Limpiar las opciones previas
                                            const equipos = JSON.parse(xhr.responseText);
                                            if (equipos.length > 0) {
                                                equipos.forEach(function(equipo) {
                                                    const option = document.createElement('option');
                                                    option.value = equipo.id;
                                                    option.text = equipo.nombre;
                                                    equiposSelect.appendChild(option);
                                                });
                                            } else {
                                                equiposSelect.innerHTML = '<option value="">No hay equipos disponibles</option>';
                                            }
                                            // Informar a multi.js sobre el cambio de opciones
                                            equiposSelect.dispatchEvent(new Event('change'));
                                        } else {
                                            console.error('Error al realizar la solicitud AJAX', xhr.status, xhr.statusText); // Depuración
                                        }
                                    }
                                };
                                xhr.send();
                            } else {
                                equiposSelect.innerHTML = '<option value="refres">Dale clic</option>';
                            }
                        });

                        function actualizarEstadoBoton() {
                            if (document.querySelectorAll('#listatabla tbody tr').length > 0) {
                                document.getElementById('add-btn').disabled = false;
                            } else {
                                document.getElementById('add-btn').disabled = true;
                            }
                        }
                        actualizarEstadoBoton();

                        document.getElementById('btnAgregar').addEventListener('click', function(e) {
                            e.preventDefault();

                            const equiposSelect = document.getElementById('multiselect-optiongroup');
                            const seleccionados = Array.from(equiposSelect.selectedOptions);

                            if (seleccionados.length === 0) {
                                equiposSelect.classList.add('campo-faltante');
                                equiposSelect.focus();
                                return;
                            } else {
                                equiposSelect.classList.remove('campo-faltante');
                            }

                            // Obtener el número de filas actuales para iniciar el contador correctamente
                            let counter = document.querySelectorAll('#listatabla tbody tr').length + 1;

                            seleccionados.forEach(function(option) {
                                const id_equipo = option.value;
                                const nombre_equipo = option.text;

                                let exists = false;
                                document.querySelectorAll('#listatabla tbody tr').forEach(function(row) {
                                    if (row.querySelector('input[name="idequipo_[]"]').value === id_equipo) {
                                        exists = true;
                                    }
                                });

                                if (!exists) {
                                    const newRow = `
                                        <tr>
                                            <td>${counter}</td>
                                            <td><input type="hidden" name="idequipo_[]" value="${id_equipo}" />${nombre_equipo}</td>
                                            <td><input type="number" required name="nuevonuero_[]" /></td>
                                            <td><button type="button" class="btn btn-danger btn-sm btnEliminar"><i class="ri-delete-bin-2-line"></i></button></td>
                                        </tr>`;

                                    document.querySelector('#listatabla tbody').insertAdjacentHTML('beforeend', newRow);
                                    counter++;
                                }
                            });

                            actualizarEstadoBoton();
                        });

                        document.addEventListener('click', function(e) {
                            if (e.target && e.target.closest('.btnEliminar')) {
                                e.preventDefault();
                                e.target.closest('tr').remove();

                                // Reasignar el contador después de eliminar una fila
                                document.querySelectorAll('#listatabla tbody tr').forEach((row, index) => {
                                    row.querySelector('td').textContent = index + 1;
                                });

                                actualizarEstadoBoton();
                            }
                        });
                    });
                </script>
                <hr>
                <div class="col-md-12 d-flex align-items-end">
                    <button id="btnAgregar" title="Agregar a la lista" class="btn btn-info btnguardar w-100">
                        <i class="ri-add-line align-bottom me-1"> </i>Agregar a la lista
                    </button>
                </div>
            </div>
            <hr>
            <table id="listatabla" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%; font-size: 10px;">
                <thead class="bg-primary text-light">
                    <tr>
                        <th>Nº</th>
                        <th>Equipo</th>
                        <th width="20px"># del Equipo</th>
                        <th width="5px"><i class="ri-delete-bin-2-line"></i></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div> 
        <div class="modal-footer bg-info d-flex justify-content-between pb-0">
            <input class="form-control" type="hidden" name="actions" value="48">
        </div>
        </form>
    </div>
  </div>
</div>
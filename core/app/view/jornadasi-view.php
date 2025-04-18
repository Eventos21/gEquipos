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
                        <div class="card-header bg-primary text-white d-flex align-items-center justify-content-center">
                            <h5 class="card-title mb-0 text-white">Jornadas</h5>
                        </div>
                        <div class="card-body">
                            <table id="customerTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                <thead>
                                    <tr class="table-primary">
                                        <th>Nº</th>
                                        <th>Emparejamiento</th>
                                        <th>Resultado</th>
                                        <th>Autor</th>
                                        <th>Ok</th>
                                        <th>Actas</th>
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
<script>
    $(document).ready(function() {
        var rowCounter = 0;

        $('#customerTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "index.php?action=apijornadas",
                "type": "GET",
                "dataSrc": function (json) {
                    var dataWithComments = [];
                    for (var tipoCompeticion in json.data) {
                        if (json.data.hasOwnProperty(tipoCompeticion)) {
                            dataWithComments.push({
                                isComment: true,
                                comment: tipoCompeticion
                            });
                            json.data[tipoCompeticion].forEach(function (item) {
                                dataWithComments.push({
                                    ...item, // Copia todas las propiedades de item
                                    isComment: false // Añade la propiedad isComment
                                });
                            });
                        }
                    }
                    return dataWithComments;
                }
            },
            "paging": false,
            "lengthChange": false,
            "searching": true,
            "info": false,
            "columns": [
                {
                    "data": null,
                    "render": function (data, type, row, meta) {
                        if (data.isComment) {
                            rowCounter = 0; // Reinicia el contador cuando se encuentra un comentario
                            return ''; // Empty cell for the comment row
                        }
                        rowCounter++; // Incrementa el contador para cada fila de datos
                        return rowCounter;
                    }
                },
                {
                    "data": null,
                    "render": function(data) {
                        if (data.isComment) {
                            return '<strong>' + data.comment + '</strong>';
                        }
                        return '<input style="font-size: 9px" type="hidden" class="form-control" name="emparejamiento_[]" value="' + data.competencia_id + '">' + (data.equipoa || '') + ' - ' + (data.equipob || '') ;
                    }
                },
                {
                    "data": null,
                    "render": function(data) {
                        if (data.isComment) {
                            return ''; // Empty cell for the comment row
                        }
                        return '<input readonly style="font-size: 12px; width:35px" type="text" name="resultadoa_[]" value="' + data.resultado_a + '">' + ' - ' +
                            
                            '<input readonly style="font-size: 12px; width:35px" type="text" name="resultadob_[]" value="' + data.resultado_b + '">';
                    }
                },
                { "data": null,
                    "render": function(data) {
                        if (data.isComment) {
                            return ''; // Empty cell for the comment row
                        }
                        if (data.usuario === null || data.usuario === '') {
                            return '--';
                        } else {
                            return data.usuarios;
                        }
                    }
                },
                {
                    "data": null,
                    "render": function(data) {
                        if (data.isComment) {
                            return ''; // Empty cell for the comment row
                        }
                        return data.aprobacion;
                    }
                },
                {
                    "data": null,
                    "render": function(data) {
                        if (data.isComment) {
                            return ''; // Empty cell for the comment row
                        }
                        return '<form action="actasi" method="post">' +
                                '<input style="font-size: 9px" type="hidden" class="form-control" name="tid" value="' + data.id + '">' +
                                '<button class="btn btn-light btn-sm" type="submit">Acta</button>' +
                                '</form>' ;
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
            "rowCallback": function(row, data, index) {
                if (data.isComment) {
                    $(row).addClass('comment-row');
                }
            }
        });
    });
</script>
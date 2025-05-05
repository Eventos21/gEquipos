
<?php 
if (isset($_SESSION["conticomtc"]) && isset($_SESSION["typeuser"]) && ($_SESSION["typeuser"] == 1 || $_SESSION["typeuser"] == 2)) {
if ($_SESSION["typeuser"]==1) {
    $u = UserData::verid($_SESSION['conticomtc']);
}
if ($_SESSION["typeuser"]==2) {
    $u = JugadorData::verid($_SESSION['conticomtc']);
} ?>
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
                            <input type="text" id="calendar" placeholder="Selecciona una fecha" style="margin-bottom: 20px;">
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

        var table = $('#customerTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "index.php?action=apijornadasp",
                "type": "GET",
                "data": function (d) {
                    d.fecha = $('#calendar').val(); 
                },
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
                                    ...item,
                                    isComment: false
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
                <?php if ($u->cargo==1) { ?>
                {
                    "data": null,
                    "render": function(data) {
                        if (data.isComment) {
                            return ''; // Empty cell for the comment row
                        }
                        return '<form action="actas" method="post">' +
                                '<input style="font-size: 9px" type="hidden" class="form-control" name="tid" value="' + data.id + '">' +
                                '<button class="btn btn-light btn-sm" type="submit">Acta</button>' +
                                '</form>' ;
                    }
                } <?php } ?>
                <?php if ($u->cargo==3) { ?>
                {
                    "data": null,
                    "render": function(data) {
                        if (data.isComment) {
                            return ''; // Empty cell for the comment row
                        }
                        return '<form action="actasa" method="post">' +
                                '<input style="font-size: 9px" type="hidden" class="form-control" name="tid" value="' + data.id + '">' +
                                '<button class="btn btn-light btn-sm" type="submit">Acta</button>' +
                                '</form>' ;
                    }
                } <?php } ?>
                <?php if ($u->cargo==4) { ?>
                {
                    "data": null,
                    "render": function(data) {
                        if (data.isComment) {
                            return ''; // Empty cell for the comment row
                        }
                        return '<form action="actasc" method="post">' +
                                '<input style="font-size: 9px" type="hidden" class="form-control" name="tid" value="' + data.id + '">' +
                                '<button class="btn btn-light btn-sm" type="submit">Acta</button>' +
                                '</form>' ;
                    }
                } <?php } ?>
                <?php if ($u->cargo==5) { ?>
                {
                    "data": null,
                    "render": function(data) {
                        if (data.isComment) {
                            return ''; // Empty cell for the comment row
                        }
                        return '<form action="actasj" method="post">' +
                                '<input style="font-size: 9px" type="hidden" class="form-control" name="tid" value="' + data.id + '">' +
                                '<button class="btn btn-light btn-sm" type="submit">Acta</button>' +
                                '</form>' ;
                    }
                } <?php } ?>
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
        $("#calendar").flatpickr({
            defaultDate: getTodayDate(),
            locale: {
                firstDayOfWeek: 1,
                weekdays: {
                    shorthand: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
                    longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado']
                },
                months: {
                    shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                    longhand: [
                        'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                    ]
                }
            },
            onChange: function(selectedDates, dateStr, instance) {
                if (table) {
                    table.ajax.reload();
                }
            }
        });

        // Forzar recarga inicial al cargar con la fecha de hoy
        table.ajax.reload();

        function getTodayDate() {
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); // Enero es 0
            var yyyy = today.getFullYear();
            return yyyy + '-' + mm + '-' + dd;
        }
    });
</script>
<?php } else {
    header("Location: ./"); 
    exit();
} ?>

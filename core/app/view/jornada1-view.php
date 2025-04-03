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
                "url": "index.php?action=apijornada",
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
                        return '<input style="font-size: 9px" type="text" class="form-control" name="emparejamiento_[]" value="' + (data.equipo_a || '') + ' vs ' + (data.equipo_b || '') + '">';
                    }
                },
                {
                    "data": null,
                    "render": function(data) {
                        if (data.isComment) {
                            return ''; // Empty cell for the comment row
                        }
                        return '<input style="font-size: 9px" type="hidden" class="form-control" name="equipo_a[]" value="' + data.equipo_a + '">'+'<select class="" name="resultados">' +
                               '<option value="">Elegir</option>' +
                               '<option value="1">1</option>' +
                               '<option value="1/2">1/2</option>' +
                               '<option value="0">0</option>' +
                               '<option value="+">+</option>' +
                               '<option value="-">-</option>' +
                               '</select>' + ' ' + '<select class="" name="resultados">' +
                               '<option value="">Elegir</option>' +
                               '<option value="1">1</option>' +
                               '<option value="1/2">1/2</option>' +
                               '<option value="0">0</option>' +
                               '<option value="+">+</option>' +
                               '<option value="-">-</option>' +
                               '</select>' + '<input style="font-size: 9px" type="hidden" class="form-control" name="equipo_b[]" value="' + data.equipo_b + '">' +' '+ '<button class="btn btn-light btn-sm" type="submit">Enviar</button>';
                    }
                },
                {
                    "data": null,
                    "render": function(data) {
                        if (data.isComment) {
                            return ''; // Empty cell for the comment row
                        }
                        // return '<input style="font-size: 9px" type="text" class="form-control" name="autor_[]" value="' + (data.competicion) +'">';
                        return 'FMA';
                    }
                },
                {
                    "data": null,
                    "render": function(data) {
                        if (data.isComment) {
                            return ''; // Empty cell for the comment row
                        }
                        return 'N';
                    }
                },
                {
                    "data": null,
                    "render": function(data) {
                        if (data.isComment) {
                            return ''; // Empty cell for the comment row
                        }
                        return '<form action="acta" method="post">' +
                                '<input style="font-size: 9px" type="hidden" class="form-control" name="equipo_a" value="' + data.equipo_a + '">' +
                                '<input style="font-size: 9px" type="hidden" class="form-control" name="equipo_b" value="' + data.equipo_b + '">' + '<input style="font-size: 9px" type="hidden" class="form-control" name="competiciones" value="' + data.competencia_id + '">' + ' ' +
                                '<button class="btn btn-light btn-sm" type="submit">Acta</button>' + ' ' + 'S' +
                                '</form>' ;
                    }
                }
            ],
            "rowCallback": function(row, data, index) {
                if (data.isComment) {
                    $(row).addClass('comment-row');
                }
            }
        });
    });
</script>
<!-- <script>
    $(document).ready(function() {
        var rowCounter = 0;

        $('#customerTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "index.php?action=apijornada",
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
                        return '<input style="font-size: 9px" type="text" class="form-control" name="emparejamiento_[]" value="' + (data.encuentro1_a || '') + ' vs ' + (data.encuentro1_b || '') + '">';
                    }
                },
                {
                    "data": null,
                    "render": function(data) {
                        if (data.isComment) {
                            return ''; // Empty cell for the comment row
                        }
                        return '<input style="font-size: 9px" type="text" class="form-control" name="resultado_[]" value="' + (data.fecha_encuentro || '') + '">';
                    }
                },
                {
                    "data": null,
                    "render": function(data) {
                        if (data.isComment) {
                            return ''; // Empty cell for the comment row
                        }
                        return '<input style="font-size: 9px" type="text" class="form-control" name="autor_[]" value="' + (data.encuentro2_a || '') + ' vs ' + (data.encuentro2_b || '') + '">';
                    }
                },
                {
                    "data": null,
                    "render": function(data) {
                        if (data.isComment) {
                            return ''; // Empty cell for the comment row
                        }
                        return '<input style="font-size: 9px" type="text" class="form-control" name="ok_[]" value="' + (data.encuentro3_a || '') + ' vs ' + (data.encuentro3_b || '') + '">';
                    }
                },
                {
                    "data": null,
                    "render": function(data) {
                        if (data.isComment) {
                            return ''; // Empty cell for the comment row
                        }
                        return '<input style="font-size: 9px" type="text" class="form-control" name="actas_[]" value="' + (data.encuentro4_a || '') + ' vs ' + (data.encuentro4_b || '') + '">';
                    }
                }
            ],
            "rowCallback": function(row, data, index) {
                if (data.isComment) {
                    $(row).addClass('comment-row');
                }
            }
        });
    });
</script> -->

 <!-- <script>
    $(document).ready(function() {
        $('#customerTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "index.php?action=apijornada",
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
                                dataWithComments.push(item);
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
                            return ''; // Empty cell for the comment row
                        }
                        return meta.row + 1;
                    }
                },
                {
                    "data": null,
                    "render": function(data) {
                        if (data.isComment) {
                            return '<strong>' + data.comment + '</strong>';
                        }
                        return '<input style="font-size: 9px" type="text" class="form-control" name="emparejamiento_[]" value="' + data.encuentro1_a + ' vs ' + data.encuentro1_b + '">';
                    }
                },
                {
                    "data": null,
                    "render": function(data) {
                        if (data.isComment) {
                            return ''; // Empty cell for the comment row
                        }
                        return '<input style="font-size: 9px" type="text" class="form-control" name="resultado_[]" value="' + data.fecha_encuentro + '">';
                    }
                },
                {
                    "data": null,
                    "render": function(data) {
                        if (data.isComment) {
                            return ''; // Empty cell for the comment row
                        }
                        return '<input style="font-size: 9px" type="text" class="form-control" name="autor_[]" value="' + data.encuentro2_a + ' vs ' + data.encuentro2_b + '">';
                    }
                },
                {
                    "data": null,
                    "render": function(data) {
                        if (data.isComment) {
                            return ''; // Empty cell for the comment row
                        }
                        return '<input style="font-size: 9px" type="text" class="form-control" name="ok_[]" value="' + data.encuentro3_a + ' vs ' + data.encuentro3_b + '">';
                    }
                },
                {
                    "data": null,
                    "render": function(data) {
                        if (data.isComment) {
                            return ''; // Empty cell for the comment row
                        }
                        return '<input style="font-size: 9px" type="text" class="form-control" name="actas_[]" value="' + data.encuentro4_a + ' vs ' + data.encuentro4_b + '">';
                    }
                }
            ],
            "rowCallback": function(row, data, index) {
                if (data.isComment) {
                    $(row).addClass('comment-row');
                }
            },
            "drawCallback": function(settings) {
                var api = this.api();
                var rows = api.rows({ page: 'current' }).nodes();
                var lastTipoCompeticion = null;
                var contador = 1;
                api.column(0, { page: 'current' }).data().each(function(data, i) {
                    if (data.isComment) {
                        lastTipoCompeticion = data.comment;
                        contador = 1;
                    } else {
                        if (lastTipoCompeticion !== null) {
                            api.cell(rows[i], 0).data(contador).draw(false);
                            contador++;
                        }
                    }
                });
            }
        });
    });
</script> -->

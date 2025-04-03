<style>
    /* Estilo para botones */
    .btn {
        font-size: 10px; /* Tamaño de la fuente para botones */
        padding: 5px 8px; /* Espaciado interno de botones */
    }

    /* Estilo para contenido de la tabla */
    #customerTable th,
    #customerTable td {
        font-size: 10px;
        padding-left: 8px; /* Espaciado interno izquierdo */
        padding-right: 5px; /* Espaciado interno derecho */
        padding-top: 5px; /* Espaciado interno superior */
        padding-bottom: 5px; /* Espaciado interno inferior */
    }
</style>
<?php 
if ($_SESSION["typeuser"]==1) {
    $u = UserData::verid($_SESSION['conticomtc']);
}
if ($_SESSION["typeuser"]==2) {
    $u = JugadorData::verid($_SESSION['conticomtc']);
}
 ?>
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
                            <h5 class="card-title mb-0 text-white">Clasificación de Emparejamientos</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table  id="customerTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                    <thead>
                                        <tr class="table-primary">
                                            <th width="5px">Nº</th>
                                            <th>Equipo</th>
                                            <th>Partidas</th>
                                            <th>+ (Victorias)</th>
                                            <th>= (Empates)</th>
                                            <th>- (Derrotas)</th>
                                            <th>Inc (Incomparecencias)</th>
                                            <th>Puntos</th>
                                            <th>Olímpico</th>
                                            <th>Sonnenborg-Berger</th>
                                            <?php if ($u->cargo==1) { ?>
                                            <th>Sanción</th><?php } ?>
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
</div>
<script>
    function updateSancion(element, puntos, sala_id, equipo) {
        var sancion = element.value;
        var fila = element.parentNode.parentNode;
        var modificulo = fila.cells[7];
        var valoractual = parseFloat(modificulo.textContent);
        console.log(element);
        $.ajax({
            url: 'index.php?action=updatesancion',
            type: 'POST',
            data: {
                action: 'updatesancion',
                sala: sala_id,
                equipo: equipo,
                sancion: sancion
            },
            success: function(response) {
                console.log('Actualización exitosa:', response);
                modificulo.textContent=puntos-sancion;
            },
            error: function(xhr, status, error) {
                console.error('Error en la actualización:', error);
            }
        });
    }
$(document).ready(function() {
    var sancionCache = {};

    var table = $('#customerTable').DataTable({
        // "responsive": true,   
        // "fixedHeader": true,  
        // "pageLength": 30,     
        // "scrollY": "400px",   
        // // "scrollCollapse": true,  
        "paging": false,
        "ordering": false,
        "info": false,
        "ajax": {
            "url": "index.php?action=apiclasificacion",
            "type": "GET",
            "dataSrc": function(json) {
                console.log('Datos iniciales:', json);
                return json;
            }
        },
        "columns": [
            { 
                "data": null,
                "render": function(data, type, row, meta) {
                    if (row.is_separator) {
                        return ''; // No mostrar número de fila para el separador
                    }
                    var rowIndex = table.row(meta.row).index();
                    var prevData = table.row(rowIndex - 1).data();
                    if (prevData && prevData.is_separator) {
                        return 1; // Reiniciar el contador a 1 después del separador
                    } else {
                        var count = 1;
                        for (var i = rowIndex - 1; i >= 0; i--) {
                            var prevRow = table.row(i).data();
                            if (prevRow.is_separator) {
                                break;
                            }
                            count++;
                        }
                        return count;
                    }
                }
            },
            { "data": "nomequipo", "defaultContent": "" },
            { "data": "veces_jugadas", "defaultContent": "" },
            { "data": "victorias", "defaultContent": "" },
            { "data": "empates", "defaultContent": "" },
            { "data": "derrotas", "defaultContent": "" },
            { "data": "incomparecencias", "defaultContent": "" },
            { "data": "puntos", "defaultContent": "" },
            // {
            //     "data": "puntos", "defaultContent": "",
            //     "render": function(data, type, row, meta) {
            //         var sala_id = row.sala_id;
            //         var equipo = row.equipo;
            //         var puntosBase = parseFloat(data) || 0;
            //         var cacheKey = sala_id + '_' + equipo;

            //         if (sancionCache[cacheKey] !== undefined) {
            //             var puntosSancion = sancionCache[cacheKey];
            //             return puntosBase - puntosSancion;
            //         }

            //         // Hacer una solicitud AJAX para obtener los puntos de sanción si no están en caché
            //         $.ajax({
            //             url: 'index.php?action=apisancion',
            //             type: 'GET',
            //             data: {
            //                 sala: sala_id,
            //                 equipo: equipo
            //             },
            //             success: function(response) {
            //                 var puntosSancion = parseFloat(response.sancion) || 0;
            //                 sancionCache[cacheKey] = puntosSancion; // Almacenar en caché
            //                 var puntosTotales = puntosBase - puntosSancion;
            //                 table.cell(meta.row, meta.col).data(puntosBase).draw(false); // Redibujar solo esta celda
            //             },
            //             error: function(xhr, status, error) {
            //                 console.error('Error al obtener puntos de sanción:', error);
            //             }
            //         });

            //         // Mientras se obtienen los datos de sanción, mostrar los puntos base
            //         return puntosBase;
            //     }
            // },
            { "data": "olimpico", "defaultContent": "" },
            { "data": "sonnenborg_berger", "defaultContent": "" },
            <?php if ($u->cargo==1) { ?>
            {
                "data": null,
                "render": function(data, type, row) {
                    if (row.is_separator) return ''; // No mostrar campo de sanción para el separador
                    return '<input style="font-size: 9px; width: 50px;" type="text" name="sancion_[]" id="sancion_' + row.sala_id + '_' + row.equipo + '" onchange="updateSancion(this,\'' + row.puntos + '\', \'' + row.sala_id + '\', \'' + row.equipo + '\')" value="' + (row.sancion || '') + '">';
                }
            },<?php } ?>
        ],
        "rowCallback": function(row, data, index) {
            if (data.is_separator) {
                $(row).addClass('table-info'); 
                $('td', row).css('font-weight', 'bold');
                $('td', row).css('background-color', '#e9ecef');
                $('td', row).attr('colspan', 11); // Combinar todas las celdas de la fila
                $('td:gt(0)', row).remove(); // Eliminar celdas adicionales
                $('td:first', row).text(data.sala_id); // Mostrar el nombre del grupo
            }
        },
        "initComplete": function(settings, json) {
            json.forEach(function(row) {
                if (!row.is_separator) {
                    var cacheKey = row.sala_id + '_' + row.equipo;

                    if (!sancionCache[cacheKey]) {
                        $.ajax({
                            url: 'index.php?action=apisancion',
                            type: 'GET',
                            data: {
                                sala: row.sala_id,
                                equipo: row.equipo
                            },
                            success: function(response) {
                                var sancionData = parseFloat(response.sancion) || 0;
                                sancionCache[cacheKey] = sancionData; // Almacenar en caché
                                var inputId = '#sancion_' + row.sala_id + '_' + row.equipo;
                                var input = $(inputId);
                                if (input.length) {
                                    input.val(sancionData);
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error en la solicitud:', error);
                            }
                        });
                    }
                }
            });
        }
    });
});
</script>
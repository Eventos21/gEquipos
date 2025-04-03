<?php $usuarioss = JugadorData::verid($_POST['tid']); 
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
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card shadow">
                            <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between" style="padding: 0.5rem 1rem;">
                                <h5 class="card-title mb-0 text-white flex-grow-1 text-center" style="font-size: 1rem; margin: 0;">
                                   <b><?= $usuarioss->nombre." ".$usuarioss->apellido1." ".$usuarioss->apellido2;?></b>
                                </h5>
                                <div>
                                    <a style="border-radius: 50px; padding: 0.375rem 1rem; text-transform: uppercase; font-weight: bold; background: linear-gradient(45deg, #007bff, #00d4ff); color: white; transition: background 0.3s ease;" href="jugador" class="btn btn-light btn-sm" onclick="window.location.href='jugador'; return false;" onmouseover="window.status=''; return true;" onmouseout="window.status=''; return true;"> <i class="ri-arrow-go-back-line"></i> Volver </a>
                                    <!-- <button class="btn btn-light btn-sm" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Agregar</button> -->
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="customerTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                <thead>
                                    <tr class="table-primary">
                                        <th>Clubs</th>
                                        <th>Equipo</th>
                                        <th>Estado</th>
                                        <th>Liga</th>
                                        <th>Temporada</th>
                                    </tr>
                                </thead>
                                <tbody>
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
        $('#customerTable').DataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "index.php?action=apijugador_general&actions=2&usuario="+<?= $usuarioss->id;?>,
            "columns": [
                { "data": "club_nombre" },
                { "data": "nombreequipo" },
                { "data": "estado_juego",
                    "render": function(data, type, row) {
                        // Personalización del texto y el estilo del estado
                        if (data === 'Ya ha jugado') {
                            return `<span class="badge bg-success">${data}</span>`;
                        } else {
                            return `<span class="badge bg-warning">${data}</span>`;
                        }
                    }
                },
                { "data": "nombreliga" },
                { "data": "nombretemporada" }
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
        $('#customerTable').on('click', '.edit-btn', function() {
            let id = $(this).data('id');
            $.get("index.php?action=proveedor&actions=2&id=" + id, function(data) {
                $('#razon_social').val(data.razon_social);
                $('#ruc').val(data.ruc);
                $('#responsable').val(data.responsable);
                $('#telefono').val(data.telefono);
                $('#email').val(data.email);
                $('#direccion').val(data.direccion);
                $('#referencia').val(data.referencia);
                if(data.estado == 1) {
                    $('#estado').prop('checked', true);
                } else {
                    $('#estado').prop('checked', false);
                }
                $('#ids').val(data.id);
                $('#EditarModal').modal('show');
            }, "json");
        });
        $('#customerTable').on('click', '.delete-btn', function() {
            let id = $(this).data('id');
            $('#id').val(id);
            $('#confirm-delete-btn').data('id', id);
            $('#deleteModal').modal('show');
        });
    });
</script>
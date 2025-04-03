<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <!-- Espacio para un título si lo requieres -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
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
                            <div class="card">
                                <div class="card-header d-flex align-items-center">
                                    <h5 class="card-title mb-0 flex-grow-1">Lista de Cargos</h5>
                                    <div>
                                        <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Agregar</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="customerTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Tipo de venta</th>
                                                <th>Sucursal</th>
                                                <th width="15%">Acciones</th>
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
    </div>
</div>
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar registro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <form class="tablelist-form" autocomplete="off" method="post" action="index.php?action=registro">
                <div class="modal-body">
                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row gy-0">
                                <div class="col-xxl-12 col-md-12">
                                    <label for="sucursal">Sucursal</label>
                                    <select class="form-control" id="sucursal" name="sucursal">
                                    </select>
                                </div>
                                <div class="col-xxl-12 col-md-12">
                                    <label for="customername-field" class="form-label">Cargo</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control" required />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <input type="hidden" name="actions" value="23">
                        <input type="hidden" name="id" id="ids">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success" id="add-btn">Validar actualización</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
            </div>
            <form class="tablelist-form" autocomplete="off" method="post" action="index.php?action=registro">
                <div class="modal-body">
                    <div class="mt-2 text-center">
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>¿Estás seguro?</h4>
                            <p class="text-muted mx-4 mb-0">¿Está seguro de que desea eliminar este registro?</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <input type="hidden" name="actions" value="24">
                        <input type="hidden" name="id" id="id">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn w-sm btn-danger " id="delete-record">¡Sí, elimínalo!</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div> 
<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo registro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <form enctype="multipart/form-data" class="tablelist-form" autocomplete="off" method="post" action="index.php?action=registro">
                <div class="modal-body">
                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row gy-0">
                                <div class="col-xxl-12 col-md-12">
                                    <label for="customername-field" class="form-label">Sucursal</label>
                                    <select class="form-control" id="sucursal-fieldd" name="sucursal">
                                    <option value=""></option>
                                    </select>
                                </div>
                                <div class="col-xxl-12 col-md-12">
                                    <label for="customername-field" class="form-label">Cargo</label>
                                    <input type="text" name="nombre" class="form-control" required />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <input type="hidden" name="actions" value="22">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success" id="add-btn">Validar registro</button>
                    </div>
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
            "ajax": "index.php?action=apicargo",
            "columns": [
                { "data": "nombre" },
                { "data": "sucursales" },
                { 
                    "data": null,
                    "render": function (data, type, row) {
                        return '<button class="btn btn-primary btn-sm edit-btn" data-id="' + row.id + '">Editar</button>' + ' ' 
                        + '<button class="btn btn-danger btn-sm delete-btn" data-id="' + row.id + '">Eliminar</button>';
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
        $('#showModal').on('show.bs.modal', function() {
            if ($('#sucursal-fieldd option').length <= 1) {
                $.ajax({
                    url: 'index.php?action=apisucursal',
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        data.forEach(function(sucursal) {
                            $('#sucursal-fieldd').append($('<option>', {
                                value: sucursal.id,
                                text: sucursal.nombre
                            }));
                        });
                    }
                });
            }
        });
        $('#customerTable').on('click', '.edit-btn', function() {
            let id = $(this).data('id');
            $.get("index.php?action=getcargo&id=" + id, function(data) {
                $('#nombre').val(data.nombre);
                $.ajax({
                    url: 'index.php?action=apisucursal',
                    method: 'GET',
                    dataType: 'json',
                    success: function(sucursales) {
                        $('#sucursal').empty();
                        $('#sucursal').append($('<option>', {value: '', text: ''}));
                        sucursales.forEach(function(sucursal) {
                            $('#sucursal').append($('<option>', {
                                value: sucursal.id,
                                text: sucursal.nombre
                            }));
                        });
                        $('#sucursal').val(data.sucursal);
                    }
                });
                $('#ids').val(data.id);
                $('#editModal').modal('show');
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
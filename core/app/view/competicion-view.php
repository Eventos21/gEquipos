<?php
if (
    isset($_SESSION["conticomtc"]) && 
    isset($_SESSION["typeuser"]) && $_SESSION["typeuser"] == 1 && 
    isset($_SESSION["cargo"]) && $_SESSION["cargo"] == 1
) {
?>
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
                            <h5 class="card-title mb-0 text-white">Lista de registro de Competiciones </h5>
                            <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#exampleModalLong">
                                <i class="ri-add-line align-bottom me-1"></i> Nuevo registro
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="customerTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                <thead>
                                    <tr class="table-primary">
                                        <th>#</th>
                                        <th>Liga</th>
                                        <th>Categoria</th>
                                        <th>Sistema</th>
                                        <th>Ascenso</th>
                                        <th>Rondas</th>
                                        <th>Jugadores</th>
                                        <th>Grupo</th>
                                        <th width="50px">Acción</th>
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
        $('#customerTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "index.php?action=apicompeticiones",
            "columns": [
                { "data": function(row) {
                        return row.padre_competicion + '';
                    }
                },
                { "data": "liganombre" },
                { 
                    "data": function(row) {
                        console.log(row.nombregrupo);
                        if (row.nombregrupo == null || row.nombregrupo == 'NULL' || row.nombregrupo == "") {
                            return '-';
                        } else {
                            return row.nombregrupo;
                        }
                    }
                },
                { "data": "tipocompinombre" },
                { "data": "tipoascenso" },
                { "data": "rondas" },
                { "data": "cantidajugadores" },
                { "data": "grupo" },
                {
                    "data": null,
                    "render": function (data, type, row) {
                        var editButton = '';
                        if (row.codigo == 'LFARE') {
                            editButton = '<button class="btn btn-primary btn-sm edit-btn" data-id="' + row.id + '">Editar</button>';
                        } else if (row.codigo == 'LFS16') {
                            editButton = '<button class="btn btn-primary btn-sm edit1-btn" data-id="' + row.id + '">Editar</button>';
                        } else if (row.codigo == 'LFRE') {
                            editButton = '<a href="editcompeticion&tid=' + row.padre_competicion + '" class="btn btn-primary btn-sm">Editar</a>';
                        }
                        
                        var deleteButton = '<a href="ronda&tid=' + row.padre_competicion + '&tid1=' + row.id + '" class="btn btn-info btn-sm">Ronda</a>' + ' ' + '<button class="btn btn-danger btn-sm delete-btn" data-id="' + row.id + '">Eliminar</button>';
                        
                        return editButton + ' ' + deleteButton;
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
            dom: '<"top d-flex justify-content-between align-items-center mb-2"<"dt-length text-start"l><"dt-buttons text-center"B><"dt-filter text-end"f>>rt<"bottom"ip>',
            buttons: [
                {
                    extend: 'copy',
                    text: 'Copiar',
                    titleAttr: 'Copiar al portapapeles',
                    className: 'btn btn-light',
                    action: function (e, dt, button, config) {
                        $.fn.dataTable.ext.buttons.copyHtml5.action.call(this, e, dt, button, config);
                        setTimeout(function () {
                            $('.dt-button-info')
                                .addClass('text-dark bg-light border rounded p-3')
                                .css({'top': '60%', 'left': '50%', 'transform': 'translate(-50%, -50%)'})
                                .html('<strong>Copiado al portapapeles</strong><br>' + dt.rows({ selected: true }).count() + ' filas copiadas');
                        }, 10);
                    }
                },
                {
                    extend: 'csv',
                    text: 'CSV',
                    titleAttr: 'Exportar como CSV'
                },
                {
                    extend: 'excel',
                    text: 'Excel',
                    titleAttr: 'Exportar como Excel'
                },
                {
                    extend: 'print',
                    text: 'Imprimir',
                    titleAttr: 'Imprimir'
                },
            ]
        });
       $('#customerTable').on('click', '.edit-btn', function() {
            let id = $(this).data('id');
            $.get("index.php?action=getcompetecion&id=" + id, function(data) {

                $('#padre_competicion').val(data.padre_competicion);
                $('#nombregrupo').val(data.nombregrupo);
                $('#rondas1').val(data.rondas);
                $('#jornadas1').val(data.jornadas);
                $('#cantidajugadores1').val(data.cantidajugadores);
                $('#grupo1').val(data.grupo);
                $('#ids').val(data.id);

                var $tipoascenso = $('#tipoascenso1');
                var registeredValue = data.tipoascenso;
                if ($tipoascenso.find('option[value="' + registeredValue + '"]').length > 0) {
                    $tipoascenso.val(registeredValue);
                } else {
                    $tipoascenso.append('<option value="Sin data">Sin data</option>');
                    $tipoascenso.val('Sin data');
                }

                $.ajax({
                    url: 'index.php?action=apitipocompeticiones',
                    method: 'GET',
                    dataType: 'json',
                    success: function(cargos) {
                        $('#select-competicion').empty();
                        $('#select-competicion').append($('<option>', {value: '', text: 'Elegir'}));
                        cargos.forEach(function(tipocompeticion) {
                            $('#select-competicion').append($('<option>', {
                                value: tipocompeticion.id,
                                text: tipocompeticion.nombre
                            }));
                        });
                        $('#select-competicion').val(data.tipocompeticion);
                    }
                });
                $('#EditarModal').modal('show');
            }, "json");
        });
       $('#customerTable').on('click', '.edit1-btn', function() {
            let id = $(this).data('id');
            $.get("index.php?action=getcompetecion&id=" + id, function(data) {

                $('#padre_competicion').val(data.padre_competicion);
                $('#nombregrupo').val(data.nombregrupo);
                $('#rondas2').val(data.rondas);
                $('#jornadas2').val(data.jornadas);
                $('#cantidajugadores2').val(data.cantidajugadores);
                $('#ids1').val(data.id);

                var $tipoascenso = $('#tipoascenso2');
                var registeredValue = data.tipoascenso;
                if ($tipoascenso.find('option[value="' + registeredValue + '"]').length > 0) {
                    $tipoascenso.val(registeredValue);
                } else {
                    $tipoascenso.append('<option value="Sin data">Sin data</option>');
                    $tipoascenso.val('Sin data');
                }

                var $grupo = $('#grupo2');
                var registeredValue = data.grupo;
                if ($grupo.find('option[value="' + registeredValue + '"]').length > 0) {
                    $grupo.val(registeredValue);
                } else {
                    $grupo.append('<option value="Sin data">Sin data</option>');
                    $grupo.val('Sin data');
                }

                $.ajax({
                    url: 'index.php?action=apitipocompeticiones',
                    method: 'GET',
                    dataType: 'json',
                    success: function(cargos) {
                        $('#select-competicion1').empty();
                        $('#select-competicion1').append($('<option>', {value: '', text: 'Elegir'}));
                        cargos.forEach(function(tipocompeticion1) {
                            $('#select-competicion1').append($('<option>', {
                                value: tipocompeticion1.id,
                                text: tipocompeticion1.nombre
                            }));
                        });
                        $('#select-competicion1').val(data.tipocompeticion);
                    }
                });
                $('#EditarModal1').modal('show');
            }, "json");
        });
       $('#customerTable').on('click', '.delete-btn', function() {
            let id = $(this).data('id');
            $('#id').val(id);
            $('#confirm-delete-btn').data('id', id);
            $('#eliminarmodal').modal('show');
        });
    });
</script>
<!-- Modal Editar -->
<div class="modal fade" id="EditarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content border-5">
          <div class="modal-header bg-info">
            <h5 class="modal-title text-white" id="exampleModalLabel">Actualizar Registro</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form enctype="multipart/form-data" method="post" action="index.php?action=registro">
        <div class="modal-body bg-light">
            <div class="row">
                <div class="col-md-4"> 
                            <label class="form-label" for="first-name"> Tipo de competición</label>
                            <select class="form-select" name="tipocompeticion" id="select-competicion">
                                <option value="">Seleccionar</option>
                           </select>
                       </div>
                       <div class="col-md-4"> 
                            <label class="form-label" for="first-name"> Tipo de Ascenso</label>
                            <select class="form-select" name="tipoascenso" id="tipoascenso1">
                                <option  value="Si">Si</option>
                                <option value="No">No</option>
                           </select>
                       </div>
                       <div class="col-md-3"> 
                            <label class="form-label" for="first-name"> Rondas</label>
                            <input class="form-control" id="rondas1" name="rondas" type="text" aria-label="First name" required>
                        </div>
                        <div class="col-md-1"> 
                            <label class="form-label" for="first-name"> Jornadas</label>
                            <input class="form-control" id="jornadas1" name="jornadas" type="text" aria-label="First name" required>
                        </div>
                        <div class="col-md-2"> 
                            <label class="form-label" for="first-name"> Jugadores</label>
                            <input class="form-control" id="cantidajugadores1" name="cantidajugadores" type="text" aria-label="First name" required>
                        </div>
                        <div class="col-md-2"> 
                            <label class="form-label" for="first-name"> Grupo</label>
                            <input class="form-control" id="grupo1" name="grupo" type="text" aria-label="First name" readonly="" required>
                        </div>
            </div>
        </div>
        <div class="modal-footer bg-info d-flex justify-content-between pb-0">
            <input class="form-control" type="hidden" name="actions" value="43">
            <input class="form-control" type="hidden" name="id" id="ids">
            <button type="button" class="btn btn-outline-light me-2" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-light me-2">Guardar cambios</button>
          </div>
        </form>
        </div>
    </div>
</div>
<div class="modal fade" id="EditarModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content border-5">
          <div class="modal-header bg-info">
            <h5 class="modal-title text-white" id="exampleModalLabel">Actualizar Registro</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form enctype="multipart/form-data" method="post" action="index.php?action=registro">
        <div class="modal-body bg-light">
            <div class="row">
                <div class="col-md-4"> 
                            <label class="form-label" for="first-name"> Tipo de competición</label>
                            <select class="form-select" name="tipocompeticion" id="select-competicion1">
                                <option value="">Seleccionar</option>
                           </select>
                       </div>
                       <div class="col-md-4"> 
                            <label class="form-label" for="first-name"> Tipo de Ascenso</label>
                            <select class="form-select" name="tipoascenso" id="tipoascenso2">
                                <option  value="Si">Si</option>
                                <option value="No">No</option>
                           </select>
                       </div>
                       <div class="col-md-3"> 
                            <label class="form-label" for="first-name"> Rondas</label>
                            <input class="form-control" id="rondas2" name="rondas" type="text" aria-label="First name" required>
                        </div>
                        <div class="col-md-1"> 
                            <label class="form-label" for="first-name"> Jornadas</label>
                            <input class="form-control" id="jornadas2" name="jornadas" type="text" aria-label="First name" required>
                        </div>
                        <div class="col-md-2"> 
                            <label class="form-label" for="first-name"> Jugadores</label>
                            <input class="form-control" id="cantidajugadores2" name="cantidajugadores" type="text" aria-label="First name" required>
                        </div>
                        <div class="col-md-2"> 
                            <label class="form-label" for="first-name"> Tipo de Categoria</label>
                            <select class="form-select" id="grupo2" required name="grupo">
                                <option value="">Seleccionar</option>
                                <option  value="16">Sub 16</option>
                                <option  value="12">Sub 12</option>
                           </select>
                       </div>
            </div>
        </div>
        <div class="modal-footer bg-info d-flex justify-content-between pb-0">
            <input class="form-control" type="hidden" name="actions" value="43">
            <input class="form-control" type="hidden" name="id" id="ids1">
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
          <input type="hidden" name="actions" value="47">
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
<!-- Modal nuevo Registro -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
    <div class="modal-content border-5">
      <div class="modal-header bg-info">
        <h5 class="modal-title text-white" id="exampleModalLabel">Nuevo registro</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body bg-light">
                <style>
                    .liga-div {
                        display: none;
                    }
                </style>
                <div class="col-md-4 d-flex align-items-center">
                    <label class="form-label me-2" for="cargo-fieldd">Ligas</label>
                    <select class="form-select" id="cargo-fieldd" required>
                        <option value="">Elegir</option>
                        <?php $ligas = LigaData::vercontenidos();
                        foreach ($ligas as $liga) { ?>
                            <option value="<?= $liga->id;?>" data-codigo="<?= $liga->codigo;?>"><?= $liga->nombre;?></option>
                        <?php } ?>
                    </select>
                </div>
                <script type="text/javascript">
                    document.getElementById('cargo-fieldd').addEventListener('change', function() {
                        var selectedOption = this.options[this.selectedIndex];
                        var inputFields = document.querySelectorAll('.valorid');
                        
                        inputFields.forEach(function(inputField) {
                            inputField.value = selectedOption.value;
                        });
                    });
                </script>
                <hr>
                <div id="LFARE" class="liga-div">
                    <form enctype="multipart/form-data" method="POST" class="tablelist-form" autocomplete="off" action="index.php?action=registro">
                        <input type="hidden" class="form-control valorid" name="liga">
                    <div class="row">
                        <div class="col-md-4"> 
                            <label class="form-label" for="first-name"> Tipo de competición</label>
                            <select class="form-select" name="tipocompeticion">
                                <?php $tiposcompeticiones = TipoCompeticionData::vercontenido();
                                foreach ($tiposcompeticiones as $tipco) { ?>
                                   <option <?php if ($tipco->id==2) { echo "selected"; } ?> value="<?= $tipco->id;?>"><?= $tipco->nombre;?></option>
                               <?php } ?>
                           </select>
                       </div>
                       <div class="col-md-4"> 
                            <label class="form-label" for="first-name"> Tipo de Ascenso</label>
                            <select class="form-select" name="tipoascenso">
                                <option  value="Si">Si</option>
                                <option selected="" value="No">No</option>
                           </select>
                       </div>
                       <div class="col-md-3"> 
                            <label class="form-label" for="first-name"> Rondas</label>
                            <input class="form-control" name="rondas" value="14" type="text" aria-label="First name" required>
                        </div>
                        <div class="col-md-1"> 
                            <label class="form-label" for="first-name"> Jornadas</label>
                            <input class="form-control" name="jornadas" value="7" type="text" aria-label="First name" required>
                        </div>
                        <div class="col-md-2"> 
                            <label class="form-label" for="first-name"> Jugadores</label>
                            <input class="form-control" name="cantidajugadores" value="5" type="text" aria-label="First name" required>
                        </div>
                        <div class="col-md-2"> 
                            <label class="form-label" for="first-name"> Grupo</label>
                            <input class="form-control" name="grupo" readonly="" value="Único" type="text" aria-label="First name" required>
                        </div>                    
                    </div>
                    <hr>
                    <div class="modal-footer bg-info d-flex justify-content-between pb-0">
                      <input class="form-control" type="hidden" name="actions" value="40">
                      <button type="button" class="btn btn-outline-light me-2" data-bs-dismiss="modal">Cerrar</button>
                      <button type="submit" class="btn btn-light">Guardar registro</button>
                    </div>
                    </form>
                </div>

                <div id="LFS16" class="liga-div">
                    <form enctype="multipart/form-data" method="POST" class="tablelist-form" autocomplete="off" action="index.php?action=registro">
                        <input type="hidden" class="form-control valorid" name="liga">
                    <div class="row">
                        <div class="col-md-4"> 
                            <label class="form-label" for="first-name"> Tipo de competición</label>
                            <select class="form-select" name="tipocompeticion">
                                <?php $tiposcompeticiones = TipoCompeticionData::vercontenido();
                                foreach ($tiposcompeticiones as $tipco) { ?>
                                   <option <?php if ($tipco->id==2) { echo "selected"; } ?> value="<?= $tipco->id;?>"><?= $tipco->nombre;?></option>
                               <?php } ?>
                           </select>
                       </div>
                       <div class="col-md-4"> 
                            <label class="form-label" for="first-name"> Tipo de Ascenso</label>
                            <select class="form-select" name="tipoascenso">
                                <option  value="Si">Si</option>
                                <option selected="" value="No">No</option>
                           </select>
                       </div>
                       <div class="col-md-3"> 
                            <label class="form-label" for="first-name"> Rondas</label>
                            <input class="form-control" name="rondas" value="12" type="text" aria-label="First name" required>
                        </div>
                        <div class="col-md-1"> 
                            <label class="form-label" for="first-name"> Jornadas</label>
                            <input class="form-control" name="jornadas" value="6" type="text" aria-label="First name" required>
                        </div>
                        <div class="col-md-2"> 
                            <label class="form-label" for="first-name"> Jugadores</label>
                            <input class="form-control" name="cantidajugadores" value="4" type="text" aria-label="First name" required>
                        </div>
                        <div class="col-md-2"> 
                            <label class="form-label" for="first-name"> Tipo de Categoria</label>
                            <select class="form-select" required name="grupo">
                                <option value="">Seleccionar</option>
                                <option  value="16">Sub 16</option>
                                <option  value="12">Sub 12</option>
                           </select>
                       </div>
                    </div>
                    <hr>
                    <div class="modal-footer bg-info d-flex justify-content-between pb-0">
                      <input class="form-control" type="hidden" name="actions" value="41">
                      <button type="button" class="btn btn-outline-light me-2" data-bs-dismiss="modal">Cerrar</button>
                      <button type="submit" class="btn btn-light">Guardar registro</button>
                    </div>
                    </form>
                </div>

                <div id="LFRE" class="liga-div">
                    <form enctype="multipart/form-data" method="POST" class="tablelist-form" autocomplete="off" action="index.php?action=registro">
                        <input type="hidden" class="form-control valorid" name="liga">
                    <div class="row">
                       <div class="col-md-4"> 
                            <label class="form-label" for="first-name"> Tipo de Ascenso</label>
                            <select class="form-select" name="tipoascenso">
                                <option selected="" value="Si">Si</option>
                                <option value="No">No</option>
                           </select>
                       </div>
                       <div class="col-md-3"> 
                            <label class="form-label" for="first-name"> # de Grupos</label>
                            <input class="form-control" name="cantidad" id="cantidad" value="12" type="text" aria-label="First name" required>
                        </div>
                        <hr>
                        <div class="container mt-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header bg-primary text-white">
                                            <h5 class="card-title text-white">Crear Grupos</h5>
                                        </div>
                                        <div class="card-body">
                                            <input type="hidden" name="contador" id="contador" class="form-control" readonly>
                                            <div class="d-flex mb-3">
                                                <button type="button" class="btn btn-primary mr-2" id="mi-boton" onclick="agregarFila()"><i class="ri ri-add-line"></i></button>
                                            </div>
                                            <table class="table table-bordered" id="tablaprueba">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th width="20px">Item</th>
                                                        <th>Nombre Grupo</th>
                                                        <th>T. Competeción</th>
                                                        <th>Ronda</th>
                                                        <th>Jugadores</th>
                                                        <th>Grupo</th>
                                                        <th width="10px"><i class="ri-delete-bin-5-fill"></i></th>
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
                        <script type="text/javascript">
                            function agregarFila() {
                                var maxFilas = parseInt(document.getElementById("cantidad").value);
                                var table = document.getElementById("tablaprueba");
                                
                                if (table.rows.length - 1 >= maxFilas) {
                                    alert("No se pueden agregar más filas. El número máximo de grupos es " + maxFilas);
                                    return;
                                }
                                
                                var newRow = table.insertRow(-1);
                                var cell1 = newRow.insertCell(0);
                                var cell2 = newRow.insertCell(1);
                                var cell3 = newRow.insertCell(2);
                                var cell4 = newRow.insertCell(3);
                                var cell5 = newRow.insertCell(4);
                                var cell6 = newRow.insertCell(5);
                                var cell7 = newRow.insertCell(6);
                                
                                cell1.innerHTML = table.rows.length - 1;
                                cell2.innerHTML = '<input type="text" required class="form-control" name="nombregrupo[]">';
                                
                                var selectTipoCompeticion = '<select required class="form-select" name="tipocompeticion[]">';
                                <?php $tiposcompeticiones = TipoCompeticionData::vercontenido(); ?>
                                <?php foreach ($tiposcompeticiones as $tipco) { ?>
                                    selectTipoCompeticion += '<option <?php if ($tipco->id == 1) { echo "selected"; } ?> value="<?= $tipco->id; ?>"><?= $tipco->nombre; ?></option>';
                                <?php } ?>
                                selectTipoCompeticion += '</select>';
                                cell3.innerHTML = selectTipoCompeticion;
                                
                                cell4.innerHTML = '<input type="text" class="form-control" required name="ronda[]">';
                                cell5.innerHTML = '<input type="text" class="form-control" required name="jugadores[]">';
                                
                                var selectGrupo = '<select class="form-select" name="grupo[]">';
                                selectGrupo += '<option value="Único">Único</option>';
                                selectGrupo += '<option value="A">A</option>';
                                selectGrupo += '<option value="B">B</option>';
                                selectGrupo += '<option value="C">C</option>';
                                selectGrupo += '<option value="D">D</option>';
                                selectGrupo += '<option value="F">F</option>';
                                selectGrupo += '<option value="G">G</option>';
                                selectGrupo += '<option value="H">H</option>';
                                selectGrupo += '<option value="I">I</option>';
                                selectGrupo += '</select>';
                                cell6.innerHTML = selectGrupo;
                                
                                cell7.innerHTML = '<a onclick="eliminarFila(this)"><i class="ri-delete-bin-5-fill"></i></a>';
                                actualizarContador();
                            }

                            function eliminarFila(btn) {
                                var row = btn.parentNode.parentNode;
                                row.parentNode.removeChild(row);
                                actualizarContador();
                            }

                            function actualizarContador() {
                                var table = document.getElementById("tablaprueba");
                                document.getElementById('contador').value = table.rows.length - 1;
                                for (var i = 1; i < table.rows.length; i++) {
                                    table.rows[i].cells[0].innerHTML = i;
                                }
                            }
                        </script>
                        <!-- <script type="text/javascript">
                            function agregarFila() {
                                var table = document.getElementById("tablaprueba");
                                var newRow = table.insertRow(-1);
                                var cell1 = newRow.insertCell(0);
                                var cell2 = newRow.insertCell(1);
                                var cell3 = newRow.insertCell(2);
                                var cell4 = newRow.insertCell(3);
                                var cell5 = newRow.insertCell(4);
                                var cell6 = newRow.insertCell(5);
                                var cell7 = newRow.insertCell(6);
                                
                                cell1.innerHTML = table.rows.length - 1;
                                cell2.innerHTML = '<input type="text" required class="form-control" name="nombregrupo[]">';
                                
                                var selectTipoCompeticion = '<select required class="form-select" name="tipocompeticion[]">';
                                <?php $tiposcompeticiones = TipoCompeticionData::vercontenido(); ?>
                                <?php foreach ($tiposcompeticiones as $tipco) { ?>
                                    selectTipoCompeticion += '<option <?php if ($tipco->id == 1) { echo "selected"; } ?> value="<?= $tipco->id; ?>"><?= $tipco->nombre; ?></option>';
                                <?php } ?>
                                selectTipoCompeticion += '</select>';
                                cell3.innerHTML = selectTipoCompeticion;
                                
                                cell4.innerHTML = '<input type="text" class="form-control" required name="ronda[]">';
                                cell5.innerHTML = '<input type="text" class="form-control" required name="jugadores[]">';
                                
                                var selectGrupo = '<select class="form-select" name="grupo[]">';
                                selectGrupo += '<option value="unico">Único</option>';
                                selectGrupo += '<option value="A">A</option>';
                                selectGrupo += '<option value="B">B</option>';
                                selectGrupo += '<option value="C">C</option>';
                                selectGrupo += '<option value="D">D</option>';
                                selectGrupo += '<option value="F">F</option>';
                                selectGrupo += '<option value="G">G</option>';
                                selectGrupo += '<option value="H">H</option>';
                                selectGrupo += '<option value="I">I</option>';
                                selectGrupo += '</select>';
                                cell6.innerHTML = selectGrupo;
                                
                                cell7.innerHTML = '<a onclick="eliminarFila(this)"><i class="ri-delete-bin-5-fill"></i></a>';
                                actualizarContador();
                            }

                            function eliminarFila(btn) {
                                var row = btn.parentNode.parentNode;
                                row.parentNode.removeChild(row);
                                actualizarContador();
                            }

                            function actualizarContador() {
                                var table = document.getElementById("tablaprueba");
                                document.getElementById('contador').value = table.rows.length - 1;
                                for (var i = 1; i < table.rows.length; i++) {
                                    table.rows[i].cells[0].innerHTML = i;
                                }
                            }
                        </script> -->
                    </div>
                    <hr>
                    <div class="modal-footer bg-info d-flex justify-content-between pb-0">
                      <input class="form-control" type="hidden" name="actions" value="42">
                      <button type="button" class="btn btn-outline-light me-2" data-bs-dismiss="modal">Cerrar</button>
                      <button type="submit" class="btn btn-light">Guardar registro</button>
                    </div>
                    </form>
                </div>
                  <script>
                    document.getElementById('cargo-fieldd').addEventListener('change', function() {
                        document.querySelectorAll('.liga-div').forEach(function(div) {
                            div.style.display = 'none';
                        });
                        var selectedOption = this.options[this.selectedIndex];
                        var codigo = selectedOption.getAttribute('data-codigo');
                        if (codigo) {
                            var divToShow = document.getElementById(codigo);
                            if (divToShow) {
                                divToShow.style.display = 'block';
                            }
                        }
                    });
                </script>
          </div>        
    </div>
  </div>
</div>
<?php } else {
    header("Location: ./"); 
    exit();
} ?>
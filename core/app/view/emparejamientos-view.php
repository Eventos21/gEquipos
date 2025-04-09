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
                            <h5 class="card-title mb-0 text-white">Lista de registro de Emparejamientos</h5>
                            <div class="d-flex ms-auto">
                                <button type="button" class="btn btn-light me-2" data-bs-toggle="modal" data-bs-target="#exampleModalLong">
                                    <i class="ri-add-line align-bottom me-1"></i> Asignar Sala
                                </button>
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
            "ajax": "index.php?action=apisala1",
            "columns": [
                { "data": function(row) { return 'Sala: ' + row.codigo; } },
                { "data": "ligas" },
                { "data": "competiciones" },
                { "data": null,
                    "render": function(data, type, row) {
                        let buttons = '<button title="Tabla de distribución" class="btn btn-info btn-sm tabla-btn" data-id="' + row.id + '"><i class="ri-table-2"></i></button>';
                        
                        buttons += ' <a href="actemparejamiento&tid='+row.id+'" class="btn btn-primary btn-sm registro1-btn" title="Actualizar"><i class="ri-edit-2-fill"></i></a>';

                        buttons += ' <button title="Jornada" class="btn btn-warning btn-sm rondas-btn" data-id="' + row.id + '"><i class="ri-checkbox-multiple-fill"></i></button>';

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
        $.get("index.php?action=apisalaperosnalizada&sala=" + id, function(data) {
            // Limpiar el contenido anterior
            $('#tablaCompeticion thead tr').empty();
            $('#tablaCompeticion tbody').empty();

            // Dinámicamente determinar la cantidad de encuentros y generar encabezados
            let maxEncuentros = 0;

            // Encontrar el número máximo de encuentros en los datos
            data.forEach(function(row) {
                let encuentros = 0;
                for (let key in row) {
                    if (key.startsWith('Competidor')) {
                        encuentros++;
                    }
                }
                if (encuentros > maxEncuentros) {
                    maxEncuentros = encuentros;
                }
            });

            // Crear el encabezado de la tabla dinámicamente
            let headerHtml = '<th>Ronda</th><th>Fecha</th>';
            let activeEncuentros = [];  // Array para almacenar los índices de los encuentros que tienen datos

            // Determinar qué encuentros tienen datos
            data.forEach(function(row) {
                for (let i = 1; i <= maxEncuentros; i++) {
                    if (row['Competidor' + i] && row['Rival' + i]) {
                        if (!activeEncuentros.includes(i)) {
                            activeEncuentros.push(i);  // Solo añadir el índice si no está ya en el array
                        }
                    }
                }
            });

            // Crear las cabeceras solo para los encuentros con datos
            activeEncuentros.forEach(function(encuentro) {
                headerHtml += `<th>Encuentro ${encuentro}</th>`;
            });
            $('#tablaCompeticion thead tr').append(headerHtml);

            // Insertar los datos en la tabla
            data.forEach(function(row) {
                let rowHtml = `<tr><td>${row.ronda}</td><td>${row.fecha}</td>`;
                let hasEncuentros = false;

                activeEncuentros.forEach(function(encuentro) {
                    let competidor = row['Competidor' + encuentro];
                    let rival = row['Rival' + encuentro];

                    if (competidor && rival) {
                        rowHtml += `<td>${competidor} VS ${rival}</td>`;
                        hasEncuentros = true;
                    }
                });

                rowHtml += '</tr>';

                // Solo añadir la fila si tiene al menos un encuentro
                if (hasEncuentros) {
                    $('#tablaCompeticion tbody').append(rowHtml);
                }
            });

            // Mostrar el modal
            $('#tablacompeticionModal').modal('show');
        }, "json");
    });





    $('#customerTable').on('click', '.rondas-btn', function() {
        let id = $(this).data('id');
        $.get("index.php?action=getsala&id=" + id, function(data) {
            $('#ids1').val(data.id);
            $('#RondasModal').modal('show');
        }, "json");
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
                                
                            </tr>
                        </thead>
                        <tbody style="font-size: 9px;">
                            <!-- Contenido dinámico -->
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
                <button type="submit" class="btn btn-light">Guardar registro</button>
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
                <div id="importar" style="display: none;" class="col-md-3">
                    <label class="form-label me-2 text-danger" for="competicion-field">Importar Configuración *</label>
                    <input type="file" name="archivo" class="form-control text-danger" accept=".xls, .xlsx, .csv">
                </div>
                <div class="col-md-1">
                    <label class="form-label me-2 text-success" for="competicion-field">Plantilla</label>
                    <a download="" href="storage/per/plantillasala.xlsx">
                        <i style="font-size: 30px;" class="ri-download-cloud-2-line me-6"> </i> 
                    </a>
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
                                    $('#liga-field').append('<option data-codigo="'+liga.codigo+'" value="' + liga.id + '">' + liga.nombre + '</option>');
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
                        // para ocultar el file
                        $('#liga-field').on('change', function() {
                            // Obtener el código del elemento seleccionado
                            var selectedCodigo = $('#liga-field option:selected').data('codigo');
                            
                            // Verificar si el código es "LFARE"LFS16 LFRE
                            if (selectedCodigo == "LFARE" | selectedCodigo == "LFS16" | selectedCodigo == "LFRE") {
                                $('#importar').show(); // Mostrar el campo de importación
                            } else {
                                $('#importar').hide(); // Ocultar el campo de importación
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
            <input class="form-control" type="hidden" name="actions" value="53">
            <button type="button" class="btn btn-outline-light me-2" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-light" id="add-btn">Registrar Sala</button>
        </div>
        </form>
    </div>
  </div>
</div>
<!-- Agregar los datos   -->
<div class="modal fade" id="RondasModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white" id="exampleModalLabel">Importar Resultado</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form enctype="multipart/form-data" method="POST" class="tablelist-form" autocomplete="off" action="index.php?action=registro">
            <div class="modal-body bg-light p-4">
                <div class="row mb-4">
                    <div class="col-12">
                        <label class="form-label text-dark fw-bold" for="archivo">Importar Archivo</label>
                        <input required type="file" name="archivo" id="archivo" class="form-control border-secondary" accept=".xls, .xlsx, .csv">
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-info d-flex justify-content-between pb-0">
                <input type="hidden" name="sala" id="ids1">
                <input type="hidden" name="actions" value="65">
                <button type="button" class="btn btn-outline-light me-2" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-light">Importar</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Agregar los Datos -->
<div class="modal fade" id="RondasModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <label class="form-label me-2" for="liga-field1">Ligas</label>
                    <select class="form-select" name="liga" id="liga-field1" required>
                        <option value="">Elegir</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label me-2" for="competicion-field1">Competiciones</label>
                    <select class="form-select" name="competicion" id="competicion-field1" required>
                        <option value="">Elegir</option>
                    </select>
                </div>
                <div id="importar1" style="display: none;" class="col-md-3">
                    <label class="form-label me-2 text-danger" for="archivo">Importar Configuración *</label>
                    <input required type="file" name="archivo" class="form-control text-danger" accept=".xls, .xlsx, .csv">
                </div>
                <div class="col-md-1">
                    <label class="form-label me-2 text-success" for="plantilla">Plantilla</label>
                    <a href="storage/per/plantillasala.xlsx">
                            <i style="font-size: 30px;" class="ri-download-cloud-2-line me-6"> </i> 
                        </a>
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="mt-4">
                    <h5 class="fs-14 mb-1">Lista de Equipos</h5>
                    <select multiple="multiple" name="equipo" class="listar_equipos" id="multiselect-optiongroup1">
                    </select>
                </div>
                <script>
                    $(document).ready(function() {
                        $.ajax({
                            url: 'index.php?action=apiligas',
                            method: 'GET',
                            dataType: 'json',
                            success: function(response) {
                                $('#liga-field1').empty();
                                $('#liga-field1').append('<option value="">Seleccionar</option>');
                                $.each(response, function(index, liga) {
                                    $('#liga-field1').append('<option data-codigo="'+liga.codigo+'" value="' + liga.id + '">' + liga.nombre + '</option>');
                                });
                            }
                        });
                        $('#liga-field1').change(function() {
                            var especialidadId = $(this).val();
                            if (especialidadId) {
                                $.ajax({
                                    url: 'index.php?action=apilistarcompeticiones&especialidadId=' + especialidadId,
                                    method: 'GET',
                                    dataType: 'json',
                                    success: function(response) {
                                        $('#competicion-field1').empty().prop('disabled', false);
                                        $('#competicion-field1').append('<option value="">Seleccionar</option>');
                                        $.each(response, function(index, competicion) {
                                            $('#competicion-field1').append('<option value="' + competicion.id + '">' + competicion.nombregrupo + ' (' + competicion.grupo + ')' + ' ' + competicion.tipocompinombre + '</option>');
                                        });
                                    }
                                });
                            } else {
                                $('#competicion-field1').empty().prop('disabled', true);
                            }
                        });
                        // para ocultar el file
                        $('#liga-field1').on('change', function() {
                            // Obtener el código del elemento seleccionado
                            var selectedCodigo = $('#liga-field1 option:selected').data('codigo');
                            
                            // Verificar si el código es "LFARE"LFS16 LFRE
                            if (selectedCodigo == "LFARE" | selectedCodigo == "LFS16" | selectedCodigo == "LFRE") {
                                $('#importar1').show(); // Mostrar el campo de importación
                            } else {
                                $('#importar1').hide(); // Ocultar el campo de importación
                            }
                        });
                    });
                </script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const cargoField = document.getElementById('competicion-field1');
                        const equiposSelect = document.getElementById('multiselect-optiongroup1');

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

                        function actualizarEstadoBoton1() {
                            if (document.querySelectorAll('#listatabla1 tbody tr').length > 0) {
                                document.getElementById('add-btn').disabled = false;
                            } else {
                                document.getElementById('add-btn').disabled = true;
                            }
                        }
                        actualizarEstadoBoton1();

                        document.getElementById('btnAgregar1').addEventListener('click', function(e) {
                            e.preventDefault();

                            const equiposSelect = document.getElementById('multiselect-optiongroup1');
                            const seleccionados = Array.from(equiposSelect.selectedOptions);

                            if (seleccionados.length === 0) {
                                equiposSelect.classList.add('campo-faltante');
                                equiposSelect.focus();
                                return;
                            } else {
                                equiposSelect.classList.remove('campo-faltante');
                            }

                            // Obtener el número de filas actuales para iniciar el contador correctamente
                            let counter = document.querySelectorAll('#listatabla1 tbody tr').length + 1;

                            seleccionados.forEach(function(option) {
                                const id_equipo = option.value;
                                const nombre_equipo = option.text;

                                let exists = false;
                                document.querySelectorAll('#listatabla1 tbody tr').forEach(function(row) {
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
                                            <td><button type="button" class="btn btn-danger btn-sm btnEliminar1"><i class="ri-delete-bin-2-line"></i></button></td>
                                        </tr>`;

                                    document.querySelector('#listatabla1 tbody').insertAdjacentHTML('beforeend', newRow);
                                    counter++;
                                }
                            });

                            actualizarEstadoBoton1();
                        });

                        document.addEventListener('click', function(e) {
                            if (e.target && e.target.closest('.btnEliminar1')) {
                                e.preventDefault();
                                e.target.closest('tr').remove();

                                // Reasignar el contador después de eliminar una fila
                                document.querySelectorAll('#listatabla1 tbody tr').forEach((row, index) => {
                                    row.querySelector('td').textContent = index + 1;
                                });

                                actualizarEstadoBoton1();
                            }
                        });
                    });
                </script>
                <hr>
                <div class="col-md-12 d-flex align-items-end">
                    <button id="btnAgregar1" title="Agregar a la lista" class="btn btn-info btnguardar w-100">
                        <i class="ri-add-line align-bottom me-1"> </i>Agregar a la lista
                    </button>
                </div>
            </div>
            <hr>
            <table id="listatabla1" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%; font-size: 10px;">
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
            <input type="hidden" name="sala" id="ids1">
            <input type="hidden" name="actions" value="56">
            <button type="button" class="btn btn-outline-light me-2" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-light" id="add-btn">Registrar Sala</button>
        </div>
        </form>
    </div>
  </div>
</div>
<?php } else {
    header("Location: ./"); 
    exit();
} ?>
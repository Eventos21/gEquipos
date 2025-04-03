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
                            <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#exampleModalLong">
                                <i class="ri-add-line align-bottom me-1"></i> Asignar valor
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="customerTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                <thead>
                                    <tr class="table-primary">
                                        <th>data</th>
                                        <th>data</th>
                                        <th>data</th>
                                        <th>data</th>
                                        <th width="10px"><i class="ri-checkbox-circle-line"></i></th>
                                        <th width="50px">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Datos del club -->
                                </tbody>
                            </table>
                            <hr>
                            <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
<table>
        <thead>
            <tr>
                <th>Ronda</th>
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
            <?php
            $liga = 3;
            $equipos = ValorEquipoData::vercontenido($liga);
            
            $data = [
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

            $valores = [];
            foreach ($equipos as $equipo) {
                $valores[$equipo->valor] = $equipo->nombre;
            }

            for ($i = 0; $i < count($data); $i++) {
                echo "<tr>";
                echo "<td>Ronda " . ($i + 1) . "</td>";
                for ($j = 0; $j < 14; $j += 2) {
                    $valor1 = $data[$i][$j];
                    $valor2 = $data[$i][$j + 1];
                    $equipo1 = isset($valores[$valor1]) ? $valores[$valor1] : '-';
                    $equipo2 = isset($valores[$valor2]) ? $valores[$valor2] : '-';
                    echo "<td>{$equipo1} - {$equipo2}</td>";
                }
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
            <div class="col-md-4 d-flex align-items-center">
                <label class="form-label me-2" for="cargo-fieldd">Ligas</label>
                <select class="form-select" name="liga" id="cargo-fieldd" required>
                    <option value="">Elegir</option>
                    <?php $ligas = LigaData::vercontenidos();
                    foreach ($ligas as $liga) { ?>
                        <option value="<?= $liga->id;?>"><?= $liga->nombre;?></option>
                    <?php } ?>
                </select>
            </div>
            <hr>

            <div class="row">
                <div class="mt-4">
                    <h5 class="fs-14 mb-1">Lista de Equipos</h5>
                    <select multiple="multiple" name="equipo" class="listar_equipos" id="multiselect-optiongroup">
                    </select>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const cargoField = document.getElementById('cargo-fieldd');
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
                                            <td><input type="hidden" name="idequipo_[]" value="${id_equipo}" />${nombre_equipo}</td>
                                            <td><input type="text" name="nuevonuero_[]" /></td>
                                            <td><button class="btn btn-danger btn-sm btnEliminar"><i class="ri-delete-bin-2-line"></i></button></td>
                                        </tr>`;

                                    document.querySelector('#listatabla tbody').insertAdjacentHTML('beforeend', newRow);
                                }
                            });

                            actualizarEstadoBoton();
                        });

                        document.addEventListener('click', function(e) {
                            if (e.target && e.target.classList.contains('btnEliminar')) {
                                e.preventDefault();
                                e.target.closest('tr').remove();
                                actualizarEstadoBoton();
                            }
                        });
                    });
                </script>
                 <!-- <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const cargoField = document.getElementById('cargo-fieldd');
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
                    });
                </script> -->
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
            <button type="button" class="btn btn-outline-light me-2" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-light" id="add-btn">Guardar registro</button>
        </div>
        </form>
<!--         <script>
            function actualizarEstadoBoton() {
                if ($('table tbody tr').length > 0) {
                    $('#add-btn').prop('disabled', false);
                } else {
                    $('#add-btn').prop('disabled', true);
                }
            }
            actualizarEstadoBoton();

            $('#btnAgregar').on('click', function(e) {
                e.preventDefault();

                var remisiones = $('#multiselect-optiongroup').val();
                if (remisiones == "") {
                    $('select[name="equipo"]').addClass('campo-faltante').focus(); 
                    return;
                } else {
                    $('select[name="equipo"]').removeClass('campo-faltante'); 
                }

                $('#multiselect-optiongroup option:selected').each(function() {
                    var id_equipo = $(this).val();
                    var nombre_equipo = $(this).text();

                    var exists = false;
                    $('table tbody tr').each(function() {
                        if ($(this).find('input[name="idequipo_[]"]').val() == id_equipo) {
                            exists = true;
                            return false; // break the loop
                        }
                    });

                    if (!exists) {
                        var newRow = `<tr>
                            <td><input type="hidden" name="idequipo_[]" value="${id_equipo}" />${nombre_equipo}</td>
                            <td><input type="hidden" name="nuevonuero_[]" /><td><button class="btn btn-danger btn-sm btnEliminar"><i class="ri-delete-bin-2-line"></i></button></td>
                        </tr>`;

                        $('table tbody').append(newRow);
                    }
                });

                actualizarEstadoBoton();
            });
            $(document).on('click', '.btnEliminar', function(e) {
                e.preventDefault();
                $(this).closest('tr').remove();
                actualizarEstadoBoton();
            });
        </script> -->
    </div>
  </div>
</div>
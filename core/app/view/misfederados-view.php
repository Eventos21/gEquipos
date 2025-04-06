<?php
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
  <!-- Estructura similar a la vista jugadoresclub -->
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
          <div class="col">
            <div class="card shadow">
              <!-- Cabecera similar, pero sin botones de importación o nuevo registro -->
              <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0 text-white">Mis Jugadores Federados</h5>
              </div>
              <div class="card-body">
                <table id="jugadoresTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                  <thead>
                    <tr class="table-primary">
                      <th>Nombres y apellidos</th>
                      <th>ID FIDE</th>
                      <th>Fecha nacimiento</th>
                      <th>Teléfono</th>
                      <th>Elo</th>
                      <th>Estado</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- Los datos se cargarán vía AJAX -->
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Inicialización de DataTables -->
  <script>
    $(document).ready(function(){
      $('#jugadoresTable').DataTable({
         "processing": true,
         "serverSide": true,
         "ajax": {
            "url": "index.php?action=apijugadorporclub2&actions=1&club=<?php echo isset($_SESSION['club']) ? $_SESSION['club'] : ''; ?>",
            "dataSrc": "data"
         },
         "columns": [
           { "data": function(row){ 
               return row.nombre + " " + row.apellido1 + " " + row.apellido2; 
             } 
           },
           { "data": "numlicencia" },
           { 
             "data": "nacimiento",
             "render": function(data, type, row){
                return moment(data).format('DD-MM-YYYY');
             }
           },
           { "data": "telefono" },
           { "data": "elo" },
           { 
             "data": "estado",
             "render": function(data, type, row){
               return data == 1 
                     ? '<i class="ri-checkbox-circle-line text-success"></i>' 
                     : '<i class="ri-close-circle-line text-danger"></i>';
             }
           }
         ],
         "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
               "sFirst": "Primero",
               "sLast": "Último",
               "sNext": "Siguiente",
               "sPrevious": "Anterior"
            }
         }
      });
    });
  </script>
</body>
</html>

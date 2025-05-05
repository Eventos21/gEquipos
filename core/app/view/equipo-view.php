<?php
if (
    isset($_SESSION["conticomtc"]) &&
    isset($_SESSION["typeuser"]) && $_SESSION["typeuser"] == 1 &&
    isset($_SESSION["cargo"]) && $_SESSION["cargo"] == 1
) {
    // Asignamos $u dentro del bloque de acceso autorizado.
    $u = UserData::verid($_SESSION['conticomtc']);
?>
<style>
    .btn {
        font-size: 10px; 
        padding: 5px 8px;
    }
    #customerTable th,
    #customerTable td {
        font-size: 11px;
        padding-left: 20px;
        padding-right: 8px;
        padding-top: 8px; 
        padding-bottom: 8px; 
    }
</style>
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
                            <h5 class="card-title mb-0 text-white">Lista de registro de Equipos</h5>
                            <?php if ($u->club=="") { ?>
                            <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#exampleModalLong">
                                <i class="ri-add-line align-bottom me-1"></i> Nuevo registro
                            </button>
                            <?php } ?>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="customerTable" class="table table-bordered  table-striped align-middle" style="width:100%; font-size: 7px;">
                                    <thead>
                                        <tr class="table-primary">
                                            <th>Equipo</th>
                                            <th>Liga</th>
                                            <th>Capitán</th>
                                            <th>Subcapitán</th>
                                            <th>Estado</th>
                                            <th># Jugador</th>
                                            <th>Acción</th>
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
<!-- Modal Editar -->
<div class="modal fade" id="EditarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-5">
      <div class="modal-header bg-info">
        <h5 class="modal-title text-white" id="exampleModalLabel">Actualizar registro</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form enctype="multipart/form-data" method="post" action="index.php?action=registro">
        <div class="modal-body bg-light">
            <div class="row">
                <div class="col-md-12"> 
                    <label class="form-label" for="first-name"> Nombre del Equipo</label>
                    <input class="form-control" name="nombre" id="nombre" type="text" aria-label="First name" required>
                  </div>
                <div class="col-md-12"> 
                    <label class="form-label" for="first-name"> Club</label>
                    <select class="form-control miSelect1" name="club" id="select-clubb"><option></option></select>
                  </div>
                  <div class="col-md-2" style="display: none;">
                    <label class="form-check-label" for="condicion">Condición</label>
                    <div class="form-check form-switch form-switch-lg" dir="ltr">
                        <input type="checkbox" name="condicion" class="form-check-input" id="condicion">
                    </div>
                  </div>
                  <div class="col-md-12"> 
                    <label class="form-label" for="first-name"> Liga</label>
                    <select class="form-control" name="liga" id="liga"><option></option></select>
                  </div>
                <div class="col-md-12">
                    <label class="form-label me-2" for="competicion-field">Competiciones</label>
                    <select class="form-select" name="competicion" id="competicion" required>
                        <option value="">Elegir</option>
                    </select>
                </div>
                  <!-- <div class="col-md-2"> 
                    <label class="form-label" for="first-name" style="color: #ED0404; font-size: 10px;"> Disponible</label>
                    <input type="text" readonly="readonly" class="form-control" name="cantidad1" id="cantidad1">
                  </div> -->
                  <div class="col-md-8"> 
                    <label class="form-label" for="first-name"> Capitan <b style="color: #A1C2BD;"> |      Marcar si es nuevo: </b> <input style="border: 1px bold;" type="checkbox" id="siesnuevo1" class="form-check-input siesnuevo1"></label>
                    <div class="mostrar1a">
                        <select class="form-control select-usuario1 miSelect1" name="capitan">
                          <option value="">Seleccionar</option>  
                        </select>
                    </div>
                        <div class="mostrar1b" style="display: none;">
                        <input type="text" class="form-control" name="capitan1">
                    </div>
                  </div>
                  <div class="col-md-4"> 
                    <label class="form-label" for="first-name">F. de nacimiento</label>
                    <input class="form-control" name="nacimiento1" id="nacimiento1" type="date" aria-label="First name">
                    <div id="mensaje3" style="color: red; font-size: smaller;"></div>
                  </div>
                  <div class="col-md-8"> 
                    <label class="form-label" for="first-name"> Subcapitan <b style="color: #A1C2BD;"> |      Marcar si es nuevo: </b> <input style="border: 1px bold;" type="checkbox" id="siesnuevo2" class="form-check-input siesnuevo2"></label>
                    <div class="mostrar2a">
                        <select class="form-control select-usuario2 miSelect1" name="subcapitan">
                          <option value="">Seleccionar</option>  
                        </select>
                    </div>
                        <div class="mostrar2b" style="display: none;">
                        <input type="text" class="form-control" name="subcapitan1">
                    </div>
                  </div>
                  <div class="col-md-4"> 
                    <label class="form-label" for="first-name">F. de nacimiento</label>
                    <input class="form-control" name="nacimiento2" id="nacimiento2" type="date" aria-label="First name">
                    <div id="mensaje4" style="color: red; font-size: smaller;"></div>
                  </div>
                  <div class="col-md-12"> 
                    <label class="form-label" for="exampleFormControlTextarea1"> Descripción</label>
                    <textarea class="form-control" name="descripcion" id="descripcion" rows="3"></textarea>
                  </div>
            </div>
          </div>
          <div class="modal-footer bg-info d-flex justify-content-between pb-0">
            <input class="form-control" type="hidden" name="actions" value="14">
            <input class="form-control" type="hidden" name="id" id="ids">
            <button type="button" class="btn btn-outline-light me-2" data-bs-dismiss="modal">Cerrar</button>
            <button id="btnactualizar" type="submit" id="btnGuardar1" class="btn btn-light me-2">Guardar Cambio</button>
          </div>
        </form>
    </div>
  </div>
</div>
<!-- <script>
    function actualizarEstadoBoton1() {
        var btnGuardar1 = document.getElementById('btnGuardar1');
        var cantidadInput = document.getElementsByName('cantidad1')[0];
        var cantidad1 = parseFloat(cantidadInput.value);
        if (cantidad1 <= 0 || isNaN(cantidad1)) {
            btnGuardar1.disabled = true;
        } else {
            btnGuardar1.disabled = false;
        }
    }
    document.addEventListener("DOMContentLoaded", function() {
        actualizarEstadoBoton1();
        document.getElementById('liga').addEventListener('change', function() {
            var liga = this.value;
            var club = document.getElementById('select-clubb').value;
            fetch('index.php?action=catidaddisponible&liga=' + liga + '&club=' + club)
                .then(response => response.json())
                .then(data => {
                    var cantidadInput = document.getElementsByName('cantidad1')[0];
                    cantidadInput.value = data.cantidad;
                    actualizarEstadoBoton1();
                })
                .catch(error => console.error('Error:', error));
        });
    });
</script> -->
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
          <input type="hidden" name="actions" value="15">
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
<!-- Modal de Registro -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-5">
      <div class="modal-header bg-info">
        <h5 class="modal-title text-white" id="exampleModalLabel">Nuevo registro</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form enctype="multipart/form-data" method="POST" class="tablelist-form" autocomplete="off" action="index.php?action=registro">
        <div class="modal-body bg-light">
            <div class="row">
              <div class="col-md-12"> 
                <label class="form-label" for="first-name"> Nombre del Equipo</label>
                <input class="form-control" name="nombre" type="text" aria-label="First name" required>
              </div>
              <div class="col-md-10"> 
                <label class="form-label" for="first-name"> Club</label>
                <select class="form-control miSelect1" name="club" id="select-club"><option></option></select>
              </div>
              <div class="col-md-2"> 
                <label class="form-label" for="first-name" style="color: #ED0404; font-size: 10px;"> Disponible</label>
                <input type="text" readonly="readonly" class="form-control" name="cantidad" id="cantidad">
                <input type="hidden" readonly="readonly" class="form-control" name="idcantidad" id="idcantidad">
              </div>
              <div class="col-md-12"> 
                <label class="form-label" for="first-name"> Liga</label>
                <select class="form-control" name="liga" id="select-liga" required></select>
              </div>
              <div class="col-md-12">
                    <label class="form-label me-2" for="competicion-field">Competiciones</label>
                    <select class="form-select" name="competicion" id="competicion-field" required>
                        <option value="">Elegir</option>
                    </select>
                </div>
              <div class="col-md-8" style="display: none;"> 
                <label class="form-label" for="first-name"> Capitan <b style="color: #A1C2BD;"> |      Marcar si es nuevo: </b> <input style="border: 1px bold;" type="checkbox" id="customSwitchsizelg" class="form-check-input"></label>
                <div class="ver1">
                    <select class="form-control select-usuario miSelect1" name="capitan">
                      <option value="">Seleccionar</option>  
                    </select>
                </div>
                    <div class="ver2" style="display: none;">
                    <input type="text" class="form-control" name="capitan1">
                </div>
              </div>
              <div class="col-md-4" style="display: none;"> 
                <label class="form-label" for="first-name">F. de nacimiento</label>
                <input class="form-control" name="nacimiento1" id="nacimiento11" type="date" aria-label="First name" required>
                <div id="mensaje1" style="color: red; font-size: smaller;"></div>
              </div>
              <div class="col-md-8" style="display: none;"> 
                <label class="form-label" for="first-name"> Subcapitan <b style="color: #A1C2BD;"> |      Marcar si es nuevo: </b> <input style="border: 1px bold;" type="checkbox" id="customSwitchsizelg1" class="form-check-input"></label>
                <div class="ver11">
                    <select class="form-control select-usuario miSelect1" name="subcapitan">
                      <option value="">Seleccionar</option>  
                    </select>
                </div>
                    <div class="ver22" style="display: none;">
                    <input type="text" class="form-control" name="subcapitan1">
                </div>
              </div>
              <div class="col-md-4" style="display: none;"> 
                <label class="form-label" for="first-name">F. de nacimiento</label>
                <input class="form-control" name="nacimiento2" id="nacimiento12" type="date" aria-label="First name" required>
                <div id="mensaje2" style="color: red; font-size: smaller;"></div>
              </div>
              <div class="col-md-12"> 
                <label class="form-label" for="exampleFormControlTextarea1"> Descripción</label>
                <textarea class="form-control" name="descripcion" id="exampleFormControlTextarea1" rows="3"></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer bg-info d-flex justify-content-between pb-0">
              <input class="form-control" type="hidden" name="actions" value="13">
              <button type="button" class="btn btn-outline-light me-2" data-bs-dismiss="modal">Cerrar</button>
              <button id="btnregistro" type="submit" class="bloquerar btn btn-light">Guardar registro</button>
            </div>
        </form>
        
    </div>
  </div>
</div>
<!-- <script>
document.addEventListener("DOMContentLoaded", function() {
    var btnGuardar = document.getElementById('btnGuardar');
    var cantidadInput = document.getElementById('cantidad');
    
    function actualizarEstadoBoton() {
        var cantidad = parseFloat(cantidadInput.value);
        if (cantidad <= 0 || isNaN(cantidad)) {
            btnGuardar.disabled = true;
        } else {
            btnGuardar.disabled = false;
        }
    }

    cantidadInput.addEventListener('input', actualizarEstadoBoton);
    actualizarEstadoBoton(); // Esto asegura que el botón esté en el estado correcto cuando la página se cargue por primera vez.
});
</script>
 -->
<script>
    function actualizarEstadoBoton() {
        var btnregistro = document.getElementById('btnregistro');
        var cantidadInput = document.getElementsByName('cantidad')[0];
        var cantidad = parseFloat(cantidadInput.value);
        if (cantidad <= 0 || isNaN(cantidad)) {
            btnregistro.disabled = true;
        } else {
            btnregistro.disabled = false;
        }
    }
    document.addEventListener("DOMContentLoaded", function() {
        actualizarEstadoBoton();
        document.getElementById('select-liga').addEventListener('change', function() {
            var liga = this.value;
            var club = document.getElementById('select-club').value;
            fetch('index.php?action=catidaddisponible&liga=' + liga + '&club=' + club)
                .then(response => response.json())
                .then(data => {
                    var cantidadInput = document.getElementsByName('cantidad')[0];
                    cantidadInput.value = data.cantidad;
                    var idcantidadInput = document.getElementsByName('idcantidad')[0];
                    idcantidadInput.value = data.id;
                    actualizarEstadoBoton();
                })
                .catch(error => console.error('Error:', error));
        });
    });
</script>
<script>
    var fecha18Años = new Date();
    fecha18Años.setFullYear(fecha18Años.getFullYear() - 18);
    var fechaFormateada = fecha18Años.toISOString().slice(0,10);
    document.getElementById("nacimiento11").value = fechaFormateada;
    function validarEdadAlCargar() {
        var fechaNacimiento = new Date(document.getElementById("nacimiento11").value);
        var hoy = new Date();
        var edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
        var mes = hoy.getMonth() - fechaNacimiento.getMonth();
        if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
            edad--;
        }
        if (edad < 18) {
            document.getElementById("btnregistro").disabled = true;
            document.getElementById("mensaje1").innerText = "No es mayor de Edad";
        } else {
            document.getElementById("btnregistro").disabled = false;
            document.getElementById("mensaje1").innerText = "";
        }
    }
    validarEdadAlCargar();
    document.getElementById("nacimiento11").addEventListener("change", validarEdadAlCargar);
</script>
<script>
    var fecha18Años = new Date();
    fecha18Años.setFullYear(fecha18Años.getFullYear() - 18);
    var fechaFormateada = fecha18Años.toISOString().slice(0,10);
    document.getElementById("nacimiento12").value = fechaFormateada;
    function validarEdadAlCargar() {
        var fechaNacimiento = new Date(document.getElementById("nacimiento12").value);
        var hoy = new Date();
        var edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
        var mes = hoy.getMonth() - fechaNacimiento.getMonth();
        if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
            edad--;
        }
        if (edad < 18) {
            document.getElementById("btnregistro").disabled = true;
            document.getElementById("mensaje2").innerText = "No es mayor de Edad";
        } else {
            document.getElementById("btnregistro").disabled = false;
            document.getElementById("mensaje2").innerText = "";
        }
    }
    validarEdadAlCargar();
    document.getElementById("nacimiento12").addEventListener("change", validarEdadAlCargar);
</script>

<!-- Modal de Enviar a la Federación -->
<div class="modal fade" id="Federacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-5">
      <div class="modal-header bg-info">
        <h5 class="modal-title text-white" id="exampleModalLabel">Envío a la Federación</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form enctype="multipart/form-data" method="POST" class="tablelist-form" autocomplete="off" action="index.php?action=registro">
            <div class="modal-body bg-light">
                <p align="center">
                    <lord-icon
                    src="https://cdn.lordicon.com/usownftb.json"
                    trigger="loop"
                    delay="1500"
                    stroke="bold"
                    state="in-reveal"
                    colors="primary:#110a5c,secondary:#e86830"
                    style="width:125px;height:125px">
                    </lord-icon></p><p align="center"><b>Importante</b></p> <p align="justify"> Antes de enviar el orden de fuerza del equipo a la FMA, es esencial que tengas en cuenta que asumirás toda la responsabilidad. Una vez que se haya enviado, no habrá posibilidad de detener el proceso hasta que la FMA lo gestione. Por lo tanto, es crucial asegurarse de que la relación esté completa y precisa antes de proceder con el envío.</p>
                </p>
            </div>
          <div class="modal-footer bg-info d-flex justify-content-between pb-0">
              <input class="form-control" type="hidden" name="actions" id="actionsFederacion" value="">
              <input class="form-control" type="hidden" name="id" id="ids1">
              <button type="button" class="btn btn-outline-light me-2" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-light">Enviar</button>
            </div>
        </form>
        
    </div>
  </div>
</div>
<!-- Modal de Respuesta de Federación -->
<div class="modal fade" id="RespuestaFederacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-5">
      <div class="modal-header bg-info">
        <h5 class="modal-title text-white" id="exampleModalLabel"></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form enctype="multipart/form-data" method="POST" class="tablelist-form" autocomplete="off" action="index.php?action=registro">
            <div class="modal-body bg-light">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center mb-4">Respuesta de la Federación</h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <p class="font-weight-bold">Equipo:</p>
                                <p id="nombrej" class="card-text"></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="font-weight-bold">Club:</p>
                                <p id="clubesj" class="card-text"></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="font-weight-bold">Capitán:</p>
                                <p id="capitanesj" class="card-text"></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="font-weight-bold">Fecha de nacimiento:</p>
                                <p id="nacimiento1j" class="card-text"></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="font-weight-bold">Subcapitán:</p>
                                <p id="subcapitanesj" class="card-text"></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="font-weight-bold">Fecha de nacimiento:</p>
                                <p id="nacimiento2j" class="card-text"></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="font-weight-bold">Estado:</p>
                                <p id="estados" class="card-text"></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <a title="Descargar Relación" class="text-center" style=" display: inline-block;
                                        width: 50px; 
                                        height: 50px; 
                                        background-image: url('storage/per/pdf.png');
                                        background-size: contain;
                                        background-repeat: no-repeat;
                                        background-position: center; " target="_BLANK" id="descar-pdf"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="mensajefederacion" class="form-label">Comentario adjunto</label>
                    <textarea name="mensajefederacion" id="mensajefederacionj" class="form-control" rows="3"></textarea>
                </div>
            </div>
          <div class="modal-footer bg-info d-flex justify-content-between pb-0">
              <button type="button" class="btn btn-outline-light me-2" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </form>
        
    </div>
  </div>
</div>
<script>
    $(document).ready(function() {
        $('#customSwitchsizelg').change(function() {
            if ($(this).is(':checked')) {
                $('.ver1').hide();
                $('.ver2').show();
            } else {
                $('.ver1').show();
                $('.ver2').hide();
            }
        });
        $('#customSwitchsizelg1').change(function() {
            if ($(this).is(':checked')) {
                $('.ver11').hide();
                $('.ver22').show();
            } else {
                $('.ver11').show();
                $('.ver22').hide();
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#customerTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "index.php?action=apiequipo",
            "columns": [
                { "data": function(row) {
                        return row.nombre ;
                    }
                },
                { "data": "ligas" },
                // { "data": "clubes" },
                { "data": function(row) {
                        return row.capitanes + ' ' + "<span style='color: blue;'>(" + moment(row.nacimiento1).format('DD-MM-YYYY') + ")</span>";
                    }
                },
                { "data": function(row) {
                        return row.subcapitanes + ' ' + "<span style='color: blue;'>(" + moment(row.nacimiento2).format('DD-MM-YYYY') + ")</span>";
                    }
                },
                { "data": "estado",
                    "render": function(data, type, row) {
                        if(data == 1) {
                            return '<span class="text-primary">Sin Enviar</span>';
                        }
                        if(data == 2) {
                            return '<span class="text-success">Enviado</span>';
                        }
                        if(data == 3) {
                            return '<button class="btn btn-sm btn-success noinnabilitar jugadores-btn" data-id="' + row.id + '">Aceptado</button>';
                        }
                        if(data == 4) {
                            return '<button class="btn btn-sm btn-danger noinnabilitar jugadores-btn" data-id="' + row.id + '">Rechazado</button>';
                        }
                        if(data == 5) {
                            return '<button class="btn btn-sm btn-warning noinnabilitar jugadores-btn" data-id="' + row.id + '">Observado</button>';
                        }
                        if(data == 6) {
                            return '<button class="btn btn-sm btn-warning noinnabilitar jugadores-btn" data-id="' + row.id + '">Modificado</button>';
                        }
                    }
                },
                { "data": "cantidad_jugadores" },
                { 
                    "data": null,
                    "render": function (data, type, row) { 
                        let buttons =   ' ' ;
                        // if ((row.capitan != null && row.capitan != "") && parseInt(row.cantidad_jugadores) >= parseInt(row.minimo) && parseInt(row.cantidad_jugadores) <= parseInt(row.maximo)) {
                        if ((row.capitan != null && row.capitan != "") && parseInt(row.cantidad_jugadores) >= parseInt(row.minimo)) {
                            buttons += '<button title="Enviar a la FMA para su validación" class="btn btn-warning btn-sm federacion-btn" data-id="' + row.id + '"><i class="ri-telegram-fill"></i></button>';
                        }
                        buttons += ' <a title="Añadir jugadores" href="participante?tid=' + row.id + '" class="btn btn-info btn-sm"><i class="ri-group-fill"></i></a>' + ' ' +  '<a title="Actualizar datos" class="btn btn-primary btn-sm edit-btn" data-id="' + row.id + '"><i class="ri-edit-2-fill"></i></a>' + ' ' + '<button title="Eliminar registro" class="btn btn-danger btn-sm delete-btn" data-id="' + row.id + '"><i class="ri-delete-bin-2-line"></i></button>';
                        if (row.estado == 3) {
                            buttons += ' <a title="Descargar orden de fuerza" href="index.php?action=descarga&equipo=' + row.id + '" download class="btn btn-success btn-sm"><i class="ri-file-ppt-fill"></i></a>';
                        }
                        return buttons;
                    }
                }
            ],
            buttons: [
                {
                    extend: 'copy',
                    text: 'Copiar',
                    titleAttr: 'Copiar al portapapeles'
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

            "rowCallback": function(row, data) {
    if (data.estado == 2 || data.estado == 4) {
        $(row).addClass('bg-light');
        $('button', row).not('.noinnabilitar').prop('disabled', true); // Deshabilitar todos los botones excepto aquellos con la clase 'noinnabilitar'
    }
}

        });
        $('#exampleModalLong').on('show.bs.modal', function() {
          $('#select-club').empty();
          $.ajax({
              url: 'index.php?action=apiclubs',
              method: 'GET',
              dataType: 'json',
              success: function(data) {
                  data.forEach(function(clubes) {
                      $('#select-club').append($('<option>', {
                          value: clubes.id,
                          text: clubes.nombre
                      }));
                  });
              },
              error: function() {
                  console.error("Error al cargar datos de la API");
              }
          });
          // $('#select-liga').empty();
          // $.ajax({
          //     url: 'index.php?action=apiligas',
          //     method: 'GET',
          //     dataType: 'json',
          //     success: function(data) {
          //         data.forEach(function(clubes) {
          //             $('#select-liga').append($('<option>', {
          //                 value: clubes.id,
          //                 text: clubes.nombre
          //             }));
          //         });
          //     },
          //     error: function() {
          //         console.error("Error al cargar datos de la API");
          //     }
          // });
          $('#select-liga').empty();
            $.ajax({
                url: 'index.php?action=apiligas',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#select-liga').append($('<option>', {
                        value: '',
                        text: '-- Seleccionar --' 
                    }));
                    data.forEach(function(clubes) {
                        $('#select-liga').append($('<option>', {
                            value: clubes.id,
                            text: clubes.nombre
                        }));
                    });
                },
                error: function() {
                    console.error("Error al cargar datos de la API");
                }
            });

          $.ajax({
              url: 'index.php?action=apiusuario',
              method: 'GET',
              dataType: 'json',
              success: function(data) {
                  data.forEach(function(usuario) {
                      $('.select-usuario').append($('<option>', {
                          value: usuario.id,
                          text: usuario.nombre + ' ' + usuario.apellido
                      }));
                  });
              },
              error: function() {
                  console.error("Error al cargar datos de la API");
              }
          });
      });
        function validarEdad() {
            var fechaNacimiento = new Date(document.getElementById("nacimiento1").value);
            var hoy = new Date();
            var edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
            var mes = hoy.getMonth() - fechaNacimiento.getMonth();
            if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
                edad--;
            }
            if (edad < 18) {
                document.getElementById("btnactualizar").disabled = true;
                document.getElementById("mensaje3").innerText = "No es mayor de Edad";
            } else {
                document.getElementById("btnactualizar").disabled = false;
                document.getElementById("mensaje3").innerText = "";
            }
        }

        // Función para validar la edad de nacimiento2
        function validarEdad1() {
            var fechaNacimiento = new Date(document.getElementById("nacimiento2").value);
            var hoy = new Date();
            var edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
            var mes = hoy.getMonth() - fechaNacimiento.getMonth();
            if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
                edad--;
            }
            if (edad < 18) {
                document.getElementById("btnactualizar").disabled = true;
                document.getElementById("mensaje4").innerText = "No es mayor de Edad";
            } else {
                document.getElementById("btnactualizar").disabled = false;
                document.getElementById("mensaje4").innerText = "";
            }
        }

        // Ejecutar la validación cuando se cambia la fecha de nacimiento
        document.getElementById("nacimiento1").addEventListener("change", validarEdad);
        document.getElementById("nacimiento2").addEventListener("change", validarEdad1);

        $('#customerTable').on('click', '.edit-btn', function() {
            let id = $(this).data('id');
            $.get("index.php?action=getequipo&id=" + id, function(data) {
                validarEdad();
                validarEdad1();
                $('#categoria').val(data.categoria);
                $('#nombre').val(data.nombre);
                $('#descripcion').val(data.descripcion);
                $('#nacimiento1').val(data.nacimiento1);
                $('#nacimiento2').val(data.nacimiento2);
                $('#ids').val(data.id);
                if(data.condicion == 1) {
                    $('#condicion').prop('checked', true);
                } else {
                    $('#condicion').prop('checked', false);
                }
                $.ajax({
                    url: 'index.php?action=apiclubs',
                    method: 'GET',
                    dataType: 'json',
                    success: function(facultades) {
                        $('#select-clubb').empty();
                        $('#select-clubb').append($('<option>', {value: '', text: 'Elegir'}));
                        facultades.forEach(function(club) {
                            $('#select-clubb').append($('<option>', {
                                value: club.id,
                                text: club.nombre
                            }));
                        });
                        $('#select-clubb').val(data.club);
                    }
                });
                // $.ajax({
                //     url: 'index.php?action=apiligas',
                //     method: 'GET',
                //     dataType: 'json',
                //     success: function(ligas) {
                //         $('#liga').empty();
                //         $('#liga').append($('<option>', {value: '', text: 'Elegir'}));
                //         ligas.forEach(function(liga) {
                //             $('#liga').append($('<option>', {
                //                 value: liga.id,
                //                 text: liga.nombre
                //             }));
                //         });
                //         $('#liga').val(data.liga);
                //     }
                // }); liga
// competicion
                $.ajax({
                        url: 'index.php?action=apicompeteciones&especialidadId='+data.liga,
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            $('#competicion').empty();
                            $('#competicion').append('<option value="">Seleccionar</option>');
                            response.forEach(function(competicionn) {
                                $('#competicion').append($('<option>', {
                                    value: competicionn.id,
                                    text: competicionn.nombregrupo + ' (' + competicionn.grupo + ') ' + ' ' + competicionn.tipocompinombre
                                }));
                            });
                            $('#competicion').val(data.competicion);
                        }
                    });

                    // Cargar las especialidades
                    $.ajax({
                        url: 'index.php?action=apiligas',
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            $('#liga').empty();
                            $('#liga').append('<option value="">Seleccionar</option>');
                            response.forEach(function(liga) {
                                $('#liga').append($('<option>', {
                                    value: liga.id,
                                    text: liga.nombre
                                }));
                            });
                            $('#liga').val(data.liga);
                        }
                    });

                    // Actualizar las materias según la especialidad seleccionada
                    $('#liga').change(function() {
                        var especialidadId = $(this).val();
                        if (especialidadId) {
                            $.ajax({
                                url: 'index.php?action=apilistarcompeticiones&especialidadId=' + especialidadId,
                                method: 'GET',
                                dataType: 'json',
                                success: function(response) {
                                    $('#competicion').empty().prop('disabled', false);
                                    $('#competicion').append('<option value="">Seleccionar</option>');
                                    response.forEach(function(competiciones) {
                                        $('#competicion').append($('<option>', {
                                            value: competiciones.id,
                                            text: competiciones.nombregrupo + ' (' + competiciones.grupo + ') ' + ' ' + competiciones.tipocompinombre
                                        }));
                                    });
                                    $('#competicion').val(data.competicion);
                                }
                            });
                        } else {
                            $('#competicion').empty().prop('disabled', true);
                        }
                    });
                // Función para determinar si es un número entero
                function isInteger(value) {
                    return /^\d+$/.test(value);
                }
                 // Mostrar el campo adecuado para el capitan
                if (isInteger(data.capitan)) {
                    $('.mostrar1a').show();
                    $('.mostrar1b').hide();
                    $('.select-usuario1').val(data.capitan);
                } else {
                    $('.mostrar1a').hide();
                    $('.mostrar1b').show();
                    $('input[name="capitan1"]').val(data.capitan);
                }
                // Mostrar el campo adecuado para el subcapitan
                if (isInteger(data.subcapitan)) {
                    $('.mostrar2a').show();
                    $('.mostrar2b').hide();
                    $('.select-usuario2').val(data.subcapitan);
                } else {
                    $('.mostrar2a').hide();
                    $('.mostrar2b').show();
                    $('input[name="subcapitan1"]').val(data.subcapitan);
                }
                // Cambio de evento para el checkbox siesnuevo1
                $('.siesnuevo1').change(function() {
                    if ($(this).is(':checked')) {
                        $('.mostrar1a').hide();
                        $('.mostrar1b').show();
                    } else {
                        $('.mostrar1a').show();
                        $('.mostrar1b').hide();
                    }
                });
                // Cambio de evento para el checkbox siesnuevo2
                $('.siesnuevo2').change(function() {
                    if ($(this).is(':checked')) {
                        $('.mostrar2a').hide();
                        $('.mostrar2b').show();
                    } else {
                        $('.mostrar2a').show();
                        $('.mostrar2b').hide();
                    }
                });
                // Llamada inicial para asegurar que los campos estén configurados correctamente al cargar la página
        // if ($('#siesnuevo1').is(':checked')) {
        //     $('.mostrar1a').hide();
        //     $('.mostrar1b').show();
        // } else {
        //     $('.mostrar1a').show();
        //     $('.mostrar1b').hide();
        // }

        // if ($('#siesnuevo2').is(':checked')) {
        //     $('.mostrar2a').hide();
        //     $('.mostrar2b').show();
        // } else {
        //     $('.mostrar2a').show();
        //     $('.mostrar2b').hide();
        // }
                // Carga de opciones de usuarios
                $.ajax({
                    url: 'index.php?action=apiusuario',
                    method: 'GET',
                    dataType: 'json',
                    success: function(apimodulos) {
                        // Opciones para el capitan
                        $('.select-usuario1').empty();
                        $('.select-usuario1').append($('<option>', {value: '', text: 'Elegir'}));
                        apimodulos.forEach(function(capitan) {
                            $('.select-usuario1').append($('<option>', {
                                value: capitan.id,
                                text: capitan.nombre + ' ' + capitan.apellido
                            }));
                        });
                        // Opciones para el subcapitan
                        $('.select-usuario2').empty();
                        $('.select-usuario2').append($('<option>', {value: '', text: 'Elegir'}));
                        apimodulos.forEach(function(subcapitan) {
                            $('.select-usuario2').append($('<option>', {
                                value: subcapitan.id,
                                text: subcapitan.nombre + ' ' + subcapitan.apellido
                            }));
                        });
                        // Seleccionar valores
                        $('.select-usuario1').val(data.capitan);
                        $('.select-usuario2').val(data.subcapitan);
                    }
                });
                // Mostrar el modal
                $('#EditarModal').modal('show');
            }, "json");
        });
        $('#customerTable').on('click', '.delete-btn', function() {
            let id = $(this).data('id');
            $('#id').val(id);
            $('#confirm-delete-btn').data('id', id);
            $('#eliminarmodal').modal('show');
        });

        $('#customerTable').on('click', '.federacion-btn', function() {
            // 1) Obtén la fila DataTable
            var table = $('#customerTable').DataTable();
            var data  = table.row($(this).closest('tr')).data();

            // 2) Rellena el campo oculto con el ID
            $('#ids1').val(data.id);

            // 3) Decide la acción: si estado == 1 → 33, sino → 330
            var accion = (data.estado == 1) ? 33 : 330;
            $('#actionsFederacion').val(accion);

            // 4) Abre el modal
            $('#Federacion').modal('show');
        });






        $('#customerTable').on('click', '.jugadores-btn', function() {
            let id = $(this).data('id');
            $.get("index.php?action=getequipo&id=" + id, function(data) {
                $('#clubesj').text(data.clubes);
                $('#nombrej').text(data.nombre);
                $('#descripcionj').text(data.descripcion);
                $('#nacimiento1j').text('' + moment(data.nacimiento1).format('DD-MM-YYYY'));
                // $('#cantidad').text(data.cantidad);
                $('#nacimiento2j').text(moment(data.nacimiento2).format('DD-MM-YYYY'));
                $('#ids1j').val(data.id);
                $('#capitanesj').text(data.capitanes);
                $('#subcapitanesj').text(data.subcapitanes);
                $('#mensajefederacionj').val(data.mensajefederacion);
                let valorEstado = data.estado;
                $('#estado option').each(function() {
                    if ($(this).val() == valorEstado) {
                        $(this).prop('selected', true);
                    }
                });
                $('#descar-pdf').attr('href', 'index.php?action=descarga&equipo=' + data.id);
                if(data.estado == 1) {
                    $('#estados').text('Sin enviar').css('color', '#f0ad4e'); // Amarillo para 'Sin enviar'
                    $('#descar-pdf').hide();
                }
                if(data.estado == 2) {
                    $('#estados').text('Enviado').css('color', '#5bc0de'); // Azul para 'Enviado'
                    $('#descar-pdf').hide();
                }
                if(data.estado == 3) {
                    $('#estados').text('Aceptado').css('color', '#5cb85c'); // Verde para 'Aceptado'
                    $('#descar-pdf').show();
                }
                if(data.estado == 4) {
                    $('#estados').text('Rechazado').css('color', '#d9534f'); // Rojo para 'Rechazado'
                    $('#descar-pdf').hide();
                }
                if(data.estado == 5) {
                    $('#estados').text('Observado').css('color', '#0275d8'); // Azul claro para 'Observado'
                    $('#descar-pdf').hide();
                }
                if(data.estado == 6) {
                    $('#estados').text('Modificado').css('color', '#f0ad4e'); // Amarillo para 'Modificado'
                    $('#descar-pdf').hide();
                }

                $('#RespuestaFederacion').modal('show');
            }, "json");
        });


    });
</script>
<script>
    $(document).ready(function() {
        $('#select-liga').change(function() {
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
    });
</script>
<?php } else {
    header("Location: ./"); 
    exit();
} ?>
<style>
    .full-width-container {
        width: 100%;
        max-width: 100%;
        background-color: #f0f0f0; /* Color de fondo */
        border: 1px solid #ccc; /* Borde */
        border-radius: 8px; /* Bordes redondeados */
        padding: 20px; /* Espaciado interno */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Sombra */
    }

    .full-width-container img {
        display: block;
        width: 100%; /* Hacer que la imagen ocupe todo el ancho del contenedor */
        height: auto; /* Mantener la proporción de la imagen */
        border-radius: 8px; /* Bordes redondeados */
    }
</style>
<?php 
if (isset($_SESSION["typeuser"]) && ($_SESSION["typeuser"] == 1 || $_SESSION["typeuser"] == 2)) {
    if (isset($_SESSION["conticomtc"])) {
        if ($_SESSION["typeuser"] == 1) {
            $u = UserData::verid($_SESSION['conticomtc']); if ($u->cargo==1) { ?>
<div class="main-content"> 
    <div class="page-content">
        <div class="container-fluid"> 
            <div class="row">
                <div class="col">
                    <div class="h-100">
                        <div class="row">
                            <div class="col-xl-4 col-md-6">
                                <!-- card -->
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <?php $club = count(ClubData::vercontenido()); $club1 = count(UserData::vercontenidos()); ?>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Total de clubs</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <h5 class="text-success fs-14 mb-0">
                                                    <i class="ri-arrow-right-up-line fs-13 align-middle"></i><?= $club; ?>
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="<?= $club; ?>"><?= $club; ?></span>  </h4>
                                                <a href="club" class="text-decoration-underline">Club</a>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-soft-success rounded fs-3">
                                                    <i class="ri-file-settings-line text-success"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-6">
                                <!-- card -->
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <?php $liga = count(LigaData::vercontenidos()); $liga1 = count(LigaData::vercontenidos()); ?>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total de Ligas</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <h5 class="text-danger fs-14 mb-0">
                                                    <i class="ri-arrow-right-down-line fs-13 align-middle"></i> <?= $liga;?>
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="<?= $liga;?>"><?= $liga1;?></span></h4>
                                                <a href="liga" class="text-decoration-underline">Liga</a>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-soft-info rounded fs-3">
                                                    <i class="ri-trophy-line"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->

                            <div class="col-xl-4 col-md-6">
                                <!-- card -->
                                <div class="card card-animate">
                                    <?php $user = count(UserData::vercontenido()); $user1 = count(UserData::vercontenidos()); ?>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">TOTAL DE ADMINISTRADORES</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <h5 class="text-success fs-14 mb-0">
                                                    <i class="ri-arrow-right-up-line fs-13 align-middle"></i><?= $user;?>
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="<?= $user;?>"><?= $user1;?></span> </h4>
                                                <a href="usuario" class="text-decoration-underline">Administrador</a>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-soft-warning rounded fs-3">
                                                    <i class="ri-admin-fill text-warning"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end row-->
                        <div class="full-width-container">
                            <img src="storage/per/inicio.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } else { 
    $u1 = UserData::verid($_SESSION['conticomtc']); ?>
<div class="main-content"> 
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-center">
                    <img src="storage/per/logo.png" alt="Federación Madrileña de Ajedrez" class="img-fluid my-3" style="max-width: 150px;">
                    <h1 class="text-primary">Bienvenido, <?= $u1->nombre.' '.$u1->apellido;?></h1>
                    <p class="text-muted">Tu espacio personal en la Federación Madrileña de Ajedrez</p>
                </div>
<!-- <table id="tabladecambiios" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
    <thead>
        <tr class="table-primary">
            <th>Nombres y apellidos</th>
            <th>Nº licencia</th>
            <th>F. nacimiento</th>
            <th>Telefono</th>
            <th>Club (Cod)</th>
            <th>Federac. (Cod)</th>
            <th>Elo</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $datas = EquipoJugadorData::holamundillo(61);
        foreach ($datas as $data) { ?>
            <tr data-id="<?= $data->id1; ?>" data-jugador="<?= $data->id; ?>" data-equipo="<?= $data->id2; ?>" data-estado="<?= $data->estadoee; ?>" data-duplicidad="<?= $data->duplicidadee; ?>" data-fecha="<?= $data->fechaee; ?>"> 
                <td ><?= $data->nombre." ".$data->apellido1." ".$data->apellido2; ?></td>
                <td  >Club del jugador</td>
                <td  ><?= $data->edad_completa; ?></td>
                <td  ><?= $data->telefono; ?></td>
                <td >Fecha del último torneo</td>
                <td ><?= $data->codigofide; ?></td>
                <td ><?= $data->elo; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var tbody = document.querySelector('table tbody');
    new Sortable(tbody, {
        animation: 150,
        handle: 'tr',
        ghostClass: 'sortable-ghost',
        onEnd: function (evt) {
            var order = [];
            tbody.querySelectorAll('tr').forEach(function (row) {
                order.push({
                    id: row.getAttribute('data-id'),
                    jugador: row.getAttribute('data-jugador'),
                    equipo: row.getAttribute('data-equipo'),
                    estado: row.getAttribute('data-estado'),
                    duplicidad: row.getAttribute('data-duplicidad'),
                    fecha: row.getAttribute('data-fecha')
                });
            });

            // Enviar los datos al servidor mediante fetch
            fetch('index.php?action=apiguardarorden', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ order: order }), // Enviar el nuevo orden
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Orden actualizado con éxito.');
                } else {
                    console.error('Error al actualizar el orden:', data.errors);
                }
            })
            .catch(error => console.error('Error en la solicitud:', error));
        }
    });
});
</script> -->



            </div>
        </div>
    </div> 
</div>
        <?php } } elseif ($_SESSION["typeuser"] == 2) {
            $u = JugadorData::verid($_SESSION['conticomtc']); ?>
<div class="main-content"> 
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-center">
                    <img src="storage/per/logo.png" alt="Federación Madrileña de Ajedrez" class="img-fluid my-3" style="max-width: 150px;">
                    <h1 class="text-primary">Bienvenido, <?= $u->nombre.' '.$u->apellido1.' '.$u->apellido2;?></h1>
                    <p class="text-muted">Tu espacio personal en la Federación Madrileña de Ajedrez</p>
                </div>
            </div>
        </div>
    </div> 
</div>
        <?php }
    } else {
        echo "login";
    }
} else { ?>
    <div class="main-content"> 
    <div class="page-content">
        <div class="container-fluid"> 
            <div class="row">
                <div class="col-12 text-center">
                    <img src="storage/per/logo.png" alt="Federación Madrileña de Ajedrez" class="img-fluid my-3" style="max-width: 150px;">
                    <h1 class="text-primary">Federación Madrileña de Ajedrez</h1>
                    <p class="text-muted">Promoviendo el ajedrez en la Comunidad de Madrid</p>
                </div>
            </div>
            <!-- <div class="row my-5">
                <div class="col-12">
                    <h2 class="text-primary">Últimas Noticias</h2>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Torneo Regional 2024</h5>
                            <p class="card-text">Únete al torneo regional que se celebrará el próximo mes en Madrid.</p>
                            <a href="#" class="btn btn-primary">Leer Más</a>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Resultados del Campeonato Simple</h5>
                            <p class="card-text">Consulta los resultados del reciente Campeonato Simple celebrado en Madrid.</p>
                            <a href="clasificacionsi" class="btn btn-primary">Ver Resultados</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row my-5">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="storage/per/1.jpg" class="img-fluid mb-3" alt="Imagen de Torneo">
                        </div>
                        <div class="col-md-4">
                            <img src="storage/per/2.jpg" class="img-fluid mb-3" alt="Imagen de Torneo">
                        </div>
                        <div class="col-md-4">
                            <img src="storage/per/3.jpg" class="img-fluid mb-3" alt="Imagen de Torneo">
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div> 
</div>
<?php } ?>
<?php 
$img=null;
if (isset($_SESSION["typeuser"]) && ($_SESSION["typeuser"] == 1 || $_SESSION["typeuser"] == 2)) {
    
    // Verifica si la sesión 'conticomtc' está establecida
    if (isset($_SESSION["conticomtc"])) {

        // Usuario tipo 1 (administrador)
        if ($_SESSION["typeuser"] == 1) {
            $u = UserData::verid($_SESSION['conticomtc']); 
            if ($u->imagen=="") {
                $img="storage/per/logo.png";
            } else {
                $img="storage/per/".$u->imagen;
            }
            // Aquí puedes agregar el contenido para jugadores
            ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- Tarjeta principal del perfil -->
                    <div class="card shadow-lg border-0">
                        <!-- Encabezado del perfil -->
                        <div class="card-header bg-gradient-primary text-white d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0 text-white flex-grow-1 text-center">Mi Perfil</h5>
                        </div>

                        <!-- Contenido de la tarjeta -->
                        <div class="card-body bg-dark text-light">
                            <!-- Imagen de perfil (opcional) -->
                            <div class="text-center mb-4">
                                <img src="<?= $img;?>" alt="Avatar" class="shadow" width="70">
                                <h6 class="mt-3"><?= htmlspecialchars($u->nombre); ?></h6>
                                <p class="text-muted"><?= htmlspecialchars($u->apellido); ?></p>
                            </div>

                            <!-- Formulario para editar el perfil -->
                            <form enctype="multipart/form-data" method="post" action="index.php?action=registro">
                                <div class="row">
                                    <!-- Nombre -->
                                    <div class="col-md-12 mb-3">
                                        <label for="nombre" class="form-label">Nombres</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($u->nombre); ?>">
                                    </div>

                                    <!-- Apellido 1 -->
                                    <div class="col-md-12 mb-3">
                                        <label for="apellido" class="form-label">Apellidos</label>
                                        <input type="text" class="form-control" id="apellido" name="apellido" value="<?= htmlspecialchars($u->apellido); ?>">
                                    </div>
                                    <!-- Fecha de Nacimiento -->
                                    <div class="col-md-6 mb-3">
                                        <label for="nacimiento" class="form-label">Fecha de Nacimiento</label>
                                        <input type="date" class="form-control" id="nacimiento" name="nacimiento" value="<?= htmlspecialchars($u->nacimiento); ?>">
                                    </div>

                                    <!-- Teléfono -->
                                    <div class="col-md-6 mb-3">
                                        <label for="telefono" class="form-label">Teléfono</label>
                                        <input type="tel" class="form-control" id="telefono" name="telefono" value="<?= htmlspecialchars($u->telefono); ?>">
                                    </div>

                                    <!-- Número de Licencia -->
                                    <div class="col-md-6 mb-3">
                                        <label for="ci" class="form-label">CI</label>
                                        <input type="text" class="form-control" id="ci" name="ci" value="<?= htmlspecialchars($u->ci); ?>">
                                    </div>
                                    <hr>
                                    <div class="col-md-6 mb-3">
                                        <label for="elo" class="form-label">Usuario</label>
                                        <input type="text" class="form-control" name="users">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="elo" class="form-label">Contraseña</label>
                                        <input type="password" class="form-control"  name="password">
                                    </div>

                                    <!-- Botón de guardar cambios -->
                                    <div class="col-12 text-center">
                                        <input type="hidden" name="actions" value="68">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($u->id); ?>">
                                        <button type="submit" class="btn btn-primary px-4 py-2 mt-3">Guardar Cambios</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Pie de la tarjeta -->
                        <div class="card-footer text-center bg-gradient-primary text-white">
                            <a href="salir.php" class="text-white">Cerrar Sesión</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .card {
    border-radius: 15px;
    overflow: hidden;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
}

.form-control:focus {
    border-color: #6a11cb;
    box-shadow: 0 0 10px rgba(106, 17, 203, 0.5);
}

.btn-primary {
    background-color: #6a11cb;
    border: none;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #2575fc;
}

img.rounded-circle {
    border: 3px solid #6a11cb;
    transition: transform 0.3s ease;
}

img.rounded-circle:hover {
    transform: scale(1.05);
}
</style>
        <?php }

        // Usuario tipo 2 (jugador)
        elseif ($_SESSION["typeuser"] == 2) {
            $u = JugadorData::verid($_SESSION['conticomtc']);
            if ($u->imagen=="") {
                $img="storage/per/logo.png";
            } else {
                $img="storage/per/".$u->imagen;
            }
            // Aquí puedes agregar el contenido para jugadores
            ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- Tarjeta principal del perfil -->
                    <div class="card shadow-lg border-0">
                        <!-- Encabezado del perfil -->
                        <div class="card-header bg-gradient-primary text-white d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0 text-white flex-grow-1 text-center">Mi Perfil</h5>
                        </div>

                        <!-- Contenido de la tarjeta -->
                        <div class="card-body bg-dark text-light">
                            <!-- Imagen de perfil (opcional) -->
                            <div class="text-center mb-4">
                                <img src="<?= $img;?>" alt="Avatar" class="shadow" width="70">
                                <h6 class="mt-3"><?= htmlspecialchars($u->nombre); ?></h6>
                                <p class="text-muted"><?= htmlspecialchars($u->apellido1 . ' ' . $u->apellido2); ?></p>
                            </div>

                            <!-- Formulario para editar el perfil -->
                            <form enctype="multipart/form-data" method="post" action="index.php?action=registro">
                                <div class="row">
                                    <!-- Nombre -->
                                    <div class="col-md-6 mb-3">
                                        <label for="nombre" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($u->nombre); ?>">
                                    </div>

                                    <!-- Apellido 1 -->
                                    <div class="col-md-6 mb-3">
                                        <label for="apellido1" class="form-label">Primer Apellido</label>
                                        <input type="text" class="form-control" id="apellido1" name="apellido1" value="<?= htmlspecialchars($u->apellido1); ?>">
                                    </div>

                                    <!-- Apellido 2 -->
                                    <div class="col-md-6 mb-3">
                                        <label for="apellido2" class="form-label">Segundo Apellido</label>
                                        <input type="text" class="form-control" id="apellido2" name="apellido2" value="<?= htmlspecialchars($u->apellido2); ?>">
                                    </div>

                                    <!-- Fecha de Nacimiento -->
                                    <div class="col-md-6 mb-3">
                                        <label for="nacimiento" class="form-label">Fecha de Nacimiento</label>
                                        <input type="date" class="form-control" id="nacimiento" name="nacimiento" value="<?= htmlspecialchars($u->nacimiento); ?>">
                                    </div>

                                    <!-- Teléfono -->
                                    <div class="col-md-6 mb-3">
                                        <label for="telefono" class="form-label">Teléfono</label>
                                        <input type="tel" class="form-control" id="telefono" name="telefono" value="<?= htmlspecialchars($u->telefono); ?>">
                                    </div>

                                    <!-- Número de Licencia -->
                                    <div class="col-md-6 mb-3">
                                        <label for="numlicencia" class="form-label">Número de Licencia</label>
                                        <input type="text" class="form-control" id="numlicencia" name="numlicencia" value="<?= htmlspecialchars($u->numlicencia); ?>">
                                    </div>

                                    <!-- ELO -->
                                    <div class="col-md-6 mb-3">
                                        <label for="elo" class="form-label">ELO</label>
                                        <input type="text" class="form-control" id="elo" name="elo" value="<?= htmlspecialchars($u->elo); ?>">
                                    </div>
                                    <hr>
                                    <div class="col-md-6 mb-3">
                                        <label for="elo" class="form-label">Usuario</label>
                                        <input type="text" class="form-control" name="users">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="elo" class="form-label">Contraseña</label>
                                        <input type="password" class="form-control"  name="password">
                                    </div>

                                    <!-- Botón de guardar cambios -->
                                    <div class="col-12 text-center">
                                        <input type="hidden" name="actions" value="67">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($u->id); ?>">
                                        <button type="submit" class="btn btn-primary px-4 py-2 mt-3">Guardar Cambios</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Pie de la tarjeta -->
                        <div class="card-footer text-center bg-gradient-primary text-white">
                            <a href="salir.php" class="text-white">Cerrar Sesión</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .card {
    border-radius: 15px;
    overflow: hidden;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
}

.form-control:focus {
    border-color: #6a11cb;
    box-shadow: 0 0 10px rgba(106, 17, 203, 0.5);
}

.btn-primary {
    background-color: #6a11cb;
    border: none;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #2575fc;
}

img.rounded-circle {
    border: 3px solid #6a11cb;
    transition: transform 0.3s ease;
}

img.rounded-circle:hover {
    transform: scale(1.05);
}
</style>
            <?php
        }
    }
} else {
    header("Location: ./"); 
    exit();
}
?>

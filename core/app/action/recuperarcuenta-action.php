<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<?php
// Inicialización y conexión a la base de datos
$base = Database::getInstance();
$con = $base->getConnection();

// Inicializa una variable para almacenar el mensaje de error
$errorMsg = "";

// Verificar si el token está presente en la URL
if(isset($_GET['token'])) {
    $token = $_GET['token'];

    // Buscar el token en la base de datos
    $sql = "SELECT * FROM usuario WHERE token=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        // Token válido
        $user = $result->fetch_assoc();

        // Si el formulario ha sido enviado
        if(isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            // Validaciones
            if(empty($new_password) || strlen($new_password) > 255) {
                $errorMsg = "La contraseña es inválida.";
            } elseif($new_password !== $confirm_password) {
                $errorMsg = "Las contraseñas no coinciden.";
            } else {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Actualizar el nombre de usuario y la contraseña en la base de datos
                $sql = "UPDATE usuario SET password=?, token=NULL WHERE id=?";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("si", $hashed_password, $user['id']);
                $stmt->execute();

                echo "<div class='alert alert-success'>Usuario y contraseña actualizados con éxito!</div>";
            }
        } else {
            // Mostrar el formulario para ingresar el nuevo nombre de usuario y contraseña
            echo '
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">Restablecer Contraseña</div>
                            <div class="card-body">
                                <form method="post">
                                    <div class="mb-3">
                                        <label for="new_password" class="form-label">Nueva Contraseña:</label>
                                        <input autofocus type="password" class="form-control" name="new_password" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="confirm_password" class="form-label">Confirmar Contraseña:</label>
                                        <input type="password" class="form-control" name="confirm_password" required>
                                    </div>
                                    <input type="submit" class="btn btn-primary" value="Actualizar">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            ';
        }
    } else {
        $errorMsg = "El enlace de recuperación es inválido o ha expirado.";
    }
} else {
    $errorMsg = "Acceso denegado.";
}

// Si hay un mensaje de error, muestra el toast
if($errorMsg) {
    echo "
    <div class='position-fixed bottom-0 end-0 p-3' style='z-index: 5'>
        <div id='errorToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true'>
            <div class='toast-header bg-danger text-white'>
                <i class='fas fa-exclamation-circle me-2'></i>
                <strong class='me-auto'>Error</strong>
                <button type='button' class='btn-close' data-bs-dismiss='toast' aria-label='Close'></button>
            </div>
            <div class='toast-body'>
                $errorMsg
            </div>
        </div>
    </div>

    <script>
        var toastEl = document.getElementById('errorToast');
        var toast = new bootstrap.Toast(toastEl);
        toast.show();

        // Redirige al usuario al formulario después de 5 segundos (5000 milisegundos)
        setTimeout(function() {
            window.location.href = 'http://ajedrez.madrid/gEquipos/index.php?action=recuperarcuenta&token=$token';
        }, 5000);
    </script>
    ";
}
?>

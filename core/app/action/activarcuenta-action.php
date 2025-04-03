<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<?php
$base = Database::getInstance();
$con = $base->getConnection();
$errorMsg = "";

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $stmt = $con->prepare("SELECT id FROM usuario WHERE token = ?");
    
    if ($stmt) {
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        $stmt->close(); // Cerrar la sentencia anterior

        if ($user) {
            $stmt2 = $con->prepare("UPDATE usuario SET estado = 1, token = NULL WHERE id = ?");
            if ($stmt2) {
                $stmt2->bind_param("i", $user['id']);
                if ($stmt2->execute()) {
                    echo "<div class='custom-alert'>
                    ¡Tu cuenta ha sido activada con éxito! </p></p>
                    Por seguridad, te recomendamos que cambies tu contraseña haciendo clic en 'Olvidó su contraseña' en el formulario de acceso al sistema. Haz clic <a href='https://ajedrez.madrid/gEquipos/index.php?action=iniciador&tid=1'>aquí</a> para entrar.
                    </div>"
                ;
                } else {
                    echo "<div class='alert alert-danger'>Hubo un error al activar tu cuenta. Por favor, inténtalo de nuevo.</div>";
                }
                $stmt2->close();
            } else {
                $errorMsg = "Hubo un error al preparar la consulta de actualización.";
            }
        } else {
            $errorMsg = "Token inválido o ya ha sido utilizado.";
        }
        $result->free(); // Libera el resultado
    } else {
        $errorMsg = "Hubo un error al preparar la consulta de selección.";
    }
} else {
    $errorMsg = "Acceso denegado.";
}
// Si hay un mensaje de error, muestra el toast
if ($errorMsg) {
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
    </script>
    ";
}
?>
<?php
session_start();  // Iniciar la sesión para poder almacenar mensajes de error en ella.

// Para depuración (temporal)
error_log("Tipo de usuario: " . (isset($_SESSION['typeuser']) ? $_SESSION['typeuser'] : "No definido"));

$user_var = htmlentities($_POST["usuario"]);
$password_var = htmlentities($_POST['password']);

$base = Database::getInstance();
$con = $base->getConnection();

/**
 * Caso 1: Usuario de tipo 1 (administrativo)  
 * Dentro de estos, se consideran:
 *   - cargo 1: Federación
 *   - cargo 2: Club
 *   - cargo 3: Árbitro
 *   - cargo 4: Capitán
 *
 * Para TODOS los usuarios de tipo 1 se enviará un código de verificación,
 * pero si el usuario es de cargo 2 (Club), además se debe almacenar en la sesión
 * el valor alfabético del club. Ese valor se obtiene del campo "club" de la tabla
 * usuario (que contiene un valor numérico) y se usa para buscar en la tabla club el campo "codigo".
 */
if ($_SESSION['typeuser'] == 1) {
    $sql = "SELECT * FROM usuario WHERE usuario = ? AND estado = 1";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $user_var);
    $stmt->execute();
    $result = $stmt->get_result();

    $credentialsCorrect = false;
    $emailExists = false;
    $yo = null;
    $cargo = null;
    $clubAlfabetico = '';

    // Se asume que solo existe un registro por usuario
    $r = $result->fetch_assoc();
    if ($r) {
        if (password_verify($password_var, $r['password'])) {
            $credentialsCorrect = true;
            $yo = $r['id'];
            $cargo = $r['cargo']; // Por ejemplo: 1, 2, 3 o 4
            $_SESSION['cargo'] = $cargo;
            // En el caso de cargo=2 (Club), el campo "club" de la tabla usuario contiene un valor numérico
            // que debemos usar para obtener el código alfabético desde la tabla club.
            if ($cargo == 2) {
                $club_id = $r['club'];
                error_log("Club ID obtenido (usuario): " . $club_id);
                if (!empty($club_id)) {
                    $sqlClub = "SELECT codigo FROM club WHERE id = ?";
                    $stmtClub = $con->prepare($sqlClub);
                    $stmtClub->bind_param("i", $club_id);
                    $stmtClub->execute();
                    $resultClub = $stmtClub->get_result();
                    if ($resultClub->num_rows > 0) {
                        $rClub = $resultClub->fetch_assoc();
                        $_SESSION['club'] = $rClub['codigo'];
                        error_log("Club asignado en sesión: " . $_SESSION['club']);
                    } else {
                        $_SESSION['club'] = '';
                        error_log("No se encontró registro en la tabla club para id: " . $club_id);
                    }
                } else {
                    $_SESSION['club'] = '';
                    error_log("El campo club en la tabla usuario está vacío para el usuario");
                }
            }
            // Para otros cargos, podrías asignar $_SESSION['club'] = '' o dejarlo sin modificar
            if (!empty($r['email'])) {
                $emailExists = true;
                $email = $r['email'];
            }
        }
    }

    if (!$credentialsCorrect) {
        $_SESSION['error_message'] = "Usuario o contraseña incorrecta";
        header("Location: index.php?view=login");
        exit;
    } elseif (!$emailExists) {
        $_SESSION['error_message'] = "Correo no registrado";
        header("Location: index.php?view=login");
        exit;
    } else {
        // Enviar el código de verificación (doble autenticación)
        $verificationCode = rand(100000, 999999);
        $posiblesesion = $yo;
        setcookie('verificationCode', $verificationCode, time() + 120);
        setcookie('posiblesesion', $posiblesesion, time() + 120);
        $_SESSION['verificationStartTime'] = time();
        // Configuración de errores para depuración (puedes quitarla en producción)
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        require 'PHPMailer/PHPMailerAutoload.php';
        try {
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'no-reply@ajedrez.madrid';
            $mail->Password = 'idltdeybkoxupnbe';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $correo = $email;
            $mail->setFrom('federacion@ajedrez.madrid', 'Federación Madrileña de Ajedrez');
            $mail->addAddress($correo, 'FMA - No responder');
            $mail->CharSet = 'UTF-8';
            $mail->isHTML(true);

            $image_path = "storage/per/logo.png";
            $image_data = file_get_contents($image_path);
            $image_base64 = base64_encode($image_data);
            $image_type = pathinfo($image_path, PATHINFO_EXTENSION);
            $image_src = "data:image/{$image_type};base64,{$image_base64}";

            $mail->Subject = 'Código de verificación de Gestión de Equipos - Federación Madrileña de Ajedrez';
            $mail->Body = '
                <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; line-height: 1.5; background-color: #f7f7f7; }
                        .container { background-color: #ffffff; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); }
                        h2 { color: #4CAF50; border-bottom: 2px solid #4CAF50; padding-bottom: 10px; margin-bottom: 20px; }
                        .code { background-color: #e9ecef; padding: 10px; border-radius: 5px; font-size: 18px; font-weight: bold; color: #d54; margin: 20px 0; }
                        p { margin-bottom: 10px; }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <div style="text-align: center;">
                            <h2>Código de verificación</h2>
                            <p>Has recibido este correo porque has solicitado un código de verificación para acceder al sistema de Gestión de Equipos de la Federación Madrileña de Ajedrez. Si no hiciste esta solicitud, por favor ignora este mensaje.</p>
                            <div class="code">
                                Tu código es: ' . $verificationCode . '
                            </div>
                            <p>Este código es válido durante 2 minutos. No compartas este código con nadie.</p>
                            <p>Un saludo,<br>Federación Madrileña de Ajedrez</p>
                        </div>
                    </div>
                </body>
                </html>
                ';

            $mail->AltBody = "Has recibido este correo porque has solicitado un código de verificación para acceder al sistema de Gestión de Equipos de la FMA. Si no hiciste esta solicitud, ignora este mensaje.\n\nTu código es: $verificationCode\n\nEste código es válido durante 2 minutos.\n\nUn saludo,\nFMA";
            $mail->send();
            // En este caso, tras enviar el código, redirigimos a una página de verificación para que el usuario ingrese el código
            header("Location: index.php?view=verificar");
            exit;
        } catch (Exception $e) {
            echo "Error de envío: {$mail->ErrorInfo}";
        }
    }
}

/**
 * Caso 2: Usuario de tipo 2 (jugador)
 * Se autentica sin doble autenticación.
 */
if ($_SESSION['typeuser'] == 2) {
    $sql = "SELECT * FROM jugador WHERE users = ? AND estado = 1";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $user_var);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
         $r = $result->fetch_assoc();
         if (password_verify($password_var, $r['password'])) {
             $_SESSION['conticomtc'] = $r['id'];
             header("Location: index.php?view=index");
             exit;
         } else {
             $_SESSION['error_message'] = "Usuario o contraseña incorrecta";
             header("Location: index.php?view=login");
             exit;
         }
    } else {
         $_SESSION['error_message'] = "Jugador no registrado";
         header("Location: index.php?view=login");
         exit;
    }
}
?>

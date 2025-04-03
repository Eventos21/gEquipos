<?php
$email = htmlentities($_POST["correo"]);
$base = Database::getInstance();
$con = $base->getConnection();
$sql = "SELECT * FROM usuario WHERE email= ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$emailExists = false;
while ($r = $result->fetch_assoc()) {
    if ($result->num_rows > 0) {
        $emailExists = true;
        $email1 = $r['email'];
        $yo = $r['id'];
    }
}
if (!$emailExists) {
    $_SESSION['error_message2'] = "Correo no registrado";
    header("Location: index.php?view=login");
    exit;
} else {
    $_SESSION['error_message3'] = "Correo enviado correctamente";
    // actualizar Token
    $token = bin2hex(random_bytes(50));
    $sql = "UPDATE usuario SET token=? WHERE id=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("si", $token, $yo);
    $stmt->execute();
    // -------------------------------------------
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require 'PHPMailer/PHPMailerAutoload.php';
    try {
        $mail = new PHPMailer();
        $mail->isSMTP();  
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true; 
        $mail->Username   = 'no-reply@ajedrez.madrid';
        $mail->Password   = 'idltdeybkoxupnbe';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;
        $correo = $email1;
        $mail->setFrom('federacion@ajedrez.madrid', 'Federación Madrileña de Ajedrez');
        $mail->addAddress(''.$correo.'', 'FMA - No responder');
        $mail->CharSet = 'UTF-8';
        $mail->isHTML(true);
        $resetLink = "http://ajedrez.madrid/gEquipos/index.php?action=recuperarcuenta&token=$token";
        $mailBody = "
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 0;
                }
                .container {
                    max-width: 600px;
                    margin: 50px auto;
                    background-color: #ffffff;
                    padding: 20px;
                    box-shadow: 0 0 10px rgba(0,0,0,0.1);
                }
                .header {
                    background-color: #007BFF;
                    color: #ffffff;
                    padding: 10px 0;
                    text-align: center;
                }
                .content {
                    padding: 20px;
                }
                .button {
                    display: block;
                    width: 200px;
                    height: 50px;
                    margin: 20px auto;
                    background-color: #007BFF;
                    text-align: center;
                    border-radius: 5px;
                    color: white;
                    font-weight: bold;
                    line-height: 50px;
                    text-decoration: none;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Recuperación de contraseña</h2>
                </div>
                <div class='content'>
                    <p>Hola,</p>
                    <p>Hemos recibido una solicitud para restablecer la contraseña de tu cuenta. Si no hiciste esta solicitud, simplemente ignora este correo.</p>
                    <p>De lo contrario, haz clic en el siguiente enlace para establecer una nueva contraseña:</p>
                    <a  style='color: #FFFFFF;' href='$resetLink' class='button'>Restablecer contraseña</a>
                    <p>Un saludo,<br>Federación Madrileña de Ajedrez</p>
                </div>
            </div>
        </body>
        </html>
        ";

        $mail->Subject = 'Recuperación de contraseña';
        $mail->Body    = $mailBody;
        $mail->AltBody = "Copia y pega este enlace en tu navegador para restablecer tu contraseña: $resetLink";

        $mail->send();
        header("Location: index.php?view=index");
    } catch (Exception $e) {
        echo "Error de envío: {$mail->ErrorInfo}";
    }
}
?>
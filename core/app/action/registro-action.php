<?php
require 'excel/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
require 'PHPMailer/PHPMailerAutoload.php';
use PhpOffice\PhpSpreadsheet\Shared\Date;
$database = Database::getInstance();
$mysqli = $database->getConnection();
$actions = $_POST['actions'];
if ($actions==1) {
    $c = ClienteData::duplicidad($_POST['ci']);
        if ($c == null) {
           $registro = new ClienteData();
        foreach ($_POST as $K => $v){
            if (property_exists($registro, $K)) {
                $registro->$K = $v;
            }
        }
        $registro->registro();
        $_SESSION['success_message'] = "El registro se completó con éxito.";
        header("Location: cliente");
        } else {
            $_SESSION['error_message'] = "Ya existe el registro...!";
            header("Location: cliente");
        }
}
if ($actions==2) {
    $registro = new ClienteData();
    foreach ($_POST as $k => $v) {
        if (property_exists($registro, $k)) {
            $registro->$k = $v;
        }
    }
    if (ClienteData::evitarladuplicidad($_POST['ci'], $_POST['id'])) {
        $_SESSION['success_messagea1'] = "El usuario ya existe en otro registro.";
        header("Location: cliente");
        exit;
    }
    $registro->actualizar();
    $_SESSION['success_messagea'] = "Actualizado con éxito.";
    header("Location: cliente");
}
if ($actions==3) {
    $eliminar = ClienteData::verid($_POST["id"]);
    $eliminar->eliminar();
    $_SESSION['eliminado'] = "Eliminado con éxito.";
    header("Location: cliente");
}
if ($actions==4) {
    $c = UserData::duplicidad($_POST['ci']);
        if ($c == null) {
           $registro = new UserData();
        foreach ($_POST as $K => $v){
            if (property_exists($registro, $K)) {
                $registro->$K = $v;
            }
        }
        $target_dir = "storage/archivo/";
        $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
            echo "El imagen " . basename($_FILES["imagen"]["name"]) . " ha sido subido.";
            $registro->imagen = basename($_FILES["imagen"]["name"]);
        } else { }
        $registro->usuario = $_POST['ci'];
        $registro->password = password_hash($_POST['ci'], PASSWORD_DEFAULT); 
        $usuario = $registro->registro();

        // *************************************************************************

        $token = bin2hex(random_bytes(50));
        $base = Database::getInstance();
        $con = $base->getConnection();
        $sql = "UPDATE usuario SET token=? WHERE id=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $token, $usuario[1]);
        $stmt->execute();
        // // -------------------------------------------
        // envíar correo:
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        // require 'PHPMailer/PHPMailerAutoload.php';
        try {
            //Server settings
            $mail = new PHPMailer();
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'no-reply@ajedrez.madrid';                     //SMTP username
            $mail->Password   = 'idltdeybkoxupnbe';                               //SMTP password
            $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            //Recipients
            $correo = $_POST['email'];
            $mail->setFrom('federacion@ajedrez.madrid', 'Federación Madrileña de Ajedrez');
            $mail->addAddress($correo, 'FMA - No responder');     //Add a recipient
            //Attachments
            $mail->CharSet = 'UTF-8'; // Para manejar caracteres especiales como tildes
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->addEmbeddedImage('storage/per/logoFMAmail.png', 'logo_cid');
            $url = "https://ajedrez.madrid/gEquipos/index.php?action=activarcuenta&token=$token";
            $url1 = "https://ajedrez.madrid/gEquipos/index.php?view=login";
            $mail->Subject = 'Activación de cuenta en Federación Madrileña de Ajedrez'; // Asunto
            $mail->Body = '
            <html>
                <head>
                    <style>
                        body {
                            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
                            color: #000; /* Cambiado a negro */
                            max-width: 600px;
                            margin: 0 auto;
                            padding: 20px;
                            line-height: 1.6;
                            background-color: #f4f6f8;
                        }
                        .container {
                            background-color: #ffffff;
                            padding: 40px;
                            border-radius: 10px;
                            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
                        }
                        .header {
                            text-align: center;
                            margin-bottom: 40px;
                        }
                        .header img {
                            max-width: 150px;
                            margin-bottom: 20px;
                        }
                        .btn {
                            display: inline-block;
                            margin: 10px 0;
                            padding: 15px 30px;
                            font-size: 16px;
                            cursor: pointer;
                            text-align: center;
                            text-decoration: none;
                            outline: none;
                            color: #FFFFFF;
                            background-color: #3498db;
                            border: none;
                            border-radius: 5px;
                            transition: background-color 0.3s;
                            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                        }
                        .btn:hover {
                            background-color: #2980b9;
                        }
                        .info {
                            background-color: #f7f9fc;
                            padding: 15px;
                            border-radius: 5px;
                            margin-top: 20px;
                        }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <div class="header">
                            <img src="cid:logo_cid" alt="Logo FMA">
                            <h2>Bienvenido al Sistema de Gestión de la Federación Madrileña de Ajedrez</h2>
                        </div>
                        <p>Has sido registrado en Federación Madrileña de Ajedrez.</p>
                        <p>Para activar tu cuenta, simplemente haz clic en el siguiente botón:</p>
                        <a class="btn" style="color: #FFFFFF" target="_blank" href="' . $url . '">Activar cuenta</a>
                        <p></p>
                        <div class="info">
                            <p><strong>Usuario:</strong> ' . $_POST['ci'] . '</p>
                            <p><strong>Contraseña:</strong> ' . $_POST['ci'] . '</p>
                        </div>
                        <p>Si tienes alguna pregunta, no dudes en contactar con nosotros</p>
                        <p><em>Federación Madrileña de Ajedrez</em></p>
                    </div>
                </body>
                </html>
            ';
            $mail->AltBody = 'Para activar tu cuenta, visita el siguiente enlace: ' . $url . '. Tu Usuario es: ' . $_POST['ci'] . ' y tu contraseña es: ' . $_POST['ci'];
            $mail->send();
            echo 'El mensaje se envío correctamente';
        } catch (Exception $e) {
            echo "Error de envío: {$mail->ErrorInfo}";
        }

        // *************************************************************************

        $_SESSION['success_message'] = "El registro se completó correctamente.";
        header("Location: usuario");
        } else {
            $_SESSION['error_message'] = "Ya existe el registro.";
            header("Location: usuario");
        }
}
if ($actions==5) {
    $registro = new UserData();
    foreach ($_POST as $k => $v) {
        if (property_exists($registro, $k)) {
            $registro->$k = $v;
        }
    }
    if (UserData::evitarladuplicidad($_POST['ci'], $_POST['id'])) {
        $_SESSION['success_messagea1'] = "El usuario ya existe en otro registro.";
        header("Location: usuario");
        exit;
    }
    if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
        $imagen = $_FILES["imagen"]["name"];
        $target_dir = "storage/archivo/";
        $target_file = $target_dir . basename($imagen);
        if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
        }
        $registro->imagen = $imagen;
    } else {
        $registro->imagen = $_POST['imagen1Campo'];
    }

    if ($_POST['usuario']) {
        $registro->usuario=$_POST['usuario'];
        $registro->actualizarusuario();
    }
    if ($_POST['password']) {
        $registro->password=password_hash($_POST['password'], PASSWORD_DEFAULT);
        $registro->actualizarpassword();
    }
    $registro->estado = isset($_POST['estado']) && $_POST['estado'] == 'on';

    $registro->actualizar();
    $_SESSION['success_messagea'] = "Actualizado correctamente.";
    header("Location: usuario");
}
if ($actions==6) {
    if ($_SESSION['conticomtc'] == $_POST['id']) {
        $_SESSION['eliminado'] = "No se puede eliminarse a sí mismo.";
    } else {
        try {
            $mysqli->begin_transaction();
            $eliminar = UserData::verid($_POST["id"]);
            $eliminar->eliminar();
            $mysqli->commit();

            $_SESSION['eliminado'] = "Eliminado con éxito.";
        } catch (mysqli_sql_exception $e) {
            $_SESSION['eliminado'] = "No se puede eliminar este usuario debido a relaciones en otras tablas.";
        }
    }
    header("Location: usuario");
}
if ($actions==7) {
    $c = ClubData::duplicidad($_POST['codigo']);
        if ($c == null) {
           $registro = new ClubData();
        foreach ($_POST as $K => $v){
            if (property_exists($registro, $K)) {
                $registro->$K = $v;
            }
        }
        $registro->usuario=$_SESSION['conticomtc'];
        $registro->registro();
        $_SESSION['success_message'] = "El registro se completó con éxito.";
        header("Location: club");
        } else {
            $_SESSION['error_message'] = "Ya existe el registro...!";
            header("Location: club");
        }
}
if ($actions==8) {
    $registro = new ClubData();
    foreach ($_POST as $k => $v) {
        if (property_exists($registro, $k)) {
            $registro->$k = $v;
        }
    }
    if (ClubData::evitarladuplicidad($_POST['codigo'], $_POST['id'])) {
        $_SESSION['success_messagea1'] = "Ya existe en otro registro.";
        header("Location: club");
        exit;
    }
    $registro->estado = isset($_POST['estado']) && $_POST['estado'] == 'on';
    $registro->actualizar();
    $_SESSION['success_messagea'] = "Actualizado con éxito.";
    header("Location: club");
}
if ($actions==9) {
    try {
            $mysqli->begin_transaction();
            $eliminar = ClubData::verid($_POST["id"]);
            $eliminar->eliminar();
            $mysqli->commit();

            $_SESSION['eliminado'] = "Eliminado con éxito.";
        } catch (mysqli_sql_exception $e) {
            $_SESSION['eliminado'] = "No se puede eliminar este usuario debido a relaciones en otras tablas.";
        }
    header("Location: club");
}
if ($actions==10) {
    $duplicidad=$_POST['numlicencia'].$_POST['apellido1'].$_POST['apellido2'];
    // echo "$duplicidad";
    $c = JugadorData::duplicidad($duplicidad);
        if ($c == null) {
           $registro = new JugadorData();
        foreach ($_POST as $K => $v){
            if (property_exists($registro, $K)) {
                $registro->$K = $v;
            }
        }
        $registro->usuario=$_SESSION['conticomtc'];
        $registro->duplicidad=$duplicidad;
        $registro->users = $_POST['numlicencia'];
        $registro->password = password_hash($_POST['telefono'], PASSWORD_DEFAULT); 
        $participante = $registro->registro();

        $duplicidad11 = $participante[1] . $_POST['tid'];
        if (!EquipoJugadorData::duplicidad($duplicidad11)) {
            $registro = new EquipoJugadorData();
            $registro->equipo=$_POST['tid'];
            $registro->jugador=$participante[1];
            $registro->duplicidad=$duplicidad11;
            $registro->registro();
        }
        $_SESSION['success_message'] = "El registro se completó con éxito.";
        header("Location: participante&tid=".$_POST['tid']);
        } else {
            $_SESSION['error_message'] = "Ya existe el registro...!";
            header("Location: participante&tid=".$_POST['tid']);
        }
}
if ($actions==11) {
    $duplicidad=$_POST['numlicencia'].$_POST['apellido1'].$_POST['apellido2'];
    $registro = new JugadorData();
    foreach ($_POST as $k => $v) {
        if (property_exists($registro, $k)) {
            $registro->$k = $v;
        }
    }
    $registro->duplicidad=$duplicidad;
    if (JugadorData::evitarladuplicidad($duplicidad, $_POST['id'])) {
        $_SESSION['success_messagea1'] = "Ya existe en otro registro similar.";
       header("Location: participante&tid=".$_POST['tid']);
        exit;
    }
    $registro->estado = isset($_POST['estado']) && $_POST['estado'] == 'on';
    $registro->actualizar();
    $_SESSION['success_messagea'] = "Actualizado con éxito.";
    header("Location: participante&tid=".$_POST['tid']);
}
if ($actions==12) {
    try {
            $mysqli->begin_transaction();
            $eliminar = JugadorData::verid($_POST["id"]);
            $eliminar->eliminar();
            $mysqli->commit();

            $_SESSION['eliminado'] = "Eliminado con éxito.";
        } catch (mysqli_sql_exception $e) {
            $_SESSION['eliminado'] = "No se puede eliminar este usuario debido a relaciones en otras tablas.";
        }
        header("Location: jugador");
}
if ($actions==13) {
    $duplicidad=$_POST['nombre'].$_POST['liga'];
    $c = EquipoData::duplicidad($duplicidad);
        if ($c == null) {
           $registro = new EquipoData();
        foreach ($_POST as $K => $v){
            if (property_exists($registro, $K)) {
                $registro->$K = $v;
            }
        }
        if ($_POST['capitan']=="") {
            $registro->capitan=$_POST['capitan1'];
        } else {
            $registro->capitan=$_POST['capitan'];
        }
        if ($_POST['subcapitan']=="") {
            $registro->subcapitan=$_POST['subcapitan1'];
        } else {
            $registro->subcapitan=$_POST['subcapitan'];
        }
        $registro->duplicidad=$duplicidad;
        $registro->usuario=$_SESSION['conticomtc'];
        $registro->registro();

        // $registro1 = new ligaUsuarioData();
        // $registro1->id=$_POST['idcantidad'];
        // // $registro1->cantidad=$_POST['cantidad']-1;
        // $registro1->actualizar_cantidad();

        $_SESSION['success_message'] = "El registro se completó con éxito.";
        header("Location: equipo");
        } else {
            $_SESSION['error_message'] = "Ya existe el registro...!";
            header("Location: equipo");
        }
}
if ($actions==14) {
    $duplicidad=$_POST['nombre'].$_POST['liga'];
    $registro = new EquipoData();
    foreach ($_POST as $k => $v) {
        if (property_exists($registro, $k)) {
            $registro->$k = $v;
        }
    }
    $registro->duplicidad=$duplicidad;
    if (EquipoData::evitarladuplicidad($duplicidad, $_POST['id'])) {
        $_SESSION['success_messagea1'] = "Ya existe en otro registro similar.";
        header("Location: equipo");
        exit;
    }
        if ($_POST['capitan']=="") {
            $registro->capitan=$_POST['capitan1'];
        } else {
            $registro->capitan=$_POST['capitan'];
        }
        if ($_POST['subcapitan']=="") {
            $registro->subcapitan=$_POST['subcapitan1'];
        } else {
            $registro->subcapitan=$_POST['subcapitan'];
        }
    $registro->condicion = isset($_POST['condicion']) && $_POST['condicion'] == 'on';
    $registro->actualizar();
    $_SESSION['success_messagea'] = "Actualizado con éxito.";
    header("Location: equipo");
}
if ($actions==15) {
    try {
            $mysqli->begin_transaction();
            $eliminar = EquipoData::verid($_POST["id"]);
            $eliminar->eliminar();
            $mysqli->commit();

            $_SESSION['eliminado'] = "Eliminado con éxito.";
        } catch (mysqli_sql_exception $e) {
            $_SESSION['eliminado'] = "No se puede eliminar este usuario debido a relaciones en otras tablas.";
        }
        header("Location: equipo");
}
if ($actions==16) {
    $duplicidad=$_POST['nombre'].$_POST['sucursal'];
    $c = CargoData::duplicidadd($duplicidad);
        if ($c == null) {
           $registro = new CargoData();
        foreach ($_POST as $K => $v){
            if (property_exists($registro, $K)) {
                $registro->$K = $v;
            }
        }
        $registro->duplicidad=$duplicidad;
        $registro->registro();
        $_SESSION['success_message'] = "El registro se completó con éxito.";
        header("Location: cargo");
        } else {
            $_SESSION['error_message'] = "Ya existe el registro...!";
            header("Location: cargo");
        }
}
if ($actions==17) {
    $duplicidad=$_POST['nombre'].$_POST['sucursal'];
    $registro = new CargoData();
    foreach ($_POST as $k => $v) {
        if (property_exists($registro, $k)) {
            $registro->$k = $v;
        }
    }
    $registro->duplicidad=$duplicidad;
    if (CargoData::evitarladuplicidad($duplicidad, $_POST['id'])) {
        $_SESSION['success_messagea1'] = "Ya existe en otro registro similar.";
        header("Location: cargo");
        exit;
    }
    $registro->actualizar();
    $_SESSION['success_messagea'] = "Actualizado con éxito.";
    header("Location: cargo");
}
if ($actions==18) {
    try {
        $mysqli->begin_transaction();
        $eliminar = CargoData::verid($_POST["id"]);
        $eliminar->eliminar();
        $mysqli->commit();

        $_SESSION['eliminado'] = "Eliminado con éxito.";
    } catch (mysqli_sql_exception $e) {
        $_SESSION['eliminado'] = "No se puede eliminar este usuario debido a relaciones en otras tablas.";
    }
    header("Location: cargo");
}
if ($actions==19) {
    $duplicidad=$_POST['nombre'];
    $c = TemporadaData::duplicidad($duplicidad);
        if ($c == null) {
           $registro = new TemporadaData();
        foreach ($_POST as $K => $v){
            if (property_exists($registro, $K)) {
                $registro->$K = $v;
            }
        }
        $registro->duplicidad=$duplicidad;
        $registro->usuario=$_SESSION['conticomtc'];
        $temp = $registro->registro();

        $datos = array(
            'Liga FMA Ajedrez Rápido por Equipos', 'LFARE',
            'Liga FMA Sub-16 por Equipos', 'LFS16',
            'Liga FMA Regular por Equipos', 'LFRE'
        );

        // Recorremos el array en pares (nombre y código)
        for ($i = 0; $i < count($datos); $i += 2) {
            $nombreTemporada = $datos[$i];
            $codigoTemporada = $datos[$i + 1];

            $registro1 = new LigaData();
            $registro1->nombre = $nombreTemporada;
            $registro1->codigo = $codigoTemporada;
            $registro1->temporada = $temp[1];
            $registro1->usuario = $_SESSION['conticomtc'];
            $registro1->registro_liga();
        }
        $_SESSION['success_message'] = "El registro se completó con éxito.";
        header("Location: temporada");
        } else {
            $_SESSION['error_message'] = "Ya existe el registro...!";
            header("Location: temporada");
        }
}
if ($actions==20) {
    $registro = new TemporadaData();
    foreach ($_POST as $k => $v) {
        if (property_exists($registro, $k)) {
            $registro->$k = $v;
        }
    }
        $registro->archivado = isset($_POST['archivado']) && $_POST['archivado'] == 'on';
    if (TemporadaData::evitarladuplicidad($_POST['nombre'], $_POST['id'])) {
        $_SESSION['success_messagea1'] = "Ya existe en otro registro similar.";
        header("Location: temporada");
        exit;
    }
    $registro->actualizar();
    $_SESSION['success_messagea'] = "Actualizado con éxito.";
    header("Location: temporada");
}
if ($actions==21) {
    try {
        $mysqli->begin_transaction();
        $eliminar = TemporadaData::verid($_POST["id"]);
        $eliminar->eliminar();
        $mysqli->commit();

        $_SESSION['eliminado'] = "Eliminado con éxito.";
    } catch (mysqli_sql_exception $e) {
        $_SESSION['eliminado'] = "No se puede eliminar este usuario debido a relaciones en otras tablas.";
    }
    header("Location: temporada");
}
if ($actions==22) {
    $duplicidad=$_POST['nombre'];
    $c = LigaData::duplicidad($duplicidad);
        if ($c == null) {
           $registro = new LigaData();
        foreach ($_POST as $K => $v){
            if (property_exists($registro, $K)) {
                $registro->$K = $v;
            }
        }
        $registro->usuario=$_SESSION['conticomtc'];
        $registro->registro();
        $_SESSION['success_message'] = "El registro se completó con éxito.";
        header("Location: liga");
        } else {
            $_SESSION['error_message'] = "Ya existe el registro...!";
            header("Location: liga");
        }
}
if ($actions==23) {
    $registro = new LigaData();
    foreach ($_POST as $k => $v) {
        $registro->$k = $v;
    }
    $registro->estado = isset($_POST['estado']) && $_POST['estado'] == 'on';
    $registro->actualizar();
    $_SESSION['success_messagea'] = "Actualizado con éxito.";
    header("Location: liga");
}
// if ($actions==23) {
//     $registro = new LigaData();
//     foreach ($_POST as $k => $v) {
//         if (property_exists($registro, $k)) {
//             $registro->$k = $v;
//         }
//     }
//         $registro->estado = isset($_POST['estado']) && $_POST['estado'] == 'on';
//     if (LigaData::evitarladuplicidad($_POST['nombre'], $_POST['id'])) {
//         $_SESSION['success_messagea1'] = "Ya existe en otro registro similar.";
//         header("Location: liga");
//         exit;
//     }
//     $registro->actualizar();
//     $_SESSION['success_messagea'] = "Actualizado con éxito.";
//     header("Location: liga");
// }
if ($actions==24) {
    try {
        $mysqli->begin_transaction();
        $eliminar = LigaData::verid($_POST["id"]);
        $eliminar->eliminar();
        $mysqli->commit();

        $_SESSION['eliminado'] = "Eliminado con éxito.";
    } catch (mysqli_sql_exception $e) {
        $_SESSION['eliminado'] = "No se puede eliminar este usuario debido a relaciones en otras tablas.";
    }
    header("Location: liga");
}
if ($actions==25) {
    

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['archivo'])) {
    // Ruta del archivo temporal
    $archivo = $_FILES['archivo']['tmp_name'];

    // Cargar el archivo Excel
    $spreadsheet = IOFactory::load($archivo);
    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

    // Iterar sobre las filas, comenzando desde la segunda fila (índice 1)
    foreach (array_slice($sheetData, 1) as $row) {
        $apellido1 = $row['A'];
        $apellido2 = $row['B'];
        $nombre = $row['C'];
        // $nacimiento = $row['D'];
        $nacimiento = date('Y-m-d', strtotime($row['D']));
        $numlicencia = $row['E'];
        $club = $row['F'];
        $codigofide = $row['G'];
        $elo = $row['H'];
        $telefono = $row['I'];

        // Calcular el valor de duplicidad
        $duplicidad = $numlicencia . $apellido1 . $apellido2;

        // Verificar duplicidad
        if (!JugadorData::duplicidad($duplicidad)) {
            // Si no hay duplicidad, registrar el jugador
            $registro = new JugadorData();
            $registro->apellido1 = $apellido1;
            $registro->apellido2 = $apellido2;
            $registro->nombre = $nombre;
            $registro->nacimiento = $nacimiento;
            $registro->numlicencia = $numlicencia;
            $registro->club = $club;
            $registro->codigofide = $codigofide;
            $registro->elo = $elo;
            $registro->telefono = $telefono;
            $registro->duplicidad = $duplicidad;
            $registro->users = $numlicencia;
            $registro->password = password_hash($telefono, PASSWORD_DEFAULT); 

            $participante = $registro->registro();

            $duplicidad11 = $participante[1] . $_POST['tid'];
            if (!EquipoJugadorData::duplicidad($duplicidad11)) {
                $registro1 = new EquipoJugadorData();
                $registro1->equipo=$_POST['tid'];
                $registro1->jugador=$participante[1];
                $registro1->duplicidad=$duplicidad11;
                $registro1->registro();
            }
        }
    }
    echo "Datos importados y registrados con éxito.";
}
    $_SESSION['success_message'] = "El registro se completó con éxito.";
    header("Location: participante&tid=".$_POST['tid']);
}
if ($actions==26) {
    $jugador=$_POST['jugador'];
    for ($i=0; $i < count($jugador) ; $i++) { 
        $duplicidad = $jugador[$i] . $_POST['tid'];
        if (!EquipoJugadorData::duplicidad($duplicidad)) {
            $datajugador = JugadorData::verid($jugador[$i]);
            $registro = new EquipoJugadorData();
            $registro->equipo=$_POST['tid'];
            $registro->jugador=$jugador[$i];
            $registro->duplicidad=$duplicidad;
            $registro->elo = $datajugador->elo;
            $registro->registro();
        }
    }
    $_SESSION['success_message'] = "El registro se completó con éxito.";
    header("Location: participante&tid=".$_POST['tid']);
}
if ($actions==27) {
    try {
        $mysqli->begin_transaction();
        $eliminar = EquipoJugadorData::verid($_POST["id"]);
        $eliminar->eliminar();
        $mysqli->commit();

        $_SESSION['eliminado'] = "Eliminado con éxito.";
    } catch (mysqli_sql_exception $e) {
        $_SESSION['eliminado'] = "No se puede eliminar este usuario debido a relaciones en otras tablas.";
    }
    header("Location: participante&tid=".$_POST['tid']);
}
if ($actions==28) {
    $duplicidad=$_POST['numlicencia'].$_POST['apellido1'].$_POST['apellido2'];
    // echo "$duplicidad";
    $c = JugadorData::duplicidad($duplicidad);
        if ($c == null) {
           $registro = new JugadorData();
        foreach ($_POST as $K => $v){
            if (property_exists($registro, $K)) {
                $registro->$K = $v;
            }
        }
        $registro->usuario=$_SESSION['conticomtc'];
        $registro->duplicidad=$duplicidad;
        $registro->users = $_POST['numlicencia'];
        $registro->password = password_hash($_POST['telefono'], PASSWORD_DEFAULT); 
        $registro->registro();
        $_SESSION['success_message'] = "El registro se completó con éxito.";
        header("Location: jugador");
        } else {
            $_SESSION['error_message'] = "Ya existe el registro...!";
            header("Location: jugador");
        }
}
if ($actions==29) {
    $duplicidad=$_POST['numlicencia'].$_POST['apellido1'].$_POST['apellido2'];
    $registro = new JugadorData();
    foreach ($_POST as $k => $v) {
        if (property_exists($registro, $k)) {
            $registro->$k = $v;
        }
    }
    $registro->duplicidad=$duplicidad;
    if (JugadorData::evitarladuplicidad($duplicidad, $_POST['id'])) {
        $_SESSION['success_messagea1'] = "Ya existe en otro registro similar.";
       header("Location: participante&tid=".$_POST['tid']);
        exit;
    }
    $registro->estado = isset($_POST['estado']) && $_POST['estado'] == 'on';
    $registro->actualizar();
    $_SESSION['success_messagea'] = "Actualizado con éxito.";
    header("Location: jugador");
}
if ($actions==30) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['archivo'])) {
        // Ruta del archivo temporal
        $archivo = $_FILES['archivo']['tmp_name'];

        // Cargar el archivo Excel
        $spreadsheet = IOFactory::load($archivo);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        // Bandera para verificar si hay algún error en las filas
        $error = false;

        // Iterar sobre las filas, comenzando desde la segunda fila (índice 1)
        foreach (array_slice($sheetData, 1) as $index => $row) {
            // Verificar si todos los campos de la fila están llenos
            if (!empty($row['A']) && !empty($row['C']) && !empty($row['D']) && !empty($row['E']) && !empty($row['F']) && !empty($row['G'])) {
                $apellido1 = $row['A'];
                $apellido2 = $row['B'];
                $nombre = $row['C'];
                $nacimiento = date('Y-m-d', strtotime($row['D']));
                $numlicencia = $row['E'];
                $club = $row['F'];
                $codigofide = $row['G'];
                $elo = $row['H'];
                $telefono = $row['I'];

                // Calcular el valor de duplicidad
                $duplicidad = $numlicencia . $apellido1;

                // Verificar si ya existe un registro con esta duplicidad
                $jugadorExistente = JugadorData::verPorDuplicidad($duplicidad);

                if ($jugadorExistente) {
                    // Si existe, actualizar los datos del jugador
                    $jugadorExistente->apellido1 = $apellido1;
                    $jugadorExistente->apellido2 = $apellido2;
                    $jugadorExistente->nombre = $nombre;
                    $jugadorExistente->nacimiento = $nacimiento;
                    $jugadorExistente->numlicencia = $numlicencia;
                    $jugadorExistente->club = $club;
                    $jugadorExistente->codigofide = $codigofide;
                    $jugadorExistente->elo = $elo;
                    $jugadorExistente->telefono = $telefono;
                    $jugadorExistente->duplicidad = $duplicidad;
                    $jugadorExistente->actualizar();
                } else {
                    // Si no existe, registrar un nuevo jugador
                    $registro = new JugadorData();
                    $registro->apellido1 = $apellido1;
                    $registro->apellido2 = $apellido2;
                    $registro->nombre = $nombre;
                    $registro->nacimiento = $nacimiento;
                    $registro->numlicencia = $numlicencia;
                    $registro->club = $club;
                    $registro->codigofide = $codigofide;
                    $registro->elo = $elo;
                    $registro->telefono = $telefono;
                    $registro->users = $numlicencia;
                    $registro->password = password_hash($telefono, PASSWORD_DEFAULT); 
                    $registro->duplicidad = $duplicidad;
                    $registro->registro();
                }
            } else {
                // Si algún campo está vacío, establecer la bandera de error en verdadero
                $error = true;
                // Mostrar un mensaje de error indicando la fila afectada
                echo "Error: La fila " . ($index + 1) . " tiene campos vacíos y no puede ser registrada.<br>";
            }
        }
        // Mostrar mensaje de éxito solo si no hubo errores
        if (!$error) {
            echo "Todos los datos importados y registrados/actualizados con éxito.";
        }
    }
    $_SESSION['success_message'] = "El registro se completó con éxito.";
    header("Location: jugador");
}
// if ($actions==30) {
    
// if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['archivo'])) {
//     // Ruta del archivo temporal
//     $archivo = $_FILES['archivo']['tmp_name'];

//     // Cargar el archivo Excel
//     $spreadsheet = IOFactory::load($archivo);
//     $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

//     // Iterar sobre las filas, comenzando desde la segunda fila (índice 1)
//     foreach (array_slice($sheetData, 1) as $row) {
//         $apellido1 = $row['A'];
//         $apellido2 = $row['B'];
//         $nombre = $row['C'];
//         // $nacimiento = $row['D'];
//         $nacimiento = date('Y-m-d', strtotime($row['D']));
//         $numlicencia = $row['E'];
//         $club = $row['F'];
//         $codigofide = $row['G'];
//         $elo = $row['H'];
//         $telefono = $row['I'];

//         // Calcular el valor de duplicidad
//         $duplicidad = $numlicencia . $apellido1 . $apellido2;

//         // Verificar duplicidad
//         if (!JugadorData::duplicidad($duplicidad)) {
//             // Si no hay duplicidad, registrar el jugador
//             $registro = new JugadorData();
//             $registro->apellido1 = $apellido1;
//             $registro->apellido2 = $apellido2;
//             $registro->nombre = $nombre;
//             $registro->nacimiento = $nacimiento;
//             $registro->numlicencia = $numlicencia;
//             $registro->club = $club;
//             $registro->codigofide = $codigofide;
//             $registro->elo = $elo;
//             $registro->telefono = $telefono;
//             $registro->duplicidad = $duplicidad;
//             $registro->registro();
//         }
//     }
//     echo "Datos importados y registrados con éxito.";
// }
//     $_SESSION['success_message'] = "El registro se completó con éxito.";
//     header("Location: jugador");
// }
if ($actions==31) {
    $registro = new EquipoData();
    foreach ($_POST as $k => $v) {
        if (property_exists($registro, $k)) {
            $registro->$k = $v;
        }
    }
    $registro->calificacion_federacion();
    $_SESSION['success_messagea'] = "Actualizado con éxito.";
    header("Location: federacion");
}
if ($actions==32) {
    $registro = new ClubData();
    foreach ($_POST as $k => $v) {
        if (property_exists($registro, $k)) {
            $registro->$k = $v;
        }
    }
    if (ClubData::evitarladuplicidad($_POST['codigo'], $_POST['id'])) {
        $_SESSION['success_messagea1'] = "Ya existe en otro registro.";
        header("Location: mclub");
        exit;
    }
    $registro->estado = isset($_POST['estado']) && $_POST['estado'] == 'on';
    $registro->actualizar();
    $_SESSION['success_messagea'] = "Actualizado con éxito.";
    header("Location: mclub");
}
if ($actions==33) {
    $registro = new EquipoData();
    $registro->estado=2;
    $registro->id=$_POST['id'];
    $registro->enviar_federacion();
    $_SESSION['success_messagea'] = "Enviado a la federación de manera exitosa.";
    header("Location: equipo");
}
if ($actions==330) {
    $registro = new EquipoData();
    $registro->estado=6;
    $registro->id=$_POST['id'];
    $registro->enviar_federacion();
    $_SESSION['success_messagea'] = "Enviado a la federación de manera exitosa.";
    header("Location: equipo");
}
if ($actions==34) {
    $duplicidad=$_POST['nombre'].$_POST['liga'];
    $c = EquipoData::duplicidad($duplicidad);
        if ($c == null) {
           $registro = new EquipoData();
        foreach ($_POST as $K => $v){
            if (property_exists($registro, $K)) {
                $registro->$K = $v;
            }
        }
        if ($_POST['capitan']=="") {
            $registro->capitan=$_POST['capitan1'];
        } else {
            $registro->capitan=$_POST['capitan'];
        }
        if ($_POST['subcapitan']=="") {
            $registro->subcapitan=$_POST['subcapitan1'];
        } else {
            $registro->subcapitan=$_POST['subcapitan'];
        }
        $registro->duplicidad=$duplicidad;
        $registro->usuario=$_SESSION['conticomtc'];
        $registro->registro();

        $registro1 = new ligaUsuarioData();
        $registro1->id=$_POST['idcantidad'];
        $registro1->cantidad=$_POST['cantidad']-1;
        $registro1->actualizar_cantidad();
        
        $_SESSION['success_message'] = "El registro se completó con éxito.";
        header("Location: mequipo");
        } else {
            $_SESSION['error_message'] = "Ya existe el registro...!";
            header("Location: mequipo");
        }
}
if ($actions==35) {
    $duplicidad=$_POST['nombre'].$_POST['liga'];
    $registro = new EquipoData();
    foreach ($_POST as $k => $v) {
        if (property_exists($registro, $k)) {
            $registro->$k = $v;
        }
    }
    $registro->duplicidad=$duplicidad;
    if (EquipoData::evitarladuplicidad($duplicidad, $_POST['id'])) {
        $_SESSION['success_messagea1'] = "Ya existe en otro registro similar.";
        header("Location: mequipo");
        exit;
    }
        if ($_POST['capitan']=="") {
            $registro->capitan=$_POST['capitan1'];
        } else {
            $registro->capitan=$_POST['capitan'];
        }
        if ($_POST['subcapitan']=="") {
            $registro->subcapitan=$_POST['subcapitan1'];
        } else {
            $registro->subcapitan=$_POST['subcapitan'];
        }
    $registro->condicion = isset($_POST['condicion']) && $_POST['condicion'] == 'on';
    $registro->actualizar_mequipo();
    $_SESSION['success_messagea'] = "Actualizado con éxito.";
    header("Location: mequipo");
}
if ($actions==36) {
    try {
            $mysqli->begin_transaction();
            $eliminar = EquipoData::verid($_POST["id"]);
            $eliminar->eliminar();
            $mysqli->commit();

            $_SESSION['eliminado'] = "Eliminado con éxito.";
        } catch (mysqli_sql_exception $e) {
            $_SESSION['eliminado'] = "No se puede eliminar este usuario debido a relaciones en otras tablas.";
        }
        header("Location: mequipo");
}
if ($actions==37) {
    $registro = new EquipoData();
    $registro->estado=2;
    $registro->id=$_POST['id'];
    $registro->enviar_federacion();
    $datas = EquipoJugadorData::vercontenidos1($_POST['id']);
    foreach ($datas as $data) {
        $actualizar = new EquipoJugadorData();
        $actualizar->id=$data->id;
        $actualizar->nuevo=1;
        $actualizar->cambiodenuevo();
        $actualizar->validado=1;
        $actualizar->cambiodevalidado();        
    }
    $_SESSION['success_messagea'] = "Enviado a la federación de manera exitosa.";
    header("Location: mequipo");
}
if ($actions==370) {
    $registro = new EquipoData();
    $registro->estado=6;
    $registro->id=$_POST['id'];
    $registro->enviar_federacion();
    $datas = EquipoJugadorData::vercontenidos1($_POST['id']);
    foreach ($datas as $data) {
        $actualizar = new EquipoJugadorData();
        $actualizar->id=$data->id;
        $actualizar->nuevo=1;
        $actualizar->cambiodenuevo();
        $actualizar->validado=1;
        $actualizar->cambiodevalidado();
    }
    $_SESSION['success_messagea'] = "Enviado a la federación de manera exitosa.";
    header("Location: mequipo");
}

if ($actions == 38) {
    $clubes = $_POST['club_'];
    $liga = $_POST['liga'];
    $cantidades = $_POST['cantidad_'];
    $ids = $_POST['id_']; // Si es necesario

    // Verificar si la liga y el club ya están registrados juntos
    foreach ($clubes as $i => $club) {
        $duplicados = ligaUsuarioData::duplicidad($liga, $club);

        if (!empty($duplicados)) {
            // Si ya están registrados, actualizar la cantidad
            $actualizar = new ligaUsuarioData();
            $actualizar->id = $ids[$i]; // Suponiendo que solo puede haber una fila duplicada
            $actualizar->cantidad = $cantidades[$i]; // Ajusta esto según cómo recibes la cantidad
            $actualizar->actualizar();
            $_SESSION['success_messagea'] = "Actualizado con éxito.";
        } else {
            // Si no están registrados, realizar un nuevo registro
            $registro = new ligaUsuarioData();
            $registro->liga = $liga;
            $registro->club = $club;
            $registro->cantidad = $cantidades[$i]; // Ajusta esto según cómo recibes la cantidad
            $registro->registro();
            $_SESSION['success_messagea'] = "Registrado con éxito.";
        }
    }
    header("Location: liga");
}
if ($actions==39) {
    $jugador=$_POST['jugador'];
    for ($i=0; $i < count($jugador) ; $i++) { 
        $duplicidad = $jugador[$i] . $_POST['tid'];
        if (!EquipoJugadorData::duplicidad($duplicidad)) {
            $datajugador = JugadorData::verid($jugador[$i]);
            $registro = new EquipoJugadorData();
            $registro->equipo=$_POST['tid'];
            $registro->jugador=$jugador[$i];
            $registro->duplicidad=$duplicidad;
            $registro->elo = $datajugador->elo;
            $registro->registro();
        }
    }

    $actualizar = new EquipoData();
    $actualizar->id=$_POST['tid'];
    $actualizar->estado = 1;
    $actualizar->cambioestado();
    $_SESSION['success_message'] = "El registro se completó con éxito.";
    header("Location: participante1&tid=".$_POST['tid']."&td=".$_POST['td']);
} 
if ($actions==40) {
    $registro = new PadreCompeticionData();
    $dataliga = LigaData::verid($_POST['liga']);
    $registro->tipoascenso = $_POST['tipoascenso'];
    $registro->liga = $_POST['liga'];
    $registro->cantidad = 1;
    $padre = $registro->registro();

    $registro1 = new CompeticionData();
    foreach ($_POST as $k => $v) {
        $registro1->$k = $v;
    }
    $registro1->nombregrupo=$dataliga->codigo;
    $registro1->padre_competicion=$padre[1];
    $registro1->registro();
    $_SESSION['success_message'] = "El registro se completó con éxito.";
    header("Location: competicion");
}
if ($actions==41) {
    $ligas = count(PadreCompeticionData::vertotal($_POST['liga']));
    $dataliga = LigaData::verid($_POST['liga']);
    if ($ligas<=2) {
       if ($ligas==0) {
        $registro = new PadreCompeticionData();
        $registro->tipoascenso = $_POST['tipoascenso'];
        $registro->liga = $_POST['liga'];
        $registro->cantidad = 1;
        $padre = $registro->registro();

        $registro1 = new CompeticionData();
        foreach ($_POST as $k => $v) {
            $registro1->$k = $v;
        }
        $registro1->nombregrupo=$dataliga->codigo;
        $registro1->padre_competicion=$padre[1];
        $registro1->registro();
        $_SESSION['success_message'] = "El registro se completó con éxito.";
        header("Location: competicion");
        } else {
            $seleccionarmaxi = PadreCompeticionData::vertotalmax($_POST['liga']);
            // echo "".$seleccionarmaxi;
            $registro1 = new CompeticionData();
            foreach ($_POST as $k => $v) {
                $registro1->$k = $v;
            }
            $registro1->nombregrupo=$dataliga->codigo;
            $registro1->padre_competicion=$seleccionarmaxi;
            $registro1->registro();
            $_SESSION['success_message'] = "El registro se completó con éxito.";
            header("Location: competicion");
        }
    } else {
        $registro = new PadreCompeticionData();
        $registro->tipoascenso = $_POST['tipoascenso'];
        $registro->liga = $_POST['liga'];
        $registro->cantidad = 1;
        $padre = $registro->registro();

        $registro1 = new CompeticionData();
        foreach ($_POST as $k => $v) {
            $registro1->$k = $v;
        }
        $registro1->nombregrupo=$dataliga->codigo;
        $registro1->padre_competicion=$padre[1];
        $registro1->registro();
        $_SESSION['success_message'] = "El registro se completó con éxito.";
        header("Location: competicion");
    }
        
}
if ($actions==42) {
    $liga= $_POST['liga'];
    $tipoascenso= $_POST['tipoascenso'];
    $cantidad= $_POST['cantidad'];

    $nombregrupo = $_POST['nombregrupo'];
    $tipocompeticion = $_POST['tipocompeticion'];
    $ronda = $_POST['ronda'];
    $jugadores = $_POST['jugadores'];
    $grupo = $_POST['grupo'];

    $registro = new PadreCompeticionData();
    $registro->tipoascenso = $tipoascenso;
    $registro->liga = $liga;
    $registro->cantidad = $cantidad;
    $padre = $registro->registro();

    for ($i=0; $i < count($nombregrupo); $i++) { 
        $registro1 = new CompeticionData();
        $registro1->padre_competicion = $padre[1];
        $registro1->tipocompeticion = $tipocompeticion[$i];
        $registro1->nombregrupo = $nombregrupo[$i];
        $registro1->tipoascenso = $tipoascenso;
        $registro1->rondas = $ronda[$i];
        $registro1->jornadas = "";
        $registro1->cantidajugadores = $jugadores[$i];
        $registro1->grupo = $grupo[$i];
        $registro1->registro();
    }
    $_SESSION['success_message'] = "El registro se completó con éxito.";
    header("Location: competicion");
}
if ($actions==43) {
    $actualizar = new CompeticionData();
    foreach ($_POST as $K => $v){
        $actualizar->$K = $v;
    }
    $actualizar->actualizar1();
    $_SESSION['success_messagea'] = "Actualizado con éxito.";
    header("Location: competicion");
}
if ($actions==44) {
    $actualizar = new CompeticionData();
    foreach ($_POST as $K => $v){
        $actualizar->$K = $v;
    }
    $actualizar->actualizar2();
    $_SESSION['success_messagea'] = "Actualizado con éxito.";
    header("Location: editcompeticion&tid=".$_POST['tid']);
}
if ($actions==45) {
    try {
            $mysqli->begin_transaction();
            $eliminar = CompeticionData::verid($_POST["id"]);
            $eliminar->eliminar();
            $mysqli->commit();

            $_SESSION['eliminado'] = "Eliminado con éxito.";
        } catch (mysqli_sql_exception $e) {
            $_SESSION['eliminado'] = "No se puede eliminar este usuario debido a relaciones en otras tablas.";
        }
    header("Location: editcompeticion&tid=".$_POST['tid']);
}
if ($actions==46) {
    $padre_competicion= $_POST['tid'];

    $nombregrupo = $_POST['nombregrupo'];
    $tipocompeticion = $_POST['tipocompeticion'];
    $ronda = $_POST['ronda'];
    $jugadores = $_POST['jugadores'];
    $grupo = $_POST['grupo'];

    for ($i=0; $i < count($nombregrupo); $i++) { 
        $registro1 = new CompeticionData();
        $registro1->padre_competicion = $padre_competicion;
        $registro1->tipocompeticion = $tipocompeticion[$i];
        $registro1->nombregrupo = $nombregrupo[$i];
        $registro1->tipoascenso = $tipoascenso;
        $registro1->rondas = $ronda[$i];
        $registro1->jornadas = "";
        $registro1->cantidajugadores = $jugadores[$i];
        $registro1->grupo = $grupo[$i];
        $registro1->registro();
    }
    $_SESSION['success_message'] = "El registro se completó con éxito.";
    header("Location: editcompeticion&tid=".$_POST['tid']);
}
if ($actions==47) {
    try {
            $mysqli->begin_transaction();
            $eliminar = CompeticionData::verid($_POST["id"]);
            $eliminar->eliminar();
            $mysqli->commit();

            $_SESSION['eliminado'] = "Eliminado con éxito.";
        } catch (mysqli_sql_exception $e) {
            $_SESSION['eliminado'] = "No se puede eliminar este usuario debido a relaciones en otras tablas.";
        }
        header("Location: competicion");
    }
if ($actions==48) {
    $competicion = $_POST['competicion'];
    $liga = $_POST['liga'];
    $idequipo = $_POST['idequipo_'];
    $nuevonuero = $_POST['nuevonuero_'];
if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] !== UPLOAD_ERR_NO_FILE) {
    // Crear un mapeo de nombre de equipo => id
    $equipoMap = array_combine($nuevonuero, $idequipo);

    // Leer el archivo Excel
    $archivo = $_FILES['archivo']['tmp_name'];
    $spreadsheet = IOFactory::load($archivo);
    $worksheet = $spreadsheet->getActiveSheet();
    $data = $worksheet->toArray();

    // Registro inicial en SalaData
    $registro1 = new SalaData();
    $ultimoRequerimiento = SalaData::verultimoid();
    $cajita = ($ultimoRequerimiento !== null) ? $ultimoRequerimiento + 1 : 1;
    $registro1->codigo = $cajita;
    $registro1->liga = $liga;
    $registro1->competicion = $competicion;
    $sala = $registro1->registro1();

    // Inicializar variables para el seguimiento de la ronda y el encuentro
    $ronda_actual = null;
    $encuentro = 0;

    // Procesar cada fila del archivo Excel (omitimos la primera fila si tiene cabecera)
    for ($i = 1; $i < count($data); $i++) {
        $row = $data[$i];
        $ronda = $row[0];
        // $fecha = date('Y-m-d', strtotime($row[1])); // Convertir a formato Y-m-d
        $fecha = date('Y-m-d H:i:s', strtotime($row[1]));
        $equipoA = $row[2];
        $equipoB = $row[3];

        // Obtener id_competidor e id_rival
        $id_competidor = $equipoMap[$equipoA] ?? null;
        $id_rival = $equipoMap[$equipoB] ?? null;

        // Verificar si hemos cambiado de ronda
        if ($ronda_actual !== $ronda) {
            $ronda_actual = $ronda;
            $encuentro = 1; // Reiniciar el contador de encuentros para la nueva ronda
        } else {
            $encuentro++; // Incrementar el contador de encuentros dentro de la misma ronda
        }

        // Registrar en SalaPersonalizadaData
        $registro1 = new SalaPersonalizadaData();
        $registro1->sala = $sala[1];
        $registro1->ronda = $ronda;
        $registro1->fecha = $fecha;
        $registro1->equipo_competidor = $equipoA;
        $registro1->equipo_rival = $equipoB;
        $registro1->id_competidor = $id_competidor;
        $registro1->id_rival = $id_rival;
        $registro1->encuentro = $encuentro;
        $registro1->registro();
    }

    echo "Datos importados y registrados correctamente.";
    header("Location: emparejamiento");
}
 else {
        // echo "sin archivo";
        

        $registro1 = new SalaData();
        $cajita = 0;
        $ultimoRequerimiento = SalaData::verultimoid();
        if ($ultimoRequerimiento !== null) {
             $cajita= $ultimoRequerimiento+1;
         } else {
            $cajita=1;
        }
        echo "$cajita";
        $registro1->codigo = $cajita;
        $registro1->liga=$liga;
        $registro1->competicion=$competicion;
        $sala=$registro1->registro();

        for ($i=0; $i < count($idequipo); $i++) { 
            $registro = new ValorEquipoData();
            $registro->liga=$liga;
            $registro->equipo= $idequipo[$i];
            $registro->valor= $nuevonuero[$i];
            $registro->sala= $sala[1];
            $registro->competicion= $competicion;
            $registro->registro();
        }
        header("Location: emparejamiento");
    }
}



// if ($actions==49) {
//     $cantidadRondas = 13;
//     $cantidadEncuentrosPorRonda = 7;
    
//     for ($i = 0; $i < $cantidadRondas; $i++) {
//         $registro = new CompetenciasData();
        
//         for ($j = 0; $j < $cantidadEncuentrosPorRonda; $j++) {
//             $indice = $i * $cantidadEncuentrosPorRonda + $j;
//             $registro->{"encuentro".($j+1)."_a"} = $_POST['valor_a'][$indice];
//             $registro->{"encuentro".($j+1)."_b"} = $_POST['valor_b'][$indice];
//         }
//         $registro->fecha_encuentro = $_POST['fecha_encuentro'][$i];
//         $registro->sala = $_POST['sala'];
//         $registro->registro_competicion();
//     }
//  }
//  if ($actions==50) {
//     $cantidadRondas = 14;
//     $cantidadEncuentrosPorRonda = 4;
//     for ($i = 0; $i < $cantidadRondas; $i++) {
//         $registro = new CompetenciasData();
        
//         for ($j = 0; $j < $cantidadEncuentrosPorRonda; $j++) {
//             $indice = $i * $cantidadEncuentrosPorRonda + $j;
//             $registro->{"encuentro".($j+1)."_a"} = $_POST['valor_a'][$indice];
//             $registro->{"encuentro".($j+1)."_b"} = $_POST['valor_b'][$indice];
//         }
//         $registro->fecha_encuentro = $_POST['fecha_encuentro'][$i];
//         $registro->sala = $_POST['sala'];
//         $registro->registro_competicionDH();
//     }
//  }
if ($actions == 49) {
    $cantidadRondas = 13;
    $cantidadEncuentrosPorRonda = 7;
    for ($i = 0; $i < count($_POST['fecha_encuentro']); $i++) {
        $fechaEncuentro = $_POST['fecha_encuentro'][$i];
        // Verificar que fecha_encuentro no esté vacío
        if (!empty($fechaEncuentro)) {
            $c = CompetenciasData::duplicidad($_POST['sala'], $fechaEncuentro);
            // Comprobar la duplicidad
            if ($c == null) {
                $registro = new CompetenciasData();
                for ($j = 0; $j < $cantidadEncuentrosPorRonda; $j++) {
                    $indice = $i * $cantidadEncuentrosPorRonda + $j;
                    $registro->{"encuentro".($j+1)."_a"} = $_POST['valor_a'][$indice];
                    $registro->{"encuentro".($j+1)."_b"} = $_POST['valor_b'][$indice];
                }
                $registro->fecha_encuentro = $fechaEncuentro;
                $registro->sala = $_POST['sala'];
                $registro->registro_competicion();
                echo "Registro creado: fecha $fechaEncuentro, sala ".$_POST['sala']."<br>";
            } else {
                echo "Registro duplicado: fecha $fechaEncuentro, sala ".$_POST['sala']."<br>";
            }
        } else {
            echo "Fecha de encuentro vacía en la posición $i<br>";
        }
    }
    header("Location: emparejamiento");
}
if ($actions == 50) {
    $cantidadRondas = 14;
    $cantidadEncuentrosPorRonda = 4;
    for ($i = 0; $i < count($_POST['fecha_encuentro']); $i++) {
        $fechaEncuentro = $_POST['fecha_encuentro'][$i];
        if (!empty($fechaEncuentro)) {
            $c = CompetenciasData::duplicidad($_POST['sala'], $fechaEncuentro);
            if ($c == null) {
                $registro = new CompetenciasData();
                for ($j = 0; $j < $cantidadEncuentrosPorRonda; $j++) {
                    $indice = $i * $cantidadEncuentrosPorRonda + $j;
                    $registro->{"encuentro".($j+1)."_a"} = $_POST['valor_a'][$indice];
                    $registro->{"encuentro".($j+1)."_b"} = $_POST['valor_b'][$indice];
                }
                $registro->fecha_encuentro = $fechaEncuentro;
                $registro->sala = $_POST['sala'];
                $registro->registro_competicionDH();
                echo "Registro creado: fecha $fechaEncuentro, sala ".$_POST['sala']."<br>";
            } else {
                echo "Registro duplicado: fecha $fechaEncuentro, sala ".$_POST['sala']."<br>";
            }
        } else {
            echo "Fecha de encuentro vacía en la posición $i<br>";
        }
    }
    header("Location: emparejamiento");
}
if ($actions==51) {
    $fecha_encuentro = $_POST['fecha_encuentro_'];
    $id = $_POST['id_'];

    for ($i=0; $i < count($id) ; $i++) { 
        $actualizar = new CompetenciasData();
        $actualizar->id = $id[$i];
        $actualizar->fecha_encuentro = $fecha_encuentro[$i];
        $actualizar->actualizar();
    }
    header("Location: emparejamiento");
}
if ($actions==52) {
    $registro = new ActaData();
    $registro->competencias = $_POST['competencias'];
    $registro->equipo = $_POST['equipo'];
    $registro->jugador = $_POST['jugador'];
    $registro->registro();
    echo json_encode(['status' => 'success']);
} elseif ($actions == 'updateTable1') {
    $competencia_id = $_POST['competencia_id'];
    $equipo_id = $_POST['equipo_id'];
    $datas = ActaData::vercontenidos($competencia_id, $equipo_id);
    $contador1 = 1;
    foreach ($datas as $data) {
        echo '<tr>
            <td>' . $contador1++ . '</td>
            <td>' . $data->equipo . '</td>
            <td>' . $data->jugador . '</td>
            <td>
                <select name="resultado">
                    <option value="">Elegir</option>
                    <option value="1">1</option>
                    <option value="1/2">1/2</option>
                    <option value="0">0</option>
                    <option value="+">+</option>
                    <option value="-">-</option>
                </select>
            </td>
            <td><a class="add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#exampleModalLong">Limpiar</a></td>
        </tr>';
    }
}
if ($actions==53) {
    $competicion = $_POST['competicion'];
    $liga = $_POST['liga'];
    $idequipo = $_POST['idequipo_'];
    $nuevonuero = $_POST['nuevonuero_'];
// if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] !== UPLOAD_ERR_NO_FILE) {
//     // Crear un mapeo de nombre de equipo => id
//     $equipoMap = array_combine($nuevonuero, $idequipo);

//     // Leer el archivo Excel
//     $archivo = $_FILES['archivo']['tmp_name'];
//     $spreadsheet = IOFactory::load($archivo);
//     $worksheet = $spreadsheet->getActiveSheet();
//     $data = $worksheet->toArray();

//     // Registro inicial en SalaData
//     $registro1 = new SalaData();
//     $ultimoRequerimiento = SalaData::verultimoid();
//     $cajita = ($ultimoRequerimiento !== null) ? $ultimoRequerimiento + 1 : 1;
//     $registro1->codigo = $cajita;
//     $registro1->liga = $liga;
//     $registro1->competicion = $competicion;
//     $sala = $registro1->registro1();

//     // Inicializar variables para el seguimiento de la ronda y el encuentro
//     $ronda_actual = null;
//     $encuentro = 0;

//     // Procesar cada fila del archivo Excel (omitimos la primera fila si tiene cabecera)
//     for ($i = 1; $i < count($data); $i++) {
//         $row = $data[$i];
//         $ronda = $row[0];
//         $fecha = date('Y-m-d', strtotime($row[1])); // Convertir a formato Y-m-d
//         $equipoA = $row[2];
//         $equipoB = $row[3];

//         // Obtener id_competidor e id_rival
//         $id_competidor = $equipoMap[$equipoA] ?? null;
//         $id_rival = $equipoMap[$equipoB] ?? null;

//         // Verificar si hemos cambiado de ronda
//         if ($ronda_actual !== $ronda) {
//             $ronda_actual = $ronda;
//             $encuentro = 1; // Reiniciar el contador de encuentros para la nueva ronda
//         } else {
//             $encuentro++; // Incrementar el contador de encuentros dentro de la misma ronda
//         }
//         // Registrar en SalaPersonalizadaData
//         $registro1 = new SalaPersonalizadaData();
//         $registro1->sala = $sala[1];
//         $registro1->ronda = $ronda;
//         $registro1->fecha = $fecha;
//         $registro1->equipo_competidor = $equipoA;
//         $registro1->equipo_rival = $equipoB;
//         $registro1->id_competidor = $id_competidor;
//         $registro1->id_rival = $id_rival;
//         $registro1->encuentro = $encuentro;
//         $registro1->registro();

//         $registro2 = new ValorData();
//         $registro2->sala = $sala[1];
//         $registro2->equipo=$idequipo;
//         $registro2->valor=$valor;
//         $registro2->registro();
//     }

//     echo "Datos importados y registrados correctamente.";
//     header("Location: emparejamientos");
// }
// Obtener los datos de POST
// $competicion = $_POST['competicion'];
// $liga = $_POST['liga'];
// $idequipo = $_POST['idequipo_'];
// $nuevonuero = $_POST['nuevonuero_'];

// // Verificar si se subió un archivo
// if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] !== UPLOAD_ERR_NO_FILE) {
//     // Crear un mapeo de nombre de equipo => id
//     $equipoMap = array_combine($nuevonuero, $idequipo);

//     // Leer el archivo Excel
//     $archivo = $_FILES['archivo']['tmp_name'];
//     $spreadsheet = IOFactory::load($archivo);
//     $worksheet = $spreadsheet->getActiveSheet();
//     $data = $worksheet->toArray();

//     // Registro inicial en SalaData
//     $registro1 = new SalaData();
//     $ultimoRequerimiento = SalaData::verultimoid();
//     $cajita = ($ultimoRequerimiento !== null) ? $ultimoRequerimiento + 1 : 1;
//     $registro1->codigo = $cajita;
//     $registro1->liga = $liga;
//     $registro1->competicion = $competicion;
//     $sala = $registro1->registro1();

//     // Inicializar variables para el seguimiento de la ronda y el encuentro
//     $ronda_actual = null;
//     $encuentro = 0;

//     // Procesar cada fila del archivo Excel (omitimos la primera fila si tiene cabecera)
//     for ($i = 1; $i < count($data); $i++) {
//         $row = $data[$i];
//         $ronda = $row[0];
//         $fecha = date('Y-m-d', strtotime($row[1])); // Convertir a formato Y-m-d
//         $equipoA = $row[2];
//         $equipoB = $row[3];

//         // Obtener id_competidor e id_rival
//         $id_competidor = $equipoMap[$equipoA] ?? null;
//         $id_rival = $equipoMap[$equipoB] ?? null;

//         // Verificar si hemos cambiado de ronda
//         if ($ronda_actual !== $ronda) {
//             $ronda_actual = $ronda;
//             $encuentro = 1; // Reiniciar el contador de encuentros para la nueva ronda
//         } else {
//             $encuentro++; // Incrementar el contador de encuentros dentro de la misma ronda
//         }

//         // Registrar en SalaPersonalizadaData
//         $registro1 = new SalaPersonalizadaData();
//         $registro1->sala = $sala[1];
//         $registro1->ronda = $ronda;
//         $registro1->fecha = $fecha;
//         $registro1->equipo_competidor = $equipoA;
//         $registro1->equipo_rival = $equipoB;
//         $registro1->id_competidor = $id_competidor;
//         $registro1->id_rival = $id_rival;
//         $registro1->encuentro = $encuentro;
//         $registro1->registro();

//         // Verificar y registrar para el equipo competidor
//         $duplicados_competidor = ValorData::duplicidad($sala[1], $id_competidor);
//         if (count($duplicados_competidor) === 0) {
//             $registro2 = new ValorData();
//             $registro2->sala = $sala[1];
//             $registro2->equipo = $id_competidor;
//             $registro2->valor = $equipoA;
//             $registro2->registro();
//         }

//         // Verificar y registrar para el equipo rival
//         $duplicados_rival = ValorData::duplicidad($sala[1], $id_rival);
//         if (count($duplicados_rival) === 0) {
//             $registro2 = new ValorData();
//             $registro2->sala = $sala[1];
//             $registro2->equipo = $id_rival;
//             $registro2->valor = $equipoA;
//             $registro2->registro();
//         }
//     }

//     echo "Datos importados y registrados correctamente.";
//     // header("Location: emparejamientos");
// }












if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] !== UPLOAD_ERR_NO_FILE) {
    // Crear un mapeo de nombre de equipo => id
    $equipoMap = array_combine($nuevonuero, $idequipo);

    // Leer el archivo Excel
    $archivo = $_FILES['archivo']['tmp_name'];
    $spreadsheet = IOFactory::load($archivo);
    $worksheet = $spreadsheet->getActiveSheet();
    $data = $worksheet->toArray();

    // Registro inicial en SalaData
    $registro1 = new SalaData();
    $ultimoRequerimiento = SalaData::verultimoid();
    $cajita = ($ultimoRequerimiento !== null) ? $ultimoRequerimiento + 1 : 1;
    $registro1->codigo = $cajita;
    $registro1->liga = $liga;
    $registro1->competicion = $competicion;
    $sala = $registro1->registro1();

    // Inicializar variables para el seguimiento de la ronda y el encuentro
    $ronda_actual = null;
    $encuentro = 0;

    // Crear una instancia para el registro de valores únicos
    $registro = new ValorData();

    // Procesar cada fila del archivo Excel (omitimos la primera fila si tiene cabecera)
    for ($i = 1; $i < count($data); $i++) {
        $row = $data[$i];
        $ronda = $row[0];
        // $fecha = date('Y-m-d', strtotime($row[1])); // Convertir a formato Y-m-d
        $fecha = date('Y-m-d H:i:s', strtotime($row[1]));
        $equipoA = $row[2];
        $equipoB = $row[3];

        // Obtener id_competidor e id_rival
        $id_competidor = $equipoMap[$equipoA] ?? null;
        $id_rival = $equipoMap[$equipoB] ?? null;

        // Verificar si hemos cambiado de ronda
        if ($ronda_actual !== $ronda) {
            $ronda_actual = $ronda;
            $encuentro = 1; // Reiniciar el contador de encuentros para la nueva ronda
        } else {
            $encuentro++; // Incrementar el contador de encuentros dentro de la misma ronda
        }

        // Registrar en SalaPersonalizadaData
        $registro1 = new SalaPersonalizadaData();
        $registro1->sala = $sala[1];
        $registro1->ronda = $ronda;
        $registro1->fecha = $fecha;
        $registro1->equipo_competidor = $equipoA;
        $registro1->equipo_rival = $equipoB;
        $registro1->id_competidor = $id_competidor;
        $registro1->id_rival = $id_rival;
        $registro1->encuentro = $encuentro;
        $registro1->registro();

        // Registrar valores únicos en datosdelquipo
        if ($id_competidor && count(ValorData::duplicidad($equipoA, $sala[1])) == 0) {
            $registro->valor = $equipoA;
            $registro->sala = $sala[1];
            $registro->equipo = $id_competidor;
            $registro->registro();
        }

        if ($id_rival && count(ValorData::duplicidad($equipoB, $sala[1])) == 0) {
            $registro->valor = $equipoB;
            $registro->sala = $sala[1];
            $registro->equipo = $id_rival;
            $registro->registro();
        }
    }

    echo "Datos importados y registrados correctamente.";
    header("Location: emparejamientos");
}

 else {
        // echo "sin archivo";
        

        $registro1 = new SalaData();
        $cajita = 0;
        $ultimoRequerimiento = SalaData::verultimoid();
        if ($ultimoRequerimiento !== null) {
             $cajita= $ultimoRequerimiento+1;
         } else {
            $cajita=1;
        }
        echo "$cajita";
        $registro1->codigo = $cajita;
        $registro1->liga=$liga;
        $registro1->competicion=$competicion;
        $sala=$registro1->registro();

        for ($i=0; $i < count($idequipo); $i++) { 
            $registro = new ValorEquipoData();
            $registro->liga=$liga;
            $registro->equipo= $idequipo[$i];
            $registro->valor= $nuevonuero[$i];
            $registro->sala= $sala[1];
            $registro->competicion= $competicion;
            $registro->registro();
        }
        header("Location: emparejamientos");
    }
}
if ($actions==54) {
    $registro = new SalaPersonalizadaData();
    foreach ($_POST as $k => $v) {
        $registro->$k = $v;
    }
    $registro->actualizar1();
    $_SESSION['success_messagea'] = "Actualizado con éxito.";
    header("Location: actemparejamiento&tid=".$_POST['tid']);
}
if ($actions==55) {
    try {
            $mysqli->begin_transaction();
            $eliminar = SalaPersonalizadaData::verid($_POST["id"]);
            $eliminar->eliminar();
            $mysqli->commit();

            $_SESSION['eliminado'] = "Eliminado con éxito.";
        } catch (mysqli_sql_exception $e) {
            $_SESSION['eliminado'] = "No se puede eliminar este usuario debido a relaciones en otras tablas.";
        }
    header("Location: actemparejamiento&tid=".$_POST['tid']);
}
if ($actions==56) {
    $competicion = $_POST['competicion'];
    $liga = $_POST['liga'];
    $idequipo = $_POST['idequipo_'];
    $nuevonuero = $_POST['nuevonuero_'];
    $sala = $_POST['sala'];
if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] !== UPLOAD_ERR_NO_FILE) {
    // Crear un mapeo de nombre de equipo => id
    $equipoMap = array_combine($nuevonuero, $idequipo);

    // Leer el archivo Excel
    $archivo = $_FILES['archivo']['tmp_name'];
    $spreadsheet = IOFactory::load($archivo);
    $worksheet = $spreadsheet->getActiveSheet();
    $data = $worksheet->toArray();

    // Inicializar variables para el seguimiento de la ronda y el encuentro
    $ronda_actual = null;
    $encuentro = 0;

    // Procesar cada fila del archivo Excel (omitimos la primera fila si tiene cabecera)
    for ($i = 1; $i < count($data); $i++) {
        $row = $data[$i];
        $ronda = $row[0];
        $fecha = date('Y-m-d H:i:s', strtotime($row[1]));
        $equipoA = $row[2];
        $equipoB = $row[3];

        // Obtener id_competidor e id_rival
        $id_competidor = $equipoMap[$equipoA] ?? null;
        $id_rival = $equipoMap[$equipoB] ?? null;

        // Verificar si hemos cambiado de ronda
        if ($ronda_actual !== $ronda) {
            $ronda_actual = $ronda;
            $encuentro = 1; // Reiniciar el contador de encuentros para la nueva ronda
        } else {
            $encuentro++; // Incrementar el contador de encuentros dentro de la misma ronda
        }

        // Registrar en SalaPersonalizadaData
        $registro1 = new SalaPersonalizadaData();
        $registro1->sala = $sala;
        $registro1->ronda = $ronda;
        $registro1->fecha = $fecha;
        $registro1->equipo_competidor = $equipoA;
        $registro1->equipo_rival = $equipoB;
        $registro1->id_competidor = $id_competidor;
        $registro1->id_rival = $id_rival;
        $registro1->encuentro = $encuentro;
        $registro1->registro();
    }

    echo "Datos importados y registrados correctamente.";
    $_SESSION['success_messagea'] = "Registro Exitoso.";
    header("Location: emparejamientos");
    exit;
} else {

    }
    $_SESSION['success_messagea'] = "Sin registrar, falta el archivo.";
    header("Location: emparejamientos");
}
if ($actions==57) {
    $actualizar = new SalaPersonalizadaData();
    $actualizar->observaciona = $_POST['observaciona'];
    $actualizar->firmaa = $_POST['firmaa'];
    $actualizar->id = $_POST['id'];
    if (isset($_FILES["archivo"]) && $_FILES["archivo"]["error"] == 0) {
        $archivo = $_FILES["archivo"]["name"];
        $target_dir = "storage/archivo/";
        $target_file = $target_dir . basename($archivo);
        if (!move_uploaded_file($_FILES["archivo"]["tmp_name"], $target_file)) {
        }
        $actualizar->archivoa = $archivo;
    } else {
        $actualizar->archivoa = $_POST['archivo1'];
    }
    $actualizar->usuario=$_SESSION['conticomtc'];
    $actualizar->actualizara();
    echo json_encode(['status' => 'success']);
    exit();
}
if ($actions == 58) {
    $actualizar = new SalaPersonalizadaData();
    $actualizar->observacionb = $_POST['observacionb'];
    $actualizar->firmab = $_POST['firmab'];
    $actualizar->id = $_POST['id'];
    if (isset($_FILES["archivo"]) && $_FILES["archivo"]["error"] == 0) {
        $archivo = $_FILES["archivo"]["name"];
        $target_dir = "storage/archivo/";
        $target_file = $target_dir . basename($archivo);
        if (!move_uploaded_file($_FILES["archivo"]["tmp_name"], $target_file)) {
        }
        $actualizar->archivob = $archivo;
    } else {
        $actualizar->archivob = $_POST['archivo1'];
    }
    $actualizar->usuario=$_SESSION['conticomtc'];
    $actualizar->actualizarb();
    echo json_encode(['status' => 'success']);
    exit();
}
if ($actions == 59) {
    $actualizar = new SalaPersonalizadaData();
    $actualizar->arbitro = $_POST['arbitro'];
    $actualizar->observacion_arbitro = $_POST['observacion_arbitro'];
    $actualizar->firma_arbitro = $_POST['firma_arbitro'];
    $actualizar->id = $_POST['id'];
    $actualizar->usuario=$_SESSION['conticomtc'];
    $actualizar->actualizarar();
    echo json_encode(['status' => 'success']);
    exit();
}
if ($actions == 60) {
    $actualizar = new SalaPersonalizadaData();
    $actualizar->obervacion_fma = $_POST['obervacion_fma'];
    $actualizar->aprobacion = $_POST['aprobacion'];
    $actualizar->id = $_POST['id'];
    $actualizar->usuario = $_SESSION['conticomtc'];
    $actualizar->actualizarfm();
    echo json_encode(['status' => 'success']);
    exit();
}
if ($actions == 61) {
    $actualizar = new SalaPersonalizadaData();
    $actualizar->puntajea = $_POST['resultado1'];
    $actualizar->id = $_POST['id'];
    $actualizar->puntajea();
    echo json_encode(['status' => 'success']);
    exit();
}
if ($actions == 62) {
    $actualizar = new SalaPersonalizadaData();
    $actualizar->puntajeb = $_POST['resultado1'];
    $actualizar->id = $_POST['id'];
    $actualizar->puntajeb();
    echo json_encode(['status' => 'success']);
    exit();
}
if ($actions==63) {
    $registro = new ActaData();
    $registro->sala_personalizada = $_POST['competencias'];
    $registro->equipo = $_POST['equipo'];
    $registro->jugador = $_POST['jugador'];
    $registro->registro1();
    echo json_encode(['status' => 'success']);
} elseif ($actions == 'updateTable1') {
    $sala_personalizada = $_POST['competencia_id'];
    $equipo_id = $_POST['equipo_id'];
    $datas = ActaData::vercontenidos1($sala_personalizada, $equipo_id);
    $contador1 = 1;
    foreach ($datas as $data) {
        echo '<tr>
            <td>' . $contador1++ . '</td>
            <td>' . $data->equipo . '</td>
            <td>' . $data->jugador . '</td>
            <td>
                <select name="resultado">
                    <option value="">Elegir</option>
                    <option value="1">1</option>
                    <option value="1/2">1/2</option>
                    <option value="0">0</option>
                    <option value="+">+</option>
                    <option value="-">-</option>
                </select>
            </td>
            <td><a class="add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#exampleModalLong">Limpiar</a></td>
        </tr>';
    }
}
if ($actions == 64) {
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] !== UPLOAD_ERR_NO_FILE) {
        $archivo = $_FILES['archivo']['tmp_name'];

        // Registrar en la tabla resultado
        $registro1 = new ResultadoData();
        $registro1->tipo = $_POST['tipo'];
        $registro1->fecha = date("Y-m-d");
        $resul = $registro1->registro();

        // Cargar el archivo Excel
        $spreadsheet = IOFactory::load($archivo);
        $worksheet = $spreadsheet->getActiveSheet();

        // Iniciar contador de filas
        $fila = 0;

        // Iterar sobre las filas
        foreach ($worksheet->getRowIterator() as $row) {
            $fila++;
            
            // Saltar la primera fila (cabecera)
            if ($fila == 1) {
                continue;
            }

            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false); // Permitir iterar todas las celdas, incluso vacías

            $data = [];
            foreach ($cellIterator as $cell) {
                $data[] = $cell->getValue();
            }

            // Asignar los valores desde el Excel
            $registro = new DetalleResultadoData();
            $registro->numero = $data[0];
            $registro->equipo = $data[1];
            $registro->puntos = $data[2];
            $registro->progresivo = $data[3];
            $registro->buchholz_1 = $data[4];
            $registro->buchholz = $data[5];
            $registro->mediano_buchholz = $data[6];
            $registro->olimpico = $data[7];
            $registro->resultado = $resul[1];

            // Registrar en la base de datos
            $registro->registro();
        }
    }
    $_SESSION['success_messagea'] = "Registro Exitoso.";
    header("Location: clasificacions");
}
if ($actions == 65) {
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] !== UPLOAD_ERR_NO_FILE) {
        $archivo = $_FILES['archivo']['tmp_name'];
        $sala = $_POST['sala'];

        // Leer el archivo Excel
        $spreadsheet = IOFactory::load($archivo);
        $worksheet = $spreadsheet->getActiveSheet();
        $data = $worksheet->toArray();

        // Obtener los valores registrados en la base de datos para la sala especificada
        $valoresRegistrados = ValorData::vercontenidos($sala);

        // Crear un mapeo de valor => id_equipo
        $mapaValoresRegistrados = [];
        foreach ($valoresRegistrados as $valor) {
            $mapaValoresRegistrados[$valor->valor] = $valor->equipo;
        }

        // Inicializar variables para el seguimiento de la ronda y el encuentro
        $ronda_actual = null;
        $encuentro = 0;
        // Procesar cada fila del archivo Excel (omitimos la primera fila si tiene cabecera)
        for ($i = 1; $i < count($data); $i++) {
            $row = $data[$i];
            $ronda = $row[0];
            // $fecha = date('Y-m-d', strtotime($row[1]));
            $fecha = date('Y-m-d H:i:s', strtotime($row[1]));
            $equipoA = $row[2];
            $equipoB = $row[3];

            // Verificar si hemos cambiado de ronda
            if ($ronda_actual !== $ronda) {
                $ronda_actual = $ronda;
                $encuentro = 1; // Reiniciar el contador de encuentros para la nueva ronda
            } else {
                $encuentro++; // Incrementar el contador de encuentros dentro de la misma ronda
            }

            // Obtener el id_competidor y id_rival de los valores registrados
            $id_competidor = $mapaValoresRegistrados[$equipoA] ?? null;
            $id_rival = $mapaValoresRegistrados[$equipoB] ?? null;

            // Registrar en SalaPersonalizadaData
            $registro1 = new SalaPersonalizadaData();
            $registro1->sala = $sala;
            $registro1->ronda = $ronda;
            $registro1->encuentro = $encuentro;
            $registro1->fecha = $fecha;
            $registro1->equipo_competidor = $equipoA;
            $registro1->equipo_rival = $equipoB;
            $registro1->id_competidor = $id_competidor;
            $registro1->id_rival = $id_rival;
            $registro1->registro();
        }

        echo "Datos importados y registrados correctamente.";
        header("Location: emparejamientos");
    }
}
if ($actions==66) {
    try {
        $mysqli->begin_transaction();
        $eliminar = EquipoJugadorData::verid($_POST["id"]);
        $eliminar->eliminar();
        $mysqli->commit();

        $_SESSION['eliminado'] = "Eliminado con éxito.";
    } catch (mysqli_sql_exception $e) {
        $_SESSION['eliminado'] = "No se puede eliminar este usuario debido a relaciones en otras tablas.";
    }
    header("Location: participante1&tid=".$_POST['tid']."&td=".$_POST['td']);
} 
if ($actions==67) {
    $registro = new JugadorData();
    foreach ($_POST as $k => $v) {
        if (property_exists($registro, $k)) {
            $registro->$k = $v;
        }
    }
    if (JugadorData::evitarladuplicidad($_POST['numlicencia'], $_POST['id'])) {
        $_SESSION['success_messagea1'] = "El usuario ya existe en otro registro.";
        header("Location: perfil");
        exit;
    }
    if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
        $imagen = $_FILES["imagen"]["name"];
        $target_dir = "storage/archivo/";
        $target_file = $target_dir . basename($imagen);
        if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
        }
        $registro->imagen = $imagen;
    } else {
        $registro->imagen = $_POST['imagen1Campo'];
    }

    if ($_POST['users']) {
        $registro->users=$_POST['users'];
        $registro->actualizarusuario();
    }
    if ($_POST['password']) {
        $registro->password=password_hash($_POST['password'], PASSWORD_DEFAULT);
        $registro->actualizarpassword();
    }
    // $registro->estado = isset($_POST['estado']) && $_POST['estado'] == 'on';

    // $registro->actualizar();
    $_SESSION['success_messagea'] = "Actualizado correctamente.";
    header("Location: perfil");
}
if ($actions==68) {
    $registro = new UserData();
    foreach ($_POST as $k => $v) {
        if (property_exists($registro, $k)) {
            $registro->$k = $v;
        }
    }
    if (UserData::evitarladuplicidad($_POST['ci'], $_POST['id'])) {
        $_SESSION['success_messagea1'] = "El usuario ya existe en otro registro.";
        header("Location: perfil");
        exit;
    }
    if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
        $imagen = $_FILES["imagen"]["name"];
        $target_dir = "storage/archivo/";
        $target_file = $target_dir . basename($imagen);
        if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
        }
        $registro->imagen = $imagen;
    } else {
        $registro->imagen = $_POST['imagen1Campo'];
    }

    if ($_POST['users']) {
        $registro->usuario=$_POST['users'];
        $registro->actualizarusuario();
    }
    if ($_POST['password']) {
        $registro->password=password_hash($_POST['password'], PASSWORD_DEFAULT);
        $registro->actualizarpassword();
    }
    // $registro->estado = isset($_POST['estado']) && $_POST['estado'] == 'on';

    // $registro->actualizar();
    $_SESSION['success_messagea'] = "Actualizado correctamente.";
    header("Location: perfil");
}
?>
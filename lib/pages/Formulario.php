<!DOCTYPE html>
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Si usas el composer
require $_SERVER['DOCUMENT_ROOT'] . '/Videoclub-Online/vendor/autoload.php';

session_start();

require $_SERVER['DOCUMENT_ROOT'] . '/Videoclub-Online/lib/models/UserModel.php';

$users = new UserModel();

//Comprobar que se ha iniciado sesion en la aplicacion
if (!isset($_SESSION['user'])) {
    header("location: ../../index.php");
}

$user = $users->getUsers();

//Comprobar el nivel del usuario
if (isset($user['rol'])) {
    if ($user['rol'] != 0) {
        header("location: ../../index.php");
    }
}

if (isset($_POST['salir'])) {
    session_destroy();
    header("Location: ../../index.php");
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Formulario</title>
        <link rel="stylesheet" href="../css/formulario.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    </head>
    <body>
        <!-- Header -->
        <header class="header d-flex justify-content-between">
            <div class="d-flex me-5">
                <h4 class="title ms-5 me-5 mt-1"><a class="header__link" href="./Info.php">Videoclub Carla</a></h4>
                <a class="header__link" href="#">Formulario</a>
            </div>
            <div class="d-flex justify-content-between me-5">
                <p class="header__text text-white me-5 mt-2">Usuario: <?php echo $_SESSION['user']; ?></p>
                <form method="POST" action="">
                    <button class="btn btn-danger" name="salir" type="submit">Cerrar Sesión</button>
                </form>
            </div>
        </header>
        <!-- Form -->
        <main class="container mt-5">
            <form method="POST" action="" class="form text-white p-3">
                <h1>Envíe su email</h1>
                <div class="mb-3">
                    <label for="exampleName1" class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" id="exampleName1">
                </div>
                <div class="mb-3">
                    <label for="example1" class="form-label">Asunto</label>
                    <input type="text" name="asunto" class="form-control" id="example1">
                </div>
                <div class="mb-3">
                    <label for="example2" class="form-label">Comentario</label>
                    <textarea name="comentario" class="form-control" id="example2"></textarea>
                </div>
                <button class="btn btn-primary" name="enviar" type="submit">Enviar</button>
                    <?php
                    //Crear el objeto de la clase PHPMailer
                    $mail = new PHPMailer(true);
                    if (isset($_POST['enviar'])) {
                        try {
                            $mail->SMTPDebug = 0;
                            $mail->isSMTP();
                            $mail->Host = 'smtp.gmail.com';
                            $mail->SMTPAuth = true;
                            //Dirección de correo desde el que se va a enviar el correo
                            $mail->Username = 'c3670924@gmail.com';
                            $mail->Password = 'ckxcllovcvwsyxxq';
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                            $mail->Port = 465;

                            //Desde donde se va a enviar el correo
                            $mail->setFrom('c3670924@gmail.com');
                            //Persona a la que se le va a enviar el correo
                            $mail->addAddress('c3670924@gmail.com', 'Alias');

                            //Contenido del email
                            $mail->isHTML(true);
                            //Asunto del email
                            $mail->Subject = $_POST['asunto'];
                            //Cuerpo del email
                            $mail->Body = $_POST['comentario'];
                            //Tipo de caracterés
                            $mail->CharSet = 'UTF-8';
                            //Para qie se envie el email
                            $mail->send();

                            //Para comprobar que se ha enviado el email
                            echo '<div class="alert alert-success d-flex align-items-center mt-3" style="height: 50px; width: 100%;" role="alert">
                                    Mensaje enviado
                                  </div>';
                        } catch (Exception $ex) {
                            echo '<div class="alert alert-danger d-flex align-items-center mt-3" role="alert">
                                    Error al enviar el mensaje
                                </div>';
                        }
                    }
                    ?>
                </div>
            </form>
        </main>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    </body>
</html>
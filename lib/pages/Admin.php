<!DOCTYPE html>
<?php
session_start();

require $_SERVER['DOCUMENT_ROOT'] . '/Videoclub-Online/lib/models/UserModel.php';
require $_SERVER['DOCUMENT_ROOT'] . '/Videoclub-Online/lib/models/PeliculasModel.php';

//Objetos de las clases
$user = new UserModel();
$film = new PeliculasModel();

//Comprobar que se ha iniciado sesion en la aplicacion
if (!isset($_SESSION['user'])) {
    header("location: ../../index.php");
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin</title>
        <link rel="stylesheet" href="../css/admin.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    </head>
    <body>
        <!-- Header -->
        <header class="header d-flex justify-content-between">
            <div class="d-flex me-5">
                <h4 class="title ms-5 me-5">Videoclub Carla</h4>
                <form method="POST" action="">
                    <button class="btn btn-primary" name="insert" type="submit">Insertar Película</button>
                </form>
            </div>
            <div class="d-flex justify-content-between me-5">
                <p class="header__text text-white me-5 pt-1">Usuario: <?php echo $_SESSION['user'];?></p>
                <form method="POST" action="">
                    <button class="btn btn-danger" name="salir" type="submit">Cerrar Sesión</button>
                </form>
            </div>
        </header>
        <!-- Container -->
        <div id="container" class="container mt-3 mb-3">
            <?php
            $actorsFilms = $film->getRepartoFilm();
            $film->listarFilms($actorsFilms);
            ?>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    </body>
</html>
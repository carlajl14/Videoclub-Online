<!DOCTYPE html>
<?php
session_start();

require $_SERVER['DOCUMENT_ROOT'] . '/Videoclub-Online/lib/models/UserModel.php';
require $_SERVER['DOCUMENT_ROOT'] . '/Videoclub-Online/lib/models/PeliculasModel.php';
//require $_SERVER['DOCUMENT_ROOT'] . '/Videoclub-Online/lib/models/Peliculas.php';
//Objetos de las clases
$user = new UserModel();
$film = new PeliculasModel();

//Comprobar que se ha iniciado sesion en la aplicacion
if (!isset($_SESSION['user'])) {
    header("location: ../../index.php");
}

//Destruir la sesion al pulsar el boton de cerrar sesión
if (isset($_POST['salir'])) {
    session_destroy();
    header("location: ../../index.php");
}

//Comprobar si se ha pulsado el botón de borrar de la tarjeta
if (isset($_POST['eliminar'])) {
    header("location: ./Admin.php");
}

//Comprobar que se ha pulsado el botón del modal para modificar la película
if (isset($_POST['nuevo'])) {
    header("location: ./Admin.php");
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
                <h4 class="title ms-5 me-5 mt-1">Videoclub Carla</h4>
                <button class="btn btn-primary" name="insert" id="insert" type="submit">Insertar Película</button>
            </div>
            <div class="d-flex justify-content-between me-5">
                <p class="header__text text-white me-5 mt-2">Usuario: <?php echo $_SESSION['user']; ?></p>
                <form method="POST" action="">
                    <button class="btn btn-danger" name="salir" type="submit">Cerrar Sesión</button>
                </form>
            </div>
        </header>
        <?php
        //Modal insert
        $film->modalInsert();

        if (empty($titulo) || empty($genero) || empty($pais) || empty($anyo)) {
            echo '<div class="alert alert-danger d-flex align-items-center mt-3" style="height: 50px; width: 87%; margin-left: 100px" role="alert">
                    Error al insertar la película
                </div>';
        }
        ?>
        <!-- Container -->
        <div id="container" class="container mt-3 mb-3">
            <?php
            //Tarjetas con las películas
            $actorsFilms = $film->getFilms();
            $film->listarFilms($actorsFilms);

            //Comprobar que se ha pulsado el botón de modificar
            if (isset($_POST['modificar'])) {
                echo $_POST['pelicula'];
                //Comprobar si se ha pulsado el botón de enviar del modal
                if (isset($_POST['nuevo'])) {
                    $film->updateFilm($_POST['titulo'], $_POST['genero'], $_POST['pais'], $_POST['anyo'], $_POST['pelicula']);
                    echo $_POST['titulo'], $_POST['pelicula'];
                }
            }
            ?>
        </div>
        <script src="../js/admin.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    </body>
</html>
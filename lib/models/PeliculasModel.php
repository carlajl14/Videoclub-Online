<?php

class PeliculasModel {

    private $db;
    private $pdo;

    public function __construct() {
        $this->db = new DB();
        $this->pdo = $this->db->getPDO();
    }

    /**
     * Obtener todas las peliculas
     * @return type
     */
    public function getFilms() {
        $stmt = $this->pdo->prepare('SELECT * FROM peliculas');
        $stmt->execute();
        $films = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $films;
    }

    /**
     * Obtener el reparto de cada película
     * @return type
     */
    public function getRepartoFilm() {
        $stmt = $this->pdo->prepare('select ac.idPelicula, p.titulo, p.genero, p.pais, p.anyo, p.cartel, ac.idActor, a.nombre, a.apellidos, a.fotografia from peliculas p join actuan ac on(p.id = ac.idPelicula) join actores a on(a.id = ac.idActor)');
        $stmt->execute();
        $actorsFilms = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $actorsFilms;
    }

    public function listarFilms($actorsFilms) {
        $films = ["el_senor_de_los_aneles.jpg", "titanic.jpg", "pulp_fiction.jpg", "la_la_land.jpg", "el_padrino.jpg"];
        $actors = ["elijah_wood.jpg", "kate_winslet.jpg", "john_travolta.jpg", "ryan_gosling.jpg", "marlon_brando.jpg"];
        echo '<h2 class="text-center text-white pt-2">Películas</h2>';
        echo '<div class="d-flex flex-wrap justify-content-evenly p-3">';
        
        foreach ($actorsFilms as $film) {
            echo '<div class="card mb-3 me-3" style="width: 540px">';
            echo '<div class="row g-0">
                        <div class="col-md-5">';
            foreach ($films as $f) {
                if ($f == $film['cartel']) {
                    echo '<img class="image" src="../assets/images/' . $film['cartel'] . '">';
                }
            }
            echo '</div>
                    <div class="card col-md-7">
                        <div class="card-body">
                            <h5 class="card-title">' . $film['titulo'] . '</h5>
                            <p class="card-text"><b>Género: </b>' . $film['genero'] . '</p>
                            <p class="card-text"><b>Estreno: </b>' . $film['pais'] . ', ' . $film['anyo'] . '</p>
                            <div class="d-flex flex-wrap">
                                <form class="me-2" method="POST" action="">
                                    <input type="number" name="pelicula" value="' . $film['idPelicula'] . '" hidden/>
                                    <button type="submit" class="btn btn-primary" name="modificar">Modificar</button>
                                </form>
                                <form class="me-2" method="POST" action="">
                                    <input type="number" name="pelicula" value="' . $film['idPelicula'] . '" hidden/>
                                    <button type="submit" class="btn btn-danger" name="eliminar">Borrar</button>
                                </form> 
                            </div>
                            <h6 class="card-title mt-1">Reparto</h6>';
                                foreach ($actors as $a) {
                                    if ($a == $film['fotografia']) {
                                        echo '<img class = "ima" src = "../assets/images/' . $film['fotografia'] . '">';
                                    }
                                }
                                echo '<p class="card-text">' . $film['nombre'] . ' ' . $film['apellidos'] . '</p>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
        }
        echo '</div>';
    }

    public function listarReparto($id) {
        echo '<div id = "actor" class = "move">
            <div class = "card mb-3 me-3" style = "max-width: 460px;">
            <div class = "row g-0">
            <div class = "col-md-5">';
        foreach ($actors as $a) {
            if ($a == $film['fotografia']) {
                echo '<img class = "image" src = "../assets/images/' . $film['fotografia'] . '">';
            }
        }
        echo '</div>
            <div class = "col-md-7">
            <div class = "card-body">
            <h5 class = "card-title">' . $film['nombre'] . ' ' . $film['apellidos'] . '</h5>
            <button name = "reparto" id = "volver' . $film['idActor'] . '" class = "mt-2 btn btn-primary">Volver</button>
            </div>
            </div>
            </div>
            </div>
            </div>';
    }

}

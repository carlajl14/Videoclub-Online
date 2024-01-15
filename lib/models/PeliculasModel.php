<?php

require $_SERVER['DOCUMENT_ROOT'] . '/Videoclub-Online/lib/models/Peliculas.php';

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

    public function getActors($idFilm) {
        $stmt = $this->pdo->prepare('SELECT a.nombre, a.apellidos, a.fotografia FROM `actores` a join actuan ac on(a.id = ac.idActor) WHERE ac.idPelicula = ?');
        $stmt->bindParam(1, $idFilm);
        $stmt->execute();
        $actors = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $actors;
    }

    /**
     * Crear las tarjetas de las pelícluas con los actores
     * @param type $actorsFilms
     */
    public function listarFilms($actorsFilms) {
        $films = ["el_senor_de_los_aneles.jpg", "titanic.jpg", "pulp_fiction.jpg", "la_la_land.jpg", "el_padrino.jpg"];

        echo '<h2 class="text-center text-white pt-2" id="container">Películas</h2>';
        echo '<div class="d-flex flex-wrap justify-content-evenly">';

        foreach ($actorsFilms as $film) {
            echo '<div class="card mb-3 me-3" style="width: 560px">';
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
                            <p class="card-text"><b>Estreno: </b>' . $film['pais'] . ', ' . $film['anyo'] . '</p>';
            echo '<h6 class="card-title"><b>Reparto</b></h6>';
            echo '<div class="d-flex flex-wrap justify-content-evenly">';
            $actors = $this->getActors($film['id']);
            foreach ($actors as $a) {
                echo '<div>';
                echo '<img class="ima" src = "../assets/images/' . $a['fotografia'] . '">';
                echo '<p class="card-text">' . $a['nombre'] . ' ' . $a['apellidos'] . '</p>';
                echo '</div>';
            }
            echo '</div>';
            echo '<div class="d-flex flex-wrap mt-2">
                                <form class="me-2" method="POST" action="">
                                    <input type="number" name="pelicula" value="' . $film['id'] . '" hidden/>
                                    <button type="submit" class="btn btn-primary" name="modificar" id="modify">Modificar</button>
                                </form>
                                <form class="me-2" method="POST" action="">
                                    <input type="number" name="deletefilm" value="' . $film['id'] . '" hidden/>
                                    <button type="submit" class="btn btn-danger" name="eliminar" id="delete">Borrar</button>
                                </form> 
                            </div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';

        if (isset($_POST['modificar'])) {
            //$film = $_POST['pelicula'];
            $this->modalUpdate();
        }

        if (isset($_POST['eliminar'])) {
            $film = $_POST['deletefilm'];
            $this->deleteActuan($film);
            $this->deleteFilm($film);
        }
    }

    /**
     * Modificar los datos de una película
     * @param type $titulo
     * @param type $genero
     * @param type $pais
     * @param type $anio
     * @param type $nombre
     * @param type $apellidos
     * @param type $idFilm
     * @return type
     */
    public function updateFilm($titulo, $genero, $pais, $anyo, $idFilm) {
        try {
            $stmt = $this->pdo->prepare('UPDATE `peliculas` SET titulo = ?, `genero`=?,`pais`=?,`anyo`=? WHERE id = ?');
            $stmt->bindParam(1, $titulo);
            $stmt->bindParam(2, $genero);
            $stmt->bindParam(3, $pais);
            $stmt->bindParam(4, $anyo);
            $stmt->bindParam(5, $idFilm);
            $stmt->execute();
            if ($stmt->rowCount() == 1) {
                //return $newFilm = $stmt->fetch(PDO::FETCH_ASSOC);
                echo '<div class="alert alert-success d-flex align-items-center mt-3" style="height: 50px; width: 87%; margin-left: 100px" role="alert">
                    Película modificada correctamente</div>';
            } else {
                throw new Exception('<div class="alert alert-danger d-flex align-items-center mt-3" style="height: 50px; width: 87%; margin-left: 100px" role="alert">
                    Error al modificar la película
                  </div>');
            }
        } catch (Exception $e) {
            $e->getMessage();
        }
    }

    /**
     * Formulario para obtener los datos que hay que modificar
     */
    public function modalUpdate() {
        echo '<div id="modal_update" class="modal__update">
                <form method="POST">
                    <p>Datos de la película</p>
                    <div>
                        <label>Titulo</label>
                        <input type="text" name="titulo"/>
                    </div>
                    <div>
                        <label>Género</label>
                        <input type="text" name="genero"/>
                    </div>
                    <div>
                        <label>País</label>
                        <input type="text" name="pais"/>
                    </div>
                    <div>
                        <label>Año</label>
                        <input type="number" name="anyo"/>
                    </div>
                    <button type="submit" name="nuevo" id="nuevo" class="btn btn-primary mt-2">Enviar</button>
                </form>
              </div>';
    }

    /**
     * Eliminar pelicula de la tabla actuan
     * @param type $idFilm
     * @return type
     */
    public function deleteActuan($id) {
        $stmt = $this->pdo->prepare('DELETE FROM actuan where idPelicula = ?');
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    /**
     * Eliminar una película de la tabla peliculas
     * @param type $idFilm
     */
    public function deleteFilm($id) {
        $stmt = $this->pdo->prepare('DELETE FROM peliculas where id = ?');
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    /**
     * Formulario para obtener los datos que hay que eliminar
     */
    public function modalDelete($id) {
        echo '<div id="modal_delete" class="modal__borrar">
                <form action="" method="POST">
                    <p>¿Quieres eliminar esta película?</p>
                    <input type="number" name="deletefilm" value="' . $id . '" hidden/>
                    <button type="submit" name="delete" class="btn btn-primary mt-2 ms-5">Eliminar</button>
                </form>
              </div>';

        if (isset($_POST['delete'])) {
            $this->deleteActuan($id);
            $this->deleteFilm($id);
        }
    }

    /**
     * Insertar una nueva película en la tabla peliculas
     * @param type $titulo
     * @param type $genero
     * @param type $pais
     * @param type $anyo
     */
    public function insertFilm($titulo, $genero, $pais, $anyo) {
        try {
            $stmt = $this->pdo->prepare('INSERT INTO `peliculas`(`titulo`, `genero`, `pais`, `anyo`) VALUES (?,?,?,?)');
            $stmt->bindParam(1, $titulo);
            $stmt->bindParam(2, $genero);
            $stmt->bindParam(3, $pais);
            $stmt->bindParam(4, $anyo);
            $stmt->execute();

            if ($stmt->rowCount() == 1) {
                echo '<div name="alert" class="alert alert-success d-flex align-items-center mt-3" style="height: 50px; width: 87%; margin-left: 100px" role="alert">
                    Película insertada correctamente
                  </div>';
            } else {
                    throw new Exception('<div class="alert alert-danger d-flex align-items-center" role="alert">
                    Error al insertar la película
                </div>');
            }
        } catch (Exception $e) {
            $e->getMessage();
        }
    }

    public function modalInsert() {
        echo '<div id="modal_insert" class="modal__insert">
                <form action="./Admin.php" method="POST">
                    <p>Datos de la película</p>
                    <div>
                        <label>Titulo</label>
                        <input type="text" name="titulo"/>
                    </div>
                    <div>
                        <label>Género</label>
                        <input type="text" name="genero"/>
                    </div>
                    <div>
                        <label>País</label>
                        <input type="text" name="pais"/>
                    </div>
                    <div>
                        <label>Año</label>
                        <input type="number" name="anio"/>
                    </div>
                    <button type="submit" name="insertar" id="enviar" class="btn btn-primary mt-2">Insertar</button>
                </form>
              </div>';

        if (isset($_POST['insertar'])) {
            $insert = [$_POST['titulo'], $_POST['genero'], $_POST['pais'], $_POST['anio']];
            $this->insertFilm($insert[0], $insert[1], $insert[2], $insert[3]);
        }
    }

    /**
     * Mostrar las peliculas
     * @param type $cards
     */
    public function cardsFilms($cards) {
        echo '<h2 class="text-center text-white pt-2">Películas</h2>';
        echo '<div class="wrapper">';
        foreach ($cards as $card) {
            echo '<div class="cards">';
            echo '<div class="poster">';
            echo '<img class="image" src="../assets/images/' . $card['cartel'] . '">';
            echo '<div class="details">';
            echo '<h1 class="title">' . $card['titulo'] . '</h1>';
            echo '<h2 class="anyo">' . $card['anyo'] . '</h2>';
            echo '<div class="tags">';
            echo '<span class="tags">' . $card['pais'] . ' · </span>';
            echo '<span class="tags"> ' . $card['genero'] . '</span>';
            echo '<div class="d-flex flex-wrap justify-content-center">';
            $actors = $this->getActors($card['id']);
            foreach ($actors as $a) {
                echo '<div>';
                echo '<img class="ima" src = "../assets/images/' . $a['fotografia'] . '" alt="peli">';
                echo '</div>';
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
    }

}

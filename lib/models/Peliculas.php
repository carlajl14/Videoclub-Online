<?php

class Peliculas {
    
    //Definición de los atributos
    private $id;
    private $titulo;
    private $genero;
    private $pais;
    private $anyo;
    private $cartel;
    
    //Constructor de la clase
    public function __construct($id, $titulo, $genero, $pais, $anyo) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->genero = $genero;
        $this->pais = $pais;
        $this->anyo = $anyo;
        //$this->cartel = $cartel;
    }

        //Getters and setters
    public function getId() {
        return $this->id;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getGenero() {
        return $this->genero;
    }

    public function getPais() {
        return $this->pais;
    }

    public function getAnyo() {
        return $this->anyo;
    }

    public function getCartel() {
        return $this->cartel;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setTitulo($titulo): void {
        $this->titulo = $titulo;
    }

    public function setGenero($genero): void {
        $this->genero = $genero;
    }

    public function setPais($pais): void {
        $this->pais = $pais;
    }

    public function setAnyo($anyo): void {
        $this->anyo = $anyo;
    }

    public function setCartel($cartel): void {
        $this->cartel = $cartel;
    }
}
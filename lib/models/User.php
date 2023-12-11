<?php

class User{
    
    //Definición de los atributos
    private $id;
    private $username;
    private $password;
    private $rol;
    
    //Constructor de la clase
    public function __construct($id, $username, $password, $rol) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->rol = $rol;
    }

    //Getters and setters
    public function getId() {
        return $this->id;
    }
    
    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getRol() {
        return $this->rol;
    }
    
    public function setId($id): void {
        $this->id = $id;
    }

    public function setUsername($username): void {
        $this->username = $username;
    }

    public function setPassword($password): void {
        $this->password = $password;
    }

    public function setRol($rol): void {
        $this->rol = $rol;
    }
}
<?php

class DB {
    private $pdo;

    public function __construct() {
        require $_SERVER['DOCUMENT_ROOT'].'/Videoclub-Online/lib/Config/config.php';
        
        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $usuario, $pwd);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    public function getPDO() {
        return $this->pdo;
    }
}

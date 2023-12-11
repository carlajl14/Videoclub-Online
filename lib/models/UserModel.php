<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/Videoclub/lib/DB/db.php';

class UserModel {
    
    private $db;
    private $pdo;

    public function __construct() {
        $this->db = new DB();
        $this->pdo = $this->db->getPDO();
    }
    
    /**
     * Función para mostrar un txt con información de cada usuario que inicie sesión o lo intente
     */
    function accesoInformacion() {
        $contenidotxt = "";

        if (file_exists("log.txt")) {
            $contenidotxt = file_get_contents('log.txt');
        }

        if (isset($_POST['username']) && isset($_POST['password'])) {
            $user = $this->inicioSesion($_POST['username'], $_POST['password']);
            if ($user != false) {
                $lastconnection = date("Y / n / j H:i:s");
                $login = "NOMBRE USUARIO: " . $_POST['username'] . ", FECHA: " . $lastconnection . ", VALIDO: SI";
                $file = fopen("log.text", 'w+');
                $login = $contenidotxt . "\nREGISTRO: " . $login;
                fwrite($file, $login);
                fclose($file);

            } else {
                $lastconnection = date("Y / n / j H:i:s");
                $login = "NOMBRE USUARIO: " . $_POST['username'] . ", FECHA: " . $lastconnection . ", VALIDO: NO";
                $file = fopen("log.text", 'w+');
                $login = $contenidotxt . "\nREGISTRO: " . $login;
                fwrite($file, $login);
                fclose($file);
            }
        } else {
            header('Location: index.php');
        }
    }
    
    /**
     * Función para iniciar sesión en la aplicación
     * @param type $user
     * @param type $pass
     */
    public function inicioSesion($user, $pass) {        
        $stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE username = ? and password = sha1(?)');
        $stmt->bindParam(1, $user);
        $stmt->bindParam(2, $pass);
        $stmt->execute();
        
        if($stmt->rowCount() === 1) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            echo '<p style="color:white">Usuario o contraseña incorrectos</p>';
        }
    }
    
    /**
     * Obtener el nombre del usuario y meterlo en una sesión
     * @param type $user
     */
    public function getUser($user) {
        $stmt = $this->pdo->prepare('SELECT * FROM usuarios where username=?');
        $stmt->bindParam(1, $user);
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($usuarios as $user) {
            $_SESSION['user'] = $user['username'];
        }
    }
}
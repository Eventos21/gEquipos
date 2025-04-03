<?php

class Database {
    private static $instance = null;
    private $con;

    private $user = "root";
    private $pass = "";
    private $host = "localhost";
    private $ddbb = "u362265027_chessmaster";

    private function __construct() {
        $this->con = new mysqli($this->host, $this->user, $this->pass, $this->ddbb);

        if ($this->con->connect_error) {
            die("Connection failed: " . $this->con->connect_error); 
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->con;
    }
}

?>

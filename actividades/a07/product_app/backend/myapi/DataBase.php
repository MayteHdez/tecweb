<?php
namespace MyApi;

abstract class DataBase {
    protected $conexion;

    public function __construct($host, $user, $pass, $dbname) {
        $this->conexion = new \mysqli($host, $user, $pass, $dbname);

        if ($this->conexion->connect_error) {
            die("Error de conexión a la base de datos: " . $this->conexion->connect_error);
        }
    }
}



<?php

    //POO

    class ConexionBDEscuela{

        private $conexion;
        private $host = "localhost:3306";
        private $usuario = "eduardo";
        private $password = "Eduardo10";
        private $bd = "BD_Escuela_Web_2026";

        public function __construct(){

            $this->conexion = mysqli_connect($this->host, $this->usuario, $this->password, $this->bd);

            if(!$this->conexion){

            die("Error en la conexion con MYSQL: " . mysqli_connect_error());

            }

        }

        public function getConexion(){

            return $this->conexion;

        }

    }

?>
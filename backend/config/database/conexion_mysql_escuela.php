<?php

    //POO

    class ConexionBDEscuela{

        private $conexion;
        private $host = "bhxfz9yg53hqfc0d6xpd-mysql.services.clever-cloud.com:3306";
        private $usuario = "ugd5muhy0xrqcphp";
        private $password = "aqfzSxYkbnt792oXRCsV";
        private $bd = "bhxfz9yg53hqfc0d6xpd";

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
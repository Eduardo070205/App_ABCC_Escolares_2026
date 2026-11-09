<?php

    // POO

    class ConexionBDEscuela {

        private $conexion;
        private $host = "bhxfz9yg53hqfc0d6xpd-mysql.services.clever-cloud.com"; 
        private $usuario = "ugd5muhy0xrqcphp";
        private $password = "aqfzSxYkbnt792oXRCsV";
        private $bd = "bhxfz9yg53hqfc0d6xpd";
        private $puerto = 3306; 

        public function __construct() {

            
            $this->conexion = mysqli_connect(
                $this->host, 
                $this->usuario, 
                $this->password, 
                $this->bd, 
                $this->puerto
            );

            if (!$this->conexion) {
                die("Error en la conexion con MYSQL: " . mysqli_connect_error());
            }

        }

        public function getConexion() {
            return $this->conexion;
        }

    }

?>
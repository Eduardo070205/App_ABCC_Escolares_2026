<?php

    // POO + PDO

    class ConexionBDEscuela {

        private PDO $conexion;

        public function __construct() {

            $c = require __DIR__ . '/.gitignore';

            $dsn = "mysql:host={$c['host']};port={$c['puerto']};dbname={$c['bd']};charset=utf8mb4";

            $this->conexion = new PDO($dsn, $c['usuario'], $c['password'], [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        }

        public function getConexion(): PDO {
            return $this->conexion;
        }

    }

?>
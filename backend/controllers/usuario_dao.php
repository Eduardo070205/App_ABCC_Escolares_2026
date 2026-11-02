<?php

    require_once __DIR__ . '/../config/database/conexion_mysql_escuela.php';
    require_once __DIR__ . '/../models/usuario_model.php';

    class UsuarioDAO{

        private $conexion;

        public function __construct(){

            $con = new ConexionBDEscuela();

            $this->conexion = $con->getConexion();
           
        }

        //========================= Metodos CRUD =======================

        // ---------------- ALTAS ---------------
        public function agregarUsuario(Usuario $usuario){

            $nombreUsuario = $usuario->getNombreUsuario();
            $contrasena = $usuario->getContrasena();

            $sql = "INSERT INTO usuarios VALUES(sha1('$nombreUsuario'),sha1('$contrasena'))";

            $res = mysqli_query($this->conexion, $sql);

            return $res;

        }

    }

?>
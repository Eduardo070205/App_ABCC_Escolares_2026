<?php

    class Usuario{


        private $nombreUsuario;
        private $contrasena;


        public function __construct($nombreUsuario, $contrasena){
            $this->nombreUsuario = $nombreUsuario;
            $this->contrasena = $contrasena;
 
        }

        public function getNombreUsuario(){
            return $this->nombreUsuario;
        }

        public function setNombreUsuario($nombreUsuario){
            $this->nombreUsuario = $nombreUsuario;
        }

        public function getContrasena(){
            return $this->contrasena;
        }

        public function setContrasena($contrasena){
            $this->contrasena = $contrasena;
        }

    }

?>
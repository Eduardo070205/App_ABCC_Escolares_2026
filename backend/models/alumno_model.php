<?php

    class Alumno implements JsonSerializable{

        private $numControl;
        private $nombre;
        private $primerAp;
        private $segundoAp;
        private $fechaNac;
        private $semestre;
        private $carrera;

        public function __construct($numControl, $nombre, $primerAp, $segundoAp, $fechaNac, $semestre, $carrera){
            $this->numControl = $numControl;
            $this->nombre = $nombre;
            $this->primerAp = $primerAp;
            $this->segundoAp = $segundoAp;
            $this->fechaNac = $fechaNac;
            $this->semestre = $semestre;
            $this->carrera = $carrera;
        }

        public function getNumControl(){
            return $this->numControl;
        }

        public function setNumControl($numControl){
            $this->numControl = $numControl;
        }

        public function getNombre(){
            return $this->nombre;
        }

        public function setNombre($nombre){
            $this->nombre = $nombre;
        }

        public function getPrimerAp(){
            return $this->primerAp;
        }

        public function setPrimerAp($primerAp){
            $this->primerAp = $primerAp;
        }

        public function getSegundoAp(){
            return $this->segundoAp;
        }

        public function setSegundoAp($segundoAp){
            $this->segundoAp = $segundoAp;
        }

        public function getFechaNac(){
            return $this->fechaNac;
        }

        public function setFechaNac($fechaNac){
            $this->fechaNac = $fechaNac;
        }

        public function getSemestre(){
            return $this->semestre;
        }

        public function setSemestre($semestre){
            $this->semestre = $semestre;
        }

        public function getCarrera(){
            return $this->carrera;
        }

        public function setCarrera($carrera){
            $this->carrera = $carrera;
        }

        public function jsonSerialize(): array{
        return [
            'numControl' => $this->numControl,
            'nombre'     => $this->nombre,
            'primerAp'   => $this->primerAp,
            'segundoAp'  => $this->segundoAp,
            'fechaNac'   => $this->fechaNac,
            'semestre'   => $this->semestre,
            'carrera'    => $this->carrera,
        ];
    }

    }

?>

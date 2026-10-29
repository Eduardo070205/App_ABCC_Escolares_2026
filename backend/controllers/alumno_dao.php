<?php

    require_once __DIR__ . '/../config/database/conexion_mysql_escuela.php';

    //$conexion = new ConexionBDEscuela();

    //$con = $conexion->getConexion();

    //var_dump($con)


    class AlumnoDAO{

        private $conexion;

        public function __construct(){

            $con = new ConexionBDEscuela();

            $this->conexion = $con->getConexion();
           
        }

        //========================= Metodos CRUD =======================

        // ---------------- ALTAS ---------------
        public function agregarAlumno($nc, $nombre, $primerAp, $segundoAP, $fechaNac, $semenstre, $carrera){

            $sql = "INSERT INTO alumnos VALUES('$nc','$nombre','$primerAp','$segundoAP','$fechaNac','$semenstre','$carrera')";

            $res = mysqli_query($this->conexion, $sql);

            return $res;

        }

        // ----------------- BAJAS -------------------------------


                
        public function eliminarAlumno($nc){

            $sql = "DELETE FROM alumnos WHERE numControl = '$nc'";

            $res = mysqli_query($this->conexion, $sql);

            return $res;

        }

        // ---------------------- CAMBIOS ------------------------

        public function actualizarAlumno($nc, $nombre, $primerAp, $segundoAp, $fechaNac, $semestre, $carrera){
            $sql = "UPDATE alumnos 
                    SET nombre = '$nombre', 
                        primerAp = '$primerAp', 
                        segundoAp = '$segundoAp', 
                        fechaNac = '$fechaNac', 
                        semestre = '$semestre', 
                        carrera = '$carrera' 
                    WHERE numControl = '$nc'";

            $res = mysqli_query($this->conexion, $sql);
            return $res;
        }

        // -------------------- CONSULTAS ----------------

        public function consultarAlumno(){

            $sql = "SELECT numControl, nombre, primerAp, segundoAp FROM alumnos";

            $res = mysqli_query($this->conexion, $sql);

            return $res;

        }

        
        public function consultarAlumnoNC($nc){

            $sql = "SELECT * FROM alumnos WHERE numControl = ". $nc;

            $res = mysqli_query($this->conexion, $sql);

            return $res;

        }


    }

?>
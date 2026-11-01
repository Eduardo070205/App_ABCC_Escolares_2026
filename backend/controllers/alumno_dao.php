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

        public function consultarAlumnosBusqueda($criterio, $valor){

            // Solo se permiten columnas conocidas; el valor se envia por separado.
            $campos = [
                'control' => 'numControl', 'nombre' => 'nombre',
                'apellido1' => 'primerAp', 'apellido2' => 'segundoAp',
                'anio' => 'YEAR(fechaNac)', 'semestre' => 'semestre',
                'carrera' => 'carrera'
            ];
            if (!isset($campos[$criterio])) {
                return false;
            }
            $campo = $campos[$criterio];
            if (in_array($criterio, ['control', 'nombre', 'apellido1', 'apellido2'], true)) {
                $condicion = "LOCATE(?, $campo) > 0";
            } else {
                $condicion = "$campo = ?";
            }
            $sql = "SELECT numControl, nombre, primerAp, segundoAp, fechaNac, semestre, carrera FROM alumnos WHERE $condicion";
            $consulta = mysqli_prepare($this->conexion, $sql);
            mysqli_stmt_bind_param($consulta, 's', $valor);
            mysqli_stmt_execute($consulta);
            $res = mysqli_stmt_get_result($consulta);
            mysqli_stmt_close($consulta);

            return $res;

        }

        
        public function consultarAlumnoNC($nc){

            $sql = "SELECT * FROM alumnos WHERE numControl = ". $nc;

            $res = mysqli_query($this->conexion, $sql);

            return $res;

        }


    }

?>

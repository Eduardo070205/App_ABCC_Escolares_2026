<?php

    require_once __DIR__ . '/../config/database/conexion_mysql_escuela.php';
    require_once __DIR__ . '/../models/alumno_model.php';

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
        public function agregarAlumno(Alumno $alumno){

            $nc = $alumno->getNumControl();
            $nombre = $alumno->getNombre();
            $primerAp = $alumno->getPrimerAp();
            $segundoAP = $alumno->getSegundoAp();
            $fechaNac = $alumno->getFechaNac();
            $semenstre = $alumno->getSemestre();
            $carrera = $alumno->getCarrera();

            $sql = "INSERT INTO alumnos (numControl,nombre,primerAp,segundoAp,fechaNac,semestre,carrera) VALUES (?,?,?,?,?,?,?)";

            $stmt = $this->conexion->prepare($sql);
            $res = $stmt->execute([$nc,$nombre,$primerAp,$segundoAP,$fechaNac,$semenstre,$carrera]);

            return $res;

        }

        // ----------------- BAJAS -------------------------------


                
        public function eliminarAlumno($nc){

            $sql = "DELETE FROM alumnos WHERE numControl = ?";

            $stmt = $this->conexion->prepare($sql);
            $res = $stmt->execute([$nc]);

            return $res;

        }

        // ---------------------- CAMBIOS ------------------------

        public function actualizarAlumno(Alumno $alumno){

            $nc = $alumno->getNumControl();
            $nombre = $alumno->getNombre();
            $primerAp = $alumno->getPrimerAp();
            $segundoAp = $alumno->getSegundoAp();
            $fechaNac = $alumno->getFechaNac();
            $semestre = $alumno->getSemestre();
            $carrera = $alumno->getCarrera();
            $sql = 'UPDATE alumnos SET nombre = ?, primerAp = ?, segundoAp = ?, fechaNac = ?, semestre = ?, carrera = ? WHERE numControl = ?';
            $stmt = $this->conexion->prepare($sql);
            return $stmt->execute([$nombre,$primerAp,$segundoAp,$fechaNac,$semestre,$carrera,$nc]);
        }

        // -------------------- CONSULTAS ----------------

        public function consultarAlumno(){

            $sql = "SELECT numControl, nombre, primerAp, segundoAp FROM alumnos";

            $res = $this->conexion->query($sql)->fetchAll();

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
            $consulta = $this->conexion->prepare($sql);
            $consulta->execute([$valor]);
            $res = $consulta->fetchAll();

            return $res;

        }

        
        public function consultarAlumnoNC($nc){

            $sql = "SELECT * FROM alumnos WHERE numControl = ?";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$nc]);
            $res = $stmt->fetch();

            return $res;

        }


    }

?>

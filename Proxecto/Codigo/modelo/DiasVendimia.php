<?php 
require_once ("ConexionBD.php");

class DiasVendimia{
    private $dni;
    private $fecha;
    private $cajas;
    private $conexionBD;




    public function __construct(){
        $this->conexionBD = new ConexionBD();

        //Array con los parámetros enviados a la función
		$params = func_get_args();

		//Número de parámetros que estoy recibiendo
		$numeroParametros = func_num_args();

        switch($numeroParametros){
            case 3:
                call_user_func_array(array($this, "iniciarAtributos"),$params);
                break;
        }
    }
    


    /**
     * Método que inicia los atributos de la clase
     * 
     * @param String $dni
     * @param DATE $fecha
     * @param INT $cajas
     * @return void
     */
    private function iniciarAtributos($dni, $fecha, $cajas){
        $this->dni = $dni;
        $this->fecha = $fecha;
        $this->cajas = $cajas;
    }



    /**
     * Método que almacena los datos de la vendimia
     *
     * @return INT|String Número de registros guardados
     */
    public function guardarDiasVendimia(){
        try {
            if (!$this->existeDiaVendimia()){
                $sql = "insert into dias_vendimia (fecha, usuario, cajas) values (:fecha, :usuario, :cajas)";
                $sentencia = $this->conexionBD-> prepare($sql);
                $sentencia->bindValue(':fecha', $this->fecha);
                $sentencia->bindValue(':usuario', $this->dni);
                $sentencia->bindValue(':cajas', $this->cajas);
                $sentencia->execute();

                return $sentencia->rowCount();
            } else {
                return "El usuario ya tiene el día de vendimia asignado";
            }

        } catch (PDOException $error) {
            echo "Hubo un error al guardar los datos de la vendimia: $error";
        }
    }



    /**
     * Función que actualiza los datos de un día de vendimia
     *
     * @param INT $id ID del registro del día de la vendimia
     * @return INT Número de registros actualizados
     */
    public function actualizarDiasVendimia($id){
        try {
            if ($this->existeDiaVendimia()){
                $sql = "update dias_vendimia set fecha = :fecha, usuario = :usuario, cajas = :cajas where id = :id";
                $sentencia = $this->conexionBD-> prepare($sql);
                $sentencia->bindValue(':fecha', $this->fecha);
                $sentencia->bindValue(':usuario', $this->dni);
                $sentencia->bindValue(':cajas', $this->cajas);
                $sentencia->bindValue(':id', $id);
                $sentencia->execute();

                return $sentencia->rowCount();

            } else {
                return "El usuario no tiene ese día de vendimia asignado";
            }

        } catch (PDOException $error) {
            echo "Hubo un error al actualizr los datos de la vendimia: $error";
        }
    }


    /**
     * FUnción que comprueba si un usuario tiene un día determinado asignado
     *
     * @return void
     */
    private function existeDiaVendimia(){
        try {
            $sql = "select * from dias_vendimia where usuario = :usuario  and fecha = :fecha";
            $sentencia = $this->conexionBD-> prepare($sql);
            $sentencia->bindValue(':usuario', $this->dni);
            $sentencia->bindValue(':fecha', $this->fecha);
            $sentencia->execute();

            return ($sentencia->rowCount() > 0) ? true : false;

        } catch (PDOException $error) {
            echo "Hubo un error al consultar el día de la vendimia: $error";
        }
    }


    /**
     * Método que obtiene los días de vendimia de un usuario
     *
     * @param String $tipoDatos fechas|cajas|todos tipo de datos a devolver
     * @param String $dni DNI del usuario a consultar
     * @return Array
     */
    public function obtenerDatosDiasVendimia($tipoDatos, $dni, $ano){
        try{ 
            switch($tipoDatos){
                case "fechas":
                    $sql = "select fecha from dias_vendimia where usuario = :usuario and year(fecha) = :ano";
                    break;

                case "cajas":
                    $sql = "select cajas from dias_vendimia where usuario = :usuario and year(fecha) = :ano";
                    break;

                case "todos":
                    $sql = "select * from dias_vendimia where usuario = :usuario and year(fecha) = :ano order by fecha";
                    break;
            }
            
            $sentencia = $this->conexionBD->prepare($sql);
            $sentencia->bindValue(':usuario', $dni);
            $sentencia->bindValue(':ano', $ano);
            $sentencia->execute();

            return $sentencia->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $error){
            echo "Error al consultar los datos de la vendimia del usuario: $error";
        }
    }


    /**
     * Función que obtiene los datos de un día de vendimia en concreto
     *
     * @param INT $id ID del día de la vendimia
     * @return void
     */
    public function obtenerDiaVendimia($id){
        try{ 
            $sql = "select * from dias_vendimia where id = :id";
            $sentencia = $this->conexionBD->prepare($sql);
            $sentencia->bindValue(':id', $id);
            $sentencia->execute();

            return $sentencia->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $error){
            echo "Error al consultar los datos de un día de vendimia: $error";
        }
    }


    /**
     * Función que obtiene el día de inicio o de fin de la vendimia de un año en concreto
     *
     * @param $inicioFin inicio | fin para indicar la fecha a devolver
     * @param String $ano
     * @return Array
     */
    public function obtenerInicioFinVendimia($inicioFin, $ano){
        try{ 
            $sql = ($inicioFin == "inicio") ? "select fecha from dias_vendimia where year(fecha) = :ano order by fecha asc limit 1" : "select fecha from dias_vendimia where year(fecha) = :ano order by fecha desc limit 1";
            $sentencia = $this->conexionBD->prepare($sql);
            $sentencia->bindValue(':ano', $ano);
            $sentencia->execute();

            return cambiarFormatoFecha($sentencia->fetchAll(PDO::FETCH_ASSOC));
            
        } catch (PDOException $error){
            echo "Error al consultar los días de vendimia del usuario: $error";
        }
    }



    /**
     * Función que borra un día de vendimia
     *
     * @param INT $id ID del día de la vendimia
     * @return INT Número de registros borrados
     */
    public function borrarDiasVendimia($id){
        try {
            $sql = "delete from dias_vendimia where id = :id";
    
            $sentencia = $this->conexionBD->prepare($sql);
            $sentencia->bindValue('id', $id);
            $sentencia->execute();

            return $sentencia->rowCount();

        } catch (PDOException $error) {
            die("Hubo un error al borrar el día de vendimia del usuairo: $error");
        }
    }



    /**
     * Función que borra los días de vendimia de un usuario
     *
     * @param String $dni DNI del usuario
     * @return Boolean
     */
    public function borrarDiasVendimiaUsuario($dni){
        try {
            $sql = "delete from dias_vendimia where usuario = :dni";
    
            $sentencia = $this->conexionBD->prepare($sql);
            $sentencia->bindValue('dni', $dni);
            return $sentencia->execute();

        } catch (PDOException $error) {
            die("Hubo un error al borrar los días de vendimia del usuairo: $error");
        }
    }



    //-------------------- Getters y Setters
    /**
     * Get the value of dni
     */
    public function getDni() {
        return $this->dni;
    }

    /**
     * Set the value of dni
     */
    public function setDni($dni): self {
        $this->dni = $dni;

        return $this;
    }

    /**
     * Get the value of fecha
     */
    public function getFecha() {
        return $this->fecha;
    }

    /**
     * Set the value of fecha
     */
    public function setFecha($fecha): self {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get the value of cajas
     */
    public function getCajas() {
        return $this->cajas;
    }

    /**
     * Set the value of cajas
     */
    public function setCajas($cajas): self {
        $this->cajas = $cajas;

        return $this;
    }
}



?>
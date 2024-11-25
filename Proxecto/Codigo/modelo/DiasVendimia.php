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
     * @return String
     */
    public function guardarDiasVendimia(){
        try {
            $sql = "insert into dias_vendimia (fecha, usuario, cajas) values (:fecha, :usuario, :cajas)";
            $sentencia = $this->conexionBD-> prepare($sql);
            $sentencia->bindValue(':fecha', $this->fecha);
            $sentencia->bindValue(':usuario', $this->dni);
            $sentencia->bindValue(':cajas', $this->cajas);
            $sentencia->execute();

            if ($sentencia->rowCount() == 1) echo "Datos de la vendimia guardados";

        } catch (PDOException $error) {
            echo "Hubo un error al guardar los datos de la vendimia: $error";
        }
    }



    /**
     * Método que obtiene los días de vendimia de un usuario
     *
     * @param String $dni
     * @return Array
     */
    public function obtenerDiasVendimia($dni){
        try{ 
            $anoActual = date("Y");
            $sql = "select fecha from dias_vendimia where usuario = :usuario and fecha <= :anoActual'-12-31' and fecha >= :anoActual'-01-01'";
            $sentencia = $this->conexionBD->prepare($sql);
            $sentencia->bindValue(':usuario', $dni);
            $sentencia->bindValue(':anoActual', $anoActual);
            $sentencia->execute();

            return $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $error){
            echo "Error al consultar los días de vendimia del usuario: $error";
        }
    }



    /**
     * Método que obtiene el número de cajas de la vendimia del usuario
     *
     * @param String $dni
     * @return Array
     */
    public function obtenerCajasVendimia($dni){
        try{ 
            $anoActual = date("Y");
            $sql = "select cajas from dias_vendimia where usuario = :usuario and fecha <= :anoActual'-12-31' and fecha >= :anoActual'-01-01'";
            $sentencia = $this->conexionBD->prepare($sql);
            $sentencia->bindValue(':usuario', $dni);
            $sentencia->bindValue(':anoActual', $anoActual);
            $sentencia->execute();

            return $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $error){
            echo "Error al consultar los días de vendimia del usuario: $error";
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
<?php 
require_once "../modelo/IngresosFacturas.php";

class Facturas extends IngresosFacturas{
    private $numeroFactura;
    private $dni;
    private $concepto;
    private $fecha;
    private $baseImponible;
    private $iva;
    private $total;
    private $archivo;
    private $pagada;



    public function __construct(){
        parent::__construct();

        //Array con los parámetros enviados a la función
		$params = func_get_args();

		//Número de parámetros que estoy recibiendo
		$numeroParametros = func_num_args();

        switch($numeroParametros){
            case 1: 
                call_user_func_array(array($this, "iniciarUsuario"),$params);
                break;

            case 8:
                call_user_func_array(array($this, "iniciarAtributos"),$params);
                break;
        }
    }
    


    /**
     * Método que inicia los atributos de la clase
     * 
     * @param String $numeroFactura
     * @param String $dni
     * @param String $concepto
     * @param Date $fecha
     * @param Float $baseImponible
     * @param Float $iva
     * @param Float $total
     * @param Boolean $pagada
     * @return void
     */
    private function iniciarAtributos($numeroFactura, $dni, $concepto, $fecha, $baseImponible, $iva, $total, $pagada){
        $this->numeroFactura = $numeroFactura;
        $this->dni = $dni;
        $this->concepto = $concepto;
        $this->fecha = $fecha;
        $this->baseImponible = $baseImponible;
        $this->iva = $iva;
        $this->total = $total;
        $this->pagada = $pagada;
    }



    /**
     * Método que iniciar el atributo dni
     *
     * @param String $dni
     * @return void
     */
    private function iniciarUsuario($dni){
        $this->dni = $dni;
    }



    /**
     * Método que almacena una factura en la base de datos
     *
     * @return String
     */
    public function guardarFactura(){
        try {
            if (!$this->existeFactura()){
                if (subirPDF($this->archivo, $this->numeroFactura)){
                    $sql = "insert into facturas (numero_factura, usuario, concepto, fecha, base_imponible, iva, total, pagada, archivo) values (:numeroFactura, :dni, :concepto, :fecha, :baseImponible, :iva, :total, :pagada, :archivo)";
                    
                    $sentencia = $this->conexionBD->prepare($sql);
                    $sentencia->bindValue(':numeroFactura', $this->numeroFactura);
                    $sentencia->bindValue(':dni', $this->dni);
                    $sentencia->bindValue(':concepto', $this->concepto);
                    $sentencia->bindValue(':fecha', $this->fecha);
                    $sentencia->bindValue(':baseImponible', $this->baseImponible);
                    $sentencia->bindValue(':iva', $this->iva);
                    $sentencia->bindValue(':total', $this->total);
                    $sentencia->bindValue(':pagada', $this->pagada);

                    $nombreArchivo = str_replace( "/", "_", $this->numeroFactura) . ".pdf";
                    $sentencia->bindValue(':archivo', $nombreArchivo); 

                    $sentencia->execute();

                    return ($sentencia->rowCount());

                } else {
                    return "Error al subir el archivo de la factura";
                }

            } else {
                return "La factura ya existe en la base de datos";
            }

        } catch (PDOException $error) {
            die("Hubo un error al guardar la factura: $error");
        }
    }



    /**
     * Función que comprueba si una factura existe en la base de datos
     *
     * @return Boolean
     */
    private function existeFactura(){
        try {

            $sql = "select * from facturas where numero_factura = :numeroFactura";
            
            $sentencia = $this->conexionBD->prepare($sql);
            $sentencia->bindValue(':numeroFactura', $this->numeroFactura);
            $sentencia->execute();

            return ($sentencia->rowCount()) == 1 ? true : false;

        } catch (PDOException $error) {
            die("Hubo un error al guardar la factura: $error");
        }
    }



    /**
     * Método que calcula el número de la factura
     *
     * @return String
     */
    public function calcularNumeroFactura(){
        $numeroUltimaFactura = "";
        $plantilla = "F" . date("Y") . "/";

        //Número factura: F2024/xx
        $numeroFactura = (intval(substr($this->obtenerNumeroUltimaFactura(), 6)));

        if ($numeroFactura != null){
            if ($numeroFactura < 9){
                $numeroUltimaFactura = $plantilla . "0" . ($numeroFactura + 1);
            
            } else {
                $numeroUltimaFactura = $plantilla . $numeroFactura + 1;
            }
            
        } else {
            $numeroUltimaFactura = $plantilla . "01";
        }

        return $numeroUltimaFactura;
    }



    /**
     * Método que obtiene el id de la última factura
     *
     * @return String
     */
    private function obtenerNumeroUltimaFactura(){
        try {
            $sql = "select numero_factura from facturas order by numero_factura desc limit 1";
            $sentencia = $this->conexionBD->query($sql);
            $sentencia->execute();

            if ($sentencia->rowCount() == 1){
                foreach ($sentencia->fetch(PDO::FETCH_ASSOC) as $numeroFactura){
                    return $numeroFactura;
                }
            }

        } catch (PDOException $error) {
            die("Hubo un error al obtener el número de la última factura: $error");
        }
    }



    /**
     * Método que obtiene la lista de facturas impagadas totales o por usuarios
     *
     * @param String $cantidadDatos usuario | todos
     * @param String $usuario dni del usuario
     * @return Array
     */
    public function obtenerFacturasImpagadas($cantidadDatos, $usuario){
        try {
            switch($cantidadDatos){
                case "usuario":
                    $sql = "select * from facturas where usuario = :dni and pagada = false";
                    $sentencia = $this->conexionBD->prepare($sql);
                    $sentencia->bindValue(':dni', $usuario);
                    break;

                case "todos":
                    $sql = "select * from facturas where pagada = false";
                    $sentencia = $this->conexionBD->query($sql);
                    break;
            }
            
            $sentencia->execute();

            return $sentencia->fetchAll(PDO::FETCH_ASSOC);

            

        } catch (PDOException $error) {
            die("Hubo un error al obtener la deuda: $error");
        }
    }



    /**
     * Método que devuelve la suma del total de facturas impagadas 
     *
     * @param Array $listaFacturas lista de facturas impagadas
     * @param Boolean $formato Indica si queremos devolver el número con formato español
     * @return Float|String
     */
    public function obtenerTotalDeuda($listaFacturas, $formato){
        $deuda = 0;

        foreach ($listaFacturas as $cantidad){
            $deuda += $cantidad['total'];
        }

        return ($formato) ? number_format($deuda , 2, '\'', '.') : $deuda;
    }



    /**
     * Método que obtiene todas las facturas o las facturas de un usuario
     * 
     * @param String $cantidad todos|todosAno|todosIndividual|individualAno
     * @param String $ano
     * @param DATE $ano
     *
     * @return Array
     */
    public function obtenerHistoricoFacturas($cantidad, $dni, $ano){
        try {
            switch($cantidad){
                case "todos":
                    $sql = "select * from facturas";
                    $sentencia = $this->conexionBD->query($sql);
                    break;

                case "todosAno":
                    $sql = "select * from facturas where year(fecha) = :ano";

                    $sentencia = $this->conexionBD->prepare($sql);
                    $sentencia->bindValue(':ano', $ano);
                    break;

                case "todosIndividual":
                    $sql = "select * from facturas where usuario = :dni";

                    $sentencia = $this->conexionBD->prepare($sql);
                    $sentencia->bindValue(':dni', $dni);
                    break;

                case "individualAno":
                    $sql = "select * from facturas where usuario = :dni and year(fecha) = :ano order by numero_factura desc";

                    $sentencia = $this->conexionBD->prepare($sql);
                    $sentencia->bindValue(':dni', $dni);
                    $sentencia->bindValue(':ano', $ano);
                    break;
            }

            $sentencia->execute();

            return $sentencia->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $error) {
            die("Hubo un error al obtener las facturas del usuario: $error");
        }
    }



    /**
     * Método que obtiene los datos de una factura en concreto
     *
     * @param String $numeroFactura
     * @return Array
     */
    public function obtenerDatosFactura($numeroFactura){
        try {
            $sql = "select nombre, apellidos, f.* 
            from facturas f 
            INNER JOIN usuarios u
            ON f.usuario = u.dni
            where numero_factura = :numeroFactura";
            
            $sentencia = $this->conexionBD->prepare($sql);
            $sentencia->bindValue(':numeroFactura', $numeroFactura);
            $sentencia->execute();

            return $sentencia->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $error) {
            die("Hubo un error al obtener la factura: $error");
        }
    }



    /**
     * Método que actualiza los datos de una factura
     *
     * @return void
     */
    public function actualizarFactura() {
        try {
            if ($this->existeFactura()){
                if ($this->archivo = ""){
                    $sql = "update facturas set usuario = :usuario, fecha = :fecha, concepto = :concepto, base_imponible = :baseImponible, iva = :iva, total = :total, pagada = :pagada where numero_factura = :numeroFactura";
                } else {
                    $sql = "update facturas set usuario = :usuario, fecha = :fecha, concepto = :concepto, base_imponible = :baseImponible, iva = :iva, total = :total, pagada = :pagada, archivo = :archivo where numero_factura = :numeroFactura";
                }

                $sentencia = $this->conexionBD->prepare($sql);
                $sentencia->bindValue(':usuario', $this->dni);
                $sentencia->bindValue(':fecha', $this->fecha);
                $sentencia->bindValue(':concepto', $this->concepto);
                $sentencia->bindValue(':baseImponible', $this->baseImponible);
                $sentencia->bindValue(':iva', $this->iva);
                $sentencia->bindValue(':total', $this->total);
                $sentencia->bindValue(':pagada', $this->pagada);
                $sentencia->bindValue(':numeroFactura', $this->numeroFactura);
                $sentencia->execute();

                return $sentencia->rowCount();

            } else {
                return 2;
            }

        } catch (PDOException $error) {
            die("Hubo un error al obtener la factura: $error");
        }
    }



    /**
     * Método que elimina una factura
     *
     * @param INT $id
     * @return INT Número de registros borrados
     */
    public function borrarFactura($numeroFactura){
        try {
            $sql = "delete from facturas where numero_factura = :numeroFactura";
            $sentencia = $this->conexionBD->prepare($sql);
            $sentencia->bindValue(':numeroFactura', $numeroFactura);
            $sentencia->execute();

            return $sentencia->rowCount();

        } catch (PDOException $error) {
            die("Hubo un error al borrar la factura: $error");
        }
    }



    /**
     * Método que devuelve la suma de todas las facturas agrupados por años de un usuario
     *
     * @param String $dni
     * @return void
     */
    public function obtenerGastosUsuario($dni){
        try {
            $sql = "select year(fecha) as ano, sum(total) as total
                from facturas where usuario = :dni
                group by ano
                order by ano;";
            $sentencia = $this->conexionBD->prepare($sql);
            $sentencia->bindValue(':dni', $dni);
            $sentencia->execute();

            return $sentencia->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $error) {
            die("Hubo un error al obtener los gastos de un usuario por año: $error");
        }
    }




    //-------------------- Getters y Setters
    /**
     * Get the value of numeroFactura
     */
    public function getNumeroFactura() {
        return $this->numeroFactura;
    }

    /**
     * Set the value of numeroFactura
     */
    public function setNumeroFactura($numeroFactura): self {
        $this->numeroFactura = $numeroFactura;

        return $this;
    }

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
     * Get the value of concepto
     */
    public function getConcepto() {
        return $this->concepto;
    }

    /**
     * Set the value of concepto
     */
    public function setConcepto($concepto): self {
        $this->concepto = $concepto;

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
     * Get the value of baseImponible
     */
    public function getBaseImponible() {
        return $this->baseImponible;
    }

    /**
     * Set the value of baseImponible
     */
    public function setBaseImponible($baseImponible): self {
        $this->baseImponible = $baseImponible;

        return $this;
    }

    /**
     * Get the value of iva
     */
    public function getIva() {
        return $this->iva;
    }

    /**
     * Set the value of iva
     */
    public function setIva($iva): self {
        $this->iva = $iva;

        return $this;
    }

    /**
     * Get the value of total
     */
    public function getTotal() {
        return $this->total;
    }

    /**
     * Set the value of total
     */
    public function setTotal($total): self {
        $this->total = $total;

        return $this;
    }

    /**
     * Get the value of archivo
     */
    public function getArchivo() {
        return $this->archivo;
    }

    /**
     * Set the value of archivo
     */
    public function setArchivo($archivo): self {
        $this->archivo = $archivo;

        return $this;
    }

    /**
     * Get the value of pagada
     */
    public function getPagada() {
        return $this->pagada;
    }

    /**
     * Set the value of pagada
     */
    public function setPagada($pagada): self {
        $this->pagada = $pagada;

        return $this;
    }
}
?>
<?php 
require_once "../modelo/IngresosFacturas.php";
require_once "../modelo/Recolecta.php";

class Ingresos extends IngresosFacturas{
    private $numeroIngreso;
    private $dni;
    private $fecha;
    private $concepto;
    private $ingresoBruto;
    private $retencion;
    private $porcentaje;
    private $total;
    private $estado;
    private $archivo;



    public function __construct(){ 
        parent::__construct();

        //Array con los parámetros enviados a la función
		$parametros = func_get_args();

		//Número de parámetros que estoy recibiendo
		$numeroParametros = func_num_args();

        switch($numeroParametros){
            case 1: //DNI
                call_user_func_array(array($this, "iniciarUsuario"),$parametros);
                break;

            case 9:
                call_user_func_array(array($this, "establecerEstado"), $parametros);
        }
    }
    

    /**
     * Método que inicia el atributo dni
     * @param String $dni
     * 
     * @return void
     */
    private function iniciarUsuario($dni){
        $this->dni = $dni;
    }



    /**
     * Método que establece el estado de los atributos
     *
     * @param String $numeroIngreso
     * @param String $dni
     * @param DATE $fecha
     * @param String $concepto
     * @param Float $ingresoBruto
     * @param Float $retencion
     * @param Float $porcentaje
     * @param Float $total
     * @param Boolean $estado
     * @return void
     */
    private function establecerEstado($numeroIngreso, $dni, $fecha, $concepto, $ingresoBruto, $retencion, $porcentaje, $total, $estado){
        $this->numeroIngreso = $numeroIngreso;
        $this->dni = $dni;
        $this->fecha = $fecha;
        $this->concepto = $concepto;
        $this->ingresoBruto = $ingresoBruto;
        $this->retencion = $retencion;
        $this->porcentaje = $porcentaje;
        $this->total = $total;
        $this->estado = $estado;
    }



    /**
     * Método que almacena un ingreso en la base de datos
     *
     * @return INT
     */
    public function guardarIngreso(){
        try{
            if (!$this->existeIngreso()){
                if (subirPDF($this->archivo, $this->numeroIngreso)){
                    $sql = "insert into ingresos (numero_ingreso, fecha, concepto, ingreso_bruto, retencion, porcentaje_retencion, total, estado, usuario, archivo) values (:numeroIngreso, :fecha, :concepto, :ingresoBruto, :retencion, :porcentaje, :total, :estado, :usuario, :archivo)";

                    $sentencia = $this->conexionBD->prepare($sql);
                    $sentencia->bindValue(':numeroIngreso', $this->numeroIngreso);
                    $sentencia->bindValue(':fecha', $this->fecha);
                    $sentencia->bindValue(':concepto', $this->concepto);
                    $sentencia->bindValue(':ingresoBruto', $this->ingresoBruto);
                    $sentencia->bindValue(':retencion', $this->retencion);
                    $sentencia->bindValue(':porcentaje', $this->porcentaje);
                    $sentencia->bindValue(':total', $this->total);
                    $sentencia->bindValue(':estado', $this->estado);
                    $sentencia->bindValue(':usuario', $this->dni);
                    
                    $nombreArchivo = str_replace( "/", "_", $this->numeroIngreso) . ".pdf";
                    $sentencia->bindValue(':archivo', $nombreArchivo); 
                    
                    $sentencia->execute();

                    return $sentencia->rowCount();

                } else {
                    return "Error al subir el archivo del ingreso";
                }

            } else {
                return "El ingreso ya existe en la base de datos";
            }  

        } catch (PDOException $error){
            echo "Hubo un error al guardar el ingreso: $error";
        }
    }



    /**
     * Método que comprueba si un ingreso existe en la base de datos
     *
     * @return Boolean
     */
    private function existeIngreso(){
        try {

            $sql = "select * from ingresos where numero_ingreso = :numeroIngreso";
            
            $sentencia = $this->conexionBD->prepare($sql);
            $sentencia->bindValue(':numeroIngreso', $this->numeroIngreso);
            $sentencia->execute();

            return ($sentencia->rowCount() == 1 ? true : false);

        } catch (PDOException $error) {
            echo "Hubo un error al guardar la factura: $error";
        }
    }



    /**
     * Método que calcula el número de ingreso
     *
     * @return String
     */
    public function calcularNumeroIngreso(){
        $numeroUltimoIngreso = "";
        $plantilla = "I" . date("Y") . "/";

        //Número ingreso: I2024/xx
        $numeroIngreso = (intval(substr($this->obtenerNumeroUltimoIngreso(), 6)));

        if ($numeroIngreso != null){
            if ($numeroIngreso < 9){
                $numeroUltimoIngreso = $plantilla . "0" . ($numeroIngreso + 1);

            } else {
                $numeroUltimoIngreso = $plantilla . $numeroIngreso + 1;

            }
            
        } else {
            $numeroUltimoIngreso = $plantilla . "01";
        }

        return $numeroUltimoIngreso;
    }


    
    /**
     * Método que obtiene el número del último ingreso
     *
     * @return String
     */
    private function obtenerNumeroUltimoIngreso(){
        try {
            $sql = "select numero_ingreso from ingresos order by numero_ingreso desc limit 1";
            $sentencia = $this->conexionBD->query($sql);
            $sentencia->execute();

            if ($sentencia->rowCount() == 1){
                foreach ($sentencia->fetch(PDO::FETCH_ASSOC) as $numeroIngreso){
                    return $numeroIngreso;
                }
            }

        } catch (PDOException $error) {
            echo "Hubo un error al obtener el número del último ingreso: $error";
        }
    }



    /**
     * Método que obtiene los ingresos de un usuario de un año concreto
     * 
     * @param USUARIOS $usuario dni del usuario
     * @param DATE $ano año a buscar
     *
     * @return Array
     */
    public function obtenerIngresos($usuario, $ano){
        try {
            switch($usuario->getRol()){
                case "usuario":
                    $sql = "select * from ingresos where usuario = :usuario and year(fecha) = :ano order by numero_ingreso desc";
                
                    $sentencia = $this->conexionBD->prepare($sql);
                    $sentencia->bindValue(':usuario', $usuario->getDni());
                    $sentencia->bindValue(':ano', $ano);
                    break;

                case "administrador":
                    $sql = "select * from ingresos where year(fecha) = :ano";
                    $sentencia = $this->conexionBD->prepare($sql);
                    $sentencia->bindValue(':ano', $ano);
                    break;
            }
        
            $sentencia->execute();

            return $sentencia->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $error) {
            echo "Hubo un error al obtener los ingresos: $error";
        }
    }



    /**
     * Método que devuelve la suma del total de ingresos
     *
     * @param Array $listaIngresos lista de ingresos
     * @param Boolean $formato Indica si queremos obtener el número con el formato español
     * 
     * @return Float|String
     */
    public function obtenerTotalIngresos($listaIngresos, $formato){
        $ingresos = 0;

        foreach ($listaIngresos as $cantidad){
            $ingresos += $cantidad['total'];
        }

        return ($formato) ? number_format($ingresos , 2, '\'', '.') : $ingresos;
    }



    /**
     * Método que obtiene los datos de un ingreso en concreto
     *
     * @param String $numeroIngreso
     * @return Array
     */
    public function obtenerDatosIngreso($numeroIngreso){
        try {
            $sql = "select nombre, apellidos, i.* 
                    from ingresos i
                    INNER JOIN usuarios u
                    ON i.usuario = u.dni
                    where numero_ingreso = :numeroIngreso";
            
            $sentencia = $this->conexionBD->prepare($sql);
            $sentencia->bindValue(':numeroIngreso', $numeroIngreso);
            $sentencia->execute();

            return $sentencia->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $error) {
            echo "Hubo un error al obtener el ingreso: $error";
        }
    }



    /**
     * Método que devuelve el total que está pendiente de ingresar
     *
     * @return Float
     */
    public function obtenerPendienteIngreso($usuario){
        try {

            //Obtenemos el total de las recolectas
            $recolecta = new Recolecta();            
            $datosRecolecta = ($usuario->getRol() == "administrador") ? $recolecta->obtenerDatosTodasRecolectas("todos", $usuario->getDni()) : $recolecta->obtenerDatosTodasRecolectas("usuario", $usuario->getDni());

            $totalRecolectas = 0;
            foreach ($datosRecolecta as $fila){
                $totalRecolectas += $fila['total'];
            }

            //Obtenemos el total de ingresos cobrados
            $totalIngresado = 0;
            foreach ($this->obtenerIngresosCobrados($usuario) as $fila){
                $totalIngresado += $fila['total'];
            }


            //Calculamos lo que falta por ingresar
            return number_format($totalRecolectas - $totalIngresado, 2, '\'', '.');


        } catch (PDOException $error) {
            echo "Hubo un error al obtener los ingresos del usuario: $error";
        }
    }



    /**
     * Método que obtiene los ingresos cobrados
     *
     * @param USUARIOS $usuario
     * @return Array
     */
    public function obtenerIngresosCobrados($usuario){
        try {
            switch($usuario->getRol()){
                case "usuario":
                    $sql = "select * from ingresos where usuario = :usuario and estado = 'cobrado'";
                    $sentencia = $this->conexionBD->prepare($sql);
                    $sentencia->bindValue(':usuario', $usuario->getDni());
                    break;


                case "administrador":
                    $sql = "select * from ingresos where estado ='cobrado'";
                    $sentencia = $this->conexionBD->query($sql);
                    break;
            }

            $sentencia->execute();
            return $sentencia->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $error) {
            die("Hubo un error al obtener los ingresos cobrados: $error");
        }

    }



    /**
     * Método que actualiza los datos de un ingreso
     *
     * @return void
     */
    public function actualizarIngreso() {
        try {
            if ($this->existeIngreso()){
                if ($this->archivo == ""){
                    $sql = "update ingresos set usuario = :usuario, fecha = :fecha, concepto = :concepto, ingreso_bruto = :ingresoBruto, porcentaje_retencion = :porcentajeRetencion, retencion = :retencion, total = :total, estado = :estado where numero_ingreso = :numeroIngreso";
                } else {
                    $sql = "update ingresos set usuario = :usuario, fecha = :fecha, concepto = :concepto, ingreso_bruto = :ingresoBruto, porcentaje_retencion = :porcentajeRetencion, retencion = :retencion, total = :total, estado = :estado, archivo = :archivo where numero_ingreso = :numeroIngreso";
                }

                $sentencia = $this->conexionBD->prepare($sql);
                $sentencia->bindValue(':usuario', $this->dni);
                $sentencia->bindValue(':fecha', $this->fecha);
                $sentencia->bindValue(':concepto', $this->concepto);
                $sentencia->bindValue(':ingresoBruto', $this->ingresoBruto);
                $sentencia->bindValue(':porcentajeRetencion', $this->porcentaje);
                $sentencia->bindValue(':retencion', $this->retencion);
                $sentencia->bindValue(':total', $this->total);
                $sentencia->bindValue(':estado', $this->estado);
                $sentencia->bindValue(':numeroIngreso', $this->numeroIngreso);

                if ($this->archivo != "") $sentencia->bindValue(':archivo', $this->archivo);

                $sentencia->execute();

                return $sentencia->rowCount();
            
            } else {
                return 2;
            }

        } catch (PDOException $error) {
            echo "Hubo un error al obtener la factura: $error";
        }
    }



    /**
     * Método que elimina una ingreso
     *
     * @param INT $id
     * @return INT Número de registros borrados
     */
    public function borrarIngreso($numeroIngreso){
        try {
            $sql = "delete from ingresos where numero_ingreso = :numeroIngreso";
            $sentencia = $this->conexionBD->prepare($sql);
            $sentencia->bindValue(':numeroIngreso', $numeroIngreso);
            $sentencia->execute();

            return $sentencia->rowCount();

        } catch (PDOException $error) {
            die("Hubo un error al borrar el ingreso: $error");
        }
    }



    /**
     * Método que devuelve la suma de todas los ingresos agrupados por años de un usuario
     *
     * @param String $dni
     * @return void
     */
    public function obtenerTotalIngresosAnos($dni){
        try {
            $sql = "select year(fecha) as ano, sum(total) as total
                from ingresos where usuario = :dni
                group by ano
                order by ano;";
            $sentencia = $this->conexionBD->prepare($sql);
            $sentencia->bindValue(':dni', $dni);
            $sentencia->execute();

            return $sentencia->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $error) {
            die("Hubo un error al obtener los ingresos de un usuario por año: $error");
        }
    }




    //-------------------- Getters y Setters
    /**
     * Get the value of numeroIngreso
     */
    public function getNumeroIngreso() {
        return $this->numeroIngreso;
    }

    /**
     * Set the value of numeroIngreso
     */
    public function setNumeroIngreso($numeroIngreso): self {
        $this->numeroIngreso = $numeroIngreso;

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
     * Get the value of ingresoBruto
     */
    public function getIngresoBruto() {
        return $this->ingresoBruto;
    }

    /**
     * Set the value of ingresoBruto
     */
    public function setIngresoBruto($ingresoBruto): self {
        $this->ingresoBruto = $ingresoBruto;

        return $this;
    }

    /**
     * Get the value of retencion
     */
    public function getRetencion() {
        return $this->retencion;
    }

    /**
     * Set the value of retencion
     */
    public function setRetencion($retencion): self {
        $this->retencion = $retencion;

        return $this;
    }

    /**
     * Get the value of porcentaje
     */
    public function getPorcentaje() {
        return $this->porcentaje;
    }

    /**
     * Set the value of porcentaje
     */
    public function setPorcentaje($porcentaje): self {
        $this->porcentaje = $porcentaje;

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
     * Get the value of estado
     */
    public function getEstado() {
        return $this->estado;
    }

    /**
     * Set the value of estado
     */
    public function setEstado($estado): self {
        $this->estado = $estado;

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
}
?>
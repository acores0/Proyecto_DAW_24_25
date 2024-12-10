<?php 
require_once ("ConexionBD.php");
require_once ("AlbaranesEntrega.php");

class Recolecta{
    private $dni;
    private $ano;
    private $precio;
    private $kg;
    private $baseImponible;
    private $retencion;
    private $porcentaje;
    private $total;
    private $graduacion;
    private $conexionBD;




    public function __construct(){
        $this->conexionBD = new ConexionBD();

        //Array con los parámetros enviados a la función
		$params = func_get_args();

		//Número de parámetros que estoy recibiendo
		$numeroParametros = func_num_args();

        switch($numeroParametros){
            case 4:
                call_user_func_array(array($this, "iniciarAtributos"),$params);
                break;
        }
    }
    


    /**
     * Método que inicia los atributos de la clase
     * 
     * @param String $dni
     * @param Date $ano
     * @param Float $precio
     * @param Float $porcentaje
     * @return void
     */
    private function iniciarAtributos($dni, $ano, $precio, $porcentaje){
        $this->dni = $dni;
        $this->ano = $ano;
        $this->precio = $precio;
        $this->porcentaje = $porcentaje;

        //Cálculo de la graduación y KG
        $albaranesEntrega = new AlbaranesEntrega();
        $albaranes = $albaranesEntrega->obtenerAlbaranes($this->dni, $this->ano);
        
        $sumaGrados = 0;
        foreach ($albaranes as $albaran){
            $sumaGrados += $albaran['grado'];
            $this->kg += $albaran['pesoneto'];
        }
            
        $this->graduacion = number_format($sumaGrados / count($albaranes), 2);
            


        if ($precio != 0.00){
            //Cálculo de la base imponible
            $this->baseImponible = $this->precio * $this->kg;
            
            //Cálculo de la retención
            $this->retencion = ($this->baseImponible * $this->porcentaje)/100;

            //Cálculo del total
            $this->total = $this->baseImponible - $this->retencion;
        }

        
    }



    /**
     * Método que almacena los datos de la recolecta
     * 
     * @return String
     */
    public function guardarRecolecta(){
        try {
            if ($this->precio == 0.00) {
                $sql = "insert into recolecta (usuario, ano, kg, baseimponible, retencion, porcentaje, total, graduacion) values (:dni, :ano, :kg, :baseimponible, :retencion, :porcentaje, :total, :graduacion)";
                $sentencia = $this->conexionBD->prepare($sql);
                $sentencia->bindValue(':dni', $this->dni);
                $sentencia->bindValue(':ano', $this->ano);
                $sentencia->bindValue(':kg', $this->kg);
                $sentencia->bindValue(':baseimponible', $this->baseImponible);
                $sentencia->bindValue(':retencion', $this->retencion);
                $sentencia->bindValue(':porcentaje', $this->porcentaje);
                $sentencia->bindValue(':total', $this->total);
                $sentencia->bindValue(':graduacion', $this->graduacion);
                $sentencia->execute();
            
            } else {
                $sql = "insert into recolecta (usuario, ano, precio, kg, baseimponible, retencion, porcentaje, total, graduacion) values (:dni, :ano, :precio, :kg, :baseimponible, :retencion, :porcentaje, :total, :graduacion)";
                $sentencia = $this->conexionBD->prepare($sql);
                $sentencia->bindValue(':dni', $this->dni);
                $sentencia->bindValue(':ano', $this->ano);
                $sentencia->bindValue(':precio', $this->precio);
                $sentencia->bindValue(':kg', $this->kg);
                $sentencia->bindValue(':baseimponible', $this->baseImponible);
                $sentencia->bindValue(':retencion', $this->retencion);
                $sentencia->bindValue(':porcentaje', $this->porcentaje);
                $sentencia->bindValue(':total', $this->total);
                $sentencia->bindValue(':graduacion', $this->graduacion);
                $sentencia->execute();
            }

            if ($sentencia->rowCount() == 1) echo "Campaña guardada";

        } catch (PDOException $error) {
            echo "Hubo un error al guardar la campaña: $error";
        }
    }



    /**
     * Método que obtiene todos los datos de las campañas o de las campañas de un usuario
     * 
     * @param String $tipoConsulta usuario|todos
     * @param String $dni usuario a consultar
     * @return Array
     */
    public function obtenerDatosTodasRecolectas($tipoConsulta, $dni){
        try {
            switch ($tipoConsulta){
                case "usuario":
                    $sql = "select * from recolecta where usuario = :usuario";
                    $sentencia = $this->conexionBD->prepare($sql);
                    $sentencia->bindValue(':usuario', $dni);
                    break;
                case "todos":
                    $sql = "select * from recolecta";
                    $sentencia = $this->conexionBD->query($sql);
                    break;
            }

            $sentencia->execute();

            return $sentencia->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $error) {
            echo "Hubo un error al obtener los datos de todas las campaña: $error";
        }
    }



    /**
     * Método que obtiene todos los datos de una campaña o de la campaña de un usuario de un año en concreto
     * 
     * @param String $tipoConsulta usuario|todos
     * @param String $dni usuario a consultar
     * @param Date $ano
     * 
     * @return Array
     */
    public function obtenerDatosRecolecta($tipoConsulta, $dni, $ano){
        try {
            switch($tipoConsulta){
                case "usuario":
                    $sql = "select * from recolecta where usuario = :usuario and ano = :ano";
                    $sentencia = $this->conexionBD->prepare($sql);
                    $sentencia->bindValue(":usuario", $dni);
                    $sentencia->bindValue(":ano", $ano);
                    break;
                    
                case "todos":
                    $sql = "select * from recolecta where ano = :ano";
                    $sentencia = $this->conexionBD->prepare($sql);
                    $sentencia->bindValue('ano', $ano);
                    break;
            }
                    
            $sentencia->execute();
            return $sentencia->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $error) {
            echo "Hubo un error al obtener los datos de la campaña: $error";
        }
    }



    /**
     * Método que obtiene los kg entregados de uva de un usuario de un año en concreto
     *
     * @param USUARIOS $usuario
     * @param String $ano
     * @return Float
     */
    public function obtenerKgEntregados($usuario, $ano){
        $datos = ($usuario->getRol() == "administrador") ? $this->obtenerDatosRecolecta("todos", $usuario->getDni(), $ano) : $this->obtenerDatosRecolecta("usuario", $usuario->getDni(), $ano);

        $kgEntregados = 0;
        foreach ($datos as $valor){
            $kgEntregados += $valor['kg'];
        }

        return number_format($kgEntregados, 2, '\'', '.');
    }



    /**
     * Método que obtiene la lista del total de kg entregados por año
     *
     * @return Array
     */
    public function obtenerHistoricoKgEntregados(){
        try {
            $sql = "select ano, sum(kg) as 'total_kg' from recolecta group by ano;";
            $sentencia = $this->conexionBD->query($sql);
            $sentencia->execute();

            return $sentencia->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $error) {
            echo "Hubo un error al recuperar el histórico de kg entregados: $error";
        }
    }



    /**
     * Método de obtiene el histórico de kg entregados de un usuario por años
     *
     * @param USUARIOS $usuario
     * @return Array
     */
    public function obtenerHistoricoKgEntregadosUsuario($usuario){
        try {
            $sql = "select ano, sum(kg) as 'total_kg' from recolecta where usuario = :usuario group by ano;";
            $sentencia = $this->conexionBD->prepare($sql);
            $sentencia->bindValue(':usuario', $usuario->getDNI());
            $sentencia->execute();

            return $sentencia->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $error) {
            echo "Hubo un error al recuperar el histórico de kg entregados del usuario: $error";
        }
    }



    /**
     * Método que obtiene la media de grados de un usuario de un año en concreto
     *
     * @param USUARIOS $usuario
     * @param String $ano
     * @return Float
     */
    public function obtenerMediaGraduacion($usuario, $ano){
        $datos = ($usuario->getRol() == "administrador") ? $this->obtenerDatosRecolecta("todos", $usuario->getDni(), $ano) :  $this->obtenerDatosRecolecta("todos", $usuario->getDni(), $ano);

        $mediaGrados = 0;
        $contador = 0;
        foreach ($datos as $valor){
            $mediaGrados += $valor['graduacion'];
            $contador++;
        }

        return number_format(floor(($mediaGrados / $contador) * 100) / 100, 2, '\'', '.');
    }



    /**
     * Método que obtiene el histórico de los grados por año
     *
     * @return Array
     */
    public function obtenerHistoricoMediaGraduacion(){
        try {
            $devolverDatos = [];

            $listaAnos = $this->obtenerListaAnosRecolecta();

            foreach ($this->obtenerListaAnosRecolecta() as $datosAno){
                $anoMedia = [];

                $sql = "select sum(graduacion)/count(id) as 'media_grados' from recolecta where ano = :ano;";
                $sentencia = $this->conexionBD->prepare($sql);
                $sentencia->bindValue(':ano', $datosAno['ano']);
                $sentencia->execute();

                foreach ($sentencia->fetchAll(PDO::FETCH_ASSOC) as $media){
                    $anoMedia['ano'] = $datosAno['ano'];
                    $anoMedia['graduacion'] = number_format($media['media_grados'], 2);
                }

                array_push($devolverDatos, $anoMedia);
            }
            
            

            return $devolverDatos;

        } catch (PDOException $error) {
            echo "Hubo un error al obtener el histórico de grados: $error";
        }
    }



    /**
     * Método que obtiene el histórico de los grados de un usuario
     *
     * @return Array
     */
    public function obtenerHistoricoMediaGraduacionUsuario($usuario){
        try {
            $sql = "select ano, graduacion from recolecta where usuario = :usuario;";
            $sentencia = $this->conexionBD->prepare($sql);
            $sentencia->bindValue(':usuario', $usuario->getDNI());
            $sentencia->execute();

            return $sentencia->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $error) {
            echo "Hubo un error al obtener el histórico de grados del usuario: $error";
        }
    }



    /**
     * Método que obtiene la cantidad que un usuario tiene pendiente de cobro
     *
     * @return Float
     */
    public function obtenerPendienteCobro($dni){
        try {
            $sql = "select usuario, sum(total) AS 'total_pendiente' from recolecta where usuario = :usuario and cobrado = false";
            $sentencia = $this->conexionBD->prepare($sql);
            $sentencia->bindValue(":usuario", $dni);
            $sentencia->execute();

            if ($sentencia->rowCount() == 1){
                foreach ($sentencia->fetchAll(PDO::FETCH_ASSOC) as $total){
                    return $total['total_pendiente'];
                }
            }

        } catch (PDOException $error) {
            echo "Hubo un error al obtener la cantidad pendiente de cobro: $error";
        }
    }



    /**
     * Método que obtiene la lista de años que tienen registros
     *
     * @return Array
     */
    public function obtenerListaAnosRecolecta(){
        try {
            $sql = "select ano from recolecta group by ano order by ano desc;";
            $sentencia = $this->conexionBD->query($sql);
            $sentencia->execute();

            return $sentencia->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $error) {
            echo "Hubo un error al obtener la lista de años que tienen registros: $error";
        }
    }



    /**
     * Método que obtiene el resumen de una campaña
     *
     * @param Array $datosRecolecta Datos de la campaña
     * @return Array
     */
    public function obtenerResumenRecolecta($datosRecolecta){
        $devolverArray = [];
        $array = [];
    
        $kg = 0;
        $graduacion = 0;
        $precio = 0;
        $baseImponible = 0;
        $retencion = 0;
        $total = 0;
        $porcentaje = 0;
        $contador = 0;

        if (count($datosRecolecta) > 0){
            foreach($datosRecolecta as $datos){
                $kg += $datos['kg'];
                $graduacion += $datos['graduacion'];
                $precio = $datos['precio'];
                $baseImponible += $datos['base_imponible'];
                $retencion += $datos['retencion'];
                $total += $datos['total'];
                $porcentaje = $datos['porcentaje'];
                $contador++;
            }
        }
        
        $array['kg'] = $kg;
        $array['graduacion'] = (count($datosRecolecta) > 0) ? number_format($graduacion / $contador, 2) : $graduacion;
        $array['precio'] = $precio;
        $array['base_imponible'] = $baseImponible;
        $array['retencion'] = $retencion;
        $array['total'] = $total;
        $array['porcentaje'] = $porcentaje;

        array_push($devolverArray, $array);
        return $devolverArray;
    }



    /**
     * Método que da de alta el precio de una campaña
     *
     * @return void
     */
    public function modificarPrecio($ano, $precio, $porcentajeRetencion){
        try {
            if ($ano <= date("Y")){
                $listaRecolectas = $this->obtenerDatosRecolecta("todos", "", $ano);

                if (count($listaRecolectas) > 0){
                    if ($listaRecolectas[0]['precio'] != $precio){

                        $resultado = 0;
                        foreach ($listaRecolectas as $recolecta){
                            $baseImponible = $recolecta['kg'] * $precio;
                            $retencion = ($baseImponible * $porcentajeRetencion) / 100;
                            $total = $baseImponible - $retencion;

                            $sql = "update recolecta set precio = :precio, base_imponible = :baseImponible, porcentaje = :porcentaje, retencion = :retencion, total = :total where id = :id";
                            $sentencia = $this->conexionBD->prepare($sql);
                            $sentencia->bindValue(':precio', $precio);
                            $sentencia->bindValue(':baseImponible', $baseImponible);
                            $sentencia->bindValue(':porcentaje', $porcentajeRetencion);
                            $sentencia->bindValue(':retencion', $retencion);
                            $sentencia->bindValue(':total', $total);
                            $sentencia->bindValue(':id', $recolecta['id']);
                            $sentencia->execute();
                            $resultado += $sentencia->rowCount();
                        }

                        return ($resultado == count($listaRecolectas)) ? 1 : 0;

                    } else {
                        return "El precio de la campaña $ano y el nuevo precio es el mismo";
                    }
                } else {
                    return "No se puede poner precio a un año en el que no hay dato de la campaña";
                }

            } else {
                return "No se puede poner precio a un año futuro";
            }

        } catch (PDOException $error) {
            echo "Hubo un error al editar el precio: $error";
        }
    }



    /**
     * Método que borra todas las recolectas de un usuario
     *
     * @param String $dni DNI del usuario
     * @return Boolean
     */
    public function borrarRecolectasUsuario($dni){
        try {
            $sql = "delete from recolecta where usuario = :dni";
    
            $sentencia = $this->conexionBD->prepare($sql);
            $sentencia->bindValue('dni', $dni);
            return $sentencia->execute();

        } catch (PDOException $error) {
            die("Hubo un error al borrar las recolectas del usuario: $error");
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
     * Get the value of ano
     */
    public function getAno() {
        return $this->ano;
    }

    /**
     * Set the value of ano
     */
    public function setAno($ano): self {
        $this->ano = $ano;

        return $this;
    }

    /**
     * Get the value of precio
     */
    public function getPrecio() {
        return $this->precio;
    }

    /**
     * Set the value of precio
     */
    public function setPrecio($precio): self {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get the value of kg
     */
    public function getKg() {
        return $this->kg;
    }

    /**
     * Set the value of kg
     */
    public function setKg($kg): self {
        $this->kg = $kg;

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
     * Get the value of graduacion
     */
    public function getGraduacion() {
        return $this->graduacion;
    }

    /**
     * Set the value of graduacion
     */
    public function setGraduacion($graduacion): self {
        $this->graduacion = $graduacion;

        return $this;
    }
}





?>
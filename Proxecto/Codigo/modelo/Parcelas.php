<?php
require_once ("ConexionBD.php");

class Parcelas {
    private $usuario;
    private $nombre;
    private $direccion;
    private $municipio;
    private $codigoPostal;
    private $provincia;
    private $m2;
    private $variedad;
    private $cupo;
    private $conexionBD;


    public function __construct() {
        $this->conexionBD = new ConexionBD();

        //Array con los parámetros enviados a la función
		$parametros = func_get_args();

		//Número de parámetros que estoy recibiendo
		$numeroParametros = func_num_args();

        switch($numeroParametros){
            case 9:
                call_user_func_array(array($this, "iniciarAtributos"), $parametros);
                break;
        }
    }


    /**
     * Método que almacena el estado de los atributos
     *
     * @param String $usuario usuario propietario de la parcela
     * @param String $nombre nombre de la parcela
     * @param String $direccion dirección de la parcela
     * @param String $coordenadas coordenadas de la parcela
     * @param Float $m2 metros cuadrados de la parcela
     * @param String $variedad variedad de uva cultivada en la parcela
     * @param Float $cupo total de kg que tiene la parcela
     * @return void
     */
    private function iniciarAtributos($usuario, $nombre, $direccion, $municipio, $codigoPostal, $provincia, $m2, $variedad, $cupo) {
        $this->usuario = $usuario;
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->municipio = $municipio;
        $this->codigoPostal = $codigoPostal;
        $this->provincia = $provincia;
        $this->m2 = $m2;
        $this->variedad = $variedad;
        $this->cupo = $cupo;
    }



    /**
     * Método que almacena los datos de una parcela en la base de datos
     *
     * @return INT Retorna el número de registros que se almacenaron en la base de datos
     */
    public function guardarParcela(){
        try{

            if (!$this->existeParcela()){
                $sql = "insert into parcelas (usuario, nombre, direccion, municipio, provincia, codigo_postal, m2, variedad_uva, cupo) values (:usuario, :nombre, :direccion, :municipio, :provincia, :codigoPostal, :m2, :variedad, :cupo)";
                $sentencia = $this->conexionBD->prepare($sql);
                $sentencia->bindValue(':usuario', $this->usuario);
                $sentencia->bindValue(':nombre', $this->nombre);
                $sentencia->bindValue(':direccion', $this->direccion);
                $sentencia->bindValue(':municipio', $this->municipio);
                $sentencia->bindValue(':provincia', $this->provincia);
                $sentencia->bindValue(':codigoPostal', $this->codigoPostal);
                $sentencia->bindValue(':m2', $this->m2);
                $sentencia->bindValue(':variedad', $this->variedad);    
                $sentencia->bindValue(':cupo', $this->cupo);
                $sentencia->execute();

                return $sentencia->rowCount();
            
            } else {
                return "La parcela ya existe en la base de datos";
            }

        } catch (PDOException $error){
            return "Hubo un error al guardar la parcela en la base de datos: $error";
        }
    }



    /**
     * Método que muestra todas las parcelas de un usuario
     * 
     * @param String $cantidad todas | usuario
     * @param String $dni dni del usuario
     *
     * @return Array array con todas las parcelas con sus datos
     */
    public function obtenerParcelasUsuario($cantidad, $dni){
        try{
            switch ($cantidad){
                case "usuario":
                    $sql = "select * from parcelas where usuario = :dni";
                    $sentencia = $this->conexionBD->prepare($sql);
                    $sentencia->bindValue(":dni", $dni);
                    break;
                    
                case "todas":
                    $sql = "select * from parcelas";
                    $sentencia = $this->conexionBD->query($sql);
                    break;
            }

            $sentencia->execute();

            return $sentencia->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $error) {
            return "Hubo un error al mostrar las parcelas $error";
        }
    }



    /**
     * Método que comprueba si la parcela ya existe en la base de datos
     *
     * @return Boolean True -> existe; False -> no existe
     */
    public function existeParcela(){
        try{
            $sql = "select * from parcelas where usuario = :usuario and direccion = :direccion and codigo_postal = :codigoPostal";
            $sentencia = $this->conexionBD->prepare($sql);
            $sentencia->bindValue(':usuario', $this->usuario);
            $sentencia->bindValue('direccion', $this->direccion);
            $sentencia->bindValue(':codigoPostal', $this->codigoPostal);
            $sentencia->execute();

            return $sentencia->rowCount() != 0 ? true : false;

        } catch (PDOException $error) {
            die ("Hubo un error al acceder a la base de datos $error");
        }
    }



    /**
     * Método que obtiene los datos de una parcela en concreto
     *
     * @param INT $id id de la parcela
     * @return Array Datos de la parcela
     */
    public function obtenerDatosParcela($id){
        try{
            $sql = "select * from parcelas where id = :id";
            $sentencia = $this->conexionBD->prepare($sql);
            $sentencia->bindValue(":id", $id);
            $sentencia->execute();

            return $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $error){
            echo "Hubo un error al obtener los datos de la parcela $error";
        }
    }



    /**
     * Método que suma el cupo total de una lista de parcelas
     * 
     * @param Array $listaParcelas Array con la lista de parcelas
     *
     * @return Float
     */
    public function obtenerCupoTotal($listaParcelas){
        $cupoTotal = 0;

        foreach ($listaParcelas as $cupo){
            $cupoTotal += $cupo['cupo'];
        }

        return number_format($cupoTotal, 2, '\'', '.');

    }



    /**
     * Método que editar los datos de una parcela
     * 
     * @return INT Número de registros actualizados
     */
    public function actualizarParcela(){
        try{
            if ($this->existeParcela()){
                $sql = "update parcelas set nombre = :nombre, direccion = :direccion, municipio = :municipio, provincia = :provincia, codigo_postal = :codigoPostal, m2 = :m2, variedad_uva = :variedad, cupo = :cupo where id = :id)";
                $sentencia = $this->conexionBD->prepare($sql);
                $sentencia->bindValue(':usuario', $this->usuario);
                $sentencia->bindValue(':nombre', $this->nombre);
                $sentencia->bindValue(':direccion', $this->direccion);
                $sentencia->bindValue(':municipio', $this->municipio);
                $sentencia->bindValue(':provincia', $this->provincia);
                $sentencia->bindValue(':codigoPostal', $this->codigoPostal);
                $sentencia->bindValue(':m2', $this->m2);
                $sentencia->bindValue(':variedad', $this->variedad);    
                $sentencia->bindValue(':cupo', $this->cupo);
                $sentencia->execute();

                return $sentencia->rowCount();
            
            } else {
                return 2;
            }



        } catch (PDOException $error) {
            die ("Hubo un error al acceder a la base de datos $error");
        }
    }


   
    /**
     * Método que borra una parcela en concreto
     *
     * @param INT $id id de la parcela a borrar
     * @return INT Retorna el número de registros borrados
     */
    public function borrarParcela($id){
        try{
            $sql = "delete from parcelas where id = :id";
            $sentencia = $this->conexionBD->prepare($sql);
            $sentencia->bindValue(':id', $id);
            $sentencia->execute();

            return $sentencia->rowCount();

        } catch (PDOException $error){
            return "Hubo un error al eliminar la parcela $error";
        }
    }




    //-------------------- Getters y Setters
    /**
     * Get the value of usuario
     */
    public function getUsuario() {
        return $this->usuario;
    }

    /**
     * Set the value of usuario
     */
    public function setUsuario($usuario): self {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     */
    public function setNombre($nombre): self {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of direccion
     */
    public function getDireccion() {
        return $this->direccion;
    }

    /**
     * Set the value of direccion
     */
    public function setDireccion($direccion): self {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get the value of municipio
     */
    public function getMunicipio() {
        return $this->municipio;
    }

    /**
     * Set the value of municipio
     */
    public function setMunicipio($municipio): self {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get the value of codigoPostal
     */
    public function getCodigoPostal() {
        return $this->codigoPostal;
    }

    /**
     * Set the value of codigoPostal
     */
    public function setCodigoPostal($codigoPostal): self {
        $this->codigoPostal = $codigoPostal;

        return $this;
    }

    /**
     * Get the value of provincia
     */
    public function getProvincia() {
        return $this->provincia;
    }

    /**
     * Set the value of provincia
     */
    public function setProvincia($provincia): self {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get the value of m2
     */
    public function getM2() {
        return $this->m2;
    }

    /**
     * Set the value of m2
     */
    public function setM2($m2): self {
        $this->m2 = $m2;

        return $this;
    }

    /**
     * Get the value of variedad
     */
    public function getVariedad() {
        return $this->variedad;
    }

    /**
     * Set the value of variedad
     */
    public function setVariedad($variedad): self {
        $this->variedad = $variedad;

        return $this;
    }

    /**
     * Get the value of cupo
     */
    public function getCupo() {
        return $this->cupo;
    }

    /**
     * Set the value of cupo
     */
    public function setCupo($cupo): self {
        $this->cupo = $cupo;

        return $this;
    }

    /**
     * Get the value of conexionBD
     */
    public function getConexionBD() {
        return $this->conexionBD;
    }

    /**
     * Set the value of conexionBD
     */
    public function setConexionBD($conexionBD): self {
        $this->conexionBD = $conexionBD;

        return $this;
    }
}

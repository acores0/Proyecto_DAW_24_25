<?php 
require_once ("ConexionBD.php");

class AlbaranesEntrega{
    private $numeroAlbaran;
    private $usuario;
    private $parcela;
    private $fechaHora;
    private $pesoBruto;
    private $tara = 50;
    private $pesoNeto;
    private $grado;
    private $cajas;
    private $archivo;
    private $conexionBD;


    public function __construct(){
        $this->conexionBD = new ConexionBD();

        //Array con los parámetros enviados a la función
		$parametros = func_get_args();

		//Número de parámetros que estoy recibiendo
		$numeroParametros = func_num_args();

        switch($numeroParametros){
            case 1:
                call_user_func_array(array($this, "iniciarUsuario"), $parametros);
                break;

            case 7:
                call_user_func_array(array($this, "iniciarAtributos"), $parametros);
                break;
        }
    }
    


    /**
     * Método que inicia los atributos de la clase
     * 
     * @param String $dni
     * @param String $parcela
     * @param DateTime $fechaHora
     * @param Float $pesoBruto
     * @param Float $grado
     * @param INT cajas;
     * @return void
     */
    private function iniciarAtributos($numeroAlbaran, $dni, $parcela, $pesoBruto, $grado, $cajas, $archivo){
        $this->numeroAlbaran = $numeroAlbaran;
        $this->usuario = $dni;
        $this->parcela = $parcela;
        $this->fechaHora = date("Y-m-d H:i:s");
        $this->pesoBruto = $pesoBruto;
        $this->pesoNeto = $this->pesoBruto - $this->tara;
        $this->grado = $grado;
        $this->cajas = $cajas;
        $this->archivo = $archivo;
    }



    /**
     * Método que iniciar el atributo dni
     *
     * @param String $dni
     * @return void
     */
    private function iniciarUsuario($dni){
        $this->usuario = $dni;
    }



    /**
     * Método que almacena un albarán en la base de datos
     *
     * @return String
     */
    public function guardarAlbaran(){
        try {
            if(!$this->existeAlbaran()){
                if (subirPDF($this->archivo, $this->numeroAlbaran)){
                    $sql = "insert into albaranes (numero_albaran, usuario, parcela, fecha_hora, grado, peso_bruto, tara, peso_neto, cajas, archivo) values (:numeroAlbaran, :usuario, :parcela, :fechaHora, :grado, :pesoBruto, :tara, :pesoNeto, :cajas, :archivo)";
                    $sentencia = $this->conexionBD->prepare($sql);
                    $sentencia->bindValue(':numeroAlbaran', $this->numeroAlbaran);
                    $sentencia->bindValue(':usuario', $this->usuario);
                    $sentencia->bindValue(':parcela', $this->parcela);
                    $sentencia->bindValue(':fechaHora', $this->fechaHora);
                    $sentencia->bindValue(':grado', $this->grado);
                    $sentencia->bindValue(':pesoBruto', $this->pesoBruto);
                    $sentencia->bindValue(':tara', $this->tara);
                    $sentencia->bindValue(':pesoNeto', $this->pesoNeto);
                    $sentencia->bindValue(':cajas', $this->cajas);

                    $nombreArchivo = str_replace( "/", "_", $this->numeroAlbaran) . ".pdf";
                    $sentencia->bindValue(':archivo', $nombreArchivo); 
                    
                    $sentencia->execute();

                    return $sentencia->rowCount();
                
                } else {
                    return "Error al subir el archivo del albarán";
                }

            } else {
                return "El albarán ya existe en la base de datos";
            }

        } catch (PDOException $error) {
            die("Hubo un error al guardar el albarán $error");
        }
    }



    /**
     * Método que calcula el número del albarán
     *
     * @return String
     */
    public function calcularNumeroAlbaran(){
        $numeroUltimoAlbaran = "";
        $plantilla = "A" . date("Y") . "/";

        //Número albaran: A2024/xx
        $numeroAlbaran = (intval(substr($this->obtenerNumeroUltimoAlbaran(), 6)));

        if ($numeroAlbaran != null){
            if ($numeroAlbaran < 9){
                $numeroUltimoAlbaran = $plantilla . "0" . ($numeroAlbaran + 1);
            
            } else {
                $numeroUltimoAlbaran = $plantilla . $numeroAlbaran + 1;
            }
            
        } else {
            $numeroUltimoAlbaran = $plantilla . "01";
        }

        return $numeroUltimoAlbaran;
    }



    /**
     * Método que obtiene el id del último albarán
     *
     * @return String
     */
    private function obtenerNumeroUltimoAlbaran(){
        try {
            $sql = "select numero_albaran from albaranes order by numero_albaran desc limit 1";
            $sentencia = $this->conexionBD->query($sql);
            $sentencia->execute();

            if ($sentencia->rowCount() == 1){
                foreach ($sentencia->fetch(PDO::FETCH_ASSOC) as $numeroAlbaran){
                    return $numeroAlbaran;
                }
            }

        } catch (PDOException $error) {
            die("Hubo un error al obtener el número de la última factura: $error");
        }
    }



    /**
     * Método que comprueba si un albaran existe en la base de datos
     *
     * @return Boolean
     */
    private function existeAlbaran(){
        try {

            $sql = "select * from albaranes where numero_albaran = :numeroAlbaran";
            
            $sentencia = $this->conexionBD->prepare($sql);
            $sentencia->bindValue(':numeroAlbaran', $this->numeroAlbaran);
            $sentencia->execute();

            return ($sentencia->rowCount() == 1) ? true : false;

        } catch (PDOException $error) {
            die("Hubo un error al guardar la factura: $error");
        }
    }



    /**
     * Método que obtiene los albaranes de un año determinado de un usuario
     *
     * @param String $dni
     * @param Date $ano
     * @return Array
     */
    public function obtenerAlbaranes($dni, $ano){
        try {
            $sql = "select a.*, p.nombre from albaranes a
                join parcelas 
                p on a.parcela = p.id
                where a.usuario = :usuario and a.fecha_hora between concat(:ano, '-01-01') and concat(:ano, '-12-31')";
    
            $sentencia = $this->conexionBD->prepare($sql);
            $sentencia->bindValue(':usuario', $dni);
            $sentencia->bindValue(':ano', $ano);
            $sentencia->execute();

            return $sentencia->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $error) {
            die("Hubo un error al obtener los albaranes del usuario $error");
        }
    }

    

    /**
     * Método que obtiene los datos de un albarán en concreto
     *
     * @param String $numeroAlbaran
     * @return Array
     */
    public function obtenerDatosAlbaran($numeroAlbaran){
        try {
            $sql = "select a.*, u.nombre, u.apellidos from albaranes a
                join usuarios u 
                on a.usuario = u.dni
                where numero_albaran = :numeroAlbaran";
    
            $sentencia = $this->conexionBD->prepare($sql);
            $sentencia->bindValue(':numeroAlbaran', $numeroAlbaran);
            $sentencia->execute();

            return $sentencia->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $error) {
            die("Hubo un error al obtener los albaranes del usuario $error");
        }
    }



    /**
     * Método que borrar un albarán
     *
     * @param INT $id ID del albarán a borrar
     * @return INT Número de registros borrados
     */
    public function borrarAlbaran($id){
        try {
            $sql = "delete from albaranes where id = :id";
    
            $sentencia = $this->conexionBD->prepare($sql);
            $sentencia->bindValue(':id', $id);
            $sentencia->execute();

            return $sentencia->rowCount();

        } catch (PDOException $error) {
            die("Hubo un error al borrar el albarán: $error");
        }
    }

   


    //-------------------- Getters y Setters
    /**
     * Get the value of numeroAlbaran
     */
    public function getNumeroAlbaran() {
        return $this->numeroAlbaran;
    }

    /**
     * Set the value of numeroAlbaran
     */
    public function setNumeroAlbaran($numeroAlbaran): self {
        $this->numeroAlbaran = $numeroAlbaran;

        return $this;
    }

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
     * Get the value of parcela
     */
    public function getParcela() {
        return $this->parcela;
    }

    /**
     * Set the value of parcela
     */
    public function setParcela($parcela): self {
        $this->parcela = $parcela;

        return $this;
    }

    /**
     * Get the value of fechaHora
     */
    public function getFechaHora() {
        return $this->fechaHora;
    }

    /**
     * Set the value of fechaHora
     */
    public function setFechaHora($fechaHora): self {
        $this->fechaHora = $fechaHora;

        return $this;
    }

    /**
     * Get the value of pesoBruto
     */
    public function getPesoBruto() {
        return $this->pesoBruto;
    }

    /**
     * Set the value of pesoBruto
     */
    public function setPesoBruto($pesoBruto): self {
        $this->pesoBruto = $pesoBruto;

        return $this;
    }

    /**
     * Get the value of tara
     */
    public function getTara() {
        return $this->tara;
    }

    /**
     * Set the value of tara
     */
    public function setTara($tara): self {
        $this->tara = $tara;

        return $this;
    }

    /**
     * Get the value of pesoNeto
     */
    public function getPesoNeto() {
        return $this->pesoNeto;
    }

    /**
     * Set the value of pesoNeto
     */
    public function setPesoNeto($pesoNeto): self {
        $this->pesoNeto = $pesoNeto;

        return $this;
    }

    /**
     * Get the value of grado
     */
    public function getGrado() {
        return $this->grado;
    }

    /**
     * Set the value of grado
     */
    public function setGrado($grado): self {
        $this->grado = $grado;

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
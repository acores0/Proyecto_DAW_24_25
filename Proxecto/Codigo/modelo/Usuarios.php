<?php
require_once("ConexionBD.php");

class Usuarios{
    private $dni;
    private $nombre;
    private $apellidos;
    private $direccion;
    private $codigoPostal;
    private $municipio;
    private $provincia;
    private $rol = "usuario";
    private $correo;
    private $telefono;
    private $contrasinal;
    private $formaPago;
    private $cuentaBancaria;
    private $foto;
    private $conexionBD;




    /**
     * Conctructor de la clase
     */
    public function __construct() {
        $this->conexionBD = new ConexionBD();

        //Array con los parámetros enviados a la función
        $parametros = func_get_args();

        //Número de parámetros que estoy recibiendo
        $numeroParametros = func_num_args();

        switch ($numeroParametros) {
            case 1: //DNI
                call_user_func_array(array($this, "iniciarAtributos"), $parametros);
                break;
            case 10:
                call_user_func_array(array($this, "establecerEstado"), $parametros);
                break;
        }
    }



    /**
     * Método que inicia los atributos de la clase
     * 
     * @param String $dni
     *
     * @return void
     */
    private function iniciarAtributos($dni) {
        try {
            $sql = "select * from usuarios where dni = :dni";
            $sentencia = $this->conexionBD->prepare($sql);
            $sentencia->bindValue(':dni', $dni);
            $sentencia->execute();

            if ($sentencia->rowCount() == 1) {
                foreach ($sentencia->fetchAll(PDO::FETCH_ASSOC) as $fila) {
                    $this->dni = $fila['dni'];
                    $this->nombre = $fila['nombre'];
                    $this->apellidos = $fila['apellidos'];
                    $this->direccion = $fila['direccion'];
                    $this->codigoPostal = $fila['codigo_postal'];
                    $this->municipio = $fila['municipio'];
                    $this->provincia = $fila['provincia'];
                    $this->correo = $fila['correo'];
                    $this->contrasinal = $fila['contrasinal'];
                    $this->formaPago = $fila['forma_pago'];
                    $this->rol = $fila['rol'];
                }
            }
        } catch (PDOException $error) {
            echo ("Hubo un error al iniciar los atributos: $error");
        }
    }



    /**
     * Método que establece el estado de los atributos
     *
     * @param Array $datosUsuario
     * @return void
     */
    private function establecerEstado($dni, $nombre, $apellidos, $direccion, $codigoPostal, $municipio, $provincia, $correo, $telefono, $formaPago) {
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->direccion = $direccion;
        $this->codigoPostal = $codigoPostal;
        $this->municipio = $municipio;
        $this->provincia = $provincia;
        $this->correo = $correo;
        $this->telefono = $telefono;
        $this->formaPago = $formaPago;
        $this->contrasinal = password_hash('Abc123.', PASSWORD_DEFAULT);
    }



    /**
     * Método que almacena un usuario en la base de datos
     * 
     * @param String $dni
     * @param String $nombreApellidos
     * @param String $direccion
     * @param INT $codigoPostal
     * @param String $municipio
     * @param String $provincia
     * @param String $rol
     * @param String $correo
     * @param String $contrasinal
     * @param String $formaPago
     *
     * @return String Retorna un mensaje de éxito en el caso de que el usuario se guardó con éxito o un mensaje de error en caso contrario
     */
    public function guardarUsuario() {
        try {
            if (!$this->existeUsuario($this->dni)) {
                if ($this->foto == "" && $this->cuentaBancaria == "") {
                    $sql = "insert into usuarios (dni, nombre, apellidos, direccion, codigo_postal, municipio, provincia, rol, correo, telefono, contrasinal, forma_pago) values (:dni, :nombre, :apellidos, :direccion, :codigoPostal, :municipio, :provincia, :rol, :correo, :telefono, :contrasinal, :formaPago)";

                } else if ($this->foto != "" && $this->cuentaBancaria == ""){
                    $sql = "insert into usuarios (dni, nombre, apellidos, direccion, codigo_postal, municipio, provincia, rol, correo, telefono, contrasinal, forma_pago, foto) values (:dni, :nombre, :apellidos, :direccion, :codigoPostal, :municipio, :provincia, :rol, :correo, :telefono, :contrasinal, :formaPago, :foto)";

                } else if ($this->foto == "" && $this->cuentaBancaria != ""){
                    $sql = "insert into usuarios (dni, nombre, apellidos, direccion, codigo_postal, municipio, provincia, rol, correo, telefono, contrasinal, forma_pago, cuenta_bancaria) values (:dni, :nombre, :apellidos, :direccion, :codigoPostal, :municipio, :provincia, :rol, :correo, :telefono, :contrasinal, :formaPago, :cuentaBancaria)";

                } else {
                    $sql = "insert into usuarios (dni, nombre, apellidos, direccion, codigo_postal, municipio, provincia, rol, correo, telefono, contrasinal, forma_pago, cuenta_bancaria, foto) values (:dni, :nombre, :apellidos, :direccion, :codigoPostal, :municipio, :provincia, :rol, :correo, :telefono, :contrasinal, :formaPago, :cuentaBancaria, :foto)";
                }

                $sentencia = $this->conexionBD->prepare($sql);
                $sentencia->bindValue(':dni', $this->dni);
                $sentencia->bindValue(':nombre', $this->nombre);
                $sentencia->bindValue(':apellidos', $this->apellidos);
                $sentencia->bindValue(':direccion', $this->direccion);
                $sentencia->bindValue(':codigoPostal', $this->codigoPostal);
                $sentencia->bindValue(':municipio', $this->municipio);
                $sentencia->bindValue(':provincia', $this->provincia);
                $sentencia->bindValue(':rol', $this->rol);
                $sentencia->bindValue(':correo', $this->correo);
                $sentencia->bindValue(':telefono', $this->telefono);
                $sentencia->bindValue(':contrasinal', $this->contrasinal);
                $sentencia->bindValue(':formaPago', $this->formaPago);

                if ($this->cuentaBancaria != "") $sentencia->bindValue(":cuentaBancaria", $this->cuentaBancaria);
                if ($this->foto != "") $sentencia->bindValue(':foto', $this->foto);

                $sentencia->execute();

                return  $sentencia->rowCount();

            } else {
                return "El usuario ya existe en la base de datos";
            }
        } catch (PDOException $error) {
            die("Hubo un error al guardar el usuario: $error");
        }
    }



    /**
     * Método que obtiene los datos de un usuario en concreto
     *
     * @param String $parametro Puede ser el dni o el correo del usuario
     * @return Array
     */
    public function obtenerDatosUsuario($parametro) {
        try {

            if (preg_match("/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i", $parametro) == 1) {
                $sql = "select * from usuarios where correo = :correo";
                $sentencia = $this->conexionBD->prepare($sql);
                $sentencia->bindValue(':correo', $parametro);

            } else if (preg_match("/^[0-9]{8}[A-Za-z]{1}$/i", $parametro) == 1) {
                $sql = "select * from usuarios where dni = :dni";
                $sentencia = $this->conexionBD->prepare($sql);
                $sentencia->bindValue(':dni', $parametro);
               
            }

            $sentencia->execute();
            return $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $error) {
            die("Hubo un error al obtener los datos del usuario: " . $error->getMessage());
        }
    }



    /**
     * Método que borra un usuario
     *
     * @param String $dni dni del usuario a borrar
     * @return INT Retorna el núḿero de registros borrados
     */
    public function borrarUsuario($dni) {
        
        try {
            $sql = "delete from usuarios where dni = :dni";
            $sentencia = $this->conexionBD->prepare($sql);
            $sentencia->bindValue(':dni', $dni);
            return $sentencia->execute();

        } catch (PDOException $error) {
            die("Hubo un error al borrar el usuario: $error");
        }
    }



    /**
     * Método que comprueba si el usuario ya existe en la base de datos
     * 
     * @param String parametro Puede ser el dni o el correo
     * 
     * @return Boolean True -> existe; False -> no existe
     */
    public function existeUsuario($parametro) {
        try {
            if (preg_match("/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i", $parametro) == 1) {
                $sql = "select * from usuarios where correo = :correo";
                $sentencia = $this->conexionBD->prepare($sql);
                $sentencia->bindValue(':correo', $parametro);
            
            } else if (preg_match("/^[0-9]{8}[A-Za-z]{1}$/i", $parametro) == 1) {
                $sql = "select * from usuarios where dni = :dni";
                $sentencia = $this->conexionBD->prepare($sql);
                $sentencia->bindValue(':dni', $parametro);
            }

            $sentencia->execute();
            return $sentencia->rowCount() == 1 ? true : false;

        } catch (PDOException $error) {
            die("Hubo un error al acceder a la base de datos $error");
        }
    }



    /**
     * Método que cambia la contraseña de un usuario
     *
     * @param String $contrasinal
     * @param String $parametro dni|correo
     * @return INT Número de registros modifi
     */
    public function cambiarContrasinal($contrasinal, $parametro) {
        try {
            if ($this->existeUsuario($parametro)){
                $contrasinal = password_hash($contrasinal, PASSWORD_DEFAULT);
                if (preg_match("/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i", $parametro) == 1) {
                    $sql = "update usuarios set contrasinal = :contrasinal where correo = :correo";
                    $sentencia = $this->conexionBD->prepare($sql);
                    $sentencia->bindValue(':contrasinal', $contrasinal);
                    $sentencia->bindValue(':correo', $parametro);
                } else if (preg_match("/^[0-9]{8}[A-Za-z]{1}$/i", $parametro) == 1) {
                    $sql = "update usuarios set contrasinal = :contrasinal where dni = :dni";
                    $sentencia = $this->conexionBD->prepare($sql);
                    $sentencia->bindValue(':contrasinal', $contrasinal);
                    $sentencia->bindValue(':dni', $parametro);
                }

                $sentencia->execute();
                return $sentencia->rowCount();

            } else {
                return "El correo introducido es erróneo";
            }

        } catch (PDOException $error) {
            die("Hubo un error al cambiar la contraseña: $error");
        }
    }



    /**
     * Método que devuelve todos los datos de todos los usuarios
     *
     * @return Array
     */
    public function obtenerTodosUsuarios(){
        try {
            $sql = "select * from usuarios where rol = 'usuario'";
            $sentencia = $this->conexionBD->query($sql);
            $sentencia->execute();

            return $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $error) {
            die("Hubo un error al acceder a la base de datos $error");
        }
    }



    /**
     * Método que actualiza los datos de un usuario
     *
     * @return INT Número de registros actualizados
     */
    public function actualizarUsuario(){
        if ($this->foto == "" && $this->cuentaBancaria == "") {
            $sql = "update usuarios set dni = :dni, nombre = :nombre, apellidos = :apellidos, direccion = :direccion, codigo_postal = :codigoPostal, municipio = :municipio, provincia = :provincia, correo = :correo, telefono = :telefono, forma_pago = :formaPago where dni = :dni";

        } else if ($this->foto != "" && $this->cuentaBancaria == ""){
            $sql = "update usuarios set dni = :dni, nombre = :nombre, apellidos = :apellidos, direccion = :direccion, codigo_postal = :codigoPostal, municipio = :municipio, provincia = :provincia, correo = :correo, telefono = :telefono, forma_pago = :formaPago, foto = :foto where dni = :dni";

        } else if ($this->foto == "" && $this->cuentaBancaria != ""){
            $sql = "update usuarios set dni = :dni, nombre = :nombre, apellidos = :apellidos, direccion = :direccion, codigo_postal = :codigoPostal, municipio = :municipio, provincia = :provincia, correo = :correo, telefono = :telefono, forma_pago = :formaPago, cuenta_bancaria = :cuentaBancaria where dni = :dni";

        } else {
            $sql = "update usuarios set dni = :dni, nombre = :nombre, apellidos = :apellidos, direccion = :direccion, codigo_postal = :codigoPostal, municipio = :municipio, provincia = :provincia, correo = :correo, telefono = :telefono, forma_pago = :formaPago, cuenta_bancaria = :cuentaBancaria, foto = :foto where dni = :dni";
        }

        $sentencia = $this->conexionBD->prepare($sql);
        $sentencia->bindValue(':dni', $this->dni);
        $sentencia->bindValue(':nombre', $this->nombre);
        $sentencia->bindValue(':apellidos', $this->apellidos);
        $sentencia->bindValue(':direccion', $this->direccion);
        $sentencia->bindValue(':codigoPostal', $this->codigoPostal);
        $sentencia->bindValue(':municipio', $this->municipio);
        $sentencia->bindValue(':provincia', $this->provincia);
        $sentencia->bindValue(':correo', $this->correo);
        $sentencia->bindValue(':telefono', $this->telefono);
        $sentencia->bindValue(':formaPago', $this->formaPago);

        if ($this->cuentaBancaria != "") $sentencia->bindValue(":cuentaBancaria", $this->cuentaBancaria);
        if ($this->foto != "") $sentencia->bindValue(':foto', $this->foto);

        $sentencia->execute();

        return  $sentencia->rowCount();
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
     * Get the value of apellidos
     */
    public function getApellidos() {
        return $this->apellidos;
    }

    /**
     * Set the value of apellidos
     */
    public function setApellidos($apellidos): self {
        $this->apellidos = $apellidos;

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
     * Get the value of rol
     */
    public function getRol() {
        return $this->rol;
    }

    /**
     * Set the value of rol
     */
    public function setRol($rol): self {
        $this->rol = $rol;

        return $this;
    }

    /**
     * Get the value of correo
     */
    public function getCorreo() {
        return $this->correo;
    }

    /**
     * Set the value of correo
     */
    public function setCorreo($correo): self {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get the value of telefono
     */
    public function getTelefono() {
        return $this->telefono;
    }

    /**
     * Set the value of telefono
     */
    public function setTelefono($telefono): self {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get the value of contrasinal
     */
    public function getContrasinal() {
        return $this->contrasinal;
    }

    /**
     * Set the value of contrasinal
     */
    public function setContrasinal($contrasinal): self {
        $this->contrasinal = $contrasinal;

        return $this;
    }

    /**
     * Get the value of formaPago
     */
    public function getFormaPago() {
        return $this->formaPago;
    }

    /**
     * Set the value of formaPago
     */
    public function setFormaPago($formaPago): self {
        $this->formaPago = $formaPago;

        return $this;
    }

    /**
     * Get the value of cuentaBancaria
     */
    public function getCuentaBancaria() {
        return $this->cuentaBancaria;
    }

    /**
     * Set the value of cuentaBancaria
     */
    public function setCuentaBancaria($cuentaBancaria): self {
        $this->cuentaBancaria = $cuentaBancaria;

        return $this;
    }

    /**
     * Get the value of foto
     */
    public function getFoto() {
        return $this->foto;
    }

    /**
     * Set the value of foto
     */
    public function setFoto($foto): self {
        $this->foto = $foto;

        return $this;
    }
}

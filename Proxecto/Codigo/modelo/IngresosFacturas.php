<?php 

require_once "../modelo/ConexionBD.php";

abstract class IngresosFacturas{
    protected $conexionBD;

    public function __construct() {
        $this->conexionBD = new ConexionBD();
    }


    /**
     * Método que muestra los ingresos y las facturas de un usuario
     *
     * @param USUARIOS $usuario
     * @return Array
     */
    public function obtenerIngresosFacturas($usuario){
        try {
            switch($usuario->getRol()){
                case "usuario":
                    $sql = "select 'Ingreso' AS tipo, usuario, numero_ingreso, fecha, concepto, total, archivo from ingresos
                            union all 
                            select 'Factura' AS tipo, usuario, numero_factura, fecha, concepto, total, archivo from facturas
                            where usuario = :usuario
                            order by fecha desc limit 5";

                    $sentencia = $this->conexionBD->prepare($sql);
                    $sentencia->bindValue(':usuario', $usuario->getDni());
                break;
                
            case "administrador": 
                $sql = "select 'Ingreso' AS tipo, usuario, numero_ingreso, fecha, concepto, total, archivo from ingresos
                        union all 
                        select 'Factura' AS tipo, usuario, numero_factura, fecha, concepto, total, archivo from facturas
                        order by fecha desc limit 5";

                    $sentencia = $this->conexionBD->query($sql);
                break;
            }

            $sentencia->execute();
            return $sentencia->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $error) {
            echo "Hubo un error al consultar los últimos movimientos: $error";
        }
    }
}







?>
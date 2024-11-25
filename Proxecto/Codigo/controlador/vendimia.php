<?php 
//Añadimos los archivos del modelo
require_once "../modelo/DiasVendimia.php";
require_once "../modelo/AlbaranesEntrega.php";
require_once "../modelo/Recolecta.php";
require_once "../modelo/Usuarios.php";
require_once "funcionesControlador.php";

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    die();

} else {
    $usuario = new Usuarios($_SESSION['usuario']);
    $vendimia = new DiasVendimia();
    $albaranes = new AlbaranesEntrega($usuario->getDni());
    $recolecta = new Recolecta();
    require_once "../vista/funcionesVista.php";
    if ($usuario->getRol() == "usuario"){
        $fechasVendimia = cambiarFormatoFecha($vendimia->obtenerDiasVendimia($usuario->getDni()));
        $datosVendimia = $recolecta->obtenerDatosRecolecta("usuario", $usuario->getDni(), date("Y"));
        $listaAlbaranes = cambiarFormatoFecha($albaranes->obtenerAlbaranes($usuario->getDni(), date("Y")));
        $cajasVendimia = $vendimia->obtenerCajasVendimia($_SESSION['usuario']);

        require_once "../vista/vendimiaUsuarios.php";

    } else if ($usuario->getRol() == "administrador"){
        $datosVendimia = $recolecta->obtenerResumenRecolecta($recolecta->obtenerDatosRecolecta("todos", "", date("Y")));
        
        require_once "../vista/vendimiaAdmin.php";
    }
}

?>
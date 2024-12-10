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
    $diasVendimia = new DiasVendimia();
    require_once "../vista/funcionesVista.php";

    $fechaInicioVendimia = $diasVendimia->obtenerInicioFinVendimia("inicio", date("Y"));
    $fechaFinVendimia = $diasVendimia->obtenerInicioFinVendimia("fin", date("Y"));
    
    if ($usuario->getRol() == "usuario"){
        $fechasVendimia = cambiarFormatoFecha($vendimia->obtenerDatosDiasVendimia("fechas", $usuario->getDni(), date("Y")));
        $cajasVendimia = $vendimia->obtenerDatosDiasVendimia("cajas", $usuario->getDni(), date("Y"));
        $datosVendimia = $recolecta->obtenerDatosRecolecta("usuario", $usuario->getDni(), date("Y"));
        $listaAlbaranes = cambiarFormatoFecha($albaranes->obtenerAlbaranes($usuario->getDni(), date("Y")));

        require_once "../vista/vendimiaUsuarios.php";

    } else if ($usuario->getRol() == "administrador"){
        $datosVendimia = $recolecta->obtenerResumenRecolecta($recolecta->obtenerDatosRecolecta("todos", "", date("Y")));
        
        require_once "../vista/vendimiaAdmin.php";
    }
}

?>
<?php

//Añadimos los archivos del modelo
require_once "../modelo/Usuarios.php";
require_once "../modelo/Facturas.php";
require_once "../modelo/Ingresos.php";

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    die();

} else {
    require_once "../vista/funcionesVista.php";

    $usuario = new Usuarios($_SESSION['usuario']);
    $facturas = new Facturas();
    $ingresos = new Ingresos();

    if ($usuario->getRol() == "usuario"){
        $listaFacturas = $facturas->obtenerHistoricoFacturas("individualAno", $usuario->getDni(), date("Y"));
        $listaIngresos = $ingresos->obtenerIngresos($usuario, date("Y"));
    
        
        require_once "../vista/consultaDocumentosUsuario.php";

    } else if ($usuario->getRol() == "administrador"){
        require_once "../vista/consultaDocumentosAdmin.php";
    }
    
}

?>
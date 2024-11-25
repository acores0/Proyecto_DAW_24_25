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
    $usuario = new Usuarios($_SESSION['usuario']);
    require_once "../vista/funcionesVista.php";
    require_once "../vista/consultaUsuarios.php";
}


?>
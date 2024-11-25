<?php
require_once "../modelo/Usuarios.php";

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    die();

} else {
    $usuario = new Usuarios($_SESSION['usuario']);
    require_once "../vista/funcionesVista.php";
    require_once "../vista/altaUsuario.php";

}


?>
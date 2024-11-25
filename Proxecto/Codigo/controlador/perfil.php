<?php 
//Añadimos los archivos del modelo
require_once "../modelo/Parcelas.php";
require_once "../modelo/Usuarios.php";

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    die();

} else {
    $usuario = new Usuarios($_SESSION['usuario']);
    $datosUsuario = $usuario->obtenerDatosUsuario($usuario->getDni());

    $parcelas = new Parcelas();
    $listaParcelas = $parcelas->obtenerParcelasUsuario("usuario", $usuario->getDni());

    require_once "../vista/funcionesVista.php";
    require_once "../vista/perfil.php";
}

?>
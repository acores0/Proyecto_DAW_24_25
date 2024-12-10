<?php 
//Añadimos los archivos del modelo
$archivosModelo = glob('../modelo/*.php');

foreach ($archivosModelo as $archivo) {
    require_once $archivo;
}

//CAMBIAR LOS DATOS SIGUIENTES POR LOS DEL USUARIO ADMINISTRADOR: dni, nombre, apellidos y correo electrónico
$usuario = new Usuarios("46001270M", "Arancha", "Cores López", "", "", "", "", "administrador@baseinfodb3.es", "", "");
$usuario->setRol("administrador");
$usuario->guardarUsuario();

//NOTA IMPORTANTE: POR DEFECTO LA CONTRASEÑA ES: Abc123.

?>
<?php 

//Añadimos los archivos del modelo
//require_once "../modelo/Usuarios.php";

/*if (isset($_POST['btnEntrar'])){

    $correo = filter_input(INPUT_POST, "correoLogin", FILTER_VALIDATE_EMAIL);
    $contrasinal = filter_input(INPUT_POST, "contrasinalLogin");

    $usuario = new Usuarios();
    $resultado = $usuario->obtenerDatosUsuario($correo);

    if (count($resultado) == 1){
        foreach ($resultado as $fila){
            if(password_verify($contrasinal, $fila['contrasinal'])){
                $_SESSION['usuario'] = $fila['dni'];
                header("Location: ../controlador/dashboard.php");
                exit;
            }
        }
    } else {
        echo "Error en la base de datos";
    }
    

} else if (isset ($_POST['btnPasswd'])){
    $correo = filter_input(INPUT_POST, "correo", FILTER_VALIDATE_EMAIL);
    $contrasinal = filter_input(INPUT_POST, "contrasinal");
    $repetirContrasinal = filter_input(INPUT_POST, "repetirContrasinal");

    if ($contrasinal === $repetirContrasinal){
        $usuario = new Usuarios();

        if ($usuario->existeUsuario($correo)){
            //Encriptamos la contraseña
            $encriptarContrasinal = password_hash('abc123.', PASSWORD_DEFAULT);

            $usuario->cambiarContrasinal($contrasinal, $correo);
        }
    }



} else {*/
    require_once "../vista/funcionesVista.php";
    require_once "../vista/login.php";
//}

?>
<?php 

//Añadimos los archivos del modelo
$archivosModelo = glob('../modelo/*.php');

foreach ($archivosModelo as $archivo) {
    require_once $archivo;
}

require_once "funcionesControlador.php";

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    die();

} else {
    require_once "../vista/funcionesVista.php";

    $usuario = new Usuarios($_SESSION['usuario']);
    $ingresos = new Ingresos();
    $recolecta = new Recolecta();
    $facturas = new Facturas();
    $parcelas = new Parcelas();

    $listaIngresosFacturas = cambiarFormatoFecha($facturas->obtenerIngresosFacturas($usuario));

    if ($usuario->getRol() == "usuario"){
        
         //Variables resumen datos:

            //Pendiente cobrar
            $pendienteIngresos = $ingresos->obtenerPendienteIngreso($usuario);

            //Pendiente pagar
            $pendienteFacturas = $facturas->obtenerTotalDeuda($facturas->obtenerFacturasImpagadas("usuario", $usuario->getDni()), true);

            //Cupo
            $cupo = $parcelas->obtenerCupoTotal($parcelas->obtenerParcelasUsuario("todas", ""));   

            //Kg entregados
            $kgEntregados = $recolecta->obtenerKgEntregados($usuario, date("Y"));

            //Media grados
            $mediaGrados = $recolecta->obtenerMediaGraduacion($usuario, date("Y"));     

    
        require_once "../vista/dashboardUsuario.php";

    } else if ($usuario->getRol() == "administrador"){
        

        //Variables resumen datos:

            //Pendiente cobrar
            $pendienteFacturas = $facturas->obtenerTotalDeuda($facturas->obtenerFacturasImpagadas("todos", ""), true);

            //Pendiente pagar
            $pendienteIngresos = $ingresos->obtenerPendienteIngreso($usuario);

            //Proveedores de uva
            $numeroProveedores = count($usuario->obtenerTodosUsuarios());

            //Kg entregados
            $kgEntregados = $recolecta->obtenerKgEntregados($usuario, date("Y"));

            //Media grados
            $mediaGrados = $recolecta->obtenerMediaGraduacion($usuario, date("Y"));


        //Variables para mostrar la tabla de los usuarios con el pendientes de ingreso y cobro
        $listaUsuarios = $usuario->obtenerTodosUsuarios();
        
        require_once "../vista/dashboardAdmin.php";
    }
}

?>
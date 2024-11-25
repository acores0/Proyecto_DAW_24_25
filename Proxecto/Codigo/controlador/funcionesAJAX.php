<?php 
session_start();

//Añadimos los archivos del modelo
$archivosModelo = glob('../modelo/*.php');

foreach ($archivosModelo as $archivo) {
    require_once $archivo;
}

require_once "funcionesFormularios.php";
require_once "funcionesControlador.php";
require_once "../vista/funcionesVista.php";

$usuario = (isset($_SESSION['usuario'])) ? new Usuarios($_SESSION['usuario']) : new Usuarios();
$parcela = new Parcelas();
$factura = new Facturas();
$ingreso = new Ingresos();
$albaran = new AlbaranesEntrega();
$recolecta = new Recolecta();





/**
 * Código que devuelve las facturas o ingresos del usuairo
 */
if (filter_input(INPUT_POST, "obtenerDocumentos")){
    $documento = strip_tags(filter_input(INPUT_POST, "obtenerDocumentos"));
    $ano = strip_tags(filter_input(INPUT_POST, "ano"));

    switch  ($documento){
        case "facturas":
            $listaFacturas = ($usuario->getRol() == "administrador") ? $factura->obtenerHistoricoFacturas("individualAno", filter_input(INPUT_POST, "dni"), $ano) : $factura->obtenerHistoricoFacturas("individualAno", $usuario->getDni(), $ano);
            $array = [
                "facturas" => $listaFacturas,
                "rol" => $usuario->getRol()
            ];

            echo json_encode($array);
            break;

        case "ingresos":
            $listaIngresos = ($usuario->getRol() == "administrador") ? $ingreso->obtenerIngresos(new Usuarios(filter_input(INPUT_POST, "dni")), $ano) : $ingreso->obtenerIngresos($usuario, $ano);
            $array = [
               "ingresos" => $listaIngresos,
               "rol" => $usuario->getRol()
            ];

            echo json_encode($array);
            break;

        case "albaranes": case "mostrarAlbaranes":
            $listaAlbaranes = ($usuario->getRol() == "administrador") ? $albaran->obtenerAlbaranes(filter_input(INPUT_POST, "dni"), $ano) : $albaran->obtenerAlbaranes($usuario->getDni(), $ano);
            $array = [
                "albaranes" => $listaAlbaranes,
                "rol" => $usuario->getRol()
            ];

            echo json_encode($array);
            break;

        case "consultaRecolectas":
            $datosVendimia = $recolecta->obtenerResumenRecolecta($recolecta->obtenerDatosRecolecta("todos", "", $ano));
            $array = [
                "recolectas" => $datosVendimia,
                "rol" => $usuario->getRol()
            ];

            echo json_encode($array);
            break;

        case "ingresosFacturas":
            $dni = strip_tags(filter_input(INPUT_POST, "dni"));
            $listaFacturas = $factura->obtenerHistoricoFacturas("individualAno", $dni, $ano);
            $listaIngresos = $ingreso->obtenerIngresos(new Usuarios($dni), $ano);

            $array = [
                "facturas" => $listaFacturas,
                "ingresos" => $listaIngresos,
                "rol" => $usuario->getRol()
            ];

            echo json_encode($array);
            break;
    }
}



/**
 * Código para introducir datos en la base de datos a través de los formularios
 */
if (filter_input(INPUT_POST, "alta")){
    $tipoAlta = strip_tags(filter_input(INPUT_POST, "alta"));

    switch($tipoAlta){
        case "altaUsuario":
            echo json_encode(cargarUsuario("altaUsuario"));
            break;

        case "altaParcela":
            echo json_encode(altaParcela());
            break;

        case "altaFactura":
            echo json_encode(altaFactura());
            break;
            
        case "altaIngreso":
            echo json_encode(altaIngreso());
            break;

        case "altaAlbaran":
            echo json_encode(altaAlbaran());
            break;
    }
}




if (filter_input(INPUT_POST, "movimiento")){
    $accion = strip_tags(filter_input(INPUT_POST, "movimiento"));
    $id = strip_tags(filter_input(INPUT_POST, "id"));

    $movimiento = (substr($id, 0, 1) == "F") ? "factura" : "ingreso";

    if ($movimiento == "factura"){
        $datosTabla = $factura->obtenerDatosFactura($id);
                    
    } else if ($movimiento == "ingreso"){
        $datosTabla = $ingreso->obtenerDatosIngreso($id);
    }

    switch($accion){
        case "verMovimiento":
            modalMostrarMovimiento($movimiento, $datosTabla, $usuario->getRol());
            break;

        case "editarMovimiento":
            ($movimiento == "factura") ? modalEditarFactura($datosTabla, $usuario) : modalEditarIngreso($datosTabla, $usuario);
            break;
                
        case "eliminarMovimiento":
            echo json_encode(($movimiento == "factura") ? $factura->borrarFactura($id) : $ingreso->borrarIngreso($id));
            break;
    }
}



/**
 * Código que actualiza los datos de la base de datos
 */
if (filter_input(INPUT_POST, "editar")){
    $tipoEditar = strip_tags(filter_input(INPUT_POST, "editar"));

    switch ($tipoEditar){
        case "editarFactura":
            echo json_encode(editarFactura());
            break;

        case "editarIngreso":
            echo json_encode(editarIngreso());
            break;

        case "editarParcela":
            echo json_encode(editarParcela());
            break;
            
        case "editarPrecio":
            echo json_encode(editarPrecio());
            break;
    }
}




if (filter_input(INPUT_POST, "parcela")){
    $tipoAccion = strip_tags(filter_input(INPUT_POST, "parcela"));
    $id = strip_tags(filter_input(INPUT_POST, "id"));
    $datosParcela = $parcela->obtenerDatosParcela($id);

    switch($tipoAccion){
        case "verParcela": 
            modalMostrarParcela($datosParcela);
            break;

        case "obtenerDireccion":
            $devolverDireccion = [];
            foreach ($datosParcela as $parcela){
                $devolverDireccion['direccion'] = $parcela['direccion'];
                $devolverDireccion['municipio'] = $parcela['municipio'];
                $devolverDireccion['provincia'] = $parcela['provincia'];
            }

            echo json_encode($devolverDireccion);
            break;

        case "obtenerParcelasUsuario":
            echo json_encode($parcela->obtenerParcelasUsuario("usuario", $id));
            break;
    }
}



/**
 * Código que borrar datos de la base de datos
 */
if (filter_input(INPUT_POST, "borrar")){
    $tipoBorrar = strip_tags(filter_input(INPUT_POST, "borrar"));

    //Recoger array de JavaScript
    $archivos = json_decode(filter_input(INPUT_POST, "archivos"));
    $resultado = 0;

    
    switch($tipoBorrar){
        case "borrarVariosMovimientos":
            foreach($archivos as $archivo){
                if (substr($archivo, 0, 1) == "F") {
                    $resultado += $factura->borrarFactura($archivo);
                
                } else if (substr($archivo, 0 , 1) == "I"){
                    $resultado += $ingreso->borrarIngreso($archivo);
                }
            }

            break;

        case "borrarVariosAlbaranes":
            foreach ($archivos as $archivo){
                $resultado += $albaran->borrarAlbaran($archivo);
            }

            break;

        case "borrarVariasParcelas":
            foreach ($archivos as $archivo){
                $resultado += $parcela->borrarParcela($archivo);
            }

        break;
    }

    if ($resultado == count($archivos)){
        echo 1;
    } else {
        echo 0;
    }
}



if (filter_input(INPUT_POST, "albaranes")){
    $tipoAccion = strip_tags(filter_input(INPUT_POST, "albaranes"));
    $id = strip_tags(filter_input(INPUT_POST, "id"));

    switch($tipoAccion){
        case "verAlbaran":
            modalMostrarAlbaran($albaran->obtenerDatosAlbaran($id), $usuario->getRol());
            break;
        case "mostrarSeccionAlbaranes":
            $dni = strip_tags(filter_input(INPUT_POST, "dni"));
            $listaAlbaranes = cambiarFormatoFecha($albaran->obtenerAlbaranes($dni, date("Y")));
            $datosVendimia = $recolecta->obtenerDatosRecolecta("usuario", $dni, date("Y"));
            mostrarAlbaranes($usuario->getRol(), $listaAlbaranes, $datosVendimia);
            break;
    }
}



/**
 * Código para devolver las coordenadas de la dirección
 */
if (filter_input(INPUT_POST, "mapa")){
    header('Content-Type: text/html; charset=UTF-8');
    $direccion = filter_input(INPUT_POST, "direccion");
    $municipio = filter_input(INPUT_POST, "municipio");
    $provincia = filter_input(INPUT_POST, "provincia");

    $nuevaDireccion = dividirCadena($direccion) . "," . dividirCadena($municipio) . "," . dividirCadena($provincia);
    //$nuevaDireccion = dividirCadena("Santiago de Compostela");
    //$search_url = "https://nominatim.openstreetmap.org/search.php?q=$direccion,$municipio,$provincia&format=jsonv2";
    //$search_url = "https://nominatim.openstreetmap.org/search?q=Santiago de Compostela,Spain&format=jsonv2";
    //$search_url = "https://nominatim.openstreetmap.org/search.php?q=santiago+de+compostela&format=jsonv2";
    //$search_url = "https://nominatim.openstreetmap.org/search.php?q=Avenida%20Cambados%2016,Vilagarc%C3%ADa%20de%20Arousa,Pontevedra&format=jsonv2";
    //$search_url = "https://nominatim.openstreetmap.org/search.php?q=$direccion&format=jsonv2"; 
    $search_url = "https://nominatim.openstreetmap.org/search.php?q=$nuevaDireccion&format=jsonv2";
    $httpOptions = [
        "http" => [
        "method" => "GET",
        "header" => "User-Agent: Nominatim-Test"
        ]
    ];

    $streamContext = stream_context_create($httpOptions);
    $json = file_get_contents($search_url, false, $streamContext);

    //!COMPROBAR SI HAY RESULTADOS, DE LO CONTRARIO ERROR-> LA DIRECCIÓN ES INCORRECTA
    $decoded = json_decode($json, true);
    $lat = $decoded[0]["lat"];
    $lng = $decoded[0]["lon"];

    $array = array(
        "latitud" => $lat,
        "longitud" => $lng
    );

    echo json_encode($array);
}



/**
 * Código para devolver los datos de los gráficos
 */
if (filter_input(INPUT_POST, "grafico")){
    $datos = strip_tags(filter_input(INPUT_POST, "datosGrafico"));
    $rol = $usuario->getRol();

    switch($datos){
        case "kg":
            echo ($rol == "administrador") ? json_encode($recolecta->obtenerHistoricoKgEntregados()) : json_encode($recolecta->obtenerHistoricoKgEntregadosUsuario($usuario));
            break;
            
        case "mediaGrados":
            echo ($rol == "administrador") ? json_encode($recolecta->obtenerHistoricoMediaGraduacion()) : json_encode($recolecta->obtenerHistoricoMediaGraduacionUsuario($usuario));
            break;

        case "ingresosPagados":

            if ($rol == "administrador"){
                $totalDeuda = $factura->obtenerTotalDeuda($factura->obtenerFacturasImpagadas("todos", ""), false);
                $totalIngresos = $ingreso->obtenerTotalIngresos($ingreso->obtenerIngresos($usuario, date("Y")), false);

            } else if ($rol == "usuario"){
                $totalDeuda = $factura->obtenerTotalDeuda($factura->obtenerFacturasImpagadas("usuario", $usuario->getDni()), false);
                $totalIngresos = $ingreso->obtenerTotalIngresos($ingreso->obtenerIngresos($usuario, date("Y")), false);
            }

            $array = [
                "totalDeuda" => $totalDeuda,
                "totalIngresos" => $totalIngresos
            ];
            
            echo json_encode($array);
            break;

        case "ingresosGastos":
            $gastos = $factura->obtenerGastosUsuario($usuario->getDni());
            $ingresos = $ingreso->obtenerTotalIngresosAnos($usuario->getDni());

            $array = [
                "gastos" => $gastos,
                "ingresos" => $ingresos
            ];

            echo json_encode($array);
            break;
    }

}



if (filter_input(INPUT_POST, "usuarios")){
    switch(filter_input(INPUT_POST, "usuarios")){
        case "consultaUsuarios":
            $tipoConsulta = strip_tags(filter_input(INPUT_POST, "tipoConsulta"));

            if ($tipoConsulta == "todos"){   
                echo json_encode($usuario->obtenerTodosUsuarios());
    
            } else if ($tipoConsulta == "individual"){
                $dni = strip_tags(filter_input(INPUT_POST, "dni"));
                mostrarPerfilUsuario($usuario->obtenerDatosUsuario($dni), $usuario->getRol(), $parcela->obtenerParcelasUsuario("usuario", $dni));
            }
            break;

        case "cambiarContrasinal":
            $correo = strip_tags(filter_input(INPUT_POST, "correoContrasinal"));
            $contrasinal = strip_tags(filter_input(INPUT_POST, "cambiarContrasinal"));
            $repContrasinal = strip_tags(filter_input(INPUT_POST, "repContrasinal"));

            if ($contrasinal === $repContrasinal){
                if (password_verify($contrasinal, $usuario->getContrasinal())){          
                    if ($correo){
                        echo json_encode($usuario->cambiarContrasinal($contrasinal, $correo));
                    } else {
                        echo json_encode($usuario->cambiarContrasinal($contrasinal, $usuario->getDni()));
                    }
                } else {
                    echo json_encode("La contraseña introducida es la misma que la actual");
                }
            } else {
                echo json_encode("Las contraseñas introducidas no son iguales");
            }

            break;
 
        case "editarUsuario":
            echo json_encode(cargarUsuario("editarUsuario"));
            break;

        case "borrarUsuario":
            $dni = filter_input(INPUT_POST, "id");
            echo json_encode($usuario->borrarUsuario($dni));
            break;

        case "iniciarSesion":
            $correo = filter_input(INPUT_POST, "correoLogin", FILTER_VALIDATE_EMAIL);
            $contrasinal = filter_input(INPUT_POST, "contrasinalLogin");
            
            $resultado = $usuario->obtenerDatosUsuario($correo);
            
            if (count($resultado) == 1){
                foreach ($resultado as $fila){
                    if (password_verify($contrasinal, $fila['contrasinal'])){
                        session_regenerate_id(true);
                        $_SESSION['usuario'] = $fila['dni'];
                    } else {
                        echo json_encode("La contraseña introducida no es válida");
                    }
                }
            }
              
            echo json_encode(count($resultado));  
            break;
    }
}


if (filter_input(INPUT_POST, "ventanasModales")){
    switch(filter_input(INPUT_POST, "ventanasModales")){
        case "modalEditarPerfil":
            modalEditarPerfil($usuario->obtenerDatosUsuario($usuario->getDni()));
            break;

        case "modalMostrarParcela":
            modalMostrarParcela($parcela->obtenerDatosParcela(filter_input(INPUT_POST, "id")));
            break;
            
        case "modalAltaParcela":
            modalAltaParcela();
            break;
    }
}


/**
 * Código para devolver el número de ingreso o de factura
 */
if (filter_input(INPUT_POST, "calcularNumero")){
    $tipoNumero = strip_tags(filter_input(INPUT_POST, "calcularNumero"));

    switch($tipoNumero){
        case "numeroFactura":
            echo json_encode($factura->calcularNumeroFactura());
            break;

        case "numeroIngreso":
            echo json_encode($ingreso->calcularNumeroIngreso());
            break;
        case "numeroAlbaran":
            echo json_encode($albaran->calcularNumeroAlbaran());
            break;
    }
}


/**
 * Código que muestra los datos de la aplicación
 */
if (filter_input(INPUT_POST, "refrescar")){
    $refrescar = strip_tags(filter_input(INPUT_POST, "refrescar"));

    switch($refrescar){
        case "tablaUltimosMovimientos":
            mostrarTablaUltimosMovimientos($usuario->getRol(), $factura->obtenerIngresosFacturas($usuario));
            break;

        case "tablaRecolecta":
            $ano = filter_input(INPUT_POST, "ano");
            mostrarTablaResumenVendimia($recolecta->obtenerResumenRecolecta($recolecta->obtenerDatosRecolecta("todos", "", $ano)), $usuario->getRol());
            break;

        case "tablaAlbaranes":
            $dni = strip_tags(filter_input(INPUT_POST, "dni"));
            $ano = strip_tags(filter_input(INPUT_POST, "ano"));
            mostrarTablaAlbaranes("usuario", $albaran->obtenerAlbaranes($dni, $ano));
            break;

        case "tablaParcelas":
            $dni = strip_tags(filter_input(INPUT_POST, "dni"));
            mostrarTablaParcelas($usuario->getRol(), $parcela->obtenerParcelasUsuario("usuario", "dni"));
            break;
    }
}

?>
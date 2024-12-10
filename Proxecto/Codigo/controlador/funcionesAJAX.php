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
$diasVendimia = new DiasVendimia();




/**
 * Código para introducir datos en la base de datos a través de los formularios
 */
if (filter_input(INPUT_POST, "alta")){
    $tipoAlta = strip_tags(filter_input(INPUT_POST, "alta"));

    switch($tipoAlta){
        case "altaUsuario":
            echo json_encode(editarUsuario("altaUsuario"));
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

        case "altaDiasVendimia":
            echo json_encode(altaDiasVendimia()); //JSON_UNESCAPED_UNICODE);
            break;
    }
}


/**
 * Código que actualiza los datos de la base de datos
 */
if (filter_input(INPUT_POST, "editarDatos")){
    $tipoEditar = strip_tags(filter_input(INPUT_POST, "editarDatos"));

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

        case "editarAlbaran":
            echo json_encode(editarAlbaran());
            break;

        case "editarUsuario":
            echo json_encode(editarUsuario("editarUsuario"));
            break;

        case "editarDiasVendimia":
            echo json_encode(editarDiasVendimia());
            break;
    }
}


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

        case "albaranes": case "mostrarAlbaranes": case "consultaAlbaranes":
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

        case "ultimosMovimientos":
            $movimientos = $factura->obtenerIngresosFacturas($usuario);
            $array = [
                "movimientos" => $movimientos,
                "rol" => $usuario->getRol()
            ];

            echo json_encode($array);
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

        case "modalEditarMovimiento":
            ($movimiento == "factura") ? modalEditarFactura($datosTabla, $usuario) : modalEditarIngreso($datosTabla, $usuario);
            break;
                
        case "eliminarMovimiento":
            echo json_encode(($movimiento == "factura") ? $factura->borrarFactura($id) : $ingreso->borrarIngreso($id));
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

        case "modalEditarParcela":
            modalEditarParcela($datosParcela);
            break;

        case "borrarParcela":
            echo json_encode($parcela->borrarParcela($id));
            break;
    }
}



if (filter_input(INPUT_POST, "diasVendimia")){
    $accion = strip_tags(filter_input(INPUT_POST, "diasVendimia"));

    switch ($accion) {
        case "mostrarSeccionDiasVendimia":
            $dni = strip_tags(filter_input(INPUT_POST, "dniDiasVendimia"));
            mostrarDiasVendimia($diasVendimia->obtenerDatosDiasVendimia("todos", $dni, date("Y")));
            break;

        case "modalEditarDiasVendimia":
            $id = strip_tags(filter_input(INPUT_POST, "id"));
            modalEditarDiasVendimia($diasVendimia->obtenerDiaVendimia($id), $usuario);
            break;

        case "datosVendimia":
            $dni = strip_tags(filter_input(INPUT_POST, "dni"));
            echo json_encode($diasVendimia->obtenerDatosDiasVendimia("todos", $dni, date("Y")));
            break;

        case "borrarDiaVendimia":
            $id = strip_tags(filter_input(INPUT_POST, "id"));
            echo json_encode($diasVendimia->borrarDiasVendimia($id));
            break;
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
            $listaAlbaranes = $albaran->obtenerAlbaranes($dni, date("Y"));
            $datosVendimia = $recolecta->obtenerDatosRecolecta("usuario", $dni, date("Y"));
            mostrarAlbaranes($usuario->getRol(), $listaAlbaranes, $datosVendimia);
            break;

        case "modalEditarAlbaran":
            modalEditarAlbaran($albaran->obtenerDatosAlbaran($id), $usuario);
            break;

        case "borrarAlbaran":
            echo json_encode($albaran->borrarAlbaran($id));
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
                $datosUsuario = $usuario->obtenerDatosUsuario($correo);

                if (count($datosUsuario) == 1){
                    $contrasinalBD = count($_SESSION) == 0 ? $datosUsuario[0]['contrasinal'] : $usuario->getContrasinal();

                    if (!password_verify($contrasinal, $contrasinalBD)){          
                        if ($correo){
                            echo json_encode($usuario->cambiarContrasinal($contrasinal, $correo));
                        } else {
                            echo json_encode($usuario->cambiarContrasinal($contrasinal, $usuario->getDni()));
                        }
                    
                    } else {
                        echo json_encode("La contraseña introducida es la misma que la actual");
                    }   
                } else {
                    echo json_encode("Las credenciales introducidas son erróneas");
                }
            } else {
                echo json_encode("Las contraseñas introducidas no son iguales");
            }

            break;
 

        case "borrarUsuario":
            $dni = strip_tags(filter_input(INPUT_POST, "id"));

            if ($usuario->existeUsuario($dni)){
                $albaran->borrarAlbaranesUsuario($dni);
                $parcela->borrarParcelasUsuario($dni);
                $recolecta->borrarRecolectasUsuario($dni);
                $factura->borrarFacturasUsuario($dni);
                $ingreso->borrarIngresosUsuario($dni);
                $diasVendimia->borrarDiasVendimiaUsuario($dni);
                $usuario->borrarUsuario($dni);

                echo json_encode(true);

            } else {
                echo json_encode(false);
            }
            break;

        case "iniciarSesion":
            $correo = strip_tags(filter_input(INPUT_POST, "correoLogin", FILTER_VALIDATE_EMAIL));
            $contrasinal = strip_tags(filter_input(INPUT_POST, "contrasinalLogin"));
            
            $resultado = $usuario->obtenerDatosUsuario($correo);
            
            if (count($resultado) == 1){
                if (password_verify($contrasinal, $resultado[0]['contrasinal'])){
                    session_regenerate_id(true);
                    $_SESSION['usuario'] = $resultado[0]['dni'];
                    echo json_encode(count($resultado));  
                } else {
                    echo json_encode("La contraseña introducida no es válida");
                }
            } else {
                echo json_encode(0);
            }
            
            break;
    }
}


/**
 * Código que borra varios registros de la base de datos
 */
if (filter_input(INPUT_POST, "borrarVariosRegistros")){
    $tipoBorrar = strip_tags(filter_input(INPUT_POST, "borrarVariosRegistros"));

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

        case "borrarVariosDiasVendimia":
            foreach($archivos as $archivo){
                $resultado += $diasVendimia->borrarDiasVendimia($archivo);
            }

            break;
    }

    if ($resultado == count($archivos)){
        echo 1;
    } else {
        echo 0;
    }
}



if (filter_input(INPUT_POST, "ventanasModales")){
    $id = strip_tags(filter_INPUT(INPUT_POST, "id"));

    switch(filter_input(INPUT_POST, "ventanasModales")){
        case "modalEditarPerfil":
            modalEditarPerfil($usuario->obtenerDatosUsuario($id));
            break;

        case "modalMostrarParcela":
            modalMostrarParcela($parcela->obtenerDatosParcela($id));
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
    $dni = strip_tags(filter_input(INPUT_POST, "dni"));
    $ano = strip_tags(filter_input(INPUT_POST, "ano"));

    switch($refrescar){
        case "tablaUltimosMovimientos":
            mostrarTablaUltimosMovimientos($usuario->getRol(), $factura->obtenerIngresosFacturas($usuario));
            break;

        case "tablaRecolecta":
            mostrarTablaResumenVendimia($recolecta->obtenerResumenRecolecta($recolecta->obtenerDatosRecolecta("todos", "", $ano)), $usuario->getRol());
            break;

        case "tablaAlbaranes": 
            mostrarTablaAlbaranes($usuario->getRol(), $albaran->obtenerAlbaranes($dni, $ano));
            break;

        case "tablaParcelas":
            mostrarTablaParcelas($usuario->getRol(), $parcela->obtenerParcelasUsuario("usuario", $dni));
            break;

        case "tablaDiasVendimia":
            mostrarTablaDiasVendimiaAdmin($diasVendimia->obtenerDatosDiasVendimia("todos", $dni, date("Y")));
            break;            
    }
}



/**
 * Código para devolver las coordenadas de la dirección
 */
if (filter_input(INPUT_POST, "mapa")){
    $direccion = strip_tags(filter_input(INPUT_POST, "direccion"));
    $municipio = strip_tags(filter_input(INPUT_POST, "municipio"));
    $provincia = strip_tags(filter_input(INPUT_POST, "provincia"));

    $direccionCompleta = dividirCadena($direccion) . "," . dividirCadena($municipio) . "," . dividirCadena($provincia);
    $search_url = "https://nominatim.openstreetmap.org/search.php?q=$direccionCompleta&format=jsonv2";
    $httpOptions = [
        "http" => [
        "method" => "GET",
        "header" => "User-Agent: Nominatim-Test"
        ]
    ];

    $streamContext = stream_context_create($httpOptions);
    $json = @file_get_contents($search_url, false, $streamContext);
    $error = error_get_last();

    if ($json == false || http_response_code() >= 400){
        echo json_encode("La dirección introducida no es correcta");

    } else {

        $decoded = json_decode($json, true);
        $lat = $decoded[0]["lat"];
        $lng = $decoded[0]["lon"];

        $array = array(
            "latitud" => $lat,
            "longitud" => $lng
        );

        echo json_encode($array);
    }
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

?>
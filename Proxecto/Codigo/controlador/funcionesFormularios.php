<?php 

//Añadimos los archivos del modelo
$archivosModelo = glob('../modelo/*.php');

foreach ($archivosModelo as $archivo) {
    require_once $archivo;
}



/**
 * Función que almacena en la base de datos un nuevo usuario
 *
 * @return String/INT Mensaje de error o el número de registros guardados en la base de datos
 */
function editarUsuario($tipoCargaDatos){
    $dni = strip_tags(filter_input(INPUT_POST, "dni"));
    $nombre = strip_tags(filter_input(INPUT_POST, "nombre"));
    $apellidos = strip_tags(filter_input(INPUT_POST, "apellidos"));
    $direccion = strip_tags(filter_input(INPUT_POST, "direccion"));
    $cp = strip_tags(filter_input(INPUT_POST, "cp"));
    $municipio = strip_tags(filter_input(INPUT_POST, "municipio"));
    $provincia = strip_tags(filter_input(INPUT_POST, "provincia"));
    $correo = strip_tags(filter_input(INPUT_POST, "correo"));
    $telefono = strip_tags(filter_input(INPUT_POST, "telefono"));
    $formaPago = strip_tags(filter_input(INPUT_POST, "formaPago"));

    $usuario = new Usuarios($dni, $nombre, $apellidos, $direccion, $cp, $municipio, $provincia, $correo, $telefono, $formaPago);

    if ($formaPago == "domiciliado") $usuario->setCuentaBancaria(filter_input(INPUT_POST, "cuentaBancaria"));

    if (subirImagenPerfil($dni, $usuario)){
        switch($tipoCargaDatos){
            case "altaUsuario":
                return $usuario->guardarUsuario();
                break;

            case "editarUsuario":
                return $usuario->actualizarUsuario();
                break;
        } 

    } else {
        return "Error al cargar la imagen de perfil";
    }
}



/**
 * Función que almacena en la base de datos una nueva parcela
 *
 * @return String/INT Mensaje de error o el número de registros guardados en la base de datos
 */
function altaParcela(){
    $usuario = strip_tags(filter_input(INPUT_POST, "usuario"));
    $nombre = strip_tags(filter_input(INPUT_POST, "nombreParcela"));
    $m2 = strip_tags(filter_input(INPUT_POST, "m2Parcela"));
    $direccion = strip_tags(filter_input(INPUT_POST, "direccionParcela"));
    $codigoPostal = strip_tags(filter_input(INPUT_POST, "cpParcela"));
    $municipio = strip_tags(filter_input(INPUT_POST, "municipio"));
    $provincia = strip_tags(filter_input(INPUT_POST, "provincia"));
    $cupo = strip_tags(filter_input(INPUT_POST, "cupoParcela"));
    $variedad = strip_tags(filter_input(INPUT_POST, "variedadUva"));

    $parcela = new Parcelas($usuario, $nombre, $direccion, $municipio, $codigoPostal, $provincia, $m2, $variedad, $cupo);
    return $parcela->guardarParcela();
}



/**
 * Función que guarda una factura en la base de datos
 *
 * @return String/INT Mensaje de error o el número de registros guardados en la base de datos
 */
function altaFactura(){
    $numeroFactura = strip_tags(filter_input(INPUT_POST, "numeroFactura"));
    $fecha = strip_tags(filter_input(INPUT_POST, "fechaFactura"));
    $usuarioFactura = strip_tags(filter_input(INPUT_POST, "usuariosFactura"));
    $concepto = strip_tags(filter_input(INPUT_POST, "conceptoFactura"));
    $baseImponible = strip_tags(filter_input(INPUT_POST, "baseImponible"));
    $iva = strip_tags(filter_input(INPUT_POST, "iva"));
    $total = strip_tags(filter_input(INPUT_POST, "totalFactura"));
    $pagada = (strip_tags(filter_input(INPUT_POST, "facturaPagada")) == "pagada") ? 1 : 0;
    $archivo = $_FILES["facturaPDF"];

    $usuario = new Usuarios();
    if ($usuario->existeUsuario($usuarioFactura)){
        $factura = new Facturas($numeroFactura, $usuarioFactura, $concepto, $fecha, $baseImponible, $iva, $total, $pagada, $archivo);
        return $factura->guardarFactura();

    } else {
        return "El usuario seleccionado no existe en la base de datos";
    }
}



/**
 * Función que guarda un ingreso en la base de datos
 *
 * @return String/INT Mensaje de error o el número de registros guardados en la base de datos
 */
function altaIngreso(){
    $numeroIngreso = strip_tags(filter_input(INPUT_POST, "numeroIngreso"));
    $fecha = strip_tags(filter_input(INPUT_POST, "fechaIngreso"));
    $usuarioIngreso = strip_tags(filter_input(INPUT_POST, "usuariosIngreso"));
    $concepto = strip_tags(filter_input(INPUT_POST, "conceptoIngreso"));
    $ingresoBruto =  strip_tags(filter_input(INPUT_POST, "ingresoBruto"));
    $retencion =  strip_tags(filter_input(INPUT_POST, "retencion"));
    $total =  strip_tags(filter_input(INPUT_POST, "total"));
    $estado = strip_tags(filter_input(INPUT_POST, "estado"));
    $porcentajeRetencion = strip_tags(filter_input(INPUT_POST, "porcentajeRetencion"));
    $archivo = $_FILES['ingresoPDF'];

    $usuario = new Usuarios();
    if ($usuario->existeUsuario($usuarioIngreso)){
        $ingreso = new Ingresos($numeroIngreso, $usuarioIngreso, $fecha, $concepto, $ingresoBruto, $retencion, $porcentajeRetencion, $total, $estado, $archivo);
        return $ingreso->guardarIngreso();
        
    } else {
        return "El usuario seleccionado no existe en la base de datos";
    }
}



/**
 * Función que guarda un albarán en la base de datos
 *
 * @return String/INT Mensaje de error o el número de registros guardados en la base de datos
 */
function altaAlbaran(){
    $numeroAlbaran = strip_tags(filter_input(INPUT_POST, "numeroAlbaran"));
    $usuarioParcela = strip_tags(filter_input(INPUT_POST, "usuariosAlbaran"));
    $idParcela = strip_tags(filter_input(INPUT_POST, "parcelas"));
    $pesoBruto = strip_tags(filter_input(INPUT_POST, "pesoBruto"));
    $grado = strip_tags(filter_input(INPUT_POST, "grado"));
    $cajas = strip_tags(filter_input(INPUT_POST, "cajas"));
    $archivo = $_FILES['albaranPDF'];

    $usuario = new Usuarios($usuarioParcela);
    $parcela = new Parcelas();

    if ($usuario->existeUsuario($usuario->getDni()) && count($parcela->obtenerDatosParcela($idParcela)) == 1){
        $albaran = new AlbaranesEntrega($numeroAlbaran, $usuarioParcela, $idParcela, $pesoBruto, $grado, $cajas, $archivo);
        return $albaran->guardarAlbaran();

    } else {
        return "El usuario seleccionado no existe en la base de datos";
    }
 
}



/**
 * Función que guarda una día de vendimia y las cajas asignadas en la base de datos
 *
 * @return String/INT Mensaje de error o el número de registros guardados en la base de datos
 */
function altaDiasVendimia(){
    $usuario =  strip_tags(filter_input(INPUT_POST, "usuariosDiasVendimia"));
    $fecha =  strip_tags(filter_input(INPUT_POST, "fechaAltaDiasVendimia"));
    $numeroCajas =  strip_tags(filter_input(INPUT_POST, "altaCajas"));
    
    $diasVendimia = new DiasVendimia($usuario, $fecha, $numeroCajas);
    return $diasVendimia->guardarDiasVendimia();
}



/**
 * Función que guarda el precio de una campaña en la base de datos
 *
 * @return String/INT Mensaje de error o el número de registros modificados en la base de datos
 */
function editarPrecio(){
    $ano = strip_tags(filter_input(INPUT_POST, "anoPrecio"));
    $precio = strip_tags(filter_input(INPUT_POST, "precioRecolecta"));
    $porcentajeRetencion = strip_tags(filter_input(INPUT_POST, "porcentajeRetencion"));

    $recolecta = new Recolecta();
    return $recolecta->modificarPrecio($ano, $precio, $porcentajeRetencion);
}



/**
 * Función que actualiza los datos de una parcela
 *
 * @return String/INT Mensaje de error o el número de registros modificados en la base de datos
 */
function editarParcela(){
    $id = strip_tags(filter_input(INPUT_POST, "idParcela"));
    $usuario = strip_tags(filter_input(INPUT_POST, "usuario"));
    $nombre = strip_tags(filter_input(INPUT_POST, "nombreEditarParcela"));
    $direccion = strip_tags(filter_input(INPUT_POST, "direccionEditarParcela"));
    $municipio = strip_tags(filter_input(INPUT_POST, "municipio"));
    $codigoPostal = strip_tags(filter_input(INPUT_POST, "cpEditarParcela"));
    $provincia = strip_tags(filter_input(INPUT_POST, "provincia"));
    $m2 = strip_tags(filter_input(INPUT_POST, "m2EditarParcela"));
    $variedad = strip_tags(filter_input(INPUT_POST, "editarVariedadUva"));
    $cupo = strip_tags(filter_input(INPUT_POST, "cupoEditarParcela"));

    $parcela = new Parcelas($usuario, $nombre, $direccion, $municipio, $codigoPostal, $provincia, $m2, $variedad, $cupo);
    $parcela->setIdParcela($id);
    return $parcela->actualizarParcela();
}



/**
 * Función que actualizar¡ los datos de una factura
 *
 * @return String/INT Mensaje de error o el número de registros modificados en la base de datos
 */
function editarFactura(){
    $numeroFactura = strip_tags(filter_input(INPUT_POST, "numeroFactura"));
    $usuario = strip_tags(filter_input(INPUT_POST, "usuariosEditarFactura"));
    $fechaFactura = strip_tags(filter_input(INPUT_POST, "fechaEditarFactura"));
    $concepto = strip_tags(filter_input(INPUT_POST, "conceptoEditarFactura"));
    $baseImponible = strip_tags(filter_input(INPUT_POST, "editarBaseImponible"));
    $iva = strip_tags(filter_input(INPUT_POST, "ivaEditarFactura"));
    $totalFactura = strip_tags(filter_input(INPUT_POST, "editarTotalFactura"));
    $facturaPagada = strip_tags(filter_input(INPUT_POST, "facturaPagadaEditar") == "pagada") ? 1 : 0;
    $archivo = (isset($_FILES['editarFacturaPDF'])) ? $_FILES['editarFacturaPDF'] : "";

    $factura = new Facturas($numeroFactura, $usuario, $concepto, $fechaFactura, $baseImponible, $iva, $totalFactura, $facturaPagada, $archivo);
    return $factura->actualizarFactura();
}



/**
 * Función que actualiza los datos de un ingreso
 *
 * @return String/INT Mensaje de error o el número de registros modificados en la base de datos
 */
function editarIngreso(){
    $numeroIngreso = strip_tags(filter_input(INPUT_POST, "numeroIngreso"));
    $fechaIngreso = strip_tags(filter_input(INPUT_POST, "fechaEditarIngreso"));
    $usuario = strip_tags(filter_input(INPUT_POST, "usuariosEditarIngreso"));
    $concepto = strip_tags(filter_input(INPUT_POST, "conceptoEditarIngreso"));
    $ingresoBruto = strip_tags(filter_input(INPUT_POST, "editarIngresoBruto"));
    $retencion = strip_tags(filter_input(INPUT_POST, "retencionEditar"));
    $totalIngreso = strip_tags(filter_input(INPUT_POST, "editarTotalIngreso"));
    $archivo  = (isset($_FILES['ingresoEditarPDF'])) ? $_FILES['ingresoEditarPDF'] : "";
    $estado = strip_tags(filter_input(INPUT_POST, "estadoEditarIngreso"));
    $porcentaje = strip_tags(filter_input(INPUT_POST, "porcentajeRetencionEditar"));
    
    $ingreso = new Ingresos($numeroIngreso, $usuario, $fechaIngreso, $concepto, $ingresoBruto, $retencion, $porcentaje, $totalIngreso, $estado, $archivo);
    return $ingreso->actualizarIngreso();
}



/**
 * Función que actualiza los datos de un albarán
 *
 * @return String/INT Mensaje de error o el número de registros modificados en la base de datos
 */
function editarAlbaran(){
    $numeroAlbaran = strip_tags(filter_input(INPUT_POST, "numeroAlbaran"));
    $parcela = strip_tags(filter_input(INPUT_POST, "parcelas"));
    $grado = strip_tags(filter_input(INPUT_POST, "editarGrado"));
    $peso = strip_tags(filter_input(INPUT_POST, "editarPesoBruto"));
    $cajas = strip_tags(filter_input(INPUT_POST, "editarCajas"));
    $archivo = (isset($_FILES['editarAlbaranPDF'])) ? $_FILES['editarAlbaranPDF'] : "";
    
    $parcelas = new Parcelas();
    $datosParcela = $parcelas->obtenerDatosParcela($parcela);
    $albaran = new AlbaranesEntrega($numeroAlbaran, $datosParcela[0]['usuario'], $parcela, $peso, $grado, $cajas, $archivo);
    return $albaran->actualizarAlbaran();
}



/**
 * Función que actualiza los datos de un día de vendimia y sus cajas asignadas
 *
 * @return String/INT Mensaje de error o el número de registros modificados en la base de datos
 */
function editarDiasVendimia(){
    $id = strip_tags(filter_input(INPUT_POST, "id"));
    $usuario =  strip_tags(filter_input(INPUT_POST, "usuariosEditarDiasVendimia"));
    $fecha =  strip_tags(filter_input(INPUT_POST, "fechaEditarDiasVendimia"));
    $numeroCajas =  strip_tags(filter_input(INPUT_POST, "editarCajas"));
    
    $diasVendimia = new DiasVendimia($usuario, $fecha, $numeroCajas);
    return $diasVendimia->actualizarDiasVendimia($id);
}
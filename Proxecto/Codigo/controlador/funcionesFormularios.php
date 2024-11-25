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
function cargarUsuario($tipoCargaDatos){
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

    if (subirImagen($dni, $usuario)){
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
 * Función para cargar una inmagen en el servidor
 *
 * @param String $dni
 * @param USUARIOS $usuario
 * @return Boolean
 */
function subirImagen($dni, $usuario){
    if ($_FILES['imagenPerfil']['size'] > 0){
        $nombreImagen = $dni . "." . substr($_FILES['imagenPerfil']['name'], -3);
        $origen = $_FILES['imagenPerfil']['tmp_name'];
        $destino = "../documentosUsuarios/imagenesUsuarios/" . $nombreImagen;

        $usuario->setFoto($nombreImagen);

        return (!move_uploaded_file($origen, $destino)) ? false : true;

    } else {
        return true;
    }
}



/**
 * Función que almacena en la base de datos una nueva parcela
 *
 * @return INT Número de registros guardados en la base de datos
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
 * @return INT Número de registros guardados en la base de datos
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

    $usuario = new Usuarios();
    if ($usuario->existeUsuario($usuarioFactura)){
        $factura = new Facturas($numeroFactura, $usuarioFactura, $concepto, $fecha, $baseImponible, $iva, $total, $pagada);
        $factura->setArchivo($_FILES["facturaPDF"]);

        return $factura->guardarFactura();

    } else {
        return "El usuario seleccionado no existe en la base de datos";
    }
}



/**
 * Función que guarda un ingreso en la base de datos
 *
 * @return INT Número de registros guardados en la base de datos
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

    $usuario = new Usuarios();
    if ($usuario->existeUsuario($usuarioIngreso)){
        $ingreso = new Ingresos($numeroIngreso, $usuarioIngreso, $fecha, $concepto, $ingresoBruto, $retencion, $porcentajeRetencion, $total, $estado);
        $ingreso->setArchivo($_FILES['ingresoPDF']);

        return $ingreso->guardarIngreso();
        
    } else {
        return "El usuario seleccionado no existe en la base de datos";
    }
}



/**
 * Función que guarda un albarán en la base de datos
 *
 * @return INT Número de registros guardados en la base de datos
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
 * Función que guarda el precio de una campaña en la base de datos
 *
 * @return INT Número de registros modificados
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
 * @return INT Número de registros actualizados
 */
function editarParcela(){
    $usuario = strip_tags(filter_input(INPUT_POST, "usuario"));
    $nombre = strip_tags(filter_input(INPUT_POST, "nombreParcela"));
    $direccion = strip_tags(filter_input(INPUT_POST, "direccionParcela"));
    $municipio = strip_tags(filter_input(INPUT_POST, "municipioParcela"));
    $codigoPostal = strip_tags(filter_input(INPUT_POST, "cpParcela"));
    $provincia = strip_tags(filter_input(INPUT_POST, "provinciaParcela"));
    $m2 = strip_tags(filter_input(INPUT_POST, "m2Parcela"));
    $variedad = strip_tags(filter_input(INPUT_POST, "variedadUva"));
    $cupo = strip_tags(filter_input(INPUT_POST, "cupoParcela"));

    $parcela = new Parcelas($usuario, $nombre, $direccion, $municipio, $codigoPostal, $provincia, $m2, $variedad, $cupo);
    return $parcela->actualizarParcela();
}



/**
 * Función que actualizar¡ los datos de una factura
 *
 * @return INT Número de registros actualizados
 */
function editarFactura(){
    $numeroFactura = strip_tags(filter_input(INPUT_POST, "numeroFactura"));
    $usuario = strip_tags(filter_input(INPUT_POST, "usuario"));
    $fechaFactura = strip_tags(filter_input(INPUT_POST, "fechaFactura"));
    $concepto = strip_tags(filter_input(INPUT_POST, "concepto"));
    $baseImponible = strip_tags(filter_input(INPUT_POST, "baseImponible"));
    $iva = strip_tags(filter_input(INPUT_POST, "iva"));
    $totalFactura = strip_tags(filter_input(INPUT_POST, "totalFactura"));
    $facturaPagada = strip_tags(filter_input(INPUT_POST, "facturaPagada"));
    $archivo = (isset($_FILES['facturaPDF'])) ? $_FILES['facturaPDF'] : "";

    $factura = new Facturas($numeroFactura, $usuario, $concepto, $fechaFactura, $baseImponible, $iva, $totalFactura, $facturaPagada, $archivo);
    return $factura->actualizarFactura();
}



/**
 * Función que actualiza los datos de un ingreso
 *
 * @return INT Número de registros actualizados
 */
function editarIngreso(){
    $numeroIngreso = strip_tags(filter_input(INPUT_POST, "numeroIngreso"));
    $fechaIngreso = strip_tags(filter_input(INPUT_POST, "fechaIngreso"));
    $usuario = strip_tags(filter_input(INPUT_POST, "usuarios"));
    $concepto = strip_tags(filter_input(INPUT_POST, "conceptoIngreso"));
    $ingresoBruto = strip_tags(filter_input(INPUT_POST, "ingresoBruto"));
    $retencion = strip_tags(filter_input(INPUT_POST, "retencion"));
    $totalIngreso = strip_tags(filter_input(INPUT_POST, "total"));
    $archivo  = (isset($_FILES['ingresoPDF'])) ? $_FILES['ingresoPDF'] : "";
    $estado = strip_tags(filter_input(INPUT_POST, "estado"));
    $porcentaje = strip_tags(filter_input(INPUT_POST, "porcentajeRetencion"));
    
    $ingreso = new Ingresos($numeroIngreso, $usuario, $fechaIngreso, $concepto, $ingresoBruto, $retencion, $porcentaje, $totalIngreso, $estado, $archivo);
    return $ingreso->actualizarIngreso();
}
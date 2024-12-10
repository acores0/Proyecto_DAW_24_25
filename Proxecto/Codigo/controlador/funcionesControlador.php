<?php 

/**
 * Función que devuelve una cadena separando cada palabra con el signo +
 *
 * @param String $cadena a cambiar
 * @return String
 */
function dividirCadena($cadena){
    $tildes = ["Á", "á", "É", "é", "Í", "í", "Ó", "ó", "Ú", "ú", ",", " "];
    $sinTildes = [ "A", "a", "E", "e", "I", "i", "O", "o", "U", "u", "", "+"];
    $cadena = str_replace($tildes, $sinTildes, $cadena);

    return $cadena;
}



/**
 * Función que cambia el formato de la fecha (yyyy-mm-dd --> dd/mm/yyyy)
 *
 * @param Array $arrayDatos Array con los datos a cambiar
 * @return Array
 */
function cambiarFormatoFecha($array){
    $devolverArray = [];

    foreach ($array as $fila){
        $arrayFila = [];

        foreach ($fila as $clave => $valor) {
            if ($clave == "fecha" || $clave == "fecha_hora"){
                $ano = substr($valor, 0, 4);
                $mes = substr($valor, 5, 2);
                $dia = substr($valor, 8, 2);


                switch($clave){
                    case "fecha":
                        $valor = $dia . "/" . $mes . "/" . $ano;
                        break;

                    case "fecha_hora":
                        $hora = substr($valor, 10);
                        $valor = $dia . "/" . $mes . "/" . $ano . $hora;
                        break;       
                }
            }

            $arrayFila[$clave] = $valor;    
        }

        array_push($devolverArray, $arrayFila);
    }

    return $devolverArray;
}



/**
 * Función que sube un archivo al servidor
 *
 * @param FILE $archivo Array con los datos del archivo
 * @param String $nombreArchivo Nombre del archivo
 * @return Boolean
 */
function subirPDF($archivo, $numeroDocumento){
    $tipoDocumento = substr($numeroDocumento, 0, 1);
    $rutaArchivo = "";

    switch($tipoDocumento){
        case "F":
            $rutaArchivo = "../documentosUsuarios/archivosFacturas/";
            break;

        case "I":
            $rutaArchivo = "../documentosUsuarios/archivosIngresos/";
            break;

        case "A":
            $rutaArchivo = "../documentosUsuarios/archivosAlbaranes/";
            break;
    }

    $origen = $archivo['tmp_name'];
    $nombreArchivo = str_replace( "/", "_", $numeroDocumento);
    $destino = $rutaArchivo . $nombreArchivo . ".pdf";
    
    return (!move_uploaded_file($origen, $destino)) ? false : true;  
}



/**
 * Función para cargar la imagen de perfil del usuario en el servidor
 *
 * @param String $dni DNI del usuario
 * @param USUARIOS $usuario Objeto usuarios
 * @return Boolean
 */
function subirImagenPerfil($dni, $usuario){
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


?>
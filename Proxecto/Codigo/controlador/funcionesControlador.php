<?php 
//require_once "../modelo/Parcelas.php";

function mapa($direccion, $municipio){
    //$search_url = "https://nominatim.openstreetmap.org/search?q=$direccion,$municipio&format=json";
    //$search_url = "https://nominatim.openstreetmap.org/search?q=Santiado de Compostela,Spain&format=json";
    $search_url = "https://nominatim.openstreetmap.org/search.php?q=santiago+de+compostela&format=jsonv2";
    $httpOptions = [
        "http" => [
        "method" => "GET",
        "header" => "User-Agent: Nominatim-Test"
        ]
    ];

    $streamContext = stream_context_create($httpOptions);
    $json = file_get_contents($search_url, false, $streamContext);

    $decoded = json_decode($json, true);
    $lat = $decoded[0]["lat"];
    $lng = $decoded[0]["lon"];

    $array = array(
        "latitude" => $lat,
        "lonxitude" => $lng
    );

    return $array;
}


//!TERMINAR --> MAPA
/**
 * Función que deveuelve una cadena separando cada palabra con el signo +
 *
 * @param String $cadena
 * @return String
 */
function dividirCadena($cadena){
    /*$letrasCadena = str_split($cadena);
    $cadenaSinTildes = "";*/

    //for ($i = 0; $i < count($letrasCadena); $i++){
    for ($i = 0; $i < strlen($cadena); $i++) {
        $prueba = $cadena[$i];
        switch($cadena[$i]){
            case "á": case "Á":
                $cadena[$i] = ($cadena[$i] == "á") ? "á" : "Á";
                break;

            case "é": case "É":
                $cadena[$i] = ($cadena[$i] == "é") ? "é" : "É";
                break;

            case "í": case "Í":
                $cadena[$i] = ($cadena[$i] == "í") ? "í" : "Í";
                break;

            case "ó": case "Ó":
                $cadena[$i] = ($cadena[$i] == "ó") ? "ó" : "Ó";
                break;

            case "ú": case "Ú":
                $cadena[$i] = ($cadena[$i] == "ú") ? "ú" : "Ú";
                break;
        }

        //$cadenaSinTildes .= $letrasCadena[$i];
        
    }

    
    


    $array = explode(" ", $cadena);
    $nuevaCadena = "";
    
    for ($i = 0; $i < count($array); $i++){
        $nuevaCadena .= ($i == count($array) - 1) ? $array[$i] : $array[$i] . "+";
    }

    return $nuevaCadena;
}



/**
 * Función que cambia el formato de la fecha (yyyy-mm-dd --> dd/mm/yyyy)
 *
 * @param Array $listaFechas
 * @return Array
 */
function cambiarFormatoFecha($array){
    $devolverArray = [];

    foreach ($array as $fila){
        $arrayFila = [];

        foreach ($fila as $clave => $valor) {
            if ($clave == "fecha"){
                $ano = substr($valor, 0, 4);
                $mes = substr($valor, 5, 2);
                $dia = substr($valor, 8, 2);

                $valor = $dia . "/" . $mes . "/" . $ano;
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
 * @param FILE $archivo
 * @param String $nombreArchivo
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


?>
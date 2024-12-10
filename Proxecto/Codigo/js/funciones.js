//--------- Funciónes de las ventanas modales ---------
/**
 * Función para abrir las ventanas modales
 * @param {*} ventanaModal Ventana modal a abrir
 */
export function abrirVentanaModal(ventanaModal){
    ventanaModal[0].showModal();
    
}

/**
 * Función que cierra las ventanas modales
 * @param {*} ventanaModal Ventana modal a cerrar
 */
export function cerrarVentanaModal(ventanaModal){
    ventanaModal[0].close();
}






//-------------------- Funciones para validar los formularios --------------------
/**
 * Función para validar los formularios
 * @param {String} idFormulario ID del formulario a validar
 * @returns Boolean
 */
export function validarFormulario(idFormulario){
    let inputsFormulario = $(`#${idFormulario} input, #${idFormulario} select`);

    let error = "";
    for (let input of inputsFormulario){
        if (input.type != "submit"){
            error = validarCamposFormulario(input.className, input.id);

            if (error != "") return false;
        }
    }

    return true;
}



/**
 * Función que valida los inputs de los formularios
 * 
 * @param {String} claseInput clase del input a validar
 * @param {String} idInput ID del input a validar
 * @returns String Mensaje de error o ""
 */
export function validarCamposFormulario(claseInput, idInput){
    let tipoInput = claseInput.split(' ')[0];

    switch (tipoInput){
        case "dni":
            return validarDNI(idInput);
            break;

        case "texto":
            return validarCamposTexto(idInput);
            break;

        case "contrasinal":
            return validarContrasinal(idInput);
            break;

        case "codigoPostal":
            return validarCodigoPostal(idInput);
            break;

        case "correo":
            return validarCorreoElectronico(idInput);
            break;

        case "telefono":
            return validarTelefono(idInput);
            break;

        case "select":
            return validarSelect(idInput);
            break;

        case "cuentaBancaria":
            return validarCuentaBancaria(idInput);
            break;

        case "numero":
            return validarCampoNumero(idInput);
            break;

        case "archivo":
            return validarArchivo(idInput);
            break;

        case "fecha":
            return validarFecha(idInput);
            break;

        case "contrasinal":
            return validarContrasinal(idInput);
            break;

        default:
            return ""
            break;
    }
}



/**
 * Función que comprueba si una imagen se añadió al input y la previsualiza
 * @param {*} e Evento asociado
 * @param {String} imagenActual Ruta de la imagen actual en el servidor
 */
export function previsualizarImagen(e, imagenActual){  
    let imagen = e.target.files[0];
    
    if (imagen){
        if (imagen.type == "image/png" || imagen.type == "image/jpg" || imagen.type == "image/webp" || imagen.type == "image/jpeg") {
            const fr = new FileReader();
            fr.onload = function (event) {
                $("#imagenUsuario").attr("src", event.target.result);
                $("#imagenUsuario").attr("alt", "Imagen de perfil del usuario");
            }

            fr.readAsDataURL(imagen);

        } else {
            mostrarNotificacionError($("#imagenUsuario").closest("form").attr("id"), "La imagen debe ser .png, .jpg o .webp");
        }
    
    } else {
        $("#imagenUsuario").attr("src", imagenActual);
    }
}



/**
 * Función que valida un dni
 * @param {String} ID del input DNI
 * @returns String Mensaje de error o ""
 */
function validarDNI(idInput){
    let letrasDni = ["T", "R", "W", "A", "G", "M", "Y", "F ", "P", "D", "X", "B", "N", "J", "Z", "S", "Q", "V", "H", "L", "C", "K", "E"];
    let patronDni = /^\d{8}[A-Za-z]$/;
    let patronDniNumeros = /^\d{8}$/;
    let dni = $(`#${idInput}`).val();
    let resto, letra;

    if (dni == ""){
        return "Introduce el DNI";
    
    } else if (patronDniNumeros.test(dni)){
        resto = parseInt(dni) % 23;
        letra = letrasDni[resto];
        $(`#${idInput}`).val(dni + letra);
        return "";
        

    //Si el dni coincide con el patrón comprobamos si la letra introducida es correcta
    } else if(patronDni.test(dni)){
        letra = dni.substring(8).toUpperCase();
        resto = Math.trunc(parseInt(dni.substring(0, 8)) % 23);
        return letrasDni[resto] == letra ? "" : "La letra es incorrecta para el DNI introducido";

    } else {
        return "El DNI introducido es incorrecto";
    }
}



/**
 * Función que valida un campo de texto
 * @param {String} idINput Id del input a validar
 * @returns String Mensaje de error o ""
 */
function validarContrasinal(idInput){
    let patronContrasinal = /^(?=.*[A-z])(?=.*[A-Z])(?=.*[0-9])\S{6,}$/;
    let contrasinal =  $(`#${idInput}`).val();

    if (contrasinal == ""){
        return "Introduce la contraseña";
    } else if (!patronContrasinal.test(contrasinal)){
        return "La contraseña introducida no cumple los requisitos: mínimo 6 caracteres, 1 mayúscula, 1 minúscula y 1 número";
    } else {
        return "";
    }
}



/**
 * Función que valida un campo de una contraseña
 * @param {String} idInput Id del input a validar
 * @returns String Mensaje de error o ""
 */
function validarCamposTexto(idInput){
    let texto =  $(`#${idInput}`).val();
    let nombreLabel = $(`#${idInput} ~ label`)[0].textContent;
    return texto == "" ? `Introduce el campo ${nombreLabel}` : "";
}



/**
 * Función que valida el código postal
 * @param {String} idInput Id del input a validar
 * @returns String Mensaje de error o ""
 */
function validarCodigoPostal(idInput){
    let patronCP = /^\d{5}$/;
    let codigoPostal = $(`#${idInput}`).val();

    if (codigoPostal == ""){
        return "Introduce el código postal";
    
    } else if (!patronCP.test(codigoPostal)){
        return "El código postal introducido no es válido";

    }

    return "";
}



/**
 * Función que valida un correo electrónico
 * @param {String} idInput Id del input a validar
 * @returns String Mensaje con el error o ""
 */
function validarCorreoElectronico(idInput){
    let patronCorreo = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    let correo = $(`#${idInput}`).val();

    if (correo == "") {
        return "Introduce el correo";
    } else {
        return patronCorreo.test(correo) ? "" : "El correo electrónico no es válido";
    }
}



/**
 * Función que valida un teléfono
 * @param {String} idInput Id del input a validar
 * @returns String Mensaje con el error o ""
 */
function validarTelefono(idInput){
    let patronTelefono = /^\d{9}$/;
    let telefono = $(`#${idInput}`).val();

    if (telefono == ""){
        return "Introduce el teléfono";
    
    } else {
        return patronTelefono.test(telefono) ? "" : "El teléfono es incorrecto";
    }
}



/**
 * Función que valida un campo que debe contener números
 * @param {String} idInput Id del input a validar
 * @returns String Mensaje con el error o ""
 */
function validarCampoNumero(idInput){
    let numero = $(`#${idInput}`).val();
    let nombreCampo = $(`#${idInput} ~ label`)[0].textContent;


    if (numero == ""){
        return `Introduce el campo ${nombreCampo}`;

    } else if (numero == 0){
        return `El campo ${nombreCampo} debe ser mayor que 0`;

    } else if (idInput == "porcentajeRetencion" && numero > 100){
        return "El porcentaje de retención no puede ser superior a 100";

    } else {
        return (!isNaN(Number(numero))) ? "" : `El campo ${nombreCampo} debe ser un número`;
    }
}



/**
 * Función que valida los selects
 * @param {String} idSelect ID del select a validar
 * @returns Mensaje de error o ""
 */
function validarSelect(idSelect){
    let valorSelect = $(`#${idSelect}`).val();

    idSelect = idSelect.toLowerCase();

    if (idSelect.includes("formapago")){
        if (valorSelect == "predeterminado"){
            return "Selecciona una forma de pago";

        } else if (valorSelect == "cheque" || valorSelect == "contado"){
            return "";

        } else if (valorSelect == "domiciliado"){
            return validarCuentaBancaria();
        }

    } else if (idSelect.includes("usuarios")){
        return (valorSelect == "predeterminado") ? "Selecciona un usuario" : "";

    } else if (idSelect.includes("iva")){
        if (valorSelect == "predeterminado"){
            return "Selecciona un valor de IVA";

        } else if (valorSelect == "21" || valorSelect == "10" || valorSelect == "4"){
            return "";
        }

    } else if (idSelect.includes("parcelas")){
        return (valorSelect == "predeterminado") ? "Selecciona una parcela" : "";

    } else if (idSelect.includes("estado")){
        return (valorSelect == "predeterminado") ? "Selecciona un estado" : "";  

    } else if (idSelect.includes("pagada")){
        return (valorSelect == "predeterminado") ? "Selecciona el estado de la factura" : "";  
    }
}



/**
 * Función que valida una cuenta bancaria
 * @param {String} idInput ID del input de la cuenta bancaria
 * @returns Mensaje de error o ""
 */
function validarCuentaBancaria(idInput){
    let patronBanco = /^([A-Z]{2}\d{2}\s\d{4}\s\d{4}\s\d{2}\s\d{10})||([A-Z]{2}\d{22})$/;
    let cuentaBanco = $(`#${idInput}`).val();
    let select = $(`#${idInput}`).closest("form select").attr("id");

    switch(select){
        case "formaPago":
            if ($(`#${idInput}`).val() == "domiciliado"){

            if (cuentaBanco == ""){
                return "Introduce la cuenta del banco";

            } else {
                return patronBanco.test(cuentaBanco) ? "" : "La cuenta bancaria introducida no es correcta";
            }
        }
    }

    return "";
}



/**
 * Función que valida que esté seleccionado un archivo
 * @param {String} idInput ID del input file
 * @returns String Mensaje de error o ""
 */
function validarArchivo(idInput){
    return ($(`#${idInput}`).files != "") ? "" : "Sube el archivo de la factura";

}



/**
 * Función que valida si una fecha es correcta
 * @param {String} idInput ID del input fecha
 * @returns Mensaje de error o ""
 */
function validarFecha(idInput){
    //Recibe yyyy-mm-dd
    let patronFecha = /^(19|20)\d{2}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/;
    let fecha = $(`#${idInput}`).val();

    if (fecha == ""){
        return "Introduce la fecha";
    
    } else {
        return patronFecha.test(fecha) ? "" : "La fecha es incorrecta";
    }
}




//-------------------- Funciones para mostrar datos --------------------

/**
 * Función que obtiene el número de la factura o ingreso
 * @param {String} idInput ID del input donde se va a mostrar el resultado
 */
export function calcularNumero(idInput){
    $.ajax({ 
        url: "../controlador/funcionesAJAX.php", 
        type: 'POST',
        async: true, 
        data: {"calcularNumero": idInput},
        success: (respuesta) => {
            $(`#${idInput}`).val(JSON.parse(respuesta));
        }
    })
}


/**
 * Función que muestra la fecha de hoy en un input
 * @param {*} input Input donde se va a mostrar la fecha
 */
export function calcularFecha(input){
    let fecha = new Date();
    let dia =  (fecha.getDate() < 10) ? "0" + fecha.getDate() : fecha.getDate();
    let mes = fecha.getMonth() + 1;

    input.value = `${fecha.getFullYear()}-${mes}-${dia}`;
}




//-------------------- Funciones para obtener el municipio y provincia --------------------

/**
 * Función que obtiene el municipio a partir de un código postal
 * @param {String} codigoPostal 
 * @param {String} idFormulario ID del formulario donde se encuentra el código postal
 * @returns Boolean True: si encuentra el municipio. False: si no encuentra el municipio
 */
export function obtenerMunicipio(codigoPostal, idFormulario){ 
    $.ajax({ 
        url: "https://servicios.ine.es/wstempus/js/ES/VALORES_VARIABLE/19?page=1", 
        type: 'POST',
        async: true, 
        success: (respuesta) => {
            let municipio = false;  

            for (let municipios of respuesta){
                if (municipios.Codigo == codigoPostal){
                    municipio = true;

                    let inputsFormulario = $(`#${idFormulario} input`);
                    let inputMunicipio, inputProvincia;
                    
                    for(let input of inputsFormulario){
                        if (input.id.includes("provincia")){
                            inputProvincia = input.id;
                            
                        } else if (input.id.includes("municipio")){
                            inputMunicipio = input.id;
                            
                        }
                    }
                    
                    $(`#${inputMunicipio}`).val(`${municipios.Nombre}`).css("color", "#000");
                    $(`#${inputMunicipio} ~ label`).addClass("inputCubierto");
                    obtenerProvincia(codigoPostal, inputProvincia);
                }
            }

            (municipio) ? "" : mostrarNotificacionError($(`${idInput}`).closest("form").attr("id"), "El código postal introducido no existe");
        }
    })
}



/**
 * Función que obtiene la provincia a la que pertenece un código postal
 * @param {String} codigoPostal
 * @param {String} idProvincia ID del input donde se va a mostrar el nombre de la provincia
 */
function obtenerProvincia(codigoPostal, idProvincia){
    let codigo = codigoPostal.substring(0, 2);
    
    $.ajax({ 
        url: "https://servicios.ine.es/wstempus/js/ES/VALORES_VARIABLE/115?page=1", 
        type: 'POST',
        async: true, 
        success: (respuesta) => {
            
            for (let provincias of respuesta){
                if (provincias.Codigo == codigo){
                    $(`#${idProvincia}`).val(`${provincias.Nombre}`).css("color", "#000");
                    $(`#${idProvincia} ~ label`).addClass("inputCubierto");
                    comprobarDireccion($(`#${idProvincia}`).closest("form").attr("id"));
                }
            }
        }
    });
}




//-------------------- Funciones para mostrar el mapa --------------------

/**
 * Función que comprueba si los datos de la dirección están cubiertos
 * @param {String} idFormulario 
 */
export function comprobarDireccion(idFormulario){

    let idMinusculas = idFormulario.toLowerCase();

    //Comprobamos si hay que mostrar un mapa
    if (idMinusculas.includes("parcela")){

        let inputsFormulario = $(`#${idFormulario} input`);

        let municipio = "", provincia = "", direccion = "";
        
        for (let input of inputsFormulario){
            if (input.id.includes("provincia") && input.value != ""){
                provincia = input.value;
                
            } else if (input.id.includes("municipio") && input.value != ""){
                municipio = input.value;
                
            } else if (input.id.includes("direccion") && input.value != ""){
                direccion = input.value;
            }

        }

        if (provincia != "" && municipio != "" && direccion != ""){
            mostrarMapa(idFormulario, direccion, municipio, provincia);
        }
    }
}



/**
 * Función que muestra en un mapa una dirección
 * @param {String} idContenedor ID del contenedor donde se va a mostrar el mapa
 * @param {String} direccion Dirección para mostrar en el mapa
 * @param {String} municipio Municipio al que pertenece la dirección
 * @param {String} provincia Provincia a la que pertenece la dirección
 */
export function mostrarMapa(contenedor, direccion, municipio, provincia){
    $.ajax({ 
        url: "../controlador/funcionesAJAX.php", 
        type: 'POST',
        async: true, 
        data: {
            "mapa": "mapa", 
            "direccion": direccion,
            "municipio": municipio,
            "provincia": provincia
        },

        success: (respuesta) => {
            respuesta = JSON.parse(respuesta);
            if (!respuesta.longitud){
                mostrarNotificacionError(contenedor, respuesta);

            } else {
                let longitud = parseFloat(respuesta.longitud);
                let latitud = parseFloat(respuesta.latitud);
                
                let contenedorMapa = $(`#${contenedor}`) ? $(`#${contenedor}`).next(".mapa").attr("id") : $(`.${contenedor}`).next(".mapa").attr("id");      
                $(`#${contenedorMapa}`).empty();
                
                
                let map = new ol.Map({
                    layers: [new ol.layer.Tile({source: new ol.source.OSM()})],
                    target: `${contenedorMapa}`,
                    view: new ol.View({
                    projection: 'EPSG:4326',
                    center:[longitud, latitud],
                    zoom: 19
                    })
                });
                
                $(`#${contenedorMapa}`).css("padding", "0.1rem");
            }
        }
    });
}




//-------------------- Funciones mostrar notificaciones --------------------

/**
 * Función que muestra una notificación con un mensaje de error
 * @param {String} contenedor Id del contenedor donde se muestra la notificación
 * @param {String} textoExito Texto a mostrar en la notificación
 */
export function mostrarNotificacionError(contenedor, textoError){
    $(`#${contenedor} .notificaciones`).append(`
        <div class="error">
            <div>
                <p><span class="close-filled"></span></p>
            </div>

            <div>
                <p>Error</p>
                <p>${textoError}</p>
            </div>
            <div>
                <p><span class="close-outline"></span></p>
            </div>
        </div> 
    `);
    
    setTimeout(() => {
        $(".notificaciones .error:first-child").remove();
    }, 10000);
}



/**
 * Función que muestra una notificación con un mensaje de éxito
 * @param {String} contenedor Id del contenedor donde se muestra la notificación
 * @param {String} textoExito Texto a mostrar en la notificación
 */
export function mostrarNotificacionExito(contenedor, textoExito){
    $(`#${contenedor} .notificaciones`).append(`
        <div class="exito">
            <div>
                <p><span class="checkmark-filled"></span></p>
            </div>

            <div>
                <p>Éxito</p>
                <p>${textoExito}</p>
            </div>
            <div>
                <p><span class="close-outline"></span></p>
            </div>
        </div> 
    `);
    
    setTimeout(() => {
        $(".notificaciones .error:first-child").remove();
    }, 10000);
}




//-------------------- Funciones mostrar tablas --------------------

/**
 * Función que muestra los datos de la tabla facturas
 * @param {String} idContenedor Id de la tabla donde se va a mostrar los datos
 * @param {Array} datos Array con los datos a mostrar
 * @param {String} rolUsuario Rol del usuario
 */
export function mostrarTablaFacturas(idContenedor, datos, rolUsuario){
    let contenedor = $(`#${idContenedor} tbody`);
    
    //Borramos los hijos que tiene el contenedor
    contenedor.empty();

    let contenidoTabla = "";

    //Llenamos el contenedor
    for(let factura of datos){
        contenidoTabla += "<tr>";
        
        if (rolUsuario == "administrador"){
            contenidoTabla += 
                `<td><input type='checkbox' id='${factura['numero_factura']}' name='borrarMovimiento' value='${factura['numero_factura']}'></td>` +
                `<td><label for='${factura['numero_factura']}'>${factura['numero_factura']}</label></td>`;
        } else {
            contenidoTabla += `<td>${factura['numero_factura']} </td>`;
        }

        contenidoTabla += 
            `<td>${cambiarFormatoFecha(factura['fecha'])}</td>` + 
            `<td>${factura['concepto']}</td>` + 
            `<td>${factura['base_imponible']}€</td>` +
            `<td>${factura['iva']}%</td>` +
            `<td>${factura['total']}€</td>`;
            
        contenidoTabla += factura['pagada'] ? "<td>SI</td>" : "<td>NO</td>";
        contenidoTabla += "<td>" + 
                `<a target="_blank" href="../documentosUsuarios/archivosFacturas/${factura['archivo']}"><span class="download-rounded" title="Descargar factura"></span></a>` +
                `<button id="${factura['numero_factura']}" class="verMovimiento"><span class="eye" title="Ver factura"></span></button>`;

        if (rolUsuario == "administrador"){
            contenidoTabla += 
                `<button id="${factura['numero_factura']}" class="editar editarMovimiento"><span class="edit" title="Editar factura"></span></button>`+
                `<button id="${factura['numero_factura']}" class="eliminarMovimiento"><span class="close-rounded" title="Eliminar factura"></span></button>`;
        }

        contenidoTabla += "</td>";
        contenidoTabla += "</tr>";
    } 

    contenedor.append(contenidoTabla);
}



/**
 * Función que muestra los datos de la tabla ingresos
 * @param {String} idContenedor ID de la tabla donde se van mostrar los datos
 * @param {Array} datos Array con los datos a mostrar
 * @param {String} rolUsuario Rol del usuario 
 */
export function mostrarTablaIngresos(idContenedor, datos, rolUsuario){
    let contenedor = $(`#${idContenedor} tbody`);
    
    //Borramos los hijos que tiene el contenedor
    contenedor.empty();

    let contenidoTabla = "";

    //Llenamos el contenedor
    for(let ingreso of datos){
        contenidoTabla += "<tr>";
        
        if (rolUsuario == "administrador"){
            contenidoTabla += 
                `<td><input type='checkbox' id='${ingreso['numero_ingreso']}' name='borrarMovimiento' value='${ingreso['numero_ingreso']}']</td>` + 
                `<td><label for='${ingreso['numero_ingreso']}'>${ingreso['numero_ingreso']}</label>`;
        } else {
            contenidoTabla += `<td>${ingreso['numero_ingreso']} </td>`;
        }

        contenidoTabla += 
            `<td>${cambiarFormatoFecha(ingreso['fecha'])}</td>` +
            `<td>${ingreso['concepto']}</td>` +
            `<td>${ingreso['ingreso_bruto']}€</td>` +
            `<td>${ingreso['porcentaje_retencion']}%</td>` +
            `<td>${ingreso['retencion']}€</td>` +
            `<td>${ingreso['total']}€</td>` +
            `<td>${ingreso['estado']}</td>` +
            "<td>" + 
                `<a target="_blank" href="../documentosUsuarios/archivosIngresos/${ingreso['archivo']}"><span class="download-rounded" title="Descargar ingreso"></span></a>`+
                `<button id="${ingreso['numero_ingreso']}" class="verMovimiento"><span class="eye" title="Ver ingreso"></span></button>`;

        if (rolUsuario == "administrador"){
            contenidoTabla += 
                `<button id="${ingreso['numero_ingreso']}" class="editar editarMovimiento"><span class="edit" title="Editar ingreso"></span></button>`+
                `<button id="${ingreso['numero_ingreso']}" class="eliminarMovimiento"><span class="close-rounded" title="Eliminar ingreso"></span></button>`;
        }

        contenidoTabla += "</td></tr>";
    }

    contenedor.append(contenidoTabla);
}



/**
 * Funicón que muestra los datos de la tabla últimos movimientos
 * @param {String} idContenedor ID de la tabla donde se van a mostrar los datos
 * @param {Array} datos Array con los datos a mostrar
 * @param {String} rolUsuario Rol del usuario
 */
export function mostrarTablaUltimosMovimientos(idContenedor, datos, rolUsuario){
    let contenedor = $(`#${idContenedor} tbody`);
    
    //Borramos los hijos que tiene el contenedor
    contenedor.empty();

    let contenidoTabla = "";

    //Llenamos el contenedor
    for(let movimiento of datos){
        contenidoTabla += "<tr>";

        if (rolUsuario == "administrador"){
            contenidoTabla +=
                `<td><input id="movimiento${movimiento['numero_ingreso']}" type="checkbox" name="borrarMovimiento" value="${movimiento['numero_ingreso']}"></td>` +
                `<td><label for="movimiento${movimiento['numero_ingreso']}">${movimiento['usuario']}</label></td>`;
        } 

        contenidoTabla += 
            `<td>${movimiento['tipo']}</td>` +
            `<td>${movimiento['numero_ingreso']}</td>` +
            `<td>${cambiarFormatoFecha(movimiento['fecha'])}</td>` +
            `<td>${movimiento['concepto']}</td>` +
            `<td>${movimiento['total']}€</td>`;

        contenidoTabla += "<td>";
            if (movimiento['tipo'] == "Ingreso"){
                contenidoTabla += `<a target="_blank" href="../documentosUsuarios/archivosIngresos/${movimiento['archivo']}"><span class="download-rounded" title="Descargar ingreso"></span></a>`;
            } else {
                contenidoTabla += `<a target="_blank" href="../documentosUsuarios/archivosFacturas/${movimiento['archivo']}"><span class="download-rounded" title="Descargar factura"></span></a>`;
            }

        contenidoTabla += `<button id="${movimiento['numero_ingreso']}" class="verMovimiento"><span class="eye" title="Ver movimiento"></span></button>`;
                
        if (rolUsuario == "administrador"){
            contenidoTabla += 
                `<button id="${movimiento['numero_ingreso']}" class="editar editarMovimiento"><span class="edit" title="Editar movimiento"></span></button>`+ 
                `<button id="${movimiento['numero_ingreso']}" class="eliminarMovimiento"><span class="close-rounded" title="Eliminar movimiento"></span></button>`;
        }
        
        contenidoTabla += "</td></tr>";

    }

    contenedor.append(contenidoTabla);
}



/**
 * Función que muestra los datos de la tabla albaranes
 * @param {String} idContenedor ID de la tabla donde se van a mostrar los datos
 * @param {Array} datos Array con los datos a mostrar
 * @param {String} rolUsuario Rol del usuario
 */
export function mostrarTablaAlbaranes(idContenedor, datos, rolUsuario){
    let contenedor = $(`#${idContenedor} tbody`);
    
    //Borramos los hijos que tiene el contenedor
    contenedor.empty();

    let contenidoTabla = "";
    //Llenamos el contenedor
    for (let albaran of datos){
        contenidoTabla += "<tr>";
        
        if (rolUsuario == "administrador"){
            contenidoTabla += 
                `<td><input type='checkbox' id='${albaran['numero_albaran']}' name='borrarAlbaran' value='${albaran['numero_albaran']}'></td>` +
                `<td><label for='${albaran['numero_albaran']}'>${albaran['numero_albaran']}</label></td>`;
        } else {
            contenidoTabla += `<td>${albaran['numero_albaran']} </td>`;
        }

        contenidoTabla += 
            `<td>${cambiarFormatoFecha(albaran['fecha_hora'])}</td>` +
            `<td>${albaran['nombre']}</td>` +
            `<td>${albaran['cajas']}</td>` +
            `<td>${albaran['peso_bruto']}</td>` +
            `<td>${albaran['tara']}</td>` +
            `<td>${albaran['peso_neto']}</td>` +
            `<td>${albaran['grado']}</td>` +
            "<td>" +
            `<a target="_blank" href="../documentosUsuarios/archivosAlbaranes/${albaran['archivo']}"><span class="download-rounded" title="Descargar albarán"></span></a>` +
            `<button id="${albaran['numero_albaran']}" class="verAlbaran"><span class="eye" title="Ver albaran"></span></button>`;
                        

        if (rolUsuario == "administrador"){
            contenidoTabla += `<button id="${albaran['numero_albaran']}" class="editar editarAlbaran"><span class="edit" title="Editar albaran"></span></button>`;
            contenidoTabla += `<button id="${albaran['numero_albaran']}" class="eliminarAlbaran"><span class="close-rounded" title="Eliminar albaran"></span></button>`;
        }

        contenidoTabla += "</td></tr>";
    }

    contenedor.append(contenidoTabla);
}



/**
 * Función que muestra la tabla resumen de la vendimia
 * @param {String} idContenedor ID de la tabla donde se van a mostrar los datos
 * @param {Array} datos Array con los datos a mostrar
 */
export function mostrarTablaResumenVendimia(idContenedor, datos){
    let contenedor = $(`#${idContenedor} tbody`);
    
    //Borramos los hijos que tiene el contenedor
    contenedor.empty();

    let contenidoTabla = "";
    
    for (let vendimia of datos){
        contenidoTabla += 
        "<tr>" +
            `<td>${vendimia['kg']}</td>` + 
            `<td>${vendimia['graduacion']}</td>` + 
            `<td>${vendimia['precio']}</td>` + 
            `<td>${vendimia['base_imponible']}</td>` + 
            `<td>${vendimia['retencion']}</td>` + 
            `<td>${vendimia['total']}</td>` + 
        "</tr>";
    }    

    contenedor.append(contenidoTabla);
}



/**
 * Función que añade una fila a la tabla de parcelas al añadir una nueva parcela
 * @param {String} idContenedor ID de la tabla donde se van a mostrar los datos
 * @param {Array} datos Array con los datos a mostrar
 */
export function mostrarTablaParcelasNuevaParcela(idContenedor, dni){
    $.ajax({ 
        url: "../controlador/funcionesAJAX.php", 
        type: 'POST',
        async: true, 
        data: {"parcela": "obtenerParcelasUsuario", "id": dni},
        success: (respuesta) => {
            let contenedor = $(`#${idContenedor} tbody`);
            contenedor.empty();

            let contenidoTabla = "";
            for (let parcela of JSON.parse(respuesta)){
                contenidoTabla += 
                "<tr>" + 
                    `<td><input type="checkbox" id="parcela${parcela['id']}" name="borrarParcela" value="${parcela['id']}"></td>`+
                    `<td><label for="parcela${parcela['id']}">${parcela['nombre']}</label></td>` +
                    `<td>${parcela['direccion']}</td>` + 
                    `<td>${parcela['municipio']}</td>` + 
                    `<td>${parcela['provincia']}</td>` + 
                    `<td>${parcela['m2']}</td>` + 
                    `<td>${parcela['cupo']}</td>` + 
                    `<td>${parcela['variedad_uva']}</td>`+ 
                    "<td>"  +
                        `<button id="${parcela['id']}" class="verParcela"><span class="eye" title="Ver parcela"></span></button>` +
                        `<button id="${parcela['id']}" class="editar editarParcela"><span class="edit" title="Editar parcela"></span></button>` +
                        `<button id="${parcela['id']}" class="eliminarParcela"><span class="close-rounded" title="Eliminar parcela"></span></button>` +
                    "</td>" +
                "</tr>";
            }         

            contenedor.append(contenidoTabla);
        }
    });
}



/**
 * Función que muestra los datos de la tabla de días de vendimia
 * @param {String} idContenedor ID de la tabla donde se van a mostrar los datos
 * @param {String} dni DNi del usuario
 */
export function mostrarTablaDiasVendimia(idContenedor, dni){
    $.ajax({ 
        url: "../controlador/funcionesAJAX.php", 
        type: 'POST',
        async: true, 
        data: {"diasVendimia": "datosVendimia", "dni": dni},
        success: (respuesta) => {
            let contenedor = $(`#${idContenedor} tbody`);
            
            //Borramos los hijos que tiene el contenedor
            contenedor.empty();

            let contenidoTabla = "";
            
            for (let diasVendimia of JSON.parse(respuesta)){
                contenidoTabla += 
                    "<tr>" + 
                        `<td><input type="checkbox" id="${diasVendimia['id']}" name="borrarDiasVendimia" value="${diasVendimia['id']}"></td>`+
                        `<td><label for="${diasVendimia['id']}">${cambiarFormatoFecha(diasVendimia['fecha'])}</label></td>`+
                        `<td>${diasVendimia['cajas']}</td>`+
                        "<td>" +
                            `<button id="${diasVendimia['id']}" class="editar diasVendimia"><span class="edit" title="Editar días vendimia"></span></button>` +
                            `<button id="${diasVendimia['id']}" class="eliminarDiasVendimia"><span class="close-rounded" title="Eliminar días vendimia"></span></button>` +
                        "</td>" +
                    "</tr>";
            }

            contenedor.append(contenidoTabla);    
        }
    })
}



/**
 * Función que cambia el formato de una fecha almacenada en una base de datos al formato: dd/mm/aaaa (hh:mm:ss)
 * @param {String} fecha Fecha a cambiar
 * @returns String Fecha cambiada
 */
function cambiarFormatoFecha(fecha){
    let ano = fecha.substring(0,4);
    let mes = fecha.substring(5,7);
    let dia = fecha.substring(8, 10);

    if (fecha.length == 10){
        return dia + "/" + mes + "/" + ano;

    } else {
        let hora = fecha.substring(10);
        return dia + "/" + mes + "/" + ano + hora;
    }
}




//-------------------- Funciones para mostrar gráficos --------------------
/**
 * Función que muestra un gráfico de barras donde se muestra el número de kg recogidos por año
 */
export function mostrarGraficoKG() {
    let grafico = echarts.init(document.getElementById("totalKg"));

    $.ajax({ 
        url: "../controlador/funcionesAJAX.php", 
        type: 'POST',
        async: true, 
        data: {"grafico": "grafico", "datosGrafico": "kg"},
        success: (respuesta) => {
            let datosEjeX = [], datosEjeY = [];
            
            for (let datos of JSON.parse(respuesta)){
                datosEjeX.push(datos['ano']);
                datosEjeY.push(datos['total_kg']);
            }
            
            //Indicamos las opciones del gráfico
            let opcion = {
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {
                        ype: 'shadow'
                    }
                },

                grid: {
                    left: '3%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: true
                },

                xAxis: [{
                    type: 'category',
                    data: datosEjeX,
                    axisTick: {
                        alignWithLabel: true
                    }
                }],

                yAxis: [{
                    type: 'value'
                }],

                series: [{
                    type: 'bar',
                    barWidth: '60%',
                    data: datosEjeY,
                    itemStyle: {
                        color: "#125e52"
                    }
                }]
            };
        
            grafico.setOption(opcion);
        
        }
    });

}



/**
 * Función que muestra un gráfico de línea donde se muestra la evolución de la media de los grados por años
 */
export function mostrarGraficoMediaGrados(){
    let grafico = echarts.init(document.getElementById("mediaGrados"));

    $.ajax({ 
        url: "../controlador/funcionesAJAX.php", 
        type: 'POST',
        async: true, 
        data: {"grafico": "grafico", "datosGrafico": "mediaGrados"},
        success: (respuesta) => {
            let datosEjeX = [], datosEjeY = [];
            
            for (let datos of JSON.parse(respuesta)){
                datosEjeX.push(datos['ano']);
                datosEjeY.push(datos['graduacion']);
            }
            
            //Indicamos las opciones del gráfico
            let opcion = {
                tooltip: {
                    trigger: 'item'
                },

                grid: {
                    left: '3%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: true
                },

                xAxis: {
                    type: 'category',
                    boundaryGap: false,
                    data: datosEjeX
                },

                yAxis: {
                    type: 'value'
                },

                series: [{
                    type: 'line',
                    symbolSize: 14,
                    lineStyle: {
                        color: "#93ad8b"
                    },

                    itemStyle: {
                        color: "#125e52"
                    },

                    tooltip: {
                        formatter: '{b0}: {c0}',
                        textStyle: {
                          fontWeight: "bolder"
                        }
                    },

                    data: datosEjeY
                }]
            };
        
            grafico.setOption(opcion);
        
        }
    });
}



/**
 * Función que muestra un gráfico circular con el totar a pagar y el total cobrado de este año
 */
export function mostrarGraficoCircular(){
    let grafico = echarts.init(document.getElementById("ingresosPagados"));

    $.ajax({ 
        url: "../controlador/funcionesAJAX.php", 
        type: 'POST',
        async: true, 
        data: {"grafico": "grafico", "datosGrafico": "ingresosPagados"},
        success: (respuesta) => {
            respuesta = JSON.parse(respuesta);            
            
            let opcion = {
                tooltip: {
                    trigger: 'item',
                },

                legend: {
                    right: 'center',
                    bottom: '0%',
                    orient: 'vertical',
                    textStyle: {
                        fontSize: 30
                    }
                },

                series: [{
                    type: 'pie',
                    radius: ['40%', '70%'],
                    avoidLabelOverlap: false,
                    selectedMode: 'single',

                    itemStyle: {
                        borderRadius: 10,
                        borderColor: '#fff',
                        borderWidth: 2
                    },

                    label: {
                        show: false,
                        position: 'center'
                    },

                    emphasis: {
                        label: {
                            show: true,
                            fontSize: 40,
                            fontWeight: 'bold'
                        }
                    },

                    labelLine: {
                        show: false
                    },

                    data: [
                        { 
                            value:  respuesta['totalDeuda'],
                            name: 'Total a pagar',
                            itemStyle: {
                                color: "#125e52"
                            }
                        },

                        { 
                            value: respuesta['totalIngresos'], 
                            name: 'Total pagado',
                            itemStyle: {
                                color: "#93ad8b"
                            }
                        }
                    ]
                    
                }]
            }
                
                
            grafico.setOption(opcion);
        
        }
    })
}



/**
 * Función que muestra un gráfico con dos líneas: una con los ingresos y otra con los gastos de cada año
 */
export function mostrarGraficoIngresosGastos(){
    let grafico = echarts.init(document.getElementById("ingresosGastos"));

    $.ajax({ 
        url: "../controlador/funcionesAJAX.php", 
        type: 'POST',
        async: true, 
        data: {"grafico": "grafico", "datosGrafico": "ingresosGastos"},
        success: (respuesta) => {
            respuesta = JSON.parse(respuesta);      

            let anos = [], ingresos = [], gastos = [];

            for (let datosIngresos of respuesta.ingresos){
                ingresos.push(datosIngresos.total);
                anos.push(datosIngresos.ano);
            }

            for (let datosFacturas of respuesta.gastos){
                gastos.push(datosFacturas.total);
            }


            let opcion = {
                tooltip: {
                    trigger: 'axis'
                },

                legend: {
                    data: ['Ingresos', 'Gastos']
                },

                grid: {
                    left: '3%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: true
                },

                xAxis: {
                    type: 'category',
                    boundaryGap: false,
                    data: anos
                },

                yAxis: {
                    type: 'value'
                },

                series: [
                    {
                        name: 'Ingresos',
                        type: 'line',
                        color: "#125e52",
                        symbolSize: 14,
                        itemStyle: {
                            color: "#125e52"
                        },

                        tooltip: {
                            formatter: '{b0}: {c0}',
                            textStyle: {
                                fontWeight: "bolder"
                            },
                        },

                        data: ingresos
                    },

                    {
                        name: 'Gastos',
                        type: 'line',
                        color: "#93ad8b",
                        symbolSize: 14,
                        itemStyle: {
                            color: "#93ad8b"
                        },

                        tooltip: {
                            formatter: '{b0}: {c0}',
                            textStyle: {
                                fontWeight: "bolder"
                            },
                        },
                        
                        data: gastos
                    }
                ]
            };
            
            grafico.setOption(opcion);
        }
    })
}


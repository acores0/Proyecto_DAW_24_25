//--------- Funciónes de las ventanas modales ---------
    /**
     * Función para abrir las ventanas modales
     */
    export function abrirVentanaModal(ventanaModal){
        ventanaModal[0].showModal();
    }

    /**
     * Función que cierra las ventanas modales
     */
    export function cerrarVentanaModal(ventanaModal){
        ventanaModal.close();
    }




//-------------------- Funciones para validar los formularios --------------------
/**
 * Función para validar los formularios
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
 * @param {} Input para validar
 * @returns String Mensaje de error
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
 * @param {*} e 
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
 * @returns String Mensaje de error
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
        letra = dni.substring(8);
        resto = Math.trunc(parseInt(dni.substring(0, 8)) % 23);
        return letrasDni[resto] == letra ? "" : "La letra es incorrecta para el DNI introducido";

    } else {
        return "El DNI introducido es incorrecto";
    }
}



/**
 * Función que valida un campo de texto
 * @param {String} campo Id del input a validar
 * @returns String Mensaje de error
 */
function validarContrasinal(idInput){
    let patronContrasinal = /^(?=.*[A-z])(?=.*[A-Z])(?=.*[0-9])\S{6,}$/;
    let contrasinal =  $(`#${idInput}`).val();

    if (contrasinal == ""){
        return "Introduce la contraseña";
    } else if (contrasinal.length < 6){
        return "La contraseña debe tener como mínimo 6 dígitos";
    } else if (!patronContrasinal.test(contrasinal)){
        return "La contraseña introducida no cumple los requisitos: Mínimo 6 caracteres, 1 mayúscula, 1 minúscula y 1 número";
    } else {
        return "";
    }
}



/**
 * Función que valida un campo de una contraseña
 * @param {String} campo Id del input a validar
 * @returns String Mensaje de error
 */
function validarCamposTexto(idInput){
    let texto =  $(`#${idInput}`).val();
    let nombreLabel = $(`#${idInput} ~ label`)[0].textContent;
    return texto == "" ? `Introduce el campo ${nombreLabel}` : "";
}



/**
 * Función que valida el código postal
 * @returns String Mensaje de error
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
 * 
 * @returns String Mensaje con el error
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
 * @returns String Mensaje con el error
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
 * @param {String} valorInput Valor introducido en el input
 * @param {String} nombreCampo Nombre del campo
 * @returns String Mensaje con el error
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

    if (idSelect.includes("formaPago")){
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
 * @returns String Mensaje de error
 */
function validarArchivo(idInput){
    return ($(`#${idInput}`).files != "") ? "" : "Sube el archivo de la factura";

}



/**
 * Función que valida si una fecha es correcta
 * @param {String} idInput ID del input fecha
 * @returns Mensaje de errr
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
 * @param {String} claseInput Nombre de la clase de los inputs
 */
export function calcularFecha(input){
    let fecha = new Date();
    let dia =  (fecha.getDate() < 10) ? "0" + fecha.getDate() : fecha.getDate();
    let mes = fecha.getMonth() + 1;

    input.value = `${fecha.getFullYear()}-${mes}-${dia}`;
}




//-------------------- Funciones para obtener el municipio y provincia --------------------

/**
 * Función que obtiene el municipio dado un código postal
 * @param {String} codigoPostal 
 * 
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

    //Comprobamos si hay que mostrar un mapa
    let padreFormulario = "", mapa;
    if ($(`#${idFormulario}`).parent().attr("id")){
        padreFormulario = $(`#${idFormulario}`).parent().attr("id");
        mapa = $(`#${padreFormulario} .mapa`).length;

    } else if ($(`#${idFormulario}`).parent().attr("class")){
        padreFormulario = $(`#${idFormulario}`).parent().attr("class")
        mapa = $(`.${padreFormulario} .mapa`).length;
    }

    if (mapa){

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
            //mostrarMapa(padreFormulario, direccion, municipio, provincia);
            mostrarMapa(padreFormulario, coordenadasMapa(direccion, municipio, provincia));
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
export function mostrarMapa(idContenedor, direccion, municipio, provincia){
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
            //!Comprobar mapa alta parcela
            let contenedorMapa1 = $(`.${idContenedor} .mapa`).attr("id");
            let contenedorMapa = $(`#${idContenedor} .mapa`).attr("id");
            console.log(contenedorMapa + "   ----->     " + contenedorMapa1);
            
            $(`#${contenedorMapa}`).empty();
            
            
            let map = new ol.Map({
                layers: [new ol.layer.Tile({source: new ol.source.OSM()})],
                target: `${contenedorMapa}`,
                view: new ol.View({
                //projection: 'EPSG:4326',
                projection: 'EPSG:3857',
                //center:[respuesta.latitud, respuesta.longitud],
                center: ol.proj.fromLonLat([respuesta.longitud, respuesta.latitud]),
                zoom: 16
                })
            });    
            
            // Crear un marcador
            const marker = new ol.Feature({
                geometry: new ol.geom.Point(ol.proj.fromLonLat([respuesta.longitud, respuesta.latitud])) // Convertir a EPSG:3857
            });

            // Crear una capa vectorial para el marcador
            const vectorSource = new ol.source.Vector({
                features: [marker]
            });

            const markerLayer = new ol.layer.Vector({
                source: vectorSource
            });

            // Añadir la capa de marcador al mapa
            map.addLayer(markerLayer);
            $(`#${contenedorMapa}`).css("padding", "0.1rem");
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
                <p><span class="close-rounded"></span></p>
            </div>
        </div> 
    `);
    
    setTimeout(() => {
        $(".notificaciones .error:first-child").remove();
    }, 5000);
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
                <p><span class="close-rounded"></span></p>
            </div>
        </div> 
    `);
    
    setTimeout(() => {
        $(".notificaciones .error:first-child").remove();
    }, 5000);
}




//-------------------- Funciones mostrar tablas --------------------

/**
 * Función que muestra los datos de la tabla facturas
 * @param {String} contenedor Id del contenedor donde se va a mostrar la tabla
 * @param {Array} datos Datos a mostrar
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
            contenidoTabla += "<td>" +
                    `<label for='${factura['numero_factura']}'><span class='checkbox-blank-outline'></span></label>` +
                    `<input type='checkbox' id='${factura['numero_factura']}' name='borrarFactura' value='${factura['numero_factura']}']` + 
                    "</td>";
        }
        contenidoTabla += `<td>${factura['numero_factura']} </td>`;
        contenidoTabla += `<td>${factura['fecha']}</td>`;
        contenidoTabla += `<td>${factura['concepto']}</td>`;
        contenidoTabla += `<td>${factura['base_imponible']}€</td>`;
        contenidoTabla += `<td>${factura['iva']}%</td>`;
        contenidoTabla += `<td>${factura['total']}€</td>`;
        contenidoTabla += factura['pagada'] ? "<td>SI</td>" : "<td>NO</td>";
        contenidoTabla += "<td>" + 
                `<a target="_blank" href="../documentosUsuarios/archivosFacturas/${factura['archivo']}"><span class="download-rounded" title="Descargar factura"></span></a>` +
                `<button id="${factura['numero_factura']}" class="verMovimiento"><span class="eye" title="Ver factura"></span></button>`;

        if (rolUsuario == "administrador"){
            contenidoTabla += 
                `<button id="${factura['numero_factura']}" class="editarMovimiento"><span class="edit" title="Editar factura"></span></button>`+
                `<button id="${factura['numero_factura']}" class="eliminarMovimiento"><span class="close-rounded" title="Eliminar factura"></span></button>`;
        }

        contenidoTabla += "</td>";
        contenidoTabla += "</tr>";
    } 

    contenedor.append(contenidoTabla);
}



/**
 * Función que muestra los datos de la tabla ingresos
 * @param {Array} datos 
 * @param {Array} datos Datos a mostrar
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
            contenidoTabla += "<td>"+
                    `<label for='${ingreso['numero_ingreso']}'><span class='checkbox-blank-outline'></span></label>` +
                    `<input type='checkbox' id='${ingreso['numero_ingreso']}' name='borrarIngreso' value='${ingreso['numero_ingreso']}']` + 
                    "</td>";
        }
        contenidoTabla += `<td>${ingreso['numero_ingreso']} </td>`;
        contenidoTabla += `<td>${ingreso['fecha']}</td>`;
        contenidoTabla += `<td>${ingreso['concepto']}</td>`;
        contenidoTabla += `<td>${ingreso['ingreso_bruto']}€</td>`;
        contenidoTabla += `<td>${ingreso['porcentaje_retencion']}%</td>`;
        contenidoTabla += `<td>${ingreso['retencion']}€</td>`;
        contenidoTabla += `<td>${ingreso['total']}€</td>`;
        contenidoTabla += `<td>${ingreso['estado']}</td>`;


        contenidoTabla += 
            "<td>" + 
            `<a target="_blank" href="../documentosUsuarios/archivosIngresos/${ingreso['archivo']}"><span class="download-rounded" title="Descargar ingreso"></span></a>`+
            `<button id="${ingreso['numero_ingreso']}" class="verMovimiento"><span class="eye" title="Ver ingreso"></span></button>`;

        if (rolUsuario == "administrador"){
            contenidoTabla += 
                `<button id="${ingreso['numero_ingreso']}" class="editarMovimiento"><span class="edit" title="Editar ingreso"></span></button>`+
                `<button id="${ingreso['numero_ingreso']}" class="eliminarMovimiento"><span class="close-rounded" title="Eliminar ingreso"></span></button>`;
        }

        contenidoTabla += "</td>";
        contenedor.append("</tr>");
    }

    contenedor.append(contenidoTabla);
}



/**
 * Función que muestra los datos de la tabla albaranes
 * @param {String} idContenedor ID del contenedor donde se va a mostrar la tabla
 * @param {Array} datos Array con los datos a mostrar
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
            contenidoTabla += "<td>" +
                    `<label for='${albaran['id']}'><span class='checkbox-blank-outline'></span></label>` +
                    `<input type='checkbox' id='${albaran['id']}' name='borrarAlbaran' value='${albaran['numero_albaran']}']` + 
                    "</td>";
        }
        contenidoTabla += `<td>${albaran['numero_albaran']} </td>`;
        contenidoTabla += `<td>${albaran['fecha_hora']}</td>`;
        contenidoTabla += `<td>${albaran['nombre']}</td>`;
        contenidoTabla += `<td>${albaran['cajas']}</td>`;
        contenidoTabla += `<td>${albaran['peso_bruto']}</td>`;
        contenidoTabla += `<td>${albaran['tara']}</td>`;
        contenidoTabla += `<td>${albaran['peso_neto']}</td>`;
        contenidoTabla += `<td>${albaran['grado']}</td>`;

        contenidoTabla += "<td>";
        contenidoTabla += `<a target="_blank" href="../documentosUsuarios/archivosAlbaranes/${albaran['archivo']}"><span class="download-rounded" title="Descargar albarán"></span></a>`;
        contenidoTabla += `<button id="${albaran['numero_albaran']}" class="verAlbaran"><span class="eye" title="Ver albaran"></span></button>`;
                        

        if (rolUsuario == "administrador"){
            contenidoTabla += `<button id="${albaran['numero_albaran']}" class="editarAlbaran"><span class="edit" title="Editar albaran"></span></button>`;
            contenidoTabla += `<button id="${albaran['numero_albaran']}" class="eliminarAlbaran"><span class="close-rounded" title="Eliminar albaran"></span></button>`;
        }
        contenidoTabla += "</td>";
        
        contenidoTabla += "</tr>";
    }

    contenedor.append(contenidoTabla);
}



/**
 * Función que muestra la tabla resumen de la vendimia
 * @param {} idContenedor 
 * @param {Array} datos 
 */
export function mostrarTablaResumenVendimia(idContenedor, datos){
    let contenedor = $(`#${idContenedor} tbody`);
    
    //Borramos los hijos que tiene el contenedor
    contenedor.empty();

    let contenidoTabla = "";
    
    for (let vendimia of datos){
        contenidoTabla += "<tr>";
        contenidoTabla += `<td>${vendimia['kg']}</td>`;
        contenidoTabla += `<td>${vendimia['graduacion']}</td>`;
        contenidoTabla += `<td>${vendimia['precio']}</td>`;
        contenidoTabla += `<td>${vendimia['base_imponible']}</td>`;
        contenidoTabla += `<td>${vendimia['retencion']}</td>`;
        contenidoTabla += `<td>${vendimia['total']}</td>`;
        contenidoTabla += "</tr>";
    }    

    contenedor.append(contenidoTabla);
}



/**
 * Función que añade una fila a la tabla de parcelas al añadir una nueva parcela
 * @param {String} idContenedor Contenedor que va a mostrar los datos
 * @param {Array} datos Datos a mostrar
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
                contenidoTabla += "<tr>";
                contenidoTabla += "<td>" + 
                    `<label for="parcela${parcela['id']}"></label>` +
                    `<input type="checkbox" id="parcela${parcela['id']}" name="borrarParcela" value="${parcela['id']}">`+
                    "</td>";

                contenidoTabla += `<td>${parcela['nombre']}</td>`;
                contenidoTabla += `<td>${parcela['direccion']}</td>`;
                contenidoTabla += `<td>${parcela['municipio']}</td>`;
                contenidoTabla += `<td>${parcela['provincia']}</td>`;
                contenidoTabla += `<td>${parcela['m2']}</td>`;
                contenidoTabla += `<td>${parcela['cupo']}</td>`;
                contenidoTabla += `<td>${parcela['variedad_uva']}</td>`;
                contenidoTabla += "<td>"  +
                    `<button id="${parcela['id']}" class="verParcela"><span class="eye" title="Ver parcela"></span></button>` +
                    `<button id="${parcela['id']}" class="editarDatos"><span class="edit" title="Editar parcela"></span></button>` +
                    `<button id="${parcela['id']}" class="eliminarDatos"><span class="close-rounded" title="Eliminar parcela"></span></button>` +
                    "</td>";
                contenidoTabla += "</tr>";
            }         

            contenedor.append(contenidoTabla);
        }
    });
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
                    trigger: 'item'
                },

                legend: {
                    right: 'center',
                    bottom: '0%',
                    orient: 'vertical'
                },

                series: [{
                    type: 'pie',
                    radius: ['40%', '70%'],
                    avoidLabelOverlap: false,
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


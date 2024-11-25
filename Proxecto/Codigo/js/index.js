import * as funciones from './funciones.js';



$(() => {

    //------------------------------ Código página login
        //Código para mostrar u ocultar la contraseña en los inputs para las contraseñas
        $(".iconoMostrarContrasinal").click(function () {
            let inputContrasinal = $(this).next()[0];

            if ($(this).hasClass("eye")) {
                inputContrasinal.type = "text"; //Con JQuery no funciona
                this.classList.add("eye-off");
                this.classList.remove("eye");
            } else {
                inputContrasinal.type = "password";
                this.classList.remove("eye-off");
                this.classList.add("eye");
            }
        })


        
        //Código del enlace para cambiar la contraseña
        $("#cambiarPasswd").click(function (event) {
            event.preventDefault();
            $("#login").addClass("cambiarContrasinal");
        })



        //Código del botón para iniciar sesión del apartado cambiar contraseña
        $(".btnIniciarSesion").click(function () {
            $("#login").removeClass("cambiarContrasinal");
        })


        //------------------- Código de los formularios
            //Código que cambia la contraseña de un usuario en la pantalla de login
            $("#formularioCambiarContrasinal").submit(function(event){
                event.preventDefault();

                if (funciones.validarFormulario(this.id)){
                    if ($("#cambiarContrasinal").val() === $("#repContrasinal").val()){
                        const datos = new FormData(this);
                        datos.append("usuarios", "cambiarContrasinal");
                    
                        fetch("../controlador/funcionesAJAX.php", {
                            method: 'POST',
                            body: datos
                        })
                    
                        .then (response => response.json())
                        .then (data => {
                            switch (data){
                                case 0:
                                    funciones.mostrarNotificacionError(this.id, "Error al cambiar la contraseña del usuario"); 
                                    break;

                                case 1:
                                    funciones.mostrarNotificacionExito(this.id, "Constraseña cambiada");
                                    break;

                                default:
                                    funciones.mostrarNotificacionError(this.id, data);
                            }                
                        })
                        .catch (error => {alert(`Hubo un error al cambiar la contraseña del usuario: ${error}`)});
                    } else {
                        funciones.mostrarNotificacionError(this.id, "No se pudo enviar el formulario porque faltan datos por completar");
                    }
                }
            });


            //Código para iniciar sesión en aplicación
            $("#formularioInicioSesion").submit(function(event){
                event.preventDefault();

                if (funciones.validarFormulario(this.id)){
                    const datos = new FormData(this);
                    datos.append("usuarios", "iniciarSesion");
                    
                    fetch("../controlador/funcionesAJAX.php", {
                        method: 'POST',
                        body: datos
                    })
                    
                    .then (response => response.json())
                    .then (data => {
                        switch (data){
                            case 0:
                                funciones.mostrarNotificacionError(this.id, "Las credenciales introducidas son incorrectas"); 
                                break;

                            case 1:
                                window.location.href = 'dashboard.php';
                                break;

                            default:
                                funciones.mostrarNotificacionError(this.id, data);
                        }                
                    })
                    .catch (error => {alert(`Hubo un error al cambiar la contraseña del usuario: ${error}`)});
                } else {
                    funciones.mostrarNotificacionError(this.id, "No se pudo enviar el formulario porque faltan datos por completar");
                }
            });




    //------------------- Código menú principal móvil
        //Código que muestra el menú de la pantalla para móvil
        $("#menuHamburguesa").click(function(){
            $("#menuPrincipal").addClass("abrirMenuPrincipal");
        })



        //Código que cierra el menú de la pantalla para móvil
        $("#menuPrincipal .close-rounded").click(function(){
            $("#menuPrincipal").removeClass("abrirMenuPrincipal");
            $("#menuPrincipal").addClass("cerrarMenuPrincipal");
        });




    //------------------- Código para utilizar las pestañas
        //Código que activa la interacción de las pestañas
        $(".menuSecciones li").each(function(index, value) {
            $(this).click(function(){            
                //Borramos la clase activo de todas las opciones del menú y de todas las secciones
                $(".menuSecciones li, .secciones section").filter(".activo").removeClass("activo");

                //Asignamos la clase activo a nueva opción del menú
                $(this).addClass("activo");

                //Asignamos la clase activo a la correspondiente opción del menú
                $(".secciones section").eq(index).addClass("activo");
            })
        });




    //-------------------- Código para las ventanas modales
        //---------- Abrir ventanas modales
        //Código para abrir ventana modal en el dashboard mediante el botón para añadir una factura o un ingreso
        $("#btnEngadirDocumento").click(function(){
            funciones.abrirVentanaModal($("#modalEngadirFacturaIngreso"));
        })



        //Código para abrir la ventana modal para cambiar la contraseña
        $("#btnContrasinal").click(function(){
            funciones.abrirVentanaModal($("#modalCambiarContrasinal"));
        });



        //Código para mostrar la ventana modal para añadir un albarán
        $("#btnEngadirAlbaran").click(function(){
            funciones.abrirVentanaModal($("#modalAltaAlbaranes"));
        })

        

        //Código para mostrar la ventana modal para modificar el precio de una campaña
        $("#btnModalEditarPrecio").click(function(){
            $("#formularioEditarPrecio #anoPrecio").val($("#consultaRecolectas h3 .ano").text());
            funciones.abrirVentanaModal($("#modalEditarPrecio"));
        })



        //Código para abrir la ventana modal para añadir una nueva parcela
        $("#btnNuevaParcela").click(function(){
            $.ajax({ 
                url: "../controlador/funcionesAJAX.php", 
                type: 'POST',
                async: true, 
                data: {"ventanasModales": "modalAltaParcela"},
                success: (respuesta) => {
                    $("#ventanasModales").append(respuesta);
                    funciones.abrirVentanaModal($("#modalAltaParcela"));
                }
            });
        })
        
        

    
        //---------- Cerrar ventanas modales
        $("dialog .close-rounded").each(function(index, value){
            $(this).click(function(){
                funciones.cerrarVentanaModal(this.offsetParent);
            });
        });




    //-------------------- Flechas de navegación
        //Código de las fechas de navegación
        $(".chevron-left-rounded, .chevron-right-rounded").click(function(){  
            let idContenedor = this.offsetParent.id;
            let ano = parseInt($(`#${idContenedor} .ano`)[0].textContent);
            
            if ($(this).hasClass("chevron-left-rounded")){
                ano -= 1;
            } else {
                ano += 1;
            }

            $(`#${idContenedor} .ano`)[0].textContent = ano;

            let enviarDatos =  "";
            if ($("#btnConsultaUsuarios").length){
                enviarDatos = {"ano": ano, "obtenerDocumentos": this.offsetParent.id, "dni": $("#dni").val()};

            } else {
                enviarDatos = {"ano": ano, "obtenerDocumentos": this.offsetParent.id};
            }

            $.ajax({ 
                url: '../controlador/funcionesAJAX.php', 
                type: 'POST',
                data: enviarDatos,
                async: true, 
                success: (respuesta) => {
                    let datos = JSON.parse(respuesta);

                    switch(idContenedor){
                        case "facturas":
                            funciones.mostrarTablaFacturas(idContenedor, datos['facturas'], datos['rol']);
                            break;

                        case "ingresos":
                            funciones.mostrarTablaIngresos(idContenedor, datos['ingresos'], datos['rol']);
                            break;

                        case "albaranes": 
                            funciones.mostrarTablaAlbaranes(idContenedor, datos['albaranes'], datos['rol']);
                            break;

                        case "mostrarAlbaranes":
                            funciones.mostrarTablaAlbaranes(idContenedor, datos['albaranes'], datos['rol']);
                            
                            //Mostrar tabla resumen vendimia
                            $.ajax({ 
                                url: '../controlador/funcionesAJAX.php', 
                                type: 'POST',
                                data: { "ano": ano, "obtenerDocumentos": "consultaRecolectas"},
                                async: true, 
                                success: (respuestaRecolectas) => {
                                    let datos = JSON.parse(respuestaRecolectas);
                                    funciones.mostrarTablaResumenVendimia("resumenVendimia", datos['recolectas'], datos['rol']);
                                    }
                            })

                            break;

                        case "consultaRecolectas":
                            funciones.mostrarTablaResumenVendimia(idContenedor, datos['recolectas'], datos['rol']);
                            break;
                    }
                }
            })
        });




    //-------------------- Código de formularios --------------------

        //Código para activar el input de la cuenta bancaria (altaUsuario.php)
        $("#formaPago").change(function(){
            if (this.value == "domiciliado"){
                $("#cuentaBancaria")[0].disabled = false;
                $("#cuentaBancaria")[0].required = true;
                $("#cuentaBancaria")[0].ariaRequired = true;
                $("#cuentaBancaria")[0].focus();
            
            } else {
                $("#cuentaBancaria").empty();
                $("#cuentaBancaria")[0].disabled = true;
                $("#cuentaBancaria")[0].required = false;
                $("#cuentaBancaria")[0].ariaRequired = false;
            }
        })



        //Código para detectar los input al perder el foco
        $("input:not([type='submit'])").blur(function(){
            let formularioPadre = $(this).closest("form").attr("id");

            let error = funciones.validarCamposFormulario(this.className, this.id);

            if (error == ""){
                $(this).removeClass("campoInvalido");

                if (error == "" && this.className == "codigoPostal"){
                    funciones.obtenerMunicipio($(this).val(), formularioPadre);

                } else if ($(".direccion").length) {
                    //Comprobamos si los campos de la dirección están cubiertos y mostramos el mapa
                    funciones.comprobarDireccion(formularioPadre);
                }

            } else if (error != ""){
                $(this).addClass("campoInvalido");
                funciones.mostrarNotificacionError(formularioPadre, error);
                $(this).focus();
            }
        })



        //Código que previsualiza la imagen de perfil de usuario al añadir o modificar los datos de un usuario
        $("#imagenPerfil").change(function (e) {
            let imagenActual = $("#imagenUsuario").attr("src");
            funciones.previsualizarImagen(e, imagenActual);
        });



        //Código que activa el botón Nuevo usuario
        $("#btnNuevoUsuario").click(function(){
            $(".altaUsuario > div").css("display", "none"); 
            $("#formularioAltaUsuario")[0].reset();
            $(`#formularioAltaUsuario label`).removeClass("inputCubierto");
        })

        

                                   




        //-------------------- Formularios de alta de facturas e ingresos
            //Código que muestra el formulario de facturas o ingresos según la opción seleccionada
            $("input[name='tipo']").change(function() {
                //Borramos la clase activo de todas las opciones y de todos los formularios
                $("input[name='tipo'], .formularios form").filter(".activo").removeClass("activo");
        
                //Asignamos la clase activo a nueva opción del menú
                (this.value == "factura") ? $("#formularioFactura").addClass("activo") : $("#formularioIngreso").addClass("activo");
            })
            



        //-------------------- Código para mostrar datos en los campos de los formularios
            //Código para mostrar el número de factura que corresponde
            if ($("#numeroFactura").length){
                funciones.calcularNumero($("#numeroFactura").attr("id"));
            }


    
            //Código para mostra el número de ingreso que corresponde
            if ($("#numeroIngreso").length){
                funciones.calcularNumero($("#numeroIngreso").attr("id"));
            }

    

            //Código para mostrar el número de albarán que corresponde
            if ($("#numeroAlbaran").length){
                funciones.calcularNumero($("#numeroAlbaran").attr("id"));
            }
            
  
    
            //Código para mostrar las parcelas de un usuario en concreto en un formulario
            if ($("#parcelas").length){
                $("#usuariosAlbaran").change(function(){
                    if ($(this).val() != "" || $(this).val() != "predeterminado"){
                        let usuarioParcelas = $("#usuariosAlbaran").val();
                        $.ajax({ 
                            url: "../controlador/funcionesAJAX.php", 
                            type: 'POST',
                            async: true, 
                            data: {"parcela": "obtenerParcelasUsuario", "id": usuarioParcelas},
                            success: (respuesta) => {
                                let datosParcelas = JSON.parse(respuesta);

                                datosParcelas.forEach(parcela => {
                                    $("#parcelas").append(`<option value="${parcela.id}">${parcela.nombre}</option>`);
                                });

                                $("#parcelas").removeAttr("disabled");
                            }
                        })
                    }
                })
            }
           

    
            //Código para mostrar la fecha en los formularios
            if ($(".fecha").length > 0){
                $(".fecha").each(function(index, value){
                    funciones.calcularFecha(value);
                });
            };        



        //-------------------- Enviar datos al servidor --------------------
            //---------- Usuarios
                //Código para enviar el formulario de alta de un usuario al servidor
                $("#formularioAltaUsuario").submit(function(event){
                    event.preventDefault();
                
                    if (funciones.validarFormulario(this.id)){
                        const datos = new FormData(this);
                        datos.append("municipio", $("#municipio").val());
                        datos.append("provincia", $("#provincia").val());
                        datos.append("alta", "altaUsuario");
                
                        fetch("../controlador/funcionesAJAX.php", {
                            method: 'POST',
                            body: datos
                        })
                
                        .then (response => response.json())
                        .then (data => {
                            switch (data){
                                case 0:
                                    funciones.mostrarNotificacionError(this.id, "Error al añadir el usuario"); 
                                    break;

                                case 1:
                                    funciones.mostrarNotificacionExito(this.id, "El usuario se añadió a la base de datos");
                                    $(".altaUsuario > div").css("display", "flex");

                                    $("#engadirParcelas")[0].scrollIntoView({
                                        behavior: "smooth",
                                        block: "start"
                                    });

                                    break;

                                default:
                                    funciones.mostrarNotificacionError(this.id, data);
                            }                
                        })
                        .catch (error => {alert(`Hubo un error al guardar el usuario: ${error}`)});
                    } else {
                        funciones.mostrarNotificacionError(this.id, "No se pudo enviar el formulario porque faltan datos por completar");
                    }
                });



                //Código para enviar el usuario a consultar en la página consultaUsuarios
                $("#formularioConsultaUsuarios").submit(function(event){
                    event.preventDefault();

                    if (funciones.validarFormulario(this.id)){
                        const datos = new FormData(this);  
                        datos.append("usuarios", "consultaUsuarios");
                        datos.append("tipoConsulta", "individual");              
                
                        fetch("../controlador/funcionesAJAX.php", {
                            method: 'POST',
                            body: datos
                        })
                
                        .then (response => response.text())
                        .then (data => {
                            $(".consultaUsuarios .datosPerfil").empty();
                            $(".consultaUsuarios .datosPerfil").append(data);
                                        
                        })
                        .catch (error => {alert(`Hubo un error al mostrar los albaranes del usuario: ${error}`)});

                    } else {
                        funciones.mostrarNotificacionError(this.id, "No se pudo enviar el formulario porque faltan datos por completar");
                    }
                })



                //Código para enviar el cambio de datos de un usuario
                $("#formularioEditarPerfil").submit(function (event){
                    event.preventDefault();

                    if (funciones.validarFormulario(this.id)){
                        const datos = new FormData(this);  
                        datos.append("usuarios", "editarUsuario");              
                
                        fetch("../controlador/funcionesAJAX.php", {
                            method: 'POST',
                            body: datos
                        })
                    
                        .then (response => response.json())
                        .then (data => {
                            if (data == 1){
                                funciones.mostrarNotificacionExito(this.id, "Datos actualizados");
                            } else {
                                funciones.mostrarNotificacionError(this.id, data);
                            }
                                            
                        })

                        .catch (error => {alert(`Hubo un error actualizar los datos del usuario: ${error}`)});

                    } else {
                        funciones.mostrarNotificacionError(this.id, "No se pudo enviar el formulario porque faltan datos por completar");
                    }
                });



                //Código que muestra los documentos de un usuario
                $("#formularioConsultaDocumentos").submit(function(event){
                    event.preventDefault();

                    if (funciones.validarFormulario(this.id)){
                        const datos = new FormData(this);  
                        datos.append("obtenerDocumentos", "ingresosFacturas");
                        datos.append("ano", new Date().getFullYear());              
                
                        fetch("../controlador/funcionesAJAX.php", {
                            method: 'POST',
                            body: datos
                        })
                
                        .then (response => response.text())
                        .then (data => {
                            let datos = JSON.parse(data);
                            $("#mostrarDocumentos").css("display", "flex");
                            funciones.mostrarTablaFacturas("tablaFacturas", datos['facturas'], datos['rol']);
                            $("#facturas").append("<button id='btnBorrarFacturas' class='btnOscuro' name='btnBorrarFacturas'>Borrar seleccionadas</button>");
                            funciones.mostrarTablaIngresos("tablaIngresos", datos['ingresos'], datos['rol']);
                            $("#ingresos").append("<button id='btnBorrarIngresos' class='btnOscuro' name='btnBorrarIngresos'>Borrar seleccionadas</button>");
                                        
                        })
                        .catch (error => {alert(`Hubo un error al mostrar los documentos del usuario: ${error}`)});

                    } else {
                        funciones.mostrarNotificacionError(this.id, "No se pudo enviar el formulario porque faltan datos por completar");
                    }
                })




            //---------- Parcelas
                //Código para enviar el formulario de alta de una parcela al servidor
                $("#formularioAltaParcela").submit(function(event){
                    event.preventDefault();

                    if (funciones.validarFormulario(this.id)){
                        const datos = new FormData(this);
                        datos.append("municipio", $("#municipioParcela").val());
                        datos.append("provincia", $("#provinciaParcela").val());
                        datos.append("usuario", $("#dni").val());
                        datos.append("alta", "altaParcela");
                
                        fetch("../controlador/funcionesAJAX.php", {
                            method: 'POST',
                            body: datos
                        })
                
                        .then (response => response.json())
                        .then (data => {
                            switch (data){
                                case 0:
                                    funciones.mostrarNotificacionError(this.id, "Error al añadir la parcela"); 
                                    break;

                                case 1:
                                    funciones.mostrarNotificacionExito(this.id, "La parcela se añadió a la base de datos");
                                    $(`#${this.id}`)[0].reset();
                                    $(`#${this.id} label`).removeClass("inputCubierto");

                                    $(".mapa").empty();
                                    $(".mapa").css("padding", "1rem");
                                    $(".mapa").append("<p>Introduce los datos de la dirección para mostrar en el mapa la parcela</p>")
                                    
                                    //Actualizar tabla parcelas
                                    funciones.mostrarTablaParcelasNuevaParcela("parcelas", $("#dni").val());

                                    $(`#nombreParcela`).focus();
                                    break;

                                default:
                                    funciones.mostrarNotificacionError(this.id, data);
                            }                
                        })
                        .catch (error => {alert(`Hubo un error al guardar la parcela: ${error}`)});
                    } else {
                        funciones.mostrarNotificacionError(this.id, "No se pudo enviar el formulario porque faltan datos por completar");
                    }
                });




            //---------- Ingresos y facturas
                //Código para enviar los formularios de alta de una factura o de un ingreso al servidor
                $("#formularioFactura, #formularioIngreso").submit(function(event){
                    event.preventDefault();

                    if (funciones.validarFormulario(this.id)){
                        let documento = "";
                        const datos = new FormData(this);
                        
                        if (this.id == "formularioFactura"){
                            datos.append("numeroFactura", $("#numeroFactura").val());
                            datos.append("alta", "altaFactura");
                            documento = "Factura";

                        } else if (this.id == "formularioIngreso"){
                            datos.append("numeroIngreso", $("#numeroIngreso").val());
                            datos.append("alta", "altaIngreso");
                            documento = "Ingreso";
                        }
                
                        fetch("../controlador/funcionesAJAX.php", {
                            method: 'POST',
                            body: datos
                        })
                
                        .then (response => response.json())
                        .then (data => {
                            let mensaje = "";
                            switch (data){
                                case 0:
                                    mensaje = (documento == "Factura") ? "Error al añadir la factura" : "Error al añadir el ingreso";
                                    funciones.mostrarNotificacionError(this.id, mensaje); 
                                    break;

                                case 1:
                                    mensaje = (documento == "Factura") ? "La factura se añadió a la base de datos" : "El ingreso se añadió a la base de datos";
                                    funciones.mostrarNotificacionExito(this.id, mensaje);
                                    $(`#${this.id}`)[0].reset();

                                    funciones.calcularNumero($(`#numero${documento}`).attr("id"));
                                    funciones.calcularFecha($(`#fecha${documento}`)[0]);

                                    $.ajax({ 
                                        url: "../controlador/funcionesAJAX.php", 
                                        type: 'POST',
                                        async: true, 
                                        data: {"refrescar": "tablaUltimosMovimientos"},
                                        success: (respuestaRefrescar) => {
                                            $("#dashboardAdmin div:first-child .tabla").empty(); 
                                            $("#dashboardAdmin div:first-child .tabla").append(respuestaRefrescar);
                                        }
                                    })

                                    
                    
                                    break;

                                default:
                                    funciones.mostrarNotificacionError(this.id, data);
                            }                
                        })
                        .catch (error => {alert(`Hubo un error al guardar el documento: ${error}`)});
                    } else {
                        funciones.mostrarNotificacionError(this.id, "No se pudo enviar el formulario porque faltan datos por completar");
                    }
                })



                //Código para editar los datos de un ingreso
                $("#formularioEditarFactura, #formularioEditarIngreso").submit(function(event){
                    event.preventDefault();

                    if (funciones.validarFormulario(this.id)){
                        const datos = new FormData(this);

                        if (this.id == "formularioEditarFactura"){
                            datos.append("numeroFactura", $("#numeroFactura").val());
                            datos.append("editar", "editarFactura");
                            documento = "Factura";

                        } else if (this.id == "formularioEditarIngreso"){
                            datos.append("numeroIngreso", $("#numeroIngreso").val());
                            datos.append("editar", "editarIngreso");
                            documento = "Ingreso";
                        }
                
                        fetch("../controlador/funcionesAJAX.php", {
                            method: 'POST',
                            body: datos
                        })
                
                        .then (response => response.json())
                        .then (data => {
                            let mensaje = "";
                            switch (data){
                                case 0:
                                    mensaje = (documento == "Factura") ? "Error al editar la factura" : "Error al editar el ingreso";
                                    funciones.mostrarNotificacionError(this.id, mensaje); 
                                    break;

                                case 1:
                                    mensaje = (documento == "Factura") ? "Los datos de la factura se guardaron en la base de datos" : "Los datos del ingreso se guardaron en la base de datos";
                                    funciones.mostrarNotificacionExito(this.id, mensaje);
                                    break;

                                default:
                                    funciones.mostrarNotificacionError(this.id, data);
                            }                
                        })
                        .catch (error => {alert(`Hubo un error al modificar el documento: ${error}`)});
                    } else {
                        funciones.mostrarNotificacionError(this.id, "No se pudo enviar el formulario porque faltan datos por completar");
                    }
                })




            //---------- Albaranes
                //Código para mostrar la tabla de albaranes y resumen de vendimia de un usuario
                $("#formularioConsultaAlbaranes").submit(function(event){
                    event.preventDefault();

                    if (funciones.validarFormulario(this.id)){
                        const datos = new FormData(this);  
                        datos.append("albaranes", "mostrarSeccionAlbaranes");             
                
                        fetch("../controlador/funcionesAJAX.php", {
                            method: 'POST',
                            body: datos
                        })
                
                        .then (response => response.text())
                        .then (data => {
                            $("#mostrarAlbaranes").empty();
                            $("#mostrarAlbaranes").append(data);
                            $("#mostrarAlbaranes").css("display", "flex");
                            $("#mostrarAlbaranes > div:first-child").append("<button id='btnBorrarAlbaranes' class='btnOscuro'>Borrar seleccionados</button>");
                                        
                        })
                        .catch (error => {alert(`Hubo un error al mostrar los albaranes del usuario: ${error}`)});

                    } else {
                        funciones.mostrarNotificacionError(this.id, "No se pudo enviar el formulario porque faltan datos por completar");
                    }
                })



                //Código para guardar en la base de datos un albarán
                $("#formularioAltaAlbaranes").submit(function(event){
                    event.preventDefault();

                    if (funciones.validarFormulario(this.id)){
                        const datos = new FormData(this);  
                        datos.append("alta", "altaAlbaran");    
                        datos.append("numeroAlbaran", $("#numeroAlbaran").val());        
                
                        fetch("../controlador/funcionesAJAX.php", {
                            method: 'POST',
                            body: datos
                        })
                
                        .then (response => response.text())
                        .then (data => {
                            switch (data){
                                case "0":
                                    funciones.mostrarNotificacionError(this.id, "Error al añadir el albarán"); 
                                    break;

                                case "1":
                                    funciones.mostrarNotificacionExito(this.id, "El albarán se añadió a la base de datos");
                                    $(`#${this.id}`)[0].reset();
                                    funciones.calcularNumero($("#numeroAlbaran").attr("id"));
                                    $("#usuariosAlbaran").focus();
                                    break;

                                default:
                                    funciones.mostrarNotificacionError(this.id, data);
                            }        
                                        
                        })
                        .catch (error => {alert(`Hubo un error al dar de alta un albarán: ${error}`)});

                    } else {
                        funciones.mostrarNotificacionError(this.id, "No se pudo enviar el formulario porque faltan datos por completar");
                    }
                })

               


            //---------- Contraseña
                //Código para enviar el cambio de contraseña de un usuario al servidor
                /*$("#formularioCambiarContrasinal").submit(function(event){
                    event.preventDefault();

                    if (funciones.validarFormulario(this.id)){
                        const datos = new FormData(this);  
                        datos.append("usuarios", "cambiarContrasinal");              

                        if (datos.get("contrasinal") === datos.get("repContrasinal")){
                
                            fetch("../controlador/funcionesAJAX.php", {
                                method: 'POST',
                                body: datos
                            })
                    
                            .then (response => response.text())
                            .then (data => {
                                if (data == 0){
                                    $(`#${this.id}`)[0].reset();
                                    funciones.mostrarNotificacionExito(this.id, "Contraseña actualizada");
                                } else {
                                    funciones.mostrarNotificacionError(this.id, "Error al cambiar la contraseña");
                                }
                                            
                            })
                            .catch (error => {alert(`Hubo un error al cambiar la contraseña del usuario: ${error}`)});

                        } else {
                            funciones.mostrarNotificacionError(this.id, "Las contraseñas no son iguales");
                        }

                    } else {
                        funciones.mostrarNotificacionError(this.id, "No se pudo enviar el formulario porque faltan datos por completar");
                    }
                })*/



            
            //---------- Recolecta
                //Código que editar el precio de una campaña de vendimia
                $("#formularioEditarPrecio").submit(function(event){
                    event.preventDefault();

                    if (funciones.validarFormulario(this.id)){
                        const datos = new FormData(this);  
                        datos.append("editar", "editarPrecio");             
                
                        fetch("../controlador/funcionesAJAX.php", {
                            method: 'POST',
                            body: datos
                        })
                
                        .then (response => response.text())
                        .then (data => {
                            switch (JSON.parse(data)){
                                case 0:
                                    funciones.mostrarNotificacionError(this.id, "Error al editar el precio"); 
                                    break;

                                case 1:
                                    funciones.mostrarNotificacionExito(this.id, "El precio se actualizó correctamente");
                                    

                                    $.ajax({ 
                                        url: "../controlador/funcionesAJAX.php", 
                                        type: 'POST',
                                        async: true, 
                                        data: {"refrescar": "tablaRecolecta", "ano": $("#anoPrecio").val()},
                                        success: (respuesta) => {
                                            $("#consultaRecolectas .tabla").empty(); 
                                            $("#consultaRecolectas .tabla").append(respuesta);
                                            $(`#${this.id}`)[0].reset();
                                        }
                                    })

                                    break;

                                default:
                                    funciones.mostrarNotificacionError(this.id, data);
                            }        
                                        
                        })
                        .catch (error => {alert(`Hubo un error al dar de alta un albarán: ${error}`)});
                    }
                });



            
        //-------------------- Código de las notificaciones --------------------
            //Código para cerrar las notificaciones de error de los formularios
            $(".error .close-rounded").click(function() {
                $(this).remove();
            })
    



    //------------------- Código para los gráficos --------------------
        //Código para mostrar los gráficos del dashboard
        if ($(".dashboard").length){
            funciones.mostrarGraficoKG();
            funciones.mostrarGraficoMediaGrados();
            funciones.mostrarGraficoCircular()
        }

        if ($("#dashboardUsuario").length){
            funciones.mostrarGraficoIngresosGastos();
        }




    //------------------- Código de las acciones de las tablas --------------------
        //---------- Ingresos y facturas
            //Código para mostrar una ventana modal con los datos de un ingreso o una factura
            $(".verMovimiento").each(function(index, value){
                $(this).click(function(){

                    $.ajax({ 
                        url: "../controlador/funcionesAJAX.php", 
                        type: 'POST',
                        async: true, 
                        data: {"movimiento": this.className, "id": this.id},
                        success: (respuesta) => {
                            $("#ventanasModales").append(respuesta);
                            funciones.abrirVentanaModal($("#modalVerMovimiento"));
                        }
                    })
                })
            });



            //Código para mostrar una ventana modal con un formulario para editar los datos de un ingreso o una factura/
            $(".editarMovimiento").each(function(index, value){
                $(this).click(function(){

                    $.ajax({ 
                        url: "../controlador/funcionesAJAX.php", 
                        type: 'POST',
                        async: true, 
                        data: {"movimiento": this.className, "id": this.id},
                        success: (respuesta) => {
                            $("#ventanasModales").append(respuesta);
                            (this.id.substring(0, 1) == "F") ? funciones.abrirVentanaModal($("#modalEditarFactura")) : funciones.abrirVentanaModal($("#modalEditarIngreso"));
                        }
                    })
                })
            });


//!!!!!!!!!!11 REFRESCAR
            //Código para borrar un ingreso o una factura
            $(".eliminarMovimiento").each(function(index, value){
                $(this).click(function(){
                    if (confirm("¿Estás seguro de borrar el documento?")){
                        $.ajax({ 
                            url: "../controlador/funcionesAJAX.php", 
                            type: 'POST',
                            async: true, 
                            data: {"movimiento": this.className, "id": this.id},
                            success: (respuesta) => {
                                if (respuesta == 1){
                                    $.ajax({ 
                                        url: "../controlador/funcionesAJAX.php", 
                                        type: 'POST',
                                        async: true, 
                                        data: {"refrescar": "tablaUltimosMovimientos"},
                                        success: (respuestaRefrescar) => {
                                            $("#dashboardAdmin div:first-child .tabla").empty(); 
                                            $("#dashboardAdmin div:first-child .tabla").append(respuestaRefrescar);
                                        }
                                    })
                                    
                                    alert("El documento se borró de la base de datos");
                                } else {
                                    alert("Error al borrar el documento");
                                }
                            }
                        }) 
                    }
                })
            })



            //Código para borrar varios ingresos y facturas (checkbox)
            $("#btnBorrarDocumento, #btnBorrarFacturas, #btnBorrarIngresos").click(function(){
                let archivos = $("input[name='borrarMovimiento']:checked");

                if (archivos.length != 0){;
                    if (confirm("¿Estás seguro de borrar los documentos?")){
                        
                        let valuesArchivos = [];
                        for (let archivo of archivos){
                            valuesArchivos.push(archivo.value);
                        }
                        
                        //Enviar array a PHP
                        let enviarValores = JSON.stringify(valuesArchivos);

                        $.ajax({ 
                            url: "../controlador/funcionesAJAX.php",
                            type: 'POST',
                            async: true, 
                            data: {"borrar": "borrarVariosMovimientos", "archivos": enviarValores},
                            success: (respuesta) => {
                                if (respuesta == 1){
                                    $.ajax({ 
                                        url: "../controlador/funcionesAJAX.php", 
                                        type: 'POST',
                                        async: true, 
                                        data: {"refrescar": "tablaUltimosMovimientos"},
                                        success: (respuestaRefrescar) => {
                                            $("#dashboardAdmin div:first-child .tabla").empty(); 
                                            $("#dashboardAdmin div:first-child .tabla").append(respuestaRefrescar);
                                        }
                                    })

                                    alert("Los archivos seleccionados se han borrado");
                                } else {
                                    alert("Error al borrar los documentos");
                                }
                            }
                        })
                    }
                }
            });




        //--------- Albaranes
            //Código que muestra una ventana modal con los datos de un albarán
            $(".verAlbaran").click(function(){
                $.ajax({ 
                    url: "../controlador/funcionesAJAX.php", 
                    type: 'POST',
                    async: true, 
                    data: {"albaranes": this.className, "id": this.id},
                    success: (respuesta) => {
                        $("#ventanasModales").append(respuesta);
                        funciones.abrirVentanaModal($("#modalMostrarAlbaran"));
                        ventanasModales = funciones.obtenerBotonesCerrarVentanaModal();
                    }
                })
            });



            //Código para borrar varios ingresos y facturas (checkbox)
            $("#btnBorrarAlbaranes").click(function(){
                let archivos = $("input[name='borrarAlbaran']:checked");

                if (archivos.length != 0){;
                    if (confirm("¿Estás seguro de borrar los albaranes?")){
                        
                        let valuesArchivos = [];
                        for (let archivo of archivos){
                            valuesArchivos.push(archivo.value);
                        }
                        
                        //Enviar array a PHP
                        let enviarValores = JSON.stringify(valuesArchivos);

                        $.ajax({ 
                            url: "../controlador/funcionesAJAX.php",
                            type: 'POST',
                            async: true, 
                            data: {"borrar": "borrarVariosAlbaranes", "archivos": enviarValores},
                            success: (respuesta) => {
                                if (respuesta == 1){
                                    $.ajax({ 
                                        url: "../controlador/funcionesAJAX.php", 
                                        type: 'POST',
                                        async: true, 
                                        data: {"refrescar": "tablaAlbaranes", "dni": $("#dni").val(), "ano": $("#mostrarAlbaranes .ano").textContent},
                                        success: (respuestaRefrescar) => {
                                            $("#mostrarAlbaranes .tabla").empty(); 
                                            $("#mostrarAlbaranes .tabla").append(respuestaRefrescar);
                                        }
                                    })

                                    alert("Los archivos seleccionados se han borrado");
                                } else {
                                    alert("Error al borrar los documentos");
                                }
                            }
                        })
                    }
                }
            });




        //---------- Parcelas
            //Código que muestra una ventana modal con los datos de una parcela
            $(".verParcela").click(function(event){
                $.ajax({ 
                    url: "../controlador/funcionesAJAX.php", 
                    type: 'POST',
                    async: true, 
                    data: {"parcela": this.className, "id": this.id},
                    success: (respuesta) => {
                        $("#ventanasModales").append(respuesta);
                            
                        $.ajax({ 
                            url: "../controlador/funcionesAJAX.php", 
                            type: 'POST',
                            async: true, 
                            data: {"parcela": "obtenerDireccion", "id": this.id},
                            success: (direccion) => {
                                let datosDireccion = JSON.parse(direccion);
                                funciones.mostrarMapa("modalMostrarParcela", datosDireccion['direccion'], datosDireccion['municipio'], datosDireccion['provincia']);
                                funciones.abrirVentanaModal($("#modalMostrarParcela"));
                            }
                        })
                    }
                })
            })



            //Código para borrar una parcela
            $("#btnBorrarParcelas").click(function (){
                let archivos = $("input[name='borrarParcela']:checked"); 

                if (archivos.length != 0){
                    if (confirm("¿Estás seguro de borrar las parcelas?")){
                        
                        let valuesArchivos = [];
                        for (let archivo of archivos){
                            valuesArchivos.push(archivo.value);
                        }
                        
                        //Enviar array a PHP
                        let enviarValores = JSON.stringify(valuesArchivos);

                        $.ajax({ 
                            url: "../controlador/funcionesAJAX.php", 
                            type: 'POST',
                            async: true, 
                            data: {"borrar": "borrarVariasParcelas", "archivos": enviarValores},
                            success: (respuesta) => {
                                if (respuesta == 1){
                                    $.ajax({ 
                                        url: "../controlador/funcionesAJAX.php", 
                                        type: 'POST',
                                        async: true, 
                                        data: {"refrescar": "tablaParcelas", "dni": $("#dni").val()},
                                        success: (respuestaRefrescar) => {

                                            $("#parcelas .tabla").empty(); 
                                            $("#parcelas .tabla").append(respuestaRefrescar);
                                        }
                                    })

                                    alert("Las parcelas seleccionadas se han borrado");

                                } else {
                                    $.ajax({ 
                                        url: "../controlador/funcionesAJAX.php", 
                                        type: 'POST',
                                        async: true, 
                                        data: {"refrescar": "tablaParcelas", "dni": $("#dni").val()},
                                        success: (respuestaRefrescar) => {

                                            $("#parcelas .tabla").empty(); 
                                            $("#parcelas .tabla").append(respuestaRefrescar);
                                        }
                                    })

                                    alert("Error al borrar alguna de las parcelas");
                                    
                                }
                                
                            }, 

                            error : function(xhr, status) {
                                alert(`Hubo un error al borrar las parcelas seleccionadas + ${xhr}`);
                            }
                        });
                    }
                }
            });




        //---------- Usuarios
            //Código que muestra una ventana modal para editar los datos de un usuario
            $("#btnEditarPerfil").click(function(){
                $.ajax({ 
                    url: "../controlador/funcionesAJAX.php", 
                    type: 'POST',
                    async: true, 
                    data: {"ventanasModales": "modalEditarPerfil"},
                    success: (respuesta) => {
                        $("#ventanasModales").append(respuesta);
                        funciones.abrirVentanaModal($("#modalEditarPerfil"));
                    }
                })
            })



            //Código que elimina un usuario
            $("#btnEliminarUsuario").click(function(){
                if (confirm("¿Estás seguro de borrar el usuario?")){
                    $.ajax({ 
                        url: "../controlador/funcionesAJAX.php", 
                        type: 'POST',
                        async: true, 
                        data: {"usuario": "borrarUsuario", "id": $("#dniUsuario")},
                        success: (respuesta) => {
                            switch (data){
                                case 0:
                                    funciones.mostrarNotificacionError(this.id, "Error al borrar el usuario"); 
                                    break;

                                case 1:
                                    alert("El usuario se borró de la base de datos");
                                    $("#datosPerfil").remove();
                                    break;
                            }
                        }
                    }) 
                }
            })
})

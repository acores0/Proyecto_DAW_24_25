import * as funciones from './funciones.js';




$(() => {   

    //------------------------------ Código página login
        //Código para mostrar u ocultar la contraseña en los inputs para las contraseñas
        $(".iconoMostrarContrasinal").click(function () {
            let inputContrasinal = $(this).next()[0];

            //Con JQuery no funciona
            $(this).hasClass("eye") ? inputContrasinal.type = "text" : inputContrasinal.type = "password";
            this.classList.toggle("eye-off");
            this.classList.toggle("eye");
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
                                    $("#formularioCambiarContrasinal").empty;
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
                    .catch (error => {alert(`Hubo un error iniciar sesión: ${error}`)});
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
        $("body").on("click", ".ventanaModal", function(){
            switch($(this).attr("id")){

                //Código para abrir ventana modal en el dashboard mediante el botón para añadir una factura o un ingreso
                case "btnEngadirDocumento":
                    funciones.abrirVentanaModal($("#modalEngadirFacturaIngreso"));
                    break;

                //Código para abrir la ventana modal para cambiar la contraseña
                case "btnContrasinal":
                    funciones.abrirVentanaModal($("#modalCambiarContrasinal"));
                    break;

                //Código para mostrar la ventana modal para añadir un albarán
                case "btnEngadirAlbaran":
                    funciones.abrirVentanaModal($("#modalAltaAlbaranes"));
                    break;

                //Código para mostrar la ventana modal para modificar el precio de una campaña
                case "btnModalEditarPrecio":
                    $("#formularioEditarPrecio #anoPrecio").val($("#consultaRecolectas .ano").text());
                    funciones.abrirVentanaModal($("#modalEditarPrecio"));
                    break;

                //Código para abrir la ventana modal para añadir una nueva parcela
                case "btnNuevaParcela":
                    funciones.abrirVentanaModal($("#modalAltaParcela"));
                    $("#nombreParcela").focus();
                    break;

                //Código para abrir la ventana modal para añadir un día de vendimia
                case "btnEngadirDiasVendimia":
                    funciones.abrirVentanaModal($("#modalAltaDiasVendimia"));
                    break;
            }
        })
        
        

    
        //---------- Cerrar ventanas modales
        $("#ventanasModales").on("click", '.close-rounded', function() {
            funciones.cerrarVentanaModal($(this).closest("dialog"));
            
            //Borrar ventanas modales en el caso de que el id de la ventana coincida con alguna del array
            let arrayBorrarVentanasModales = ["modalEditarParcela", "modalVerMovimiento", "modalEditarAlbaran", "modalMostrarParcela", "modalEditarDiasVendimia", "modalMostrarAlbaran"];
            let idVentanaModal = $(this).closest("dialog").attr("id");
            if (arrayBorrarVentanasModales.includes(idVentanaModal)) $(`#${idVentanaModal}`).remove();

            //Borrar notificaciones
            $("#ventanasModales .notificaciones").empty();
            
        });




    //-------------------- Flechas de navegación
        //Código de las fechas de navegación
        $("body").on("click", ".chevron-left-rounded, .chevron-right-rounded", function(){  
            let idContenedor = this.offsetParent.id;
            let ano = parseInt($(`#${idContenedor} .ano`)[0].textContent);
            
            if ($(this).hasClass("chevron-left-rounded")){
                ano -= 1;
            } else {
                ano += 1;
            }

            $(`#${idContenedor} .ano`)[0].textContent = ano;

            let enviarDatos =  "";
            if ($("#btnConsulta").length){
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

                        case "mostrarAlbaranes": case "consultaAlbaranes":
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
        $("body").on("change", "#formaPago", function(){
            if (this.value == "domiciliado"){
                $("#cuentaBancaria")[0].disabled = false;
                $("#cuentaBancaria")[0].required = true;
                $("#cuentaBancaria")[0].ariaRequired = true;
                $("#cuentaBancaria")[0].focus();
            
            } else {
                $("#cuentaBancaria").val("");
                $("#cuentaBancaria label").removeClass("inputCubierto");
                $("#cuentaBancaria")[0].disabled = true;
                $("#cuentaBancaria")[0].required = false;
                $("#cuentaBancaria")[0].ariaRequired = false;
            }
        })



        //Código que muestra el formulario de facturas o ingresos según la opción seleccionada
        $("input[name='tipoDocumento']").change(function() {
            //Borramos la clase activo de todas las opciones y de todos los formularios
            $("input[name='tipo'], .formularios form").filter(".activo").removeClass("activo");
        
            //Asignamos la clase activo a nueva opción del menú
            (this.value == "factura") ? $("#formularioFactura").addClass("activo") : $("#formularioIngreso").addClass("activo");
        })



        //Código para detectar los input al perder el foco
        $("body").on("blur", "input:not([type='submit'])", function(){
            let formularioPadre = $(this).closest("form").attr("id");

            let error = funciones.validarCamposFormulario(this.className, this.id);

            if (error == ""){
                $(this).removeClass("campoInvalido");

                if (this.className == "codigoPostal"){
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
        $("body").on("change", "#imagenPerfil", function (e) {
            let imagenActual = $("#imagenUsuario").attr("src");
            funciones.previsualizarImagen(e, imagenActual);
        });



        //Código que activa el botón Nuevo usuario tras dar de alta un nuevo usuario
        $("#btnNuevoUsuario").click(function(){
            $(".altaUsuario > div").css("display", "none"); 
            $("#formularioAltaUsuario")[0].reset();
            $(`#formularioAltaUsuario label`).removeClass("inputCubierto");
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
            
  

            //Código para mostrar la lista de parcelas de un usuario en los formularios de los albaranes
            $("body").on("change", ".selectUsuarios", function(){
                let formulario = $(this).closest("form").attr("id");
                if ($(`#${formulario} .selectParcelas`).length){

                    if ($(this).val() != "" || $(this).val() != "predeterminado"){
                        $.ajax({ 
                            url: "../controlador/funcionesAJAX.php", 
                            type: 'POST',
                            async: true, 
                            data: {"parcela": "obtenerParcelasUsuario", "id": $(this).val()},
                            success: (respuesta) => {
                                $(".selectParcelas").empty();
                                $(".selectParcelas").append(`<option value="predeterminado">Selecciona una parcela</option>`);

                                JSON.parse(respuesta).forEach(parcela => {
                                    $(".selectParcelas").append(`<option value="${parcela.id}">${parcela.nombre}</option>`);
                                });
                                $(".selectParcelas").removeAttr("disabled");
                            }
                        })
                    }
                }
            })

           
    
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

                            if (data == ""){
                                funciones.mostrarNotificacionError(this.id, "El usuario consultado no existe en la base de datos");
                            } else {
                                $(".consultaUsuarios .datosPerfil").empty();
                                $(".consultaUsuarios .datosPerfil").append(data);
                            }           
                        })
                        .catch (error => {alert(`Hubo un error al mostrar los albaranes del usuario: ${error}`)});

                    } else {
                        funciones.mostrarNotificacionError(this.id, "No se pudo enviar el formulario porque faltan datos por completar");
                    }
                })



                //Código para enviar el cambio de datos de un usuario
                $("body").on("submit", "#formularioEditarPerfil", function (event){
                    event.preventDefault();

                    if (funciones.validarFormulario(this.id)){
                        const datos = new FormData(this);  
                        datos.append("editarDatos", "editarUsuario");              
                
                        fetch("../controlador/funcionesAJAX.php", {
                            method: 'POST',
                            body: datos
                        })
                    
                        .then (response => response.json())
                        .then (data => {
                            if (data == 1){
                                funciones.mostrarNotificacionExito(this.id, "Datos del usuario actualizados");    
                                
                                $.ajax({ 
                                    url: "../controlador/funcionesAJAX.php", 
                                    type: 'POST',
                                    async: true, 
                                    data: {
                                        "usuarios": "consultaUsuarios",
                                        "tipoConsulta": "individual",
                                        "dni": $("#dni").val()
                                    },
                                    success: (respuesta) => {
                                        $(".datosPerfil").empty();
                                        $(".datosPerfil").append(respuesta);
                                    }
                                 })   
                            
                            } else {
                                funciones.mostrarNotificacionError(this.id, "No se han modificado los datos");
                            }
                                            
                        })

                        .catch (error => {alert(`Hubo un error actualizar los datos del usuario: ${error}`)});

                    } else {
                        funciones.mostrarNotificacionError(this.id, "No se pudo enviar el formulario porque faltan datos por completar");
                    }
                });




            //---------- Parcelas
                //Código para enviar el formulario de alta de una parcela
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
                                    funciones.mostrarTablaParcelasNuevaParcela("listaParcelas", $("#dni").val());

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


                
                //Código para enviar el formulario que edita los datos de una parcela
                $("body").on("submit", "#formularioEditarParcela", function(event){
                    event.preventDefault();

                    if (funciones.validarFormulario(this.id)){
                        const datos = new FormData(this);
                        datos.append("municipio", $("#municipioEditarParcela").val());
                        datos.append("provincia", $("#provinciaEditarParcela").val())
                        datos.append("usuario", $("#dni").val());
                        datos.append("editarDatos", "editarParcela");
                
                        fetch("../controlador/funcionesAJAX.php", {
                            method: 'POST',
                            body: datos
                        })
                
                        .then (response => response.json())
                        .then (data => {
                            switch (data){
                                case 0:
                                    funciones.mostrarNotificacionError(this.id, "No se modificaron datos de la parcela");                                     
                                    break;

                                case 1:
                                    funciones.mostrarNotificacionExito(this.id, "Los datos de la parcela se actualizaron");
                                    funciones.mostrarTablaParcelasNuevaParcela("listaParcelas", $("#dni").val());
                                                                        
                                    break;

                                default:
                                    funciones.mostrarNotificacionError(this.id, data);
                            }                
                        })
                        .catch (error => {alert(`Hubo un error al modificar la parcela: ${error}`)});
                    } else {
                        funciones.mostrarNotificacionError(this.id, "No se pudo enviar el formulario porque faltan datos por completar");
                    }
                })
                



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

                                     //Hacemos scroll hacia la parte superior de la ventana modal
                                    $('#modalEngadirFacturaIngreso').animate({
                                        scrollTop : 0
                                    }, 'slow');

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



                //Código para editar los datos de un ingreso o factura                
                $('#ventanasModales').on('submit', '#formularioEditarFactura, #formularioEditarIngreso', function(event) {
                    event.preventDefault();

                    if (funciones.validarFormulario(this.id)){
                        const datos = new FormData(this);            

                        let documento = "";

                        if (this.id == "formularioEditarFactura"){
                            datos.append("numeroFactura", $("#numeroEditarFactura").val());
                            datos.append("editarDatos", "editarFactura");
                            documento = "Factura";

                        } else if (this.id == "formularioEditarIngreso"){
                            datos.append("numeroIngreso", $("#numeroEditarIngreso").val());
                            datos.append("editarDatos", "editarIngreso");
                            documento = "Ingreso";
                        }
                
                        fetch("../controlador/funcionesAJAX.php", {
                            method: 'POST',
                            body: datos
                        })
                
                        .then (response => response.json())
                        .then (data => {
                            let mensaje = "";
                            data = JSON.parse(data);

                            switch (data){
                                case 0:
                                    mensaje = (documento == "Factura") ? "No se modificaron datos de la factura" : "No se modificaron datos de la factura";
                                    funciones.mostrarNotificacionError(this.id, mensaje);                                     
                                    break;

                                case 1:
                                    mensaje = (documento == "Factura") ? "Los datos de la factura se actualizaron" : "Los datos del ingreso se actualizaron";
                                    funciones.mostrarNotificacionExito(this.id, mensaje);

                                    let refrescarDatos = "";
                                    if ($(".tabla").attr("id") == "ultimosMovimientos"){
                                        refrescarDatos = {"obtenerDocumentos": "ultimosMovimientos"};
                                    
                                    } else {
                                        refrescarDatos = (documento == "Factura") ? refrescarDatos = {"obtenerDocumentos": "facturas", "dni": $("#dni").val(), "ano": $("#facturas .ano").text()} : refrescarDatos = {"obtenerDocumentos": "ingresos", "dni": $("#dni").val(), "ano": $("#ingresos .ano").text()};
                                    
                                    }
                                    
                                    $.ajax({ 
                                        url: '../controlador/funcionesAJAX.php', 
                                        type: 'POST',
                                        data: refrescarDatos,
                                        async: true, 
                                        success: (respuesta) => {
                                            let datos = JSON.parse(respuesta);

                                            if ($(".tabla").attr("id") == "ultimosMovimientos"){
                                                funciones.mostrarTablaUltimosMovimientos("ultimosMovimientos", datos['movimientos'], datos['rol']);    
                                            
                                            } else if (documento == "Factura"){
                                                funciones.mostrarTablaFacturas("tablaFacturas", datos['facturas'], datos['rol']);

                                            }  else {
                                                funciones.mostrarTablaIngresos("tablaIngresos", datos['ingresos'], datos['rol']);
                                            }
                                        }
                                    })
                                    
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



                //Código que muestra las facturas e ingresos de un usario en el apartado de Consulta documentos
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
                            $("#mostrarAlbaranes > div:first-child").append("<button id='btnBorrarAlbaranes' class='btnOscuro'>Borrar seleccionados</button>");
                            $("#mostrarAlbaranes").css("display", "flex");
                                        
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

                                    if ($("#tablaAlbaranes").length){
                                        $.ajax({ 
                                            url: "../controlador/funcionesAJAX.php", 
                                            type: 'POST',
                                            async: true, 
                                            data: {"obtenerDocumentos": "albaranes", "dni" : $("#dni").val(), "ano" : $("#mostrarAlbaranes .ano").text()},
                                            success: (respuesta) => {
                                                let datos = JSON.parse(respuesta);
                                                funciones.mostrarTablaAlbaranes("mostrarAlbaranes", datos['albaranes'], datos['rol']);    
                                            }
                                        })
                                    }

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



                //Código para editar los datos de un albarán
                $("body").on("submit", "#formularioEditarAlbaran", function (event){
                    event.preventDefault();

                    if (funciones.validarFormulario(this.id)){
                        const datos = new FormData(this);
                        datos.append("numeroAlbaran", $("#numeroEditarAlbaran").val());
                        datos.append("editarDatos", "editarAlbaran");              
                
                        fetch("../controlador/funcionesAJAX.php", {
                            method: 'POST',
                            body: datos
                        })
                    
                        .then (response => response.json())
                        .then (data => {
                            data = JSON.parse(data);

                            switch (data){
                                case 0:
                                    funciones.mostrarNotificacionError(this.id, "No se modificaron datos del albarán");                                     
                                    break;

                                case 1:
                                    funciones.mostrarNotificacionExito(this.id, "Los datos del albarán se actualizaron");
                                    
                                    $.ajax({ 
                                        url: '../controlador/funcionesAJAX.php', 
                                        type: 'POST',
                                        data: {"obtenerDocumentos" : "albaranes", "dni" : $("#dni").val(), "ano": $("#mostrarAlbaranes .ano").text()},
                                        async: true, 
                                        success: (respuesta) => {
                                            let datos = JSON.parse(respuesta);
                                            funciones.mostrarTablaAlbaranes("tablaAlbaranes", datos['albaranes'], datos['rol']);
                                        }
                                    })
                                    
                                    break;

                                default:
                                    funciones.mostrarNotificacionError(this.id, data);
                            }                
                        })
                        .catch (error => {alert(`Hubo un error al modificar el albarán: ${error}`)});

                    } else {
                        funciones.mostrarNotificacionError(this.id, "No se pudo enviar el formulario porque faltan datos por completar");
                    }
                });


            

            //---------- Recolecta
                //Código que editar el precio de una campaña de vendimia
                $("#formularioEditarPrecio").submit(function(event){
                    event.preventDefault();

                    if (funciones.validarFormulario(this.id)){
                        const datos = new FormData(this);  
                        datos.append("editarDatos", "editarPrecio");             
                
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




            //---------- Días vendimia
                //Código para mostrar la tabla con los días de vendimia y cajas de un usuario
                $("#formularioConsultaDiasVendimia").submit(function(event){
                    event.preventDefault();

                    if (funciones.validarFormulario(this.id)){
                        const datos = new FormData(this);  
                        datos.append("diasVendimia", "mostrarSeccionDiasVendimia");
                
                        fetch("../controlador/funcionesAJAX.php", {
                            method: 'POST',
                            body: datos
                        })
                
                        .then (response => response.text())
                        .then (data => {
                            $("#mostrarDiasVendimia").empty();
                            $("#mostrarDiasVendimia").append(data);
                            $("#mostrarDiasVendimia > div:first-child").append("<button id='btnBorrarDiasVendimia' class='btnOscuro'>Borrar seleccionados</button>");
                            $("#mostrarDiasVendimia").css("display", "flex");
                                        
                        })
                        .catch (error => {alert(`Hubo un error al mostrar los albaranes del usuario: ${error}`)});

                    } else {
                        funciones.mostrarNotificacionError(this.id, "No se pudo enviar el formulario porque faltan datos por completar");
                    }
                })



                //Código para añadir los días de vendimia en la base de datos
                $("#formularioAltaDiasVendimia").submit(function(event){
                    event.preventDefault();

                    if (funciones.validarFormulario(this.id)){
                        const datos = new FormData(this);  
                        datos.append("alta", "altaDiasVendimia");
                
                        fetch("../controlador/funcionesAJAX.php", {
                            method: 'POST',
                            body: datos
                        })
                
                        .then (response => response.text())
                        .then (data => {
                            data = JSON.parse(data)
                            switch (data){
                                case 0:
                                    funciones.mostrarNotificacionError(this.id, "Error al añadir el día de la vendimia"); 
                                    break;

                                case 1:
                                    funciones.mostrarNotificacionExito(this.id, "El día de la vendimia se añadió a la base de datos");
                                    $(`#${this.id}`)[0].reset();
                                    funciones.calcularFecha($("#fechaAltaDiasVendimia")[0]);

                                    if ($("#tablaDiasVendimia").length){
                                        $.ajax({ 
                                            url: "../controlador/funcionesAJAX.php", 
                                            type: 'POST',
                                            async: true, 
                                            data: {"refrescar": "tablaDiasVendimia", "dni": $("#dniDiasVendimia").val()},
                                            success: (respuesta) => {
                                                $("#mostrarDiasVendimia .tabla").empty(); 
                                                $("#mostrarDiasVendimia .tabla").append(respuesta);
                                            }
                                        })
                                    }

                                    break;

                                default:
                                    funciones.mostrarNotificacionError(this.id, data);
                            }   
                                        
                        })
                        .catch (error => {alert(`Hubo un error guardar el día de la vendimia: ${error}`)});

                    } else {
                        funciones.mostrarNotificacionError(this.id, "No se pudo enviar el formulario porque faltan datos por completar");
                    }
                })



                //Código para editar los datos de un día de vendimia
                $("body").on("submit", "#formularioEditarDiasVendimia", function(event){
                    event.preventDefault();

                    if (funciones.validarFormulario(this.id)){
                        const datos = new FormData(this);
                        datos.append("id", $("#idDiaVendimia").val());
                        datos.append("editarDatos", "editarDiasVendimia");              
                
                        fetch("../controlador/funcionesAJAX.php", {
                            method: 'POST',
                            body: datos
                        })
                    
                        .then (response => response.json())
                        .then (data => {
                            data = JSON.parse(data);

                            switch (data){
                                case 0:
                                    funciones.mostrarNotificacionError(this.id, "No se modificaron datos del día de vendimia");                                     
                                    break;

                                case 1:
                                    funciones.mostrarNotificacionExito(this.id, "Los datos del día de vendimia se actualizaron");
                                    funciones.mostrarTablaDiasVendimia("tablaDiasVendimia", $("#dniDiasVendimia").val());
                                    break;

                                default:
                                    funciones.mostrarNotificacionError(this.id, data);
                            }                
                        })
                        .catch (error => {alert(`Hubo un error al modificar el albarán: ${error}`)});

                    } else {
                        funciones.mostrarNotificacionError(this.id, "No se pudo enviar el formulario porque faltan datos por completar");
                    }
                })



            
        //-------------------- Código de las notificaciones --------------------
            //Código para cerrar las notificaciones de error de los formularios
            $("body").on("click", ".error .close-outline", function() {
                $(this).closest(".error").remove();
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
            $(".tabla").on("click", ".verMovimiento", function () {                
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



            //Código para borrar un ingreso o una factura
            $(".tabla").on("click", ".eliminarMovimiento", function(){
                if (confirm("¿Estás seguro de borrar el documento?")){

                    $.ajax({ 
                        url: "../controlador/funcionesAJAX.php", 
                        type: 'POST',
                        async: true, 
                        data: {"movimiento": this.className, "id": this.id},
                        success: (respuesta) => {
                            if (respuesta == 1){
                                let refrescarDatos = "";

                                switch($(".tabla").attr("id")){
                                    case "ultimosMovimientos":
                                        refrescarDatos = {"obtenerDocumentos": "ultimosMovimientos"};
                                        break;
                                    case "tablaFacturas":
                                        refrescarDatos = {"obtenerDocumentos": "facturas", "dni": $("#dni").val(), "ano": $("#facturas .ano").text()};
                                        break; 
                                    case "tablaIngresos": 
                                        refrescarDatos = {"obtenerDocumentos": "ingresos", "dni": $("#dni").val(), "ano": $("#ingresos .ano").text()};          
                                        break;
                                }


                                $.ajax({ 
                                    url: "../controlador/funcionesAJAX.php", 
                                    type: 'POST',
                                    async: true, 
                                    data: refrescarDatos,
                                    success: (respuestaRefrescar) => {
                                        let datos = JSON.parse(respuestaRefrescar);

                                        switch($(".tabla").attr("id")){
                                            case "ultimosMovimientos":
                                                funciones.mostrarTablaUltimosMovimientos("ultimosMovimientos", datos['movimientos'], datos['rol']);    
                                                break;
                                                
                                            case "tablaFacturas":
                                                funciones.mostrarTablaFacturas("tablaFacturas", datos['facturas'], datos['rol']);
                                                break;
    
                                            case "tablaIngresos":
                                                funciones.mostrarTablaIngresos("tablaIngresos", datos['ingresos'], datos['rol']);
                                                break;
                                            }
                                        }
                                    })
                                    
                                alert("El documento se borró de la base de datos");
                            } else {
                                alert("Error al borrar el documento");
                            }
                        }
                    }) 
                }
            });
            


            //Código para borrar varios ingresos y facturas (checkbox)
            $("body").on("click", "#btnBorrarDocumento, #btnBorrarFacturas, #btnBorrarIngresos", function(){
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
                            data: {"borrarVariosRegistros": "borrarVariosMovimientos", "archivos": enviarValores},
                            success: (respuesta) => {
                                if (respuesta == 1){
                                    let refrescarDatos = "";

                                    switch($(".tabla").attr("id")){
                                        case "ultimosMovimientos":
                                            refrescarDatos = {"obtenerDocumentos": "ultimosMovimientos"};
                                            break;
                                        case "tablaFacturas":
                                            refrescarDatos = {"obtenerDocumentos": "facturas", "dni": $("#dni").val(), "ano": $("#facturas .ano").text()};
                                            break; 
                                        case "tablaIngresos": 
                                            refrescarDatos = {"obtenerDocumentos": "ingresos", "dni": $("#dni").val(), "ano": $("#ingresos .ano").text()};          
                                            break;
                                    }

                                    $.ajax({ 
                                        url: "../controlador/funcionesAJAX.php", 
                                        type: 'POST',
                                        async: true, 
                                        data: refrescarDatos,
                                        success: (respuestaRefrescar) => {
                                            let datos = JSON.parse(respuestaRefrescar);

                                            switch($(".tabla").attr("id")){
                                                case "ultimosMovimientos":
                                                    funciones.mostrarTablaUltimosMovimientos("ultimosMovimientos", datos['movimientos'], datos['rol']);    
                                                    break;
                                                    
                                                case "tablaFacturas":
                                                    funciones.mostrarTablaFacturas("tablaFacturas", datos['facturas'], datos['rol']);
                                                    break;
        
                                                case "tablaIngresos":
                                                    funciones.mostrarTablaIngresos("tablaIngresos", datos['ingresos'], datos['rol']);
                                                    break;
                                            }
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
            $("body").on("click", ".verAlbaran", function(){
                $.ajax({ 
                    url: "../controlador/funcionesAJAX.php", 
                    type: 'POST',
                    async: true, 
                    data: {"albaranes": this.className, "id": this.id},
                    success: (respuesta) => {
                        $("#ventanasModales").append(respuesta);
                        funciones.abrirVentanaModal($("#modalMostrarAlbaran"));
                    }
                })
            });



            //Código para borrar varios ingresos y facturas (checkbox)
            $("#mostrarAlbaranes").on("click", "#btnBorrarAlbaranes", function(){
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
                            data: {"borrarVariosRegistros": "borrarVariosAlbaranes", "archivos": enviarValores},
                            success: (respuesta) => {
                                if (respuesta == 1){
                                    $.ajax({ 
                                        url: "../controlador/funcionesAJAX.php", 
                                        type: 'POST',
                                        async: true, 
                                        data: {"refrescar": "tablaAlbaranes", "dni": $("#dni").val(), "ano": $("#mostrarAlbaranes .ano").text()},
                                        success: (respuestaRefrescar) => {
                                            $("#tablaAlbaranes").empty(); 
                                            $("#tablaAlbaranes").append(respuestaRefrescar);
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
            


            //Código para eliminar un albarán
            $("body").on("click", ".eliminarAlbaran", function(){
                if (confirm("¿Estás seguro de borrar el albarán?")){
                    $.ajax({ 
                        url: "../controlador/funcionesAJAX.php", 
                        type: 'POST',
                        async: true, 
                        data: {"albaranes": "borrarAlbaran", "id": this.id},
                        success: (respuesta) => {
                            if (respuesta == 1){
                                $.ajax({ 
                                    url: "../controlador/funcionesAJAX.php", 
                                    type: 'POST',
                                    async: true, 
                                    data: {"refrescar": "tablaAlbaranes", "dni": $("#dni").val(), "ano" : $("#mostrarAlbaranes .ano").text()},
                                    success: (respuestaRefrescar) => {
                                        $("#tablaAlbaranes").empty(); 
                                        $("#tablaAlbaranes").append(respuestaRefrescar);
                                    }
                                })
                                    
                                alert("El albarán se borró de la base de datos");

                            } else {
                                alert("Error al borrar la parcela");
                            }
                        }
                    })
                }
            })




        //---------- Parcelas
            //Código que muestra una ventana modal con los datos de una parcela
            $("body").on("click", ".verParcela", function(){
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
                                funciones.mostrarMapa("datosParcela", datosDireccion['direccion'], datosDireccion['municipio'], datosDireccion['provincia']);
                                funciones.abrirVentanaModal($("#modalMostrarParcela"));
                            }
                        })
                    }
                })
            })



            //Código para eliminar una parcela
            $("body").on("click", ".eliminarParcela", function(){
                if (confirm("¿Estás seguro de borrar la parcela?")){
                    $.ajax({ 
                        url: "../controlador/funcionesAJAX.php", 
                        type: 'POST',
                        async: true, 
                        data: {"parcela": "borrarParcela", "id": this.id},
                        success: (respuesta) => {
                            if (respuesta == 1){
                                $.ajax({ 
                                    url: "../controlador/funcionesAJAX.php", 
                                    type: 'POST',
                                    async: true, 
                                    data: {"refrescar": "tablaParcelas", "dni": $("#dni").val()},
                                    success: (respuestaRefrescar) => {
                                        $("#listaParcelas .tabla").empty(); 
                                        $("#listaParcelas .tabla").append(respuestaRefrescar);
                                    }
                                })
                                    
                                alert("La parcela se borró de la base de datos");

                            } else {
                                alert("Error al borrar la parcela");
                            }
                        }
                    })
                }
            })



            //Código para borrar varias parcelas
            $("body").on("click", "#btnBorrarParcelas", function (){
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
                            data: {"borrarVariosRegistros": "borrarVariasParcelas", "archivos": enviarValores},
                            success: (respuesta) => {
                                if (respuesta == 1){
                                    $.ajax({ 
                                        url: "../controlador/funcionesAJAX.php", 
                                        type: 'POST',
                                        async: true, 
                                        data: {"refrescar": "tablaParcelas", "dni": $("#dni").val()},
                                        success: (respuestaRefrescar) => {

                                            $("#listaParcelas .tabla").empty(); 
                                            $("#listaParcelas .tabla").append(respuestaRefrescar);
                                        }
                                    })

                                    alert("Las parcelas seleccionadas se han borrado");

                                } else {
                                    alert("Hubo un error al borrar las parcelas seleccionadas: " + data);
                                }

                            }
                        });
                    }
                }
            });




        //---------- Usuarios
            //Código que muestra una ventana modal para editar los datos de un usuario
            $("body").on("click", "#btnEditarPerfil", function(){
                $.ajax({ 
                    url: "../controlador/funcionesAJAX.php", 
                    type: 'POST',
                    async: true, 
                    data: {"ventanasModales": "modalEditarPerfil", "id": $("#dniUsuario").text()},
                    success: (respuesta) => {
                        $("#ventanasModales").append(respuesta);
                        funciones.abrirVentanaModal($("#modalEditarPerfil"));
                    }
                })
            })



            //Código que elimina un usuario
            $("body").on("click", "#btnEliminarUsuario", function(){

                if (confirm("¿Estás seguro de borrar el usuario?")){
                    $.ajax({ 
                        url: "../controlador/funcionesAJAX.php", 
                        type: 'POST',
                        async: true, 
                        data: {"usuarios": "borrarUsuario", "id": $("#dniUsuario").text()},
                        success: (respuesta) => {
                            if (respuesta){
                                alert("El usuario se borró de la base de datos");
                                $(".datosPerfil").remove();
                                $("#dni").val("");

                            } else {
                                funciones.mostrarNotificacionError(this.id, "Error al borrar el usuario"); 
                            }
                        }
                    }) 
                }
            })




        //--------- Días vendimia
            //Código que elimina un día de vendimia
            $("body").on("click", ".eliminarDiasVendimia", function(){
                if (confirm("¿Estás seguro de borrar el día de vendimia?")){
                    $.ajax({ 
                        url: "../controlador/funcionesAJAX.php", 
                        type: 'POST',
                        async: true, 
                        data: {"diasVendimia": "borrarDiaVendimia", "id": this.id},
                        success: (respuesta) => {
                            if (respuesta == 1){
                                $.ajax({ 
                                    url: "../controlador/funcionesAJAX.php", 
                                    type: 'POST',
                                    async: true, 
                                    data: {"refrescar": "tablaDiasVendimia", "dni": $("#dniDiasVendimia").val()},
                                    success: (respuestaRefrescar) => {
                                        $("#tablaDiasVendimia").empty(); 
                                        $("#tablaDiasVendimia").append(respuestaRefrescar);
                                    }
                                })
                                    
                                alert("El día de vendimia se borró de la base de datos");

                            } else {
                                alert("Error al borrar el día de vendimia");
                            }
                        }
                    })
                }
            })



            //Código que borra varios días de vendimia
            $("body").on("click", "#btnBorrarDiasVendimia", function(){
                let archivos = $("input[name='borrarDiasVendimia']:checked"); 

                if (archivos.length != 0){
                    if (confirm("¿Estás seguro de borrar los días de vendimia?")){
                            
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
                            data: {"borrarVariosRegistros": "borrarVariosDiasVendimia", "archivos": enviarValores},
                                success: (respuesta) => {
                                    if (respuesta == 1){
                                        $.ajax({ 
                                            url: "../controlador/funcionesAJAX.php", 
                                            type: 'POST',
                                            async: true, 
                                            data: {"refrescar": "tablaDiasVendimia", "dni": $("#dniDiasVendimia").val()},
                                            success: (respuestaRefrescar) => {

                                                $("#tablaDiasVendimia").empty(); 
                                                $("#tablaDiasVendimia").append(respuestaRefrescar);
                                            }
                                        })

                                        alert("Los días de vendimia seleccionados se han borrado");

                                    } else {
                                        alert("Hubo un error al borrar los días de vendimia: " + data);
                                    }

                                }
                            });
                        }
                    }
            })




        //---------- Editar datos
            //Código que muestra una ventana modal para editar los datos correspondientes
            $("body").on("click", ".editar", function(){
                let tipoEditar = $(this).attr('class').split(' ')[1];
                let editarDatos = {};

                switch(tipoEditar){
                    case "editarMovimiento":
                        editarDatos['movimiento'] = "modalEditarMovimiento";
                        break;

                    case "editarAlbaran":
                        editarDatos['albaranes'] = "modalEditarAlbaran";
                        break;

                    case "editarParcela":
                        editarDatos['parcela'] = "modalEditarParcela";
                        break;

                    case "diasVendimia":
                        editarDatos['diasVendimia'] = "modalEditarDiasVendimia";
                        break;
                }

                editarDatos['id'] = this.id;
                
                $.ajax({ 
                    url: "../controlador/funcionesAJAX.php", 
                    type: 'POST',
                    async: true, 
                    data: editarDatos,
                    success: (respuesta) => {
                        $("#ventanasModales").append(respuesta);

                        //Código que muestra una ventana modal para editar los datos correspondientes
                        switch(tipoEditar){
                            case "editarMovimiento":
                                (this.id.substring(0, 1) == "F") ? funciones.abrirVentanaModal($("#modalEditarFactura")) : funciones.abrirVentanaModal($("#modalEditarIngreso"));
                                break;

                            case "editarAlbaran":
                                funciones.abrirVentanaModal($("#modalEditarAlbaran"));
                                break;

                            case "editarParcela":
                                funciones.abrirVentanaModal($("#modalEditarParcela"));
                                funciones.comprobarDireccion("formularioEditarParcela");
                                $("#nombreEditarParcela").focus();
                                break;

                            case "diasVendimia":
                                funciones.abrirVentanaModal($("#modalEditarDiasVendimia"));
                                break;
                        }
                    }
                })
            })
})
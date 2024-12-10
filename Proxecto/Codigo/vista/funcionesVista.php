<?php
require_once "../controlador/funcionesControlador.php";

//-------------------- Funciones que muestran la estructura de la aplicación
/**
 * Función que muestra la cabecera HTML
 *
 * @param String $tituloPagina título de la página
 * @return void
 */
function mostrarCabeceraHTML($tituloPagina){ ?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../assets/css/base.css">
        <link rel="icon" href="../assets/imagenes/Logo_oscuro_16x16.png" type="image/x-icon">
        <title><?php echo $tituloPagina; ?></title>
    </head>

    <body>
<?php }



/**
 * Función que muestra el pide de página HTML
 *
 * @return void
 */
function mostrarPiePaginaHTML() { ?>
            <!-- JQuery -->
            <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
            
            <!-- Open Street Maps -->
            <script src="https://cdn.rawgit.com/openlayers/openlayers.github.io/master/en/v5.3.0/build/ol.js"></script>

            <!-- Apache ECharts -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.5.0/echarts.min.js"></script>

            <!-- JavaScript -->
            <script type="module" src="../js/index.js"></script>

    
        </body>
    </html>


<?php }



/**
 * Función que muestra la cabecera HTML y el menú principal
 *
 * @return void
 */
function mostrarCabecera($rol, $tituloPagina) {
    mostrarCabeceraHTML($tituloPagina); ?>

    <header id="cabeceraPrincipal">
        <div>
            <a href="../controlador/dashboard.php">
                <picture>
                    <source media="(max-width:550px)" srcset="../assets/imagenes/Logo_oscuro.png">
                    <img src="../assets/imagenes/Logo_claro.png" alt="Logo BaseInfoDB3">
                </picture>
            </a>

            <div id="menuHamburguesa">
                <p><span class="menu-rounded"></span></p>
            </div>
        </div>

        <div id="menuPrincipal">
            <div id="cerrarMenuPrincipal">
                <p><span class="close-rounded"></span></p>
            </div>

            <nav>
                <?php $rol == "usuario" ? menuUsuario() : menuAdmin(); ?>
            </nav>

            <div>
                <p><a href="cerrarSesion.php"><span class="logout-rounded"></span></a></p>
            </div>
        </div>
    </header>
<?php }



/**
 * Función que muestra el menú de un usuario administrador
 *
 * @return void
 */
function menuAdmin() { ?>
    <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="altaUsuario.php">Alta usuario</a></li>
        <li><a href="consultaUsuarios.php">Consultar usuarios</a></li>
        <li><a href="consultaDocumentos.php">Consultar documentos</a></li>
        <li><a href="vendimia.php">Vendimia</a></li>
    </ul>
<?php }



/**
 * Función que muestra el menú del usuario
 *
 * @return void
 */
function menuUsuario() { ?>
    <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="consultaDocumentos.php">Consulta documentos</a></li>
        <li><a href="vendimia.php">Vendimia</a></li>
        <li><a href="perfil.php">Perfil</a></li>
    </ul>
<?php }



/**
 * Función que muestra el título de la página
 *
 * @param String $titulo Título de la página
 * @param String $subtitulo Subtítulo de la página
 * @return void
 */
function mostrarTituloPagina($titulo, $subtitulo) { ?>
    <header class="tituloPagina">
        <h2><?php echo $titulo; ?></h2>
        <p><?php echo $subtitulo; ?></p>
    </header>
<?php }



/**
 * Función que muestra el pié de página
 *
 * @return void
 */
function mostrarPiePagina() { ?>
    <footer>
        <p>&copy; <?php echo date('Y'); ?> BaseInfoDB3</p>
        <ul>
            <li><a href="avisoLegal.php">Aviso legal</a></li>
            <li><a href="politicaPrivacidad.php">Política de privacidad</a></li>
        </ul>
    </footer>
<?php }




//-------------------- Funciones que muestran las ventanas modales de la aplicación
/**
 * Función que muestra el modal para dar de alta una parcela
 *
 * @return void
 */
function modalAltaParcela(){ ?>
    <dialog id="modalAltaParcela">
        <div class="tituloVentana">
            <h2>Añadir parcela</h2>
            <p><span class="close-rounded"></span></p>
        </div>

        <div class="contenidoVentana">
            <form id="formularioAltaParcela">
                <fieldset>
                    <legend>Datos parcela</legend>

                    <div>
                        <input type="text" name="nombreParcela" id="nombreParcela" class="texto" title="Nombre de la parcela" required aria-required="true">
                        <label for="nombreParcela">Nombre parcela</label>
                    </div>

                    <div>
                        <input type="text" name="m2Parcela" id="m2Parcela" class="numero" min="0" step="0.01" title="Metros cuadrados de la parcela" required aria-required="true">
                        <label for="m2Parcela">Metros cuadrados</label>
                    </div>

                    <div>
                        <input type="number" name="cupoParcela" id="cupoParcela" class="numero" min="0" step="0.01" title="Kilos de producción de la parcela" required aria-required="true">
                        <label for="cupoParcela">Cupo (kg)</label>
                    </div>

                    <div>
                        <input type="text" name="variedadUva" id="variedadUva" class="texto" title="Variedad de uva plantada en la parcela" required aria-required="true">
                        <label for="variedadUva">Variedad uva</label>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Datos de la dirección</legend>

                    <div>
                        <input type="text" name="direccionParcela" id="direccionParcela" class="texto direccion" title="Dirección donde se ubica la parcela" required aria-required="true">
                        <label for="direccionParcela">Dirección</label>
                    </div>

                    <div>
                        <input type="text" name="cpParcela" id="cpParcela" class="codigoPostal" title="Código postal donde se ubica la parcela" required aria-required="true">
                        <label for="cpParcela">Código postal</label>
                    </div>

                    <div>
                        <input type="text" name="municipioParcela" id="municipioParcela" class="texto" title="Municipio donde se ubica la parcela" required aria-required="true" disabled>
                        <label for="municipioParcela">Municipio</label>
                    </div>

                    <div>
                        <input type="text" name="provinciaParcela" id="provinciaParcela" class="texto" title="Provincia donde se ubica la parcela" required aria-required="true" disabled>
                        <label for="provinciaParcela">Provincia</label>
                    </div>
                </fieldset>

                <div>
                    <input type="submit" id="altaParcela" class="btnOscuro" name="altaParcela" value="Guardar parcela">
                </div>
                    
                <div class="notificaciones"></div>
            </form>

            <div id="mapaNuevaParcela" class="mapa">
                <p>Introduce los datos de la dirección para mostrar en el mapa la parcela</p>
            </div>
        </div>
    </dialog>
<?php }



/**
 * Función que muestra la ventana modal que muestra los datos de la parcela
 *
 * @param Array $datosParcela Array con los datos de la parcela a mostrar
 * @return void
 */
function modalMostrarParcela($datosParcela) { ?>
    <dialog id="modalMostrarParcela">
        <div class="tituloVentana">
            <h2>Datos de la parcela</h2>
            <p><span class="close-rounded"></span></p>
        </div>

        <div class="contenidoVentana">
            <?php foreach ($datosParcela as $parcela): ?>
                <div id="datosParcela">
                    <div>
                        <p>Nombre parcela:</p>
                        <p><?php echo $parcela['nombre']; ?></p>
                    </div>

                    <div>
                        <p>Dirección:</p>
                        <p><?php echo $parcela['direccion']; ?></p>
                    </div>

                    <div>
                        <p>Código postal:</p>
                        <p><?php echo $parcela['codigo_postal'] ;?></p>
                    </div>

                    <div>
                        <p>Municipio:</p>
                        <p><?php echo $parcela['municipio']; ?></p>
                    </div>

                    <div>
                        <p>Provincia</p>
                        <p><?php echo $parcela['provincia']; ?></p>
                    </div>

                    <div>
                        <p>Metros cuadrados:</p>
                        <p><?php echo $parcela['m2']; ?></p>
                    </div>

                    <div>
                        <p>Cupo (kg)</p>
                        <p><?php echo $parcela['cupo']; ?></p>
                    </div>
                    <div>
                        <p>Variedad/es:</p>
                        <p><?php echo $parcela['variedad_uva']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>

            <div id="mapaMostrarParcela" class="mapa"></div>
        </div>
    </dialog>
<?php }



/**
 * Función que muestra una ventana modal para editar los datos de una parcela
 *
 * @param Array $datosParcela Array con los datos de la parcela a editar
 * @return void
 */
function modalEditarParcela($datosParcela){ ?>
    <dialog id="modalEditarParcela">
        <div class="tituloVentana">
            <h2>Editar parcela</h2>
            <p><span class="close-rounded"></span></p>
        </div>

        <div class="contenidoVentana">
            <form id="formularioEditarParcela">
                <?php foreach ($datosParcela as $parcela): ?>
                    <fieldset>
                        <legend>Datos parcela</legend>

                        <input type="hidden" id="idParcela" name="idParcela" value="<?php echo $parcela['id']; ?>">

                        <div>
                            <input type="text" name="nombreEditarParcela" id="nombreEditarParcela" class="texto" title="Nombre de la parcela" required aria-required="true" value="<?php echo $parcela['nombre']; ?>">
                            <label for="nombreParcela">Nombre parcela</label>
                        </div>

                        <div>
                            <input type="text" name="m2EditarParcela" id="m2EditarParcela" class="numero" min="0" step="0.01" title="Metros cuadrados de la parcela" required aria-required="true" value="<?php echo $parcela['m2']; ?>">
                            <label for="m2Parcela">Metros cuadrados</label>
                        </div>

                        <div>
                            <input type="number" name="cupoEditarParcela" id="cupoEditarParcela" class="numero" min="0" step="0.01" title="Kilos de producción de la parcela" required aria-required="true" value="<?php echo $parcela['cupo']; ?>">
                            <label for="cupoParcela">Cupo (kg)</label>
                        </div>

                        <div>
                            <input type="text" name="editarVariedadUva" id="editarVariedadUva" class="texto" title="Variedad de uva plantada en la parcela" required aria-required="true" value="<?php echo $parcela['variedad_uva']; ?>">
                            <label for="variedadUva">Variedad uva</label>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Datos de la dirección</legend>

                        <div>
                            <input type="text" name="direccionEditarParcela" id="direccionEditarParcela" class="texto direccion" title="Dirección donde se ubica la parcela" required aria-required="true" value="<?php echo $parcela['direccion']; ?>">
                            <label for="direccionParcela">Dirección</label>
                        </div>

                        <div>
                            <input type="text" name="cpEditarParcela" id="cpEditarParcela" class="codigoPostal" title="Código postal donde se ubica la parcela" required aria-required="true" value="<?php echo $parcela['codigo_postal']; ?>">
                            <label for="cpParcela">Código postal</label>
                        </div>

                        <div>
                            <input type="text" name="municipioEditarParcela" id="municipioEditarParcela" class="texto" title="Municipio donde se ubica la parcela" required aria-required="true" disabled value="<?php echo $parcela['municipio']; ?>">
                            <label for="municipioParcela" class="inputCubierto">Municipio</label>
                        </div>

                        <div>
                            <input type="text" name="provinciaEditarParcela" id="provinciaEditarParcela" class="texto" title="Provincia donde se ubica la parcela" required aria-required="true" disabled value="<?php echo $parcela['provincia']; ?>">
                            <label for="provinciaParcela" class="inputCubierto">Provincia</label>
                        </div>
                    </fieldset>

                <?php endforeach; ?>

                <div>
                    <input type="submit" id="editarParcela" class="btnOscuro" name="editarParcela" value="Guardar parcela">
                </div>
                        
                <div class="notificaciones"></div>
            </form>

            <div id="mapaEditarParcela" class="mapa">
                <p>Generando el mapa...</p>
            </div>
        </div>
    </dialog>
<?php }



/**
 * Función que muestra la ventana modal para cambiar la contraseña
 *
 * @return void
 */
function modalCambiarContrasinal(){ ?>
    <dialog id="modalCambiarContrasinal">
        <div class="tituloVentana">
            <h2>Cambiar contraseña</h2>
            <p><span class="close-rounded"></span></p>
        </div>

        <div class="contenidoVentana">
            <form id="formularioCambiarContrasinal">
                <div>
                    <span class="eye iconoMostrarContrasinal"></span>
                    <input type="password" name="cambiarContrasinal" id="cambiarContrasinal" class="contrasinal" pattern="(?=.*[A-z])(?=.*[A-Z])(?=.*[0-9])\S{6,}" title="La contraseña debe tener 1 mayúscula, 1 minúscula, 1 número y como mínimo 6 caracteres" required aria-required="true">
                    <label for="cambiarContrasinal"><span class="lock-open-outline-rounded"></span>Contraseña nueva</label>
                </div>

                <div>
                    <span class="eye iconoMostrarContrasinal"></span>
                    <input type="password" name="repContrasinal" id="repContrasinal" class="contrasinal" pattern="(?=.*[A-z])(?=.*[A-Z])(?=.*[0-9])\S{6,}" title="La contraseña debe tener 1 mayúscula, 1 minúscula, 1 número y como mínimo 6 caracteres" required aria-required="true">
                    <label for="repContrasinal"><span class="lock-open-outline-rounded"></span>Repite la contraseña</label>
                </div>

                <div class="boton"> 
                    <input type="submit" name="btnPasswd" id="btnPasswd" class="btnOscuro" value="Cambiar contraseña">
                </div>

                <div class="notificaciones"></div>
            </form>
        </div>
    </dialog>
<?php }



/**
 * Código para mostrar una ventana modal con un formulario para editar los datos del usuario
 *
 * @return void
 */
function modalEditarPerfil($datosPerfil){ ?>
    <dialog id="modalEditarPerfil">
        <div class="tituloVentana">
            <h2>Editar datos personales</h2>
            <p><span class="close-rounded"></span></p>
        </div>
        
        <div class="contenidoVentana">
            <form id="formularioEditarPerfil">
                <?php foreach($datosPerfil as $perfil): ?>
                    <div>
                        <figure>
                            <?php if ($perfil['foto'] == ""): ?>
                                <img id="imagenUsuario" src="../assets/imagenes/Avatar_perfil.png" alt="Foto de perfil predeterminada">                        
                            <?php else: ?>
                                <img id="imagenUsuario" src="../documentosUsuarios/imagenesUsuarios/<?php echo $perfil['foto']; ?>" alt="Imagen del usuario <?php echo $perfil['nombre'] . " ". $perfil['apellidos']; ?>">
                            <?php endif; ?>
                        </figure>

                        <div class="zonaImagen">
                            <p><span class="cloud-arrow-up-outline"></span></p>
                            <input type="file" name="imagenPerfil" id="imagenPerfil">
                            <label for="imagenPerfil">Haz clic para cambiar la imagen (Opcional)</label>
                        </div>
                    </div>

                    <div>
                        <fieldset>
                            <legend>Datos del usuario</legend>

                            <div>
                                <input type="text" name="dni" id="dni" class="dni" title="Ejemplo: 12345678A" pattern="\d{8}[A-Za-z]" required aria-required="true" value="<?php echo $perfil['dni']; ?>">
                                <label for="dni">DNI</label>
                            </div>

                            <div>
                                <input type="text" name="nombre" id="nombre" class="texto" title="Nombre del usuario" required aria-required="true" value="<?php echo $perfil['nombre']; ?>">
                                <label for="nombre">Nombre</label>
                            </div>

                            <div>
                                <input type="text" name="apellidos" id="apellidos" class="texto" title="Apellidos del usuario" required aria-required="true" value="<?php echo $perfil['apellidos']; ?>">
                                <label for="apellidos">Apellidos</label>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>Datos de la dirección</legend>

                            <div>
                                <input type="text" name="direccion" id="direccion" class="texto" title="Dirección del usuario" required aria-required="true" value="<?php echo $perfil['direccion']; ?>">
                                <label for="direccion">Dirección</label>
                            </div>

                            <div>
                                <input type="text" name="cp" id="cp" class="codigoPostal" title="Ejemplo: 12345" pattern="\d{5}" required aria-required="true" value="<?php echo $perfil['codigo_postal']; ?>">
                                <label for="cp">Código postal</label>
                            </div>

                            <div>
                                <input type="text" name="municipio" id="municipio" class="texto" title="Municipio donde vive el usuario" required aria-required="true" value="<?php echo $perfil['municipio']; ?>">
                                <label for="municipio">Municipio</label>
                            </div>

                            <div>
                                <input type="text" name="provincia" id="provincia" class="texto" title="Provincia a la que pertenece el municipio" required aria-required="true" value="<?php echo $perfil['provincia']; ?>">
                                <label for="provincia">Provincia</label>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>Datos de contacto</legend>

                            <div>
                                <input type="email" name="correo" id="correo" class="correo" pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}" title="Ejemplo: correo@gmail.com" required aria-required="true" value="<?php echo $perfil['correo']; ?>">
                                <label for="correo">Correo electrónico</label>
                            </div>

                            <div>
                                <input type="tel" name="telefono" id="telefono" class="telefono" pattern="\d{9}" title="Teléfono del usuario (9 dígitos)" required aria-required="true" value="<?php echo $perfil['telefono']; ?>">
                                <label for="telefono">Teléfono</label>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>Datos de la forma de pago</legend>

                            <div>
                                <label for="formaPago">Forma de pago:</label>
                                <select name="formaPago" id="formaPago" class="select" title="Forma de cobro del usuario" required aria-required="true">
                                    <?php ($perfil['forma_pago'] == "") ? mostrarOpcionesSelectFormaPago("") : mostrarOpcionesSelectFormaPago($perfil['forma_pago']); ?>
                                </select>
                            </div>

                            <?php if ($perfil['cuenta_bancaria'] != ""): ?>
                                <div>
                                    <input type="text" name="cuentaBancaria" id="cuentaBancaria" class="cuentaBancaria" title="Introduce el IBAN" pattern="[A-Z]{2}\d{2}\s\d{4}\s\d{4}\s\d{2}\s\d{10}||[A-Z]{2}\d{22}" disabled aria-disabled="true" value="<?php echo $perfil['cuenta_bancaria']; ?>">
                                    <label for="cuentaBancaria" class="inputCubierto">IBAN Cuenta bancaria</label>
                                </div>

                            <?php else: ?>
                                <div>
                                    <input type="text" name="cuentaBancaria" id="cuentaBancaria" class="cuentaBancaria" title="Introduce el IBAN" pattern="[A-Z]{2}\d{2}\s\d{4}\s\d{4}\s\d{2}\s\d{10}||[A-Z]{2}\d{22}" disabled aria-disabled="true">
                                    <label for="cuentaBancaria">IBAN Cuenta bancaria</label>
                                </div>
                            <?php endif; ?>
                        </fieldset>

                        <div id="botonGuardarUsuario">
                            <input type="submit" id="btnGuardarUsuario" class="btnOscuro" name="btnGuardarUsuario" value="Guardar usuario">
                        </div>
                    </div>

                    <div class="notificaciones"></div>
                <?php endforeach; ?>
            </form>
        </div>
    </dialog>
<?php }



/**
 * Función que muestra el modal para dar de alta una factura o ingreso
 *
 * @param USUARIOS $usuario Objeto usuario
 * @return void
 */
function modalEngadirFacturaIngreso($usuario){ ?>
    <dialog id="modalEngadirFacturaIngreso">
        <div class="tituloVentana">
            <h2>Añadir factura / ingreso</h2>
            <p><span class="close-rounded"></span></p>
        </div>
            
        <div class="contenidoVentana">
            <div>
                <fieldset>
                    <legend>Tipo de documento</legend>
                    <div>
                        <input type="radio" name="tipoDocumento" id="factura" value="factura" checked>
                        <label for="factura">Factura</label>
                    </div>
        
                    <div>
                        <input type="radio" name="tipoDocumento" id="ingreso" value="ingreso">
                        <label for="ingreso">Ingreso</label>
                    </div>
                </fieldset>
            </div>

            <div class="formularios">
                <form id="formularioFactura" class="activo">
                    <div>
                        <input type="text" name="numeroFactura" id="numeroFactura" class="texto" title="Número de la factura" required aria-required="true" disabled aria-disabled="true">
                        <label for="numeroFactura" class="inputCubierto">Número factura</label>
                    </div>
        
                    <div>
                        <input type="date" name="fechaFactura" id="fechaFactura" class="fecha" title="Fecha de emisión de la factura" required aria-required="true">
                        <label for="fecha">Fecha</label>
                    </div>
        
                    <div>
                        <label for="usuariosFactura">Usuario</label>
                        <select id="usuariosFactura" name="usuariosFactura" class="select" title="Nombre del usuario al que pertenece la factura" required aria-required="true">
                            <?php mostrarOpcionesSelectUsuarios($usuario->obtenerTodosUsuarios(), ""); ?>
                        </select>
                    </div>
        
                    <div>
                        <input type="text" name="conceptoFactura" id="conceptoFactura" class="texto" title="Concepto de la factura" required aria-required="true">
                        <label for="concepto">Concepto</label>
                    </div>
        
                    <div>
                        <input type="number" name="baseImponible" id="baseImponible" class="numero" min="0" step="0.01" title="La base imponible debe ser un número mayor que 0" required aria-required="true">
                        <label for="baseImponible">Base imponible</label>
                    </div>
        
                    <div>
                        <label for="iva">IVA</label>
                        <select name="iva" id="iva" class="select" title="Selecciona el IVA aplicable a la factura" required aria-required="true">
                            <?php mostrarOpcionesSelectIVA(""); ?>
                        </select>
                    </div>
        
                    <div>
                        <input type="number" name="totalFactura" id="totalFactura" class="numero" min="0" step="0.01" title="EL total de la factura debe ser un número mayor que 0" required aria-required="true">
                        <label for="total">Total</label>
                    </div>
                    <div>
                        <label for="facturaPagada">Pagada:</label>
                        <select name="facturaPagada" id="facturaPagada" class="select" title="Estado de pago de la factura" required aria-required="true">
                            <option value="predeterminado" selected>Selecciona un estado de pago</option>
                            <option value="pagada">Pagada</option>
                            <option value="noPagada">No pagada</option>
                        </select>
                    </div>

                    <div>
                        <label for="facturaPDF">Factura PDF:</label>
                        <input type="file" name="facturaPDF" id="facturaPDF" class="archivo" title="Archivo PDF de la factura" required aria-required="true">
                    </div>
        
                    <div id="boton">
                        <input type="submit" name="btnFactura" id="btnFactura" value="Guardar factura" class="btnOscuro">
                    </div>

                    <div class="notificaciones"></div>
                </form>
        
                <form id="formularioIngreso">
                    <div>
                        <input type="text" name="numeroIngreso" id="numeroIngreso" class="texto" title="Número del ingreso" required aria-required="true" disabled aria-disabled="true">
                        <label for="numeroIngreso" class="inputCubierto">Número ingreso</label>
                    </div>
        
                    <div>
                        <input type="date" name="fechaIngreso" id="fechaIngreso" class="fecha" title="Fecha de ingreso" required aria-required="true">
                        <label for="fechaIngreso">Fecha</label>
                    </div>
        
                    <div>
                        <label for="usuariosIngreso">Usuario</label>
                        <select id="usuariosIngreso" name="usuariosIngreso" class="select" title="Usuario al que pertenece el ingreso" required aria-required="true">
                            <?php mostrarOpcionesSelectUsuarios($usuario->obtenerTodosUsuarios(), ""); ?>
                        </select>
                    </div>
        
                    <div>
                        <input type="text" name="conceptoIngreso" id="conceptoIngreso" class="texto" title="Concepto del ingreso" required aria-required="true">
                        <label for="conceptoIngreso">Concepto</label>
                    </div>
        
                    <div>
                        <input type="number" name="ingresoBruto" id="ingresoBruto" class="numero" min="0" step="0.01" title="El ingreso bruto debe ser un número mayor que 0" required aria-required="true">
                        <label for="ingresoBruto">Ingreso bruto</label>
                    </div>
        
                    <div>
                        <input type="number" name="porcentajeRetencion" id="porcentajeRetencion" class="numero" min="0" step="0.01" max="100" title="El porcentaje de retención debe ser un número mayor que 0 y menor o igual a 100" required aria-required="true">
                        <label for="porcentajeRetencion">Porcentaje retención</label>
                    </div>

                    <div>
                        <input type="number" name="retencion" id="retencion" class="numero" min="0" step="0.01" title="La retención debe ser un número mayor que 0" required aria-required="true">
                        <label for="retencion">Retención</label>
                    </div>
        
                    <div>
                        <input type="number" name="total" id="totalIngreso" class="numero" min="0" step="0.01" title="El total del ingreso debe ser mayor que 0" required aria-required="true">
                        <label for="totalIngreso">Total</label>
                    </div>
        
                    <div>
                        <label for="ingresoPDF">Ingreso PDF:</label>
                        <input type="file" name="ingresoPDF" id="ingresoPDF" class="archivo" title="Archivo PDF del ingreso" required aria-required="true">
                    </div>

                    <div>
                        <label for="estado">Estado:</label>
                        <select name="estado" id="estado" class="select" title="Estado del pago del ingreso" required aria-required="true">
                            <?php mostrarOpcionesSelectEstadoIngreso(""); ?>
                        </select>
                    </div>
        
                    <div id="boton">
                        <input type="submit" name="btnIngreso" id="btnIngreso" value="Guardar ingreso" class="btnOscuro">
                    </div>

                    <div class="notificaciones"></div>
                </form>
            </div>
        </div>
    </dialog>
<?php }



/**
 * Función que muestra la ventana modal para ver un movimiento
 *
 * @param String $movimiento Indica si es una factura o un ingreso
 * @param Array $datos Datos de la factura o ingreso
 * @param String $rol Rol del usuario que lo solicita
 * @return void
 */
function modalMostrarMovimiento($movimiento, $datos, $rol){ 
    $datos = cambiarFormatoFecha($datos); ?>
    <dialog id="modalVerMovimiento">
        <div class="tituloVentana">
            <?php echo ($movimiento == "factura") ? "<h2>Ver factura</h2>" : "<h2>Ver ingreso</h2>"; ?>
            <p><span class="close-rounded"></span></p>
        </div>
            
        <div class="contenidoVentana">
            <?php foreach ($datos as $datosMovimiento) :?>
            <div>
                <div>
                    <?php if ($movimiento == "factura") :?>
                        <p>Número factura:<p>
                        <p><?php echo $datosMovimiento['numero_factura'];?></p>
                    <?php else :?>
                        <p>Número ingreso:</p>
                        <p><?php echo $datosMovimiento['numero_ingreso'];?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <p>Fecha: </p>
                    <p><?php echo $datosMovimiento['fecha'];?></p>
                </div>

                <?php if ($rol == "administrador"): ?>
                    <div>
                        <p>Usuario: </p>
                        <p><?php echo $datosMovimiento['nombre'] . " " . $datosMovimiento['apellidos'];?></p>
                    </div>
                <?php endif; ?>
                
                <div>
                    <p>Concepto:</p>
                    <p><?php echo $datosMovimiento['concepto'];?></p>
                </div>


               <?php  switch($movimiento):
                    case "factura": ?>
                        <div>
                            <p>Base imponible:</p>
                            <p><?php echo $datosMovimiento['base_imponible'];?>€</p>
                        </div>

                        <div>
                            <p>IVA:</p>
                            <p><?php echo $datosMovimiento['iva'];?>%</p>
                        </div>
                        <?php break;
                    
                    case "ingreso": ?>
                        <div>
                            <p>Ingreso bruto:</p>
                            <p><?php echo $datosMovimiento['ingreso_bruto'];?>€</p>
                        </div>

                        <div>
                            <p>Porcentaje retención:</p>
                            <p><?php echo $datosMovimiento['porcentaje_retencion'];?>%</p>
                        </div>
                        <div>
                            <p>Retención:</p>
                            <p><?php echo $datosMovimiento['retencion'];?>€</p>
                        </div>

                        <?php break;
                endswitch;?>

                <div>
                    <p>Total:</p>
                    <p><?php echo $datosMovimiento ['total'];?>€</p>
                </div>

                <div>
                    <?php if ($movimiento == "ingreso"): ?>
                        <p>Estado:</p>
                        <p><?php echo $datosMovimiento['estado'];?></p>
                    <?php else: ?>
                        <p>Pagada:</p>
                        <p><?php echo ($datosMovimiento['pagada'] == 1) ? "SI" : "NO"; ?></p>
                    <?php endif; ?>
                </div>

                <div>     
                    <?php if ($movimiento == "factura"): ?>
                        <a target="_blank" href="../documentosUsuarios/archivosFacturas/<?php echo $datosMovimiento['archivo']; ?>">Descargar factura</a>
                    <?php else : ?>
                        <a target="_blank" href="../documentosUsuarios/archivosIngresos/<?php echo $datosMovimiento['archivo']; ?>">Descargar ingreso</a>
                    <?php endif; ?>
                </div>
            </div>

            <?php endforeach; ?>
        </div>
    </dialog>
<?php }



/**
 * Función que muestra la ventana modal para editar un ingreso
 *
 * @param Array $datosIngreso Array con los datos del ingreso a editar
 * @return void
 */
function modalEditarIngreso($datosIngreso, $usuario){ ?>
    <dialog id="modalEditarIngreso">
        <div class="tituloVentana">
            <h2>Editar ingreso</h2>
            <p><span class="close-rounded"></span></p>
        </div>
            
        <div class="contenidoVentana">
            <form id="formularioEditarIngreso">
                <?php foreach ($datosIngreso as $ingreso): ?>
                    <div>
                        <input type="text" name="numeroEditarIngreso" id="numeroEditarIngreso" class="texto" title="Número del ingreso" required aria-required="true" value="<?php echo $ingreso['numero_ingreso']; ?>" disabled aria-disabled="true">
                        <label for="numeroEditarIngreso" class="inputCubierto">Número ingreso</label>
                    </div>
            
                    <div>
                        <input type="date" name="fechaEditarIngreso" id="fechaEditarIngreso" class="fecha" title="Fecha de ingreso" required aria-required="true" value="<?php echo $ingreso['fecha']; ?>">
                        <label for="fechaEditarIngreso">Fecha</label>
                    </div>
            
                    <div>
                        <label for="usuariosEditarIngreso">Usuario:</label>
                        <select id="usuariosEditarIngreso" name="usuariosEditarIngreso" class="select" title="Usuario al que pertenece el ingreso" required aria-required="true">
                            <?php mostrarOpcionesSelectUsuarios($usuario->obtenerTodosUsuarios(), $ingreso['usuario']); ?>
                        </select>
                    </div>
            
                    <div>
                        <input type="text" name="conceptoEditarIngreso" id="conceptoEditarIngreso" class="texto" title="Concepto del ingreso" required aria-required="true" value="<?php echo $ingreso['concepto']; ?>">
                        <label for="conceptoEditarIngreso">Concepto</label>
                    </div>
            
                    <div>
                        <input type="number" name="editarIngresoBruto" id="editarIngresoBruto" class="numero" min="0" step="0.01" title="El ingreso bruto debe ser un número mayor que 0" required aria-required="true" value="<?php echo $ingreso['ingreso_bruto']; ?>">
                        <label for="editarIngresoBruto">Ingreso bruto</label>
                    </div>
            

                    <div>
                        <input type="number" name="porcentajeRetencionEditar" id="porcentajeRetencionEditar" class="numero" min="0" step="0.01" max="100" title="El porcentaje de retención debe ser un número mayor que 0 y menor o igual a 100" required aria-required="true" value="<?php echo $ingreso['porcentaje_retencion']; ?>">
                        <label for="porcentajeRetencionEditar">Porcentaje retención</label>
                    </div>

                    <div>
                        <input type="number" name="retencionEditar" id="retencionEditar" class="numero"min="0" step="0.01" title="La retención debe ser un número mayor que 0"  required aria-required="true" value="<?php echo $ingreso['retencion']; ?>">
                        <label for="retencionEditar">Retención</label>
                    </div>
            
                    <div>
                        <input type="number" name="editarTotalIngreso" id="editarTotalIngreso" class="numero" min="0" step="0.01" title="El total del ingreso debe ser mayor que 0" required aria-required="true" value="<?php echo $ingreso['total']; ?>">
                        <label for="editarTotalIngreso">Total</label>
                    </div>
            
                    <div>
                        <label for="estadoEditarIngreso">Estado:</label>
                        <select name="estadoEditarIngreso" id="estadoEditarIngreso" title="Estado del pago del ingreso" required aria-required="true">
                            <?php mostrarOpcionesSelectEstadoIngreso($ingreso['estado']); ?>
                        </select>
                    </div>
                    
                    <div>
                        <label for="ingresoEditarPDF">Cambiar archivo PDF (Opcional):</label>
                        <input type="file" name="ingresoEditarPDF" id="ingresoEditarPDF" class="archivo" title="Archivo PDF del ingreso">
                        <p> <a target="_blank" href="../documentosUsuarios/archivosIngresos/<?php echo $ingreso['archivo']; ?>">Ver ingreso actual</a></p>
                    </div>

            
                    <div id="boton">
                        <input type="submit" name="btnEditarIngreso" id="btnEditarIngreso" value="Guardar ingreso" class="btnOscuro">
                    </div>

                <?php endforeach; ?>

                <div class="notificaciones"></div>
            </form>
        </div>
    </dialog>
<?php }



/**
 * Función que muestra la ventana modal para editar una factura
 *
 * @param Array $datosFactura
 * @return void
 */
function modalEditarFactura($datosFactura, $usuario){ ?>
    <dialog id="modalEditarFactura">
        <div class="tituloVentana">
            <h2>Editar factura</h2>
            <p><span class="close-rounded"></span></p>
        </div>
        
        <div class="contenidoVentana">
            <?php foreach($datosFactura as $factura) ?>
                <form id="formularioEditarFactura" class="activo">
                    <div>
                        <input type="text" name="numeroEditarFactura" id="numeroEditarFactura" class="texto" title="Número de la factura" required aria-required="true" value="<?php echo $factura['numero_factura']; ?>" disabled aria-disabled="true">
                        <label for="numeroEditarFactura" class="inputCubierto">Número factura</label>
                    </div>
        
                    <div>
                        <input type="date" name="fechaEditarFactura" id="fechaEditarFactura" class="fecha" title="Fecha de emisión de la factura" required aria-required="true" value="<?php echo $factura['fecha']; ?>">
                        <label for="fechaEditarFactura">Fecha</label>
                    </div>
        
                    <div>
                        <label for="usuariosEditarFactura">Usuario</label>
                        <select id="usuariosEditarFactura" name="usuariosEditarFactura" class="select" title="Nombre del usuario al que pertenece la factura" required aria-required="true">
                            <?php mostrarOpcionesSelectUsuarios($usuario->obtenerTodosUsuarios(), $factura['usuario']); ?>
                        </select>
                    </div>
        
                    <div>
                        <input type="text" name="conceptoEditarFactura" id="conceptoEditarFactura" class="texto" title="Concepto de la factura" required aria-required="true" value="<?php echo $factura['concepto']; ?>" >
                        <label for="conceptoEditarFactura">Concepto</label>
                    </div>
        
                    <div>
                        <input type="number" name="editarBaseImponible" id="editarBaseImponible" class="numero" min="0" step="0.01" title="La base imponible debe ser un número mayor que 0" required aria-required="true" value="<?php echo $factura['base_imponible']; ?>">
                        <label for="editarBaseImponible">Base imponible</label>
                    </div>
        
                    <div>
                        <label for="ivaEditarFactura">IVA</label>
                        <select name="ivaEditarFactura" id="ivaEditarFactura" class="select" title="Selecciona el IVA aplicable a la factura" required aria-required="true">
                            <?php mostrarOpcionesSelectIVA($factura['iva']); ?>
                        </select>
                    </div>
        
                    <div>
                        <input type="number" name="editarTotalFactura" id="editarTotalFactura" class="numero" min="0" step="0.01" title="EL total de la factura debe ser un número mayor que 0" required aria-required="true" value="<?php echo $factura['total']; ?>">
                        <label for="editarTotalFactura">Total</label>
                    </div>

                    <div>
                        <label for="facturaPagadaEditar">Pagada:</label>
                        <select name="facturaPagadaEditar" id="facturaPagadaEditar" title="Estado de pago de la factura" required aria-required="true">
                            <option value="predeterminado">Selecciona una opción</option>
                            <?php echo ($factura['pagada']) ? "<option value='pagada' selected>Pagada</option>" : "<option value='noPagada' selected>No pagada</option>" ?>
                        </select>
                    </div>

                    <div>
                        <label for="editarFacturaPDF">Cambiar archivo PDF (Opcional):</label>
                        <input type="file" name="editarFacturaPDF" id="editarFacturaPDF" class="archivo" title="Archivo PDF de la factura">
                        <p><a target="_blank" href="../documentosUsuarios/archivosFacturas/<?php echo $factura['archivo']; ?>">Ver factura actual</a></p>
                    </div>
        
                    <div id="boton">
                        <input type="submit" name="btnEditarFactura" id="btnEditarFactura" value="Guardar factura" class="btnOscuro">
                    </div>

                    <div class="notificaciones"></div>
                </form>
            </div>
        </div>
    </dialog>
<?php }



/**
 * Función que muestra la ventana modal para mostrar los datos de un albarán
 *
 * @param Array $datosAlbaran
 * @param String $rol
 * @return void
 */
function modalMostrarAlbaran($datosAlbaran, $rol){ 
    $datosAlbaran = cambiarFormatoFecha($datosAlbaran); ?>

    <dialog id="modalMostrarAlbaran">
        <div class="tituloVentana">
            <h2>Ver albarán</h2>
            <p><span class="close-rounded"></span></p>
        </div>
            
        <div class="contenidoVentana">
            <?php foreach ($datosAlbaran as $albaran) :?>
            <div>
                <div>
                    <p>Número albarán:<p>
                    <p><?php echo $albaran['numero_albaran'];?></p>
                </div>

                <div>
                    <p>Fecha y hora: </p>
                    <p><?php echo $albaran['fecha_hora'];?></p>
                </div>

                <?php if ($rol == "administrador"): ?>
                    <div>
                        <p>Usuario: </p>
                        <p><?php echo $albaran['nombreUsuario'] . " " . $albaran['apellidos'];?></p>
                    </div>
                <?php endif; ?>
                
                <div>
                    <p>Parcela:</p>
                    <p><?php echo $albaran['nombreParcela'];?></p>
                </div>

                <div>
                    <p>Grado:</p>
                    <p><?php echo $albaran['grado'];?></p>
                </div>

                <div>
                    <p>Peso bruto:</p>
                    <p><?php echo $albaran['peso_bruto'];?></p>
                </div>

                <div>
                    <p>Tara:</p>
                    <p><?php echo $albaran['tara'];?></p>
                </div>

                <div>
                    <p>Peso neto:</p>
                    <p><?php echo $albaran['peso_neto'];?></p>
                </div>

                <div>
                    <p>Número de cajas:</p>
                    <p><?php echo $albaran['cajas'];?></p>
                </div>

                <div>
                    <a target="_blank" href="../documentosUsuarios/archivosAlbaranes/<?php echo $albaran['archivo']; ?>">Descargar albarán</a>
                </div>
            </div>

            <?php endforeach; ?>
        </div>
    </dialog>
<?php }



/**
 * Función que muestra la ventana modal para dar de alta un albarán
 */
function modalAltaAlbaran($usuario){ ?>
    <dialog id="modalAltaAlbaranes">
        <div class="tituloVentana">
            <h2>Añadir albarán</h2>
            <p><span class="close-rounded"></span></p>
        </div>
            
        <div class="contenidoVentana">
            <form id="formularioAltaAlbaranes">
                <div>
                    <input type="text" name="numeroAlbaran" id="numeroAlbaran" class="texto" title="Número de albarán" required aria-required="true" disabled aria-disabled="true">
                    <label for="numeroAlbaran" class="inputCubierto">Número albarán</label>
                </div>

                <div>
                    <label for="usuariosAlbaran">Usuario</label>
                    <select id="usuariosAlbaran" name="usuariosAlbaran" class="select selectUsuarios" title="Usuario al que pertenece el albarán" required aria-required="true">
                        <?php mostrarOpcionesSelectUsuarios($usuario->obtenerTodosUsuarios(), ""); ?>
                    </select>
                </div>

                <div>
                    <label for="parcelas">Parcela</label>
                    <select id="parcelas" name="parcelas" class="select selectParcelas" title="Selecciona la parcela a la que pertenece el albarán" required aria-required="true" disabled>
                        <option value="predeterminado">Selecciona una parcela</option>
                    </select>
                </div>
                    
                <div>
                    <input type="number" name="grado" id="grado" class="numero" min="10" step="0.01" max="20" title="Grado de la entrega de uva. Debe estar entre 10 y 20 grados" required aria-required="true">
                    <label for="grado">Grado</label>
                </div>

                <div>
                    <input type="number" name="pesoBruto" id="pesoBruto" class="numero" min="0" step="0.01" title="Pesada de la entrega de uva" required aria-required="true">
                    <label for="pesoBruto">Peso bruto</label>
                </div>

                <div>
                    <input type="number" name="cajas" id="cajas" class="numero" min="0" title="Número de cajas entregadas" required aria-required="true">
                    <label for="cajas">Número de cajas</label>
                </div>

                <div>
                    <label for="albaranPDF">Albarán pdf: </label>
                    <input type="file" name="albaranPDF" id="albaranPDF" class="archivo" title="Archivo PDF del albarán" required aria-required="true">
                </div>

                <div id="boton">
                    <input type="submit" id="btnAltaAlbaran" name="btnAltaAlbaran" class="btnOscuro" value="Guardar albarán">
                </div>

                <div class="notificaciones"></div>
            </form>
        </div>
    </dialog>
<?php }



/**
 * Función que muestra una ventana modal con los datos de un albarán para editarlo
 *
 * @param Array $datosAlbaran Array con los datos del albarán a editar
 * @param USUARIO $usuario Objeto usuario
 * @return void
 */
function modalEditarAlbaran($datosAlbaran, $usuario){
    $datosAlbaran = cambiarFormatoFecha($datosAlbaran); ?>

    <dialog id="modalEditarAlbaran">
        <div class="tituloVentana">
            <h2>Editar albarán</h2>
            <p><span class="close-rounded"></span></p>
        </div>
        
        <div class="contenidoVentana">
            <?php foreach ($datosAlbaran as $albaran) :?>
                <form id="formularioEditarAlbaran">
                    <div>
                        <input type="text" name="numeroEditarAlbaran" id="numeroEditarAlbaran" class="texto" title="Número de albarán" required aria-required="true" disabled aria-disabled="true" value="<?php echo $albaran['numero_albaran']; ?>">
                        <label for="numeroAlbaran" class="inputCubierto">Número albarán</label>
                    </div>

                    <div>
                        <label for="usuariosEditarAlbaran">Usuario</label>
                        <select id="usuariosEditarAlbaran" name="usuariosEditarAlbaran" class="select selectUsuarios" title="Usuario al que pertenece el albarán" required aria-required="true">
                            <?php mostrarOpcionesSelectUsuarios($usuario->obtenerTodosUsuarios(), $albaran['usuario']); ?>
                        </select>
                    </div>

                    <div>
                        <label for="editarParcelas">Parcela</label>
                        <select id="editarParcelas" name="parcelas" class="select selectParcelas" title="Selecciona la parcela a la que pertenece el albarán" required aria-required="true">
                            <?php mostrarOpcionesSelectParcelas($albaran['usuario'], $albaran['parcela']); ?>
                        </select>
                    </div>
                        
                    <div>
                        <input type="number" name="editarGrado" id="editarGrado" class="numero" min="10" step="0.01" max="20" title="Grado de la entrega de uva. Debe estar entre 10 y 20 grados" required aria-required="true" value="<?php echo $albaran['grado']; ?>">
                        <label for="editarGrado">Grado</label>
                    </div>

                    <div>
                        <input type="number" name="editarPesoBruto" id="editarPesoBruto" class="numero" min="0" step="0.01" title="Pesada de la entrega de uva" required aria-required="true" value="<?php echo $albaran['peso_bruto']; ?>">
                        <label for="editarPesoBruto">Peso bruto</label>
                    </div>

                    <div>
                        <input type="number" name="editarCajas" id="editarCajas" class="numero" min="0" title="Número de cajas entregadas" required aria-required="true" value="<?php echo $albaran['cajas']; ?>">
                        <label for="editarCajas">Cajas</label>
                    </div>

                    <div>
                        <label for="editarAlbaranPDF">Cambiar archivo PDF (Opcional): </label>
                        <input type="file" name="editarAlbaranPDF" id="editarAlbaranPDF" class="archivo" title="Archivo PDF del albarán">
                        <p><a target="_blank" href="../documentosUsuarios/archivosArbaranes/<?php echo $albaran['archivo']; ?>">Ver albarán actual</a></p>
                    </div>

                    <div id="boton">
                        <input type="submit" id="btnAltaAlbaran" name="btnAltaAlbaran" class="btnOscuro" value="Registrar albarán">
                    </div>

                    <div class="notificaciones"></div>
                </form>
            <?php endforeach;?>
        </div>
    </dialog>
<?php }



/**
 * Función que muestra una ventana modal para editar el precio de una campaña
 *
 * @return void
 */
function modalEditarPrecio(){ ?>
    <dialog id="modalEditarPrecio">
        <div class="tituloVentana">
            <h2>Editar precio</h2>
            <p><span class="close-rounded"></span></p>
        </div>
            
        <div class="contenidoVentana">
            <form id="formularioEditarPrecio">
                <div>
                    <input type="text" name="anoPrecio" id="anoPrecio" class="texto" pattern="\d{4}" required aria-required="true">
                    <label for="anoPrecio">Ano</label>
                </div>

                <div>
                    <input type="number" name="precioRecolecta" id="precioRecolecta" class="numero" step="0.01" required aria-required="true">
                    <label for="precioRecolecta">Precio</label>
                </div>

                <div>
                    <input type="number" name="porcentajeRetencion" id="porcentajeRetencion" class="numero" step="0.01" required aria-required="true">
                    <label for="porcentajeRetencion">Porcentaje de retención</label>
                </div>

                <div id="boton">
                    <input type="submit" id="btnEditarPrecio" name="btnEditarPrecio" class="btnOscuro" value="Registrar nuevo precio">
                </div>

                <div class="notificaciones"></div>
            </form>
        </div>
    </dialog>
<?php }



/**
 * Función que muestra una ventana modal para dar del alta un día de vendimia y las cajas asignadas
 *
 * @param USUARIO $usuario Objeto usuario
 * @return void
 */
function modalAltaDiasVendimia($usuario){ ?>
    <dialog id="modalAltaDiasVendimia">
        <div class="tituloVentana">
            <h2>Añadir día de vendimia</h2>
            <p><span class="close-rounded"></span></p>
        </div>
        
        <div class="contenidoVentana">
            <form id="formularioAltaDiasVendimia">
                <div>
                    <input type="date" name="fechaAltaDiasVendimia" id="fechaAltaDiasVendimia" class="fecha" title="Fecha del día de vendimia" required aria-required="true">
                    <label for="fechaAltaDiasVendimia">Fecha</label>
                </div>

                <div>
                    <label for="usuariosDiasVendimia">Usuario</label>
                    <select id="usuariosDiasVendimia" name="usuariosDiasVendimia" class="select selectUsuarios" title="Usuario al que se le asigna el día de la vendimia y las cajas" required aria-required="true">
                        <?php mostrarOpcionesSelectUsuarios($usuario->obtenerTodosUsuarios(), ""); ?>
                    </select>
                </div>
                    
                <div>
                    <input type="number" name="altaCajas" id="altaCajas" class="numero" min="0" step="0.01" title="Número de cajas asignadas al usuario" required aria-required="true">
                    <label for="altaCajas">Número de cajas</label>
                </div>

                <div class="boton">
                    <input type="submit" id="btnAltaDiasVendimia" name="btnAltaDiasVendimia" class="btnOscuro" value="Registrar día de vendimia">
                </div>

                <div class="notificaciones"></div>
            </form>
        </div>
    </dialog>
<?php }



/**
 * Función que muestra una ventana modal con el día de vendimia y cajas asignadas de un usuario para editar los esos datos
 *
 * @param Array $datosDiasVendimia Array con los datos de los días de la vendimia a mostrar
 * @param USUARIO $usuario Objeto usuario
 * @return void
 */
function modalEditarDiasVendimia($datosDiasVendimia, $usuario){ ?>
    <dialog id="modalEditarDiasVendimia">
        <div class="tituloVentana">
            <h2>Editar día de vendimia</h2>
            <p><span class="close-rounded"></span></p>
        </div>
        
        <div class="contenidoVentana">
            <?php foreach ($datosDiasVendimia as $diasVendimia): ?>

                <form id="formularioEditarDiasVendimia">
                    <input type="hidden" id="idDiaVendimia" value="<?php echo $diasVendimia['id']; ?>">
                    <div>
                        <input type="date" name="fechaEditarDiasVendimia" id="fechaEditarDiasVendimia" class="fecha" title="Fecha del día de vendimia" required aria-required="true" value="<?php echo $diasVendimia['fecha']; ?>">
                        <label for="fechaEditarDiasVendimia">Fecha</label>
                    </div>

                    <div>
                        <label for="usuariosEditarDiasVendimia">Usuario</label>
                        <select id="usuariosEditarDiasVendimia" name="usuariosEditarDiasVendimia" class="select selectUsuarios" title="Usuario al que se le asigna el día de la vendimia y las cajas" required aria-required="true">
                            <?php mostrarOpcionesSelectUsuarios($usuario->obtenerTodosUsuarios(), $diasVendimia['usuario']); ?>
                        </select>
                    </div>
                        
                    <div>
                        <input type="number" name="editarCajas" id="editarCajas" class="numero" min="0" step="0.01" title="Número de cajas asignadas al usuario" required aria-required="true" value="<?php echo $diasVendimia['cajas']; ?>">
                        <label for="altaCajas">Número de cajas</label>
                    </div>

                    <div class="boton">
                        <input type="submit" id="btnEditarDiasVendimia" name="btnEditarDiasVendimia" class="btnOscuro" value="Actualizar día de vendimia">
                    </div>

                    <div class="notificaciones"></div>
                </form>
            <?php endforeach; ?>
        </div>
    </dialog>
<?php }




//-------------------- Funciones que muestran las opciones de los selects de los formularios de la aplicación
/**
 * Función que muestra las opciones del select para seleccionar un usuario
 *
 * @param Array $listaUsuarios Array con los datos de los usuarios
 * @param String $compararUsuario Valor|"". Indica si hay un usuario seleccionado
 * @return void
 */
function mostrarOpcionesSelectUsuarios($listaUsuarios, $compararUsuario){
    if ($compararUsuario == ""){
        echo "<option value='predeterminado' selected aria-selected='true'>Selecciona un usuario</option>";
        foreach ($listaUsuarios as $datosUsuario){
            echo "<option value='" . $datosUsuario['dni'] . "'>" . $datosUsuario['nombre'] . " " . $datosUsuario['apellidos'] . "</option>";
        }    

    } else {
        echo "<option value='predeterminado'>Selecciona un usuario</option>";
        foreach ($listaUsuarios as $datosUsuario){
            if ($compararUsuario == $datosUsuario['dni']){
                echo "<option value='" . $datosUsuario['dni'] . "' selected aria-selected='true'>" . $datosUsuario['nombre'] . " " . $datosUsuario['apellidos'] . "</option>";
            } else {
                echo "<option value='" . $datosUsuario['dni'] . "'>" . $datosUsuario['nombre'] . " " . $datosUsuario['apellidos'] . "</option>";
            }
        }  
    }
}



/**
 * Función que muestra la lista de parcelas de un usuario en un select
 *
 * @param String $usuario Usuario a buscar
 * @param String $compararParcela Valor de la parcela seleccionada
 * @return void
 */
function mostrarOpcionesSelectParcelas($usuario, $compararParcela){
    echo "<option value='predeterminado'>Selecciona una parcela</option>";

    $parcelas = new Parcelas();
    $listaParcelas = $parcelas->obtenerParcelasUsuario("usuario", $usuario);
            
    foreach($listaParcelas as $parcela){
        if ($parcela['id'] == $compararParcela) {
            echo "<option value='" . $parcela['id'] . "' selected aria-selected='true'>" . $parcela['nombre'] . "</option>";
        } else {
            echo "<option value='" . $parcela['id'] . "' >" . $parcela['nombre'] . "</option>";
        }
    }
}



/**
 * Función que muestra las opciones de la forma de pago
 *
 * @param String $compararForma Valor|"" Indica si hay una opción seleccionada
 * @return void
 */
function mostrarOpcionesSelectFormaPago($compararForma){
    $formasPago = ["domiciliado", "cheque", "contado"];
    $valoresPago = ["Domiciliado", "Cheque", "Al contado"];

    if ($compararForma == ""){
        echo "<option value='predeterminado' selected aria-selected='true'>Seleccione una forma de pago</option>";
        foreach ($formasPago as $indice => $forma){
            echo "<option value='$forma'>$valoresPago[$indice]</option>";
        }
    } else {
        echo "<option value='predeterminado'>Seleccione una forma de pago</option>";
        foreach ($formasPago as $indice => $forma){
            if ($compararForma == $forma){
                echo "<option value='$forma' selected aria-selected='true'>$valoresPago[$indice]</option>";
            } else {
                echo "<option value='$forma'>$valoresPago[$indice]</option>";
            }
        }
    }
}



/**
 * Función que muestra la lista de opciones del select del IVA
 *
 * @param String $compararIVA Valor|"" Indica si hay una opción seleccionada
 * @return void
 */
function mostrarOpcionesSelectIVA($compararIVA){
    $tiposIVA = [21, 10, 4];

    if  ($compararIVA == ""){
        echo "<option value='predeterminado' selected aria-selected='true'>Selecciona un valor</option>";
        foreach($tiposIVA as $iva){
            echo "<option value='$iva'>$iva%</option>";
        }
    } else {
        echo "<option value='predeterminado'>Selecciona un valor</option>";
        foreach($tiposIVA as $iva){
            echo ($compararIVA == $iva) ? "<option value='$iva' selected aria-selected='true'>$iva%</option>" : "<option value='$iva'>$iva%</option>";
        }
    }
}



/**
 * Función que muestra la lista de opciones del select del estado de un ingreso
 *
 * @param String $compararEstado Valor|"" Indica si hay una opción seleccionada
 * @return void
 */
function mostrarOpcionesSelectEstadoIngreso($compararEstado){
    $opciones = ['pendiente de cobro', 'cobrado'];

    if ($compararEstado == ""){
        echo "<option value='predeterminado' selected aria-selected='true'>Selecciona un estado</option>";
        foreach ($opciones as $opcion){
            echo "<option value='$opcion'>$opcion</option>";
        }
    } else {
        echo "<option value='predeterminado'>Selecciona un estado</option>";
        foreach ($opciones as $opcion){
            echo ($compararEstado == $opcion) ? "<option value'$opcion' selected aria-selected='true'>$opcion</option>" : "<option value='$opcion'>$opcion</option>";
        }
    }
}




//-------------------- Funciones que muestran las tablas de la aplicación

/**
 * Función que muestra la tabla de facturas
 *
 * @param String $rol Rol del usuario
 * @param Array $facturas Array con los datos de las facturas
 * @return void
 */
function mostrarTablaFacturas($rol, $facturas) { 
    $facturas = cambiarFormatoFecha($facturas); ?>
    <table>
        <thead>
            <tr>
                <?php if ($rol == "administrador"): ?>
                    <th></th>
                <?php endif; ?>

                <th>Número de factura</th>
                <th>Fecha</th>
                <th>Concepto</th>
                <th>Base imponible</th>
                <th>IVA</th>
                <th>Total</th>
                <th>Pagada</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($facturas as $factura): ?>
                <tr>
                    <?php if ($rol == "administrador"): ?>
                        <td><input type="checkbox" id="factura<?php echo $factura['numero_factura']; ?>" name="borrarMovimiento" value="<?php echo $factura['numero_factura']; ?>"></td>
                        <td><label for="factura<?php echo $factura['numerofactura']; ?>"><?php echo $factura['numero_factura']; ?></label></td>
                    <?php else: ?>
                        <td><?php echo $factura['numero_factura']; ?></td>
                    <?php endif; ?>

                    <td><?php echo $factura['fecha']; ?></td>
                    <td><?php echo $factura['concepto']; ?></td>
                    <td><?php echo $factura['base_imponible']; ?>€</td>
                    <td><?php echo $factura['iva'] ?>%</td>
                    <td><?php echo $factura['total'] ?>€</td>
                    <td><?php echo $factura['pagada'] ? "SI" : "NO"; ?></td>

                    <td>
                        <a target="_blank" href="../documentosUsuarios/archivosFacturas/<?php echo $factura['archivo']; ?>"><span class="download-rounded" title="Descargar factura"></span></a>
                        <button id="<?php echo $factura['numero_factura']; ?>" class="verMovimiento"><span class="eye" title="Ver factura"></span></button>
                        
                        <?php if ($rol == "administrador"): ?>
                            <button id="<?php echo $factura['numero_factura']; ?>" class="editar editarMovimiento"><span class="edit" title="Editar factura"></span></button>
                            <button id="<?php echo $factura['numero_factura']; ?>" class="eliminarMovimiento"><span class="close-rounded" title="Eliminar factura"></span></button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php }



/**
 * Función que muestra la tabla de ingresos
 *
 * @param String $rol Rol del usuario
 * @param Array $ingresos Array con los datos de los ingresos
 * @return void
 */
function mostrarTablaIngresos($rol, $ingresos) { 
    $ingresos = cambiarFormatoFecha($ingresos);?>
    <table>
        <thead>
            <tr>
                <?php if ($rol == "administrador"): ?>
                    <th></th>
                <?php endif; ?>

                <th>Número de ingreso</th>
                <th>Fecha</th>
                <th>Concepto</th>
                <th>A liquidar</th>
                <th>Porcentaje</th>
                <th>Retención</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($ingresos as $ingreso): ?>
                <tr>
                    <?php if ($rol == "administrador"): ?>
                        <td><input type="checkbox" id="<?php echo $ingreso['numero_ingreso']; ?>" name="borrarMovimiento" value="<?php echo $ingreso['numero_ingreso']; ?>"></td>
                        <td><label for="parcela<?php echo $ingreso['numero_ingreso']; ?>"><?php echo $ingreso['numero_ingreso']; ?></label></td>
                   
                    <?php else: ?>
                        <td><?php echo $ingreso['numero_ingreso']; ?></td>
                    <?php endif; ?>

                    <td><?php echo $ingreso['fecha']; ?></td>
                    <td><?php echo $ingreso['concepto']; ?></td>
                    <td><?php echo $ingreso['ingreso_bruto']; ?>€</td>
                    <td><?php echo $ingreso['porcentaje_retencion']; ?>%</td>
                    <td><?php echo $ingreso['retencion']; ?>€</td>
                    <td><?php echo $ingreso['total']; ?>€</td>
                    <td><?php echo $ingreso['estado']; ?></td>
                    <td>
                        <a target="_blank" href="../documentosUsuarios/archivosIngresos/<?php echo $ingreso['archivo']; ?>"><span class="download-rounded" title="Descargar ingreso"></span></a>
                        <button id="<?php echo $ingreso['numero_ingreso']; ?>" class="verMovimiento"><span class="eye" title="Ver ingreso"></span></button>
                        
                        <?php if ($rol == "administrador"): ?>
                            <button id="<?php echo $ingreso['numero_ingreso']; ?>" class="editar editarMovimiento"><span class="edit" title="Editar ingreso"></span></button>
                            <button id="<?php echo $ingreso['numero_ingreso']; ?>" class="eliminarMovimiento"><span class="close-rounded" title="Eliminar ingreso"></span></button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php }



/**
 * Función que muestra la tabla de parcelas en función del rol del usuario
 *
 * @param String $rol Rol del usuario
 * @param Array $listaParcelas Array con los datos de las parcelas a mostrar
 * @return void
 */
function mostrarTablaParcelas($rol, $listaParcelas) { ?>
    <table>
        <thead>
            <tr>
                <?php if ($rol == "administrador"): ?>
                    <th></th>
                <?php endif; ?>

                <th>Nombre parcela</th>
                <th>Dirección</th>
                <th>Municipio</th>
                <th>Provincia</th>
                <th>M<sup>2</sup></th>
                <th>Cupo (kg)</th>
                <th>Variedad de uva</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($listaParcelas as $parcela): ?>
                <tr>
                    <?php if ($rol == "administrador"): ?>
                        <td><input type="checkbox" id="parcela<?php echo $parcela['id']; ?>" name="borrarParcela" value="<?php echo $parcela['id']; ?>"></td>
                        <td><label for="parcela<?php echo $parcela['id']; ?>"><?php echo $parcela['nombre']; ?></label>
                    <?php else: ?>
                        <td><?php echo $parcela['nombre']; ?></td>
                    <?php endif; ?>

                    <td><?php echo $parcela['direccion']; ?></td>
                    <td><?php echo $parcela['municipio']; ?></td>
                    <td><?php echo $parcela['provincia']; ?></td>
                    <td><?php echo $parcela['m2']; ?></td>
                    <td><?php echo $parcela['cupo']; ?></td>
                    <td><?php echo $parcela['variedad_uva']; ?></td>
                    <td>
                        <button id="<?php echo $parcela['id']; ?>" class="verParcela"><span class="eye" title="Ver parcela"></span></button>
                        
                        <?php if ($rol == "administrador"): ?>
                            <button id="<?php echo $parcela['id']; ?>" class="editar editarParcela"><span class="edit" title="Editar parcela"></span></button>
                            <button id="<?php echo $parcela['id']; ?>" class="eliminarParcela"><span class="close-rounded" title="Eliminar parcela"></span></button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php }



/**
 * Función que muestra la tabla de últimos movimientos
 *
 * @param String $rol Rol del usuario
 * @param Array $listaMovimientos Array con los datos de los últimos movimientos
 * @return void
 */
function mostrarTablaUltimosMovimientos($rol, $listaMovimientos) { ?>
    <table>
        <thead>
            <tr>
                <?php if ($rol == "administrador"): ?>
                    <th></th>
                    <th>Usuario</th>
                <?php endif; ?>

                <th>Tipo</th>
                <th>Número</th>
                <th>Fecha</th>
                <th>Concepto</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($listaMovimientos as $movimiento): ?>
                <tr>
                    <?php if ($rol == "administrador"): ?>
                        <td><input id="movimiento<?php echo $movimiento['numero_ingreso']; ?>" type="checkbox" name="borrarMovimiento" value="<?php echo $movimiento['numero_ingreso']; ?>"></td>
                        <td><label for="movimiento<?php echo $movimiento['numero_ingreso']; ?>"><?php echo $movimiento['usuario']; ?></label></td>
                    <?php endif; ?>

                    <td><?php echo $movimiento['tipo']; ?></td>
                    <td><?php echo $movimiento['numero_ingreso']; ?></td>
                    <td><?php echo $movimiento['fecha']; ?></td>
                    <td><?php echo $movimiento['concepto']; ?></td>
                    <td><?php echo $movimiento['total']; ?>€</td>

                    <td>
                        <?php if ($movimiento['tipo'] == "Ingreso"): ?>
                            <a target="_blank" href="../documentosUsuarios/archivosIngresos/<?php echo $movimiento['archivo']; ?>"><span class="download-rounded" title="Descargar ingreso"></span></a>
                        <?php else : ?>
                            <a target="_blank" href="../documentosUsuarios/archivosFacturas/<?php echo $movimiento['archivo']; ?>"><span class="download-rounded" title="Descargar factura"></span></a>
                        <?php endif; ?>

                        <button id="<?php echo $movimiento['numero_ingreso']; ?>" class="verMovimiento"><span class="eye" title="Ver movimiento"></span></button>
                        
                        <?php if ($rol == "administrador"): ?>
                            <button id="<?php echo $movimiento['numero_ingreso']; ?>" class="editar editarMovimiento"><span class="edit" title="Editar movimiento"></span></button>
                            <button id="<?php echo $movimiento['numero_ingreso']; ?>" class="eliminarMovimiento"><span class="close-rounded" title="Eliminar movimiento"></span></button>
                        <?php endif; ?> 
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php }



/**
 * Función que muestra la tabla de albaranes
 *
 * @param Array $listaAlbaranes Array con los datos de los albaranes a mostar
 * @return void
 */
function mostrarTablaAlbaranes($rol, $listaAlbaranes) { 
    $listaAlbaranes = cambiarFormatoFecha($listaAlbaranes); ?>
    <table>
        <thead>
            <tr>
                <?php if ($rol == "administrador"): ?>
                    <th></th>
                <?php endif; ?>

                <th>Número de albarán</th>
                <th>Fecha y hora</th>
                <th>Parcela</th>
                <th>Número de cajas</th>
                <th>Peso bruto</th>
                <th>Tara</th>
                <th>Peso neto</th>
                <th>Grado</th>
                <th>Acciones</th>
            </tr>
        </thead>
            <?php foreach ($listaAlbaranes as $albaran): ?>
                <tr>
                    <?php if ($rol == "administrador"): ?>
                        <td><input type="checkbox" id="<?php echo $albaran['numero_albaran']; ?>" name="borrarAlbaran" value="<?php echo $albaran['numero_albaran']; ?>"></td>
                        <td><label for="<?php echo $albaran['numero_albaran']; ?>"><?php echo $albaran['numero_albaran']; ?></label></td>

                    <?php else: ?>
                        <td><?php echo $albaran['numero_albaran']; ?></td>
                    <?php endif; ?>

                    <td><?php echo $albaran['fecha_hora']; ?></td>
                    <td><?php echo $albaran['nombre']; ?></td>
                    <td><?php echo $albaran['cajas']; ?></td>
                    <td><?php echo $albaran['peso_bruto']; ?></td>
                    <td><?php echo $albaran['tara']; ?></td>
                    <td><?php echo $albaran['peso_neto']; ?></td>
                    <td><?php echo $albaran['grado']; ?></td>
                    
                    <td>
                        <a target="_blank" href="../documentosUsuarios/archivosAlbaranes/<?php echo $albaran['archivo']; ?>"><span class="download-rounded" title="Descargar albarán"></span></a>
                        <button id="<?php echo $albaran['numero_albaran']; ?>" class="verAlbaran"><span class="eye" title="Ver albarán"></span></button>
                        

                        <?php if ($rol == "administrador"): ?>
                            <button id="<?php echo $albaran['numero_albaran']; ?>" class="editar editarAlbaran"><span class="edit" title="Editar albarán"></span></button>
                            <button id="<?php echo $albaran['numero_albaran']; ?>" class="eliminarAlbaran"><span class="close-rounded" title="Eliminar albarán"></span></button>
                        <?php endif; ?>

                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php }



/**
 * Función que muestra la tabla resumen de los datos de la vendimia
 *
 * @param Array $datosVendimia Array con los datos de la vendimia a mostrar
 * @return void
 */
function mostrarTablaResumenVendimia($datosVendimia, $rol){ ?>
    <table>
        <thead>
            <tr>
                <th>Total kg uva</th>
                <th>Grado medio</th>
                <th>Precio</th>
                <th>Base imponible</th>
                <th>Retención IRPF (<?php echo $datosVendimia[0]['porcentaje']; ?>%)</th>
                <?php echo ($rol == "usuario") ? "<th>Total a percibir</th>" : "<th>Total a pagar</th>" ?>
            </tr>
        </thead>

        <tbody>
            <tr>
                <?php foreach ($datosVendimia as $vendimia): ?>
                    <td><?php echo $vendimia['kg']; ?></td>
                    <td><?php echo $vendimia['graduacion']; ?></td>
                    <td><?php echo $vendimia['precio']; ?>€</td>
                    <td><?php echo $vendimia['base_imponible']; ?>€</td>
                    <td><?php echo $vendimia['retencion']; ?>€</td>
                    <td><?php echo $vendimia['total']; ?>€</td>
                <?php endforeach; ?>
            </tr>
        </tbody>
    </table>
<?php }



/**
 * Función que muestra la tabla con los días de la vendimia de un usuario y el número de cajas asignadas a cada día
 *
 * @param Array $fechasVendimia Array con las fechas de la vendimia
 * @param Array $cajasVendimia Array con las cajas de la vendimia
 * @return void
 */
function mostrarTablaDiasVendimiaUsuario($fechasVendimia, $cajasVendimia){ ?>
    <table id="tablaVendimia">
        <tbody>
            <tr>
                <td>Días de vendimia</td>
                <?php foreach ($fechasVendimia as $dias): ?>
                    <td><?php echo $dias['fecha']; ?></td>
                <?php endforeach; ?>
            </tr>

            <tr>
                <td>Número de cajas</td>
                <?php foreach ($cajasVendimia as $cajas): ?>
                    <td><?php echo $cajas['cajas'];?></td>
                <?php endforeach; ?>
            </tr>
        </tbody>
    </table>
<?php }



/**
 * Función que muestta la tabla con las fecha de la vendimia y el número de cajas asignadas
 *
 * @param Array $listaDiasVendimia Array con los datos de las fechas de las vendimias
 * @return void
 */
function mostrarTablaDiasVendimiaAdmin($listaDiasVendimia){
    $listaDiasVendimia = cambiarFormatoFecha($listaDiasVendimia); ?>
    <table>
        <thead>
            <tr>
                <th></th>
                <th>Día asignado</th>
                <th>Número de cajas asginadas</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($listaDiasVendimia as $diasVendimia): ?>
                <tr>
                    <td><input type="checkbox" id="<?php echo $diasVendimia['id']; ?>" name="borrarDiasVendimia" value="<?php echo $diasVendimia['id']; ?>"></td>
                    <td><label for="<?php echo $diasVendimia['id']; ?>"><?php echo $diasVendimia['fecha']; ?></label></td>
                    <td><?php echo $diasVendimia['cajas']; ?></td>
                    <td>
                        <button id="<?php echo $diasVendimia['id']; ?>" class="editar diasVendimia"><span class="edit" title="Editar días vendimia"></span></button>
                        <button id="<?php echo $diasVendimia['id']; ?>" class="eliminarDiasVendimia"><span class="close-rounded" title="Eliminar días vendimia"></span></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php }



/**
 * Función que muestra la tabla con la lista de usuarios y, para cada uno de ellos, se muestra el pendiente de pagar e ingresar
 * 
 * @param Array $listaUsuarios Array con la lista de usuarios a mostrar
 * @param RECOLECTA $recolecta Instancia de un objeto de tipo Recolecta
 * @param FACTURAS $facturas Instancia de un objeto de tipo Facturas
 *
 * @return void
 */
function mostrarTablaUsuariosDeuda($listaUsuarios, $recolecta, $facturas){ ?>
    <table>
        <thead>
            <tr>
                <th>Nombre y apellidos</th>
                <th>Total a pagar</th>
                <th>Total a cobrar</th>
            </tr>
        </thead>
                    
        <tbody>
            <?php foreach ($listaUsuarios as $datosUsuario) :?>
                <tr>
                    <td><?php echo $datosUsuario['nombre'] . " " . $datosUsuario['apellidos']; ?></td>
                    <td><?php echo ($recolecta->obtenerPendienteCobro($datosUsuario['dni']) == null) ? "0.00" : $recolecta->obtenerPendienteCobro($datosUsuario['dni']); ?>€</td>
                    <td><?php echo $facturas->obtenerTotalDeuda($facturas->obtenerFacturasImpagadas("usuario", $datosUsuario['dni'])); ?>€</td>
                </tr>
            <?php endforeach?>
        </tbody>
    </table>
<?php }
   



//-------------------- Funciones que muestran secciones de la aplicación
/**
 * Función que muestra los datos resumen en el dashboard del usuario
 *
 * @param USUARIOS $usuario
 * @param Float $pendienteCobrar
 * @param Float $pendientePagar
 * @param Float|INT $valorSeccion
 * @param Float $kgEntregados
 * @param Float $mediaGrados
 * @return void
 */
function mostrarResumenDashboard($usuario, $pendienteCobrar, $pendientePagar, $valorseccion, $kgEntregados, $mediaGrados){ ?>
    <section>
        <article>
            <p><span class="receive-money"></span></p>
            <div>
                <p><?php echo $pendienteCobrar; ?>€</p>
                <p>pendiente de cobrar</p>
            </div>
        </article>

        <article>
            <p><span class="pay-money"></span></p>
            <div>
                <p><?php echo $pendientePagar; ?>€</p>
                <p>pendiente de pagar</p>
            </div>
        </article>

        <?php if ($usuario->getRol() == "usuario"): ?>
            <article>
                <p><span class="weight"></span></p>
                <div>
                    <p><?php echo $valorseccion; ?></p>
                    <p>cupo (kg)</p>
                </div>
            </article>

        <?php else :?>
            <article>
                <p><span class="users"></span></p>
                <div>
                    <p><?php echo $valorseccion; ?></p>
                    <p>proveedores de uva</p>
                </div>
            </article>
       <?php endif;?>
            

        <article>
            <p><span class="weight"></span></p>
            <div>
                <p><?php echo $kgEntregados; ?></p>
                <p>kg entregados</p>
            </div>
        </article>

        <article>
            <p><span class="grapes"></span></p>
            <div>
                <p><?php echo $mediaGrados; ?></p>
                <p>media grados</p>
            </div>
        </article>
    </section>
<?php }



/**
 * Función que muestra los datos de perfil y las parcelas de un usuario
 *
 * @param Array $datosUsuario Array con los datos del usuario a mostrar
 * @param String $rol Rol del usuario
 * @param Array $listaParcelas Array con los datos de las parcelas asociadas al usuario a mostrar
 * 
 * @return String
 */
function mostrarPerfilUsuario($datosUsuario, $rol, $listaParcelas){ 
    if (count($datosUsuario) == 0) return;
    ?>

    <div>
        <?php foreach ($datosUsuario as $usuario): ?>
            <div>
                <figure>
                    <?php if ($usuario['foto'] == ""): ?>
                        <img src="../../assets/imagenes/Avatar_perfil.png" alt="Foto de perfil predeterminada">
                    <?php else: ?>
                        <img src="../../documentosUsuarios/imagenesUsuarios/<?php echo $usuario['foto']; ?>" alt="Foto del usuario <?php echo $usuario['nombre'] . ' ' . $usuario['apellidos']; ?>">
                    <?php endif; ?>
                 </figure>

                <p class="negrita"><?php echo $usuario['nombre'] . " " . $usuario['apellidos']; ?></p>
                <button id="btnEditarPerfil" class="btnClaro">Editar datos</button>

                <?php if($rol == "usuario"): ?>
                    <button id="btnContrasinal" class="btnOscuro ventanaModal">Cambiar contraseña</button>

                <?php else: ?>

                    <button id="btnEliminarUsuario" class="btnOscuro">Eliminar usuario</button>
                <?php endif; ?>
            </div>

            <div>
                <div>
                    <div id="mostrarDNI">
                        <h4>DNI</h4>
                        <p id="dniUsuario"><?php echo $usuario['dni']; ?></p>
                    </div>

                    <div>
                        <h4>Dirección</h4>

                        <div> 
                            <p>Direccion:</p>
                            <p><?php echo $usuario['direccion']; ?></p>
                        </div>

                        <div>
                            <p>Código postal:</p>
                            <p><?php echo $usuario['codigo_postal']; ?></p>
                        </div>

                        <div>
                            <p>Municipio:</p>
                            <p><?php echo $usuario['municipio']; ?></p>
                        </div>

                        <div>
                            <p>Provincia:</p>
                            <p><?php echo $usuario['provincia']; ?></p>
                        </div>
                    </div>
                </div>

                <div>
                    <div>
                        <h4>Datos de contacto</h4>
                        <div>
                            <p>Correo electrónico:</p>
                            <p><?php echo $usuario['correo']; ?></p>
                        </div>

                        <div>
                            <p>Teléfono:</p>
                            <p><?php echo $usuario['telefono']; ?></p>
                        </div>
                    </div>

                    <div>
                        <h4>Método de pago</h4>
                        <div>
                            <p>Forma de pago:</p>
                            <p><?php echo $usuario['forma_pago']; ?></p>
                        </div>

                        <?php if ($usuario['forma_pago'] == "domiciliado"): ?>
                            <div>
                                <p>Cuenta bancaria:</p>
                                <p><?php echo $usuario['cuenta_bancaria']; ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php 
        mostrarParcelas($rol, $listaParcelas);
}



/**
 * Función que muestra la sección de una tabla con las parcelas
 *
 * @param String $rol Rol del usuario
 * @param Array $listaParcelas Array con los datos de las parcelas a mostrar
 * @return void
 */
function mostrarParcelas($rol, $listaParcelas){ ?>
    <div id="listaParcelas">
        <h3>Listado de parcelas</h3>
        <div class="tabla">
            <?php mostrarTablaParcelas($rol, $listaParcelas); ?>
        </div>
        <?php if ($rol == "administrador"): ?>
            <div id="botones">
                <button id="btnNuevaParcela" name="btnNuevaParcela" class="btnOscuro ventanaModal">Nueva parcela</button>
                <button id="btnBorrarParcelas" class="btnClaro" name="btnBorrarParcelas">Borrar seleccionadas</button>
            </div>
        <?php endif; ?>
    </div>
<?php }



/**
 * Función que muestra la sección donde se muestra la tabla de albaranes
 *
 * @param String $rol Rol del usuario
 * @param Array $listaAlbaranes Array con los datos de los albaranes a mostrar
 * @param Array $datosVendimia Array con los datos de la vendimia
 * @return void
 */
function mostrarAlbaranes($rol, $listaAlbaranes, $datosVendimia){ ?>
    <div>
        <div>
            <h3>Listado de albaranes de entrega de uva <span class="ano"><?php echo date("Y"); ?></span></h3>
            <div class="flechasNavegacion">
                <p><span class="chevron-left-rounded"></span></p>
                <p><span class="chevron-right-rounded"></span></p>
            </div>
        </div>

        <div id="tablaAlbaranes" class="tabla">
            <?php mostrarTablaAlbaranes($rol, $listaAlbaranes); ?>
        </div>
    </div>

    <div id="resumenVendimia" class="tabla">
        <?php mostrarTablaResumenVendimia($datosVendimia, $rol); ?>
    </div>
<?php }



/**
 * FUnción que muestra la sección donde se muestra la fecha de inicio y fin de la vendimia
 *
 * @param Array $fechaInicioVendimia Array con la fecha de inicio de la vendimia
 * @param Array $fechaFinVendimia Array con la fecha de fin de la vendimia
 * @return void
 */
function mostrarFechasVendimia($fechaInicioVendimia, $fechaFinVendimia){ ?>
    <div id="fechasVendimia">
        <div>
            <p>Inicio campaña</p>
            <p><?php echo $fechaInicioVendimia[0]['fecha']; ?></p>
        </div>

        <div>
            <p>Fin campaña</p>
            <p><?php echo $fechaFinVendimia[0]['fecha']; ?></p>
        </div>
    </div>
<?php }



/**
 * Función que muestra la sección de las normas de la vendimia
 *
 * @return void
 */
function mostrarNormasVendimia(){ ?>
    <div>
        <h3>Normas vendimia </h3>
        <div>
            <p>La apertura para la entrega de uva serán los días del 02 al 15 de septiembre en horario de 9:00 a 23:00p</p>
            <p>Durante la recogida de uva se deben cumplir las siguientes normas:</p>
            <ul>
                <li>Todos los remolques descargarán la uva recogida en el día.</li>
                <li>Se prohíbe vendimiar por la noche y se empieza la recogida a partir de las 7 de la mañana.</li>
                <li>La uva recogida con máquina se descargará dependiente de las necesidades de la bodega y se deberá avisar con antelación, especialmente en los comienzos de la vendimia de uva blanca.</li>
                <li>Se decide establecer como el año anterior dos calidades 1ª Y 2ª.</li>
                <li>Será de 1º calidad las uvas blancas y tintas con un contenido en glucónico igual a 0 o menor de 0,5</li>
                <li>El valor mínimo de acidez total es de 2,94 que medida en ácido tartárico es 4,5, por debajo del cual la uva sería de 2ª calidad.</li>
                <li>Respecto del grado alcohólico, como en años anteriores, se ha dedidido establecer límite de 14 grados para el tinto y 12,5 para el blanco. Además un valor inferior a 10,5º en tinto y 9,3º (9 alcohol probable), en blanco depreciarán a la uva a 2ª calidad.</li>
                <li>El grado se determinará por refractometría (método oficial)</li>
                <li>En el caso de que las condiciones de calidad se vieran afectadas por podredumbre (a partir de valores de 1,5 glucónico), el consejo rector determinará, si lo estima conveniente, eliminar el grado de toda la campaña, así como establecer precios de esta uva a resultas.</li>
            </ul>
        </div>
    </div>
<?php }



/**
 * Función que muestra la sección donde se muestra la tabla de los días de vendimia
 *
 * @param Array $listaDiasVendimia Array con los días de vendimia a  mostrar
 * @return void
 */
function mostrarDiasVendimia($listaDiasVendimia){ ?>
    <div>
        <h3>Listado de días y cajas asignadas para la entrega de uva</h3>

        <div id="tablaDiasVendimia" class="tabla">
            <?php mostrarTablaDiasVendimiaAdmin($listaDiasVendimia); ?>
        </div>
    </div>
<?php }



?>
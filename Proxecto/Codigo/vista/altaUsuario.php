<?php mostrarCabecera($usuario->getRol(), "Alta usuario"); ?>

<main>
    <?php mostrarTituloPagina("Alta usuario", "Da de alta un nuevo usuario"); ?>

    <div id="contenido" class="altaUsuario">
        <form id="formularioAltaUsuario">
            <div>
                <figure>
                    <img id="imagenUsuario" src="../assets/imagenes/Avatar_perfil.png" alt="Foto de perfil predeterminada">
                </figure>

                <div class="zonaArrastreImagen">
                    <p><span class="cloud-arrow-up-outline"></span></p>
                    <input type="file" name="imagenPerfil" id="imagenPerfil">
                    <label for="imagenPerfil">Click para añadir una imagen (Opcional)</></label>
                </div>
            </div>

            <div>
                <fieldset>
                    <legend>Datos del usuario</legend>

                    <div>
                        <input type="text" name="dni" id="dni" class="dni" title="Ejemplo: 12345678A" pattern="\d{8}[A-Za-z]" required aria-required="true">
                        <label for="dni">DNI</label>
                    </div>

                    <div>
                        <input type="text" name="nombre" id="nombre" class="texto" title="Nombre del usuario" required aria-required="true">
                        <label for="nombre">Nombre</label>
                    </div>

                    <div>
                        <input type="text" name="apellidos" id="apellidos" class="texto" title="Apellidos del usuario" required aria-required="true">
                        <label for="apellidos">Apellidos</label>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Datos de la dirección</legend>

                    <div>
                        <input type="text" name="direccion" id="direccion" class="texto" title="Dirección del usuario" required aria-required="true">
                        <label for="direccion">Dirección</label>
                    </div>

                    <div>
                        <input type="text" name="cp" id="cp" class="codigoPostal" title="Ejemplo: 12345" pattern="\d{5}" required aria-required="true">
                        <label for="cp">Código postal</label>
                    </div>

                    <div>
                        <input type="text" name="municipio" id="municipio" class="texto" title="Municipio donde vive el usuario" readonly aria-readonly="true" disabled aria-disabled="true">
                        <label for="municipio">Municipio</label>
                    </div>

                    <div>
                        <input type="text" name="provincia" id="provincia" class="texto" title="Provincia a la que pertenece el municipio" readonly aria-readonly="true" disabled aria-disabled="true">
                        <label for="provincia">Provincia</label>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Datos de contacto</legend>

                    <div>
                        <input type="email" name="correo" id="correo" class="correo" pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}" title="Ejemplo: correo@gmail.com" required aria-required="true">
                        <label for="correo">Correo electrónico</label>
                    </div>

                    <div>
                        <input type="tel" name="telefono" id="telefono" class="telefono" pattern="\d{9}" title="Teléfono del usuario (9 dígitos)" required aria-required="true">
                        <label for="telefono">Teléfono</label>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Datos de la forma de pago</legend>

                    <div>
                        <label for="formaPago">Forma de pago:</label>
                        <select name="formaPago" id="formaPago" class="select">
                            <option value="predeterminado">Seleccione una forma de pago</option>
                            <option value="domiciliado">Domiciliado</option>
                            <option value="cheque">Cheque</option>
                            <option value="contado">Al contado</option>
                        </select>
                    </div>

                    <div>
                        <input type="text" name="cuentaBancaria" id="cuentaBancaria" class="cuentaBancaria" title="Introduce el IBAN" pattern="[A-Z]{2}\d{2}\s\d{4}\s\d{4}\s\d{2}\s\d{10}||[A-Z]{2}\d{22}" disabled aria-disabled="true">
                        <label for="cuentaBancaria">IBAN Cuenta bancaria</label>
                    </div>
                </fieldset>

                <div id="botonAltaUsuario">
                    <input type="submit" id="btnGuardarUsuario" class="btnOscuro" name="btnGuardarUsuario" value="Guardar usuario">
                </div>
            </div>

            <div class="notificaciones"></div>
        </form>

        <div id="engadirParcelas">
            <div id="parcelas">
                <h3>Listado de parcelas</h3>

                <div class="tabla">
                    <table>
                        <thead>
                            <tr>
                                <th></th>
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

                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <div id="botones">
                <button id="btnNuevaParcela" class="btnOscuro" name="btnNuevaParcela">Nueva parcela</button>
                <button id="btnBorrarParcelas" class="btnClaro" name="btnBorrarParcelas">Borrar seleccionadas</button>
            </div>
        </div>

        <div id="nuevoUsuario">
            <button id="btnNuevoUsuario" class="btnOscuro">Nuevo usuario</button>
        </div>
    </div>

    <?php mostrarPiePagina(); ?>
</main>

<div id="ventanasModales">
    <?php modalAltaParcela(); ?>
</div>

<?php mostrarPiePaginaHTML(); ?>
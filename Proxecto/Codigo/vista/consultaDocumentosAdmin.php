<?php mostrarCabecera($usuario->getRol(), "Consultar documentos"); ?>


<main>
    <?php mostrarTituloPagina("Consultar documentos", "Comprueba los documentos de los usuarios"); ?>

    <div id="contenido" class="consultaDocumentos">
        <form id="formularioConsultaDocumentos">
            <div>
                <input type="text" name="dni" id="dni" class="dni" title="Ejemplo: 12345678A" pattern="\d{8}[A-Za-z]" required aria-required="true">
                <label for="dni">DNI</label>
            </div>

            <div class="botones">
                <input type="submit" id="btnConsultaUsuarios" name="btnConsultaUsuarios" class="btnOscuro" value="Consultar usuario">
            </div>

            <div class="notificaciones"></div>
        </form>
        
        <div id="mostrarDocumentos">
            <div class="menuSecciones">
                <nav>
                    <ul>
                        <li class="activo">Facturas</li>
                        <li>Ingresos</li>
                    </ul>
                </nav>
            </div>

            <div class="secciones">
                <section id="facturas" class="activo">
                    <div>
                        <h3>Facturas <span class="ano"><?php echo date("Y");?></span></h3>
                        <div class="flechasNavegacion">
                            <p><span class="chevron-left-rounded "></span></p>
                            <p><span class="chevron-right-rounded "></span></p>
                        </div>
                    </div>

                    <div id="tablaFacturas" class="tabla">
                        <table>
                            <thead>
                                <tr>
                                    <th></th>
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

                            <tbody></tbody>
                        </table>
                    </div>
                </section>

                <section id="ingresos">
                    <div>
                        <h3>Ingresos <span class="ano"><?php echo date("Y");?></span></h3>
                        <div class="flechasNavegacion">
                            <p><span class="chevron-left-rounded "></span></p>
                            <p><span class="chevron-right-rounded "></span></p>
                        </div>
                    </div>

                    <div id="tablaIngresos" class="tabla">
                        <table>
                            <thead>
                                <tr>
                                    <th></th>
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

                            <tbody></tbody>
                        </table>
                    </div>

                </section>
            </div>
        </div>
    </div>

    <?php mostrarPiePagina(); ?>
</main>

<div id="ventanasModales"></div>

<?php mostrarPiePaginaHTML(); ?>
<?php mostrarCabecera($usuario->getRol(), "Vendimia"); ?>


<main>
    <?php mostrarTituloPagina("Vendimia", "Comprueba los datos de las vendimias"); ?>

    <div id="contenido" class="vendimia">
        <div class="menuSecciones">
            <nav>
                <ul>
                    <li class="activo">Normativa</li>
                    <li>Días vendimia</li>
                    <li>Albaranes</li>
                    <li>Campañas</li>
                </ul>
            </nav>
        </div>

        <div class="secciones">
            <section id="normativa" class="activo">
                <?php 
                    mostrarFechasVendimia($fechaInicioVendimia, $fechaFinVendimia);
                    mostrarNormasVendimia(); 
                ?>
            </section>

            <section id="consultaDiasVendimia">
                <div>
                    <form id="formularioConsultaDiasVendimia" class="formularioConsulta">
                        <div>
                            <input type="text" name="dniDiasVendimia" id="dniDiasVendimia" class="dni" title="Ejemplo: 12345678A" pattern="\d{8}[A-Za-z]" required aria-required="true">
                            <label for="dniDiasVendimia">DNI</label>
                        </div>

                        <div class="botones">
                            <input type="submit" id="btnConsultaDiasVendimia" name="btnConsultaDiasVendimia" class="btnOscuro" value="Consultar usuario">
                        </div>

                        <div class="notificaciones"></div>
                    </form> 
                    <button id="btnEngadirDiasVendimia" class="btnOscuro ventanaModal">Añadir días vendimia</button>
                </div>
                
                <div id="mostrarDiasVendimia"></div>
            </section>

            <section id="consultaAlbaranes">
                <div>
                    <form id="formularioConsultaAlbaranes" class="formularioConsulta">
                        <div>
                            <input type="text" name="dni" id="dni" class="dni" title="Ejemplo: 12345678A" pattern="\d{8}[A-Za-z]" required aria-required="true">
                            <label for="dni">DNI</label>
                        </div>

                        <div class="botones">
                            <input type="submit" id="btnConsulta" name="btnConsulta" class="btnOscuro" value="Consultar albaranes usuario">
                        </div>

                        <div class="notificaciones"></div>
                    </form>
                    <button id="btnEngadirAlbaran" class="btnOscuro ventanaModal">Añadir albarán</button>
                </div>

                <div id="mostrarAlbaranes"></div>
            </section>

            <section id="consultaRecolectas">
                <div>
                    <h3>Resultados campaña <span class="ano">2024</span></h3>
                    <div class="flechasNavegacion">
                        <p><span class="chevron-left-rounded"></span></p>
                        <p><span class="chevron-right-rounded"></span></p>
                    </div>
                </div>

                <div class="tabla">
                    <?php mostrarTablaResumenVendimia($datosVendimia, $usuario->getRol()); ?>
                </div>

                <div class="botones">
                    <button id="btnModalEditarPrecio" class="btnOscuro ventanaModal">Editar precio campaña</button>
                </div>
            </section>
        </div>
    </div>

    <?php mostrarPiePagina(); ?>
</main>

<div id="ventanasModales">
    <?php 
        modalAltaDiasVendimia($usuario);
        modalAltaAlbaran($usuario);
        modalEditarPrecio();
    ?>
</div>

<?php mostrarPiePaginaHTML(); ?>
<?php mostrarCabecera($usuario->getRol(), "Mis documentos"); ?>


<main>
    <?php mostrarTituloPagina("Mis documentos", "Comprueba tus facturas e ingresos"); ?>

    <div id="contenido">
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

                <div class="tabla">
                    <?php mostrarTablaFacturas($usuario->getRol(), $listaFacturas); ?>
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

                <div class="tabla">
                    <?php mostrarTablaIngresos($usuario->getRol(), $listaIngresos); ?>
                </div>

            </section>
        </div>
    </div>

    <?php mostrarPiePagina(); ?>
</main>

<div id="ventanasModales"></div>

<?php mostrarPiePaginaHTML(); ?>
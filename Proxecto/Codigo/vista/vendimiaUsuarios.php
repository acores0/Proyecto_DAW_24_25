<?php mostrarCabecera($usuario->getRol(), "Vendimia"); ?>


<main>
    <?php mostrarTituloPagina("Mi vendimia", "Comprueba los datos de la vendimia"); ?>

    <div id="contenido" class="vendimia">
        <div class="menuSecciones">
            <nav>
                <ul>
                    <li class="activo">Normativa</li>
                    <li>Albaranes</li>
                </ul>
            </nav>
        </div>

        <div class="secciones">
            <section id="normativa" class="activo">
                <?php 
                    mostrarFechasVendimia($fechaInicioVendimia, $fechaFinVendimia);

                    echo "<div id='mostrarDatosVendimia' class='tabla'>";
                        mostrarTablaDiasVendimiaUsuario($fechasVendimia, $cajasVendimia);
                    echo "</div>";

                    mostrarNormasVendimia(); 
                ?>
            </section>

            <section id="mostrarAlbaranes">
                <div>
                    <div>
                        <h3>Listado de albaranes de entrega de uva <span class="ano">2024</span></h3>
                        <div class="flechasNavegacion">
                            <p><span class="chevron-left-rounded"></span></p>
                            <p><span class="chevron-right-rounded"></span></p>
                        </div>
                    </div>

                    <div class="tabla">
                        <?php mostrarTablaAlbaranes($usuario->getRol(), $listaAlbaranes); ?>
                    </div>
                </div>

                <div id="resumenVendimia" class="tabla">
                    <?php mostrarTablaResumenVendimia($datosVendimia, $usuario->getRol()); ?>
                </div>
            </section>
        </div>
    </div>

    <?php mostrarPiePagina(); ?>
</main>

<div id="ventanasModales"></div>

<?php mostrarPiePaginaHTML(); ?>
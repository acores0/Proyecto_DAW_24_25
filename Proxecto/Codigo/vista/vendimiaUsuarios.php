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
                <div class="tabla">
                    <table>
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
                </div>

                <div>
                    <h3>Normas vendimia </h3>
                    <div>
                        <p>La apertura para la entrega de uva serán los días del 02 al 15 de septiembre en horario de
                            9:00 a
                            23:00p</p>

                        <p>Durante la recogida de uva se deben cumplir las siguientes normas:</p>
                        <ul>

                            <li>TODOS LOS REMOLQUES DESCARGARAN LA UVA RECOGIDA EN EL DIA BAJO SANCIÓN.</li>
                            <li>SE PROHIBE VENDIMIAR POR LA NOCHE, Y SE EMPEZARA LA RECOGIDA A PARTIR DE LAS 7 DE LA
                                MAÑANA.</li>
                            <li> LA UVA RECOGIDA CON MAQUINA, SE DESCARGARA DEPENDIENDO DE LAS NECESIDADES DE LA BODEGA
                                Y SE
                                DEBERA AVISAR CON ANTELACIÓN, especialmente en los comienzos de la vendimia
                                de uva blanca.</li>
                            <li> SE DECIDE ESTABLECER COMO EL AÑO ANTERIOR DOS CALIDADES 1ª Y 2ª.</li>
                            <li> SERÁ DE 1º CALIDAD LAS UVAS BLANCAS Y TINTAS CON UN CONTENIDO EN GLUCÓNICO IGUAL
                                O MENOR DE 0,5.</li>
                            <li> EL VALOR MÍNIMO DE ACIDEZ TOTAL ES DE 2,94 QUE MEDIDA EN ACIDO TARTARICO ES 4,5,
                                POR DEBAJO DEL CUAL LA UVA SERÍA DE 2ª CALIDAD.</li>
                            <li> RESPECTO DEL GRADO ALCOHÓLICO, COMO EN AÑOS ANTERIORES SE HA DECIDIDO ESTABLECER
                                LÍMITE DE 14 GRADOS PARA EL TINTO Y 12,5 PARA EL BLANCO. ADEMÁS UN VALOR INFERIOR A
                                10,5º EN TINTO y 9,3º (9 ALCOHOL PROBABLE), EN BLANCO DEPRECIARÁN A LA UVA A 2ª CALIDAD.
                            </li>
                            <li> EL GRADO BAUME SE DETERMINARÁ POR REFRACTOMETRIA (METODO OFICIAL), CADA UNA LLEVARÁ SU
                                GRADO, A EXCEPCIÓN DE LA UVA MACABEO QUE MANTENIENDO EL GRADO MÁXIMO DE BODEGA PERMITIDO
                                PARA EL RESTO DE UVA BLANCA, SE LE ASIGNARÁ EL GRADO MEDIO DE SU VARIEDAD.</li>
                            <li> EN EL CASO QUE LAS CONDICIONES DE CALIDAD SE VIERAN AFECTADAS POR PODREDUMBRE, (A
                                PARTIR
                                DE VALORES DE 1,5 DE GLUCÓNICO), EL CONSEJO RECTOR DETERMINARA SI LO ESTIMA CONVENIENTE
                                ELIMINAR EL GRADO DE TODA LA CAMPAÑA, ASÍ COMO ESTABLECER PRECIOS DE ESTA UVA A
                                RESULTAS.
                            </li>
                        </ul>

                    </div>
                </div>
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
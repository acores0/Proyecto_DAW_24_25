<?php mostrarCabecera($usuario->getRol(), "Dashboard"); ?>

<main id="contenido">
    <?php
        $titulo = "¡Hola " . $usuario->getNombre() . "!";
        mostrarTituloPagina($titulo, "Comprueba tus estadísticas"); 
    ?>

    <div id="dashboardUsuario" class="dashboard">   

        <?php mostrarResumenDashboard($usuario, $pendienteIngresos, $pendienteFacturas, $cupo, $kgEntregados, $mediaGrados); ?>

        <div id="graficos">
            <div>
                <h3>Media de grados por año</h3>
                <div id="mediaGrados" class="grafico"></div>
            </div>

            <div>
                <h3>Número de kg por año</h3>
                <div id="totalKg" class="grafico"></div>
            </div>


            <div>
                <h3>Total gastos e ingresos por año</h3>
                <div id="ingresosGastos" class="grafico"></div>
            </div>
        </div>


        <div>
            <div>
                <h3>Últimos movimientos</h3>
                <div class="tabla">
                    <?php mostrarTablaUltimosMovimientos($usuario->getRol(), $listaIngresosFacturas); ?>
                </div>
            </div>

            <div id="ingresosPagados" class="grafico"></div>
        </div>


    </div>
    <?php mostrarPiePagina(); ?>
</main>

<div id="ventanasModales"></div>

<?php mostrarPiePaginaHTML(); ?>
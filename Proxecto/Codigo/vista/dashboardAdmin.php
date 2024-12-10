<?php mostrarCabecera($usuario->getRol(), "Dashboard"); ?>

<main id="contenido">
    <?php
        $titulo = "¡Hola " . $usuario->getNombre() . "!";
        mostrarTituloPagina($titulo, "Comprueba tus estadísticas"); 
    ?>

    <div id="dashboardAdmin" class="dashboard">
        <?php mostrarResumenDashboard($usuario, $pendienteFacturas, $pendienteIngresos, $numeroProveedores, $kgEntregados, $mediaGrados); ?>

        <div>
            <div>
                <h3>Últimos movimientos</h3>

                <div id="ultimosMovimientos" class="tabla">
                    <?php mostrarTablaUltimosMovimientos($usuario->getRol(), $listaIngresosFacturas); ?>
                </div>

                <div class="botones">
                    <button id="btnEngadirDocumento" class="btnOscuro ventanaModal">Añadir factura / ingreso</button>
                    <button id="btnBorrarDocumento" class="btnClaro">Borrar seleccionados</button>
                </div>
            </div>

            <div>
                <h3>Proveedores de uva</h3>
                <div class="tabla">
                    <?php mostrarTablaUsuariosDeuda($listaUsuarios, $recolecta, $facturas); ?>
                </div>
            </div>
        </div>

        <div id="graficos">
            <div>
                <h3>Número de kg por año</h3>
                <div id="totalKg" class="grafico"></div>
            </div>

            <div>
                <h3>Media de grados por año</h3>
                <div id="mediaGrados" class="grafico"></div>
            </div>

            <div>
                <div id="ingresosPagados" class="grafico"></div>
            </div>
        </div>

    </div>

    <?php mostrarPiePagina(); ?>

</main>

 <div id="ventanasModales">
    <?php 
        modalEngadirFacturaIngreso($usuario); 
    ?>
</div>

<?php mostrarPiePaginaHTML(); ?>
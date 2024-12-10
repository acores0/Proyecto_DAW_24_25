<?php mostrarCabecera($usuario->getRol(), "Mis usuarios"); ?>


<main>
    <?php mostrarTituloPagina("Mis usuarios", "Comprueba los datos de los usuarios"); ?>

    <div id="contenido" class="consultaUsuarios">
        <form id="formularioConsultaUsuarios" class="formularioConsulta">
            <div>
                <input type="text" name="dni" id="dni" class="dni" title="Ejemplo: 12345678A" pattern="\d{8}[A-Za-z]" required aria-required="true">
                <label for="dni">DNI</label>
            </div>

            <div class="botones">
                <input type="submit" id="btnConsultaUsuarios" name="btnConsultaUsuarios" class="btnOscuro ventanaModal" value="Consultar usuario">
            </div>

            <div class="notificaciones"></div>
        </form>

        <div class="datosPerfil"></div>

        <?php mostrarPiePagina(); ?>
    </div>
</main>

<div id="ventanasModales">
    <?php modalAltaParcela(); ?>
</div>

<?php mostrarPiePaginaHTML(); ?>
<?php mostrarCabecera($usuario->getRol(), "Mi perfil"); ?>

<main>
    <?php mostrarTituloPagina("Mi perfil", "Comprueba tus datos"); ?>

    <div id="contenido" class="datosPerfil">
        <?php mostrarPerfilUsuario($datosUsuario, $usuario->getRol(), $listaParcelas); ?>
    </div> 

    <?php mostrarPiePagina(); ?>
</main>

<div id="ventanasModales">
    <?php modalCambiarContrasinal(); ?>
</div>

<?php mostrarPiePaginaHTML(); ?>
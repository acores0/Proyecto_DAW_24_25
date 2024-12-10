<?php mostrarCabeceraHTML("Inicio"); ?>

<main id="login">
    <div>
        <figure>
            <img src="../assets/imagenes/Logo_claro.png" alt="Logo BaseInfoDB3">
        </figure>
    </div>

    <section class="form-login">
        <div>
            <h2>Identifícate</h2>
            <ul>
                <li><span class="facebook-fill"></span></li>
                <li><span class="google"></span></li>
                <li><span class="apple"></span></li>
            </ul>

            <form id="formularioInicioSesion">
                <div>
                    <input type="email" name="correoLogin" id="correoLogin" class="correo" pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}" title="Ejemplo: correo@gmail.com" required aria-required="true">
                    <label for="correoLogin"><span class="mail-outline-rounded"></span> Correo electrónico</label>
                </div>

                <div>
                    <span class="eye iconoMostrarContrasinal"></span>
                    <input type="password" name="contrasinalLogin" id="contrasinalLogin" class="contrasinal" pattern="(?=.*[A-z])(?=.*[A-Z])(?=.*[0-9])\S{6,}" title="La contraseña debe tener cómo mínimo 6 caracteres, 1 mayúscula, 1 minúscula y 1 número" required aria-required="true">
                    <label for="contrasinalLogin"><span class="lock-open-outline-rounded"></span> Contraseña</label>
                </div>

                <div>
                    <a href="" id="cambiarPasswd">¿Olvidaste tu contraseña?</a>
                </div>

                <div class="boton">
                    <input type="submit" name="btnEntrar" id="btnEntrar" class="btnEntrar botonLogin" value="Entrar">
                </div>
                
                <div class="notificaciones"></div>
            </form>
        </div>
    </section>

    <section class="form-passwd">
        <div>
            <h2>Cambiar Contraseña</h2>
            <form id="formularioCambiarContrasinal">
                <div>
                    <input type="email" name="correoContrasinal" id="correoContrasinal" class="correo" pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}" title="Ejemplo: correo@gmail.com" required aria-required="true">
                    <label for="correoContrasinal"><span class="mail-outline-rounded"></span> Correo electrónico</label>
                </div>

                <div>
                    <span class="eye iconoMostrarContrasinal"></span>
                    <input type="password" name="cambiarContrasinal" id="cambiarContrasinal" class="contrasinal" pattern="(?=.*[A-z])(?=.*[A-Z])(?=.*[0-9])\S{6,}" title="La contraseña debe tener cómo mínimo 6 caracteres, 1 mayúscula, 1 minúscula y 1 número" required aria-required="true">
                    <label for="cambiarContrasinal"><span class="lock-open-outline-rounded"></span> Contraseña nueva</label>
                </div>

                <div>
                    <span class="eye iconoMostrarContrasinal"></span>
                    <input type="password" name="repContrasinal" id="repContrasinal" class="contrasinal" pattern="(?=.*[A-z])(?=.*[A-Z])(?=.*[0-9])\S{6,}" title="La contraseña debe tener cómo mínimo 6 caracteres, 1 mayúscula, 1 minúscula y 1 número" required aria-required="true">
                    <label for="repetirContrasinal"><span class="lock-open-outline-rounded"></span>Repite la contraseña</label>
                </div>

                <div class="boton">
                    <input type="submit" name="btnPasswd" id="btnPasswd" class="btnPasswd botonLogin" value="Cambiar contraseña">
                    <button id="btnSesionMovil" class="btnIniciarSesion botonLogin btnClaro">Iniciar sesión</button>
                </div>

                <div class="notificaciones"></div>
            </form>
        </div>
    </section>

    <section class="toggle">
        <div>
            <div class="toggle-login">
                <figure>
                    <img src="../assets/imagenes/Logo_claro.png" alt="Logo BaseInfoDB3">
                </figure>
                <h2>¡Bienvenido a BaseInfoDB3!</h2>
            </div>

            <div class="toggle-passwd">
                <h2>¡Bienvenido a BaseInfoDB3!</h2>
                <button class="btnIniciarSesion botonLogin">Iniciar sesión</button>
            </div>
        </div>
    </section>
</main>

<?php mostrarPiePaginaHTML(); ?>
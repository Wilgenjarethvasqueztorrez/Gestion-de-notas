<?php
session_start();

// Si ya está logueado, redirigir según rol  
if (isset($_SESSION['usuario_id'])) {
    header("location:../../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inicio de Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../src/css/styles.css">
</head>

<body class="auth-page">
    <main class="auth-shell">
        <section class="auth-identity" aria-labelledby="institution-title">
            <div class="auth-brand-mark">
                <img src="../../src/images/logo-uml.png" alt="Logo de la Universidad Martín Lutero">
            </div>
            <p class="auth-kicker">Portal institucional</p>
            <h1 id="institution-title">Universidad<br><strong>Martín Lutero</strong></h1>
            <p class="auth-intro">Gestiona tus actividades académicas y administrativas desde un solo lugar.</p>
            <div class="auth-context">
                <i class="bi bi-shield-check" aria-hidden="true"></i>
                <span>Acceso seguro para personal docente y administrativo</span>
            </div>
        </section>

        <section class="auth-panel" aria-labelledby="login-title">
            <div class="auth-panel-heading">
                <span class="auth-icon"><i class="bi bi-person-lock" aria-hidden="true"></i></span>
                <div>
                    <p class="auth-kicker">SIGEAP-UML</p>
                    <h2 id="login-title">Bienvenido de nuevo</h2>
                    <p>Ingresa tus credenciales para continuar.</p>
                </div>
            </div>

            <?php
                    // Mostrar mensaje de error si existe  
                    if (isset($_GET['error'])) {
                        echo '<div class="alert alert-danger" role="alert">';
                        if ($_GET['error'] == 'credenciales') {
                            echo 'Correo o contraseña incorrectos';
                        } elseif ($_GET['error'] == 'sesion') {
                            echo 'Debe iniciar sesión para acceder';
                        } elseif ($_GET['error'] == 'no_autorizado') {  
                            echo 'Tu cuenta de Google no está registrada en el sistema';  
                        } elseif ($_GET['error'] == 'google') {  
                            echo 'No se pudo completar el inicio de sesión con Google';  
                        }
                        echo '</div>';
                    }
            ?>

            <form class="auth-form" action="../../CRUD/Login/validarLogin.php" method="post">
                <div class="auth-field">
                    <label for="correo">Correo electrónico</label>
                    <div class="auth-input-wrap">
                        <i class="bi bi-envelope" aria-hidden="true"></i>
                        <input type="email" id="correo" name="Correo" placeholder="usuario@ejemplo.com" autocomplete="email" required autofocus>
                    </div>
                </div>

                <div class="auth-field">
                    <label for="password">Contraseña</label>
                    <div class="auth-input-wrap">
                        <i class="bi bi-lock" aria-hidden="true"></i>
                        <input type="password" id="password" name="Password" placeholder="Ingresa tu contraseña" autocomplete="current-password" required>
                        <button class="auth-visibility" type="button" aria-label="Mostrar contraseña" data-password-toggle="password"><i class="bi bi-eye" aria-hidden="true"></i></button>
                    </div>
                </div>

                <button type="submit" class="auth-submit">
                    Ingresar <i class="bi bi-arrow-right" aria-hidden="true"></i>
                </button>

                <div class="auth-divider"><span>o continúa con</span></div>

                <a href="../../CRUD/Login/googleLogin.php" class="auth-google">
                    <i class="bi bi-google" aria-hidden="true"></i> Iniciar sesión con Google
                </a>
            </form>
            <p class="auth-footer"><i class="bi bi-lock-fill" aria-hidden="true"></i> Tu información se mantiene protegida</p>
        </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('[data-password-toggle]').forEach(function (button) {
            button.addEventListener('click', function () {
                const field = document.getElementById(button.dataset.passwordToggle);
                const isPassword = field.type === 'password';
                field.type = isPassword ? 'text' : 'password';
                button.setAttribute('aria-label', isPassword ? 'Ocultar contraseña' : 'Mostrar contraseña');
                button.innerHTML = '<i class="bi bi-' + (isPassword ? 'eye-slash' : 'eye') + '" aria-hidden="true"></i>';
            });
        });
    </script>
</body>

</html>
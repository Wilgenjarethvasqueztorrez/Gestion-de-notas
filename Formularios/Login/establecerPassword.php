<?php  
session_start();  
  
// Verificar que existe una sesión temporal con el ID del usuario  
if (!isset($_SESSION['temp_usuario_id'])) {  
    // Si no hay sesión temporal, redirigir al login  
    header("location: ../../Formularios/Login/login.php");  
    exit();  
}  
  
include("../../Config/Conexion.php");  
  
// Obtener información del usuario  
$usuario_id = $_SESSION['temp_usuario_id'];  
$sql = "SELECT nombre, apellido, correo FROM usuarios WHERE id = $usuario_id";  
$resultado = $conexion->query($sql);  
$usuario = $resultado->fetch_assoc();  
?>  
<!DOCTYPE html>  
<html lang="es">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1">  
    <title>Establecer Contraseña</title>  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">  
    <link rel="stylesheet" href="../../src/css/styles.css">
</head>  
<body class="auth-page">
    <main class="auth-shell auth-shell-password">
        <section class="auth-identity" aria-labelledby="institution-title">
            <div class="auth-brand-mark">
                <img src="../../src/images/logo-uml.png" alt="Logo de la Universidad Martín Lutero">
            </div>
            <p class="auth-kicker">Primer acceso</p>
            <h1 id="institution-title">Configura tu<br><strong>cuenta institucional</strong></h1>
            <p class="auth-intro">Crea una contraseña personal para proteger tu acceso al sistema académico.</p>
            <div class="auth-context">
                <i class="bi bi-shield-lock" aria-hidden="true"></i>
                <span>Usa una contraseña que puedas recordar y no compartas con otras personas</span>
            </div>
        </section>

        <section class="auth-panel" aria-labelledby="password-title">
            <div class="auth-panel-heading">
                <span class="auth-icon"><i class="bi bi-key" aria-hidden="true"></i></span>
                <div>
                    <p class="auth-kicker">Activación de cuenta</p>
                    <h2 id="password-title">Establece tu contraseña</h2>
                    <p>Completa este paso para ingresar al portal.</p>
                </div>
            </div>
                          
                        <div class="auth-welcome" role="alert">
                            <i class="bi bi-info-circle"></i>   
                            Bienvenido/a, <strong><?php echo $usuario['nombre'] . ' ' . $usuario['apellido']; ?></strong>.   
                            Por favor, establece una contraseña para tu cuenta.  
                        </div>
                          
                        <?php  
                        // Mostrar mensaje de error si existe  
                        if (isset($_GET['error'])) {  
                            echo '<div class="alert alert-danger" role="alert">';  
                            if ($_GET['error'] == 'no_coinciden') {  
                                echo 'Las contraseñas no coinciden';  
                            } elseif ($_GET['error'] == 'muy_corta') {  
                                echo 'La contraseña debe tener al menos 6 caracteres';  
                            } elseif ($_GET['error'] == 'db') {  
                                echo 'Error al guardar la contraseña. Intenta nuevamente.';  
                            }  
                            echo '</div>';  
                        }  
                        ?>  
                          
                        <form class="auth-form" action="../../CRUD/Login/guardarPassword.php" method="post" onsubmit="return validarPassword()">
                            <input type="hidden" name="UsuarioId" value="<?php echo $usuario_id; ?>">  
                              
                            <div class="auth-field">
                                <label for="correo">Correo electrónico</label>
                                <div class="auth-input-wrap auth-input-readonly">
                                    <i class="bi bi-envelope" aria-hidden="true"></i>
                                    <input type="email" id="correo" value="<?php echo $usuario['correo']; ?>" disabled>
                                </div>
                            </div>
                              
                            <div class="auth-field">
                                <label for="password">Nueva contraseña</label>
                                <div class="auth-input-wrap">
                                    <i class="bi bi-lock" aria-hidden="true"></i>
                                    <input type="password" id="password" name="Password" placeholder="Mínimo 6 caracteres" autocomplete="new-password" required minlength="6">
                                    <button class="auth-visibility" type="button" aria-label="Mostrar contraseña" data-password-toggle="password"><i class="bi bi-eye" aria-hidden="true"></i></button>
                                </div>
                            </div>
                              
                            <div class="auth-field">
                                <label for="confirmar_password">Confirmar contraseña</label>
                                <div class="auth-input-wrap">
                                    <i class="bi bi-lock-fill" aria-hidden="true"></i>
                                    <input type="password" id="confirmar_password" name="ConfirmarPassword" placeholder="Repite la contraseña" autocomplete="new-password" required minlength="6">
                                    <button class="auth-visibility" type="button" aria-label="Mostrar contraseña" data-password-toggle="confirmar_password"><i class="bi bi-eye" aria-hidden="true"></i></button>
                                </div>
                            </div>
                              
                            <button type="submit" class="auth-submit">Guardar contraseña <i class="bi bi-check2" aria-hidden="true"></i></button>
                        </form>  
            <p class="auth-footer"><i class="bi bi-info-circle" aria-hidden="true"></i> Tu contraseña debe tener al menos 6 caracteres</p>
        </section>
    </main>
      
    <script>  
        function validarPassword() {  
            const password = document.getElementById('password').value;  
            const confirmar = document.getElementById('confirmar_password').value;  
              
            if (password !== confirmar) {  
                alert('Las contraseñas no coinciden');  
                return false;  
            }  
              
            if (password.length < 6) {  
                alert('La contraseña debe tener al menos 6 caracteres');  
                return false;  
            }  
              
            return true;  
        }  
    </script>  
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
      
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>  
</body>  
</html>
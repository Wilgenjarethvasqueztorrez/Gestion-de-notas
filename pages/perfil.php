<?php
// Proteger la página        
require("../Config/verificarSesion.php");

// Solo administradores y oficina pueden ver esta página        
verificarRol(['Administrador', 'Oficina']);

require(BASE_PATH . "Config/Conexion.php");

// Obtener información del usuario actual    
$usuario_id = $_SESSION['usuario_id'];
$sql_usuario = $conexion->query("SELECT nombre, apellido, correo, rol_sistema     
                                  FROM usuarios     
                                  WHERE id = $usuario_id");
$usuario = $sql_usuario->fetch_assoc();
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mi Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>src/css/styles.css">
</head>

<body class="perfil-profesor-page perfil-admin-page">

   <?php include(BASE_PATH . "src/includes/Componentes/sidebar.php"); ?>

    <main class="container perfil-profesor-shell">
        <?php include(BASE_PATH . "src/includes/Componentes/userbar.php"); ?>

        <header class="profesor-header">
            <div>
                <span class="profesor-eyebrow"><i class="bi bi-shield-check"></i> Cuenta institucional</span>
                <h1><i class="bi bi-person-circle"></i> Mi perfil</h1>
                <p>Administra tu información y consulta el nivel de acceso de tu cuenta.</p>
            </div>
            <div class="profesor-header-icon" aria-hidden="true"><i class="bi bi-person-gear"></i></div>
        </header>

        <div class="profesor-overview">
            <div class="profesor-profile-card">
                <div class="profesor-avatar" aria-hidden="true">
                    <?php echo htmlspecialchars(strtoupper(substr($usuario['nombre'], 0, 1) . substr($usuario['apellido'], 0, 1)), ENT_QUOTES, 'UTF-8'); ?>
                </div>
                <div>
                    <span class="profesor-label">Usuario activo</span>
                    <h2><?php echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido'], ENT_QUOTES, 'UTF-8'); ?></h2>
                    <p><i class="bi bi-envelope me-1"></i><?php echo htmlspecialchars($usuario['correo'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            </div>
            <div class="profesor-stat-card">
                <span class="profesor-stat-icon"><i class="bi bi-shield-fill-check"></i></span>
                <div><strong><?php echo htmlspecialchars($usuario['rol_sistema'], ENT_QUOTES, 'UTF-8'); ?></strong><span>Rol del sistema</span></div>
            </div>
        </div>

        <div class="section-heading">
            <div><span class="profesor-eyebrow">Cuenta</span><h2>Información y permisos</h2></div>
            <span class="section-count"><i class="bi bi-calendar-event me-1"></i><?php echo date('d/m/Y'); ?></span>
        </div>

        <div class="admin-profile-grid">
            <section class="clase-card admin-info-card">
                <div class="clase-card-header">
                    <div class="clase-title"><span class="clase-icon"><i class="bi bi-person-vcard"></i></span><h3>Información personal</h3></div>
                </div>
                <div class="admin-detail-list">
                    <div><span>Nombre completo</span><strong><?php echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido'], ENT_QUOTES, 'UTF-8'); ?></strong></div>
                    <div><span>Correo electrónico</span><strong><?php echo htmlspecialchars($usuario['correo'], ENT_QUOTES, 'UTF-8'); ?></strong></div>
                    <div><span>Rol del sistema</span><strong><?php echo htmlspecialchars($usuario['rol_sistema'], ENT_QUOTES, 'UTF-8'); ?></strong></div>
                </div>
            </section>

            <section class="clase-card admin-info-card">
                <div class="clase-card-header">
                    <div class="clase-title"><span class="clase-icon"><i class="bi bi-gear-fill"></i></span><h3>Seguridad y acceso</h3></div>
                </div>
                <ul class="admin-security-list">
                    <li><i class="bi bi-check-circle-fill"></i><span>Cuenta verificada</span></li>
                    <li><i class="bi bi-shield-check"></i><span>Acceso de nivel: <?php echo htmlspecialchars($usuario['rol_sistema'], ENT_QUOTES, 'UTF-8'); ?></span></li>
                    <li><i class="bi bi-clock-history"></i><span>Sesión iniciada: <?php echo date('d/m/Y H:i'); ?></span></li>
                </ul>
                <div class="admin-permission-note">
                    <i class="bi bi-info-circle-fill"></i>
                    <span><strong>Permisos:</strong> <?php echo $usuario['rol_sistema'] === "Administrador" ? "acceso completo a la gestión del sistema." : "acceso limitado a ciertas funciones de la gestión del sistema."; ?></span>
                </div>
            </section>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$nombreUsuario = $_SESSION['usuario_nombre'] ?? 'Usuario';
$apellidoUsuario = $_SESSION['usuario_apellido'] ?? '';
$rolUsuario = $_SESSION['usuario_rol'] ?? '';
?>

<header class="user-header-bar">
    <div class="bar-branding-section">
        <div class="bar-brand-link">
            <i class="bi bi-journal-bookmark-fill"></i>
            <span>Gestión de Notas</span>
        </div>
    </div>

    <div class="bar-actions-section">
        <div class="user-info-section">
            
            <a href="<?php echo BASE_URL; ?>pages/perfil.php" title="Ver mi Perfil">
                <span class="user-avatar"><i class="bi bi-person-circle"></i></span>
            </a>

            <span class="user-details">
                <span class="welcome-text">Bienvenido/a</span>
                <span class="user-name"><?php echo htmlspecialchars(trim($nombreUsuario . ' ' . $apellidoUsuario)); ?></span>
                <span class="role-badge-custom"><?php echo htmlspecialchars($rolUsuario); ?></span>
            </span>
        </div>

        <a href="<?php echo BASE_URL; ?>CRUD/Login/cerrarSesion.php" class="btn-logout-custom" title="Cerrar sesión">
            <i class="bi bi-box-arrow-right"></i>
            <span>Cerrar sesión</span>
        </a>
    </div>
</header>
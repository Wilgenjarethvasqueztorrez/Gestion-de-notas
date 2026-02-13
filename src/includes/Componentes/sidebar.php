<!-- Sidebar Navegación -->  
<!-- Botón para abrir el menú -->  
<button class="menu-toggle" id="menuToggle">  
    <i class="bi bi-list"></i> Menú  
</button>  
  
<!-- Overlay oscuro -->  
<div class="sidebar-overlay" id="sidebarOverlay"></div>  
  
<!-- Sidebar -->  
<nav class="sidebar" id="sidebar">  
    <div class="sidebar-header">  
        <h3><i class="bi bi-journal-bookmark"></i> Sistema de Notas</h3>  
    </div>  
  
    <ul class="sidebar-menu">  
        <li>  
            <a href="index.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">  
                <i class="bi bi-speedometer2"></i>  
                <span>Notas</span>  
            </a>  
        </li>  
  
        <li>  
            <a href="alumno.php"  
                class="<?php echo basename($_SERVER['PHP_SELF']) == 'alumno.php' ? 'active' : ''; ?>">  
                <i class="bi bi-people"></i>  
                <span>Alumnos</span>  
            </a>  
        </li>  
  
        <li>  
            <a href="parcial.php"  
                class="<?php echo basename($_SERVER['PHP_SELF']) == 'parcial.php' ? 'active' : ''; ?>">  
                <i class="bi bi-calendar-check"></i>  
                <span>Parciales</span>  
            </a>  
        </li>  
  
        <li>  
            <a href="clase.php"  
                class="<?php echo basename($_SERVER['PHP_SELF']) == 'clase.php' ? 'active' : ''; ?>">  
                <i class="bi bi-book"></i>  
                <span>Clases</span>  
            </a>  
        </li>  
  
        <li>  
            <a href="year.php"  
                class="<?php echo basename($_SERVER['PHP_SELF']) == 'year.php' ? 'active' : ''; ?>">  
                <i class="bi bi-calendar"></i>  
                <span>Años</span>  
            </a>  
        </li>  
    </ul>  
</nav>  
  
<script>  
    // Toggle sidebar      
    const menuToggle = document.getElementById('menuToggle');  
    const sidebar = document.getElementById('sidebar');  
    const overlay = document.getElementById('sidebarOverlay');  
  
    if (menuToggle && sidebar && overlay) {  
        menuToggle.addEventListener('click', function () {  
            sidebar.classList.toggle('active');  
            overlay.classList.toggle('active');  
        });  
  
        overlay.addEventListener('click', function () {  
            sidebar.classList.remove('active');  
            overlay.classList.remove('active');  
        });  
  
        // Cerrar sidebar al hacer clic en un enlace (en móviles)      
        const sidebarLinks = document.querySelectorAll('.sidebar-menu a');  
        sidebarLinks.forEach(link => {  
            link.addEventListener('click', function () {  
                if (window.innerWidth <= 768) {  
                    sidebar.classList.remove('active');  
                    overlay.classList.remove('active');  
                }  
            });  
        });  
    }  
</script>
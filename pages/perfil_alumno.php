<?php  
require("../Config/verificarSesion.php");  
verificarRol(['Estudiante', 'Oficina', 'Administrador']);  
require(BASE_PATH . "Config/Conexion.php");  
  
// alumno_id del usuario logueado (alumnos.id)  
$usuario_id = $_SESSION['usuario_id'];  
$sql_alumno = $conexion->query("SELECT alumnos.id,  
                                       usuarios.nombre,  
                                       usuarios.apellido,  
                                       usuarios.correo,  
                                       alumnos.estado  
                                FROM alumnos  
                                INNER JOIN usuarios ON alumnos.alumno_id = usuarios.id  
                                WHERE usuarios.id = $usuario_id");  
$alumno = $sql_alumno->fetch_assoc();  
$alumno_id = $alumno['id'];  
  
// Clases matriculadas y su profesor  
$sqlClases = $conexion->query("SELECT clases.id,  
                                      clases.nombre AS clase_nombre,  
                                      profe.nombre AS profe_nombre,  
                                      profe.apellido AS profe_apellido  
                               FROM matricula  
                               INNER JOIN clases ON matricula.clase_id = clases.id  
                               LEFT JOIN usuarios profe ON clases.profesor_id = profe.id  
                               WHERE matricula.alumno_id = $alumno_id  
                               ORDER BY clases.nombre ASC");  
$totalClases = $sqlClases->num_rows;
?>  
<!doctype html>  
<html lang="es">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1">  
    <title>Mi Perfil - Estudiante</title>  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">  
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">  
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>  
    <link class="styles-sheet" rel="stylesheet" href="<?php echo BASE_URL; ?>src/css/styles.css?v=2.8">  
</head>  
<body class="perfil-profesor-page perfil-estudiante-page">  
    <main class="container perfil-profesor-shell">  
        <?php include(BASE_PATH . 'src/includes/Componentes/userbar.php'); ?>
  
        <header class="profesor-header">  
            <div>
                <span class="profesor-eyebrow"><i class="bi bi-mortarboard-fill"></i> Área académica</span>
                <h1><i class="bi bi-person-workspace"></i> Panel del Estudiante</h1>
                <p>Consulta tus clases matriculadas y conoce a los profesores responsables.</p>
            </div>
            <div class="profesor-header-icon" aria-hidden="true"><i class="bi bi-backpack2-fill"></i></div>
        </header>
  
        <div class="profesor-overview">  
            <div class="profesor-profile-card">
                <div class="profesor-avatar" aria-hidden="true">
                    <?php echo htmlspecialchars(strtoupper(substr($alumno['nombre'], 0, 1) . substr($alumno['apellido'], 0, 1)), ENT_QUOTES, 'UTF-8'); ?>
                </div>  
                <div>
                    <span class="profesor-label">Estudiante</span>
                    <h2><?php echo htmlspecialchars($alumno['nombre'] . ' ' . $alumno['apellido'], ENT_QUOTES, 'UTF-8'); ?></h2>
                    <p><i class="bi bi-envelope me-1"></i><?php echo htmlspecialchars($alumno['correo'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <span class="student-status mt-2"><?php echo htmlspecialchars($alumno['estado'], ENT_QUOTES, 'UTF-8'); ?></span>
                </div>  
            </div>
            <div class="profesor-stat-card">
                <span class="profesor-stat-icon"><i class="bi bi-journal-bookmark-fill"></i></span>
                <div><strong><?php echo $totalClases; ?></strong><span>Clases matriculadas</span></div>
            </div>
        </div>
  
        <div class="section-heading">
            <div><span class="profesor-eyebrow">Mi formación</span><h2>Clases matriculadas</h2></div>
            <span class="section-count"><?php echo $totalClases; ?> registradas</span>
        </div>

        <section class="clase-card">
            <div class="table-responsive">  
                <table id="tabla-clases-alumno" class="table profesor-table align-middle">  
                    <thead>  
                        <tr>  
                            <th>Clase</th>  
                            <th>Profesor</th>  
                        </tr>  
                    </thead>  
                    <tbody>  
                        <?php if ($totalClases > 0) { while ($c = $sqlClases->fetch_assoc()) { ?>  
                            <tr>  
                                <td class="student-name"><i class="bi bi-journal-text text-info me-2"></i><?php echo htmlspecialchars($c['clase_nombre'], ENT_QUOTES, 'UTF-8'); ?></td>  
                                <td>  
                                    <?php  
                                    if ($c['profe_nombre']) {  
                                        echo '<span class="profesor-name"><i class="bi bi-person-badge me-2"></i>' . htmlspecialchars($c['profe_nombre'] . ' ' . $c['profe_apellido'], ENT_QUOTES, 'UTF-8') . '</span>';  
                                    } else {  
                                        echo "<span class='text-muted'>Sin profesor asignado</span>";  
                                    }  
                                    ?>  
                                </td>  
                            </tr>  
                        <?php }} else { ?>
                            <tr><td colspan="2" class="empty-state"><i class="bi bi-journal-x"></i><span>Aún no tienes clases matriculadas.</span></td></tr>
                        <?php } ?>
                    </tbody>  
                </table>  
            </div>  
        </div>  
  
    </main>  
    <?php include(BASE_PATH . "src/includes/Dependencias/datatables.php"); ?>  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>  
</body>  
</html>
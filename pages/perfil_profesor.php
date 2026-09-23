<?php
require("../Config/verificarSesion.php");
verificarRol(['Profesor', 'Oficina', 'Administrador']);
require(BASE_PATH . "Config/Conexion.php");

// El profesor es un usuario (clases.profesor_id -> usuarios.id)  
$usuario_id = $_SESSION['usuario_id'];
$sql_profe = $conexion->query("SELECT nombre, apellido, correo, rol_sistema  
                               FROM usuarios  
                               WHERE id = $usuario_id");
$profesor = $sql_profe->fetch_assoc();

// Clases que imparte + cantidad de estudiantes por clase  
$sqlClases = $conexion->query("SELECT clases.id,  
                                      clases.nombre AS clase_nombre,  
                                      COUNT(matricula.id) AS total_alumnos  
                               FROM clases  
                               LEFT JOIN matricula ON matricula.clase_id = clases.id  
                               WHERE clases.profesor_id = $usuario_id  
                               GROUP BY clases.id, clases.nombre  
                               ORDER BY clases.nombre ASC");
$totalClases = $sqlClases->num_rows;
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mi Perfil - Profesor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link class="styles-sheet" rel="stylesheet" href="<?php echo BASE_URL; ?>src/css/styles.css">
</head>

<body class="perfil-profesor-page">
    <main class="container perfil-profesor-shell">
        <?php include(BASE_PATH . 'src/includes/Componentes/userbar.php'); ?>

        <header class="profesor-header">
            <div>
                <span class="profesor-eyebrow"><i class="bi bi-shield-check"></i> Área académica</span>
                <h1><i class="bi bi-person-video3"></i> Panel del Profesor</h1>
                <p>Consulta tus clases y el estado de tus estudiantes desde un solo lugar.</p>
            </div>
            <div class="profesor-header-icon" aria-hidden="true"><i class="bi bi-person-workspace"></i></div>
        </header>

        <div class="profesor-overview">
            <div class="profesor-profile-card">
                <div class="profesor-avatar" aria-hidden="true">
                    <?php echo htmlspecialchars(strtoupper(substr($profesor['nombre'], 0, 1) . substr($profesor['apellido'], 0, 1)), ENT_QUOTES, 'UTF-8'); ?>
                </div>
                <div>
                    <span class="profesor-label">Profesor responsable</span>
                    <h2><?php echo htmlspecialchars($profesor['nombre'] . ' ' . $profesor['apellido'], ENT_QUOTES, 'UTF-8'); ?></h2>
                    <p><i class="bi bi-envelope me-1"></i><?php echo htmlspecialchars($profesor['correo'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            </div>
            <div class="profesor-stat-card">
                <span class="profesor-stat-icon"><i class="bi bi-journal-bookmark-fill"></i></span>
                <div><strong><?php echo $totalClases; ?></strong><span>Clases asignadas</span></div>
            </div>
        </div>

        <div class="section-heading">
            <div><span class="profesor-eyebrow">Seguimiento</span>
                <h2>Mis clases</h2>
            </div>
            <span class="section-count"><?php echo $totalClases; ?> registradas</span>
        </div>

        <?php while ($c = $sqlClases->fetch_assoc()) {
            $clase_id = $c['id'];
            // Nombres de los estudiantes de esta clase  
            $sqlAlumnos = $conexion->query("SELECT usuarios.nombre, usuarios.apellido, alumnos.estado  
                                            FROM matricula  
                                            INNER JOIN alumnos ON matricula.alumno_id = alumnos.id  
                                            INNER JOIN usuarios ON alumnos.alumno_id = usuarios.id  
                                            WHERE matricula.clase_id = $clase_id  
                                            ORDER BY usuarios.nombre ASC");
        ?>
            <section class="clase-card">
                <div class="clase-card-header">
                    <div class="clase-title"><span class="clase-icon"><i class="bi bi-journal-text"></i></span>
                        <h3><?php echo htmlspecialchars($c['clase_nombre'], ENT_QUOTES, 'UTF-8'); ?></h3>
                    </div>
                    <span class="student-count"><strong><?php echo $c['total_alumnos']; ?></strong> estudiantes</span>
                </div>
                <div class="table-responsive">
                    <table class="table profesor-table align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Estudiante</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if ($sqlAlumnos->num_rows > 0) {
                                while ($a = $sqlAlumnos->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td class="student-name"><?php echo htmlspecialchars($a['nombre'] . ' ' . $a['apellido'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><span class="student-status"><?php echo htmlspecialchars($a['estado'], ENT_QUOTES, 'UTF-8'); ?></span></td>
                                    </tr>
                            <?php }
                            } else {
                                echo "<tr><td colspan='3' class='text-center text-muted py-3'>Sin estudiantes matriculados</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
        <?php } ?>

    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
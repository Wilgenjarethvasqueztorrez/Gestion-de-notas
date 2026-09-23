<?php
date_default_timezone_set('America/Managua'); // Ajusta a tu zona horaria  
// Proteger la página  
require("Config/verificarSesion.php");

// Solo administradores pueden ver esta página  
verificarRol(['Administrador']);
//Conexion a la base de datos
require("Config/Conexion.php");

$fecha_actual = date('Y-m-d');

// CONSULTAS (según el esquema: usuarios, alumnos, clases, matricula, notas, parciales, years)  
$totalUsuarios     = $conexion->query("SELECT COUNT(*) AS total FROM usuarios")->fetch_assoc()['total'];
$totalProfesores   = $conexion->query("SELECT COUNT(*) AS total FROM usuarios WHERE rol_sistema = 'Profesor'")->fetch_assoc()['total'];
$totalEstudiantes  = $conexion->query("SELECT COUNT(*) AS total FROM usuarios WHERE rol_sistema = 'Estudiante'")->fetch_assoc()['total'];

$totalAlumnosAct   = $conexion->query("SELECT COUNT(*) AS total FROM alumnos WHERE estado = 'Activo'")->fetch_assoc()['total'];
$totalAlumnosGrad  = $conexion->query("SELECT COUNT(*) AS total FROM alumnos WHERE estado = 'Graduado'")->fetch_assoc()['total'];
$totalAlumnosSusp  = $conexion->query("SELECT COUNT(*) AS total FROM alumnos WHERE estado = 'Suspendido'")->fetch_assoc()['total'];

$totalClases       = $conexion->query("SELECT COUNT(*) AS total FROM clases")->fetch_assoc()['total'];
$totalMatriculas   = $conexion->query("SELECT COUNT(*) AS total FROM matricula")->fetch_assoc()['total'];
$totalNotas        = $conexion->query("SELECT COUNT(*) AS total FROM notas")->fetch_assoc()['total'];
$totalParciales    = $conexion->query("SELECT COUNT(*) AS total FROM parciales")->fetch_assoc()['total'];
$totalYears        = $conexion->query("SELECT COUNT(*) AS total FROM years")->fetch_assoc()['total'];
$promedioGeneral   = $conexion->query("SELECT AVG(valor) AS prom FROM notas")->fetch_assoc()['prom'] ?? 0;

// NUEVAS MÉTRICAS  
$notaMaxima     = $conexion->query("SELECT MAX(valor) AS v FROM notas")->fetch_assoc()['v'] ?? 0;
$notaMinima     = $conexion->query("SELECT MIN(valor) AS v FROM notas")->fetch_assoc()['v'] ?? 0;
$totalAprobados = $conexion->query("SELECT COUNT(*) AS total FROM notas WHERE valor >= 60")->fetch_assoc()['total'];
$totalReprobados = $conexion->query("SELECT COUNT(*) AS total FROM notas WHERE valor < 60")->fetch_assoc()['total'];
$tasaAprobacion = $totalNotas > 0 ? ($totalAprobados / $totalNotas) * 100 : 0;
$totalOficina   = $conexion->query("SELECT COUNT(*) AS total FROM usuarios WHERE rol_sistema = 'Oficina'")->fetch_assoc()['total'];
$totalAdmins    = $conexion->query("SELECT COUNT(*) AS total FROM usuarios WHERE rol_sistema = 'Administrador'")->fetch_assoc()['total'];
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="src/css/styles.css">
</head>

<body>
    <?php include('src/includes/Componentes/sidebar.php'); ?>

    <main class="container py-4">
        <?php include('src/includes/Componentes/userbar.php'); ?>
        <div class="p-4 rounded-4 text-white mb-4" style="background: linear-gradient(135deg, #1d439c, #3b6ec5);">
            <div
                class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
                <div>
                    <h1 class="mb-2">Dashboard del Sistema de Notas</h1>
                    <p class="mb-0 text-light">Resumen de usuarios, alumnos, clases, matrículas y notas.</p>
                </div>
                <div class="text-end">
                    <span class="badge rounded-pill bg-light text-dark">Hoy: <?php echo date('d/m/Y'); ?></span>
                </div>
            </div>
        </div>

        <!-- RESUMEN GENERAL -->
        <h3 class="mt-5"><i class="bi bi-bar-chart-fill"></i> Resumen General</h3>
        <div class="row mt-4 g-3">
            <div class="col-md-4 col-lg-3">
                <div class="card bg-primary text-white text-center">
                    <div class="card-body">
                        <h5><i class="bi bi-people-fill"></i> Usuarios</h5>
                        <p class="display-4 fw-bold mb-0"><?php echo $totalUsuarios; ?></p>
                        <small>Total en el sistema</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="card bg-success text-white text-center">
                    <div class="card-body">
                        <h5><i class="bi bi-mortarboard-fill"></i> Estudiantes</h5>
                        <p class="display-4 fw-bold mb-0"><?php echo $totalEstudiantes; ?></p>
                        <small><?php echo $totalProfesores; ?> profesores</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="card bg-info text-white text-center">
                    <div class="card-body">
                        <h5><i class="bi bi-person-check-fill"></i> Alumnos Activos</h5>
                        <p class="display-4 fw-bold mb-0"><?php echo $totalAlumnosAct; ?></p>
                        <small><?php echo $totalAlumnosSusp; ?> suspendidos</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="card bg-secondary text-white text-center">
                    <div class="card-body">
                        <h5><i class="bi bi-award-fill"></i> Graduados</h5>
                        <p class="display-4 fw-bold mb-0"><?php echo $totalAlumnosGrad; ?></p>
                        <small>Alumnos graduados</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="card bg-danger text-dark text-center">
                    <div class="card-body">
                        <h5><i class="bi bi-book-fill"></i> Clases</h5>
                        <p class="display-4 fw-bold mb-0"><?php echo $totalClases; ?></p>
                        <small>Registradas</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="card bg-primary text-white text-center">
                    <div class="card-body">
                        <h5><i class="bi bi-card-checklist"></i> Matrículas</h5>
                        <p class="display-4 fw-bold mb-0"><?php echo $totalMatriculas; ?></p>
                        <small>Alumno-clase</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="card bg-dark text-white text-center">
                    <div class="card-body">
                        <h5><i class="bi bi-pencil-square"></i> Notas</h5>
                        <p class="display-4 fw-bold mb-0"><?php echo $totalNotas; ?></p>
                        <small>Registradas</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="card bg-success text-white text-center">
                    <div class="card-body">
                        <h5><i class="bi bi-calculator"></i> Promedio General</h5>
                        <p class="display-4 fw-bold mb-0"><?php echo number_format($promedioGeneral, 1); ?></p>
                        <small>De todas las notas</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="card bg-info text-white text-center">
                    <div class="card-body">
                        <h5><i class="bi bi-calendar-check"></i> Parciales</h5>
                        <p class="display-4 fw-bold mb-0"><?php echo $totalParciales; ?></p>
                        <small><?php echo $totalYears; ?> años</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="card bg-success text-white text-center">
                    <div class="card-body">
                        <h5><i class="bi bi-arrow-up-circle-fill"></i> Nota Más Alta</h5>
                        <p class="display-4 fw-bold mb-0"><?php echo $notaMaxima; ?></p>
                        <small>Máximo registrado</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="card bg-danger text-white text-center">
                    <div class="card-body">
                        <h5><i class="bi bi-arrow-down-circle-fill"></i> Nota Más Baja</h5>
                        <p class="display-4 fw-bold mb-0"><?php echo $notaMinima; ?></p>
                        <small>Mínimo registrado</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="card bg-info text-white text-center">
                    <div class="card-body">
                        <h5><i class="bi bi-check-circle-fill"></i> Aprobados</h5>
                        <p class="display-4 fw-bold mb-0"><?php echo $totalAprobados; ?></p>
                        <small><?php echo $totalReprobados; ?> reprobados</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="card bg-success text-dark text-center">
                    <div class="card-body">
                        <h5><i class="bi bi-percent"></i> Tasa Aprobación</h5>
                        <p class="display-4 fw-bold mb-0"><?php echo number_format($tasaAprobacion, 1); ?>%</p>
                        <small>Del total de notas</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="card bg-secondary text-white text-center">
                    <div class="card-body">
                        <h5><i class="bi bi-person-badge"></i> Oficina / Admin</h5>
                        <p class="display-4 fw-bold mb-0"><?php echo $totalOficina; ?> / <?php echo $totalAdmins; ?></p>
                        <small>Personal del sistema</small>
                    </div>
                </div>
            </div>
        </div>


        <!-- ÚLTIMAS NOTAS -->
        <h3 class="mt-5"><i class="bi bi-clock-history"></i> Últimas Notas Registradas</h3>
        <div class="dashboard-table-container mb-4">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Alumno</th>
                        <th>Clase</th>
                        <th>Parcial</th>
                        <th>Año</th>
                        <th>Nota</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sqlUltimas = $conexion->query("  
            SELECT u.nombre, u.apellido, c.nombre AS clase, p.numero AS parcial, y.nombre AS anio, n.valor  
            FROM notas n  
            INNER JOIN matricula m ON n.matricula_id = m.id  
            INNER JOIN alumnos a   ON m.alumno_id = a.id  
            INNER JOIN usuarios u  ON a.alumno_id = u.id  
            INNER JOIN clases c    ON m.clase_id = c.id  
            INNER JOIN parciales p ON n.parcial_id = p.id  
            INNER JOIN years y     ON p.year_id = y.id  
            ORDER BY n.id DESC  
            LIMIT 10  
          ");
                    if ($sqlUltimas && $sqlUltimas->num_rows > 0) {
                        while ($n = $sqlUltimas->fetch_assoc()) {
                            $color = $n['valor'] >= 60 ? 'bg-success' : 'bg-danger';
                            echo "<tr>  
                      <td><strong>{$n['nombre']} {$n['apellido']}</strong></td>  
                      <td>{$n['clase']}</td>  
                      <td>Parcial {$n['parcial']}</td>  
                      <td>{$n['anio']}</td>  
                      <td><span class='badge {$color}'>{$n['valor']}</span></td>  
                    </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center text-muted'>No hay notas registradas</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- CLASES Y PROFESORES -->
        <h3 class="mt-5"><i class="bi bi-person-workspace"></i> Clases y sus Profesores</h3>
        <div class="dashboard-table-container mb-5">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Clase</th>
                        <th>Profesor</th>
                        <th>Alumnos Matriculados</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sqlClases = $conexion->query("  
            SELECT c.id, c.nombre AS clase, u.nombre, u.apellido,  
                   (SELECT COUNT(*) FROM matricula m WHERE m.clase_id = c.id) AS matriculados  
            FROM clases c  
            LEFT JOIN usuarios u ON c.profesor_id = u.id  
            ORDER BY c.nombre ASC  
          ");
                    if ($sqlClases && $sqlClases->num_rows > 0) {
                        while ($c = $sqlClases->fetch_assoc()) {
                            $prof = $c['nombre'] ? "{$c['nombre']} {$c['apellido']}" : "<span class='text-muted'>Sin asignar</span>";
                            echo "<tr>  
                      <td><strong>{$c['clase']}</strong></td>  
                      <td>{$prof}</td>  
                      <td><span class='badge bg-primary'>{$c['matriculados']}</span></td>  
                    </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3' class='text-center text-muted'>No hay clases registradas</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Alumnos con promedios mas altos -->
        <h3 class="mt-5"><i class="bi bi-trophy-fill"></i> Top Alumnos por Promedio</h3>
        <div class="dashboard-table-container mb-4">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Lugar</th>
                        <th>Alumno</th>
                        <th>Notas</th>
                        <th>Promedio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sqlTop = $conexion->query("  
                        SELECT u.nombre, u.apellido, COUNT(n.id) AS cantidad, AVG(n.valor) AS promedio  
                        FROM notas n  
                        INNER JOIN matricula m ON n.matricula_id = m.id  
                        INNER JOIN alumnos a   ON m.alumno_id = a.id  
                        INNER JOIN usuarios u  ON a.alumno_id = u.id  
                        GROUP BY a.id, u.nombre, u.apellido  
                        ORDER BY promedio DESC  
                        LIMIT 5  
                      ");
                    $pos = 1;
                    if ($sqlTop && $sqlTop->num_rows > 0) {
                        while ($t = $sqlTop->fetch_assoc()) {
                            $color = $t['promedio'] >= 60 ? 'bg-success' : 'bg-danger';
                            echo "<tr>  
                  <td><strong>{$pos}</strong></td>  
                  <td><strong>{$t['nombre']} {$t['apellido']}</strong></td>  
                  <td><span class='badge bg-primary'>{$t['cantidad']}</span></td>  
                  <td><span class='badge {$color}'>" . number_format($t['promedio'], 1) . "</span></td>  
                </tr>";
                            $pos++;
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center text-muted'>No hay datos suficientes</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Promedio por clase -->
        <h3 class="mt-5"><i class="bi bi-bar-chart-line-fill"></i> Promedio por Clase</h3>
        <div class="dashboard-table-container mb-4">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Clase</th>
                        <th>Notas Registradas</th>
                        <th>Promedio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sqlPromClase = $conexion->query("  
                       SELECT c.nombre AS clase, COUNT(n.id) AS cantidad, AVG(n.valor) AS promedio  
                       FROM clases c  
                       LEFT JOIN matricula m ON m.clase_id = c.id  
                       LEFT JOIN notas n     ON n.matricula_id = m.id  
                       GROUP BY c.id, c.nombre  
                       ORDER BY promedio DESC  
                     ");
                    if ($sqlPromClase && $sqlPromClase->num_rows > 0) {
                        while ($pc = $sqlPromClase->fetch_assoc()) {
                            $prom = $pc['promedio'] !== null ? number_format($pc['promedio'], 1) : '-';
                            $color = ($pc['promedio'] !== null && $pc['promedio'] >= 60) ? 'bg-success' : 'bg-danger';
                            echo "<tr>  
                  <td><strong>{$pc['clase']}</strong></td>  
                  <td>{$pc['cantidad']}</td>  
                  <td><span class='badge {$color}'>{$prom}</span></td>  
                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3' class='text-center text-muted'>No hay clases registradas</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Alumnos reprobados -->
        <!-- <h3 class="mt-5"><i class="bi bi-exclamation-triangle-fill"></i> Notas Reprobadas</h3>
        <div class="dashboard-table-container mb-4">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Alumno</th>
                        <th>Clase</th>
                        <th>Parcial</th>
                        <th>Nota</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sqlRep = $conexion->query("  
        SELECT u.nombre, u.apellido, c.nombre AS clase, p.numero AS parcial, n.valor  
        FROM notas n  
        INNER JOIN matricula m ON n.matricula_id = m.id  
        INNER JOIN alumnos a   ON m.alumno_id = a.id  
        INNER JOIN usuarios u  ON a.alumno_id = u.id  
        INNER JOIN clases c    ON m.clase_id = c.id  
        INNER JOIN parciales p ON n.parcial_id = p.id  
        WHERE n.valor < 60  
        ORDER BY n.valor ASC  
        LIMIT 10  
      ");
                    if ($sqlRep && $sqlRep->num_rows > 0) {
                        while ($r = $sqlRep->fetch_assoc()) {
                            echo "<tr>  
                  <td><strong>{$r['nombre']} {$r['apellido']}</strong></td>  
                  <td>{$r['clase']}</td>  
                  <td>Parcial {$r['parcial']}</td>  
                  <td><span class='badge bg-danger'>{$r['valor']}</span></td>  
                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center text-muted'>No hay notas reprobadas</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div> -->
        
        <!-- Usuarios por rol -->
        <!-- <h3 class="mt-5"><i class="bi bi-people"></i> Usuarios por Rol</h3>
        <div class="dashboard-table-container mb-5">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Rol</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sqlRoles = $conexion->query("  
        SELECT rol_sistema, COUNT(*) AS total  
        FROM usuarios  
        GROUP BY rol_sistema  
        ORDER BY total DESC  
      ");
                    if ($sqlRoles && $sqlRoles->num_rows > 0) {
                        while ($rr = $sqlRoles->fetch_assoc()) {
                            echo "<tr>  
                  <td><strong>{$rr['rol_sistema']}</strong></td>  
                  <td><span class='badge bg-primary'>{$rr['total']}</span></td>  
                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2' class='text-center text-muted'>No hay usuarios</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div> -->
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
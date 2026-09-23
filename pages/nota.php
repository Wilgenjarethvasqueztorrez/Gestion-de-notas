<?php require('../Config/verificarSesion.php'); ?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro de Notas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!--Dependencias-->
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- CSS de DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <!-- jQuery (requerido por DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables Responsive -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>src/css/styles.css">
</head>

<body>

    <?php include(BASE_PATH . 'src/includes/Componentes/sidebar.php'); ?>

    <main class="container mt-4">
        <?php include(BASE_PATH . 'src/includes/Componentes/userbar.php'); ?>
        <h1 class="bg-info p-3 text-white text-center rounded">📚 LISTADO DE NOTAS</h1>

        <div class="text-end mb-3">
            <a href="<?php echo BASE_URL; ?>Formularios/Notas/AgregarNota.php" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Agregar Nota
            </a>
        </div>

        <div class="table-container">
            <table id="tabla" class="table table-hover">
                <thead>
                    <tr>
                        <th>Nombre del Alumno</th>
                        <th>Parcial</th>
                        <th>Año</th>
                        <th>Clase</th>
                        <th>Nota</th>
                        <th>Criterios</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require(BASE_PATH . "Config/Conexion.php");

                    $sql = $conexion->query("SELECT 
                    notas.id AS nota_id,
                    notas.valor,
                    usuarios.nombre,
                    usuarios.apellido,
                    parciales.numero,
                    years.nombre AS year_nombre,
                    clases.nombre AS clase_nombre,
                    notas.matricula_id
                FROM notas
                INNER JOIN matricula ON notas.matricula_id = matricula.id
                INNER JOIN alumnos ON matricula.alumno_id = alumnos.id
                INNER JOIN usuarios ON alumnos.alumno_id = usuarios.id
                INNER JOIN clases ON matricula.clase_id = clases.id
                INNER JOIN parciales ON notas.parcial_id = parciales.id
                INNER JOIN years ON parciales.year_id = years.id
                ORDER BY usuarios.nombre ASC
            ");

                    while ($resultado = $sql->fetch_assoc()) {
                        $nota = $resultado['valor'];

                        // Definir criterios según rangos
                        if ($nota >= 90) {
                            $criterio = "AA";
                        } elseif ($nota >= 80) {
                            $criterio = "AB";
                        } elseif ($nota >= 70) {
                            $criterio = "AC";
                        } elseif ($nota >= 60) {
                            $criterio = "AS";
                        } else {
                            $criterio = "AD";
                        }

                        // Definir estado
                        $estado = ($nota >= 60) ? "Aprobado" : "Aplazado";
                    ?>
                        <tr>
                            <td>
                                <div class="nombre-apellido">
                                    <span><strong><?php echo htmlspecialchars($resultado['nombre']); ?></strong></span>
                                    <span><?php echo htmlspecialchars($resultado['apellido']); ?></span>
                                </div>
                            </td>
                            <td><?php echo $resultado['numero']; ?></td>
                            <td><?php echo htmlspecialchars($resultado['year_nombre']); ?></td>
                            <td><?php echo htmlspecialchars($resultado['clase_nombre']); ?></td>
                            <td>
                                <span class="badge bg-info text-dark"><?php echo $nota; ?></span>
                            </td>
                            <td>
                                <?php
                                $badge_class = '';
                                switch ($criterio) {
                                    case 'AA': // Nota >= 90
                                        $badge_class = 'bg-success'; // Azul
                                        break;
                                    case 'AB': // Nota 80-89
                                        $badge_class = 'bg-primary'; // Verde
                                        break;
                                    case 'AC': // Nota 70-79
                                        $badge_class = 'bg-warning text-dark'; // Amarillo
                                        break;
                                    case 'AS': // Nota 60-69
                                        $badge_class = 'bg-info text-dark'; // Celeste
                                        break;
                                    case 'AD': // Nota < 60
                                        $badge_class = 'bg-danger'; // Rojo
                                        break;
                                }
                                echo "<span class='badge $badge_class'>$criterio</span>";
                                ?>
                            </td>

                            <td>
                                <span class="badge <?php echo ($estado == 'Aprobado') ? 'bg-success' : 'bg-danger'; ?>">
                                    <?php echo $estado; ?>
                                </span>
                            </td>
                            <td class="acciones">
                                <a href="<?php echo BASE_URL; ?>Formularios/Notas/EditarNota.php?Id=<?php echo $resultado['nota_id']; ?>"
                                    class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>
                                <a href="<?php echo BASE_URL; ?>CRUD/Notas/eliminarNota.php?Id=<?php echo $resultado['nota_id']; ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="event.preventDefault(); confirmarEliminacion(this.href)">
                                    <i class="bi bi-trash3"></i> Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </main>

    <!-- Inicializar DataTables -->
    <?php include(BASE_PATH . 'src/includes/Dependencias/datatables.php'); ?>

    <!-- Inicializar SweetAlert2 -->
    <?php include(BASE_PATH . 'src/includes/Dependencias/sweetalert.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>
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

    <link rel="stylesheet" href="src/css/styles.css">
</head>

<body>

    <?php include('src/includes/Componentes/sidebar.php'); ?>

    <main class="container mt-4">
        <h1 class="bg-info p-3 text-white text-center rounded">📚 LISTADO DE NOTAS</h1>

        <div class="text-end mb-3">
            <a href="Formularios/Notas/AgregarNota.php" class="btn btn-success">
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
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require("Config/Conexion.php");

                    $sql = $conexion->query("SELECT 
                            notas.id AS nota_id,
                            notas.valor,
                            alumnos.nombres,
                            alumnos.apellidos,
                            parciales.numero,
                            parciales.year_id,
                            clases.nombre
                        FROM notas
                        INNER JOIN alumnos ON notas.alumno_id = alumnos.id
                        INNER JOIN parciales ON notas.parcial_id = parciales.id
                        INNER JOIN clases ON notas.clase_id = clases.id
                        ORDER BY alumnos.nombres ASC
                    ");


                    while ($resultado = $sql->fetch_assoc()) {
                    ?>
                        <tr>
                            <td>
                                <div class="nombre-apellido">
                                    <span><strong><?php echo $resultado['nombres']; ?></strong></span>
                                    <span><?php echo $resultado['apellidos']; ?></span>
                                </div>
                            </td>
                            <td><?php echo $resultado['numero']; ?></td>
                            <td><?php echo $resultado['year_id']; ?></td>
                            <td><?php echo $resultado['nombre']; ?></td>
                            <td>
                                <span class="badge bg-info text-dark"><?php echo $resultado['valor']; ?></span>
                            </td>
                            <td class="acciones">
                                <a href="Formularios/Notas/EditarNota.php?Id=<?php echo $resultado['nota_id']; ?>"
                                    class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>
                                <a href="CRUD/Notas/eliminarNota.php?Id=<?php echo $resultado['nota_id']; ?>"
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
    <?php include('src/includes/Dependencias/datatables.php'); ?>

    <!-- Inicializar SweetAlert2 -->
    <?php include('src/includes/Dependencias/sweetalert.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>
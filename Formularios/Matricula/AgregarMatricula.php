<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agregar matrícula</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../src/css/styles.css" />
</head>

<body>
    <div class="container" style="max-width: 650px;">
        <div class="form-card-container">
            <h1 class="form-title-custom text-center mb-4">📖 Agregar Matrícula</h1>
            <form action="../../CRUD/Matricula/insertarMatricula.php" method="post">
                <?php include('../../Config/Conexion.php'); ?>
                <div class="mb-3">
                    <label class="form-label-custom">Alumno</label>
                    <select id="select2" class="form-select form-control-custom" name="alumno_id" required>
                        <option value="" selected disabled>-- Seleccionar alumno --</option>
                        <?php
                        $alumnos = $conexion->query("SELECT alumnos.id, usuarios.nombre, usuarios.apellido FROM alumnos INNER JOIN usuarios ON usuarios.id = alumnos.alumno_id WHERE alumnos.estado = 'Activo' ORDER BY usuarios.nombre");
                        while ($alumno = $alumnos->fetch_assoc()):
                        ?>
                            <option value="<?php echo $alumno['id']; ?>"><?php echo htmlspecialchars($alumno['nombre'] . ' ' . $alumno['apellido']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label-custom">Clase</label>
                    <select id="select2-clase" class="form-select form-control-custom" name="clase_id" required>
                        <option value="" selected disabled>-- Seleccionar clase --</option>
                        <?php
                        $clases = $conexion->query("SELECT id, nombre FROM clases ORDER BY nombre");
                        while ($clase = $clases->fetch_assoc()):
                        ?>
                            <option value="<?php echo $clase['id']; ?>"><?php echo htmlspecialchars($clase['nombre']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="d-flex justify-content-center gap-3">
                    <button type="submit" class="btn-submit-custom">
                        <i class="bi bi-check-circle-fill me-1"></i> Registrar
                    </button>
                    <a href="../../pages/matricula.php"
                        class="btn-cancel-custom text-decoration-none d-flex align-items-center justify-content-center">
                        <i class="bi bi-x-circle-fill me-1"></i>
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

   <?php include('../../src/includes/Dependencias/Select2.php'); ?>

</body>

</html>
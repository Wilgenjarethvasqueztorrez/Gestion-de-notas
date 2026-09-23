<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agregar clase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../src/css/styles.css?v=3.1" />
</head>

<body>
    <div class="container" style="max-width: 650px;">
        <div class="form-card-container">
            <h1 class="form-title-custom text-center mb-4">📘 Agregar Clase</h1>
            <form action="../../CRUD/Clases/insertarClase.php" method="post">

                <div class="mb-3">
                    <label class="form-label-custom">Nombre de la clase</label>
                    <input type="text" class="form-control form-control-custom" name="NombreClase" maxlength="100" required>
                </div>

                <div class="mb-3">
                    <label class="form-label-custom">Profesor</label>
                    <select id="select2" class="form-select form-control-custom" name="ProfesorId">
                        <option value="">-- Sin profesor asignado --</option>
                        <?php
                        include("../../Config/Conexion.php");
                        $profesores = $conexion->query("SELECT id, nombre, apellido FROM usuarios WHERE rol_sistema = 'Profesor' ORDER BY nombre, apellido");
                        while ($profesor = $profesores->fetch_assoc()):
                        ?>
                            <option value="<?php echo (int) $profesor['id']; ?>">
                                <?php echo htmlspecialchars($profesor['nombre'] . ' ' . $profesor['apellido'], ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="d-flex justify-content-center gap-3">
                    <button type="submit" class="btn-submit-custom">
                        <i class="bi bi-check-circle-fill me-1"></i> Registrar
                    </button>
                    <a href="../../pages/clase.php" class="btn-cancel-custom text-decoration-none d-flex align-items-center justify-content-center">
                        <i class="bi bi-x-circle-fill me-1"></i>
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <?php include('../../src/includes/Dependencias/Select2.php'); ?>
</body>

</html>
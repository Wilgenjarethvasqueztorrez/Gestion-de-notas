<!doctype html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar Clase</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../../src/css/styles.css?v=3.1" />
</head>

<body>
  <div class="container" style="max-width: 650px;">
    <div class="form-card-container">
      <h1 class="form-title-custom text-center mb-4">✏️ Editar Clase</h1>
      <form action="../../CRUD/Clases/editarClase.php" method="post">
        <?php
        include('../../Config/Conexion.php');

        $id = filter_input(INPUT_GET, 'Id', FILTER_VALIDATE_INT);
        if (!$id) {
          die('ID no válido');
        }
        $stmt = $conexion->prepare("SELECT id, nombre, profesor_id FROM clases WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        if (!$resultado->num_rows) {
          die('Clase no encontrada');
        }
        $row = $resultado->fetch_assoc();
        ?>
        <input type="hidden" class="form-control" name="Id" value="<?php echo (int) $row['id']; ?>">

        <!--Traer datos de clase-->
        <div class="mb-3">
          <label class="form-label-custom">Clase</label>
          <input type="text" class="form-control form-control-custom" name="clase" maxlength="100"
            value="<?php echo htmlspecialchars($row['nombre'], ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label-custom">Profesor</label>
          <select id="select2" class="form-select form-control-custom" name="ProfesorId">
            <option value="">-- Sin profesor asignado --</option>
            <?php
            $profesores = $conexion->query("SELECT id, nombre, apellido FROM usuarios WHERE rol_sistema = 'Profesor' ORDER BY nombre, apellido");
            while ($profesor = $profesores->fetch_assoc()):
            ?>
              <option value="<?php echo (int) $profesor['id']; ?>"
                <?php echo ((int) $row['profesor_id'] === (int) $profesor['id']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($profesor['nombre'] . ' ' . $profesor['apellido'], ENT_QUOTES, 'UTF-8'); ?>
              </option>
            <?php endwhile; ?>
          </select>
        </div>


        <div class="d-flex justify-content-center gap-3">
          <button type="submit" class="btn-submit-custom">
            <i class="bi bi-arrow-clockwise me-1"></i> Actualizar
          </button>
          <a href="../../pages/clase.php"
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
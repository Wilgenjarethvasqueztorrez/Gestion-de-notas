  <?php
  include('../../Config/Conexion.php');

  if (!isset($_GET['Id']) || !is_numeric($_GET['Id'])) {
    die("ID no válido");
  }

  $id = intval($_GET['Id']);

  $sql = "SELECT * FROM notas WHERE id = $id";
  $resultado = $conexion->query($sql);

  if ($resultado->num_rows == 0) {
    die("Registro no encontrado");
  }

  $row = $resultado->fetch_assoc();
  ?>

  <!doctype html>
  <html lang="es">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Nota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../src/css/styles.css" />
  </head>

  <body>

    <div class="container" style="max-width: 650px;">
      <div class="form-card-container">
        <h1 class="form-title-custom text-center mb-4">✏️ Editar Nota</h1>
        <form action="../../CRUD/Notas/editarNota.php" method="post">

          <!-- ID oculto -->
          <input type="hidden" name="Id" value="<?php echo $row['id']; ?>">

          <!-- PARCIAL -->
          <div class="mb-3">
            <label class="form-label-custom">Parcial</label>
            <select id="select2" class="form-select form-control-custom" name="parcial" required>
              <option disabled>--Seleccionar parcial--</option>
              <?php
              $parciales = $conexion->query("  
    SELECT parciales.id, parciales.numero, years.nombre AS anio  
    FROM parciales  
    INNER JOIN years ON parciales.year_id = years.id  
    ORDER BY parciales.numero ASC  
");
              while ($parcial = $parciales->fetch_assoc()) {
                echo "<option value='{$parcial['id']}'>  
            Parcial {$parcial['numero']} - Año {$parcial['anio']}  
          </option>";
              }
              ?>
            </select>
          </div>

          <!-- MATRICULA -->
          <div class="mb-3">
            <label class="form-label-custom">Matrícula</label>
            <select id="select2-clase" class="form-select form-control-custom" name="matricula" required>
              <option disabled>--Seleccionar alumno y clase--</option>
              <?php
              $matriculas = $conexion->query("SELECT matricula.id, usuarios.nombre, usuarios.apellido, clases.nombre AS clase
                                          FROM matricula
                                          INNER JOIN alumnos ON matricula.alumno_id = alumnos.id
                                          INNER JOIN usuarios ON alumnos.alumno_id = usuarios.id
                                          INNER JOIN clases ON matricula.clase_id = clases.id
                                          ORDER BY usuarios.nombre, clases.nombre");
              while ($matricula = $matriculas->fetch_assoc()) {
                $selected = ($matricula['id'] == $row['matricula_id']) ? "selected" : "";
                echo "<option value='{$matricula['id']}' $selected>
                  " . htmlspecialchars($matricula['nombre'] . ' ' . $matricula['apellido'] . ' - ' . $matricula['clase']) . "
                </option>";
              }
              ?>
            </select>
          </div>

          <!-- NOTA -->
          <div class="mb-3">
            <label class="form-label-custom">Nota</label>
            <input type="number"
              class="form-control form-control-custom"
              name="valor"
              min="0"
              max="100"
              value="<?php echo $row['valor']; ?>"
              required>
          </div>

          <div class="d-flex justify-content-center gap-3">
            <button type="submit" class="btn-submit-custom">
              <i class="bi bi-arrow-clockwise me-1"></i> Actualizar
            </button>
            <a href="../../pages/nota.php"
              class="btn-cancel-custom text-decoration-none d-flex align-items-center justify-content-center">
              <i class="bi bi-x-circle-fill me-1"></i>
              Cancelar
            </a>
          </div>

        </form>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php include('../../src/includes/Dependencias/Select2.php'); ?>

  </body>

  </html>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Agregar parcial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../src/css/styles.css" />
</head>

<body>
  <div class="container" style="max-width: 650px;">
    <div class="form-card-container">
      <h1 class="form-title-custom text-center mb-4">📙 Agregar Parcial</h1>
      <form action="../../CRUD/Parciales/insertarParcial.php" method="post">
        <div class="mb-3">
          <label class="form-label-custom">Parcial</label>
          <input type="number" class="form-control form-control-custom" name="NumeroParcial" min="1" required>
        </div>
        <label class="form-label-custom" for="NumeroAño">Año</label>
        <select class="form-select form-control-custom mb-3" id="NumeroAño" name="NumeroAño" required>
          <option selected disabled>--Seleccionar año--</option>
          <?php
          include("../../Config/Conexion.php");
          $sql = $conexion->query("SELECT * FROM years");
          while ($resultado = $sql->fetch_assoc()) {
            echo "<option value='" . $resultado['id'] . "'>" . $resultado['nombre'] . "</option>";
          }
          ?>
        </select>


        <div class="d-flex justify-content-center gap-3">
          <button type="submit" class="btn-submit-custom">
            <i class="bi bi-check-circle-fill me-1"></i> Registrar
          </button>
          <a href="../../pages/parcial.php"
            class="btn-cancel-custom text-decoration-none d-flex align-items-center justify-content-center">
            <i class="bi bi-x-circle-fill me-1"></i>
            Cancelar
          </a>
        </div>

      </form>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
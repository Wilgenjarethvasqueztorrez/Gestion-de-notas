<!doctype html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar nota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../src/css/styles.css" />
</head>

<body>
  <div class="container" style="max-width: 650px;">
    <div class="form-card-container">
      <h1 class="form-title-custom text-center mb-4">✏️ Editar Año</h1>
      <form action="../../CRUD/Years/editarYear.php" method="post">
        <?php
        include('../../Config/Conexion.php');

        $sql = "SELECT * FROM years WHERE id =" . $_GET['Id'];
        $resultado = $conexion->query($sql);

        $row = $resultado->fetch_assoc();
        ?>
        <input type="hidden" class="form-control" name="Id" value="<?php echo $row['id']; ?>">

        <!--Insertar datos de año-->
        <div class="mb-3">
          <label class="form-label-custom">Año</label>
          <input type="text" class="form-control form-control-custom" name="Year" value="<?php echo htmlspecialchars($row['nombre']); ?>" required>
        </div>



        <div class="d-flex justify-content-center gap-3">
          <button type="submit" class="btn-submit-custom">
            <i class="bi bi-arrow-clockwise me-1"></i> Actualizar
          </button>
          <a href="../../pages/year.php"
            class="btn-cancel-custom text-decoration-none d-flex align-items-center justify-content-center">
            <i class="bi bi-x-circle-fill me-1"></i>
            Cancelar
          </a>
        </div>

      </form>
    </div>
  </div>
</body>
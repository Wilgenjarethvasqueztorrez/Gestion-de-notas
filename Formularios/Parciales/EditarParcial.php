<!doctype html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar Parciale</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../src/css/styles.css" />
</head>

<body>
  <div class="container" style="max-width: 650px;">
    <div class="form-card-container">
      <h1 class="form-title-custom text-center mb-4">✏️ Editar Parcial</h1>
      <form action="../../CRUD/Parciales/editarParcial.php" method="post">
        <?php
        include('../../Config/Conexion.php');

        $sql = "SELECT * FROM parciales WHERE id =" . $_GET['Id'];
        $resultado = $conexion->query($sql);

        $row = $resultado->fetch_assoc();
        ?>

        <!--Traer id-->
        <div class="mb-3">
          <input type="hidden" class="form-control" name="Id" value="<?php echo $row['id']; ?>">
        </div>

        <!--Traer datos de parciales-->
        <div class="mb-3">
          <label class="form-label-custom">Parcial</label>
          <input type="number" class="form-control form-control-custom" name="parciales" value="<?php echo $row['numero']; ?>" min="1" required>
        </div>


        <!--Traer datos de años-->
        <label class="form-label-custom" for="year_id">Año</label>
        <select class="form-select form-control-custom mb-3" id="year_id" name="años" required>
          <option selected disabled>--Seleccionar año--</option>
          <?php
          include("../../Config/Conexion.php");
          $sql1 = "SELECT * FROM years WHERE id=" . $row['year_id'];
          $resultado1 = $conexion->query($sql1);

          $row1 = $resultado1->fetch_assoc();

          echo "<option selected value='" . $row1['id'] . "'>" . $row1['nombre'] . "</option>";

          $sql2 = "SELECT * FROM years";
          $resultado2 = $conexion->query($sql2);

          while ($Fila = $resultado2->fetch_array()) {
            echo "<option value='" . $Fila['id'] . "'>" . $Fila['nombre'] . "</option>";
          }
          ?>
        </select>

        <div class="d-flex justify-content-center gap-3">
          <button type="submit" class="btn-submit-custom">
            <i class="bi bi-arrow-clockwise me-1"></i> Actualizar
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
</body>
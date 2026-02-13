<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar Nota</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../src/css/styles.css">
</head>

<body>

  <h1 class="bg-black p-2 text-white text-center">EDITAR NOTA</h1>
  <br>

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
  <div class="container">
    <form action="../../CRUD/Notas/editarNota.php" method="post">

      <!-- ID oculto -->
      <input type="hidden" name="Id" value="<?php echo $row['id']; ?>">

      <!-- ALUMNO -->
      <div class="mb-3">
        <label class="form-label">Alumno</label>
        <select class="form-select" name="alumnos" required>
          <option disabled>--Seleccionar alumno--</option>
          <?php
          $alumnos = $conexion->query("SELECT * FROM alumnos");
          while ($alumno = $alumnos->fetch_assoc()) {
            $selected = ($alumno['id'] == $row['alumno_id']) ? "selected" : "";
            echo "<option value='{$alumno['id']}' $selected>
                  {$alumno['nombres']} {$alumno['apellidos']}
                </option>";
          }
          ?>
        </select>
      </div>

      <!-- PARCIAL -->
      <div class="mb-3">
        <label class="form-label">Parcial</label>
        <select class="form-select" name="parciales" required>
          <option disabled>--Seleccionar parcial--</option>
          <?php
          $parciales = $conexion->query("SELECT * FROM parciales");
          while ($parcial = $parciales->fetch_assoc()) {
            $selected = ($parcial['id'] == $row['parcial_id']) ? "selected" : "";
            echo "<option value='{$parcial['id']}' $selected>
                  Parcial {$parcial['numero']} - Año {$parcial['year_id']}
                </option>";
          }
          ?>
        </select>
      </div>

      <!-- CLASE -->
      <div class="mb-3">
        <label class="form-label">Clase</label>
        <select class="form-select" name="clases" required>
          <option disabled>--Seleccionar clase--</option>
          <?php
          $clases = $conexion->query("SELECT * FROM clases");
          while ($clase = $clases->fetch_assoc()) {
            $selected = ($clase['id'] == $row['clase_id']) ? "selected" : "";
            echo "<option value='{$clase['id']}' $selected>
                  {$clase['nombre']}
                </option>";
          }
          ?>
        </select>
      </div>

      <!-- NOTA -->
      <div class="mb-3">
        <label class="form-label">Nota</label>
        <input type="number"
          class="form-control"
          name="valores"
          min="0"
          max="100"
          value="<?php echo $row['valor']; ?>"
          required>
      </div>

      <div class="text-center">
        <button type="submit" class="btn btn-dark">Actualizar</button>
        <a href="../../index.php" class="btn btn-dark">Regresar</a>
      </div>

    </form>
  </div>

</body>

</html>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Agregar Nota</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../src/css/styles.css">
</head>

<body>

  <h1 class="bg-dark p-3 text-white text-center">AGREGAR NOTA</h1>

  <?php
  include("../../Config/Conexion.php");
  ?>

  <div class="container">
    <form action="../../CRUD/Notas/insertarNota.php" method="post">

      <!-- ALUMNO -->
      <div class="mb-3">
        <label class="form-label">Alumno</label>
        <select class="form-select" name="NombreAlumno" required>
          <option disabled selected>-- Seleccionar alumno --</option>
          <?php
          $alumnos = $conexion->query("SELECT * FROM alumnos ORDER BY nombres ASC");
          while ($alumno = $alumnos->fetch_assoc()) {
            echo "<option value='{$alumno['id']}'>
                                    {$alumno['nombres']} {$alumno['apellidos']}
                                  </option>";
          }
          ?>
        </select>
      </div>

      <!-- PARCIAL -->
      <div class="mb-3">
        <label class="form-label">Parcial</label>
        <select class="form-select" name="NumeroParcial" required>
          <option disabled selected>-- Seleccionar parcial --</option>
          <?php
          $parciales = $conexion->query("SELECT * FROM parciales ORDER BY numero ASC");
          while ($parcial = $parciales->fetch_assoc()) {
            echo "<option value='{$parcial['id']}'>
                                    Parcial {$parcial['numero']} - Año {$parcial['year_id']}
                                  </option>";
          }
          ?>
        </select>
      </div>

      <!-- CLASE -->
      <div class="mb-3">
        <label class="form-label">Clase</label>
        <select class="form-select" name="NombreClase" required>
          <option disabled selected>-- Seleccionar clase --</option>
          <?php
          $clases = $conexion->query("SELECT * FROM clases ORDER BY nombre ASC");
          while ($clase = $clases->fetch_assoc()) {
            echo "<option value='{$clase['id']}'>
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
          name="Valor"
          min="0"
          max="100"
          maxlength="3"
          placeholder="Ingrese la nota (0 - 100)"
          required>
      </div>

      <!-- BOTONES -->
      <div class="text-center">
        <button type="submit" class="btn btn-dark">Registrar</button>
        <a href="../../index.php" class="btn btn-dark">Regresar</a>
      </div>

    </form>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
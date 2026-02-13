<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar Parciale</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="../../src/css/styles.css">
</head>

<body>
  <h1 class="bg-black p-2 text-white text-center">EDITAR PARCIAL</h1>
  <div class="container">
    <form class="container" action="../../CRUD/Parciales/editarParcial.php" method="post">
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
        <label class="form-label">parcial</label>
        <input type="text" class="form-control" name="parciales" value="<?php echo $row['numero']; ?>">
      </div>


      <!--Traer datos de años-->
      <label>Años</label>
      <select class="form-select mb-3" aria-label="Default select example" name="años">
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

      <div class="text-center">
        <button type="submit" class="btn btn-dark">Actualizar</button>
        <a href="../../parcial.php" class="btn btn-dark">Regresar</a>
      </div>
    </form>
  </div>
</body>
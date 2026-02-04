<!doctype html>
<html lang="en">
  <head>
   <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar notas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
<body>
 <h1 class="bg-black p-2 text-white text-center">EDITAR NOTAS</h1>
 <br>
 <form class="container" action="../CRUD/editarParcial.php" method="post">
  <?php
   include ('../Config/Conexion.php');

   $sql ="SELECT * FROM parciales WHERE id =".$_GET['Id'];
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
  <label>AÑos</label>
  <select class="form-select mb-3" aria-label="Default select example" name="años">
   <option selected disabled>--Seleccionar año--</option>
   <?php
    include("../Config/Conexion.php");
    $sql1 ="SELECT * FROM years WHERE idyear=".$row['year_id'];
    $resultado1 = $conexion->query($sql1);

    $row1 = $resultado1->fetch_assoc();

    echo "<option selected value='".$row1['idyear']."'>".$row1['nombre']."</option>";

    $sql2 = "SELECT * FROM years";
    $resultado2 = $conexion->query($sql2);

    while ($Fila = $resultado2->fetch_array()) {
      echo "<option value='".$Fila['idyear']."'>".$Fila['nombre']."</option>";
    }
   ?>
  </select>
 
  <div class="text-center">
   <button type="submit" class="btn btn-danger">Actualizar</button>
   <a href="../parcial.php" class="btn btn-dark">Regresar</a>
  </div>
 </form>
</body>

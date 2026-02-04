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
 <form class="container" action="../CRUD/editarNota.php" method="post">
  <?php
   include ('../Config/Conexion.php');

   $sql ="SELECT * FROM notas WHERE idnota =".$_GET['Id'];
   $resultado = $conexion->query($sql);

   $row = $resultado->fetch_assoc();
  ?>

 <!--Traer datos de valores-->
 <div class="mb-3">
    <input type="hidden" class="form-control" name="Id" value="<?php echo $row['idnota']; ?>">
  </div>

 <!--Traer datos de alumnos-->
  <label>Alumnos</label>
  <select class="form-select mb-3" aria-label="Default select example" name="alumnos">
   <option selected disabled>--Seleccionar alumno--</option>
   <?php
    include("../Config/Conexion.php");
    $sql1 ="SELECT * FROM alumnos WHERE id=".$row['alumno_id'];
    $resultado1 = $conexion->query($sql1);

    $row1 = $resultado1->fetch_assoc();

    echo "<option selected value='".$row1['id']."'>".$row1['nombres'].$row1['apellidos']."</option>";

    $sql2 = "SELECT * FROM alumnos";
    $resultado2 = $conexion->query($sql2);

    while ($Fila = $resultado2->fetch_array()) {
      echo "<option value='".$Fila['id']."'>".$Fila['nombres'].$Fila['apellidos']."</option>";
    }
   ?>
  </select>

  <!--Traer datos de parciles-->
  <label>Parciales</label>
  <select class="form-select mb-3" aria-label="Default select example" name="parciales">
   <option selected disabled>--Seleccionar parcial--</option>
   <?php
    include("../Config/Conexion.php");
    $sql3 ="SELECT * FROM parciales WHERE id=".$row['parcial_id'];
    $resultado3 = $conexion->query($sql3);

    $row3 = $resultado3->fetch_assoc();

    echo "<option selected value='".$row3['id']."'>".$row3['numero'].$row3['year_id']."</option>";

    $sql4 = "SELECT * FROM parciales";
    $resultado4 = $conexion->query($sql4);

    while ($Fila = $resultado4->fetch_array()) {
      echo "<option value='".$Fila['id']."'>".$Fila['numero'].$Fila['year_id']."</option>";
    }
   ?>
  </select>

  <!--Traer datos de clases-->
  <label>Clases</label>
  <select class="form-select mb-3" aria-label="Default select example" name="clases">
   <option selected disabled>--Seleccionar clase--</option>
   <?php
    include("../Config/Conexion.php");
    $sql5 ="SELECT * FROM clases WHERE id=".$row['clase_id'];
    $resultado5 = $conexion->query($sql5);

    $row5 = $resultado5->fetch_assoc();

    echo "<option selected value='".$row5['id']."'>".$row5['nombre']."</option>";

    $sql6 = "SELECT * FROM clases";
    $resultado6 = $conexion->query($sql6);

    while ($Fila = $resultado6->fetch_array()) {
      echo "<option value='".$Fila['id']."'>".$Fila['nombre']."</option>";
    }
   ?>
  </select>

  <!--Traer datos de valores-->
  <div class="mb-3">
    <label class="form-label">Nota</label>
    <input type="text" class="form-control" name="valores" value="<?php echo $row['valor']; ?>">
  </div>
  <div class="text-center">
   <button type="submit" class="btn btn-danger">Actualizar</button>
   <a href="../index.php" class="btn btn-dark">Regresar</a>
  </div>
 
 </form>
</body>

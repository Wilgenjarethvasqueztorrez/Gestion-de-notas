<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agregar nota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <h1 class="bg-black p-2 text-white text-center">Agregar notas</h1>
    <div class="container">
    <form action="../CRUD/insertarNota.php" method="post">
        <label for="">Alumnos</label>
     <select class="form-select mb-3" name="NombreAlumno">
     <option selected disabled>--Seleccionar alumno--</option>
     <?php
       include ("../Config/Conexion.php");
       $sql = $conexion->query("SELECT * FROM alumnos");
       while ($resultado = $sql->fetch_assoc()) {
        echo "<option value='".$resultado['id']."'>".$resultado['nombres'].$resultado['apellidos']."</option>";
       }
     ?>
   </select>
 
   <label for="">Parciales</label>
     <select class="form-select mb-3" name="NumeroParcial">
     <option selected disabled>--Seleccionar parcial--</option>
     <?php
       include ("../Config/Conexion.php");
       $sql = $conexion->query("SELECT * FROM parciales");
       while ($resultado = $sql->fetch_assoc()) {
        echo "<option value='".$resultado['id']."'>".$resultado['numero'].$resultado['year_id']."</option>";
       
       }
     ?>
   </select>
   <label for="">Clases</label>
     <select class="form-select mb-3" name="NombreClase">
     <option selected disabled>--Seleccionar clase--</option>
     <?php
       include ("../Config/Conexion.php");
       $sql = $conexion->query("SELECT * FROM clases");
       while ($resultado = $sql->fetch_assoc()) {
        echo "<option value='".$resultado['id']."'>".$resultado['nombre']."</option>";
       }
     ?>
   </select>
  <div class="mb-3">
    <label class="form-label">Nota</label>
    <input type="text" class="form-control" name="Valor">
  </div>
  <div class="text-center">
   <button type="submit" class="btn btn-danger">Registrar</button>
   <a href="../index.php" class="btn btn-dark">Regresar</a>
  </div>
 
</form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
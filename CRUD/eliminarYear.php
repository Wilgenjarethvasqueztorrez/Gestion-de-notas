<?php

include ("../Config/Conexion.php");

$Id = $_GET["Id"];
$sql = "DELETE FROM years WHERE idyear=".$Id."";

$query = mysqli_query($conexion,$sql);

if ($query === TRUE) {
   header("location: ../year.php");
} else {
    echo "No se pueden eliminar las clases que ya estan regsitradas en la tabla de notas";
  }
<?php

include ("../Config/Conexion.php");

$nombre = $_POST['NombreClase'];


$sql = "INSERT INTO clases(nombre) VALUES('$nombre')";

$resultado = mysqli_query($conexion, $sql);

if ($resultado === TRUE) {
   header("location:../Clase.php");
} else {
  echo "Clase no insertada";
}
<?php

include ("../Config/Conexion.php");

$nombre = $_POST['NumeroAño'];

$sql = "INSERT INTO years(nombre) VALUES('$nombre')";

$resultado = mysqli_query($conexion, $sql);

if ($resultado === TRUE) {
   header("location:../Year.php");
} else {
  echo "Parcial no insertado";
}
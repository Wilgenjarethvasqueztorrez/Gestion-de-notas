<?php

include ("../Config/Conexion.php");

$alumno = $_POST['NombreAlumno'];
$parcial = $_POST['NumeroParcial'];
$clase = $_POST['NombreClase'];
$valor = $_POST['Valor'];

$sql = "INSERT INTO notas(alumno_id,parcial_id,clase_id,valor) VALUES('$alumno','$parcial','$clase','$valor')";

$resultado = mysqli_query($conexion, $sql);

if ($resultado === TRUE) {
   header("location:../Index.php");
} else {
  echo "Nota no insertada";
}


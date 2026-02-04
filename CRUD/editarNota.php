<?php

include ("../Config/Conexion.php");

$id = $_POST['Id'];
$Alumno = $_POST['alumnos'];
$Parcial = $_POST['parciales'];
$Clase = $_POST['clases'];
$Valor = $_POST['valores'];

$sql = "UPDATE notas SET 
               idnota='".$id."', 
               alumno_id='".$Alumno."', 
               parcial_id='".$Parcial."', 
               clase_id='".$Clase."', 
               valor='".$Valor."' WHERE idnota = ".$id."";

if ($resultado = $conexion->query($sql)) {
    header("location:../index.php");
}
  

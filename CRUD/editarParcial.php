<?php

include ("../Config/Conexion.php");

$id = $_POST['Id'];
$Parcial = $_POST['parciales'];
$Año = $_POST['años'];

$sql = "UPDATE parciales SET 
               id='".$id."', 
               numero='".$Parcial."', 
               year_id='".$Año."' WHERE id = ".$id."";
           

if ($resultado = $conexion->query($sql)) {
    header("location:../parcial.php");
}
  
<?php

include ("../Config/conexion.php");

$id = $_POST['Id'];
$Year = $_POST['Year'];

$sql ="UPDATE years SET
          idyear='".$id."',
          nombre='".$Year."' WHERE idyear= ".$id."";

if ($resultado = $conexion->query($sql)) {
            header("location:../year.php");
}
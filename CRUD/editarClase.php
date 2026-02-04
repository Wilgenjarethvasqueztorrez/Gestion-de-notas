<?php

include ("../Config/conexion.php");

$id = $_POST['Id'];
$Clase = $_POST['clase'];

$sql ="UPDATE clases SET
          id='".$id."',
          nombre='".$Clase."' WHERE id= ".$id."";

if ($resultado = $conexion->query($sql)) {
            header("location:../clase.php");
}
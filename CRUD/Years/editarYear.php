<?php

include ("../../Config/conexion.php");

$id = $_POST['Id'];
$Year = $_POST['Year'];

$sql ="UPDATE years SET
          id='".$id."',
          nombre='".$Year."' WHERE id= ".$id."";

if (mysqli_query($conexion, $sql)) {  
    header("location:../../year.php?success=editado");  
} else {  
    header("location:../../year.php?error=db");  
}
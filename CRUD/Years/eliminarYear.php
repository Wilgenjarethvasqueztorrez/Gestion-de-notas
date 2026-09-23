<?php

include ("../../Config/Conexion.php");

$Id = $_GET["Id"];
$sql = "DELETE FROM years WHERE id=".$Id."";

$query = mysqli_query($conexion,$sql);

if (mysqli_query($conexion, $sql)) {  
    header("location:../../pages/year.php?success=eliminado");  
} else {  
    header("location:../../pages/year.php?error=db");  
}
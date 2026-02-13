<?php

include ("../../Config/Conexion.php");

$Id = $_GET['Id'];
$sql = "DELETE FROM parciales WHERE id=".$Id."";

$query = mysqli_query($conexion,$sql);

if ($query === TRUE) {
    header("location:../../parcial.php?success=eliminado");  
} else {  
    header("location:../../parcial.php?error=db");  
}

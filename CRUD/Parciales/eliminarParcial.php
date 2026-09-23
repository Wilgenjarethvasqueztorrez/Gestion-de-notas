<?php

include ("../../Config/Conexion.php");

$Id = $_GET['Id'];
$sql = "DELETE FROM parciales WHERE id=".$Id."";

$query = mysqli_query($conexion,$sql);

if ($query === TRUE) {
    header("location:../../pages/parcial.php?success=eliminado");  
} else {  
    header("location:../../pages/parcial.php?error=db");  
}

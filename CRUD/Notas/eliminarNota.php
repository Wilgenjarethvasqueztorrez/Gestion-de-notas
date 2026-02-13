<?php

include ("../../Config/Conexion.php");

$Id = $_GET['Id'];
$sql = "DELETE FROM notas WHERE id=".$Id."";

$query = mysqli_query($conexion,$sql);

if ($query === TRUE) {
    header("location:../../index.php?success=eliminado");  
} else {  
    header("location:../../index.php?error=db");  
}

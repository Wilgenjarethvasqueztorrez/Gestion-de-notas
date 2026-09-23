<?php

include ("../../Config/Conexion.php");

$Id = $_GET['Id'];
$sql = "DELETE FROM notas WHERE id=".$Id."";

$query = mysqli_query($conexion,$sql);

if ($query === TRUE) {
    header("location:../../pages/nota.php?success=eliminado");  
} else {  
    header("location:../../pages/nota.php?error=db");  
}

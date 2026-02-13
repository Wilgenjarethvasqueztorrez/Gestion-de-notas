<?php

include ("../../Config/Conexion.php");

$numero = $_POST['NumeroParcial'];
$nombre = $_POST['NumeroAño'];

$sql = "INSERT INTO parciales(numero,year_id) VALUES('$numero','$nombre')";

$resultado = mysqli_query($conexion, $sql);

if ($resultado === TRUE) {
    header("location:../../parcial.php?success=agregado");  
} else {  
    header("location:../../parcial.php?error=db");  
}
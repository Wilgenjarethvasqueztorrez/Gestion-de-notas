<?php

include ("../../Config/Conexion.php");

$nombre = $_POST['NumeroAño'];

$sql = "INSERT INTO years(nombre) VALUES('$nombre')";

$resultado = mysqli_query($conexion, $sql);

if ($resultado)  {  
    header("location:../../pages/year.php?success=agregado");  
} else {  
    header("location:../../pages/year.php?error=db");  
}
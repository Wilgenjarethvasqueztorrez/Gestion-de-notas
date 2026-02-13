<?php

include ("../../Config/Conexion.php");

$nombre = $_POST['NumeroAño'];

$sql = "INSERT INTO years(nombre) VALUES('$nombre')";

$resultado = mysqli_query($conexion, $sql);

if (mysqli_query($conexion, $sql)) {  
    header("location:../../year.php?success=agregado");  
} else {  
    header("location:../../year.php?error=db");  
}
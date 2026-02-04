<?php

include ("../Config/Conexion.php");

$id = $_POST['Id'];
$Nombre = $_POST['nombre'];
$Apellido = $_POST['apellido'];
$Genero = $_POST['generos'];
$Direccion = $_POST['direcciones'];
$Telefono = $_POST['telefonos'];
$Correo = $_POST['correos'];


$sql = "UPDATE alumnos SET 
               id='".$id."', 
               nombres='".$Nombre."', 
               apellidos='".$Apellido."', 
               genero='".$Genero."', 
               direccion='".$Direccion."', 
               telefono='".$Telefono."', 
               correo='".$Correo."' WHERE id = ".$id."";

if ($resultado = $conexion->query($sql)) {
    header("location:../alumno.php");
}




  

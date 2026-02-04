<?php

include ("../Config/Conexion.php");

$nombre = $_POST['NombreAlumno'];
$apellido = $_POST['ApellidoAlumno'];
$genero = $_POST['GeneroAlumno'];
$direccion = $_POST['DireccionAlumno'];
$telefono = $_POST['TelefonoAlumno'];
$correo = $_POST['CorreoAlumno'];

$sql = "INSERT INTO alumnos(nombres,apellidos,genero,direccion,telefono,correo) VALUES('$nombre','$apellido','$genero','$direccion','$telefono','$correo')";

$resultado = mysqli_query($conexion, $sql);

if ($resultado === TRUE) {
   header("location:../Alumno.php");
} else {
  echo "Alumno no insertado";
}


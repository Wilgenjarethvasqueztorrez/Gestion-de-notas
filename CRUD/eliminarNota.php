<?php

include ("../Config/Conexion.php");

$Id = $_GET['Id'];
$sql = "DELETE FROM notas WHERE idnota=".$Id."";

$query = mysqli_query($conexion,$sql);

if ($query === TRUE) {
   header("location: ../index.php");
}

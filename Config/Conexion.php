<?php

  $host = "localhost";
  $user = "root";
  $pass = "wilgen12345";
  $db = "registro de notas";

  $conexion =new mysqli($host,$user,$pass,$db);

  if (!$conexion) {
    echo 'Conexion fallida';
  }
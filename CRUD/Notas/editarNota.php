<?php

include ("../../Config/Conexion.php");

$id = filter_input(INPUT_POST, 'Id', FILTER_VALIDATE_INT);
$matricula = filter_input(INPUT_POST, 'matricula', FILTER_VALIDATE_INT);
$parcial = filter_input(INPUT_POST, 'parcial', FILTER_VALIDATE_INT);
$valor = filter_input(INPUT_POST, 'valor', FILTER_VALIDATE_INT);

$stmt = $conexion->prepare("UPDATE notas SET matricula_id = ?, parcial_id = ?, valor = ? WHERE id = ?");
$stmt->bind_param('iiii', $matricula, $parcial, $valor, $id);

if ($id && $matricula && $parcial && $valor !== false && $valor >= 0 && $valor <= 100 && $stmt->execute()) {
    header("location:../../pages/nota.php?success=editado");  
} else {  
    header("location:../../pages/nota.php?error=db");  
}
  

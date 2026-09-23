<?php

include ("../../Config/Conexion.php");

$matricula = filter_input(INPUT_POST, 'Matricula', FILTER_VALIDATE_INT);
$parcial = filter_input(INPUT_POST, 'NumeroParcial', FILTER_VALIDATE_INT);
$valor = filter_input(INPUT_POST, 'Valor', FILTER_VALIDATE_INT);

$stmt = $conexion->prepare("INSERT INTO notas (matricula_id, parcial_id, valor) VALUES (?, ?, ?)");
$stmt->bind_param('iii', $matricula, $parcial, $valor);
$resultado = $matricula && $parcial && $valor !== false && $valor >= 0 && $valor <= 100 && $stmt->execute();

if ($resultado === TRUE) {
    header("location:../../pages/nota.php?success=agregado");  
} else {  
    header("location:../../pages/nota.php?error=db");  
}



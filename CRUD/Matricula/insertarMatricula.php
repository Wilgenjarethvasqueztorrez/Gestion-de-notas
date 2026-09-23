<?php
include('../../Config/Conexion.php');

$alumnoId = filter_input(INPUT_POST, 'alumno_id', FILTER_VALIDATE_INT);
$claseId = filter_input(INPUT_POST, 'clase_id', FILTER_VALIDATE_INT);
$stmt = $conexion->prepare('INSERT INTO matricula (alumno_id, clase_id) VALUES (?, ?)');
$stmt->bind_param('ii', $alumnoId, $claseId);
$ok = $alumnoId && $claseId && $stmt->execute();
header('Location: ../../pages/matricula.php?' . ($ok ? 'success=agregado' : 'error=db'));
exit;

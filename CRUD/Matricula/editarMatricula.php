<?php
include('../../Config/Conexion.php');

$id = filter_input(INPUT_POST, 'Id', FILTER_VALIDATE_INT);
$alumnoId = filter_input(INPUT_POST, 'alumno_id', FILTER_VALIDATE_INT);
$claseId = filter_input(INPUT_POST, 'clase_id', FILTER_VALIDATE_INT);
$stmt = $conexion->prepare('UPDATE matricula SET alumno_id = ?, clase_id = ? WHERE id = ?');
$stmt->bind_param('iii', $alumnoId, $claseId, $id);
$ok = $id && $alumnoId && $claseId && $stmt->execute();
header('Location: ../../pages/matricula.php?' . ($ok ? 'success=editado' : 'error=db'));
exit;

<?php
include('../../Config/Conexion.php');

$id = filter_input(INPUT_GET, 'Id', FILTER_VALIDATE_INT);
$stmt = $conexion->prepare('DELETE FROM matricula WHERE id = ?');
$stmt->bind_param('i', $id);
$ok = $id && $stmt->execute();
header('Location: ../../pages/matricula.php?' . ($ok ? 'success=eliminado' : 'error=db'));
exit;

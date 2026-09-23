<?php
include("../../Config/Conexion.php");

$id = filter_input(INPUT_GET, 'Id', FILTER_VALIDATE_INT);

if (!$id) {
    header("location:../../pages/alumno.php?error=datos");
    exit;
}

$usuario = $conexion->prepare("SELECT alumno_id FROM alumnos WHERE id = ?");
$usuario->bind_param('i', $id);
$usuario->execute();
$usuarioId = $usuario->get_result()->fetch_assoc()['alumno_id'] ?? 0;

if (!$usuarioId) {
    header("location:../../pages/alumno.php?error=no_encontrado");
    exit;
}

$conexion->begin_transaction();
$stmt = $conexion->prepare("DELETE FROM alumnos WHERE id = ?");
$stmt->bind_param('i', $id);
$alumnoEliminado = $stmt->execute() && $stmt->affected_rows > 0;

if ($alumnoEliminado) {
    $borrarUsuario = $conexion->prepare("DELETE FROM usuarios WHERE id = ? AND rol_sistema = 'Estudiante'");
    $borrarUsuario->bind_param('i', $usuarioId);
    $usuarioEliminado = $borrarUsuario->execute() && $borrarUsuario->affected_rows > 0;
} else {
    $usuarioEliminado = false;
}

if ($alumnoEliminado && $usuarioEliminado) {
    $conexion->commit();
    header("location:../../pages/alumno.php?success=eliminado");
} else {
    $conexion->rollback();
    header("location:../../pages/alumno.php?error=db");
}
exit;
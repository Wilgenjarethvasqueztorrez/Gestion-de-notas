<?php
include("../../Config/Conexion.php");

$id = filter_input(INPUT_POST, 'Id', FILTER_VALIDATE_INT);
$usuarioId = filter_input(INPUT_POST, 'UsuarioId', FILTER_VALIDATE_INT);
$estado = $_POST['estado'] ?? '';
$estadosValidos = ['Activo', 'Graduado', 'Suspendido'];

if (!$id || !$usuarioId || !in_array($estado, $estadosValidos, true)) {
    header("location:../../pages/alumno.php?error=datos");
    exit;
}

$usuario = $conexion->prepare("SELECT id FROM usuarios WHERE id = ? AND rol_sistema = 'Estudiante'");
$usuario->bind_param('i', $usuarioId);
$usuario->execute();
$usuarioExiste = $usuario->get_result()->fetch_assoc();

if (!$usuarioExiste) {
    header("location:../../pages/alumno.php?error=usuario_invalido");
    exit;
}

$duplicado = $conexion->prepare("SELECT id FROM alumnos WHERE alumno_id = ? AND id <> ?");
$duplicado->bind_param('ii', $usuarioId, $id);
$duplicado->execute();

if ($duplicado->get_result()->fetch_assoc()) {
    header("location:../../pages/alumno.php?error=duplicado");
    exit;
}

$alumno = $conexion->prepare("UPDATE alumnos SET alumno_id = ?, estado = ? WHERE id = ?");
$alumno->bind_param('isi', $usuarioId, $estado, $id);

if ($alumno->execute() && $alumno->affected_rows > 0) {
    header("location:../../pages/alumno.php?success=editado");
} else {
    header("location:../../pages/alumno.php?error=db");
}
exit;




  

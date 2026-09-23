<?php
include("../../Config/Conexion.php");

$usuarioId = filter_input(INPUT_POST, 'UsuarioId', FILTER_VALIDATE_INT);
$estado = $_POST['EstadoAlumno'] ?? '';
$estadosValidos = ['Activo', 'Graduado', 'Suspendido'];

if (!$usuarioId || !in_array($estado, $estadosValidos, true)) {
    header("location:../../pages/alumno.php?error=datos");
    exit;
}

$usuario = $conexion->prepare("SELECT id FROM usuarios WHERE id = ? AND rol_sistema = 'Estudiante'");
$usuario->bind_param('i', $usuarioId);
$usuario->execute();
$usuarioExiste = $usuario->get_result()->fetch_assoc();

$alumnoExistente = $conexion->prepare("SELECT id FROM alumnos WHERE alumno_id = ?");
$alumnoExistente->bind_param('i', $usuarioId);
$alumnoExistente->execute();
$yaEsAlumno = $alumnoExistente->get_result()->fetch_assoc();

if (!$usuarioExiste || $yaEsAlumno) {
    header("location:../../pages/alumno.php?error=duplicado");
    exit;
}

$stmt = $conexion->prepare("INSERT INTO alumnos (alumno_id, estado) VALUES (?, ?)");
$stmt->bind_param('is', $usuarioId, $estado);

if ($stmt->execute()) {
    header("location:../../pages/alumno.php?success=agregado");
} else {
    header("location:../../pages/alumno.php?error=db");
}
exit;


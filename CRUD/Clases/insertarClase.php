<?php
include("../../Config/Conexion.php");

$nombre = trim($_POST['NombreClase'] ?? '');
$profesorId = filter_input(INPUT_POST, 'ProfesorId', FILTER_VALIDATE_INT);
$profesorId = $profesorId ?: null;

if ($nombre === '' || mb_strlen($nombre) > 100) {
    header("location:../../pages/clase.php?error=datos");
    exit;
}

if ($profesorId !== null) {
    $profesor = $conexion->prepare("SELECT id FROM usuarios WHERE id = ? AND rol_sistema = 'Profesor'");
    $profesor->bind_param('i', $profesorId);
    $profesor->execute();
    if (!$profesor->get_result()->fetch_assoc()) {
        header("location:../../pages/clase.php?error=profesor_invalido");
        exit;
    }
}

$stmt = $conexion->prepare("INSERT INTO clases (nombre, profesor_id) VALUES (?, ?)");
$stmt->bind_param('si', $nombre, $profesorId);

if ($stmt->execute()) {
    header("location:../../pages/clase.php?success=agregado");
} else {
    header("location:../../pages/clase.php?error=db");
}
exit;

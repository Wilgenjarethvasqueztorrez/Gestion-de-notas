<?php
include("../../Config/Conexion.php");

$id = filter_input(INPUT_POST, 'Id', FILTER_VALIDATE_INT);
$nombre = trim($_POST['clase'] ?? '');
$profesorId = filter_input(INPUT_POST, 'ProfesorId', FILTER_VALIDATE_INT);
$profesorId = $profesorId ?: null;

if (!$id || $nombre === '' || mb_strlen($nombre) > 100) {
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

$stmt = $conexion->prepare("UPDATE clases SET nombre = ?, profesor_id = ? WHERE id = ?");
$stmt->bind_param('sii', $nombre, $profesorId, $id);

if ($stmt->execute()) {
    header("location:../../pages/clase.php?success=editado");
} else {
    header("location:../../pages/clase.php?error=db");
}
exit;

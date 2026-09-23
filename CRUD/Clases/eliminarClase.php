<?php
include("../../Config/Conexion.php");

$id = filter_input(INPUT_GET, 'Id', FILTER_VALIDATE_INT);
if (!$id) {
    header("location:../../pages/clase.php?error=datos");
    exit;
}

$stmt = $conexion->prepare("DELETE FROM clases WHERE id = ?");
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    header("location:../../pages/clase.php?success=eliminado");
} else {
    header("location:../../pages/clase.php?error=db");
}
exit;

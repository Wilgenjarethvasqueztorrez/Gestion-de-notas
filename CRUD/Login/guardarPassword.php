<?php
session_start();
include("../../Config/Conexion.php");

if (!isset($_SESSION['temp_usuario_id'])) {
    header("location: ../../Formularios/Login/login.php");
    exit();
}

$usuario_id = intval($_POST['UsuarioId']);
$password = $_POST['Password'];
$confirmar_password = $_POST['ConfirmarPassword'];

if ($password !== $confirmar_password) {
    header("location: ../../Formularios/Login/establecerPassword.php?error=no_coinciden");
    exit();
}

if (strlen($password) < 6) {
    header("location: ../../Formularios/Login/establecerPassword.php?error=muy_corta");
    exit();
}

$password_hash = password_hash($password, PASSWORD_DEFAULT);

// UPDATE con prepared statement
$stmt = $conexion->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
if (!$stmt) {
    die("Error en prepare UPDATE: " . $conexion->error);
}
$stmt->bind_param("si", $password_hash, $usuario_id);
if (!$stmt->execute()) {
    die("Error en execute UPDATE: " . $stmt->error);
}
$stmt->close();

// Obtener datos del usuario
$sqlUsuario = "SELECT id, nombre, apellido, correo, rol_sistema FROM usuarios WHERE id = ?";
$stmtUser = $conexion->prepare($sqlUsuario);
$stmtUser->bind_param("i", $usuario_id);
$stmtUser->execute();
$resultado = $stmtUser->get_result();
$usuario = $resultado->fetch_assoc();
$stmtUser->close();

unset($_SESSION['temp_usuario_id']);
$_SESSION['usuario_id'] = $usuario['id'];
$_SESSION['usuario_nombre'] = $usuario['nombre'];
$_SESSION['usuario_apellido'] = $usuario['apellido'];
$_SESSION['usuario_correo'] = $usuario['correo'];
$_SESSION['usuario_rol'] = $usuario['rol_sistema'];

if ($usuario['rol_sistema'] == 'Administrador') {
            header("location:../../index.php");
        } elseif ($usuario['rol_sistema'] == 'Oficina') {
            header("location: ../../pages/alumno.php");
        } else if ($usuario['rol_sistema'] == 'Profesor') { 
            header("location: ../../pages/perfil_profesor.php");
        } elseif ($usuario['rol_sistema'] == 'Estudiante') {
            header("location: ../../pages/perfil_alumno.php");
        }
exit();
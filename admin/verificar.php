<?php
session_start();
require_once __DIR__ . '/../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php'); exit;
}
$usuario = trim($_POST['usuario'] ?? '');
$password = $_POST['password'] ?? '';

$stmt = $pdo->prepare('SELECT id, usuario, password FROM administradores WHERE usuario = ? LIMIT 1');
$stmt->execute([$usuario]);
$admin = $stmt->fetch();

if ($admin && password_verify($password, $admin['password'])) {
    session_regenerate_id(true);
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['admin_usuario'] = $admin['usuario'];
    header('Location: panel.php');
    exit;
}
$_SESSION['login_error'] = 'Usuario o contraseña incorrectos.';
header('Location: login.php');
exit;

<?php
require_once __DIR__ . '/config/conexion.php';
$existe = (int)$pdo->query('SELECT COUNT(*) FROM administradores')->fetchColumn();
$mensaje = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $existe === 0) {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';
    if (strlen($usuario) < 4) {
        $error = 'El usuario debe tener al menos 4 caracteres.';
    } elseif (strlen($password) < 8) {
        $error = 'La contraseña debe tener al menos 8 caracteres.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO administradores (usuario, password) VALUES (?, ?)');
        $stmt->execute([$usuario, password_hash($password, PASSWORD_DEFAULT)]);
        $mensaje = 'Administrador creado. Por seguridad, eliminá ahora el archivo crear_administrador.php de la carpeta del proyecto.';
        $existe = 1;
    }
}
?>
<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Crear administrador</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="bg-light"><div class="container py-5" style="max-width:520px"><div class="card shadow-sm"><div class="card-body p-4">
<h1 class="h4 mb-3">Configuración inicial: administrador</h1>
<?php if ($mensaje): ?><div class="alert alert-success"><?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?><p class="mb-0 mt-2"><a href="admin/login.php">Ir al inicio de sesión</a></p></div>
<?php elseif ($existe > 0): ?><div class="alert alert-warning">Ya existe un administrador. Por seguridad, eliminá este archivo del proyecto.</div>
<?php else: ?>
<p class="text-secondary">Creá las credenciales que utilizarás para administrar las respuestas.</p>
<?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>
<form method="POST">
<div class="mb-3"><label class="form-label">Usuario (mínimo 4 caracteres)</label><input class="form-control" name="usuario" minlength="4" required></div>
<div class="mb-3"><label class="form-label">Contraseña (mínimo 8 caracteres)</label><input class="form-control" type="password" name="password" minlength="8" required></div>
<button class="btn btn-primary w-100">Crear administrador</button>
</form><?php endif; ?>
</div></div></div></body></html>

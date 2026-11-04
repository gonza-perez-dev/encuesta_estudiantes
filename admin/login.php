<?php
session_start();
if (!empty($_SESSION['admin_id'])) {
    header('Location: panel.php'); exit;
}
$error = $_SESSION['login_error'] ?? '';
unset($_SESSION['login_error']);
?>
<!DOCTYPE html>
<html lang="es"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Acceso administrador</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../css/estilos.css" rel="stylesheet">
</head><body>
<div class="container py-5" style="max-width:480px">
  <div class="formulario">
    <h1 class="h3 mb-2">Panel de administracion</h1>
    <p class="text-secondary">Ingresa con tu usuario y contraseña.</p>
    <?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>
    <form action="verificar.php" method="POST">
      <div class="mb-3"><label class="form-label">Usuario</label><input class="form-control" name="usuario" required autocomplete="username"></div>
      <div class="mb-3"><label class="form-label">Contraseña</label><input class="form-control" type="password" name="password" required autocomplete="current-password"></div>
      <button class="btn btn-primary w-100" type="submit">Ingresar</button>
    </form>
    <a href="../index.php" class="d-inline-block mt-3">Volver a la encuesta</a>
  </div>
</div></body></html>

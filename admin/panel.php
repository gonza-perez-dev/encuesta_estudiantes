<?php
require_once __DIR__ . '/proteger.php';
require_once __DIR__ . '/../config/conexion.php';
$total = (int)$pdo->query('SELECT COUNT(*) FROM respuestas')->fetchColumn();
$ultima = $pdo->query('SELECT fecha_registro FROM respuestas ORDER BY id DESC LIMIT 1')->fetchColumn();
?>
<!DOCTYPE html><html lang="es"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Panel de administración</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../css/estilos.css" rel="stylesheet"></head><body>
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div><h1 class="h3 mb-1">Panel de administración</h1><span class="text-secondary">Sesión: <?= htmlspecialchars($_SESSION['admin_usuario'], ENT_QUOTES, 'UTF-8') ?></span></div>
    <a class="btn btn-outline-secondary" href="cerrar_sesion.php">Cerrar sesión</a>
  </div>
  <div class="row g-3 mb-4">
    <div class="col-md-6"><div class="formulario h-100"><div class="text-secondary">Encuestas recibidas</div><div class="display-4 fw-bold"><?= $total ?></div></div></div>
    <div class="col-md-6"><div class="formulario h-100"><div class="text-secondary">Última respuesta</div><div class="fs-5 fw-semibold mt-2"><?= $ultima ? htmlspecialchars($ultima, ENT_QUOTES, 'UTF-8') : 'Todavía no hay respuestas' ?></div></div></div>
  </div>
  <div class="formulario">
    <h2 class="h5">Administrar respuestas</h2>
    <p class="text-secondary">Podés consultar cada respuesta o exportar todas las encuestas a un archivo CSV compatible con Excel.</p>
    <div class="d-flex flex-wrap gap-2">
      <a class="btn btn-primary" href="respuestas.php">Ver respuestas</a>
      <a class="btn btn-info text-white" href="estadisticas.php">Ver estadísticas</a>
      <a class="btn btn-success" href="exportar_excel.php">Exportar a Excel (CSV)</a>
    </div>
  </div>
</div></body></html>

<?php
require_once __DIR__ . '/proteger.php';
require_once __DIR__ . '/../config/conexion.php';
$pagina = max(1, (int)($_GET['pagina'] ?? 1));
$porPagina = 20;
$total = (int)$pdo->query('SELECT COUNT(*) FROM respuestas')->fetchColumn();
$paginas = max(1, (int)ceil($total / $porPagina));
$offset = ($pagina - 1) * $porPagina;
$stmt = $pdo->prepare('SELECT id, institucion, carrera, edad, genero, departamento, fecha_registro FROM respuestas ORDER BY id DESC LIMIT :limite OFFSET :offset');
$stmt->bindValue(':limite', $porPagina, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$filas = $stmt->fetchAll();
function h($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html><html lang="es"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Respuestas recibidas</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../css/estilos.css" rel="stylesheet"></head><body>
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
    <h1 class="h3 mb-0">Respuestas recibidas</h1><a href="panel.php" class="btn btn-outline-secondary">Volver al panel</a>
  </div>
  <p class="text-secondary">Total de encuestas: <?= $total ?></p>
  <div class="table-responsive bg-white rounded-3 shadow-sm">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light"><tr><th>ID</th><th>Institución</th><th>Carrera</th><th>Edad</th><th>Género</th><th>Departamento</th><th>Fecha</th><th></th></tr></thead>
      <tbody>
      <?php if (!$filas): ?><tr><td colspan="8" class="text-center py-4">Todavía no hay respuestas.</td></tr>
      <?php else: foreach ($filas as $fila): ?>
        <tr>
          <td><?= h($fila['id']) ?></td>
          <td><?= h($fila['institucion']) ?></td>
          <td><?= h($fila['carrera']) ?></td>
          <td><?= h($fila['edad']) ?></td>
          <td><?= h($fila['genero']) ?></td>
          <td><?= h($fila['departamento']) ?></td>
          <td><?= h($fila['fecha_registro']) ?></td>
          <td><a class="btn btn-sm btn-outline-primary" href="detalle.php?id=<?= (int)$fila['id'] ?>">Ver</a></td>
        </tr>
      <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
  <nav class="mt-3"><ul class="pagination">
    <?php for ($i=1; $i<=$paginas; $i++): ?>
      <li class="page-item <?= $i===$pagina ? 'active' : '' ?>"><a class="page-link" href="?pagina=<?= $i ?>"><?= $i ?></a></li>
    <?php endfor; ?>
  </ul></nav>
</div></body></html>
<?php
require_once __DIR__ . '/proteger.php';
require_once __DIR__ . '/../config/conexion.php';

function h($valor) {
    return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
}

$total = (int)$pdo->query('SELECT COUNT(*) FROM respuestas')->fetchColumn();
function obtenerDistribucion(PDO $pdo, string $campo): array {
    $camposPermitidos = [
        'institucion', 'edad', 'genero', 'departamento', 'convivencia',
        'personas_cargo', 'distancia', 'transporte', 'situacion_laboral',
        'relacion_laboral', 'ayuda_social', 'trayectoria_previa', 'interrupcion',
        'impacto_laboral', 'impacto_familiar', 'asistencia', 'factor_inasistencia',
        'puntualidad', 'dispositivo', 'propiedad_dispositivo', 'conexion_internet'
    ];
    if (!in_array($campo, $camposPermitidos, true)) {
        return [];
    }
    $sql = "SELECT `$campo` AS respuesta, COUNT(*) AS cantidad
            FROM respuestas GROUP BY `$campo` ORDER BY cantidad DESC, respuesta ASC";
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

function totalDe(PDO $pdo, string $sql): int {
    return (int)$pdo->query($sql)->fetchColumn();
}

$sinPersonasACargo = totalDe($pdo, "SELECT COUNT(*) FROM respuestas WHERE personas_cargo = '0'");
$trabajan = totalDe($pdo, "SELECT COUNT(*) FROM respuestas WHERE situacion_laboral <> 'No trabajo'");
$noTrabajan = totalDe($pdo, "SELECT COUNT(*) FROM respuestas WHERE situacion_laboral = 'No trabajo'");
$recibenAyuda = totalDe($pdo, "SELECT COUNT(*) FROM respuestas WHERE LOWER(ayuda_social) = 'sí' OR LOWER(ayuda_social) = 'si'");
$noRecibenAyuda = totalDe($pdo, "SELECT COUNT(*) FROM respuestas WHERE LOWER(ayuda_social) = 'no'");
$interrumpieron = totalDe($pdo, "SELECT COUNT(*) FROM respuestas WHERE interrupcion <> 'Nunca'");

$secciones = [
    'Situación familiar y personal' => [
        'convivencia' => '¿Con quiénes viven?',
        'personas_cargo' => 'Personas a cargo',
        'edad' => 'Edades',
        'genero' => 'Género',
        'departamento' => 'Departamento de residencia',
        'distancia' => 'Distancia hasta la institución',
        'transporte' => 'Medio de transporte'
    ],
    'Situación laboral' => [
        'situacion_laboral' => 'Situación laboral actual',
        'relacion_laboral' => 'Relación laboral',
        'ayuda_social' => 'Ayuda social'
    ],
    'Trayectoria académica' => [
        'trayectoria_previa' => 'Trayectoria previa',
        'interrupcion' => 'Interrupción de estudios',
        'impacto_laboral' => 'Impacto del trabajo en el estudio',
        'impacto_familiar' => 'Impacto de responsabilidades familiares',
        'asistencia' => 'Porcentaje de asistencia',
        'factor_inasistencia' => 'Factores que dificultan asistir',
        'puntualidad' => 'Puntualidad',
        'dispositivo' => 'Dispositivo utilizado',
        'propiedad_dispositivo' => 'Propiedad del dispositivo',
        'conexion_internet' => 'Conexión a internet'
    ],
    'Institución' => [
        'institucion' => 'Institución de pertenencia'
    ]
];

$datosLaborales = obtenerDistribucion($pdo, 'situacion_laboral');
$labelsLaborales = array_column($datosLaborales, 'respuesta');
$valoresLaborales = array_map('intval', array_column($datosLaborales, 'cantidad'));
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Estadísticas de la encuesta</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../css/estilos.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
    <div><h1 class="h3 mb-1">Estadísticas de la encuesta</h1><p class="text-secondary mb-0">Resumen actualizado de las respuestas recibidas.</p></div>
    <a href="panel.php" class="btn btn-outline-secondary">Volver al panel</a>
  </div>

  <div class="row g-3 mb-4">
    <div class="col-6 col-lg-3"><div class="formulario h-100"><div class="text-secondary">Total de encuestas</div><div class="display-5 fw-bold"><?= $total ?></div></div></div>
    <div class="col-6 col-lg-3"><div class="formulario h-100"><div class="text-secondary">Personas que trabajan</div><div class="display-5 fw-bold text-success"><?= $trabajan ?></div><small class="text-secondary"><?= $total ? round($trabajan * 100 / $total, 1) : 0 ?>% del total</small></div></div>
    <div class="col-6 col-lg-3"><div class="formulario h-100"><div class="text-secondary">No trabajan</div><div class="display-5 fw-bold"><?= $noTrabajan ?></div><small class="text-secondary"><?= $total ? round($noTrabajan * 100 / $total, 1) : 0 ?>% del total</small></div></div>
    <div class="col-6 col-lg-3"><div class="formulario h-100"><div class="text-secondary">Sin personas a cargo</div><div class="display-5 fw-bold"><?= $sinPersonasACargo ?></div><small class="text-secondary"><?= $total ? round($sinPersonasACargo * 100 / $total, 1) : 0 ?>% del total</small></div></div>
    <div class="col-6 col-lg-3"><div class="formulario h-100"><div class="text-secondary">Reciben ayuda social</div><div class="display-5 fw-bold"><?= $recibenAyuda ?></div><small class="text-secondary"><?= $total ? round($recibenAyuda * 100 / $total, 1) : 0 ?>% del total</small></div></div>
    <div class="col-6 col-lg-3"><div class="formulario h-100"><div class="text-secondary">No reciben ayuda social</div><div class="display-5 fw-bold"><?= $noRecibenAyuda ?></div><small class="text-secondary"><?= $total ? round($noRecibenAyuda * 100 / $total, 1) : 0 ?>% del total</small></div></div>
    <div class="col-6 col-lg-3"><div class="formulario h-100"><div class="text-secondary">Interrumpieron sus estudios</div><div class="display-5 fw-bold"><?= $interrumpieron ?></div><small class="text-secondary"><?= $total ? round($interrumpieron * 100 / $total, 1) : 0 ?>% del total</small></div></div>
  </div>

  <div class="alert alert-info">
    <strong>Importante:</strong> la encuesta no pregunta directamente si el estudiante tiene hijos. Pregunta cuántas personas tiene a su cargo. Por eso, la tarjeta indica “Sin personas a cargo” (respuesta 0), que no necesariamente significa “sin hijos”. La opción de convivencia también se muestra abajo por separado.
  </div>

  <div class="formulario mb-4">
    <h2 class="h5 mb-3">Situación laboral</h2>
    <?php if ($total > 0): ?><div style="max-width: 850px; margin:auto"><canvas id="graficoLaboral"></canvas></div>
    <?php else: ?><p class="text-secondary mb-0">Todavía no hay respuestas para mostrar.</p><?php endif; ?>
  </div>

  <?php foreach ($secciones as $titulo => $campos): ?>
    <section class="formulario mb-4">
      <h2 class="h5 mb-3"><?= h($titulo) ?></h2>
      <div class="row g-4">
        <?php foreach ($campos as $campo => $etiqueta): $distribucion = obtenerDistribucion($pdo, $campo); ?>
          <div class="col-12 col-lg-6">
            <h3 class="h6"><?= h($etiqueta) ?></h3>
            <?php if (!$distribucion): ?><p class="text-secondary small">Sin respuestas.</p>
            <?php else: ?><div class="table-responsive"><table class="table table-sm align-middle mb-0"><thead><tr><th>Respuesta</th><th class="text-end">Cantidad</th><th class="text-end">Porcentaje</th></tr></thead><tbody>
              <?php foreach ($distribucion as $fila): $cantidad = (int)$fila['cantidad']; ?>
                <tr><td><?= nl2br(h($fila['respuesta'])) ?></td><td class="text-end fw-semibold"><?= $cantidad ?></td><td class="text-end"><?= $total ? round($cantidad * 100 / $total, 1) : 0 ?>%</td></tr>
              <?php endforeach; ?>
            </tbody></table></div><?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  <?php endforeach; ?>
</div>
<?php if ($total > 0): ?>
<script>
const etiquetasLaborales = <?= json_encode($labelsLaborales, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;
const valoresLaborales = <?= json_encode($valoresLaborales) ?>;
new Chart(document.getElementById('graficoLaboral'), {
  type: 'bar',
  data: { labels: etiquetasLaborales, datasets: [{ label: 'Cantidad de estudiantes', data: valoresLaborales }] },
  options: { indexAxis: 'y', responsive: true, plugins: { legend: { display: false } }, scales: { x: { beginAtZero: true, ticks: { precision: 0 } } } }
});
</script>
<?php endif; ?>
</body></html>

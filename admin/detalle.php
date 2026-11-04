<?php
require_once __DIR__ . '/proteger.php';
require_once __DIR__ . '/../config/conexion.php';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) { http_response_code(400); exit('Identificador inválido.'); }
$stmt = $pdo->prepare('SELECT * FROM respuestas WHERE id = ?');
$stmt->execute([$id]);
$respuesta = $stmt->fetch();
if (!$respuesta) { http_response_code(404); exit('No se encontró la respuesta.'); }
$etiquetas = [
'institucion'=>'Institución','edad'=>'Edad','genero'=>'Género','departamento'=>'Departamento',
'convivencia'=>'¿Con quiénes vive?','personas_cargo'=>'Personas a su cargo','distancia'=>'Distancia a la institución',
'transporte'=>'Medio de transporte','situacion_laboral'=>'Situación laboral','relacion_laboral'=>'Relación laboral',
'ayuda_social'=>'Ayuda social','trayectoria_previa'=>'Trayectoria académica previa','interrupcion'=>'Interrupción de trayectoria',
'impacto_laboral'=>'Impacto laboral','impacto_familiar'=>'Impacto familiar','asistencia'=>'Porcentaje de asistencia',
'factor_inasistencia'=>'Factor que impide asistir','puntualidad'=>'Llegadas tarde / retiros anticipados',
'dispositivo'=>'Dispositivo más utilizado','propiedad_dispositivo'=>'Propiedad del dispositivo',
'conexion_internet'=>'Conexión a internet','fecha_registro'=>'Fecha de registro'
];
function h($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Detalle de respuesta</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../css/estilos.css" rel="stylesheet"></head><body>
<div class="container py-4" style="max-width:900px">
  <div class="d-flex justify-content-between align-items-center mb-3"><h1 class="h3">Detalle de encuesta #<?= (int)$id ?></h1><a href="respuestas.php" class="btn btn-outline-secondary">Volver</a></div>
  <div class="formulario">
    <?php foreach ($etiquetas as $campo=>$etiqueta): ?>
      <div class="row py-2 border-bottom"><div class="col-md-5 fw-semibold"><?= h($etiqueta) ?></div><div class="col-md-7"><?= nl2br(h($respuesta[$campo])) ?></div></div>
    <?php endforeach; ?>
  </div>
</div></body></html>

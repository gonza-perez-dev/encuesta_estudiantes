<?php
require_once __DIR__ . '/proteger.php';
require_once __DIR__ . '/../config/conexion.php';
$columnas = [
'id'=>'ID','institucion'=>'Institución','edad'=>'Edad','genero'=>'Género',
'departamento'=>'Departamento','convivencia'=>'Con quiénes vive',
'personas_cargo'=>'Personas a su cargo','distancia'=>'Distancia a la institución',
'transporte'=>'Medio de transporte','situacion_laboral'=>'Situación laboral',
'relacion_laboral'=>'Relación laboral','ayuda_social'=>'Ayuda social',
'trayectoria_previa'=>'Trayectoria académica previa','interrupcion'=>'Interrupción de trayectoria',
'impacto_laboral'=>'Impacto laboral','impacto_familiar'=>'Impacto familiar',
'asistencia'=>'Porcentaje de asistencia','factor_inasistencia'=>'Factor que impide asistir',
'puntualidad'=>'Llegadas tarde o retiros anticipados','dispositivo'=>'Dispositivo más utilizado',
'propiedad_dispositivo'=>'Propiedad del dispositivo','conexion_internet'=>'Conexión a internet',
'fecha_registro'=>'Fecha de registro'
];
header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="respuestas_encuesta_' . date('Y-m-d_H-i') . '.csv"');
header('Pragma: no-cache');
header('Expires: 0');
$salida = fopen('php://output', 'w');
fprintf($salida, chr(0xEF).chr(0xBB).chr(0xBF));
fputcsv($salida, array_values($columnas), ';');
$stmt = $pdo->query('SELECT ' . implode(', ', array_keys($columnas)) . ' FROM respuestas ORDER BY id ASC');
while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $linea = [];
    foreach (array_keys($columnas) as $campo) {
        $valor = (string)($fila[$campo] ?? '');
        if ($valor !== '' && in_array($valor[0], ['=', '+', '-', '@'], true)) {
            $valor = "'" . $valor;
        }
        $linea[] = $valor;
    }
    fputcsv($salida, $linea, ';');
}
fclose($salida);
exit;

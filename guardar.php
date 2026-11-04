
<?php
session_start();
require_once __DIR__ . '/config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

if (
    !isset($_POST['csrf_token'], $_SESSION['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
) {
    exit('La sesión del formulario venció. Volvé a cargar la encuesta e intentá nuevamente.');
}

$campos = [
    'email',
    'institucion',
    'carrera',
    'edad',
    'genero',
    'departamento',
    'convivencia',
    'personas_cargo',
    'distancia',
    'transporte',
    'situacion_laboral',
    'relacion_laboral',
    'ayuda_social',
    'trayectoria_previa',
    'interrupcion',
    'impacto_laboral',
    'impacto_familiar',
    'asistencia',
    'factor_inasistencia',
    'puntualidad',
    'dispositivo',
    'propiedad_dispositivo',
    'conexion_internet'
];

$datos = [];

foreach ($campos as $campo) {

    $valor = trim($_POST[$campo] ?? '');

    if ($valor === '') {
        exit('Falta completar el campo: ' . htmlspecialchars($campo));
    }

    $datos[$campo] = $valor;
}

if (!filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
    exit('El correo electrónico ingresado no es válido.');
}

$columnas = implode(', ', $campos);
$marcadores = ':' . implode(', :', $campos);

$sql = "INSERT INTO respuestas ($columnas) VALUES ($marcadores)";

try {

    $stmt = $pdo->prepare($sql);
    $stmt->execute($datos);

    unset($_SESSION['csrf_token']);

    $_SESSION['mensaje_exito'] = '¡Muchas gracias! Tu encuesta fue enviada correctamente.';

    header('Location: index.php');
    exit;

} catch (PDOException $e) {

    exit('No se pudo guardar la encuesta. Verificá la conexión y la estructura de la base de datos.');

}

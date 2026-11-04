<?php
$host = 'localhost';
$db   = 'encuesta_estudiantes';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    exit('No se pudo conectar con la base de datos. Revisá config/conexion.php y que MySQL esté iniciado. Detalle: ' . htmlspecialchars($e->getMessage()));
}

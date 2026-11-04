CREATE DATABASE IF NOT EXISTS encuesta_estudiantes
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE encuesta_estudiantes;

CREATE TABLE IF NOT EXISTS respuestas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    institucion VARCHAR(150) NOT NULL,
    edad VARCHAR(20) NOT NULL,
    genero VARCHAR(30) NOT NULL,
    departamento VARCHAR(50) NOT NULL,
    convivencia VARCHAR(100) NOT NULL,
    personas_cargo VARCHAR(20) NOT NULL,
    distancia VARCHAR(50) NOT NULL,
    transporte VARCHAR(100) NOT NULL,
    situacion_laboral VARCHAR(100) NOT NULL,
    relacion_laboral VARCHAR(100) NOT NULL,
    ayuda_social VARCHAR(10) NOT NULL,
    trayectoria_previa TEXT NOT NULL,
    interrupcion VARCHAR(30) NOT NULL,
    impacto_laboral VARCHAR(30) NOT NULL,
    impacto_familiar VARCHAR(30) NOT NULL,
    asistencia VARCHAR(30) NOT NULL,
    factor_inasistencia VARCHAR(200) NOT NULL,
    puntualidad VARCHAR(30) NOT NULL,
    dispositivo VARCHAR(50) NOT NULL,
    propiedad_dispositivo VARCHAR(30) NOT NULL,
    conexion_internet VARCHAR(50) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS administradores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

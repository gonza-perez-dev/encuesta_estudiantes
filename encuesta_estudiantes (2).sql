-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-11-2026 a las 02:00:28
-- Versión del servidor: 10.11.16-MariaDB
-- Versión de PHP: 8.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `encuesta_estudiantes`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`id`, `usuario`, `password`) VALUES
(1, 'admin', '$2y$12$gAUPLRMcYvufd8dQ8cziCuRS0BZgcijBzYyWD/2giV.pvSzzI6EFy');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas`
--

CREATE TABLE `respuestas` (
  `id` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `institucion` varchar(150) NOT NULL,
  `carrera` varchar(150) NOT NULL,
  `edad` varchar(20) NOT NULL,
  `genero` varchar(30) NOT NULL,
  `departamento` varchar(50) NOT NULL,
  `convivencia` varchar(100) NOT NULL,
  `personas_cargo` varchar(20) NOT NULL,
  `distancia` varchar(50) NOT NULL,
  `transporte` varchar(100) NOT NULL,
  `situacion_laboral` varchar(100) NOT NULL,
  `relacion_laboral` varchar(100) NOT NULL,
  `ayuda_social` varchar(10) NOT NULL,
  `trayectoria_previa` text NOT NULL,
  `interrupcion` varchar(30) NOT NULL,
  `impacto_laboral` varchar(30) NOT NULL,
  `impacto_familiar` varchar(30) NOT NULL,
  `asistencia` varchar(30) NOT NULL,
  `factor_inasistencia` varchar(200) NOT NULL,
  `puntualidad` varchar(30) NOT NULL,
  `dispositivo` varchar(50) NOT NULL,
  `propiedad_dispositivo` varchar(30) NOT NULL,
  `conexion_internet` varchar(50) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indices de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administradores`
--
ALTER TABLE `administradores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

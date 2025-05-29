-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-05-2025 a las 19:55:20
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema_reservas_medicas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `medico_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `motivo` text DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `estado` enum('programada','confirmada','cancelada','completada') DEFAULT 'programada',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidades`
--

CREATE TABLE `especialidades` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `especialidades`
--

INSERT INTO `especialidades` (`id`, `nombre`, `descripcion`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Medicina General', 'Atenci?n m?dica general y preventiva', 'activo', '2025-05-28 15:26:20', '2025-05-28 15:26:20'),
(2, 'Cardiolog?a', 'Especialidad en enfermedades del coraz?n', 'activo', '2025-05-28 15:26:20', '2025-05-28 15:26:20'),
(3, 'Dermatolog?a', 'Especialidad en enfermedades de la piel', 'activo', '2025-05-28 15:26:20', '2025-05-28 15:26:20'),
(4, 'Pediatr?a', 'Atenci?n m?dica para ni?os y adolescentes', 'activo', '2025-05-28 15:26:20', '2025-05-28 15:26:20'),
(5, 'Ginecolog?a', 'Especialidad en salud femenina', 'activo', '2025-05-28 15:26:20', '2025-05-28 15:26:20'),
(6, 'Medicina General', 'Atenci?n m?dica general y preventiva', 'activo', '2025-05-28 16:19:38', '2025-05-28 16:19:38'),
(7, 'Cardiolog?a', 'Especialidad en enfermedades del coraz?n', 'activo', '2025-05-28 16:19:38', '2025-05-28 16:19:38'),
(8, 'Dermatolog?a', 'Especialidad en enfermedades de la piel', 'activo', '2025-05-28 16:19:38', '2025-05-28 16:19:38'),
(9, 'Pediatr?a', 'Atenci?n m?dica para ni?os y adolescentes', 'activo', '2025-05-28 16:19:38', '2025-05-28 16:19:38'),
(10, 'Ginecolog?a', 'Especialidad en salud femenina', 'activo', '2025-05-28 16:19:38', '2025-05-28 16:19:38'),
(11, 'Medicina General', 'Atenci?n m?dica general y preventiva', 'activo', '2025-05-28 17:38:43', '2025-05-28 17:38:43'),
(12, 'Cardiolog?a', 'Especialidad en enfermedades del coraz?n', 'activo', '2025-05-28 17:38:43', '2025-05-28 17:38:43'),
(13, 'Dermatolog?a', 'Especialidad en enfermedades de la piel', 'activo', '2025-05-28 17:38:43', '2025-05-28 17:38:43'),
(14, 'Pediatr?a', 'Atenci?n m?dica para ni?os y adolescentes', 'activo', '2025-05-28 17:38:43', '2025-05-28 17:38:43'),
(15, 'Ginecolog?a', 'Especialidad en salud femenina', 'activo', '2025-05-28 17:38:43', '2025-05-28 17:38:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicos`
--

CREATE TABLE `medicos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `especialidad_id` int(11) DEFAULT NULL,
  `numero_licencia` varchar(50) DEFAULT NULL,
  `horario_inicio` time DEFAULT '08:00:00',
  `horario_fin` time DEFAULT '17:00:00',
  `dias_trabajo` set('lunes','martes','miercoles','jueves','viernes','sabado','domingo') DEFAULT 'lunes,martes,miercoles,jueves,viernes',
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `medicos`
--

INSERT INTO `medicos` (`id`, `nombre`, `apellido`, `email`, `telefono`, `especialidad_id`, `numero_licencia`, `horario_inicio`, `horario_fin`, `dias_trabajo`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Dr. Carlos', 'Rodr?guez', 'carlos.rodriguez@clinica.com', '555-0101', 1, 'MED001', '08:00:00', '17:00:00', 'lunes,martes,miercoles,jueves,viernes', 'activo', '2025-05-28 15:26:20', '2025-05-28 15:26:20'),
(2, 'Dra. Ana', 'Mart?nez', 'ana.martinez@clinica.com', '555-0102', 2, 'MED002', '08:00:00', '17:00:00', 'lunes,martes,miercoles,jueves,viernes', 'activo', '2025-05-28 15:26:20', '2025-05-28 15:26:20'),
(3, 'Dr. Luis', 'Garc?a', 'luis.garcia@clinica.com', '555-0103', 3, 'MED003', '08:00:00', '17:00:00', 'lunes,martes,miercoles,jueves,viernes', 'activo', '2025-05-28 15:26:20', '2025-05-28 15:26:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('paciente','administrador') DEFAULT 'paciente',
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `email`, `telefono`, `fecha_nacimiento`, `direccion`, `password`, `rol`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'Sistema', 'admin@sistema.com', NULL, NULL, NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'administrador', 'activo', '2025-05-28 15:26:20', '2025-05-28 15:26:20'),
(2, 'Juan', 'P?rez', 'juan.perez@email.com', NULL, NULL, NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'paciente', 'activo', '2025-05-28 15:26:20', '2025-05-28 15:26:20'),
(3, 'Mar?a', 'Gonz?lez', 'maria.gonzalez@email.com', NULL, NULL, NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'paciente', 'activo', '2025-05-28 15:26:20', '2025-05-28 15:26:20');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_cita` (`medico_id`,`fecha`,`hora`),
  ADD KEY `paciente_id` (`paciente_id`);

--
-- Indices de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `medicos`
--
ALTER TABLE `medicos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `numero_licencia` (`numero_licencia`),
  ADD KEY `especialidad_id` (`especialidad_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `medicos`
--
ALTER TABLE `medicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `citas_ibfk_2` FOREIGN KEY (`medico_id`) REFERENCES `medicos` (`id`);

--
-- Filtros para la tabla `medicos`
--
ALTER TABLE `medicos`
  ADD CONSTRAINT `medicos_ibfk_1` FOREIGN KEY (`especialidad_id`) REFERENCES `especialidades` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

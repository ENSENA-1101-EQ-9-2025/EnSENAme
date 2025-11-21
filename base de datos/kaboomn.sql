-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 21-11-2025 a las 14:28:06
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
-- Base de datos: `kaboom`
--

-- --------------------------------------------------------

-- --------------------------------------------------------

-- Estructura de tabla para la tabla `tb_models`

CREATE TABLE `tb_models` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `model_json` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcado de datos para la tabla `tb_models`

INSERT INTO `tb_models` (`id`, `name`, `model_json`, `created_at`) VALUES
(1, 'modelo_default', '{"classNames": [], "examples": {}}', current_timestamp());


--
-- Estructura de tabla para la tabla `tbl_rol`
--

CREATE TABLE `tbl_rol` (
  `id` int(11) NOT NULL,
  `nombre_rol` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tbl_rol`
--

INSERT INTO `tbl_rol` (`id`, `nombre_rol`) VALUES
(1, 'administrador'),
(2, 'usuario'),
(3, 'asesor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_chatbot_logs`
--

CREATE TABLE `tb_chatbot_logs` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `mensaje_usuario` text NOT NULL,
  `respuesta_bot` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `tipo_respuesta` varchar(50) DEFAULT 'info',
  `origen` varchar(20) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tb_chatbot_logs`
--

INSERT INTO `tb_chatbot_logs` (`id`, `usuario_id`, `mensaje_usuario`, `respuesta_bot`, `timestamp`, `tipo_respuesta`, `origen`) VALUES
(1, 123456789, '¿Qué es LSC?', 'La Lengua de Señas Colombiana (LSC) es la lengua natural de las personas sordas en Colombia...', '2025-10-24 00:50:25', 'info', 'user'),
(2, 123456789, '¿Cómo puedo aprender señas?', 'Puedes comenzar aprendiendo el alfabeto dactilológico y palabras básicas...', '2025-10-24 00:50:25', 'educativo', 'user'),
(3, 1015189816, 'Estadísticas del sistema', 'Consulta administrativa sobre métricas del chatbot', '2025-10-24 00:50:25', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_mensajes`
--

CREATE TABLE `tb_mensajes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `mensaje` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `tipo` enum('usuario','admin') DEFAULT 'usuario',
  `leido` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_usuarios`
--

CREATE TABLE `tb_usuarios` (
  `ID` int(11) NOT NULL,
  `Tipo_Documento` int(1) NOT NULL,
  `p_nombre` tinytext NOT NULL,
  `s_nombre` tinytext NOT NULL,
  `p_apellido` tinytext NOT NULL,
  `s_apellido` tinytext NOT NULL,
  `Clave` varchar(101) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `needs_pw_change` tinyint(1) DEFAULT 0,
  `foto_perfil` varchar(255) DEFAULT NULL COMMENT 'Ruta del archivo de imagen de perfil del usuario',
  `telefono` varchar(20) DEFAULT NULL COMMENT 'Número de teléfono del usuario',
  `region` varchar(100) DEFAULT NULL COMMENT 'Región geográfica del usuario (Bogotá, Medellín, Cali, etc.)',
  `condicion` varchar(100) DEFAULT NULL COMMENT 'Condición auditiva del usuario (sordo, hipoacúsico, oyente, etc.)',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Fecha y hora de registro del usuario',
  `ultima_conexion` timestamp NULL DEFAULT NULL COMMENT 'Fecha y hora de la última conexión del usuario',
  `estado` enum('activo','inactivo','suspendido') DEFAULT 'activo' COMMENT 'Estado del usuario en el sistema'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tb_usuarios`
--

INSERT INTO `tb_usuarios` (`ID`, `Tipo_Documento`, `p_nombre`, `s_nombre`, `p_apellido`, `s_apellido`, `Clave`, `id_rol`, `needs_pw_change`, `foto_perfil`, `telefono`, `region`, `condicion`, `fecha_registro`, `ultima_conexion`, `estado`) VALUES
(1015189816, 1, 'Jeremy', '', 'Chica', 'Tapasco', '$2y$10$DiWyHXNCm3ueEq/PBCxdj.sfxPda2fGSyqoaZDDtlSAZhHtUDphbC', 1, 0, NULL, NULL, NULL, NULL, '2025-11-21 12:16:52', NULL, 'activo'),
(1017136002, 1, 'Ana', 'Milena', 'Chica', 'Tapasco', '$2y$10$UO2ZOXexXzq05hYEQZU92..KWHBEXxqQ3BPLEfs72x45ltnkTzQyK', 2, 0, NULL, NULL, NULL, NULL, '2025-11-21 12:19:37', NULL, 'activo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_rol`
--
ALTER TABLE `tbl_rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tb_chatbot_logs`
--
ALTER TABLE `tb_chatbot_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `timestamp` (`timestamp`),
  ADD KEY `tipo_respuesta` (`tipo_respuesta`),
  ADD KEY `origen` (`origen`);

--
-- Indices de la tabla `tb_mensajes`
--
ALTER TABLE `tb_mensajes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `timestamp` (`timestamp`),
  ADD KEY `tipo` (`tipo`);

--
-- Indices de la tabla `tb_usuarios`
--
ALTER TABLE `tb_usuarios`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tb_chatbot_logs`
--
ALTER TABLE `tb_chatbot_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tb_mensajes`
--
ALTER TABLE `tb_mensajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tb_mensajes`
--
ALTER TABLE `tb_mensajes`
  ADD CONSTRAINT `tb_mensajes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `tb_usuarios` (`ID`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tb_usuarios`
--
ALTER TABLE `tb_usuarios`
  ADD CONSTRAINT `tb_usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `tbl_rol` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

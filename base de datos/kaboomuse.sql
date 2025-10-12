-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-10-2025 a las 01:29:11
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
(2, 'operador'),
(3, 'asesor');

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
  `needs_pw_change` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tb_usuarios`
--

INSERT INTO `tb_usuarios` (`ID`, `Tipo_Documento`, `p_nombre`, `s_nombre`, `p_apellido`, `s_apellido`, `Clave`, `id_rol`, `needs_pw_change`) VALUES
(123456789, 2, 'Morita', 'Moringa', 'Chica ', 'Tapasco', '827ccb0eea8a706c4c34a16891f84e7b', 1, 0),
(1015189816, 1, 'Jeremy', '', 'Chica', 'Tapasco', '$argon2id$v=19$m=65536,t=4,p=1$cHo4MVlWa29ISmcucjNybw$MY/7v8lA+2zVzpGWR0FTm/dGKa4Ia83p0xgUswM4WXo', 1, 1),
(1015196766, 1, 'Jacob', 'rafael', 'Rojas', 'Chica', '$2y$10$yB21eoCgcAWmZFTaPbDZ.OD9gUk8KwKzncInlLq0/1oVcnNcuEc6e', 2, 0),
(1017136002, 2, 'Ana', 'Milena', 'Chica', 'Tapasco', '827ccb0eea8a706c4c34a16891f84e7b', 2, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_rol`
--
ALTER TABLE `tbl_rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tb_usuarios`
--
ALTER TABLE `tb_usuarios`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tb_usuarios`
--
ALTER TABLE `tb_usuarios`
  ADD CONSTRAINT `tb_usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `tbl_rol` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

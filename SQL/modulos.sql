-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-06-2022 a las 18:30:28
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `style_stylecollection`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos`
--

CREATE TABLE `modulos` (
  `id_modulo` bigint(20) UNSIGNED NOT NULL,
  `nombre_modulo` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estatus` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `modulos`
--

INSERT INTO `modulos` (`id_modulo`, `nombre_modulo`, `estatus`) VALUES
(1, 'Clientes', 1),
(2, 'Campañas', 1),
(3, 'Despachos', 1),
(4, 'Liderazgos', 1),
(5, 'Liderazgos De Campaña', 1),
(6, 'Productos', 1),
(7, 'Fragancias', 1),
(8, 'Planes', 1),
(9, 'Planes De Campaña', 1),
(10, 'Premios', 1),
(11, 'Premios De Campaña', 1),
(12, 'Movimientos Bancarios', 1),
(13, 'Bancos', 1),
(14, 'Tasas', 1),
(15, 'Usuarios', 1),
(16, 'Reportes', 1),
(17, 'Bitácora', 1),
(18, 'Roles', 1),
(19, 'Modulos', 1),
(20, 'Permisos', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`id_modulo`),
  ADD UNIQUE KEY `id_modulo` (`id_modulo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `modulos`
--
ALTER TABLE `modulos`
  MODIFY `id_modulo` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

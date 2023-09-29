-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-01-2023 a las 03:55:11
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
-- Base de datos: `stylecollection_stylecollection`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos_despachos`
--

CREATE TABLE `pagos_despachos` (
  `id_pago_despacho` bigint(20) UNSIGNED NOT NULL,
  `id_despacho` int(11) DEFAULT NULL,
  `tipo_pago_despacho` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_pago_despacho` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_pago_despacho_senior` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pago_precio_coleccion` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `asignacion_pago_despacho` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estatus` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pagos_despachos`
--

INSERT INTO `pagos_despachos` (`id_pago_despacho`, `id_despacho`, `tipo_pago_despacho`, `fecha_pago_despacho`, `fecha_pago_despacho_senior`, `pago_precio_coleccion`, `asignacion_pago_despacho`, `estatus`) VALUES
(1, 1, 'Inicial', '2022-01-25', '2022-01-27', '10', '', 1),
(2, 1, 'Primer Pago', '2022-02-01', '2022-02-03', '45', 'seleccion_premios', 1),
(3, 1, 'Segundo Pago', '2022-02-15', '2022-02-17', '44', '', 1),
(4, 2, 'Inicial', '2022-04-06', '2022-04-11', '10', '', 1),
(5, 2, 'Primer Pago', '2022-04-13', '2022-04-22', '48', 'seleccion_premios', 1),
(6, 2, 'Segundo Pago', '2022-04-27', '2022-05-03', '47', '', 1),
(7, 3, 'Inicial', '2022-06-21', '2022-06-15', '10', '', 1),
(8, 3, 'Primer Pago', '2022-06-28', '2022-07-06', '48', 'seleccion_premios', 1),
(9, 3, 'Segundo Pago', '2022-07-18', '2022-07-20', '46', '', 1),
(10, 4, 'Inicial', '2022-09-16', '2022-09-16', '10', '', 1),
(11, 4, 'Primer Pago', '2022-09-23', '2022-09-30', '52', 'seleccion_premios', 1),
(12, 4, 'Segundo Pago', '2022-10-07', '2022-10-14', '47', '', 1),
(13, 5, 'Inicial', '2022-09-16', '2022-09-16', '10', '', 1),
(14, 5, 'Primer Pago', '2022-09-23', '2022-09-30', '62', 'seleccion_premios', 1),
(15, 5, 'Segundo Pago', '2022-10-07', '2022-10-14', '60', '', 1),
(16, 6, 'Inicial', '2022-11-22', '2022-12-06', '20', '', 1),
(17, 6, 'Primer Pago', '2022-12-15', '2022-12-15', '57.5', 'seleccion_premios', 1),
(18, 6, 'Segundo Pago', '2022-12-15', '2022-12-15', '30.5', '', 1),
(19, 7, 'Inicial', '2022-11-15', '2022-11-18', '20', '', 1),
(20, 7, 'Primer Pago', '2022-11-29', '2022-12-01', '68', 'seleccion_premios', 1),
(21, 7, 'Segundo Pago', '2022-11-29', '2022-12-01', '53', '', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `pagos_despachos`
--
ALTER TABLE `pagos_despachos`
  ADD PRIMARY KEY (`id_pago_despacho`),
  ADD UNIQUE KEY `id_pago_despacho` (`id_pago_despacho`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pagos_despachos`
--
ALTER TABLE `pagos_despachos`
  MODIFY `id_pago_despacho` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

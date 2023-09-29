-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-01-2023 a las 22:27:46
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
-- Estructura de tabla para la tabla `pagos_planes_campana`
--

CREATE TABLE `pagos_planes_campana` (
  `id_pago_plan_campana` bigint(20) UNSIGNED NOT NULL,
  `id_plan_campana` int(11) DEFAULT NULL,
  `id_campana` int(11) DEFAULT NULL,
  `id_despacho` int(11) DEFAULT NULL,
  `tipo_pago_plan_campana` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descuento_pago_plan_campana` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estatus` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pagos_planes_campana`
--

INSERT INTO `pagos_planes_campana` (`id_pago_plan_campana`, `id_plan_campana`, `id_campana`, `id_despacho`, `tipo_pago_plan_campana`, `descuento_pago_plan_campana`, `estatus`) VALUES
(1, 1, 1, 1, 'Primer Pago', '5', 1),
(2, 1, 1, 1, 'Segundo Pago', '5', 1),
(3, 2, 1, 1, 'Primer Pago', '0', 1),
(4, 2, 1, 1, 'Segundo Pago', '0', 1),
(5, 3, 1, 1, 'Primer Pago', '0', 1),
(6, 3, 1, 1, 'Segundo Pago', '0', 1),
(7, 7, 1, 1, 'Primer Pago', '0', 1),
(8, 7, 1, 1, 'Segundo Pago', '0', 1),
(9, 8, 1, 1, 'Primer Pago', '0', 1),
(10, 8, 1, 1, 'Segundo Pago', '0', 1),
(11, 9, 1, 1, 'Primer Pago', '0', 1),
(12, 9, 1, 1, 'Segundo Pago', '0', 1),
(13, 10, 1, 1, 'Primer Pago', '0', 1),
(14, 10, 1, 1, 'Segundo Pago', '0', 1),
(15, 11, 1, 1, 'Primer Pago', '0', 1),
(16, 11, 1, 1, 'Segundo Pago', '0', 1),
(17, 12, 1, 1, 'Primer Pago', '0', 1),
(18, 12, 1, 1, 'Segundo Pago', '0', 1),
(19, 13, 2, 2, 'Primer Pago', '5', 1),
(20, 13, 2, 2, 'Segundo Pago', '5', 1),
(21, 14, 2, 2, 'Primer Pago', '0', 1),
(22, 14, 2, 2, 'Segundo Pago', '0', 1),
(23, 15, 2, 2, 'Primer Pago', '0', 1),
(24, 15, 2, 2, 'Segundo Pago', '0', 1),
(25, 16, 2, 2, 'Primer Pago', '0', 1),
(26, 16, 2, 2, 'Segundo Pago', '0', 1),
(27, 17, 2, 2, 'Primer Pago', '0', 1),
(28, 17, 2, 2, 'Segundo Pago', '0', 1),
(29, 18, 2, 2, 'Primer Pago', '0', 1),
(30, 18, 2, 2, 'Segundo Pago', '0', 1),
(31, 19, 2, 2, 'Primer Pago', '0', 1),
(32, 19, 2, 2, 'Segundo Pago', '0', 1),
(33, 20, 2, 2, 'Primer Pago', '0', 1),
(34, 20, 2, 2, 'Segundo Pago', '0', 1),
(35, 21, 2, 2, 'Primer Pago', '0', 1),
(36, 21, 2, 2, 'Segundo Pago', '0', 1),
(37, 22, 2, 2, 'Primer Pago', '0', 1),
(38, 22, 2, 2, 'Segundo Pago', '0', 1),
(39, 23, 2, 2, 'Primer Pago', '0', 1),
(40, 23, 2, 2, 'Segundo Pago', '0', 1),
(41, 24, 2, 2, 'Primer Pago', '0', 1),
(42, 24, 2, 2, 'Segundo Pago', '0', 1),
(43, 25, 3, 3, 'Primer Pago', '5', 1),
(44, 25, 3, 3, 'Segundo Pago', '5', 1),
(45, 26, 3, 3, 'Primer Pago', '0', 1),
(46, 26, 3, 3, 'Segundo Pago', '0', 1),
(47, 27, 3, 3, 'Primer Pago', '0', 1),
(48, 27, 3, 3, 'Segundo Pago', '0', 1),
(49, 28, 3, 3, 'Primer Pago', '0', 1),
(50, 28, 3, 3, 'Segundo Pago', '0', 1),
(51, 29, 3, 3, 'Primer Pago', '0', 1),
(52, 29, 3, 3, 'Segundo Pago', '0', 1),
(53, 30, 3, 3, 'Primer Pago', '0', 1),
(54, 30, 3, 3, 'Segundo Pago', '0', 1),
(55, 31, 3, 3, 'Primer Pago', '0', 1),
(56, 31, 3, 3, 'Segundo Pago', '0', 1),
(57, 32, 3, 3, 'Primer Pago', '0', 1),
(58, 32, 3, 3, 'Segundo Pago', '0', 1),
(59, 33, 4, 4, 'Primer Pago', '5', 1),
(60, 33, 4, 4, 'Segundo Pago', '5', 1),
(61, 34, 4, 4, 'Primer Pago', '0', 1),
(62, 34, 4, 4, 'Segundo Pago', '0', 1),
(63, 35, 4, 4, 'Primer Pago', '0', 1),
(64, 35, 4, 4, 'Segundo Pago', '0', 1),
(65, 36, 4, 4, 'Primer Pago', '0', 1),
(66, 36, 4, 4, 'Segundo Pago', '0', 1),
(67, 37, 4, 4, 'Primer Pago', '0', 1),
(68, 37, 4, 4, 'Segundo Pago', '0', 1),
(69, 38, 4, 4, 'Primer Pago', '0', 1),
(70, 38, 4, 4, 'Segundo Pago', '0', 1),
(71, 39, 4, 4, 'Primer Pago', '0', 1),
(72, 39, 4, 4, 'Segundo Pago', '0', 1),
(73, 40, 4, 4, 'Primer Pago', '0', 1),
(74, 40, 4, 4, 'Segundo Pago', '0', 1),
(75, 47, 4, 4, 'Primer Pago', '0', 1),
(76, 47, 4, 4, 'Segundo Pago', '0', 1),
(77, 48, 4, 4, 'Primer Pago', '0', 1),
(78, 48, 4, 4, 'Segundo Pago', '0', 1),
(79, 49, 4, 4, 'Primer Pago', '0', 1),
(80, 49, 4, 4, 'Segundo Pago', '0', 1),
(81, 50, 4, 4, 'Primer Pago', '0', 1),
(82, 50, 4, 4, 'Segundo Pago', '0', 1),
(83, 51, 4, 4, 'Primer Pago', '0', 1),
(84, 51, 4, 4, 'Segundo Pago', '0', 1),
(85, 52, 4, 4, 'Primer Pago', '0', 1),
(86, 52, 4, 4, 'Segundo Pago', '0', 1),
(87, 53, 4, 4, 'Primer Pago', '0', 1),
(88, 53, 4, 4, 'Segundo Pago', '0', 1),
(89, 54, 4, 4, 'Primer Pago', '0', 1),
(90, 54, 4, 4, 'Segundo Pago', '0', 1),
(91, 55, 4, 4, 'Primer Pago', '0', 1),
(92, 55, 4, 4, 'Segundo Pago', '0', 1),
(93, 56, 4, 4, 'Primer Pago', '0', 1),
(94, 56, 4, 4, 'Segundo Pago', '0', 1),
(95, 57, 4, 4, 'Primer Pago', '0', 1),
(96, 57, 4, 4, 'Segundo Pago', '0', 1),
(97, 58, 4, 4, 'Primer Pago', '0', 1),
(98, 58, 4, 4, 'Segundo Pago', '0', 1),
(99, 81, 4, 4, 'Primer Pago', '0', 1),
(100, 81, 4, 4, 'Segundo Pago', '0', 1),
(101, 59, 4, 5, 'Primer Pago', '6', 1),
(102, 59, 4, 5, 'Segundo Pago', '5', 1),
(103, 60, 4, 5, 'Primer Pago', '0', 1),
(104, 60, 4, 5, 'Segundo Pago', '0', 1),
(105, 61, 4, 5, 'Primer Pago', '0', 1),
(106, 61, 4, 5, 'Segundo Pago', '0', 1),
(107, 62, 4, 5, 'Primer Pago', '0', 1),
(108, 62, 4, 5, 'Segundo Pago', '0', 1),
(109, 63, 4, 5, 'Primer Pago', '0', 1),
(110, 63, 4, 5, 'Segundo Pago', '0', 1),
(111, 64, 4, 5, 'Primer Pago', '0', 1),
(112, 64, 4, 5, 'Segundo Pago', '0', 1),
(113, 65, 4, 5, 'Primer Pago', '0', 1),
(114, 65, 4, 5, 'Segundo Pago', '0', 1),
(115, 66, 4, 5, 'Primer Pago', '0', 1),
(116, 66, 4, 5, 'Segundo Pago', '0', 1),
(117, 67, 4, 5, 'Primer Pago', '0', 1),
(118, 67, 4, 5, 'Segundo Pago', '0', 1),
(119, 68, 4, 5, 'Primer Pago', '0', 1),
(120, 68, 4, 5, 'Segundo Pago', '0', 1),
(121, 69, 4, 5, 'Primer Pago', '0', 1),
(122, 69, 4, 5, 'Segundo Pago', '0', 1),
(123, 70, 4, 5, 'Primer Pago', '0', 1),
(124, 70, 4, 5, 'Segundo Pago', '0', 1),
(125, 71, 4, 5, 'Primer Pago', '0', 1),
(126, 71, 4, 5, 'Segundo Pago', '0', 1),
(127, 72, 4, 5, 'Primer Pago', '0', 1),
(128, 72, 4, 5, 'Segundo Pago', '0', 1),
(129, 73, 4, 5, 'Primer Pago', '0', 1),
(130, 73, 4, 5, 'Segundo Pago', '0', 1),
(131, 74, 4, 5, 'Primer Pago', '0', 1),
(132, 74, 4, 5, 'Segundo Pago', '0', 1),
(133, 75, 4, 5, 'Primer Pago', '0', 1),
(134, 75, 4, 5, 'Segundo Pago', '0', 1),
(135, 76, 4, 5, 'Primer Pago', '0', 1),
(136, 76, 4, 5, 'Segundo Pago', '0', 1),
(137, 77, 4, 5, 'Primer Pago', '0', 1),
(138, 77, 4, 5, 'Segundo Pago', '0', 1),
(139, 78, 4, 5, 'Primer Pago', '0', 1),
(140, 78, 4, 5, 'Segundo Pago', '0', 1),
(141, 79, 5, 6, 'Primer Pago', '0', 1),
(142, 79, 5, 6, 'Segundo Pago', '0', 1),
(143, 86, 5, 6, 'Primer Pago', '7', 1),
(144, 86, 5, 6, 'Segundo Pago', '0', 1),
(145, 80, 5, 6, 'Primer Pago', '0', 1),
(146, 80, 5, 6, 'Segundo Pago', '0', 1),
(147, 82, 5, 7, 'Primer Pago', '0', 1),
(148, 82, 5, 7, 'Segundo Pago', '0', 1),
(149, 83, 5, 7, 'Primer Pago', '0', 1),
(150, 83, 5, 7, 'Segundo Pago', '0', 1),
(151, 84, 5, 7, 'Primer Pago', '0', 1),
(152, 84, 5, 7, 'Segundo Pago', '0', 1),
(153, 85, 5, 7, 'Primer Pago', '0', 1),
(154, 85, 5, 7, 'Segundo Pago', '0', 1),
(155, 87, 5, 7, 'Primer Pago', '0', 1),
(156, 87, 5, 7, 'Segundo Pago', '0', 1),
(157, 88, 5, 7, 'Primer Pago', '0', 1),
(158, 88, 5, 7, 'Segundo Pago', '0', 1),
(159, 89, 5, 7, 'Primer Pago', '0', 1),
(160, 89, 5, 7, 'Segundo Pago', '0', 1),
(161, 90, 5, 7, 'Primer Pago', '0', 1),
(162, 90, 5, 7, 'Segundo Pago', '0', 1),
(163, 91, 5, 7, 'Primer Pago', '0', 1),
(164, 91, 5, 7, 'Segundo Pago', '0', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `pagos_planes_campana`
--
ALTER TABLE `pagos_planes_campana`
  ADD PRIMARY KEY (`id_pago_plan_campana`),
  ADD UNIQUE KEY `id_pago_plan_campana` (`id_pago_plan_campana`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pagos_planes_campana`
--
ALTER TABLE `pagos_planes_campana`
  MODIFY `id_pago_plan_campana` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

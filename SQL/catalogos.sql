-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-01-2023 a las 18:24:39
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
-- Estructura de tabla para la tabla `catalogos`
--

CREATE TABLE `catalogos` (
  `codigo_producto_catalogo` varchar(100) DEFAULT NULL,
  `nombre_producto_catalogo` varchar(100) DEFAULT NULL,
  `imagen_producto_catalogo` varchar(150) DEFAULT NULL,
  `estatus` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `catalogos`
--

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `catalogos`
--
ALTER TABLE `catalogos`
  ADD PRIMARY KEY (`id_catalogo`),
  ADD UNIQUE KEY `id_catalogo` (`id_catalogo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `catalogos`
--
ALTER TABLE `catalogos`
  MODIFY `id_catalogo` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 04-02-2023 a las 19:06:05
-- Versión del servidor: 10.2.44-MariaDB-cll-lve
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `stylecollection_pages`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `campanas`
--

CREATE TABLE `campanas` (
  `id_campana` bigint(20) UNSIGNED NOT NULL,
  `nombre_campana` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `anio_campana` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_campana` int(11) DEFAULT NULL,
  `visibilidad` int(11) DEFAULT NULL,
  `estatus` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `campanas`
--

INSERT INTO `campanas` (`id_campana`, `nombre_campana`, `anio_campana`, `numero_campana`, `visibilidad`, `estatus`) VALUES
(1, 'Con Mucho Amor Para Ti', '2022', 1, 1, 1),
(2, 'A Tu Encuentro', '2022', 2, 1, 1),
(3, 'Te Capacita', '2022', 3, 1, 1),
(4, 'Crecemos Juntos', '2022', 4, 1, 1),
(5, 'Celebrando Juntos', '2022', 5, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogos`
--

CREATE TABLE `catalogos` (
  `codigo_producto_catalogo` varchar(30) NOT NULL,
  `nombre_producto_catalogo` varchar(150) DEFAULT NULL,
  `imagen_producto_catalogo` varchar(100) DEFAULT NULL,
  `ficha_producto_catalogo` varchar(100) DEFAULT NULL,
  `estatus` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `catalogos`
--

INSERT INTO `catalogos` (`codigo_producto_catalogo`, `nombre_producto_catalogo`, `imagen_producto_catalogo`, `ficha_producto_catalogo`, `estatus`) VALUES
('KSPN5301', 'Shampoo Para NiÃ±os', 'public/assets/img/catalogo/KSPN5301.jpg', '', 1),
('CCBF1301', '+brillo -frizz (crema De Peinar)', 'public/assets/img/catalogo/CCBF1301.jpg', '', 1),
('CLCV2401', 'Coco-vainilla (lociÃ³n Corporal)', 'public/assets/img/catalogo/CLCV2401.jpg', '', 1),
('CLPE2402', 'Pera (lociÃ³n Corporal)', 'public/assets/img/catalogo/CLPE2402.jpg', '', 1),
('CGLI2601', 'Gel Liporeductor', 'public/assets/img/catalogo/CGLI2601.jpg', '', 1),
('FCAT3101', 'Anti-edad (crema Hidratante Facial)', 'public/assets/img/catalogo/FCAT3101.jpg', '', 1),
('FLDL3201', 'LociÃ³n Dermo-limpiadora', 'public/assets/img/catalogo/FLDL3201.jpg', '', 1),
('MGAR4102', 'Arnica (gel)', 'public/assets/img/catalogo/MGAR4102.jpg', '', 1),
('CSBO1101', 'Brillo De Oro (shampoo)', 'public/assets/img/catalogo/CSBO1101.jpg', '', 1),
('CSTR1102', 'Tratamiento De Romero (shampoo)', 'public/assets/img/catalogo/CSTR1102.jpg', '', 1),
('CBBO1201', 'Brillo De Oro (baÃ±o De Crema)', 'public/assets/img/catalogo/CBBO1201.jpg', '', 1),
('CBTR1202', 'Tratamiento De Romero (baÃ±o De Crema)', 'public/assets/img/catalogo/CBTR1202.jpg', '', 1),
('CTAL1401', 'Tratamiento Alisador', 'public/assets/img/catalogo/CTAL1401.jpg', '', 1),
('CACO2101', 'Coco (aceite)', 'public/assets/img/catalogo/CACO2101.jpg', '', 1),
('CJIN2201', 'Gel Intimo', 'public/assets/img/catalogo/CJIN2201.jpg', '', 1),
('MGME4101', 'Mentolado (gel)', 'public/assets/img/catalogo/MGME4101.jpg', '', 1),
('MTPP4201', 'Talco Para Pies', 'public/assets/img/catalogo/MTPP4201.jpg', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` bigint(20) UNSIGNED NOT NULL,
  `primer_nombre` varchar(50) DEFAULT NULL,
  `segundo_nombre` varchar(50) DEFAULT NULL,
  `primer_apellido` varchar(50) DEFAULT NULL,
  `segundo_apellido` varchar(50) DEFAULT NULL,
  `cod_cedula` varchar(5) DEFAULT NULL,
  `cedula` varchar(20) DEFAULT NULL,
  `sexo` varchar(25) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `telefono` varchar(25) DEFAULT NULL,
  `telefono2` varchar(25) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `cod_rif` varchar(5) DEFAULT NULL,
  `rif` varchar(25) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `id_lider` int(11) DEFAULT NULL,
  `estatus` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `primer_nombre`, `segundo_nombre`, `primer_apellido`, `segundo_apellido`, `cod_cedula`, `cedula`, `sexo`, `fecha_nacimiento`, `telefono`, `telefono2`, `correo`, `cod_rif`, `rif`, `direccion`, `id_lider`, `estatus`) VALUES
(1, 'Admin', 'T', 'System', 'SC', NULL, '0000000', 'Masculino', '1995-01-01', '', NULL, 'josrod.2112@gmail.com', '', '', '', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colecciones`
--

CREATE TABLE `colecciones` (
  `id_coleccion` bigint(20) UNSIGNED NOT NULL,
  `id_campana` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad_productos` int(11) DEFAULT NULL,
  `precio_producto` float DEFAULT NULL,
  `estatus` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `colecciones`
--

INSERT INTO `colecciones` (`id_coleccion`, `id_campana`, `id_producto`, `cantidad_productos`, `precio_producto`, `estatus`) VALUES
(1, 1, 25, 1, 6, 1),
(2, 1, 24, 1, 6, 1),
(3, 1, 30, 1, 4, 1),
(4, 1, 10, 2, 5, 1),
(5, 1, 26, 1, 4, 1),
(6, 1, 21, 1, 4, 1),
(7, 1, 23, 1, 4, 1),
(8, 1, 34, 2, 6, 1),
(9, 1, 7, 1, 5, 1),
(10, 1, 8, 1, 5, 1),
(11, 1, 1, 1, 5, 1),
(12, 1, 6, 1, 5, 1),
(13, 1, 35, 1, 6, 1),
(14, 1, 12, 1, 5, 1),
(15, 1, 37, 1, 4, 1),
(16, 1, 41, 1, 4, 1),
(35, 2, 25, 1, 6, 1),
(36, 2, 27, 1, 4.5, 1),
(37, 2, 47, 1, 4.5, 1),
(38, 2, 46, 1, 6, 1),
(39, 2, 40, 1, 2.5, 1),
(40, 2, 39, 1, 2.5, 1),
(41, 2, 10, 1, 5, 1),
(42, 2, 16, 1, 5, 1),
(43, 2, 18, 1, 5, 1),
(44, 2, 31, 1, 8, 1),
(45, 2, 34, 2, 6, 1),
(46, 2, 3, 1, 5, 1),
(47, 2, 2, 1, 5, 1),
(48, 2, 8, 1, 5, 1),
(49, 2, 45, 1, 5, 1),
(50, 2, 48, 1, 5, 1),
(51, 2, 13, 1, 5, 1),
(52, 2, 37, 1, 4, 1),
(83, 3, 24, 1, 6.5, 1),
(84, 3, 29, 1, 5, 1),
(85, 3, 51, 1, 5, 1),
(86, 3, 50, 1, 3, 1),
(87, 3, 10, 2, 5.5, 1),
(88, 3, 26, 1, 5, 1),
(89, 3, 20, 1, 5.5, 1),
(90, 3, 54, 1, 9, 1),
(91, 3, 34, 2, 6.5, 1),
(92, 3, 4, 1, 5.5, 1),
(93, 3, 7, 1, 5.5, 1),
(94, 3, 5, 1, 5.5, 1),
(95, 3, 15, 1, 5.5, 1),
(96, 3, 37, 1, 4, 1),
(97, 3, 41, 1, 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contact_bot`
--

CREATE TABLE `contact_bot` (
  `id` varchar(35) NOT NULL,
  `first` varchar(55) DEFAULT NULL,
  `last` varchar(55) DEFAULT NULL,
  `username` varchar(85) DEFAULT NULL,
  `lang` varchar(10) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `level` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `contact_bot`
--

INSERT INTO `contact_bot` (`id`, `first`, `last`, `username`, `lang`, `status`, `level`) VALUES
('1426859469', 'Josmar', 'RodrÃ­guez', 'AnonymousZonic', 'es', '1', 'AD0011'),
('5348388297', 'Oscar', 'Perez', '', 'es', '1', 'ST01'),
('', '', '', '', '', '1', 'ST01'),
('-1001849900792', '', '', '', 'es', '1', 'ST01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estructura_catalogo`
--

CREATE TABLE `estructura_catalogo` (
  `id_estructura_catalogo` bigint(20) UNSIGNED NOT NULL,
  `nombre_campana` varchar(100) DEFAULT NULL,
  `codigo_producto_catalogo` varchar(100) DEFAULT NULL,
  `posicion` int(11) DEFAULT NULL,
  `estatus` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estructura_catalogo`
--

INSERT INTO `estructura_catalogo` (`id_estructura_catalogo`, `nombre_campana`, `codigo_producto_catalogo`, `posicion`, `estatus`) VALUES
(15, 'Estructura 01/23', 'MGME4101', 15, 1),
(14, 'Estructura 01/23', 'CJIN2201', 9, 1),
(13, 'Estructura 01/23', 'CACO2101', 8, 1),
(12, 'Estructura 01/23', 'CTAL1401', 7, 1),
(11, 'Estructura 01/23', 'CBTR1202', 4, 1),
(10, 'Estructura 01/23', 'CBBO1201', 2, 1),
(9, 'Estructura 01/23', 'CSTR1102', 3, 1),
(8, 'Estructura 01/23', 'CSBO1101', 1, 1),
(7, 'Estructura 01/23', 'MGAR4102', 16, 1),
(6, 'Estructura 01/23', 'FLDL3201', 14, 1),
(5, 'Estructura 01/23', 'FCAT3101', 13, 1),
(4, 'Estructura 01/23', 'CGLI2601', 12, 1),
(3, 'Estructura 01/23', 'CLPE2402', 11, 1),
(2, 'Estructura 01/23', 'CLCV2401', 10, 1),
(1, 'Estructura 01/23', 'CCBF1301', 6, 1),
(17, 'Estructura 01/23', 'KSPN5301', 5, 1),
(16, 'Estructura 01/23', 'MTPP4201', 16, 1);

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` bigint(20) UNSIGNED NOT NULL,
  `producto` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cantidad` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estatus` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `producto`, `descripcion`, `cantidad`, `estatus`) VALUES
(1, 'Pre Lavado Capilar Romero', '...', '400ml', 1),
(2, 'Pre Lavado Capilar Manzanilla', '...', '400ml', 1),
(3, 'Pre Lavado Capilar ArgÃ¡n', '...', '400ml', 1),
(4, 'Pre Lavado Capilar Coco', '...', '400ml', 1),
(5, 'Pre Lavado Capilar Menta', '...', '400ml', 1),
(6, 'Pre Lavado Capilar Sin Sal', '...', '400ml', 1),
(7, 'Pre Lavado Capilar Gold', '...', '400ml', 1),
(8, 'Pre Lavado Capilar Para NiÃ±os', '...', '400ml', 1),
(9, 'Shower Gel Agua De Rosas', '...', '400ml', 1),
(10, 'Gel Intimo', '...', '400ml', 1),
(11, 'Gel Intimo', '', '500ml', 1),
(12, 'Suavisante Capilar Romero', '...', '400ml', 1),
(13, 'Suavizante Capilar Manzanilla', '...', '400ml', 1),
(14, 'Suavizante Capilar Coco', '...', '400ml', 1),
(15, 'Suavizante Capilar Paraiso', '...', '400ml', 1),
(16, 'HidrataciÃ³n Corporal Caricias', '...', '400ml', 1),
(17, 'HidrataciÃ³n Corporal Passion', '...', '400ml', 1),
(18, 'HidrataciÃ³n Corporal Pera', '...', '400ml', 1),
(19, 'HidrataciÃ³n Corporal Citrus', '...', '400ml', 1),
(20, 'HidrataciÃ³n Corporal Almendra', '...', '400ml', 1),
(21, 'Lotion Body Coco & Vainilla', '...', '200ml', 1),
(22, 'Lotion Body Love Spell', '...', '200ml', 1),
(23, 'Lotion Body Pore Love', '...', '200ml', 1),
(24, 'Aceite Hidratante Corporal Y Capilar De Coco', '...', '200ml', 1),
(25, 'Aceite Hidratante Corporal Y Capilar De Almendra', '...', '200ml', 1),
(26, 'Gold Masking', '...', '250g', 1),
(27, 'Argan Hair Mask', '...', '250g', 1),
(28, 'Mascarilla Capilar', '...', '250g', 1),
(29, 'BaÃ±o De Crema Coco', '...', '250g', 1),
(30, 'BaÃ±o De Crema Romero', '...', '250g', 1),
(31, 'Kit Alisador Botox Paso 1 Y Paso 2', '...', '240ml', 1),
(32, 'Kit Alisador CÃ©lulas Madre Paso 1 Y Paso 2', '...', '240ml', 1),
(33, 'Kit Alisador Lifting Capilar Paso 1 Y Paso 2', '...', '240ml', 1),
(34, 'Mentol', '...', '500g', 1),
(35, 'Splash Alcoholado', '...', '200ml', 1),
(36, 'Gel Antibacterial', '...', '200ml', 1),
(37, 'Talco Para Los Pies', '...', '240ml', 1),
(38, 'Talco Corporal Para Dama', '...', '240ml', 1),
(39, 'Desodorante De Dama', '...', '90ml', 1),
(40, 'Desodorante De Caballero', '...', '90ml', 1),
(41, 'Vaporizer', '...', '50g', 1),
(42, 'Aftershave Lotion', '...', '200ml', 1),
(43, 'Waxhair, Cera Fijadora', '...', '250g', 1),
(44, 'Locion Dermo Limpiadora', '...', '240ml', 1),
(45, 'Prelavado De Cristal De Sabila ', 'Prelavado Capilar A Base De Cristales De Sabila, Que Actuan Como Un Poderoso Regenerador Celular Natural', '400ml', 1),
(46, 'Crema Dermoprotectora', 'Crema AntipaÃ±alitis Para La ProtecciÃ³n De La Piel De Nuestros Bebes', '90gr', 1),
(47, 'BaÃ±o De Crema De Cristales De Sabila', 'BaÃ±o De Crema De Cristales De Sabila, Regenera Su Cabello', '250ml', 1),
(48, 'Shower Gel De Pera', 'Shower Gel A Base De Pera, Limpia E Hidrata La Piel, Dejando Un Rico Aroma', '400ml', 1),
(49, 'Kit Alisador Paso 1 Y Paso 2', '...', '240ml', 1),
(50, 'Desodorante Unisex Neutro', '...', '90ml', 1),
(51, 'Crema Hidratante Facial Anti-edad', '...', '40g', 1),
(52, 'Duo De Mentoles', '...', '500g', 1),
(53, 'Desodorante Antitranspirante', '...', '75g', 1),
(54, 'Kit Alisador Cera FrÃ­a Paso 1 Y Paso 2', '...', '240ml', 1),
(55, 'Probando', '...', '220mg', 1),
(56, 'Probando', '...', '220mg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` bigint(20) UNSIGNED NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `nombre_usuario` varchar(100) DEFAULT NULL,
  `password` varchar(150) DEFAULT NULL,
  `fotoPerfil` varchar(150) DEFAULT NULL,
  `descripFotoPerfil` varchar(255) DEFAULT NULL,
  `fotoPortada` varchar(150) DEFAULT NULL,
  `descripFotoPortada` varchar(255) DEFAULT NULL,
  `estatus` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `id_cliente`, `nombre_usuario`, `password`, `fotoPerfil`, `descripFotoPerfil`, `fotoPortada`, `descripFotoPortada`, `estatus`) VALUES
(1, 1, 'Admin98', 'admin98', NULL, NULL, NULL, NULL, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `campanas`
--
ALTER TABLE `campanas`
  ADD PRIMARY KEY (`id_campana`),
  ADD UNIQUE KEY `id_campana` (`id_campana`);

--
-- Indices de la tabla `catalogos`
--
ALTER TABLE `catalogos`
  ADD PRIMARY KEY (`codigo_producto_catalogo`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `colecciones`
--
ALTER TABLE `colecciones`
  ADD PRIMARY KEY (`id_coleccion`),
  ADD UNIQUE KEY `id_coleccion` (`id_coleccion`);

--
-- Indices de la tabla `contact_bot`
--
ALTER TABLE `contact_bot`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estructura_catalogo`
--
ALTER TABLE `estructura_catalogo`
  ADD PRIMARY KEY (`id_estructura_catalogo`),
  ADD UNIQUE KEY `id_estructura_catalogo` (`id_estructura_catalogo`);

--
-- Indices de la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`id_modulo`),
  ADD UNIQUE KEY `id_modulo` (`id_modulo`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD UNIQUE KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `id_usuario` (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `campanas`
--
ALTER TABLE `campanas`
  MODIFY `id_campana` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `colecciones`
--
ALTER TABLE `colecciones`
  MODIFY `id_coleccion` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT de la tabla `estructura_catalogo`
--
ALTER TABLE `estructura_catalogo`
  MODIFY `id_estructura_catalogo` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `modulos`
--
ALTER TABLE `modulos`
  MODIFY `id_modulo` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

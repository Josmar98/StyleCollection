-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-03-2022 a las 05:19:51
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
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` bigint(20) UNSIGNED NOT NULL,
  `id_lc` int(11) DEFAULT NULL,
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

INSERT INTO `clientes` (`id_cliente`, `id_lc`, `primer_nombre`, `segundo_nombre`, `primer_apellido`, `segundo_apellido`, `cod_cedula`, `cedula`, `sexo`, `fecha_nacimiento`, `telefono`, `telefono2`, `correo`, `cod_rif`, `rif`, `direccion`, `id_lider`, `estatus`) VALUES
(1, NULL, 'Admin', 'T', 'System', 'SC', NULL, '0000000', 'Masculino', '1995-01-01', '', NULL, 'josrod.2112@gmail.com', '', '', '', 0, 0),
(2, 7, 'Amarilis', ' ', 'Rojas', ' ', 'V', '15265010', 'Femenino', '1982-03-19', '04120507600', '0412', 'amarilis472@gmail.com', 'V', '152650105', 'Av. 20 Con Calle 31 Edificio Bujana', 0, 1),
(3, 2, 'Maria', ' ', 'Yánez', ' ', 'V', '13267710', 'Femenino', '1977-03-14', '04245006954', '0412', 'mariayanez1414@gmail.com', 'V', '13267710', 'Carrera 11 Entre 6 Y 7 Valle Lindo. . Bqto Lara', 2, 1),
(4, 2, 'Thais', ' ', 'Briceño', ' ', 'V', '10129616', 'Femenino', '1971-05-16', '02512377963', '0412', 'thaisbriceno@gmail.com', 'V', '101296161', 'Carrera 5 Con Calle 17 Barrio Unión,  N. 17 12 Bqto Lara', 2, 1),
(5, 2, 'Yelismar', ' ', 'Terán', ' ', 'V', '15885159', 'Femenino', '1982-08-07', '04264553183', '0412', 'yelismar@gmail.com', 'V', '158851591', 'Calle El Samán Con Calle El Palmar, N.268 Lomas De León.  Bqto Lara', 2, 1),
(6, NULL, 'Dílcia', ' ', 'Hernández', ' ', 'V', '7316706', 'Femenino', '1961-11-16', '02512576703', '0412', 'dilciahernandez@gmail.com', 'V', '7316706', 'Barrio Lomas De León, Calle Los Robles Entre Chaguaramos Y Los Mangos. N. 2.85. Bqto Lara', 5, 1),
(7, 5, 'Yohana', ' Desire', 'Velásquez', ' De Guevara', 'V', '16738130', 'Femenino', '1984-06-25', '04245657731', '04126747568', 'yohanavelasquez@gmail.com', 'V', '167381304', 'Calle 10 Entre 13 Y14 San Rafael Detras De La Guardia Quibor ', 2, 1),
(8, 3, 'Linyusmer', ' ', 'Noguera', ' ', 'V', '14937296', 'Femenino', '1978-07-29', '04245240075', '0412', 'linyusmernoguera@gmail.com', 'V', '14937296', 'Av Hernán Garmendia Urb Rio Lama Apto 23 Manzana J.1. Bqto Lara', 7, 1),
(9, 2, 'Maryelis', ' ', 'Montilla', ' ', 'V', '15171289', 'Femenino', '1980-12-03', '04162500291', '0412', 'maryelismontilla@gmail.com', 'V', '15171289', 'Carrera 11entre 11 Y12 Los Luises, Parroquia Unión Bqto Lara', 7, 1),
(10, NULL, 'Charlie', ' ', 'Marchan', ' ', 'V', '13643481', 'Masculino', '1977-11-06', '02510000000', NULL, 'charliemarchan@gmail.com', 'V', '13643481', 'Carrera 12 Y 13 Con Calle 58 Casa N. 4 El Triunfo, Sector Las Mercedes. Bqto Lara', 9, 1),
(11, 3, 'Ana', ' ', 'Del Valle Bullon', ' ', 'V', '22106160', 'Femenino', '1990-01-16', '04126783873', '0412', 'anabullon@gmail.com', 'V', '22106160', 'Urb Llano Lindo Sector La Josefina Casa I 175', 7, 1),
(12, 2, 'Trina', ' ', 'Romano', ' ', 'V', '16415712', 'Femenino', '1982-04-20', '04126774505', '0412', 'trinaromero@gmail.com', 'V', '16415712', 'Av. 30 Con Calle 33.  Centro Acarigua Portuguesa.  Av. Libertador. Acarigua Araure', 11, 1),
(13, 2, 'Aurimar', ' ', 'Escalona', ' ', 'V', '23580288', 'Femenino', '1992-04-23', '02510000000', NULL, 'aurimarescalona@gmail.com', 'V', '23580288', 'Calle 2 Casa N. 36 Urb. Lomas De Santa Sofia Araure.', 11, 1),
(14, 5, 'Wendy', ' ', 'Escobar', ' ', 'V', '16419722', 'Femenino', '1984-05-23', '04245466194', NULL, 'wendyescobar@gmail.com', 'V', '16419722', 'Urb. Don Flores N 8 Quibor.', 7, 1),
(15, 2, 'Grecia', ' Jose', 'Escobar', ' Silva', 'V', '24201005', 'Femenino', '1993-11-12', '04145415978', '0412', 'greciaescobar@gmail.com', 'V', '24201005', 'Urb. Don Flores Acceso 10 Casa L34 Quibor', 14, 1),
(16, 3, 'Rosciri', ' Lorena', 'Damas', ' Garcia', 'V', '18432466', 'Femenino', '1988-03-25', '04245151185', '0412', 'jj1103damas.25@gmail.com', 'V', '18432466', 'Av. Stadium Con Vía La Guaroa Abajo, Sector El Paraíso, Veredas N 1.', 14, 1),
(17, 2, 'Ana', 'Dolores', 'D Bullon ', ' ', 'V', '24654882', 'Femenino', '1994-05-17', '04125261698', '0412', 'anadoloresbullon@gmail.com', 'V', '24654882', 'Urb. Villas Del Pilar 2da Etapa Calle 13 Casa 820 . Araure Portuguesa', 11, 1),
(18, 2, 'Laura', ' ', 'Linarez', ' ', 'V', '18929309', 'Femenino', '1987-11-03', '04145352403', '0412', 'malvaciall@gmail.com', 'V', '18929309', 'Urb. Los Vencedores De Araure. Av. Principal Casa 12 B Araure Portuguesa', 16, 1),
(19, 4, 'Eduardo', ' Jose', 'Linarez', ' Duran', 'V', '9570055', 'Masculino', '1965-10-04', '04166018426', '0412', 'eduardoJlinareZ@gmail.com', 'V', '9570055', 'Urb. Don Flores, N. 8 Quibor', 14, 1),
(20, 3, 'Mariela', ' ', 'León', ' ', 'V', '17134595', 'Femenino', '1983-07-10', '04122631778', '0412', 'marielaco2001@yahoo.es', 'V', '17134595', 'Av 1 Entre Calle 3 Y Bolivar Casa Sn Cabo José Dorante. Quibor Edo Lara', 19, 1),
(21, 3, 'Erica', ' ', 'Lucena', ' ', 'V', '11583214', 'Femenino', '1972-06-10', '04160581727', '04245584563', 'elucenamendoza@gmail.com', 'V', '11583214', 'Urb. El Calvario, Avenida Junin. Quibor', 20, 1),
(22, 2, 'Giddalthis', ' ', 'Flores', ' ', 'V', '12370401', 'Femenino', '1975-07-31', '04162593061', NULL, 'giddalthisflores@gmail.com', 'V', '12370401', 'Vereda Manzana 6 Casa N. 21 Urb El Atardecer, Quibor', 21, 1),
(23, 4, 'Leidy', ' ', 'Araujo', ' ', 'V', '13187541', 'Femenino', '1977-01-24', '04264206244', NULL, 'leidyaraujo@gmail.com', 'V', '13187541', 'Carrera 13 Entre 44 Y 45 Res Atlas, Torre 4 Piso 4 Apto 4.3.4 Bqto Lara', 2, 1),
(24, 2, 'Liseth', ' ', 'López', ' ', 'V', '10771787', 'Femenino', '1971-01-15', '04145115638', '0412', 'lisethlopez@gmail.com', 'V', '10771787', 'Vereda 10 Entre Av. Principal Calle 1 Casa N. 9.32  Ruiz Pineda. Bqto Lara', 23, 1),
(25, 2, 'Angela', ' ', 'López', ' ', 'V', '13921147', 'Femenino', '1976-01-11', '04141579491', '0412', 'angelalopez@gmail.com', 'V', '13921147', 'Carrera 12 Entre 8 Y 9 Los Luises N. 8.92. Bqto Lara', 23, 1),
(26, 2, 'Leidy', ' ', 'Terán', ' ', 'V', '17004963', 'Femenino', '1984-06-07', '04145454203', '0412', 'leidyteran@gmail.com', 'V', '17004963', 'Calle 4 Casa S.n Barrio Los Pinos. Boconoito, Portuguesa', 23, 1),
(27, NULL, 'Keyla', ' ', 'Rivero', ' ', 'V', '14405405', 'Femenino', '1990-01-01', '04145371003', NULL, 'keylarivero@gmail.com', 'V', '14405405', 'Calle 2 Casa 0804 Urb. La Granja Guanare Portuguesa.', 26, 1),
(28, 6, 'Corina', ' Milagros', 'Cuevas', ' De Rodriguez', 'V', '17627273', 'Femenino', '1985-06-11', '04245794855', '04121645811', 'corinamilagros@gmail.com', 'V', '17627273', 'Centro Barquisimeto, Avenida 20 Con Calle 31 Edificio Bujanas, Piso 2', 2, 1),
(29, 2, 'Yulimar', ' ', 'Paredes', ' ', 'V', '17340965', 'Femenino', '1987-02-05', '04161166353', '0412', 'yulimarparedes05@gmail.com', 'V', '17340965', 'Calle Arzobispo Chacón Principal Casa S.n Mucuchies. Estado Mérida', 28, 1),
(30, 6, 'Astrid', ' Onesis', 'Ochoa', ' Sierra', 'V', '19086748', 'Femenino', '1989-05-12', '04245915310', '0412', 'ochoastrid512@gmail.com', 'V', '19086748', 'Centro Barquisimeto, Avenida 20 Con Calle 31. Edificio Bujanas Piso 5', 28, 1),
(31, 2, 'José', 'Antonio ', 'Tovar', ' Soteldo', 'V', '19712865', 'Masculino', '1989-01-05', '04123131583', '0412', 'anthony.soteldo.89@gmail.com', 'V', '19712865', 'Avenida 12 Entre Calles 4 Y 5 Barrio La Peñita Chivacoa Estado Yaracuy', 30, 1),
(32, 2, 'Helensys', ' ', 'Rodriguez', ' ', 'V', '15004176', 'Femenino', '1979-04-07', '04125201154', '0412', 'helensys@gmail.com', 'V', '15004176', 'Centro Barquisimeto, Avenida 20 Con Calle 31 Edificio Bujanas Piso 5', 30, 1),
(33, 2, 'Sandy', ' ', 'Romero', ' ', 'V', '14269714', 'Femenino', '1979-02-15', '04145045025', NULL, 'sandyromero@gmail.com', 'V', '14269714', 'Ruiz Pineda 1 Vereda Con Calle 7. N 1a.16 Bqto Lara', 30, 1),
(34, 3, 'Johenny', ' Esperanza', 'Carreras', ' CarreÃ±o', 'V', '20799718', 'Femenino', '1992-07-03', '04164958679', '04125173146', 'johecarreras@gmail.com', 'V', '20799718', 'Urb. San Rafael Calle Oeste 3 Casa 0340 Yaritagua Carrera 22 Entre Calle 12 Y 13 .', 30, 1),
(35, 2, 'Yadira', ' Maria', 'López', ' Rosales', 'V', '11721135', 'Femenino', '1975-05-13', '04268985335', '0412', 'Yadiramlr@hotmail.com', 'V', '11714135', 'El Vigía, Estado Mérida. Parroquia Pulido Méndez. Sector Caño Seco 2 Con Calle 14', 34, 1),
(36, 2, 'Elisa', ' ', 'Vargas', ' ', 'V', '15003410', 'Femenino', '1979-05-10', '04245221770', '0412', 'elisavargas@gmail.com', 'V', '15003410', 'El Cují Vía Duaca, Calle La Ceiba Sector Prados Del Norte 1.', 30, 1),
(37, 2, 'Yannelys', ' ', 'Rodriguez', ' ', 'V', '12704028', 'Femenino', '1976-11-24', '04245047907', '0412', 'yannerodri@gmail.com', 'V', '12704028', 'Calle 3 Con Carrera 3b Y 4 A Local N. 3b.54', 36, 1),
(38, 3, 'Luismary', ' ', 'Caldera', ' ', 'V', '16112501', 'Femenino', '1984-07-18', '04120521201', NULL, 'luismarycaldera@gmail.com', 'V', '16112501', 'Urb. San Miguel, Calle 3 Av. 1 Y 2', 30, 1),
(39, 2, 'José', 'Alejandro', 'Ustáriz ', 'Arenas ', 'V', '27591948', 'Masculino', '2001-01-24', '04245903844', '04121548499', 'josealejandroustarizarenas@gmail.com', 'V', '27591948', 'Urb. Espíritu Santo, Calle 1. Sector La Montañita I. Yaritagua Casa N 2. Cerca Del Preescolar La Montañita. Yaritagua', 38, 1),
(40, 5, 'Eufari', ' ', 'Mora', ' ', 'V', '19104222', 'Femenino', '1985-11-11', '04143560616', '0412', 'eufarimora@gmail.com', 'V', '19104222', 'Centro Barquisimeto, Avenida 20 Con Calle 31 Edificio Bujanas. Piso 2', 30, 1),
(41, 2, 'María', 'Esther', 'Méndez', ' ', 'V', '17993972', 'Femenino', '1988-07-04', '04145520810', '04245121130', 'mariaesther.mendez2@gmail.com', 'V', '17993972', 'Urb Tricentenaria, Calle 7 Casa N.10 Yaritagua Estado Yaracuy', 40, 1),
(42, NULL, 'Mirlay', ' ', 'Rivero', ' ', 'V', '26136474', 'Femenino', '1997-05-07', '04164551345', NULL, 'mirlayrivero@gmail.com', 'V', '26163474', 'Carrera 15 Entre 13 Y 14 Nuevo Barrio', 40, 1),
(43, 3, 'Efraín', ' José', 'Vásquez', ' Jiménez', 'V', '25621561', 'Masculino', '1996-11-10', '04249717495', '04129415276', 'efrainjvj199610@gmail.com', 'V', '25621561', 'Boquerón, Calle Rivas Cruce Con Calle Los Jobos, Maturín Edo Monagas.', 40, 1),
(44, 2, 'Brigitte', ' ', 'Hidalgo', ' ', 'V', '21505381', 'Femenino', '1993-07-07', '04245795053', '0412', 'briggittehidalgo@gmail.com', 'V', '21505381', 'Las Tinajitas, Sector Carrera 3 Entre 7 Y 8 N. 30, A Dos Casa De Peluquería Hilda. Bqto Lara', 40, 1),
(45, 2, 'Adda', 'F', 'Balza', ' ', 'V', '10720450', 'Femenino', '1967-09-21', '04245404133', NULL, 'addafalza@gmail.com', 'V', '10720450', 'Urb. Santa Barbara 2 Calle 3, Casa N 10 Veguitas Edo Barinas.', 44, 1),
(46, 4, 'Ana', ' ', 'Cantillo', ' ', 'V', '7469962', 'Femenino', '1962-08-17', '04162519490', NULL, 'anacantillo@gmail.com', 'V', '7469962', 'Av Principal Los Cerrajones Esquina Carrera 8, Barrio 5 De Julio N.6.32. Bqto Lara', 2, 1),
(47, 2, 'Yudith', ' ', 'Rivas', ' ', 'V', '7393140', 'Femenino', '1963-01-01', '04143519714', '0412', 'yudithrivas@gmail.com', 'V', '7393140', 'Agua Viva Sector La Cruz Calle Alegría Con Altos De Tabure Prolongación El Pedregal N. 13523 Cerca De La Cauchera Del Señor Guillermo. Bqto Lara', 46, 1),
(48, 3, 'Disalex', ' Alejandra ', 'Vásquez', ' Peña', 'V', '15444242', 'Femenino', '1980-09-17', '04140567985', '0412', 'disalexvasquez@gmail.com', 'V', '15444242', 'Av Principal Los Cerrajones Casa 114, Comunidad Tierra Del Che Guevara Calle5, Bqto Lara', 46, 1),
(49, 3, 'Yudimar', ' ', 'Escalona', ' ', 'V', '18421629', 'Femenino', '1986-02-27', '04125203781', NULL, 'yudimarescalona@gmail.com', 'V', '18421629', 'Comunidad Tierra Del Che Guevara, Calle 5n. 111 Av. Principal Cerrajones. Bqto Lara', 48, 1),
(50, NULL, 'Leidy', ' ', 'Borgues', ' ', 'V', '19344715', 'Femenino', '1989-09-05', '04140556983', '0412', 'leicris0908@gmail.com', 'V', '19344715', 'Av. 21 Entre Calles 7 Y 8 Barrio Primero De Mayo Casa S.n', 7, 0),
(51, 2, 'Naileth', ' ', 'Sequera', ' ', 'V', '10959692', 'Femenino', '1968-02-21', '04120000000', '0412', 'nailethsequera@gmail.com', 'V', '10959692', 'Calle 2 Casa N.3 Urb. San Antonio. Sector Ii, El Tocuyo. Estado Lara', 49, 1),
(52, 2, 'Carmen', 'Elena', 'Castañeda', 'Rodriguez', 'V', '9573135', 'Femenino', '1966-05-22', '04125195372', '04125278216', 'carmenelena@gmail.com', 'V', '9573135', 'Carrera 4 Entre Calle 8 Y 9 Casa S.n Urb. Daniel Caria, Tocuyo, Estado Lara', 2, 1),
(53, 2, 'Dulce', 'Maria', 'Perez', 'Escalona', 'V', '11580215', 'Femenino', '1980-01-01', '04145776256', '0412', 'dulceperez@gmail.com', 'V', '11580215', '  ', 2, 1),
(54, 2, 'Maribel', ' ', 'Bastidas', ' ', 'V', '7396896', 'Femenino', '1970-12-25', '04245146869', '0412', 'maribelbastidas@gmail.com', 'V', '7396896', 'Edificio Bujana Piso 2 Av. 20 Esquina Calle 31', 2, 1),
(55, NULL, 'Alexander', ' ', 'System', ' ', 'V', '00000000', 'Masculino', '1990-01-01', '04120000000', NULL, 'alexandersystem@gmail.com', 'V', '00000000', 'Av. 20 Con Calle 31', 0, 0),
(56, NULL, 'Analista', ' ', 'System', ' ', 'V', '00000001', 'Femenino', '1990-01-01', '04120000000', '0412', 'analistastylecollection@gmail.com', 'V', '00000001', 'Edificio Bujana Av. 20 Con Calle 31 P3 A6 Barquisimeto Estado Lara.', 0, 0),
(57, 2, 'Egilda', 'Del Carmen', 'Arrieche', 'De Aranguren', 'V', '9604072', 'Femenino', '1965-09-03', '04166541470', '0412', 'egildaa072@gmail.com', 'V', '96040721', 'Calle 9 Casa Numero G.76 Barrio Jose Gregorio Hernandez Etapa E Sector G, Bqto Lara', 23, 1),
(58, 2, 'Maria', 'Auxiliadora', 'Guedes', 'Gutierrez', 'V', '13313886', 'Femenino', '1973-10-04', '04126781108', '0412', 'mariaguedes@gmail.com', 'V', '13313886', 'Calle 3 Entre Carrera 2 Y 3 Sector Los Sin Techos Sabana De Parra Yaracuy', 28, 1),
(59, 3, 'Delio', 'Antonio', 'Gonzalez', 'Yajure', 'V', '4732873', 'Masculino', '1951-04-07', '04127738022', '0412', 'deliogomez09@gmail.com', 'V', '47328736', 'Calle 2 Entre Carrera 2 Y 3 Casa Numero 2 Raya 11 Sector Simón Bolívar Sabana De Parra, Yaracuy Lara', 28, 1),
(60, 2, 'Luis', 'David', 'Rivero', 'Peroza', 'V', '22188993', 'Masculino', '1993-08-04', '04245612036', '04245046656', 'ema3elimauanita@gmail.com', 'V', '221889939', 'Urb. Rafael Caldera 2da Etapa Av. 6 Con Calle 7 Casa N.85', 2, 1),
(61, 2, 'Mirian', 'Virginia', 'Andrade', ' ', 'V', '10956892', 'Femenino', '1970-09-02', '04120000000', '0412', 'miriamandrade@gmail.com', 'V', '109568925', 'Calle Principal Manzana 13 N. 11 Urb. El Atardecer Quibor', 46, 1),
(62, 2, 'Liria', 'Rosas', 'Alvarez', 'López', 'V', '11693158', 'Femenino', '1971-11-10', '04120000000', '0412', 'liriaalvarez@gmail.com', 'V', '116931580', 'Av. Principal Jardines Del Aeropuerto Casa N.2 Sector 1', 46, 1),
(63, 2, 'Yoagli', 'Margarita', 'Campos', 'De Guevara', 'V', '12248190', 'Femenino', '1973-08-26', '04143527454', '0412', 'yoagli.26@gmail.com', 'V', '122481901', 'Av. 2 Entre Av. Principal Calle 3b Casa N.344 Urb. La Paz  Bqto Lara', 33, 1),
(64, 2, 'Anaida', 'Del Carmen', 'Mendoza', 'Campos', 'V', '9602082', 'Femenino', '1976-05-25', '04126707299', '0412', 'anaidamendoza2008@gmail.com', 'V', '96020828', 'Urb. La Mata Cabudare Av. 3 Entre Calle 11 Y 12', 46, 1),
(65, 2, 'Adrianyela', ' ', 'Jiménez', 'Osorio', 'V', '13583231', 'Femenino', '1978-10-22', '04121504657', '0412', 'adrianyelajimenez@gmail.com', 'V', '135832312', 'Av. Principal Casa 2.181 Sector Simín Bolivar. Bqto Lara', 2, 1),
(66, 2, 'Luis', 'Rafael', 'García', 'Castillo', 'V', '21560208', 'Masculino', '1987-08-18', '04120584355', '04245498539', 'griselyh28@gmail.com', 'V', '21560208', 'Urb. El Saman Calle Francisco De Miranda Casa N.46 Acarigua', 43, 1),
(67, 2, 'Andreina', 'Del Valle', 'Machado', 'Zamora', 'V', '17434571', 'Femenino', '1984-01-18', '04262443234', '0412', 'goyo7703@gmail.com', 'V', '174345712', 'Calle Rondón Casa N.13, Sector Barrio Ajuro, El Socorro Guarico', 43, 1),
(68, 2, 'Maria ', 'Coromoto', 'Colmenarez', 'Fonseca', 'V', '7360014', 'Femenino', '1958-08-09', '04245794855', '0412', 'mariacolmenarez@gmail.com', 'V', '73600142', 'Avenida Tetar Rd Con Calle Yara Quinta Lejania Casa N40 Sector Montesuma', 59, 1),
(69, 2, 'Yeninel ', 'Pastora', 'Mendoza', 'Sanchez', 'V', '18422238', 'Femenino', '1986-10-30', '04245346927', '0412', 'yeninelmendoza@gmail.com', 'V', '184222384', 'Calle La Bendición Manzana N Casa N07 Sector Libertador', 40, 1),
(70, 2, 'Mariana', 'Yarline', 'Mendoza', 'Franco', 'V', '16262624', 'Femenino', '1986-03-09', '04145778412', '0412', 'mariangiemendoza@gmail.com', 'V', '16262624', 'Sector Copa Redonda En La Calle 4 Entre Carreras 1 Y 2 Sabana De Parra Municipio José Antonio Páez Edo.yaracuy', 38, 1),
(71, NULL, 'Conciliadores', ' ', 'System', ' ', 'V', '00000002', 'Femenino', '1990-01-01', '04120000000', '0412', 'conciliadores.stylecollection@gmail.com', 'V', '00000002', 'Av. 20 Con Calle 31 Edificio Bujana', 0, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `id_cliente` (`id_cliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

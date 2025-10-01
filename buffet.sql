-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 19-08-2025 a las 18:47:30
-- Versión del servidor: 9.1.0
-- Versión de PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `buffet`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Hamburguesas', NULL),
(2, 'Milanesas', NULL),
(3, 'Ensaladas', NULL),
(4, 'Sandwiches', NULL),
(5, 'Tartas', NULL),
(6, 'Otros', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

DROP TABLE IF EXISTS `favoritos`;
CREATE TABLE IF NOT EXISTS `favoritos` (
  `usuario_id` int NOT NULL,
  `producto_id` int NOT NULL,
  PRIMARY KEY (`usuario_id`,`producto_id`),
  KEY `producto_id` (`producto_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingredientes`
--

DROP TABLE IF EXISTS `ingredientes`;
CREATE TABLE IF NOT EXISTS `ingredientes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text,
  `vegetariano` tinyint(1) DEFAULT '0',
  `sin_tacc` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `ingredientes`
--

INSERT INTO `ingredientes` (`id`, `nombre`, `descripcion`, `vegetariano`, `sin_tacc`) VALUES
(1, 'Carne vacuna', NULL, 0, 0),
(2, 'Pan de hamburguesa', NULL, 0, 0),
(3, 'Jamón', NULL, 0, 0),
(4, 'Queso', NULL, 0, 0),
(5, 'Lechuga', NULL, 0, 0),
(6, 'Tomate', NULL, 0, 0),
(7, 'Medallón de soja', NULL, 0, 0),
(8, 'Papa', NULL, 0, 0),
(9, 'Zanahoria', NULL, 0, 0),
(10, 'Masa de tarta', NULL, 0, 0),
(11, 'Huevo', NULL, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu_dia`
--

DROP TABLE IF EXISTS `menu_dia`;
CREATE TABLE IF NOT EXISTS `menu_dia` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `producto_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `producto_id` (`producto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `menu_dia`
--

INSERT INTO `menu_dia` (`id`, `fecha`, `producto_id`) VALUES
(1, '2025-08-19', 1),
(2, '2025-08-19', 4),
(3, '2025-08-19', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categoria_id` int NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text,
  `precio` decimal(10,2) NOT NULL,
  `vegetariano` tinyint(1) DEFAULT '0',
  `sin_tacc` tinyint(1) DEFAULT '0',
  `imagen` varchar(255) DEFAULT NULL,
  `stock` int DEFAULT '0',
  `creado_en` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `categoria_id` (`categoria_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `categoria_id`, `nombre`, `descripcion`, `precio`, `vegetariano`, `sin_tacc`, `imagen`, `stock`, `creado_en`) VALUES
(1, 0, 'Hamburguesa Simple', 'Medallón de carne con pan', 1500.00, 0, 1, NULL, 20, '2025-08-19 15:43:58'),
(2, 0, 'Hamburguesa Simple', 'Medallón de carne con pan', 1500.00, 0, 1, NULL, 20, '2025-08-19 15:44:24'),
(3, 0, 'Hamburguesa con J&Q', 'Hamburguesa con jamón y queso', 1800.00, 0, 1, NULL, 15, '2025-08-19 15:44:24'),
(4, 0, 'Hamburguesa Completa', 'Hamburguesa con jamón, queso, lechuga y tomate', 2000.00, 0, 1, NULL, 10, '2025-08-19 15:44:24'),
(5, 0, 'Milanesa de Soja c/Guarnición', 'Milanesa de soja con guarnición de papas o ensalada', 1700.00, 1, 1, NULL, 12, '2025-08-19 15:44:24'),
(6, 0, 'Sandwich de Milanesa', 'Sandwich con milanesa, lechuga y tomate', 1900.00, 0, 1, NULL, 14, '2025-08-19 15:44:24'),
(7, 0, 'Ensalada LTZ', 'Lechuga, tomate y zanahoria rallada', 1200.00, 1, 1, NULL, 8, '2025-08-19 15:44:24'),
(8, 0, 'Medialuna de J&Q', 'Medialuna rellena con jamón y queso', 800.00, 0, 1, NULL, 25, '2025-08-19 15:44:24'),
(9, 0, 'Tostado', 'Tostado de jamón y queso', 900.00, 0, 1, NULL, 18, '2025-08-19 15:44:24'),
(10, 0, 'Tarta de J&Q', 'Porción de tarta de jamón y queso', 1500.00, 0, 1, NULL, 10, '2025-08-19 15:44:24'),
(11, 0, 'Tortilla de Papa', 'Tortilla de papa al horno', 1400.00, 1, 1, NULL, 9, '2025-08-19 15:44:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_ingredientes`
--

DROP TABLE IF EXISTS `producto_ingredientes`;
CREATE TABLE IF NOT EXISTS `producto_ingredientes` (
  `producto_id` int NOT NULL,
  `ingrediente_id` int NOT NULL,
  PRIMARY KEY (`producto_id`,`ingrediente_id`),
  KEY `ingrediente_id` (`ingrediente_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `producto_ingredientes`
--

INSERT INTO `producto_ingredientes` (`producto_id`, `ingrediente_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 5),
(3, 6),
(4, 5),
(4, 6),
(4, 7),
(4, 8),
(5, 1),
(5, 2),
(5, 5),
(5, 6),
(6, 5),
(6, 6),
(6, 9),
(7, 3),
(7, 4),
(8, 2),
(8, 3),
(8, 4),
(9, 3),
(9, 4),
(9, 10),
(10, 8),
(10, 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

DROP TABLE IF EXISTS `reservas`;
CREATE TABLE IF NOT EXISTS `reservas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `comentario` text,
  `estado` enum('pendiente','aceptada','rechazada') DEFAULT 'pendiente',
  `creado_en` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva_detalle`
--

DROP TABLE IF EXISTS `reserva_detalle`;
CREATE TABLE IF NOT EXISTS `reserva_detalle` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reserva_id` int NOT NULL,
  `producto_id` int NOT NULL,
  `cantidad` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `reserva_id` (`reserva_id`),
  KEY `producto_id` (`producto_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

DROP TABLE IF EXISTS `rol`;
CREATE TABLE IF NOT EXISTS `rol` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rol` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `rol`) VALUES
(1, 'admin'),
(2, 'cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `contraseña` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `rol_id` int NOT NULL,
  `creado_en` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `rol_id` (`rol_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `contraseña`, `rol_id`, `creado_en`) VALUES
(1, 'Administrador Buffet', 'buffet@gmail.com', '1234', 0, '2025-08-19 15:43:12'),
(2, 'Juan Pérez', 'juan@gmail.com', '1234', 0, '2025-08-19 15:43:12'),
(3, 'Ana López', 'ana@gmail.com', '1234', 0, '2025-08-19 15:43:12'),
(4, 'Martina Gómez', 'martina@gmail.com', '1234', 0, '2025-08-19 15:43:12');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

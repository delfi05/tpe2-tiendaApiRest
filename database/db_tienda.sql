-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-11-2022 a las 03:00:26
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_tienda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `dni` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `nombre`, `apellido`, `dni`) VALUES
(4, 'carla', 'Ferreyra', 40157895),
(5, 'Marta', 'Perez', 3546589),
(7, 'Delfina', 'Ferreyra', 33244322),
(8, 'Luciana', 'Martinez', 12344222),
(9, 'Martin', 'Fernandez', 3827271),
(10, 'Lucas', 'Lopez', 436456789),
(11, 'Martina', 'Arispe', 28372626),
(12, 'Lorenzo', 'Fernadez', 1232132),
(13, 'Florencia', 'Petruzzella', 56566566),
(14, 'Julian', 'Juanez', 83392973),
(15, 'Juan', 'Bertucci', 15445566),
(16, 'Lorenzo', 'Fernadez', 1232132),
(18, 'Florencia', 'Drimoni', 3235455),
(19, 'Lucas', 'Sabina', 9958372),
(20, 'Juana', 'Ferreyra', 40157895),
(21, 'Juana', 'Ferreyra', 40157895),
(22, 'Juana', 'Ferreyra', 40157895),
(23, 'Juana', 'Ferreyra', 40157895),
(24, 'Luisa', 'Martinez', 40157895),
(25, 'Luisa', 'Martinez', 40157895);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `producto` varchar(45) NOT NULL,
  `talle` varchar(45) NOT NULL,
  `color` varchar(45) NOT NULL,
  `marca` varchar(45) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `id_cliente` int(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `producto`, `talle`, `color`, `marca`, `descripcion`, `id_cliente`) VALUES
(18, 'Pantalon', 'M', 'negro', 'Deliverind', 'medidas: 1.cintura: 32-34  2.cadera: 56-57  3.tiro: 38-40  4.Largo 54-56', 4),
(19, 'Zapatillas', '40', 'blancas', 'nike', 'las Nike Air Force 1 \'07, un modelo original de baloncesto que introduce un nuevo giro a sus ya característicos revestimientos con costuras duraderas, sus acabados impecables y la cantidad perfecta de reflectante', 5),
(20, 'Remera', '40', 'roja', 'mua', 'medidas oversize, medidas: 1.cintura: 32-34 2.cadera: 56-57 3.tiro: 38-40 4.Largo 54-56', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `email` varchar(45) NOT NULL,
  `contraseña` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `email`, `contraseña`) VALUES
(1, 'usuario@gmail.com', '$2a$12$1877Q5WteGw52lTu/4scjuklqQkFAn2.mOqV5ltYGPqAspuQeCFXa');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `fk_producto_cliente` (`id_cliente`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `id_usuario` (`id_usuario`),
  ADD UNIQUE KEY `id_usuario_2` (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_producto_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

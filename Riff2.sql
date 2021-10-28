-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 23-10-2021 a las 10:52:59
-- Versión del servidor: 10.6.4-MariaDB
-- Versión de PHP: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `Riff2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CodigosResolucion`
--

CREATE TABLE `CodigosResolucion` (
  `cod_resolucion` int(11) NOT NULL,
  `desc_codigo` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `DetalleOrden`
--

CREATE TABLE `DetalleOrden` (
  `id_det_orden` int(11) NOT NULL,
  `comentario_detalle` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_orden` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Domicilios`
--

CREATE TABLE `Domicilios` (
  `id_domicilio` int(11) NOT NULL,
  `calle` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `piso` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `depto` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cod_postal` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_provincia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `Domicilios`
--

INSERT INTO `Domicilios` (`id_domicilio`, `calle`, `numero`, `piso`, `depto`, `cod_postal`, `id_provincia`) VALUES
(1, 'Anduiza', '1933', NULL, NULL, '2300', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Empleados`
--

CREATE TABLE `Empleados` (
  `legajo` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dni` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `telefono_personal` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_domicilio` int(11) NOT NULL,
  `contrasenia` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nivel` char(1) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `Empleados`
--

INSERT INTO `Empleados` (`legajo`, `dni`, `nombre`, `apellido`, `fecha_nacimiento`, `fecha_ingreso`, `telefono_personal`, `email`, `id_domicilio`, `contrasenia`, `nivel`) VALUES
('604154', '28084025', 'Diego', 'Krause', '1980-04-10', '2008-01-01', '3492694033', 'diegok1980@gmail.com', 1, '3030', '1'),
('606060', '32323232', 'Juan', 'Pérez', '1991-09-01', '2001-01-01', '3492656565', 'jperez@cablevision.com.ar', 1, '12345678', '2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Estados`
--

CREATE TABLE `Estados` (
  `id_estado` int(11) NOT NULL,
  `desc_estado` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `Estados`
--

INSERT INTO `Estados` (`id_estado`, `desc_estado`) VALUES
(1, 'Pendiente'),
(2, 'Cursando'),
(3, 'Solucionado'),
(4, 'Cancelado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Eventos`
--

CREATE TABLE `Eventos` (
  `id_evento` int(11) NOT NULL,
  `comentario` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_creacion` date NOT NULL,
  `id_tipo_falla` int(11) NOT NULL,
  `latitud` float(10,6) NOT NULL,
  `longitud` float(10,6) NOT NULL,
  `legajo_tecnico` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_estado` int(11) NOT NULL,
  `calle` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `piso` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `depto` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cod_postal` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `Eventos`
--

INSERT INTO `Eventos` (`id_evento`, `comentario`, `fecha_creacion`, `id_tipo_falla`, `latitud`, `longitud`, `legajo_tecnico`, `id_estado`, `calle`, `numero`, `piso`, `depto`, `cod_postal`) VALUES
(1, 'Prueba des bbdd', '2021-10-08', 1, -31.274191, -61.475182, '604154', 4, 'Anduiza', '1933', '', '', '2300'),
(2, 'prueba post 3', '2021-08-13', 1, -61.505001, -31.504999, '604154', 1, 'Anduiza', '1933', '', '', '2300'),
(3, 'post desde postman', '2021-08-11', 1, -31.274191, -61.475182, '604154', 4, 'Anduiza', '1933', '', '', '2300'),
(4, 'post desde postman - 2', '2021-08-17', 3, -31.274191, -61.475182, '604154', 4, 'Anduiza', '1933', '', '', '2300'),
(9, 'prueba 10', '2021-07-18', 3, -31.274145, -61.475140, '604154', 2, 'kaksj', 'ksks', '-', '-', '2300'),
(10, 'kskajs', '2021-07-18', 3, -31.274181, -61.475117, '604154', 4, 'ksksjs', 'jdjs', '-', '-', '2300'),
(11, 'pruebe 12', '2021-07-18', 2, -31.274181, -61.475117, '604154', 1, 'kaksk', '1933', '6', '8', '2300'),
(12, 'otra prueba', '2021-07-21', 5, -31.201616, -61.475388, '604154', 1, 'Anduiza', '1933', '-', '-', '2300'),
(13, 'kdksksbd', '2021-07-21', 5, -31.201616, -61.475388, '604154', 1, 'oissj', '1929', '-', '-', '2300'),
(14, 'correr cables por construcción', '2021-08-04', 9, -31.274101, -61.475163, '604154', 1, 'San Lorenzo', '1090', '-', '-', '2300'),
(15, 'prueba para rendir', '2021-08-07', 2, -31.274143, -61.475018, '604154', 1, 'San Lorenzo', '1300', '-', '-', '2300'),
(16, 'prueba cast', '2021-08-08', 4, -31.274199, -61.475082, '604154', 1, 'San Martin', '50', '-', '-', '2300'),
(17, 'tap 17x8', '2021-08-09', 5, -31.274212, -61.475079, '606060', 1, 'San martin', '50', '1', 'd', '2300'),
(18, 'prueba', '2021-08-10', 6, -31.274065, -61.475193, '604154', 1, 'pepe', '124', '-', '-', '2300'),
(20, 'nuevo evento', '2021-09-15', 3, -31.265312, -61.484043, '604154', 1, 'udjsj', '187', '-', '-', '2300'),
(21, 'jdksjs', '2021-09-15', 4, -31.265312, -61.484043, '604154', 1, 'jdjsj', '166', '-', '-', '2300'),
(22, 'nuevo evento 2', '2021-09-15', 6, -31.265312, -61.484043, '604154', 1, 'jsja', '188', '-', '-', '2300');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Localidades`
--

CREATE TABLE `Localidades` (
  `cod_postal` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc_localidad` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_provincia` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `Localidades`
--

INSERT INTO `Localidades` (`cod_postal`, `desc_localidad`, `id_provincia`) VALUES
('2300', 'Rafaela', 3),
('3000', 'Santa Fe', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Ordenes`
--

CREATE TABLE `Ordenes` (
  `id_orden` int(11) NOT NULL,
  `legajo_tecnico` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_creacion` date NOT NULL,
  `fecha_resolucion` date DEFAULT NULL,
  `id_evento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `Ordenes`
--

INSERT INTO `Ordenes` (`id_orden`, `legajo_tecnico`, `fecha_creacion`, `fecha_resolucion`, `id_evento`) VALUES
(1, '606060', '2021-09-04', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Provincias`
--

CREATE TABLE `Provincias` (
  `id_provincia` int(11) NOT NULL,
  `desc_provincia` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `Provincias`
--

INSERT INTO `Provincias` (`id_provincia`, `desc_provincia`) VALUES
(1, 'Buenos Aires'),
(2, 'Córdoba'),
(3, 'Santa Fe');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TipoFallas`
--

CREATE TABLE `TipoFallas` (
  `id_tipo_falla` int(11) NOT NULL,
  `cod_tipo_falla` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc_falla` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `TipoFallas`
--

INSERT INTO `TipoFallas` (`id_tipo_falla`, `cod_tipo_falla`, `desc_falla`) VALUES
(1, '100', 'TAP CON DIVISORES'),
(2, '101', 'TAP CON AGUA'),
(3, '102', 'TAP BOCA ROTA'),
(4, '103', 'TAP DQI VARIA'),
(5, '200', 'CABLE BAJO'),
(6, '201', 'CABLE PORTANTE ROTA'),
(7, '202', 'CABLE ROTO'),
(8, '203', 'CABLE ROZA RAMAS'),
(9, '204', 'CABLE OBSTRUYE CONSTRUCCION'),
(10, '104', 'TAP NIVELES BAJOS');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `CodigosResolucion`
--
ALTER TABLE `CodigosResolucion`
  ADD PRIMARY KEY (`cod_resolucion`);

--
-- Indices de la tabla `DetalleOrden`
--
ALTER TABLE `DetalleOrden`
  ADD PRIMARY KEY (`id_det_orden`),
  ADD KEY `id_orden` (`id_orden`);

--
-- Indices de la tabla `Domicilios`
--
ALTER TABLE `Domicilios`
  ADD PRIMARY KEY (`id_domicilio`),
  ADD KEY `cod_postal` (`cod_postal`),
  ADD KEY `id_provincia` (`id_provincia`);

--
-- Indices de la tabla `Empleados`
--
ALTER TABLE `Empleados`
  ADD PRIMARY KEY (`legajo`),
  ADD KEY `id_domicilio` (`id_domicilio`);

--
-- Indices de la tabla `Estados`
--
ALTER TABLE `Estados`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `Eventos`
--
ALTER TABLE `Eventos`
  ADD PRIMARY KEY (`id_evento`),
  ADD KEY `id_tipo_falla` (`id_tipo_falla`),
  ADD KEY `legajo_tecnico` (`legajo_tecnico`),
  ADD KEY `cod_postal` (`cod_postal`),
  ADD KEY `id_estado` (`id_estado`);

--
-- Indices de la tabla `Localidades`
--
ALTER TABLE `Localidades`
  ADD PRIMARY KEY (`cod_postal`),
  ADD KEY `id_provincia` (`id_provincia`);

--
-- Indices de la tabla `Ordenes`
--
ALTER TABLE `Ordenes`
  ADD PRIMARY KEY (`id_orden`),
  ADD KEY `id_evento` (`id_evento`),
  ADD KEY `Ordenes2` (`legajo_tecnico`);

--
-- Indices de la tabla `Provincias`
--
ALTER TABLE `Provincias`
  ADD PRIMARY KEY (`id_provincia`);

--
-- Indices de la tabla `TipoFallas`
--
ALTER TABLE `TipoFallas`
  ADD PRIMARY KEY (`id_tipo_falla`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `DetalleOrden`
--
ALTER TABLE `DetalleOrden`
  MODIFY `id_det_orden` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Domicilios`
--
ALTER TABLE `Domicilios`
  MODIFY `id_domicilio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `Estados`
--
ALTER TABLE `Estados`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `Eventos`
--
ALTER TABLE `Eventos`
  MODIFY `id_evento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `Ordenes`
--
ALTER TABLE `Ordenes`
  MODIFY `id_orden` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `Provincias`
--
ALTER TABLE `Provincias`
  MODIFY `id_provincia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `TipoFallas`
--
ALTER TABLE `TipoFallas`
  MODIFY `id_tipo_falla` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `DetalleOrden`
--
ALTER TABLE `DetalleOrden`
  ADD CONSTRAINT `DetalleOrden_ibfk_1` FOREIGN KEY (`id_orden`) REFERENCES `Ordenes` (`id_orden`);

--
-- Filtros para la tabla `Domicilios`
--
ALTER TABLE `Domicilios`
  ADD CONSTRAINT `Domicilios_ibfk_1` FOREIGN KEY (`cod_postal`) REFERENCES `Localidades` (`cod_postal`),
  ADD CONSTRAINT `Domicilios_ibfk_2` FOREIGN KEY (`id_provincia`) REFERENCES `Provincias` (`id_provincia`);

--
-- Filtros para la tabla `Empleados`
--
ALTER TABLE `Empleados`
  ADD CONSTRAINT `Empleados_ibfk_1` FOREIGN KEY (`id_domicilio`) REFERENCES `Domicilios` (`id_domicilio`);

--
-- Filtros para la tabla `Eventos`
--
ALTER TABLE `Eventos`
  ADD CONSTRAINT `Eventos_ibfk_1` FOREIGN KEY (`id_tipo_falla`) REFERENCES `TipoFallas` (`id_tipo_falla`),
  ADD CONSTRAINT `Eventos_ibfk_2` FOREIGN KEY (`legajo_tecnico`) REFERENCES `Empleados` (`legajo`),
  ADD CONSTRAINT `Eventos_ibfk_3` FOREIGN KEY (`cod_postal`) REFERENCES `Localidades` (`cod_postal`),
  ADD CONSTRAINT `Eventos_ibfk_4` FOREIGN KEY (`id_estado`) REFERENCES `Estados` (`id_estado`);

--
-- Filtros para la tabla `Localidades`
--
ALTER TABLE `Localidades`
  ADD CONSTRAINT `Localidades_ibfk_1` FOREIGN KEY (`id_provincia`) REFERENCES `Provincias` (`id_provincia`) ON DELETE CASCADE;

--
-- Filtros para la tabla `Ordenes`
--
ALTER TABLE `Ordenes`
  ADD CONSTRAINT `Ordenes2` FOREIGN KEY (`legajo_tecnico`) REFERENCES `Empleados` (`legajo`),
  ADD CONSTRAINT `Ordenes_ibfk_1` FOREIGN KEY (`id_evento`) REFERENCES `Eventos` (`id_evento`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

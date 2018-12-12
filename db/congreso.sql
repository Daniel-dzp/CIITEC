-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-09-2018 a las 09:07:59
-- Versión del servidor: 10.1.30-MariaDB
-- Versión de PHP: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `congreso`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `id_user` int(11) NOT NULL,
  `permisos` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asiste_confer`
--

CREATE TABLE `asiste_confer` (
  `id_conferencia` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `asistencia` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asiste_evento`
--

CREATE TABLE `asiste_evento` (
  `id_user` int(11) NOT NULL,
  `id_evento` int(11) NOT NULL,
  `asistencia` char(1) NOT NULL,
  `asiento` int(11) NOT NULL,
  `camion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asiste_taller`
--

CREATE TABLE `asiste_taller` (
  `id_user` int(11) NOT NULL,
  `id_taller` int(11) NOT NULL,
  `asistencia` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asiste_visita`
--

CREATE TABLE `asiste_visita` (
  `id_user` int(11) NOT NULL,
  `id_visita` int(11) NOT NULL,
  `asistencia` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conferencia`
--

CREATE TABLE `conferencia` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `lugar_conf` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `id_conferencista` int(11) NOT NULL,
  `costo` double NOT NULL,
  `cupo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conferencista`
--

CREATE TABLE `conferencista` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `genero` char(1) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `institucion` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `biografia` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_fiscales`
--

CREATE TABLE `datos_fiscales` (
  `id` int(11) NOT NULL,
  `RFC` char(12) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `Razon_Social` char(120) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `Domicilio` char(120) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `CP` char(6) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `Ciudad` char(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `Estado` char(30) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `id_user` int(11) NOT NULL,
  `facturado` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_reconocimientos`
--

CREATE TABLE `datos_reconocimientos` (
  `id` int(11) NOT NULL,
  `posiX` int(11) NOT NULL,
  `posiY` int(11) NOT NULL,
  `tipo` set('T','I','C') NOT NULL COMMENT 'Texto,imagen,Campo',
  `Contenido` text NOT NULL,
  `I` int(11) NOT NULL,
  `N` int(11) NOT NULL,
  `S` int(11) NOT NULL,
  `ancho` int(11) NOT NULL,
  `alto` int(11) NOT NULL COMMENT 'si es texto son mm de cada renglon',
  `TLetra` int(11) NOT NULL,
  `orden` int(11) NOT NULL DEFAULT '1',
  `cat` set('C','P','R','F','1','2','S') NOT NULL COMMENT 'Carta de aceptación o diploma ponente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egresos`
--

CREATE TABLE `egresos` (
  `id` int(11) NOT NULL,
  `concepto` text NOT NULL,
  `monto` float NOT NULL DEFAULT '0',
  `tipo` set('I','E') NOT NULL DEFAULT 'E'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento_social`
--

CREATE TABLE `evento_social` (
  `id` int(11) NOT NULL,
  `evento` varchar(300) NOT NULL,
  `lugar` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `observaciones` text NOT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `costo` double NOT NULL,
  `cupo` int(11) NOT NULL,
  `transporte` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ficha_deposito`
--

CREATE TABLE `ficha_deposito` (
  `id` int(11) NOT NULL,
  `ficha` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `monto` float NOT NULL,
  `idUser` int(11) NOT NULL,
  `idAutorizo` int(11) NOT NULL,
  `ref_bancaria` varchar(30) NOT NULL,
  `fecha` date NOT NULL,
  `Factura` char(1) NOT NULL,
  `tipo_pago` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1Art 2Con 3 CoA',
  `cuenta` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logos`
--

CREATE TABLE `logos` (
  `id` int(11) NOT NULL,
  `imagen` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `posicion` char(10) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `ancho` char(10) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `max_ancho` char(10) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `enlace` varchar(30) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `float` char(7) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id` int(11) NOT NULL,
  `mensaje` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos_efectivo`
--

CREATE TABLE `pagos_efectivo` (
  `id` int(11) NOT NULL,
  `monto` float NOT NULL,
  `id_user` int(11) NOT NULL COMMENT 'id_user/id_articulo',
  `tipo_pago` tinyint(4) NOT NULL COMMENT 'congreso/articulo',
  `id_autorizo` int(11) NOT NULL,
  `Factura` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taller`
--

CREATE TABLE `taller` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci,
  `Temario` text NOT NULL,
  `Requisitos` text NOT NULL,
  `lugar` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `id_tallerista` int(11) NOT NULL,
  `costo` double NOT NULL,
  `cupo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tallerista`
--

CREATE TABLE `tallerista` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(35) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `curriculum` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `institucion` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_user`
--

CREATE TABLE `tipo_user` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_user`
--

INSERT INTO `tipo_user` (`id`, `usuario`) VALUES
(1, 'congresista'),
(2, 'ponentes'),
(3, 'Revisor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `correo` char(70) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `nombre` char(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `apellidos` char(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechUltiAcceso` datetime DEFAULT NULL,
  `pwd` char(45) DEFAULT NULL,
  `id_tipo` int(11) DEFAULT '1',
  `estaPago` int(1) DEFAULT '0',
  `diploCongreso` tinyint(4) NOT NULL DEFAULT '0',
  `descDiploma` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visita_indus`
--

CREATE TABLE `visita_indus` (
  `id` int(11) NOT NULL,
  `empresa` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `costo` double NOT NULL,
  `cupo` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `observaciones` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id_user`);

--
-- Indices de la tabla `asiste_confer`
--
ALTER TABLE `asiste_confer`
  ADD PRIMARY KEY (`id_user`,`id_conferencia`),
  ADD KEY `id_conferencia` (`id_conferencia`);

--
-- Indices de la tabla `asiste_evento`
--
ALTER TABLE `asiste_evento`
  ADD PRIMARY KEY (`id_user`,`id_evento`),
  ADD KEY `id_evento` (`id_evento`);

--
-- Indices de la tabla `asiste_taller`
--
ALTER TABLE `asiste_taller`
  ADD PRIMARY KEY (`id_user`,`id_taller`),
  ADD KEY `id_taller` (`id_taller`);

--
-- Indices de la tabla `asiste_visita`
--
ALTER TABLE `asiste_visita`
  ADD PRIMARY KEY (`id_user`,`id_visita`),
  ADD KEY `id_visita` (`id_visita`);

--
-- Indices de la tabla `conferencia`
--
ALTER TABLE `conferencia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_conferencista` (`id_conferencista`);

--
-- Indices de la tabla `conferencista`
--
ALTER TABLE `conferencista`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `datos_fiscales`
--
ALTER TABLE `datos_fiscales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indices de la tabla `datos_reconocimientos`
--
ALTER TABLE `datos_reconocimientos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `egresos`
--
ALTER TABLE `egresos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `evento_social`
--
ALTER TABLE `evento_social`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ficha_deposito`
--
ALTER TABLE `ficha_deposito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idAutorizo` (`idAutorizo`),
  ADD KEY `idUser` (`idUser`);

--
-- Indices de la tabla `logos`
--
ALTER TABLE `logos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pagos_efectivo`
--
ALTER TABLE `pagos_efectivo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_autorizo` (`id_autorizo`);

--
-- Indices de la tabla `taller`
--
ALTER TABLE `taller`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tallerista` (`id_tallerista`);

--
-- Indices de la tabla `tallerista`
--
ALTER TABLE `tallerista`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_user`
--
ALTER TABLE `tipo_user`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `id_tipo` (`id_tipo`);

--
-- Indices de la tabla `visita_indus`
--
ALTER TABLE `visita_indus`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `conferencia`
--
ALTER TABLE `conferencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `conferencista`
--
ALTER TABLE `conferencista`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `datos_fiscales`
--
ALTER TABLE `datos_fiscales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `datos_reconocimientos`
--
ALTER TABLE `datos_reconocimientos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `egresos`
--
ALTER TABLE `egresos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `evento_social`
--
ALTER TABLE `evento_social`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ficha_deposito`
--
ALTER TABLE `ficha_deposito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `logos`
--
ALTER TABLE `logos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pagos_efectivo`
--
ALTER TABLE `pagos_efectivo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `taller`
--
ALTER TABLE `taller`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tallerista`
--
ALTER TABLE `tallerista`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_user`
--
ALTER TABLE `tipo_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `visita_indus`
--
ALTER TABLE `visita_indus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asiste_confer`
--
ALTER TABLE `asiste_confer`
  ADD CONSTRAINT `asiste_confer_ibfk_1` FOREIGN KEY (`id_conferencia`) REFERENCES `conferencia` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asiste_confer_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `asiste_evento`
--
ALTER TABLE `asiste_evento`
  ADD CONSTRAINT `asiste_evento_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asiste_evento_ibfk_2` FOREIGN KEY (`id_evento`) REFERENCES `evento_social` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `asiste_taller`
--
ALTER TABLE `asiste_taller`
  ADD CONSTRAINT `asiste_taller_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asiste_taller_ibfk_2` FOREIGN KEY (`id_taller`) REFERENCES `taller` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `asiste_visita`
--
ALTER TABLE `asiste_visita`
  ADD CONSTRAINT `asiste_visita_ibfk_1` FOREIGN KEY (`id_visita`) REFERENCES `visita_indus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asiste_visita_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `conferencia`
--
ALTER TABLE `conferencia`
  ADD CONSTRAINT `conferencia_ibfk_1` FOREIGN KEY (`id_conferencista`) REFERENCES `conferencista` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `datos_fiscales`
--
ALTER TABLE `datos_fiscales`
  ADD CONSTRAINT `datos_fiscales_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ficha_deposito`
--
ALTER TABLE `ficha_deposito`
  ADD CONSTRAINT `ficha_deposito_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pagos_efectivo`
--
ALTER TABLE `pagos_efectivo`
  ADD CONSTRAINT `pagos_efectivo_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `taller`
--
ALTER TABLE `taller`
  ADD CONSTRAINT `taller_ibfk_1` FOREIGN KEY (`id_tallerista`) REFERENCES `tallerista` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 20-04-2025 a las 11:57:22
-- Versión del servidor: 5.7.44
-- Versión de PHP: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `isla_transfers`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tranfer_hotel`
--

CREATE TABLE `tranfer_hotel` (
  `id_hotel` int(11) NOT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `Comision` varchar(50) DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tranfer_hotel`
--

INSERT INTO `tranfer_hotel` (`id_hotel`, `id_zona`, `Comision`, `usuario`, `password`) VALUES
(1, 1, '50 euros', 'admin@demo.com', '$2y$10$82ihgxbrDs1Ir0/l08z42edwpB7igy.sS8An2x46hTZG6lxOVuTCa'),
(2, 1, '60 euros', 'admin@demo.com', '$2y$10$82ihgxbrDs1Ir0/l08z42edwpB7igy.sS8An2x46hTZG6lxOVuTCa'),
(3, 1, '100 euros', 'admin@demo.com', '$2y$10$82ihgxbrDs1Ir0/l08z42edwpB7igy.sS8An2x46hTZG6lxOVuTCa'),
(5, 1, '10', 'admin@demo.com', '$2y$10$SooLtAAQNQMrkNwoVOcLU.24HDFvHOMC7EzvefvbAsAnjOWnG4ULK'),
(6, 10, '2', 'admin@demo.com', '$2y$10$JG.kpgQar0tHM1IvrJFkYu81RqkWqlb/A1d9nBSh.hQEcpvaGafYm');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transfer_precios`
--

CREATE TABLE `transfer_precios` (
  `id_precios` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `id_hotel` int(11) NOT NULL,
  `Precio` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `transfer_precios`
--

INSERT INTO `transfer_precios` (`id_precios`, `id_vehiculo`, `id_hotel`, `Precio`) VALUES
(1, 1, 1, '100 euros/noche'),
(2, 1, 2, '200 euros/noche'),
(3, 1, 3, '500 euros/noche');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transfer_reservas`
--

CREATE TABLE `transfer_reservas` (
  `id_reserva` int(11) NOT NULL,
  `localizador` varchar(100) NOT NULL,
  `id_hotel` int(11) DEFAULT NULL COMMENT 'Es el hotel que realiza la reserva',
  `id_tipo_reserva` int(11) NOT NULL,
  `email_cliente` varchar(50) NOT NULL,
  `fecha_reserva` datetime NOT NULL,
  `fecha_modificacion` datetime NOT NULL,
  `id_destino` int(11) NOT NULL,
  `fecha_entrada` date NOT NULL,
  `hora_entrada` time NOT NULL,
  `numero_vuelo_entrada` varchar(50) NOT NULL,
  `origen_vuelo_entrada` varchar(50) NOT NULL,
  `hora_vuelo_salida` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fecha_vuelo_salida` date NOT NULL,
  `num_viajeros` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `transfer_reservas`
--

INSERT INTO `transfer_reservas` (`id_reserva`, `localizador`, `id_hotel`, `id_tipo_reserva`, `email_cliente`, `fecha_reserva`, `fecha_modificacion`, `id_destino`, `fecha_entrada`, `hora_entrada`, `numero_vuelo_entrada`, `origen_vuelo_entrada`, `hora_vuelo_salida`, `fecha_vuelo_salida`, `num_viajeros`, `id_vehiculo`) VALUES
(1, '15D4F5C8', 1, 1, 'admin@demo.com', '2025-04-19 15:53:04', '2025-04-19 15:53:04', 1, '2025-04-25', '10:00:00', '126547A', 'Vietnam', '2025-04-19 14:30:00', '2025-04-19', 2, 1),
(2, '23FEC39C', 1, 1, 'admin@demo.com', '2025-04-20 09:14:29', '2025-04-20 09:14:29', 1, '2022-02-22', '11:11:00', '1', 'Barcelona', '2025-04-20 11:11:00', '2025-04-20', 1, 1),
(3, '55BB6F2C', 1, 1, 'particular@gmail.com', '2025-04-20 09:17:29', '2025-04-20 09:17:29', 1, '2022-11-11', '11:11:00', '2', 'Barcelona', '2025-04-20 11:11:00', '2025-04-20', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transfer_tipo_reserva`
--

CREATE TABLE `transfer_tipo_reserva` (
  `id_tipo_reserva` int(11) NOT NULL,
  `Descripción` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `transfer_tipo_reserva`
--

INSERT INTO `transfer_tipo_reserva` (`id_tipo_reserva`, `Descripción`) VALUES
(1, 'Estandar'),
(2, 'Premium'),
(3, 'VIP');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transfer_vehiculo`
--

CREATE TABLE `transfer_vehiculo` (
  `id_vehiculo` int(11) NOT NULL,
  `description` varchar(100) NOT NULL,
  `email_conductor` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `transfer_vehiculo`
--

INSERT INTO `transfer_vehiculo` (`id_vehiculo`, `description`, `email_conductor`, `password`) VALUES
(1, 'Mercedes Benz', 'pepito@conductor.com', '$2y$10$1FTd2ZMVka3MgzULcWG02uSP7ePH.fq1ggB3xEHvg1197NPweBHgC');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transfer_viajeros`
--

CREATE TABLE `transfer_viajeros` (
  `id_viajero` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido1` varchar(100) NOT NULL,
  `apellido2` varchar(100) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `codigoPostal` varchar(100) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `pais` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `tipo_cliente` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `transfer_viajeros`
--

INSERT INTO `transfer_viajeros` (`id_viajero`, `nombre`, `apellido1`, `apellido2`, `direccion`, `codigoPostal`, `ciudad`, `pais`, `email`, `password`, `tipo_cliente`) VALUES
(3, 'Pedro', 'demo', 'demo2', 'calle falsa 123', '08080', 'Barcelona', 'España', 'admin@demo.com', '$2y$10$NHDXWJpsBwe3HSXDqM8DJuabQ8N67yte69kaPtfMPwvl57GwTlMQm', 'administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transfer_zona`
--

CREATE TABLE `transfer_zona` (
  `id_zona` int(11) NOT NULL,
  `descripcion` varchar(40) NOT NULL,
  `nombre_zona` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `transfer_zona`
--

INSERT INTO `transfer_zona` (`id_zona`, `descripcion`, `nombre_zona`) VALUES
(1, 'La zona mas molona es la de Barcelona.', 'Zona Norte'),
(2, 'Zona Sur', 'Zona Sur'),
(3, 'Zona Este', 'Zona Este'),
(4, 'Zona Oeste', 'Zona Oeste'),
(5, 'Zona Centro', 'Zona Centro'),
(6, 'Zona Montaña', 'Zona Montaña'),
(7, 'Zona Playa', 'Zona Playa'),
(8, 'Zona Campo', 'Zona Campo'),
(9, 'Zona Ciudad', 'Zona Ciudad'),
(10, 'Zona Internacional', 'Zona Internacional');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tranfer_hotel`
--
ALTER TABLE `tranfer_hotel`
  ADD PRIMARY KEY (`id_hotel`),
  ADD KEY `FK_HOTEL_ZONA` (`id_zona`);

--
-- Indices de la tabla `transfer_precios`
--
ALTER TABLE `transfer_precios`
  ADD KEY `FK_PRECIOS_HOTEL` (`id_hotel`),
  ADD KEY `FK_PRECIOS_VEHICULO` (`id_vehiculo`);

--
-- Indices de la tabla `transfer_reservas`
--
ALTER TABLE `transfer_reservas`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `FK_RESERVAS_DESTINO` (`id_destino`),
  ADD KEY `FK_RESERVAS_HOTEL` (`id_hotel`),
  ADD KEY `FK_RESERVAS_TIPO` (`id_tipo_reserva`),
  ADD KEY `FK_RESERVAS_VEHICULO` (`id_vehiculo`);

--
-- Indices de la tabla `transfer_tipo_reserva`
--
ALTER TABLE `transfer_tipo_reserva`
  ADD PRIMARY KEY (`id_tipo_reserva`);

--
-- Indices de la tabla `transfer_vehiculo`
--
ALTER TABLE `transfer_vehiculo`
  ADD PRIMARY KEY (`id_vehiculo`);

--
-- Indices de la tabla `transfer_viajeros`
--
ALTER TABLE `transfer_viajeros`
  ADD PRIMARY KEY (`id_viajero`);

--
-- Indices de la tabla `transfer_zona`
--
ALTER TABLE `transfer_zona`
  ADD PRIMARY KEY (`id_zona`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tranfer_hotel`
--
ALTER TABLE `tranfer_hotel`
  MODIFY `id_hotel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `transfer_reservas`
--
ALTER TABLE `transfer_reservas`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `transfer_tipo_reserva`
--
ALTER TABLE `transfer_tipo_reserva`
  MODIFY `id_tipo_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `transfer_vehiculo`
--
ALTER TABLE `transfer_vehiculo`
  MODIFY `id_vehiculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `transfer_viajeros`
--
ALTER TABLE `transfer_viajeros`
  MODIFY `id_viajero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `transfer_zona`
--
ALTER TABLE `transfer_zona`
  MODIFY `id_zona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tranfer_hotel`
--
ALTER TABLE `tranfer_hotel`
  ADD CONSTRAINT `FK_HOTEL_ZONA` FOREIGN KEY (`id_zona`) REFERENCES `transfer_zona` (`id_zona`);

--
-- Filtros para la tabla `transfer_precios`
--
ALTER TABLE `transfer_precios`
  ADD CONSTRAINT `FK_PRECIOS_HOTEL` FOREIGN KEY (`id_hotel`) REFERENCES `tranfer_hotel` (`id_hotel`),
  ADD CONSTRAINT `FK_PRECIOS_VEHICULO` FOREIGN KEY (`id_vehiculo`) REFERENCES `transfer_vehiculo` (`id_vehiculo`);

--
-- Filtros para la tabla `transfer_reservas`
--
ALTER TABLE `transfer_reservas`
  ADD CONSTRAINT `FK_RESERVAS_DESTINO` FOREIGN KEY (`id_destino`) REFERENCES `tranfer_hotel` (`id_hotel`),
  ADD CONSTRAINT `FK_RESERVAS_HOTEL` FOREIGN KEY (`id_hotel`) REFERENCES `tranfer_hotel` (`id_hotel`),
  ADD CONSTRAINT `FK_RESERVAS_TIPO` FOREIGN KEY (`id_tipo_reserva`) REFERENCES `transfer_tipo_reserva` (`id_tipo_reserva`),
  ADD CONSTRAINT `FK_RESERVAS_VEHICULO` FOREIGN KEY (`id_vehiculo`) REFERENCES `transfer_vehiculo` (`id_vehiculo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 14-02-2024 a las 22:26:54
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `demo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `apis`
--

CREATE TABLE `apis` (
  `id` int(11) NOT NULL,
  `api_name` varchar(50) DEFAULT NULL,
  `url` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `apis`
--

INSERT INTO `apis` (`id`, `api_name`, `url`) VALUES
(1, 'api_1', 'https://securedatacorner.com/demo/api/1'),
(2, 'api_2', 'https://securedatacorner.com/demo/api/2'),
(3, 'api_3', 'https://securedatacorner.com/demo/api/3'),
(4, 'api_4', 'https://securedatacorner.com/demo/api/4'),
(5, 'api_5', 'https://securedatacorner.com/demo/api/5'),
(6, 'api_6', 'https://securedatacorner.com/demo/api/6'),
(7, 'api_7', 'https://securedatacorner.com/demo/api/7'),
(8, 'api_8', 'https://securedatacorner.com/demo/api/8');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stats_2`
--

CREATE TABLE `stats_2` (
  `id` int(11) NOT NULL,
  `subid` varchar(20) DEFAULT NULL,
  `dday` date DEFAULT NULL,
  `geo` varchar(7) DEFAULT NULL,
  `partner` varchar(50) DEFAULT NULL,
  `channel` varchar(20) DEFAULT NULL,
  `searches` int(11) NOT NULL DEFAULT 0,
  `monetized` int(11) NOT NULL DEFAULT 0,
  `clicks` int(11) NOT NULL DEFAULT 0,
  `revenue` float NOT NULL DEFAULT 0,
  `ctr` decimal(10,2) DEFAULT NULL,
  `cpc` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `userName` varchar(12) NOT NULL,
  `password` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `userName`, `password`) VALUES
(1, 'admin', '$2y$10$/SV60ndDJIC89EgftvliUuynQ5GjGYkXT8BXNmCePC48T69TIMij2');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `apis`
--
ALTER TABLE `apis`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `stats_2`
--
ALTER TABLE `stats_2`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subid` (`subid`,`dday`,`geo`,`channel`) USING BTREE;

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `apis`
--
ALTER TABLE `apis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `stats_2`
--
ALTER TABLE `stats_2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

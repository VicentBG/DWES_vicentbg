-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 16-01-2021 a las 18:33:17
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `videoclub`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actores`
--

CREATE TABLE `actores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `anyoNacimiento` int(4) NOT NULL,
  `pais` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `actores`
--

INSERT INTO `actores` (`id`, `nombre`, `anyoNacimiento`, `pais`) VALUES
(1, 'Marlon Brandon', 1924, 'Estados Unidos'),
(2, 'Al Pacino', 1940, 'Estados Unidos'),
(3, 'Robert Duvall', 1931, 'Estados Unidos'),
(4, 'James Cann', 1940, 'Estados Unidos'),
(5, 'Diane Keaton', 1946, 'Estados Unidos'),
(6, 'Robert de Niro', 1943, 'Estados Unidos'),
(7, 'Kirk Douglas', 1916, 'Estados Unidos'),
(8, 'Ralph Meeker', 1920, 'Estados Unidos'),
(9, 'Adolphe Menjou', 1890, 'Estados Unidos'),
(10, 'Jack Lemmon', 1925, 'Estados Unidos'),
(11, 'Walter Matthau', 1920, 'Estados Unidos'),
(12, 'Susan Sarandon', 1946, 'Estados Unidos'),
(13, 'El Fary II', 1957, 'Catalonia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `directores`
--

CREATE TABLE `directores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `anyoNacimiento` int(4) NOT NULL,
  `pais` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `directores`
--

INSERT INTO `directores` (`id`, `nombre`, `anyoNacimiento`, `pais`) VALUES
(1, 'Francis Ford Coppola', 1939, 'Estados Unidos'),
(2, 'Stanley Kubrick', 1928, 'Estados Unidos'),
(3, 'Billy Wilder', 1906, 'Polonia'),
(4, 'El Gran Wyoming', 1951, 'España');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peliculas`
--

CREATE TABLE `peliculas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `anyo` int(4) NOT NULL,
  `duracion` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `peliculas`
--

INSERT INTO `peliculas` (`id`, `titulo`, `anyo`, `duracion`) VALUES
(1, 'El Padrino', 1972, 175),
(2, 'El Padrino 2', 1974, 200),
(3, 'Senderos de gloria', 1957, 86),
(4, 'Primera plana', 1974, 105),
(5, 'Fiebre del sabadete noche', 2020, 155);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peliculas_actores`
--

CREATE TABLE `peliculas_actores` (
  `id_pelicula` int(11) NOT NULL,
  `id_actor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `peliculas_actores`
--

INSERT INTO `peliculas_actores` (`id_pelicula`, `id_actor`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(2, 1),
(2, 2),
(2, 3),
(2, 5),
(2, 6),
(3, 7),
(3, 8),
(3, 9),
(5, 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peliculas_directores`
--

CREATE TABLE `peliculas_directores` (
  `id_pelicula` int(11) NOT NULL,
  `id_director` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `peliculas_directores`
--

INSERT INTO `peliculas_directores` (`id_pelicula`, `id_director`) VALUES
(1, 1),
(2, 1),
(3, 2),
(4, 3),
(5, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `guardaCredenciales` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `password`, `guardaCredenciales`) VALUES
(1, 'prueba@pruebas.com', 'prueba', 0),
(2, 'v@b.g', 'vbg', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actores`
--
ALTER TABLE `actores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `directores`
--
ALTER TABLE `directores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `titulo` (`titulo`);

--
-- Indices de la tabla `peliculas_actores`
--
ALTER TABLE `peliculas_actores`
  ADD PRIMARY KEY (`id_pelicula`,`id_actor`),
  ADD KEY `id_actor` (`id_actor`);

--
-- Indices de la tabla `peliculas_directores`
--
ALTER TABLE `peliculas_directores`
  ADD PRIMARY KEY (`id_pelicula`,`id_director`),
  ADD KEY `id_director` (`id_director`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actores`
--
ALTER TABLE `actores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `directores`
--
ALTER TABLE `directores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `peliculas_actores`
--
ALTER TABLE `peliculas_actores`
  ADD CONSTRAINT `peliculas_actores_ibfk_1` FOREIGN KEY (`id_pelicula`) REFERENCES `peliculas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `peliculas_actores_ibfk_2` FOREIGN KEY (`id_actor`) REFERENCES `actores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `peliculas_directores`
--
ALTER TABLE `peliculas_directores`
  ADD CONSTRAINT `peliculas_directores_ibfk_1` FOREIGN KEY (`id_pelicula`) REFERENCES `peliculas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `peliculas_directores_ibfk_2` FOREIGN KEY (`id_director`) REFERENCES `directores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

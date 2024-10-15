-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-07-2024 a las 05:09:11
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
-- Base de datos: `proyecto_credencial`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cooperativa`
--

CREATE TABLE `cooperativa` (
  `id_cooperativa` int(11) NOT NULL,
  `cooperativa` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cooperativa`
--

INSERT INTO `cooperativa` (`id_cooperativa`, `cooperativa`, `email`) VALUES
(1, 'cos', 'cos@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `establecimiento_educativo`
--

CREATE TABLE `establecimiento_educativo` (
  `id_establecimiento_educativo` int(10) NOT NULL,
  `CUE` int(100) NOT NULL,
  `establecimiento_educativo` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `token` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `establecimiento_educativo`
--

INSERT INTO `establecimiento_educativo` (`id_establecimiento_educativo`, `CUE`, `establecimiento_educativo`, `email`, `token`) VALUES
(13, 60774600, 'Secundaria 4', 'ees4lacosta@gmail.com', ''),
(15, 60777300, 'MS1', ' ees1lacosta@gmail.com', ''),
(20, 60826200, 'Secundaria 3', 'ees3lacosta@gmail.com', ''),
(22, 60826400, 'Tecnica 1', 'eest1lacosta@gmail.com', ''),
(26, 61188000, 'Secundaria 13', 'ees13lacosta@gmail.com', ''),
(33, 61676100, 'Secundaria 7', 'ees7lacosta@gmail.com', ''),
(36, 61723200, 'Secundaria 9', 'ees9lacosta@gmail.com', ''),
(37, 61727100, 'MS2', 'ees2lacosta@gmail.com', ''),
(38, 61767200, 'Secundaria 8', 'ees8lacosta@gmail.com', ''),
(39, 61767300, 'Secundaria 10', 'ees10lacosta@gmail.com', ''),
(40, 61806600, 'Secundaria 12', 'ees12lacosta@gmail.com', ''),
(41, 61986200, 'Secundaria 11', 'ees11lacosta@gmail.com', ''),
(43, 62177000, 'Tecnica 2', 'eest2lacosta@gmail.com', ''),
(47, 62286600, 'Secundaria 14', 'ees14lacosta@gmail.com', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante`
--

CREATE TABLE `estudiante` (
  `id_estudiante` int(11) NOT NULL,
  `DNI` int(8) NOT NULL,
  `nombre_apellido` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `desde` varchar(50) NOT NULL,
  `hasta` varchar(50) NOT NULL,
  `establecimiento_educativo` varchar(100) NOT NULL,
  `img_documento_frente` varchar(200) NOT NULL,
  `img_documento_reverso` varchar(200) NOT NULL,
  `img_estudiante` varchar(200) NOT NULL,
  `img_constancia_alumno` varchar(200) NOT NULL,
  `estado_credencial` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estudiante`
--

INSERT INTO `estudiante` (`id_estudiante`, `DNI`, `nombre_apellido`, `email`, `direccion`, `desde`, `hasta`, `establecimiento_educativo`, `img_documento_frente`, `img_documento_reverso`, `img_estudiante`, `img_constancia_alumno`, `estado_credencial`) VALUES
(59, 47017713, 'ciro lazarte', 'cirolazarte713@gmail.com', 'calle 36 n1518', '1', '8', '13', 'uploads/dni frente.jpeg', 'uploads/dni atras.png', 'uploads/WhatsApp Image 2024-02-27 at 01.06.55.jpeg', 'uploads/images.jpg', 'habilitado'),
(60, 46872050, 'facundo aragon', 'cirolazarte713@gmail.com', 'calle 36 n1518', '7', '8', '22', 'uploads/dni frente.jpeg', 'uploads/dni atras.png', 'uploads/WhatsApp Image 2024-02-27 at 01.06.55.jpeg', 'uploads/images.jpg', 'habilitado'),
(61, 12345678, 'pepe', 'titocalderom@gmail.com', 'calle 36 n1518', '1', '8', '22', 'uploads/dni frente.jpeg', 'uploads/dni atras.png', 'uploads/foto.jpg', 'uploads/images.jpg', 'habilitado'),
(62, 46896312, 'Martin Oyola Fernández', 'martin.oyola100@yahoo.com', 'aaaa', '1', '1', '20', '../uploads/CROMECRAFT2.png', '../uploads/JUAN DOMINGO PERON.png', '../uploads/imagen_2024-06-19_011713925-removebg-preview.png', '../uploads/imagen_2024-07-04_233713148.png', 'habilitado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `localidades`
--

CREATE TABLE `localidades` (
  `id_localidad` int(10) NOT NULL,
  `localidad` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `localidades`
--

INSERT INTO `localidades` (`id_localidad`, `localidad`) VALUES
(1, 'Mar de Ajo'),
(2, 'San Bernardo'),
(3, 'Costa Azul'),
(4, 'La Lucila del Mar'),
(5, 'Aguas Verdes'),
(6, 'Costa del Este'),
(7, 'Mar del Tuyu'),
(8, 'Santa Teresita'),
(9, 'Costa Chica'),
(10, 'Las Toninas'),
(11, 'San Clemente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `usuario` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `usuario`, `password`) VALUES
(18, 'cos@gmail.com', '$2y$10$a5SUHCNxUVsqgL1Ri8hP1.BoxejDlbnHW.BKSOjtPPOxUJiIBZaS2'),
(12345681, '2222222', '$2y$10$Y.Je6lknWAxaHSncj810fe6l3VzG8E7ZTn/0kA8CqHlT9.jISmDLC'),
(12345682, '60209200', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345683, '60209400', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345684, '60247400', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345685, '60247600', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345686, '60247800', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345687, '60542700', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345688, '60542800', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345689, '60542900', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345690, '60543000', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345691, '60547500', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345692, '60767500', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345693, '60774600', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345694, '60777200', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345695, '60777300', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345696, '60788600', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345697, '60788700', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345698, '60788800', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345699, '60788900', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345700, '60826200', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345701, '60826300', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345702, '60826400', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345703, '60826600', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345704, '60826700', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345705, '61187900', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345706, '61188000', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345707, '61188200', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345708, '61279200', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345709, '61282200', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345710, '61303900', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345711, '61304900', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345712, '61392100', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345713, '61676100', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345714, '61684600', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345715, '61696400', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345716, '61723200', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345717, '61727100', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345718, '61767200', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345719, '61767300', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345720, '61806600', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345721, '61986200', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345722, '62089600', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345723, '62177000', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345724, '62177800', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345725, '62200800', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345726, '62240000', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345727, '62286600', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345728, '62330600', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345744, '62286600', '$2y$10$7sWqj9aNe2oc/t7wgRaGE.Vzg8EnIcYcHjGYwu1.mOitEiTko9HXS'),
(12345745, '47017713', '$2y$10$gBW.ed2iVpS8zGYbf9iZkevyP2.5LGI0sCOc7bgVqMoEjXByDCe6u'),
(12345746, '46872050', '$2y$10$HsivRo/WdqzuZAZIovVUB.cd2/QLEn7M9QF/fkfJxw37kmNdUERZG'),
(12345747, '12345678', '$2y$10$3b8kXdLtYwimLt4qG2YBzeaxm0fGvjcfEk3I7zmVZZsVEyT0xV6xy'),
(12345748, '46896312', '$2y$10$fq.RO8eUHsbwsnrc6NYv1eIkeeUuiJqp.Il3HT1/4eZS5oOxh7d2W');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cooperativa`
--
ALTER TABLE `cooperativa`
  ADD PRIMARY KEY (`id_cooperativa`);

--
-- Indices de la tabla `establecimiento_educativo`
--
ALTER TABLE `establecimiento_educativo`
  ADD PRIMARY KEY (`id_establecimiento_educativo`);

--
-- Indices de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD PRIMARY KEY (`id_estudiante`),
  ADD UNIQUE KEY `DNI` (`DNI`);

--
-- Indices de la tabla `localidades`
--
ALTER TABLE `localidades`
  ADD PRIMARY KEY (`id_localidad`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `establecimiento_educativo`
--
ALTER TABLE `establecimiento_educativo`
  MODIFY `id_establecimiento_educativo` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  MODIFY `id_estudiante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de la tabla `localidades`
--
ALTER TABLE `localidades`
  MODIFY `id_localidad` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12345749;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

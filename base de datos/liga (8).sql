-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-10-2026 a las 18:20:31
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `liga`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `avisos`
--

CREATE TABLE `avisos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `contenido` text NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `boletines`
--

CREATE TABLE `boletines` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `archivo` varchar(255) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carnets`
--

CREATE TABLE `carnets` (
  `id` int(11) NOT NULL,
  `id_jugador` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `fecha_vencimiento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `año` varchar(45) NOT NULL,
  `cantidad_jugadores` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `año`, `cantidad_jugadores`) VALUES
(12, '2013', 0),
(13, '2014', 0),
(14, '2015', 0),
(15, '2016', 0),
(16, '2017', 0),
(18, '2018', 0),
(19, '2019', 0),
(20, '2020', 0),
(21, 'Femenino', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `club`
--

CREATE TABLE `club` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `club`
--

INSERT INTO `club` (`id`, `nombre`, `logo`, `activo`, `password`) VALUES
(18, 'Montevideo City Torque', NULL, 1, ''),
(19, 'Nacional', NULL, 1, ''),
(20, 'Cerro Largo', NULL, 1, ''),
(21, 'Peñarol', NULL, 1, ''),
(22, 'Deportivo Maldonado', NULL, 1, ''),
(23, 'Racing', NULL, 1, ''),
(24, 'Liverpool', NULL, 1, ''),
(25, 'Wanderers', NULL, 1, ''),
(26, 'Albion', NULL, 1, ''),
(27, 'Juventud', NULL, 1, ''),
(28, 'Central', NULL, 1, ''),
(29, 'Boston River', NULL, 1, ''),
(30, 'Cerro', NULL, 1, ''),
(31, 'Danubio', NULL, 1, ''),
(32, 'Progreso', NULL, 1, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `competicion`
--

CREATE TABLE `competicion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `competicion`
--

INSERT INTO `competicion` (`id`, `nombre`) VALUES
(1, 'Copa Oro'),
(2, 'Copa Plata');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jugadores`
--

CREATE TABLE `jugadores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `apellido` varchar(45) DEFAULT NULL,
  `cedula` varchar(45) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `id_club` int(11) DEFAULT NULL,
  `id_categoria` varchar(45) DEFAULT NULL,
  `masa` decimal(5,2) DEFAULT NULL,
  `altura` decimal(4,2) DEFAULT NULL,
  `peso` decimal(10,2) DEFAULT NULL,
  `velocidad` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `jugadores`
--

INSERT INTO `jugadores` (`id`, `nombre`, `apellido`, `cedula`, `fecha_nacimiento`, `id_club`, `id_categoria`, `masa`, `altura`, `peso`, `velocidad`) VALUES
(268, 'Luis', 'Gonzalez', '64355724', '2013-01-31', 19, '22', 40.00, 1.20, 392.00, 4.85),
(269, 'Abril', 'Cabrera', '74516251', '2016-01-17', 18, '21', 11.94, 1.37, 31.38, 19.92),
(270, 'Luna', 'Sosa', '20545155', '2016-08-02', 18, '21', 12.23, 1.34, 30.21, 20.84),
(271, 'Manuel', 'Fernández', '51870616', '2017-12-24', 18, '16', 9.19, 1.24, 25.74, 18.06),
(272, 'Tomás', 'López', '64982074', '2014-06-26', 18, '13', 12.26, 1.40, 30.78, 19.46),
(273, 'Tomás', 'Techera', '79103764', '2013-02-10', 18, '12', 12.43, 1.38, 31.91, 23.19),
(274, 'Renata', 'Méndez', '78872952', '2017-07-06', 19, '21', 9.86, 1.22, 25.06, 19.12),
(275, 'Emiliano', 'Méndez', '73687075', '2016-02-06', 19, '15', 10.94, 1.30, 27.46, 19.71),
(276, 'Luna', 'Sosa', '39213949', '2014-04-23', 19, '21', 14.36, 1.48, 35.72, 18.53),
(277, 'Joaquín', 'Suárez', '74982185', '2014-07-25', 19, '13', 14.96, 1.43, 36.02, 21.87),
(278, 'Simón', 'Techera', '67090977', '2013-11-26', 19, '12', 12.57, 1.45, 34.94, 22.28),
(279, 'Emma', 'Martínez', '59262877', '2016-11-17', 20, '21', 12.91, 1.37, 33.31, 17.59),
(280, 'Facundo', 'Correa', '77186019', '2019-10-11', 20, '19', 9.68, 1.23, 24.34, 15.34),
(281, 'Agustín', 'Píriz', '42094671', '2017-05-17', 20, '16', 9.43, 1.29, 25.93, 18.06),
(282, 'Zoe', 'Píriz', '73598967', '2018-04-02', 20, '21', 9.31, 1.23, 23.86, 16.97),
(283, 'Facundo', 'Bentancur', '20047971', '2019-04-12', 20, '19', 10.00, 1.23, 26.10, 15.81),
(284, 'Abril', 'Silva', '64686632', '2014-02-13', 21, '21', 13.01, 1.36, 31.10, 18.44),
(285, 'Bianca', 'Martínez', '37766922', '2018-03-07', 21, '21', 6.82, 1.16, 19.32, 15.12),
(286, 'Agustín', 'Píriz', '74515724', '2018-12-20', 21, '18', 10.26, 1.22, 24.46, 18.15),
(287, 'Dylan', 'Vázquez', '69361936', '2020-09-21', 21, '20', 6.56, 1.09, 19.01, 16.26),
(288, 'Mateo', 'Pereira', '22635106', '2013-02-06', 21, '12', 13.20, 1.49, 38.23, 21.53),
(289, 'Mateo', 'Ramos', '24544202', '2018-07-28', 22, '18', 9.55, 1.24, 25.49, 15.61),
(290, 'Delfina', 'Méndez', '29166156', '2017-11-27', 22, '21', 10.80, 1.31, 29.42, 18.82),
(291, 'Mateo', 'Acosta', '26323749', '2016-04-07', 22, '15', 9.88, 1.30, 27.87, 16.23),
(292, 'Renata', 'Sosa', '27823449', '2020-02-20', 22, '21', 10.43, 1.16, 25.64, 16.16),
(293, 'Manuel', 'Olivera', '20180808', '2014-03-27', 22, '13', 13.69, 1.38, 33.46, 21.69),
(294, 'Felipe', 'Acosta', '24795374', '2017-01-30', 23, '16', 9.78, 1.26, 24.47, 17.16),
(295, 'Joaquín', 'Morales', '35588124', '2020-09-01', 23, '20', 6.13, 1.05, 17.38, 15.05),
(296, 'Lautaro', 'Bentancur', '67787835', '2019-02-04', 23, '19', 7.51, 1.17, 21.49, 14.59),
(297, 'Julieta', 'Morales', '41874614', '2017-11-01', 23, '21', 10.94, 1.30, 27.87, 16.88),
(298, 'Catalina', 'Castro', '45165574', '2019-06-10', 23, '21', 8.51, 1.16, 21.62, 16.90),
(299, 'Facundo', 'Correa', '65568423', '2018-03-09', 24, '18', 11.21, 1.33, 27.32, 16.44),
(300, 'Ian', 'Medina', '76024424', '2014-11-10', 24, '13', 14.97, 1.45, 39.16, 20.74),
(301, 'Clara', 'Medina', '33039911', '2013-12-06', 24, '21', 16.40, 1.57, 45.40, 23.77),
(302, 'Santiago', 'Medina', '42144571', '2020-11-05', 24, '20', 7.24, 1.07, 18.32, 15.74),
(303, 'Zoe', 'Ramos', '20297431', '2020-05-08', 24, '21', 7.66, 1.22, 22.06, 13.50),
(304, 'Tomás', 'Silva', '68864448', '2015-12-20', 25, '14', 14.14, 1.40, 34.75, 19.00),
(305, 'Agustín', 'Martínez', '50015213', '2018-08-09', 25, '18', 10.96, 1.26, 26.60, 17.79),
(306, 'Gael', 'Castro', '54089402', '2017-05-08', 25, '16', 8.56, 1.18, 22.25, 16.87),
(307, 'Agustina', 'Barrios', '54585763', '2015-03-21', 25, '21', 11.75, 1.42, 33.28, 20.27),
(308, 'Valentina', 'Fernández', '40817770', '2020-06-19', 25, '21', 7.61, 1.10, 19.34, 13.09),
(309, 'Dylan', 'Medina', '43414701', '2014-04-27', 26, '13', 14.11, 1.44, 37.95, 20.91),
(310, 'Victoria', 'Méndez', '22315308', '2013-09-18', 26, '21', 13.14, 1.50, 34.31, 24.33),
(311, 'Tomás', 'Correa', '46313162', '2017-04-02', 26, '16', 6.75, 1.14, 19.69, 16.94),
(312, 'Nicolás', 'Bentancur', '23723415', '2015-09-19', 26, '14', 11.81, 1.35, 33.25, 21.99),
(313, 'Luna', 'Cabrera', '36528503', '2019-01-01', 26, '21', 7.27, 1.08, 18.42, 17.63),
(314, 'Delfina', 'Cabrera', '55269592', '2018-06-17', 27, '21', 7.86, 1.20, 22.44, 17.67),
(315, 'Emiliano', 'Techera', '45490870', '2019-12-13', 27, '19', 8.29, 1.18, 21.50, 13.30),
(316, 'Josefina', 'Acosta', '57059694', '2018-08-09', 27, '21', 10.03, 1.29, 27.41, 15.14),
(317, 'Renzo', 'Castro', '43805722', '2014-04-20', 27, '13', 12.45, 1.33, 29.87, 20.82),
(318, 'Facundo', 'Castro', '39702209', '2018-11-21', 27, '18', 8.76, 1.15, 21.04, 16.58),
(319, 'Renzo', 'Cabrera', '77681940', '2016-11-18', 28, '15', 9.23, 1.25, 24.91, 18.36),
(320, 'Valentina', 'Píriz', '78377316', '2013-02-24', 28, '21', 15.84, 1.50, 39.18, 21.03),
(321, 'Zoe', 'Vázquez', '64554570', '2015-01-26', 28, '21', 9.07, 1.27, 25.95, 21.05),
(322, 'Agustín', 'Bentancur', '62343862', '2016-06-11', 28, '15', 13.63, 1.38, 35.05, 18.09),
(323, 'Nicolás', 'Sosa', '73490913', '2017-08-17', 28, '16', 10.68, 1.35, 28.26, 17.94),
(324, 'Camila', 'Suárez', '32818239', '2017-10-04', 29, '21', 10.88, 1.32, 29.36, 18.39),
(325, 'Ian', 'Acosta', '52671689', '2020-02-02', 29, '20', 7.27, 1.09, 19.26, 16.95),
(326, 'Bianca', 'Morales', '60011964', '2020-12-22', 29, '21', 9.32, 1.17, 24.15, 14.85),
(327, 'Thiago', 'López', '65812890', '2016-06-01', 29, '15', 10.92, 1.33, 26.24, 16.97),
(328, 'Valentino', 'Olivera', '48196586', '2017-09-07', 29, '16', 9.89, 1.32, 28.90, 19.47),
(329, 'Martín', 'Vázquez', '51803413', '2020-04-03', 30, '20', 7.99, 1.18, 22.38, 13.40),
(330, 'Santiago', 'Píriz', '65249748', '2015-08-04', 30, '14', 12.23, 1.46, 35.80, 20.58),
(331, 'Martina', 'López', '36723585', '2013-04-25', 30, '21', 12.67, 1.42, 32.32, 22.09),
(332, 'Thiago', 'Bentancur', '38284197', '2019-03-20', 30, '19', 6.19, 1.05, 17.72, 17.08),
(333, 'Renata', 'Araujo', '33737672', '2015-05-12', 30, '21', 12.03, 1.38, 30.96, 19.99),
(334, 'Emma', 'Araujo', '67473868', '2019-06-04', 31, '21', 7.73, 1.15, 22.11, 13.97),
(335, 'Joaquín', 'López', '61121095', '2013-09-30', 31, '12', 13.75, 1.43, 36.15, 20.52),
(336, 'Tomás', 'Cabrera', '56531300', '2017-07-05', 31, '16', 11.38, 1.37, 28.69, 16.02),
(337, 'Máximo', 'Barrios', '56538637', '2014-09-25', 31, '13', 14.73, 1.47, 36.40, 19.44),
(338, 'Amparo', 'Morales', '43398191', '2017-05-18', 31, '21', 10.61, 1.26, 25.57, 18.94),
(339, 'Simón', 'Acosta', '20851534', '2020-06-30', 32, '20', 8.01, 1.14, 19.51, 14.16),
(340, 'Zoe', 'Acosta', '40159839', '2018-02-13', 32, '21', 8.85, 1.19, 23.01, 18.43),
(341, 'Ian', 'Ramos', '40409915', '2016-11-26', 32, '15', 9.31, 1.32, 27.26, 18.61),
(342, 'Josefina', 'Castro', '66169931', '2019-10-25', 32, '21', 8.46, 1.23, 23.03, 16.80),
(343, 'Bautista', 'López', '64951526', '2020-12-25', 32, '20', 6.70, 1.08, 18.69, 14.28);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partidos`
--

CREATE TABLE `partidos` (
  `id` int(11) NOT NULL,
  `id_club_local` int(11) NOT NULL,
  `id_club_visitante` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'sin_fecha',
  `goles_local` int(11) DEFAULT NULL,
  `goles_visitante` int(11) DEFAULT NULL,
  `id_competicion` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `partidos`
--

INSERT INTO `partidos` (`id`, `id_club_local`, `id_club_visitante`, `id_categoria`, `fecha`, `estado`, `goles_local`, `goles_visitante`, `id_competicion`) VALUES
(1, 19, 18, 14, '2026-02-10', 'jugado', 1, 0, 1),
(3, 19, 20, 15, '2026-08-25', 'jugado', 5, 6, 1),
(4, 19, 18, 14, '2025-12-21', 'jugado', 2, 0, 1),
(5, 19, 21, 17, '2026-12-14', 'programado', NULL, NULL, 1),
(6, 24, 30, 14, '2026-10-20', 'programado', 3, 0, 1),
(7, 24, 26, 16, '2026-02-10', 'programado', 1, 1, 1),
(8, 19, 22, 17, '2026-12-12', 'jugado', 3, 2, 1),
(9, 18, 22, 14, '2026-10-21', 'programado', 3, 5, 1),
(10, 20, 21, 13, '2026-12-12', 'programado', 3, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sanciones`
--

CREATE TABLE `sanciones` (
  `id` int(11) NOT NULL,
  `id_jugador` int(11) NOT NULL,
  `tipo` enum('Amarilla','Roja') NOT NULL,
  `fecha` date NOT NULL,
  `motivo` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sanciones`
--

INSERT INTO `sanciones` (`id`, `id_jugador`, `tipo`, `fecha`, `motivo`) VALUES
(7, 291, 'Roja', '2026-10-26', 'Asesinonato'),
(8, 340, 'Amarilla', '2026-10-26', 'Penal para argensiria');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usuario` varchar(50) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `rol` enum('admin','club') NOT NULL DEFAULT 'club',
  `id_club` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usuario`, `contraseña`, `rol`, `id_club`) VALUES
('administrador', '$2y$10$t5ltcUQybGy3DpszGpayru/iADGLVzE5C6zhlg4jg5WXAY8vfLCGa', 'admin', NULL),
('albion', '$2y$10$74XHEPlSYqbZB3wxrtpiZuwAoqEtWPYjbwtMA1ySC8B.eGfKd9VgC', 'club', 26),
('bostonriver', '$2y$10$3WQBigUp7z4vUO3rzB2VD.A/lT8R6kiMrFfCDUJwxeJexliLePDTi', 'club', 29),
('central', '$2y$10$1zgeML8gcECTvQ55g5lRKeuHcOXhv6USs69DcUdAarNOlLV0ETlNu', 'club', 28),
('cerro', '$2y$10$UFCRCyM9nn3imOpNz6d3vONKbqyZyCbBbM6uGPlTwpNiXGdnoQED.', 'club', 30),
('cerrolargo', '$2y$10$k2U2hb8vP.iq0SkDBdXGjui7NrJ2sNh8z/Scf59iU/pUVFymcKWH.', 'club', 20),
('danubio', '$2y$10$m0VkFxusJxExC8gxYvunreirKPwoxQ9j6vpuzTIpPtQWeF9W7NxC6', 'club', 31),
('deportivomaldonado', '$2y$10$TqC5CKhvA1reXvw0XixIB.mg6sNVhatPPwnKjeDRw9FxIF6lUPmWK', 'club', 22),
('juventud', '$2y$10$NtltaWI3iR2r1c8pPaGl5uwSLBYHMzwjOHfBT//CcEorpjKGU8cwS', 'club', 27),
('liverpool', '$2y$10$xk1Mj4ey9bTy/xTz1Ume3OJ7ENne0a3xAlPvAKdzRmyBE67bdD7ou', 'club', 24),
('montevideocitytorque', '$2y$10$.sOXf7qXPb61JLzd853mxeHlo2ioH0DIsYpbLHP572E.yJvwEsm/S', 'club', 18),
('nacional', '$2y$10$A1VumXPnY1wxyBOZVMn.QONfOea61csXoBDRInDFS8nQkYyZVw4K2', 'club', 19),
('peñarol', '$2y$10$ZP9hjZCVvasqqhA.DQnoP..I3p9CBMot5DFaWtwsuqjAvqyopBnfG', 'club', 21),
('progreso', '$2y$10$TbS6ALa2k6zqr26Mhl/6A.h5uZR01BOcklFhPIqOAC1ngacitGkoC', 'club', 32),
('racing', '$2y$10$NKA8du8Lg09Qe18c5Q7RXOaVj.JJpdTgnMPUOkYVMaeEI4YB/TMPi', 'club', 23),
('wanderers', '$2y$10$ZPrsYZf3xhRLgDyDb/GVNuiat2UpkShrpKoQtWoHtkVfxggOA7GMa', 'club', 25);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `avisos`
--
ALTER TABLE `avisos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `boletines`
--
ALTER TABLE `boletines`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `carnets`
--
ALTER TABLE `carnets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_jugador` (`id_jugador`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `club`
--
ALTER TABLE `club`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `competicion`
--
ALTER TABLE `competicion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `jugadores`
--
ALTER TABLE `jugadores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cedula` (`cedula`);

--
-- Indices de la tabla `partidos`
--
ALTER TABLE `partidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sanciones`
--
ALTER TABLE `sanciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_jugador` (`id_jugador`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuario`),
  ADD KEY `usuarios_club_fk` (`id_club`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `avisos`
--
ALTER TABLE `avisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `boletines`
--
ALTER TABLE `boletines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `carnets`
--
ALTER TABLE `carnets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `club`
--
ALTER TABLE `club`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `competicion`
--
ALTER TABLE `competicion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `jugadores`
--
ALTER TABLE `jugadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=348;

--
-- AUTO_INCREMENT de la tabla `partidos`
--
ALTER TABLE `partidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `sanciones`
--
ALTER TABLE `sanciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carnets`
--
ALTER TABLE `carnets`
  ADD CONSTRAINT `carnets_ibfk_1` FOREIGN KEY (`id_jugador`) REFERENCES `jugadores` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sanciones`
--
ALTER TABLE `sanciones`
  ADD CONSTRAINT `sanciones_ibfk_1` FOREIGN KEY (`id_jugador`) REFERENCES `jugadores` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_club_fk` FOREIGN KEY (`id_club`) REFERENCES `club` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

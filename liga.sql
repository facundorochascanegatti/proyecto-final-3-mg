-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-11-2026 a las 23:33:34
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

--
-- Volcado de datos para la tabla `avisos`
--

INSERT INTO `avisos` (`id`, `titulo`, `contenido`, `fecha`) VALUES
(13, 'Inicio de Temporada', 'Se le comunica a todos los clubes el inicio de la temporada.', '2026-10-27'),
(14, 'Lesion grave', 'Joaquin Guzman sufrio una grave lesion por parte de\r\nDavid Eneas Anluz', '2026-10-29');

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

--
-- Volcado de datos para la tabla `boletines`
--

INSERT INTO `boletines` (`id`, `titulo`, `archivo`, `fecha`) VALUES
(1, 'Inicio de Temporada', 'boletin_1793166179.pdf', '2026-10-28'),
(2, 'Inicio de Temporada - 26/27', 'boletin_1793166454.pdf', '2026-10-28');

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

--
-- Volcado de datos para la tabla `carnets`
--

INSERT INTO `carnets` (`id`, `id_jugador`, `foto`, `fecha_vencimiento`) VALUES
(5, 355, 'jugador_355.png', '2027-02-10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `año` varchar(45) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `año`, `activo`) VALUES
(12, '2013', 1),
(13, '2014', 1),
(14, '2015', 1),
(15, '2016', 1),
(16, '2017', 1),
(18, '2018', 1),
(19, '2019', 1),
(20, '2020', 1),
(21, 'Femenino', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `club`
--

CREATE TABLE `club` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `presidente` text NOT NULL,
  `estadio` varchar(70) NOT NULL,
  `fundacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `club`
--

INSERT INTO `club` (`id`, `nombre`, `logo`, `activo`, `presidente`, `estadio`, `fundacion`) VALUES
(18, 'Montevideo City Torque', 'club_18.png', 1, 'Raúl Aquino', 'Estadio Charrua', 2007),
(19, 'Nacional', 'club_19.png', 1, 'Ricardo Vairo', 'Gran Parque Central', 1899),
(20, 'Cerro Largo', 'club_20.png', 1, 'Ernesto Dehl.', 'Estadio Municipal Arq. Antonio Eleuterio Ubilla', 2002),
(21, 'Peñarol', 'club_21.png', 1, 'Ignacio Ruglio', 'Campeon del Siglo', 1913),
(22, 'Deportivo Maldonado', 'club_22.png', 1, 'Malcom Caine', 'Estadio Domingo Burgueño Miguel', 1928),
(23, 'Racing', 'club_23.png', 1, 'Washington Lizandro', 'Parque Osvaldo Roberto', 1919),
(24, 'Liverpool', 'club_24.png', 1, '', '0', 0),
(25, 'Wanderers', 'club_25.png', 1, '', '0', 0),
(26, 'Albion', 'club_26.png', 1, '', '0', 0),
(27, 'Juventud', 'club_27.png', 1, '', '0', 0),
(28, 'Central Español', 'club_28.png', 1, '', '0', 0),
(29, 'Boston River', 'club_29.png', 1, '', '0', 0),
(30, 'Cerro', 'club_30.png', 1, '', '0', 0),
(31, 'Danubio', 'club_31.png', 1, '', '0', 0),
(32, 'Progreso', 'club_32.png', 1, '', '0', 0),
(40, 'Defensor Sporting', 'club_40.png', 1, '', '0', 0);

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
  `id_club` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `masa` decimal(5,2) DEFAULT NULL,
  `altura` decimal(4,2) DEFAULT NULL,
  `peso` decimal(10,2) DEFAULT NULL,
  `velocidad` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `jugadores`
--

INSERT INTO `jugadores` (`id`, `nombre`, `apellido`, `cedula`, `fecha_nacimiento`, `id_club`, `id_categoria`, `masa`, `altura`, `peso`, `velocidad`) VALUES
(348, 'Mateo', 'Silva', '97954763', '2013-03-15', 18, 12, 48.50, 1.58, 475.30, 5.56),
(349, 'Thiago', 'Pereira', '55101443', '2014-07-21', 18, 13, 45.00, 1.54, 441.00, 5.49),
(350, 'Lucia', 'Fernandez', '34567894', '2013-05-10', 18, 21, 43.00, 1.55, 421.83, 20.00),
(351, 'Martina', 'Rodriguez', '45678911', '2015-09-12', 18, 21, 40.00, 1.48, 392.40, 19.00),
(352, 'Santiago', 'Martinez', '56789129', '2015-01-18', 19, 15, 40.00, 1.47, 392.00, 5.37),
(353, 'Joaquin', 'Suarez', '67891234', '2016-06-12', 19, 15, 38.00, 1.43, 372.78, 19.00),
(354, 'Valentina', 'Mendez', '78912348', '2014-04-22', 19, 21, 44.00, 1.53, 431.64, 20.00),
(355, 'Camila', 'Acosta', '89123451', '2016-11-08', 19, 21, 37.00, 1.42, 362.97, 18.00),
(356, 'Felipe', 'Gonzalez', '91234563', '2017-03-11', 20, 21, 32.00, 1.32, 313.60, 5.09),
(357, 'Nicolas', 'Mendez', '13579247', '2018-08-19', 20, 16, 30.00, 1.28, 294.00, 5.01),
(358, 'Sofia', 'Castro', '24681351', '2017-06-17', 20, 21, 34.00, 1.36, 333.54, 17.00),
(359, 'Agustina', 'Lopez', '35792462', '2018-02-14', 20, 21, 30.00, 1.29, 294.30, 15.00),
(360, 'Tomas', 'Olivera', '46813576', '2019-02-14', 21, 19, 27.00, 1.23, 264.87, 14.00),
(361, 'Franco', 'Acosta', '57924687', '2020-10-03', 21, 20, 24.00, 1.18, 235.44, 12.50),
(362, 'Emma', 'Ramos', '68135790', '2019-05-16', 21, 21, 26.00, 1.21, 255.06, 13.50),
(363, 'Mia', 'Vazquez', '79246817', '2020-12-01', 21, 21, 23.00, 1.16, 225.63, 12.00),
(364, 'Dylan', 'Morales', '81357929', '2013-04-09', 22, 12, 49.00, 1.59, 480.69, 22.00),
(365, 'Iker', 'Cabrera', '12468021', '2014-09-24', 22, 13, 44.00, 1.52, 431.64, 20.50),
(366, 'Isabella', 'Pereira', '23579132', '2013-07-07', 22, 21, 42.00, 1.53, 412.02, 20.00),
(367, 'Renata', 'Silva', '34680243', '2015-03-25', 22, 21, 39.00, 1.46, 382.59, 18.50),
(368, 'Bruno', 'Fernandez', '45791354', '2015-06-20', 23, 14, 41.00, 1.48, 402.21, 19.00),
(369, 'Lautaro', 'Ramos', '56802465', '2016-08-12', 23, 15, 37.00, 1.42, 362.97, 18.00),
(370, 'Julieta', 'Martinez', '20135791', '2014-01-19', 23, 21, 43.00, 1.52, 421.83, 20.00),
(371, 'Florencia', 'Suarez', '31246802', '2016-10-29', 23, 21, 36.00, 1.40, 353.16, 17.50),
(372, 'Martin', 'Castro', '42357913', '2017-05-11', 24, 16, 33.00, 1.34, 323.73, 16.50),
(373, 'Facundo', 'Mendez', '53468024', '2018-12-19', 24, 18, 29.00, 1.27, 284.49, 15.00),
(374, 'Antonella', 'Gonzalez', '64579135', '2017-08-08', 24, 21, 34.00, 1.35, 333.54, 16.50),
(375, 'Pilar', 'Olivera', '75680246', '2018-04-16', 24, 21, 29.00, 1.26, 284.49, 14.50),
(376, 'Benicio', 'Lopez', '86791357', '2019-04-12', 25, 19, 26.00, 1.22, 255.06, 13.50),
(377, 'Gael', 'Acosta', '97802468', '2020-07-25', 25, 20, 23.00, 1.17, 225.63, 12.00),
(378, 'Olivia', 'Morales', '18913579', '2019-09-14', 25, 21, 25.00, 1.20, 245.25, 13.00),
(379, 'Alma', 'Cabrera', '29024680', '2020-02-03', 25, 21, 22.00, 1.14, 215.82, 11.50),
(380, 'Matias', 'Vazquez', '30135791', '2013-11-02', 26, 12, 51.00, 1.62, 500.31, 23.00),
(381, 'Ignacio', 'Ramos', '41246802', '2014-03-17', 26, 13, 46.00, 1.56, 451.26, 21.50),
(382, 'Josefina', 'Silva', '52357913', '2013-08-22', 26, 21, 44.00, 1.56, 431.64, 20.50),
(383, 'Clara', 'Pereira', '63468024', '2015-12-09', 26, 21, 41.00, 1.49, 402.21, 19.00),
(384, 'Emiliano', 'Suarez', '74579135', '2015-04-08', 27, 14, 39.00, 1.46, 382.59, 19.00),
(385, 'Alejo', 'Martinez', '85680246', '2016-09-14', 27, 15, 36.00, 1.41, 353.16, 18.00),
(386, 'Bianca', 'Fernandez', '96791357', '2014-06-15', 27, 21, 42.00, 1.51, 412.02, 19.50),
(387, 'Catalina', 'Castro', '17802468', '2016-02-27', 27, 21, 37.00, 1.43, 362.97, 18.00),
(388, 'Valentino', 'Gonzalez', '28913579', '2017-10-05', 28, 16, 34.00, 1.35, 333.54, 17.00),
(389, 'Bautista', 'Olivera', '39024680', '2018-05-23', 28, 18, 30.00, 1.29, 294.30, 15.50),
(390, 'Maite', 'Lopez', '40135791', '2017-01-13', 28, 21, 33.00, 1.33, 323.73, 16.00),
(391, 'Lola', 'Ramos', '51246802', '2018-09-18', 28, 21, 28.00, 1.25, 274.68, 14.50),
(392, 'Ciro', 'Pereira', '62357913', '2019-08-17', 29, 19, 27.00, 1.23, 264.87, 14.00),
(393, 'Juan', 'Silva', '73468024', '2020-03-21', 29, 20, 24.00, 1.18, 235.44, 12.50),
(394, 'Delfina', 'Acosta', '84579135', '2019-11-02', 29, 21, 26.00, 1.21, 255.06, 13.50),
(395, 'Ambar', 'Morales', '95680246', '2020-06-12', 29, 21, 23.00, 1.16, 225.63, 12.00),
(397, 'Aaron', 'Mendez', '27802468', '2014-12-11', 30, 13, 45.00, 1.55, 441.45, 21.00),
(398, 'Miranda', 'Vazquez', '38913579', '2013-10-06', 30, 21, 43.00, 1.54, 421.83, 20.00),
(399, 'Victoria', 'Gonzalez', '49024680', '2015-07-29', 30, 21, 40.00, 1.47, 392.40, 19.00),
(400, 'Salvador', 'Ramos', '50135791', '2015-10-14', 31, 14, 42.00, 1.49, 412.02, 19.50),
(401, 'Maximo', 'Lopez', '61246802', '2016-03-09', 31, 15, 37.00, 1.42, 362.97, 18.00),
(402, 'Ana', 'Olivera', '72357913', '2014-08-21', 31, 21, 44.00, 1.54, 431.64, 20.00),
(403, 'Belen', 'Suarez', '83468024', '2016-05-05', 31, 21, 36.00, 1.41, 353.16, 17.50),
(404, 'Lorenzo', 'Castro', '94579135', '2017-09-19', 32, 16, 33.00, 1.34, 323.73, 16.50),
(405, 'Simón', 'Fernandez', '15680246', '2018-01-07', 32, 18, 31.00, 1.30, 303.21, 15.50),
(406, 'Zoe', 'Martinez', '26791357', '2017-04-24', 32, 21, 34.00, 1.36, 333.54, 16.50),
(407, 'Aitana', 'Pereira', '37802468', '2018-11-30', 32, 21, 29.00, 1.27, 284.49, 15.00),
(409, 'Lionel', 'Messias', '59911010', '2016-10-20', 24, 15, 60.00, 1.70, 588.00, 5.00),
(410, 'Pedro', 'Cabrera', '52457274', '2013-02-10', 30, 12, 60.00, 1.70, 588.00, 6.00),
(412, 'Cristiano', 'Sakpal', '33781015', '2013-02-10', 19, 12, 45.00, 1.72, 441.00, 6.00),
(413, '1sre', 'se12', '13579246', '2013-01-12', 30, 13, 60.00, 1.75, 588.00, 18.00);

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
(5, 19, 21, 21, '2026-06-17', 'jugado', 6, 1, 1),
(6, 24, 30, 14, '2026-10-20', 'jugado', 3, 0, 1),
(7, 24, 26, 16, '2026-02-10', 'jugado', 1, 1, 1),
(8, 19, 22, 16, '2026-12-12', 'programado', NULL, NULL, 1),
(9, 18, 22, 14, '2026-10-21', 'jugado', 3, 5, 1),
(10, 20, 21, 13, '2026-12-12', 'programado', NULL, NULL, 2),
(11, 27, 25, 14, '2026-12-31', 'programado', NULL, NULL, 1),
(12, 23, 29, 15, '2026-08-20', 'jugado', 2, 1, 2),
(13, 19, 18, 12, '2026-02-10', 'jugado', 5, 0, 1);

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
(10, 394, 'Roja', '2026-10-29', 'Diarrea Explosiva Masiva en Plan OMG'),
(11, 361, 'Roja', '2026-11-02', 'Tirar un garrafon');

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
('defensorsporting', '$2y$10$KKylaxm/WhcD88Jo7JMCe.YD71ZoTTkRrQl7e.uA0NHFiEeygB7Yq', 'club', 40),
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
  ADD UNIQUE KEY `cedula` (`cedula`),
  ADD KEY `fk_jugadores_club` (`id_club`),
  ADD KEY `fk_jugadores_categoria` (`id_categoria`);

--
-- Indices de la tabla `partidos`
--
ALTER TABLE `partidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_partidos_local` (`id_club_local`),
  ADD KEY `fk_partidos_visitante` (`id_club_visitante`),
  ADD KEY `fk_partidos_categoria` (`id_categoria`),
  ADD KEY `fk_partidos_competicion` (`id_competicion`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `boletines`
--
ALTER TABLE `boletines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `carnets`
--
ALTER TABLE `carnets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `club`
--
ALTER TABLE `club`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `competicion`
--
ALTER TABLE `competicion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `jugadores`
--
ALTER TABLE `jugadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=414;

--
-- AUTO_INCREMENT de la tabla `partidos`
--
ALTER TABLE `partidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `sanciones`
--
ALTER TABLE `sanciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carnets`
--
ALTER TABLE `carnets`
  ADD CONSTRAINT `carnets_ibfk_1` FOREIGN KEY (`id_jugador`) REFERENCES `jugadores` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `jugadores`
--
ALTER TABLE `jugadores`
  ADD CONSTRAINT `fk_jugadores_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`),
  ADD CONSTRAINT `fk_jugadores_club` FOREIGN KEY (`id_club`) REFERENCES `club` (`id`);

--
-- Filtros para la tabla `partidos`
--
ALTER TABLE `partidos`
  ADD CONSTRAINT `fk_partidos_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`),
  ADD CONSTRAINT `fk_partidos_competicion` FOREIGN KEY (`id_competicion`) REFERENCES `competicion` (`id`),
  ADD CONSTRAINT `fk_partidos_local` FOREIGN KEY (`id_club_local`) REFERENCES `club` (`id`),
  ADD CONSTRAINT `fk_partidos_visitante` FOREIGN KEY (`id_club_visitante`) REFERENCES `club` (`id`);

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

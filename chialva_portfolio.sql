-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-10-2025 a las 09:50:23
-- Versión del servidor: 8.0.41
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `chialva_portfolio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citazioni`
--

CREATE TABLE `citazioni` (
  `idCita` int NOT NULL,
  `idUser` int NOT NULL,
  `titolo` varchar(255) NOT NULL,
  `descrizione` text,
  `data_cita` date NOT NULL,
  `ora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notizie`
--

CREATE TABLE `notizie` (
  `idNotizia` int NOT NULL,
  `titolo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `immagine` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `testo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `data_pubblicazione` date NOT NULL,
  `idUser` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `notizie`
--

INSERT INTO `notizie` (`idNotizia`, `titolo`, `immagine`, `testo`, `data_pubblicazione`, `idUser`) VALUES
(4, 'sds', '', 'sdsd', '2025-10-05', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_data`
--

CREATE TABLE `users_data` (
  `idUser` int NOT NULL,
  `nome` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `cognome` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `data_nascita` date NOT NULL,
  `indirizzo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `sesso` enum('M','F','Altro') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `users_data`
--

INSERT INTO `users_data` (`idUser`, `nome`, `cognome`, `email`, `telefono`, `data_nascita`, `indirizzo`, `sesso`) VALUES
(1, 'Admin', 'Sito', 'admin@site.com', '000000', '2015-10-08', NULL, NULL),
(7, 'Nicolas', 'Chialva', 'chialvanicolas@outlook.ar', '3669984236', '1992-07-02', 'Via Boston, 102, Torino, TO', 'M'),
(8, 'Nicolas Lionel', 'Chialva', 'admin@outlook.it', '3669984236', '1993-07-07', NULL, 'M'),
(9, 'Nicolas Lionel', 'Chialva', 'chialvanicolas@outlook.org', '3669984236', '2025-10-09', 'Via Boston, 102, Torino, TO', 'M'),
(10, 'Nicolas', 'Chialva', 'chialvanicolas@outlook.sd', '3669984236', '1992-07-02', 'Via Boston, 102, Torino, TO', 'M');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_login`
--

CREATE TABLE `users_login` (
  `idLogin` int NOT NULL,
  `utente` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) NOT NULL,
  `ruolo` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'user',
  `idUser` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `users_login`
--

INSERT INTO `users_login` (`idLogin`, `utente`, `password`, `ruolo`, `idUser`) VALUES
(3, 'admin', '123456', 'admin', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citazioni`
--
ALTER TABLE `citazioni`
  ADD PRIMARY KEY (`idCita`),
  ADD KEY `idUser` (`idUser`);

--
-- Indices de la tabla `notizie`
--
ALTER TABLE `notizie`
  ADD PRIMARY KEY (`idNotizia`),
  ADD UNIQUE KEY `titulo` (`titolo`),
  ADD KEY `idUser` (`idUser`);

--
-- Indices de la tabla `users_data`
--
ALTER TABLE `users_data`
  ADD PRIMARY KEY (`idUser`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `users_login`
--
ALTER TABLE `users_login`
  ADD PRIMARY KEY (`idLogin`),
  ADD UNIQUE KEY `idUser` (`idUser`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citazioni`
--
ALTER TABLE `citazioni`
  MODIFY `idCita` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `notizie`
--
ALTER TABLE `notizie`
  MODIFY `idNotizia` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `users_data`
--
ALTER TABLE `users_data`
  MODIFY `idUser` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `users_login`
--
ALTER TABLE `users_login`
  MODIFY `idLogin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citazioni`
--
ALTER TABLE `citazioni`
  ADD CONSTRAINT `citazioni_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users_data` (`idUser`);

--
-- Filtros para la tabla `notizie`
--
ALTER TABLE `notizie`
  ADD CONSTRAINT `notizie_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users_data` (`idUser`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 18-09-2024 a las 09:39:12
-- Versión del servidor: 10.5.26-MariaDB
-- Versión de PHP: 8.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `adm_sienna`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documents`
--

CREATE TABLE `documents` (
  `id_document` int(11) NOT NULL,
  `id_folder_document` int(11) NOT NULL COMMENT 'tbl folders',
  `id_user_document` int(11) NOT NULL COMMENT 'tbl users',
  `key_document` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `file_name_document` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `file_extension_document` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `first_fech_document` date DEFAULT NULL,
  `second_fech_document` date DEFAULT NULL,
  `status_document` int(11) NOT NULL,
  `created_at_document` datetime NOT NULL,
  `updated_at_document` datetime NOT NULL,
  `eliminated_at_document` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `folders`
--

CREATE TABLE `folders` (
  `id_folder` int(11) NOT NULL,
  `id_user_folder` int(11) NOT NULL COMMENT 'tbl users',
  `fk_folder` int(11) NOT NULL,
  `key_folder` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `name_folder` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `first_fech_folder` date DEFAULT NULL,
  `second_fech_folder` date DEFAULT NULL,
  `chk_alta_fact_folder` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Check Vo.Bo. Alta Facturación',
  `chk_lib_folder` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Check Vo.Bo. Liberación',
  `chk_orig_recib_folder` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Check Original Recibido',
  `fech_orig_recib_folder` date DEFAULT NULL COMMENT 'Fecha de Original Recibido',
  `status_folder` int(11) NOT NULL,
  `created_at_folder` datetime NOT NULL,
  `updated_at_folder` datetime NOT NULL,
  `eliminated_at_folder` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notifications`
--

CREATE TABLE `notifications` (
  `id_notification` int(11) NOT NULL,
  `id_user_notificacion` int(11) NOT NULL COMMENT 'tbl users',
  `id_documents` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `notifications`
--

INSERT INTO `notifications` (`id_notification`, `id_user_notificacion`, `id_documents`) VALUES
(1, 1, '0'),
(2, 2, '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `types`
--

CREATE TABLE `types` (
  `id_type` int(11) NOT NULL,
  `name_type` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `types`
--

INSERT INTO `types` (`id_type`, `name_type`) VALUES
(1, 'Administrador'),
(2, 'Empleado'),
(3, 'Ventas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `id_type_user` int(11) NOT NULL COMMENT 'tbl types',
  `key_user` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `name_user` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `rfc_user` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `photo_user` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `phone_user` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `email_user` varchar(60) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `password_user` varchar(80) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `status_user` int(11) NOT NULL,
  `created_at_user` datetime NOT NULL,
  `updated_at_user` datetime NOT NULL,
  `eliminated_at_user` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `id_type_user`, `key_user`, `name_user`, `rfc_user`, `photo_user`, `phone_user`, `email_user`, `password_user`, `status_user`, `created_at_user`, `updated_at_user`, `eliminated_at_user`) VALUES
(1, 1, 'USR-CJSLX', 'ADMINISTRADOR SYSOP', 'SOXA850715ABC', 'USR-CJSLX_s-sysop.png', '8112330000', 'malonso@sysop.com.mx', '$2y$10$jgEuEKZcyjne0CaWwMqID.gC2AujUxwVnl4IG5L55BKdmHG8uxrNa', 1, '2024-05-28 16:52:10', '2024-08-19 14:58:55', '0000-00-00 00:00:00'),
(2, 1, 'USR-Z4GBK', 'ADMINISTRACION SIENNA', 'ADM200110XXXS', NULL, '1234567890', 'administracion@sienna.mx', '$2y$10$7g/cidh64NILCYPP2RxjkucAIVdsitY1qwhj7RhD/B82su.aH6wsm', 1, '2024-05-28 16:54:18', '2024-09-17 18:32:06', '0000-00-00 00:00:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id_document`);

--
-- Indices de la tabla `folders`
--
ALTER TABLE `folders`
  ADD PRIMARY KEY (`id_folder`);

--
-- Indices de la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id_notification`);

--
-- Indices de la tabla `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id_type`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `documents`
--
ALTER TABLE `documents`
  MODIFY `id_document` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `folders`
--
ALTER TABLE `folders`
  MODIFY `id_folder` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id_notification` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `types`
--
ALTER TABLE `types`
  MODIFY `id_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

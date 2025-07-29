-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 31-01-2025 a las 14:33:11
-- Versión del servidor: 10.5.26-MariaDB
-- Versión de PHP: 8.3.14

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
  `id_customer_folder` int(11) DEFAULT NULL COMMENT 'tbl users',
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
-- Estructura de tabla para la tabla `materials_sections`
--

CREATE TABLE `materials_sections` (
  `id_material` int(11) NOT NULL,
  `id_section_material` int(11) NOT NULL COMMENT 'tbl sections',
  `id_user_material` int(11) NOT NULL COMMENT 'tbl users',
  `key_material` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `file_name_material` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `file_extension_material` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `status_material` int(11) NOT NULL,
  `position_material` int(11) DEFAULT NULL,
  `created_at_material` datetime NOT NULL,
  `updated_at_material` datetime NOT NULL,
  `deleted_at_material` datetime DEFAULT NULL
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
-- Estructura de tabla para la tabla `notify_folders`
--

CREATE TABLE `notify_folders` (
  `id_notify_folder` int(11) NOT NULL,
  `id_folder_notify_assigned` int(11) NOT NULL COMMENT 'tbl folders',
  `id_user_notify_assigned` int(11) NOT NULL COMMENT 'tbl users',
  `is_reading_notify` int(11) NOT NULL,
  `message_notify` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `usr_type_notify` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `status_notify_folder` int(11) NOT NULL,
  `created_at_notify_folder` datetime NOT NULL,
  `updated_at_notify_folder` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notify_tracings`
--

CREATE TABLE `notify_tracings` (
  `id_notify` int(11) NOT NULL,
  `id_tracing_notify` int(11) NOT NULL COMMENT 'tbl tracings',
  `id_user_assigned_notify` int(11) NOT NULL COMMENT 'tbl users',
  `id_folder_notify` int(11) NOT NULL COMMENT 'tbl folders',
  `is_reading` int(11) NOT NULL,
  `is_two_reading` int(11) NOT NULL,
  `created_at_notify` datetime NOT NULL,
  `updated_at_notify` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sections`
--

CREATE TABLE `sections` (
  `id_section` int(11) NOT NULL,
  `id_user_section` int(11) NOT NULL COMMENT 'tbl users',
  `key_section` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `title_section` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `chk_view_empl` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Check view employees',
  `chk_view_sales` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Check view ventas',
  `status_section` int(11) NOT NULL,
  `created_at_section` datetime NOT NULL,
  `updated_at_section` datetime NOT NULL,
  `deleted_at_section` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tracings`
--

CREATE TABLE `tracings` (
  `id_tracing` int(11) NOT NULL,
  `id_folder_tracing` int(11) NOT NULL COMMENT 'tbl folders',
  `id_user_tracing` int(11) NOT NULL COMMENT 'tbl users',
  `key_tracing` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `comment_tracing` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `status_tracing` int(11) NOT NULL,
  `created_at_tracing` datetime NOT NULL,
  `updated_at_tracing` datetime NOT NULL,
  `deleted_at_tracing` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
  `photo_user` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
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
(1, 1, 'USR-CIAY7', 'ADMINISTRADOR SYSOP', '3R6C9J1K2S8HP', 'USR-CIAY7_s-sysop_(1).png', '8112330000', 'malonso@sysop.com.mx', '$2y$10$YiUYxPTTHTtByNfNPWHHWehvjmGA6dQXjFN958IbCBMR9GpPJWD9i', 1, '2025-01-31 14:31:09', '2025-01-31 14:31:09', NULL),
(2, 1, 'USR-ITFEG', 'ADMINISTRACION SIENNA', 'HEJI7FQRCK9NV', NULL, '1234567890', 'administracion@sienna.mx', '$2y$10$htIObbM0rMSJOTnZ5BWEnemZ1J/aF9inLxBaIbipybPHyaILW515.', 1, '2025-01-31 14:31:55', '2025-01-31 14:31:55', NULL);

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
-- Indices de la tabla `materials_sections`
--
ALTER TABLE `materials_sections`
  ADD PRIMARY KEY (`id_material`);

--
-- Indices de la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id_notification`);

--
-- Indices de la tabla `notify_folders`
--
ALTER TABLE `notify_folders`
  ADD PRIMARY KEY (`id_notify_folder`);

--
-- Indices de la tabla `notify_tracings`
--
ALTER TABLE `notify_tracings`
  ADD PRIMARY KEY (`id_notify`);

--
-- Indices de la tabla `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id_section`);

--
-- Indices de la tabla `tracings`
--
ALTER TABLE `tracings`
  ADD PRIMARY KEY (`id_tracing`);

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
-- AUTO_INCREMENT de la tabla `materials_sections`
--
ALTER TABLE `materials_sections`
  MODIFY `id_material` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id_notification` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `notify_folders`
--
ALTER TABLE `notify_folders`
  MODIFY `id_notify_folder` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notify_tracings`
--
ALTER TABLE `notify_tracings`
  MODIFY `id_notify` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sections`
--
ALTER TABLE `sections`
  MODIFY `id_section` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tracings`
--
ALTER TABLE `tracings`
  MODIFY `id_tracing` int(11) NOT NULL AUTO_INCREMENT;

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

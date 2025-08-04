-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 04-08-2025 a las 20:10:53
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
-- Base de datos: `adm_sienna`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `companies`
--

CREATE TABLE `companies` (
  `id_company` int(11) NOT NULL,
  `key_company` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `name_company` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `rfc_company` varchar(13) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `razon_social` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `tipo_persona` enum('fisica','moral','fideicomiso') DEFAULT 'moral',
  `fecha_constitucion` date DEFAULT NULL,
  `estado` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `ciudad` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `colonia` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `calle` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `num_exterior` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `num_interior` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `codigo_postal` varchar(6) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `apoderado_nombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `apoderado_apellido_paterno` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `apoderado_apellido_materno` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `apoderado_rfc` varchar(13) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `apoderado_curp` varchar(18) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `status_company` int(11) NOT NULL DEFAULT 1,
  `created_at_company` datetime NOT NULL,
  `updated_at_company` datetime NOT NULL,
  `eliminated_at_company` datetime DEFAULT NULL,
  `type_company` enum('system','client') DEFAULT 'client',
  `created_by_user` int(11) DEFAULT NULL,
  `fiduciario_nombre` varchar(100) DEFAULT NULL,
  `fiduciario_rfc` varchar(13) DEFAULT NULL,
  `fideicomitente_nombre` varchar(50) DEFAULT NULL,
  `fideicomitente_apellido_paterno` varchar(50) DEFAULT NULL,
  `fideicomitente_apellido_materno` varchar(50) DEFAULT NULL,
  `fideicomitente_rfc` varchar(13) DEFAULT NULL,
  `fideicomitente_curp` varchar(18) DEFAULT NULL,
  `fideicomisario_nombre` varchar(50) DEFAULT NULL,
  `fideicomisario_apellido_paterno` varchar(50) DEFAULT NULL,
  `fideicomisario_apellido_materno` varchar(50) DEFAULT NULL,
  `fideicomisario_rfc` varchar(13) DEFAULT NULL,
  `fideicomisario_curp` varchar(18) DEFAULT NULL,
  `numero_fideicomiso` varchar(20) DEFAULT NULL,
  `fecha_fideicomiso` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `companies`
--

INSERT INTO `companies` (`id_company`, `key_company`, `name_company`, `rfc_company`, `razon_social`, `tipo_persona`, `fecha_constitucion`, `estado`, `ciudad`, `colonia`, `calle`, `num_exterior`, `num_interior`, `codigo_postal`, `telefono`, `email`, `apoderado_nombre`, `apoderado_apellido_paterno`, `apoderado_apellido_materno`, `apoderado_rfc`, `apoderado_curp`, `status_company`, `created_at_company`, `updated_at_company`, `eliminated_at_company`, `type_company`, `created_by_user`, `fiduciario_nombre`, `fiduciario_rfc`, `fideicomitente_nombre`, `fideicomitente_apellido_paterno`, `fideicomitente_apellido_materno`, `fideicomitente_rfc`, `fideicomitente_curp`, `fideicomisario_nombre`, `fideicomisario_apellido_paterno`, `fideicomisario_apellido_materno`, `fideicomisario_rfc`, `fideicomisario_curp`, `numero_fideicomiso`, `fecha_fideicomiso`) VALUES
(7, 'EMP-QUKIOX41', 'Chedraui1', 'AJRV841119FQ0', 'Anonima Capital Verde', 'moral', '2025-07-09', 'Nuevo Leon', 'Veracruz La antigua', 'Centro', 'Av. Constitucion', '123', NULL, '31231', '111111111', 'uzziellopezvaldez@gmail.com', 'Uzziel', 'Lopez', 'Valdez', 'BKBA730210DO6', 'KXXM110209MCHEHT24', 1, '2025-07-29 15:30:46', '2025-07-30 13:33:49', NULL, 'system', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'EMP-CF54A9U6', 'Inmobiliaria 1', 'MDCQ610717MMC', 'Inmobiliaria 1', 'moral', '2025-07-03', 'Nuevo Leon', 'Cardel', 'Centro', 'Av consitucion', '12', 'a', '12121', '2961156892', 'auzziellopezvaldez@gmail.com', 'Jaun', 'Carlos', 'lopez', 'MPEI310305MTC', 'MPEI310305MTCKMK25', 1, '2025-07-30 13:27:35', '2025-07-30 13:27:35', NULL, 'client', 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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

--
-- Volcado de datos para la tabla `documents`
--

INSERT INTO `documents` (`id_document`, `id_folder_document`, `id_user_document`, `key_document`, `file_name_document`, `file_extension_document`, `first_fech_document`, `second_fech_document`, `status_document`, `created_at_document`, `updated_at_document`, `eliminated_at_document`) VALUES
(1, 7, 2, 'DOC-GSHFWO8', '3-Ejercicios de polinomios - presentación.pdf', 'pdf', NULL, NULL, 2, '2025-07-30 13:31:22', '2025-07-30 13:31:22', '2025-07-30 13:33:09'),
(2, 9, 2, 'DOC-PD3IATR', 'Distribucion_Binomial.xlsx - Hoja1.pdf', 'pdf', NULL, NULL, 1, '2025-07-30 13:31:50', '2025-07-30 13:31:50', NULL),
(3, 7, 5, 'DOC-SQ0PUVI', 'Actividad 1 Infografia Ing sistemas.pdf', 'pdf', NULL, NULL, 2, '2025-08-04 11:58:14', '2025-08-04 11:58:14', '2025-08-04 12:03:07'),
(4, 10, 5, 'DOC-NUGZMLY', 'Actividad 1 Infografia Ing sistemas.pdf', 'pdf', NULL, NULL, 1, '2025-08-04 12:03:15', '2025-08-04 12:03:15', NULL),
(5, 7, 5, 'DOC-B5RUMHC', 'Actividad 1 Infografia Ing sistemas.pdf', 'pdf', NULL, NULL, 2, '2025-08-04 12:03:41', '2025-08-04 12:03:41', '2025-08-04 12:03:54'),
(6, 7, 5, 'DOC-Z63O1MI', '3-Ejercicios de polinomios - presentación.pdf', 'pdf', NULL, NULL, 2, '2025-08-04 12:04:02', '2025-08-04 12:04:02', '2025-08-04 12:04:30'),
(7, 7, 5, 'DOC-RP7DYBQ', 'PE_Lectura de apoyo_B4.pdf', 'pdf', NULL, NULL, 2, '2025-08-04 12:04:37', '2025-08-04 12:04:37', '2025-08-04 12:04:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `folders`
--

CREATE TABLE `folders` (
  `id_folder` int(11) NOT NULL,
  `id_user_folder` int(11) NOT NULL COMMENT 'tbl users',
  `id_customer_folder` int(11) DEFAULT NULL COMMENT 'tbl users',
  `company_id` int(11) DEFAULT NULL COMMENT 'tbl companies - empresa relacionada',
  `fk_folder` int(11) NOT NULL,
  `key_folder` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `name_folder` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `rfc_folder` varchar(13) DEFAULT NULL,
  `curp_folder` varchar(18) DEFAULT NULL,
  `address_folder` text DEFAULT NULL,
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

--
-- Volcado de datos para la tabla `folders`
--

INSERT INTO `folders` (`id_folder`, `id_user_folder`, `id_customer_folder`, `company_id`, `fk_folder`, `key_folder`, `name_folder`, `rfc_folder`, `curp_folder`, `address_folder`, `first_fech_folder`, `second_fech_folder`, `chk_alta_fact_folder`, `chk_lib_folder`, `chk_orig_recib_folder`, `fech_orig_recib_folder`, `status_folder`, `created_at_folder`, `updated_at_folder`, `eliminated_at_folder`) VALUES
(7, 2, 0, 11, 0, 'XCJ5Z0UKAY', 'Inmobiliaria 1', NULL, NULL, NULL, '2025-07-01', '2025-08-30', NULL, NULL, NULL, NULL, 1, '2025-07-30 13:27:35', '2025-08-04 11:14:14', NULL),
(9, 2, 0, NULL, 7, 'CARP-HQT1LA', 'PDF', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2025-07-30 13:31:39', '2025-07-30 13:31:39', '2025-07-30 13:33:06'),
(10, 5, 5, NULL, 7, 'CLI-E6VNC0', 'Juan Perez Lopez', 'LACX280506GR6', 'ZFVH400209HCHMDV85', 'Av Cedro 14 Vicente Lopez Ciudad Cardel', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-08-03 12:04:32', '2025-08-03 12:04:32', NULL);

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
(3, 'Cliente Empresa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `id_type_user` int(11) NOT NULL COMMENT 'tbl types',
  `id_company` int(11) DEFAULT NULL COMMENT 'tbl companies - empresa asignada',
  `company_role` enum('admin_empresa','operador','consultor') DEFAULT 'operador' COMMENT 'Rol en la empresa',
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

INSERT INTO `users` (`id_user`, `id_type_user`, `id_company`, `company_role`, `key_user`, `name_user`, `rfc_user`, `photo_user`, `phone_user`, `email_user`, `password_user`, `status_user`, `created_at_user`, `updated_at_user`, `eliminated_at_user`) VALUES
(2, 1, NULL, 'operador', 'USR-ITFEG', 'ADMINISTRACION SIENNA', NULL, NULL, '1234567890', 'administracion@sienna.mx', '$2y$10$htIObbM0rMSJOTnZ5BWEnemZ1J/aF9inLxBaIbipybPHyaILW515.', 1, '2025-01-31 14:31:55', '2025-01-31 14:31:55', NULL),
(5, 3, 7, 'operador', 'USR-Q609R', 'Chedraui', 'FH34XTSYP0NCB', 'USR-Q609R_7.png', '5659139591', 'uzziellopezvaldez@gmail.com', '$2y$10$qHKZz5wcsZn9oWnRWw62A.Sofdwts2jnrs2CiUZtoOS.HcYUeQHfe', 1, '2025-07-29 15:34:07', '2025-07-29 15:34:07', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id_company`),
  ADD UNIQUE KEY `key_company` (`key_company`),
  ADD UNIQUE KEY `rfc_company` (`rfc_company`),
  ADD KEY `status_company` (`status_company`);

--
-- Indices de la tabla `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id_document`);

--
-- Indices de la tabla `folders`
--
ALTER TABLE `folders`
  ADD PRIMARY KEY (`id_folder`),
  ADD KEY `idx_folders_company_id` (`company_id`);

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
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `idx_company` (`id_company`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `companies`
--
ALTER TABLE `companies`
  MODIFY `id_company` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `documents`
--
ALTER TABLE `documents`
  MODIFY `id_document` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `folders`
--
ALTER TABLE `folders`
  MODIFY `id_folder` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `materials_sections`
--
ALTER TABLE `materials_sections`
  MODIFY `id_material` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id_notification` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `folders`
--
ALTER TABLE `folders`
  ADD CONSTRAINT `fk_folders_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id_company`) ON DELETE SET NULL;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_company`) REFERENCES `companies` (`id_company`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

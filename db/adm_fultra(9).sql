-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 28-07-2025 a las 23:58:06
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
-- Base de datos: `adm_fultra`
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
  `eliminated_at_company` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `companies`
--

INSERT INTO `companies` (`id_company`, `key_company`, `name_company`, `rfc_company`, `razon_social`, `tipo_persona`, `fecha_constitucion`, `estado`, `ciudad`, `colonia`, `calle`, `num_exterior`, `num_interior`, `codigo_postal`, `telefono`, `email`, `apoderado_nombre`, `apoderado_apellido_paterno`, `apoderado_apellido_materno`, `apoderado_rfc`, `apoderado_curp`, `status_company`, `created_at_company`, `updated_at_company`, `eliminated_at_company`) VALUES
(1, 'EMP-PAPITAS', 'Papitas del Norte SA de CV', 'PDN190815ABC', 'PAPITAS DEL NORTE SOCIEDAD ANONIMA DE CAPITAL VARIABLE', 'moral', '2019-08-15', 'Nuevo León', 'Monterrey', 'Centro', 'Av. Constitución', '1234', NULL, '64000', '8181234567', 'contacto@papitasnorte.mx', 'Juan Carlos', 'Pérez', NULL, 'PEJC800101ABC', NULL, 1, '2025-07-28 13:25:53', '2025-07-28 13:25:53', NULL),
(2, 'EMP-CONSTR', 'Constructora Ejemplo SA de CV', 'CEJ200310DEF', 'CONSTRUCTORA EJEMPLO SOCIEDAD ANONIMA DE CAPITAL VARIABLE', 'moral', '2020-03-10', 'Ciudad de México', 'CDMX', 'Roma Norte', 'Calle Álvaro Obregón', '567', NULL, '06700', '5551234567', 'info@constructoraejemplo.mx', 'María Elena', 'González', NULL, 'GOME750505DEF', NULL, 1, '2025-07-28 13:25:53', '2025-07-28 13:25:53', NULL),
(3, 'EMP-INMOB', 'Inmobiliaria Moderna SA de CV', 'IMM210520GHI', 'INMOBILIARIA MODERNA SOCIEDAD ANONIMA DE CAPITAL VARIABLE', 'moral', '2021-05-20', 'Jalisco', 'Guadalajara', 'Providencia', 'Av. López Mateos', '890', NULL, '44630', '3331234567', 'ventas@inmobiliariamoderna.mx', 'Roberto', 'Martínez', NULL, 'MARR850315GHI', NULL, 1, '2025-07-28 13:25:53', '2025-07-28 13:25:53', NULL);

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
(1, 1, NULL, 'operador', 'USR-CIAY7', 'ADMINISTRADOR SYSOP', '3R6C9J1K2S8HP', 'USR-CIAY7_s-sysop_(1).png', '8112330000', 'malonso@sysop.com.mx', '$2y$10$YiUYxPTTHTtByNfNPWHHWehvjmGA6dQXjFN958IbCBMR9GpPJWD9i', 1, '2025-01-31 14:31:09', '2025-01-31 14:31:09', NULL),
(2, 1, NULL, 'operador', 'USR-ITFEG', 'ADMINISTRACION FULTRA', 'HEJI7FQRCK9NV', NULL, '1234567890', 'administracion@fultra.mx', '$2y$10$htIObbM0rMSJOTnZ5BWEnemZ1J/aF9inLxBaIbipybPHyaILW515.', 1, '2025-01-31 14:31:55', '2025-01-31 14:31:55', NULL),
(3, 3, 3, 'admin_empresa', 'USR-EMPRESA1', 'UZZIEL EMPRESA', 'PEJC800101ABC', 'USR-EMPRESA1_ChatGPT_Image_10_jul_2025,_10_14_10.png', '2296018327', 'uzziellopezvaldez@papitasnorte.mx', '$2y$10$G2M1TojeOpHFMJr4PtCtl.nU4g2drRDALMa8vrDeGlDMtujcc6GVq', 1, '2025-07-28 13:25:53', '2025-07-28 15:45:35', NULL);

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
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `idx_company` (`id_company`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `companies`
--
ALTER TABLE `companies`
  MODIFY `id_company` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_company`) REFERENCES `companies` (`id_company`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

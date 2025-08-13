-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 13-08-2025 a las 19:19:05
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
(11, 'EMP-CF54A9U6', 'Inmobiliaria 4', 'MDCQ610717MMC', 'Inmobiliaria 1', 'moral', '2025-07-03', 'Nuevo Leon', 'Cardel', 'Centro', 'Av consitucion', '12', 'a', '12121', '2961156892', 'auzziellopezvaldez@gmail.com', 'Jaun Pedro', 'Carlos', 'lopez', 'MPEI310305MTC', 'MPEI310305MTCKMK25', 1, '2025-07-30 13:27:35', '2025-08-06 11:42:41', NULL, 'client', 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
  `id_user_folder` int(11) DEFAULT NULL COMMENT 'tbl users',
  `id_customer_folder` int(11) DEFAULT NULL COMMENT 'tbl users',
  `company_id` int(11) DEFAULT NULL COMMENT 'tbl companies - empresa relacionada',
  `fk_folder` int(11) DEFAULT NULL,
  `tipo_persona` enum('fisica','moral','fideicomiso') DEFAULT NULL,
  `pf_nombre` varchar(100) DEFAULT NULL,
  `pf_apellido_paterno` varchar(100) DEFAULT NULL,
  `pf_apellido_materno` varchar(100) DEFAULT NULL,
  `pf_fecha_nacimiento` date DEFAULT NULL,
  `pf_estado` varchar(100) DEFAULT NULL,
  `pf_ciudad` varchar(100) DEFAULT NULL,
  `pf_colonia` varchar(100) DEFAULT NULL,
  `pf_codigo_postal` varchar(5) DEFAULT NULL,
  `pf_calle` varchar(200) DEFAULT NULL,
  `pf_num_exterior` varchar(20) DEFAULT NULL,
  `pf_num_interior` varchar(20) DEFAULT NULL,
  `pf_telefono` varchar(20) DEFAULT NULL,
  `pf_email` varchar(100) DEFAULT NULL,
  `pf_tiene_domicilio_extranjero` tinyint(1) DEFAULT 0,
  `pf_pais_origen` varchar(100) DEFAULT NULL,
  `pf_estado_extranjero` varchar(100) DEFAULT NULL,
  `pf_ciudad_extranjero` varchar(100) DEFAULT NULL,
  `pf_colonia_extranjero` varchar(100) DEFAULT NULL,
  `pf_calle_extranjero` varchar(200) DEFAULT NULL,
  `pf_num_exterior_ext` varchar(20) DEFAULT NULL,
  `pf_num_interior_ext` varchar(20) DEFAULT NULL,
  `pf_codigo_postal_ext` varchar(20) DEFAULT NULL,
  `pm_razon_social` varchar(200) DEFAULT NULL,
  `pm_fecha_constitucion` date DEFAULT NULL,
  `pm_apoderado_nombre` varchar(100) DEFAULT NULL,
  `pm_apoderado_paterno` varchar(100) DEFAULT NULL,
  `pm_apoderado_materno` varchar(100) DEFAULT NULL,
  `pm_apoderado_fecha_nacimiento` date DEFAULT NULL,
  `pm_apoderado_rfc` varchar(13) DEFAULT NULL,
  `pm_apoderado_curp` varchar(18) DEFAULT NULL,
  `pm_estado` varchar(100) DEFAULT NULL,
  `pm_ciudad` varchar(100) DEFAULT NULL,
  `pm_colonia` varchar(100) DEFAULT NULL,
  `pm_codigo_postal` varchar(5) DEFAULT NULL,
  `pm_calle` varchar(200) DEFAULT NULL,
  `pm_num_exterior` varchar(20) DEFAULT NULL,
  `pm_num_interior` varchar(20) DEFAULT NULL,
  `pm_telefono` varchar(20) DEFAULT NULL,
  `pm_email` varchar(100) DEFAULT NULL,
  `pm_tiene_domicilio_extranjero` tinyint(1) DEFAULT 0,
  `pm_pais_origen` varchar(100) DEFAULT NULL,
  `pm_estado_extranjero` varchar(100) DEFAULT NULL,
  `pm_ciudad_extranjero` varchar(100) DEFAULT NULL,
  `pm_colonia_extranjero` varchar(100) DEFAULT NULL,
  `pm_calle_extranjero` varchar(200) DEFAULT NULL,
  `pm_num_exterior_ext` varchar(20) DEFAULT NULL,
  `pm_num_interior_ext` varchar(20) DEFAULT NULL,
  `pm_codigo_postal_ext` varchar(20) DEFAULT NULL,
  `fid_razon_social` varchar(200) DEFAULT NULL,
  `fid_numero_referencia` varchar(50) DEFAULT NULL,
  `fid_apoderado_nombre` varchar(100) DEFAULT NULL,
  `fid_apoderado_paterno` varchar(100) DEFAULT NULL,
  `fid_apoderado_materno` varchar(100) DEFAULT NULL,
  `fid_apoderado_fecha_nacimiento` date DEFAULT NULL,
  `fid_apoderado_rfc` varchar(13) DEFAULT NULL,
  `fid_apoderado_curp` varchar(18) DEFAULT NULL,
  `fid_estado` varchar(100) DEFAULT NULL,
  `fid_ciudad` varchar(100) DEFAULT NULL,
  `fid_colonia` varchar(100) DEFAULT NULL,
  `fid_codigo_postal` varchar(5) DEFAULT NULL,
  `fid_calle` varchar(200) DEFAULT NULL,
  `fid_num_exterior` varchar(20) DEFAULT NULL,
  `fid_num_interior` varchar(20) DEFAULT NULL,
  `fid_telefono` varchar(20) DEFAULT NULL,
  `fid_email` varchar(100) DEFAULT NULL,
  `fid_tiene_domicilio_extranjero` tinyint(1) DEFAULT 0,
  `fid_pais_origen` varchar(100) DEFAULT NULL,
  `fid_estado_extranjero` varchar(100) DEFAULT NULL,
  `fid_ciudad_extranjero` varchar(100) DEFAULT NULL,
  `fid_colonia_extranjero` varchar(100) DEFAULT NULL,
  `fid_calle_extranjero` varchar(200) DEFAULT NULL,
  `fid_num_exterior_ext` varchar(20) DEFAULT NULL,
  `fid_num_interior_ext` varchar(20) DEFAULT NULL,
  `fid_codigo_postal_ext` varchar(20) DEFAULT NULL,
  `key_folder` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `name_folder` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Nombre completo o razón social',
  `rfc_folder` varchar(13) DEFAULT NULL COMMENT 'RFC genérico (PF, PM o Fideicomiso)',
  `curp_folder` varchar(18) DEFAULT NULL COMMENT 'CURP (solo para PF)',
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

INSERT INTO `folders` (`id_folder`, `id_user_folder`, `id_customer_folder`, `company_id`, `fk_folder`, `tipo_persona`, `pf_nombre`, `pf_apellido_paterno`, `pf_apellido_materno`, `pf_fecha_nacimiento`, `pf_estado`, `pf_ciudad`, `pf_colonia`, `pf_codigo_postal`, `pf_calle`, `pf_num_exterior`, `pf_num_interior`, `pf_telefono`, `pf_email`, `pf_tiene_domicilio_extranjero`, `pf_pais_origen`, `pf_estado_extranjero`, `pf_ciudad_extranjero`, `pf_colonia_extranjero`, `pf_calle_extranjero`, `pf_num_exterior_ext`, `pf_num_interior_ext`, `pf_codigo_postal_ext`, `pm_razon_social`, `pm_fecha_constitucion`, `pm_apoderado_nombre`, `pm_apoderado_paterno`, `pm_apoderado_materno`, `pm_apoderado_fecha_nacimiento`, `pm_apoderado_rfc`, `pm_apoderado_curp`, `pm_estado`, `pm_ciudad`, `pm_colonia`, `pm_codigo_postal`, `pm_calle`, `pm_num_exterior`, `pm_num_interior`, `pm_telefono`, `pm_email`, `pm_tiene_domicilio_extranjero`, `pm_pais_origen`, `pm_estado_extranjero`, `pm_ciudad_extranjero`, `pm_colonia_extranjero`, `pm_calle_extranjero`, `pm_num_exterior_ext`, `pm_num_interior_ext`, `pm_codigo_postal_ext`, `fid_razon_social`, `fid_numero_referencia`, `fid_apoderado_nombre`, `fid_apoderado_paterno`, `fid_apoderado_materno`, `fid_apoderado_fecha_nacimiento`, `fid_apoderado_rfc`, `fid_apoderado_curp`, `fid_estado`, `fid_ciudad`, `fid_colonia`, `fid_codigo_postal`, `fid_calle`, `fid_num_exterior`, `fid_num_interior`, `fid_telefono`, `fid_email`, `fid_tiene_domicilio_extranjero`, `fid_pais_origen`, `fid_estado_extranjero`, `fid_ciudad_extranjero`, `fid_colonia_extranjero`, `fid_calle_extranjero`, `fid_num_exterior_ext`, `fid_num_interior_ext`, `fid_codigo_postal_ext`, `key_folder`, `name_folder`, `rfc_folder`, `curp_folder`, `address_folder`, `first_fech_folder`, `second_fech_folder`, `chk_alta_fact_folder`, `chk_lib_folder`, `chk_orig_recib_folder`, `fech_orig_recib_folder`, `status_folder`, `created_at_folder`, `updated_at_folder`, `eliminated_at_folder`) VALUES
(7, 2, 0, 11, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'XCJ5Z0UKAY', 'Inmobiliaria 4', NULL, NULL, NULL, '2025-07-01', '2025-08-30', NULL, NULL, NULL, NULL, 1, '2025-07-30 13:27:35', '2025-08-06 09:32:46', NULL),
(9, 2, 0, NULL, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'CARP-HQT1LA', 'PDF', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2025-07-30 13:31:39', '2025-07-30 13:31:39', '2025-07-30 13:33:06'),
(10, 5, 0, NULL, 7, 'fisica', 'Juan', 'Perez', 'Lopez', '2000-10-20', 'Veracruz', 'Cardel', 'General Vicente', '90000', 'Av. Cedro', '13', '2', '5659139591', 'jaime@gmail.com', 0, '', '', '', '', '', '', '', '', '', NULL, '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', 'CLI-E6VNC0', 'Juan Perez Lopez', 'LACX280506GR6', 'ZFVH400209HCHMDV85', 'Av Cedro 14 Vicente Lopez Ciudad Cardel', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-08-03 12:04:32', '2025-08-06 13:45:49', NULL),
(11, 2, 0, NULL, 7, 'fisica', 'Juan', 'Perez', 'Lopez', '1999-11-12', 'Tabasco', 'Villahermosa', 'Centro', '86000', 'Av. Siempre', '123', 'A', '9931720723', 'correo@gmail.com', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'CLI-E0NWK4', 'Juan Perez Lopez', 'VRNR880521HCM', 'VRNR880521HCMKOY95', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2025-08-06 10:46:01', '2025-08-06 10:46:01', '2025-08-06 10:46:35'),
(12, 2, 0, NULL, 7, 'moral', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Empresa SA de CV', '1212-12-12', 'Uzziel', 'Lopez', 'Valdez', '2000-10-26', 'OASW510513MCM', 'OASW510513MCMNAE65', 'Veracruz', 'Cardel', 'General Pachuca', '96780', 'Av cedro ', '12', NULL, '2296018327', 'qbeahanw_o548f@vixej.com', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'CLI-T8MSE4', 'Empresa SA de CV', 'OASW510513MC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2025-08-06 11:01:08', '2025-08-06 11:01:08', '2025-08-06 11:10:02'),
(13, 2, 0, NULL, 7, 'fisica', 'Jaime', 'Perez', 'Lopez', '2000-10-26', 'Tabasco', 'Villahermosa', 'Centro', '86000', 'AV siempre', '123', 'A', '2296018327', 'hubenacauffa-3470@yopmail.com', 1, 'Estados Unidos', 'Texas', 'Houston', 'Colonia', 'Calle del Extranjero', '1232', '1234', '21332323221', '', NULL, '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', 'CLI-3HVFYX', 'Jaime Perez Lopez', 'OASW510513MCF', 'OASW510513MCMNAE65', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-08-06 11:09:45', '2025-08-11 19:22:39', NULL),
(15, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-08-11 19:24:10', '2025-08-11 19:24:10', NULL);

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
-- Estructura de tabla para la tabla `operation_beneficiarios`
--

CREATE TABLE `operation_beneficiarios` (
  `id_beneficiario` int(11) NOT NULL,
  `id_pm` int(11) NOT NULL COMMENT 'tbl operation_persona_moral',
  `beneficiario_nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `beneficiario_paterno` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `beneficiario_materno` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `beneficiario_rfc` varchar(13) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `beneficiario_curp` varchar(18) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `beneficiario_fecha_nacimiento` date DEFAULT NULL,
  `beneficiario_nacionalidad` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT 'Mexicana',
  `beneficiario_pais_nacimiento` varchar(50) DEFAULT 'México',
  `beneficiario_tipo_participacion` varchar(50) DEFAULT NULL,
  `beneficiario_fecha_bc` date DEFAULT NULL,
  `beneficiario_es_directo` enum('si','no') DEFAULT 'si',
  `beneficiario_estado` varchar(100) DEFAULT NULL,
  `beneficiario_ciudad` varchar(100) DEFAULT NULL,
  `beneficiario_colonia` varchar(100) DEFAULT NULL,
  `beneficiario_calle` varchar(200) DEFAULT NULL,
  `beneficiario_num_exterior` varchar(10) DEFAULT NULL,
  `beneficiario_num_interior` varchar(10) DEFAULT NULL,
  `beneficiario_cp` varchar(10) DEFAULT NULL,
  `beneficiario_correo` varchar(100) DEFAULT NULL,
  `beneficiario_telefono` varchar(15) DEFAULT NULL,
  `beneficiario_porcentaje` decimal(5,2) DEFAULT NULL,
  `cadena_titularidad` enum('si','no') DEFAULT 'no',
  `descripcion_cadena` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operation_control_efectivo`
--

CREATE TABLE `operation_control_efectivo` (
  `id_control` int(11) NOT NULL,
  `id_fid` int(11) NOT NULL COMMENT 'tbl operation_fideicomiso',
  `control_nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `control_paterno` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `control_materno` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `control_rfc` varchar(13) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `control_curp` varchar(18) DEFAULT NULL,
  `control_fecha_nacimiento` date DEFAULT NULL,
  `control_nacionalidad` varchar(50) DEFAULT 'Mexicana',
  `control_pais_nacimiento` varchar(50) DEFAULT 'México',
  `control_tipo_participacion` varchar(50) DEFAULT NULL,
  `control_fecha_bc` date DEFAULT NULL,
  `control_es_directo` enum('si','no') DEFAULT 'si',
  `control_estado` varchar(100) DEFAULT NULL,
  `control_ciudad` varchar(100) DEFAULT NULL,
  `control_colonia` varchar(100) DEFAULT NULL,
  `control_calle` varchar(200) DEFAULT NULL,
  `control_num_exterior` varchar(10) DEFAULT NULL,
  `control_num_interior` varchar(10) DEFAULT NULL,
  `control_cp` varchar(10) DEFAULT NULL,
  `control_correo` varchar(100) DEFAULT NULL,
  `control_telefono` varchar(15) DEFAULT NULL,
  `control_porcentaje` decimal(5,2) DEFAULT NULL,
  `cadena_titularidad` enum('si','no') DEFAULT 'no',
  `descripcion_cadena` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operation_fideicomisarios`
--

CREATE TABLE `operation_fideicomisarios` (
  `id_fideicomisario` int(11) NOT NULL,
  `id_fid` int(11) NOT NULL COMMENT 'tbl operation_fideicomiso',
  `fideicomisario_nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fideicomisario_paterno` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fideicomisario_materno` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `fideicomisario_rfc` varchar(13) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fideicomisario_curp` varchar(18) DEFAULT NULL,
  `fideicomisario_fecha_nacimiento` date DEFAULT NULL,
  `fideicomisario_nacionalidad` varchar(50) DEFAULT 'Mexicana',
  `fideicomisario_pais_nacimiento` varchar(50) DEFAULT 'México',
  `fideicomisario_tipo_participacion` varchar(50) DEFAULT NULL,
  `fideicomisario_fecha_bc` date DEFAULT NULL,
  `fideicomisario_es_directo` enum('si','no') DEFAULT 'si',
  `fideicomisario_estado` varchar(100) DEFAULT NULL,
  `fideicomisario_ciudad` varchar(100) DEFAULT NULL,
  `fideicomisario_colonia` varchar(100) DEFAULT NULL,
  `fideicomisario_calle` varchar(200) DEFAULT NULL,
  `fideicomisario_num_exterior` varchar(10) DEFAULT NULL,
  `fideicomisario_num_interior` varchar(10) DEFAULT NULL,
  `fideicomisario_cp` varchar(10) DEFAULT NULL,
  `fideicomisario_correo` varchar(100) DEFAULT NULL,
  `fideicomisario_telefono` varchar(15) DEFAULT NULL,
  `fideicomisario_porcentaje` decimal(5,2) DEFAULT NULL,
  `cadena_titularidad` enum('si','no') DEFAULT 'no',
  `descripcion_cadena` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operation_fideicomiso`
--

CREATE TABLE `operation_fideicomiso` (
  `id_fid` int(11) NOT NULL,
  `id_operation` int(11) NOT NULL COMMENT 'tbl vulnerable_operations',
  `fid_numero_contrato` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fid_fecha_contrato` date DEFAULT NULL,
  `fid_tipo_fideicomiso` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `fid_proposito` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `fid_numero_referencia` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `fid_pais` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT 'México',
  `fid_estado` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `fid_ciudad` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `fid_colonia` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `fid_calle` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `fid_num_exterior` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `fid_num_interior` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `fid_codigo_postal` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `fid_tiene_domicilio_extranjero` tinyint(1) DEFAULT 0,
  `fid_pais_extranjero` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `fid_estado_extranjero` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `fid_ciudad_extranjero` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `fid_direccion_extranjero` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `fid_codigo_postal_extranjero` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `fid_apoderado_nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `fid_apoderado_paterno` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `fid_apoderado_materno` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `fid_telefono` varchar(15) DEFAULT NULL,
  `fid_email` varchar(100) DEFAULT NULL,
  `fid_razon_social` varchar(200) DEFAULT NULL,
  `fid_rfc` varchar(13) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operation_fideicomitentes`
--

CREATE TABLE `operation_fideicomitentes` (
  `id_fideicomitente` int(11) NOT NULL,
  `id_fid` int(11) NOT NULL COMMENT 'tbl operation_fideicomiso',
  `fideicomitente_nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fideicomitente_paterno` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fideicomitente_materno` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `fideicomitente_rfc` varchar(13) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fideicomitente_curp` varchar(18) DEFAULT NULL,
  `fideicomitente_fecha_nacimiento` date DEFAULT NULL,
  `fideicomitente_nacionalidad` varchar(50) DEFAULT 'Mexicana',
  `fideicomitente_pais_nacimiento` varchar(50) DEFAULT 'México',
  `fideicomitente_tipo_participacion` varchar(50) DEFAULT NULL,
  `fideicomitente_fecha_bc` date DEFAULT NULL,
  `fideicomitente_es_directo` enum('si','no') DEFAULT 'si',
  `fideicomitente_estado` varchar(100) DEFAULT NULL,
  `fideicomitente_ciudad` varchar(100) DEFAULT NULL,
  `fideicomitente_colonia` varchar(100) DEFAULT NULL,
  `fideicomitente_calle` varchar(200) DEFAULT NULL,
  `fideicomitente_num_exterior` varchar(10) DEFAULT NULL,
  `fideicomitente_num_interior` varchar(10) DEFAULT NULL,
  `fideicomitente_cp` varchar(10) DEFAULT NULL,
  `fideicomitente_correo` varchar(100) DEFAULT NULL,
  `fideicomitente_telefono` varchar(15) DEFAULT NULL,
  `fideicomitente_porcentaje` decimal(5,2) DEFAULT NULL,
  `cadena_titularidad` enum('si','no') DEFAULT 'no',
  `descripcion_cadena` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operation_fiduciarios`
--

CREATE TABLE `operation_fiduciarios` (
  `id_fiduciario` int(11) NOT NULL,
  `id_fid` int(11) NOT NULL COMMENT 'tbl operation_fideicomiso',
  `fiduciario_nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fiduciario_paterno` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fiduciario_materno` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `fiduciario_rfc` varchar(13) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fiduciario_curp` varchar(18) DEFAULT NULL,
  `fiduciario_fecha_nacimiento` date DEFAULT NULL,
  `fiduciario_nacionalidad` varchar(50) DEFAULT 'Mexicana',
  `fiduciario_pais_nacimiento` varchar(50) DEFAULT 'México',
  `fiduciario_tipo_participacion` varchar(50) DEFAULT NULL,
  `fiduciario_fecha_bc` date DEFAULT NULL,
  `fiduciario_es_directo` enum('si','no') DEFAULT 'si',
  `fiduciario_estado` varchar(100) DEFAULT NULL,
  `fiduciario_ciudad` varchar(100) DEFAULT NULL,
  `fiduciario_colonia` varchar(100) DEFAULT NULL,
  `fiduciario_calle` varchar(200) DEFAULT NULL,
  `fiduciario_num_exterior` varchar(10) DEFAULT NULL,
  `fiduciario_num_interior` varchar(10) DEFAULT NULL,
  `fiduciario_cp` varchar(10) DEFAULT NULL,
  `fiduciario_correo` varchar(100) DEFAULT NULL,
  `fiduciario_telefono` varchar(15) DEFAULT NULL,
  `fiduciario_porcentaje` decimal(5,2) DEFAULT NULL,
  `cadena_titularidad` enum('si','no') DEFAULT 'no',
  `descripcion_cadena` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operation_persona_fisica`
--

CREATE TABLE `operation_persona_fisica` (
  `id_pf` int(11) NOT NULL,
  `id_operation` int(11) NOT NULL COMMENT 'tbl vulnerable_operations',
  `pf_nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `pf_apellido_paterno` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `pf_apellido_materno` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `pf_rfc` varchar(13) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `pf_curp` varchar(18) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `pf_fecha_nacimiento` date DEFAULT NULL,
  `pf_nacionalidad` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT 'Mexicana',
  `pf_telefono` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `pf_email` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `pf_pais` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT 'México',
  `pf_estado` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `pf_ciudad` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `pf_colonia` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `pf_calle` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `pf_num_exterior` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `pf_num_interior` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `pf_codigo_postal` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `pf_tiene_domicilio_extranjero` tinyint(1) DEFAULT 0,
  `pf_pais_extranjero` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `pf_estado_extranjero` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `pf_ciudad_extranjero` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `pf_direccion_extranjero` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `pf_codigo_postal_extranjero` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `operation_persona_fisica`
--

INSERT INTO `operation_persona_fisica` (`id_pf`, `id_operation`, `pf_nombre`, `pf_apellido_paterno`, `pf_apellido_materno`, `pf_rfc`, `pf_curp`, `pf_fecha_nacimiento`, `pf_nacionalidad`, `pf_telefono`, `pf_email`, `pf_pais`, `pf_estado`, `pf_ciudad`, `pf_colonia`, `pf_calle`, `pf_num_exterior`, `pf_num_interior`, `pf_codigo_postal`, `pf_tiene_domicilio_extranjero`, `pf_pais_extranjero`, `pf_estado_extranjero`, `pf_ciudad_extranjero`, `pf_direccion_extranjero`, `pf_codigo_postal_extranjero`) VALUES
(1, 1, 'sadasd', 'sadasd', 'sdasdasd', 'ZWUH290624HT1', 'ZWUH290624HT1asdas', '1212-12-12', 'Mexicana', '2961156892', 'uzziellopezvaldez@gmail.com', 'México', 'New York', 'New York', 'asdasd', 'sadasd', '21', '12', '231231', 1, '', '', '', NULL, ''),
(2, 2, 'Pablo', 'Rodríguez', 'Morales', 'ABCD0102031T2', 'ROMP050427HNDLRBA4', '2005-04-27', 'Mexicana', '8182724271', 'pablo@args.mx', 'México', 'Nuevo León', 'San Pedro Garza Garcia, NL', 'Colonial de la Sierra', 'Colonial de la Sierra', '321', '', '123456', 1, '', '', '', NULL, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operation_persona_moral`
--

CREATE TABLE `operation_persona_moral` (
  `id_pm` int(11) NOT NULL,
  `id_operation` int(11) NOT NULL COMMENT 'tbl vulnerable_operations',
  `pm_razon_social` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `pm_rfc` varchar(13) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `pm_fecha_constitucion` date DEFAULT NULL,
  `pm_pais_constitucion` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT 'México',
  `pm_giro_mercantil` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `pm_pais` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT 'México',
  `pm_estado` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `pm_ciudad` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `pm_colonia` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `pm_calle` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `pm_num_exterior` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `pm_num_interior` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `pm_codigo_postal` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `pm_tiene_domicilio_extranjero` tinyint(1) DEFAULT 0,
  `pm_pais_extranjero` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `pm_estado_extranjero` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `pm_ciudad_extranjero` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `pm_direccion_extranjero` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `pm_codigo_postal_extranjero` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `pm_representante_nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `pm_representante_paterno` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `pm_representante_materno` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `pm_representante_rfc` varchar(13) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `pm_representante_curp` varchar(18) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `pm_telefono` varchar(15) DEFAULT NULL,
  `pm_email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pld_thresholds`
--

CREATE TABLE `pld_thresholds` (
  `id_threshold` int(11) NOT NULL,
  `tipo_operacion` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `monto_minimo` decimal(15,2) NOT NULL,
  `moneda` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT 'MXN',
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `pld_thresholds`
--

INSERT INTO `pld_thresholds` (`id_threshold`, `tipo_operacion`, `monto_minimo`, `moneda`, `descripcion`, `activo`, `created_at`, `updated_at`) VALUES
(1, 'Compraventa', 1600000.00, 'MXN', 'Operaciones de compraventa que requieren aviso al SAT', 1, '2025-08-04 12:20:26', '2025-08-04 12:20:26'),
(2, 'Arrendamiento', 2000000.00, 'MXN', 'Operaciones de arrendamiento que requieren aviso al SAT', 1, '2025-08-04 12:20:26', '2025-08-04 12:20:26'),
(3, 'Donación', 800000.00, 'MXN', 'Operaciones de donación que requieren aviso al SAT', 1, '2025-08-04 12:20:26', '2025-08-04 12:20:26'),
(4, 'Fideicomiso', 1000000.00, 'MXN', 'Operaciones de fideicomiso que requieren aviso al SAT', 1, '2025-08-04 12:20:26', '2025-08-04 12:20:26'),
(5, 'Efectivo', 500000.00, 'MXN', 'Operaciones en efectivo que requieren reporte especial', 1, '2025-08-04 12:20:26', '2025-08-04 12:20:26');

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vulnerable_operations`
--

CREATE TABLE `vulnerable_operations` (
  `id_operation` int(11) NOT NULL,
  `id_user_operation` int(11) NOT NULL COMMENT 'tbl users - quien registra',
  `id_company_operation` int(11) NOT NULL COMMENT 'tbl folders - empresa (fk_folder = 0)',
  `id_client_operation` int(11) DEFAULT NULL COMMENT 'tbl folders - cliente específico',
  `key_operation` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `tipo_cliente` enum('persona_fisica','persona_moral','fideicomiso') NOT NULL,
  `tipo_operacion` enum('intermediacion','compra_directa','preventa','construccion','arrendamiento','compraventa','donacion') NOT NULL,
  `fecha_operacion` date NOT NULL,
  `monto_operacion` decimal(15,2) NOT NULL,
  `moneda` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT 'MXN',
  `moneda_otra` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `forma_pago` enum('transferencia','cheque','efectivo','credito','otro') DEFAULT 'transferencia',
  `monto_efectivo` decimal(15,2) DEFAULT NULL,
  `tipo_propiedad` varchar(100) DEFAULT NULL,
  `uso_inmueble` varchar(100) DEFAULT NULL,
  `direccion_inmueble` text DEFAULT NULL,
  `codigo_postal` varchar(10) DEFAULT NULL,
  `folio_escritura` varchar(50) DEFAULT NULL,
  `propietario_anterior` varchar(200) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `inmueble_direccion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `inmueble_valor` decimal(15,2) DEFAULT NULL,
  `inmueble_tipo` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `requiere_aviso_sat` tinyint(1) DEFAULT 0,
  `umbral_superado` tinyint(1) DEFAULT 0,
  `status_operation` int(11) NOT NULL DEFAULT 1,
  `created_at_operation` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at_operation` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at_operation` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `vulnerable_operations`
--

INSERT INTO `vulnerable_operations` (`id_operation`, `id_user_operation`, `id_company_operation`, `id_client_operation`, `key_operation`, `tipo_cliente`, `tipo_operacion`, `fecha_operacion`, `monto_operacion`, `moneda`, `moneda_otra`, `forma_pago`, `monto_efectivo`, `tipo_propiedad`, `uso_inmueble`, `direccion_inmueble`, `codigo_postal`, `folio_escritura`, `propietario_anterior`, `observaciones`, `inmueble_direccion`, `inmueble_valor`, `inmueble_tipo`, `requiere_aviso_sat`, `umbral_superado`, `status_operation`, `created_at_operation`, `updated_at_operation`, `deleted_at_operation`) VALUES
(1, 5, 11, NULL, '20RGLQ', 'persona_fisica', 'preventa', '2025-08-01', 12312312.00, 'USD', NULL, 'cheque', NULL, 'comercial', 'terreno', 'qwe', '213123', 'asdsad', 'sadasd', 'asdasdasd', NULL, NULL, NULL, 1, 1, 0, '2025-08-04 15:23:47', '2025-08-11 21:31:00', '2025-08-11 20:57:57'),
(2, 2, 11, NULL, 'C7M86Z', 'persona_fisica', 'compra_directa', '2020-10-10', 10000000.00, 'MXN', NULL, 'transferencia', NULL, 'habitacional', 'casa_residencial', 'Colonial de la Sierra 321 Col. Colonial de la Sierra', '66286', '12345678', 'Lorena Morales', NULL, NULL, NULL, NULL, 1, 1, 1, '2025-08-06 10:20:43', '2025-08-11 21:31:05', NULL),
(3, 2, 11, NULL, 'YI6MQJ', 'persona_fisica', 'intermediacion', '2020-10-10', 1000000.00, 'MXN', NULL, 'transferencia', NULL, 'habitacional', 'casa_residencial', 'Colonial de la Sierra 321', '66286', '123456', 'Juan Perez Lopez', NULL, NULL, NULL, NULL, 0, 0, 1, '2025-08-11 21:28:34', '2025-08-11 21:31:09', NULL);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_clientes_completos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_clientes_completos` (
`id_folder` int(11)
,`key_folder` varchar(30)
,`tipo_persona` enum('fisica','moral','fideicomiso')
,`status_folder` int(11)
,`created_at_folder` datetime
,`updated_at_folder` datetime
,`nombre_completo` mediumtext
,`rfc` varchar(13)
,`empresa` text
,`empresa_id` int(11)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `v_clientes_completos`
--
DROP TABLE IF EXISTS `v_clientes_completos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_clientes_completos`  AS SELECT `f`.`id_folder` AS `id_folder`, `f`.`key_folder` AS `key_folder`, `f`.`tipo_persona` AS `tipo_persona`, `f`.`status_folder` AS `status_folder`, `f`.`created_at_folder` AS `created_at_folder`, `f`.`updated_at_folder` AS `updated_at_folder`, CASE WHEN `f`.`tipo_persona` = 'fisica' THEN concat(`f`.`pf_nombre`,' ',`f`.`pf_apellido_paterno`,' ',ifnull(`f`.`pf_apellido_materno`,'')) WHEN `f`.`tipo_persona` = 'moral' THEN `f`.`pm_razon_social` WHEN `f`.`tipo_persona` = 'fideicomiso' THEN `f`.`fid_razon_social` ELSE `f`.`name_folder` END AS `nombre_completo`, CASE WHEN `f`.`tipo_persona` = 'fisica' THEN `f`.`rfc_folder` WHEN `f`.`tipo_persona` = 'moral' THEN `f`.`rfc_folder` WHEN `f`.`tipo_persona` = 'fideicomiso' THEN `f`.`rfc_folder` ELSE NULL END AS `rfc`, `c`.`name_company` AS `empresa`, `c`.`id_company` AS `empresa_id` FROM (`folders` `f` left join `companies` `c` on(`f`.`company_id` = `c`.`id_company`)) WHERE `f`.`key_folder` like 'CLI-%' AND `f`.`eliminated_at_folder` is null ;

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
  ADD KEY `idx_folders_company_id` (`company_id`),
  ADD KEY `idx_tipo_persona` (`tipo_persona`),
  ADD KEY `idx_rfc` (`rfc_folder`),
  ADD KEY `idx_pf_rfc` (`pf_nombre`,`pf_apellido_paterno`),
  ADD KEY `idx_pm_razon_social` (`pm_razon_social`),
  ADD KEY `idx_fid_razon_social` (`fid_razon_social`);

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
-- Indices de la tabla `operation_beneficiarios`
--
ALTER TABLE `operation_beneficiarios`
  ADD PRIMARY KEY (`id_beneficiario`),
  ADD KEY `idx_pm` (`id_pm`);

--
-- Indices de la tabla `operation_control_efectivo`
--
ALTER TABLE `operation_control_efectivo`
  ADD PRIMARY KEY (`id_control`),
  ADD KEY `idx_fid` (`id_fid`);

--
-- Indices de la tabla `operation_fideicomisarios`
--
ALTER TABLE `operation_fideicomisarios`
  ADD PRIMARY KEY (`id_fideicomisario`),
  ADD KEY `idx_fid` (`id_fid`);

--
-- Indices de la tabla `operation_fideicomiso`
--
ALTER TABLE `operation_fideicomiso`
  ADD PRIMARY KEY (`id_fid`),
  ADD KEY `idx_operation` (`id_operation`);

--
-- Indices de la tabla `operation_fideicomitentes`
--
ALTER TABLE `operation_fideicomitentes`
  ADD PRIMARY KEY (`id_fideicomitente`),
  ADD KEY `idx_fid` (`id_fid`);

--
-- Indices de la tabla `operation_fiduciarios`
--
ALTER TABLE `operation_fiduciarios`
  ADD PRIMARY KEY (`id_fiduciario`),
  ADD KEY `idx_fid` (`id_fid`);

--
-- Indices de la tabla `operation_persona_fisica`
--
ALTER TABLE `operation_persona_fisica`
  ADD PRIMARY KEY (`id_pf`),
  ADD KEY `idx_operation` (`id_operation`);

--
-- Indices de la tabla `operation_persona_moral`
--
ALTER TABLE `operation_persona_moral`
  ADD PRIMARY KEY (`id_pm`),
  ADD KEY `idx_operation` (`id_operation`);

--
-- Indices de la tabla `pld_thresholds`
--
ALTER TABLE `pld_thresholds`
  ADD PRIMARY KEY (`id_threshold`);

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
-- Indices de la tabla `vulnerable_operations`
--
ALTER TABLE `vulnerable_operations`
  ADD PRIMARY KEY (`id_operation`),
  ADD KEY `idx_company` (`id_company_operation`),
  ADD KEY `idx_client` (`id_client_operation`),
  ADD KEY `idx_user` (`id_user_operation`),
  ADD KEY `idx_fecha` (`fecha_operacion`),
  ADD KEY `idx_tipo_cliente` (`tipo_cliente`),
  ADD KEY `idx_company_fecha` (`id_company_operation`,`fecha_operacion`),
  ADD KEY `idx_monto` (`monto_operacion`),
  ADD KEY `idx_status` (`status_operation`),
  ADD KEY `idx_alerts` (`requiere_aviso_sat`,`umbral_superado`),
  ADD KEY `idx_vo_tipo_fecha` (`tipo_cliente`,`fecha_operacion`),
  ADD KEY `idx_vo_monto_umbral` (`monto_operacion`,`requiere_aviso_sat`);

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
  MODIFY `id_folder` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
-- AUTO_INCREMENT de la tabla `operation_beneficiarios`
--
ALTER TABLE `operation_beneficiarios`
  MODIFY `id_beneficiario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `operation_control_efectivo`
--
ALTER TABLE `operation_control_efectivo`
  MODIFY `id_control` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `operation_fideicomisarios`
--
ALTER TABLE `operation_fideicomisarios`
  MODIFY `id_fideicomisario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `operation_fideicomiso`
--
ALTER TABLE `operation_fideicomiso`
  MODIFY `id_fid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `operation_fideicomitentes`
--
ALTER TABLE `operation_fideicomitentes`
  MODIFY `id_fideicomitente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `operation_fiduciarios`
--
ALTER TABLE `operation_fiduciarios`
  MODIFY `id_fiduciario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `operation_persona_fisica`
--
ALTER TABLE `operation_persona_fisica`
  MODIFY `id_pf` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `operation_persona_moral`
--
ALTER TABLE `operation_persona_moral`
  MODIFY `id_pm` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pld_thresholds`
--
ALTER TABLE `pld_thresholds`
  MODIFY `id_threshold` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- AUTO_INCREMENT de la tabla `vulnerable_operations`
--
ALTER TABLE `vulnerable_operations`
  MODIFY `id_operation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `folders`
--
ALTER TABLE `folders`
  ADD CONSTRAINT `fk_folders_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id_company`) ON DELETE SET NULL;

--
-- Filtros para la tabla `operation_beneficiarios`
--
ALTER TABLE `operation_beneficiarios`
  ADD CONSTRAINT `operation_beneficiarios_ibfk_1` FOREIGN KEY (`id_pm`) REFERENCES `operation_persona_moral` (`id_pm`) ON DELETE CASCADE;

--
-- Filtros para la tabla `operation_control_efectivo`
--
ALTER TABLE `operation_control_efectivo`
  ADD CONSTRAINT `operation_control_efectivo_ibfk_1` FOREIGN KEY (`id_fid`) REFERENCES `operation_fideicomiso` (`id_fid`) ON DELETE CASCADE;

--
-- Filtros para la tabla `operation_fideicomisarios`
--
ALTER TABLE `operation_fideicomisarios`
  ADD CONSTRAINT `operation_fideicomisarios_ibfk_1` FOREIGN KEY (`id_fid`) REFERENCES `operation_fideicomiso` (`id_fid`) ON DELETE CASCADE;

--
-- Filtros para la tabla `operation_fideicomiso`
--
ALTER TABLE `operation_fideicomiso`
  ADD CONSTRAINT `operation_fideicomiso_ibfk_1` FOREIGN KEY (`id_operation`) REFERENCES `vulnerable_operations` (`id_operation`) ON DELETE CASCADE;

--
-- Filtros para la tabla `operation_fideicomitentes`
--
ALTER TABLE `operation_fideicomitentes`
  ADD CONSTRAINT `operation_fideicomitentes_ibfk_1` FOREIGN KEY (`id_fid`) REFERENCES `operation_fideicomiso` (`id_fid`) ON DELETE CASCADE;

--
-- Filtros para la tabla `operation_fiduciarios`
--
ALTER TABLE `operation_fiduciarios`
  ADD CONSTRAINT `operation_fiduciarios_ibfk_1` FOREIGN KEY (`id_fid`) REFERENCES `operation_fideicomiso` (`id_fid`) ON DELETE CASCADE;

--
-- Filtros para la tabla `operation_persona_fisica`
--
ALTER TABLE `operation_persona_fisica`
  ADD CONSTRAINT `operation_persona_fisica_ibfk_1` FOREIGN KEY (`id_operation`) REFERENCES `vulnerable_operations` (`id_operation`) ON DELETE CASCADE;

--
-- Filtros para la tabla `operation_persona_moral`
--
ALTER TABLE `operation_persona_moral`
  ADD CONSTRAINT `operation_persona_moral_ibfk_1` FOREIGN KEY (`id_operation`) REFERENCES `vulnerable_operations` (`id_operation`) ON DELETE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_company`) REFERENCES `companies` (`id_company`) ON DELETE SET NULL;

--
-- Filtros para la tabla `vulnerable_operations`
--
ALTER TABLE `vulnerable_operations`
  ADD CONSTRAINT `fk_vo_company` FOREIGN KEY (`id_company_operation`) REFERENCES `companies` (`id_company`),
  ADD CONSTRAINT `fk_vo_user` FOREIGN KEY (`id_user_operation`) REFERENCES `users` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 28-07-2025 a las 16:07:09
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
-- Base de datos: `adm_fultra`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `currencies`
--

CREATE TABLE `currencies` (
  `id_currency` int(11) NOT NULL,
  `code_currency` varchar(3) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `name_currency` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `status_currency` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `currencies`
--

INSERT INTO `currencies` (`id_currency`, `code_currency`, `name_currency`, `status_currency`) VALUES
(1, 'MXN', 'Peso Mexicano', 1),
(2, 'USD', 'Dólar Estadounidense', 1),
(3, 'EUR', 'Euro', 1);

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

--
-- Volcado de datos para la tabla `folders`
--

INSERT INTO `folders` (`id_folder`, `id_user_folder`, `id_customer_folder`, `fk_folder`, `key_folder`, `name_folder`, `first_fech_folder`, `second_fech_folder`, `chk_alta_fact_folder`, `chk_lib_folder`, `chk_orig_recib_folder`, `fech_orig_recib_folder`, `status_folder`, `created_at_folder`, `updated_at_folder`, `eliminated_at_folder`) VALUES
(1, 2, 0, 0, 'CARP-0KONJH', 'Pruebas Uzziel', '2025-07-27', '2025-08-07', NULL, 'Si', NULL, NULL, 3, '2025-07-27 17:23:38', '2025-07-27 17:23:38', '2025-07-27 17:40:12'),
(2, 2, 0, 0, 'CARP-JXPWZI', 'asdasd', '2025-01-12', '2025-12-12', 'Si', NULL, NULL, NULL, 3, '2025-07-27 17:46:48', '2025-07-27 17:47:16', '2025-07-27 17:53:28'),
(3, 2, 0, 0, 'CARP-WOXF73', 'asasd', '2025-01-12', '2025-12-12', 'Si', NULL, NULL, NULL, 3, '2025-07-27 17:47:43', '2025-07-27 17:47:43', '2025-07-27 17:47:52'),
(4, 2, 0, 2, 'CARP-61KG9W', 'adasd', '2024-12-12', '2025-12-12', NULL, 'Si', NULL, NULL, 3, '2025-07-27 17:53:12', '2025-07-27 17:53:12', '2025-07-27 17:53:24'),
(5, 2, 0, 0, 'CARP-LOKQGR', 'asd', '2025-07-01', '2025-07-31', 'Si', NULL, NULL, NULL, 3, '2025-07-27 18:35:11', '2025-07-27 18:35:11', '2025-07-28 07:19:01'),
(6, 2, 0, 0, 'CARP-9X6A4I', 'Uzziel Lopez', '2025-07-01', '2025-07-31', 'Si', NULL, NULL, NULL, 1, '2025-07-28 07:21:44', '2025-07-28 07:21:44', NULL),
(7, 2, 0, 6, 'CARP-14ILH0', 'Carpeta 1', '2025-07-01', '2025-07-31', NULL, NULL, NULL, NULL, 3, '2025-07-28 07:22:17', '2025-07-28 07:22:17', '2025-07-28 07:26:46'),
(8, 2, 0, 6, 'CARP-GJTV6N', 'Expediente 1', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-07-28 07:55:41', '2025-07-28 07:55:41', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `identification_types`
--

CREATE TABLE `identification_types` (
  `id_identification_type` int(11) NOT NULL,
  `name_identification_type` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `status_identification_type` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `identification_types`
--

INSERT INTO `identification_types` (`id_identification_type`, `name_identification_type`, `status_identification_type`) VALUES
(1, 'INE/IFE', 1),
(2, 'Pasaporte', 1),
(3, 'Cédula Profesional', 1),
(4, 'Licencia de Conducir', 1),
(5, 'Cartilla del Servicio Militar', 1),
(6, 'Otro', 1);

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
(2, 2, '0'),
(3, 3, '0');

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
-- Estructura de tabla para la tabla `operation_parties`
--

CREATE TABLE `operation_parties` (
  `id_party` int(11) NOT NULL,
  `id_operation` int(11) NOT NULL COMMENT 'tbl vulnerable_operations',
  `party_role` enum('buyer','seller') CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `party_type` enum('fisica','moral','fideicomiso') CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `full_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre o razón social',
  `rfc` varchar(13) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'RFC - Obligatorio en XML',
  `nationality` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT 'Mexicana' COMMENT 'Nacionalidad - Obligatorio para física',
  `occupation_business` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Ocupación o giro - Obligatorio',
  `address_street` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `address_number` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `address_neighborhood` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `address_city` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `address_state` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `address_country` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT 'México',
  `address_postal_code` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `curp` varchar(18) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'CURP - Recomendado para física',
  `id_identification_type` int(11) DEFAULT NULL COMMENT 'Tipo de identificación - Obligatorio para física',
  `identification_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Número de identificación - Obligatorio para física',
  `legal_representative` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `legal_rep_rfc` varchar(13) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `trustee_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `trustor_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `beneficiary_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `trust_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `controlled_beneficiary_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `controlled_beneficiary_percentage` decimal(5,2) DEFAULT NULL,
  `status_party` int(11) NOT NULL DEFAULT 1,
  `created_at_party` datetime NOT NULL,
  `updated_at_party` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operation_types`
--

CREATE TABLE `operation_types` (
  `id_operation_type` int(11) NOT NULL,
  `name_operation_type` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `status_operation_type` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `operation_types`
--

INSERT INTO `operation_types` (`id_operation_type`, `name_operation_type`, `status_operation_type`) VALUES
(1, 'Compra directa', 1),
(2, 'Intermediación', 1),
(3, 'Preventa', 1),
(4, 'Arrendamiento', 1),
(5, 'Construcción', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id_payment_method` int(11) NOT NULL,
  `name_payment_method` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `status_payment_method` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `payment_methods`
--

INSERT INTO `payment_methods` (`id_payment_method`, `name_payment_method`, `status_payment_method`) VALUES
(1, 'Transferencia bancaria', 1),
(2, 'Cheque', 1),
(3, 'Efectivo', 1),
(4, 'Crédito', 1),
(5, 'Otro', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `property_uses`
--

CREATE TABLE `property_uses` (
  `id_property_use` int(11) NOT NULL,
  `name_property_use` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `status_property_use` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `property_uses`
--

INSERT INTO `property_uses` (`id_property_use`, `name_property_use`, `status_property_use`) VALUES
(1, 'Habitacional', 1),
(2, 'Comercial', 1),
(3, 'Industrial', 1),
(4, 'Mixto', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `real_estate_companies`
--

CREATE TABLE `real_estate_companies` (
  `id_company` int(11) NOT NULL,
  `key_company` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `company_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Razón social de la inmobiliaria',
  `rfc_company` varchar(13) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `business_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Nombre comercial',
  `address_street` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `address_number` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `address_neighborhood` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `address_city` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `address_state` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `address_country` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT 'México',
  `address_postal_code` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `legal_representative` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `legal_rep_rfc` varchar(13) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `phone` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `website` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `missing_contact_info` tinyint(1) DEFAULT 0 COMMENT '1 si falta teléfono o email',
  `missing_address_details` tinyint(1) DEFAULT 0 COMMENT '1 si falta información del domicilio',
  `missing_legal_info` tinyint(1) DEFAULT 0 COMMENT '1 si falta información del representante legal',
  `status_company` int(11) NOT NULL DEFAULT 1,
  `created_at_company` datetime NOT NULL,
  `updated_at_company` datetime NOT NULL,
  `eliminated_at_company` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `real_estate_companies`
--

INSERT INTO `real_estate_companies` (`id_company`, `key_company`, `company_name`, `rfc_company`, `business_name`, `address_street`, `address_number`, `address_neighborhood`, `address_city`, `address_state`, `address_country`, `address_postal_code`, `legal_representative`, `legal_rep_rfc`, `phone`, `email`, `website`, `missing_contact_info`, `missing_address_details`, `missing_legal_info`, `status_company`, `created_at_company`, `updated_at_company`, `eliminated_at_company`) VALUES
(1, 'COMP-ABC123', 'Inmobiliaria del Centro SA de CV', 'IDC123456789', 'Inmobiliaria del Centro', 'Av. Central', '123', 'Centro', 'Tuxtla Gutiérrez', 'Chiapas', 'México', '29000', 'Juan Carlos López', 'LOCJ800101ABC', '9611234567', 'contacto@inmobiliariacentro.mx', NULL, 0, 0, 0, 1, '2025-07-27 19:33:07', '2025-07-27 19:33:07', NULL),
(2, 'COMP-DEF456', 'Bienes Raíces Premium SA de CV', 'BRP987654321', 'Premium Real Estate', 'Blvd. Los Empresarios', '456', 'Las Arboledas', 'Tuxtla Gutiérrez', 'Chiapas', 'México', '29040', 'María Elena García', 'GARM750215DEF', '9617654321', 'info@premiumrealestate.mx', NULL, 0, 0, 0, 1, '2025-07-27 19:33:07', '2025-07-27 19:33:07', NULL),
(3, 'COMP-GHI789', 'Desarrollos Inmobiliarios del Sur SA', 'DIS456789123', 'Desarrollos del Sur', 'Calle Reforma', '789', 'La Pochota', 'Tuxtla Gutiérrez', 'Chiapas', 'México', '29050', 'Roberto Mendoza Silva', 'MESR680920GHI', '9613456789', 'ventas@desarrollossur.mx', NULL, 0, 0, 0, 1, '2025-07-27 19:33:07', '2025-07-27 19:33:07', NULL);

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

--
-- Volcado de datos para la tabla `sections`
--

INSERT INTO `sections` (`id_section`, `id_user_section`, `key_section`, `title_section`, `chk_view_empl`, `chk_view_sales`, `status_section`, `created_at_section`, `updated_at_section`, `deleted_at_section`) VALUES
(1, 2, 'SEC-B7XZ2F', 'asd', 'Si', NULL, 2, '2025-07-27 17:15:28', '2025-07-27 17:15:28', '2025-07-27 17:15:33');

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

--
-- Volcado de datos para la tabla `tracings`
--

INSERT INTO `tracings` (`id_tracing`, `id_folder_tracing`, `id_user_tracing`, `key_tracing`, `comment_tracing`, `status_tracing`, `created_at_tracing`, `updated_at_tracing`, `deleted_at_tracing`) VALUES
(1, 1, 2, 'TRC-GWR96I', 'asd', 2, '2025-07-27 17:36:53', '2025-07-27 17:36:53', '2025-07-27 17:36:59'),
(2, 6, 2, 'TRC-0R5B1X', 'PDF EXCel', 2, '2025-07-28 07:26:35', '2025-07-28 07:26:35', '2025-07-28 07:54:37');

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
(2, 1, 'USR-ITFEG', 'ADMINISTRACION FULTRA', 'HEJI7FQRCK9NV', NULL, '1234567890', 'administracion@fultra.mx', '$2y$10$htIObbM0rMSJOTnZ5BWEnemZ1J/aF9inLxBaIbipybPHyaILW515.', 1, '2025-01-31 14:31:55', '2025-01-31 14:31:55', NULL),
(3, 3, 'USR-H3CG8', 'JAIME', '9AQY7Z5UHOL2X', NULL, '5659139591', 'uzziellopezvaldez@gmail.com', '$2y$10$LkbE3UALOQpZq2PYoka5MeHBJB33v6O3zRMxMJ11uIPQh.C292J0u', 3, '2025-07-27 17:43:10', '2025-07-27 17:43:10', '2025-07-27 17:44:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vulnerable_operations`
--

CREATE TABLE `vulnerable_operations` (
  `id_operation` int(11) NOT NULL,
  `id_user_operation` int(11) NOT NULL COMMENT 'Usuario que registra - tbl users',
  `key_operation` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `operation_date` date NOT NULL COMMENT 'Fecha de operación',
  `id_operation_type` int(11) NOT NULL COMMENT 'Tipo de operación - tbl operation_types',
  `id_payment_method` int(11) NOT NULL COMMENT 'Forma de pago - tbl payment_methods',
  `id_currency` int(11) NOT NULL COMMENT 'Moneda - tbl currencies',
  `exchange_rate` decimal(10,4) DEFAULT NULL COMMENT 'Tipo de cambio si no es MXN',
  `operation_amount` decimal(15,2) NOT NULL COMMENT 'Monto total de la operación',
  `cash_amount` decimal(15,2) DEFAULT 0.00 COMMENT 'Monto en efectivo para validar Art. 32',
  `id_property_use` int(11) NOT NULL COMMENT 'Uso del inmueble - tbl property_uses',
  `buyer_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del cliente/comprador',
  `buyer_rfc` varchar(13) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'RFC del cliente (opcional)',
  `id_folder_buyer` int(11) DEFAULT NULL COMMENT 'Liga con expediente PLD - tbl folders',
  `id_company` int(11) NOT NULL COMMENT 'Empresa inmobiliaria que registra - tbl real_estate_companies',
  `property_street` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `property_number` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `property_neighborhood` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `property_city` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `property_state` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `property_country` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT 'México',
  `previous_owner_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Nombre del propietario anterior (opcional)',
  `internal_observations` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Observaciones internas',
  `is_reportable` tinyint(1) DEFAULT 0 COMMENT '1 si supera umbral y debe reportarse',
  `xml_generated` tinyint(1) DEFAULT 0 COMMENT '1 si ya se generó XML',
  `xml_reported` tinyint(1) DEFAULT 0 COMMENT '1 si ya se reportó al SAT',
  `xml_file_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `illegal_cash_alert` tinyint(1) DEFAULT 0 COMMENT '1 si efectivo > $719,200',
  `missing_buyer_info` tinyint(1) DEFAULT 0 COMMENT '1 si falta información del comprador para XML',
  `missing_seller_info` tinyint(1) DEFAULT 0 COMMENT '1 si falta información del vendedor para XML',
  `status_operation` int(11) NOT NULL DEFAULT 1 COMMENT '1=Activa, 2=Inactiva, 3=Eliminada',
  `created_at_operation` datetime NOT NULL,
  `updated_at_operation` datetime NOT NULL,
  `eliminated_at_operation` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_operations_traffic_light`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_operations_traffic_light` (
`id_operation` int(11)
,`key_operation` varchar(15)
,`operation_date` date
,`buyer_name` varchar(255)
,`operation_amount` decimal(15,2)
,`code_currency` varchar(3)
,`company_name` varchar(255)
,`name_operation_type` varchar(50)
,`semaforo_status` varchar(8)
,`status_description` varchar(13)
,`illegal_cash_alert` tinyint(1)
,`missing_buyer_info` tinyint(1)
,`missing_seller_info` tinyint(1)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `v_operations_traffic_light`
--
DROP TABLE IF EXISTS `v_operations_traffic_light`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_operations_traffic_light`  AS SELECT `vo`.`id_operation` AS `id_operation`, `vo`.`key_operation` AS `key_operation`, `vo`.`operation_date` AS `operation_date`, `vo`.`buyer_name` AS `buyer_name`, `vo`.`operation_amount` AS `operation_amount`, `c`.`code_currency` AS `code_currency`, `rc`.`company_name` AS `company_name`, `ot`.`name_operation_type` AS `name_operation_type`, CASE WHEN `vo`.`xml_reported` = 1 THEN 'verde' WHEN `vo`.`xml_generated` = 1 AND `vo`.`xml_reported` = 0 THEN 'amarillo' WHEN `vo`.`is_reportable` = 1 AND `vo`.`xml_generated` = 0 THEN 'rojo' ELSE 'verde' END AS `semaforo_status`, CASE WHEN `vo`.`xml_reported` = 1 THEN 'Reportado' WHEN `vo`.`xml_generated` = 1 AND `vo`.`xml_reported` = 0 THEN 'XML Generado' WHEN `vo`.`is_reportable` = 1 AND `vo`.`xml_generated` = 0 THEN 'Pendiente' ELSE 'No Reportable' END AS `status_description`, `vo`.`illegal_cash_alert` AS `illegal_cash_alert`, `vo`.`missing_buyer_info` AS `missing_buyer_info`, `vo`.`missing_seller_info` AS `missing_seller_info` FROM (((`vulnerable_operations` `vo` left join `operation_types` `ot` on(`vo`.`id_operation_type` = `ot`.`id_operation_type`)) left join `currencies` `c` on(`vo`.`id_currency` = `c`.`id_currency`)) left join `real_estate_companies` `rc` on(`vo`.`id_company` = `rc`.`id_company`)) WHERE `vo`.`status_operation` = 1 ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id_currency`);

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
-- Indices de la tabla `identification_types`
--
ALTER TABLE `identification_types`
  ADD PRIMARY KEY (`id_identification_type`);

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
-- Indices de la tabla `operation_parties`
--
ALTER TABLE `operation_parties`
  ADD PRIMARY KEY (`id_party`),
  ADD KEY `idx_operation` (`id_operation`),
  ADD KEY `idx_party_role` (`party_role`),
  ADD KEY `idx_party_type` (`party_type`),
  ADD KEY `idx_rfc` (`rfc`),
  ADD KEY `idx_identification_type` (`id_identification_type`);

--
-- Indices de la tabla `operation_types`
--
ALTER TABLE `operation_types`
  ADD PRIMARY KEY (`id_operation_type`);

--
-- Indices de la tabla `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id_payment_method`);

--
-- Indices de la tabla `property_uses`
--
ALTER TABLE `property_uses`
  ADD PRIMARY KEY (`id_property_use`);

--
-- Indices de la tabla `real_estate_companies`
--
ALTER TABLE `real_estate_companies`
  ADD PRIMARY KEY (`id_company`),
  ADD UNIQUE KEY `key_company` (`key_company`),
  ADD UNIQUE KEY `rfc_company` (`rfc_company`),
  ADD KEY `idx_company_name` (`company_name`),
  ADD KEY `idx_status` (`status_company`);

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
-- Indices de la tabla `vulnerable_operations`
--
ALTER TABLE `vulnerable_operations`
  ADD PRIMARY KEY (`id_operation`),
  ADD UNIQUE KEY `key_operation` (`key_operation`),
  ADD KEY `idx_operation_date` (`operation_date`),
  ADD KEY `idx_operation_amount` (`operation_amount`),
  ADD KEY `idx_user_operation` (`id_user_operation`),
  ADD KEY `idx_operation_type` (`id_operation_type`),
  ADD KEY `idx_payment_method` (`id_payment_method`),
  ADD KEY `idx_currency` (`id_currency`),
  ADD KEY `idx_property_use` (`id_property_use`),
  ADD KEY `idx_folder_buyer` (`id_folder_buyer`),
  ADD KEY `idx_company` (`id_company`),
  ADD KEY `idx_reportable` (`is_reportable`),
  ADD KEY `idx_xml_status` (`xml_generated`,`xml_reported`),
  ADD KEY `idx_date_amount` (`operation_date`,`operation_amount`,`status_operation`),
  ADD KEY `idx_cash_alert` (`cash_amount`,`illegal_cash_alert`),
  ADD KEY `idx_xml_control` (`xml_generated`,`xml_reported`,`created_at_operation`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id_currency` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `documents`
--
ALTER TABLE `documents`
  MODIFY `id_document` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `folders`
--
ALTER TABLE `folders`
  MODIFY `id_folder` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `identification_types`
--
ALTER TABLE `identification_types`
  MODIFY `id_identification_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `materials_sections`
--
ALTER TABLE `materials_sections`
  MODIFY `id_material` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id_notification` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
-- AUTO_INCREMENT de la tabla `operation_parties`
--
ALTER TABLE `operation_parties`
  MODIFY `id_party` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `operation_types`
--
ALTER TABLE `operation_types`
  MODIFY `id_operation_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id_payment_method` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `property_uses`
--
ALTER TABLE `property_uses`
  MODIFY `id_property_use` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `real_estate_companies`
--
ALTER TABLE `real_estate_companies`
  MODIFY `id_company` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `sections`
--
ALTER TABLE `sections`
  MODIFY `id_section` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tracings`
--
ALTER TABLE `tracings`
  MODIFY `id_tracing` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- AUTO_INCREMENT de la tabla `vulnerable_operations`
--
ALTER TABLE `vulnerable_operations`
  MODIFY `id_operation` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `operation_parties`
--
ALTER TABLE `operation_parties`
  ADD CONSTRAINT `fk_party_identification` FOREIGN KEY (`id_identification_type`) REFERENCES `identification_types` (`id_identification_type`),
  ADD CONSTRAINT `fk_party_operation` FOREIGN KEY (`id_operation`) REFERENCES `vulnerable_operations` (`id_operation`) ON DELETE CASCADE;

--
-- Filtros para la tabla `vulnerable_operations`
--
ALTER TABLE `vulnerable_operations`
  ADD CONSTRAINT `fk_operation_company` FOREIGN KEY (`id_company`) REFERENCES `real_estate_companies` (`id_company`),
  ADD CONSTRAINT `fk_operation_currency` FOREIGN KEY (`id_currency`) REFERENCES `currencies` (`id_currency`),
  ADD CONSTRAINT `fk_operation_folder` FOREIGN KEY (`id_folder_buyer`) REFERENCES `folders` (`id_folder`),
  ADD CONSTRAINT `fk_operation_payment` FOREIGN KEY (`id_payment_method`) REFERENCES `payment_methods` (`id_payment_method`),
  ADD CONSTRAINT `fk_operation_property_use` FOREIGN KEY (`id_property_use`) REFERENCES `property_uses` (`id_property_use`),
  ADD CONSTRAINT `fk_operation_type` FOREIGN KEY (`id_operation_type`) REFERENCES `operation_types` (`id_operation_type`),
  ADD CONSTRAINT `fk_operation_user` FOREIGN KEY (`id_user_operation`) REFERENCES `users` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

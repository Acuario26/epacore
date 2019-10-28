/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50719
 Source Host           : localhost:3306
 Source Schema         : core

 Target Server Type    : MySQL
 Target Server Version : 50719
 File Encoding         : 65001

 Date: 28/10/2019 10:57:29
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for empleados
-- ----------------------------
DROP TABLE IF EXISTS `empleados`;
CREATE TABLE `empleados`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identificacion` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nombres` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `apellidos` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ciudad_id` int(10) NULL DEFAULT NULL,
  `cargo_id` int(10) NULL DEFAULT NULL,
  `direccion` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `celular` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `convencional` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ing_empresa` date NULL DEFAULT NULL,
  `email` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `estado` varchar(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `usuario_ing` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `updated_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `usuario_mod` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `asigna` int(11) NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of empleados
-- ----------------------------
INSERT INTO `empleados` VALUES (1, '0926339731', 'tona', 'espinoza', 1024, 1269, 'DURAN CDLA LOS HELECHOS', '0982364756', '2801544', '2018-12-01', 'anthony.espinozaf@gmail.com', 'A', '1', '2019-02-02 14:14:00', '2019-02-02 14:14:00', '1', 1);
INSERT INTO `empleados` VALUES (2, '0988888888', 'andrea', 'lozano', 1024, 1260, 'LOLA', '0987252436', '28216725', '2018-11-05', 'andrealozano@gmail.com', 'A', '1', '2019-02-02 14:03:50', '2019-02-02 14:03:50', '1', 1);
INSERT INTO `empleados` VALUES (3, '0922606223', 're', 'ca', 1024, 1259, 'XX', '0982726262', NULL, '2018-12-19', 'a@gh.com', 'A', '1', '2019-02-02 14:03:50', '2019-02-02 14:03:50', '1', 0);
INSERT INTO `empleados` VALUES (4, '0922334455', 'Operador 2', 'Operador 2', 1024, 1268, 'PRUEBA', '0922334455', '0922334455', '2019-01-28', 'a@a.com', 'A', '1', '2019-04-22 09:51:50', '2019-04-22 09:51:50', '1', 0);
INSERT INTO `empleados` VALUES (5, '0922222222', 'supervisor', 'supervisor', 1024, 1270, 'ASD', '0982625252', '2801544', '2019-01-29', 'asd@asd.com', 'A', '1', '2019-04-22 09:50:41', '2019-04-22 09:50:41', '1', 0);

-- ----------------------------
-- Table structure for menus
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `order` smallint(6) NOT NULL DEFAULT 0,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `menus_slug_unique`(`slug`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 91 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of menus
-- ----------------------------
INSERT INTO `menus` VALUES (2, 'Usuarios', '/admin/users', 10, 1, 1, NULL, NULL);
INSERT INTO `menus` VALUES (3, 'Roles', '/admin/roles', 10, 0, 1, NULL, NULL);
INSERT INTO `menus` VALUES (8, 'Menu', 'admin/MenuCreate', 10, 2, 1, NULL, NULL);
INSERT INTO `menus` VALUES (10, 'Administrador', '#', 0, 1, 1, NULL, NULL);
INSERT INTO `menus` VALUES (14, 'Parametros', 'admin/ParametroIndex', 10, 4, 1, '2018-04-10 05:48:29', '2018-04-10 05:49:04');
INSERT INTO `menus` VALUES (40, 'Sin Nivel', 'Sin Nivel', 0, 0, 1, NULL, NULL);
INSERT INTO `menus` VALUES (73, 'Directorio', 'uath/DirectorioIndex', 10, 5, 1, '2018-12-05 01:53:42', '2018-12-05 01:53:42');
INSERT INTO `menus` VALUES (74, 'Gestión', 'GESTION', 0, 2, 1, '2018-12-05 03:10:43', '2018-12-05 03:11:43');
INSERT INTO `menus` VALUES (75, 'Clientes', 'clientes/gestionIndex', 74, 1, 1, '2018-12-05 03:12:42', '2018-12-05 03:12:42');
INSERT INTO `menus` VALUES (76, 'Historial de LLamadas', 'clientes/historialCall', 74, 0, 1, '2019-02-16 01:10:17', '2019-02-16 12:02:00');
INSERT INTO `menus` VALUES (77, 'ASIGNACION LLAMADAS', 'asignacion/llamadas', 74, 0, 1, '2019-03-02 17:35:59', '2019-03-02 17:35:59');
INSERT INTO `menus` VALUES (78, 'AGENDA', 'asignacion/llamadas2', 74, 0, 1, '2019-03-11 15:03:16', '2019-03-11 15:03:16');
INSERT INTO `menus` VALUES (79, 'DIRECCIÓN FINANCIERA', 'financiera/#', 0, 2, 1, '2019-04-22 09:22:48', '2019-06-13 10:43:04');
INSERT INTO `menus` VALUES (80, 'CONTROL PREVIO', 'financiera/pagos', 79, 0, 1, '2019-04-22 09:23:31', '2019-06-13 10:43:17');
INSERT INTO `menus` VALUES (81, 'Firma Digital', 'firma/index', 0, 3, 1, '2019-04-23 10:39:16', '2019-04-23 10:39:16');
INSERT INTO `menus` VALUES (82, 'viaticos', 'financiera/viaticos', 79, 2, 1, '2019-06-26 12:03:14', '2019-06-26 12:03:14');
INSERT INTO `menus` VALUES (83, 'DTIC', 'INFORMES', 0, 5, 1, '2019-06-27 11:17:07', '2019-10-22 14:56:32');
INSERT INTO `menus` VALUES (84, 'MIS INFORMES', 'informe/informetecnicotics', 83, 1, 1, '2019-06-27 11:17:51', '2019-09-04 12:40:32');
INSERT INTO `menus` VALUES (85, 'PENDIENTES REVISIÓN', 'informe/informespendientesR', 83, 2, 1, '2019-09-04 12:41:29', '2019-09-04 16:33:46');
INSERT INTO `menus` VALUES (86, 'PENDIENTES aPROBAR', 'informe/informespendientesA', 83, 3, 1, '2019-09-04 16:34:21', '2019-09-04 16:34:21');
INSERT INTO `menus` VALUES (87, 'COMERCIAL', '#comercial', 0, 5, 1, '2019-10-22 14:59:29', '2019-10-22 14:59:46');
INSERT INTO `menus` VALUES (88, 'CARGAR LOTES', 'comercial/index', 87, 1, 1, '2019-10-22 15:10:34', '2019-10-22 15:10:48');
INSERT INTO `menus` VALUES (89, 'REPORTE DE LOTES (FACTURACIÓN)', 'reporte/ReporteGeneralIndex', 87, 2, 1, '2019-10-22 15:11:22', '2019-10-24 14:23:24');
INSERT INTO `menus` VALUES (90, 'REPORTE DE LOTES (RECAUDACIÓN)', 'reporte/ReporteGeneralIndexRecaudacion', 87, 3, 1, '2019-10-24 14:23:56', '2019-10-24 14:23:56');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (3, '2017_07_12_145959_create_permission_tables', 1);
INSERT INTO `migrations` VALUES (4, '2018_04_05_003121_create_menus_table', 2);
INSERT INTO `migrations` VALUES (5, '2018_05_31_144003_create_notifications_table', 3);

-- ----------------------------
-- Table structure for model_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions`  (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `model_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`permission_id`, `model_id`, `model_type`) USING BTREE,
  INDEX `model_has_permissions_model_id_model_type_index`(`model_id`, `model_type`) USING BTREE,
  CONSTRAINT `model_has_permissions_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for model_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles`  (
  `role_id` int(10) UNSIGNED NOT NULL,
  `model_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`role_id`, `model_id`, `model_type`) USING BTREE,
  INDEX `model_has_roles_model_id_model_type_index`(`model_id`, `model_type`) USING BTREE,
  CONSTRAINT `model_has_roles_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of model_has_roles
-- ----------------------------
INSERT INTO `model_has_roles` VALUES (1, 1, 'App\\User');
INSERT INTO `model_has_roles` VALUES (6, 1, 'App\\User');
INSERT INTO `model_has_roles` VALUES (8, 1, 'App\\User');
INSERT INTO `model_has_roles` VALUES (9, 1, 'App\\User');
INSERT INTO `model_has_roles` VALUES (10, 1, 'App\\User');

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `password_resets_email_index`(`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES (1, 'users_manage', 'web', '2018-04-04 14:20:50', '2018-04-04 14:20:50');
INSERT INTO `permissions` VALUES (2, 'Estandar', 'web', '2018-04-05 11:46:29', '2018-04-07 07:19:13');

-- ----------------------------
-- Table structure for places
-- ----------------------------
DROP TABLE IF EXISTS `places`;
CREATE TABLE `places`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `estado` varchar(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'A',
  `created_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `updated_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of places
-- ----------------------------
INSERT INTO `places` VALUES (1, 'UNIVERSIDAD DE GUAYAQUIL', 'A', '2018-08-21 16:19:39', '2018-08-21 16:19:39');
INSERT INTO `places` VALUES (2, 'CONSTITUCIONAL', 'A', '2018-08-20 02:09:08', '2018-08-20 02:09:08');
INSERT INTO `places` VALUES (3, 'CENTRO', 'A', NULL, NULL);
INSERT INTO `places` VALUES (4, 'PRUEBA', 'I', '2018-08-21 16:20:00', '2018-08-21 16:20:00');

-- ----------------------------
-- Table structure for role_has_permission
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permission`;
CREATE TABLE `role_has_permission`  (
  `permission_id` int(11) NULL DEFAULT NULL,
  `role_id` int(11) NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role_has_permission
-- ----------------------------
INSERT INTO `role_has_permission` VALUES (10, 1);
INSERT INTO `role_has_permission` VALUES (3, 1);
INSERT INTO `role_has_permission` VALUES (8, 1);
INSERT INTO `role_has_permission` VALUES (2, 1);
INSERT INTO `role_has_permission` VALUES (14, 1);
INSERT INTO `role_has_permission` VALUES (73, 1);
INSERT INTO `role_has_permission` VALUES (79, 6);
INSERT INTO `role_has_permission` VALUES (80, 6);
INSERT INTO `role_has_permission` VALUES (81, 1);
INSERT INTO `role_has_permission` VALUES (79, 8);
INSERT INTO `role_has_permission` VALUES (82, 8);
INSERT INTO `role_has_permission` VALUES (83, 9);
INSERT INTO `role_has_permission` VALUES (84, 9);
INSERT INTO `role_has_permission` VALUES (85, 9);
INSERT INTO `role_has_permission` VALUES (86, 9);
INSERT INTO `role_has_permission` VALUES (87, 10);
INSERT INTO `role_has_permission` VALUES (88, 10);
INSERT INTO `role_has_permission` VALUES (89, 10);
INSERT INTO `role_has_permission` VALUES (90, 10);

-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions`  (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `role_id`) USING BTREE,
  INDEX `role_has_permissions_role_id_foreign`(`role_id`) USING BTREE,
  CONSTRAINT `role_has_permissions_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `role_has_permissions_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role_has_permissions
-- ----------------------------
INSERT INTO `role_has_permissions` VALUES (2, 1);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `abv` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `max_student` int(3) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'administrator', 'web', '2018-04-04 14:20:50', '2018-04-04 14:20:50', 'ADM', NULL);
INSERT INTO `roles` VALUES (2, 'Recaudador', 'web', '2018-12-12 19:22:07', '2018-12-12 19:22:07', NULL, NULL);
INSERT INTO `roles` VALUES (3, 'Operador', 'web', '2018-12-12 19:22:20', '2018-12-12 19:22:20', NULL, NULL);
INSERT INTO `roles` VALUES (4, 'operador2', 'web', '2019-02-01 23:26:51', '2019-02-01 23:26:51', NULL, NULL);
INSERT INTO `roles` VALUES (5, 'Supervisor', 'web', '2019-02-16 01:12:39', '2019-02-16 01:12:39', NULL, NULL);
INSERT INTO `roles` VALUES (6, 'DigitadorPagos', 'web', '2019-04-22 09:23:52', '2019-04-22 09:23:52', NULL, NULL);
INSERT INTO `roles` VALUES (8, 'Digitadorviaticos', 'web', '2019-06-26 16:55:51', '2019-06-26 16:55:51', NULL, NULL);
INSERT INTO `roles` VALUES (9, 'informestics', 'web', '2019-06-27 11:18:18', '2019-06-27 11:18:18', NULL, NULL);
INSERT INTO `roles` VALUES (10, 'DigitadorComercial', 'web', '2019-10-22 15:16:45', '2019-10-22 15:16:45', NULL, NULL);

-- ----------------------------
-- Table structure for tablabase
-- ----------------------------
DROP TABLE IF EXISTS `tablabase`;
CREATE TABLE `tablabase`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tabla_id` int(11) NULL DEFAULT NULL,
  `descripcion` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `estado` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'A',
  `created_at` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tablabase
-- ----------------------------
INSERT INTO `tablabase` VALUES (3, 1, 'prueba', 'A', '2018-06-02 05:52:19');
INSERT INTO `tablabase` VALUES (4, 1, 'prueba', 'A', '2018-06-04 05:03:39');

-- ----------------------------
-- Table structure for tb_parametro
-- ----------------------------
DROP TABLE IF EXISTS `tb_parametro`;
CREATE TABLE `tb_parametro`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `parametro_id` int(11) NULL DEFAULT NULL,
  `estado` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'A',
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `nivel` int(4) NULL DEFAULT 4,
  `verificacion` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1279 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_parametro
-- ----------------------------
INSERT INTO `tb_parametro` VALUES (43, 'PROVINCIAS', NULL, 'A', NULL, NULL, 2, '0');
INSERT INTO `tb_parametro` VALUES (126, 'SIN NIVEL', NULL, 'A', '2018-07-29 12:44:43', NULL, 1, '0');
INSERT INTO `tb_parametro` VALUES (357, 'CIUDADES', 43, 'A', NULL, NULL, 3, '0');
INSERT INTO `tb_parametro` VALUES (1024, 'CIU-Guayaquil', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1025, 'CIU-Quito', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1026, 'CIU-Cuenca', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1027, 'CIU-SantoDomingo', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1028, 'CIU-Machala', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1029, 'CIU-Duran', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1030, 'CIU-Manta', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1031, 'CIU-Portoviejo', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1032, 'CIU-Loja', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1033, 'CIU-Ambato', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1034, 'CIU-Esmeraldas', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1035, 'CIU-Quevedo', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1036, 'CIU-Riobamba', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1037, 'CIU-Milagro', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1038, 'CIU-Ibarra', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1039, 'CIU-LaLibertad', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1040, 'CIU-Babahoyo', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1041, 'CIU-Sangolqui', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1042, 'CIU-Daule', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1043, 'CIU-Latacunga', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1044, 'CIU-Tulcan', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1045, 'CIU-Chone', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1046, 'CIU-Pasaje', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1047, 'CIU-SantaRosa', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1048, 'CIU-NuevaLoja', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1049, 'CIU-Huaquillas', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1050, 'CIU-ElCarmen', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1051, 'CIU-Montecristi', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1052, 'CIU-Samborondon', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1053, 'CIU-PuertoFranciscodeOrellana', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1054, 'CIU-Jipijapa', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1055, 'CIU-SantaElena', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1056, 'CIU-Otavalo', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1057, 'CIU-Cayambe', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1058, 'CIU-BuenaFe', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1059, 'CIU-Ventanas', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1060, 'CIU-VelascoIbarra(ElEmpalme)', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1061, 'CIU-LaTroncal', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1062, 'CIU-ElTriunfo', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1063, 'CIU-Salinas', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1064, 'CIU-GeneralVillamil(Playas)', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1065, 'CIU-Azogues', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1066, 'CIU-Puyo', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1067, 'CIU-Vinces', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1068, 'CIU-LaConcordia', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1069, 'CIU-RosaZarate(Quinindé)', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1070, 'CIU-Balzar', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1071, 'CIU-Naranjito', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1072, 'CIU-Naranjal', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1073, 'CIU-Guaranda', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1074, 'CIU-LaMana', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1075, 'CIU-Tena', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1076, 'CIU-SanLorenzo', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1077, 'CIU-Catamayo', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1078, 'CIU-ElGuabo', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1079, 'CIU-Pedernales', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1080, 'CIU-Atuntaqui', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1081, 'CIU-BahiadeCaraquez', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1082, 'CIU-PedroCarbo', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1083, 'CIU-Macas', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1084, 'CIU-Yaguachi', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1085, 'CIU-Calceta', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1086, 'CIU-Arenillas', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1087, 'CIU-Jaramijo', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1088, 'CIU-Valencia', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1089, 'CIU-Machachi', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1090, 'CIU-Shushufindi', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1091, 'CIU-Atacames', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1092, 'CIU-Pi&ntilde;as', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1093, 'CIU-SanGabriel', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1094, 'CIU-Gualaceo', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1095, 'CIU-LomasdeSargentillo', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1096, 'CIU-Ca&ntilde;ar', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1097, 'CIU-Cariamanga', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1098, 'CIU-Ba&ntilde;osdeAguaSanta', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1099, 'CIU-Montalvo', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1100, 'CIU-Macara', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1101, 'CIU-SanMiguel(Salcedo)', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1102, 'CIU-Zamora', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1103, 'CIU-PuertoAyora', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1104, 'CIU-LaJoyadelosSachas', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1105, 'CIU-Salitre', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1106, 'CIU-Tosagua', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1107, 'CIU-Pelileo', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1108, 'CIU-Pujili', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1109, 'CIU-Tabacundo', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1110, 'CIU-PuertoLopez', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1111, 'CIU-SanVicente', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1112, 'CIU-SantaAnadeVueltaLarga', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1113, 'CIU-Zaruma', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1114, 'CIU-Balao', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1115, 'CIU-Rocafuerte', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1116, 'CIU-Yantzaza', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1117, 'CIU-Cotacachi', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1118, 'CIU-SantaLucia', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1119, 'CIU-Cumanda', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1120, 'CIU-Palestina', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1121, 'CIU-AlfredoBaquerizoMoreno(Jujan)', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1122, 'CIU-NarcisadeJesus(Nobol)', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1123, 'CIU-Mocache', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1124, 'CIU-Puebloviejo', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1125, 'CIU-Portovelo', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1126, 'CIU-Sucua', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1127, 'CIU-Guano', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1128, 'CIU-Pillaro', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1129, 'CIU-SimonBolivar', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1130, 'CIU-Gualaquiza', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1131, 'CIU-Paute', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1132, 'CIU-Saquisili', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1133, 'CIU-CoronelMarcelinoMaridue&ntilde;a', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1134, 'CIU-Pajan', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1135, 'CIU-SanMiguel', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1136, 'CIU-PuertoBaquerizoMoreno', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1137, 'CIU-Catacocha', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1138, 'CIU-Palenque', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1139, 'CIU-Alausi', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1140, 'CIU-Caluma', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1141, 'CIU-Catarama', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1142, 'CIU-FlavioAlfaro', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1143, 'CIU-Colimes', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1144, 'CIU-Echeandia', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1145, 'CIU-Jama', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1146, 'CIU-GeneralAntonioElizalde(Bucay)', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1147, 'CIU-IsidroAyora', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1148, 'CIU-Muisne', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1149, 'CIU-SantaIsabel', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1150, 'CIU-PedroVicenteMaldonado', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1151, 'CIU-Biblian', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1152, 'CIU-Archidona', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1153, 'CIU-Junin', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1154, 'CIU-Baba', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1155, 'CIU-Valdez(Limones)', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1156, 'CIU-Pimampiro', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1157, 'CIU-CamiloPonceEnriquez', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1158, 'CIU-SanMigueldeLosBancos', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1159, 'CIU-ElTambo', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1160, 'CIU-Quinsaloma', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1161, 'CIU-Elangel', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1162, 'CIU-Alamor', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1163, 'CIU-Chambo', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1164, 'CIU-SanJosédeChimbo', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1165, 'CIU-Celica', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1166, 'CIU-Chordeleg', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1167, 'CIU-Balsas', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1168, 'CIU-Saraguro', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1169, 'CIU-ElChaco', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1170, 'CIU-Giron', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1171, 'CIU-Huaca', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1172, 'CIU-Pichincha', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1173, 'CIU-Chunchi', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1174, 'CIU-Pallatanga', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1175, 'CIU-Marcabeli', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1176, 'CIU-Sigsig', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1177, 'CIU-GeneralLeonidasPlazaGutiérrez(Limon)', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1178, 'CIU-Urcuqui', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1179, 'CIU-Loreto', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1180, 'CIU-Rioverde', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1181, 'CIU-Zumba', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1182, 'CIU-Palora', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1183, 'CIU-Mira', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1184, 'CIU-ElPangui', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1185, 'CIU-PuertoQuito', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1186, 'CIU-Bolivar', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1187, 'CIU-Sucre', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1188, 'CIU-Chillanes', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1189, 'CIU-Quero', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1190, 'CIU-Guamote', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1191, 'CIU-Cevallos', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1192, 'CIU-Zapotillo', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1193, 'CIU-VillaLaUnion(Cajabamba)', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1194, 'CIU-SantiagodeMéndez', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1195, 'CIU-Zumbi', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1196, 'CIU-PuertoElCarmendePutumayo', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1197, 'CIU-Patate', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1198, 'CIU-Olmedo', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1199, 'CIU-PuertoVillamil', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1200, 'CIU-ElDoradodeCascales', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1201, 'CIU-Lumbaqui', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1202, 'CIU-Palanda', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1203, 'CIU-Sigchos', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1204, 'CIU-Pindal', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1205, 'CIU-Guayzimi', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1206, 'CIU-Baeza', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1207, 'CIU-ElCorazon', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1208, 'CIU-Paccha', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1209, 'CIU-Amaluza', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1210, 'CIU-LasNaves', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1211, 'CIU-Logro&ntilde;o', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1212, 'CIU-SanFernando', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1213, 'CIU-Gonzanama', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1214, 'CIU-SanJuanBosco', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1215, 'CIU-28deMayo(SanJosédeYacuambi)', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1216, 'CIU-SantaClara', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1217, 'CIU-Arajuno', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1218, 'CIU-Tarapoa', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1219, 'CIU-Tisaleo', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1220, 'CIU-Suscal', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1221, 'CIU-Nabon', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1222, 'CIU-NuevoRocafuerte', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1223, 'CIU-Mocha', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1224, 'CIU-LaVictoria', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1225, 'CIU-Guachapala', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1226, 'CIU-Santiago', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1227, 'CIU-Chaguarpamba', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1228, 'CIU-Penipe', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1229, 'CIU-Taisha', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1230, 'CIU-Chilla', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1231, 'CIU-Paquisha', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1232, 'CIU-CarlosJulioArosemenaTola', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1233, 'CIU-Sozoranga', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1234, 'CIU-Pucara', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1235, 'CIU-Huamboya', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1236, 'CIU-Quilanga', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1237, 'CIU-SanFelipedeO&ntilde;a', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1238, 'CIU-SevilladeOro', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1239, 'CIU-Mera', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1240, 'CIU-PabloSexto', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1241, 'CIU-Olmedo', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1242, 'CIU-Déleg', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1243, 'CIU-LaBonita', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1244, 'CIU-ElPan', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1245, 'CIU-Tiputini', 357, 'A', NULL, NULL, 4, '0');
INSERT INTO `tb_parametro` VALUES (1258, 'AREA', NULL, 'A', '2018-12-04 23:53:45', '2018-12-24 16:19:11', 2, '0');
INSERT INTO `tb_parametro` VALUES (1259, 'RECAUDADOR', 1258, 'A', '2018-12-04 23:54:13', '2018-12-05 00:07:19', 3, '0');
INSERT INTO `tb_parametro` VALUES (1260, 'OPERADOR', 1258, 'A', '2018-12-04 23:54:29', '2018-12-05 00:07:07', 3, '0');
INSERT INTO `tb_parametro` VALUES (1261, 'DEPARTAMENTOS', NULL, 'A', '2018-12-05 00:06:23', '2018-12-05 00:06:23', 2, '0');
INSERT INTO `tb_parametro` VALUES (1262, 'OPERACIONES', 1261, 'A', '2018-12-05 00:06:41', '2018-12-05 00:06:41', 3, '0');
INSERT INTO `tb_parametro` VALUES (1263, 'RECAUDACIONES', 1261, 'A', '2018-12-05 00:06:54', '2018-12-05 00:06:54', 3, '0');
INSERT INTO `tb_parametro` VALUES (1264, 'TIPO_PAGO', NULL, 'A', '2018-12-05 04:32:31', '2018-12-05 04:32:31', 2, '0');
INSERT INTO `tb_parametro` VALUES (1265, 'COMPROBANTE (BAUCHER)', 1264, 'A', '2018-12-05 04:32:51', '2019-02-02 14:20:55', 3, '0');
INSERT INTO `tb_parametro` VALUES (1266, 'CHEQUE', 1264, 'I', '2018-12-05 04:33:01', '2019-02-02 14:20:09', 3, '0');
INSERT INTO `tb_parametro` VALUES (1267, 'EFECTIVO', 1264, 'A', '2018-12-05 04:33:13', '2018-12-05 04:33:13', 3, '0');
INSERT INTO `tb_parametro` VALUES (1268, 'OPERADOR2', 1258, 'A', '2019-02-02 08:45:28', '2019-02-02 08:45:28', 3, '0');
INSERT INTO `tb_parametro` VALUES (1269, 'ADMINISTRADOR', 1258, 'A', '2019-02-02 14:13:29', '2019-02-02 14:13:29', 3, '0');
INSERT INTO `tb_parametro` VALUES (1270, 'TABLA', NULL, 'A', '2019-10-07 10:22:40', '2019-10-07 10:22:40', 2, '0');
INSERT INTO `tb_parametro` VALUES (1271, 'TABLA_LOTES', NULL, 'A', '2019-10-22 14:53:27', '2019-10-25 08:43:31', 2, '0');
INSERT INTO `tb_parametro` VALUES (1272, 'FACTURACION', 1271, 'A', '2019-10-22 14:54:06', '2019-10-22 14:55:17', 3, '0');
INSERT INTO `tb_parametro` VALUES (1273, 'RECAUDACION', 1271, 'A', '2019-10-22 14:54:22', '2019-10-22 14:55:08', 3, '0');
INSERT INTO `tb_parametro` VALUES (1275, 'TIPO_REPORTE', NULL, 'A', '2019-10-25 08:45:28', '2019-10-25 08:45:28', 2, '0');
INSERT INTO `tb_parametro` VALUES (1276, 'FACTURA', 1275, 'A', '2019-10-25 08:45:49', '2019-10-25 08:45:49', 3, '0');
INSERT INTO `tb_parametro` VALUES (1277, 'NOTAS DE CRÉDITO', 1275, 'A', '2019-10-25 08:46:04', '2019-10-25 08:46:31', 3, '0');
INSERT INTO `tb_parametro` VALUES (1278, 'NOTAS DE DÉBITO', 1275, 'A', '2019-10-25 08:46:19', '2019-10-25 08:46:19', 3, '0');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `persona_id` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `last_login` datetime(0) NULL DEFAULT NULL,
  `estado` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `session_id` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `abv` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `lugarasignado_id` int(11) NULL DEFAULT NULL,
  `nombreCompleto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'admin', 'admin@admin.com', '$2y$10$42HlUwqhBfT.SAbH2dY3.e9VC9Ple2liXvlqppc.uuID8OsVKOXSq', 'ANKLuvutRLpZTf7TxsZNcTLD3Qexf4V58YT3QeDbus8VqbcTTmndBUbkzqQU', '2018-04-04 14:20:51', '2019-10-25 15:20:18', '0926339731', '2019-10-25 15:20:18', 'A', 'JPE43WuVVf0ljbi3Y3sbiEpD89HSWql3g4iTh8YI', '202', NULL, 'CN=Anthony W. Espinoza Fajardo,CARGO=adm');

SET FOREIGN_KEY_CHECKS = 1;

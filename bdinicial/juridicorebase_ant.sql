/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50719
Source Host           : localhost:3306
Source Database       : juridicorebase_ant

Target Server Type    : MYSQL
Target Server Version : 50719
File Encoding         : 65001

Date: 2019-03-08 18:03:27
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for empleados
-- ----------------------------
DROP TABLE IF EXISTS `empleados`;
CREATE TABLE `empleados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identificacion` varchar(15) DEFAULT NULL,
  `nombres` varchar(25) DEFAULT NULL,
  `apellidos` varchar(25) DEFAULT NULL,
  `ciudad_id` int(10) DEFAULT NULL,
  `cargo_id` int(10) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `celular` varchar(10) DEFAULT NULL,
  `convencional` varchar(10) DEFAULT NULL,
  `ing_empresa` date DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `usuario_ing` varchar(25) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `usuario_mod` varchar(255) DEFAULT NULL,
  `asigna` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of empleados
-- ----------------------------
INSERT INTO `empleados` VALUES ('1', '0926339731', 'tona', 'espinoza', '1024', '1269', 'DURAN CDLA LOS HELECHOS', '0982364756', '2801544', '2018-12-01', 'anthony.espinozaf@gmail.com', 'A', '1', '2019-02-02 14:14:00', '2019-02-02 14:14:00', '1', '1');
INSERT INTO `empleados` VALUES ('2', '0988888888', 'andrea', 'lozano', '1024', '1260', 'LOLA', '0987252436', '28216725', '2018-11-05', 'andrealozano@gmail.com', 'A', '1', '2019-02-02 14:03:50', '2019-02-02 14:03:50', '1', '1');
INSERT INTO `empleados` VALUES ('3', '0922606223', 're', 'ca', '1024', '1259', 'XX', '0982726262', null, '2018-12-19', 'a@gh.com', 'A', '1', '2019-02-02 14:03:50', '2019-02-02 14:03:50', '1', '0');
INSERT INTO `empleados` VALUES ('4', '0922334455', 'Operador 2', 'Operador 2', '1024', '1268', 'PRUEBA', '0922334455', '0922334455', '2019-01-28', 'a@a.com', 'A', '1', '2019-02-02 08:46:42', '2019-02-02 08:46:42', '1', '0');
INSERT INTO `empleados` VALUES ('5', '0922222222', 'supervisor', 'supervisor', '1024', '1270', 'ASD', '0982625252', '2801544', '2019-01-29', 'asd@asd.com', 'A', '1', '2019-02-16 01:30:36', '2019-02-16 01:30:36', '1', '0');

-- ----------------------------
-- Table structure for menus
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` int(10) unsigned NOT NULL DEFAULT '0',
  `order` smallint(6) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `menus_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of menus
-- ----------------------------
INSERT INTO `menus` VALUES ('2', 'Usuarios', '/admin/users', '10', '1', '1', null, null);
INSERT INTO `menus` VALUES ('3', 'Roles', '/admin/roles', '10', '0', '1', null, null);
INSERT INTO `menus` VALUES ('8', 'Menu', 'admin/MenuCreate', '10', '2', '1', null, null);
INSERT INTO `menus` VALUES ('10', 'Administrador', '#', '0', '1', '1', null, null);
INSERT INTO `menus` VALUES ('14', 'Parametros', 'admin/ParametroIndex', '10', '4', '1', '2018-04-10 05:48:29', '2018-04-10 05:49:04');
INSERT INTO `menus` VALUES ('40', 'Sin Nivel', 'Sin Nivel', '0', '0', '1', null, null);
INSERT INTO `menus` VALUES ('73', 'Directorio', 'uath/DirectorioIndex', '10', '5', '1', '2018-12-05 01:53:42', '2018-12-05 01:53:42');
INSERT INTO `menus` VALUES ('74', 'Gestión', 'GESTION', '0', '2', '1', '2018-12-05 03:10:43', '2018-12-05 03:11:43');
INSERT INTO `menus` VALUES ('75', 'Clientes', 'clientes/gestionIndex', '74', '1', '1', '2018-12-05 03:12:42', '2018-12-05 03:12:42');
INSERT INTO `menus` VALUES ('76', 'Historial de LLamadas', 'clientes/historialCall', '74', '0', '1', '2019-02-16 01:10:17', '2019-02-16 12:02:00');
INSERT INTO `menus` VALUES ('77', 'ASIGNACION LLAMADAS', 'asignacion/llamadas', '74', '0', '1', '2019-03-02 17:35:59', '2019-03-02 17:35:59');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('1', '2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('2', '2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO `migrations` VALUES ('3', '2017_07_12_145959_create_permission_tables', '1');
INSERT INTO `migrations` VALUES ('4', '2018_04_05_003121_create_menus_table', '2');
INSERT INTO `migrations` VALUES ('5', '2018_05_31_144003_create_notifications_table', '3');

-- ----------------------------
-- Table structure for model_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `model_id` int(10) unsigned NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of model_has_permissions
-- ----------------------------

-- ----------------------------
-- Table structure for model_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles` (
  `role_id` int(10) unsigned NOT NULL,
  `model_id` int(10) unsigned NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of model_has_roles
-- ----------------------------
INSERT INTO `model_has_roles` VALUES ('1', '1', 'App\\User');
INSERT INTO `model_has_roles` VALUES ('2', '21', 'App\\User');
INSERT INTO `model_has_roles` VALUES ('3', '36', 'App\\User');
INSERT INTO `model_has_roles` VALUES ('4', '37', 'App\\User');
INSERT INTO `model_has_roles` VALUES ('5', '38', 'App\\User');

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES ('1', 'users_manage', 'web', '2018-04-04 14:20:50', '2018-04-04 14:20:50');
INSERT INTO `permissions` VALUES ('2', 'Estandar', 'web', '2018-04-05 11:46:29', '2018-04-07 07:19:13');

-- ----------------------------
-- Table structure for places
-- ----------------------------
DROP TABLE IF EXISTS `places`;
CREATE TABLE `places` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) DEFAULT NULL,
  `estado` varchar(2) DEFAULT 'A',
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of places
-- ----------------------------
INSERT INTO `places` VALUES ('1', 'UNIVERSIDAD DE GUAYAQUIL', 'A', '2018-08-21 16:19:39', '2018-08-21 16:19:39');
INSERT INTO `places` VALUES ('2', 'CONSTITUCIONAL', 'A', '2018-08-20 02:09:08', '2018-08-20 02:09:08');
INSERT INTO `places` VALUES ('3', 'CENTRO', 'A', null, null);
INSERT INTO `places` VALUES ('4', 'PRUEBA', 'I', '2018-08-21 16:20:00', '2018-08-21 16:20:00');

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `abv` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `max_student` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', 'administrator', 'web', '2018-04-04 14:20:50', '2018-04-04 14:20:50', 'ADM', null);
INSERT INTO `roles` VALUES ('2', 'Recaudador', 'web', '2018-12-12 19:22:07', '2018-12-12 19:22:07', null, null);
INSERT INTO `roles` VALUES ('3', 'Operador', 'web', '2018-12-12 19:22:20', '2018-12-12 19:22:20', null, null);
INSERT INTO `roles` VALUES ('4', 'operador2', 'web', '2019-02-01 23:26:51', '2019-02-01 23:26:51', null, null);
INSERT INTO `roles` VALUES ('5', 'Supervisor', 'web', '2019-02-16 01:12:39', '2019-02-16 01:12:39', null, null);

-- ----------------------------
-- Table structure for role_has_permission
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permission`;
CREATE TABLE `role_has_permission` (
  `permission_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of role_has_permission
-- ----------------------------
INSERT INTO `role_has_permission` VALUES ('10', '1');
INSERT INTO `role_has_permission` VALUES ('3', '1');
INSERT INTO `role_has_permission` VALUES ('8', '1');
INSERT INTO `role_has_permission` VALUES ('2', '1');
INSERT INTO `role_has_permission` VALUES ('14', '1');
INSERT INTO `role_has_permission` VALUES ('73', '1');
INSERT INTO `role_has_permission` VALUES ('74', '2');
INSERT INTO `role_has_permission` VALUES ('75', '2');
INSERT INTO `role_has_permission` VALUES ('74', '3');
INSERT INTO `role_has_permission` VALUES ('75', '3');
INSERT INTO `role_has_permission` VALUES ('74', '4');
INSERT INTO `role_has_permission` VALUES ('75', '4');
INSERT INTO `role_has_permission` VALUES ('74', '5');
INSERT INTO `role_has_permission` VALUES ('75', '5');
INSERT INTO `role_has_permission` VALUES ('76', '5');
INSERT INTO `role_has_permission` VALUES ('77', '5');

-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of role_has_permissions
-- ----------------------------
INSERT INTO `role_has_permissions` VALUES ('2', '1');

-- ----------------------------
-- Table structure for tablabase
-- ----------------------------
DROP TABLE IF EXISTS `tablabase`;
CREATE TABLE `tablabase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tabla_id` int(11) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `estado` varchar(1) DEFAULT 'A',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tablabase
-- ----------------------------
INSERT INTO `tablabase` VALUES ('3', '1', 'prueba', 'A', '2018-06-02 05:52:19');
INSERT INTO `tablabase` VALUES ('4', '1', 'prueba', 'A', '2018-06-04 05:03:39');

-- ----------------------------
-- Table structure for tb_parametro
-- ----------------------------
DROP TABLE IF EXISTS `tb_parametro`;
CREATE TABLE `tb_parametro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) DEFAULT NULL,
  `parametro_id` int(11) DEFAULT NULL,
  `estado` char(1) DEFAULT 'A',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `nivel` int(4) DEFAULT '4',
  `verificacion` varchar(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1271 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of tb_parametro
-- ----------------------------
INSERT INTO `tb_parametro` VALUES ('43', 'PROVINCIAS', null, 'A', null, null, '2', '0');
INSERT INTO `tb_parametro` VALUES ('126', 'SIN NIVEL', null, 'A', '2018-07-29 12:44:43', null, '1', '0');
INSERT INTO `tb_parametro` VALUES ('357', 'CIUDADES', '43', 'A', null, null, '3', '0');
INSERT INTO `tb_parametro` VALUES ('1024', 'CIU-Guayaquil', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1025', 'CIU-Quito', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1026', 'CIU-Cuenca', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1027', 'CIU-SantoDomingo', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1028', 'CIU-Machala', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1029', 'CIU-Duran', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1030', 'CIU-Manta', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1031', 'CIU-Portoviejo', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1032', 'CIU-Loja', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1033', 'CIU-Ambato', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1034', 'CIU-Esmeraldas', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1035', 'CIU-Quevedo', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1036', 'CIU-Riobamba', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1037', 'CIU-Milagro', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1038', 'CIU-Ibarra', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1039', 'CIU-LaLibertad', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1040', 'CIU-Babahoyo', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1041', 'CIU-Sangolqui', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1042', 'CIU-Daule', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1043', 'CIU-Latacunga', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1044', 'CIU-Tulcan', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1045', 'CIU-Chone', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1046', 'CIU-Pasaje', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1047', 'CIU-SantaRosa', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1048', 'CIU-NuevaLoja', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1049', 'CIU-Huaquillas', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1050', 'CIU-ElCarmen', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1051', 'CIU-Montecristi', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1052', 'CIU-Samborondon', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1053', 'CIU-PuertoFranciscodeOrellana', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1054', 'CIU-Jipijapa', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1055', 'CIU-SantaElena', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1056', 'CIU-Otavalo', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1057', 'CIU-Cayambe', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1058', 'CIU-BuenaFe', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1059', 'CIU-Ventanas', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1060', 'CIU-VelascoIbarra(ElEmpalme)', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1061', 'CIU-LaTroncal', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1062', 'CIU-ElTriunfo', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1063', 'CIU-Salinas', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1064', 'CIU-GeneralVillamil(Playas)', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1065', 'CIU-Azogues', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1066', 'CIU-Puyo', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1067', 'CIU-Vinces', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1068', 'CIU-LaConcordia', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1069', 'CIU-RosaZarate(Quinindé)', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1070', 'CIU-Balzar', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1071', 'CIU-Naranjito', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1072', 'CIU-Naranjal', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1073', 'CIU-Guaranda', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1074', 'CIU-LaMana', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1075', 'CIU-Tena', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1076', 'CIU-SanLorenzo', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1077', 'CIU-Catamayo', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1078', 'CIU-ElGuabo', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1079', 'CIU-Pedernales', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1080', 'CIU-Atuntaqui', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1081', 'CIU-BahiadeCaraquez', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1082', 'CIU-PedroCarbo', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1083', 'CIU-Macas', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1084', 'CIU-Yaguachi', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1085', 'CIU-Calceta', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1086', 'CIU-Arenillas', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1087', 'CIU-Jaramijo', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1088', 'CIU-Valencia', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1089', 'CIU-Machachi', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1090', 'CIU-Shushufindi', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1091', 'CIU-Atacames', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1092', 'CIU-Pi&ntilde;as', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1093', 'CIU-SanGabriel', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1094', 'CIU-Gualaceo', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1095', 'CIU-LomasdeSargentillo', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1096', 'CIU-Ca&ntilde;ar', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1097', 'CIU-Cariamanga', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1098', 'CIU-Ba&ntilde;osdeAguaSanta', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1099', 'CIU-Montalvo', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1100', 'CIU-Macara', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1101', 'CIU-SanMiguel(Salcedo)', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1102', 'CIU-Zamora', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1103', 'CIU-PuertoAyora', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1104', 'CIU-LaJoyadelosSachas', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1105', 'CIU-Salitre', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1106', 'CIU-Tosagua', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1107', 'CIU-Pelileo', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1108', 'CIU-Pujili', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1109', 'CIU-Tabacundo', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1110', 'CIU-PuertoLopez', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1111', 'CIU-SanVicente', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1112', 'CIU-SantaAnadeVueltaLarga', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1113', 'CIU-Zaruma', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1114', 'CIU-Balao', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1115', 'CIU-Rocafuerte', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1116', 'CIU-Yantzaza', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1117', 'CIU-Cotacachi', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1118', 'CIU-SantaLucia', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1119', 'CIU-Cumanda', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1120', 'CIU-Palestina', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1121', 'CIU-AlfredoBaquerizoMoreno(Jujan)', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1122', 'CIU-NarcisadeJesus(Nobol)', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1123', 'CIU-Mocache', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1124', 'CIU-Puebloviejo', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1125', 'CIU-Portovelo', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1126', 'CIU-Sucua', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1127', 'CIU-Guano', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1128', 'CIU-Pillaro', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1129', 'CIU-SimonBolivar', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1130', 'CIU-Gualaquiza', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1131', 'CIU-Paute', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1132', 'CIU-Saquisili', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1133', 'CIU-CoronelMarcelinoMaridue&ntilde;a', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1134', 'CIU-Pajan', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1135', 'CIU-SanMiguel', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1136', 'CIU-PuertoBaquerizoMoreno', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1137', 'CIU-Catacocha', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1138', 'CIU-Palenque', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1139', 'CIU-Alausi', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1140', 'CIU-Caluma', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1141', 'CIU-Catarama', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1142', 'CIU-FlavioAlfaro', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1143', 'CIU-Colimes', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1144', 'CIU-Echeandia', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1145', 'CIU-Jama', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1146', 'CIU-GeneralAntonioElizalde(Bucay)', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1147', 'CIU-IsidroAyora', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1148', 'CIU-Muisne', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1149', 'CIU-SantaIsabel', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1150', 'CIU-PedroVicenteMaldonado', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1151', 'CIU-Biblian', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1152', 'CIU-Archidona', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1153', 'CIU-Junin', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1154', 'CIU-Baba', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1155', 'CIU-Valdez(Limones)', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1156', 'CIU-Pimampiro', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1157', 'CIU-CamiloPonceEnriquez', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1158', 'CIU-SanMigueldeLosBancos', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1159', 'CIU-ElTambo', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1160', 'CIU-Quinsaloma', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1161', 'CIU-Elangel', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1162', 'CIU-Alamor', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1163', 'CIU-Chambo', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1164', 'CIU-SanJosédeChimbo', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1165', 'CIU-Celica', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1166', 'CIU-Chordeleg', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1167', 'CIU-Balsas', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1168', 'CIU-Saraguro', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1169', 'CIU-ElChaco', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1170', 'CIU-Giron', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1171', 'CIU-Huaca', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1172', 'CIU-Pichincha', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1173', 'CIU-Chunchi', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1174', 'CIU-Pallatanga', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1175', 'CIU-Marcabeli', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1176', 'CIU-Sigsig', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1177', 'CIU-GeneralLeonidasPlazaGutiérrez(Limon)', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1178', 'CIU-Urcuqui', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1179', 'CIU-Loreto', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1180', 'CIU-Rioverde', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1181', 'CIU-Zumba', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1182', 'CIU-Palora', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1183', 'CIU-Mira', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1184', 'CIU-ElPangui', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1185', 'CIU-PuertoQuito', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1186', 'CIU-Bolivar', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1187', 'CIU-Sucre', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1188', 'CIU-Chillanes', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1189', 'CIU-Quero', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1190', 'CIU-Guamote', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1191', 'CIU-Cevallos', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1192', 'CIU-Zapotillo', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1193', 'CIU-VillaLaUnion(Cajabamba)', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1194', 'CIU-SantiagodeMéndez', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1195', 'CIU-Zumbi', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1196', 'CIU-PuertoElCarmendePutumayo', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1197', 'CIU-Patate', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1198', 'CIU-Olmedo', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1199', 'CIU-PuertoVillamil', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1200', 'CIU-ElDoradodeCascales', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1201', 'CIU-Lumbaqui', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1202', 'CIU-Palanda', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1203', 'CIU-Sigchos', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1204', 'CIU-Pindal', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1205', 'CIU-Guayzimi', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1206', 'CIU-Baeza', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1207', 'CIU-ElCorazon', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1208', 'CIU-Paccha', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1209', 'CIU-Amaluza', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1210', 'CIU-LasNaves', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1211', 'CIU-Logro&ntilde;o', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1212', 'CIU-SanFernando', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1213', 'CIU-Gonzanama', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1214', 'CIU-SanJuanBosco', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1215', 'CIU-28deMayo(SanJosédeYacuambi)', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1216', 'CIU-SantaClara', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1217', 'CIU-Arajuno', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1218', 'CIU-Tarapoa', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1219', 'CIU-Tisaleo', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1220', 'CIU-Suscal', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1221', 'CIU-Nabon', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1222', 'CIU-NuevoRocafuerte', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1223', 'CIU-Mocha', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1224', 'CIU-LaVictoria', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1225', 'CIU-Guachapala', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1226', 'CIU-Santiago', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1227', 'CIU-Chaguarpamba', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1228', 'CIU-Penipe', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1229', 'CIU-Taisha', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1230', 'CIU-Chilla', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1231', 'CIU-Paquisha', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1232', 'CIU-CarlosJulioArosemenaTola', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1233', 'CIU-Sozoranga', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1234', 'CIU-Pucara', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1235', 'CIU-Huamboya', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1236', 'CIU-Quilanga', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1237', 'CIU-SanFelipedeO&ntilde;a', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1238', 'CIU-SevilladeOro', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1239', 'CIU-Mera', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1240', 'CIU-PabloSexto', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1241', 'CIU-Olmedo', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1242', 'CIU-Déleg', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1243', 'CIU-LaBonita', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1244', 'CIU-ElPan', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1245', 'CIU-Tiputini', '357', 'A', null, null, '4', '0');
INSERT INTO `tb_parametro` VALUES ('1258', 'AREA', null, 'A', '2018-12-04 23:53:45', '2018-12-24 16:19:11', '2', '0');
INSERT INTO `tb_parametro` VALUES ('1259', 'RECAUDADOR', '1258', 'A', '2018-12-04 23:54:13', '2018-12-05 00:07:19', '3', '0');
INSERT INTO `tb_parametro` VALUES ('1260', 'OPERADOR', '1258', 'A', '2018-12-04 23:54:29', '2018-12-05 00:07:07', '3', '0');
INSERT INTO `tb_parametro` VALUES ('1261', 'DEPARTAMENTOS', null, 'A', '2018-12-05 00:06:23', '2018-12-05 00:06:23', '2', '0');
INSERT INTO `tb_parametro` VALUES ('1262', 'OPERACIONES', '1261', 'A', '2018-12-05 00:06:41', '2018-12-05 00:06:41', '3', '0');
INSERT INTO `tb_parametro` VALUES ('1263', 'RECAUDACIONES', '1261', 'A', '2018-12-05 00:06:54', '2018-12-05 00:06:54', '3', '0');
INSERT INTO `tb_parametro` VALUES ('1264', 'TIPO_PAGO', null, 'A', '2018-12-05 04:32:31', '2018-12-05 04:32:31', '2', '0');
INSERT INTO `tb_parametro` VALUES ('1265', 'COMPROBANTE (BAUCHER)', '1264', 'A', '2018-12-05 04:32:51', '2019-02-02 14:20:55', '3', '0');
INSERT INTO `tb_parametro` VALUES ('1266', 'CHEQUE', '1264', 'I', '2018-12-05 04:33:01', '2019-02-02 14:20:09', '3', '0');
INSERT INTO `tb_parametro` VALUES ('1267', 'EFECTIVO', '1264', 'A', '2018-12-05 04:33:13', '2018-12-05 04:33:13', '3', '0');
INSERT INTO `tb_parametro` VALUES ('1268', 'OPERADOR2', '1258', 'A', '2019-02-02 08:45:28', '2019-02-02 08:45:28', '3', '0');
INSERT INTO `tb_parametro` VALUES ('1269', 'ADMINISTRADOR', '1258', 'A', '2019-02-02 14:13:29', '2019-02-02 14:13:29', '3', '0');
INSERT INTO `tb_parametro` VALUES ('1270', 'SUPERVISOR', '1258', 'A', '2019-02-16 01:11:05', '2019-02-16 01:11:05', '3', '0');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `persona_id` varchar(13) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `estado` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `session_id` longtext COLLATE utf8mb4_unicode_ci,
  `abv` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lugarasignado_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'admin', 'admin@admin.com', '$2y$10$42HlUwqhBfT.SAbH2dY3.e9VC9Ple2liXvlqppc.uuID8OsVKOXSq', 'pRXcs1SxfeJfM5N1o2mFS0VVfGPQAlsN6ixyv96ASSEg1bvIqGeaZ4RzTgQb', '2018-04-04 14:20:51', '2019-03-07 15:37:14', '0926339731', '2019-03-07 15:37:14', 'A', '6MXjZJdwT3MEv8w4ntF4sP7FJr0FwYew8fU0d0Df', '202', null);
INSERT INTO `users` VALUES ('21', 'recaudador', 'ajr@gmail.com', '$2y$10$42HlUwqhBfT.SAbH2dY3.e9VC9Ple2liXvlqppc.uuID8OsVKOXSq', 'xPJjoo9B0g0JdaXttQWlhEjxONJD6ypPXUqaz2ysG8AHYDUdelH3CNtgFwHO', '2018-07-23 02:06:11', '2019-02-09 18:52:34', '0922606223', '2019-02-09 18:52:34', 'A', 'wxqzjg0TkNS9yotS9jAG9qsfpuuclz7lOsU2Ah8P', 'SEC', null);
INSERT INTO `users` VALUES ('36', 'operador1', 'anthony.espinozaf@ug.edu.ec', '$2y$10$42HlUwqhBfT.SAbH2dY3.e9VC9Ple2liXvlqppc.uuID8OsVKOXSq', 'x5A6Wj4WP4wus3DTXlJdShEWFbeYgEXnUUiTuE3WsBdgQhMtKYsk5FSpaHuI', '2018-08-25 14:16:46', '2019-03-08 14:28:58', '0988888888', '2019-03-08 14:28:58', 'A', 'uVUWIuBFbGup69ZUGAvVTuOua8yn8yrEGAzwFJXj', null, null);
INSERT INTO `users` VALUES ('37', 'operador2', 'a@a.com', '$2y$10$42HlUwqhBfT.SAbH2dY3.e9VC9Ple2liXvlqppc.uuID8OsVKOXSq', 'XZidplOovAzcUzX3NsywdZDV1FUHTl8RcQ3JfpjwLjKAdAEGHwOXAShUiddg', '2019-02-01 23:27:48', '2019-03-08 14:29:13', '0922334455', '2019-03-08 14:29:13', 'A', 'Rlm9xcI2k005HQY4GOB6waXZsHqdy3Q4tPbHiMPb', null, null);
INSERT INTO `users` VALUES ('38', 'Supervisor', 'supervisor@asd.com', '$2y$10$42HlUwqhBfT.SAbH2dY3.e9VC9Ple2liXvlqppc.uuID8OsVKOXSq', 'QFk7LddYWRQCMigolXlrhdzyQt18HJqXfi6cdFrSWMpggYWRTqNvVrlSOFHb', '2019-02-16 01:26:36', '2019-03-07 17:47:35', '0926339731', '2019-03-07 17:47:35', 'A', 'uHUj9tfJdN6ebK55YlwYyLSm1g4oGxeVHQKAlaTu', null, null);

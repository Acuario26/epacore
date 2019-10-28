/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50719
Source Host           : localhost:3306
Source Database       : solicitudescjnew_ant

Target Server Type    : MYSQL
Target Server Version : 50719
File Encoding         : 65001

Date: 2019-03-08 18:03:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for archivos
-- ----------------------------
DROP TABLE IF EXISTS `archivos`;
CREATE TABLE `archivos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `archivo_caso` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of archivos
-- ----------------------------

-- ----------------------------
-- Table structure for asistencias
-- ----------------------------
DROP TABLE IF EXISTS `asistencias`;
CREATE TABLE `asistencias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `docente_id` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `estado` varchar(1) DEFAULT 'I',
  `semana` varchar(8) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `horas` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_fin` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of asistencias
-- ----------------------------
INSERT INTO `asistencias` VALUES ('1', '36', '25', '2018-08-01', 'A', 'Semana 2', 'hice algo', '2', '2018-08-25 14:25:55', '2018-08-25 14:29:05', '09:00:00', '11:00:00');
INSERT INTO `asistencias` VALUES ('2', '36', '25', '2018-08-03', 'A', 'Semana 2', 'e', '4', '2018-08-25 14:30:35', '2018-08-25 14:33:07', '09:00:00', '13:00:00');
INSERT INTO `asistencias` VALUES ('3', '36', '25', '2018-08-05', 'A', 'Semana 2', 'rf', '6', '2018-08-25 14:30:57', '2018-08-25 14:33:05', '11:00:00', '17:00:00');
INSERT INTO `asistencias` VALUES ('4', '36', '25', '2018-08-06', 'A', 'Semana 2', 'd', '2', '2018-08-25 14:31:25', '2018-08-25 14:33:12', '12:00:00', '14:00:00');
INSERT INTO `asistencias` VALUES ('5', '36', '25', '2018-08-07', 'A', 'Semana 2', 'gg', '6', '2018-08-25 14:31:41', '2018-08-25 14:33:09', '12:00:00', '18:00:00');

-- ----------------------------
-- Table structure for asistencias_monitor
-- ----------------------------
DROP TABLE IF EXISTS `asistencias_monitor`;
CREATE TABLE `asistencias_monitor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `monitor_id` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `estado` varchar(1) COLLATE utf8_unicode_ci DEFAULT 'I',
  `semana` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `horas` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_fin` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of asistencias_monitor
-- ----------------------------

-- ----------------------------
-- Table structure for clientes
-- ----------------------------
DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `apellidos` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `cedula` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `nacionalidad` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `etnia` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `celular` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `convencional` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sexo` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `tipo_sexo` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `instruccion` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `domicilio` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `estado_civil` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `sector` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `ocupacion` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `iess` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `ingresos` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bono` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `discapacidad` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `tipo_discapacidad` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `enfermedad` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `tipo_enfermedad` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `foto_cedula` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estado` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `monitor_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `supervisor_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of clientes
-- ----------------------------

-- ----------------------------
-- Table structure for consultas
-- ----------------------------
DROP TABLE IF EXISTS `consultas`;
CREATE TABLE `consultas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `supervisor_id` int(11) NOT NULL,
  `practicante_id` int(11) DEFAULT NULL,
  `razon` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `detalle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `causa` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipo_proceso` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `unidad_judicial` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `tipo_usuario` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estado` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `materia` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipo_judicatura` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipo_patrocinio` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `defensoria_publica` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pretension_presion` double(8,2) DEFAULT NULL,
  `nombre_juez` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ultima_actividad` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_ultima_actividad` date DEFAULT NULL,
  `estado_caso` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `resolucion_judicial` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_resolucion` date DEFAULT NULL,
  `convirtio_patrocinio` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of consultas
-- ----------------------------

-- ----------------------------
-- Table structure for ends
-- ----------------------------
DROP TABLE IF EXISTS `ends`;
CREATE TABLE `ends` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `estado` varchar(3) DEFAULT 'P',
  `descripcion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ends
-- ----------------------------
INSERT INTO `ends` VALUES ('1', '36', '36Final.pdf', '2018-12-22 14:59:53', '2018-12-22 14:59:53', 'P', null);

-- ----------------------------
-- Table structure for evaluacionestudiante
-- ----------------------------
DROP TABLE IF EXISTS `evaluacionestudiante`;
CREATE TABLE `evaluacionestudiante` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL,
  `updated_at` varchar(255) DEFAULT NULL,
  `e1` varchar(2) DEFAULT NULL,
  `e2` varchar(2) DEFAULT NULL,
  `e3` varchar(2) DEFAULT NULL,
  `e4` varchar(2) DEFAULT NULL,
  `e5` varchar(2) DEFAULT NULL,
  `e6` varchar(2) DEFAULT NULL,
  `e7` varchar(2) DEFAULT NULL,
  `e8` varchar(2) DEFAULT NULL,
  `e9` varchar(2) DEFAULT NULL,
  `e10` varchar(2) DEFAULT NULL,
  `e11` varchar(2) DEFAULT NULL,
  `s1` varchar(2) DEFAULT NULL,
  `ob1` varchar(255) DEFAULT NULL,
  `ob2` varchar(255) DEFAULT NULL,
  `ob3` varchar(255) DEFAULT NULL,
  `ob4` varchar(255) DEFAULT NULL,
  `sugerencias` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of evaluacionestudiante
-- ----------------------------
INSERT INTO `evaluacionestudiante` VALUES ('1', '35', '2018-08-24 18:41:34', '2018-08-24 18:41:34', '5', '5', '5', '5', '5', '5', '5', '5', '5', '5', '5', null, null, null, null, null, null);
INSERT INTO `evaluacionestudiante` VALUES ('2', '36', '2018-08-25 15:33:46', '2018-08-25 15:33:46', '5', '5', '5', '5', '4', '4', '4', '4', '4', '4', '4', null, null, null, null, null, null);

-- ----------------------------
-- Table structure for evaluacionsupervisor
-- ----------------------------
DROP TABLE IF EXISTS `evaluacionsupervisor`;
CREATE TABLE `evaluacionsupervisor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL,
  `updated_at` varchar(255) DEFAULT NULL,
  `e1` varchar(2) DEFAULT NULL,
  `e2` varchar(2) DEFAULT NULL,
  `e3` varchar(2) DEFAULT NULL,
  `e4` varchar(2) DEFAULT NULL,
  `e5` varchar(2) DEFAULT NULL,
  `e6` varchar(2) DEFAULT NULL,
  `e7` varchar(2) DEFAULT NULL,
  `e8` varchar(2) DEFAULT NULL,
  `e9` varchar(2) DEFAULT NULL,
  `e10` varchar(2) DEFAULT NULL,
  `e11` varchar(2) DEFAULT NULL,
  `ob1` varchar(255) DEFAULT NULL,
  `ob2` varchar(255) DEFAULT NULL,
  `ob3` varchar(255) DEFAULT NULL,
  `ob4` varchar(255) DEFAULT NULL,
  `total` varchar(3) DEFAULT NULL,
  `fr1` varchar(3) DEFAULT NULL,
  `fr2` varchar(3) DEFAULT NULL,
  `sum1` varchar(3) DEFAULT NULL,
  `sum2` varchar(3) NOT NULL,
  `nota` varchar(5) DEFAULT NULL,
  `docente_id` int(11) DEFAULT NULL,
  `fr3` varchar(3) DEFAULT NULL,
  `fr4` varchar(3) DEFAULT NULL,
  `fr5` varchar(3) DEFAULT NULL,
  `sum3` varchar(3) DEFAULT NULL,
  `sum4` varchar(3) DEFAULT NULL,
  `sum5` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of evaluacionsupervisor
-- ----------------------------
INSERT INTO `evaluacionsupervisor` VALUES ('1', '36', '2018-08-25 15:07:47', '2018-08-25 15:07:47', '5', '5', '5', '5', '5', '5', '5', '5', '5', '5', '5', null, null, null, null, '55', '0', '0', '0', '0', '10', '25', '0', '0', '11', '0', '0', '55');

-- ----------------------------
-- Table structure for evaluaciontutor
-- ----------------------------
DROP TABLE IF EXISTS `evaluaciontutor`;
CREATE TABLE `evaluaciontutor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `docente_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL,
  `updated_at` varchar(255) DEFAULT NULL,
  `visita` int(11) DEFAULT NULL,
  `e1` varchar(2) DEFAULT NULL,
  `e2` varchar(2) DEFAULT NULL,
  `e3` varchar(2) DEFAULT NULL,
  `e4` varchar(2) DEFAULT NULL,
  `e5` varchar(2) DEFAULT NULL,
  `ec1` varchar(2) DEFAULT NULL,
  `ec2` varchar(2) DEFAULT NULL,
  `ec3` varchar(2) DEFAULT NULL,
  `ec4` varchar(2) DEFAULT NULL,
  `ec5` varchar(2) DEFAULT NULL,
  `vfa` varchar(2) DEFAULT NULL,
  `vfr` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of evaluaciontutor
-- ----------------------------
INSERT INTO `evaluaciontutor` VALUES ('1', '25', '36', '2018-08-25 14:41:31', '2018-08-25 14:41:31', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', 'X', '');

-- ----------------------------
-- Table structure for horarios
-- ----------------------------
DROP TABLE IF EXISTS `horarios`;
CREATE TABLE `horarios` (
  `id` int(11) DEFAULT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `periodo_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of horarios
-- ----------------------------
INSERT INTO `horarios` VALUES ('1', 'horario 1', '1');
INSERT INTO `horarios` VALUES ('2', 'horario 2', '1');
INSERT INTO `horarios` VALUES ('3', 'horario 3', '1');
INSERT INTO `horarios` VALUES ('4', 'horario 4', '1');

-- ----------------------------
-- Table structure for periodos
-- ----------------------------
DROP TABLE IF EXISTS `periodos`;
CREATE TABLE `periodos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) DEFAULT NULL,
  `fechai` date DEFAULT NULL,
  `recepcioni` date DEFAULT NULL,
  `fechaf` date DEFAULT NULL,
  `recepcionf` date DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `notificaf` date DEFAULT NULL,
  `mesi` varchar(15) DEFAULT NULL,
  `mesf` varchar(15) DEFAULT NULL,
  `notificai` date DEFAULT NULL,
  `habilita` varchar(2) DEFAULT 'A',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of periodos
-- ----------------------------
INSERT INTO `periodos` VALUES ('4', 'ciclo prueba', '2018-08-15', '2018-08-07', '2018-12-31', '2018-12-31', 'A', '2018-12-22 15:02:46', '2018-12-22 15:02:46', '2018-12-31', 'mayo', '11', '2018-08-14', 'A');

-- ----------------------------
-- Table structure for postulants
-- ----------------------------
DROP TABLE IF EXISTS `postulants`;
CREATE TABLE `postulants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(50) DEFAULT NULL,
  `apellidos` varchar(50) DEFAULT NULL,
  `identificacion` varchar(13) DEFAULT NULL,
  `semestre` varchar(50) DEFAULT NULL,
  `carrera` varchar(50) DEFAULT NULL,
  `direccion` longtext,
  `celular` varchar(10) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `edad` varchar(50) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `horario_t` varchar(50) DEFAULT NULL,
  `cedula_archivo` int(1) DEFAULT '0',
  `papeleta_archivo` int(1) DEFAULT '0',
  `paralelo` varchar(50) DEFAULT NULL,
  `foto_archivo` int(1) DEFAULT '0',
  `curriculum_archivo` int(1) DEFAULT '0',
  `certificado_matricula` int(1) DEFAULT '0',
  `certificado_no_arrastre` int(1) DEFAULT '0',
  `solicitud_sellada` int(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `estado` varchar(1) DEFAULT 'A',
  `convencional` varchar(10) DEFAULT NULL,
  `modalidad` varchar(10) DEFAULT NULL,
  `horario` varchar(10) DEFAULT NULL,
  `provincia_id` varchar(50) DEFAULT NULL,
  `ciudad_id` varchar(50) DEFAULT NULL,
  `labora` varchar(50) DEFAULT NULL,
  `direccion_t` varchar(50) DEFAULT NULL,
  `telefono_t` varchar(50) DEFAULT NULL,
  `ocupacion` varchar(50) DEFAULT NULL,
  `discapacidad` varchar(50) DEFAULT NULL,
  `carnet` varchar(50) DEFAULT NULL,
  `estado_civil` varchar(50) DEFAULT NULL,
  `area` varchar(50) DEFAULT NULL,
  `correo_institucional` varchar(255) DEFAULT NULL,
  `civil` int(11) DEFAULT '0',
  `penal` int(11) DEFAULT '0',
  `familia` int(11) DEFAULT '0',
  `laboral` int(11) DEFAULT '0',
  `violenciaf` int(11) DEFAULT '0',
  `inquilinato` int(11) DEFAULT '0',
  `fiscalia` int(11) DEFAULT '0',
  `defensoria` int(11) DEFAULT '0',
  `constitucional` int(11) DEFAULT '0',
  `motivo` varchar(255) DEFAULT NULL,
  `hsitu` int(5) DEFAULT '0',
  `hacademicas` int(5) DEFAULT '0',
  `hclinica` int(5) DEFAULT '0',
  `htrabajoc` int(5) DEFAULT '0',
  `capacitaciones` int(5) DEFAULT '0',
  `periodo_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of postulants
-- ----------------------------
INSERT INTO `postulants` VALUES ('2', 'asd', 'fc', '0922606223', 'EGRESADO', 'Derecho', 'as', '0999999999', null, '22', '2018-08-16', null, '1', '1', '-', '1', '1', '1', '1', '1', '2019-01-18 10:08:56', '2019-01-18 10:08:56', 'T', null, 'ANUAL', 'MATUTINO', 'guayas', 'guayaquil', 'NO', null, null, null, 'NO', null, 'SOLTERO', null, 'anthony.espinozaf@ug.edu.ec', '0', '1', '0', '0', '1', '0', '0', '1', '0', null, '0', '0', '0', '0', '0', '4');

-- ----------------------------
-- Table structure for products_photos
-- ----------------------------
DROP TABLE IF EXISTS `products_photos`;
CREATE TABLE `products_photos` (
  `user_id` int(11) NOT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of products_photos
-- ----------------------------
INSERT INTO `products_photos` VALUES ('36', 'photos/5jpCZ8XN6BPJm90HPHyu0L68dwv61m8ETrrwCNBh.jpeg', '2018-08-25 14:24:16', '2018-08-25 14:24:16');
INSERT INTO `products_photos` VALUES ('36', 'photos/BOB8O7cjxSCfEflarJLjYBjBHPlfSqzPrQWYM3zi.jpeg', '2018-08-25 14:24:23', '2018-08-25 14:24:23');

-- ----------------------------
-- Table structure for requests
-- ----------------------------
DROP TABLE IF EXISTS `requests`;
CREATE TABLE `requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state_id` int(11) DEFAULT '5',
  `postulant_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `estado` varchar(1) DEFAULT 'A',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `state_id_a` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of requests
-- ----------------------------
INSERT INTO `requests` VALUES ('2', '2', '2', '2018-08-25 14:16:46', 'A', '2018-08-25 14:16:46', null);

-- ----------------------------
-- Table structure for semanaobservaciones
-- ----------------------------
DROP TABLE IF EXISTS `semanaobservaciones`;
CREATE TABLE `semanaobservaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `semana` varchar(11) DEFAULT NULL,
  `observacion` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `docente_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of semanaobservaciones
-- ----------------------------
INSERT INTO `semanaobservaciones` VALUES ('1', 'Semana 2', 'asd', '36', '2018-08-25 14:29:17', '2018-08-25 14:29:17', '25');

-- ----------------------------
-- Table structure for states
-- ----------------------------
DROP TABLE IF EXISTS `states`;
CREATE TABLE `states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) DEFAULT NULL,
  `estado` varchar(1) DEFAULT 'A',
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `abv` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of states
-- ----------------------------
INSERT INTO `states` VALUES ('1', 'AUTORIZADO', 'A', null, null, 'AU');
INSERT INTO `states` VALUES ('2', 'APROBADO', 'A', null, null, 'AP');
INSERT INTO `states` VALUES ('3', 'NEGADO', 'A', null, null, 'NE');
INSERT INTO `states` VALUES ('4', 'ABANDONO', 'A', null, null, 'AB');
INSERT INTO `states` VALUES ('5', 'PENDIENTE', 'A', '2018-07-29 00:52:15', '2018-07-29 00:52:15', 'PE');
INSERT INTO `states` VALUES ('6', 'AUTORIZADO', 'A', '2018-08-07 06:32:29', '2018-08-07 06:32:29', 'AUI');

-- ----------------------------
-- Table structure for students_teachers
-- ----------------------------
DROP TABLE IF EXISTS `students_teachers`;
CREATE TABLE `students_teachers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_est_id` int(11) DEFAULT NULL,
  `user_doc_id` int(11) DEFAULT NULL,
  `estado` varchar(1) DEFAULT 'A',
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `tipo` varchar(5) DEFAULT NULL,
  `horario_id` int(11) DEFAULT NULL,
  `lugar_id` int(11) DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_fin` time DEFAULT NULL,
  `cant_horas` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of students_teachers
-- ----------------------------
INSERT INTO `students_teachers` VALUES ('2', '36', '25', 'A', '2018-08-25 14:22:05', '2018-08-25 14:22:05', 'SUP', null, '1', '09:00:00', '11:00:00', '2');
INSERT INTO `students_teachers` VALUES ('3', '36', '30', 'A', '2018-08-25 14:22:40', '2018-08-25 14:22:40', 'TUT', null, null, null, null, null);

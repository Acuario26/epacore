/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50719
Source Host           : localhost:3306
Source Database       : recaudaciones

Target Server Type    : MYSQL
Target Server Version : 50719
File Encoding         : 65001

Date: 2019-03-08 18:03:34
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for clientes
-- ----------------------------
DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identificacion` varchar(13) DEFAULT NULL,
  `nombres` varchar(100) DEFAULT NULL,
  `ciudad` varchar(20) DEFAULT NULL,
  `celular` varchar(10) DEFAULT NULL,
  `direccion` varchar(50) DEFAULT NULL,
  `dias_mora` int(11) DEFAULT NULL,
  `valor_vencido` decimal(10,2) DEFAULT NULL,
  `valor_deuda` decimal(10,2) DEFAULT '0.00',
  `estado` varchar(2) DEFAULT 'P',
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `usuario_ing` varchar(15) DEFAULT NULL,
  `usuario_mod` varchar(15) DEFAULT NULL,
  `pago_id` int(11) DEFAULT NULL,
  `recaudador_user` varchar(13) DEFAULT NULL,
  `operador_user` varchar(13) DEFAULT NULL,
  `convencional` varchar(10) DEFAULT NULL,
  `celularlaboral` varchar(10) DEFAULT NULL,
  `celularreferencia` varchar(10) DEFAULT NULL,
  `nombrelaboral` varchar(100) DEFAULT NULL,
  `nombrereferencia` varchar(100) DEFAULT NULL,
  `fecha_vencida` datetime DEFAULT NULL,
  `fecha_acuerdo` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `acuerdo` longtext,
  `intentos` int(11) DEFAULT '0',
  `cuotas` int(11) DEFAULT '0',
  `valor_acuerdo` decimal(10,2) DEFAULT '0.00',
  `fecha_acuerdo2` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `acuerdo2` longtext,
  `cuotas2` int(11) DEFAULT '0',
  `valor_acuerdo2` decimal(10,2) DEFAULT '0.00',
  `porcentaje_mora` int(11) DEFAULT '0',
  `porcentaje_pago` int(11) DEFAULT '0',
  `llamada` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of clientes
-- ----------------------------
INSERT INTO `clientes` VALUES ('1', '0923445566', 'Ricardo Soso', 'MANABI', '0982734567', 'gye', '20', '15.22', '0.00', 'P', '2019-03-08 18:01:28', '2019-03-08 18:01:28', '', '', null, '0922606223', '0922334455', '042124578', '042124573', '0999999999', 'LAUREL', 'MAY', '2018-10-11 19:07:31', '2019-03-08 18:01:28', '43', '0', '4', '233.00', '2019-03-08 18:01:28', '43', '4', '233.00', '0', '0', '1');
INSERT INTO `clientes` VALUES ('2', '0923445567', 'Ricardo Sosa', 'MANABI', '0982734568', 'gye', '20', '1000.00', '500.00', 'I', '2019-03-08 14:55:56', '2019-03-08 14:55:56', '', '', null, '0922606223', '0922334455', '042124577', '042124572', '0987441423', 'PIÑA', 'TELA', '2019-01-14 19:07:40', '2019-03-08 14:55:56', '213', '0', '123', '12.00', '2019-03-08 14:55:56', '334', '334', '123.00', '0', '0', '0');
INSERT INTO `clientes` VALUES ('3', '0923445568', 'Ricardo SosI', 'MANABI', '0982734569', 'gye', '20', '1500.00', '0.00', 'P', '2019-03-08 14:52:32', '2019-03-08 14:52:32', '', '', null, '0922606223', '0922334455', '042124576', '042124571', '0977777777', 'PASA', 'KOLA', '2018-08-07 19:07:47', '2019-03-08 14:52:32', 'prueba prueba prueba prueba prueba prueba prueba prueba prueba prueba prueba prueba prueba prueba prueba prueba prueba prueba prueba prueba prueba prueba prueba prueba prueba prueba prueba prueba prueba prueba prueba prueba prueba prueba prueba prueba prueba prueba prueba prueba prueba prueba prueba ', '0', '0', '0.00', '2019-03-08 14:52:32', null, null, null, '0', '0', '0');
INSERT INTO `clientes` VALUES ('4', '0923445560', 'Ricardo SosU', 'MANABI', '0982734560', 'gye', '20', '200.00', '0.00', 'P', '2019-03-08 14:52:33', '2019-03-08 14:52:33', '', '', null, '0922606223', '0922334455', '042124575', '042124570', '0925487787', 'SASA', 'SELLA', '2018-11-14 19:07:59', '2019-03-08 14:52:33', '33', '0', '2', '22.00', '2019-03-08 14:52:33', '3434', '123', '123.00', '0', '0', '0');
INSERT INTO `clientes` VALUES ('5', '0923445562', 'Ricardo SosE', 'MANABI', '0982734562', 'gye', '20', '450.00', '0.00', 'P', '2019-03-08 14:52:30', '2019-03-08 14:52:30', '', '', null, '0922606223', '0922334455', '042124574', '042124571', '0974749787', 'GOTA', 'MERA', '2019-01-15 19:08:04', '2019-03-08 14:52:30', '450', '0', '0', '450.00', '2019-03-08 14:52:30', 'dfgdfg', '1', '25.00', '0', '0', '0');
INSERT INTO `clientes` VALUES ('6', '0926339730', 'PRUEBA', 'PRUEBA', '0911111111', null, null, '12000.00', '0.00', 'P', '2019-03-08 14:52:28', '2019-03-08 14:52:28', '21', '21', null, '0922606223', '0922334455', '0911111111', '0911111112', '0911111113', 'L', null, '2018-12-30 00:00:00', '2019-03-08 14:52:28', 'dfghjk', '0', '0', '8000.00', '2019-03-08 14:52:28', null, null, null, '0', '0', '0');
INSERT INTO `clientes` VALUES ('8', '0987654321', 'prueba', 'guayaquil', '0981263123', 'duran', null, '27.99', '0.00', 'P', '2019-03-08 17:45:47', '2019-03-08 17:45:47', '1', '1', null, '0922606223', '0922334455', '2801544', '0981231752', '2801544', 'PUBLY', null, '2019-01-29 00:00:00', '2019-03-08 17:45:47', 'prueba', '0', '1', '20.00', '2019-03-08 17:45:47', 'prueba2', '1', '12.00', '0', '0', '0');

-- ----------------------------
-- Table structure for llamadas
-- ----------------------------
DROP TABLE IF EXISTS `llamadas`;
CREATE TABLE `llamadas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inicio` datetime DEFAULT NULL,
  `fin` datetime DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `operador_id` varchar(13) DEFAULT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `comentario` varchar(255) DEFAULT NULL,
  `estadoLLamada` varchar(255) DEFAULT NULL,
  `numero` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of llamadas
-- ----------------------------

-- ----------------------------
-- Table structure for pagos
-- ----------------------------
DROP TABLE IF EXISTS `pagos`;
CREATE TABLE `pagos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `valor` decimal(10,2) DEFAULT NULL,
  `comprobante` varchar(20) DEFAULT NULL,
  `tipo_pago` int(11) DEFAULT NULL,
  `recaudador_user` varchar(13) NOT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `entidad` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pagos
-- ----------------------------
INSERT INTO `pagos` VALUES ('11', '500.00', '500', '1265', '0922606223', '2', 'A', '500RC2.jpg', '2019-02-02 14:50:21', '2019-02-02 14:50:21', null);
INSERT INTO `pagos` VALUES ('12', '12.00', '123', '1267', '0922606223', '8', 'A', '123RC8.jpg', '2019-02-05 19:29:40', '2019-02-05 19:29:40', null);

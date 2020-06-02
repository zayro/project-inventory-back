/*
 Navicat Premium Data Transfer

 Source Server         : mysql_localhost
 Source Server Type    : MySQL
 Source Server Version : 80016
 Source Host           : localhost:3306
 Source Schema         : inventario

 Target Server Type    : MySQL
 Target Server Version : 80016
 File Encoding         : 65001

 Date: 01/06/2020 23:56:17
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for bodega
-- ----------------------------
DROP TABLE IF EXISTS `bodega`;
CREATE TABLE `bodega`  (
  `id` int(12) NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `detalle` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ciudad` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `direccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bodega
-- ----------------------------
INSERT INTO `bodega` VALUES (1, 'bodeda principal', 'zona 1', 'bucaramanga', 'cll 38 # 7');
INSERT INTO `bodega` VALUES (2, 'bodega venta..', 'zona 2', 'san gil', 'cl34');

-- ----------------------------
-- Table structure for categoria
-- ----------------------------
DROP TABLE IF EXISTS `categoria`;
CREATE TABLE `categoria`  (
  `id` int(11) NOT NULL DEFAULT 0,
  `nombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `creado` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `eliminado` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `nombre`(`nombre`, `descripcion`) USING BTREE,
  INDEX `id`(`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of categoria
-- ----------------------------
INSERT INTO `categoria` VALUES (1, 'equipos de computo', 'categoria se debe asociar lo relacionado a computador', '2017-03-10 18:35:17', '2017-05-25 20:10:03', NULL);
INSERT INTO `categoria` VALUES (2, 'papeleria', 'lo relacionado a las papelerias', '2017-04-26 11:10:46', '2017-05-15 01:32:44', NULL);
INSERT INTO `categoria` VALUES (3, 'cafeteria', 'descripcion', '2017-04-26 11:10:59', NULL, NULL);

-- ----------------------------
-- Table structure for detalle_movimiento
-- ----------------------------
DROP TABLE IF EXISTS `detalle_movimiento`;
CREATE TABLE `detalle_movimiento`  (
  `id` int(11) NOT NULL,
  `id_producto` int(12) NOT NULL COMMENT 'codigo de articulos',
  `cantidad` smallint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'cantidad de articulos',
  `precio` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'precio del articulo',
  `id_maestro_movimiento` int(12) NOT NULL,
  PRIMARY KEY (`id`, `id_producto`, `id_maestro_movimiento`) USING BTREE,
  INDEX `id_maestro_factura`(`id_maestro_movimiento`) USING BTREE,
  INDEX `id_producto`(`id_producto`) USING BTREE,
  UNIQUE INDEX `id`(`id`) USING BTREE,
  CONSTRAINT `detalle_movimiento_ibfk_3` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `detalle_movimiento_ibfk_4` FOREIGN KEY (`id_maestro_movimiento`) REFERENCES `maestro_movimiento` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of detalle_movimiento
-- ----------------------------
INSERT INTO `detalle_movimiento` VALUES (1, 2, 5, 15000, 1);
INSERT INTO `detalle_movimiento` VALUES (2, 2, 5, 15000, 2);
INSERT INTO `detalle_movimiento` VALUES (3, 1, 9, 30000, 2);
INSERT INTO `detalle_movimiento` VALUES (4, 2, 65, 15000, 3);
INSERT INTO `detalle_movimiento` VALUES (5, 2, 6, 15000, 4);
INSERT INTO `detalle_movimiento` VALUES (6, 1, 5, 30000, 5);
INSERT INTO `detalle_movimiento` VALUES (7, 1, 6, 30000, 6);
INSERT INTO `detalle_movimiento` VALUES (8, 2, 4, 15000, 7);
INSERT INTO `detalle_movimiento` VALUES (9, 2, 4, 15000, 8);
INSERT INTO `detalle_movimiento` VALUES (10, 2, 6, 15000, 9);
INSERT INTO `detalle_movimiento` VALUES (11, 2, 6, 15000, 10);
INSERT INTO `detalle_movimiento` VALUES (12, 2, 12, 16000, 11);
INSERT INTO `detalle_movimiento` VALUES (13, 1, 10, 30000, 12);
INSERT INTO `detalle_movimiento` VALUES (14, 2, 1, 20000, 14);
INSERT INTO `detalle_movimiento` VALUES (15, 1, 1, 36000, 14);
INSERT INTO `detalle_movimiento` VALUES (16, 2, 1, 20000, 15);
INSERT INTO `detalle_movimiento` VALUES (17, 1, 1, 36000, 15);
INSERT INTO `detalle_movimiento` VALUES (18, 2, 1, 20000, 16);
INSERT INTO `detalle_movimiento` VALUES (19, 1, 1, 36000, 16);
INSERT INTO `detalle_movimiento` VALUES (20, 2, 1, 20000, 17);
INSERT INTO `detalle_movimiento` VALUES (21, 1, 1, 36000, 17);
INSERT INTO `detalle_movimiento` VALUES (22, 2, 1, 20000, 18);
INSERT INTO `detalle_movimiento` VALUES (23, 1, 1, 36000, 18);
INSERT INTO `detalle_movimiento` VALUES (24, 2, 1, 20000, 19);
INSERT INTO `detalle_movimiento` VALUES (25, 2, 1, 20000, 20);
INSERT INTO `detalle_movimiento` VALUES (26, 2, 1, 20000, 21);
INSERT INTO `detalle_movimiento` VALUES (27, 1, 1, 36000, 21);
INSERT INTO `detalle_movimiento` VALUES (28, 2, 1, 20000, 22);
INSERT INTO `detalle_movimiento` VALUES (29, 1, 1, 36000, 22);
INSERT INTO `detalle_movimiento` VALUES (30, 1, 1, 36000, 23);
INSERT INTO `detalle_movimiento` VALUES (31, 2, 1, 20000, 23);

-- ----------------------------
-- Table structure for maestro_movimiento
-- ----------------------------
DROP TABLE IF EXISTS `maestro_movimiento`;
CREATE TABLE `maestro_movimiento`  (
  `id` int(12) NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `descuento` mediumint(11) NULL DEFAULT NULL,
  `impuesto` smallint(11) NULL DEFAULT NULL,
  `total` decimal(10, 2) NULL DEFAULT NULL,
  `id_tipo_comprobante` int(12) NOT NULL,
  `id_tipo_pago` int(11) NOT NULL,
  `identificacion_tercero` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `identificacion_usuario` int(11) NOT NULL,
  `eliminado` timestamp(0) NULL DEFAULT NULL,
  `actualizado` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `creado` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `tipo_factura`(`id_tipo_comprobante`) USING BTREE,
  INDEX `id_tercero`(`identificacion_tercero`) USING BTREE,
  INDEX `id_tipo_pago`(`id_tipo_pago`) USING BTREE,
  INDEX `identificacion_usuario`(`identificacion_usuario`) USING BTREE,
  CONSTRAINT `maestro_movimiento_ibfk_2` FOREIGN KEY (`id_tipo_pago`) REFERENCES `tipo_pago` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `maestro_movimiento_ibfk_3` FOREIGN KEY (`identificacion_tercero`) REFERENCES `tercero` (`identificacion`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `maestro_movimiento_ibfk_5` FOREIGN KEY (`id_tipo_comprobante`) REFERENCES `tipo_comprobante` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `maestro_movimiento_ibfk_6` FOREIGN KEY (`identificacion_usuario`) REFERENCES `users` (`id_users`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of maestro_movimiento
-- ----------------------------
INSERT INTO `maestro_movimiento` VALUES (1, NULL, NULL, NULL, 87000.00, 2, 2, '804014839-1', 0, NULL, '2020-05-26 00:42:15', '2017-05-22 14:18:48');
INSERT INTO `maestro_movimiento` VALUES (2, NULL, NULL, NULL, 400200.00, 2, 2, '804014839-1', 0, NULL, '2020-05-26 00:42:15', '2017-05-22 14:19:23');
INSERT INTO `maestro_movimiento` VALUES (3, NULL, 6000, 16, 969000.00, 1, 2, '804014839-1', 0, NULL, '2020-05-26 00:42:15', '2017-05-22 16:24:19');
INSERT INTO `maestro_movimiento` VALUES (4, NULL, 0, 16, 104400.00, 3, 1, '804014839-1', 0, NULL, '2020-05-26 00:42:15', '2017-05-22 16:38:12');
INSERT INTO `maestro_movimiento` VALUES (5, NULL, 0, 16, 174000.00, 2, 3, '804014839-1', 0, NULL, '2020-05-26 00:42:15', '2017-05-22 16:52:21');
INSERT INTO `maestro_movimiento` VALUES (6, NULL, NULL, 16, 208800.00, 6, 2, '804014839-1', 0, NULL, '2020-05-26 00:42:15', '2017-05-22 16:59:58');
INSERT INTO `maestro_movimiento` VALUES (7, NULL, NULL, 16, 69600.00, 6, 3, '804014839-1', 0, NULL, '2020-05-26 00:42:15', '2017-05-22 17:02:55');
INSERT INTO `maestro_movimiento` VALUES (8, NULL, NULL, 16, 59400.00, 4, 3, '804014839-1', 0, NULL, '2020-05-26 00:42:15', '2017-05-22 17:04:41');
INSERT INTO `maestro_movimiento` VALUES (9, 'descuetos', 400, 16, 89600.00, 6, 5, '804014839-1', 0, NULL, '2020-05-26 00:42:15', '2017-05-22 17:09:18');
INSERT INTO `maestro_movimiento` VALUES (10, NULL, 0, 16, 104400.00, 2, 2, '804014839-1', 0, NULL, '2020-05-26 00:42:15', '2017-05-25 11:42:00');
INSERT INTO `maestro_movimiento` VALUES (11, 'detalles de la factura', 9000, 0, 183000.00, 4, 5, '804014839-1', 0, NULL, '2020-05-26 00:42:15', '2017-05-25 19:55:33');
INSERT INTO `maestro_movimiento` VALUES (12, NULL, 0, 16, 348000.00, 1, 2, '804014839-1', 0, NULL, '2020-05-26 00:42:15', '2017-06-01 11:37:29');
INSERT INTO `maestro_movimiento` VALUES (13, NULL, 0, 16, 400200.00, 4, 3, '804014839-1', 0, NULL, '2020-05-26 00:42:15', '2017-06-01 11:38:06');
INSERT INTO `maestro_movimiento` VALUES (14, '', 20, 10, 61580.00, 2, 2, '102030', 0, NULL, NULL, '2020-05-26 01:51:01');
INSERT INTO `maestro_movimiento` VALUES (15, '', 20, 10, 61580.00, 2, 2, '102030', 0, NULL, NULL, '2020-05-26 01:51:20');
INSERT INTO `maestro_movimiento` VALUES (16, '', 20, 10, 61580.00, 2, 2, '102030', 0, NULL, NULL, '2020-05-26 01:51:36');
INSERT INTO `maestro_movimiento` VALUES (17, '', 20, 10, 61580.00, 2, 2, '102030', 0, NULL, NULL, '2020-05-26 01:53:14');
INSERT INTO `maestro_movimiento` VALUES (18, '', 20, 10, 61580.00, 2, 2, '102030', 0, NULL, NULL, '2020-05-26 12:45:34');
INSERT INTO `maestro_movimiento` VALUES (19, '', 0, 0, 0.00, 3, 3, '102030', 0, NULL, NULL, '2020-05-26 12:46:36');
INSERT INTO `maestro_movimiento` VALUES (20, '', 0, 0, 20000.00, 3, 2, '102030', 0, NULL, NULL, '2020-05-26 13:53:24');
INSERT INTO `maestro_movimiento` VALUES (21, 'sdfsf', 0, 0, 56000.00, 3, 3, '102030', 10, NULL, NULL, '2020-05-27 12:37:18');
INSERT INTO `maestro_movimiento` VALUES (22, 'sdfsf', 40, 30, 72760.00, 3, 3, '102030', 10, NULL, NULL, '2020-05-27 12:37:49');
INSERT INTO `maestro_movimiento` VALUES (23, '', 0, 0, 56000.00, 2, 3, '0', 10, NULL, NULL, '2020-05-28 15:11:49');

-- ----------------------------
-- Table structure for producto
-- ----------------------------
DROP TABLE IF EXISTS `producto`;
CREATE TABLE `producto`  (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `serial` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `precio_compra` int(11) NOT NULL,
  `precio_venta` int(11) NOT NULL,
  `stock_alerta` smallint(11) NOT NULL,
  `stock_emergencia` smallint(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_bodega` int(11) NOT NULL,
  `id_tipo_unidad` int(11) NOT NULL,
  `activo` bit(1) NULL DEFAULT b'1',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `nombre`(`nombre`) USING BTREE,
  UNIQUE INDEX `serial`(`serial`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `id_categoria`(`id_categoria`) USING BTREE,
  INDEX `id_unidad`(`id_tipo_unidad`) USING BTREE,
  INDEX `id_bodega`(`id_bodega`) USING BTREE,
  CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `producto_ibfk_3` FOREIGN KEY (`id_tipo_unidad`) REFERENCES `tipo_unidad` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `producto_ibfk_4` FOREIGN KEY (`id_bodega`) REFERENCES `bodega` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of producto
-- ----------------------------
INSERT INTO `producto` VALUES (1, 'teclado', '0028', 30000, 36000, 11, 5, 1, 1, 7, b'1');
INSERT INTO `producto` VALUES (2, 'mouse', '0044', 15000, 20000, 10, 5, 1, 1, 7, b'1');
INSERT INTO `producto` VALUES (3, 'dfgdfg', '3453453', 0, 0, 0, 0, 2, 2, 1, b'1');

-- ----------------------------
-- Table structure for tercero
-- ----------------------------
DROP TABLE IF EXISTS `tercero`;
CREATE TABLE `tercero`  (
  `id` int(12) NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `telefono` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `identificacion` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ciudad` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `id_tipo_tercero` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `identificacion`(`identificacion`) USING BTREE,
  INDEX `id_tipo_tercero`(`id_tipo_tercero`) USING BTREE,
  UNIQUE INDEX `email`(`email`) USING BTREE,
  CONSTRAINT `tercero_ibfk_1` FOREIGN KEY (`id_tipo_tercero`) REFERENCES `tipo_tercero` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tercero
-- ----------------------------
INSERT INTO `tercero` VALUES (0, 'default', '0', '0', 'default', NULL, 1);
INSERT INTO `tercero` VALUES (1, 'Instituto del corazon', '6329291', '804014839-1', 'compras@institutodelcorazon.com', '', 2);
INSERT INTO `tercero` VALUES (2, 'sony', '56456449', '102030', 'test@gmail.com', NULL, 3);
INSERT INTO `tercero` VALUES (3, 'cliente', '0', '10203', '0000', NULL, 3);

-- ----------------------------
-- Table structure for tipo_comprobante
-- ----------------------------
DROP TABLE IF EXISTS `tipo_comprobante`;
CREATE TABLE `tipo_comprobante`  (
  `id` int(12) NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `id_naturaleza` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_naturaleza`(`id_naturaleza`) USING BTREE,
  CONSTRAINT `tipo_comprobante_ibfk_2` FOREIGN KEY (`id_naturaleza`) REFERENCES `tipo_naturaleza` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tipo_comprobante
-- ----------------------------
INSERT INTO `tipo_comprobante` VALUES (1, 'ingreso por compra', 1);
INSERT INTO `tipo_comprobante` VALUES (2, 'ingreso por devolucion', 1);
INSERT INTO `tipo_comprobante` VALUES (3, 'ingreso por ajuste', 1);
INSERT INTO `tipo_comprobante` VALUES (4, 'salida por venta', 2);
INSERT INTO `tipo_comprobante` VALUES (5, 'salida por defectos', 2);
INSERT INTO `tipo_comprobante` VALUES (6, 'salida por ajuste', 2);
INSERT INTO `tipo_comprobante` VALUES (7, 'cotizacion', 3);

-- ----------------------------
-- Table structure for tipo_naturaleza
-- ----------------------------
DROP TABLE IF EXISTS `tipo_naturaleza`;
CREATE TABLE `tipo_naturaleza`  (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tipo_naturaleza
-- ----------------------------
INSERT INTO `tipo_naturaleza` VALUES (1, 'entrada');
INSERT INTO `tipo_naturaleza` VALUES (2, 'salida');
INSERT INTO `tipo_naturaleza` VALUES (3, 'otra');

-- ----------------------------
-- Table structure for tipo_pago
-- ----------------------------
DROP TABLE IF EXISTS `tipo_pago`;
CREATE TABLE `tipo_pago`  (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tipo_pago
-- ----------------------------
INSERT INTO `tipo_pago` VALUES (1, 'efectivo');
INSERT INTO `tipo_pago` VALUES (2, 'credito');
INSERT INTO `tipo_pago` VALUES (3, 'cheque');
INSERT INTO `tipo_pago` VALUES (4, 'transferencia bancaria');
INSERT INTO `tipo_pago` VALUES (5, 'otro');

-- ----------------------------
-- Table structure for tipo_tercero
-- ----------------------------
DROP TABLE IF EXISTS `tipo_tercero`;
CREATE TABLE `tipo_tercero`  (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tipo_tercero
-- ----------------------------
INSERT INTO `tipo_tercero` VALUES (1, 'interno');
INSERT INTO `tipo_tercero` VALUES (2, 'proveedor');
INSERT INTO `tipo_tercero` VALUES (3, 'cliente');

-- ----------------------------
-- Table structure for tipo_unidad
-- ----------------------------
DROP TABLE IF EXISTS `tipo_unidad`;
CREATE TABLE `tipo_unidad`  (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tipo_unidad
-- ----------------------------
INSERT INTO `tipo_unidad` VALUES (1, 'tonelada');
INSERT INTO `tipo_unidad` VALUES (2, 'kilogramo');
INSERT INTO `tipo_unidad` VALUES (3, 'gramo');
INSERT INTO `tipo_unidad` VALUES (4, 'libra');
INSERT INTO `tipo_unidad` VALUES (5, 'galon');
INSERT INTO `tipo_unidad` VALUES (6, 'litro');
INSERT INTO `tipo_unidad` VALUES (7, 'unidad');

-- ----------------------------
-- View structure for compras
-- ----------------------------
DROP VIEW IF EXISTS `compras`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `compras` AS select sum(`maestro_movimiento`.`total`) AS `total`,cast(`maestro_movimiento`.`creado` as date) AS `mes` from (`maestro_movimiento` join `tipo_comprobante` on((`maestro_movimiento`.`id_tipo_comprobante` = `tipo_comprobante`.`id`))) where ((`tipo_comprobante`.`id` = 1) and isnull(`maestro_movimiento`.`eliminado`) and (month(`maestro_movimiento`.`creado`) = month(now()))) group by month(`maestro_movimiento`.`creado`);

-- ----------------------------
-- View structure for estadistica
-- ----------------------------
DROP VIEW IF EXISTS `estadistica`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `estadistica` AS select `maestro_movimiento`.`total` AS `total`,`tipo_comprobante`.`nombre` AS `factura`,cast(`maestro_movimiento`.`creado` as date) AS `fecha` from (`maestro_movimiento` join `tipo_comprobante` on((`tipo_comprobante`.`id` = `maestro_movimiento`.`id_tipo_comprobante`))) where (year(`maestro_movimiento`.`creado`) = year(now())) order by `tipo_comprobante`.`nombre`;

-- ----------------------------
-- View structure for movimientos_detalles
-- ----------------------------
DROP VIEW IF EXISTS `movimientos_detalles`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `movimientos_detalles` AS select `detalle_movimiento`.`id_producto` AS `id_producto`,`detalle_movimiento`.`cantidad` AS `cantidad`,`detalle_movimiento`.`precio` AS `precio`,`producto`.`nombre` AS `nombre`,`producto`.`serial` AS `serial`,`detalle_movimiento`.`id_maestro_movimiento` AS `id_maestro_movimiento` from (`detalle_movimiento` join `producto` on((`detalle_movimiento`.`id_producto` = `producto`.`id`)));

-- ----------------------------
-- View structure for movimientos_encabezados
-- ----------------------------
DROP VIEW IF EXISTS `movimientos_encabezados`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `movimientos_encabezados` AS select `maestro_movimiento`.`id` AS `id`,`tercero`.`nombre` AS `persona`,`tipo_comprobante`.`nombre` AS `movimiento`,`tipo_pago`.`nombre` AS `pago`,`tipo_naturaleza`.`nombre` AS `naturaleza`,`maestro_movimiento`.`total` AS `total`,`tercero`.`telefono` AS `telefono`,`tercero`.`identificacion` AS `identificacion`,`maestro_movimiento`.`descuento` AS `descuento`,`maestro_movimiento`.`descripcion` AS `descripcion`,`maestro_movimiento`.`impuesto` AS `impuesto`,`maestro_movimiento`.`eliminado` AS `eliminado`,`tercero`.`email` AS `email`,date_format(`maestro_movimiento`.`creado`,'%Y-%m-%d') AS `fecha` from ((((`maestro_movimiento` join `tipo_comprobante` on((`maestro_movimiento`.`id_tipo_comprobante` = `tipo_comprobante`.`id`))) join `tipo_pago` on((`maestro_movimiento`.`id_tipo_pago` = `tipo_pago`.`id`))) join `tercero` on((`maestro_movimiento`.`identificacion_tercero` = `tercero`.`identificacion`))) join `tipo_naturaleza` on((`tipo_comprobante`.`id_naturaleza` = `tipo_naturaleza`.`id`)));

-- ----------------------------
-- View structure for stock_general
-- ----------------------------
DROP VIEW IF EXISTS `stock_general`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `stock_general` AS select `producto`.`id` AS `id`,`producto`.`nombre` AS `producto`,`tipo_comprobante`.`id_naturaleza` AS `naturaleza`,`tipo_comprobante`.`nombre` AS `movimiento`,`maestro_movimiento`.`creado` AS `creado`,`tercero`.`nombre` AS `persona`,`detalle_movimiento`.`cantidad` AS `cantidad` from ((((`detalle_movimiento` join `maestro_movimiento` on((`detalle_movimiento`.`id_maestro_movimiento` = `maestro_movimiento`.`id`))) join `producto` on((`detalle_movimiento`.`id_producto` = `producto`.`id`))) join `tipo_comprobante` on((`maestro_movimiento`.`id_tipo_comprobante` = `tipo_comprobante`.`id`))) join `tercero` on((`maestro_movimiento`.`identificacion_tercero` = `tercero`.`identificacion`))) where ((`tipo_comprobante`.`id_naturaleza` in (1,2)) and isnull(`maestro_movimiento`.`eliminado`)) order by `maestro_movimiento`.`creado` desc;

-- ----------------------------
-- View structure for stock_movimiento
-- ----------------------------
DROP VIEW IF EXISTS `stock_movimiento`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `stock_movimiento` AS select `tipo_naturaleza`.`nombre` AS `naturaleza`,`producto`.`nombre` AS `producto`,`producto`.`serial` AS `serial`,sum(`detalle_movimiento`.`cantidad`) AS `cantidad` from ((((`maestro_movimiento` join `detalle_movimiento` on((`detalle_movimiento`.`id_maestro_movimiento` = `maestro_movimiento`.`id`))) join `producto` on((`detalle_movimiento`.`id_producto` = `producto`.`id`))) join `tipo_comprobante` on((`maestro_movimiento`.`id_tipo_comprobante` = `tipo_comprobante`.`id`))) join `tipo_naturaleza` on((`tipo_comprobante`.`id_naturaleza` = `tipo_naturaleza`.`id`))) group by `producto`,`naturaleza`;

-- ----------------------------
-- View structure for ventas
-- ----------------------------
DROP VIEW IF EXISTS `ventas`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `ventas` AS select sum(`maestro_movimiento`.`total`) AS `total`,cast(`maestro_movimiento`.`creado` as date) AS `mes` from (`maestro_movimiento` join `tipo_comprobante` on((`maestro_movimiento`.`id_tipo_comprobante` = `tipo_comprobante`.`id`))) where ((`tipo_comprobante`.`id` = 4) and isnull(`maestro_movimiento`.`eliminado`) and (month(`maestro_movimiento`.`creado`) = month(now()))) group by month(`maestro_movimiento`.`creado`);

-- ----------------------------
-- View structure for view_cliente
-- ----------------------------
DROP VIEW IF EXISTS `view_cliente`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `view_cliente` AS select `tercero`.`nombre` AS `nombre`,`tercero`.`id` AS `id`,`tipo_tercero`.`nombre` AS `tipo_tercero`,`tercero`.`telefono` AS `telefono`,`tercero`.`identificacion` AS `identificacion`,`tercero`.`email` AS `email`,`tercero`.`ciudad` AS `ciudad` from (`tercero` join `tipo_tercero` on((`tercero`.`id_tipo_tercero` = `tipo_tercero`.`id`))) where (`tipo_tercero`.`id` = 3);

-- ----------------------------
-- View structure for view_proveedor
-- ----------------------------
DROP VIEW IF EXISTS `view_proveedor`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `view_proveedor` AS select `tercero`.`nombre` AS `nombre`,`tercero`.`id` AS `id`,`tipo_tercero`.`nombre` AS `tipo_tercero`,`tercero`.`telefono` AS `telefono`,`tercero`.`identificacion` AS `identificacion`,`tercero`.`email` AS `email`,`tercero`.`ciudad` AS `ciudad`,`tercero`.`id_tipo_tercero` AS `id_tipo_tercero` from (`tercero` join `tipo_tercero` on((`tercero`.`id_tipo_tercero` = `tipo_tercero`.`id`))) where (`tipo_tercero`.`id` = 2);

SET FOREIGN_KEY_CHECKS = 1;

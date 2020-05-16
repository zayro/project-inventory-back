/*
Navicat MariaDB Data Transfer

Source Server         : local mariadb
Source Server Version : 100122
Source Host           : localhost:3307
Source Database       : acceso

Target Server Type    : MariaDB
Target Server Version : 100122
File Encoding         : 65001

Date: 2019-04-12 20:12:14
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(249) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `verified` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `resettable` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `roles_mask` int(10) unsigned NOT NULL DEFAULT '0',
  `registered` int(10) unsigned NOT NULL,
  `last_login` int(10) unsigned DEFAULT NULL,
  `force_logout` mediumint(7) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'marlon@tipcolombia.com', '$2y$10$s5aEKQZFZHVC7x2AMuFHMOqR6zWhGzN7yKcBmBOTT8BrhVo0ifXUm', 'zayro', '0', '1', '1', '1', '1532795515', '1544109798', '0');
INSERT INTO `users` VALUES ('2', 'demo@tipcolombia.com', '$2y$10$Ea9JHTusZ36DxZu/otr2Y.gBYlKO.rieHhapzKMj0HOuaa.xM.KoK', 'demo', '0', '1', '1', '16', '1536006150', '1540326051', '0');
INSERT INTO `users` VALUES ('3', 'test@tipcolombia.com', '$2y$10$VasYINvoyNmFmmmFfU0EluX2IytfLaOuTafDFKQ64jjOUrwCqNkvi', 'test', '0', '1', '1', '5', '1540326118', '1542817035', '0');
INSERT INTO `users` VALUES ('4', 'olga@tipcolombia.com', '$2y$10$Jx3fDiB.h4GxsUap4TRRhO9IWDxC7juvngWyTPvKUwknxyx1CGYny', 'olga', '0', '1', '1', '1', '1544107223', '1544107313', '0');

-- ----------------------------
-- Table structure for users_confirmations
-- ----------------------------
DROP TABLE IF EXISTS `users_confirmations`;
CREATE TABLE `users_confirmations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `email` varchar(249) COLLATE utf8mb4_unicode_ci NOT NULL,
  `selector` varchar(16) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `selector` (`selector`),
  KEY `email_expires` (`email`,`expires`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users_confirmations
-- ----------------------------

-- ----------------------------
-- Table structure for users_menu
-- ----------------------------
DROP TABLE IF EXISTS `users_menu`;
CREATE TABLE `users_menu` (
  `id_users_menu` int(11) NOT NULL,
  `menu` varchar(50) NOT NULL,
  `link` varchar(50) NOT NULL,
  `order_menu` int(3) NOT NULL,
  PRIMARY KEY (`id_users_menu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users_menu
-- ----------------------------
INSERT INTO `users_menu` VALUES ('1', 'MENU.sampling.title', 'table-export', '5');
INSERT INTO `users_menu` VALUES ('2', 'MENU.species.title', 'species', '8');
INSERT INTO `users_menu` VALUES ('3', 'test', 'test', '-100');
INSERT INTO `users_menu` VALUES ('4', 'home', 'home', '1');
INSERT INTO `users_menu` VALUES ('5', 'MENU.audit.title', 'audit', '-1');
INSERT INTO `users_menu` VALUES ('6', 'MENU.project.title', 'projects', '2');
INSERT INTO `users_menu` VALUES ('7', 'MENU.biozone.title', 'biozone', '6');
INSERT INTO `users_menu` VALUES ('8', 'MENU.basins.title', 'basin', '3');
INSERT INTO `users_menu` VALUES ('9', 'MENU.location.title', 'location', '4');
INSERT INTO `users_menu` VALUES ('10', 'MENU.import.title', 'import', '100');
INSERT INTO `users_menu` VALUES ('11', 'MENU.formations.title', 'formations', '7');
INSERT INTO `users_menu` VALUES ('12', 'MENU.samples.title', 'samples', '4');
INSERT INTO `users_menu` VALUES ('13', 'MENU.type_species.title', 'type_species', '0');
INSERT INTO `users_menu` VALUES ('14', 'MENU.residuos.title', 'residuos', '10');
INSERT INTO `users_menu` VALUES ('15', 'MENU.plates.title', 'plates', '9');
INSERT INTO `users_menu` VALUES ('16', 'MENU. finished_samples.title', 'finished_samples', '0');

-- ----------------------------
-- Table structure for users_privileges
-- ----------------------------
DROP TABLE IF EXISTS `users_privileges`;
CREATE TABLE `users_privileges` (
  `id_users_privileges` int(11) NOT NULL AUTO_INCREMENT,
  `id_users_roles` int(11) NOT NULL,
  `id_users_menu` int(11) NOT NULL,
  PRIMARY KEY (`id_users_privileges`),
  UNIQUE KEY `id_users_roles_2` (`id_users_roles`,`id_users_menu`),
  KEY `id_users_roles` (`id_users_roles`,`id_users_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users_privileges
-- ----------------------------
INSERT INTO `users_privileges` VALUES ('1', '1', '1');
INSERT INTO `users_privileges` VALUES ('2', '1', '2');
INSERT INTO `users_privileges` VALUES ('4', '1', '4');
INSERT INTO `users_privileges` VALUES ('6', '1', '6');
INSERT INTO `users_privileges` VALUES ('7', '1', '7');
INSERT INTO `users_privileges` VALUES ('8', '1', '8');
INSERT INTO `users_privileges` VALUES ('9', '1', '9');
INSERT INTO `users_privileges` VALUES ('11', '1', '10');
INSERT INTO `users_privileges` VALUES ('12', '1', '11');
INSERT INTO `users_privileges` VALUES ('27', '1', '12');
INSERT INTO `users_privileges` VALUES ('28', '1', '14');
INSERT INTO `users_privileges` VALUES ('29', '1', '15');
INSERT INTO `users_privileges` VALUES ('15', '5', '1');
INSERT INTO `users_privileges` VALUES ('16', '5', '2');
INSERT INTO `users_privileges` VALUES ('17', '5', '3');
INSERT INTO `users_privileges` VALUES ('18', '5', '4');
INSERT INTO `users_privileges` VALUES ('19', '5', '5');
INSERT INTO `users_privileges` VALUES ('20', '5', '6');
INSERT INTO `users_privileges` VALUES ('21', '5', '7');
INSERT INTO `users_privileges` VALUES ('22', '5', '8');
INSERT INTO `users_privileges` VALUES ('23', '5', '9');
INSERT INTO `users_privileges` VALUES ('24', '5', '10');
INSERT INTO `users_privileges` VALUES ('25', '5', '11');
INSERT INTO `users_privileges` VALUES ('26', '5', '12');

-- ----------------------------
-- Table structure for users_remembered
-- ----------------------------
DROP TABLE IF EXISTS `users_remembered`;
CREATE TABLE `users_remembered` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `selector` varchar(24) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `selector` (`selector`),
  KEY `user` (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users_remembered
-- ----------------------------

-- ----------------------------
-- Table structure for users_resets
-- ----------------------------
DROP TABLE IF EXISTS `users_resets`;
CREATE TABLE `users_resets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `selector` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `selector` (`selector`),
  KEY `user_expires` (`user`,`expires`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users_resets
-- ----------------------------

-- ----------------------------
-- Table structure for users_roles
-- ----------------------------
DROP TABLE IF EXISTS `users_roles`;
CREATE TABLE `users_roles` (
  `id_users_roles` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id_users_roles`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users_roles
-- ----------------------------
INSERT INTO `users_roles` VALUES ('1', 'ADMIN');
INSERT INTO `users_roles` VALUES ('2', 'AUTHOR');
INSERT INTO `users_roles` VALUES ('4', 'CONSULTANT');
INSERT INTO `users_roles` VALUES ('5', 'DEVELOPER');
INSERT INTO `users_roles` VALUES ('16', 'CONSUMER');

-- ----------------------------
-- Table structure for users_throttling
-- ----------------------------
DROP TABLE IF EXISTS `users_throttling`;
CREATE TABLE `users_throttling` (
  `bucket` varchar(44) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `tokens` float unsigned NOT NULL,
  `replenished_at` int(10) unsigned NOT NULL,
  `expires_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`bucket`),
  KEY `expires_at` (`expires_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users_throttling
-- ----------------------------
INSERT INTO `users_throttling` VALUES ('gfpgD6u8OVPqBE3UuiOWEQhatAycxVzxkwxzbp7u598', '498.04', '1536587577', '1536760377');
INSERT INTO `users_throttling` VALUES ('Jjl8HEbTSJpZBWoyXOajJXqciuUdngUbah061jwhliE', '18.0078', '1536587577', '1536623577');
INSERT INTO `users_throttling` VALUES ('ejWtPDKvxt-q7LZ3mFjzUoIWKJYzu47igC8Jd9mffFk', '72.3403', '1544109798', '1544649798');
INSERT INTO `users_throttling` VALUES ('QduM75nGblH2CDKFyk0QeukPOwuEVDAUFE54ITnHM38', '67.2453', '1537816876', '1538356876');

-- ----------------------------
-- View structure for view_privileges
-- ----------------------------
DROP VIEW IF EXISTS `view_privileges`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `view_privileges` AS select `u`.`id` AS `id`,`u`.`username` AS `username`,`u`.`email` AS `email`,`ur`.`name` AS `name`,`um`.`menu` AS `menu`,`um`.`link` AS `link` from (((`users` `u` join `users_roles` `ur` on((`ur`.`id_users_roles` = `u`.`roles_mask`))) join `users_privileges` `up` on((`up`.`id_users_roles` = `ur`.`id_users_roles`))) join `users_menu` `um` on((`um`.`id_users_menu` = `up`.`id_users_menu`))) order by `um`.`order_menu` ; ;
SET FOREIGN_KEY_CHECKS=1;

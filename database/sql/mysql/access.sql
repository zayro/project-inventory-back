-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.16 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Volcando estructura para tabla access.users
CREATE TABLE IF NOT EXISTS `users` (
  `id_users` int(11) NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_users`),
  UNIQUE KEY `users_id_users_unique` (`id_users`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Volcando datos para la tabla access.users: ~12 rows (aproximadamente)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
REPLACE INTO `users` (`id_users`, `username`, `email`, `password`, `created_at`, `updated_at`) VALUES
	(1, 'zayros', 'marlon@tipcolombia.com', '$2y$10$hm0IkIoVec8Bbb9nPW4XoeC/2A/xlFF5XCTJX1d.w2Bp/dmNd9jGK', '2019-03-24 01:57:59', '2019-03-24 01:57:59'),
	(7, 'xbruen', 'stracke.floy@gmail.com', '$2y$10$bijZ7YpysDXr47X.rlaRS..3I9XfjkFEQkAkGF4UVw40hpuNARUjW', '2019-03-24 01:50:51', '2019-03-24 01:50:51'),
	(10, 'zayro', 'zayro8905@gmail.com', '$2y$10$6LxlgY1/hQQ8oSwf9JC7GuOMpc94jVRsxEczr8Fn25W2iI3AvmPma', '2020-04-25 00:10:23', '2020-04-25 00:10:24'),
	(63, 'uhirthe', 'bartholome.wintheiser@vandervort.com', '$2y$10$OB3RYuzbzCIh01fHqgn6C.DK7nqUhKbJHWW2gxktfoF3heWI7iRrq', '2019-03-24 01:50:51', '2019-03-24 01:50:51'),
	(29680, 'shanon62', 'xparisian@hotmail.com', '$2y$10$fIaQ92cIdXzFcCxglzHX7.NfuT6Ei8xgnCPLzZLEviBZbEIRXn90S', '2019-03-24 01:50:50', '2019-03-24 01:50:50'),
	(33561, 'verla.reinger', 'lessie.monahan@yahoo.com', '$2y$10$D1IX0adt1QS8T3YfPKvUWeqJxAGJDFv1KgoicHQ24PLv7maXw779y', '2019-03-24 01:50:51', '2019-03-24 01:50:51'),
	(61222, 'satterfield.jalyn', 'langworth.jonas@hotmail.com', '$2y$10$N9yIysYDShm69vZAHmUit.vF27c0OH8Errj.OuCSU3XOGuT/NwX0.', '2019-03-24 01:50:51', '2019-03-24 01:50:51'),
	(87400, 'rhomenick', 'dmitchell@schmitt.com', '$2y$10$fTpu/Sk4TTP8QvwoMlo0oe0FUH2jlRFtkCANMSl4It8bIiEvqJKqG', '2019-03-24 01:50:51', '2019-03-24 01:50:51'),
	(7215715, 'nedra50', 'harber.gwendolyn@white.net', '$2y$10$0ns3OOnbVuX7s2jt2E.1ouU/TEJkpKjNihVLwGFA8T8sUbmyZ5yKa', '2019-03-24 01:50:51', '2019-03-24 01:50:51'),
	(74580478, 'zrohan', 'irma.flatley@vonrueden.net', '$2y$10$.3nZppsG9cz0RCfWSNEh9e7rX/tK.KUKutrGorJbfcR4uvkE8xxUy', '2019-03-24 01:50:51', '2019-03-24 01:50:51'),
	(861461762, 'arlie.bergstrom', 'theo.johns@gmail.com', '$2y$10$lKZ0OGYpyNdQ8rm5M3YbE.tz5MQpfYfhygG3HX3UPACFX7zEdFK9S', '2019-03-24 01:50:51', '2019-03-24 01:50:51'),
	(954799259, 'verdie.rogahn', 'pdavis@glover.com', '$2y$10$HsdkQ.j86rWA97EOyLriU.5kwlP0fUTeOr73Q8tY4dzf2ZLKCdguO', '2019-03-24 01:50:51', '2019-03-24 01:50:51');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Volcando estructura para tabla access.users_information
CREATE TABLE IF NOT EXISTS `users_information` (
  `id_users_information` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `phone` int(10) DEFAULT NULL,
  PRIMARY KEY (`id_users_information`,`id_users`),
  KEY `id_users` (`id_users`),
  CONSTRAINT `users_information_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla access.users_information: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `users_information` DISABLE KEYS */;
REPLACE INTO `users_information` (`id_users_information`, `id_users`, `first_name`, `last_name`, `phone`) VALUES
	(1, 10, 'MARLON', 'ARIAS', 301319930);
/*!40000 ALTER TABLE `users_information` ENABLE KEYS */;

-- Volcando estructura para tabla access.users_menu
CREATE TABLE IF NOT EXISTS `users_menu` (
  `id_users_menu` int(11) NOT NULL,
  `menu` varchar(50) NOT NULL,
  `link` varchar(50) NOT NULL,
  `order_menu` int(3) NOT NULL,
  `icon` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_users_menu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla access.users_menu: ~10 rows (aproximadamente)
/*!40000 ALTER TABLE `users_menu` DISABLE KEYS */;
REPLACE INTO `users_menu` (`id_users_menu`, `menu`, `link`, `order_menu`, `icon`) VALUES
	(1, 'config', 'config', -100, 'settings'),
	(2, 'home', 'home', -2, 'home'),
	(3, 'auditoria', 'audit', -1, 'security'),
	(4, 'compras', 'compras', 1, 'shopping_cart'),
	(5, 'ventas', 'ventas', 2, 'receipt'),
	(6, 'productos', 'productos', 3, 'extension'),
	(7, 'reportes', 'reportes', 4, 'bar_chart'),
	(8, 'clientes', 'clientes', 5, 'people'),
	(9, 'proveedores', 'proveedores', 6, 'airport_shuttle'),
	(11, 'consultas', 'consultas', 8, '');
/*!40000 ALTER TABLE `users_menu` ENABLE KEYS */;

-- Volcando estructura para tabla access.users_menu_level_one
CREATE TABLE IF NOT EXISTS `users_menu_level_one` (
  `id_users_menu_level_one` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_users_menu` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_users_menu_level_one`),
  KEY `users_menu_level_one_fk` (`id_users_menu`),
  CONSTRAINT `users_menu_level_one_fk` FOREIGN KEY (`id_users_menu`) REFERENCES `users_menu` (`id_users_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla access.users_menu_level_one: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `users_menu_level_one` DISABLE KEYS */;
REPLACE INTO `users_menu_level_one` (`id_users_menu_level_one`, `id_users_menu`, `name`) VALUES
	(1, 11, 'extracto de facturas'),
	(2, 11, 'informe general');
/*!40000 ALTER TABLE `users_menu_level_one` ENABLE KEYS */;

-- Volcando estructura para tabla access.users_privileges
CREATE TABLE IF NOT EXISTS `users_privileges` (
  `id_users_privileges` int(11) NOT NULL AUTO_INCREMENT,
  `id_users_roles` int(11) NOT NULL,
  `id_users_menu` int(11) NOT NULL,
  PRIMARY KEY (`id_users_privileges`,`id_users_roles`,`id_users_menu`),
  KEY `id_users_roles` (`id_users_roles`),
  KEY `id_users_menu` (`id_users_menu`),
  CONSTRAINT `users_privileges_ibfk_1` FOREIGN KEY (`id_users_menu`) REFERENCES `users_menu` (`id_users_menu`),
  CONSTRAINT `users_privileges_ibfk_2` FOREIGN KEY (`id_users_roles`) REFERENCES `users_roles` (`id_users_roles`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla access.users_privileges: ~9 rows (aproximadamente)
/*!40000 ALTER TABLE `users_privileges` DISABLE KEYS */;
REPLACE INTO `users_privileges` (`id_users_privileges`, `id_users_roles`, `id_users_menu`) VALUES
	(1, 5, 1),
	(2, 5, 2),
	(3, 5, 3),
	(4, 5, 4),
	(5, 5, 5),
	(6, 5, 6),
	(7, 5, 7),
	(8, 5, 8),
	(9, 5, 9);
/*!40000 ALTER TABLE `users_privileges` ENABLE KEYS */;

-- Volcando estructura para tabla access.users_roles
CREATE TABLE IF NOT EXISTS `users_roles` (
  `id_users_roles` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id_users_roles`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla access.users_roles: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `users_roles` DISABLE KEYS */;
REPLACE INTO `users_roles` (`id_users_roles`, `name`) VALUES
	(1, 'ADMIN'),
	(2, 'AUTHOR'),
	(4, 'CONSULTANT'),
	(5, 'DEVELOPER'),
	(16, 'CONSUMER');
/*!40000 ALTER TABLE `users_roles` ENABLE KEYS */;

-- Volcando estructura para tabla access.users_validation
CREATE TABLE IF NOT EXISTS `users_validation` (
  `id_users_validation` int(11) NOT NULL,
  `id_users_roles` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `verified` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_users_validation`,`id_users_roles`,`id_users`),
  KEY `id_users_roles` (`id_users_roles`),
  KEY `users_validation_id_users_fk` (`id_users`),
  CONSTRAINT `users_validation_id_users_fk` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `users_validation_id_users_roles_fk` FOREIGN KEY (`id_users_roles`) REFERENCES `users_roles` (`id_users_roles`) ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla access.users_validation: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `users_validation` DISABLE KEYS */;
REPLACE INTO `users_validation` (`id_users_validation`, `id_users_roles`, `id_users`, `status`, `verified`) VALUES
	(1, 5, 10, 1, 1);
/*!40000 ALTER TABLE `users_validation` ENABLE KEYS */;

-- Volcando estructura para vista access.view_information_users
-- Creando tabla temporal para superar errores de dependencia de VIEW
CREATE TABLE `view_information_users` (
	`username` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
	`email` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
	`first_name` VARCHAR(255) NULL COLLATE 'utf8_general_ci',
	`last_name` VARCHAR(255) NULL COLLATE 'utf8_general_ci',
	`phone` INT(10) NULL
) ENGINE=MyISAM;

-- Volcando estructura para vista access.view_menu
-- Creando tabla temporal para superar errores de dependencia de VIEW
CREATE TABLE `view_menu` (
	`id` INT(11) NOT NULL,
	`username` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
	`email` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
	`name` VARCHAR(100) NOT NULL COLLATE 'utf8_general_ci',
	`menu` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`link` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`icon` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;

-- Volcando estructura para vista access.view_menus
-- Creando tabla temporal para superar errores de dependencia de VIEW
CREATE TABLE `view_menus` (
	`id` INT(11) NOT NULL,
	`username` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
	`email` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
	`name` VARCHAR(100) NOT NULL COLLATE 'utf8_general_ci',
	`menu` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`link` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`icon` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;

-- Volcando estructura para vista access.view_privileges
-- Creando tabla temporal para superar errores de dependencia de VIEW
CREATE TABLE `view_privileges` (
	`id` INT(11) NOT NULL,
	`username` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
	`email` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
	`name` VARCHAR(100) NOT NULL COLLATE 'utf8_general_ci',
	`menu` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`link` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`icon` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;

-- Volcando estructura para vista access.view_submenus
-- Creando tabla temporal para superar errores de dependencia de VIEW
CREATE TABLE `view_submenus` (
	`id` INT(11) NOT NULL,
	`username` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
	`email` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
	`name` VARCHAR(100) NOT NULL COLLATE 'utf8_general_ci',
	`menu` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`link` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`submenu1` VARCHAR(50) NULL COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;

-- Volcando estructura para vista access.view_information_users
-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `view_information_users`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_information_users` AS select `users`.`username` AS `username`,`users`.`email` AS `email`,`users_information`.`first_name` AS `first_name`,`users_information`.`last_name` AS `last_name`,`users_information`.`phone` AS `phone` from (`users` join `users_information` on((`users_information`.`id_users` = `users`.`id_users`)));

-- Volcando estructura para vista access.view_menu
-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `view_menu`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_menu` AS select `u`.`id_users` AS `id`,`u`.`username` AS `username`,`u`.`email` AS `email`,`ur`.`name` AS `name`,`um`.`menu` AS `menu`,`um`.`link` AS `link`,`um`.`icon` AS `icon` from ((((`users` `u` join `users_validation` `uv` on((`uv`.`id_users` = `u`.`id_users`))) join `users_roles` `ur` on((`ur`.`id_users_roles` = `uv`.`id_users_roles`))) join `users_privileges` `up` on((`up`.`id_users_roles` = `ur`.`id_users_roles`))) join `users_menu` `um` on((`um`.`id_users_menu` = `up`.`id_users_menu`))) order by `um`.`order_menu`;

-- Volcando estructura para vista access.view_menus
-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `view_menus`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_menus` AS select `u`.`id_users` AS `id`,`u`.`username` AS `username`,`u`.`email` AS `email`,`ur`.`name` AS `name`,`um`.`menu` AS `menu`,`um`.`link` AS `link`,`um`.`icon` AS `icon` from ((((`users` `u` join `users_validation` `uv` on((`uv`.`id_users` = `u`.`id_users`))) join `users_roles` `ur` on((`ur`.`id_users_roles` = `uv`.`id_users_roles`))) join `users_privileges` `up` on((`up`.`id_users_roles` = `ur`.`id_users_roles`))) join `users_menu` `um` on((`um`.`id_users_menu` = `up`.`id_users_menu`))) order by `um`.`order_menu`;

-- Volcando estructura para vista access.view_privileges
-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `view_privileges`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_privileges` AS select `u`.`id_users` AS `id`,`u`.`username` AS `username`,`u`.`email` AS `email`,`ur`.`name` AS `name`,`um`.`menu` AS `menu`,`um`.`link` AS `link`,`um`.`icon` AS `icon` from ((((`users` `u` join `users_validation` `uv` on((`uv`.`id_users` = `u`.`id_users`))) join `users_roles` `ur` on((`ur`.`id_users_roles` = `uv`.`id_users_roles`))) join `users_privileges` `up` on((`up`.`id_users_roles` = `ur`.`id_users_roles`))) join `users_menu` `um` on((`um`.`id_users_menu` = `up`.`id_users_menu`))) order by `um`.`order_menu`;

-- Volcando estructura para vista access.view_submenus
-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `view_submenus`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_submenus` AS select `u`.`id_users` AS `id`,`u`.`username` AS `username`,`u`.`email` AS `email`,`ur`.`name` AS `name`,`um`.`menu` AS `menu`,`um`.`link` AS `link`,`um1`.`name` AS `submenu1` from (((((`users` `u` join `users_validation` `uv` on((`uv`.`id_users` = `u`.`id_users`))) join `users_roles` `ur` on((`ur`.`id_users_roles` = `uv`.`id_users_roles`))) join `users_privileges` `up` on((`up`.`id_users_roles` = `ur`.`id_users_roles`))) join `users_menu` `um` on((`um`.`id_users_menu` = `up`.`id_users_menu`))) left join `users_menu_level_one` `um1` on((`um1`.`id_users_menu` = `um`.`id_users_menu`))) order by `um`.`order_menu`;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

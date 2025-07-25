-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour gestion_pret_pc
CREATE DATABASE IF NOT EXISTS `gestion_pret_pc` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `gestion_pret_pc`;

-- Listage de la structure de table gestion_pret_pc. pcs
CREATE TABLE IF NOT EXISTS `pcs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `numero_serie` varchar(50) NOT NULL,
  `status` enum('disponible','réservé','en prêt','en réparation','en attente') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'disponible',
  `date_debut` date DEFAULT NULL,
  `date_retour` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `numero_serie` (`numero_serie`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table gestion_pret_pc.pcs : ~41 rows (environ)
INSERT INTO `pcs` (`id`, `numero_serie`, `status`, `date_debut`, `date_retour`) VALUES
	(43, 'PC-buro-101', 'en réparation', NULL, NULL),
	(45, 'PC-buro-102', 'réservé', NULL, NULL),
	(46, 'PC-buro-103', 'réservé', NULL, NULL),
	(47, 'PC-buro-104', 'réservé', NULL, NULL),
	(48, 'PC-buro-105', 'en réparation', NULL, NULL),
	(49, 'PC-buro-106', 'disponible', NULL, NULL),
	(50, 'PC-buro-107', 'disponible', NULL, NULL),
	(51, 'PC-buro-108', 'disponible', NULL, NULL),
	(52, 'PC-buro-109', 'réservé', NULL, NULL),
	(53, 'PC-buro-110', 'réservé', NULL, NULL),
	(54, 'PC-buro-111', 'disponible', NULL, NULL),
	(56, 'PC-buro-113', 'réservé', NULL, NULL),
	(57, 'PC-buro-114', 'disponible', NULL, NULL),
	(58, 'PC-buro-115', 'disponible', NULL, NULL),
	(59, 'PC-buro-116', 'disponible', NULL, NULL),
	(60, 'PC-buro-117', 'réservé', NULL, NULL),
	(61, 'PC-buro-118', 'disponible', NULL, NULL),
	(86, 'PC-graph-501', 'disponible', NULL, NULL),
	(87, 'PC-graph-502', 'disponible', NULL, NULL),
	(88, 'PC-graph-503', 'disponible', NULL, NULL),
	(89, 'PC-graph-504', 'disponible', NULL, NULL),
	(90, 'PC-graph-505', 'disponible', NULL, NULL),
	(91, 'PC-graph-506', 'disponible', NULL, NULL),
	(92, 'PC-graph-507', 'en réparation', NULL, NULL),
	(93, 'PC-graph-508', 'en réparation', NULL, NULL),
	(94, 'PC-graph-509', 'disponible', NULL, NULL),
	(95, 'PC-graph-510', 'disponible', NULL, NULL),
	(96, 'PC-graph-511', 'disponible', NULL, NULL),
	(97, 'PC-graph-512', 'réservé', NULL, NULL),
	(98, 'PC-graph-513', 'réservé', NULL, NULL),
	(99, 'PC-graph-514', 'réservé', NULL, NULL),
	(100, 'PC-graph-515', 'disponible', NULL, NULL),
	(101, 'PC-graph-516', 'disponible', NULL, NULL),
	(102, 'PC-graph-701', 'disponible', NULL, NULL),
	(103, 'PC-graph-702', 'disponible', NULL, NULL),
	(104, 'PC-graph-703', 'disponible', NULL, NULL),
	(105, 'PC-TEST-801', 'disponible', NULL, NULL),
	(106, 'PC-TEST-802', 'disponible', NULL, NULL),
	(107, 'PC-TEST-803', 'disponible', NULL, NULL),
	(108, 'PC-TEST-804', 'disponible', NULL, NULL),
	(109, 'PC-TEST-805', 'disponible', NULL, NULL),
	(110, 'PC-TEST-901', 'disponible', NULL, NULL),
	(111, 'PC-TEST-902', 'disponible', NULL, NULL),
	(112, 'PC-TEST-903', 'disponible', NULL, NULL),
	(113, 'PC-TEST-904', 'disponible', NULL, NULL),
	(114, 'PC-TEST-905', 'disponible', NULL, NULL);

-- Listage de la structure de table gestion_pret_pc. reservations
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `id_pc` int NOT NULL,
  `date_debut` datetime DEFAULT NULL,
  `date_retour` datetime NOT NULL,
  `status` enum('en attente','validé','rendu','annulé','réservé','en réparation','disponible','en prêt') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'en attente',
  `validated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=155 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table gestion_pret_pc.reservations : ~126 rows (environ)
INSERT INTO `reservations` (`id`, `id_user`, `id_pc`, `date_debut`, `date_retour`, `status`, `validated_by`) VALUES
	(5, 2, 2, '2025-02-13 14:56:04', '2025-02-13 15:56:04', 'rendu', NULL),
	(6, 2, 1, '2025-02-13 15:10:05', '2025-02-13 16:10:05', 'rendu', NULL),
	(7, 2, 3, '2025-02-15 15:20:00', '2025-02-15 15:20:00', 'disponible', NULL),
	(8, 2, 4, '2025-02-14 15:39:00', '2025-02-22 15:39:00', 'rendu', NULL),
	(9, 2, 5, '2025-02-13 15:43:00', '2025-02-15 15:43:00', 'rendu', NULL),
	(10, 2, 3, '2025-02-12 10:00:00', '2025-02-12 12:00:00', 'disponible', NULL),
	(11, 2, 6, '2025-02-15 10:38:00', '2025-02-18 10:38:00', 'rendu', NULL),
	(12, 2, 7, '2025-02-14 11:12:00', '2025-02-15 11:12:00', 'annulé', NULL),
	(13, 2, 7, '2025-02-15 11:28:00', '2025-02-16 11:28:00', 'annulé', NULL),
	(14, 2, 9, '2025-02-17 11:40:00', '2025-02-18 11:40:00', 'annulé', NULL),
	(15, 2, 10, '2025-02-14 14:54:00', '2025-02-15 14:54:00', 'annulé', NULL),
	(16, 2, 11, '2025-02-14 15:12:00', '2025-02-15 15:12:00', 'rendu', NULL),
	(17, 2, 14, '2025-02-14 15:15:00', '2025-02-15 15:15:00', 'annulé', NULL),
	(18, 2, 15, '2025-02-14 15:16:00', '2025-02-15 15:16:00', 'annulé', NULL),
	(19, 2, 14, '2025-02-14 15:25:00', '2025-02-21 15:25:00', 'annulé', NULL),
	(20, 2, 16, '2025-02-14 15:25:00', '2025-02-21 15:25:00', 'annulé', NULL),
	(21, 2, 18, '2025-02-14 15:30:00', '2025-02-15 15:30:00', 'annulé', NULL),
	(22, 2, 19, '2025-02-14 15:31:00', '2025-02-21 17:31:00', 'annulé', NULL),
	(23, 2, 13, '2025-02-15 18:22:00', '2025-02-18 18:22:00', 'annulé', NULL),
	(24, 2, 24, '2025-02-15 18:25:00', '2025-02-16 18:25:00', 'annulé', NULL),
	(25, 2, 20, '2025-02-15 10:00:00', '2025-02-18 16:30:00', 'annulé', NULL),
	(26, 2, 6, '2025-02-16 11:56:00', '2025-03-02 11:56:00', 'annulé', NULL),
	(27, 2, 12, '2025-02-21 11:56:00', '2025-03-09 11:56:00', 'rendu', NULL),
	(28, 2, 18, '2025-02-20 11:59:00', '2025-02-22 12:00:00', 'rendu', NULL),
	(29, 2, 6, '2025-02-17 16:24:00', '2025-02-18 16:24:00', 'disponible', NULL),
	(30, 2, 7, '2025-02-18 16:24:00', '2025-02-19 16:24:00', 'rendu', NULL),
	(31, 2, 8, '2025-02-16 16:25:00', '2025-02-18 16:25:00', 'disponible', NULL),
	(32, 2, 19, '2025-02-16 16:27:00', '2025-02-17 16:27:00', 'disponible', NULL),
	(33, 2, 20, '2025-02-16 16:28:00', '2025-02-17 16:28:00', 'annulé', NULL),
	(34, 2, 23, '2025-02-16 16:41:00', '2025-02-17 16:41:00', 'annulé', NULL),
	(35, 2, 24, '2025-02-17 16:41:00', '2025-02-18 16:41:00', 'annulé', NULL),
	(36, 2, 9, '2025-02-16 16:43:00', '2025-02-19 16:43:00', 'annulé', NULL),
	(37, 2, 10, '2025-02-23 16:43:00', '2025-02-28 16:43:00', 'annulé', NULL),
	(38, 2, 11, '2025-02-18 16:43:00', '2025-02-20 16:43:00', 'rendu', NULL),
	(39, 2, 14, '2025-02-16 16:43:00', '2025-02-17 16:43:00', 'annulé', NULL),
	(40, 2, 15, '2025-02-16 16:55:00', '2025-02-18 16:55:00', 'annulé', NULL),
	(41, 2, 16, '2025-02-18 16:55:00', '2025-02-20 16:55:00', 'annulé', NULL),
	(42, 2, 9, '2025-02-16 17:01:00', '2025-02-17 17:01:00', 'annulé', NULL),
	(43, 2, 10, '2025-02-17 17:01:00', '2025-02-18 17:01:00', 'annulé', NULL),
	(44, 2, 20, '2025-02-17 17:36:00', '2025-02-28 17:36:00', 'annulé', NULL),
	(45, 2, 24, '2025-02-22 17:37:00', '2025-02-28 17:37:00', 'annulé', NULL),
	(46, 2, 15, '2025-02-16 17:43:00', '2025-02-23 17:43:00', 'annulé', NULL),
	(47, 2, 23, '2025-02-16 17:43:00', '2025-02-19 17:43:00', 'annulé', NULL),
	(48, 2, 13, '2025-02-16 17:48:00', '2025-02-19 17:48:00', 'annulé', NULL),
	(49, 2, 13, '2025-02-21 17:49:00', '2025-02-28 17:49:00', 'annulé', NULL),
	(50, 2, 15, '2025-02-18 17:49:00', '2025-02-20 17:49:00', 'annulé', NULL),
	(51, 2, 2, '2025-02-16 18:30:00', '2025-02-19 18:31:00', 'annulé', NULL),
	(52, 2, 5, '2025-02-19 18:31:00', '2025-03-01 18:31:00', 'annulé', NULL),
	(53, 2, 6, '2025-02-19 18:31:00', '2025-02-28 18:32:00', 'annulé', NULL),
	(54, 2, 4, '2025-02-17 20:48:00', '2025-02-18 20:48:00', 'annulé', NULL),
	(55, 2, 9, '2025-02-20 20:48:00', '2025-02-28 20:48:00', 'annulé', NULL),
	(56, 2, 12, '2025-02-21 10:17:00', '2025-02-22 10:17:00', 'annulé', NULL),
	(57, 2, 22, '2025-02-21 10:23:00', '2025-02-22 10:23:00', 'annulé', NULL),
	(58, 2, 18, '2025-02-21 12:13:00', '2025-02-24 12:13:00', 'annulé', NULL),
	(59, 2, 25, '2025-02-21 15:33:00', '2025-03-01 15:33:00', 'annulé', NULL),
	(60, 2, 18, '2025-02-21 15:46:00', '2025-02-22 15:46:00', 'annulé', NULL),
	(61, 2, 25, '2025-02-21 15:47:00', '2025-02-22 15:47:00', 'annulé', NULL),
	(62, 2, 13, '2025-02-21 16:01:00', '2025-02-28 16:01:00', 'rendu', NULL),
	(63, 2, 10, '2025-02-21 16:11:00', '2025-03-02 16:11:00', 'annulé', NULL),
	(64, 2, 10, '2025-02-22 08:50:00', '2025-02-26 08:50:00', 'rendu', NULL),
	(65, 2, 2, '2025-02-22 09:41:00', '2025-03-02 09:41:00', 'rendu', NULL),
	(66, 2, 2, '2025-02-22 09:57:00', '2025-02-28 09:57:00', 'rendu', NULL),
	(67, 2, 2, '2025-02-26 09:57:00', '2025-03-07 09:57:00', 'validé', NULL),
	(68, 2, 4, '2025-02-22 09:58:00', '2025-03-07 09:58:00', 'rendu', NULL),
	(69, 2, 2, '2025-02-21 13:02:00', '2025-03-01 13:02:00', 'annulé', NULL),
	(70, 2, 2, '2025-02-26 13:02:00', '2025-03-01 13:02:00', 'annulé', NULL),
	(72, 2, 2, '2025-02-22 13:05:00', '2025-03-09 13:05:00', 'annulé', NULL),
	(73, 2, 6, '2025-02-22 13:06:00', '2025-02-28 13:06:00', 'rendu', NULL),
	(74, 2, 6, '2025-02-21 13:07:00', '2025-03-01 13:07:00', 'rendu', NULL),
	(76, 2, 9, '2025-02-26 08:56:00', '2025-02-27 08:56:00', 'rendu', NULL),
	(77, 2, 4, '2025-03-04 16:14:00', '2025-03-12 16:14:00', 'annulé', NULL),
	(82, 2, 14, '2025-03-11 16:39:00', '2025-03-14 16:40:00', 'annulé', NULL),
	(83, 2, 4, '2025-03-10 16:42:00', '2025-03-17 16:42:00', 'annulé', NULL),
	(84, 2, 12, '2025-03-11 16:44:00', '2025-03-21 16:44:00', 'rendu', NULL),
	(85, 2, 14, '2025-03-13 16:47:00', '2025-03-22 16:47:00', 'rendu', NULL),
	(86, 2, 14, '2025-03-13 16:47:00', '2025-03-22 16:47:00', 'rendu', NULL),
	(87, 2, 12, '2025-03-28 11:19:00', '2025-04-01 11:19:00', 'annulé', NULL),
	(89, 2, 4, '2025-03-17 13:34:00', '2025-03-18 13:34:00', 'rendu', NULL),
	(90, 2, 4, '2025-03-17 13:36:00', '2025-03-18 13:36:00', 'rendu', NULL),
	(91, 2, 34, '2025-03-18 17:18:00', '2025-03-19 17:18:00', 'annulé', NULL),
	(96, 2, 10, '2025-03-20 18:55:00', '2025-03-21 18:56:00', 'rendu', NULL),
	(97, 2, 5, '2025-03-28 20:30:00', '2025-03-29 20:30:00', 'annulé', NULL),
	(98, 2, 11, '2025-03-20 22:49:00', '2025-03-29 22:49:00', 'rendu', NULL),
	(101, 2, 6, '2025-03-22 08:31:00', '2025-03-23 08:31:00', 'annulé', NULL),
	(102, 2, 28, '2025-03-21 08:46:00', '2025-03-22 08:47:00', 'annulé', NULL),
	(104, 2, 10, '2025-03-25 11:46:00', '2025-03-29 11:46:00', 'annulé', NULL),
	(105, 2, 10, '2025-03-22 17:55:00', '2025-03-30 17:55:00', 'annulé', NULL),
	(106, 2, 33, '2025-03-22 15:08:00', '2025-03-28 15:11:00', 'annulé', NULL),
	(107, 2, 6, '2025-03-23 16:30:00', '2025-03-24 16:30:00', 'annulé', NULL),
	(108, 2, 5, '2025-03-27 10:31:00', '2025-03-29 10:31:00', 'annulé', NULL),
	(109, 2, 6, '2025-03-29 10:31:00', '2025-04-05 10:31:00', 'annulé', NULL),
	(110, 2, 38, '2025-04-08 10:31:00', '2025-04-24 10:31:00', 'annulé', NULL),
	(111, 2, 9, '2025-03-28 10:35:00', '2025-04-06 10:35:00', 'rendu', NULL),
	(113, 2, 10, '2025-03-28 10:36:00', '2025-04-27 10:36:00', 'rendu', NULL),
	(116, 2, 6, '2025-03-31 11:22:00', '2025-04-30 11:22:00', 'annulé', NULL),
	(119, 2, 46, '2025-04-01 18:09:00', '2025-04-06 18:09:00', 'rendu', NULL),
	(121, 2, 53, '2025-04-03 18:09:00', '2025-04-16 18:10:00', 'validé', NULL),
	(123, 2, 6, '2025-04-05 18:10:00', '2025-04-11 18:10:00', 'en attente', NULL),
	(124, 2, 60, '2025-04-06 18:11:00', '2025-04-20 18:11:00', 'validé', NULL),
	(125, 2, 47, '2025-06-07 18:11:00', '2025-06-26 18:11:00', 'validé', NULL),
	(126, 2, 56, '2025-04-12 18:11:00', '2025-04-27 18:11:00', 'validé', NULL),
	(128, 2, 81, '2025-04-02 18:15:00', '2025-04-06 18:15:00', 'annulé', NULL),
	(129, 2, 78, '2025-04-05 18:15:00', '2025-04-20 18:15:00', 'annulé', NULL),
	(130, 2, 54, '2025-04-05 18:15:00', '2025-05-10 18:15:00', 'en attente', NULL),
	(131, 2, 75, '2025-04-06 18:15:00', '2025-05-09 18:15:00', 'annulé', NULL),
	(132, 2, 51, '2025-04-05 18:15:00', '2025-05-07 18:16:00', 'en attente', NULL),
	(133, 2, 43, '2025-03-29 18:19:00', '2025-04-03 18:19:00', 'en attente', NULL),
	(134, 2, 72, '2025-04-05 18:20:00', '2025-04-19 18:20:00', 'annulé', NULL),
	(135, 2, 90, '2025-03-29 18:27:00', '2025-04-04 18:27:00', 'annulé', NULL),
	(136, 2, 98, '2025-04-04 18:27:00', '2025-04-16 18:27:00', 'annulé', NULL),
	(137, 2, 97, '2025-03-30 18:28:00', '2025-04-06 18:28:00', 'validé', NULL),
	(138, 2, 99, '2025-04-06 18:28:00', '2025-05-10 18:28:00', 'validé', NULL),
	(139, 2, 101, '2025-04-13 18:28:00', '2025-05-10 18:28:00', 'en attente', NULL),
	(140, 2, 96, '2025-05-10 18:28:00', '2025-06-07 18:28:00', 'en attente', NULL),
	(141, 2, 86, '2025-04-07 10:51:00', '2025-04-08 10:51:00', 'annulé', NULL),
	(142, 2, 43, '2025-04-07 11:08:00', '2025-04-08 11:08:00', 'en attente', NULL),
	(143, 2, 88, '2025-04-08 10:54:00', '2025-04-09 10:54:00', 'en attente', NULL),
	(144, 3, 45, '2025-04-18 14:21:00', '2025-05-09 14:21:00', 'validé', NULL),
	(145, 5, 45, '2025-04-10 15:54:00', '2025-04-11 15:54:00', 'validé', NULL),
	(146, 3, 52, '2025-04-08 15:58:00', '2025-04-10 15:59:00', 'validé', NULL),
	(147, 3, 98, '2025-04-16 13:58:00', '2025-04-26 13:58:00', 'en prêt', NULL),
	(148, 3, 46, '2025-04-09 15:51:00', '2025-04-10 15:51:00', 'en prêt', NULL),
	(149, 3, 49, '2025-04-16 16:11:00', '2025-04-18 16:11:00', 'rendu', NULL),
	(150, 3, 49, '2025-04-19 10:06:00', '2025-05-03 10:06:00', 'rendu', NULL),
	(151, 3, 86, '2025-06-12 22:01:00', '2025-06-14 22:01:00', 'rendu', NULL),
	(152, 3, 86, '2025-06-13 08:25:00', '2025-06-17 08:25:00', 'annulé', NULL),
	(153, 3, 91, '2025-06-18 14:47:00', '2025-06-19 14:47:00', 'annulé', NULL),
	(154, 3, 88, '2025-06-12 14:51:00', '2025-06-13 14:51:00', 'rendu', NULL);

-- Listage de la structure de table gestion_pret_pc. users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password_hash` varchar(50) DEFAULT NULL,
  `microsoft_id` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `microsoft_id` (`microsoft_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table gestion_pret_pc.users : ~9 rows (environ)
INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `microsoft_id`, `created_at`, `role`, `password`) VALUES
	(1, 'user1', NULL, NULL, NULL, '2025-02-12 10:28:32', 'user', NULL),
	(3, 'user', NULL, NULL, NULL, '2025-04-07 09:17:39', 'user', '$2y$10$1N6cieShtAr983uz9xcyHeLx3WHnP.uR0ENnOcU4uz/ksUyG6BYI.'),
	(4, 'admin', NULL, NULL, NULL, '2025-04-07 09:17:39', 'admin', '$2y$10$lCfTGMLRiKfz5ZUCjAFauuo30dDToYndsTDkaiLAfTpjVnHLlw6uG'),
	(5, 'norum', NULL, NULL, NULL, '2025-04-07 09:36:42', 'user', '$2y$10$xtaU6hhPxuUGVWviZ8/QXuEs3dJyVr2GCbvs/sPN9fWYdyTL2vMum'),
	(7, 'joey', NULL, NULL, NULL, '2025-04-07 09:54:22', 'user', '$2y$10$3KbvtKW.utkLTKlO5S1bOOUpSnAVaqXhFr8Dcl1ZwbN1OtniDVZsi'),
	(10, 'tempest', NULL, NULL, NULL, '2025-04-07 10:27:15', 'user', '$2y$10$o9gXCKBlFtTU4wsgVR2NEO7NZ9mfK67OckQICt4awm0xdqKzK289i'),
	(11, 'kee', NULL, NULL, NULL, '2025-04-07 10:41:25', 'user', '$2y$10$y27kTdIPyIvaVtlVbxBZ1uPiHSfU6V506uyER2ZHcbg5IdCra6x6K'),
	(12, 'john', NULL, NULL, NULL, '2025-04-07 10:53:01', 'user', '$2y$10$5s3ldGXb4t9Q3F8PivjoWuU7WmCaR.ZyAW9rAa5s88ETQYbIQ6Xum'),
	(13, 'bonjovi', NULL, NULL, NULL, '2025-04-18 06:13:30', 'user', '$2y$10$ArfUpvOkdM4/Bz69uSjG4O7FjJH/kDdk7QNy1.PlPaNjHso.VhCeO');

-- Listage de la structure de déclencheur gestion_pret_pc. after_reservation_validation
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `after_reservation_validation` AFTER UPDATE ON `reservations` FOR EACH ROW BEGIN
    IF NEW.status = 'validé' THEN
        UPDATE pcs SET status = 'en prêt' WHERE id = NEW.id_pc;
    ELSEIF NEW.status = 'rendu' OR NEW.status = 'annulé' THEN
        UPDATE pcs SET status = 'disponible' WHERE id = NEW.id_pc;
    END IF;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

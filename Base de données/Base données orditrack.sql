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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table gestion_pret_pc.pcs : ~13 rows (environ)
INSERT INTO `pcs` (`id`, `numero_serie`, `status`, `date_debut`, `date_retour`) VALUES
	(4, 'PC-TEST-124', 'réservé', NULL, NULL),
	(5, 'PC-TEST-125', 'réservé', NULL, NULL),
	(6, 'PC-TEST-126', 'disponible', NULL, NULL),
	(7, 'PC-TEST-127', 'disponible', NULL, NULL),
	(9, 'PC-TEST-129', 'disponible', NULL, NULL),
	(10, 'PC-TEST-130', 'disponible', NULL, NULL),
	(11, 'PC-TEST-131', 'disponible', NULL, NULL),
	(12, 'PC-TEST-132', 'disponible', NULL, NULL),
	(13, 'PC-TEST-133', 'réservé', NULL, NULL),
	(14, 'PC-TEST-134', 'disponible', NULL, NULL),
	(25, 'PC-TEST-144', 'en réparation', NULL, NULL),
	(27, 'PC-TEST-146', 'en réparation', NULL, NULL),
	(28, 'PC-TEST-150', 'disponible', NULL, NULL);

-- Listage de la structure de table gestion_pret_pc. reservations
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `id_pc` int NOT NULL,
  `date_debut` datetime DEFAULT NULL,
  `date_retour` datetime NOT NULL,
  `status` enum('en attente','validé','rendu','annulé','réservé','en réparation','disponible') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'en attente',
  `validated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table gestion_pret_pc.reservations : ~67 rows (environ)
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
	(62, 2, 13, '2025-02-21 16:01:00', '2025-02-28 16:01:00', 'validé', NULL),
	(63, 2, 10, '2025-02-21 16:11:00', '2025-03-02 16:11:00', 'annulé', NULL),
	(64, 2, 10, '2025-02-22 08:50:00', '2025-02-26 08:50:00', 'validé', NULL),
	(65, 2, 2, '2025-02-22 09:41:00', '2025-03-02 09:41:00', 'rendu', NULL),
	(66, 2, 2, '2025-02-22 09:57:00', '2025-02-28 09:57:00', 'rendu', NULL),
	(67, 2, 2, '2025-02-26 09:57:00', '2025-03-07 09:57:00', 'validé', NULL),
	(68, 2, 4, '2025-02-22 09:58:00', '2025-03-07 09:58:00', 'validé', NULL),
	(69, 2, 2, '2025-02-21 13:02:00', '2025-03-01 13:02:00', 'annulé', NULL),
	(70, 2, 2, '2025-02-26 13:02:00', '2025-03-01 13:02:00', 'annulé', NULL),
	(71, 2, 5, '2025-02-22 13:03:00', '2025-03-08 13:03:00', 'validé', NULL),
	(72, 2, 2, '2025-02-22 13:05:00', '2025-03-09 13:05:00', 'annulé', NULL),
	(73, 2, 6, '2025-02-22 13:06:00', '2025-02-28 13:06:00', 'rendu', NULL),
	(74, 2, 6, '2025-02-21 13:07:00', '2025-03-01 13:07:00', 'en attente', NULL),
	(75, 2, 7, '2025-02-22 13:07:00', '2025-02-28 13:07:00', 'en attente', NULL),
	(76, 2, 9, '2025-02-26 08:56:00', '2025-02-27 08:56:00', 'rendu', NULL);

-- Listage de la structure de table gestion_pret_pc. users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password_hash` varchar(50) DEFAULT NULL,
  `microsoft_id` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `microsoft_id` (`microsoft_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table gestion_pret_pc.users : ~1 rows (environ)
INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `microsoft_id`, `created_at`, `role`, `password`) VALUES
	(1, 'user1', NULL, NULL, NULL, '2025-02-12 10:28:32', 'user', NULL),
	(2, 'user', NULL, '1234', NULL, '2025-02-13 10:46:28', 'user', NULL);

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

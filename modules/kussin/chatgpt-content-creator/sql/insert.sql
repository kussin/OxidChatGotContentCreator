-- --------------------------------------------------------
-- Host:                         localhost
-- Server-Version:               5.7.35-1 - (Debian)
-- Server-Betriebssystem:        debian-linux-gnu
-- HeidiSQL Version:             12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Exportiere Struktur von Tabelle usrdb_triequax.kussin_chatgpt_content_creator_queue
CREATE TABLE `kussin_chatgpt_content_creator_queue` (
    `id` INT(10) NOT NULL AUTO_INCREMENT,
    `object` VARCHAR(55) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
    `object_id` CHAR(32) NULL DEFAULT NULL COMMENT 'OXID of the corresponding object' COLLATE 'utf8_unicode_ci',
    `field` VARCHAR(55) NULL DEFAULT NULL COMMENT 'DB Table Field or OXID Attribute' COLLATE 'utf8_unicode_ci',
    `shop_id` INT(11) NOT NULL DEFAULT '1',
    `lang_id` INT(11) NOT NULL DEFAULT '0',
    `content` TEXT NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
    `prompt` TEXT NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
    `generated` TEXT NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
    `process_ip` VARCHAR(55) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
    `status` VARCHAR(16) NOT NULL DEFAULT 'pending' COLLATE 'utf8_unicode_ci',
    `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `id` (`id`) USING BTREE,
    INDEX `object_id` (`object_id`) USING BTREE,
    INDEX `object` (`object`) USING BTREE,
    INDEX `status` (`status`) USING BTREE,
    INDEX `field` (`field`) USING BTREE
)
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB
;

-- Daten-Export vom Benutzer nicht ausgewählt

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

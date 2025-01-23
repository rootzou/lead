CREATE TABLE IF NOT EXISTS `about_us` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insérer des données par défaut si la table est vide
INSERT INTO `about_us` (`title`, `subtitle`, `image_url`, `video_url`)
SELECT 'About Us', 'Welcome to our company', '', ''
WHERE NOT EXISTS (SELECT 1 FROM `about_us`);

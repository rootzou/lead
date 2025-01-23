CREATE TABLE IF NOT EXISTS `directory_portfolio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `directory_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `image` varchar(255),
  `project_date` date,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `directory_id` (`directory_id`),
  CONSTRAINT `fk_directory_portfolio` FOREIGN KEY (`directory_id`) REFERENCES `directories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `directories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `location` varchar(255),
  `pays` varchar(2),
  `contact_email` varchar(255),
  `contact_phone` varchar(50),
  `website_url` varchar(255),
  `logo` varchar(255),
  `cover_image` varchar(255),
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `directory_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `directory_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_directory_services_directory` (`directory_id`),
  KEY `fk_directory_services_service` (`service_id`),
  CONSTRAINT `fk_directory_services_directory` FOREIGN KEY (`directory_id`) REFERENCES `directories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_directory_services_service` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

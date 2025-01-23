-- Create services table
CREATE TABLE IF NOT EXISTS `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `icon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create directory_services (junction table for many-to-many relationship)
CREATE TABLE IF NOT EXISTS `directory_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `directory_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `directory_id` (`directory_id`),
  KEY `service_id` (`service_id`),
  CONSTRAINT `directory_services_ibfk_1` FOREIGN KEY (`directory_id`) REFERENCES `directories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `directory_services_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

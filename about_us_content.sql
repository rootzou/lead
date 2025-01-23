CREATE TABLE IF NOT EXISTS `about_us_content` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `block_id` int(11) NOT NULL,
    `title` varchar(255) DEFAULT NULL,
    `subtitle` text DEFAULT NULL,
    `image_url` varchar(255) DEFAULT NULL,
    `video_url` varchar(255) DEFAULT NULL,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `block_id` (`block_id`),
    CONSTRAINT `fk_about_us_content_block` FOREIGN KEY (`block_id`) REFERENCES `blocks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `blocks` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `type` varchar(50) NOT NULL, -- 'about_us', 'statistics', 'faq'
    `order_num` int(11) NOT NULL,
    `is_visible` tinyint(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insérer les blocs par défaut
INSERT INTO `blocks` (`type`, `order_num`, `is_visible`) VALUES
('about_us', 1, 1),
('statistics', 2, 1),
('faq', 3, 1);

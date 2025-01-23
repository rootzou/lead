CREATE TABLE IF NOT EXISTS `statistics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `happy_clients_count` int(11) DEFAULT 0,
  `happy_clients_text` varchar(255) DEFAULT NULL,
  `projects_count` int(11) DEFAULT 0,
  `projects_text` varchar(255) DEFAULT NULL,
  `support_hours_count` int(11) DEFAULT 0,
  `support_hours_text` varchar(255) DEFAULT NULL,
  `workers_count` int(11) DEFAULT 0,
  `workers_text` varchar(255) DEFAULT NULL,
  `is_visible` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `statistics` (id, happy_clients_count, happy_clients_text, projects_count, projects_text, support_hours_count, support_hours_text, workers_count, workers_text, is_visible) 
VALUES (1, 232, 'consequuntur quae', 521, 'adipisci atque cum quia aut', 1453, 'aut commodi quaerat', 32, 'rerum asperiores dolor', 1)
ON DUPLICATE KEY UPDATE id=id;

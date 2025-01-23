CREATE TABLE IF NOT EXISTS `faq` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `question` text NOT NULL,
    `answer` text NOT NULL,
    `order_num` int(11) NOT NULL DEFAULT 0,
    `is_visible` tinyint(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `faq` (`question`, `answer`, `order_num`) VALUES
('Non consectetur a erat nam at lectus urna duis?', 'Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus laoreet non curabitur gravida. Venenatis lectus magna fringilla urna porttitor rhoncus dolor purus non.', 1),
('Feugiat scelerisque varius morbi enim nunc faucibus a pellentesque?', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 2),
('Dolor sit amet consectetur adipiscing elit pellentesque?', 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 3),
('Ac odio tempor orci dapibus. Aliquam eleifend mi in nulla?', 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.', 4),
('Tempus quam pellentesque nec nam aliquam sem et tortor consequat?', 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum.', 5);

-- phpMyAdmin SQL Dump
-- Table structure for table `pages_lead`

CREATE TABLE `pages_lead` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre_seo` varchar(255) NOT NULL,
  `desc_seo` varchar(164) NOT NULL,
  `titre_h1` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `bloc1_titre` varchar(255) NOT NULL,
  `bloc1_contenu` text NOT NULL,
  `bloc2_titre` varchar(255) NOT NULL,
  `bloc2_contenu` text NOT NULL,
  `bloc3_titre` varchar(255) NOT NULL,
  `bloc3_contenu` text NOT NULL,
  `bloc4_titre` varchar(255) NOT NULL,
  `bloc4_contenu` text NOT NULL,
  `bloc5_titre` varchar(255) NOT NULL,
  `bloc5_contenu` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

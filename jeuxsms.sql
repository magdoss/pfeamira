-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 05 juin 2019 à 22:32
-- Version du serveur :  5.7.24
-- Version de PHP :  5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `jeuxsms`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `short_code_id` int(11) DEFAULT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `jsonConfig` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:array)',
  `keyword` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `date_creation` date NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `price` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_23A0E668C7B29BF` (`short_code_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `short_code_id`, `libelle`, `description`, `jsonConfig`, `keyword`, `is_active`, `date_creation`, `date_debut`, `date_fin`, `price`) VALUES
(5, 3, 'article 2', 'gefgdfg', NULL, 'a', 1, '2019-06-02', '2019-06-02', '2019-06-02', 1300),
(6, 2, 'hjk', 'iolk', 'a:3:{s:4:\"menu\";a:4:{i:0;a:2:{s:3:\"key\";s:5:\"steps\";s:5:\"value\";s:6:\"étape\";}i:1;a:2:{s:3:\"key\";s:11:\"ingredients\";s:5:\"value\";s:12:\"ingrédients\";}i:2;a:2:{s:3:\"key\";s:5:\"value\";s:5:\"value\";s:16:\"valeur nutritive\";}i:3;a:2:{s:3:\"key\";s:3:\"vdo\";s:5:\"value\";s:6:\"vidéo\";}}s:5:\"steps\";a:2:{i:0;a:3:{s:5:\"title\";s:7:\"etape 1\";s:8:\"subTitle\";s:9:\"02:00 min\";s:7:\"content\";s:444:\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum\";}i:1;a:3:{s:5:\"title\";s:7:\"etape 2\";s:8:\"subTitle\";s:9:\"04:00 min\";s:7:\"content\";s:73:\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod .\";}}s:8:\"menu Key\";a:3:{i:0;a:0:{}i:1;a:0:{}i:2;a:0:{}}}', 'ujk', 0, '2019-06-04', '2019-06-04', '2019-06-04', 1300);

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `numTel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` int(11) NOT NULL,
  `dateInscription` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `emmision`
--

DROP TABLE IF EXISTS `emmision`;
CREATE TABLE IF NOT EXISTS `emmision` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `short_code_id` int(11) DEFAULT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lot_id` int(11) DEFAULT NULL,
  `keyword` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `is_active` tinyint(1) NOT NULL,
  `date_creation` date NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `price` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_41E391C1A8CBA5F7` (`lot_id`),
  KEY `IDX_41E391C18C7B29BF` (`short_code_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `emmision`
--

INSERT INTO `emmision` (`id`, `short_code_id`, `libelle`, `lot_id`, `keyword`, `description`, `is_active`, `date_creation`, `date_debut`, `date_fin`, `price`) VALUES
(2, 1, 'emmision extra', 1, 'ee', 'dsgsd', 1, '2019-06-02', '2019-06-02', '2019-06-02', 2000);

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

DROP TABLE IF EXISTS `image`;
CREATE TABLE IF NOT EXISTS `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `emmision_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C53D045F7294869C` (`article_id`),
  KEY `IDX_C53D045FA775319F` (`emmision_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `image`
--

INSERT INTO `image` (`id`, `article_id`, `name`, `emmision_id`) VALUES
(6, NULL, '1e05069006cf0ea8e2f6c864f642ed4d277e4ea4.jpeg', 2),
(7, NULL, '610f326cfde2f0fc50b5a200192990f29cad9751.jpeg', 2);

-- --------------------------------------------------------

--
-- Structure de la table `inscription`
--

DROP TABLE IF EXISTS `inscription`;
CREATE TABLE IF NOT EXISTS `inscription` (
  `client_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `score` int(11) DEFAULT NULL,
  `isWinner` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`client_id`,`service_id`),
  KEY `IDX_5E90F6D619EB6921` (`client_id`),
  KEY `IDX_5E90F6D6ED5CA9E6` (`service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `lot`
--

DROP TABLE IF EXISTS `lot`;
CREATE TABLE IF NOT EXISTS `lot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `valeur` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nb_gagnant` int(11) DEFAULT NULL,
  `nb_restant` int(11) DEFAULT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B81291B853CD175` (`quiz_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `lot`
--

INSERT INTO `lot` (`id`, `nom`, `valeur`, `nb_gagnant`, `nb_restant`, `quiz_id`) VALUES
(1, 'kia rio', '45000', 0, 1, NULL),
(2, 'smartphone', '1200', 0, 3, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

DROP TABLE IF EXISTS `question`;
CREATE TABLE IF NOT EXISTS `question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `question` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prop1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prop2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `isPropOneCorrect` tinyint(1) NOT NULL,
  `pointToAdd` int(11) NOT NULL,
  `pointToSubIfFail` int(11) NOT NULL,
  `reponse_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B6F7494ECF18BB82` (`reponse_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `question`
--

INSERT INTO `question` (`id`, `lang`, `question`, `prop1`, `prop2`, `isPropOneCorrect`, `pointToAdd`, `pointToSubIfFail`, `reponse_id`) VALUES
(5, 'fr', 'La tunisie appartient au continent ?', 'Asiatique', 'Africain', 1, 10, 2, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `question_quiz`
--

DROP TABLE IF EXISTS `question_quiz`;
CREATE TABLE IF NOT EXISTS `question_quiz` (
  `question_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  PRIMARY KEY (`question_id`,`quiz_id`),
  KEY `IDX_FAFC177D1E27F6BF` (`question_id`),
  KEY `IDX_FAFC177D853CD175` (`quiz_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `question_quiz`
--

INSERT INTO `question_quiz` (`question_id`, `quiz_id`) VALUES
(4, 3),
(5, 4);

-- --------------------------------------------------------

--
-- Structure de la table `quiz`
--

DROP TABLE IF EXISTS `quiz`;
CREATE TABLE IF NOT EXISTS `quiz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `short_code_id` int(11) DEFAULT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `keyword` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `date_creation` date NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `price` double DEFAULT NULL,
  `lot_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A412FA928C7B29BF` (`short_code_id`),
  KEY `IDX_A412FA92A8CBA5F7` (`lot_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `quiz`
--

INSERT INTO `quiz` (`id`, `short_code_id`, `libelle`, `description`, `keyword`, `is_active`, `date_creation`, `date_debut`, `date_fin`, `price`, `lot_id`) VALUES
(4, 3, 'tt quiz', 'quiz tunisie', 'q', 1, '2019-06-02', '2019-06-02', '2019-06-02', 2000, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `reponse`
--

DROP TABLE IF EXISTS `reponse`;
CREATE TABLE IF NOT EXISTS `reponse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) DEFAULT NULL,
  `rep` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dateRep` datetime NOT NULL,
  `etat` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5FB6DEC71E27F6BF` (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `service`
--

DROP TABLE IF EXISTS `service`;
CREATE TABLE IF NOT EXISTS `service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) DEFAULT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `emmision_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_E19D9AD27294869C` (`article_id`),
  UNIQUE KEY `UNIQ_E19D9AD2853CD175` (`quiz_id`),
  UNIQUE KEY `UNIQ_E19D9AD2A775319F` (`emmision_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `service`
--

INSERT INTO `service` (`id`, `article_id`, `quiz_id`, `emmision_id`) VALUES
(8, NULL, NULL, 2),
(9, 5, NULL, NULL),
(10, NULL, 4, NULL),
(11, 6, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `short_code`
--

DROP TABLE IF EXISTS `short_code`;
CREATE TABLE IF NOT EXISTS `short_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `short_code`
--

INSERT INTO `short_code` (`id`, `code`) VALUES
(1, '85585'),
(2, '85518'),
(3, '25415'),
(4, '225588');

-- --------------------------------------------------------

--
-- Structure de la table `type_service`
--

DROP TABLE IF EXISTS `type_service`;
CREATE TABLE IF NOT EXISTS `type_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `type_service`
--

INSERT INTO `type_service` (`id`, `type`) VALUES
(1, 'Emission'),
(2, 'Quiz'),
(3, 'Abonnement'),
(4, 'service amira');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D64992FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_8D93D649A0D96FBF` (`email_canonical`),
  UNIQUE KEY `UNIQ_8D93D649C05FB297` (`confirmation_token`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`) VALUES
(1, 'admin', 'admin', 'admin@admin.tn', 'admin@admin.tn', 1, NULL, '$2y$13$4.PQOhme/v3k9jBT5W7MKOz3p5KNUEf/.U2aY/K8Cb4VPL.LIFK2W', '2019-06-05 13:43:51', NULL, NULL, 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}'),
(2, 'amira', 'amira', 'amira@amira.tn', 'amira@amira.tn', 1, NULL, '$2y$13$XRPMDKWT8FeJxRlAGybhI.2OkmOnRMk.QDr0KStQAL/G8q41szYZi', '2019-06-01 14:30:18', NULL, NULL, 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}');

-- --------------------------------------------------------

--
-- Structure de la table `value`
--

DROP TABLE IF EXISTS `value`;
CREATE TABLE IF NOT EXISTS `value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `value`
--

INSERT INTO `value` (`id`, `name`) VALUES
(1, 'majdi');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `FK_23A0E668C7B29BF` FOREIGN KEY (`short_code_id`) REFERENCES `short_code` (`id`);

--
-- Contraintes pour la table `emmision`
--
ALTER TABLE `emmision`
  ADD CONSTRAINT `FK_41E391C18C7B29BF` FOREIGN KEY (`short_code_id`) REFERENCES `short_code` (`id`),
  ADD CONSTRAINT `FK_41E391C1A8CBA5F7` FOREIGN KEY (`lot_id`) REFERENCES `lot` (`id`);

--
-- Contraintes pour la table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `FK_C53D045F7294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`),
  ADD CONSTRAINT `FK_C53D045FA775319F` FOREIGN KEY (`emmision_id`) REFERENCES `emmision` (`id`);

--
-- Contraintes pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD CONSTRAINT `FK_5E90F6D619EB6921` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `FK_5E90F6D6ED5CA9E6` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`);

--
-- Contraintes pour la table `lot`
--
ALTER TABLE `lot`
  ADD CONSTRAINT `FK_B81291B853CD175` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`);

--
-- Contraintes pour la table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `FK_B6F7494ECF18BB82` FOREIGN KEY (`reponse_id`) REFERENCES `reponse` (`id`);

--
-- Contraintes pour la table `question_quiz`
--
ALTER TABLE `question_quiz`
  ADD CONSTRAINT `FK_FAFC177D1E27F6BF` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_FAFC177D853CD175` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `FK_A412FA928C7B29BF` FOREIGN KEY (`short_code_id`) REFERENCES `short_code` (`id`),
  ADD CONSTRAINT `FK_A412FA92A8CBA5F7` FOREIGN KEY (`lot_id`) REFERENCES `lot` (`id`);

--
-- Contraintes pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD CONSTRAINT `FK_5FB6DEC71E27F6BF` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`);

--
-- Contraintes pour la table `service`
--
ALTER TABLE `service`
  ADD CONSTRAINT `FK_E19D9AD27294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_E19D9AD2853CD175` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_E19D9AD2A775319F` FOREIGN KEY (`emmision_id`) REFERENCES `emmision` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

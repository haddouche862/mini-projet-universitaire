-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 10 déc. 2024 à 13:28
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `universit`
--

-- --------------------------------------------------------

--
-- Structure de la table `cours`
--

CREATE TABLE `cours` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `code` int(11) NOT NULL,
  `credits` int(11) NOT NULL,
  `formation` enum('LP','DEUST','BOTH') DEFAULT 'BOTH',
  `horaires_dates` text DEFAULT NULL,
  `salle_classe` varchar(255) DEFAULT NULL,
  `semestre` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `cours`
--

INSERT INTO `cours` (`id`, `nom`, `code`, `credits`, `formation`, `horaires_dates`, `salle_classe`, `semestre`) VALUES
(1, 'Web dynamique et bases de données', 219, 6, 'LP', 'Mercredi 09h-11h, Vendredi 14h-16h', 'Salle A101', 1),
(2, 'Administration de serveurs', 214, 10, 'LP', 'Lundi 10h-12h, Jeudi 15h-17h', 'Salle A102', 1),
(3, 'Creation de contenue multimedia', 217, 6, 'LP', 'Mardi 13h-15h', 'Salle B201', 1),
(4, 'Fonctionnalites et usages de l\'internet', 213, 8, 'DEUST', 'Vendredi 08h-10h', 'Salle B202', 1),
(5, 'Community manager', 216, 6, 'DEUST', 'Mercredi 08h-10h', 'Salle C101', 1),
(6, 'Introduction a la creation de contenus', 202, 4, 'DEUST', 'Mardi 10h-12h', 'Salle C102', 1),
(7, 'Ordinateur et périphériques', 204, 6, 'BOTH', 'Lundi 14h-16h', 'Amphi A', 1),
(8, 'Anglais', 223, 4, 'BOTH', 'Mardi 16h-18h', 'Salle A103', 1),
(9, 'Hebergement et référencement', 106, 6, 'BOTH', 'Jeudi 09h-11h', 'Salle B203', 1),
(10, 'Algorithmique', 107, 10, 'BOTH', 'Vendredi 13h-15h', 'Salle C201', 1),
(11, 'Connaissance de l\'entreprise', 108, 3, 'BOTH', 'Mardi 14h-16h', 'Salle A201', 2),
(12, 'Veille et e-réputation', 110, 5, 'BOTH', 'Lundi 16h-18h', 'Salle B204', 2),
(13, 'Découverte du milieu professionnel', 111, 8, 'BOTH', 'Jeudi 08h-10h', 'Salle C202', 2),
(14, 'Technologies XML', 112, 6, 'BOTH', 'Mercredi 13h-15h', 'Salle A202', 2),
(15, 'Introduction aux bases de données', 115, 2, 'BOTH', 'Vendredi 10h-12h', 'Salle B205', 2),
(16, 'Introduction au JavaScript', 114, 5, 'BOTH', 'Lundi 09h-11h', 'Salle C203', 2),
(17, 'Qualité d\'un site web', 100, 4, 'BOTH', 'Mardi 08h-10h', 'Salle A203', 2),
(18, 'Droit du numérique', 120, 10, 'BOTH', 'Mercredi 14h-16h', 'Salle B206', 2),
(19, 'Intégration web', 201, 4, 'BOTH', 'Jeudi 13h-15h', 'Salle C204', 2),
(20, 'Sécurité du web', 203, 2, 'BOTH', 'Vendredi 15h-17h', 'Salle A204', 2);

-- --------------------------------------------------------

--
-- Structure de la table `cours_enseignants`
--

CREATE TABLE `cours_enseignants` (
  `id` int(11) NOT NULL,
  `id_cours` int(11) NOT NULL,
  `id_prof` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `cours_enseignants`
--

INSERT INTO `cours_enseignants` (`id`, `id_cours`, `id_prof`) VALUES
(1, 18, 1),
(2, 1, 2),
(3, 19, 2),
(4, 2, 3),
(5, 20, 3),
(6, 3, 4),
(7, 4, 5),
(8, 6, 7),
(9, 7, 8),
(10, 8, 9),
(11, 9, 10),
(12, 10, 11),
(13, 11, 12),
(14, 12, 13),
(15, 13, 14),
(16, 14, 15),
(17, 15, 16),
(18, 16, 17),
(19, 17, 18),
(20, 1, 20),
(21, 19, 20);

-- --------------------------------------------------------

--
-- Structure de la table `devoirs`
--

CREATE TABLE `devoirs` (
  `id_devoir` int(11) NOT NULL,
  `id_cours` int(11) NOT NULL,
  `description` text NOT NULL,
  `date_limite` date NOT NULL,
  `modifiable` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `devoirs`
--

INSERT INTO `devoirs` (`id_devoir`, `id_cours`, `description`, `date_limite`, `modifiable`) VALUES
(1, 1, 'Créer une base de données pour une boutique en ligne (produits, clients, commandes). Inclure un schéma relationnel complet avec des exemples de requêtes SQL.', '2024-12-15', 1),
(2, 3, 'Réaliser un projet vidéo de présentation d\'une entreprise fictive avec un montage professionnel.', '2024-12-15', 1),
(3, 2, 'Configurer un serveur Apache avec des règles de sécurité. Rédiger un guide d\'installation et de configuration.', '2024-12-22', 1),
(4, 5, 'Créer une campagne de communication pour un produit fictif sur les réseaux sociaux, incluant un calendrier éditorial.', '2024-12-22', 1),
(5, 4, 'Rédiger un rapport sur les évolutions des usages d\'internet depuis 2000, avec une analyse des tendances actuelles.', '2024-12-29', 1),
(6, 6, 'Écrire un article de blog de 1000 mots sur un sujet technologique de votre choix.', '2024-12-29', 1),
(7, 7, 'Rédiger un rapport sur la comparaison entre les différents types de stockage (SSD, HDD, cloud).', '2025-01-05', 1),
(8, 9, 'Optimiser le référencement naturel (SEO) d\'un site web fictif pour un produit spécifique.', '2025-01-05', 1);

-- --------------------------------------------------------

--
-- Structure de la table `enseignants`
--

CREATE TABLE `enseignants` (
  `id` int(11) NOT NULL,
  `identifiant` varchar(255) NOT NULL,
  `motdepasse` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'prof'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `enseignants`
--

INSERT INTO `enseignants` (`id`, `identifiant`, `motdepasse`, `role`) VALUES
(1, 'isabelle02', '#++happy--Teacher++#', 'prof'),
(2, 'Hugo01', 'OrI)M*f3Itl@7N*3', 'prof'),
(3, 'Fredon02', 'OnwyBHohrdgYzH6]', 'prof'),
(4, 'Stephanie03', 'K@BWyMQc!Zqe0DuA', 'prof'),
(5, 'Baptiste07', 'Twf)O8ujFG6G8az4', 'prof'),
(6, 'Eric01', 'pp4gUDBlN/a5NnGW', 'admin'),
(7, 'Amelin02', 'oPUS5jib)dS9J7BL', 'prof'),
(8, 'Emilie01', 'dL*GawKAMmeDHc(V', 'prof'),
(9, 'Claudia02', 'w9Ljlfwf(It8/HRU', 'prof'),
(10, 'Serge01', '9oF*_r7oOmw0DmAw', 'prof'),
(11, 'Vincent05', 'HG]jQMisfOtTLlCu', 'prof'),
(12, 'Corinne06', 'V(vC6sMgOTkK3QKd', 'prof'),
(13, 'Anna03', 'b@XoZfI77Vg4MfM6', 'prof'),
(14, 'Julien07', 's.3V*mRX(tXKBy(W', 'prof'),
(15, 'Benoit01', 'TIo44aAvZDEqvBwN', 'prof'),
(16, 'Myriam02', 'aC/trG5c3G2zw1RH', 'prof'),
(17, 'Christophe02', '[4L/o9ErSzgVXacM', 'prof'),
(18, 'Daniel06', 'CpT(2EufAGMJ85wi', 'prof'),
(19, 'Phillipe05', '[(r]EuKg49z_TJn_', 'admin'),
(20, 'Ilaria01', '59qWlY[T/Jc)y76S', 'prof');

-- --------------------------------------------------------

--
-- Structure de la table `etudiants`
--

CREATE TABLE `etudiants` (
  `id` int(11) NOT NULL,
  `identifiant` varchar(255) NOT NULL,
  `motdepasse` varchar(255) NOT NULL,
  `formation` varchar(25) NOT NULL,
  `role` varchar(50) DEFAULT 'etudiant'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `etudiants`
--

INSERT INTO `etudiants` (`id`, `identifiant`, `motdepasse`, `formation`, `role`) VALUES
(1, 'Dupont02', 'd7uRg4()zm9HBPEG', 'LP', 'etudiant'),
(2, 'Ablain01', 'd7uRg4()zm9HBPEG', 'DEUST', 'etudiant'),
(3, 'Brionnaud01', 'Wf]/*/Ole3!e5k*q', 'LP', 'etudiant'),
(4, 'Lalali01', 'jMR4f*Vt1[j6n4yW', 'LP', 'etudiant'),
(5, 'Jonshon01', '@o0oV6c1jSa4mjJ.r', 'DEUST', 'etudiant'),
(6, 'Guillon01', 'fHmj0BUgGo@wYM*j', 'LP', 'etudiant'),
(7, 'Gautier01', '_*oVaVG*ic@58_xc', 'LP', 'etudiant'),
(8, 'Fontaine02', 'PE8nFAn_uDU(pi3I', 'DEUST', 'etudiant'),
(9, 'Martin02', '!E(BO-UaaD[0JtFl', 'LP', 'etudiant'),
(10, 'Moreau02', 'p*3pGO_cq5Qkm(D5', 'LP', 'etudiant'),
(11, 'Dubois03', '_)cnq!zvOxaXpZLA', 'LP', 'etudiant'),
(12, 'Raynaud04', 'HBkJPy!x4xhoBC', 'DEUST', 'etudiant'),
(13, 'Leblanc01', 'xoXF3xzZppAO@OFG', 'DEUST', 'etudiant'),
(14, 'Petit01', '90@f4vcZY0aj_J(t', 'DEUST', 'etudiant'),
(15, 'Sanchez02', 'rh6uPT4CiMCEA9Gl', 'LP', 'etudiant'),
(16, 'Gomez01', ']umogwzPVErLa-dh', 'DEUST', 'etudiant'),
(17, 'Olive02', 'x08)ysXUSaIeYvUp', 'DEUST', 'etudiant'),
(18, 'Durand01', 'Rw7Ev05oF!ChikvX', 'LP', 'etudiant'),
(19, 'Nonde03', '8PGLhjlCQ!YvnWM9', 'LP', 'etudiant'),
(20, 'Marchal01', 'EejTScO5[q9fjGDZ', 'DEUST', 'etudiant'),
(21, 'Etienne01', 'YywiNnE[.iUcP/iz', 'LP', 'etudiant'),
(22, 'Gillet02', 'yP)[rx[Hv!t_k87t', 'LP', 'etudiant'),
(23, 'Poulain03', 'RPS]]1GKSSkrcRXX', 'DEUST', 'etudiant'),
(24, 'Lemaitre01', 'WJJP@)9o5qz6WI[D', 'LP', 'etudiant'),
(25, 'Marechal01', 'ZRph8bjyTf2bR4wV', 'DEUST', 'etudiant'),
(26, 'Bernard02', 't6dL9kCunNgrtQG', 'DEUST', 'etudiant'),
(27, 'Bourgeois01', ']DwX7Di-d42lPtgZ', 'DEUST', 'etudiant'),
(28, 'Collin01', '3-3sIqw5d7CwKZa9', 'DEUST', 'etudiant'),
(29, 'Rodriguez02', 'O@R9_!aKS3X2mX2g', 'LP', 'etudiant'),
(30, 'Charpentier01', 'qYyQ*wncspZPbhbj', 'DEUST', 'etudiant'),
(31, 'Dupuis01', 'sPxXIE_VkJ@2@z))', 'LP', 'etudiant'),
(32, 'Deschamps01', 'o[xt2nY5*p8vavdM', 'LP', 'etudiant'),
(33, 'Leroux02', './mPuWV3]K*.(ywf', 'DEUST', 'etudiant'),
(34, 'Dupuy01', '*/VaxAfuJ8UzwQcD', 'LP', 'etudiant'),
(35, 'Morel02', 'uCPed[af]n@VWUi2', 'DEUST', 'etudiant'),
(36, 'Rousseau01', 'D*36b/z7!_S3Jtb)', 'LP', 'etudiant'),
(37, 'Joly01', 'R74uxTkG.I[Oda2g', 'DEUST', 'etudiant'),
(38, 'Renard02', 'zw(]MDAzy)Vc7Y7[', 'DEUST', 'etudiant'),
(39, 'Bourgeois02', '(K.ooEF02qq]DMkj', 'LP', 'etudiant'),
(40, 'Huet01', 'rTDB(gaXV0.mK.s-Z', 'DEUST', 'etudiant'),
(41, 'Picard02', 'AordUP1)Q7(RAcxN', 'LP', 'etudiant'),
(42, 'Lecompte03', 'OssZQX9/!U.wZnRo', 'DEUST', 'etudiant'),
(43, 'Camus01', '(EL!@2ySB4G/2*j5', 'DEUST', 'etudiant'),
(44, 'Clement01', 'P@7rcqtLNgbLYF/bZ', 'LP', 'etudiant'),
(45, 'Mercier02', '3IE-6MWRDKwj5kIs', 'DEUST', 'etudiant');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `cours`
--
ALTER TABLE `cours`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cours_enseignants`
--
ALTER TABLE `cours_enseignants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cours` (`id_cours`),
  ADD KEY `id_prof` (`id_prof`);

--
-- Index pour la table `devoirs`
--
ALTER TABLE `devoirs`
  ADD PRIMARY KEY (`id_devoir`),
  ADD KEY `id_cours` (`id_cours`);

--
-- Index pour la table `enseignants`
--
ALTER TABLE `enseignants`
  ADD PRIMARY KEY (`id`);
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Index pour la table `etudiants`
--
ALTER TABLE `etudiants`
  ADD PRIMARY KEY (`id`);
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `cours`
--
ALTER TABLE `cours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `cours_enseignants`
--
ALTER TABLE `cours_enseignants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `devoirs`
--
ALTER TABLE `devoirs`
  MODIFY `id_devoir` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `enseignants`
--
ALTER TABLE `enseignants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `cours_enseignants`
--
ALTER TABLE `cours_enseignants`
  ADD CONSTRAINT `cours_enseignants_ibfk_1` FOREIGN KEY (`id_cours`) REFERENCES `cours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cours_enseignants_ibfk_2` FOREIGN KEY (`id_prof`) REFERENCES `enseignants` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `devoirs`
--
ALTER TABLE `devoirs`
  ADD CONSTRAINT `devoirs_ibfk_1` FOREIGN KEY (`id_cours`) REFERENCES `cours` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 06 déc. 2024 à 22:11
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
  `devoirs_contenu` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `cours`
--

INSERT INTO `cours` (`id`, `nom`, `code`, `credits`, `formation`, `horaires_dates`, `salle_classe`, `devoirs_contenu`) VALUES
(1, 'Web dynamique et bases de données', 219, 6, 'LP', 'Lundi 16/12/2024 09h-11h, Jeudi 19/12/2024 14h-16h', 'Salle A204', 'Introduction au sujet, Exercice 1 à préparer'),
(2, 'Administration de serveurs', 214, 10, 'LP', 'Mardi 17/12/2024 11h-13h, Vendredi 20/12/2024 15h-17h', 'Salle A106', 'Chapitre 2 à lire, TP 1 à soumettre'),
(3, 'Creation de contenue multimedia', 217, 6, 'LP', 'Mardi 17/12/2024 15h-16h', 'Salle B106', NULL),
(4, 'Fonctionnalites et usages de l\'internet', 213, 8, 'DEUST', 'Vendredi 20/12/2024 8h-10h', 'Salle A306', NULL),
(5, 'Community manager', 216, 6, 'DEUST', 'mercredi 18/12/2024 8h-10h', 'Salle C101', NULL),
(6, 'Introduction a la creation de contenus', 202, 4, 'DEUST', 'mercredi 18/12/2024 10h-12h', 'Salle B213', NULL),
(7, 'Ordinateur et périphériques', 204, 6, 'BOTH', 'Lundi 16/12/2024 14h-16h', 'Amphi A', NULL),
(8, 'Anglais', 223, 4, 'BOTH', NULL, NULL, NULL),
(9, 'Hebergement et référencement', 106, 6, 'BOTH', NULL, NULL, NULL),
(10, 'Algorithmique', 107, 10, 'BOTH', NULL, NULL, NULL),
(11, 'Connaissance de l\'entreprise', 108, 3, 'BOTH', NULL, NULL, NULL),
(12, 'Veille et e-réputation', 110, 5, 'BOTH', NULL, NULL, NULL),
(13, 'Découverte du milieu professionnel', 111, 8, 'BOTH', NULL, NULL, NULL),
(14, 'Technologies XML', 112, 6, 'BOTH', NULL, NULL, NULL),
(15, 'Introduction aux bases de données', 115, 2, 'BOTH', NULL, NULL, NULL),
(16, 'Introduction au JavaScript', 114, 5, 'BOTH', NULL, NULL, NULL),
(17, 'Qualité d\'un site web', 100, 4, 'BOTH', NULL, NULL, NULL),
(18, 'Droit du numérique', 120, 10, 'BOTH', NULL, NULL, NULL),
(19, 'Intégration web', 201, 4, 'BOTH', NULL, NULL, NULL),
(20, 'Sécurité du web', 203, 2, 'BOTH', NULL, NULL, NULL);

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
  `formation` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `etudiants`
--

INSERT INTO `etudiants` (`id`, `identifiant`, `motdepasse`, `formation`) VALUES
(1, 'Dupont02', 'd7uRg4()zm9HBPEG', 'LP'),
(2, 'Ablain01', 'd7uRg4()zm9HBPEG', 'DEUST'),
(3, 'Brionnaud01', 'Wf]/*/Ole3!e5k*q', 'LP'),
(4, 'Lalali01', 'jMR4f*Vt1[j6n4yW', 'LP'),
(5, 'Jonshon01', '@o0oV6c1jSa4mjJ.r', 'DEUST'),
(6, 'Guillon01', 'fHmj0BUgGo@wYM*j', 'LP'),
(7, 'Gautier01', '_*oVaVG*ic@58_xc', 'LP'),
(8, 'Fontaine02', 'PE8nFAn_uDU(pi3I', 'DEUST'),
(9, 'Martin02', '!E(BO-UaaD[0JtFl', 'LP'),
(10, 'Moreau02', 'p*3pGO_cq5Qkm(D5', 'LP'),
(11, 'Dubois03', '_)cnq!zvOxaXpZLA', 'LP'),
(12, 'Raynaud04', 'HBkJPy!x4xhoBC', 'DEUST'),
(13, 'Leblanc01', 'xoXF3xzZppAO@OFG', 'DEUST'),
(14, 'Petit01', '90@f4vcZY0aj_J(t', 'DEUST'),
(15, 'Sanchez02', 'rh6uPT4CiMCEA9Gl', 'LP'),
(16, 'Gomez01', ']umogwzPVErLa-dh', 'DEUST'),
(17, 'Olive02', 'x08)ysXUSaIeYvUp', 'DEUST'),
(18, 'Durand01', 'Rw7Ev05oF!ChikvX', 'LP'),
(19, 'Nonde03', '8PGLhjlCQ!YvnWM9', 'LP'),
(20, 'Marchal01', 'EejTScO5[q9fjGDZ', 'DEUST'),
(21, 'Etienne01', 'YywiNnE[.iUcP/iz', 'LP'),
(22, 'Gillet02', 'yP)[rx[Hv!t_k87t', 'LP'),
(23, 'Poulain03', 'RPS]]1GKSSkrcRXX', 'DEUST'),
(24, 'Lemaitre01', 'WJJP@)9o5qz6WI[D', 'LP'),
(25, 'Marechal01', 'ZRph8bjyTf2bR4wV', 'DEUST'),
(26, 'Bernard02', 't6dL9kCunNgrtQG', 'DEUST'),
(27, 'Bourgeois01', ']DwX7Di-d42lPtgZ', 'DEUST'),
(28, 'Collin01', '3-3sIqw5d7CwKZa9', 'DEUST'),
(29, 'Rodriguez02', 'O@R9_!aKS3X2mX2g', 'LP'),
(30, 'Charpentier01', 'qYyQ*wncspZPbhbj', 'DEUST'),
(31, 'Dupuis01', 'sPxXIE_VkJ@2@z))', 'LP'),
(32, 'Deschamps01', 'o[xt2nY5*p8vavdM', 'LP'),
(33, 'Leroux02', './mPuWV3]K*.(ywf', 'DEUST'),
(34, 'Dupuy01', '*/VaxAfuJ8UzwQcD', 'LP'),
(35, 'Morel02', 'uCPed[af]n@VWUi2', 'DEUST'),
(36, 'Rousseau01', 'D*36b/z7!_S3Jtb)', 'LP'),
(37, 'Joly01', 'R74uxTkG.I[Oda2g', 'DEUST'),
(38, 'Renard02', 'zw(]MDAzy)Vc7Y7[', 'DEUST'),
(39, 'Bourgeois02', '(K.ooEF02qq]DMkj', 'LP'),
(40, 'Huet01', 'rTDB(gaXV0.mK.s-Z', 'DEUST'),
(41, 'Picard02', 'AordUP1)Q7(RAcxN', 'LP'),
(42, 'Lecompte03', 'OssZQX9/!U.wZnRo', 'DEUST'),
(43, 'Camus01', '(EL!@2ySB4G/2*j5', 'DEUST'),
(44, 'Clement01', 'P@7rcqtLNgbLYF/bZ', 'LP'),
(45, 'Mercier02', '3IE-6MWRDKwj5kIs', 'DEUST');

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
-- Index pour la table `enseignants`
--
ALTER TABLE `enseignants`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `etudiants`
--
ALTER TABLE `etudiants`
  ADD PRIMARY KEY (`id`);

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

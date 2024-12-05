-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 05 déc. 2024 à 12:05
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
-- Base de données : `université`
--

-- --------------------------------------------------------

--
-- Structure de la table `cours`
--

CREATE TABLE `cours` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `code` int(11) NOT NULL,
  `credits` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `cours`
--

INSERT INTO `cours` (`id`, `nom`, `code`, `credits`) VALUES
(1, 'Web dynamique et bases de données', 219, 6),
(2, 'Administration de serveurs', 214, 10),
(3, 'Creation de contenue multimedia', 217, 6),
(4, 'Fonctionnalites et usages de l''internet', 213, 8),
(5, 'Community manager', 216, 6),
(6, 'Introduction a la creation de contenus', 202, 4),
(7, 'Ordinateur et périphériques', 204, 6),
(8, 'Anglais', 223, 4),
(9, 'Hebergement et référencement', 106, 6),
(10, 'Algorithmique', 107, 10),
(11, 'Connaissance de l''entreprise', 108, 3),
(12, 'Veille et e-réputation', 110, 5),
(13, 'Découverte du milieu professionnel', 111, 8),
(14, 'Technologies XML', 112, 6),
(15, 'Introduction aux bases de données', 115, 2),
(16, 'Introduction au JavaScript', 114, 5),
(17, 'Qualité d''un site web', 100, 4),
(18, 'Droit du numérique', 120, 10),
(19, 'Intégration web', 201, 4),
(20, 'Sécurité du web', 203, 2);
-- --------------------------------------------------------

--
-- Structure de la table `enseignants`
--

CREATE TABLE `enseignants` (
  `id` int(11) NOT NULL,
  `identifiant` varchar(255) NOT NULL,
  `motdepasse` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `enseignants`
--

INSERT INTO `enseignants` (`id`, `identifiant`, `motdepasse`) VALUES
(1, 'isabelle02', '#++happy--Teacher++#'),
(2, 'Hugo01', 'OrI)M*f3Itl@7N*3'),
(3, 'Fredon02', 'OnwyBHohrdgYzH6]'),
(4, 'Stephanie03', 'K@BWyMQc!Zqe0DuA'),
(5, 'Baptiste07', 'Twf)O8ujFG6G8az4'),
(6, 'Eric01', 'pp4gUDBlN/a5NnGW'),
(7, 'Amelin02', 'oPUS5jib)dS9J7BL'),
(10, 'Serge01', '9oF*_r7oOmw0DmAw'),
(11, 'Vincent05', 'HG]jQMisfOtTLlCu'),
(12, 'Corinne06', 'V(vC6sMgOTkK3QKd'),
(13, 'Anna03', 'b@XoZfI77Vg4MfM6'),
(14, 'Julien07', 's.3V*mRX(tXKBy(W'),
(15, 'Benoit01', 'TIo44aAvZDEqvBwN'),
(16, 'Myriam02', 'aC/trG5c3G2zw1RH'),
(17, 'Christophe02', '[4L/o9ErSzgVXacM'),
(18, 'Daniel06', 'CpT(2EufAGMJ85wi'),
(19, 'Phillipe05', '[(r]EuKg49z_TJn_'),
(20, 'Ilaria01', '59qWlY[T/Jc)y76S');






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

INSERT INTO `etudiants` (`id`, `identifiant`, `motdepasse`,`formation`) VALUES
(1, 'Dupont02', 'd7uRg4()zm9HBPEG', 'LP'),
(2, 'Ablain01', 'd7uRg4()zm9HBPEG','DEUST'),
(3, 'Brionnaud01', 'Wf]/*/Ole3!e5k*q', 'LP'),
(4, 'Lalali01','jMR4f*Vt1[j6n4yW', 'LP'),
(5, 'Jonshon01', '@o0oV6c1jSa4mjJ.r','DEUST'),
(6, 'Guillon01', 'fHmj0BUgGo@wYM*j', 'LP'),
(7, 'Gautier01', '_*oVaVG*ic@58_xc', 'LP'),
(8, 'Fontaine02', 'PE8nFAn_uDU(pi3I', 'DEUST'),
(9, 'Martin02', '!E(BO-UaaD[0JtFl', 'LP'),
(10, 'Moreau02', 'p*3pGO_cq5Qkm(D5','LP'),
(11, 'Dubois03', '_)cnq!zvOxaXpZLA', 'LP'),
(12, 'Raynaud04', 'HBkJPy!x4xhoBC', 'DEUST'),
(13, 'Leblanc01','xoXF3xzZppAO@OFG', 'DEUST'),
(14, 'Petit01', '90@f4vcZY0aj_J(t',  'DEUST'),
(15, 'Sanchez02', 'rh6uPT4CiMCEA9Gl',  'LP'),
(16, 'Gomez01', ']umogwzPVErLa-dh',  'DEUST'),
(17, 'Olive02', 'x08)ysXUSaIeYvUp' , 'DEUST'),
(18, 'Durand01', 'Rw7Ev05oF!ChikvX',  'LP'),
(19, 'Nonde03', '8PGLhjlCQ!YvnWM9', 'LP'),
(20, 'Marchal01', 'EejTScO5[q9fjGDZ' , 'DEUST'),
(21, 'Etienne01', 'YywiNnE[.iUcP/iz' , 'LP'),
(22, 'Gillet02', 'yP)[rx[Hv!t_k87t' , 'LP'),
(23, 'Poulain03', 'RPS]]1GKSSkrcRXX' , 'DEUST'),
(24, 'Lemaitre01', 'WJJP@)9o5qz6WI[D' , 'LP'),
(25, 'Marechal01', 'ZRph8bjyTf2bR4wV' , 'DEUST'),
(26, 'Bernard02', 't6dL9kCunNgrtQG' , 'DEUST'),
(27, 'Bourgeois01', ']DwX7Di-d42lPtgZ' , 'DEUST'),
(28, 'Collin01', '3-3sIqw5d7CwKZa9' , 'DEUST'),
(29, 'Rodriguez02', 'O@R9_!aKS3X2mX2g' , 'LP'),
(30, 'Charpentier01', 'qYyQ*wncspZPbhbj' , 'DEUST'),
(31, 'Dupuis01', 'sPxXIE_VkJ@2@z))' , 'LP'),
(32, 'Deschamps01', 'o[xt2nY5*p8vavdM' , 'LP'),
(33, 'Leroux02', './mPuWV3]K*.(ywf' , 'DEUST'),
(34, 'Dupuy01', '*/VaxAfuJ8UzwQcD' , 'LP'),
(35, 'Morel02', 'uCPed[af]n@VWUi2' , 'DEUST'),
(36, 'Rousseau01', 'D*36b/z7!_S3Jtb)' , 'LP'),
(37, 'Joly01', 'R74uxTkG.I[Oda2g' , 'DEUST'),
(38, 'Renard02', 'zw(]MDAzy)Vc7Y7[' , 'DEUST'),
(39, 'Bourgeois02', '(K.ooEF02qq]DMkj' , 'LP'),
(40, 'Huet01', 'rTDB(gaXV0.mK.s-Z' , 'DEUST'),
(41, 'Picard02', 'AordUP1)Q7(RAcxN' , 'LP'),
(42, 'Lecompte03', 'OssZQX9/!U.wZnRo' , 'DEUST'),
(43, 'Camus01', '(EL!@2ySB4G/2*j5' , 'DEUST'),
(44, 'Clement01', 'P@7rcqtLNgbLYF/bZ' , 'LP'),
(45, 'Mercier02', '3IE-6MWRDKwj5kIs' , 'DEUST');




--
-- Index pour les tables déchargées
--

--
-- Index pour la table `cours`
--
ALTER TABLE `cours`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `enseignants`
--
ALTER TABLE `enseignants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

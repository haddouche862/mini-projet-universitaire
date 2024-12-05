-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Nov 10, 2021 at 02:16 PM
-- Server version: 5.7.24
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `UE_L204`
--

-- --------------------------------------------------------

--
-- Table structure for table `bibliotheque`
--

CREATE TABLE `bibliotheque` (
  `identifiant` int(11) NOT NULL,
  `auteur` varchar(50) NOT NULL,
  `titre` varchar(50) NOT NULL,
  `annee` int(11) NOT NULL,
  `exemplaires` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bibliotheque`
--

INSERT INTO `bibliotheque` (`identifiant`, `auteur`, `titre`, `annee`, `exemplaires`) VALUES
(1, 'Hugo', 'Notre-dame de Paris', '1831', '8'),
(2, 'Hugo', 'Les misérables', '1862', '5'),
(3, 'Hugo', 'Le Dernier Jour d\'un condamné', '1829', '4'),
(4, 'Zola', 'Germinal', '1885', '30'),
(5, 'Zola', 'La bête humaine', '1890', '11'),
(6, 'Steinbeck', 'Les raisins de la colère', '1939', '6'),
(7, 'Orwell', '1984', '1949', '12'),
(8, 'Orwell', 'La ferme des animaux', '1945', '3'),
(9, 'Fournier', 'Le grand Meaulnes', '1913', '25'),
(10, 'Stendhal', 'Le rouge et le noir', '1830', '2'),
(11, 'Flaubert', 'Madame Bovary', '1857', '50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bibliotheque`
--
ALTER TABLE `bibliotheque`
  ADD PRIMARY KEY (`identifiant`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bibliotheque`
--
ALTER TABLE `bibliotheque`
  MODIFY `identifiant` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

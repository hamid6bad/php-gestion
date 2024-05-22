-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 22, 2024 at 09:54 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gestion`
--

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `password`) VALUES
(1, 'yassin', 'yassin'),
(2, 'yassin', 'yassin');

-- --------------------------------------------------------

--
-- Table structure for table `stagiaire`
--

CREATE TABLE `stagiaire` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `branche` varchar(255) NOT NULL,
  `datee` date NOT NULL,
  `datedenaissance` date NOT NULL,
  `datedebut` date NOT NULL,
  `datefin` date NOT NULL,
  `diplome` varchar(255) NOT NULL,
  `demande` varchar(255) NOT NULL,
  `cv` varchar(255) NOT NULL,
  `assurance` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stagiaire`
--

INSERT INTO `stagiaire` (`id`, `nom`, `prenom`, `telephone`, `email`, `ville`, `branche`, `datee`, `datedenaissance`, `datedebut`, `datefin`, `diplome`, `demande`, `cv`, `assurance`) VALUES
(22, 'nouhaila', 'el habchi', '0000000', 'nouhailaelhabchi7@gmail.com', 'khenifra', 'development digital', '0000-00-00', '2004-07-16', '0000-00-00', '0000-00-00', 'pdf-test.pdf', 'pdf-test.pdf', 'pdf-test.pdf', 'pdf-test.pdf'),
(24, 'abdrazak', 'hamid', '0618103442', 'bad6hamid@gmail.com', 'AIT ISHAQ', 'development digital', '2024-05-11', '2003-04-07', '2024-04-22', '2024-05-18', 'pdf-test.pdf', 'pdf-test.pdf', 'pdf-test.pdf', 'pdf-test.pdf'),
(25, 'nouhaila', 'el habchi', '0000000', 'nouhailaelhabchi7@gmail.com', 'khenifra', 'development digital', '0000-00-00', '2004-07-16', '0000-00-00', '0000-00-00', 'pdf-test.pdf', 'pdf-test.pdf', 'pdf-test.pdf', 'pdf-test.pdf'),
(26, 'abdrazak', 'hamid', '0618103442', 'bad6hamid@gmail.com', 'AIT ISHAQ', 'development digital', '2024-05-11', '2003-04-07', '2024-04-22', '2024-05-18', 'pdf-test.pdf', 'pdf-test.pdf', 'pdf-test.pdf', 'pdf-test.pdf'),
(27, 'nouhaila', 'el habchi', '0000000', 'nouhailaelhabchi7@gmail.com', 'khenifra', 'development digital', '0000-00-00', '2004-07-16', '0000-00-00', '0000-00-00', 'pdf-test.pdf', 'pdf-test.pdf', 'pdf-test.pdf', 'pdf-test.pdf'),
(28, 'abdrazak', 'hamid', '0618103442', 'bad6hamid@gmail.com', 'AIT ISHAQ', 'development digital', '2024-05-11', '2003-04-07', '2024-04-22', '2024-05-18', 'pdf-test.pdf', 'pdf-test.pdf', 'pdf-test.pdf', 'pdf-test.pdf'),
(29, 'nouhaila', 'el habchi', '0000000', 'nouhailaelhabchi7@gmail.com', 'khenifra', 'development digital', '0000-00-00', '2004-07-16', '0000-00-00', '0000-00-00', 'pdf-test.pdf', 'pdf-test.pdf', 'pdf-test.pdf', 'pdf-test.pdf'),
(30, 'abdrazak', 'hamid', '0618103442', 'bad6hamid@gmail.com', 'AIT ISHAQ', 'development digital', '2024-05-11', '2003-04-07', '2024-04-22', '2024-05-18', 'pdf-test.pdf', 'pdf-test.pdf', 'pdf-test.pdf', 'pdf-test.pdf');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stagiaire`
--
ALTER TABLE `stagiaire`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stagiaire`
--
ALTER TABLE `stagiaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

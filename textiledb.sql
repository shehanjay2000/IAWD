-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2024 at 07:48 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `textiledb`
--

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int(10) NOT NULL,
  `name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(15) NOT NULL,
  `type` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `name`, `email`, `password`, `type`) VALUES
(2, 'shehan', '0', '12345', 'user'),
(3, 'shehan', '0', '12345', 'user'),
(4, 'shehan', '0', '12345', 'user'),
(5, 'shehan', '0', '1234', 'user'),
(6, 'shehan', '0', 'Srthgrhrth', 'user'),
(7, 'shehan', '0', '12345', 'user'),
(8, 'shehan', 'admin@gmail.com', '827ccb0eea8a706', 'user'),
(9, 'shehan', 'admin1@gmail.com', 'b0fe1b8be5b4b14', 'user'),
(10, 'ravindu', 'admin2@gmail.com', 'b0fe1b8be5b4b14', 'user'),
(11, 'fsfsff', 'admin11@gmail.com', '827ccb0eea8a706', 'user'),
(12, 'shehan', 'admin22@gmail.com', '827ccb0eea8a706', 'user'),
(13, 'sdfE', 'admin24@gmail.com', '827ccb0eea8a706', 'user'),
(14, 'gegergeg', 'shehanjay2000@gmail.com', 'gergegegergergg', 'user'),
(15, 't3r3t3', 'admin45@gmail.com', 'hg4hy34wffwfw', 'user'),
(16, 'anuraja', 'anurajathrunu@gmail.com', 'a2s3drfvt', 'user'),
(17, 'ravindu', 'dunusenura@gmail.com', 'crttreerghh', 'admin'),
(18, 'Ravindu', 'ravindu@gmail.com', '12345', 'admin'),
(19, 'visal', 'visal@gmail.com', '12345', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

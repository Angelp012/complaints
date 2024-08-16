-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2024 at 08:01 AM
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
-- Database: `signup`
--

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `complaintno` int(11) NOT NULL,
  `complaintdetails` mediumtext NOT NULL,
  `complaintfile` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `Admissionno` varchar(50) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`Admissionno`, `Email`, `Password`) VALUES
('scci/03781p', 'praiseangel61@gmail.com', '$2y$10$LvY/ff/Z.GsBbYuNF0awSOCLsko5J.lcRhQDyM9RbKYyLOBRMspgm'),
('scci/03781p/king', 'king@gmail.com', '$2y$10$9i38G9xJPwP7GmdQBmoAbeaNbUQ5aL9j0PSADoC9pa.udY198rK4i'),
('scii/123', 'apa@gmail.com', '$2y$10$MDKnHQebVkaOnnklgp/gvOPu5TVlocAhSXmvWe89kc8pdDlTI5TKW'),
('sccj/777', 'q@gmail.com', '$2y$10$icJWjHWIOBUkXNlqZXgM5uzS80msEul4J5MVitic/HRLypNN28YUG'),
('sccj/777', 'ap@gmail.com', '$2y$10$BqxmRo4Ntl2uzaIXP650O.5CrnrnGjhpxiRjRSat59va7AspcRpSK'),
('sccj/555', 'a@gmail.com', '$2y$10$DyegNOVWZus20ttxk1xRq.npbhnp2WPYsvciD.ZhfZbiXLioC8UbK');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`complaintno`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `complaintno` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

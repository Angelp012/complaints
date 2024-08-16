-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2024 at 09:06 PM
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
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `issue` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `password`, `issue`) VALUES
(1, 'kingori', '$2y$10$XSkIOci4MTu78xyvkSKB6eWzyE5p84ZJLL8GONH7qfCZbumQi0UHe', 'finance'),
(2, 'king', '$2y$10$Pywzrpz7DnkUNooyqEJkx.MNj6QyigT/1Wjfrnysi/3MecKb0dsqO', 'lecturer'),
(3, 'Angel Angoya', '$2y$10$EZp4lIhlXxEct7dWWL4BEux2t7a6TzacGaOmkVebHaRadcgC5O8gu', 'finance'),
(4, 'Angel Angoya', '$2y$10$oa3gvLsRDYgAwPjgUI53hOOS5xYZgT1JwNKFGUOwbWgLPw8Qup6Gq', 'exams'),
(5, 'ruth', '$2y$10$DdEJhDv6n8yQgV3uTWIWPuiLVfi9BIlVS8dhcItAmVphNHpi/Ts8O', 'exams'),
(6, 'Amy', '$2y$10$R0KHA0pr5mqyVhJDR6UbS.jScmpASErBOgzkwMEHDz/CJtnpIYasK', 'lecturer'),
(7, 'victor', '$2y$10$1efUncKig043v809b2quteU9IIsuqlM0qVcWxfygnEfZfmXHTnVHS', 'lecturer'),
(9, 'Grace', '$2y$10$dP7O3uIuD9cFSvYwx7jckuDQJYyMu58gCHHDph4xt2Gt74vFNRJXG', 'exams'),
(10, 'Peter', '$2y$10$z9hOovPZxLmS0nIWi.2NR.wAllW2b7dYU5wXD25lr1Hj/OXXIXoLm', 'finance');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `complaintno` int(11) NOT NULL,
  `complaintfile` varchar(255) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `complaint` varchar(200) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`complaintno`, `complaintfile`, `name`, `complaint`, `id`) VALUES
(1, '', 'smk,', 'sk', 0),
(2, '', 'smk,', 'sa', 0),
(3, '', 'smk,', 'al', 0),
(4, '', 'exams', 'test for exams', 0),
(5, '', 'finance', 'test for finance', 0),
(6, '', 'lecturer', 'test for lecturer', 0),
(7, '', 'exams', 'testfor exams', 0),
(8, '', 'finance', 'test2forresolution', 0),
(9, 'complaintdocs/admins.JPG', 'exams', 'trial run', 0),
(10, '', 'finance', 'fee not reflecting', 0),
(12, '', 'lecturer', 'show late', 5),
(13, '', 'lecturer', 'comes late', 5),
(14, '', 'lecturer', 'comes late', 5),
(15, '', 'finance', 'eir', 5),
(16, '', 'finance', 'we', 5),
(17, '', 'finance', 'not reflecting', 13),
(18, '', 'exams', 'did not sit for special', 13),
(19, 'complaintdocs/code design.PNG', 'finance', 'try', 13);

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int(20) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int(255) NOT NULL,
  `Admissionno` varchar(50) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `Admissionno`, `Email`, `Password`) VALUES
(5, 'sccj/777', 'ap@gmail.com', '$2y$10$BqxmRo4Ntl2uzaIXP650O.5CrnrnGjhpxiRjRSat59va7AspcRpSK'),
(13, 'SCCI/000/2020', 'suki@gmail.com', '$2y$10$qJ0YghuaMkrh9ZUW7nLs6.BQBluL.VcEIvFSGX3HvbGeL4kUsxUDe'),
(15, 'SCCI/111/2030', 'apa@students.tukenya.ac.ke', '$2y$10$Bvst6LiwneBFpSr4PTOBY.GivOLTN1MS.RL4QdIW0.1PyYYKcYr2m'),
(16, 'SCIE/222/2023', 'brenda@students.tukenya.ac.ke', '$2y$10$VF5GNxXSf1LCPg4VlxUNReBXhHEVbYVTwwys3.uZ8PKc3k8WUe.Va');

-- --------------------------------------------------------

--
-- Table structure for table `resolutions`
--

CREATE TABLE `resolutions` (
  `id` int(11) NOT NULL,
  `complaintno` int(11) DEFAULT NULL,
  `resolution` text DEFAULT NULL,
  `resolution_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resolutions`
--

INSERT INTO `resolutions` (`id`, `complaintno`, `resolution`, `resolution_date`) VALUES
(1, 6, 'test1', '2024-05-07 11:06:46'),
(2, 6, 'ok', '2024-05-11 09:39:45'),
(3, 6, 'ok', '2024-05-11 09:43:43'),
(4, 6, 'ok', '2024-05-11 09:43:56'),
(5, 6, 'ok', '2024-05-11 09:44:18'),
(6, 13, 'deal with it', '2024-05-11 09:52:04'),
(7, 12, 'come to d23', '2024-05-11 09:58:53'),
(8, 18, 'next exams are 4h june', '2024-05-12 19:43:53'),
(9, 9, 'ait', '2024-05-12 19:51:30'),
(10, 4, 'exam tomorrow', '2024-05-12 20:28:43'),
(11, 19, 'k', '2024-05-13 06:06:41');

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `course` varchar(255) DEFAULT NULL,
  `year` varchar(50) DEFAULT NULL,
  `degree` varchar(10) DEFAULT NULL CHECK (`degree` in ('Bachelor','Master','Diploma'))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`id`, `email`, `course`, `year`, `degree`) VALUES
(1, 'brenda@students.tukenya.ac.ke', 'ct', '2', 'Diploma');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`complaintno`),
  ADD KEY `fk_user_id` (`id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `resolutions`
--
ALTER TABLE `resolutions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `complaintno` (`complaintno`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `complaintno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `resolutions`
--
ALTER TABLE `resolutions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`id`) REFERENCES `registration` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `resolutions`
--
ALTER TABLE `resolutions`
  ADD CONSTRAINT `resolutions_ibfk_1` FOREIGN KEY (`complaintno`) REFERENCES `complaints` (`complaintno`);

--
-- Constraints for table `user_details`
--
ALTER TABLE `user_details`
  ADD CONSTRAINT `user_details_ibfk_1` FOREIGN KEY (`email`) REFERENCES `registration` (`Email`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2020 at 12:46 PM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `teamsys`
--

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `tname` varchar(255) NOT NULL,
  `lead_tname` varchar(255) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `tname`, `lead_tname`, `create_at`) VALUES
(1, 'WFH', 'Amir', '2020-05-02 20:57:59'),
(2, 'WFO', 'Hazim', '2020-05-02 21:00:49'),
(3, 'General Task', 'Saheen', '2020-05-03 06:57:56'),
(4, 'Development', 'Arya', '2020-05-03 09:26:01'),
(5, 'Tester', 'Zulfakar', '2020-05-03 10:42:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `uname` varchar(255) NOT NULL,
  `team_id` int(11) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uname`, `team_id`, `create_at`) VALUES
(1, 'Amirah', 1, '2020-05-02 20:58:40'),
(2, 'Jalil', 2, '2020-05-02 21:00:49'),
(3, 'Imran', 2, '2020-05-02 21:00:49'),
(4, 'Raju', 3, '2020-05-03 06:57:56'),
(5, 'Adila', 3, '2020-05-03 06:57:56'),
(6, 'Munirah', 3, '2020-05-03 06:57:56'),
(7, 'Saiful', 4, '2020-05-03 09:26:02'),
(8, 'Cindy', 4, '2020-05-03 09:26:02'),
(9, 'Ahmad', 4, '2020-05-03 09:26:02'),
(10, 'Zulkifli', 4, '2020-05-03 09:26:02'),
(11, 'Syahmi', 5, '2020-05-03 10:42:11'),
(12, 'Hanisah', 5, '2020-05-03 10:42:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_TeamsUsers` (`team_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_TeamsUsers` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

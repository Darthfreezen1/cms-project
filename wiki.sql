-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2019 at 08:55 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wiki`
--

-- --------------------------------------------------------

--
-- Table structure for table `changes`
--

CREATE TABLE `changes` (
  `id` int(11) NOT NULL,
  `pageid` int(11) NOT NULL,
  `comment` varchar(100) NOT NULL,
  `type` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `location` varchar(100) NOT NULL,
  `description` varchar(15000) NOT NULL,
  `attributes` varchar(200) DEFAULT NULL,
  `creator` varchar(30) NOT NULL,
  `type` varchar(50) NOT NULL,
  `image_path` varchar(200) DEFAULT NULL,
  `page_type` char(1) NOT NULL DEFAULT 'I'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `location`, `description`, `attributes`, `creator`, `type`, `image_path`, `page_type`) VALUES
(1, 'h', 'h', 'h', 'h', 'admin', 'Consumable', 'images\\items\\gfriesenSA1-pshprintstopped.png', 'I'),
(2, 'j', 'j', 'j', 'j', 'admin', 'Weapon', 'images\\items\\gfriesenDM2-PrintInstalled.png', 'I');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(61) NOT NULL,
  `type` char(1) NOT NULL DEFAULT 'U',
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `type`, `email`) VALUES
(1, 'test', '$2y$10$gKY09R3OOeIGXJorwE8XF.r', 'U', ''),
(2, 'testing', '$2y$10$0yUQqFPWIdSN65/.G.pGduF', 'U', ''),
(5, 'another', '$2y$10$jLu54QcFL.wIkvhCqlddEeUy1us/9zdPu2cgHrOCtmd.bNs45/UQu', 'A', ''),
(6, 'admin', '$2y$10$YDI05uzIUWXic2gQB8JpCubSQqKH24LFIeAAa53vjIEB1qka3JtEy', 'A', ''),
(7, 'normal', '$2y$10$KXF9Z0f14EGLTazD.ubj3uJppxoNlOTORU77QGM6pjN58e0IVIhKu', 'A', ''),
(8, 'a', '$2y$10$YXPCNHszprcZfqmiq1o0l.ROt.DF3sbHY2mvlwJbTMG3hoDGwdybC', 'A', ''),
(9, 'a', '$2y$10$xo1wS4EeW/mrYcttfGbpMuxHnIOwvzwZ8HulmNN9yy6FEeFzJuryi', 'A', 'a'),
(10, 'a', '$2y$10$QMgjeUEQLFEtMlHNWpq4NOlt9Xeo8/NprAldFihsac7XautOjzham', 'A', 'a'),
(11, 'a', '$2y$10$xSfY0nAsX1NrIEcyZSIVBOO3wB3nK3iNJRem2X50Ei3KH2zglxe0e', 'A', 'a'),
(12, 'a', '$2y$10$mxux9uT5yzlvCIuuvasLfe/t7nVurTXUooj/pbC7NKEo8Xp8aW/4u', 'A', 'a'),
(13, 'a', '$2y$10$hd/kMCFAlQZaQGhRadPELezv1VUW2eiZ8aRxJU1d.u5lD3glkPOzG', 'A', 'a'),
(14, 'a', '$2y$10$jzQRoghlCmLbvJc8zxllb.7P4rXeCRWtcMKevle93vt8sGzYl/nVu', 'A', 'a'),
(15, 'a', '$2y$10$UAlFE2z7J2aL113XxqTHVuTup6nXnbLBxjzJZPbsliuIDcfff/U9a', 'A', 'a'),
(16, 'a', '$2y$10$OCAQzfcUawIc6SVva1b.f.0SPMTok/eMIb2Mns6zWooNvhNgOx8VG', 'A', 'a'),
(17, 'asdassfdsfsafsaf', '$2y$10$pciXv8vIgczJv63e5C7jyu7iz9lHO/SH3H66kII3iQ1JPmZJF0rL6', 'U', 'sasdas'),
(18, 'sahkjhkjh', '$2y$10$AVd6MIzzi0meWCAvfl2s9.pgPvUiZZcuxSCODMsOPzJWTPvFEUdw.', 'U', 'a'),
(19, 'change', '$2y$10$DhlKISMzI/AMGTHDgpSwUeI5K8rwmh47N15/yFHLX8iC6boZAtfN2', 'A', 'change'),
(20, 'aa', '$2y$10$/vQCDCh6Qo6CuECg/RtWIuI7MT9l.lmUrls/2E9/Q8LdDLf/My2sG', 'A', 'aa'),
(21, 'aaa', '$2y$10$EiGtJlu0ab.1FoPOPfNw2uCZXHj92q2JqQCQJX0HeEzpN8VoSLUPS', 'A', 'aaa'),
(22, 'f', '$2y$10$FQJIdSWrQbtPXVp0Sp6wYeT9aafCjOn98jt5lpOGzheDNFOSpm1Nm', 'U', 'f'),
(23, 'g', '$2y$10$FaWL70h9kKyCotGzXsS35.tZD.5ZcvKQJix4jTn3kF6ZA/0ylNf8u', 'M', 'g'),
(24, 'h', '$2y$10$AWcSiZpj9MbtrKHafa/LweiG4feKI7qshZR9UBvCh2ZDkUsN6fsgm', 'U', 'h');

-- --------------------------------------------------------

--
-- Table structure for table `user_changes`
--

CREATE TABLE `user_changes` (
  `id` int(11) NOT NULL,
  `comment` varchar(1500) NOT NULL DEFAULT 'Requests Administrative Access',
  `pageid` int(11) DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL,
  `type` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `changes`
--
ALTER TABLE `changes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_changes`
--
ALTER TABLE `user_changes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `changes`
--
ALTER TABLE `changes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `user_changes`
--
ALTER TABLE `user_changes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

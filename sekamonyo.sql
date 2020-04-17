-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2018 at 10:14 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sekamonyo`
--

-- --------------------------------------------------------

--
-- Table structure for table `choirs`
--

CREATE TABLE `choirs` (
  `id` int(10) NOT NULL,
  `ch_name` varchar(100) NOT NULL,
  `ch_details` text NOT NULL,
  `ch_created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `choirs`
--

INSERT INTO `choirs` (`id`, `ch_name`, `ch_details`, `ch_created_at`) VALUES
(1, 'The Young Of Christ', 'The young of Christ Choir it\'s an SDA choir located in Eglise Francophone Goma-ville. ', '2018-11-10 18:24:48'),
(3, 'Lumiere Sda Choir', 'Lumiere choir it\'s an sda choir located in francophone goma ville sda church', '2018-11-12 17:41:35'),
(9, 'Sound Of Angels ', 'Maranatha sda church', '2018-11-14 17:08:32'),
(12, 'Nouvelle Jerusalem', 'Himbi sda church', '2018-11-14 17:15:25'),
(22, 'Agape Singers ', 'Himbi Sda church ', '2018-11-28 13:17:58');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(10) NOT NULL,
  `event_title` varchar(100) NOT NULL,
  `event_details` text NOT NULL,
  `event_date` varchar(100) NOT NULL,
  `event_choir_id` int(10) NOT NULL,
  `event_created_by` int(10) NOT NULL,
  `event_created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event_title`, `event_details`, `event_date`, `event_choir_id`, `event_created_by`, `event_created_at`) VALUES
(1, 'Trip To Naivasha', 'Demain nous sommes tous demander a venir avec le 400$ pour l\'organosation de notre concert\r\nDemain nous sommes tous demander a venir avec le 400$ pour l\'organosation de notre concert\r\nDemain nous sommes tous demander a venir avec le 400$ pour l\'organosation de notre concert\r\nDemain nous sommes tous demander a venir avec le 400$ pour l\'organosation de notre concert\r\nDemain nous sommes tous demander a venir avec le 400$ pour l\'organosation de notre concert\r\nDemain nous sommes tous demander a venir avec le 400$ pour l\'organosation de notre concert', '08/29/2018', 1, 7, '2018-11-19 11:51:41');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `msg_Id` int(10) NOT NULL,
  `msg_senderName` varchar(100) NOT NULL,
  `msg_senderEmail` varchar(100) NOT NULL,
  `msg_subject` varchar(150) NOT NULL,
  `msg_fullText` text NOT NULL,
  `msg_status` varchar(15) NOT NULL DEFAULT 'unread',
  `msg_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`msg_Id`, `msg_senderName`, `msg_senderEmail`, `msg_subject`, `msg_fullText`, `msg_status`, `msg_datetime`) VALUES
(7, 'Jeremie Ishimwe Sekamonyo', 'nkizinkikojeremie20@gmail.com', 'I want also to be a member of the young of christ choir', 'Good afternoon young of christ  since Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.\r\n\r\nThe standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham. ', 'read', '2018-11-28 11:57:38'),
(8, 'jeremie ishimwe', 'jeremieishimwe@outlook.fr', 'hello ', 'text', 'read', '2018-11-28 12:34:25');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `news_id` int(10) NOT NULL,
  `news_title` varchar(100) NOT NULL,
  `news_details` text NOT NULL,
  `news_choir_id` int(10) NOT NULL,
  `news_created_by` int(10) NOT NULL,
  `news_created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`news_id`, `news_title`, `news_details`, `news_choir_id`, `news_created_by`, `news_created_at`) VALUES
(8, 'Depatement de la discipline', 'Demain nous sommes tous demandÃ© a venir avec le 400$ pour l\'organisation de notre concert\r\nDemain nous sommes tous demandÃ© a venir avec le 400$ pour l\'organosation de notre concert\r\nDemain nous sommes tous demander a venir avec le 400$ pour l\'organosation de notre concert', 1, 7, '2018-11-27 03:41:13'),
(9, 'wmlfndbjbfsjkcndk hsnksc hsc babcvhaxbjcsvhgchzcbjsc sc skc zn sjc', 'nsjcbsicnksnbcjbjkankcbjbnclskcsxakjckjcjscvhscvscjsvcjscksbchbbzkxbjsvhxasjxknasbx baxs nbsx', 8, 7, '2018-11-28 13:23:58');

-- --------------------------------------------------------

--
-- Table structure for table `prayer`
--

CREATE TABLE `prayer` (
  `pray_id` int(10) NOT NULL,
  `pray_choir_id` varchar(100) NOT NULL,
  `pray_details` varchar(150) NOT NULL,
  `pray_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prayer`
--

INSERT INTO `prayer` (`pray_id`, `pray_choir_id`, `pray_details`, `pray_datetime`) VALUES
(1, '1', 'smnknjcbsjcbcxksnickseiehqiehqiqjiqdiidndjndiqndiqndiqndkqndjqbndjqbdqbdbqdjqd', '2018-11-27 22:06:30'),
(2, '1', 'smnknjcbsjcbcxksnicks', '2018-11-27 22:06:33');

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `song_id` int(10) NOT NULL,
  `song_title` varchar(100) NOT NULL,
  `song_photo` varchar(200) DEFAULT NULL,
  `song_lyrics` text NOT NULL,
  `song_choir_id` int(10) NOT NULL,
  `song_created_by` text NOT NULL,
  `song_created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`song_id`, `song_title`, `song_photo`, `song_lyrics`, `song_choir_id`, `song_created_by`, `song_created_at`) VALUES
(3, 'mj7j7juu', NULL, 'jmjmjjmjmmmjmjm', 1, 'k,i,imukukkkiliki', '2018-11-23 14:53:05'),
(4, 'mj7j7juu', NULL, 'jmjmjjmjmmmjmjm', 1, 'k,i,imukukkkiliki', '2018-11-23 14:53:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `choir` int(10) NOT NULL DEFAULT '0',
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `email`, `phone`, `type`, `choir`, `username`, `password`, `created_at`) VALUES
(7, 'Jeremie', 'Nkizinkiko', 'nkizinkikojeremie20@gmail.com', '+254743300247', 'Admin', 0, 'jeremie', '$2y$10$ByQ0TZsUHiqFxeNT6l0xyOC8G3Zq3UzxeXyd8SuUFsz2e0mXtU5Fa', '2018-11-12 19:12:24'),
(17, 'Imani', 'Daniel', 'dan@yahoo.com', '9917012654', 'Chorister', 1, 'imani daniel', '$2y$10$hmYLZNJlR8mAiiJl1dp6t.B3FTypYaasH/YAh/3uIou3PImtdP5vK', '2018-11-28 23:43:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `choirs`
--
ALTER TABLE `choirs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`msg_Id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`news_id`);

--
-- Indexes for table `prayer`
--
ALTER TABLE `prayer`
  ADD PRIMARY KEY (`pray_id`);

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`song_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `choirs`
--
ALTER TABLE `choirs`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `msg_Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `news_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `prayer`
--
ALTER TABLE `prayer`
  MODIFY `pray_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `song_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

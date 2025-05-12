-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3300
-- Generation Time: May 12, 2025 at 09:43 PM
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
-- Database: `contact_form`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `date_envoi` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `nom`, `email`, `message`, `date_envoi`) VALUES
(1, 1, 'Ismail', 'ali.samir.ismail03@gmail.com', 'ALI ISMAIL EPSI', '2025-05-12 12:42:16'),
(2, 1, 'Ismail', 'ali.samir.ismail03@gmail.com', 'My name is ali ismail 19', '2025-05-12 14:18:11'),
(3, 1, 'Ismail', 'ali.samir.ismail03@gmail.com', 'My name is ali ismail 19', '2025-05-12 14:24:26'),
(4, 1, 'ISMAIL', 'ali.samir.ismail03@gmail.com', 'memmememememeeemememememememe', '2025-05-12 14:33:27'),
(5, 1, 'Ismail', 'ali.samir.ismail03@gmail.com', 'Ali ISMAIL ALALALLALALA', '2025-05-12 14:35:41'),
(6, 1, 'Ali', 'ali.samir.ismail03@gmail.com', 'hello je suis etudiant a epsi et j etudie tres bien ici', '2025-05-12 14:40:24'),
(7, 1, 'Ali', 'ali.samir.ismail03@gmail.com', 'hababbabababaibibibibibibibib', '2025-05-12 14:42:51'),
(8, 1, 'ISMAIL', 'ali.samir.ismail03@gmail.com', 'HIIIIIIIIIIIIIIIIIIIIIIIII ANA WAEL LALLALA', '2025-05-12 14:45:02'),
(9, 1, 'ISMAIL', 'ali.samir.ismail03@gmail.com', '010101001010100101010101', '2025-05-12 14:50:27'),
(10, 1, 'Ismail', 'ali.samir.ismail03@gmail.com', 'lalallalalalal', '2025-05-12 16:26:17'),
(11, 1, 'ali', 'ali.samir.ismail03@gmail.com', 'je m apelle jejjejejej', '2025-05-12 16:27:55'),
(12, 1, 'roseline', 'ali.samir.ismail03@gmail.com', 'je m appelle roseline je vais a la salle chaque jour 2 fois ', '2025-05-12 16:29:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`) VALUES
(1, 'ali.samir.ismail03@gmail.com', '$2y$10$zsqtg3jTB1hNjr/Jj8YZAuLGxC3nt2qw1HbeG5OVENO.qlKAGP/le');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

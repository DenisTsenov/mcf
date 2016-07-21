-- phpMyAdmin SQL Dump
-- version 4.6.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 
-- Версия на сървъра: 10.1.13-MariaDB
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mcf`
--

-- --------------------------------------------------------

--
-- Структура на таблица `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `group_cat_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `date_added` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `category`
--

INSERT INTO `category` (`category_id`, `group_cat_id`, `name`, `description`, `active`, `date_added`) VALUES
(4, 4, 'php 7', 'all for it', 1, 1465894548),
(5, 5, 'c++ for  beginers', 'abc in  c++', 1, 1465894553),
(6, 6, 'php advance functions', 'php lambda', 1, 1465928514),
(8, 4, 'php 7 oop', 'objects and  classes', 1, 1467402867);

-- --------------------------------------------------------

--
-- Структура на таблица `group_cat`
--

CREATE TABLE `group_cat` (
  `group_cat_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `date_added` int(11) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `group_cat`
--

INSERT INTO `group_cat` (`group_cat_id`, `name`, `active`, `date_added`, `description`) VALUES
(4, 'php 7', 1, 1465590863, 'All for php oop!'),
(5, 'C++', 1, 1465590948, 'Всичко  за С++'),
(6, 'php advance', 1, 1465928399, 'php lambda  functions');

-- --------------------------------------------------------

--
-- Структура на таблица `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `date_added` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `view_count` int(11) NOT NULL,
  `edited_by` int(11) NOT NULL,
  `edited_when` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `posts`
--

INSERT INTO `posts` (`post_id`, `cat_id`, `added_by`, `date_added`, `title`, `content`, `view_count`, `edited_by`, `edited_when`) VALUES
(20, 4, 8, 1466018253, 'what new in php', 'php 7 is  done', 32, 0, '00:00:00'),
(23, 4, 8, 1466707100, 'dbdbfg', 'bfgngfngfngf', 32, 0, '00:00:00'),
(35, 4, 8, 1466713363, 'jstoto', '&lt;javascript&gt;', 32, 0, '00:00:00'),
(37, 4, 8, 1466713798, 'tema 2', 'opis  na  temata', 32, 0, '00:00:00'),
(48, 6, 8, 1467059556, 'Lambda!', 'How  to use  lambda func in php!', 32, 0, '00:00:00'),
(51, 5, 8, 1467317195, 'C++ for midel level', 'objects in C++', 0, 0, '00:00:00'),
(52, 7, 8, 1467402773, 'php 7 oop', 'methods and propertis', 0, 0, '00:00:00'),
(53, 4, 13, 1467576421, 'temata', 'na luchano', 0, 0, '00:00:00'),
(54, 4, 13, 1467576910, 'bfgngfngf', 'dbdfbfbfg', 0, 0, '00:00:00'),
(60, 4, 8, 1467744174, 'js in php', 'how to enter js code in php script', 0, 0, '00:00:00');

-- --------------------------------------------------------

--
-- Структура на таблица `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `pass` varchar(32) NOT NULL,
  `real_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `date_registred` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1',
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `user_ip` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `users`
--

INSERT INTO `users` (`user_id`, `login`, `pass`, `real_name`, `email`, `date_registred`, `type`, `active`, `user_ip`) VALUES
(8, 'denis', '827ccb0eea8a706c4c34a16891f84e7b', 'deniscenov', 'denis_cenov_@abv.bg', 1465566781, 3, 1, ''),
(9, 'mitaka', '827ccb0eea8a706c4c34a16891f84e7b', 'mitkodimotrow', 'mitaka@abv.bg', 1465990342, 1, 1, ''),
(13, 'luchano', '827ccb0eea8a706c4c34a16891f84e7b', 'luchano', 'lucho@abvb.bg', 1467237713, 1, 1, '::1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `group_cat_id` (`group_cat_id`);

--
-- Indexes for table `group_cat`
--
ALTER TABLE `group_cat`
  ADD PRIMARY KEY (`group_cat_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `group_cat`
--
ALTER TABLE `group_cat`
  MODIFY `group_cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

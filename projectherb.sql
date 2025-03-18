-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2025 at 03:51 AM
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
-- Database: `projectherb`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `commentID` int(11) NOT NULL,
  `herbID` int(11) NOT NULL,
  `userID` varchar(11) NOT NULL,
  `commentText` text NOT NULL,
  `timeAdded` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `featuredherb`
--

CREATE TABLE `featuredherb` (
  `featuredID` varchar(11) NOT NULL,
  `Date` date NOT NULL,
  `herbID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `healthconcerns`
--

CREATE TABLE `healthconcerns` (
  `concernID` int(11) NOT NULL,
  `concernName` varchar(20) NOT NULL,
  `herbID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `herb`
--

CREATE TABLE `herb` (
  `herbID` int(11) NOT NULL,
  `herbName` varchar(20) NOT NULL,
  `sideEffect` varchar(255) NOT NULL,
  `recommendedUsage` text NOT NULL,
  `Benefit` text NOT NULL,
  `heatlhConcerns` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `savedlist`
--

CREATE TABLE `savedlist` (
  `savedListID` int(11) NOT NULL,
  `userID` varchar(11) NOT NULL,
  `herbID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` varchar(11) NOT NULL,
  `Name` varchar(20) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `passwordHash` varchar(255) NOT NULL,
  `healthInterest` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`commentID`),
  ADD KEY `herbID` (`herbID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `featuredherb`
--
ALTER TABLE `featuredherb`
  ADD PRIMARY KEY (`featuredID`),
  ADD KEY `herbID` (`herbID`);

--
-- Indexes for table `healthconcerns`
--
ALTER TABLE `healthconcerns`
  ADD PRIMARY KEY (`concernID`),
  ADD KEY `herbID` (`herbID`);

--
-- Indexes for table `herb`
--
ALTER TABLE `herb`
  ADD PRIMARY KEY (`herbID`),
  ADD KEY `healthConcerns` (`heatlhConcerns`);

--
-- Indexes for table `savedlist`
--
ALTER TABLE `savedlist`
  ADD PRIMARY KEY (`savedListID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `herbID` (`herbID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

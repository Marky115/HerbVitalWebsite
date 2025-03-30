-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2025 at 08:25 PM
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
  `concernName` varchar(50) NOT NULL,
  `herbID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `healthconcerns`
--

INSERT INTO `healthconcerns` (`concernID`, `concernName`, `herbID`) VALUES
(1, 'Digestive Issues', 0),
(2, 'Immune Support', 0),
(3, 'Stress and Anxiety', 0),
(4, 'Inflammation and Pain', 0),
(5, 'Skin Health', 0),
(6, 'Sleep Disorders', 0),
(7, 'Cardiovascular Health', 0),
(8, 'Detoxification', 0);

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
  `heatlhConcerns` int(11) NOT NULL,
  `imagePath` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `herb`
--

INSERT INTO `herb` (`herbID`, `herbName`, `sideEffect`, `recommendedUsage`, `Benefit`, `heatlhConcerns`, `imagePath`) VALUES
(1, 'Peppermint', 'Possible heartburn', 'Tea or capsules', 'Helps with indigestion and bloating', 1, 'img/peppermint.jpg'),
(2, 'Ginger', 'Mild stomach upset', 'Tea or capsule', 'Alleviates nausea and aids digestion', 1, 'img/ginger.png'),
(3, 'Chamomile', 'Drowsiness', 'Tea', 'Relieves indigestion and promotes relaxation', 1, 'img/chamomile.jpg'),
(4, 'Fennel', 'Rare allergic reactions', 'Tea or raw', 'Reduces bloating and aids digestion', 1, 'img/fennel.jpg'),
(5, 'Lemon Balm', 'Rare allergic reactions', 'Tea or tincture', 'Helps with bloating and indigestion', 1, ''),
(6, 'Slippery Elm', 'Nausea (rare)', 'Tea or capsule', 'Soothes the stomach and digestive tract', 1, ''),
(7, 'Echinacea', 'Mild upset stomach', 'Tea or capsules', 'Boosts the immune system and helps fight infections', 2, ''),
(8, 'Elderberry', 'Diarrhea (rare)', 'Syrup or capsules', 'Supports the immune system and fights cold/flu symptoms', 2, ''),
(9, 'Astragalus', 'None reported', 'Capsules or powder', 'Enhances immune function and has anti-inflammatory properties', 2, ''),
(10, 'Garlic', 'Bad breath, body odor', 'Raw or capsules', 'Known to fight infections and support immune health', 2, ''),
(11, 'Andrographis', 'Stomach upset (rare)', 'Capsules or powder', 'Supports immune health and has antiviral properties', 2, ''),
(12, 'Reishi Mushroom', 'Dry mouth, dizziness', 'Capsules or extract', 'Boosts immune function and reduces inflammation', 2, ''),
(13, 'Ashwagandha', 'Drowsiness', 'Capsules or powder', 'Adaptogenic herb that helps reduce stress and anxiety', 3, ''),
(14, 'Valerian Root', 'Drowsiness, dizziness', 'Tea or capsule', 'Promotes relaxation and reduces anxiety', 3, ''),
(15, 'Holy Basil', 'None reported', 'Tea or capsules', 'Helps reduce stress and improve mood', 3, ''),
(16, 'Lavender', 'Skin irritation (rare)', 'Tea or essential oil', 'Reduces anxiety and promotes relaxation', 3, ''),
(17, 'Lemon Balm', 'Mild allergic reactions', 'Tea or tincture', 'Calms the nervous system and reduces anxiety', 3, ''),
(18, 'Passionflower', 'Drowsiness', 'Tea or capsules', 'Used to reduce anxiety and promote relaxation', 3, ''),
(19, 'Turmeric', 'Stomach upset (rare)', 'Capsule or extract', 'Known for its anti-inflammatory properties', 4, ''),
(20, 'Ginger', 'Mild stomach upset', 'Tea or capsule', 'Reduces pain and inflammation', 4, ''),
(21, 'Boswellia', 'Stomach upset', 'Capsules', 'Has anti-inflammatory and pain-relieving properties.', 4, ''),
(22, 'Willow Bark', 'Stomach upset, dizziness', 'Tea, Capsules', 'Used for pain relief and to reduce inflammation.', 4, ''),
(23, 'Devil’s Claw', 'Diarrhea, stomach upset', 'Capsules, Powder', 'Reduces inflammation and alleviates pain.', 4, ''),
(24, 'Capsaicin', 'Burning sensation, skin irritation', 'Cream, Capsules', 'Helps alleviate pain and reduce inflammation.', 4, ''),
(25, 'Aloe Vera', 'Allergic reactions in some.', 'Gel, Cream', 'Used for burns, acne, and skin irritation.', 5, ''),
(26, 'Calendula', 'Mild allergic reactions', 'Cream, Ointment', 'Heals wounds, reduces inflammation, and helps with skin conditions.', 5, ''),
(27, 'Tea Tree Oil', 'Skin irritation, allergic reactions', 'Essential Oil', 'Used for acne and fungal infections.', 5, ''),
(28, 'Lavender', 'Allergic reactions in some.', 'Essential Oil, Cream', 'Promotes skin healing and soothes irritation.', 5, ''),
(29, 'Chamomile', 'Mild allergic reactions', 'Cream, Tea', 'Calms skin and reduces inflammation.', 5, ''),
(30, 'Neem', 'Skin irritation, allergic reactions', 'Oil, Cream', 'Used to treat skin infections, acne, and rashes.', 5, ''),
(31, 'Valerian Root', 'Drowsiness,stomach upset', 'Capsule, tea, tincture', 'Promotes relaxation,reduces anxiety and improves sleep quality', 6, ''),
(32, 'Lavender', 'Skin irritation, mild allergic reaction', 'Tea, essential oil', 'Known for its anti-inflammatory properties and calming effects', 6, ''),
(33, 'Chamomile', 'Mild allergic reactions', 'Tincture, Tea', 'Aids relaxation and improves sleep quality', 6, ''),
(34, 'Passionflower', 'Confusion, dizziness', 'Tincture, tea, capsule', 'Promotes restful sleep and reduces anxiety', 6, ''),
(35, 'Lemon Balm', 'Nausea, skin irritation', 'Essential oil, tea', 'Aids in sleep and helps with digestive issues ', 6, ''),
(36, 'Hops', 'Drowsiness, hormonal effects', 'Tea, pillows (dried hops)', 'Reduces insomnia and calms the nervous system', 6, ''),
(37, 'Hawthorn Berry', 'Fatigue, dizziness, nausea', 'Capsules, tea', 'supports heart health and regulates blood pressure', 7, ''),
(38, 'Garlic', 'Bad Breath, stomach upset', 'Raw, powder, extract', 'Known to support immune health and reduce cholesterol', 7, ''),
(39, 'Turmeric', 'Stomach upsetm diarrhea', 'Powder, capsules', 'supports heart health and reduces inflammation', 7, ''),
(40, 'Ginger', 'Heartburn, mild allergic reaction', 'Fresh, tea, powder', 'Improves circulation and supports heart health', 7, ''),
(41, 'Cayenne Pepper', 'Burning sensation, sweating', 'Powder, extract', 'Boosts circulation of blood around the heart', 7, ''),
(42, 'Olive Leaf', 'Dizziness, headache', 'Capsules, tea', 'Reduces blood pressure and supports cardiovascular health', 7, ''),
(43, 'Milk Thistle', 'Mild laxative effect, bloating', 'Capsules, tea', 'Supports liver detox and regeneration', 8, ''),
(44, 'Dandelion Root', 'Mild allergic reactions', 'Tea, roasted (coffe substitute)', 'Promotes liver detox and body cleansing', 8, ''),
(45, 'Artichoke Leaf', 'Gas, bloating', 'Capsules, tea', 'Supports liver health and detoxification', 8, ''),
(46, 'Yellow Dock Root', 'Stomach upset, skin irritation', 'Tea, Capsules', 'Aids detoxification and supports liver function', 8, ''),
(47, 'Burdock Root', 'Mild allergic reactions', 'Cooked (as food), tea', 'Helps cleanse the liver and detoxify the body', 8, ''),
(48, 'Schisandra', 'Skin rash, heartburn', 'Powder, capsules', 'Supports liver detox and regeneration with antioxidant properties', 8, '');

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
  `healthInterest` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `Name`, `Email`, `passwordHash`, `healthInterest`) VALUES
('wennis', 'wener', 'haha@haha.com', '$2y$10$fqilOMzoF6vxr20yJj/hFOVBQZlZzfMjTG.c6yYwwTrGRZQuAXtrK', 0),
('wennis1', 'wener', 'haha@haha.ca', '$2y$10$BXuLnC3LKKgl7ieAun6.JuMeYr63tszU4NalOCV6UewSsqlT2hA4G', 2);

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
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `healthInterest` (`healthInterest`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

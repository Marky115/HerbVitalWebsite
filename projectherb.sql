-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2025 at 05:26 AM
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

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`commentID`, `herbID`, `userID`, `commentText`, `timeAdded`) VALUES
(15, 25, 'wennis', 'hello', '2025-04-02 20:09:19'),
(16, 25, 'wennis', 'bye', '2025-04-02 20:09:22'),
(17, 25, 'tehe1', 'hi', '2025-04-02 20:10:21'),
(18, 41, 'tehe1', 'hello', '2025-04-02 20:11:09'),
(19, 11, 'wennis', 'thats a you problem', '2025-04-05 02:55:40'),
(20, 11, 'wennis', 'yeah im talking to you', '2025-04-05 02:55:48'),
(21, 11, 'tehe1', 'thats what i thought', '2025-04-05 02:56:09'),
(22, 48, 'tehe1', 'testing', '2025-04-05 02:56:41'),
(23, 25, 'wennis', 'sup', '2025-04-05 03:07:44'),
(24, 45, 'wennis', 'taste bad', '2025-04-05 03:08:04'),
(25, 13, 'wennis', 'its too bitter for me turns my tongue yellow', '2025-04-05 03:08:25');

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
  `concernName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `healthconcerns`
--

INSERT INTO `healthconcerns` (`concernID`, `concernName`) VALUES
(1, 'Digestive Issues'),
(2, 'Immune Support'),
(3, 'Stress and Anxiety'),
(4, 'Inflammation and Pain'),
(5, 'Skin Health'),
(6, 'Sleep Disorders'),
(7, 'Cardiovascular Health'),
(8, 'Detoxification');

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
  `healthConcerns` int(11) NOT NULL,
  `imagePath` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `herb`
--

INSERT INTO `herb` (`herbID`, `herbName`, `sideEffect`, `recommendedUsage`, `Benefit`, `healthConcerns`, `imagePath`) VALUES
(1, 'Peppermint', 'Possible heartburn', 'Tea or capsules', 'Helps with indigestion and bloating', 1, 'img/peppermint.jpg'),
(2, 'Ginger', 'Mild stomach upset', 'Tea or capsule', 'Alleviates nausea and aids digestion', 1, 'img/ginger.png'),
(3, 'Chamomile', 'Drowsiness', 'Tea', 'Relieves indigestion and promotes relaxation', 1, 'img/chamomile.jpg'),
(4, 'Fennel', 'Rare allergic reactions', 'Tea or raw', 'Reduces bloating and aids digestion', 1, 'img/fennel.jpg'),
(5, 'Lemon Balm', 'Rare allergic reactions', 'Tea or tincture', 'Helps with bloating and indigestion', 1, 'img/lemonbalm.jpg'),
(6, 'Slippery Elm', 'Nausea (rare)', 'Tea or capsule', 'Soothes the stomach and digestive tract', 1, 'img/slipperyelm.jpg'),
(7, 'Echinacea', 'Mild upset stomach', 'Tea or capsules', 'Boosts the immune system and helps fight infections', 2, 'img/echinacea.jpg'),
(8, 'Elderberry', 'Diarrhea (rare)', 'Syrup or capsules', 'Supports the immune system and fights cold/flu symptoms', 2, 'img/elderberry.jpg'),
(9, 'Astragalus', 'None reported', 'Capsules or powder', 'Enhances immune function and has anti-inflammatory properties', 2, 'img/astragalus.jpg'),
(10, 'Garlic', 'Bad breath, body odor', 'Raw or capsules', 'Known to fight infections and support immune health', 2, 'img/garlic.jpg'),
(11, 'Andrographis', 'Stomach upset (rare)', 'Capsules or powder', 'Supports immune health and has antiviral properties', 2, 'img/Andrographis.png'),
(12, 'Reishi Mushroom', 'Dry mouth, dizziness', 'Capsules or extract', 'Boosts immune function and reduces inflammation', 2, 'img/reishi.jpg'),
(13, 'Ashwagandha', 'Drowsiness', 'Capsules or powder', 'Adaptogenic herb that helps reduce stress and anxiety', 3, 'img/ashwagandha.jpg'),
(14, 'Valerian Root', 'Drowsiness, dizziness', 'Tea or capsule', 'Promotes relaxation and reduces anxiety', 3, 'img/valerian.jpg'),
(15, 'Holy Basil', 'None reported', 'Tea or capsules', 'Helps reduce stress and improve mood', 3, 'img/holybasil.jpg'),
(16, 'Lavender', 'Skin irritation (rare)', 'Tea or essential oil', 'Reduces anxiety and promotes relaxation', 3, 'img/Lavender.jpg'),
(17, 'Lemon Balm', 'Mild allergic reactions', 'Tea or tincture', 'Calms the nervous system and reduces anxiety', 3, 'img/lemonbalm.jpg'),
(18, 'Passionflower', 'Drowsiness', 'Tea or capsules', 'Used to reduce anxiety and promote relaxation', 3, 'img/passionflower.jpg'),
(19, 'Turmeric', 'Stomach upset (rare)', 'Capsule or extract', 'Known for its anti-inflammatory properties', 4, 'img/turmeric.png'),
(20, 'Ginger', 'Mild stomach upset', 'Tea or capsule', 'Reduces pain and inflammation', 4, 'img/ginger.png'),
(21, 'Boswellia', 'Stomach upset', 'Capsules', 'Has anti-inflammatory and pain-relieving properties.', 4, 'img/Boswellia.png'),
(22, 'Willow Bark', 'Stomach upset, dizziness', 'Tea, Capsules', 'Used for pain relief and to reduce inflammation.', 4, 'img/willow.jpg'),
(23, 'Devil’s Claw', 'Diarrhea, stomach upset', 'Capsules, Powder', 'Reduces inflammation and alleviates pain.', 4, 'img/devilclaw.jpg'),
(24, 'Capsaicin', 'Burning sensation, skin irritation', 'Cream, Capsules', 'Helps alleviate pain and reduce inflammation.', 4, 'img/Capsaicin.jpg'),
(25, 'Aloe Vera', 'Allergic reactions in some.', 'Gel, Cream', 'Used for burns, acne, and skin irritation.', 5, 'img/aloe.jpg'),
(26, 'Calendula', 'Mild allergic reactions', 'Cream, Ointment', 'Heals wounds, reduces inflammation, and helps with skin conditions.', 5, 'img/Calendula.jpg'),
(27, 'Tea Tree Oil', 'Skin irritation, allergic reactions', 'Essential Oil', 'Used for acne and fungal infections.', 5, 'img/teatree.jpg'),
(28, 'Lavender', 'Allergic reactions in some.', 'Essential Oil, Cream', 'Promotes skin healing and soothes irritation.', 5, 'img/Lavender.jpg'),
(29, 'Chamomile', 'Mild allergic reactions', 'Cream, Tea', 'Calms skin and reduces inflammation.', 5, 'img/chamomile.jpg'),
(30, 'Neem', 'Skin irritation, allergic reactions', 'Oil, Cream', 'Used to treat skin infections, acne, and rashes.', 5, 'img/Neem.jpg'),
(31, 'Valerian Root', 'Drowsiness,stomach upset', 'Capsule, tea, tincture', 'Promotes relaxation,reduces anxiety and improves sleep quality', 6, 'img/valerian.jpg'),
(32, 'Lavender', 'Skin irritation, mild allergic reaction', 'Tea, essential oil', 'Known for its anti-inflammatory properties and calming effects', 6, 'img/Lavender.jpg'),
(33, 'Chamomile', 'Mild allergic reactions', 'Tincture, Tea', 'Aids relaxation and improves sleep quality', 6, 'img/chamomile.jpg'),
(34, 'Passionflower', 'Confusion, dizziness', 'Tincture, tea, capsule', 'Promotes restful sleep and reduces anxiety', 6, 'img/passionflower.jpg'),
(35, 'Lemon Balm', 'Nausea, skin irritation', 'Essential oil, tea', 'Aids in sleep and helps with digestive issues ', 6, 'img/lemonbalm.jpg'),
(36, 'Hops', 'Drowsiness, hormonal effects', 'Tea, pillows (dried hops)', 'Reduces insomnia and calms the nervous system', 6, 'img/hops.jpg'),
(37, 'Hawthorn Berry', 'Fatigue, dizziness, nausea', 'Capsules, tea', 'supports heart health and regulates blood pressure', 7, 'img/hawthorn.jpg'),
(38, 'Garlic', 'Bad Breath, stomach upset', 'Raw, powder, extract', 'Known to support immune health and reduce cholesterol', 7, 'img/garlic.jpg'),
(39, 'Turmeric', 'Stomach upsetm diarrhea', 'Powder, capsules', 'supports heart health and reduces inflammation', 7, 'img/turmeric.png'),
(40, 'Ginger', 'Heartburn, mild allergic reaction', 'Fresh, tea, powder', 'Improves circulation and supports heart health', 7, 'img/ginger.png'),
(41, 'Cayenne Pepper', 'Burning sensation, sweating', 'Powder, extract', 'Boosts circulation of blood around the heart', 7, 'img/cayenne.jpg'),
(42, 'Olive Leaf', 'Dizziness, headache', 'Capsules, tea', 'Reduces blood pressure and supports cardiovascular health', 7, 'img/oliveleaf.jpg'),
(43, 'Milk Thistle', 'Mild laxative effect, bloating', 'Capsules, tea', 'Supports liver detox and regeneration', 8, 'img/milkthistle.jpg'),
(44, 'Dandelion Root', 'Mild allergic reactions', 'Tea, roasted (coffe substitute)', 'Promotes liver detox and body cleansing', 8, 'img/dandelionRoot.jpg'),
(45, 'Artichoke Leaf', 'Gas, bloating', 'Capsules, tea', 'Supports liver health and detoxification', 8, 'img/Artichoke.jpg'),
(46, 'Yellow Dock Root', 'Stomach upset, skin irritation', 'Tea, Capsules', 'Aids detoxification and supports liver function', 8, 'img/YellowDock.jpg'),
(47, 'Burdock Root', 'Mild allergic reactions', 'Cooked (as food), tea', 'Helps cleanse the liver and detoxify the body', 8, 'img/burdock.jpg'),
(48, 'Schisandra', 'Skin rash, heartburn', 'Powder, capsules', 'Supports liver detox and regeneration with antioxidant properties', 8, 'img/Schisandra.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `savedlist`
--

CREATE TABLE `savedlist` (
  `userID` varchar(11) NOT NULL,
  `herbID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `savedlist`
--

INSERT INTO `savedlist` (`userID`, `herbID`) VALUES
('0', 11),
('0', 48),
('0', 45),
('0', 25),
('0', 13);

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
('rash1', 'rashy', 'rashy@gmail.com', '$2y$10$rebZuRZiEtlym8eoA8a3RuwyiyYZWLkS13aD3KkY1ym.8ODz9VTGu', 2),
('tehe1', 'rash', 'rash@gmaill.com', '$2y$10$Xe0g6fGohUXUdpb6UyeNDuQ5sY.pW1TGPwLy27i83gP9flIoCrey6', 1),
('wennis', 'wener', 'haha@haha.com', '$2y$10$fqilOMzoF6vxr20yJj/hFOVBQZlZzfMjTG.c6yYwwTrGRZQuAXtrK', 0),
('wenny', 'wenny', 'hihi@haha.com', '$2y$10$5F2/dRTCjUToDXd487jxuuCTMQL4m.mM5owhBR0oG5r18k/dZ8x.m', 8);

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
  ADD PRIMARY KEY (`concernID`);

--
-- Indexes for table `herb`
--
ALTER TABLE `herb`
  ADD PRIMARY KEY (`herbID`),
  ADD KEY `healthConcerns` (`healthConcerns`);

--
-- Indexes for table `savedlist`
--
ALTER TABLE `savedlist`
  ADD KEY `userID` (`userID`),
  ADD KEY `herbID` (`herbID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  DROP INDEX `healthInterest`,
  ADD PRIMARY KEY (`userID`),
  ADD INDEX `healthInterest` (`healthInterest`);


--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `commentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

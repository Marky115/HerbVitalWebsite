-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2025 at 04:58 AM
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
(8, 25, 'eva', 'qedfsa', '2025-04-06 23:25:03'),
(9, 25, 'eva', 'weFDS', '2025-04-06 23:25:07'),
(10, 25, 'eva', 'TY', '2025-04-06 23:25:10'),
(11, 25, 'eva', 'EWGDDRSFHHHHHHHHHHHHHHHHR STEHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHTESH            DTHSSSSSSSSSSSSSSSSSSSSSSSSSSSSS HTSSSSSSSSSE THSDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDD', '2025-04-06 23:27:03'),
(12, 7, 'eva', 'BEADFZVsafzv', '2025-04-06 23:27:31'),
(13, 25, 'eva', 'eagrsf', '2025-04-06 23:42:37'),
(14, 10, 'eva', 'taste spicy', '2025-04-06 23:43:06'),
(15, 10, 'eva', 'dont like', '2025-04-06 23:43:11'),
(16, 10, 'eva', 'upsets my stomache', '2025-04-06 23:43:20'),
(18, 22, 'wennis', 'taste like wood', '2025-04-08 01:51:56');

-- --------------------------------------------------------

--
-- Table structure for table `healthconcerns`
--

CREATE TABLE `healthconcerns` (
  `concernID` int(11) NOT NULL,
  `concernName` varchar(50) NOT NULL,
  `healthDesc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `healthconcerns`
--

INSERT INTO `healthconcerns` (`concernID`, `concernName`, `healthDesc`) VALUES
(1, 'Digestive Issues', 'Support a healthy gut with natural herbal remedies. These botanicals are traditionally used to soothe discomfort, aid digestion, and promote overall digestive wellness, helping you feel balanced and comfortable.'),
(2, 'Immune Support', 'Boost your body\'s natural defenses with the power of herbs. Known for their ability to fortify the immune system, these natural options can help you stay resilient and maintain good health throughout the year.'),
(3, 'Stress and Anxiety', 'Find natural calm and relaxation with traditional herbs. These botanicals are often used to ease tension, reduce anxiety, and promote a more peaceful state of mind, supporting your emotional well-being.'),
(4, 'Inflammation and Pain', 'Discover nature\'s solutions for managing discomfort. Certain herbs possess properties that may help reduce inflammation and alleviate pain, offering natural support for a more active and comfortable life.'),
(5, 'Skin Health', 'Nourish and support your skin naturally with herbal remedies. These botanicals are traditionally used to promote a healthy complexion, address various skin concerns, and enhance your natural radiance.'),
(6, 'Sleep Disorders', 'Encourage restful sleep with the gentle power of herbs. Traditionally used to calm the mind and promote healthy sleep patterns, these natural aids can help you achieve a more rejuvenating night\'s rest.'),
(7, 'Cardiovascular Health', 'Support a healthy heart and circulation with natural herbs. These botanicals are often used to maintain cardiovascular wellness and contribute to a balanced and energetic lifestyle.'),
(8, 'Detoxification', 'Gently cleanse and support your body\'s natural detoxification processes with selected herbs. These natural aids can assist in eliminating impurities and promoting overall internal balance.');

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
(21, 'Boswellia', 'Stomach upset', 'Capsules', 'Has anti-inflammatory and pain-relieving properties', 4, 'img/Boswellia.png'),
(22, 'Willow Bark', 'Stomach upset, dizziness', 'Tea, Capsules', 'Used for pain relief and to reduce inflammation', 4, 'img/willow.jpg'),
(23, 'Devil’s Claw', 'Diarrhea, stomach upset', 'Capsules, Powder', 'Reduces inflammation and alleviates pain', 4, 'img/devilclaw.jpg'),
(24, 'Capsaicin', 'Burning sensation, skin irritation', 'Cream, Capsules', 'Helps alleviate pain and reduce inflammation', 4, 'img/Capsaicin.jpg'),
(25, 'Aloe Vera', 'Allergic reactions in some.', 'Gel, Cream', 'Used for burns, acne, and skin irritation', 5, 'img/aloe.jpg'),
(26, 'Calendula', 'Mild allergic reactions', 'Cream, Ointment', 'Heals wounds, reduces inflammation, and helps with skin conditions', 5, 'img/Calendula.jpg'),
(27, 'Tea Tree Oil', 'Skin irritation, allergic reactions', 'Essential Oil', 'Used for acne and fungal infections', 5, 'img/teatree.jpg'),
(28, 'Lavender', 'Allergic reactions in some.', 'Essential Oil, Cream', 'Promotes skin healing and soothes irritation', 5, 'img/Lavender.jpg'),
(29, 'Chamomile', 'Mild allergic reactions', 'Cream, Tea', 'Calms skin and reduces inflammation', 5, 'img/chamomile.jpg'),
(30, 'Neem', 'Skin irritation, allergic reactions', 'Oil, Cream', 'Used to treat skin infections, acne, and rashes', 5, 'img/Neem.jpg'),
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
('wenny', 3),
('eva', 7),
('eva', 25),
('wennis', 45),
('wennis', 22);

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
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `Name`, `Email`, `passwordHash`, `healthInterest`) VALUES
('eva', 'eva', 'haha@haha.caewrf', '$2y$10$sTAa4HJx.maLlOqydOGaiuX8NloBRjazT3771PyO3MvbSJ0YsSn/G', '2,3,4,5,6'),
('wennis', 'wener', 'haha@haha.com', '$2y$10$T3pSlTJLspe4St/VVb5scur3upQTZyFvH3f3W5/uPtbtpnkzsjo96', '3,5,6');

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `commentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

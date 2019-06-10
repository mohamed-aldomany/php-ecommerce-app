-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2018 at 03:45 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE `categorie` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Ordering` int(11) DEFAULT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT '0',
  `Allow_comment` tinyint(4) NOT NULL DEFAULT '0',
  `Allow_ads` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`ID`, `Name`, `Description`, `Ordering`, `Visibility`, `Allow_comment`, `Allow_ads`) VALUES
(2, 'Electronics', 'contains hardware and software for developers', 1, 0, 0, 0),
(4, 'Mobiles', 'smart phones and tablets', 2, 0, 0, 0),
(5, 'Games', 'cd/online games', 3, 0, 0, 0),
(6, 'watch', 'classic and casual watch ', 4, 0, 0, 0),
(7, 'labtops', 'pcs and laptops for all uses ', 5, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `C_ID` int(11) NOT NULL,
  `C_Name` text NOT NULL,
  `C_Status` tinyint(4) NOT NULL DEFAULT '0',
  `C_Date` date NOT NULL,
  `UserID` int(11) NOT NULL,
  `itemID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`C_ID`, `C_Name`, `C_Status`, `C_Date`, `UserID`, `itemID`) VALUES
(3, 'my best mobile phone', 1, '2018-02-24', 8, 6),
(7, 'what is the available colors', 1, '2018-02-24', 12, 6),
(9, 'is the country made is france', 1, '2018-02-24', 7, 8);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Price` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Country` varchar(255) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Rating` smallint(6) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT '0',
  `Cat_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`ID`, `Name`, `Description`, `Price`, `Date`, `Country`, `Image`, `Status`, `Rating`, `Approve`, `Cat_ID`, `User_ID`) VALUES
(6, 'iphone 6', 'apple smartphones product', 11000, '2018-02-23', 'America', '', '1', 0, 1, 4, 7),
(8, 'television Samsung', 'LED / LCD TV ', 12000, '2018-02-24', 'Germany', '', '2', 0, 0, 2, 14),
(15, 'hp pavilion', 'icore 7,ram 6gb , hardisk : 1tera', 12000, '2018-03-05', 'egypt', '', '', 0, 0, 7, 14),
(16, 'rolex', 'ole rolex original made in america', 35000, '2018-03-05', 'egypt', '', '', 0, 0, 6, 13),
(17, 'omega', 'omega sa original made in italy', 50000, '2018-03-05', 'egypt', '', '', 0, 0, 6, 8),
(18, 'apple', 'icore 5 , ram:4gb , harddisk : 1tera', 24000, '2018-03-05', 'egypt', '', '', 0, 1, 7, 12),
(19, 'arduino board', 'arduino board made in china 3rd edition  ', 260, '2018-03-05', 'egypt', '', '', 0, 1, 2, 11),
(20, 'call of duty', 'ps4 action game ', 950, '2018-03-05', 'oman', '', '', 0, 0, 5, 15),
(21, 'GTAV', 'Pc computer game \"GtaV\".', 1150, '2018-03-05', '', '', '', 0, 0, 5, 16),
(22, 'samsung j7prime ', 'made in vitname color black ram 6gb ', 3500, '2018-03-05', '', '', '', 0, 0, 4, 8);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT '0',
  `TrustStatus` int(11) NOT NULL DEFAULT '0',
  `RegStatus` int(11) NOT NULL DEFAULT '0',
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `UserName`, `Password`, `Email`, `FullName`, `GroupID`, `TrustStatus`, `RegStatus`, `Date`) VALUES
(7, 'mostafa22', '250135a142b538760ccee6244dff05690f01cadb', 'mostafa@yahoo', 'mostafa abdo elsayed', 0, 0, 1, '2018-02-05'),
(8, 'rokya10', '0105b858898b7b7f307f6dda1fbeccb0c3aea670', 'rokya@yahoo', 'rokya abdo elsayed', 0, 0, 1, '2018-02-07'),
(9, 'mohamed', '292959f6c7ab4f8b0761469ac1f11fc73f43b306', 'mohamed@yahoo', 'mohamed abdo elsayed', 1, 0, 1, '2018-01-10'),
(11, 'jone', '2030fe011dbeeea051b9c237691f2c0b93148c68', 'jone@gmail', 'jone cena', 0, 0, 1, '2018-02-12'),
(12, 'fady', 'cac54a8f1052131c719d1433b8ea67ca7c432e36', 'fady@gmail.com', 'fady osman gamal', 0, 0, 1, '2018-02-19'),
(13, 'adel', 'd1b71236c6af50fb0e65345fb51b6437a6d4a4ed', 'adel@yahoo', 'adel ahmed taha', 0, 0, 1, '2018-02-20'),
(14, 'ali', '867d2b29bbd38bb6148cfc6183bbad313ae9ce83', 'ali@gmail.com', 'ali ahmed mohamed', 0, 0, 1, '2018-02-20'),
(15, 'loaiabd', '3e9b42127e45998bdbb987db275f67cd0d357653', 'loai@yahoo.com', 'loai mohamed ahemd', 0, 0, 1, '2018-02-25'),
(16, 'amr', 'f955d6d2f0ee4d4bf5800710865ea25fff635d32', 'amr@yahoo.com', 'amr ahmed ', 0, 0, 1, '2018-03-03'),
(17, 'karem50', 'kimokiko', 'kimo@yahoo.com', 'karem karm kimo', 0, 0, 0, '2018-03-24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`C_ID`),
  ADD KEY `item_comment` (`itemID`),
  ADD KEY `user_comment` (`UserID`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `categ` (`Cat_ID`),
  ADD KEY `user` (`User_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `UserName` (`UserName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `C_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `item_comment` FOREIGN KEY (`itemID`) REFERENCES `item` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_comment` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `categ` FOREIGN KEY (`Cat_ID`) REFERENCES `categorie` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user` FOREIGN KEY (`User_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

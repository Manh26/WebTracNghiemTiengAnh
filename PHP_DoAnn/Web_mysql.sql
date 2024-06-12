-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2024 at 06:52 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web1_mysql`
--
CREATE DATABASE IF NOT EXISTS `web1_mysql` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `web1_mysql`;

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE `exam` (
  `IdExam` int(11) NOT NULL,
  `ExamName` varchar(255) NOT NULL,
  `TestDate` date DEFAULT NULL,
  `TestTime` time DEFAULT NULL,
  `TotalQuestions` int(11) DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `IdQuestion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `UserID` int(11) NOT NULL,
  `UserName` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Role` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `IdQuestion` int(11) NOT NULL,
  `Question` varchar(255) NOT NULL,
  `AnswerA` varchar(255) DEFAULT NULL,
  `AnswerB` varchar(255) DEFAULT NULL,
  `AnswerC` varchar(255) DEFAULT NULL,
  `AnswerD` varchar(255) DEFAULT NULL,
  `CorrectAnswer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `userexamhistory`
--

CREATE TABLE `userexamhistory` (
  `UserExamHistoryID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `IdExam` int(11) DEFAULT NULL,
  `TestDate` date DEFAULT NULL,
  `StartTime` time DEFAULT NULL,
  `EndTime` time DEFAULT NULL,
  `Point` float DEFAULT NULL,
  `CorrectAnswers` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `userexams`
--

CREATE TABLE `userexams` (
  `UserIdExam` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `ExamName` varchar(50) NOT NULL,
  `Point` float DEFAULT NULL,
  `CorrectAnswer` int(11) DEFAULT NULL,
  `IdExam` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`IdExam`),
  ADD KEY `IdQuestion` (`IdQuestion`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`IdQuestion`);

--
-- Indexes for table `userexamhistory`
--
ALTER TABLE `userexamhistory`
  ADD PRIMARY KEY (`UserExamHistoryID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `IdExam` (`IdExam`);

--
-- Indexes for table `userexams`
--
ALTER TABLE `userexams`
  ADD PRIMARY KEY (`UserIdExam`),
  ADD KEY `IdExam` (`IdExam`),
  ADD KEY `UserID` (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `exam`
--
ALTER TABLE `exam`
  MODIFY `IdExam` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `IdQuestion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `userexamhistory`
--
ALTER TABLE `userexamhistory`
  MODIFY `UserExamHistoryID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `userexams`
--
ALTER TABLE `userexams`
  MODIFY `UserIdExam` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `exam`
--
ALTER TABLE `exam`
  ADD CONSTRAINT `exam_ibfk_1` FOREIGN KEY (`IdQuestion`) REFERENCES `questions` (`IdQuestion`);

--
-- Constraints for table `userexamhistory`
--
ALTER TABLE `userexamhistory`
  ADD CONSTRAINT `userexamhistory_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `login` (`UserID`),
  ADD CONSTRAINT `userexamhistory_ibfk_2` FOREIGN KEY (`IdExam`) REFERENCES `exam` (`IdExam`);

--
-- Constraints for table `userexams`
--
ALTER TABLE `userexams`
  ADD CONSTRAINT `userexams_ibfk_1` FOREIGN KEY (`IdExam`) REFERENCES `exam` (`IdExam`),
  ADD CONSTRAINT `userexams_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `login` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

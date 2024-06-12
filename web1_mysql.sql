-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 05, 2024 lúc 03:09 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `web1_mysql`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhmuc`
--

CREATE TABLE `danhmuc` (
  `Iddanhmuc` int(11) NOT NULL,
  `tendanhmuc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `danhmuc`
--

INSERT INTO `danhmuc` (`Iddanhmuc`, `tendanhmuc`) VALUES
(1, 'Đề Lớp 10'),
(2, 'Đề Lớp 12'),
(3, 'Đề lớp 11'),
(4, 'hehe');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `exam`
--

CREATE TABLE `exam` (
  `IdExam` int(11) NOT NULL,
  `ExamName` varchar(255) NOT NULL,
  `TestDate` date DEFAULT NULL,
  `TestTime` time DEFAULT NULL,
  `StartTime` date DEFAULT NULL,
  `TotalQuestions` int(11) DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `Iddanhmuc` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `exam`
--

INSERT INTO `exam` (`IdExam`, `ExamName`, `TestDate`, `TestTime`, `StartTime`, `TotalQuestions`, `Status`, `Iddanhmuc`) VALUES
(1, 'Câu Đồng Nghĩa', NULL, NULL, NULL, 50, NULL, 1),
(2, 'Câu Trái Nghĩa', NULL, NULL, NULL, 40, NULL, 2),
(3, 'Câu Trái Nghĩa', NULL, NULL, NULL, 50, NULL, 1),
(8, 'c', NULL, '00:00:40', NULL, 40, NULL, 1),
(9, 'HEHE', NULL, '00:00:30', NULL, 50, NULL, 2),
(10, 'hehe', NULL, '00:00:40', NULL, 40, NULL, 4),
(11, 'haha', NULL, '00:00:30', NULL, 40, NULL, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `login`
--

CREATE TABLE `login` (
  `UserID` int(11) NOT NULL,
  `UserName` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Role` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `login`
--

INSERT INTO `login` (`UserID`, `UserName`, `Password`, `Email`, `Role`) VALUES
(1, 'user1', '123', 'user@gmail.com', '1'),
(10, 'admin', 'admin', 'admin@gmail.com', '0'),
(17, 'manh1', '123', 'nh', '1'),
(18, 'minh', '123', 'minh', '1'),
(19, 'hui', '123', 'huy', '1'),
(20, 'ty', '123', 'tuui', '1'),
(21, 'tyu', '133', 'tyu', '1'),
(22, 'user1', 'aA1@1111', 'thanh@gmail.com', '1'),
(23, 'truc', '1@aAaaaa', 'truc@gmail.com', '1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `questions`
--

CREATE TABLE `questions` (
  `IdQuestion` int(11) NOT NULL,
  `Question` varchar(255) NOT NULL,
  `AnswerA` varchar(255) DEFAULT NULL,
  `AnswerB` varchar(255) DEFAULT NULL,
  `AnswerC` varchar(255) DEFAULT NULL,
  `AnswerD` varchar(255) DEFAULT NULL,
  `CorrectAnswer` varchar(255) NOT NULL,
  `IdExam` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `questions`
--

INSERT INTO `questions` (`IdQuestion`, `Question`, `AnswerA`, `AnswerB`, `AnswerC`, `AnswerD`, `CorrectAnswer`, `IdExam`) VALUES
(11, 'Perhaps more than anything else, it was (onerous) taxes that led to \'the Peasants\' Revolt in England in 1381.', 'multiple\r\n', 'unjust', 'burdensome', 'infamous', 'unjust', 2),
(13, 'It was (boiling) yesterday. We have a very humid and dry summer this year.', 'very hot', 'cooking ', 'dry', 'cooked', 'dry', 3),
(14, 'It was (inevitable) that the smaller company should merge with the larger one.', 'vital', 'unnecessary', 'urgent', 'unavoidable', 'vital', 1),
(15, ' He made one last (futile) effort to convince her and left home.', 'favorable', 'difficult', 'ineffectual', 'firm', 'favorable', 2),
(16, 'Most of the school-leavers are (sanguine) about the idea of going to work and earning money.', 'fearsome', 'expected ', 'excited', 'optimistic', 'expected    ', 3),
(17, ' The situation seems to be changing (minute by minute).', 'from time to time ', 'time after time', 'again and again', 'very rapidly', 'from time to time ', 1),
(18, 'HEHE', '1', '3', '5', '4', '4', 2),
(19, 'hrdhd', '1', 't4', 'h5', 'nt', '1', 8);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `userexamhistory`
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

--
-- Đang đổ dữ liệu cho bảng `userexamhistory`
--

INSERT INTO `userexamhistory` (`UserExamHistoryID`, `UserID`, `IdExam`, `TestDate`, `StartTime`, `EndTime`, `Point`, `CorrectAnswers`) VALUES
(188, NULL, 1, '2024-06-01', NULL, '03:25:44', 5, 1),
(189, NULL, 1, '2024-06-01', NULL, '03:26:23', 0, 0),
(190, NULL, 1, '2024-06-01', NULL, '03:26:32', 10, 2),
(191, NULL, 1, '2024-06-01', NULL, '03:27:14', 10, 2),
(192, NULL, 1, '2024-06-01', NULL, '03:27:29', 5, 1),
(193, NULL, 1, '2024-06-01', NULL, '03:29:01', 10, 2),
(194, NULL, 1, '2024-06-01', NULL, '03:30:22', 10, 2),
(195, NULL, 1, '2024-06-01', NULL, '03:30:29', 10, 2),
(196, 22, 3, '2024-06-01', '04:34:59', '04:35:04', 0, 0),
(197, 22, 1, '2024-06-01', '04:47:15', '04:47:19', 0, 0),
(198, 22, 1, '2024-06-01', '04:50:35', '04:50:38', 5, 1),
(199, 22, 1, '2024-06-01', '14:46:36', '14:46:47', 10, 2),
(200, 22, 3, '2024-06-01', '15:10:10', '15:10:46', 0, 0),
(201, 22, 1, '2024-06-01', '15:26:46', '15:26:51', 5, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `userexams`
--

CREATE TABLE `userexams` (
  `UserIdExam` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `ExamName` varchar(50) NOT NULL,
  `cautraloisai` text DEFAULT NULL,
  `dapandachon` text DEFAULT NULL,
  `Point` float DEFAULT NULL,
  `CorrectAnswer` int(11) DEFAULT NULL,
  `IdExam` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `danhmuc`
--
ALTER TABLE `danhmuc`
  ADD PRIMARY KEY (`Iddanhmuc`);

--
-- Chỉ mục cho bảng `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`IdExam`),
  ADD KEY `Iddanhmuc` (`Iddanhmuc`);

--
-- Chỉ mục cho bảng `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`UserID`);

--
-- Chỉ mục cho bảng `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`IdQuestion`),
  ADD KEY `IdExam` (`IdExam`);

--
-- Chỉ mục cho bảng `userexamhistory`
--
ALTER TABLE `userexamhistory`
  ADD PRIMARY KEY (`UserExamHistoryID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `IdExam` (`IdExam`);

--
-- Chỉ mục cho bảng `userexams`
--
ALTER TABLE `userexams`
  ADD PRIMARY KEY (`UserIdExam`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `IdExam` (`IdExam`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `danhmuc`
--
ALTER TABLE `danhmuc`
  MODIFY `Iddanhmuc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `exam`
--
ALTER TABLE `exam`
  MODIFY `IdExam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `login`
--
ALTER TABLE `login`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `questions`
--
ALTER TABLE `questions`
  MODIFY `IdQuestion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `userexamhistory`
--
ALTER TABLE `userexamhistory`
  MODIFY `UserExamHistoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT cho bảng `userexams`
--
ALTER TABLE `userexams`
  MODIFY `UserIdExam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `exam`
--
ALTER TABLE `exam`
  ADD CONSTRAINT `exam_ibfk_1` FOREIGN KEY (`Iddanhmuc`) REFERENCES `danhmuc` (`Iddanhmuc`);

--
-- Các ràng buộc cho bảng `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`IdExam`) REFERENCES `exam` (`IdExam`);

--
-- Các ràng buộc cho bảng `userexamhistory`
--
ALTER TABLE `userexamhistory`
  ADD CONSTRAINT `userexamhistory_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `login` (`UserID`),
  ADD CONSTRAINT `userexamhistory_ibfk_2` FOREIGN KEY (`IdExam`) REFERENCES `exam` (`IdExam`);

--
-- Các ràng buộc cho bảng `userexams`
--
ALTER TABLE `userexams`
  ADD CONSTRAINT `userexams_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `login` (`UserID`),
  ADD CONSTRAINT `userexams_ibfk_2` FOREIGN KEY (`IdExam`) REFERENCES `exam` (`IdExam`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

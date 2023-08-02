-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th8 02, 2023 lúc 04:55 PM
-- Phiên bản máy phục vụ: 10.6.14-MariaDB-cll-lve-log
-- Phiên bản PHP: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `xnioscom_dtbasm`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `Course`
--

CREATE TABLE `Course` (
  `CourseID` int(11) NOT NULL,
  `CourseCode` varchar(20) NOT NULL,
  `CourseName` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `Department` varchar(50) DEFAULT NULL,
  `CreditHours` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Đang đổ dữ liệu cho bảng `Course`
--

INSERT INTO `Course` (`CourseID`, `CourseCode`, `CourseName`, `Description`, `Department`, `CreditHours`) VALUES
(1, 'PIT', 'Programing 01', 'Programing New 01', 'IT123', 1000),
(2, 'DD01', 'Database Design', 'Database Design 01', 'IT234', 1000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `Enrollment`
--

CREATE TABLE `Enrollment` (
  `EnrollmentID` int(11) NOT NULL,
  `StudentID` int(11) DEFAULT NULL,
  `CourseID` int(11) DEFAULT NULL,
  `EnrollmentDate` date NOT NULL,
  `Grade` decimal(5,2) DEFAULT NULL CHECK (`Grade` >= 0 and `Grade` <= 100)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Đang đổ dữ liệu cho bảng `Enrollment`
--

INSERT INTO `Enrollment` (`EnrollmentID`, `StudentID`, `CourseID`, `EnrollmentDate`, `Grade`) VALUES
(2, 1, 1, '2023-08-23', 91.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `GradingComponent`
--

CREATE TABLE `GradingComponent` (
  `ComponentID` int(11) NOT NULL,
  `ComponentName` varchar(100) NOT NULL,
  `Weightage` decimal(5,2) NOT NULL CHECK (`Weightage` >= 0 and `Weightage` <= 100),
  `CourseID` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Đang đổ dữ liệu cho bảng `GradingComponent`
--

INSERT INTO `GradingComponent` (`ComponentID`, `ComponentName`, `Weightage`, `CourseID`) VALUES
(1, 'Assignment 1 Programing', 50.00, 1),
(2, 'Assignment 1 Programing', 50.00, 1),
(4, 'Assignment 1 Database', 50.00, 2),
(5, 'Assignment 2 Database', 50.00, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `Score`
--

CREATE TABLE `Score` (
  `ScoreID` int(11) NOT NULL,
  `StudentID` int(11) DEFAULT NULL,
  `ComponentID` int(11) DEFAULT NULL,
  `Marks` decimal(5,2) NOT NULL CHECK (`Marks` >= 0 and `Marks` <= 100)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Đang đổ dữ liệu cho bảng `Score`
--

INSERT INTO `Score` (`ScoreID`, `StudentID`, `ComponentID`, `Marks`) VALUES
(1, 1, 1, 1.00),
(2, 1, 1, 100.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `Student`
--

CREATE TABLE `Student` (
  `StudentID` int(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `StudentCode` varchar(255) NOT NULL,
  `DateOfBirth` date NOT NULL,
  `Gender` enum('Male','Female','Other') NOT NULL,
  `ContactNumber` varchar(20) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Address` text DEFAULT NULL,
  `EnrollmentStatus` enum('Active','Inactive') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Đang đổ dữ liệu cho bảng `Student`
--

INSERT INTO `Student` (`StudentID`, `FirstName`, `LastName`, `StudentCode`, `DateOfBirth`, `Gender`, `ContactNumber`, `Email`, `Address`, `EnrollmentStatus`) VALUES
(1, 'Nguyen', 'Xuan Nam', 'BH01234', '2004-05-23', 'Male', '0123456789', 'xuannam@edu.vn', 'Soc Son, Ha Noi', 'Active'),
(2, 'Nguyen', 'Ha Trung Phong', 'BH03456', '2004-01-01', 'Female', '0123456789', 'trungphong@edu.vn', 'Hai Duong, Viet Nam', 'Active');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`) VALUES
(1, 'admin', 'admin');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `Course`
--
ALTER TABLE `Course`
  ADD PRIMARY KEY (`CourseID`),
  ADD UNIQUE KEY `CourseCode` (`CourseCode`);

--
-- Chỉ mục cho bảng `Enrollment`
--
ALTER TABLE `Enrollment`
  ADD PRIMARY KEY (`EnrollmentID`),
  ADD UNIQUE KEY `StudentID` (`StudentID`,`CourseID`),
  ADD KEY `CourseID` (`CourseID`);

--
-- Chỉ mục cho bảng `GradingComponent`
--
ALTER TABLE `GradingComponent`
  ADD PRIMARY KEY (`ComponentID`),
  ADD KEY `CourseID` (`CourseID`);

--
-- Chỉ mục cho bảng `Score`
--
ALTER TABLE `Score`
  ADD PRIMARY KEY (`ScoreID`),
  ADD KEY `StudentID` (`StudentID`),
  ADD KEY `ComponentID` (`ComponentID`);

--
-- Chỉ mục cho bảng `Student`
--
ALTER TABLE `Student`
  ADD PRIMARY KEY (`StudentID`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `Course`
--
ALTER TABLE `Course`
  MODIFY `CourseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `Enrollment`
--
ALTER TABLE `Enrollment`
  MODIFY `EnrollmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `GradingComponent`
--
ALTER TABLE `GradingComponent`
  MODIFY `ComponentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `Score`
--
ALTER TABLE `Score`
  MODIFY `ScoreID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `Student`
--
ALTER TABLE `Student`
  MODIFY `StudentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

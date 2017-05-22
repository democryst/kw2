-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2017 at 04:34 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kw2_multi_doc`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `CommentID` int(11) NOT NULL,
  `Comment` longtext COLLATE utf8_unicode_ci NOT NULL,
  `CommentTime` datetime NOT NULL,
  `WFRequestDetailID` int(11) NOT NULL,
  `CommentBy` int(11) NOT NULL,
  `CommentTo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currentworklist`
--

CREATE TABLE `currentworklist` (
  `CurrentWorkListID` int(11) NOT NULL,
  `WFRequestDetailID` int(11) NOT NULL,
  `StateName` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `State` int(11) NOT NULL,
  `Priority` int(11) NOT NULL,
  `DoneBy` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  `StartTime` datetime NOT NULL,
  `EndTime` datetime NOT NULL,
  `ApproveStatus` int(11) NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `HistoryID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `WFRequestID` int(11) NOT NULL,
  `WFRequestDetailID` int(11) NOT NULL,
  `Comment` longtext COLLATE utf8_unicode_ci NOT NULL,
  `Priority` int(11) NOT NULL,
  `Late` int(11) NOT NULL,
  `WhatDone` int(11) NOT NULL,
  `TimeDone` datetime NOT NULL,
  `WFRequestDocID` text COLLATE utf8_unicode_ci NOT NULL,
  `WfdocType` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `priority`
--

CREATE TABLE `priority` (
  `PriorityID` int(11) NOT NULL,
  `Priority` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `priority`
--

INSERT INTO `priority` (`PriorityID`, `Priority`) VALUES
(1, 'Requester'),
(2, 'Approver'),
(3, 'Flow_Admin'),
(4, 'Sys_Admin');

-- --------------------------------------------------------

--
-- Table structure for table `ugroup`
--

CREATE TABLE `ugroup` (
  `GroupID` int(11) NOT NULL,
  `GroupName` varchar(250) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ugroup`
--

INSERT INTO `ugroup` (`GroupID`, `GroupName`) VALUES
(4, 'ICT Secretary'),
(5, 'ICT head'),
(6, 'ICT Teacher'),
(7, 'ICT Student');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `UserName` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `Name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `Surname` varchar(250) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `UserName`, `Password`, `Name`, `Surname`) VALUES
(1, 'Advisor_Boon', 'aaaa', 'Boon', 'Y'),
(2, 'Flow_admin', 'admin', 'PNAN', 'NAN'),
(3, 'Admin', 'admin', 'admin', 'admin'),
(4, 'Ekawit', 'aaaa', 'Dr.Ekawit', 'Nantajeewarawat'),
(5, 'Thanaruk ', 'aaaa', 'Dr.Thanaruk ', 'Theeramunkong'),
(6, 'Ravit', 'aaaa', 'Ravit', 'T'),
(7, '5622780674', 'aaaa', 'Pawit', 'Manussirivitaya'),
(31, 'aaaa01', 'aaaa', 'aaaa02', 'aaaa03'),
(32, 'TEST', 'aaaa', 'TEST', 'Register');

-- --------------------------------------------------------

--
-- Table structure for table `usergroup`
--

CREATE TABLE `usergroup` (
  `UserID` int(11) NOT NULL,
  `GroupID` int(11) NOT NULL,
  `UserGroupID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `usergroup`
--

INSERT INTO `usergroup` (`UserID`, `GroupID`, `UserGroupID`) VALUES
(4, 5, 6),
(1, 6, 7),
(4, 6, 8),
(6, 7, 9),
(7, 7, 10),
(31, 7, 12),
(32, 7, 13);

-- --------------------------------------------------------

--
-- Table structure for table `userpriority`
--

CREATE TABLE `userpriority` (
  `UserPriorityID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `PriorityID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `userpriority`
--

INSERT INTO `userpriority` (`UserPriorityID`, `UserID`, `PriorityID`) VALUES
(1, 7, 1),
(2, 1, 2),
(3, 2, 3),
(4, 3, 4),
(5, 4, 2),
(6, 5, 2),
(7, 6, 1),
(9, 31, 1),
(10, 32, 1);

-- --------------------------------------------------------

--
-- Table structure for table `wfaccess`
--

CREATE TABLE `wfaccess` (
  `WfAccessID` int(11) NOT NULL,
  `WFGenInfoID` int(11) NOT NULL,
  `WFDetailID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `GroupID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `wfaccess`
--

INSERT INTO `wfaccess` (`WfAccessID`, `WFGenInfoID`, `WFDetailID`, `UserID`, `GroupID`) VALUES
(156, 212, 200, 0, 7),
(157, 212, 201, 0, 6),
(158, 212, 202, 0, 5),
(159, 213, 203, 0, 7),
(160, 213, 204, 0, 6),
(161, 213, 205, 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `wfdetail`
--

CREATE TABLE `wfdetail` (
  `WFDetailID` int(11) NOT NULL,
  `ParentID` int(11) DEFAULT NULL,
  `StateName` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `CreateTime` text COLLATE utf8_unicode_ci NOT NULL,
  `ModifyTime` text COLLATE utf8_unicode_ci,
  `Deadline` text COLLATE utf8_unicode_ci,
  `WFDocID` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `WFGenInfoID` int(11) NOT NULL,
  `TemplateFileChose` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `wfdetail`
--

INSERT INTO `wfdetail` (`WFDetailID`, `ParentID`, `StateName`, `CreateTime`, `ModifyTime`, `Deadline`, `WFDocID`, `WFGenInfoID`, `TemplateFileChose`) VALUES
(200, 0, 'a_fileupload01', '04-26-14***2017-05-22', 'null', '0', 'a:2:{i:0;s:3:"210";i:1;s:3:"211";}', 212, 0),
(201, 200, 'b_fileupload01', '04-26-14***2017-05-22', 'null', '0', 'a:2:{i:0;s:3:"210";i:1;s:3:"211";}', 212, 1),
(202, 201, 'c_fileupload01', '04-26-14***2017-05-22', 'null', '0', 'a:2:{i:0;s:3:"210";i:1;s:3:"211";}', 212, 1),
(203, 0, 'a_kwform01', '04-28-34***2017-05-22', 'null', '0', 'a:2:{i:0;s:3:"212";i:1;s:3:"213";}', 213, 0),
(204, 203, 'b_kwform01', '04-28-34***2017-05-22', 'null', '0', 'a:2:{i:0;s:3:"212";i:1;s:3:"213";}', 213, 0),
(205, 204, 'c_kwform01', '04-28-34***2017-05-22', 'null', '0', 'a:2:{i:0;s:3:"212";i:1;s:3:"213";}', 213, 0);

-- --------------------------------------------------------

--
-- Table structure for table `wfdoc`
--

CREATE TABLE `wfdoc` (
  `WFDocID` int(11) NOT NULL,
  `WFGenInfoID` int(11) NOT NULL,
  `DocName` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `DocURL` longtext COLLATE utf8_unicode_ci NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `WfdocType` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `wfdoc`
--

INSERT INTO `wfdoc` (`WFDocID`, `WFGenInfoID`, `DocName`, `DocURL`, `TimeStamp`, `WfdocType`) VALUES
(210, 212, 'architectural-modelpptx', 'uploads/3_2017-05-22/architectural-model_1495419996.pptx', '2017-05-22 02:26:36', 0),
(211, 212, 'file65_cpe2013pdf', 'uploads/3_2017-05-22/file65_cpe2013_1495419996.pdf', '2017-05-22 02:26:36', 0),
(212, 213, 'kw1_form01', 'f52', '2017-05-22 02:30:05', 1),
(213, 213, 'kw1_form02', 'f51', '2017-05-22 02:30:05', 1);

-- --------------------------------------------------------

--
-- Table structure for table `wfgeninfo`
--

CREATE TABLE `wfgeninfo` (
  `WFGenInfoID` int(11) NOT NULL,
  `CreatorID` int(11) DEFAULT NULL,
  `CreateTime` text COLLATE utf8_unicode_ci NOT NULL,
  `WFInfoModifyID` int(11) DEFAULT NULL,
  `FormName` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `Description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `AdminID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `wfgeninfo`
--

INSERT INTO `wfgeninfo` (`WFGenInfoID`, `CreatorID`, `CreateTime`, `WFInfoModifyID`, `FormName`, `Description`, `AdminID`) VALUES
(212, NULL, '04-26-14***2017-05-22', NULL, 'Final Present01', 'file upload', 2),
(213, NULL, '04-28-34***2017-05-22', NULL, 'Final present 02', 'kw1', 2);

-- --------------------------------------------------------

--
-- Table structure for table `wfinfomodify`
--

CREATE TABLE `wfinfomodify` (
  `WFInfoModifyID` int(11) NOT NULL,
  `ModiferID` int(11) NOT NULL,
  `ModifyTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wfrequest`
--

CREATE TABLE `wfrequest` (
  `WFRequestID` int(11) NOT NULL,
  `CreatorID` int(11) NOT NULL,
  `CreateTime` text COLLATE utf8_unicode_ci NOT NULL,
  `FormName` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `Description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `AdminID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `wfrequest`
--

INSERT INTO `wfrequest` (`WFRequestID`, `CreatorID`, `CreateTime`, `FormName`, `Description`, `AdminID`) VALUES
(23, 6, '09-28-05***2017-05-22', 'Final Present01', 'file upload', 2),
(24, 6, '09-31-02***2017-05-22', 'Final present 02', 'kw1', 2);

-- --------------------------------------------------------

--
-- Table structure for table `wfrequestaccess`
--

CREATE TABLE `wfrequestaccess` (
  `WFRequestAccessID` int(11) NOT NULL,
  `WFRequestID` int(11) NOT NULL,
  `WFRequestDetailID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `GroupID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `wfrequestaccess`
--

INSERT INTO `wfrequestaccess` (`WFRequestAccessID`, `WFRequestID`, `WFRequestDetailID`, `UserID`, `GroupID`) VALUES
(48, 23, 48, 0, 7),
(49, 23, 49, 0, 6),
(50, 23, 50, 0, 5),
(51, 24, 51, 0, 7),
(52, 24, 52, 0, 6),
(53, 24, 53, 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `wfrequestdetail`
--

CREATE TABLE `wfrequestdetail` (
  `WFRequestDetailID` int(11) NOT NULL,
  `ParentID` int(11) NOT NULL,
  `StateName` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `CreateTime` text COLLATE utf8_unicode_ci NOT NULL,
  `ModifyTime` text COLLATE utf8_unicode_ci NOT NULL,
  `Deadline` text COLLATE utf8_unicode_ci NOT NULL,
  `WFRequestDocID` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `State` int(11) NOT NULL,
  `Priority` int(11) NOT NULL,
  `DoneBy` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  `StartTime` datetime NOT NULL,
  `EndTime` datetime NOT NULL,
  `WFRequestID` int(11) NOT NULL,
  `TemplateFileChose` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `wfrequestdetail`
--

INSERT INTO `wfrequestdetail` (`WFRequestDetailID`, `ParentID`, `StateName`, `CreateTime`, `ModifyTime`, `Deadline`, `WFRequestDocID`, `State`, `Priority`, `DoneBy`, `Status`, `StartTime`, `EndTime`, `WFRequestID`, `TemplateFileChose`) VALUES
(48, 0, 'a_fileupload01', '09-28-05***2017-05-22', '', '0', 'a:2:{i:0;s:2:"40";i:1;s:2:"41";}', 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 23, 0),
(49, 48, 'b_fileupload01', '09-28-05***2017-05-22', '', '0', 'a:2:{i:0;s:2:"40";i:1;s:2:"41";}', 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 23, 1),
(50, 49, 'c_fileupload01', '09-28-05***2017-05-22', '', '0', 'a:2:{i:0;s:2:"40";i:1;s:2:"41";}', 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 23, 1),
(51, 0, 'a_kwform01', '09-31-02***2017-05-22', '', '0', 'a:2:{i:0;s:2:"42";i:1;s:2:"43";}', 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 24, 0),
(52, 51, 'b_kwform01', '09-31-02***2017-05-22', '', '0', 'a:2:{i:0;s:2:"42";i:1;s:2:"43";}', 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 24, 0),
(53, 52, 'c_kwform01', '09-31-02***2017-05-22', '', '0', 'a:2:{i:0;s:2:"42";i:1;s:2:"43";}', 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 24, 0);

-- --------------------------------------------------------

--
-- Table structure for table `wfrequestdoc`
--

CREATE TABLE `wfrequestdoc` (
  `WFRequestDocID` int(11) NOT NULL,
  `WFRequestID` int(11) NOT NULL,
  `DocName` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `DocURL` longtext COLLATE utf8_unicode_ci NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `WFDocID` int(11) NOT NULL,
  `WFRequestDetailID` int(11) NOT NULL,
  `WfdocType` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wfrequestdoctemplate`
--

CREATE TABLE `wfrequestdoctemplate` (
  `WFRequestTemplateDocID` int(11) NOT NULL,
  `WFRequestID` int(11) NOT NULL,
  `DocName` varchar(250) NOT NULL,
  `DocURL` longtext NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `WFDocID` int(11) NOT NULL,
  `WfdocType` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `wfrequestdoctemplate`
--

INSERT INTO `wfrequestdoctemplate` (`WFRequestTemplateDocID`, `WFRequestID`, `DocName`, `DocURL`, `TimeStamp`, `WFDocID`, `WfdocType`) VALUES
(40, 23, 'architectural-modelpptx', 'uploads/3_2017-05-22/architectural-model_1495419996.pptx', '2017-05-22 02:26:36', 210, 0),
(41, 23, 'file65_cpe2013pdf', 'uploads/3_2017-05-22/file65_cpe2013_1495419996.pdf', '2017-05-22 02:26:36', 211, 0),
(42, 24, 'kw1_form01', 'item48', '2017-05-22 02:30:05', 212, 1),
(43, 24, 'kw1_form02', 'item49', '2017-05-22 02:30:05', 213, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`CommentID`),
  ADD KEY `WFRequestDetailID` (`WFRequestDetailID`),
  ADD KEY `CommentBy` (`CommentBy`);

--
-- Indexes for table `currentworklist`
--
ALTER TABLE `currentworklist`
  ADD PRIMARY KEY (`CurrentWorkListID`),
  ADD KEY `WFRequestDetailID` (`WFRequestDetailID`),
  ADD KEY `DoneBy` (`DoneBy`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`HistoryID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `WFRequestID` (`WFRequestID`),
  ADD KEY `WFRequestDetailID` (`WFRequestDetailID`);

--
-- Indexes for table `priority`
--
ALTER TABLE `priority`
  ADD PRIMARY KEY (`PriorityID`);

--
-- Indexes for table `ugroup`
--
ALTER TABLE `ugroup`
  ADD PRIMARY KEY (`GroupID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `usergroup`
--
ALTER TABLE `usergroup`
  ADD PRIMARY KEY (`UserGroupID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `GroupID` (`GroupID`);

--
-- Indexes for table `userpriority`
--
ALTER TABLE `userpriority`
  ADD PRIMARY KEY (`UserPriorityID`);

--
-- Indexes for table `wfaccess`
--
ALTER TABLE `wfaccess`
  ADD PRIMARY KEY (`WfAccessID`),
  ADD KEY `WFGenInfoID` (`WFGenInfoID`),
  ADD KEY `WFDetailID` (`WFDetailID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `GroupID` (`GroupID`);

--
-- Indexes for table `wfdetail`
--
ALTER TABLE `wfdetail`
  ADD PRIMARY KEY (`WFDetailID`),
  ADD KEY `ParentID` (`ParentID`),
  ADD KEY `WFDocID` (`WFDocID`),
  ADD KEY `WFGenInfoID` (`WFGenInfoID`);

--
-- Indexes for table `wfdoc`
--
ALTER TABLE `wfdoc`
  ADD PRIMARY KEY (`WFDocID`),
  ADD KEY `WFGenInfoID` (`WFGenInfoID`);

--
-- Indexes for table `wfgeninfo`
--
ALTER TABLE `wfgeninfo`
  ADD PRIMARY KEY (`WFGenInfoID`),
  ADD KEY `CreatorID` (`CreatorID`),
  ADD KEY `WFInfoModifyID` (`WFInfoModifyID`),
  ADD KEY `AdminID` (`AdminID`);

--
-- Indexes for table `wfinfomodify`
--
ALTER TABLE `wfinfomodify`
  ADD PRIMARY KEY (`WFInfoModifyID`),
  ADD KEY `ModiferID` (`ModiferID`);

--
-- Indexes for table `wfrequest`
--
ALTER TABLE `wfrequest`
  ADD PRIMARY KEY (`WFRequestID`),
  ADD KEY `CreatorID` (`CreatorID`),
  ADD KEY `AdminID` (`AdminID`);

--
-- Indexes for table `wfrequestaccess`
--
ALTER TABLE `wfrequestaccess`
  ADD PRIMARY KEY (`WFRequestAccessID`),
  ADD KEY `WFRequestID` (`WFRequestID`),
  ADD KEY `WFRequestDetailID` (`WFRequestDetailID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `GroupID` (`GroupID`);

--
-- Indexes for table `wfrequestdetail`
--
ALTER TABLE `wfrequestdetail`
  ADD PRIMARY KEY (`WFRequestDetailID`),
  ADD KEY `ParentID` (`ParentID`),
  ADD KEY `WFDocID` (`WFRequestDocID`),
  ADD KEY `DoneBy` (`DoneBy`),
  ADD KEY `WFRequestID` (`WFRequestID`);

--
-- Indexes for table `wfrequestdoc`
--
ALTER TABLE `wfrequestdoc`
  ADD PRIMARY KEY (`WFRequestDocID`),
  ADD KEY `WFRequestID` (`WFRequestID`);

--
-- Indexes for table `wfrequestdoctemplate`
--
ALTER TABLE `wfrequestdoctemplate`
  ADD PRIMARY KEY (`WFRequestTemplateDocID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `CommentID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `currentworklist`
--
ALTER TABLE `currentworklist`
  MODIFY `CurrentWorkListID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `HistoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `priority`
--
ALTER TABLE `priority`
  MODIFY `PriorityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `ugroup`
--
ALTER TABLE `ugroup`
  MODIFY `GroupID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `usergroup`
--
ALTER TABLE `usergroup`
  MODIFY `UserGroupID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `userpriority`
--
ALTER TABLE `userpriority`
  MODIFY `UserPriorityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `wfaccess`
--
ALTER TABLE `wfaccess`
  MODIFY `WfAccessID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;
--
-- AUTO_INCREMENT for table `wfdetail`
--
ALTER TABLE `wfdetail`
  MODIFY `WFDetailID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;
--
-- AUTO_INCREMENT for table `wfdoc`
--
ALTER TABLE `wfdoc`
  MODIFY `WFDocID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;
--
-- AUTO_INCREMENT for table `wfgeninfo`
--
ALTER TABLE `wfgeninfo`
  MODIFY `WFGenInfoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;
--
-- AUTO_INCREMENT for table `wfinfomodify`
--
ALTER TABLE `wfinfomodify`
  MODIFY `WFInfoModifyID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wfrequest`
--
ALTER TABLE `wfrequest`
  MODIFY `WFRequestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `wfrequestaccess`
--
ALTER TABLE `wfrequestaccess`
  MODIFY `WFRequestAccessID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT for table `wfrequestdetail`
--
ALTER TABLE `wfrequestdetail`
  MODIFY `WFRequestDetailID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT for table `wfrequestdoc`
--
ALTER TABLE `wfrequestdoc`
  MODIFY `WFRequestDocID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `wfrequestdoctemplate`
--
ALTER TABLE `wfrequestdoctemplate`
  MODIFY `WFRequestTemplateDocID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`WFRequestDetailID`) REFERENCES `wfrequestdetail` (`WFRequestDetailID`);

--
-- Constraints for table `currentworklist`
--
ALTER TABLE `currentworklist`
  ADD CONSTRAINT `currentworklist_ibfk_1` FOREIGN KEY (`WFRequestDetailID`) REFERENCES `wfrequestdetail` (`WFRequestDetailID`);

--
-- Constraints for table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_ibfk_1` FOREIGN KEY (`WFRequestDetailID`) REFERENCES `wfrequestdetail` (`WFRequestDetailID`),
  ADD CONSTRAINT `history_ibfk_2` FOREIGN KEY (`WFRequestID`) REFERENCES `wfrequest` (`WFRequestID`);

--
-- Constraints for table `wfaccess`
--
ALTER TABLE `wfaccess`
  ADD CONSTRAINT `wfaccess_ibfk_1` FOREIGN KEY (`WFGenInfoID`) REFERENCES `wfgeninfo` (`WFGenInfoID`),
  ADD CONSTRAINT `wfaccess_ibfk_2` FOREIGN KEY (`WFDetailID`) REFERENCES `wfdetail` (`WFDetailID`);

--
-- Constraints for table `wfdetail`
--
ALTER TABLE `wfdetail`
  ADD CONSTRAINT `wfdetail_ibfk_2` FOREIGN KEY (`WFGenInfoID`) REFERENCES `wfgeninfo` (`WFGenInfoID`);

--
-- Constraints for table `wfdoc`
--
ALTER TABLE `wfdoc`
  ADD CONSTRAINT `wfdoc_ibfk_1` FOREIGN KEY (`WFGenInfoID`) REFERENCES `wfgeninfo` (`WFGenInfoID`);

--
-- Constraints for table `wfgeninfo`
--
ALTER TABLE `wfgeninfo`
  ADD CONSTRAINT `wfgeninfo_ibfk_1` FOREIGN KEY (`WFInfoModifyID`) REFERENCES `wfinfomodify` (`WFInfoModifyID`);

--
-- Constraints for table `wfrequestaccess`
--
ALTER TABLE `wfrequestaccess`
  ADD CONSTRAINT `wfrequestaccess_ibfk_1` FOREIGN KEY (`WFRequestID`) REFERENCES `wfrequest` (`WFRequestID`),
  ADD CONSTRAINT `wfrequestaccess_ibfk_2` FOREIGN KEY (`WFRequestDetailID`) REFERENCES `wfrequestdetail` (`WFRequestDetailID`);

--
-- Constraints for table `wfrequestdetail`
--
ALTER TABLE `wfrequestdetail`
  ADD CONSTRAINT `wfrequestdetail_ibfk_4` FOREIGN KEY (`WFRequestID`) REFERENCES `wfrequest` (`WFRequestID`);

--
-- Constraints for table `wfrequestdoc`
--
ALTER TABLE `wfrequestdoc`
  ADD CONSTRAINT `wfrequestdoc_ibfk_1` FOREIGN KEY (`WFRequestID`) REFERENCES `wfrequest` (`WFRequestID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

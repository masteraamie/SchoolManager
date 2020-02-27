-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2017 at 09:03 AM
-- Server version: 5.6.21
-- PHP Version: 5.5.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `school_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_assignments`
--

CREATE TABLE IF NOT EXISTS `tbl_assignments` (
`AssignmentID` int(11) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Description` text NOT NULL,
  `File` text NOT NULL,
  `ClassID` int(11) NOT NULL,
  `SectionID` int(11) NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `DOS` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_assignments`
--

INSERT INTO `tbl_assignments` (`AssignmentID`, `Title`, `Description`, `File`, `ClassID`, `SectionID`, `SubjectID`, `DOS`) VALUES
(1, 'Assignment 1', 'Hello This is a good assignment', '', 21, 6, 3, '2017-04-13'),
(2, 'Assignment 1', 'Hello How are you', './uploads/assignments/2.jpg', 21, 6, 3, '2017-04-21');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_batches`
--

CREATE TABLE IF NOT EXISTS `tbl_batches` (
`BatchID` int(11) NOT NULL,
  `Year` year(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_batches`
--

INSERT INTO `tbl_batches` (`BatchID`, `Year`) VALUES
(4, 2017);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_book_details`
--

CREATE TABLE IF NOT EXISTS `tbl_book_details` (
`SerialID` int(11) NOT NULL,
  `BookID` varchar(30) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Category` varchar(30) NOT NULL,
  `DOReg` date NOT NULL,
  `Status` tinyint(4) NOT NULL DEFAULT '0',
  `DOIssue` date NOT NULL,
  `DORet` date NOT NULL,
  `IssuedTo` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_book_details`
--

INSERT INTO `tbl_book_details` (`SerialID`, `BookID`, `Name`, `Category`, `DOReg`, `Status`, `DOIssue`, `DORet`, `IssuedTo`) VALUES
(3, 'SBS/BOOK/1001', 'Abra Kadabra', 'Science fiction', '2017-03-23', 1, '2017-03-29', '2017-03-31', 'SBS0006');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_circulars`
--

CREATE TABLE IF NOT EXISTS `tbl_circulars` (
`CircularID` int(11) NOT NULL,
  `Subject` varchar(100) NOT NULL,
  `Date` date NOT NULL,
  `Description` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_circulars`
--

INSERT INTO `tbl_circulars` (`CircularID`, `Subject`, `Date`, `Description`) VALUES
(1, 'Fee Raise', '2017-03-06', 'The fee is to be raised\r\nNow');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_classes`
--

CREATE TABLE IF NOT EXISTS `tbl_classes` (
`ClassID` int(11) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `MinAttendance` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_classes`
--

INSERT INTO `tbl_classes` (`ClassID`, `Name`, `MinAttendance`) VALUES
(1, 'Class 1', 89),
(2, 'Class 2', 80),
(3, 'Class 3', 87);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_departments`
--

CREATE TABLE IF NOT EXISTS `tbl_departments` (
`DepartmentID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_departments`
--

INSERT INTO `tbl_departments` (`DepartmentID`, `Name`) VALUES
(4, 'Library Management');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_designations`
--

CREATE TABLE IF NOT EXISTS `tbl_designations` (
`DesignationID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_designations`
--

INSERT INTO `tbl_designations` (`DesignationID`, `Name`) VALUES
(1, 'Manager'),
(2, 'Teacher');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee_details`
--

CREATE TABLE IF NOT EXISTS `tbl_employee_details` (
`EmployeeID` int(11) NOT NULL,
  `FirstName` varchar(30) NOT NULL,
  `MiddleName` varchar(30) DEFAULT NULL,
  `LastName` varchar(30) DEFAULT NULL,
  `Address` text NOT NULL,
  `DOB` date NOT NULL,
  `Gender` varchar(10) NOT NULL,
  `Contact` varchar(30) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `DOJ` date NOT NULL,
  `DepartmentID` int(11) NOT NULL,
  `DesignationID` int(11) NOT NULL,
  `Qualification` varchar(30) NOT NULL,
  `Experience` varchar(30) NOT NULL,
  `Salary` int(11) NOT NULL,
  `Photo` text,
  `Status` int(11) NOT NULL,
  `DOR` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_employee_details`
--

INSERT INTO `tbl_employee_details` (`EmployeeID`, `FirstName`, `MiddleName`, `LastName`, `Address`, `DOB`, `Gender`, `Contact`, `Email`, `DOJ`, `DepartmentID`, `DesignationID`, `Qualification`, `Experience`, `Salary`, `Photo`, `Status`, `DOR`) VALUES
(1, 'Aamir', 'Amin', 'Dar', 'Rainawari', '2017-03-15', 'male', '9798798798', 'masteraa@kymail.com', '2017-03-16', 4, 1, 'B.ed', '3 years', 20000, './uploads/employees/Aamir1.jpg', 0, '0000-00-00'),
(3, 'Aamir', 'Amin', 'Dar', 'Rainawari', '2017-03-02', 'male', '9798798798', 'masteraaaa@kymail.com', '2017-03-01', 4, 2, 'Bed', '3 years', 30000, './uploads/employees/Aamir3.png', 0, '0000-00-00'),
(4, 'Aamir', 'Amin', 'Dar', 'Rainawari', '2017-03-13', 'male', '9798798798', 'mastermmaaaa@kymail.com', '2017-03-02', 4, 2, 'Bed', '3 years', 5000, './uploads/employees/Aamir4.png', 0, '0000-00-00'),
(5, 'Aamir', 'Amin', 'Dar', 'Rainawari', '2017-03-13', 'male', '9798798798', 'mastermmaaama@kymail.com', '2017-03-03', 4, 3, 'Bed', '3 years', 2000, './uploads/employees/Aamir5.png', 0, '0000-00-00'),
(6, 'Aamir', 'Amin', 'Dar', 'Rainawari', '2017-03-06', 'male', '9798798798', 'mastermmmaaama@kymail.com', '2017-03-03', 4, 2, 'Bed', '3 years', 1000, './uploads/employees/Aamir6.png', 0, '0000-00-00'),
(7, 'Aamir', 'Amin', 'Dar', 'Rainawari', '2017-03-01', 'male', '9798798798', 'mastermmmamaama@kymail.com', '2017-03-04', 4, 3, 'Bed', '3 years', 0, './uploads/employees/Aamir7.png', 0, '0000-00-00'),
(8, 'Aamir', 'Amin', 'Dar', 'Rainawari', '2017-03-05', 'male', '9798798798', 'mastnermmmamaama@kymail.com', '2017-03-04', 4, 3, 'Bed', '3 years', 0, './uploads/employees/Aamir8.png', 0, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee_login`
--

CREATE TABLE IF NOT EXISTS `tbl_employee_login` (
  `EmployeeID` int(11) NOT NULL,
  `LoginID` varchar(30) NOT NULL,
  `Password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_employee_login`
--

INSERT INTO `tbl_employee_login` (`EmployeeID`, `LoginID`, `Password`) VALUES
(4, 'Aamir4', '123456'),
(5, 'Aamir5', '123456'),
(6, 'Aamir6', '123456'),
(7, 'Aamir7', '123456'),
(8, 'Aamir8', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_events`
--

CREATE TABLE IF NOT EXISTS `tbl_events` (
`EventID` int(11) NOT NULL,
  `EventTypeID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Description` text NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL,
  `Organiser` varchar(100) NOT NULL,
  `EventFor` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_events`
--

INSERT INTO `tbl_events` (`EventID`, `EventTypeID`, `Name`, `Description`, `StartDate`, `EndDate`, `Organiser`, `EventFor`) VALUES
(1, 0, 'New Year', 'Awesome Event', '2017-03-28', '2017-03-31', 'Anwar', 0),
(2, 0, 'New Year', 'New Year Party', '2017-03-28', '2017-03-31', 'No Man', 0),
(3, 0, 'New ', 'New Year Party', '2017-03-28', '2017-03-31', 'Mazoor Ahmad', 0),
(4, 1, 'New ', 'New Year Party', '2017-03-28', '2017-03-31', 'Mazoor Ahmad', 5),
(5, 0, 'New Year', 'Awesome Event', '2017-03-28', '2017-03-31', 'Mehmood', 0),
(6, 0, 'New Year', 'Awesome Event', '2017-03-28', '2017-03-31', 'Anwar', 0),
(7, 0, 'New Year', 'New Year Party', '2017-03-28', '2017-03-31', 'Anwar', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_event_type`
--

CREATE TABLE IF NOT EXISTS `tbl_event_type` (
`EventTypeID` int(11) NOT NULL,
  `Type` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_event_type`
--

INSERT INTO `tbl_event_type` (`EventTypeID`, `Type`) VALUES
(1, 'Cricket Match');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_leave_types`
--

CREATE TABLE IF NOT EXISTS `tbl_leave_types` (
`LeaveTypeID` int(11) NOT NULL,
  `Type` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_leave_types`
--

INSERT INTO `tbl_leave_types` (`LeaveTypeID`, `Type`) VALUES
(3, 'Diseases'),
(4, 'Maternity'),
(1, 'Personal');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_max_leaves`
--

CREATE TABLE IF NOT EXISTS `tbl_max_leaves` (
  `DesignationID` int(11) NOT NULL,
  `LeaveCount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_max_leaves`
--

INSERT INTO `tbl_max_leaves` (`DesignationID`, `LeaveCount`) VALUES
(1, 10),
(2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_parent_details`
--

CREATE TABLE IF NOT EXISTS `tbl_parent_details` (
`ParentID` int(11) NOT NULL,
  `StudentID` int(11) NOT NULL,
  `FirstName` varchar(30) NOT NULL,
  `MiddleName` varchar(30) NOT NULL,
  `LastName` varchar(30) NOT NULL,
  `Relation` varchar(30) NOT NULL,
  `Qualification` varchar(30) NOT NULL,
  `Profession` varchar(100) NOT NULL,
  `Contact` varchar(20) NOT NULL,
  `Email` text NOT NULL,
  `Photo` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_parent_details`
--

INSERT INTO `tbl_parent_details` (`ParentID`, `StudentID`, `FirstName`, `MiddleName`, `LastName`, `Relation`, `Qualification`, `Profession`, `Contact`, `Email`, `Photo`) VALUES
(1, 2, 'Muhammad', 'Amin', 'Dar', 'Father', 'M.COM', 'Manager', '7298631173', 'masteraamie@ymail.com', './uploads/students/Aamir2.png'),
(2, 3, 'Muhammad', 'Amin', 'Dar', 'Father', 'M.COM', 'Manager', '7298631173', 'masteraame@ymail.com', './uploads/students/Aamir3.jpg'),
(3, 4, 'Muhammad', '', '', 'Father', 'M.COM', 'Manager', '87987978', 'masteraame@ymail.comzx', './uploads/students/Aamir4.png'),
(4, 5, 'Muhammad', '', '', 'Father', 'M.COM', 'Manager', '87987978', 'masteraamke@ymail.comzx', './uploads/students/Aamir5.png'),
(5, 6, 'Muhammad', '', '', 'Father', 'M.COM', 'Manager', '87987978', 'masteraamke@ymail.comzxs', './uploads/students/Aamir6.png'),
(6, 19, 'Muhammad', '', '', 'Father', 'M.COM', 'Manager', '98798798', 'masteraame@ymail.comss', './uploads/students/Aamir19.jpg'),
(7, 23, 'Muhammad', '', '', 'Father', 'M.COM', 'Manager', '87687', 'masteraame@ymail.comaaaa', './uploads/students/Aamir23.jpg'),
(8, 24, 'Muhammad', '', '', 'Father', 'M.COM', 'Manager', '4234324234', 'masteraame@ymail.comaaas', './uploads/students/Aamir24.jpg'),
(9, 25, 'Awesome', '', '', 'Father', 'Awesome', 'Awesome', '231232323', 'Awesome@c.com', './uploads/students/Awesome25.jpg'),
(10, 27, 'Awesome', '', '', 'Father', 'Awesome', 'Awesome', '231232323', 'Awesome@c.comzss', './uploads/students/Awesome10.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_parent_login`
--

CREATE TABLE IF NOT EXISTS `tbl_parent_login` (
  `ParentID` int(11) NOT NULL,
  `LoginID` varchar(30) NOT NULL,
  `Password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_parent_login`
--

INSERT INTO `tbl_parent_login` (`ParentID`, `LoginID`, `Password`) VALUES
(1, 'Muhammad1', '123456'),
(2, 'Muhammad2', '123456'),
(3, 'Muhammad3', '123456'),
(4, 'Muhammad4', '123456'),
(5, 'Muhammad5', '123456'),
(6, 'Muhammad6', '123456'),
(7, 'Muhammad7', '123456'),
(8, 'Muhammad8', '123456'),
(9, 'Awesome9', '123456'),
(10, 'Awesome10', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sections`
--

CREATE TABLE IF NOT EXISTS `tbl_sections` (
`SectionID` int(11) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `ClassID` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_sections`
--

INSERT INTO `tbl_sections` (`SectionID`, `Name`, `ClassID`) VALUES
(1, 'A', 1),
(2, 'B', 1),
(3, 'C', 1),
(10, 'A', 23),
(11, 'B', 23),
(12, 'A', 24);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student_attendance`
--

CREATE TABLE IF NOT EXISTS `tbl_student_attendance` (
  `StudentID` int(11) NOT NULL,
  `Status` char(1) NOT NULL DEFAULT 'A',
  `ClassID` int(11) NOT NULL,
  `SectionID` int(11) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_student_attendance`
--

INSERT INTO `tbl_student_attendance` (`StudentID`, `Status`, `ClassID`, `SectionID`, `Date`) VALUES
(19, 'P', 1, 1, '2017-04-06'),
(25, 'A', 1, 1, '2017-04-06'),
(24, 'A', 1, 1, '2017-04-06'),
(6, 'P', 1, 1, '2017-04-06'),
(27, 'A', 1, 1, '2017-04-06'),
(7, 'P', 1, 1, '2017-04-06');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student_details`
--

CREATE TABLE IF NOT EXISTS `tbl_student_details` (
`StudentID` int(11) NOT NULL,
  `RegistrationNumber` varchar(30) NOT NULL,
  `ParentID` int(11) NOT NULL,
  `Batch` int(11) NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `MiddleName` varchar(30) NOT NULL,
  `LastName` varchar(30) NOT NULL,
  `Roll` int(11) NOT NULL,
  `ClassID` int(11) NOT NULL,
  `SectionID` char(1) NOT NULL,
  `DOB` date NOT NULL,
  `DOJ` date NOT NULL,
  `Gender` varchar(10) NOT NULL,
  `P_Address` text NOT NULL,
  `C_Address` text NOT NULL,
  `Contact` varchar(30) NOT NULL,
  `Email` text NOT NULL,
  `Photo` text NOT NULL,
  `BirthCertificate` text NOT NULL,
  `MigrationCertificate` text NOT NULL,
  `StateCertificate` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_student_details`
--

INSERT INTO `tbl_student_details` (`StudentID`, `RegistrationNumber`, `ParentID`, `Batch`, `FirstName`, `MiddleName`, `LastName`, `Roll`, `ClassID`, `SectionID`, `DOB`, `DOJ`, `Gender`, `P_Address`, `C_Address`, `Contact`, `Email`, `Photo`, `BirthCertificate`, `MigrationCertificate`, `StateCertificate`) VALUES
(1, '1212', 0, 0, 'Aamir', 'Amin', 'Dar', 4, 3, '3', '2017-03-22', '2017-03-25', 'male', 'asdaskjasldajshbajc', 'asdaskjasldajshbajc', '234242424232', 'mir.abhie@gmail.com', '', '', '', ''),
(2, 'SBS0001', 0, 0, 'Aamir', 'Amin', 'Dar', 6, 3, '3', '2017-03-06', '2017-03-14', 'male', 'Batapora', 'Batapora', '9596476919', 'mir.abie@gmail.com', './uploads/students/Aamir2.jpg', '', '', ''),
(3, '2017SBS0002', 0, 2017, 'Aamir', 'Amin', 'Dar', 6, 3, '3', '2017-03-06', '2017-03-24', 'male', 'Batapora', 'Batapora', '9596476919', 'mir.bie@gmail.com', './uploads/students/Aamir3.png', '', '', ''),
(4, 'SBS0003', 0, 2018, 'Aamir', '', '', 8, 3, '3', '2017-03-02', '2017-03-08', 'male', 'Abakjbskbad', 'Abakjbskbad', '959678237', 'masteraa@kymakil.com', './uploads/students/Aamir4.jpg', '', '', ''),
(5, 'SBS0004', 0, 2018, 'Aamir', '', '', 8, 3, '3', '2017-03-02', '2017-03-08', 'male', 'Abakjbskbad', 'Abakjbskbad', '959678237', 'mastesraa@kymakil.com', './uploads/students/Aamir5.jpg', '', '', ''),
(6, 'SBS0005', 0, 2018, 'Aamir', '', '', 8, 1, '1', '2017-03-02', '2017-03-08', 'male', 'Abakjbskbad', 'Abakjbskbad', '959678237', 'mastesraa@kymaskil.com', './uploads/students/Aamir6.jpg', '', '', ''),
(7, 'SBS0006', 0, 2018, 'Aamir', '', '', 7, 1, '1', '2017-03-23', '2017-03-09', 'male', ',hvasjhdajsdvavhs', ',hvasjhdajsdvavhs', '76577576578', 'mamnbsteraa@kymakil.com', './uploads/students/Aamir7.jpg', '', '', ''),
(19, 'SBS0007', 0, 2016, 'Aamir', '', '', 54, 1, '1', '1995-03-14', '2017-03-31', 'male', 'BATAPORA', 'BATAPORA', '876876876', 'masteraa@ymail.comfmf', './uploads/students/Aamir19.jpg', '', '', ''),
(23, 'SBS00019', 0, 2016, 'Aamir', '', '', 19, 6, '0', '2017-03-22', '2017-03-31', 'male', 'ABJBKHGBJH', 'ABJBKHGBJH', '8787676', 'masteraa@kymakil.comaaa', './uploads/students/Aamir23.jpg', '', '', ''),
(24, 'SBS00023', 0, 2016, 'Aamir', '', '', 65, 1, '1', '2017-03-09', '2017-03-31', 'male', 'Awesome', 'Awesome', '8768768', '', './uploads/students/Aamir24.jpg', './uploads/documents/birth_certificatesAamir24.jpg', './uploads/documents/migration_certificatesAamir24.jpg', './uploads/documents/state_subject_certificatesAamir24.jpg'),
(25, 'SBS00024', 0, 2016, 'Awesome', '', '', 34, 1, '1', '2017-03-06', '2017-03-20', 'male', 'Awesome', 'Awesome', '', '', './uploads/students/Awesome25.jpg', './uploads/documents/birth_certificates/Awesome25.jpg', './uploads/documents/migration_certificates/Awesome25.jpg', './uploads/documents/state_subject_certificates/Awesome25.jpg'),
(27, 'SBS00025', 0, 2016, 'Awesome', '', '', 366, 1, '1', '2017-03-06', '2017-03-20', 'male', 'Awesome', 'Awesome', '', '', './uploads/students/Awesome27.jpg', './uploads/documents/birth_certificates/Awesome27.jpg', './uploads/documents/migration_certificates/Awesome27.jpg', './uploads/documents/state_subject_certificates/Awesome27.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student_login`
--

CREATE TABLE IF NOT EXISTS `tbl_student_login` (
  `StudentID` int(11) NOT NULL,
  `LoginID` varchar(30) NOT NULL,
  `Password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_student_login`
--

INSERT INTO `tbl_student_login` (`StudentID`, `LoginID`, `Password`) VALUES
(2, 'Aamir2', '123456'),
(3, 'Aamir3', '123456'),
(4, '2018Aamir4', '123456'),
(5, '18Aamir5', '123456'),
(6, '18SBS0006', '123456'),
(7, '18SBS0007', '123456'),
(19, '16SBS00019', '123456'),
(23, '16SBS00023', '123456'),
(24, '2016SBS00024', '123456'),
(25, '2016SBS00025', '123456'),
(27, '2016SBS00027', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student_prev_details`
--

CREATE TABLE IF NOT EXISTS `tbl_student_prev_details` (
  `StudentID` int(11) NOT NULL,
  `Class` varchar(30) NOT NULL,
  `School` text NOT NULL,
  `Percentage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_student_prev_details`
--

INSERT INTO `tbl_student_prev_details` (`StudentID`, `Class`, `School`, `Percentage`) VALUES
(1, '', '', 0),
(23, '4th', 'Green Valley', 98),
(24, '4th', 'Green Valley', 87),
(25, 'Awesome', 'Awesome', 2323),
(27, 'Awesome', 'Awesome', 2323);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subjects`
--

CREATE TABLE IF NOT EXISTS `tbl_subjects` (
`SubjectID` int(11) NOT NULL,
  `Name` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_subjects`
--

INSERT INTO `tbl_subjects` (`SubjectID`, `Name`) VALUES
(3, 'Botany'),
(4, 'English');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subject_allocation`
--

CREATE TABLE IF NOT EXISTS `tbl_subject_allocation` (
  `ClassID` int(11) NOT NULL,
  `SubjectID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_subject_allocation`
--

INSERT INTO `tbl_subject_allocation` (`ClassID`, `SubjectID`) VALUES
(3, 3),
(5, 3),
(7, 3),
(8, 3),
(4, 1),
(3, 2),
(21, 3),
(21, 1),
(21, 2),
(23, 3),
(23, 1),
(24, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_teacher_allocation`
--

CREATE TABLE IF NOT EXISTS `tbl_teacher_allocation` (
  `TeacherID` int(11) NOT NULL,
  `ClassID` int(11) NOT NULL,
  `SectionID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_teacher_allocation`
--

INSERT INTO `tbl_teacher_allocation` (`TeacherID`, `ClassID`, `SectionID`) VALUES
(3, 1, 1),
(3, 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_time_table`
--

CREATE TABLE IF NOT EXISTS `tbl_time_table` (
  `ClassID` int(11) NOT NULL,
  `SectionID` int(11) NOT NULL,
  `Day` varchar(30) NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `StartTime` time NOT NULL,
  `EndTime` time NOT NULL,
  `EmployeeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_assignments`
--
ALTER TABLE `tbl_assignments`
 ADD PRIMARY KEY (`AssignmentID`);

--
-- Indexes for table `tbl_batches`
--
ALTER TABLE `tbl_batches`
 ADD PRIMARY KEY (`BatchID`), ADD UNIQUE KEY `Name` (`Year`);

--
-- Indexes for table `tbl_book_details`
--
ALTER TABLE `tbl_book_details`
 ADD PRIMARY KEY (`SerialID`), ADD UNIQUE KEY `BookID` (`BookID`);

--
-- Indexes for table `tbl_circulars`
--
ALTER TABLE `tbl_circulars`
 ADD PRIMARY KEY (`CircularID`);

--
-- Indexes for table `tbl_classes`
--
ALTER TABLE `tbl_classes`
 ADD PRIMARY KEY (`ClassID`), ADD UNIQUE KEY `Name` (`Name`), ADD UNIQUE KEY `Name_2` (`Name`);

--
-- Indexes for table `tbl_departments`
--
ALTER TABLE `tbl_departments`
 ADD PRIMARY KEY (`DepartmentID`), ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `tbl_designations`
--
ALTER TABLE `tbl_designations`
 ADD PRIMARY KEY (`DesignationID`), ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `tbl_employee_details`
--
ALTER TABLE `tbl_employee_details`
 ADD PRIMARY KEY (`EmployeeID`);

--
-- Indexes for table `tbl_employee_login`
--
ALTER TABLE `tbl_employee_login`
 ADD PRIMARY KEY (`EmployeeID`), ADD UNIQUE KEY `LoginID` (`LoginID`);

--
-- Indexes for table `tbl_events`
--
ALTER TABLE `tbl_events`
 ADD PRIMARY KEY (`EventID`);

--
-- Indexes for table `tbl_event_type`
--
ALTER TABLE `tbl_event_type`
 ADD PRIMARY KEY (`EventTypeID`), ADD UNIQUE KEY `Type` (`Type`);

--
-- Indexes for table `tbl_leave_types`
--
ALTER TABLE `tbl_leave_types`
 ADD PRIMARY KEY (`LeaveTypeID`), ADD UNIQUE KEY `Type` (`Type`);

--
-- Indexes for table `tbl_parent_details`
--
ALTER TABLE `tbl_parent_details`
 ADD PRIMARY KEY (`ParentID`), ADD UNIQUE KEY `StudentID` (`StudentID`);

--
-- Indexes for table `tbl_parent_login`
--
ALTER TABLE `tbl_parent_login`
 ADD PRIMARY KEY (`ParentID`), ADD UNIQUE KEY `LoginID` (`LoginID`);

--
-- Indexes for table `tbl_sections`
--
ALTER TABLE `tbl_sections`
 ADD PRIMARY KEY (`SectionID`);

--
-- Indexes for table `tbl_student_details`
--
ALTER TABLE `tbl_student_details`
 ADD PRIMARY KEY (`StudentID`), ADD UNIQUE KEY `RegistrationNumber` (`RegistrationNumber`);

--
-- Indexes for table `tbl_student_login`
--
ALTER TABLE `tbl_student_login`
 ADD PRIMARY KEY (`StudentID`), ADD UNIQUE KEY `LoginID` (`LoginID`);

--
-- Indexes for table `tbl_student_prev_details`
--
ALTER TABLE `tbl_student_prev_details`
 ADD UNIQUE KEY `StudentID` (`StudentID`);

--
-- Indexes for table `tbl_subjects`
--
ALTER TABLE `tbl_subjects`
 ADD PRIMARY KEY (`SubjectID`), ADD UNIQUE KEY `Name` (`Name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_assignments`
--
ALTER TABLE `tbl_assignments`
MODIFY `AssignmentID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_batches`
--
ALTER TABLE `tbl_batches`
MODIFY `BatchID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_book_details`
--
ALTER TABLE `tbl_book_details`
MODIFY `SerialID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_circulars`
--
ALTER TABLE `tbl_circulars`
MODIFY `CircularID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_classes`
--
ALTER TABLE `tbl_classes`
MODIFY `ClassID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_departments`
--
ALTER TABLE `tbl_departments`
MODIFY `DepartmentID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_designations`
--
ALTER TABLE `tbl_designations`
MODIFY `DesignationID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_employee_details`
--
ALTER TABLE `tbl_employee_details`
MODIFY `EmployeeID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tbl_events`
--
ALTER TABLE `tbl_events`
MODIFY `EventID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `tbl_event_type`
--
ALTER TABLE `tbl_event_type`
MODIFY `EventTypeID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_leave_types`
--
ALTER TABLE `tbl_leave_types`
MODIFY `LeaveTypeID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_parent_details`
--
ALTER TABLE `tbl_parent_details`
MODIFY `ParentID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `tbl_sections`
--
ALTER TABLE `tbl_sections`
MODIFY `SectionID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `tbl_student_details`
--
ALTER TABLE `tbl_student_details`
MODIFY `StudentID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `tbl_subjects`
--
ALTER TABLE `tbl_subjects`
MODIFY `SubjectID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

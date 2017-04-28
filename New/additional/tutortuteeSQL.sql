-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:8889
-- Generation Time: Apr 28, 2017 at 04:57 PM
-- Server version: 5.6.34-log
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tutortutee`
--

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `session_ID` int(11) NOT NULL,
  `tutor_ID` int(11) NOT NULL,
  `tutee_ID` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `finish_time` time NOT NULL,
  `duration` int(11) DEFAULT NULL,
  `subject` varchar(50) NOT NULL,
  `location` varchar(100) NOT NULL,
  `status` enum('booked','vacant') NOT NULL DEFAULT 'vacant'
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`session_ID`, `tutor_ID`, `tutee_ID`, `date`, `start_time`, `finish_time`, `duration`, `subject`, `location`, `status`) VALUES
(1, 2, NULL, '2017-06-06', '17:00:00', '20:00:00', 3, 'Mathematics', 'Starbucks Central Embassy', 'vacant'),
(3, 2, 1, '2017-06-08', '17:00:00', '19:00:00', 2, 'Mathematics', 'Starbucks Central Embassy', 'booked'),
(4, 2, 2, '2017-06-08', '17:00:00', '20:00:00', 3, 'Mathematics', 'Starbucks Central Embassy', 'booked'),
(5, 2, NULL, '2017-06-09', '18:00:00', '20:00:00', 1, 'Mathematics', 'Starbucks Central Embassy', 'vacant'),
(8, 3, 12, '2017-08-08', '15:00:00', '18:00:00', 3, 'Math', 'Emquatier', 'booked'),
(9, 3, 12, '2017-08-08', '09:00:00', '12:00:00', 3, 'Math', 'Emquatier', 'booked'),
(10, 3, NULL, '2017-08-08', '18:00:00', '21:00:00', 3, 'Math', 'Emquatier', 'vacant'),
(11, 3, 12, '2017-08-08', '12:00:00', '15:00:00', 3, 'Math', 'Emquatier', 'booked'),
(16, 2, 3, '0000-00-00', '00:00:00', '00:00:00', NULL, '', '', 'booked');

-- --------------------------------------------------------

--
-- Table structure for table `tutees`
--

CREATE TABLE IF NOT EXISTS `tutees` (
  `tutee_ID` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL,
  `image` varchar(256) DEFAULT NULL,
  `activated` enum('Y','N') NOT NULL DEFAULT 'N',
  `tokenCode` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tutees`
--

INSERT INTO `tutees` (`tutee_ID`, `username`, `email`, `password`, `image`, `activated`, `tokenCode`) VALUES
(1, 'Wnvynnie', 'winjung_pipi63@hotmail.com', 'stichlover', '', 'Y', 'manual added'),
(2, 'Giffufu', 'gif_fufu@hotmail.com', 'jokmok5pong', '', 'Y', 'manual added'),
(3, 'Bowbear', 'b_bowbear@hotmail.com', 'jaobomhee', '', 'Y', 'manual added'),
(11, 'book', 'book_sek@hotmail.com', 'bambook', '', 'N', '749043af361ebbc1d311f6a1b999efdf'),
(12, 'bam', 'bambanapt@hotmail.com', 'bamsuaymak', 'easywaeiei.jpg', 'Y', '8c9fdd1632283714bc07325988d14597'),
(13, 'bambook', 'bam_banapt@hotmail.com', 'bambook', '', 'N', '76b2353170c563acaf2234347f1748cb'),
(14, 'bambookkjuikjhkjk', 'b_banapt@hotmail.com', 'bambook', '', 'N', '7e4d07ae2e55793c7dc3a0b69ccd5118'),
(15, 'boon', 'boonboon@hotmail.com', 'bambook', '', 'N', '23dcf0efc92b8722805047a60b014045'),
(16, 'hello', 'hello@gmail.com', 'krikri', NULL, 'N', '0ad3a01549193cdd403c86f8a893c35c');

-- --------------------------------------------------------

--
-- Table structure for table `tutors`
--

CREATE TABLE IF NOT EXISTS `tutors` (
  `tutor_ID` int(11) NOT NULL,
  `tutor_Fname` varchar(50) NOT NULL,
  `tutor_Lname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `description` varchar(256) NOT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `image` varchar(256) DEFAULT NULL,
  `subject` varchar(256) DEFAULT NULL,
  `hourly_rate` int(6) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `faculty` varchar(50) DEFAULT NULL,
  `university` varchar(50) DEFAULT NULL,
  `certificate` varchar(256) DEFAULT NULL,
  `transcript` varchar(256) DEFAULT NULL,
  `phone` int(11) DEFAULT NULL,
  `lineID` varchar(20) DEFAULT NULL,
  `account_name` varchar(100) DEFAULT NULL,
  `account_no` int(50) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `activated` enum('Y','N') NOT NULL DEFAULT 'N',
  `tokenCode` varchar(100) DEFAULT NULL,
  `verify` enum('Y','N') NOT NULL DEFAULT 'N',
  `rating` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tutors`
--

INSERT INTO `tutors` (`tutor_ID`, `tutor_Fname`, `tutor_Lname`, `email`, `password`, `description`, `gender`, `age`, `image`, `subject`, `hourly_rate`, `location`, `faculty`, `university`, `certificate`, `transcript`, `phone`, `lineID`, `account_name`, `account_no`, `bank_name`, `activated`, `tokenCode`, `verify`, `rating`) VALUES
(1, 'Karnplu', 'Itthiratanakomol', 'k.itthikamol@gmail.com', 'nullabing', 'My name is KP. I love eatting eiei.', 'Female', 22, NULL, ',English,Mathematics,French', 300, ',Pathumwan', 'Faculty of Arts', 'Chualongkorn University', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Y', 'manual added', 'Y', 4),
(2, 'Nattanit', 'Santimetvirul', 'nattanit_s@gmail.com', 'jokmok5pong', 'I am Magic. I am the smartest girl in SJC hehe.', 'Female', 23, NULL, 'English,Mathematics,Science', 400, 'Pathumwan,Sathorn', 'Faculty of Laws', 'Chualongkorn University', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Y', 'manual added', 'Y', 3),
(3, 'Ruangyot', 'Wananan', 'x_tuay_x@hotmail.com', 'tuayza', 'My name is Tuay Ruangyot. I am a doctor woohoo.', 'Male', 22, 'xtautx.png', ',Mathematics,Physics,Biology', 500, ',Pathumwan', 'Faculty of Medicine', 'Chualongkorn University', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Y', 'manual added', 'Y', 5),
(4, 'Book', 'Sek', 'eiei@gmail.com', 'eieieiei', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, 'N', NULL),
(8, 'Bam', 'Ket', 'bambanapt@hotmail.com', 'bamsuaymak', 'kfkgjdlkgjdl', NULL, NULL, NULL, 'Thai', 400, 'Siam,Silom', 'Eng', 'Chula', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Y', NULL, 'Y', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_ID`);

--
-- Indexes for table `tutees`
--
ALTER TABLE `tutees`
  ADD PRIMARY KEY (`tutee_ID`);

--
-- Indexes for table `tutors`
--
ALTER TABLE `tutors`
  ADD PRIMARY KEY (`tutor_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `session_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `tutees`
--
ALTER TABLE `tutees`
  MODIFY `tutee_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `tutors`
--
ALTER TABLE `tutors`
  MODIFY `tutor_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

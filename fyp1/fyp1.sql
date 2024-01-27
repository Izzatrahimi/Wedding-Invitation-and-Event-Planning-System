-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2023 at 08:07 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fyp1`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_details`
--

CREATE TABLE `activity_details` (
  `activity_id` int(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `activity_title` varchar(50) NOT NULL,
  `activity_desc` varchar(500) NOT NULL,
  `activity_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activity_details`
--

INSERT INTO `activity_details` (`activity_id`, `username`, `activity_title`, `activity_desc`, `activity_time`) VALUES
(5, 'izzat', 'Ketibaan tetamu dan keluarga terdekat', 'Ketibaan tetamu dan ahli keluarga ke majlis perkahwinan.', '09:00:00'),
(6, 'izzat', 'Ketibaan rombongan pengantin', 'Rombongan pengantin tiba dan berarak masuk ke dalam majlis.', '10:00:00'),
(7, 'izzat', 'Majlis akad nikah', 'Bermula majlis akad nikah antara pasangan mempelai.', '10:30:00'),
(8, 'izzat', 'Jamuan Makan', 'Bermula jamuan makan rasmi untuk para tetamu dan pengantin.', '11:00:00'),
(9, 'izzat', 'Acara memotong kek', 'Pasangan pengantin akan memotong kek di hadapan orang ramai.', '11:15:00'),
(10, 'izzat', 'Sesi bergambar', 'Bermula sesi bergambar bersama pasangan pengantin', '12:10:00'),
(11, 'izzat', 'Sesi ramah mesra', 'Pengantin akan beramah mesra bersama tetamu yang hadir', '13:00:00'),
(12, 'izzat', 'Masjlis bersurai', 'Tamat majlis perkahwinan', '16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `checklist`
--

CREATE TABLE `checklist` (
  `checklist_id` int(20) NOT NULL,
  `checklist_title` varchar(50) NOT NULL,
  `checklist_desc` varchar(500) NOT NULL,
  `checklist_status` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `checklist`
--

INSERT INTO `checklist` (`checklist_id`, `checklist_title`, `checklist_desc`, `checklist_status`, `username`) VALUES
(9, 'meeting with tok imam', 'early morning', 'priority', 'jimmy'),
(11, 'Venue Selection', 'Choose and book a wedding venue', 'priority', 'izzat'),
(12, 'Catering', 'Select a catering service and menu  ', 'priority', 'izzat'),
(13, 'Wedding Attire', 'Choose wedding outfits for bride and groom', 'completed', 'izzat'),
(14, 'Entertainment', 'Arrange for wedding entertainment', 'upcoming', 'izzat'),
(15, 'Wedding Rings', 'Choose and purchase wedding rings', 'completed', 'izzat');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `feedback_category` varchar(50) NOT NULL,
  `feedback_topic` varchar(50) NOT NULL,
  `feedback_desc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `username`, `feedback_category`, `feedback_topic`, `feedback_desc`) VALUES
(1, 'izzat', 'bug', 'Test', 'test test test'),
(2, 'izzat', 'feature', 'Test feature', 'test test test feature'),
(3, 'izzat', 'review', 'Test feature review', 'test test test feature review'),
(4, 'izzat', 'bug', 'Test bug', 'buggy bug bugg'),
(5, 'izzat', 'feature', 'Test123', 'test123456789 123456789'),
(8, 'izzat', 'Review', 'Test', 'testing 1/10'),
(9, 'izzat', 'review', 'Test', 'review 1/10'),
(10, 'izzat', 'review', 'test review', '3/10 ');

-- --------------------------------------------------------

--
-- Table structure for table `guest`
--

CREATE TABLE `guest` (
  `guest_id` int(11) NOT NULL,
  `guest_name` varchar(50) NOT NULL,
  `guest_phone` varchar(50) NOT NULL,
  `guest_email` varchar(50) NOT NULL,
  `guest_address` varchar(100) NOT NULL,
  `guest_group` varchar(50) NOT NULL,
  `guest_status` varchar(50) NOT NULL,
  `guest_pax` int(50) NOT NULL,
  `notes` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `guest`
--

INSERT INTO `guest` (`guest_id`, `guest_name`, `guest_phone`, `guest_email`, `guest_address`, `guest_group`, `guest_status`, `guest_pax`, `notes`, `username`) VALUES
(7, 'pak ali', '0112345678', 'ali@gmail.com', 'taman megah', 'Family', 'Attending', 5, '2 adults and 3 kids', 'izzat'),
(9, 'pak abu', '0122345678', 'abu@gmail.com', 'taman rakyat', 'Family', 'Invited', 2, '2 adults', 'izzat'),
(10, 'kak nurul', '0132345678', 'nurul@yahoo.com', 'taman megah', 'Neighbour', 'Invited', 4, '2 adults and 2 kids', 'izzat'),
(11, 'cik siti', '0142345678', 'siti@gmail.com', 'taman jaya', 'Colleague', 'Invited', 1, '1 adult', 'izzat'),
(28, 'abang joe', '0152345678', 'joe@yahoo.com', 'taman ihsan', 'Neighbour', 'Attending', 1, '1 adult', 'izzat'),
(29, 'Ahmad bin Abdullah', '012-3456789', 'ahmad@email.com', '123, Jalan Raja, Kuala Lumpur', 'Family', 'Invited', 4, '4 adults', 'izzat'),
(30, 'Siti binti Hassan', '019-8765432', 'siti@email.com', '456, Jalan Merdeka, Penang', 'Family', 'Invited', 3, '2 adults and 1 kid', 'izzat'),
(31, 'Aishah bt Mohd Ali', '012-6667777 ', 'aishah@email.com', '321, Jalan Bahagia, Penang', 'Family', 'Invited', 4, '3 adults and 1 kid', 'izzat'),
(32, 'Siti Aminah', '011-9876543', 'siti@example.com', '456 Jalan Ampang, Kuala Lumpur', 'Family', 'Invited', 5, '3 adults and 2 kids', 'izzat'),
(33, 'Wong Li Wei', '016-8765432', 'liwei@example.com ', '789 Jalan Bukit Bintang', 'Friend', 'Invited', 1, '1 adult', 'izzat'),
(34, 'Tan Mei Ling ', '018-7654321', 'meiling@example.com', '101 Jalan Puchong, Selangor', 'Friend', 'Invited', 1, '1 adult', 'izzat'),
(35, 'Raj Kumar', '019-6543210', 'raj@example.com', '222 Jalan Sentul, Kuala Lumpur', 'Neighbour', 'Invited', 3, '2 adults and 1 kid', 'izzat'),
(36, 'Lisa Tan', '012-3456123', 'lisa@example.com', '333 Jalan Damansara, Selangor ', 'Colleague', 'Invited', 2, '2 adults', 'izzat'),
(37, 'Mohd Hassan', '011-9876123', 'hassan@example.com', '444 Jalan Cheras, Selangor', 'Family', 'Invited', 5, '4 adults and 1 kid', 'izzat'),
(38, 'Michelle Lim', '016-8765123', 'michelle@example.com', '555 Jalan Klang, Selangor ', 'Associate', 'Invited', 2, '2 adults', 'izzat'),
(39, 'Nurul Afiqah', '011-9876958', 'nurul@example.com', '543 Jalan Setapak, KL', 'Colleague', 'Invited', 2, '2 adults', 'izzat'),
(40, 'Mohamad Ali', '016-8765958 ', 'ali@example.com', '678 Jalan Ampang, KL ', 'Family', 'Invited', 5, '5 adults', 'izzat'),
(41, 'Mohd Aziz', '0112345678', 'aziz@email.com', '789 Jalan Damai, Penang', 'Family', 'Invited', 6, '3 adults and 3 kids', 'izzat'),
(42, 'Amir bin Hassan', '0111223344', 'amir@yahoo.com', '456 Jalan Bahagia', 'Friend', 'Invited', 4, '2 adults and 2 kids', 'izzat'),
(43, 'Nurul binti Ismail', '0187654321 ', 'nurul@gmail.com', '101 Jalan Harmoni ', 'Colleague', 'Invited', 4, '2 adults and 2 kids', 'izzat'),
(44, 'Irfan bin Hafiz ', '0199887766', ' irfan@hotmail.com ', '234 Jalan Sejahtera', 'Friend', 'Invited', 4, '2 adults and 2 kids', 'izzat'),
(45, 'Nor Azlin binti Tan', '0199887755', 'azlin@hotmail.com  ', '101 Jalan Sejahtera ', 'Acquaintance', 'Invited', 4, '2 adults and 2 kids', 'izzat'),
(46, 'Norliana binti Ismail', '0199887733', 'norliana@yahoo.com', '456 Jalan Harmoni ', 'Teeacher and Mentor', 'Invited', 5, '4 adults and 1 kid', 'izzat'),
(47, 'Norzainab binti Ali', '0199887799', 'norzainab@hotmail.com', '123 Jalan Sejahtera', 'Teeacher and Mentor', 'Invited', 4, '4 adults', 'izzat'),
(48, 'Hazwan bin Hafiz', '0199887766', 'hazwan@hotmail.com ', '234 Jalan Merdeka', 'Event Vendor', 'Invited', 2, '2 adults', 'izzat'),
(49, 'Suhaimi bin Ismail', '0199887744', 'suhaimi@gmail.com', '567 Jalan Sejahtera', 'Neighbour', 'Invited', 5, '3 adults and 2 kids', 'izzat'),
(50, 'Amira binti Abdullah', '0199887722', 'amira@gmail.com', '789 Jalan Bahagia', 'Colleague', 'Invited', 2, '2 adults', 'izzat'),
(51, 'Faizal bin Mohd ', '0123456700', 'faizal@yahoo.com ', '567 Jalan Damai', 'Family', 'Attending', 5, '2 adults and 3 kids', 'izzat'),
(52, 'Idris bin Ismail', '0111223347', 'idris@yahoo.com', '234 Jalan Harmoni', 'Acquaintance', 'Attending', 5, '2 adults and 3 kids', 'izzat'),
(53, 'aliff anuar', '0172345678', 'aliff@gmail.com', 'taman mergong jaya', 'Friend', 'Attending', 1, '1 adult', 'izzat');

-- --------------------------------------------------------

--
-- Table structure for table `header_details`
--

CREATE TABLE `header_details` (
  `header_id` int(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `bride` varchar(50) NOT NULL,
  `groom` varchar(50) NOT NULL,
  `wedding_date` varchar(50) NOT NULL,
  `wedding_location` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `message_id` int(11) NOT NULL,
  `message_name` varchar(100) NOT NULL,
  `message_email` varchar(100) NOT NULL,
  `message_phone` varchar(100) NOT NULL,
  `message_address` varchar(100) NOT NULL,
  `message_desc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`message_id`, `message_name`, `message_email`, `message_phone`, `message_address`, `message_desc`) VALUES
(1, 'Izzat Rahimi', 'izzatrahimi@gmail.com', '0112345678', 'Alor Setar, Kedah', 'How to create an account?'),
(5, 'Izzudin', 'izz@gmail.com', '0129876543', 'Alor Setar', 'how to create an account?');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `level_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `name`, `phone`, `level_id`) VALUES
(1, 'admin', 'izzatrahimi27@gmail.com', '12345', 'Muhd Izzat Rahimi', '012-3456789', 1),
(6, 'izzat', 'izzatrahimi27@gmail.com', '12345', 'Muhd Izzat Rahimi', '011-3456789', 2),
(9, 'jimmy', 'jim@gmail.com', 'asd', 'Hazim Amran', '010-1230456', 2),
(13, 'rahimi27', 'rahimi@gmail.com', '123', 'Rahimi Izzat', '011-3456789', 2),
(16, 'izzudin', 'izz@gmail.com', '123', 'izzudin zaidi', '012-9876543', 2);

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `vendor_id` int(20) NOT NULL,
  `vendor_name` varchar(50) NOT NULL,
  `vendor_price` double NOT NULL,
  `vendor_email` varchar(50) NOT NULL,
  `vendor_contact` varchar(50) NOT NULL,
  `vendor_category` varchar(50) NOT NULL,
  `vendor_link` varchar(50) NOT NULL,
  `notes` varchar(500) NOT NULL,
  `vendor_image` text NOT NULL,
  `username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`vendor_id`, `vendor_name`, `vendor_price`, `vendor_email`, `vendor_contact`, `vendor_category`, `vendor_link`, `notes`, `vendor_image`, `username`) VALUES
(8, 'Catering Bravo123', 10000, 'bravo@gmail.com', '019-3456787', 'Caterer', 'http://bravo.com', 'Western style caterer', '../images/caterer-western.jpeg', 'izzat'),
(9, 'Alpha Catering', 12000, 'alpha@gmail.com', '019-3456786', 'Caterer', 'http://alpha.com', 'Malaysian style caterer', '../images/caterer-malaysian.jpg', 'izzat'),
(10, 'Hazim Photographer', 2000, 'hazim@gmail.com', '019-3456785', 'Photographer', 'http://hazimphoto.com', 'Costly but great photographer', '../images/photographer2.jpg', 'izzat'),
(11, 'Joe Photographer', 1700, 'joe@gmail.com', '019-3456784', 'Photographer', 'http://joephoto.com', 'western style photographer', '../images/photographer1.jpg', 'izzat'),
(12, 'Alin Brideswear', 2000, 'alin@gmail.com', '019-3456783', 'Brideswear', 'http://alinbridal.com', 'Malaysian style brideswear', '../images/brideswear1.jpg', 'izzat'),
(13, 'Bridal ', 3500, 'bridal@gmail.com', '019-3456782', 'Brideswear', 'http://bridal.com', 'western style brideswear', '../images/brideswear2.jpg', 'izzat'),
(14, 'Ali Groomswear', 1000, 'ali@gmail.com', '019-3456781', 'Groomswear', 'http://aligroomswear.com', 'malaysian style groomswear', '../images/groomswear2.jpg', 'izzat'),
(15, 'West Suit', 2600, 'westsuit@gmail.com', '019-3456780', 'Groomswear', 'http://westsuit.com', 'Western style wedding suit.', '../images/groomswear1.jpg', 'izzat'),
(16, 'Blissful Planner', 2000, 'bliss@gmail.com', '019-3456770', 'Planner', 'http://blissful.com', 'western style wedding planner', '../images/panner1.jpg', 'izzat'),
(17, 'Permata Planner', 2400, 'permata@gmail.com', '019-3456760', 'Planner', 'http://permataplan.com', 'Malaysian style wedding planner', '../images/panner2.jpg', 'izzat'),
(18, 'Ms Lee Make Up', 800, 'misslee@gmail.com', '019-3456750', 'Make Up Artist', 'http://msleemakeup.com', 'Malaysian make up artist', '../images/makeup2.jpeg', 'izzat'),
(19, 'Ms Amanda Make Up', 1400, 'amanda@gmail.com', '019-3456740', 'Make Up Artist', 'http://amandamakeup.com', 'Foreign make up artist', '../images/makeup1.jpeg', 'izzat'),
(20, 'Modern Doorgift', 2500, 'modoorgift@gmail.com', '019-3456730', 'Door Gift', 'http://modoorgift.com', 'Modern doorgift min 500 pax (rm5 / pax)', '../images/doorgift1.jpeg', 'izzat'),
(21, 'Classic Doorgift', 1250, 'classicdoorgift@gmail.com', '019-3456720', 'Door Gift', 'http://classicdoorgift.com', 'Classic style doorgift min 500 pax (rm2.5 / pax)', '../images/doorgift2.jpg', 'izzat'),
(32, 'MMAS Hall', 3500, 'mmas@gmail.com', '012-12345678', 'Venue', 'http://mmas.com', 'MMAS school hall', '../images/dewan_mmas.jpg', 'izzat'),
(33, 'MMAS Hall', 3500, 'mmas@gmail.com', '012-1234567', 'Venue', 'http://mmas.com', 'MMAS school hall', '../images/dewan_mmas.jpg', 'jimmy'),
(38, 'Grand Alora Ballroom', 6000, 'grandalora@gmail.com', '013-12345678', 'Venue', 'http://grandalora.com', 'Hotel grand alora alor setar, kedah', '../images/grand_alora.jpeg', 'izzat');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_details`
--
ALTER TABLE `activity_details`
  ADD PRIMARY KEY (`activity_id`);

--
-- Indexes for table `checklist`
--
ALTER TABLE `checklist`
  ADD PRIMARY KEY (`checklist_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`);

--
-- Indexes for table `guest`
--
ALTER TABLE `guest`
  ADD PRIMARY KEY (`guest_id`);

--
-- Indexes for table `header_details`
--
ALTER TABLE `header_details`
  ADD PRIMARY KEY (`header_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`vendor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_details`
--
ALTER TABLE `activity_details`
  MODIFY `activity_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `checklist`
--
ALTER TABLE `checklist`
  MODIFY `checklist_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `guest`
--
ALTER TABLE `guest`
  MODIFY `guest_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `header_details`
--
ALTER TABLE `header_details`
  MODIFY `header_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `vendor_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

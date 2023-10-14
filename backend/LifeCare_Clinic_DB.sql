-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 03, 2023 at 12:04 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `LifeCare_Clinic_DB`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(20) NOT NULL,
  `admin_name` varchar(50) DEFAULT NULL,
  `admin_pass` varchar(255) DEFAULT NULL,
  `admin_email` varchar(100) DEFAULT NULL,
  `admin_token` varchar(255) DEFAULT NULL,
  `admin_registered` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_name`, `admin_pass`, `admin_email`, `admin_token`, `admin_registered`) VALUES
(1, 'Admin', 'kNzPnFJtxKbwaWJOx4sMFk3N/COVZzbuOxjm0kOlmrLL9AL9JJfItmd0iQBl5CNQ', 'admin@gmail.com', '2152645324265183635333', '2020-01-15 03:28:10');

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `ann_id` int(11) NOT NULL,
  `ann_title` varchar(255) DEFAULT NULL,
  `ann_content` text DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `clinic_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `app_id` int(11) NOT NULL,
  `app_date` date DEFAULT NULL,
  `app_time` varchar(255) DEFAULT NULL,
  `treatment_type` varchar(255) DEFAULT 'Not Provided',
  `patient_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `clinic_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '1: Confirm, 0: Not Confirm',
  `consult_status` int(11) DEFAULT NULL COMMENT '1: Visited 0: None',
  `arrive_status` int(11) DEFAULT NULL COMMENT '1: Arrived 0: None'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`app_id`, `app_date`, `app_time`, `treatment_type`, `patient_id`, `doctor_id`, `clinic_id`, `status`, `consult_status`, `arrive_status`) VALUES
(1, '2023-03-27', '8:30 AM', 'undefined', 1, 1, 10, 1, 0, 1),
(2, '2023-03-28', '11:30 PM', 'undefined', 1, 2, 10, 1, 1, 0),
(4, '2023-04-04', '11:30 PM', 'Pelvic Pain', 1, 2, 10, 0, 0, 1),
(6, '2023-04-03', '8:30 AM', 'undefined', 1, 1, 10, 1, 1, 0),
(7, '2023-04-03', '1:30 PM', 'undefined', 1, 1, 10, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `business_hour`
--

CREATE TABLE `business_hour` (
  `businesshour_id` int(11) NOT NULL,
  `open_week` varchar(255) DEFAULT NULL,
  `close_week` varchar(255) DEFAULT NULL,
  `open_sat` varchar(255) DEFAULT NULL,
  `close_sat` varchar(255) DEFAULT NULL,
  `open_sun` varchar(255) DEFAULT NULL,
  `close_sun` varchar(255) DEFAULT NULL,
  `clinic_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `business_hour`
--

INSERT INTO `business_hour` (`businesshour_id`, `open_week`, `close_week`, `open_sat`, `close_sat`, `open_sun`, `close_sun`, `clinic_id`) VALUES
(5, '8:30 AM', '9:30 PM', '', '', '', '', 10);

-- --------------------------------------------------------

--
-- Table structure for table `clinics`
--

CREATE TABLE `clinics` (
  `clinic_id` int(11) NOT NULL,
  `clinic_name` varchar(255) DEFAULT NULL,
  `clinic_email` varchar(255) DEFAULT NULL,
  `clinic_contact` varchar(15) DEFAULT NULL,
  `clinic_address` varchar(255) DEFAULT NULL,
  `clinic_city` varchar(255) DEFAULT NULL,
  `clinic_state` varchar(255) DEFAULT NULL,
  `clinic_zipcode` varchar(10) DEFAULT NULL,
  `clinic_status` varchar(255) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clinics`
--

INSERT INTO `clinics` (`clinic_id`, `clinic_name`, `clinic_email`, `clinic_contact`, `clinic_address`, `clinic_city`, `clinic_state`, `clinic_zipcode`, `clinic_status`, `date_created`) VALUES
(10, 'Lanmadaw Branch', 'lc.lanmadaw@lifecare.com', '09123456789', 'Maharbandula Road', 'Yangon', 'Lanmadaw', '11131', '1', '2023-03-25 01:44:48');

-- --------------------------------------------------------

--
-- Table structure for table `clinic_images`
--

CREATE TABLE `clinic_images` (
  `clinicimg_id` int(11) NOT NULL,
  `clinicimg_filename` varchar(255) DEFAULT NULL,
  `clinic_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clinic_images`
--

INSERT INTO `clinic_images` (`clinicimg_id`, `clinicimg_filename`, `clinic_id`) VALUES
(1, 'empty clinic room_3x2_hires_3x2_hires.jpg', 10),
(3, 'img1.jpg', 10);

-- --------------------------------------------------------

--
-- Table structure for table `clinic_reset`
--

CREATE TABLE `clinic_reset` (
  `reset_id` int(11) NOT NULL,
  `reset_email` varchar(255) DEFAULT NULL,
  `reset_selector` text DEFAULT NULL,
  `reset_token` longtext DEFAULT NULL,
  `reset_expires` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clinic_staff`
--

CREATE TABLE `clinic_staff` (
  `staff_id` int(11) NOT NULL,
  `staff_name` varchar(255) DEFAULT NULL,
  `staff_password` varchar(255) DEFAULT NULL,
  `staff_token` varchar(255) DEFAULT NULL,
  `staff_email` varchar(255) DEFAULT NULL,
  `staff_phone` varchar(15) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `clinic_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clinic_staff`
--

INSERT INTO `clinic_staff` (`staff_id`, `staff_name`, `staff_password`, `staff_token`, `staff_email`, `staff_phone`, `date_created`, `clinic_id`) VALUES
(3, 'U Kyaw Oo', 'RfJiofsMNmPrv051Gdb+qK17LiG7wjD6BKJQ5uvF9xZa8+XJPUhkUPQ37MWclRGs', '9131829886335586900274', '5c439685179@lamasticots.com', '09123456789', '2023-03-25 01:44:48', 10);

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `doctor_id` int(11) NOT NULL,
  `doctor_avatar` varchar(255) DEFAULT NULL,
  `doctor_firstname` varchar(255) DEFAULT NULL,
  `doctor_lastname` varchar(255) DEFAULT NULL,
  `doctor_speciality` varchar(255) DEFAULT NULL,
  `doctor_experience` varchar(10) DEFAULT NULL,
  `doctor_desc` text DEFAULT NULL,
  `doctor_password` varchar(255) DEFAULT NULL,
  `doctor_token` varchar(255) DEFAULT NULL,
  `doctor_spoke` varchar(255) DEFAULT NULL,
  `doctor_gender` varchar(10) DEFAULT NULL,
  `doctor_dob` date DEFAULT NULL,
  `doctor_email` varchar(255) DEFAULT NULL,
  `doctor_contact` varchar(15) DEFAULT NULL,
  `consult_fee` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `clinic_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`doctor_id`, `doctor_avatar`, `doctor_firstname`, `doctor_lastname`, `doctor_speciality`, `doctor_experience`, `doctor_desc`, `doctor_password`, `doctor_token`, `doctor_spoke`, `doctor_gender`, `doctor_dob`, `doctor_email`, `doctor_contact`, `consult_fee`, `date_created`, `clinic_id`) VALUES
(1, 'images.png', 'Kyaw', 'Moe Hlaing', '1', '10', 'Graduated MBBS Degree from University of Medicine (2) Yangon in 1995. He did his post graduation, Master in Surgery at University of Medicine (2) Yangon, Myanmar in 2003. At the same time, he completed his advanced surgical training courses such as Advanced Trauma Life Support (ATLS) , Basic Surgical Skill Course and Basic Laparoscopic Surgical Skill Course from University of Medicine (2) Yangon.\n\nDr. Aung Moe Hlaing is a member of Myanmar Medical Association as well as Myanmar Surgical Society and Endoscopic Surgical Society.\nAppointed as a Junior Surgeon in Government Hospital in Myanmar from 2004 to 2009. Then, Dr. Aung Moe Hlaing was promoted to Consultant Surgeon in 2009. During the course of Government Service, he performed many life saving Emergency operations and definitive and curative elective Surgical Operations.', 'Kuzob1atxfZLzBbJO9m8X5/brCRhkSLcGRbSIfE6ZDDhMABxI/UC1axAvKZsEMSI', '2755386851954322688210', 'English,Burmese', 'male', '1988-06-23', '1b659686509@inactivemachine.com', '09123456793', 5000, '2023-03-25 02:06:41', 10),
(2, 'images.png', 'Khin', 'Htwe Kyi', '7', '5', 'Graduated in Medicine from the University of Medicine (1), Yangon in 1972 and thereafter she proceeded her postgraduate training in pediatrics in the University of Medicine (1), Yangon Children Hospital and the UK. Prof. Khin Htwe holds the certificate of higher studies in pediatrics including Fellowship of Royal College of Physicians, Edinburgh and Doctorate of Medical Sciences in Pediatrics, University of Medicine (2), Yangon.\nShe sees children with all general pediatric problems. She has done research in Evaluation of Dengue Blot Test in Myanmar and Preliminary Study of Childhood Nephrosis in Yangon Children Hospital and has published many articles in journals in Myanmar. She also did international publications on diarrhea and dengue infection. She made many conference presentations of the studies related to dengue and other infectious diseases including bacterial meningitis, diarrhea and pneumococcal infection.\nProf Khin Htwe was a Vice-president of the Pediatric Society of Myanmar Medical Association from 2004 to 2009. She was also a member of the Academic Committee of the Pediatric Section, Myanmar Medical Association and Editorial Board of the Myanmar Medical Journal from 1998 to 2004. She actively participated in Material Development of Integrated Management of Maternal and Childhood Illnesses (IMMCI) Programme and Women and Child Health Development (WCHD).', '30Inz4z8ObonfuU64drrXRVJX8HNiWh0RXzjycriesrFRPJpUSnTb4mNd96yg94t', '3867913406567803910980', 'English,Burmese', 'male', '2023-03-25', 'heinkhantzaw1@gmail.com', '09123456793', 40000, '2023-03-25 23:43:52', 10);

-- --------------------------------------------------------

--
-- Table structure for table `doctor_reset`
--

CREATE TABLE `doctor_reset` (
  `reset_id` int(11) NOT NULL,
  `reset_email` varchar(255) DEFAULT NULL,
  `reset_selector` text DEFAULT NULL,
  `reset_token` longtext DEFAULT NULL,
  `reset_expires` text DEFAULT NULL,
  `activate_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medical_record`
--

CREATE TABLE `medical_record` (
  `med_id` int(11) NOT NULL,
  `med_sympton` text DEFAULT NULL,
  `med_diagnosis` text DEFAULT NULL,
  `med_date` datetime DEFAULT NULL,
  `med_advice` text DEFAULT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `clinic_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medical_record`
--

INSERT INTO `medical_record` (`med_id`, `med_sympton`, `med_diagnosis`, `med_date`, `med_advice`, `patient_id`, `clinic_id`, `doctor_id`) VALUES
(2, 'There is Pain in pelvis', 'Maybe Menstrual pain', '2023-03-29 22:21:07', 'lie on your side with a pillow between your knees.', 1, 10, 2);

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `patient_id` int(11) NOT NULL,
  `patient_avatar` varchar(255) DEFAULT NULL,
  `patient_firstname` varchar(255) DEFAULT NULL,
  `patient_lastname` varchar(255) DEFAULT NULL,
  `patient_email` varchar(255) DEFAULT NULL,
  `patient_password` varchar(255) DEFAULT NULL,
  `patient_token` varchar(255) DEFAULT NULL,
  `patient_identity` varchar(255) DEFAULT NULL,
  `patient_nationality` varchar(255) DEFAULT NULL,
  `patient_gender` varchar(255) DEFAULT NULL,
  `patient_maritalstatus` varchar(255) DEFAULT NULL,
  `patient_dob` date DEFAULT NULL,
  `patient_age` varchar(11) DEFAULT NULL,
  `patient_contact` varchar(255) DEFAULT NULL,
  `patient_address` varchar(255) DEFAULT NULL,
  `patient_city` varchar(255) DEFAULT NULL,
  `patient_state` varchar(255) DEFAULT NULL,
  `patient_zipcode` varchar(255) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`patient_id`, `patient_avatar`, `patient_firstname`, `patient_lastname`, `patient_email`, `patient_password`, `patient_token`, `patient_identity`, `patient_nationality`, `patient_gender`, `patient_maritalstatus`, `patient_dob`, `patient_age`, `patient_contact`, `patient_address`, `patient_city`, `patient_state`, `patient_zipcode`, `date_created`) VALUES
(1, NULL, 'Daw', 'Khin', 'nlggvrnaslditgn@eurokool.com', 'Eg8pw1V+mQnz3iugZj/zjVC92DGpoRTVb4VpVhA2oVWEJ7H/nsHhb4pz7t/kIYGv', '7696889925008944128435', '12/MaGaTa(N)123456', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-25 12:44:38');

-- --------------------------------------------------------

--
-- Table structure for table `patient_reset`
--

CREATE TABLE `patient_reset` (
  `reset_id` int(11) NOT NULL,
  `reset_email` varchar(255) DEFAULT NULL,
  `reset_selector` text DEFAULT NULL,
  `reset_token` longtext DEFAULT NULL,
  `reset_expires` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `review` text DEFAULT NULL,
  `date` datetime DEFAULT current_timestamp(),
  `doctor_id` int(11) DEFAULT NULL,
  `patient_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `rating`, `review`, `date`, `doctor_id`, `patient_id`) VALUES
(5, 3, 'good one', '2023-03-25 23:59:30', 2, 1),
(6, 4, 'good', '2023-04-01 01:36:28', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `schedule_id` int(11) NOT NULL,
  `date_from` date DEFAULT NULL,
  `date_to` date DEFAULT NULL,
  `schedule_week` varchar(255) DEFAULT NULL,
  `status` int(5) DEFAULT NULL COMMENT '1=Active | 0= Inactive',
  `doctor_id` int(11) DEFAULT NULL,
  `clinic_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`schedule_id`, `date_from`, `date_to`, `schedule_week`, `status`, `doctor_id`, `clinic_id`) VALUES
(1, '2023-03-01', '2023-08-31', 'Monday', 1, 1, 10),
(2, '2023-03-01', '2023-05-31', 'Tuesday', 1, 2, 10);

-- --------------------------------------------------------

--
-- Table structure for table `schedule_detail`
--

CREATE TABLE `schedule_detail` (
  `schdetail_id` int(11) NOT NULL,
  `time_slot` varchar(255) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '1= Active 0 = Inactive',
  `schedule_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule_detail`
--

INSERT INTO `schedule_detail` (`schdetail_id`, `time_slot`, `duration`, `status`, `schedule_id`) VALUES
(2, '8:30 AM', 3, 1, 1),
(3, '1:30 PM', 2, 1, 1),
(4, '11:30 PM', 2, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `speciality`
--

CREATE TABLE `speciality` (
  `speciality_id` int(11) NOT NULL,
  `speciality_name` varchar(255) DEFAULT NULL,
  `speciality_icon` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `speciality`
--

INSERT INTO `speciality` (`speciality_id`, `speciality_name`, `speciality_icon`) VALUES
(1, 'Cardiology', 'cardio.png'),
(5, 'General Medicine', 'general.png'),
(6, 'Urology', 'urologist.png'),
(7, 'Gynaecology', 'gynaecology.png'),
(8, 'Pediatrics', 'pediatrician.png'),
(9, 'Dental', 'dentist.png');

-- --------------------------------------------------------

--
-- Table structure for table `treatment_type`
--

CREATE TABLE `treatment_type` (
  `treatment_id` int(11) NOT NULL,
  `treatment_name` varchar(255) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `treatment_type`
--

INSERT INTO `treatment_type` (`treatment_id`, `treatment_name`, `doctor_id`) VALUES
(1, 'Pelvic Pain', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`ann_id`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`app_id`);

--
-- Indexes for table `business_hour`
--
ALTER TABLE `business_hour`
  ADD PRIMARY KEY (`businesshour_id`);

--
-- Indexes for table `clinics`
--
ALTER TABLE `clinics`
  ADD PRIMARY KEY (`clinic_id`);

--
-- Indexes for table `clinic_images`
--
ALTER TABLE `clinic_images`
  ADD PRIMARY KEY (`clinicimg_id`);

--
-- Indexes for table `clinic_reset`
--
ALTER TABLE `clinic_reset`
  ADD PRIMARY KEY (`reset_id`);

--
-- Indexes for table `clinic_staff`
--
ALTER TABLE `clinic_staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`doctor_id`),
  ADD KEY `clinic_id` (`clinic_id`);

--
-- Indexes for table `doctor_reset`
--
ALTER TABLE `doctor_reset`
  ADD PRIMARY KEY (`reset_id`);

--
-- Indexes for table `medical_record`
--
ALTER TABLE `medical_record`
  ADD PRIMARY KEY (`med_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`patient_id`);

--
-- Indexes for table `patient_reset`
--
ALTER TABLE `patient_reset`
  ADD PRIMARY KEY (`reset_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`schedule_id`);

--
-- Indexes for table `schedule_detail`
--
ALTER TABLE `schedule_detail`
  ADD PRIMARY KEY (`schdetail_id`);

--
-- Indexes for table `speciality`
--
ALTER TABLE `speciality`
  ADD PRIMARY KEY (`speciality_id`);

--
-- Indexes for table `treatment_type`
--
ALTER TABLE `treatment_type`
  ADD PRIMARY KEY (`treatment_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `ann_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `app_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `business_hour`
--
ALTER TABLE `business_hour`
  MODIFY `businesshour_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `clinics`
--
ALTER TABLE `clinics`
  MODIFY `clinic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `clinic_images`
--
ALTER TABLE `clinic_images`
  MODIFY `clinicimg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `clinic_staff`
--
ALTER TABLE `clinic_staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `doctor_reset`
--
ALTER TABLE `doctor_reset`
  MODIFY `reset_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `medical_record`
--
ALTER TABLE `medical_record`
  MODIFY `med_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `patient_reset`
--
ALTER TABLE `patient_reset`
  MODIFY `reset_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `schedule_detail`
--
ALTER TABLE `schedule_detail`
  MODIFY `schdetail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `speciality`
--
ALTER TABLE `speciality`
  MODIFY `speciality_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `treatment_type`
--
ALTER TABLE `treatment_type`
  MODIFY `treatment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

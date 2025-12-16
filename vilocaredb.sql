-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2025 at 04:44 PM
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
-- Database: `vilocaredb`
--

-- --------------------------------------------------------

--
-- Table structure for table `age_categories`
--

CREATE TABLE `age_categories` (
  `category_id` int(11) NOT NULL,
  `description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `alerts_schedules`
--

CREATE TABLE `alerts_schedules` (
  `alert_id` int(11) NOT NULL,
  `patient_id` varchar(20) DEFAULT NULL,
  `event_type` enum('VL','EAC','repeat_test','follow_up') NOT NULL,
  `due_date` date NOT NULL,
  `status` enum('pending','completed','overdue') NOT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `art_regimens`
--

CREATE TABLE `art_regimens` (
  `regimen_id` int(11) NOT NULL,
  `patient_id` varchar(20) DEFAULT NULL,
  `regimen_details` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `change_reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `log_id` int(11) NOT NULL,
  `action` varchar(100) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action_date` datetime NOT NULL DEFAULT current_timestamp(),
  `patient_id` varchar(20) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clinical_visits`
--

CREATE TABLE `clinical_visits` (
  `visit_id` int(11) NOT NULL,
  `patient_id` varchar(20) DEFAULT NULL,
  `visit_date` date NOT NULL,
  `clinical_notes` text DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `who_stage` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eac_sessions`
--

CREATE TABLE `eac_sessions` (
  `eac_id` int(11) NOT NULL,
  `patient_id` varchar(20) DEFAULT NULL,
  `session_number` int(11) NOT NULL,
  `session_date` date NOT NULL,
  `counselor` varchar(100) DEFAULT NULL,
  `barriers` text DEFAULT NULL,
  `action_plan` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `completion_status` enum('pending','completed') DEFAULT 'pending',
  `next_session_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `import_history`
--

CREATE TABLE `import_history` (
  `import_id` int(11) NOT NULL,
  `import_date` datetime NOT NULL DEFAULT current_timestamp(),
  `file_name` varchar(255) NOT NULL,
  `imported_by` int(11) DEFAULT NULL,
  `status` enum('success','partial','failed') NOT NULL,
  `records_total` int(11) DEFAULT NULL,
  `records_successful` int(11) DEFAULT NULL,
  `records_failed` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `patient_id` varchar(20) NOT NULL,
  `art_number` varchar(30) DEFAULT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `sex` enum('M','F') NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `art_start_date` date NOT NULL,
  `current_regimen` varchar(100) DEFAULT NULL,
  `age_category` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sample_collection`
--

CREATE TABLE `sample_collection` (
  `sample_id` int(11) NOT NULL,
  `patient_id` varchar(20) DEFAULT NULL,
  `collection_date` date NOT NULL,
  `sample_type` enum('plasma','dbs') NOT NULL,
  `collector` varchar(100) DEFAULT NULL,
  `status` enum('collected','rejected','pending') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sample_rejections`
--

CREATE TABLE `sample_rejections` (
  `rejection_id` int(11) NOT NULL,
  `sample_id` int(11) DEFAULT NULL,
  `rejection_date` date NOT NULL,
  `reason` varchar(255) NOT NULL,
  `action_taken` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `role` enum('clinician','lab','data','admin') NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `viral_load_results`
--

CREATE TABLE `viral_load_results` (
  `vl_id` int(11) NOT NULL,
  `patient_id` varchar(20) DEFAULT NULL,
  `sample_date` date NOT NULL,
  `result` varchar(50) NOT NULL,
  `lab` varchar(100) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('suppressed','unsuppressed','pending','invalid') NOT NULL,
  `result_date` date DEFAULT NULL,
  `sample_type` enum('plasma','dbs') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `age_categories`
--
ALTER TABLE `age_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `alerts_schedules`
--
ALTER TABLE `alerts_schedules`
  ADD PRIMARY KEY (`alert_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `art_regimens`
--
ALTER TABLE `art_regimens`
  ADD PRIMARY KEY (`regimen_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `clinical_visits`
--
ALTER TABLE `clinical_visits`
  ADD PRIMARY KEY (`visit_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `eac_sessions`
--
ALTER TABLE `eac_sessions`
  ADD PRIMARY KEY (`eac_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `import_history`
--
ALTER TABLE `import_history`
  ADD PRIMARY KEY (`import_id`),
  ADD KEY `imported_by` (`imported_by`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`patient_id`),
  ADD KEY `age_category` (`age_category`);

--
-- Indexes for table `sample_collection`
--
ALTER TABLE `sample_collection`
  ADD PRIMARY KEY (`sample_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `sample_rejections`
--
ALTER TABLE `sample_rejections`
  ADD PRIMARY KEY (`rejection_id`),
  ADD KEY `sample_id` (`sample_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `viral_load_results`
--
ALTER TABLE `viral_load_results`
  ADD PRIMARY KEY (`vl_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `age_categories`
--
ALTER TABLE `age_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `alerts_schedules`
--
ALTER TABLE `alerts_schedules`
  MODIFY `alert_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `art_regimens`
--
ALTER TABLE `art_regimens`
  MODIFY `regimen_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clinical_visits`
--
ALTER TABLE `clinical_visits`
  MODIFY `visit_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `eac_sessions`
--
ALTER TABLE `eac_sessions`
  MODIFY `eac_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `import_history`
--
ALTER TABLE `import_history`
  MODIFY `import_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sample_collection`
--
ALTER TABLE `sample_collection`
  MODIFY `sample_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sample_rejections`
--
ALTER TABLE `sample_rejections`
  MODIFY `rejection_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `viral_load_results`
--
ALTER TABLE `viral_load_results`
  MODIFY `vl_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alerts_schedules`
--
ALTER TABLE `alerts_schedules`
  ADD CONSTRAINT `alerts_schedules_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`);

--
-- Constraints for table `art_regimens`
--
ALTER TABLE `art_regimens`
  ADD CONSTRAINT `art_regimens_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`);

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `audit_logs_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`);

--
-- Constraints for table `clinical_visits`
--
ALTER TABLE `clinical_visits`
  ADD CONSTRAINT `clinical_visits_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`);

--
-- Constraints for table `eac_sessions`
--
ALTER TABLE `eac_sessions`
  ADD CONSTRAINT `eac_sessions_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`);

--
-- Constraints for table `import_history`
--
ALTER TABLE `import_history`
  ADD CONSTRAINT `import_history_ibfk_1` FOREIGN KEY (`imported_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_ibfk_1` FOREIGN KEY (`age_category`) REFERENCES `age_categories` (`category_id`);

--
-- Constraints for table `sample_collection`
--
ALTER TABLE `sample_collection`
  ADD CONSTRAINT `sample_collection_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`);

--
-- Constraints for table `sample_rejections`
--
ALTER TABLE `sample_rejections`
  ADD CONSTRAINT `sample_rejections_ibfk_1` FOREIGN KEY (`sample_id`) REFERENCES `sample_collection` (`sample_id`);

--
-- Constraints for table `viral_load_results`
--
ALTER TABLE `viral_load_results`
  ADD CONSTRAINT `viral_load_results_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

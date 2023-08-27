-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2023 at 11:00 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_estimation`
--

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `project_name` varchar(50) NOT NULL,
  `project_description` varchar(500) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `project_name`, `project_description`, `start_date`, `end_date`) VALUES
(20, 'Web2023', 'Description', '2023-08-13', '2023-08-30'),
(21, 'Georges HomeWork', 'HomeWork', '2023-07-30', '2023-09-07'),
(22, 'Web2022', 'NotDone', '2023-08-17', '2023-08-30'),
(23, 'WebProject', 'Desc', '2023-08-01', '2023-08-31');

-- --------------------------------------------------------

--
-- Table structure for table `stages`
--

CREATE TABLE `stages` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `stage_name` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `duration` varchar(255) NOT NULL,
  `assigned` varchar(255) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stages`
--

INSERT INTO `stages` (`id`, `project_id`, `stage_name`, `description`, `start_date`, `end_date`, `duration`, `assigned`, `status`) VALUES
(19, 20, 'First Stage', 'First', '0000-00-00', '0000-00-00', '', '', ''),
(20, 20, 'Final Stage', 'Finale', '0000-00-00', '0000-00-00', '', '', ''),
(21, 20, 'ExtremeStage', 'Extreme', '0000-00-00', '0000-00-00', '', '', ''),
(22, 23, 'UserStage', 'Description', '0000-00-00', '0000-00-00', '', '', ''),
(23, 23, 'WebAppStage', 'Description', '0000-00-00', '0000-00-00', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `stage_id` int(11) NOT NULL,
  `task_name` varchar(100) NOT NULL,
  `task_description` varchar(500) NOT NULL,
  `status` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `duration` varchar(255) NOT NULL,
  `assigned` varchar(255) NOT NULL,
  `estimation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `project_id`, `stage_id`, `task_name`, `task_description`, `status`, `start_date`, `end_date`, `duration`, `assigned`, `estimation`) VALUES
(27, 20, 19, 'SitDown', 'Descr', 'In Progress', '2023-08-13', '2023-08-20', '7', '12', 100),
(28, 20, 20, 'WriteCode', 'Write', 'In Progress', '2023-08-18', '2023-08-30', '12', '12', 150),
(29, 20, 20, 'Test', 'Test', 'Open', '2023-08-24', '2023-08-28', '4', '12', 50),
(30, 20, 20, 'Move to AWS', 'AWS', 'Done', '2023-08-25', '2023-08-28', '3', '12', 30),
(31, 20, 19, 'Procrastinate', 'Procrastinate', 'Done', '2023-08-13', '2023-08-23', '10', '12', 300),
(32, 20, 19, 'SurpriseWork', 'Work', 'Done', '2023-08-15', '2023-08-18', '3', '13', 150),
(33, 20, 0, 'MiddleTask', 'Middle', 'Open', '0000-00-00', '0000-00-00', '', '14', 0),
(34, 23, 22, 'DummyTaskOne', 'Desc', 'In Progress', '2023-08-04', '2023-08-08', '4', '12', 100),
(35, 23, 22, 'DummyTaskTwo', 'Dummy', 'Done', '2023-08-15', '2023-08-19', '4', '12', 200),
(36, 23, 23, 'DummyTaskThree', 'Descr', 'Open', '2023-08-19', '2023-08-23', '4', '15', 173),
(37, 23, 23, 'DummyTaskFour', 'Dummy', 'Done', '2023-08-12', '2023-08-20', '8', '12', 300),
(38, 23, 22, 'DummyTaskFive', 'Five', 'Done', '2023-08-29', '2023-08-30', '1', '15', 350);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(12, 'Boris', '$2y$10$ebN/u0ybWq7n5ttC3/ahY.pVWnwyPoD3qBn6wET697V4TfLKV41HS'),
(13, 'George', '$2y$10$dOj.Za5u5BQYtn5qYHRiHeU6nQSFbMJeli8URXFaJN3pF7EsGpoA.'),
(14, 'Petko', '$2y$10$IWQT42/dcYpBbAGyRolTA.xPO7VZK1TjO6B.YENOTNygCol.k4EoK'),
(15, 'User', '$2y$10$RGu8Tfm.yGBR0B.7xPzrGeCehOuB35rUqarGE6GxKWBjyBf.tlCXO');

-- --------------------------------------------------------

--
-- Table structure for table `user_projects`
--

CREATE TABLE `user_projects` (
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `project_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_projects`
--

INSERT INTO `user_projects` (`user_id`, `project_id`, `project_name`) VALUES
(12, 20, 'Web2023'),
(12, 22, 'Web2022'),
(12, 23, 'WebProject'),
(13, 20, 'Web2023'),
(13, 21, 'Georges HomeWork'),
(14, 20, 'Web2023'),
(14, 22, 'Web2022'),
(15, 23, 'WebProject');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `project_name` (`project_name`);

--
-- Indexes for table `stages`
--
ALTER TABLE `stages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_projects`
--
ALTER TABLE `user_projects`
  ADD PRIMARY KEY (`user_id`,`project_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `stages`
--
ALTER TABLE `stages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

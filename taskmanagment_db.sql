-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2023 at 06:10 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `taskmanagment_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categories_id` int(11) NOT NULL,
  `categories_name` varchar(255) NOT NULL,
  `categories_note` varchar(255) NOT NULL,
  `categories_status` int(11) NOT NULL DEFAULT 0,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categories_id`, `categories_name`, `categories_note`, `categories_status`, `created_date`) VALUES
(1, 'Web Developement', 'We want to become a Web developer', 0, '2023-06-23 10:44:32'),
(3, 'test 3', 'test 3', 1, '2023-06-24 18:35:39'),
(4, 'test', 'test 1', 1, '2023-06-24 18:36:04'),
(5, 'test 3', 'test 3', 1, '2023-06-24 18:37:23'),
(6, 'Backend developer', 'Backend developer', 1, '2023-06-24 18:57:04');

-- --------------------------------------------------------

--
-- Table structure for table `designation`
--

CREATE TABLE `designation` (
  `designation_id` bigint(20) NOT NULL,
  `designation_name` varchar(255) NOT NULL,
  `categories_id` int(255) NOT NULL,
  `designation_description` text NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `designation`
--

INSERT INTO `designation` (`designation_id`, `designation_name`, `categories_id`, `designation_description`, `created_date`) VALUES
(1, 'Backend Developer (Junior)', 1, 'The Person who has Experience 1-3 year and deal with DATABASE and API\'s and deal with logic of backend', '2023-06-25 08:37:52'),
(2, 'Web developement', 1, '<p>Web developement<br></p>', '2023-06-25 09:14:13'),
(3, 'Frontend Developer', 6, '<p>Frontend Developer<br></p>', '2023-06-25 09:16:17');

-- --------------------------------------------------------

--
-- Table structure for table `productivities`
--

CREATE TABLE `productivities` (
  `product_id` bigint(20) NOT NULL,
  `project_id` int(11) NOT NULL,
  `task_id` int(255) NOT NULL,
  `product_subject` varchar(255) NOT NULL,
  `product_from_date` varchar(255) NOT NULL,
  `product_to_date` varchar(255) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `product_status` int(12) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productivities`
--

INSERT INTO `productivities` (`product_id`, `project_id`, `task_id`, `product_subject`, `product_from_date`, `product_to_date`, `product_description`, `product_status`, `created_date`) VALUES
(1, 1, 0, 'Product_subject', '26-06-2023', '26-06-2023', 'product_description', 1, '2023-06-26 08:10:44'),
(2, 1, 0, 'Product_subject 1', '26-06-2023', '26-06-2023', 'product_description', 1, '2023-06-26 08:10:44'),
(4, 1, 4, 'Subject testddd', '2023-06-01', '2023-06-30', '<p>Product Descroption zzzz</p>', 0, '2023-06-27 03:35:35');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `project_id` bigint(255) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `categories_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `team_member_id` int(255) NOT NULL,
  `project_from_date` varchar(255) NOT NULL,
  `project_to_date` varchar(255) NOT NULL,
  `project_description` varchar(255) DEFAULT NULL,
  `project_status` int(10) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`project_id`, `project_name`, `categories_id`, `user_id`, `team_member_id`, `project_from_date`, `project_to_date`, `project_description`, `project_status`, `created_date`) VALUES
(1, 'Test', 6, 1, 6, '2023-06-10', '2023-06-24', 'test 22', 3, '2023-06-25 10:01:44');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `task_id` bigint(20) NOT NULL,
  `project_id` int(255) NOT NULL,
  `task_description` varchar(255) NOT NULL,
  `task_from_date` varchar(255) NOT NULL,
  `task_to_date` varchar(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `task_status` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`task_id`, `project_id`, `task_description`, `task_from_date`, `task_to_date`, `user_id`, `task_status`, `created_date`) VALUES
(1, 1, 'create Database', '2023-06-01', '2023-06-26', 1, 1, '2023-06-26 07:30:15'),
(3, 1, '<p>Task Description</p>', '2023-06-01', '2023-06-30', 2, 0, '2023-06-26 07:38:19'),
(4, 1, '<p>res&nbsp; &nbsp; ;pjvpd</p>', '2023-06-01', '2023-06-30', 1, 0, '2023-06-26 16:40:07'),
(5, 1, 'test', '2023-06-01', '2023-06-29', 2, 1, '2023-06-26 16:40:40');

-- --------------------------------------------------------

--
-- Table structure for table `team_member`
--

CREATE TABLE `team_member` (
  `team_member_id` bigint(20) NOT NULL,
  `team_member_image` varchar(255) NOT NULL,
  `team_member_name` varchar(255) NOT NULL,
  `team_member_email` varchar(255) NOT NULL,
  `team_member_phone` bigint(255) NOT NULL,
  `designation_id` int(255) NOT NULL,
  `categories_id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `team_member_status` int(10) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_member`
--

INSERT INTO `team_member` (`team_member_id`, `team_member_image`, `team_member_name`, `team_member_email`, `team_member_phone`, `designation_id`, `categories_id`, `address`, `team_member_status`, `created_date`) VALUES
(1, 'xo38dxJuJCliu564f4sj.jpg', 'Syed Zulkharnain', 'SyedZulkharnain334@gmail.com', 1234567895, 2, 1, 'Nhi mlm', 0, '2023-06-25 10:35:10'),
(5, 'YA2CbY1FHnIqC2kL2wRc.jpg', 'Syed Zulkharnain', 'SyedZulkharnain334@gmail.com', 1234567895, 2, 1, 'Nhi mlm', 0, '2023-06-25 16:29:43'),
(6, 'oOxRVK1v77vyo1tOM0BG.jpg', 'Syed Zulkharnain', 'SyedZulkharnain334@gmail.com', 1234567895, 2, 1, 'Nhi mlm', 1, '2023-06-25 16:30:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_image` varchar(255) DEFAULT NULL,
  `user_first_name` varchar(255) NOT NULL,
  `user_last_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_phone` bigint(12) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `user_type` int(11) NOT NULL,
  `user_status` int(11) NOT NULL DEFAULT 0,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_image`, `user_first_name`, `user_last_name`, `user_email`, `user_password`, `user_phone`, `group_id`, `user_type`, `user_status`, `created_date`) VALUES
(1, 'mfogYTnavtzr0TQt3WLL.jpg', 'syed', 'zulkharnain', 'syedzulkharnain334@gmail.com', 'syedzulkharnain334@gmail.com', 9877687541, 2, 1, 0, '2023-06-23 09:11:14'),
(2, 'oKHJM4bpDCftMAPB9w6V.jpg', 'shaikh', 'zulkharnain', 'shaikhzulkharnain334@gmail.com', 'shaikhzulkharnain334@gmail.com', 9877687541, 2, 0, 0, '2023-06-23 09:11:14'),
(5, 'rjjfz9GvbosqtpBtI6Go.jpg', 'Super', 'Admin', 'SuperAdmin', 'SuperAdmin', 9172377686, 1, 0, 0, '2023-06-27 02:57:39'),
(6, '9eUSjHZnklDuHr0ylkl4.jpg', 'Employee', 'Login', 'EmployeeLogin', 'EmployeeLogin', 12345678909, 8, 1, 1, '2023-06-27 02:59:00');

-- --------------------------------------------------------

--
-- Table structure for table `users_group`
--

CREATE TABLE `users_group` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `group_description` varchar(255) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_group`
--

INSERT INTO `users_group` (`group_id`, `group_name`, `group_description`, `created_date`) VALUES
(1, 'Web Developement', 'those Developer who can handle frontend and backend. those developer will be Web developer.', '2023-06-24 17:41:22'),
(2, 'Backend Developer', '<p>Backend Developer<br></p>', '2023-06-24 17:54:48'),
(3, 'Frontend Developer', '<p>Frontend Developer<br></p>', '2023-06-24 17:59:54'),
(5, 'Flutter Developer', '<p>Flutter Developer<br></p>', '2023-06-27 02:54:32'),
(6, 'React js Developer', '<p>React js Developer<br></p>', '2023-06-27 02:54:52'),
(7, 'Node js Developer', '<p>Node js Developer<br></p>', '2023-06-27 02:55:09'),
(8, 'Laravel Developer', '<p>Laravel Developer<br></p>', '2023-06-27 02:55:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categories_id`);

--
-- Indexes for table `designation`
--
ALTER TABLE `designation`
  ADD PRIMARY KEY (`designation_id`);

--
-- Indexes for table `productivities`
--
ALTER TABLE `productivities`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`task_id`);

--
-- Indexes for table `team_member`
--
ALTER TABLE `team_member`
  ADD PRIMARY KEY (`team_member_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `users_group`
--
ALTER TABLE `users_group`
  ADD PRIMARY KEY (`group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categories_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `designation`
--
ALTER TABLE `designation`
  MODIFY `designation_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `productivities`
--
ALTER TABLE `productivities`
  MODIFY `product_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `project_id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `task_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `team_member`
--
ALTER TABLE `team_member`
  MODIFY `team_member_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users_group`
--
ALTER TABLE `users_group`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

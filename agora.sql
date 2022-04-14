-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2022 at 06:47 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `agora`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_code` varchar(9) NOT NULL,
  `course_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_code`, `course_name`) VALUES
('ITECH3209', 'Project 2');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(8) NOT NULL,
  `post_content` text NOT NULL,
  `post_media` text NOT NULL,
  `post_likes` int(8) NOT NULL,
  `post_date` datetime NOT NULL DEFAULT current_timestamp(),
  `post_topic` int(8) NOT NULL,
  `post_by` int(8) NOT NULL,
  `status` enum('normal','pinned','deleted','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `post_content`, `post_media`, `post_likes`, `post_date`, `post_topic`, `post_by`, `status`) VALUES
(1, 'Your name is dragonking.', '', 23, '2022-03-24 18:25:18', 1, 21, 'normal'),
(18, 'Nothing at all', '', 0, '2022-04-07 17:28:10', 24, 21, 'normal');

-- --------------------------------------------------------

--
-- Table structure for table `question_attempt`
--

CREATE TABLE `question_attempt` (
  `attempt_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `response` varchar(250) NOT NULL,
  `correct` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `question_attempt`
--

INSERT INTO `question_attempt` (`attempt_id`, `question_id`, `response`, `correct`) VALUES
(1, 1, 'admin', 1),
(1, 2, 'Agora', 1),
(1, 3, 'dragonking', 1),
(1, 4, 'admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `quiz_id` int(11) NOT NULL,
  `quiz_title` text NOT NULL,
  `quiz_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`quiz_id`, `quiz_title`, `quiz_by`) VALUES
(1, 'The basics of designing quizzes', 22);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_attempt`
--

CREATE TABLE `quiz_attempt` (
  `attempt_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `attempt_by` int(11) NOT NULL,
  `total_crorrect` int(11) NOT NULL,
  `time_completed` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz_attempt`
--

INSERT INTO `quiz_attempt` (`attempt_id`, `quiz_id`, `attempt_by`, `total_crorrect`, `time_completed`) VALUES
(1, 1, 21, 4, '2022-03-31 21:10:50');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_questions`
--

CREATE TABLE `quiz_questions` (
  `question_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `quiz_by` int(11) NOT NULL,
  `question` text NOT NULL,
  `supporting_media` text NOT NULL,
  `option_a` varchar(250) NOT NULL,
  `option_b` varchar(250) NOT NULL,
  `option_c` varchar(250) NOT NULL,
  `option_d` varchar(250) NOT NULL,
  `answer` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz_questions`
--

INSERT INTO `quiz_questions` (`question_id`, `quiz_id`, `quiz_by`, `question`, `supporting_media`, `option_a`, `option_b`, `option_c`, `option_d`, `answer`) VALUES
(1, 1, 22, 'What is my name?', '', 'admin', 'dragonking', 'both', 'neither', 'admin'),
(2, 1, 22, 'What is this forum called?', '', 'Fedora', 'Agora', 'IIBIT forum', 'Federation University Forum', 'Agora'),
(3, 1, 22, 'What is your name?', '', 'dragonking', 'admin', 'none', 'teacher', 'dragonking'),
(4, 1, 22, 'Which user group has the most power?', '', 'student', 'admin', 'teachers', 'all', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `topic_id` int(8) NOT NULL,
  `topic_course` varchar(9) NOT NULL,
  `topic_subject` varchar(255) NOT NULL,
  `topic_desc` text NOT NULL,
  `embed_media` text NOT NULL,
  `topic_date` datetime NOT NULL DEFAULT current_timestamp(),
  `topic_by` int(8) NOT NULL,
  `status` enum('open','closed','deleted','') NOT NULL DEFAULT 'open'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`topic_id`, `topic_course`, `topic_subject`, `topic_desc`, `embed_media`, `topic_date`, `topic_by`, `status`) VALUES
(1, 'ITECH3209', 'What is my name?', 'I need to know the name on my birth certificate since I cant remember it at all.', '', '2022-03-24 18:24:26', 21, 'open'),
(24, 'ITECH3209', 'What do I do with my life?', 'I have no life path so I do not know what to do with my life. Help.', '', '2022-04-07 17:27:58', 21, 'open');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','teacher','student') NOT NULL,
  `status` enum('active','awaiting approval','disabled') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `status`) VALUES
(21, 'dragonking', 'dragonking@gmail.com', '$2y$10$XZUA2VSrd7BC/a9Sd7KRaOieaH7.E.06D2GqcHLBk2drnfy2TqG46', 'student', 'active'),
(22, 'admin', 'admin@forum.site', '$2y$10$KNNyGqvBBFWQOAp2AyEI9e7HykPDuM.11K1pwhTK9c5t722fH/G8i', 'admin', 'active'),
(23, 'sampleteacher', 'teacher@gmail.com', '$2y$10$AghWiLTVFq0eBCKhG2w/fujvAUFzkTkYIlyYsG34wcRi4BxSZN7CW', 'teacher', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_code`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `post_topic` (`post_topic`),
  ADD KEY `post_by` (`post_by`);

--
-- Indexes for table `question_attempt`
--
ALTER TABLE `question_attempt`
  ADD KEY `question_id` (`question_id`),
  ADD KEY `attempt_id` (`attempt_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`quiz_id`),
  ADD KEY `quiz_by` (`quiz_by`);

--
-- Indexes for table `quiz_attempt`
--
ALTER TABLE `quiz_attempt`
  ADD PRIMARY KEY (`attempt_id`),
  ADD KEY `attempt_by` (`attempt_by`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `quiz_by` (`quiz_by`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`topic_id`),
  ADD KEY `topic_by` (`topic_by`),
  ADD KEY `topic_course` (`topic_course`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `quiz_attempt`
--
ALTER TABLE `quiz_attempt`
  MODIFY `attempt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `topic_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`post_topic`) REFERENCES `topics` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`post_by`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `question_attempt`
--
ALTER TABLE `question_attempt`
  ADD CONSTRAINT `question_attempt_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `quiz_questions` (`question_id`),
  ADD CONSTRAINT `question_attempt_ibfk_2` FOREIGN KEY (`attempt_id`) REFERENCES `quiz_attempt` (`attempt_id`);

--
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_ibfk_1` FOREIGN KEY (`quiz_by`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `quiz_attempt`
--
ALTER TABLE `quiz_attempt`
  ADD CONSTRAINT `quiz_attempt_ibfk_1` FOREIGN KEY (`attempt_by`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `quiz_attempt_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`quiz_id`) ON UPDATE CASCADE;

--
-- Constraints for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD CONSTRAINT `quiz_questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`quiz_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `quiz_questions_ibfk_2` FOREIGN KEY (`quiz_by`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `topics_ibfk_1` FOREIGN KEY (`topic_by`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `topics_ibfk_2` FOREIGN KEY (`topic_course`) REFERENCES `courses` (`course_code`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

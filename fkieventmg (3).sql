-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2024 at 03:17 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fkieventmg`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendee`
--

CREATE TABLE `attendee` (
  `attendee_id` int(11) NOT NULL,
  `attendance_status` varchar(15) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `student_id` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendee`
--

INSERT INTO `attendee` (`attendee_id`, `attendance_status`, `event_id`, `student_id`) VALUES
(16, 'A', 7, 'BI21110014'),
(17, 'A', 8, 'BI21110014'),
(18, 'A', 9, 'BI21110014'),
(24, 'B', 8, 'BI21110015'),
(25, 'B', 9, 'BI21110015'),
(26, 'A', 13, 'BI21110015'),
(28, 'B', 7, '111');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `event_id` int(11) NOT NULL,
  `event_name` varchar(255) DEFAULT NULL,
  `event_synopsis` longtext DEFAULT NULL,
  `event_objective` longtext DEFAULT NULL,
  `event_impact` longtext DEFAULT NULL,
  `event_startDate` date DEFAULT NULL,
  `event_endDate` date DEFAULT NULL,
  `event_startTime` time DEFAULT NULL,
  `event_endTime` time DEFAULT NULL,
  `event_venue` varchar(255) DEFAULT NULL,
  `event_poster` varchar(255) DEFAULT NULL,
  `event_posterDesc` longtext NOT NULL,
  `event_pwd` varchar(50) DEFAULT NULL,
  `event_status` varchar(10) DEFAULT NULL,
  `event_adminRemark` longtext NOT NULL,
  `admin_id` varchar(20) DEFAULT NULL,
  `pmfki_id` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`event_id`, `event_name`, `event_synopsis`, `event_objective`, `event_impact`, `event_startDate`, `event_endDate`, `event_startTime`, `event_endTime`, `event_venue`, `event_poster`, `event_posterDesc`, `event_pwd`, `event_status`, `event_adminRemark`, `admin_id`, `pmfki_id`) VALUES
(7, 'CYBER HUNT CHALLENGE', 'The CyberHunt Challenge Program is an innovative and immersive cybersecurity initiative designed to cultivate and harness the talents of cybersecurity enthusiasts and professionals. This dynamic program aims to simulate real-world cyber threats, providing participants with hands-on experience in identifying, mitigating, and responding to diverse cybersecurity challenges. Through a series of engaging exercises and scenarios, participants will navigate through various cybersecurity landscapes, honing their skills and contributing to the collective resilience against cyber threats.', 'Develop Practical Skills: Enable participants to apply theoretical knowledge in real-world situations, enhancing their ability to secure systems and data.\r\nFoster Collaboration: Promote teamwork and collaboration among participants, as effective cybersecurity often requires collective intelligence and diverse skill sets.\r\nEnhance Incident Response: Train participants in rapid and effective incident response techniques, reducing the impact of cyber attacks.\r\nEncourage Continuous Learning: Inspire a culture of continuous learning by staying abreast of the latest cybersecurity trends and technologies.', 'Building a Skilled Workforce: Equipping participants with advanced cybersecurity skills contributes to the development of a highly skilled and capable cybersecurity workforce, ready to tackle emerging threats.\r\n\r\nIncreasing Cybersecurity Resilience: By providing realistic challenges, the program enhances participants\' ability to anticipate, detect, and respond to cyber threats, ultimately bolstering the overall resilience of organizations and systems.\r\n\r\nPromoting Innovation: Encouraging creative problem-solving within the challenges fosters innovation, leading to the development of new strategies and tools in the fight against cybercrime.\r\n\r\nCreating a Networking Platform: The program serves as a platform for cybersecurity professionals to connect, share knowledge, and build a collaborative community that extends beyond the program itself.', '2024-09-11', '2024-09-25', '10:00:00', '18:00:00', 'SANDBOX KSTI, KK', '7_f3dbd849ab065b1c_1705219487.jpg', 'Unleash your cybersecurity prowess in the CyberHunt Challenge! Dive into a simulated cyber battleground, where threats are real, and only the sharpest defenders survive. From detecting stealthy attacks to crafting rapid responses, this challenge will test your skills in a dynamic, hands-on environment.', '123', 'A', '', '1001', 'BI21110011'),
(8, 'STAR AWARDS DINNER', 'The StarAward Dinner stands as an illustrious celebration, recognizing and honoring outstanding achievements across various domains. This prestigious event brings together luminaries, leaders, and visionaries to applaud exceptional accomplishments, fostering inspiration and camaraderie within the community.', 'Recognizing Excellence: The primary objective of the StarAward Dinner is to acknowledge and celebrate excellence in diverse fields, including business, science, technology, arts, and humanitarian efforts.\r\n\r\nInspiring Success: By showcasing success stories and remarkable achievements, the event aims to inspire attendees to strive for greatness in their respective pursuits.\r\n\r\nNetworking and Collaboration: Providing a platform for professionals and influencers to connect, the StarAward Dinner encourages collaboration and the exchange of ideas, fostering a community of innovators and thought leaders.\r\n\r\nSupporting Philanthropy: In addition to recognizing accomplishments, the event may serve as a vehicle for philanthropy, raising funds and awareness for charitable causes aligned with the values of the award recipients.', 'Celebrating Achievements: The StarAward Dinner contributes to a culture that recognizes and celebrates achievements, creating role models and inspiring future generations.\r\n\r\nPromoting Excellence: By acknowledging excellence, the event encourages a commitment to quality, innovation, and continuous improvement in various fields.\r\n\r\nCommunity Building: The gathering of accomplished individuals fosters a sense of community, where professionals can share experiences, insights, and support one another in their pursuits.\r\n\r\nPhilanthropic Contributions: The event\'s potential philanthropic efforts extend the impact beyond individual achievements, making a positive difference in the broader community.', '2024-02-08', '2024-02-08', '19:50:00', '23:00:00', 'SABAH ORIENTAL HOTEL', '8_4268b85d5be88d40_1705219534.jpg', '🌟 Join us for an Evening of Excellence!\r\n\r\nUnveil the brilliance within our community at the StarAward Dinner. A night of glamour, inspiration, and celebration awaits as we honor outstanding achievements across various domains. Be part of the legacy, witness greatness, and connect with luminaries who are shaping the future. Reserve your seat and let\'s celebrate excellence together!', '123', 'A', '', '1001', 'BI21110011'),
(9, '30 HOURS CHALLENGE', 'The 30-Hour Challenge Startup is an exhilarating and intensive innovation event designed to propel budding entrepreneurs from concept to creation within a condensed timeframe. This startup accelerator brings together visionary minds, mentors, and industry experts for a dynamic 30-hour sprint, transforming innovative ideas into viable business ventures.', 'Rapid Ideation and Prototyping: The primary goal of the 30-Hour Challenge Startup is to catalyze the ideation and prototyping phase, pushing participants to refine their concepts and bring them to a tangible form within the 30-hour timeframe.\r\n\r\nEncouraging Entrepreneurship: By providing a supportive environment, the event aims to nurture entrepreneurship by empowering participants to turn their creative ideas into viable startup projects.\r\n\r\nMentorship and Guidance: Industry experts and mentors play a crucial role, guiding participants through challenges, providing insights, and sharing valuable experience to enhance the quality of the startups.\r\n\r\nFostering Collaboration: The event emphasizes teamwork and collaboration, encouraging participants to leverage diverse skills and perspectives to create robust and well-rounded startups.', 'Accelerated Startup Development: The 30-Hour Challenge accelerates the startup development process, pushing participants to rapidly iterate, adapt, and execute their ideas, preparing them for the fast-paced nature of the startup ecosystem.\r\n\r\nNetworking Opportunities: Participants have the chance to connect with mentors, industry experts, and potential collaborators, expanding their network within the entrepreneurial community.\r\n\r\nSkill Enhancement: Through hands-on experience, workshops, and mentorship, participants gain practical skills in entrepreneurship, project management, and effective communication.\r\n\r\nSeed Funding Opportunities: Exceptional startups may attract the attention of investors present at the event, opening avenues for seed funding and further development.', '2024-02-21', '2024-02-23', '10:00:00', '12:00:00', 'DEWAN RESITAL UMS', '9_9a7b89380d47e404_1705219609.jpg', '🚀 Ignite Your Startup Journey in 30 Hours!\r\n\r\nCalling all aspiring entrepreneurs and innovators! Dive into the 30-Hour Challenge Startup and transform your idea into a viable venture. With mentors, workshops, and a sprint to success, this intense accelerator promises to catapult your startup dreams. Are you up for the challenge? Don\'t miss the opportunity to turn your vision into reality!', '123', 'A', '', '1001', 'BI21110011'),
(13, 'SCRATCH WORKSHOP', 'The Scratch Workshop is an engaging and interactive learning experience designed to introduce participants to the world of creative coding using the Scratch programming language. Geared towards beginners, this workshop empowers individuals of all ages to express their creativity through coding, fostering a fun and inclusive environment for learning the basics of programming and computational thinking.', 'Introduction to Coding: The primary goal of the Scratch Workshop is to provide participants with a friendly introduction to coding, breaking down barriers and making programming accessible to everyone.', 'Creativity and Expression: Through hands-on activities, the workshop encourages participants to unleash their creativity by designing and coding interactive stories, animations, and games using Scratch.\r\n\r\nBuilding Computational Thinking: Participants learn fundamental computational thinking concepts such as sequencing, loops, and conditionals, laying a solid foundation for understanding more advanced programming principles.\r\n\r\nInclusivity: The workshop aims to create an inclusive learning environment, welcoming participants from divers', '2024-01-31', '2024-01-31', '21:17:00', '23:17:00', 'FKI', '13_0af873bd3a465bf1_1705404014.jpg', '🚀 Unlock Your Creativity with Scratch Workshop! 🚀\r\n\r\n🌟 Join us for an interactive and fun-filled Scratch Workshop where imagination knows no bounds! 🌈\r\n\r\n🎨 What is Scratch? 🎮\r\nScratch is a beginner-friendly programming language that lets you create your own interactive stories, games, and animations. Whether you\'re a coding enthusiast or a total beginner, this workshop is designed for everyone!\r\n\r\n🔍 What to Expect? 🔍\r\n🚀 Hands-on Learning: Dive into the world of coding with our step-by-step guidance.\r\n💡 Creative Exploration: Unleash your creativity and build projects that reflect your unique style.\r\n🤝 Collaborative Environment: Connect with like-minded individuals, share ideas, and collaborate on exciting projects.\r\n🌐 Web-Based: No need for installations! Scratch is an online platform accessible from any device with a web browser.', '123', 'F', '', '1001', 'BI21110020'),
(14, 'TEST EVENT', 'TESTING', 'TESTING', 'TESTING', '2024-08-15', '2024-08-15', '15:53:00', '17:56:00', 'DKP BARU', NULL, '', NULL, 'C', '', '1001', '111');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `comment` longtext DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `student_id` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `rating`, `comment`, `event_id`, `student_id`) VALUES
(7, 5, 'GOOD', 8, 'BI21110014'),
(8, 5, 'INTERESTING', 7, 'BI21110014'),
(9, 5, 'WOW', 9, 'BI21110014'),
(12, 5, 'GOOD', 13, 'BI21110015');

-- --------------------------------------------------------

--
-- Table structure for table `fki_admin`
--

CREATE TABLE `fki_admin` (
  `admin_id` varchar(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `ic` varchar(20) DEFAULT NULL,
  `pwd` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fki_admin`
--

INSERT INTO `fki_admin` (`admin_id`, `name`, `phone`, `ic`, `pwd`) VALUES
('1001', 'MICHAEL ', '01129878971', '010101121010', 'ADMIN');

-- --------------------------------------------------------

--
-- Table structure for table `pmfki`
--

CREATE TABLE `pmfki` (
  `pmfki_id` varchar(20) NOT NULL,
  `pmfki_name` varchar(255) DEFAULT NULL,
  `pmfki_phone` varchar(20) DEFAULT NULL,
  `pmfki_ic` varchar(12) DEFAULT NULL,
  `pmfki_pwd` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pmfki`
--

INSERT INTO `pmfki` (`pmfki_id`, `pmfki_name`, `pmfki_phone`, `pmfki_ic`, `pmfki_pwd`) VALUES
('11', 'ZAAA', '01129878971', '11', '$2y$10$xViyhCkwgZ0NKMz1c53XYesb14UcMr6dTPmk2NXFJu58gu4OjP4Hy'),
('111', 'PIKA', '111', '111', '$2y$10$kjDGR31Mzh/bIz4MQlvdCOqFiinCcKAjT9FnlLEdtkpbrKDryiiRy'),
('123', 'ZAW', '123', '123', '$2y$10$fF8fxX7QMBe0hx4jxXpcvubael7PEEdQMJ8IVVQUNAseIxlfj3mfa'),
('BI21110011', 'AMEERA', '01129878765', '020202020202', '$2y$10$ej9ZpnNHAGBr5ob5Yq2qsuvt2atVu12cmkMO40NziNGu9DhR0uBVK'),
('BI21110020', 'SYUFI BIN SARIDIH', '01129858965', '020509121035', '$2y$10$FA03UY8rwXI5oN3JXamgV.jfkJYwDE5x0GR2cYPDc65j0ChI.od86');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` varchar(20) NOT NULL,
  `student_name` varchar(255) DEFAULT NULL,
  `student_ic` varchar(12) DEFAULT NULL,
  `student_email` varchar(255) DEFAULT NULL,
  `student_phone` varchar(20) DEFAULT NULL,
  `student_address` longtext DEFAULT NULL,
  `student_pwd` longtext DEFAULT NULL,
  `student_profilePic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `student_name`, `student_ic`, `student_email`, `student_phone`, `student_address`, `student_pwd`, `student_profilePic`) VALUES
('111', 'ZAW', '111', '111@yahoo.com', '111', '111', '$2y$10$uEpyDSUh73rXkg1pxm.jqO9X6bIcTG735EkGx0MH9pliOD7LjfBay', '111.png'),
('123', '123', '123', '123', '123', '123', '$2y$10$9ItgJZYc3LfkUI2CPsHuSeOE/hrSwGx/5cfQqP.Btglicy0x7Sti.', '123.jpg'),
('BI21110014', 'MUHAMMAD ZAWAWIE BIN ABDUL AMIN', '020509121032', 'zawawie@gmail.com', '01129878965', 'SANDAKAN SABAH', '$2y$10$GpM8a8C4coyA5KXXzr3On.MKGBGYGpG/v/JaxBbznRMnIudHpFndi', 'BI21110014.jpg'),
('BI21110015', 'HAAMDA BINTI JUANDA', '020301121036', 'HAAMDA@GMAIL.COM', '01239858971', 'KUALA LUMPUR', '$2y$10$Nc/RPLZm2jyUVZH/nRiE/O14Wrf7A7R07tqNDwN4U4fkWA2foBL4S', 'BI21110015.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendee`
--
ALTER TABLE `attendee`
  ADD PRIMARY KEY (`attendee_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `pmfki_id` (`pmfki_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `fki_admin`
--
ALTER TABLE `fki_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `pmfki`
--
ALTER TABLE `pmfki`
  ADD PRIMARY KEY (`pmfki_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendee`
--
ALTER TABLE `attendee`
  MODIFY `attendee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendee`
--
ALTER TABLE `attendee`
  ADD CONSTRAINT `attendee_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`),
  ADD CONSTRAINT `attendee_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `fki_admin` (`admin_id`),
  ADD CONSTRAINT `event_ibfk_2` FOREIGN KEY (`pmfki_id`) REFERENCES `pmfki` (`pmfki_id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`),
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

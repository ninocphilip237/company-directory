-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2020 at 08:50 AM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `company_directory`
--

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `city_name` text NOT NULL,
  `city_decription` text NOT NULL,
  `meta_title` text NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL,
  `image` text NOT NULL,
  `status` int(11) NOT NULL,
  `added_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `added_user` int(11) NOT NULL,
  `city_slug` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `state_id`, `city_name`, `city_decription`, `meta_title`, `meta_description`, `meta_keywords`, `image`, `status`, `added_date`, `added_user`, `city_slug`) VALUES
(1, 1, 'Valanchery', 'A town in malappuram dist.', 'vly', 'valanchery town', 'valanchry,vly', '', 1, '2020-06-09 00:00:00', 1, 'valanchery'),
(2, 1, 'Kochi', 'Queen of Arabian Sea', 'Kochi', 'Queen of Arabian Sea', 'kochi,sea,kerala', '0.jpeg', 1, '2020-06-11 15:03:28', 1, 'kochi'),
(3, 3, 'Gurnoor', 'Gurnooorrrrrrrrrrrrrrrrr', 'Gurnooorrrrrrrrrrrrrrrrr', 'Gurnooorrrrrrrrrrrrrrrrr', 'Gurnooorrr,India', '0.jpeg', 1, '2020-06-11 15:03:28', 1, 'gurnoor'),
(4, 3, 'GN street', 'GN street 23', 'GN street 23', 'GN str', 'GN street,India', '0.jpeg', 1, '2020-06-11 15:03:28', 1, 'gnstreet'),
(5, 5, 'Banglore', 'Banglore', 'Banglore', 'Banglore', 'Banglore,India', '0.jpeg', 1, '2020-06-11 15:03:28', 1, 'banglore'),
(6, 6, 'Chennai', 'Chennai', 'Chennai', 'Chennai', 'Chennai,India', '0.jpeg', 1, '2020-06-11 15:03:28', 1, 'chennai'),
(7, 1, 'aluva', 'aluva puzha ', 'aluva', 'aluva', 'alway', 'a.jpeg', 0, '2020-07-09 16:55:59', 2, 'aluvass'),
(8, 1, 'dsghj', 'dghkjf', 'HKJG', 'VGDFGDF', 'VDCV', 'Screenshot from 2020-04-23 15-22-16.png', 1, '2020-07-14 22:04:13', 1, 'dsghj');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `company_name` text NOT NULL,
  `company_description` text NOT NULL,
  `profile_progress` float NOT NULL,
  `logo` text,
  `images` text,
  `website_url` text,
  `address` text NOT NULL,
  `email` text NOT NULL,
  `phone` varchar(20) NOT NULL,
  `rate_per_hour` float DEFAULT NULL,
  `team_size` float DEFAULT NULL,
  `meta_title` text NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL,
  `status` int(11) NOT NULL,
  `added_user` text,
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `company_list_status` int(11) NOT NULL DEFAULT '0',
  `slug` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `company_name`, `company_description`, `profile_progress`, `logo`, `images`, `website_url`, `address`, `email`, `phone`, `rate_per_hour`, `team_size`, `meta_title`, `meta_description`, `meta_keywords`, `status`, `added_user`, `added_date`, `company_list_status`, `slug`) VALUES
(1, 'Vofox Solutions Pvt Ltd', 'Vofox is one of the trusted offshore software development company in India with tremendous track record specially in offshore software development services. Our major offshore IT services are software development, web development, mobile app development, content management and e-commerce development etc.', 100, 'vofox.jpg', 'popoup-img.jpg|vofox-solution-pvt-ltd-kaloor-ernakulam-computer-software-developers.jpg|vofox-solution-pvt-ltd-kaloor-ernakulam-computer-software-developers-as2j6imcp9.jpg|vofox-solution-pvt-ltd-kaloor-ernakulam-computer-software-developers-xzozqw6glo.jpg|', 'vofox.com', 'Vofox Square VIP Road, JLN Stadium Metro Station, Kaloor, Ernakulam, Kerala', 'hakeempazhu@gmail.com', '09567888835', 3, 4, 'Vofox Solutions Pvt  Ltd', 'Vofox is one of the trusted offshore software development company in India with tremendous track record specially in offshore software development services. Our major offshore IT services are software', 'vofox,kochi,it,acomp,thiscompany', 1, '1', '2020-06-17 23:55:08', 1, 'vofox-solutions-pvt-ltd'),
(2, 'UST', 'ttttttttt', 33, 'mockup1.jpg', NULL, 'text.com', 'ttttttttt', 'hakeem.pa@vofoxsolut', '9999999', NULL, NULL, 'tttttttt', 'ttttttttttt', 'tttt,ttttt', 1, '1', '2020-06-18 01:17:31', 0, 'ust-glo'),
(3, 'TCS', 'aaaaaaaaaaaaa', 67, 'mockup6.jpg', NULL, 'text.com', 'aaaaaaaa', 'hakeem.pa@vofoxsolut', '9999999', 2, 4, 'aaaaaaaa', 'aaaaaaaa', 'aaa,aaaa', 1, '1', '2020-06-18 01:34:10', 0, 'tcs'),
(4, 'CTS', 'jhvjhv', 100, 'f.jpeg', '101325.jpg|691568-hd-dark-wallpapers-1920x1080-free-download.jpg|date.PNG|', 'hoihoihoihoih', 'hoihoih', 'oihoi', '55665656665656565565', 3, 2, 'sdfsdfsd', 'hvjhvjhv\r\n', 'sdffsdfsdf,dfgdfg', 1, '1', '2020-06-25 22:27:35', 0, 'cts'),
(5, 'Accenture', 'accenture', 67, 'socialbg.jpg', NULL, 'accenture.com', 'accenture', 'hakeempazhu@gmail.com', '09567888835', 3, 2, 'tttttttt', 'ttttttt', 'tttt,ttttt', 1, '1', '2020-07-02 19:59:53', 0, 'accenture'),
(6, 'Dell', 'dell', 100, 'tj.jpeg', '', 'dell.com', 'dell inc', 'aneeshraghavan.p@gmail.com', '86214578', 2, 4, 'dell', 'dell inc', 'dell', 1, '1', '2020-07-09 15:54:36', 0, 'dell'),
(7, 'Intellize software solutions', 'jhvjhvjhvhjv', 100, '268963_Viator_Shutterstock_166519.jpg', '268963_Viator_Shutterstock_166519.jpg|', 'www.intellize.com', 'kochi', 'nino.c.philip@vofoxsolutions.com', '9645530622', 3, 3, 'jhvjhvhjvhjvjhvhjv', 'hgchgckhgc', 'hjvkhjvkhjvkvkj', 1, '1', '2020-07-09 16:05:28', 0, 'intellize-software-solutions'),
(8, 'lenovo', 'hhh', 100, 'download.png', '', 'lenovo.com', 'lenovo inc ', 'aneeshraghavan.p@gmail.com', '9845124578', 4, 2, 'hjh', 'hjgh', 'hh', 1, '1', '2020-07-09 16:08:00', 0, 'lenovo'),
(9, 'infosolutions', 'ljhfjhfkhjfkhjfkjhf jhfjhfkjhf', 100, 'IMG_20170911_150807.jpg', 'IMG-20190914-WA0037.jpg|', 'www.infosolutions.com', 'kochi', 'nino.c.philip@vofoxsolutions.com', '9865321477', 3, 3, 'jkjgkjgkj', 'kjhkjkjhkl', 'hjgjhkjgkjgkjg', 1, '1', '2020-07-09 16:10:15', 0, 'infosolutions'),
(10, 'asuz', 'hgfghj', 100, 'taj.jpeg', '', 'asuz.com', 'asuz', 'aneesh.p@vofoxsolutions.com', '68476876', 4, 4, 'vcv', 'cnbgn', 'bhv', 1, '1', '2020-07-09 16:11:10', 0, 'asus'),
(11, 'apple', 'apple', 67, 'knowledge_graph_logo.png', NULL, 'apple.com', 'apples', 'aneeshraghavan.p@gmail.com', '8966526323', 7, 5, 'applkre', 'apple', 'iphone', 1, '1', '2020-07-09 16:21:28', 0, 'apple'),
(12, 'stallion systems ', 'dtt', 67, '95daa856a3d3d237ef17766ce2a84c84.png', NULL, 'stallion.com', 'stallion ', 'aneeshraghavan.p@gmail.com', '7687967897897', 5, 3, 'stallion', 'stallion', 'stallion', 1, '1', '2020-07-09 16:30:07', 0, 'stallion-systems '),
(13, 'sample', 'hhjfhj', 33, '!cid_ii_kap9l4jr1.png', NULL, 'sanj', 'jhhgjkg', 'jgkjgkj', '6', NULL, NULL, 'mvhvhjvhjv', 'hfjhfjhf', 'hjhfjhf', 1, '1', '2020-07-14 15:12:15', 0, 'sample');

-- --------------------------------------------------------

--
-- Table structure for table `company_customers_map`
--

CREATE TABLE `company_customers_map` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `customer_name` varchar(20) NOT NULL,
  `added_user` text NOT NULL,
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company_customers_map`
--

INSERT INTO `company_customers_map` (`id`, `company_id`, `customer_name`, `added_user`, `added_date`) VALUES
(1, 1, 'Hakeem P A', '1', '2020-06-23 22:24:52'),
(3, 1, 'Aneesh Raghavaan', '1', '2020-06-23 22:40:14'),
(4, 4, 'hakku thendi', '1', '2020-06-25 22:29:15'),
(5, 6, 'nino', '1', '2020-07-09 15:56:10');

-- --------------------------------------------------------

--
-- Table structure for table `company_location_map`
--

CREATE TABLE `company_location_map` (
  `id` int(20) NOT NULL,
  `company_id` int(20) NOT NULL,
  `state_id` int(20) NOT NULL,
  `city_id` int(20) NOT NULL,
  `location_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company_location_map`
--

INSERT INTO `company_location_map` (`id`, `company_id`, `state_id`, `city_id`, `location_id`) VALUES
(14, 3, 1, 2, 1),
(16, 4, 3, 4, 6),
(18, 5, 3, 3, 6),
(20, 6, 1, 1, 1),
(21, 7, 1, 1, 1),
(24, 9, 5, 5, 5),
(29, 10, 1, 1, 1),
(32, 11, 3, 3, 6),
(33, 12, 1, 2, 2),
(34, 8, 1, 1, 2),
(35, 8, 3, 4, 6),
(42, 1, 1, 2, 2),
(43, 1, 1, 2, 1),
(45, 2, 1, 1, 1),
(46, 13, 1, 1, 5),
(47, 11, 6, 6, 7);

-- --------------------------------------------------------

--
-- Table structure for table `company_portfolio_map`
--

CREATE TABLE `company_portfolio_map` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `portfolio_title` text NOT NULL,
  `image` text NOT NULL,
  `reference_link` text NOT NULL,
  `status` int(20) NOT NULL,
  `added_user` text NOT NULL,
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company_portfolio_map`
--

INSERT INTO `company_portfolio_map` (`id`, `company_id`, `portfolio_title`, `image`, `reference_link`, `status`, `added_user`, `added_date`) VALUES
(1, 1, 'Hire My Developer', 'hire.png', 'http://192.168.10.126/company-directory/admin', 1, '1', '2020-06-23 00:49:14'),
(4, 1, 'Feedback', 'imac.png', 'http://192.168.10.126/feedback', 1, '1', '2020-06-23 01:15:56'),
(5, 4, 'hjvjhvjhvjhv', 'Capture.PNG', 'kjgkjgkj', 1, '1', '2020-06-25 22:28:24'),
(6, 1, 'Test Portfolio', 'slide6.jpg', 'http://localhost/company-directory/', 1, '1', '2020-07-07 00:57:15'),
(7, 1, 'Test Portfolio2', 'slide1.jpg', 'http://localhost/company-directory/', 1, '1', '2020-07-07 00:57:38'),
(8, 6, 'ff', 'e.jpeg', 'kghfku', 1, '1', '2020-07-09 15:55:44'),
(9, 5, 'fvgbhfgh', 'd.jpeg', 'hfghfg', 1, '1', '2020-07-09 16:16:59'),
(10, 12, 'Feedback', 'minion.jpg', 'feedback.com', 1, '1', '2020-07-09 17:13:48');

-- --------------------------------------------------------

--
-- Table structure for table `company_reviews_map`
--

CREATE TABLE `company_reviews_map` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `review_text` text NOT NULL,
  `review_name` text NOT NULL,
  `review_stars` float NOT NULL,
  `status` int(20) NOT NULL,
  `added_user` text NOT NULL,
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company_reviews_map`
--

INSERT INTO `company_reviews_map` (`id`, `company_id`, `user_id`, `review_text`, `review_name`, `review_stars`, `status`, `added_user`, `added_date`) VALUES
(1, 1, NULL, '    Nice Company', 'Hakeem', 4, 0, '1', '2020-06-25 15:12:15'),
(2, 1, NULL, 'Good ', 'Aneesh', 3, 1, '1', '2020-06-25 18:10:58'),
(3, 4, NULL, ' oli', 'hakkup', 2, 1, '1', '2020-06-25 22:29:50'),
(4, 1, NULL, ' Good atmosphere and good service', 'anoop shaji', 4, 1, '1', '2020-07-07 01:01:14'),
(5, 1, NULL, ' Excellent Software company, Good working condition.', ' Gregory Wilson', 5, 1, '1', '2020-07-07 01:01:52'),
(6, 6, NULL, ' happy', 'nin', 2, 1, '1', '2020-07-09 15:56:32');

-- --------------------------------------------------------

--
-- Table structure for table `company_service_map`
--

CREATE TABLE `company_service_map` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company_service_map`
--

INSERT INTO `company_service_map` (`id`, `service_id`, `company_id`) VALUES
(9, 17, 3),
(10, 22, 3),
(71, 17, 4),
(72, 22, 4),
(73, 23, 4),
(77, 17, 5),
(78, 18, 5),
(79, 23, 5),
(81, 23, 6),
(82, 18, 7),
(85, 24, 9),
(92, 23, 10),
(93, 24, 10),
(97, 24, 11),
(98, 25, 11),
(99, 25, 12),
(100, 18, 8),
(101, 23, 8),
(114, 17, 9),
(115, 18, 1),
(116, 22, 1),
(117, 24, 1),
(121, 17, 2),
(122, 18, 2),
(123, 22, 2);

-- --------------------------------------------------------

--
-- Table structure for table `company_testimonials_map`
--

CREATE TABLE `company_testimonials_map` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `testimonial_name` varchar(20) NOT NULL,
  `testimonial_text` text NOT NULL,
  `added_user` text NOT NULL,
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company_testimonials_map`
--

INSERT INTO `company_testimonials_map` (`id`, `company_id`, `testimonial_name`, `testimonial_text`, `added_user`, `added_date`) VALUES
(1, 1, 'John', ' Very Good Experience Work with this Company !', '1', '2020-06-25 12:43:54'),
(2, 4, 'veendu hakku', ' thendi', '1', '2020-06-25 22:29:31'),
(3, 1, ' Sabu Titan Aviation', ' A well maintained IT campus... very close to JNL stadium...', '1', '2020-07-07 01:03:14'),
(4, 1, 'Anu Sebastian', '  I can say that Vofox Solutions is one of the best software development companies in India.', '1', '2020-07-07 01:04:17'),
(5, 1, 'sonia sebastian', ' Vofox Solutions did a great job of developing my mobile app. They have the knowledge to adapt to new technologies .', '1', '2020-07-07 01:05:39');

-- --------------------------------------------------------

--
-- Table structure for table `email_template`
--

CREATE TABLE `email_template` (
  `id` int(11) NOT NULL,
  `template` text NOT NULL,
  `added_date` datetime DEFAULT NULL,
  `added_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `email_template`
--

INSERT INTO `email_template` (`id`, `template`, `added_date`, `added_user`) VALUES
(1, '<p>Your Company Added to Hire My Developer !</p>\r\n<p>Please click the following link to update athe details !</p>', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `hourly_rates`
--

CREATE TABLE `hourly_rates` (
  `id` int(20) NOT NULL,
  `text` text NOT NULL,
  `status` int(20) NOT NULL,
  `added_user` text NOT NULL,
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hourly_rates`
--

INSERT INTO `hourly_rates` (`id`, `text`, `status`, `added_user`, `added_date`) VALUES
(1, 'NA', 1, '1', '2020-06-18 22:44:43'),
(2, '< $25', 1, '1', '2020-06-18 22:45:46'),
(3, '$25 - $49', 1, '1', '2020-06-18 22:59:54'),
(4, '$50 - $99', 1, '1', '2020-06-18 23:00:14'),
(5, '$100 - $149', 1, '1', '2020-06-18 23:00:15'),
(6, '$150 - $199', 1, '1', '2020-06-18 23:01:55'),
(7, '$200 - $300', 1, '1', '2020-06-18 23:03:24'),
(8, '$300 +', 1, '1', '2020-06-18 23:03:55');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `location_name` text NOT NULL,
  `location_description` text NOT NULL,
  `meta_title` text NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL,
  `image` text,
  `status` int(11) NOT NULL,
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_user` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `state_id`, `city_id`, `location_name`, `location_description`, `meta_title`, `meta_description`, `meta_keywords`, `image`, `status`, `added_date`, `added_user`) VALUES
(1, 1, 2, 'Kaloor', 'Centre of Ernakulam ', 'Kaloor', 'Centre of Ernakulam ', 'kaloor,kochi,kerala', 'kaloor-metro-station.jpg', 1, '2020-06-09 19:58:21', 1),
(2, 1, 2, 'Palarivattom', 'City of traffics', 'Palarivattom', 'City of traffics', 'kochi,kerala,kaloor', 'img5.jpg', 1, '2020-06-11 02:19:32', 1),
(5, 1, 1, 'Vaidyasala', 'place  in valanchery', 'Vaidyasala', 'Vaidyasala', 'Vaidyasala', 'list-img.jpg', 1, '2020-07-02 18:58:16', 1),
(6, 3, 3, 'Gn strreet', 'place  in delhi', 'Gurnoor', 'Gurnoor', 'Gurnoor', 'list-img.jpg', 1, '2020-07-02 18:58:16', 1),
(7, 6, 6, 'Ch_street', 'Ch_street', 'Ch_street', 'Ch_street chennai', 'Ch_street ', 'list-img.jpg', 1, '2020-07-02 18:58:16', 1);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `service_name` text NOT NULL,
  `service_description` text NOT NULL,
  `meta_title` text NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL,
  `image` text,
  `status` int(11) NOT NULL DEFAULT '1',
  `added_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `added_user` int(11) NOT NULL,
  `service_slug` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `service_name`, `service_description`, `meta_title`, `meta_description`, `meta_keywords`, `image`, `status`, `added_date`, `added_user`, `service_slug`) VALUES
(17, 'anroid applications', 'Mobile Applications', 'android appssss', 'mobile apps', 'android,mobile', 'ham.jpeg', 1, NULL, 1, 'android-applications'),
(18, 'software development', 'web and mobile softwares', 'softwares', 'softwares for web and mobiles', 'software,mobile,apps', 'c.jpeg', 1, NULL, 1, 'software-developemnt'),
(22, 'magento development', 'magento description', 'magentopro', 'magento 2', 'ecommerce', 'b.jpeg', 1, NULL, 1, 'magento-development'),
(23, 'Open Cart Development', 'Open Cart Development', 'Open Cart Development', 'Open Cart Development', 'Open Cart Development', 'f.jpeg', 1, '2020-06-25 12:13:14', 1, 'open-cart'),
(24, 'online services', 'service', 'IHOIHOIH', 'HOIHOIH', 'IOHOIH', 'tj.jpeg', 1, '2020-06-25 22:36:09', 2, 'online-services'),
(25, 'lap top repair service', 'laptop services', 'laptops', 'laptop service', 'lap', 'e.jpeg', 1, '2020-07-09 16:58:33', 3, 'laptop-repair'),
(26, 'testing services', 'testing services', 'test', 'test', 'test', 'Screenshot from 2020-06-09 16-14-48.png', 1, '2020-07-14 19:55:16', 1, 'testing-services'),
(27, 'hjh', 'jhj', 'jhj', 'jh', 'jhjh', 'Screenshot from 2020-04-23 15-22-16.png', 1, '2020-07-14 20:44:20', 1, 'hslug');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `state_name` text NOT NULL,
  `meta_title` text NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `image` text,
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_user` int(11) NOT NULL,
  `state_slug` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `state_name`, `meta_title`, `meta_description`, `meta_keywords`, `status`, `image`, `added_date`, `added_user`, `state_slug`) VALUES
(1, 'Kerala', 'Keralas', 'God\'s Own Country', 'kerala,coconut', 1, '!cid_image001_jpg@01D51AEA.jpg', '2020-06-16 17:25:45', 1, 'kerala'),
(3, 'Delhi', 'title-delhi', 'description-delhi', 'jkkjg', 1, '9-es6-let-and-const-typescript-javascript-11-638.jpg', '2020-06-16 17:25:45', 1, 'delhi'),
(5, 'Karnataka', 'Karnataka', 'description Karnataka', 'jkkjg', 1, '9-es6-let-and-const-typescript-javascript-11-638.jpg', '2020-06-16 17:25:45', 2, 'karnataka'),
(6, 'Tamil Nadu', 'Tamil Nadu', 'description Tamil Nadu', 'jkkjg', 1, '9-es6-let-and-const-typescript-javascript-11-638.jpg', '2020-06-16 17:25:45', 2, 'tamil');

-- --------------------------------------------------------

--
-- Table structure for table `team_sizes`
--

CREATE TABLE `team_sizes` (
  `id` int(20) NOT NULL,
  `text` text NOT NULL,
  `status` int(20) NOT NULL,
  `added_user` text NOT NULL,
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `team_sizes`
--

INSERT INTO `team_sizes` (`id`, `text`, `status`, `added_user`, `added_date`) VALUES
(1, '2 - 9', 1, '1', '2020-06-18 22:58:41'),
(2, '10 - 49', 1, '1', '2020-06-18 22:59:12'),
(3, '50 - 249', 1, '1', '2020-06-18 23:04:31'),
(4, '250 - 999', 1, '1', '2020-06-18 23:04:54'),
(5, '1,000 - 9,999', 1, '1', '2020-06-18 23:06:12'),
(6, '10,000 +', 1, '1', '2020-06-18 23:06:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` text NOT NULL,
  `user_role` varchar(20) NOT NULL,
  `user_status` int(11) NOT NULL COMMENT '0=>disabled,1=>enabled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `user_role`, `user_status`) VALUES
(1, 'admin', NULL, 'MTIzNDU=', 'admin', 1),
(2, 'd_entry', 'd@gmail.com', 'MTIzNDU=', 'd_entry', 1),
(3, 'aneesh', 'aneeshraghavan.p@gmail.com', 'MTIzNDU=', 'd_entry', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_customers_map`
--
ALTER TABLE `company_customers_map`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_location_map`
--
ALTER TABLE `company_location_map`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_portfolio_map`
--
ALTER TABLE `company_portfolio_map`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_reviews_map`
--
ALTER TABLE `company_reviews_map`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_service_map`
--
ALTER TABLE `company_service_map`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_testimonials_map`
--
ALTER TABLE `company_testimonials_map`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_template`
--
ALTER TABLE `email_template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hourly_rates`
--
ALTER TABLE `hourly_rates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_sizes`
--
ALTER TABLE `team_sizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `company_customers_map`
--
ALTER TABLE `company_customers_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `company_location_map`
--
ALTER TABLE `company_location_map`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `company_portfolio_map`
--
ALTER TABLE `company_portfolio_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `company_reviews_map`
--
ALTER TABLE `company_reviews_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `company_service_map`
--
ALTER TABLE `company_service_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `company_testimonials_map`
--
ALTER TABLE `company_testimonials_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `email_template`
--
ALTER TABLE `email_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `hourly_rates`
--
ALTER TABLE `hourly_rates`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `team_sizes`
--
ALTER TABLE `team_sizes`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

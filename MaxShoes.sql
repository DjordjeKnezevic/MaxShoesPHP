-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: maxshoes.cbqf4ibv1izd.eu-central-1.rds.amazonaws.com
-- Generation Time: May 28, 2023 at 05:57 PM
-- Server version: 8.0.32
-- PHP Version: 8.1.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `MaxShoes`
--

-- --------------------------------------------------------

--
-- Table structure for table `anketa`
--

CREATE TABLE `anketa` (
  `user_id` int NOT NULL,
  `brend_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `anketa`
--

INSERT INTO `anketa` (`user_id`, `brend_id`) VALUES
(18, 1),
(25, 4),
(1, 5),
(24, 5);

-- --------------------------------------------------------

--
-- Table structure for table `brend`
--

CREATE TABLE `brend` (
  `id` int NOT NULL,
  `naziv` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brend`
--

INSERT INTO `brend` (`id`, `naziv`) VALUES
(1, 'Adidas'),
(2, 'Asics'),
(3, 'Inov8'),
(4, 'New Balance'),
(5, 'Nike'),
(6, 'Puma'),
(7, 'Reebok');

-- --------------------------------------------------------

--
-- Table structure for table `cena`
--

CREATE TABLE `cena` (
  `id` int NOT NULL,
  `patika_id` int NOT NULL,
  `vrednost` decimal(6,2) NOT NULL,
  `datum_pocetka` datetime DEFAULT CURRENT_TIMESTAMP,
  `datum_kraja` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cena`
--

INSERT INTO `cena` (`id`, `patika_id`, `vrednost`, `datum_pocetka`, `datum_kraja`) VALUES
(101, 51, 250.00, '2023-03-13 21:32:01', NULL),
(102, 52, 120.00, '2023-03-13 21:32:01', NULL),
(103, 53, 180.00, '2023-03-13 21:32:01', NULL),
(104, 54, 130.00, '2023-03-13 21:32:01', '2023-03-24 13:41:32'),
(105, 55, 40.00, '2023-03-13 21:32:01', NULL),
(106, 56, 80.00, '2023-03-13 21:32:01', NULL),
(107, 57, 70.00, '2023-03-13 21:32:01', NULL),
(108, 58, 180.00, '2023-03-13 21:32:01', NULL),
(109, 59, 180.00, '2023-03-13 21:32:01', NULL),
(110, 60, 160.00, '2023-03-13 21:32:01', NULL),
(111, 61, 140.00, '2023-03-13 21:32:01', NULL),
(112, 62, 160.00, '2023-03-13 21:32:01', NULL),
(113, 63, 160.00, '2023-03-13 21:32:01', NULL),
(114, 64, 97.00, '2023-03-13 21:32:01', NULL),
(115, 65, 65.00, '2023-03-13 21:32:01', NULL),
(116, 66, 160.00, '2023-03-13 21:32:01', NULL),
(117, 67, 160.00, '2023-03-13 21:32:01', NULL),
(118, 68, 140.00, '2023-03-13 21:32:01', NULL),
(119, 69, 130.00, '2023-03-13 21:32:01', NULL),
(120, 70, 70.00, '2023-03-13 21:32:01', NULL),
(121, 71, 101.00, '2023-03-13 21:32:01', NULL),
(122, 72, 80.00, '2023-03-13 21:32:01', NULL),
(123, 73, 55.00, '2023-03-13 21:32:01', NULL),
(124, 74, 110.00, '2023-03-13 21:32:01', NULL),
(125, 75, 120.00, '2023-03-13 21:32:01', NULL),
(126, 76, 90.00, '2023-03-13 21:32:01', NULL),
(127, 77, 135.00, '2023-03-13 21:32:01', NULL),
(128, 78, 140.00, '2023-03-13 21:32:01', NULL),
(129, 79, 100.00, '2023-03-13 21:32:01', NULL),
(130, 80, 50.00, '2023-03-13 21:32:01', NULL),
(131, 81, 65.00, '2023-03-13 21:32:01', NULL),
(132, 82, 140.00, '2023-03-13 21:32:01', NULL),
(133, 83, 220.00, '2023-03-13 21:32:01', NULL),
(134, 84, 90.00, '2023-03-13 21:32:01', NULL),
(135, 85, 220.00, '2023-03-13 21:32:01', NULL),
(136, 86, 100.00, '2023-03-13 21:32:01', NULL),
(137, 87, 160.00, '2023-03-13 21:32:01', NULL),
(138, 88, 35.00, '2023-03-13 21:32:01', NULL),
(139, 89, 55.00, '2023-03-13 21:32:01', NULL),
(140, 90, 135.00, '2023-03-13 21:32:01', NULL),
(141, 91, 165.00, '2023-03-13 21:32:01', NULL),
(142, 92, 70.00, '2023-03-13 21:32:01', NULL),
(143, 93, 100.00, '2023-03-13 21:32:01', NULL),
(144, 94, 105.00, '2023-03-13 21:32:01', NULL),
(145, 95, 160.00, '2023-03-13 21:32:01', NULL),
(146, 96, 150.00, '2023-03-13 21:32:01', NULL),
(148, 98, 100.00, '2023-03-13 21:32:01', NULL),
(149, 99, 70.00, '2023-03-13 21:32:01', NULL),
(150, 100, 165.00, '2023-03-13 21:32:01', NULL),
(170, 54, 150.00, '2023-03-20 18:58:06', '2023-03-24 13:41:32'),
(171, 54, 160.00, '2023-03-20 18:58:59', '2023-03-24 13:41:32'),
(173, 54, 170.00, '2023-03-20 19:24:55', '2023-03-24 13:41:32'),
(176, 54, 150.00, '2023-03-20 23:56:17', '2023-03-24 13:41:32'),
(177, 54, 200.00, '2023-03-24 13:41:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cena_postarine`
--

CREATE TABLE `cena_postarine` (
  `id` int NOT NULL,
  `patika_id` int NOT NULL,
  `vrednost` int NOT NULL,
  `datum_pocetka` datetime DEFAULT CURRENT_TIMESTAMP,
  `datum_kraja` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cena_postarine`
--

INSERT INTO `cena_postarine` (`id`, `patika_id`, `vrednost`, `datum_pocetka`, `datum_kraja`) VALUES
(1, 51, 45, '2023-03-14 11:44:37', NULL),
(2, 53, 41, '2023-03-14 11:44:37', NULL),
(3, 54, 14, '2023-03-14 11:44:37', '2023-03-20 23:56:17'),
(4, 55, 31, '2023-03-14 11:44:37', NULL),
(5, 57, 22, '2023-03-14 11:44:37', NULL),
(6, 58, 30, '2023-03-14 11:44:37', NULL),
(7, 59, 47, '2023-03-14 11:44:37', NULL),
(8, 60, 6, '2023-03-14 11:44:37', NULL),
(9, 62, 20, '2023-03-14 11:44:37', NULL),
(10, 63, 36, '2023-03-14 11:44:37', NULL),
(11, 65, 25, '2023-03-14 11:44:37', NULL),
(12, 66, 12, '2023-03-14 11:44:37', NULL),
(13, 67, 39, '2023-03-14 11:44:37', NULL),
(14, 68, 36, '2023-03-14 11:44:37', NULL),
(15, 70, 50, '2023-03-14 11:44:37', NULL),
(16, 71, 43, '2023-03-14 11:44:37', NULL),
(17, 72, 28, '2023-03-14 11:44:37', NULL),
(18, 73, 25, '2023-03-14 11:44:37', NULL),
(19, 74, 32, '2023-03-14 11:44:37', NULL),
(20, 76, 26, '2023-03-14 11:44:37', NULL),
(21, 77, 25, '2023-03-14 11:44:37', NULL),
(22, 78, 11, '2023-03-14 11:44:37', NULL),
(23, 80, 13, '2023-03-14 11:44:37', NULL),
(24, 81, 24, '2023-03-14 11:44:37', NULL),
(25, 82, 7, '2023-03-14 11:44:37', NULL),
(26, 83, 34, '2023-03-14 11:44:37', NULL),
(27, 84, 26, '2023-03-14 11:44:37', NULL),
(28, 86, 21, '2023-03-14 11:44:37', NULL),
(29, 87, 38, '2023-03-14 11:44:37', NULL),
(30, 89, 20, '2023-03-14 11:44:37', NULL),
(31, 90, 42, '2023-03-14 11:44:37', NULL),
(32, 91, 20, '2023-03-14 11:44:37', NULL),
(33, 92, 16, '2023-03-14 11:44:37', NULL),
(34, 95, 8, '2023-03-14 11:44:37', NULL),
(36, 98, 9, '2023-03-14 11:44:37', NULL),
(37, 100, 12, '2023-03-14 11:44:37', NULL),
(41, 54, 24, '2023-03-20 19:13:46', '2023-03-20 23:56:17'),
(42, 54, 0, '2023-03-20 19:14:53', '2023-03-20 23:56:17'),
(43, 54, 45, '2023-03-20 19:24:55', '2023-03-20 23:56:17'),
(44, 54, 0, '2023-03-20 19:35:29', '2023-03-20 23:56:17'),
(45, 54, 0, '2023-03-20 19:36:44', '2023-03-20 23:56:17'),
(46, 54, 5, '2023-03-20 23:56:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ikonica`
--

CREATE TABLE `ikonica` (
  `id` int NOT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `klasa` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ikonica`
--

INSERT INTO `ikonica` (`id`, `link`, `klasa`, `label`) VALUES
(1, 'https://www.instagram.com/', 'bi bi-instagram', NULL),
(2, 'https://www.facebook.com/', 'bi bi-facebook', NULL),
(3, 'rss.xml', 'bi bi-rss', NULL),
(4, NULL, 'bi bi-telephone', '011/1234-567'),
(5, NULL, 'bi bi-envelope', 'Zdravka Celara 16'),
(6, NULL, 'bi bi-geo-alt', 'Belgrade, Serbia'),
(7, 'https://djordjeknezevic.github.io/', NULL, 'Author'),
(8, 'Dokumentacija.pdf', NULL, 'Documentation'),
(9, 'sitemap.xml', 'bi bi-diagram-3', 'Author');

-- --------------------------------------------------------

--
-- Table structure for table `kategorija`
--

CREATE TABLE `kategorija` (
  `id` int NOT NULL,
  `naziv` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategorija`
--

INSERT INTO `kategorija` (`id`, `naziv`) VALUES
(1, 'Men'),
(2, 'Women'),
(3, 'Kids');

-- --------------------------------------------------------

--
-- Table structure for table `korpa`
--

CREATE TABLE `korpa` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `ukupna_cena` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `korpa`
--

INSERT INTO `korpa` (`id`, `user_id`, `ukupna_cena`) VALUES
(1, 1, 0.00),
(2, 18, 0.00),
(3, 19, 0.00),
(6, 23, 0.00),
(7, 24, 0.00),
(8, 25, 0.00),
(10, 32, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `korpa_patika`
--

CREATE TABLE `korpa_patika` (
  `korpa_id` int NOT NULL,
  `patika_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `navigacija`
--

CREATE TABLE `navigacija` (
  `id` int NOT NULL,
  `naziv` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) NOT NULL,
  `slika_id` int DEFAULT NULL,
  `klasa` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `navigacija`
--

INSERT INTO `navigacija` (`id`, `naziv`, `link`, `slika_id`, `klasa`) VALUES
(1, 'MEN', 'products.php?category=Men', 1, 'dark-blue-bg text-white'),
(2, 'WOMEN', 'products.php?category=Women', 2, 'pink-bg text-dark'),
(3, 'KIDS', 'products.php?category=Kids', 3, 'lgreen-bg text-dark'),
(4, 'CONTACT', '#footer', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `path`
--

CREATE TABLE `path` (
  `id` int NOT NULL,
  `vrednost` varchar(10000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ikonica_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `path`
--

INSERT INTO `path` (`id`, `vrednost`, `ikonica_id`) VALUES
(1, 'M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z', 1),
(2, 'M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z', 2),
(3, 'M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z', 3),
(4, 'M5.5 12a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm-3-8.5a1 1 0 0 1 1-1c5.523 0 10 4.477 10 10a1 1 0 1 1-2 0 8 8 0 0 0-8-8 1 1 0 0 1-1-1zm0 4a1 1 0 0 1 1-1 6 6 0 0 1 6 6 1 1 0 1 1-2 0 4 4 0 0 0-4-4 1 1 0 0 1-1-1z', 3),
(5, 'M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z', 4),
(6, 'M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z', 5),
(7, 'M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z', 6),
(8, 'M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z', 6),
(9, 'M6 3.5A1.5 1.5 0 0 1 7.5 2h1A1.5 1.5 0 0 1 10 3.5v1A1.5 1.5 0 0 1 8.5 6v1H14a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0v-1A.5.5 0 0 1 2 7h5.5V6A1.5 1.5 0 0 1 6 4.5v-1zM8.5 5a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1zM0 11.5A1.5 1.5 0 0 1 1.5 10h1A1.5 1.5 0 0 1 4 11.5v1A1.5 1.5 0 0 1 2.5 14h-1A1.5 1.5 0 0 1 0 12.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm4.5.5A1.5 1.5 0 0 1 7.5 10h1a1.5 1.5 0 0 1 1.5 1.5v1A1.5 1.5 0 0 1 8.5 14h-1A1.5 1.5 0 0 1 6 12.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm4.5.5a1.5 1.5 0 0 1 1.5-1.5h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z', 9);

-- --------------------------------------------------------

--
-- Table structure for table `patika`
--

CREATE TABLE `patika` (
  `id` int NOT NULL,
  `brend_id` int NOT NULL,
  `model` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategorija_id` int NOT NULL,
  `slika_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patika`
--

INSERT INTO `patika` (`id`, `brend_id`, `model`, `kategorija_id`, `slika_id`) VALUES
(51, 2, 'Metaspeed Sky', 1, 9),
(52, 2, 'Lite Show', 1, 10),
(53, 5, 'Pegasus Turbo Next Nature', 1, 11),
(54, 2, 'Adidistar', 2, 82),
(55, 2, 'Jolt 3 GS Junior', 3, 13),
(56, 4, 'Fresh Foam X 860 v13', 2, 14),
(57, 4, 'Fresh Foam Tempo', 2, 15),
(58, 2, 'Gel-Kinsei Blast', 1, 16),
(59, 2, 'Kinsei Blast', 1, 17),
(60, 1, 'SolarBOOST 19', 2, 18),
(61, 1, 'Solar Glide 3', 2, 19),
(62, 1, 'Terrex Speed Ultra', 2, 20),
(63, 1, 'SolarBOOST 3', 1, 21),
(64, 5, 'Air Zoom Pegasus 38 Shield', 3, 22),
(65, 5, 'Rival D 10', 3, 23),
(66, 5, 'ZoomX Streakfly', 2, 24),
(67, 5, 'React Infinity Run Flyknit 3', 2, 25),
(68, 4, 'Fresh Foam Hierro v7', 2, 26),
(69, 4, 'FuelCell Rebel v3', 2, 27),
(70, 4, 'XCR7 v4', 1, 28),
(71, 4, 'Fresh Foam 880 v11', 1, 29),
(72, 3, 'X-Talon 212', 3, 30),
(73, 2, 'Gel-Noosa Tri 13 GS', 3, 31),
(74, 6, 'Liberate Nitro', 1, 32),
(75, 6, 'Velocity Nitro', 1, 33),
(76, 7, 'Nanoflex TR', 1, 34),
(77, 7, 'Nano X2', 1, 35),
(78, 7, 'Floatride Run Fast 3.0', 2, 36),
(79, 7, 'Forever Floatride Energy 2.0', 2, 37),
(80, 1, 'Terrex Agravic Flow Junior', 3, 38),
(81, 1, 'Adizero XCS Track Spike', 1, 39),
(82, 1, 'Solar Glide 4 ST', 3, 40),
(83, 1, 'Adizero Adios Pro 2', 1, 41),
(84, 2, 'Gel-Cumulus 23', 1, 42),
(85, 2, 'Superblast', 1, 43),
(86, 2, 'GT-2000 v9', 3, 44),
(87, 6, 'Deviate Nitro', 1, 45),
(88, 1, 'Youngstar Junior Hockey Shoes', 1, 46),
(89, 1, 'Allroundstar Junior Running Spikes', 1, 47),
(90, 1, 'Ultraboost 21', 1, 48),
(91, 4, 'Fresh Foam More Trail v2', 1, 49),
(92, 4, 'MD500v8', 1, 50),
(93, 7, 'Floatride Energy 3.0', 1, 51),
(94, 5, 'Terra Kiger 7', 1, 52),
(95, 5, 'Pegasus Trail 4 GTX', 1, 53),
(96, 5, 'Air Zoom Elite LJ Elite 2', 1, 54),
(98, 7, 'Floatride Energy 3.0', 1, 56),
(99, 4, 'XC Seven v4', 3, 57),
(100, 4, 'Fresh Foam More Trail v2', 1, 58);

-- --------------------------------------------------------

--
-- Table structure for table `popust`
--

CREATE TABLE `popust` (
  `id` int NOT NULL,
  `patika_id` int NOT NULL,
  `procenat` decimal(3,2) NOT NULL,
  `datum_pocetka` datetime DEFAULT CURRENT_TIMESTAMP,
  `datum_kraja` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `popust`
--

INSERT INTO `popust` (`id`, `patika_id`, `procenat`, `datum_pocetka`, `datum_kraja`) VALUES
(1, 53, 0.80, '2023-03-13 22:51:22', NULL),
(2, 69, 0.85, '2023-03-13 22:51:22', NULL),
(3, 82, 0.80, '2023-03-13 22:51:22', NULL),
(4, 85, 0.60, '2023-03-13 22:51:22', NULL),
(5, 91, 0.60, '2023-03-13 22:51:22', NULL),
(6, 95, 0.75, '2023-03-13 22:51:22', '2023-03-20 19:09:09'),
(7, 96, 0.75, '2023-03-13 22:51:22', NULL),
(15, 54, 0.90, '2023-03-20 19:07:34', '2023-03-24 13:41:03'),
(16, 95, 0.80, '2023-03-20 19:09:09', NULL),
(17, 54, 0.90, '2023-03-20 19:24:55', '2023-03-24 13:41:03'),
(20, 54, 0.90, '2023-03-20 23:56:17', '2023-03-24 13:41:03');

-- --------------------------------------------------------

--
-- Table structure for table `porudzbina`
--

CREATE TABLE `porudzbina` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `ukupna_cena` decimal(8,2) NOT NULL,
  `datum_porudzbine` datetime DEFAULT CURRENT_TIMESTAMP,
  `procenjen_datum_dostave` date NOT NULL,
  `dostavljeno` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `porudzbina`
--

INSERT INTO `porudzbina` (`id`, `user_id`, `ukupna_cena`, `datum_porudzbine`, `procenjen_datum_dostave`, `dostavljeno`) VALUES
(2, 18, 310.00, '2023-03-17 18:57:13', '2023-05-17', 0),
(3, 18, 382.00, '2023-03-17 18:58:34', '2023-05-17', 0),
(4, 18, 600.00, '2023-03-17 19:00:53', '2023-05-17', 0),
(5, 18, 151.00, '2023-03-17 19:19:22', '2023-05-17', 0),
(6, 18, 144.00, '2023-03-17 19:27:15', '2023-05-17', 0),
(7, 18, 295.00, '2023-03-17 19:28:51', '2023-05-17', 0),
(17, 1, 387.00, '2023-03-18 00:24:12', '2023-05-18', 0),
(18, 1, 600.00, '2023-03-18 11:32:58', '2023-05-18', 0),
(19, 1, 151.00, '2023-03-18 11:56:05', '2023-05-18', 0),
(20, 1, 590.00, '2023-03-18 12:01:52', '2023-05-18', 0),
(21, 18, 320.00, '2023-03-18 19:55:56', '2023-05-18', 0),
(22, 1, 112.50, '2023-03-19 00:43:07', '2023-05-19', 0),
(23, 18, 211.00, '2023-03-20 20:20:28', '2023-05-20', 0),
(24, 23, 229.00, '2023-03-21 16:04:24', '2023-05-21', 0),
(25, 18, 312.00, '2023-03-22 14:22:46', '2023-05-22', 0),
(26, 24, 295.00, '2023-03-22 14:30:05', '2023-05-22', 0);

-- --------------------------------------------------------

--
-- Table structure for table `porudzbina_patika`
--

CREATE TABLE `porudzbina_patika` (
  `porudzbina_id` int NOT NULL,
  `patika_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `porudzbina_patika`
--

INSERT INTO `porudzbina_patika` (`porudzbina_id`, `patika_id`) VALUES
(4, 51),
(7, 51),
(18, 51),
(26, 51),
(3, 52),
(4, 52),
(18, 52),
(4, 53),
(18, 53),
(2, 54),
(6, 54),
(20, 54),
(5, 55),
(19, 55),
(5, 56),
(19, 56),
(23, 57),
(2, 60),
(17, 61),
(21, 61),
(21, 62),
(25, 62),
(20, 71),
(24, 72),
(3, 74),
(20, 74),
(3, 75),
(20, 77),
(23, 82),
(25, 85),
(24, 86),
(22, 96),
(17, 99),
(17, 100);

-- --------------------------------------------------------

--
-- Table structure for table `slika`
--

CREATE TABLE `slika` (
  `id` int NOT NULL,
  `src` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `slika`
--

INSERT INTO `slika` (`id`, `src`, `alt`) VALUES
(1, 'Assets/img/MensShoes.jpg', 'MensShoes'),
(2, 'Assets/img/WomensShoes.jpg', 'WomenShoes'),
(3, 'Assets/img/KidsShoes.jpg', 'KidsShoes'),
(4, 'Assets/img/bg-1.jpg', 'bg-1'),
(5, 'Assets/img/bg-2.jpg', 'bg-2'),
(6, 'Assets/img/bg-3.jpg', 'bg-3'),
(7, 'Assets/img/bg-4.jpg', 'bg-4'),
(8, 'Assets/img/bg-5.jpg', 'bg-5'),
(9, 'Assets/img/shoes/Shoe1.jpg', 'Asics Metaspeed Sky'),
(10, 'Assets/img/shoes/Shoe2.jpg', 'Asics Lite Show'),
(11, 'Assets/img/shoes/Shoe3.jpg', 'Nike Pegasus Turbo Next Nature'),
(12, 'Assets/img/shoes/Shoe4.jpg', 'Adidas Adistar'),
(13, 'Assets/img/shoes/Shoe5.jpg', 'Asics Jolt 3 GS Junior'),
(14, 'Assets/img/shoes/Shoe6.jpg', 'New Balance Fresh Foam X 860 v13'),
(15, 'Assets/img/shoes/Shoe7.jpg', 'New Balance Fresh Foam Tempo'),
(16, 'Assets/img/shoes/Shoe8.jpg', 'Asics Gel-Kinsei Blast'),
(17, 'Assets/img/shoes/Shoe9.jpg', 'Asics Kinsei Blast'),
(18, 'Assets/img/shoes/Shoe10.jpg', 'Adidas SolarBOOST 19'),
(19, 'Assets/img/shoes/Shoe11.jpg', 'Adidas Solar Glide 3'),
(20, 'Assets/img/shoes/Shoe12.jpg', 'Adidas Terrex Speed Ultra'),
(21, 'Assets/img/shoes/Shoe13.jpg', 'Adidas SolarBOOST 3'),
(22, 'Assets/img/shoes/Shoe14.jpg', 'Nike Air Zoom Pegasus 38 Shield'),
(23, 'Assets/img/shoes/Shoe15.jpg', 'Nike Rival D 10'),
(24, 'Assets/img/shoes/Shoe16.jpg', 'Nike ZoomX Streakfly'),
(25, 'Assets/img/shoes/Shoe17.jpg', 'Nike React Infinity Run Flyknit 3'),
(26, 'Assets/img/shoes/Shoe18.jpg', 'New Balance Fresh Foam Hierro v7'),
(27, 'Assets/img/shoes/Shoe19.jpg', 'New Balance FuelCell Rebel v3'),
(28, 'Assets/img/shoes/Shoe20.jpg', 'New Balance XCR7 v4'),
(29, 'Assets/img/shoes/Shoe21.jpg', 'New Balance Fresh Foam 880 v11'),
(30, 'Assets/img/shoes/Shoe22.jpg', 'Inov8 X-Talon 212'),
(31, 'Assets/img/shoes/Shoe23.jpg', 'Asics Gel-Noosa Tri 13 GS'),
(32, 'Assets/img/shoes/Shoe24.jpg', 'Puma Liberate Nitro'),
(33, 'Assets/img/shoes/Shoe25.jpg', 'Puma Velocity Nitro'),
(34, 'Assets/img/shoes/Shoe26.jpg', 'Reebok Nanoflex TR'),
(35, 'Assets/img/shoes/Shoe27.jpg', 'Reebok Nano X2'),
(36, 'Assets/img/shoes/Shoe28.jpg', 'Reebok Floatride Run Fast 3.0'),
(37, 'Assets/img/shoes/Shoe29.jpg', 'Reebok Forever Floatride Energy 2.0'),
(38, 'Assets/img/shoes/Shoe30.jpg', 'Adidas Terrex Agravic Flow Junior'),
(39, 'Assets/img/shoes/Shoe31.jpg', 'Adidas Adizero XCS Track Spike'),
(40, 'Assets/img/shoes/Shoe32.jpg', 'Adidas Solar Glide 4 ST'),
(41, 'Assets/img/shoes/Shoe33.jpg', 'Adidas Adizero Adios Pro 2'),
(42, 'Assets/img/shoes/Shoe34.jpg', 'Asics Gel-Cumulus 23'),
(43, 'Assets/img/shoes/Shoe35.jpg', 'Asics Superblast'),
(44, 'Assets/img/shoes/Shoe36.jpg', 'Asics GT-2000 v9'),
(45, 'Assets/img/shoes/Shoe37.jpg', 'Puma Deviate Nitro'),
(46, 'Assets/img/shoes/Shoe38.jpg', 'Adidas Youngstar Junior Hockey Shoes'),
(47, 'Assets/img/shoes/Shoe39.jpg', 'Adidas Allroundstar Junior Running Spikes'),
(48, 'Assets/img/shoes/Shoe40.jpg', 'Adidas Ultraboost 21'),
(49, 'Assets/img/shoes/Shoe41.jpg', 'New Balance Fresh Foam More Trail v2'),
(50, 'Assets/img/shoes/Shoe42.jpg', 'New Balance MD500v8'),
(51, 'Assets/img/shoes/Shoe43.jpg', 'Reebok Floatride Energy 3.0'),
(52, 'Assets/img/shoes/Shoe44.jpg', 'Nike Terra Kiger 7'),
(53, 'Assets/img/shoes/Shoe45.jpg', 'Nike Pegasus Trail 4 GTX'),
(54, 'Assets/img/shoes/Shoe46.jpg', 'Nike Air Zoom Elite LJ Elite 2'),
(55, 'Assets/img/shoes/Shoe47.jpg', 'Reebok Nano X'),
(56, 'Assets/img/shoes/Shoe48.jpg', 'Reebok Floatride Energy 3.0'),
(57, 'Assets/img/shoes/Shoe49.jpg', 'New Balance XC Seven v4'),
(58, 'Assets/img/shoes/Shoe50.jpg', 'New Balance Fresh Foam More Trail v2'),
(82, 'Assets/img/shoes/Shoe51.jpg', 'Shoe51.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `sortiranje`
--

CREATE TABLE `sortiranje` (
  `id` int NOT NULL,
  `naziv` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sortiranje`
--

INSERT INTO `sortiranje` (`id`, `naziv`) VALUES
(1, 'Price Ascending'),
(2, 'Price Descending'),
(3, 'Name Ascending'),
(4, 'Name Descending');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'user',
  `verified` tinyint(1) DEFAULT '0',
  `random_number` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `first_name`, `last_name`, `email`, `address`, `type`, `verified`, `random_number`) VALUES
(1, 'Dzndzo', 'b45b2368fc6691376d038b13175cadeb46fad7d3', 'Djordje', 'Knezevic', 'kneza96123@gmail.com', 'Belog bagrema 5', 'admin', 1, 999999999999999),
(4, 'Dzndzo5', '9a1c080fd087712e07ffc673ba61dd74fc6c8862', 'Ddsfsd', 'Dzndzic', 'dfsfd@dsf.cos', 'Ddsd fdf d 2', 'user', 0, 635893590013145),
(5, 'Dzndzo6', '01938eb910321c040b7c23b6f063fc54bab84fd1', 'Djordjije', 'Dsfds', 'dsklfsl@dsfsd.sdf.ccc', 'Dsds 2', 'user', 0, 378258665849999),
(7, 'Dzndzo8', '30a5fdc70de866458152acc100792248947d7da5', 'Ddsfsd', 'Dsdfs', 'ddd@ddd.cas', 'Ddsd fdf d 2', 'user', 0, 310459267894118),
(18, 'Dzndzo2', '31c95fe9352a5d5d6c8864f81c2a21727d40f221', 'Ddsfds', 'Dsfds', 'kneza96@gmail.com', 'Dsds sds 2', 'user', 1, 848325810916465),
(19, 'Lluka', '31db1699c2c9cf43d428e7d996060fa44b541e92', 'Luka', 'Lukic', 'luka.lukic@ict.edu.rs', 'Adresa 1', 'user', 1, 414108495213794),
(23, 'Mark#321', 'c5fed217d397beeb6d7b5e936f9093f23aa348a9', 'Marina', 'Krstic', 'marinakrsticrf@gmail.com', 'Nepostojeca adresa 16', 'user', 1, 970951267639310),
(24, 'Lukaaa', '21138b4dce7f736173ad0720963cb8e6b890a331', 'Luka', 'Knee', 'illquidnb@gmail.com', 'Belog Bagrema 5', 'user', 1, 691532624217697),
(25, 'Blabla', 'ba29de99c5914130efb0840cb03302f265f7e62b', 'Ddsfds', 'Dsdfs', 'djordje.knezevic.255.22@ict.edu.rs', 'Dsds sds 2', 'user', 1, 694627079435592),
(32, 'Ddsgsdgs1', 'b45b2368fc6691376d038b13175cadeb46fad7d3', 'Ddsfdsf', 'Dsdfsdf', 'misterja@protonmail.com', 'Dsds 2', 'user', 1, 510683933408114);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anketa`
--
ALTER TABLE `anketa`
  ADD PRIMARY KEY (`user_id`,`brend_id`),
  ADD KEY `brend_id` (`brend_id`);

--
-- Indexes for table `brend`
--
ALTER TABLE `brend`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cena`
--
ALTER TABLE `cena`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patika` (`patika_id`);

--
-- Indexes for table `cena_postarine`
--
ALTER TABLE `cena_postarine`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patika_id` (`patika_id`);

--
-- Indexes for table `ikonica`
--
ALTER TABLE `ikonica`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategorija`
--
ALTER TABLE `kategorija`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `korpa`
--
ALTER TABLE `korpa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `korpa_patika`
--
ALTER TABLE `korpa_patika`
  ADD PRIMARY KEY (`korpa_id`,`patika_id`),
  ADD KEY `patika_id` (`patika_id`);

--
-- Indexes for table `navigacija`
--
ALTER TABLE `navigacija`
  ADD PRIMARY KEY (`id`),
  ADD KEY `slika` (`slika_id`);

--
-- Indexes for table `path`
--
ALTER TABLE `path`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ikonica` (`ikonica_id`);

--
-- Indexes for table `patika`
--
ALTER TABLE `patika`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vezivanje` (`brend_id`,`kategorija_id`),
  ADD KEY `kategorija_id` (`kategorija_id`),
  ADD KEY `slika_id` (`slika_id`);

--
-- Indexes for table `popust`
--
ALTER TABLE `popust`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patika_id` (`patika_id`);

--
-- Indexes for table `porudzbina`
--
ALTER TABLE `porudzbina`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `porudzbina_patika`
--
ALTER TABLE `porudzbina_patika`
  ADD PRIMARY KEY (`porudzbina_id`,`patika_id`),
  ADD KEY `patika_id` (`patika_id`);

--
-- Indexes for table `slika`
--
ALTER TABLE `slika`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sortiranje`
--
ALTER TABLE `sortiranje`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brend`
--
ALTER TABLE `brend`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cena`
--
ALTER TABLE `cena`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT for table `cena_postarine`
--
ALTER TABLE `cena_postarine`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `ikonica`
--
ALTER TABLE `ikonica`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kategorija`
--
ALTER TABLE `kategorija`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `korpa`
--
ALTER TABLE `korpa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `navigacija`
--
ALTER TABLE `navigacija`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `path`
--
ALTER TABLE `path`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `patika`
--
ALTER TABLE `patika`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `popust`
--
ALTER TABLE `popust`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `porudzbina`
--
ALTER TABLE `porudzbina`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `slika`
--
ALTER TABLE `slika`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `sortiranje`
--
ALTER TABLE `sortiranje`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `anketa`
--
ALTER TABLE `anketa`
  ADD CONSTRAINT `anketa_ibfk_1` FOREIGN KEY (`brend_id`) REFERENCES `brend` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `anketa_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cena`
--
ALTER TABLE `cena`
  ADD CONSTRAINT `cena_ibfk_1` FOREIGN KEY (`patika_id`) REFERENCES `patika` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cena_postarine`
--
ALTER TABLE `cena_postarine`
  ADD CONSTRAINT `cena_postarine_ibfk_1` FOREIGN KEY (`patika_id`) REFERENCES `patika` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `korpa`
--
ALTER TABLE `korpa`
  ADD CONSTRAINT `korpa_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `korpa_patika`
--
ALTER TABLE `korpa_patika`
  ADD CONSTRAINT `korpa_patika_ibfk_1` FOREIGN KEY (`patika_id`) REFERENCES `patika` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `korpa_patika_ibfk_2` FOREIGN KEY (`korpa_id`) REFERENCES `korpa` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `navigacija`
--
ALTER TABLE `navigacija`
  ADD CONSTRAINT `navigacija_ibfk_1` FOREIGN KEY (`slika_id`) REFERENCES `slika` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `path`
--
ALTER TABLE `path`
  ADD CONSTRAINT `path_ibfk_1` FOREIGN KEY (`ikonica_id`) REFERENCES `ikonica` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `patika`
--
ALTER TABLE `patika`
  ADD CONSTRAINT `patika_ibfk_1` FOREIGN KEY (`brend_id`) REFERENCES `brend` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `patika_ibfk_2` FOREIGN KEY (`kategorija_id`) REFERENCES `kategorija` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `patika_ibfk_3` FOREIGN KEY (`slika_id`) REFERENCES `slika` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `popust`
--
ALTER TABLE `popust`
  ADD CONSTRAINT `popust_ibfk_1` FOREIGN KEY (`patika_id`) REFERENCES `patika` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `porudzbina`
--
ALTER TABLE `porudzbina`
  ADD CONSTRAINT `porudzbina_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `porudzbina_patika`
--
ALTER TABLE `porudzbina_patika`
  ADD CONSTRAINT `porudzbina_patika_ibfk_1` FOREIGN KEY (`patika_id`) REFERENCES `patika` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `porudzbina_patika_ibfk_2` FOREIGN KEY (`porudzbina_id`) REFERENCES `porudzbina` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

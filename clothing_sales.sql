-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 01, 2023 at 04:43 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clothing_sales`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `brand_name` varchar(500) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `company` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `brand_name`, `image`, `company`) VALUES
(7, 'UGG', '6a775f870fde948d44018facf29be321-63f8e496cb6a9.svg', 'Deckers Outdoor Corporation'),
(8, 'Adidas', 'icon-adidas-logo-63f8e4a97e1c3.svg', 'adidas AG'),
(9, 'Champion', 'C-logo-63f8e4b56104b.svg', 'Hanesbrands'),
(10, 'Levi\'s', 'levis-logo-63f8e4bdec114.svg', 'Levi Strauss & Co.'),
(11, 'Dickies', 'logo-63f8e4d7d8b37.svg', 'Williamson-Dickie Mfg. Co.'),
(12, 'The North Face', 'Logos-Primary-Black-Small-63f8e4e29a2b8.svg', 'VF Corporation');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `product_count` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(500) NOT NULL,
  `description` longtext DEFAULT NULL,
  `category_parent` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_name`, `description`, `category_parent`) VALUES
(1, 'Hoodies + Sweatshirts', NULL, 'men'),
(2, 'Coats + Jackets', NULL, 'men'),
(3, 'T-Shirts', NULL, 'men'),
(4, 'Shirts', NULL, 'men'),
(5, 'Sweaters', NULL, 'men'),
(6, 'Jeans', NULL, 'men'),
(7, 'Pants', NULL, 'men'),
(8, 'Shorts + Swim', NULL, 'men'),
(9, 'Hoodies + Sweatshirts', NULL, 'women'),
(10, 'Sweaters + Cardigans', NULL, 'women'),
(11, 'T-Shirts', NULL, 'women'),
(12, 'Shirts + Blouses', NULL, 'women'),
(13, 'Jeans', NULL, 'women'),
(14, 'Pants', NULL, 'women'),
(15, 'Skirts', NULL, 'women'),
(16, 'Shorts', NULL, 'women');

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20230221050328', '2023-02-21 06:03:35', 57),
('DoctrineMigrations\\Version20230222142725', '2023-02-22 15:27:40', 508),
('DoctrineMigrations\\Version20230222143331', '2023-02-22 15:33:39', 40),
('DoctrineMigrations\\Version20230222143820', '2023-02-22 15:38:27', 40),
('DoctrineMigrations\\Version20230222144823', '2023-02-22 15:48:32', 162),
('DoctrineMigrations\\Version20230222152102', '2023-02-22 16:21:08', 530),
('DoctrineMigrations\\Version20230222153831', '2023-02-22 16:38:37', 65),
('DoctrineMigrations\\Version20230222154701', '2023-02-22 16:47:07', 52),
('DoctrineMigrations\\Version20230222154909', '2023-02-22 16:49:15', 133),
('DoctrineMigrations\\Version20230222155032', '2023-02-22 16:50:39', 91),
('DoctrineMigrations\\Version20230222160359', '2023-02-22 17:04:04', 84),
('DoctrineMigrations\\Version20230222160621', '2023-02-22 17:06:28', 148),
('DoctrineMigrations\\Version20230222160728', '2023-02-22 17:07:34', 88),
('DoctrineMigrations\\Version20230222173935', '2023-02-22 18:39:55', 548),
('DoctrineMigrations\\Version20230222175622', '2023-02-22 18:56:29', 147),
('DoctrineMigrations\\Version20230223072902', '2023-02-23 08:29:10', 470),
('DoctrineMigrations\\Version20230223113434', '2023-02-23 12:34:41', 547),
('DoctrineMigrations\\Version20230224014950', '2023-02-24 02:49:56', 578),
('DoctrineMigrations\\Version20230224015115', '2023-02-24 02:51:20', 35),
('DoctrineMigrations\\Version20230224081543', '2023-02-24 09:15:54', 156),
('DoctrineMigrations\\Version20230224150927', '2023-02-24 16:09:35', 256),
('DoctrineMigrations\\Version20230224151355', '2023-02-24 16:14:03', 121),
('DoctrineMigrations\\Version20230224152511', '2023-02-24 16:25:17', 45),
('DoctrineMigrations\\Version20230225024326', '2023-02-25 03:44:01', 477),
('DoctrineMigrations\\Version20230225030023', '2023-02-25 04:00:31', 163),
('DoctrineMigrations\\Version20230225031623', '2023-02-25 04:16:31', 43),
('DoctrineMigrations\\Version20230226202740', '2023-02-26 21:39:31', 110),
('DoctrineMigrations\\Version20230226204529', '2023-02-26 21:47:40', 205),
('DoctrineMigrations\\Version20230227044711', '2023-02-27 05:49:57', 60),
('DoctrineMigrations\\Version20230227045938', '2023-02-27 06:02:23', 40);

-- --------------------------------------------------------

--
-- Table structure for table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `sum` double NOT NULL,
  `users_id` int(11) NOT NULL,
  `address` varchar(2000) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `sum`, `users_id`, `address`, `date`) VALUES
(115, 135, 2, 'Vinh Long', '2023-02-28 22:00:05'),
(116, 55, 1, 'Vung Tau', '2023-02-28 22:01:03'),
(117, 70, 1, 'Vinh Long', '2023-02-28 22:01:35'),
(118, 80, 2, 'Vung Tau', '2023-02-28 22:08:45'),
(119, 70, 2, 'Vung Tau', '2023-03-01 01:55:31'),
(120, 139, 2, 'Hanoi', '2023-03-01 03:47:19'),
(121, 80, 2, 'Can Tho', '2023-03-01 03:47:44'),
(122, 559, 2, 'Vung Tau', '2023-03-01 03:50:38'),
(123, 234, 2, 'Hanoi', '2023-03-01 03:51:12'),
(124, 1112, 2, 'Can Tho', '2023-03-01 03:52:30'),
(125, 95, 2, 'Can Tho', '2023-03-01 03:53:00'),
(126, 245, 2, 'Tra Vinh', '2023-03-01 03:53:56'),
(127, 95, 2, 'Vung Tau', '2023-03-01 03:54:41');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `od_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`id`, `product_quantity`, `od_id`, `products_id`) VALUES
(224, 1, 115, 1),
(225, 1, 116, 1),
(226, 1, 117, 2),
(227, 1, 118, 2),
(228, 1, 119, 2),
(229, 1, 120, 1),
(230, 1, 120, 49),
(231, 1, 121, 47),
(232, 1, 122, 6),
(233, 6, 122, 2),
(234, 1, 122, 49),
(235, 1, 123, 49),
(236, 3, 123, 47),
(237, 8, 124, 49),
(238, 9, 124, 25),
(239, 1, 125, 6),
(240, 4, 126, 1),
(241, 1, 127, 25);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `product_name` varchar(1000) NOT NULL,
  `import_date` datetime NOT NULL,
  `description` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` double NOT NULL,
  `brand_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `cat_id`, `product_name`, `import_date`, `description`, `image`, `price`, `brand_id`) VALUES
(1, 1, 'Champion Reverse Weave Crew Neck Sweatshirt', '2023-02-24 00:00:00', 'Pullover crew neck sweatshirt by Champion in the brand’s signature reverse weave fabrication. Topped with logo accents. Classic silhouette and finished with ribbed knit trims.', 'champion-64530686-048-b-63f8e9fd9904e.webp', 55, 9),
(2, 1, 'Champion UO Exclusive Waffle Texture Hoodie Sweatshirt', '2023-02-24 00:00:00', 'Pullover hoodie by Champion with a textured waffle knit fabrication. Fitted with an adjustable hood, pouch front pocket and ribbed knit trims. Urban Outfitters exclusive.', 'champion-68889856-046-b-63f8ea39a4773.webp', 70, 9),
(3, 1, 'Champion UO Exclusive Reverse Weave Open Hem Hoodie Sweatshirt', '2023-02-24 00:00:00', 'Pullover hoodie by Champion in the brand’s signature reverse weave fabrication. Fitted with a hood and includes a pouch pocket. Complete with an adjustable drawstring at the hem. Urban Outfitters exclusive.', 'champion-68890029-001-b-63f8ea8de892b.webp', 75, 9),
(4, 1, 'Dickies Beavertown Crew Neck Sweatshirt', '2023-02-24 00:00:00', 'Contrast stitch crew neck sweatshirt by Dickies with graphics printed at the left chest and back. Pullover style with ribbed knit trims.', 'dickies-81134355-020-b-63f8ead157887.webp', 85, 11),
(5, 1, 'Dickies Port Allen Fleece Sweatshirt', '2023-02-24 00:00:00', 'Pullover fleece sweatshirt by Dickies. Features a partial snap closure at the front. Fitted with a left chest flap pocket and finished with elastic trims.', 'dickies-78811742-003-b-63f8eb03d5930.webp', 79, 11),
(6, 1, 'Levi’s® Team Spirits Crew Neck Sweatshirt', '2023-02-24 00:00:00', 'Crew neck sweatshirt by Levi’s® with graphics printed at the left chest and back. Cotton jersey sweatshirt with ribbed knit trims.', 'levis-79026415-001-b-63f8eb5d9b4e8.webp', 70, 10),
(7, 1, 'Levi’s® Olde English Hoodie Sweatshirt', '2023-02-24 00:00:00', 'Pullover hoodie by Levi’s® topped with text at the front. Fitted with an adjustable hood, pouch pocket and ribbed knit trims.', 'levis-79026472-030-b-63f8ebbf4bd7a.webp', 75, 10),
(8, 1, 'Levi’s® Skate Hoodie Sweatshirt', '2023-02-24 00:00:00', 'Pullover hoodie by Levi’s® topped with a woven logo label accent. Sweatshirt fitted with an adjustable hood and includes a pouch pocket and ribbed knit trims.', 'levis-79272498-060-b-63f8ebf8dafa1.webp', 70, 10),
(9, 2, 'Dickies Duck Hooded Jacket', '2023-02-25 00:00:00', 'Classic duck canvas jacket by Dickies. Workwear style with a full zip closure front and fitted with a hood. Includes pockets and finished with ribbed knit trims.', 'dickies-69351294-002-b-63f8edfd4b002.webp', 130, 11),
(10, 2, 'Dickies Lined Corduroy Jacket', '2023-02-25 00:00:00', 'Cotton cord jacket by Dickies with a lined inner. Full zip front with pockets at the sides and fitted with a tab collar.', 'dickies-69351187-021-b-63f8ee2b0e38e.webp', 95, 11),
(11, 2, 'Dickies Duck Canvas Hooded Jacket', '2023-02-25 00:00:00', 'Hooded utility jacket by Dickies. Hardwearing canvas jacket with a full zip closure at the front. Fitted with pockets and finished with ribbed knit trims.', 'dickies-69351500-022-b-63f8ee9c152be.webp', 130, 11),
(12, 2, 'Levi’s® Vintage Fit Denim Trucker Jacket', '2023-02-25 00:00:00', 'Classic vintage fit denim trucker jacket by Levi’s®. Button front style with a tab collar. Fitted with hand pockets at the waist and flap pockets at the chest.', 'levis-79726055-092-b-63f8f0f352951.webp', 98, 7),
(13, 2, 'Levi’s® Big Denim Trucker Jacket', '2023-02-25 00:00:00', 'Allover bleached text denim trucker jacket by Levi’s®. Button closure style & fitted with a tab collar. Topped with flap pockets at the chest and finished with hand pockets at the sides.', 'levis-79725875-092-b-63f8f14ee23cb.webp', 99, 10),
(14, 2, 'The North Face Nuptse Sherpa Puffer Jacket', '2023-02-25 00:00:00', 'The essential Nupste puffer jacket by The North Face updated to feature a quilted Sherpa outer. Zip-through jacket with contrast paneling and trims. Fitted with pockets to the sides and topped with a logo accent.', 'tnf-61782520-011-b-63f8f1bdbb4d0.webp', 350, 12),
(15, 2, 'The North Face McMurdo Parka Jacket', '2023-02-25 00:00:00', 'Cold weather parka by The North Face. Waterproof nylon ripstop with 550 fill down insulation. Concealed zip front jacket in a longline silhouette with a two-way zip closure. Fitted with a removeable hood with faux fur trim. Fitted with multiple pockets and topped with logo detailing.', 'tnf-68039924-016-b-63f8f3ee227ce.webp', 700, 10),
(16, 2, 'The North Face Extreme Pile Pullover Jacket', '2023-02-25 00:00:00', 'Piled fleece jacket by The North Face in a pullover style. Features a mock neckline and a partial zip at the front.', 'tnf-68039973-031-b-63f8f5117384e.webp', 159, 12),
(17, 3, 'adidas Algeria Prematch Tee', '2023-02-25 00:00:00', 'Tee by adidas with an allover tonal pattern. Short sleeve t-shirt with logo at the front. Standard fit tee with a ribbed knit crew neck.', 'adidas-68787563-000-b-63f8fbd1ebbc9.webp', 65, 8),
(18, 3, 'Champion Script Tee', '2023-02-25 00:00:00', 'Tee by Champion with a logo graphic at the left chest. Athletic look with short sleeves and contrast stripe detailing.', 'champion-80207434-060-b-63f8fc0cb13b5.webp', 35, 9),
(19, 3, 'Dickies Heavyweight Cotton Pocket Tee', '2023-02-25 00:00:00', 'Essential t-shirt by Dickies crafted from heavyweight cotton. Short sleeve tee in a standard fit with a logo-topped pocket at the left chest.', 'dickies-69741783-003-b-63f8fc44d5148.webp', 39, 11),
(20, 3, 'The North Face Wander Muscle Tee', '2023-02-25 00:00:00', 'Standard-fit sleeveless tee from The North Face in their moisture-wicking FlashDry knit to help keep you cool and dry. Slight stretch fit with a side-vented seam and heat-transfer logo. Made from 94% recycled materials.', 'tnf-64750821-001-b-63f8fcbaf20b5.webp', 35, 12),
(21, 4, 'Dickies Flannel Button-Down Shirt', '2023-02-28 00:00:00', 'Flannel pattern button-down shirt by Dickies. Cotton long sleeve shirt topped with flap pockets at the chest & finished with a tab collar.', 'dickies-69127785-038-b-63fda3a430586.webp', 60, 11),
(22, 4, 'Levi’s Relaxed Fit Western Shirt', '2023-02-28 00:00:00', 'Western style shirt by Levi’s in a cotton & hemp blend fabrication. Button-down style with flap pockets at the chest and fitted with a tab collar.', 'levis-79613535-011-b-63fda3e3b8f9b.webp', 80, 10),
(23, 4, 'Levi’s® Bandana Camp Shirt', '2023-02-28 00:00:00', 'Camp collar shirt by Levi’s® with an allover bandana pattern. Short sleeve button-down shirt with a left chest pocket and notched collar.', 'levis-79613089-040-b-63fda4129cab4.webp', 65, 10),
(24, 6, 'Dickies Washed Denim Overall', '2023-02-28 00:00:00', 'Denim overalls by Dickies in a classic silhouette with a bib front. Crafted from 100% cotton and topped with utility style pockets throughout. Finished with adjustable shoulder straps.', 'dickies-79348819-107-b-63fda53bcc746.webp', 85, 11),
(25, 6, 'Levi’s® 550 Relaxed Fit Jean', '2023-02-28 00:00:00', 'The classic 550 jeans by Levi’s®. 100% Heavyweight cotton denim is cut in a silhouette that sits at the waist with a loose fit through the hip and thigh with a straight leg. Complete with a zip fly and copper metal detailing.', 'levis-68516640-092-b-63fda57cb7de8.webp', 70, 10),
(26, 6, 'Levi’s® 501 ’93 Straight Leg Jean', '2023-02-28 00:00:00', 'Classic straight-leg jeans by Levi’s® featuring a durable cotton denim fabrication with a 5-pocket style. Finished with a button & zip closure to the front', 'levis-76143072-032-b-63fda5b27caf8.webp', 99, 10),
(27, 7, 'Dickies 874 Straight Pant', '2023-02-28 00:00:00', 'Essential work pants from Dickies. Durable twill is cut in a straight leg fit with front slant pockets and back welt pockets. Finished with a zip fly and a clasp waist closure.', 'dickies-47061072-042-b-63fda73c66ae0.webp', 65, 11),
(28, 7, 'adidas Rekive Woven Track Pant', '2023-02-28 00:00:00', 'Woven track pants by adidas in a relaxed and tapered silhouette. Features an elastic waistband with an adjustable tie drawcord. Plain weave fabrication with a mid-rise and elastic cuffs.', 'adidas-68948041-030-b-63fda77ee1391.webp', 85, 8),
(29, 7, 'The North Face Heavyweight Fleece Sweatpant', '2023-02-28 00:00:00', 'Heavyweight fleece sweatpants from The North Face. Features a relaxed fit with gathered ankle cuffs. Topped with a logo accent at the side and fitted with zip pockets. Complete with an elastic waistband.', 'tnf-68118934-001-b-63fda7bbddb1b.webp', 79, 12),
(30, 7, 'adidas Training Pant', '2023-02-28 00:00:00', 'Classic training pants by adidas in a tapered silhouette. Stretch poly pants fitted with pockets and an elastic waistband.', 'adidas-68948157-006-b-63fda7e5ed938.webp', 70, 8),
(31, 7, 'Champion Reverse Weave Sweatpant', '2023-02-28 00:00:00', 'Classic reverse weave cotton poly sweatpant by Champion in a relaxed and tapered silhouette. Topped with a Champion ‘C’ logo at the waist. Fitted with an elasticated waistband & complete with elasticated ankle cuffs.', 'champion-59935817-001-b-63fda80c737c1.webp', 65, 9),
(32, 7, 'Levi’s® Skate Fit Loose Chino Pant', '2023-02-28 00:00:00', 'Relaxed cotton chino pants by Levi’s®. Features a loose silhouette fitted with pockets at the sides & back. Finished with a button and zip closure at the front.', 'levis-65920787-001-b-63fda83bed7f5.webp', 90, 10),
(33, 8, 'adidas Logo Training Short', '2023-02-28 00:00:00', 'Logo-topped training shorts by adidas cut with 5\" inseams. Fitted with an elastic waistband and adjustable tie closure.', 'adidas-68950484-004-b-63fda9b1964da.webp', 45, 8),
(34, 8, 'Champion 5” Running Short', '2023-02-28 00:00:00', 'Running shorts by Champion with a colorblock look. Fitted with pockets and complete with an elastic waistband.', 'champion-66190638-040-b-63fda9da5e2e5.webp', 65, 9),
(35, 8, 'Dickies Hickory Stripe Carpenter Short', '2023-02-28 00:00:00', 'Hickory stripe pattern shorts by Dickies. Classic look work shorts with utility style pockets. Cut with a mid-rise waist and longline hems.', 'dickies-81109381-015-b-63fda9fdb5744.webp', 59, 11),
(36, 8, 'Levi’s® 479 Stay Baggy Denim Short', '2023-02-28 00:00:00', 'Baggy fit denim shorts by Levi’s®. Features a mid-rise waist and relaxed silhouette. Classic 5-pocket style and a zip fly & button closure.', 'levis-80011414-094-b-63fdaa22537a1.webp', 70, 10),
(37, 8, 'The North Face Never Stop Sweat Short', '2023-02-28 00:00:00', 'Sweat shorts by outdoors label The North Face. Features a cotton poly blend cut with 7\" inseams. Fitted with side slit hand pockets. Topped with a woven logo label. Complete with a stretch elastic waistband.', 'tnf-68122415-001-b-63fdaa56e2ffc.webp', 45, 12),
(38, 9, 'The North Face NSE Heavyweight Pullover Hoodie Sweatshirt', '2023-02-28 00:00:00', 'Classic hoodie from The North Face in a cozy heavyweight knit. Relaxed fit with a two-piece hood and slouchy dropped shoulders. Finished with The North Face logo detailing. Part of the new NSE collection from The North Face, a contemporary take on classic designs from The North Face archive. From bold colors to styles made for city life, the NSE collection celebrates all that The North Face has achieved and imagines everything that’s yet to come.', 'tnf-68270958-020-b-63fdab745569e.webp', 79, 12),
(39, 9, 'Champion UO Exclusive Zip-Up Sweatshirt', '2023-02-28 00:00:00', 'A staple sweatshirt from Champion. Relaxed fit with dropped shoulders and a hood. Finished with a zip closure at the front and an embroidered logo. Only available at UO.', 'champion-63365555-021-b-63fdaba9e490e.webp', 70, 9),
(40, 9, 'Levi’s Gardenia Turtle Neck Sweatshirt', '2023-02-28 00:00:00', 'Classic sweatshirt from Levi’s updated with a turtle neck silhouette. Cut in a relaxed fit with dropped shoulders and finished with a textured Levi’s graphic at the front.', 'levis-79340436-041-b-63fdabdd2cb31.webp', 89, 10),
(41, 13, 'Levi’s® 501 \'90s Jean', '2023-02-28 00:00:00', 'Effortless jeans from Levi’s® in a ‘90s inspired silhouette. Cut with a mid-rise and a baggy straight leg. Complete with a mini logo tab at the back pocket.', 'levis-70297072-093-f-63fdad5d299e6.webp', 98, 10),
(42, 11, 'Champion Heritage Cropped Tee', '2023-02-28 00:00:00', 'Cropped cotton t-shirt by heritage athletic label Champion. Short sleeve style in a cropped and boxy fit with a crew neck. Topped with a logo accent at the left chest.', 'champion-78624053-001-1-63fdad9425e41.webp', 30, 9),
(43, 14, 'Levi’s® Faux Leather Baggy Dad Pant', '2023-02-28 00:00:00', 'Levi’s® baggy dad jean silhouette reinvented in faux leather. Cut with a mid-rise and a loose wide-leg that hits just below the ankle.', 'levis-79453197-001-b-63fdaee6b6814.webp', 128, 10),
(44, 14, 'Champion UO Exclusive Reverse Weave Sweatpant', '2023-02-28 00:00:00', 'Go-to sweatpants from Champion in their classic reverse weave. Medium rise with a jogger fit complete with side pockets. UO exclusive.', 'champion-61555181-021-b-63fdaf0ff1aa7.webp', 50, 9),
(45, 14, 'Dickies Camden Snakeskin Trouser Pant', '2023-02-28 00:00:00', 'The classic Camden chinos from Dickies cut in a slimmer + more feminine silhouette. High-waisted style with a straight-leg that hits just above the ankle. Finished with an allover snakeskin print.', 'dickies-68834993-095-b-63fdaf38b24da.webp', 65, 11),
(46, 16, 'Levi’s® 501 Mid-Thigh Denim Short', '2023-02-28 00:00:00', 'Classic denim shorts from Levi’s® with a longer inseam. High-waisted style with a relaxed leg and finished with a raw cutoff hem.', 'levis-79334090-001-b-63fdb133402eb.webp', 69, 10),
(47, 16, 'Dickies Hickory Stripe Carpenter Short', '2023-02-28 00:00:00', 'Striped shorts from Dickies made from a durable cotton canvas. Cut with a high-rise and a fitted leg that hits at mid-thigh. Complete with an extra carpenter pocket at the side.', 'dickies-80315765-041-b-63fdb15e0c74d.webp', 55, 11),
(48, 16, 'Champion Reversible Two-Tone Classic Fleece Sweat Short', '2023-02-28 00:00:00', 'Cotton fleece sweat shorts by Champion. Fitted with an elastic waistband & adjustable drawstring tie closure. Finished with pockets at the sides and topped with a logo accent.', 'champion-78624236-016-b-63fdb18432907.webp', 50, 9),
(49, 15, 'Dickies Life Elizaville Mini Skirt', '2023-02-28 00:00:00', 'Wardrobe-staple mini skirt from Dickies. Cut with a mid-rise fit and an a-line silhouette. Finished with a mini logo patch at the front.', 'dickies-69079598-001-b-63fdb1c242265.webp', 59, 11);

-- --------------------------------------------------------

--
-- Table structure for table `product_detail`
--

CREATE TABLE `product_detail` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` varchar(10) NOT NULL,
  `stock` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_detail`
--

INSERT INTO `product_detail` (`id`, `product_id`, `size`, `stock`, `status`) VALUES
(1, 1, 'XL', 20, 1),
(2, 1, 'M', 20, 1),
(3, 1, 'L', 20, 1),
(4, 2, 'XXL', 20, 1),
(6, 1, 'XL', 20, 1),
(7, 3, 'XXL', 20, 1),
(8, 3, 'L', 20, 1),
(9, 4, 'XXL', 20, 1),
(10, 5, 'XXL', 20, 1),
(11, 6, 'XXL', 20, 1),
(12, 7, 'XXL', 20, 1),
(13, 8, 'XXL', 20, 1),
(14, 10, 'XXL', 20, 1),
(15, 11, 'XXL', 20, 1),
(16, 12, 'XXL', 20, 1),
(17, 13, 'XXL', 20, 1),
(18, 14, 'XXL', 20, 1),
(19, 15, 'XXL', 20, 1),
(20, 16, 'XXL', 20, 1),
(21, 17, 'XXL', 20, 1),
(22, 18, 'XXL', 20, 1),
(23, 19, 'XXL', 20, 1),
(24, 20, 'XXL', 20, 1),
(25, 21, 'XXL', 20, 1),
(26, 22, 'XXL', 20, 1),
(27, 23, 'XXL', 20, 1),
(28, 24, 'XXL', 20, 1),
(29, 25, 'XXL', 20, 1),
(30, 26, 'XXL', 20, 1),
(31, 27, 'XXL', 20, 1),
(32, 28, 'XXL', 20, 1),
(33, 29, 'XXL', 20, 1),
(34, 30, 'XXL', 20, 1),
(35, 31, 'XXL', 20, 1),
(36, 32, 'XXL', 20, 1),
(37, 33, 'XXL', 20, 1),
(38, 34, 'XXL', 20, 1),
(39, 35, 'XXL', 20, 1),
(40, 36, 'XXL', 20, 1),
(41, 37, 'XXL', 20, 1),
(42, 38, 'XXL', 20, 1),
(43, 39, 'XXL', 20, 1),
(44, 49, 'XXL', 20, 1),
(45, 48, 'XXL', 20, 1),
(46, 47, 'XXL', 20, 1),
(47, 46, 'XXL', 20, 1),
(48, 45, 'XXL', 20, 1),
(49, 44, 'XXL', 20, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_image`
--

CREATE TABLE `product_image` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_image`
--

INSERT INTO `product_image` (`id`, `product_id`, `image`) VALUES
(2, 1, '64530686-048-b-id1-63fe574693341.webp'),
(3, 2, '68889856-046-b-id2-63fe59d3eba0a.webp'),
(4, 3, '68890029-001-b-id3-63fe59e38d1dc.webp'),
(5, 4, '81134355-020-b-id4-63fe5a2f1c551.webp'),
(6, 5, '78811742-003-b-id5-63fe5a3e7a832.webp'),
(7, 6, '79026415-001-b-id6-63fe5a4f80bf4.webp'),
(8, 7, '79026472-030-b-id7-63fe5a629dd15.webp'),
(9, 8, '79272498-060-b-id8-63fe5a7dbe723.webp'),
(10, 9, '69351294-002-b-id9-63fe5aa39b952.webp'),
(11, 10, '69351187-021-b-id10-63fe5ab4022f2.webp'),
(12, 11, '69351500-022-b-id11-63fe5ac1eba26.webp'),
(13, 12, '79726055-092-b-id12-63fe61474846b.webp'),
(14, 13, '79725875-092-b-id13-63fe617416c82.webp'),
(15, 14, '61782520-011-b-id14-63fe61985a770.webp'),
(16, 15, '68039924-016-b-id15-63fe61ad89f92.webp'),
(17, 16, '68039973-031-b-id16-63fe61c6951ff.webp'),
(18, 17, '68787563-000-b-id17-63fe61dd9a5d7.webp'),
(19, 18, '80207434-060-b-id18-63fe61f944d4a.webp'),
(20, 19, '69741783-003-b-id19-63fe622f906a7.webp'),
(21, 20, '64750821-001-b-id20-63fe627715e81.webp'),
(22, 21, '69127785-038-b-id21-63fe629763dcb.webp'),
(23, 22, '79613535-011-b-id22-63fe62ab30cf3.webp'),
(24, 23, '79613089-040-b-id23-63fe62dce8307.webp'),
(25, 24, '79348819-107-b-id24-63fe62fe93bde.webp'),
(26, 25, '68516640-092-b-id25-63fe631e242e0.webp'),
(27, 26, '76143072-032-b-id26-63fe6346855f7.webp'),
(28, 27, '47061072-042-b-id27-63fe63719a661.webp'),
(29, 28, '68948041-030-b-id28-63fe6385b1601.webp'),
(30, 29, '68118934-001-b-id29-63fe63ace26a9.webp'),
(31, 30, '68948157-006-b-id30-63fe63c44d9b2.webp'),
(32, 31, '59935817-001-b-id31-63fe63e0bacf4.webp'),
(33, 32, '65920787-001-b-id32-63fe64018bbf9.webp'),
(34, 33, '68950484-004-b-id33-63fe641c21c3f.webp'),
(35, 34, '66190638-040-b-id34-63fe643b008d9.webp'),
(36, 35, '81109381-015-b-id35-63fe6468c1324.webp'),
(37, 36, '80011414-094-b-id36-63fe64947c1af.webp'),
(38, 37, '68122415-001-b-id37-63fe64a9cbd25.webp'),
(39, 38, '68270958-020-b-id38-63fe64bfa26a0.webp'),
(40, 39, '63365555-021-b-id39-63fe64e9e4580.webp'),
(41, 40, '79340436-041-b-id40-63fe6506087f8.webp'),
(42, 41, '70297072-093-f-id41-63fe651f10e0a.webp'),
(43, 42, '78624053-001-1-id42-63fe65319f4ee.webp'),
(44, 43, '79453197-001-b-id43-63fe6546257e8.webp'),
(45, 44, '61555181-021-b-id44-63fe657412dac.webp'),
(46, 45, '68834993-095-b-id45-63fe65890a81d.webp'),
(47, 46, '79334090-001-b-id46-63fe659b8e517.webp'),
(48, 47, '80315765-041-b-id47-63fe65b30d7bf.webp'),
(49, 48, '78624236-016-b-id48-63fe65bf5e57c.webp'),
(50, 49, '69079598-001-b-id49-63fe65d79f108.webp');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) NOT NULL,
  `roles` longtext NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `first_name`, `last_name`) VALUES
(1, 'cba@gmail.com', '[\"ROLE_USER\"]', '$2y$13$9I0zTC09eV2VDWp0ksqeyOVKL6MatlNhZX8X9VkdM67KUEz3qa8Mm', 'Nguyen', 'Phong'),
(2, 'admin@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$vXVC6uAGJD/VpuyGPf0iU.NRlIcoViRlwsmFB2faBp/Xu1T7lQQcW', 'Admin', '\"-\"'),
(3, 'admin1@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$TKQSQLqpBg9jg/GsHeA1mOMJbHODgRtAgBjmnXWB/yH/frfUj06oO', 'admin', '123\r\n');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_BA388B74584665A` (`product_id`),
  ADD KEY `UNIQ_BA388B7A76ED395` (`user_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F529939867B3B43D` (`users_id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_ED896F46F0046BF7` (`od_id`),
  ADD KEY `IDX_ED896F466C8A81A9` (`products_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D34A04ADE6ADA943` (`cat_id`),
  ADD KEY `IDX_D34A04AD44F5D008` (`brand_id`);

--
-- Indexes for table `product_detail`
--
ALTER TABLE `product_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4C7A3E374584665A` (`product_id`);

--
-- Indexes for table `product_image`
--
ALTER TABLE `product_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_64617F034584665A` (`product_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=242;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `product_detail`
--
ALTER TABLE `product_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `product_image`
--
ALTER TABLE `product_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `FK_BA388B74584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `IDX_BA388B7A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `FK_F529939867B3B43D` FOREIGN KEY (`users_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `FK_ED896F466C8A81A9` FOREIGN KEY (`products_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `FK_ED896F46F0046BF7` FOREIGN KEY (`od_id`) REFERENCES `order` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_D34A04AD44F5D008` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`id`),
  ADD CONSTRAINT `FK_D34A04ADE6ADA943` FOREIGN KEY (`cat_id`) REFERENCES `category` (`id`);

--
-- Constraints for table `product_detail`
--
ALTER TABLE `product_detail`
  ADD CONSTRAINT `FK_4C7A3E374584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `product_image`
--
ALTER TABLE `product_image`
  ADD CONSTRAINT `FK_64617F034584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

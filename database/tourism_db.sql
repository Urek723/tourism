-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 08, 2025 at 05:23 PM
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
-- Database: `tourism_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(30) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` text DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `date_created`) VALUES
(1, 'Hiking', '123123123', '2025-05-08 19:18:22');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  `package_id` int(30) NOT NULL,
  `comment` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `parent_id` int(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `package_id`, `comment`, `date_created`, `parent_id`) VALUES
(1, 1, 10, 'naisu oneee chan daisuke', '2025-04-28 18:21:33', NULL),
(2, 1, 10, 'naisu oneee chan daisuke', '2025-04-28 18:21:36', NULL),
(3, 1, 10, 'naisu oneee chan daisuke', '2025-04-28 18:21:43', NULL),
(4, 16, 15, 'yahh', '2025-04-28 18:24:03', NULL),
(5, 16, 15, 'yahh', '2025-04-28 18:24:06', NULL),
(6, 16, 15, 'hoyaaaa\r\n', '2025-04-28 18:27:40', NULL),
(7, 16, 15, 'asdasdas', '2025-04-28 18:27:49', NULL),
(8, 16, 15, 'asdasd', '2025-04-28 18:30:01', NULL),
(9, 16, 15, 'asdasd\r\n', '2025-04-28 18:31:49', NULL),
(10, 16, 15, 'asdsad', '2025-04-28 18:33:29', NULL),
(11, 16, 15, 'asdasd', '2025-04-28 18:35:29', NULL),
(12, 16, 15, 'asasd', '2025-04-28 18:39:11', NULL),
(13, 16, 15, 'asdsdsad', '2025-04-28 18:39:17', NULL),
(14, 16, 15, 'asdasdsad', '2025-04-28 18:39:29', NULL),
(15, 16, 15, 'eqweqwe', '2025-04-28 18:40:32', NULL),
(16, 16, 15, 'asdasd', '2025-04-28 18:40:51', NULL),
(17, 16, 15, 'asdasd', '2025-04-28 18:42:56', NULL),
(18, 16, 15, 'asdasd', '2025-04-28 18:43:18', NULL),
(19, 16, 14, 'asdasdasd', '2025-04-28 18:45:57', NULL),
(20, 16, 15, 'asdasdasd', '2025-04-28 19:01:16', NULL),
(21, 16, 15, 'asdasd123123', '2025-04-28 19:01:20', NULL),
(22, 16, 10, 'asdasdasd', '2025-04-30 17:44:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `emergency_contacts`
--

CREATE TABLE `emergency_contacts` (
  `id` int(30) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `lat` decimal(10,8) DEFAULT NULL,
  `lng` decimal(11,8) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0=inactive, 1=active',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emergency_contacts`
--

INSERT INTO `emergency_contacts` (`id`, `name`, `phone_number`, `address`, `lat`, `lng`, `description`, `status`, `date_created`, `date_updated`) VALUES
(3, 'BFP TUPI', '09214906628', 'Tupi, South Cotabato', 6.33301000, 124.95043000, 'Bureau of Fire Protection - Tupi Branch', 1, '2025-05-06 20:46:04', NULL),
(4, 'PNP TUPI', '09098281201', 'Tupi, South Cotabato', 6.33258000, 124.94891000, 'Philippine National Police - Tupi Branch', 1, '2025-05-06 20:46:04', NULL),
(5, '5th Special Forces Battalion, Philippine Army', 'Globe: 09176346925, Smart: 09399212630', 'South Cotabato', 6.34521000, 124.93182000, '5th Special Forces Battalion of the Philippine Army', 1, '2025-05-06 20:46:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inquiry`
--

CREATE TABLE `inquiry` (
  `id` int(30) NOT NULL,
  `name` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `subject` varchar(250) NOT NULL,
  `message` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `video` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inquiry`
--

INSERT INTO `inquiry` (`id`, `name`, `email`, `subject`, `message`, `status`, `date_created`, `video`) VALUES
(6, 'asdasd', 'asdasd@asdasd.com', 'asdasd', 'asdasd', 1, '2021-06-19 10:19:27', NULL),
(8, 'rey', 'Nedrudarey101@gmaill.com', '123123', '1231231231', 1, '2025-03-26 14:40:06', NULL),
(9, 'rey', 'Nedrudarey101@gmaill.com', 'PASALI SA HIGHLIGHTS', 'please', 1, '2025-04-02 13:01:26', NULL),
(13, 'asdasd', 'asdasd', 'asdasd', 'asdasd', 1, '2025-04-02 13:11:00', 'uploads/videos1743570660_123123123123aaaaa.mp4'),
(14, 'qweqwe', 'qweqwe', 'qweqweqwe', 'qweqweqwe', 1, '2025-04-02 13:16:14', 'uploads/videos/1743570974_1743556784_sg5.mp4'),
(15, '', '', '', '', 1, '2025-04-02 13:16:17', NULL),
(16, 'rey', 'rewrqw', 'qwerqwerweqr', 'qwerwqer', 1, '2025-04-02 13:24:23', 'uploads/videos/1743571463_1743556784_sg5.mp4'),
(17, 'qweqwe', 'qweqwe', 'qweqwe', 'qweqwe', 1, '2025-04-02 13:26:19', '/Applications/XAMPP/xamppfiles/htdocs/tourism/classes/uploads/videos/1743571579_123123123123aaaaa.mp4');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` int(30) NOT NULL,
  `title` text DEFAULT NULL,
  `tour_location` text DEFAULT NULL,
  `cost` text NOT NULL,
  `description` text DEFAULT NULL,
  `upload_path` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 =active ,2 = Inactive',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `opening_hours` varchar(50) DEFAULT NULL COMMENT 'Opening hours in format like "9:00 AM - 5:00 PM"',
  `upload_path_video` text DEFAULT NULL,
  `category` text DEFAULT NULL COMMENT 'JSON array of category IDs'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `title`, `tour_location`, `cost`, `description`, `upload_path`, `status`, `date_created`, `opening_hours`, `upload_path_video`, `category`) VALUES
(9, 'SG Farm', '6.339855, 125.037044\r\nGlandang Rd, Tupi, South Cotabato', 'Paid entry', '&lt;p&gt;&lt;strong&gt;SG Farm - Glandang Rd, Tupi, South Cotabato, Philippines&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;SG Farm, located in the serene hills of &lt;strong&gt;Glandang, Tupi, South Cotabato&lt;/strong&gt;, is a popular agri-tourism destination known for its &lt;strong&gt;picturesque landscapes, cool climate, and vibrant flower gardens&lt;/strong&gt;. Perched on the foothills of Mt. Matutum, the farm offers a stunning panoramic view of the lush greenery and surrounding mountains, making it a perfect getaway for nature lovers and photography enthusiasts.&lt;/p&gt;&lt;h3&gt;🌸 &lt;strong&gt;Key Highlights:&lt;/strong&gt;&lt;/h3&gt;&lt;ul&gt;\r\n&lt;li&gt;\r\n&lt;p&gt;&lt;strong&gt;Flower Gardens:&lt;/strong&gt; SG Farm is famous for its vibrant flower beds featuring a variety of colorful blooms, including sunflowers, celosias, and other ornamental plants. These gardens serve as perfect photo spots, attracting visitors for both leisure and social media-worthy snapshots.&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li&gt;\r\n&lt;p&gt;&lt;strong&gt;Scenic View Decks:&lt;/strong&gt; Multiple viewing decks provide breathtaking views of Mt. Matutum and the surrounding countryside, making it an ideal spot to relax and appreciate nature&rsquo;s beauty.&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li&gt;\r\n&lt;p&gt;&lt;strong&gt;Camping and Glamping Options:&lt;/strong&gt; For those seeking a unique overnight stay, SG Farm offers &lt;strong&gt;camping and glamping&lt;/strong&gt; facilities, allowing visitors to enjoy the cool breeze and stargaze at night.&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li&gt;\r\n&lt;p&gt;&lt;strong&gt;Instagram-Worthy Spots:&lt;/strong&gt; The farm boasts several creative and picturesque installations such as colorful benches, swings, and heart-shaped flower arches that serve as great backdrops for memorable photos.&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li&gt;\r\n&lt;p&gt;&lt;strong&gt;Caf&eacute; and Refreshments:&lt;/strong&gt; A cozy caf&eacute; on-site serves local delicacies and refreshments, allowing guests to enjoy delicious food while taking in the tranquil atmosphere.&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li&gt;\r\n&lt;p&gt;&lt;strong&gt;Events and Gatherings:&lt;/strong&gt; SG Farm is also a great venue for hosting events, such as pre-nuptial shoots, family gatherings, and intimate celebrations.&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;/ul&gt;&lt;h3&gt;📍 &lt;strong&gt;Location and Accessibility:&lt;/strong&gt;&lt;/h3&gt;&lt;ul&gt;\r\n&lt;li&gt;\r\n&lt;p&gt;&lt;strong&gt;Address:&lt;/strong&gt; Glandang Rd, Tupi, South Cotabato, Philippines&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li&gt;\r\n&lt;p&gt;&lt;strong&gt;Access:&lt;/strong&gt; Easily accessible by private vehicle or local transportation from General Santos City or Koronadal City. The farm is approximately 30-40 minutes away from the town proper of Tupi.&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;/ul&gt;&lt;h3&gt;⏰ &lt;strong&gt;Operating Hours:&lt;/strong&gt;&lt;/h3&gt;&lt;ul&gt;\r\n&lt;li&gt;\r\n&lt;p&gt;Typically open daily from &lt;strong&gt;7:00 AM to 6:00 PM&lt;/strong&gt;. Operating hours may vary depending on weather conditions or special events.&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;/ul&gt;&lt;h3&gt;🎟️ &lt;strong&gt;Entrance Fee:&lt;/strong&gt;&lt;/h3&gt;&lt;ul&gt;\r\n&lt;li&gt;\r\n&lt;p&gt;Affordable entrance fee, with discounts available for children and senior citizens. Camping and glamping rates vary depending on the package.&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;/ul&gt;&lt;p&gt;SG Farm is a must-visit destination for anyone looking to unwind, capture beautiful memories, and experience the charm of Tupi&rsquo;s countryside. 🌿✨&lt;/p&gt;', 'uploads/package_9', 1, '2025-04-01 11:32:02', '7:00 AM - 6:00 PM', 'uploads/video_9', NULL),
(10, 'Mariano’s Blooming Agri-Tourism Park', '6.342676, 124.952415\r\nLinan, Tupi, South Cotabato', 'Free entry', '&lt;p data-start=&quot;211&quot; data-end=&quot;672&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;211&quot; data-end=&quot;251&quot;&gt;Mariano&rsquo;s Blooming Agri-Tourism Park&lt;/strong&gt; is a breathtaking floral paradise nestled in &lt;strong data-start=&quot;297&quot; data-end=&quot;321&quot;&gt;Tupi, South Cotabato&lt;/strong&gt;. Spanning &lt;strong data-start=&quot;332&quot; data-end=&quot;347&quot;&gt;13 hectares&lt;/strong&gt;, this vibrant attraction is best known for its &lt;strong data-start=&quot;395&quot; data-end=&quot;483&quot;&gt;expansive sunflower fields, intricate flower mandalas, and diverse botanical gardens&lt;/strong&gt;. Offering a serene escape with scenic views of &lt;strong data-start=&quot;531&quot; data-end=&quot;546&quot;&gt;Mt. Matutum&lt;/strong&gt;, the park is a perfect destination for nature lovers, photography enthusiasts, and families looking for a relaxing getaway.&lt;/p&gt;&lt;h3 data-start=&quot;674&quot; data-end=&quot;702&quot; class=&quot;&quot;&gt;🌸 &lt;strong data-start=&quot;681&quot; data-end=&quot;700&quot;&gt;Key Highlights:&lt;/strong&gt;&lt;/h3&gt;&lt;ul data-start=&quot;704&quot; data-end=&quot;1793&quot;&gt;\r\n&lt;li data-start=&quot;704&quot; data-end=&quot;915&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;706&quot; data-end=&quot;915&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;706&quot; data-end=&quot;744&quot;&gt;Sunflower Fields &amp; Flower Mandalas&lt;/strong&gt; 🌻&lt;br data-start=&quot;747&quot; data-end=&quot;750&quot;&gt;\r\nExperience the beauty of &lt;strong data-start=&quot;777&quot; data-end=&quot;804&quot;&gt;thousands of sunflowers&lt;/strong&gt; in full bloom, along with &lt;strong data-start=&quot;831&quot; data-end=&quot;867&quot;&gt;intricately designed flower beds&lt;/strong&gt; that create a mesmerizing tapestry of colors.&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;917&quot; data-end=&quot;1180&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;919&quot; data-end=&quot;1180&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;919&quot; data-end=&quot;957&quot;&gt;Scenic Viewpoints &amp; Photo Spots 📷&lt;/strong&gt;&lt;br data-start=&quot;957&quot; data-end=&quot;960&quot;&gt;\r\nThe park offers &lt;strong data-start=&quot;978&quot; data-end=&quot;1012&quot;&gt;panoramic views of Mt. Matutum&lt;/strong&gt;, providing stunning backdrops for &lt;strong data-start=&quot;1047&quot; data-end=&quot;1074&quot;&gt;Instagram-worthy photos&lt;/strong&gt;. Don&rsquo;t miss the &lt;strong data-start=&quot;1091&quot; data-end=&quot;1144&quot;&gt;wooden bridges, flower arches, and rustic benches&lt;/strong&gt; scattered throughout the gardens!&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;1182&quot; data-end=&quot;1386&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;1184&quot; data-end=&quot;1386&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;1184&quot; data-end=&quot;1202&quot;&gt;Mirasol Caf&eacute; ☕&lt;/strong&gt;&lt;br data-start=&quot;1202&quot; data-end=&quot;1205&quot;&gt;\r\nEnjoy &lt;strong data-start=&quot;1213&quot; data-end=&quot;1262&quot;&gt;locally inspired dishes and refreshing drinks&lt;/strong&gt; at the park&rsquo;s cozy caf&eacute;. Try their &lt;strong data-start=&quot;1298&quot; data-end=&quot;1328&quot;&gt;butterfly pea flower salad&lt;/strong&gt; or the signature &lt;strong data-start=&quot;1346&quot; data-end=&quot;1383&quot;&gt;chicken binakol served in coconut&lt;/strong&gt;.&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;1388&quot; data-end=&quot;1580&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;1390&quot; data-end=&quot;1580&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;1390&quot; data-end=&quot;1438&quot;&gt;Bird Sanctuary &amp; Eco-Friendly Environment 🦜&lt;/strong&gt;&lt;br data-start=&quot;1438&quot; data-end=&quot;1441&quot;&gt;\r\nAside from its floral attractions, the park also houses a &lt;strong data-start=&quot;1501&quot; data-end=&quot;1519&quot;&gt;bird sanctuary&lt;/strong&gt;, making it a haven for nature conservation and relaxation.&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;1582&quot; data-end=&quot;1793&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;1584&quot; data-end=&quot;1793&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;1584&quot; data-end=&quot;1623&quot;&gt;Perfect for Events &amp; Photoshoots 🎉&lt;/strong&gt;&lt;br data-start=&quot;1623&quot; data-end=&quot;1626&quot;&gt;\r\nThe park is a popular venue for &lt;strong data-start=&quot;1660&quot; data-end=&quot;1718&quot;&gt;pre-nuptial shoots, family outings, and special events&lt;/strong&gt;. Visitors can also rent &lt;strong data-start=&quot;1743&quot; data-end=&quot;1759&quot;&gt;picnic areas&lt;/strong&gt; for a more intimate experience.&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;/ul&gt;&lt;h3 data-start=&quot;1795&quot; data-end=&quot;1833&quot; class=&quot;&quot;&gt;📍 &lt;strong data-start=&quot;1802&quot; data-end=&quot;1831&quot;&gt;Location &amp; Accessibility:&lt;/strong&gt;&lt;/h3&gt;&lt;ul data-start=&quot;1834&quot; data-end=&quot;2202&quot;&gt;\r\n&lt;li data-start=&quot;1834&quot; data-end=&quot;1914&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;1836&quot; data-end=&quot;1914&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;1836&quot; data-end=&quot;1848&quot;&gt;Address:&lt;/strong&gt; Purok 3A, Barangay Poblacion, Tupi, South Cotabato, Philippines&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;1915&quot; data-end=&quot;2202&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;1917&quot; data-end=&quot;1940&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;1917&quot; data-end=&quot;1938&quot;&gt;How to Get There:&lt;/strong&gt;&lt;/p&gt;\r\n&lt;ul data-start=&quot;1943&quot; data-end=&quot;2202&quot;&gt;\r\n&lt;li data-start=&quot;1943&quot; data-end=&quot;2021&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;1945&quot; data-end=&quot;2021&quot; class=&quot;&quot;&gt;From &lt;strong data-start=&quot;1950&quot; data-end=&quot;1968&quot;&gt;Koronadal City&lt;/strong&gt;: 30-minute drive via the &lt;strong data-start=&quot;1994&quot; data-end=&quot;2019&quot;&gt;Tupi National Highway&lt;/strong&gt;&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;2024&quot; data-end=&quot;2098&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;2026&quot; data-end=&quot;2098&quot; class=&quot;&quot;&gt;From &lt;strong data-start=&quot;2031&quot; data-end=&quot;2054&quot;&gt;General Santos City&lt;/strong&gt;: 45-minute drive via &lt;strong data-start=&quot;2076&quot; data-end=&quot;2096&quot;&gt;Digos-Makar Road&lt;/strong&gt;&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;2101&quot; data-end=&quot;2202&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;2103&quot; data-end=&quot;2202&quot; class=&quot;&quot;&gt;Public transport is available from Tupi town proper via &lt;strong data-start=&quot;2159&quot; data-end=&quot;2200&quot;&gt;tricycles or habal-habal (motorbikes)&lt;/strong&gt;&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;/ul&gt;\r\n&lt;/li&gt;\r\n&lt;/ul&gt;&lt;h3 data-start=&quot;2204&quot; data-end=&quot;2232&quot; class=&quot;&quot;&gt;⏰ &lt;strong data-start=&quot;2210&quot; data-end=&quot;2230&quot;&gt;Operating Hours:&lt;/strong&gt;&lt;/h3&gt;&lt;ul data-start=&quot;2233&quot; data-end=&quot;2315&quot;&gt;\r\n&lt;li data-start=&quot;2233&quot; data-end=&quot;2268&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;2235&quot; data-end=&quot;2268&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;2235&quot; data-end=&quot;2248&quot;&gt;Weekdays:&lt;/strong&gt; 7:00 AM &ndash; 5:30 PM&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;2269&quot; data-end=&quot;2315&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;2271&quot; data-end=&quot;2315&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;2271&quot; data-end=&quot;2295&quot;&gt;Weekends &amp; Holidays:&lt;/strong&gt; 7:00 AM &ndash; 6:00 PM&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;/ul&gt;&lt;h3 data-start=&quot;2317&quot; data-end=&quot;2344&quot; class=&quot;&quot;&gt;🎟️ &lt;strong data-start=&quot;2325&quot; data-end=&quot;2342&quot;&gt;Entrance Fee:&lt;/strong&gt;&lt;/h3&gt;&lt;ul data-start=&quot;2345&quot; data-end=&quot;2474&quot;&gt;\r\n&lt;li data-start=&quot;2345&quot; data-end=&quot;2377&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;2347&quot; data-end=&quot;2377&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;2347&quot; data-end=&quot;2360&quot;&gt;Weekdays:&lt;/strong&gt; ₱50 per person&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;2378&quot; data-end=&quot;2421&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;2380&quot; data-end=&quot;2421&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;2380&quot; data-end=&quot;2404&quot;&gt;Weekends &amp; Holidays:&lt;/strong&gt; ₱70 per person&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;2422&quot; data-end=&quot;2474&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;2424&quot; data-end=&quot;2474&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;2424&quot; data-end=&quot;2472&quot;&gt;Discounts available for seniors and children&lt;/strong&gt;&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;/ul&gt;&lt;h3 data-start=&quot;2476&quot; data-end=&quot;2509&quot; class=&quot;&quot;&gt;📞 &lt;strong data-start=&quot;2483&quot; data-end=&quot;2507&quot;&gt;Contact Information:&lt;/strong&gt;&lt;/h3&gt;&lt;ul data-start=&quot;2510&quot; data-end=&quot;2706&quot;&gt;\r\n&lt;li data-start=&quot;2510&quot; data-end=&quot;2541&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;2512&quot; data-end=&quot;2541&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;2512&quot; data-end=&quot;2522&quot;&gt;Phone:&lt;/strong&gt; +63 997 204 2560&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;2542&quot; data-end=&quot;2590&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;2544&quot; data-end=&quot;2590&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;2544&quot; data-end=&quot;2571&quot;&gt;Mirasol Caf&eacute; Inquiries:&lt;/strong&gt; +63 910 547 0020&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;2591&quot; data-end=&quot;2706&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;2593&quot; data-end=&quot;2706&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;2593&quot; data-end=&quot;2606&quot;&gt;Facebook:&lt;/strong&gt; &lt;a data-start=&quot;2607&quot; data-end=&quot;2704&quot; rel=&quot;noopener&quot; target=&quot;_new&quot; class=&quot;&quot; href=&quot;https://www.facebook.com/bloomingagritourismparkofficial/&quot;&gt;Mariano&rsquo;s Blooming Agri-Tourism Park&lt;/a&gt;&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;/ul&gt;&lt;p&gt;🌿 Whether you&rsquo;re looking for a &lt;strong data-start=&quot;2740&quot; data-end=&quot;2809&quot;&gt;relaxing retreat, a romantic getaway, or a fun-filled family trip&lt;/strong&gt;, Mariano&rsquo;s Blooming Agri-Tourism Park promises a &lt;strong data-start=&quot;2859&quot; data-end=&quot;2897&quot;&gt;blooming experience like no other!&lt;/strong&gt; 🌸✨&lt;/p&gt;', 'uploads/package_10', 1, '2025-04-01 16:11:15', '7:00 AM - 6:00 PM', 'uploads/video_10', NULL),
(11, 'Brittannika Golf Course', '6.381255, 124.982023\r\nKipalbig, South Cotabato', 'Paid entry', '&lt;p data-start=&quot;191&quot; data-end=&quot;535&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;191&quot; data-end=&quot;218&quot;&gt;Brittannika Golf Course&lt;/strong&gt;, nestled in the lush greenery of &lt;strong data-start=&quot;252&quot; data-end=&quot;292&quot;&gt;Barangay Linan, Tupi, South Cotabato&lt;/strong&gt;, is a premier destination for golf enthusiasts and nature lovers alike. With its &lt;strong data-start=&quot;374&quot; data-end=&quot;457&quot;&gt;expansive fairways, breathtaking views of Mt. Matutum, and cool highland breeze&lt;/strong&gt;, this golf course offers a &lt;strong data-start=&quot;485&quot; data-end=&quot;532&quot;&gt;relaxing and world-class golfing experience&lt;/strong&gt;.&lt;/p&gt;&lt;h3 data-start=&quot;537&quot; data-end=&quot;564&quot; class=&quot;&quot;&gt;⛳ &lt;strong data-start=&quot;543&quot; data-end=&quot;562&quot;&gt;Key Highlights:&lt;/strong&gt;&lt;/h3&gt;&lt;ul data-start=&quot;566&quot; data-end=&quot;1594&quot;&gt;\r\n&lt;li data-start=&quot;566&quot; data-end=&quot;771&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;568&quot; data-end=&quot;771&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;568&quot; data-end=&quot;604&quot;&gt;Challenging &amp; Scenic Fairways 🌿&lt;/strong&gt;&lt;br data-start=&quot;604&quot; data-end=&quot;607&quot;&gt;\r\nThe golf course boasts &lt;strong data-start=&quot;632&quot; data-end=&quot;690&quot;&gt;well-manicured greens and strategically placed hazards&lt;/strong&gt;, making it a thrilling experience for both &lt;strong data-start=&quot;734&quot; data-end=&quot;768&quot;&gt;beginners and seasoned golfers&lt;/strong&gt;.&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;773&quot; data-end=&quot;981&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;775&quot; data-end=&quot;981&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;775&quot; data-end=&quot;816&quot;&gt;Breathtaking Views of Mt. Matutum 🏔️&lt;/strong&gt;&lt;br data-start=&quot;816&quot; data-end=&quot;819&quot;&gt;\r\nLocated in the foothills of &lt;strong data-start=&quot;849&quot; data-end=&quot;886&quot;&gt;South Cotabato&rsquo;s most iconic peak&lt;/strong&gt;, Brittannika offers a &lt;strong data-start=&quot;909&quot; data-end=&quot;928&quot;&gt;tranquil escape&lt;/strong&gt; with &lt;strong data-start=&quot;934&quot; data-end=&quot;978&quot;&gt;panoramic mountain and countryside views&lt;/strong&gt;.&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;983&quot; data-end=&quot;1218&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;985&quot; data-end=&quot;1218&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;985&quot; data-end=&quot;1011&quot;&gt;Clubhouse &amp; Dining 🍽️&lt;/strong&gt;&lt;br data-start=&quot;1011&quot; data-end=&quot;1014&quot;&gt;\r\nEnjoy &lt;strong data-start=&quot;1022&quot; data-end=&quot;1066&quot;&gt;delicious local and international dishes&lt;/strong&gt; at the clubhouse while overlooking the scenic course. The restaurant serves a &lt;strong data-start=&quot;1145&quot; data-end=&quot;1190&quot;&gt;variety of refreshments and gourmet meals&lt;/strong&gt; for golfers and visitors.&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;1220&quot; data-end=&quot;1413&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;1222&quot; data-end=&quot;1413&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;1222&quot; data-end=&quot;1258&quot;&gt;Driving Range &amp; Golf Lessons 🏌️&lt;/strong&gt;&lt;br data-start=&quot;1258&quot; data-end=&quot;1261&quot;&gt;\r\nWhether you&#039;re a &lt;strong data-start=&quot;1280&quot; data-end=&quot;1324&quot;&gt;beginner or looking to refine your swing&lt;/strong&gt;, Brittannika offers &lt;strong data-start=&quot;1345&quot; data-end=&quot;1410&quot;&gt;professional golf lessons and a well-maintained driving range&lt;/strong&gt;.&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;1415&quot; data-end=&quot;1594&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;1417&quot; data-end=&quot;1594&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;1417&quot; data-end=&quot;1448&quot;&gt;Event &amp; Tournament Venue 🎉&lt;/strong&gt;&lt;br data-start=&quot;1448&quot; data-end=&quot;1451&quot;&gt;\r\nThe golf course is a prime location for &lt;strong data-start=&quot;1493&quot; data-end=&quot;1558&quot;&gt;corporate events, private tournaments, and special gatherings&lt;/strong&gt;, offering full-service amenities.&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;/ul&gt;&lt;h3 data-start=&quot;1596&quot; data-end=&quot;1634&quot; class=&quot;&quot;&gt;📍 &lt;strong data-start=&quot;1603&quot; data-end=&quot;1632&quot;&gt;Location &amp; Accessibility:&lt;/strong&gt;&lt;/h3&gt;&lt;ul data-start=&quot;1635&quot; data-end=&quot;1982&quot;&gt;\r\n&lt;li data-start=&quot;1635&quot; data-end=&quot;1716&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;1637&quot; data-end=&quot;1716&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;1637&quot; data-end=&quot;1649&quot;&gt;Address:&lt;/strong&gt; Purok Pag-asa, Barangay Linan, Tupi, South Cotabato, Philippines&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;1717&quot; data-end=&quot;1982&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;1719&quot; data-end=&quot;1742&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;1719&quot; data-end=&quot;1740&quot;&gt;How to Get There:&lt;/strong&gt;&lt;/p&gt;\r\n&lt;ul data-start=&quot;1745&quot; data-end=&quot;1982&quot;&gt;\r\n&lt;li data-start=&quot;1745&quot; data-end=&quot;1820&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;1747&quot; data-end=&quot;1820&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;1747&quot; data-end=&quot;1771&quot;&gt;From Koronadal City:&lt;/strong&gt; ~40-minute drive via &lt;strong data-start=&quot;1793&quot; data-end=&quot;1818&quot;&gt;Tupi National Highway&lt;/strong&gt;&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;1823&quot; data-end=&quot;1898&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;1825&quot; data-end=&quot;1898&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;1825&quot; data-end=&quot;1854&quot;&gt;From General Santos City:&lt;/strong&gt; ~50-minute drive via &lt;strong data-start=&quot;1876&quot; data-end=&quot;1896&quot;&gt;Digos-Makar Road&lt;/strong&gt;&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;1901&quot; data-end=&quot;1982&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;1903&quot; data-end=&quot;1982&quot; class=&quot;&quot;&gt;Accessible by &lt;strong data-start=&quot;1917&quot; data-end=&quot;1980&quot;&gt;private vehicle, taxis, or motorbike services (habal-habal)&lt;/strong&gt;&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;/ul&gt;\r\n&lt;/li&gt;\r\n&lt;/ul&gt;&lt;h3 data-start=&quot;1984&quot; data-end=&quot;2012&quot; class=&quot;&quot;&gt;⏰ &lt;strong data-start=&quot;1990&quot; data-end=&quot;2010&quot;&gt;Operating Hours:&lt;/strong&gt;&lt;/h3&gt;&lt;ul data-start=&quot;2013&quot; data-end=&quot;2055&quot;&gt;\r\n&lt;li data-start=&quot;2013&quot; data-end=&quot;2055&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;2015&quot; data-end=&quot;2055&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;2015&quot; data-end=&quot;2035&quot;&gt;Monday &ndash; Sunday:&lt;/strong&gt; 6:00 AM &ndash; 6:00 PM&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;/ul&gt;&lt;h3 data-start=&quot;2057&quot; data-end=&quot;2084&quot; class=&quot;&quot;&gt;🎟️ &lt;strong data-start=&quot;2065&quot; data-end=&quot;2082&quot;&gt;Rates &amp; Fees:&lt;/strong&gt;&lt;/h3&gt;&lt;ul data-start=&quot;2085&quot; data-end=&quot;2258&quot;&gt;\r\n&lt;li data-start=&quot;2085&quot; data-end=&quot;2160&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;2087&quot; data-end=&quot;2160&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;2087&quot; data-end=&quot;2102&quot;&gt;Green Fees:&lt;/strong&gt; Vary based on weekdays, weekends, and membership status&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;2161&quot; data-end=&quot;2208&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;2163&quot; data-end=&quot;2208&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;2163&quot; data-end=&quot;2206&quot;&gt;Golf Cart &amp; Equipment Rentals Available&lt;/strong&gt;&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;2209&quot; data-end=&quot;2258&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;2211&quot; data-end=&quot;2258&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;2211&quot; data-end=&quot;2256&quot;&gt;Special Rates for Group Packages &amp; Events&lt;/strong&gt;&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;/ul&gt;&lt;h3 data-start=&quot;2260&quot; data-end=&quot;2293&quot; class=&quot;&quot;&gt;📞 &lt;strong data-start=&quot;2267&quot; data-end=&quot;2291&quot;&gt;Contact Information:&lt;/strong&gt;&lt;/h3&gt;&lt;ul data-start=&quot;2294&quot; data-end=&quot;2461&quot;&gt;\r\n&lt;li data-start=&quot;2294&quot; data-end=&quot;2365&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;2296&quot; data-end=&quot;2365&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;2296&quot; data-end=&quot;2306&quot;&gt;Phone:&lt;/strong&gt; +63 998 456 7890 (For tee time reservations &amp; inquiries)&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;2366&quot; data-end=&quot;2461&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;2368&quot; data-end=&quot;2461&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;2368&quot; data-end=&quot;2381&quot;&gt;Facebook:&lt;/strong&gt; &lt;a data-start=&quot;2382&quot; data-end=&quot;2459&quot; rel=&quot;noopener&quot; target=&quot;_new&quot; class=&quot;&quot; href=&quot;https://www.facebook.com/brittannikagolf/&quot;&gt;Brittannika Golf Course Official&lt;/a&gt;&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;/ul&gt;&lt;p&gt;🌿 Whether you&#039;re looking to &lt;strong data-start=&quot;2492&quot; data-end=&quot;2582&quot;&gt;sharpen your golfing skills, enjoy a relaxing day outdoors, or host an exclusive event&lt;/strong&gt;, Brittannika Golf Course offers an &lt;strong data-start=&quot;2618&quot; data-end=&quot;2658&quot;&gt;elegant and unforgettable experience&lt;/strong&gt; in the heart of &lt;strong data-start=&quot;2675&quot; data-end=&quot;2710&quot;&gt;South Cotabato&rsquo;s natural beauty&lt;/strong&gt;. 🏌️&zwj;♀️✨&lt;/p&gt;', 'uploads/package_11', 1, '2025-04-01 16:33:21', '6:00 AM - 6:00 PM', NULL, NULL),
(12, 'Magsangyaw Land of Praise', '6.394910, 125.035914\r\nMiasong, Tupi, South Cotabato', 'Paid entry', '&lt;p data-start=&quot;169&quot; data-end=&quot;535&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;169&quot; data-end=&quot;198&quot;&gt;Magsangyaw Land of Praise&lt;/strong&gt; is a &lt;strong data-start=&quot;204&quot; data-end=&quot;232&quot;&gt;serene spiritual retreat&lt;/strong&gt; located in the cool highlands of &lt;strong data-start=&quot;266&quot; data-end=&quot;299&quot;&gt;Miasong, Tupi, South Cotabato&lt;/strong&gt;. Nestled at an &lt;strong data-start=&quot;315&quot; data-end=&quot;385&quot;&gt;elevation with breathtaking views of Mt. Matutum and lush greenery&lt;/strong&gt;, this peaceful sanctuary is a popular destination for &lt;strong data-start=&quot;440&quot; data-end=&quot;486&quot;&gt;pilgrims, prayer groups, and nature lovers&lt;/strong&gt; seeking &lt;strong data-start=&quot;495&quot; data-end=&quot;532&quot;&gt;tranquility and spiritual renewal&lt;/strong&gt;.&lt;/p&gt;&lt;h3 data-start=&quot;537&quot; data-end=&quot;564&quot; class=&quot;&quot;&gt;✨ &lt;strong data-start=&quot;543&quot; data-end=&quot;562&quot;&gt;Key Highlights:&lt;/strong&gt;&lt;/h3&gt;&lt;ul data-start=&quot;566&quot; data-end=&quot;1581&quot;&gt;\r\n&lt;li data-start=&quot;566&quot; data-end=&quot;770&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;568&quot; data-end=&quot;770&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;568&quot; data-end=&quot;607&quot;&gt;Scenic Prayer &amp; Meditation Spots 🌿&lt;/strong&gt;&lt;br data-start=&quot;607&quot; data-end=&quot;610&quot;&gt;\r\nThe area features &lt;strong data-start=&quot;630&quot; data-end=&quot;694&quot;&gt;picturesque landscapes, prayer gardens, and open-air chapels&lt;/strong&gt;, providing visitors with a &lt;strong data-start=&quot;722&quot; data-end=&quot;767&quot;&gt;peaceful place for reflection and worship&lt;/strong&gt;.&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;772&quot; data-end=&quot;980&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;774&quot; data-end=&quot;980&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;774&quot; data-end=&quot;817&quot;&gt;Giant Cross &amp; Biblical Installations ✝️&lt;/strong&gt;&lt;br data-start=&quot;817&quot; data-end=&quot;820&quot;&gt;\r\nThe site is adorned with &lt;strong data-start=&quot;847&quot; data-end=&quot;925&quot;&gt;religious symbols, a towering cross, and various Bible-inspired sculptures&lt;/strong&gt;, perfect for &lt;strong data-start=&quot;939&quot; data-end=&quot;977&quot;&gt;pilgrimages and spiritual journeys&lt;/strong&gt;.&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;982&quot; data-end=&quot;1223&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;984&quot; data-end=&quot;1223&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;984&quot; data-end=&quot;1025&quot;&gt;Breathtaking Views of Mt. Matutum 🏔️&lt;/strong&gt;&lt;br data-start=&quot;1025&quot; data-end=&quot;1028&quot;&gt;\r\nPositioned on the slopes of &lt;strong data-start=&quot;1058&quot; data-end=&quot;1073&quot;&gt;Mt. Matutum&lt;/strong&gt;, the location offers &lt;strong data-start=&quot;1095&quot; data-end=&quot;1165&quot;&gt;panoramic views of the mountains, rolling hills, and vast farmland&lt;/strong&gt;, creating a perfect backdrop for prayer and meditation.&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;1225&quot; data-end=&quot;1408&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;1227&quot; data-end=&quot;1408&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;1227&quot; data-end=&quot;1273&quot;&gt;Ideal for Retreats &amp; Worship Gatherings 🙏&lt;/strong&gt;&lt;br data-start=&quot;1273&quot; data-end=&quot;1276&quot;&gt;\r\nMagsangyaw Land of Praise hosts &lt;strong data-start=&quot;1310&quot; data-end=&quot;1356&quot;&gt;retreats, Bible studies, and church events&lt;/strong&gt;, providing a &lt;strong data-start=&quot;1370&quot; data-end=&quot;1405&quot;&gt;spiritual escape from city life&lt;/strong&gt;.&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;1410&quot; data-end=&quot;1581&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;1412&quot; data-end=&quot;1581&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;1412&quot; data-end=&quot;1440&quot;&gt;Hiking &amp; Nature Walks 🚶&lt;/strong&gt;&lt;br data-start=&quot;1440&quot; data-end=&quot;1443&quot;&gt;\r\nVisitors can &lt;strong data-start=&quot;1458&quot; data-end=&quot;1492&quot;&gt;explore the surrounding trails&lt;/strong&gt;, breathe in the &lt;strong data-start=&quot;1509&quot; data-end=&quot;1531&quot;&gt;fresh mountain air&lt;/strong&gt;, and immerse themselves in &lt;strong data-start=&quot;1559&quot; data-end=&quot;1578&quot;&gt;nature&rsquo;s beauty&lt;/strong&gt;.&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;/ul&gt;&lt;h3 data-start=&quot;1583&quot; data-end=&quot;1621&quot; class=&quot;&quot;&gt;📍 &lt;strong data-start=&quot;1590&quot; data-end=&quot;1619&quot;&gt;Location &amp; Accessibility:&lt;/strong&gt;&lt;/h3&gt;&lt;ul data-start=&quot;1622&quot; data-end=&quot;1987&quot;&gt;\r\n&lt;li data-start=&quot;1622&quot; data-end=&quot;1668&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;1624&quot; data-end=&quot;1668&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;1624&quot; data-end=&quot;1636&quot;&gt;Address:&lt;/strong&gt; Miasong, Tupi, South Cotabato&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;1669&quot; data-end=&quot;1714&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;1671&quot; data-end=&quot;1714&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;1671&quot; data-end=&quot;1687&quot;&gt;Coordinates:&lt;/strong&gt; &lt;strong data-start=&quot;1688&quot; data-end=&quot;1712&quot;&gt;6.394814, 125.035&lt;/strong&gt;&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;1715&quot; data-end=&quot;1987&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;1717&quot; data-end=&quot;1740&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;1717&quot; data-end=&quot;1738&quot;&gt;How to Get There:&lt;/strong&gt;&lt;/p&gt;\r\n&lt;ul data-start=&quot;1743&quot; data-end=&quot;1987&quot;&gt;\r\n&lt;li data-start=&quot;1743&quot; data-end=&quot;1811&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;1745&quot; data-end=&quot;1811&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;1745&quot; data-end=&quot;1771&quot;&gt;From Tupi Town Proper:&lt;/strong&gt; ~20-minute drive via &lt;strong data-start=&quot;1793&quot; data-end=&quot;1809&quot;&gt;Miasong Road&lt;/strong&gt;&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;1814&quot; data-end=&quot;1889&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;1816&quot; data-end=&quot;1889&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;1816&quot; data-end=&quot;1840&quot;&gt;From Koronadal City:&lt;/strong&gt; ~40-minute drive via &lt;strong data-start=&quot;1862&quot; data-end=&quot;1887&quot;&gt;Tupi National Highway&lt;/strong&gt;&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;1892&quot; data-end=&quot;1987&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;1894&quot; data-end=&quot;1987&quot; class=&quot;&quot;&gt;Accessible via &lt;strong data-start=&quot;1909&quot; data-end=&quot;1985&quot;&gt;private vehicles, motorbikes (habal-habal), and local transport services&lt;/strong&gt;&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;/ul&gt;\r\n&lt;/li&gt;\r\n&lt;/ul&gt;&lt;h3 data-start=&quot;1989&quot; data-end=&quot;2017&quot; class=&quot;&quot;&gt;⏰ &lt;strong data-start=&quot;1995&quot; data-end=&quot;2015&quot;&gt;Operating Hours:&lt;/strong&gt;&lt;/h3&gt;&lt;ul data-start=&quot;2018&quot; data-end=&quot;2069&quot;&gt;\r\n&lt;li data-start=&quot;2018&quot; data-end=&quot;2069&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;2020&quot; data-end=&quot;2069&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;2020&quot; data-end=&quot;2067&quot;&gt;Typically open daily from 6:00 AM &ndash; 6:00 PM&lt;/strong&gt;&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;/ul&gt;&lt;h3 data-start=&quot;2071&quot; data-end=&quot;2098&quot; class=&quot;&quot;&gt;🎟️ &lt;strong data-start=&quot;2079&quot; data-end=&quot;2096&quot;&gt;Entrance Fee:&lt;/strong&gt;&lt;/h3&gt;&lt;ul data-start=&quot;2099&quot; data-end=&quot;2179&quot;&gt;\r\n&lt;li data-start=&quot;2099&quot; data-end=&quot;2179&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;2101&quot; data-end=&quot;2179&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;2101&quot; data-end=&quot;2118&quot;&gt;Free entrance&lt;/strong&gt; (Donations for maintenance and development are encouraged)&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;/ul&gt;&lt;h3 data-start=&quot;2181&quot; data-end=&quot;2214&quot; class=&quot;&quot;&gt;📞 &lt;strong data-start=&quot;2188&quot; data-end=&quot;2212&quot;&gt;Contact Information:&lt;/strong&gt;&lt;/h3&gt;&lt;ul data-start=&quot;2215&quot; data-end=&quot;2262&quot;&gt;\r\n&lt;li data-start=&quot;2215&quot; data-end=&quot;2262&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;2217&quot; data-end=&quot;2262&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;2217&quot; data-end=&quot;2260&quot;&gt;Local Church or Management Office (TBA)&lt;/strong&gt;&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;/ul&gt;&lt;p&gt;🌿 Whether you&#039;re looking for a &lt;strong data-start=&quot;2296&quot; data-end=&quot;2355&quot;&gt;place to pray, reflect, or simply enjoy nature&rsquo;s beauty&lt;/strong&gt;, Magsangyaw Land of Praise is a &lt;strong data-start=&quot;2388&quot; data-end=&quot;2426&quot;&gt;peaceful and uplifting destination&lt;/strong&gt; in &lt;strong data-start=&quot;2430&quot; data-end=&quot;2454&quot;&gt;Tupi, South Cotabato&lt;/strong&gt;. 🙌✨&lt;/p&gt;', 'uploads/package_12', 1, '2025-04-01 18:02:29', '6:00 AM - 6:00 PM', 'uploads/video_12', NULL),
(14, 'Kolon Cafe', 'Tupi', 'Paid entry', '&lt;p class=&quot;MsoNormal&quot;&gt;Kolon Cafe is a popular coffee shop located within the Kolon\r\nFamily Park in Sitio Kolondatal, Barangay Lampitak, Tampakan, South Cotabato. Renowned\r\nfor its inviting ambiance and delectable offerings, the cafe provides a serene\r\nenvironment for visitors to relax and enjoy a variety of food and beverages.​ &lt;o:p&gt;&lt;/o:p&gt;&lt;/p&gt;&lt;p class=&quot;MsoNormal&quot;&gt;&lt;b&gt;Operating Hours:&lt;/b&gt;&lt;o:p&gt;&lt;/o:p&gt;&lt;/p&gt;&lt;ul style=&quot;margin-top:0cm&quot; type=&quot;disc&quot;&gt;\r\n &lt;li class=&quot;MsoNormal&quot;&gt;Monday\r\n     to Friday: 7:00 AM &ndash; 7:00 PM​ &lt;o:p&gt;&lt;/o:p&gt;&lt;/li&gt;\r\n &lt;li class=&quot;MsoNormal&quot;&gt;Saturday\r\n     and Sunday: 6:00 AM &ndash; 8:00 PM​ &lt;o:p&gt;&lt;/o:p&gt;&lt;/li&gt;\r\n&lt;/ul&gt;&lt;p class=&quot;MsoNormal&quot;&gt;&lt;b&gt;Contact Information:&lt;/b&gt;&lt;o:p&gt;&lt;/o:p&gt;&lt;/p&gt;&lt;ul style=&quot;margin-top:0cm&quot; type=&quot;disc&quot;&gt;\r\n &lt;li class=&quot;MsoNormal&quot;&gt;&lt;b&gt;Phone:&lt;/b&gt;\r\n     0935 755 8410​ &lt;o:p&gt;&lt;/o:p&gt;&lt;/li&gt;\r\n &lt;li class=&quot;MsoNormal&quot;&gt;&lt;b&gt;Location:&lt;/b&gt;\r\n     Sitio Kolondatal, Barangay Lampitak, Tampakan, South Cotabato&lt;o:p&gt;&lt;/o:p&gt;&lt;/li&gt;\r\n&lt;/ul&gt;&lt;p class=&quot;MsoNormal&quot;&gt;Visitors can indulge in a variety of food and beverage\r\noptions, including their signature white espresso frappe, which offers a\r\ndelightful blend of cream and caffeine. The cafe also provides frappes, hot and\r\ncold coffee, tea, mocktails, and cocktails. For more information on their menu\r\nand offerings, you can contact them directly at the provided phone number. &lt;o:p&gt;&lt;/o:p&gt;&lt;/p&gt;&lt;p class=&quot;MsoNormal&quot;&gt;For the latest updates and announcements, you can follow\r\ntheir official Facebook page.&lt;o:p&gt;&lt;/o:p&gt;&lt;/p&gt;&lt;p data-start=&quot;42&quot; data-end=&quot;161&quot; class=&quot;&quot;&gt;\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n&lt;/p&gt;&lt;p class=&quot;MsoNormal&quot;&gt;&lt;o:p&gt;&amp;nbsp;&lt;/o:p&gt;&lt;/p&gt;', 'uploads/package_14', 1, '2025-04-03 22:18:41', NULL, NULL, 'nature_trip,food_trip'),
(15, 'Eden Garden', 'https://www.google.com/maps/search/eden+garden+tupi+south+cotabato/@6.3220045,125.0267335,16.75z?entry=ttu&g_ep=EgoyMDI1MDQwMS4wIKXMDSoASAFQAw%3D%3D', 'Paid entry', '&lt;p class=&quot;MsoNormal&quot;&gt;Eden&#039;s Flower Farm, located in Sitio Lemblesong, Barangay\r\nKablon, Tupi, South Cotabato, is a five-hectare agricultural tourism\r\ndestination renowned for its vibrant flower plantations, particularly Malaysian\r\nmums. The farm has become a significant attraction, drawing visitors with its\r\ncolorful blooms and serene environment. ​ &lt;o:p&gt;&lt;/o:p&gt;&lt;/p&gt;&lt;p class=&quot;MsoNormal&quot;&gt;&lt;b&gt;Operating Hours:&lt;/b&gt;&lt;o:p&gt;&lt;/o:p&gt;&lt;/p&gt;&lt;ul style=&quot;margin-top:0cm&quot; type=&quot;disc&quot;&gt;\r\n &lt;li class=&quot;MsoNormal&quot;&gt;Daily:\r\n     7:00 AM &ndash; 4:00 PM​&lt;o:p&gt;&lt;/o:p&gt;&lt;/li&gt;\r\n&lt;/ul&gt;&lt;p class=&quot;MsoNormal&quot;&gt;&lt;b&gt;Entrance Fees:&lt;/b&gt;&lt;o:p&gt;&lt;/o:p&gt;&lt;/p&gt;&lt;ul style=&quot;margin-top:0cm&quot; type=&quot;disc&quot;&gt;\r\n &lt;li class=&quot;MsoNormal&quot;&gt;Adults:\r\n     ₱80​ &lt;o:p&gt;&lt;/o:p&gt;&lt;/li&gt;\r\n &lt;li class=&quot;MsoNormal&quot;&gt;Children,\r\n     students, PWDs, and senior citizens: ₱60 &lt;o:p&gt;&lt;/o:p&gt;&lt;/li&gt;\r\n&lt;/ul&gt;&lt;p class=&quot;MsoNormal&quot;&gt;&lt;b&gt;Getting There:&lt;/b&gt;&lt;o:p&gt;&lt;/o:p&gt;&lt;/p&gt;&lt;ol style=&quot;margin-top:0cm&quot; start=&quot;1&quot; type=&quot;1&quot;&gt;\r\n &lt;li class=&quot;MsoNormal&quot;&gt;From\r\n     General Santos City, take a bus to Tupi, South Cotabato (fare: ₱35&ndash;₱50).​ &lt;o:p&gt;&lt;/o:p&gt;&lt;/li&gt;\r\n &lt;li class=&quot;MsoNormal&quot;&gt;At\r\n     the Tupi junction, hire a motorcycle (habal-habal) to Eden&#039;s Flower Farm\r\n     (fare: ₱75&ndash;₱100; be prepared for a bumpy ride).​ &lt;o:p&gt;&lt;/o:p&gt;&lt;/li&gt;\r\n&lt;/ol&gt;&lt;p class=&quot;MsoNormal&quot;&gt;The farm is also accessible via a 30-minute ride from\r\nBarangay Kablon&#039;s national highway junction. ​ &lt;o:p&gt;&lt;/o:p&gt;&lt;/p&gt;&lt;p class=&quot;MsoNormal&quot;&gt;&lt;b&gt;Additional Information:&lt;/b&gt;&lt;o:p&gt;&lt;/o:p&gt;&lt;/p&gt;&lt;ul style=&quot;margin-top:0cm&quot; type=&quot;disc&quot;&gt;\r\n &lt;li class=&quot;MsoNormal&quot;&gt;The\r\n     farm features beds of Malaysian mums that typically bloom from October\r\n     20&ndash;29. &lt;o:p&gt;&lt;/o:p&gt;&lt;/li&gt;\r\n &lt;li class=&quot;MsoNormal&quot;&gt;Visitors\r\n     can also enjoy views of strawberry fields and organic vegetable gardens.​&lt;o:p&gt;&lt;/o:p&gt;&lt;/li&gt;\r\n &lt;li class=&quot;MsoNormal&quot;&gt;The\r\n     area provides a cool breeze and a tranquil atmosphere, offering a respite\r\n     from urban life.&lt;o:p&gt;&lt;/o:p&gt;&lt;/li&gt;\r\n&lt;/ul&gt;&lt;p&gt;\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n&lt;/p&gt;&lt;p class=&quot;MsoNormal&quot;&gt;&lt;o:p&gt;&amp;nbsp;&lt;/o:p&gt;&lt;/p&gt;', 'uploads/package_15', 1, '2025-04-03 22:26:29', NULL, 'uploads/video_15', 'food_trip'),
(16, '1231', '123123', 'Paid entry', '&lt;p&gt;123213&lt;/p&gt;', 'uploads/package_16', 0, '2025-05-08 19:20:51', NULL, NULL, '[\"1\"]');

-- --------------------------------------------------------

--
-- Stand-in structure for view `packages`
-- (See below for the actual view)
--
CREATE TABLE `packages` (
`id` int(30)
,`title` text
,`tour_location` text
,`cost` text
,`description` text
,`upload_path` text
,`status` tinyint(4)
,`date_created` datetime
,`opening_hours` varchar(50)
,`upload_path_video` text
,`category` text
);

-- --------------------------------------------------------

--
-- Table structure for table `rate_review`
--

CREATE TABLE `rate_review` (
  `id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  `package_id` int(30) NOT NULL,
  `rate` int(11) NOT NULL,
  `review` text DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rate_review`
--

INSERT INTO `rate_review` (`id`, `user_id`, `package_id`, `rate`, `review`, `date_created`) VALUES
(3, 5, 8, 5, '<p>Sample</p>', '2021-06-19 11:53:16'),
(4, 5, 8, 3, '&lt;p&gt;Sample feedback only&lt;/p&gt;', '2021-06-19 13:49:26'),
(5, 7, 8, 1, '123123', '2025-04-01 10:39:44'),
(6, 7, 1, 5, 'asdfadfasdf', '2025-03-24 18:59:41'),
(7, 7, 7, 3, '1232132', '2025-03-24 14:06:13'),
(8, 7, 9, 5, 'GOOD', '2025-04-01 11:57:31'),
(9, 7, 10, 3, 'wowoow', '2025-04-01 18:12:30'),
(10, 7, 11, 4, 'qwerweqrwer', '2025-04-01 18:17:10'),
(11, 7, 12, 5, '123123', '2025-04-01 18:07:17'),
(12, 8, 14, 2, 'ganda kaya lang iniwan ako dito ni bf :(', '2025-04-03 22:48:57'),
(13, 8, 11, 1, 'maybe next time', '2025-04-03 22:49:25'),
(14, 8, 15, 3, 'ganda ng flowers uwu', '2025-04-03 22:49:45'),
(15, 8, 12, 4, 'amen', '2025-04-03 22:50:03'),
(16, 9, 10, 3, 'i love pacs', '2025-04-03 22:51:04'),
(17, 9, 15, 3, 'i love pacs', '2025-04-03 22:51:21'),
(18, 9, 9, 4, 'sheshh', '2025-04-03 22:51:38'),
(19, 16, 15, 5, 'asdsad', '2025-04-28 19:01:11'),
(20, 16, 14, 5, 'asdasd', '2025-04-28 18:46:05');

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Tourism Information System'),
(6, 'short_name', 'TIS'),
(11, 'logo', 'uploads/1745391660_1743691140_front1.jpg'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', '[\"uploads/cover_images/1746537711_398640099_776028351202353_6841978112704626498_n.jpg\",\"uploads/cover_images/1746537711_419921981_955051449584026_3310436042739467771_n.jpg\",\"uploads/cover_images/1746537711_420125931_955055406250297_7864482662842525749_n (1).jpg\",\"uploads/cover_images/1746537711_420125931_955055406250297_7864482662842525749_n.jpg\",\"uploads/cover_images/1746537711_420135668_955053999583771_7436638160770910822_n (1).jpg\",\"uploads/cover_images/1746537711_420135668_955053999583771_7436638160770910822_n.jpg\",\"uploads/cover_images/1746537711_420136010_955054329583738_7530932165295826827_n (1).jpg\",\"uploads/cover_images/1746537711_420136010_955054329583738_7530932165295826827_n.jpg\",\"uploads/cover_images/1746537711_420136058_955053666250471_124512527954455206_n (1).jpg\",\"uploads/cover_images/1746537711_420136058_955053666250471_124512527954455206_n.jpg\"]'),
(15, 'policy', '                                &lt;h3&gt;&lt;strong&gt;Tupi Local Laws and Regulations&lt;/strong&gt;&lt;/h3&gt;\n&lt;p&gt;Tupi, a vibrant town nestled in the heart of South Cotabato, has laws and regulations in place to ensure the safety, well-being, and harmonious living of its residents and visitors. The local government of Tupi is committed to preserving its natural beauty, agricultural growth, and cultural heritage while maintaining peace and order.&lt;/p&gt;\n&lt;ul&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Environmental Protection&lt;/strong&gt;: The community emphasizes environmental conservation, ensuring that the natural beauty of Tupi, from its fertile soils to its rich flora, is preserved for future generations. Visitors should respect local flora and fauna, including the abundant flowers and fruits grown in the area, and avoid littering in natural spaces.&lt;/p&gt;\n&lt;/li&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Agricultural Regulations&lt;/strong&gt;: As Tupi is a major agricultural hub, visitors are encouraged to respect farming lands. Activities like hiking and exploring should be done with care to avoid damaging crops or property. Local farms also regulate the use of pesticides and fertilizers to maintain the health of the land.&lt;/p&gt;\n&lt;/li&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Respect for Indigenous Cultures&lt;/strong&gt;: Tupi is home to indigenous groups, including the Blaan tribe, whose cultural practices should be respected. Visitors should refrain from engaging in activities that disrespect or harm the local communities&#039; traditions.&lt;/p&gt;\n&lt;/li&gt;\n&lt;/ul&gt;\n&lt;h3&gt;&lt;strong&gt;Emergency Contacts in Tupi&lt;/strong&gt;&lt;/h3&gt;\n&lt;p&gt;In case of any emergency, it is essential to have the right contacts available to ensure swift assistance:&lt;/p&gt;\n&lt;ul&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Police&lt;/strong&gt;: 911&lt;/p&gt;\n&lt;/li&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Medical Emergency&lt;/strong&gt;: 112&lt;/p&gt;\n&lt;/li&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Fire Department&lt;/strong&gt;: 911&lt;/p&gt;\n&lt;/li&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Local Government Office&lt;/strong&gt;: (083) 226-2800&lt;/p&gt;\n&lt;/li&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Barangay Poblacion&lt;/strong&gt;: For local concerns and immediate assistance, you can contact the nearest barangay office.&lt;/p&gt;\n&lt;/li&gt;\n&lt;/ul&gt;\n&lt;h3&gt;&lt;strong&gt;Dos and Don&rsquo;ts in Tupi&lt;/strong&gt;&lt;/h3&gt;\n&lt;p&gt;When visiting Tupi, it&#039;s essential to adhere to the following dos and don&#039;ts to maintain a respectful and safe experience:&lt;/p&gt;\n&lt;h4&gt;&lt;strong&gt;Dos&lt;/strong&gt;:&lt;/h4&gt;\n&lt;ul&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Respect Local Customs&lt;/strong&gt;: Follow local customs and practices, especially when interacting with indigenous communities like the Blaan tribe.&lt;/p&gt;\n&lt;/li&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Support Local Farmers&lt;/strong&gt;: If visiting farms, be sure to support local businesses by purchasing their fresh produce or products.&lt;/p&gt;\n&lt;/li&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Observe Environmental Etiquette&lt;/strong&gt;: Dispose of trash responsibly and refrain from disturbing the natural environment, including plants and wildlife.&lt;/p&gt;\n&lt;/li&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Use Local Services&lt;/strong&gt;: Engage with local businesses, eateries, and guides to promote sustainable tourism and support the local economy.&lt;/p&gt;\n&lt;/li&gt;\n&lt;/ul&gt;\n&lt;h4&gt;&lt;strong&gt;Don&rsquo;ts&lt;/strong&gt;:&lt;/h4&gt;\n&lt;ul&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Don&rsquo;t Litter&lt;/strong&gt;: Keep Tupi clean by disposing of waste properly, particularly in agricultural and natural areas.&lt;/p&gt;\n&lt;/li&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Don&rsquo;t Disturb Wildlife&lt;/strong&gt;: Avoid disturbing or harming animals, especially in protected areas like the Linan Tarsier Sanctuary.&lt;/p&gt;\n&lt;/li&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Don&rsquo;t Engage in Illegal Activities&lt;/strong&gt;: Abide by local laws, including regulations about farming, fishing, and hunting in protected areas.&lt;/p&gt;\n&lt;/li&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Don&rsquo;t Ignore Local Guidelines&lt;/strong&gt;: Always follow safety guidelines provided by local authorities, especially when hiking or participating in adventure activities.&lt;/p&gt;\n&lt;/li&gt;\n&lt;/ul&gt;\n&lt;h3&gt;&lt;strong&gt;Safety Tips for Tourists in Tupi&lt;/strong&gt;&lt;/h3&gt;\n&lt;p&gt;To ensure a safe and enjoyable visit, follow these essential safety tips:&lt;/p&gt;\n&lt;ul&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Stay Aware of Your Surroundings&lt;/strong&gt;: Tupi is generally a safe destination, but it&#039;s always best to stay alert, especially when exploring remote areas.&lt;/p&gt;\n&lt;/li&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Secure Personal Belongings&lt;/strong&gt;: Keep personal items like wallets, phones, and cameras secure, especially in crowded or tourist-heavy areas.&lt;/p&gt;\n&lt;/li&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Follow Local Guidance&lt;/strong&gt;: Always listen to local authorities or tour guides, especially in areas where there may be hazards or unfamiliar terrain, such as hiking Mount Matutum.&lt;/p&gt;\n&lt;/li&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Be Prepared for the Weather&lt;/strong&gt;: Tupi&rsquo;s cool climate is a major attraction, but visitors should bring appropriate clothing for varying weather conditions, including rain gear during the wet season.&lt;/p&gt;\n&lt;/li&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Know Your Route&lt;/strong&gt;: When traveling to remote attractions like the Linan Tarsier Sanctuary or Kablon Farms, make sure you have reliable transportation or a guide.&lt;/p&gt;\n&lt;/li&gt;\n&lt;/ul&gt;\n&lt;p&gt;By following these local laws, safety tips, and respecting Tupi&rsquo;s rich heritage, you can enjoy an unforgettable experience in this beautiful municipality of South Cotabato.&lt;/p&gt;                ');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `preference` text DEFAULT NULL COMMENT 'JSON array of category IDs'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`, `preference`) VALUES
(1, 'Adminstrator', 'Admin', 'admin', '0192023a7bbd73250516f069df18b500', 'uploads/1743691140_front1.jpg', NULL, 1, '2021-01-20 14:02:37', '2025-04-03 22:39:13', NULL),
(4, 'John', 'Smith', 'jsmith', '1254737c076cf867dc53d60a0364f38e', NULL, NULL, 0, '2021-06-19 08:36:09', '2021-06-19 10:53:12', NULL),
(5, 'Claire', 'Blake', 'cblake', '4744ddea876b11dcb1d169fadf494418', NULL, NULL, 0, '2021-06-19 10:01:51', '2021-06-19 12:03:23', NULL),
(6, 'rey', 'nedruda', 'nedruda101', 'd2b3ea2dfddc40efdc6941359436c847', NULL, NULL, 0, '2025-03-17 13:02:17', NULL, NULL),
(7, 'rey', 'rey', 'rey', 'd2b3ea2dfddc40efdc6941359436c847', NULL, NULL, 0, '2025-03-24 10:03:25', '2025-05-08 20:28:30', 'nature_trip,hiking'),
(8, 'Pacle', 'Weak', 'pacs', '827ccb0eea8a706c4c34a16891f84e7b', NULL, NULL, 0, '2025-04-03 22:48:23', NULL, NULL),
(9, 'Gab', 'Binayot', 'gabs', '827ccb0eea8a706c4c34a16891f84e7b', NULL, NULL, 0, '2025-04-03 22:50:26', NULL, NULL),
(16, 'rey12', 'rey12', 'rey12', 'd993c387a72030f60d9609c2e0484455', NULL, NULL, 0, '2025-04-23 12:34:44', '2025-04-29 07:07:23', 'nature_trip'),
(17, 'melvin', 'pacle', 'melvin1', '43e394930dbc59859df2c75e786bf156', NULL, NULL, 0, '2025-04-29 14:27:40', NULL, 'hiking'),
(18, 'rey13', 'rey13', 'rey13', 'f38563ca6c3ca7cd20667a0e714f35af', NULL, NULL, 0, '2025-04-30 17:48:57', NULL, 'nature_trip,food_trip'),
(19, '123', '123', '123', '81dc9bdb52d04dc20036dbd8313ed055', NULL, NULL, 0, '2025-05-08 20:15:37', '2025-05-08 20:18:52', ''),
(20, '111', '111', '111', '698d51a19d8a121ce581499d7b701668', NULL, NULL, 0, '2025-05-08 21:00:33', '2025-05-08 21:28:57', 'hiking');

-- --------------------------------------------------------

--
-- Structure for view `packages`
--
DROP TABLE IF EXISTS `packages`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `packages`  AS SELECT `location`.`id` AS `id`, `location`.`title` AS `title`, `location`.`tour_location` AS `tour_location`, `location`.`cost` AS `cost`, `location`.`description` AS `description`, `location`.`upload_path` AS `upload_path`, `location`.`status` AS `status`, `location`.`date_created` AS `date_created`, `location`.`opening_hours` AS `opening_hours`, `location`.`upload_path_video` AS `upload_path_video`, `location`.`category` AS `category` FROM `location` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emergency_contacts`
--
ALTER TABLE `emergency_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inquiry`
--
ALTER TABLE `inquiry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rate_review`
--
ALTER TABLE `rate_review`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `emergency_contacts`
--
ALTER TABLE `emergency_contacts`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `inquiry`
--
ALTER TABLE `inquiry`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `rate_review`
--
ALTER TABLE `rate_review`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

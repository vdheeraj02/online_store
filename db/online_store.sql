-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2025 at 08:15 AM
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
-- Database: `online_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`) VALUES
(54, 2, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(120) DEFAULT NULL,
  `province` varchar(50) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `first_name`, `last_name`, `email`, `address`, `city`, `province`, `postal_code`, `total_price`, `order_date`) VALUES
(1, 1, '', '', '', NULL, NULL, NULL, NULL, 509.97, '2025-11-23 22:47:44'),
(2, 1, '', '', '', NULL, NULL, NULL, NULL, 699.98, '2025-11-24 09:40:34'),
(3, 1, 'Dheeraj', 'Verma', 'dhverma@algomau.ca', '64 Glenvale Blvd', 'Brampton', 'ON', 'L6S 1J2', 1599.99, '2025-11-30 09:55:41'),
(4, 1, 'Dheeraj', 'Verma', 'dhverma@algomau.ca', '64 Glenvale Blvd', 'Brampton', 'ON', 'L6S 1J2', 1599.99, '2025-11-30 10:07:43'),
(5, 1, 'Dheeraj', 'Verma', 'dhverma@algomau.ca', '64 Glenvale Blvd', 'Brampton', 'ON', 'L6S 1J2', 1599.99, '2025-11-30 10:14:02'),
(6, 1, '', '', '', NULL, NULL, NULL, NULL, 349.99, '2025-11-30 10:16:59'),
(7, 1, 'Dheeraj', 'Verma', 'dhverma@algomau.ca', '64 Glenvale Blvd', 'Brampton', 'ON', 'L6S 1J2', 349.99, '2025-11-30 10:58:57'),
(8, 1, 'Dheeraj', 'Verma', 'dhverma@algomau.ca', '64 Glenvale Blvd', 'Brampton', 'ON', 'L6S 1J2', 89.99, '2025-11-30 11:01:08'),
(9, 1, 'Dheeraj', 'Verma', 'dhverma@algomau.ca', '64 Glenvale Blvd', 'Brampton', 'ON', 'L6S 1J2', 1.99, '2025-11-30 11:33:39'),
(10, 1, 'Dheeraj', 'Verma', 'dhverma@algomau.ca', '64 Glenvale Blvd', 'Brampton', 'ON', 'L6S 1J2', 1.99, '2025-11-30 11:48:17'),
(11, 1, 'Dheeraj', 'Verma', 'dhverma@algomau.ca', '64 Glenvale Blvd', 'Brampton', 'ON', 'L6S 1J2', 349.99, '2025-11-30 11:49:26'),
(12, 1, 'Dheeraj', 'Verma', 'dhverma@algomau.ca', '64 Glenvale Blvd', 'Brampton', 'ON', 'L6S 1J2', 349.99, '2025-11-30 11:53:40'),
(13, 2, 'Fatal', 'Destiny', 'fatal.destiny6666@gmail.com', '64 Glenvale Blvd', 'Brampton', 'ON', 'L6S 1J2', 549.99, '2025-11-30 11:56:58'),
(14, 1, 'Dheeraj', 'Verma', 'dhverma@algomau.ca', '64 Glenvale Blvd', 'Brampton', 'ON', 'L6S 1J2', 349.99, '2025-11-30 23:10:59'),
(15, 1, 'Dheeraj', 'Verma', 'dhverma@algomau.ca', '64 Glenvale Blvd', 'Brampton', 'ON', 'L6S 1J2', 89.99, '2025-11-30 23:27:04'),
(16, 1, 'Dheeraj', 'Verma', 'dhverma@algomau.ca', '64 Glenvale Blvd', 'Brampton', 'ON', 'L6S 1J2', 349.99, '2025-11-30 23:38:54'),
(17, 1, 'Dheeraj', 'Verma', 'dhverma@algomau.ca', '64 Glenvale Blvd', 'Brampton', 'ON', 'L6S 1J2', 349.99, '2025-12-01 14:20:32'),
(18, 1, 'Dheeraj', 'Verma', 'dhverma@algomau.ca', '64 Glenvale Blvd', 'Brampton', 'ON', 'L6S 1J2', 349.99, '2025-12-01 14:33:15'),
(19, 1, 'Dheeraj', 'Verma', 'dhverma@algomau.ca', '64 Glenvale Blvd', 'Brampton', 'ON', 'L6S 1J2', 89.99, '2025-12-01 17:43:25'),
(20, 1, 'Dheeraj', 'Verma', 'dhverma@algomau.ca', '62 Glenvale Blvd', 'Brampton', 'ON', 'L6S 1J2', 279.99, '2025-12-01 18:25:34'),
(21, 1, 'Dheeraj', 'Verma', 'dhverma@algomau.ca', '64 Glenvale Blvd', 'Brampton', 'ON', 'L6S 1J2', 349.99, '2025-12-02 10:48:56'),
(22, 1, 'Dheeraj', 'Verma', 'dhverma@algomau.ca', '64 Glenvale Blvd', 'Brampton', 'ON', 'L6S 1J2', 269.99, '2025-12-04 05:21:09'),
(23, 1, 'Dheeraj', 'Verma', 'dhverma@algomau.ca', '64 Glenvale Blvd', 'Brampton', 'ON', 'L6S 1J2', 279.99, '2025-12-04 07:10:07');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price_each` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price_each`) VALUES
(1, 1, 11, 3, 169.99),
(2, 2, 1, 2, 349.99),
(3, 6, 1, 1, 349.99),
(4, 7, 1, 1, 349.99),
(5, 8, 41, 1, 89.99),
(6, 9, 41, 1, 1.99),
(7, 10, 41, 1, 1.99),
(8, 11, 1, 1, 349.99),
(9, 12, 1, 1, 349.99),
(10, 13, 4, 1, 549.99),
(11, 14, 1, 1, 349.99),
(12, 15, 41, 1, 89.99),
(13, 16, 1, 1, 349.99),
(14, 17, 1, 1, 349.99),
(15, 18, 1, 1, 349.99),
(16, 19, 41, 1, 89.99),
(17, 20, 2, 1, 279.99),
(18, 21, 1, 1, 349.99),
(19, 22, 22, 1, 269.99),
(20, 23, 2, 1, 279.99);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `stock` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image_url`, `category`, `stock`) VALUES
(1, 'Z790 AORUS ELITE AX', 'The Z790 AORUS ELITE AX is engineered for high-end Intel 13th/14th Gen performance, offering a premium platform for gamers and creators.  \r\nIt features advanced DDR5 memory support along with PCIe 5.0 for next-generation GPU and SSD performance.  \r\nThe 16+1+2 Twin Digital VRM design delivers exceptional power stability during heavy workloads and overclocking.  \r\nIntegrated Wi-Fi 6E and 2.5GbE LAN ensure ultra-fast, low-latency connectivity for competitive gaming.  \r\nThe board includes reinforced PCIe slots, enlarged heatsinks, and M.2 thermal guards for optimal cooling.  \r\nQ-Flash Plus allows easy BIOS updates without a CPU or RAM installed.  \r\nWith RGB Fusion and customizable lighting zones, it brings both style and performance to any build.  \r\nA true enthusiast motherboard built for smooth, reliable, long-term operation.', 349.99, 'img/products/z790-aorus-elite-ax.jpg', 'Motherboards', 6),
(2, 'B650 AORUS ELITE AX', '\r\nThe B650 AORUS ELITE AX brings powerful AM5 performance with full support for Ryzen 7000 series processors.  \r\nIts PCIe 5.0 M.2 slot delivers lightning-fast storage speeds ideal for gaming and productivity.  \r\nFeaturing robust VRM power delivery, it maintains stability during extended heavy workloads.  \r\nWi-Fi 6E and 2.5GbE LAN provide next-generation wireless and wired connectivity.  \r\nAdvanced thermal design and heatsinks ensure sustained performance under pressure.  \r\nSupport for DDR5 memory unlocks higher bandwidth and improved responsiveness.  \r\nEZ-Latch design allows quick SSD and GPU installation without tools.  \r\nA well-balanced motherboard offering premium features at an excellent value.', 279.99, 'img/products/b650-aorus-elite-ax.jpg', 'Motherboards', 10),
(3, 'GeForce RTX 4070 GAMING OC 12G', '\r\nThe GeForce RTX 4070 GAMING OC 12G delivers exceptional 1440p and solid 4K performance powered by NVIDIA Ada Lovelace.  \r\nWINDFORCE cooling with triple fans ensures low temperatures and quiet operation during heavy gaming.  \r\n12GB of GDDR6X memory provides smooth performance in demanding games and creative applications.  \r\nWith DLSS 3 and advanced ray tracing, visuals become more detailed and immersive.  \r\nA factory overclock boosts performance right out of the box.  \r\nDual BIOS allows users to choose between performance and silent modes.  \r\nMetal backplate adds durability and improves heat dissipation.  \r\nPerfect for gamers seeking high-end performance with excellent efficiency.', 799.99, 'img/products/rtx4070-gaming-oc-12g.jpg', 'Graphic Cards', 8),
(4, 'GeForce RTX 4060 Ti EAGLE OC 8G', '\r\nThe RTX 4060 Ti EAGLE OC 8G offers excellent 1080p and 1440p gaming performance with impressive efficiency.  \r\nIts compact dual-fan WINDFORCE cooling keeps temperatures stable even in smaller PC cases.  \r\nThe card features the latest Ada architecture for enhanced ray tracing and DLSS 3 acceleration.  \r\nFactory overclocking adds extra speed for competitive gaming.  \r\nA sturdy backplate prevents PCB bending and helps dissipate heat.  \r\nHDMI 2.1 and DisplayPort 1.4a outputs support high refresh-rate monitors.  \r\nLow power consumption makes it ideal for mid-range gaming builds.  \r\nA reliable and efficient GPU for smooth, modern gaming.', 549.99, 'img/products/rtx4060ti-eagle-oc-8g.jpg', 'Graphic Cards', 14),
(5, 'AORUS 15X Gaming Laptop', '\r\nThe AORUS 15X is a high-performance gaming laptop powered by Intel Core i7/i9 processors and NVIDIA RTX graphics.  \r\nIts 15.6-inch high refresh-rate display delivers smooth visuals for competitive play.  \r\nWINDFORCE Infinity cooling ensures stable performance during long gaming sessions.  \r\nThe laptop features advanced AI-powered graphics enhancements including DLSS 3.  \r\nRGB Fusion keyboard customization allows full personalization of your setup.  \r\nLarge battery capacity provides extended usage for work or entertainment.  \r\nHigh-speed PCIe SSD storage ensures fast boot times and quick load speeds.  \r\nA premium gaming machine built for portability and extreme performance.', 2299.99, 'img/products/aorus-15x.jpg', 'Laptop', 5),
(6, 'GIGABYTE G5 Gaming Laptop', '\r\nThe GIGABYTE G5 is designed for gamers seeking strong performance at an accessible price.  \r\nEquipped with Intel processors and RTX GPUs, it handles modern games with ease.  \r\nIts Full HD high refresh-rate display provides smooth, immersive gameplay.  \r\nWINDFORCE cooling ensures quiet and efficient thermal management.  \r\nThe laptop supports dual M.2 SSDs for fast storage expansion.  \r\nRGB backlit keyboard improves visibility and adds style to your setup.  \r\nLightweight design makes it ideal for travel and daily use.  \r\nA solid balance of gaming power and portability for all users.', 1499.99, 'img/products/gigabyte-g5.jpg', 'Laptop', 7),
(7, 'GIGABYTE M27Q 27\" QHD 170Hz', '\r\nThe GIGABYTE M27Q offers a 27-inch QHD IPS panel with exceptional color accuracy and clarity.  \r\nIts 170Hz refresh rate and 0.5ms response time deliver ultra-smooth gaming performance.  \r\nThe monitor supports HDR, FreeSync Premium, and Adaptive Sync for tear-free visuals.  \r\nKVM functionality allows control of multiple devices with a single keyboard and mouse.  \r\nThe wide color gamut provides stunning accuracy for both gaming and creative work.  \r\nBuilt-in gaming features include crosshair, timer, and aim stabilizer tools.  \r\nErgonomic stand allows tilt adjustments for comfortable viewing.  \r\nA top-tier value monitor for competitive gamers and professionals.', 399.99, 'img/products/m27q.jpg', 'Monitor', 9),
(8, 'GIGABYTE G34WQC 34\" Ultrawide', '\r\nThe G34WQC is a 34-inch curved ultrawide VA gaming monitor with immersive 144Hz performance.  \r\nIts 1500R curvature enhances field of view for gaming and productivity.  \r\nUltra-wide QHD resolution provides sharp visuals and excellent multitasking space.  \r\nFreeSync Premium ensures smooth gameplay with no tearing or stuttering.  \r\nHigh contrast ratio delivers deeper blacks and vivid colors.  \r\nErgonomic stand allows tilt and height adjustments for comfort.  \r\nLow blue light and flicker-free technology reduce eye strain over long sessions.  \r\nA highly immersive display ideal for racing, FPS, and cinematic gaming experiences.', 549.99, 'img/products/g34wqc.jpg', 'Monitor', 6),
(9, 'AORUS Model X Gaming Desktop', '\r\nThe AORUS Model X Gaming Desktop is a premium prebuilt system engineered for extreme gaming.  \r\nFeaturing RTX graphics and powerful Intel/AMD CPUs, it handles 4K gaming with ease.  \r\nWINDFORCE cooling ensures sustained top-tier performance under heavy load.  \r\nHigh-speed DDR5 memory enables faster responsiveness across applications.  \r\nNVMe SSD storage ensures rapid boot and load times for large games.  \r\nA sleek chassis design with RGB lighting enhances the gaming setup.  \r\nQuiet operation and optimized airflow provide an ideal gaming environment.  \r\nA complete high-end PC solution built for enthusiasts and professionals.', 2999.99, 'img/products/aorus-model-x.jpg', 'Desktop', 3),
(10, 'GIGABYTE AERO Creator Desktop', '\r\nThe GIGABYTE AERO Creator Desktop is optimized for content creators, designers, and 3D artists.  \r\nPowered by high-end CPUs and RTX GPUs, it delivers exceptional rendering and editing performance.  \r\nIts quiet and efficient cooling system ensures stable long-duration workloads.  \r\nHigh-speed storage and DDR5 memory support smooth multitasking.  \r\nThunderbolt connectivity offers fast transfer speeds for creative assets.  \r\nProfessional design with customizable lighting suits both office and studio environments.  \r\nIdeal for Adobe, Blender, DaVinci, and other creative suites.  \r\nA workstation-class machine built for creativity without compromise.', 2599.99, 'img/products/aero-creator-desktop.jpg', 'Desktop', 4),
(11, 'GIGABYTE P850GM PSU', '\r\nThe GIGABYTE P850GM is an 850W fully modular power supply built for high-end gaming systems.  \r\nIt features an 80+ Gold certification, ensuring high energy efficiency under various loads.  \r\nPremium Japanese capacitors enhance reliability and overall stability during long gaming sessions.  \r\nThe hydraulic bearing fan keeps noise levels low while maintaining excellent cooling performance.  \r\nFully modular cables improve airflow and make cable management easier inside the case.  \r\nOver-voltage, under-voltage, and short-circuit protection keep your components safe.  \r\nCompact dimensions allow compatibility with a wide range of PC cases.  \r\nA dependable PSU designed for performance, safety, and longevity.', 119.99, 'img/products/ud850gm.jpg', 'PC Components', 17),
(12, 'AORUS RGB DDR5 32GB (2x16GB) 6000MHz', '\r\nAORUS RGB DDR5 32GB memory delivers cutting-edge performance for modern gaming and content creation systems.  \r\nWith speeds up to 6000MHz, it offers faster responsiveness and improved multitasking capability.  \r\nThe advanced heat spreader ensures efficient cooling even under heavy workloads.  \r\nBeautiful RGB lighting can be synchronized with motherboard lighting through RGB Fusion.  \r\nThe optimized power management architecture enhances stability and data integrity.  \r\nHigh-quality ICs ensure consistent overclocking potential and long-term performance.  \r\nPlug-and-play compatibility makes installation simple and hassle-free.  \r\nPremium DDR5 memory designed for speed, style, and reliability.', 219.99, 'img/products/aorus-rgb-ddr5-32gb.jpg', 'PC Components', 20),
(13, 'X870 AORUS ELITE WIFI7', '\r\nThe X870 AORUS ELITE WIFI7 is a next-gen AM5 motherboard built for extreme performance and connectivity.  \r\nWith WiFi 7 and 2.5GbE LAN, it provides some of the fastest wireless and wired speeds available.  \r\nIts enhanced VRM design ensures stable power delivery to high-end Ryzen processors.  \r\nPCIe 5.0 GPU and SSD support future-proof your system for upcoming hardware generations.  \r\nLarge heatsinks and efficient thermal pads keep temperatures low during heavy tasks.  \r\nDDR5 support enables high-frequency memory performance for advanced workloads.  \r\nQ-Flash Plus allows BIOS updates without CPU or RAM installation.  \r\nA top-tier board for gamers, overclockers, and creators.', 349.99, 'img/products/mb_x870_elite.jpg', 'Motherboards', 20),
(14, 'X670 AORUS MASTER', '\r\nThe X670 AORUS MASTER is a premium AM5 motherboard engineered for advanced users and professionals.  \r\nIt features a strong VRM system designed for extreme Ryzen overclocking and stability.  \r\nPCIe 5.0 connectivity allows high-speed GPUs and storage devices for next-gen performance.  \r\nThe massive thermal armor and heatsink layout keep critical components cool.  \r\nDual BIOS provides added safety during firmware updates or tuning.  \r\nIntegrated Wi-Fi 6E and 2.5GbE LAN deliver fast and stable networking.  \r\nHigh-quality audio components ensure clear, immersive sound for entertainment.  \r\nA flagship motherboard built for power, innovation, and durability.', 499.99, 'img/products/mb_x670_master.jpg', 'Motherboards', 10),
(15, 'B760 GAMING X AX', '\r\nThe B760 GAMING X AX provides a balanced feature set for Intel gaming builds.  \r\nEquipped with PCIe 4.0 and fast M.2 support, it ensures quick load times and smooth performance.  \r\nRobust VRM and upgraded cooling maintain consistent CPU stability under load.  \r\nWi-Fi 6E and 2.5GbE LAN offer reliable high-speed networking for gaming and streaming.  \r\nAdvanced audio capacitors enhance sound output for immersive gameplay.  \r\nQ-Flash Plus enables BIOS updates without installing a CPU.  \r\nMulti-zone RGB Fusion lighting brings customization to any setup.  \r\nPerfect for mid-range gaming and everyday performance builds.', 189.99, 'img/products/mb_b760_gamingx.jpg', 'Motherboards', 30),
(16, 'Z890 AORUS XTREME', '\r\nThe Z890 AORUS XTREME stands at the top of Intel enthusiast motherboards with unmatched build quality.  \r\nIts premium VRM design supports extreme overclocking and high-performance processors.  \r\nPCIe 5.0 support ensures compatibility with the latest GPUs and storage technologies.  \r\nTriple M.2 thermal armor provides improved cooling for high-speed NVMe SSDs.  \r\nIntegrated Wi-Fi 7 and high-bandwidth LAN deliver next-level connectivity.  \r\nHigh-end DAC components offer studio-quality, low-noise audio output.  \r\nReinforced metal shielding ensures long-term durability and stability.  \r\nA dream motherboard for elite gaming rigs and professional workstations.', 799.99, 'img/products/mb_z890_xtreme.jpg', 'Motherboards', 5),
(17, 'GeForce RTX 4090 AORUS MASTER', '\r\nThe RTX 4090 AORUS MASTER represents the pinnacle of gaming GPU performance with the Ada Lovelace architecture.  \r\nWINDFORCE cooling with vapor chamber technology ensures exceptional thermal control.  \r\nIts triple-fan design keeps noise low while handling massive gaming and rendering loads.  \r\nAdvanced ray tracing and DLSS 3 deliver incredibly realistic visuals and high frame rates.  \r\nThe massive 24GB GDDR6X memory ensures unmatched performance in 4K and 8K content.  \r\nDual BIOS allows switching between performance and silent modes on the fly.  \r\nRGB lighting and premium materials give the card a bold, powerful aesthetic.  \r\nThe ultimate choice for extreme gaming and professional 3D workloads.', 2299.99, 'img/products/gpu_4090_master.jpg', 'Graphic Cards', 10),
(18, 'GeForce RTX 4080 SUPER GAMING OC', '\r\nThe RTX 4080 SUPER GAMING OC provides top-tier 4K gaming performance with enhanced efficiency.  \r\nWINDFORCE cooling technology ensures stability even at factory-overclocked speeds.  \r\nThe 16GB GDDR6X memory allows seamless 4K rendering and AI-powered workloads.  \r\nDLSS 3 frame generation pushes high refresh-rate gaming to new heights.  \r\nReinforced metal backplate improves rigidity and passive cooling.  \r\nTriple-fan design keeps the card cool while maintaining quiet operation.  \r\nAesthetic RGB lighting enables bold customization for modern PC builds.  \r\nIdeal for gamers who demand ultra-high visual fidelity and power.', 1499.99, 'img/products/gpu_4080s_oc.jpg', 'Graphic Cards', 15),
(19, 'GeForce RTX 4070 Ti AERO OC', '\r\nThe RTX 4070 Ti AERO OC provides outstanding performance for creators and gamers alike.  \r\nIts white-themed design appeals to modern PC aesthetics and workstation builds.  \r\nTriple-fan WINDFORCE cooling maintains stable temperatures under long rendering sessions.  \r\nThe 12GB GDDR6X memory offers high-speed responsiveness for 3D modeling, VR, and editing.  \r\nDLSS 3 and ray tracing technologies enhance both visual quality and efficiency.  \r\nA factory overclock ensures higher performance out of the box.  \r\nHigh-quality components ensure long-term reliability for demanding workloads.  \r\nA versatile GPU ideal for creative professionals and high-refresh gaming.', 1099.99, 'img/products/gpu_4070ti_aero.jpg', 'Graphic Cards', 20),
(20, 'Radeon RX 7900 XTX GAMING OC', '\r\nThe Radeon RX 7900 XTX GAMING OC delivers exceptional 4K performance using AMD’s RDNA 3 architecture.  \r\nIts triple-fan cooling design ensures optimum temperature control during intense gaming.  \r\n24GB of GDDR6 memory allows smooth performance in ultra-high-resolution workloads.  \r\nThe card supports advanced ray tracing and AI-enhanced rendering technologies.  \r\nMetal backplate and enhanced PCB design improve durability and thermal efficiency.  \r\nDisplayPort 2.1 support enables ultra-high refresh-rate 4K and 8K monitors.  \r\nFactory overclocking pushes gaming performance to new levels.  \r\nA powerful GPU for enthusiasts seeking AMD’s highest-tier performance.', 1199.99, 'img/products/gpu_7900xtx.jpg', 'Graphic Cards', 14),
(21, 'GeForce RTX 4060 GAMING OC', '\r\nThe RTX 4060 GAMING OC offers great mid-range gaming performance with excellent efficiency.  \r\nIts WINDFORCE dual-fan cooling system maintains low noise during gameplay.  \r\nDLSS 3 technology boosts frame rates in demanding titles for smoother experiences.  \r\nThe 8GB GDDR6 memory ensures reliable performance at 1080p and 1440p settings.  \r\nCustomizable RGB lighting allows personalization through RGB Fusion.  \r\nA protective metal backplate adds strength and improves heat dissipation.  \r\nFactory overclocking gives an immediate performance uplift out of the box.  \r\nA perfect choice for gamers seeking value and performance.', 469.99, 'img/products/gpu_4060_oc.jpg', 'Graphic Cards', 30),
(22, 'GeForce RTX 3050 EAGLE', '\r\nThe RTX 3050 EAGLE is an entry-level GPU built for modern 1080p gaming with excellent efficiency.  \r\nDual-fan WINDFORCE cooling ensures stable performance in compact builds.  \r\nRay tracing and DLSS support bring advanced visual features to budget systems.  \r\nThe 8GB GDDR6 memory provides smooth gameplay in e-sports and mainstream titles.  \r\nIts clean and compact design fits easily into small form-factor PCs.  \r\nMetal backplate enhances the overall strength of the graphics card.  \r\nLow power draw makes it compatible with most standard PSUs.  \r\nA reliable and affordable GPU for everyday gamers and beginners.', 269.99, 'img/products/gpu_3050_eagle.jpg', 'Graphic Cards', 39),
(23, 'AORUS 17X 2024', '\r\nThe AORUS 17X 2024 is a flagship gaming laptop equipped with Intel i9 processors and RTX 40-series GPUs.  \r\nIts 17-inch high refresh-rate display delivers cinematic visuals and competitive clarity.  \r\nWINDFORCE Infinity cooling ensures stable temperatures during intense gaming marathons.  \r\nMechanical keyboard switches provide a tactile and precise gaming feel.  \r\nHigh-speed DDR5 memory and PCIe Gen4 SSD storage ensure lightning-fast responsiveness.  \r\nAdvanced AI-powered graphics boost gameplay and rendering performance.  \r\nPremium aluminum construction gives the laptop durability and a sleek appearance.  \r\nA powerhouse mobile gaming machine built for elite performance.', 3699.99, 'img/products/lap_17x.jpg', 'Laptop', 8),
(24, 'AORUS 15P', '\r\nThe AORUS 15P is tailored for competitive gamers who demand high-performance hardware.  \r\nPowered by NVIDIA RTX graphics and Intel processors, it handles AAA titles with ease.  \r\nIts Full HD high refresh-rate display offers crisp and smooth visuals.  \r\nWINDFORCE cooling technology ensures stable performance during extended gaming.  \r\nProgrammable RGB keyboard provides full customization for style and gameplay.  \r\nHigh-speed NVMe SSD delivers fast loading and boot times.  \r\nLightweight chassis makes it suitable for travel and esports events.  \r\nA gaming laptop designed for speed, precision, and reliability.', 2199.99, 'img/products/lap_15p.jpg', 'Laptop', 12),
(25, 'AERO 16 OLED', '\r\nThe AERO 16 OLED is a creator-focused laptop featuring a stunning 4K OLED display.  \r\nIts ultra-accurate color reproduction is ideal for photo editing, video work, and design.  \r\nPowered by Intel CPUs and RTX graphics, it handles demanding creative applications with ease.  \r\nThin and lightweight design makes it perfect for professional mobility.  \r\nHigh-speed DDR5 memory improves multitasking and workflow performance.  \r\nLarge cooling chambers ensure quiet and efficient operation.  \r\nLong battery life supports extended productivity on the go.  \r\nA premium laptop built for creative excellence and portability.', 2599.99, 'img/products/lap_aero16.jpg', 'Laptop', 10),
(26, 'AERO 14 OLED', '\r\nThe AERO 14 OLED provides a portable yet powerful solution for creators and professionals.  \r\nIts 14-inch OLED display offers rich colors and deep contrast for visual accuracy.  \r\nWith RTX graphics and high-end Intel processors, it delivers robust creative performance.  \r\nSlim and lightweight chassis makes it easy to carry anywhere.  \r\nLong-lasting battery enables full-day productivity without compromise.  \r\nPrecision-engineered cooling enhances performance during heavy workloads.  \r\nThunderbolt connectivity ensures fast file transfers and external device support.  \r\nA compact creative workstation that delivers exceptional visual quality.', 1999.99, 'img/products/lap_aero14.jpg', 'Laptop', 15),
(27, 'GIGABYTE G6X', '\r\nThe GIGABYTE G6X gaming laptop balances performance and value for mainstream gamers.  \r\nPowered by Intel and RTX 40-series graphics, it handles modern titles smoothly.  \r\nHigh refresh-rate display enhances competitive gameplay and responsiveness.  \r\nEfficient thermal design keeps the laptop cool during long gaming sessions.  \r\nWide color gamut ensures vibrant visuals for entertainment and content creation.  \r\nFast SSD storage improves boot times and application loading.  \r\nRGB keyboard adds personalization and gaming flair.  \r\nAn all-round gaming laptop suited for students and everyday gamers.', 1399.99, 'img/products/lap_g6x.jpg', 'Laptop', 20),
(28, 'AORUS 17', '\r\nThe AORUS 17 delivers large-screen gaming performance with a powerful hardware configuration.  \r\nIts 17-inch high refresh-rate display provides immersive and fluid gameplay.  \r\nNVIDIA RTX GPUs enable ray tracing and AI-enhanced graphics performance.  \r\nWINDFORCE cooling keeps the system stable during intense matches.  \r\nHigh-speed DDR5 memory and NVMe storage accelerate overall responsiveness.  \r\nRGB Fusion keyboard allows customization for gaming aesthetics.  \r\nStrong build quality ensures durability for travel and frequent use.  \r\nA perfect choice for gamers who want performance on a larger display.', 1899.99, 'img/products/lap_17.jpg', 'Laptop', 18),
(29, 'AORUS FO48U', '\r\nThe AORUS FO48U is a massive 48-inch 4K OLED gaming monitor offering incredible visual clarity.  \r\nOLED technology delivers deep blacks, vibrant colors, and exceptional contrast.  \r\n120Hz refresh rate and HDMI 2.1 make it ideal for next-gen consoles and PC gaming.  \r\nThe monitor supports FreeSync Premium for tear-free gameplay.  \r\nBuilt-in speakers and audio enhancements provide a complete entertainment experience.  \r\nLarge screen size doubles as a premium TV replacement for media and movies.  \r\nKVM functionality lets users control multiple devices seamlessly.  \r\nA high-end display for immersive gaming and professional content viewing.', 1499.99, 'img/products/mon_fo48u.jpg', 'Monitor', 6),
(30, 'GIGABYTE M32U', '\r\nThe GIGABYTE M32U is a 32-inch 4K gaming monitor built for both PC and console performance.  \r\nWith a 144Hz refresh rate, it delivers smooth visuals at high resolution.  \r\nFast IPS panel ensures accurate colors suitable for gaming and creative work.  \r\nHDMI 2.1 support enables full 4K 120Hz performance on modern consoles.  \r\nKVM switch allows easy control of multiple systems from a single setup.  \r\nFreeSync Premium Pro ensures tear-free and low-latency gameplay.  \r\nErgonomic adjustments provide comfortable viewing for long sessions.  \r\nA versatile 4K monitor delivering exceptional clarity and speed.', 749.99, 'img/products/mon_m32u.jpg', 'Monitor', 12),
(31, 'GIGABYTE G27Q', '\r\nThe GIGABYTE G27Q is a 27-inch 1440p IPS gaming monitor built for clarity and smoothness.  \r\nWith a 165Hz refresh rate, it delivers fluid gameplay for competitive and fast-paced titles.  \r\nThe IPS panel provides accurate colors and wide viewing angles for gaming and content creation.  \r\nHDR support enhances brightness and contrast for richer visual quality.  \r\nFreeSync Premium ensures tear-free and responsive performance.  \r\nThe ergonomic stand allows height, tilt, and pivot adjustments for comfortable use.  \r\nBuilt-in crosshair and game assist features help improve in-game accuracy.  \r\nA balanced monitor perfect for gaming, productivity, and multimedia.', 299.99, 'img/products/mon_g27q.jpg', 'Monitor', 25),
(32, 'AORUS FI27Q', '\r\nThe AORUS FI27Q is a premium 27-inch QHD gaming monitor designed for enthusiasts.  \r\nIts 165Hz refresh rate ensures ultra-smooth motion and reduced input lag.  \r\nThe IPS panel offers vibrant colors and exceptional HDR performance.  \r\nThe monitor includes advanced gaming tools such as Black Equalizer 2.0 and Aim Stabilizer.  \r\nFreeSync Premium and G-SYNC compatibility prevent screen tearing.  \r\nRGB Fusion lighting adds customizable aesthetics to any gaming setup.  \r\nThe sturdy metal stand provides excellent stability and ergonomic adjustments.  \r\nIdeal for gamers seeking elite visual quality and high refresh performance.', 499.99, 'img/products/mon_fi27q.jpg', 'Monitor', 15),
(33, 'GIGABYTE GS34WQC', '\r\nThe GIGABYTE GS34WQC is a 34-inch ultrawide curved monitor built for immersive gameplay.  \r\nIts 21:9 aspect ratio provides a wider field of view ideal for racing, FPS, and productivity.  \r\nThe 144Hz refresh rate ensures smooth visuals with minimal motion blur.  \r\nVA panel technology delivers deep contrast and vibrant color reproduction.  \r\nFreeSync Premium enhances fluidity by eliminating screen tearing.  \r\nThe curved design increases immersion for both gaming and cinematic viewing.  \r\nMultiple picture modes allow optimized settings for games, movies, or work.  \r\nA versatile ultrawide display offering both performance and immersion.', 449.99, 'img/products/mon_gs34wqc.jpg', 'Monitor', 18),
(34, 'AORUS MODEL S', '\r\nThe AORUS MODEL S is a compact high-performance desktop designed for serious gamers.  \r\nPowered by RTX 4070 graphics and high-end processors, it handles AAA titles with ease.  \r\nIts optimized airflow design keeps temperatures low despite its small form factor.  \r\nPremium cooling ensures quiet operation even under heavy loads.  \r\nFast NVMe storage enables quick boot times and rapid application loading.  \r\nRGB accents add a sleek and modern aesthetic to the build.  \r\nThe compact chassis fits easily in tight spaces without sacrificing power.  \r\nA powerhouse mini-PC ideal for gaming and productivity.', 2799.99, 'img/products/desk_models.jpg', 'Desktop', 8),
(35, 'GIGABYTE AORUS C500 GLASS', '\r\nThe AORUS C500 GLASS is a full-sized ATX chassis made for enthusiasts and high-airflow builds.  \r\nIts tempered glass panels showcase your components with a premium aesthetic.  \r\nThe spacious interior supports large GPUs, liquid cooling, and multiple storage drives.  \r\nAdvanced airflow engineering enhances cooling for demanding hardware.  \r\nMultiple fan and radiator support configurations allow flexible setup options.  \r\nDust filters help maintain a clean and efficient system over long-term use.  \r\nCable management features ensure clean and organized builds.  \r\nAn ideal case for gamers building a stylish and powerful PC rig.', 1899.99, 'img/products/desk_c500.jpg', 'Desktop', 10),
(36, 'GIGABYTE U4 Series', '\r\nThe GIGABYTE U4 Series is a slim and lightweight productivity laptop for students and professionals.  \r\nPowered by Intel mobile processors, it offers smooth performance for daily tasks and applications.  \r\nIts compact aluminum design provides durability while maintaining portability.  \r\nLong battery life ensures all-day usage without frequent charging.  \r\nHigh-quality display delivers sharp visuals and comfortable viewing.  \r\nThe laptop includes fast SSD storage for quick boot times and file access.  \r\nEfficient thermal design keeps the system cool during multitasking.  \r\nA reliable and stylish machine built for work, study, and everyday use.', 1299.99, 'img/products/desk_u4.jpg', 'Desktop', 12),
(37, 'AORUS MINI PC GB-BXi7', '\r\nThe AORUS MINI PC GB-BXi7 is a compact desktop designed for space-saving performance.  \r\nPowered by an Intel Core i7 processor, it delivers strong multitasking capabilities.  \r\nIts small footprint makes it perfect for offices, home desks, or entertainment setups.  \r\nIntegrated cooling maintains stability during extended workloads.  \r\nThe minimalist design blends seamlessly into modern work environments.  \r\nExpandable memory and storage options provide added flexibility.  \r\nLow power consumption makes it energy efficient and quiet.  \r\nA small yet capable mini-PC for business, study, and light creative work.', 999.99, 'img/products/desk_brix.jpg', 'Desktop', 20),
(38, 'GIGABYTE AORUS PRO TOWER', '\r\nThe AORUS PRO TOWER is a powerful prebuilt system tailored for gaming and productivity.  \r\nEngineered with high-airflow design, it ensures optimal cooling for high-performance components.  \r\nPremium hardware provides strong performance for AAA gaming and multitasking.  \r\nRGB lighting accents give the tower a customizable gaming appearance.  \r\nIts sturdy build quality ensures long-term reliability and stability.  \r\nFast SSD storage enables rapid load times across applications and games.  \r\nThe system includes optimized cable management for a clean internal layout.  \r\nA professional-grade tower ready for gaming, streaming, and creative workloads.', 1599.99, 'img/products/desk_protower.jpg', 'Motherboards', 15),
(39, 'AORUS WATERFORCE 360', '\r\nThe AORUS WATERFORCE 360 is a high-performance 360mm liquid cooler designed for overclocking.  \r\nIts triple-fan setup delivers exceptional airflow and heat dissipation.  \r\nLarge copper base ensures efficient CPU thermal transfer for top-tier processors.  \r\nRGB lighting adds a premium aesthetic that matches modern gaming builds.  \r\nDurable tubing and reliable pump design ensure long-term cooling performance.  \r\nQuiet operation keeps your system silent even under heavy workloads.  \r\nDesigned to support both Intel and AMD sockets with broad compatibility.  \r\nA premium cooling solution for enthusiasts seeking maximum performance.', 229.99, 'img/products/comp_waterforce360.jpg', 'PC Components', 25),
(40, 'AORUS NVMe Gen4 SSD 2TB', '\r\nThe AORUS NVMe Gen4 SSD 2TB provides ultra-fast storage speeds for gaming and productivity.  \r\nWith PCIe Gen4 technology, it offers read speeds that dramatically reduce load times.  \r\nLarge 2TB capacity allows storage for games, software, and creative projects.  \r\nHigh-quality NAND ensures durability and long-term data stability.  \r\nThe built-in heatsink maintains temperature control during heavy workloads.  \r\nEnergy-efficient design helps reduce heat and improve system longevity.  \r\nPerfect for next-generation PCs needing top-tier storage performance.  \r\nA reliable, high-speed solution for gamers and professionals.', 159.99, 'img/products/comp_nvme4.jpg', 'PC Components', 50),
(41, 'GIGABYTE ATC800 Cooler', 'The GIGABYTE ATC800 is a twin-tower air cooler engineered for high-performance CPUs.  \r\nIts dual heat sink design and powerful fans offer excellent heat dissipation.  \r\nRGB lighting on the fans creates an attractive and customizable appearance.  \r\nDirect-touch heat pipes maximize cooling efficiency under heavy CPU loads.  \r\nDurable construction ensures long-term reliability and quiet operation.  \r\nOptimized airflow design keeps temperatures low even during gaming or rendering.  \r\nEasy mounting system supports a wide range of Intel and AMD CPUs.  \r\nA premium air cooler ideal for high-performance desktop builds.', 89.99, 'img/products/comp_atc800.jpg', 'PC Components', 32),
(42, 'AORUS C700 GLASS CASE', '\r\nThe AORUS C700 GLASS is a premium full-tower case built for extreme PC builds.  \r\nIts dual tempered-glass panels showcase internal components with stunning clarity.  \r\nThe spacious interior supports E-ATX boards, long GPUs, and custom liquid cooling.  \r\nExtensive airflow options ensure optimal thermal performance for powerful hardware.  \r\nTool-free installation allows easy upgrades and component changes.  \r\nIntegrated RGB lighting adds style and complements high-end gaming setups.  \r\nCable-routing channels help maintain a clean and professional interior layout.  \r\nA flagship PC case designed for enthusiasts building showcase rigs.', 349.99, 'img/products/comp_c700.jpg', 'PC Components', 14);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rating` tinyint(4) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `rating`, `comment`, `created_at`) VALUES
(1, 1, 12, 5, 'The performance and quality of this ram is next level and especially the RGB effect that it gives at night is on whole another level. I will definitely recommend this to everyone.', '2025-11-25 20:20:00'),
(2, 1, 8, 5, 'The curved display is awseome and it gives a full VR experience. I would definitely recommend it.', '2025-11-30 11:00:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `province` varchar(50) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `address`, `city`, `province`, `postal_code`, `password_hash`, `is_admin`, `created_at`) VALUES
(1, 'Dheeraj', 'Verma', 'dhverma@algomau.ca', '64 Glenvale Blvd', 'Brampton', 'ON', 'L6S 1J2', '$2y$10$osue9Ts4YcRBXLEsThCQYeS8OXk3w/A.lnAjsBaScsh4L4/g0SVZ.', 1, '2025-11-23 22:12:50'),
(2, 'Fatal', 'Destiny', 'fatal.destiny6666@gmail.com', '64 Glenvale Blvd', 'Brampton', 'ON', 'L6S 1J2', '$2y$10$p5lQYvTiPDVaywPvKO/Mf.DzZ3BZmP3kpgEKGzi1PTUzvJyIwwCWG', 0, '2025-11-24 11:42:20'),
(3, 'Soul', 'Mortal', 'soulmortal9090@gmail.com', '64 Glenvale Blvd', 'Brampton', 'ON', 'L6S 1J2', '$2y$10$Chb6PDOAWXIgno55wwjqYuqjzwK/0PzJL1.HWxShnuJBgtEs.3fB6', 0, '2025-11-30 08:27:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

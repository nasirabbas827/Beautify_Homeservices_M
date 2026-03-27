-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2026 at 07:21 AM
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
-- Database: `beautifym_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `service_address` text NOT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `status` enum('pending','confirmed','completed','cancelled') DEFAULT 'pending',
  `total_amount` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `client_id`, `appointment_date`, `appointment_time`, `service_address`, `contact_number`, `status`, `total_amount`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-02-13', '15:31:00', 'ds', 'ewrasfd', 'cancelled', 1500.00, '2026-02-07 08:31:33', '2026-02-07 12:05:51'),
(2, 1, '2026-02-07', '17:05:00', 'dsaf', 's', 'completed', 1800.00, '2026-02-07 12:05:41', '2026-02-07 12:20:26'),
(3, 1, '2026-02-07', '17:06:00', 'cxz', 'rew', 'completed', 1000.00, '2026-02-07 12:06:36', '2026-02-07 12:20:29');

-- --------------------------------------------------------

--
-- Table structure for table `appointment_services`
--

CREATE TABLE `appointment_services` (
  `id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment_services`
--

INSERT INTO `appointment_services` (`id`, `appointment_id`, `service_id`, `price`) VALUES
(1, 1, 1, 1500.00),
(2, 2, 3, 1800.00),
(3, 3, 6, 1000.00);

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `faq_id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`faq_id`, `question`, `answer`, `created_at`) VALUES
(2, 'What services do you offer at Beautify?', 'We offer skin care, hair care, facials, massages, nail art, makeup services, and more.', '2026-03-27 06:15:27'),
(3, 'Do I need an appointment?', 'Yes, we recommend booking an appointment in advance to ensure availability.', '2026-03-27 06:15:27'),
(4, 'What are your working hours?', 'Our salon is open Monday to Saturday, from 10:00 AM to 8:00 PM.', '2026-03-27 06:15:27'),
(5, 'Do you provide home service?', 'Currently, we provide all services at our salon location. Home service is not available.', '2026-03-27 06:15:27'),
(6, 'Are your products safe for sensitive skin?', 'Yes, we use dermatologist-approved products suitable for most skin types.', '2026-03-27 06:15:27'),
(7, 'How can I book an appointment?', 'You can book online through our website or call our salon directly.', '2026-03-27 06:15:27'),
(8, 'Do you offer bridal makeup packages?', 'Yes, we have customized bridal packages including makeup, hair, and skin prep.', '2026-03-27 06:15:27'),
(9, 'What is your cancellation policy?', 'Cancellations must be made at least 24 hours in advance to avoid charges.', '2026-03-27 06:15:27'),
(10, 'Can I change my appointment date?', 'Yes, please contact us at least 24 hours before your scheduled appointment.', '2026-03-27 06:15:27'),
(11, 'Do you offer gift vouchers?', 'Yes, gift vouchers are available for all services and can be purchased in salon or online.', '2026-03-27 06:15:27'),
(12, 'Are your stylists certified?', 'Yes, all our staff are professionally trained and certified in their respective fields.', '2026-03-27 06:15:27'),
(13, 'Do you provide consultations before treatments?', 'Yes, we provide personalized consultations to choose the best treatments for you.', '2026-03-27 06:15:27'),
(14, 'How long does a facial take?', 'A typical facial takes about 60 minutes, depending on the type of treatment.', '2026-03-27 06:15:27'),
(15, 'Can I request a male or female therapist?', 'Yes, you can specify your preference when booking your appointment.', '2026-03-27 06:15:27'),
(16, 'Do you have parking facilities?', 'Yes, we provide free parking space for our clients near the salon.', '2026-03-27 06:15:27'),
(17, 'Is makeup removal included in your services?', 'Yes, all facial and makeup services include proper cleansing and removal steps.', '2026-03-27 06:15:27'),
(18, 'What are your hygiene standards?', 'We follow strict hygiene protocols, including sterilization of tools and clean service areas.', '2026-03-27 06:15:27'),
(19, 'Do you offer discounts or membership plans?', 'Yes, we have seasonal discounts and membership packages for regular clients.', '2026-03-27 06:15:27'),
(20, 'Can I combine services in one appointment?', 'Yes, you can customize your appointment with multiple services in one visit.', '2026-03-27 06:15:27'),
(21, 'Do you offer consultations for skin problems?', 'Yes, our experts provide guidance and recommend suitable treatments for skin concerns.', '2026-03-27 06:15:27');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_id` int(11) NOT NULL,
  `service_name` varchar(150) NOT NULL,
  `gender` enum('men','women') NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration_minutes` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `category_id`, `subcategory_id`, `service_name`, `gender`, `price`, `duration_minutes`, `description`, `image`, `is_active`, `created_at`) VALUES
(1, 1, 1, 'Engagement Makeup', 'women', 1500.00, 90, 'Elegant engagement makeup for women.', 'service.jpg', 1, '2026-02-07 08:25:16'),
(2, 1, 2, 'Nikkah Makeup', 'women', 2000.00, 120, 'Traditional Nikkah ceremony makeup.', 'service.jpg', 1, '2026-02-07 08:25:16'),
(3, 1, 3, 'Mehndi Makeup', 'women', 1800.00, 120, 'Colorful Mehndi ceremony makeup.', 'service.jpg', 1, '2026-02-07 08:25:16'),
(4, 1, 4, 'Mayun Makeup', 'women', 1600.00, 90, 'Mayun ceremony makeup services.', 'service.jpg', 1, '2026-02-07 08:25:16'),
(5, 1, 5, 'Party Makeup', 'women', 1200.00, 60, 'Glamorous makeup for parties.', 'service.jpg', 1, '2026-02-07 08:25:16'),
(6, 1, 6, 'Soft Makeup', 'women', 1000.00, 45, 'Natural and soft makeup look.', 'service.jpg', 1, '2026-02-07 08:25:16'),
(7, 1, 7, 'Glam Makeup', 'women', 2200.00, 120, 'Full glam makeup for special occasions.', 'service.jpg', 1, '2026-02-07 08:25:16'),
(8, 1, 8, 'Bridal Makeup', 'women', 5000.00, 180, 'Complete bridal makeup package.', 'service.jpg', 1, '2026-02-07 08:25:16'),
(9, 2, 9, 'Blowdry', 'women', 800.00, 45, 'Professional hair blowdry styling.', 'service.jpg', 1, '2026-02-07 08:25:16'),
(10, 2, 10, 'Hairstyle', 'women', 1000.00, 60, 'Trendy hairstyles for women.', 'service.jpg', 1, '2026-02-07 08:25:16'),
(11, 2, 11, 'Hair Cut', 'men', 700.00, 40, 'Professional haircut for men.', 'service.jpg', 1, '2026-02-07 08:25:16'),
(12, 2, 12, 'Bridal Hairstyle', 'women', 3000.00, 120, 'Elegant bridal hair styling.', 'service.jpg', 1, '2026-02-07 08:25:16'),
(13, 2, 13, 'Hair Dye Application Only', 'women', 1500.00, 90, 'Hair coloring/dye application service.', 'service.jpg', 1, '2026-02-07 08:25:16'),
(14, 3, 14, 'Cleanser', 'women', 500.00, 30, 'Facial cleansing treatment.', 'service.jpg', 1, '2026-02-07 08:25:16'),
(15, 3, 15, 'Face Polisher', 'women', 800.00, 45, 'Polishing treatment for smooth skin.', 'service.jpg', 1, '2026-02-07 08:25:16'),
(16, 3, 16, 'Dermaclear Facial', 'women', 1200.00, 60, 'Deep cleansing Dermaclear facial treatment.', 'service.jpg', 1, '2026-02-07 08:25:16'),
(17, 3, 17, 'Dermaclear Facial with Polisher', 'women', 1500.00, 75, 'Dermaclear facial plus polisher treatment.', 'service.jpg', 1, '2026-02-07 08:25:16'),
(18, 3, 18, 'Janssen Whitening Facial', 'women', 2000.00, 90, 'Janssen brand whitening facial.', 'service.jpg', 1, '2026-02-07 08:25:16'),
(19, 3, 19, 'Janssen Whitening Facial with Polisher', 'women', 2500.00, 120, 'Whitening facial combined with polisher.', 'service.jpg', 1, '2026-02-07 08:25:16'),
(20, 3, 20, 'HydraFacial', 'women', 3000.00, 120, 'Premium hydrating HydraFacial treatment.', 'service.jpg', 1, '2026-02-07 08:25:16'),
(21, 4, 21, 'Classic Manicure', 'women', 500.00, 30, 'Basic classic manicure.', 'service.jpg', 1, '2026-02-07 08:25:16'),
(22, 4, 22, 'Classic Pedicure', 'women', 500.00, 30, 'Basic classic pedicure.', 'service.jpg', 1, '2026-02-07 08:25:16'),
(23, 4, 23, 'Classic Mani Pedi', 'women', 900.00, 60, 'Combined classic manicure and pedicure.', 'service.jpg', 1, '2026-02-07 08:25:16'),
(24, 4, 24, 'Signature Manicure', 'women', 800.00, 45, 'Special signature manicure treatment.', 'service.jpg', 1, '2026-02-07 08:25:16'),
(25, 4, 25, 'Signature Pedicure', 'women', 800.00, 45, 'Special signature pedicure treatment.', 'service.jpg', 1, '2026-02-07 08:25:16'),
(26, 4, 26, 'Signature Mani Pedi', 'women', 1400.00, 75, 'Combined signature manicure and pedicure.', 'service.jpg', 1, '2026-02-07 08:25:16');

-- --------------------------------------------------------

--
-- Table structure for table `service_categories`
--

CREATE TABLE `service_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_categories`
--

INSERT INTO `service_categories` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Makeup Services', 'Professional makeup services for all occasions including engagement, nikkah, mehndi, party, and bridal makeup.', '2026-02-07 08:11:28'),
(2, 'Hair Styling Services', 'Hair styling, cutting, dyeing, and bridal hair styling services to suit every style.', '2026-02-07 08:11:28'),
(3, 'Facial Services', 'High-quality facial treatments including cleansers, polisher, Dermaclear facials, Janssen whitening, and HydraFacial.', '2026-02-07 08:11:28'),
(4, 'Nails Services', 'Classic and signature manicure and pedicure services including combined Mani-Pedi packages.', '2026-02-07 08:11:28');

-- --------------------------------------------------------

--
-- Table structure for table `service_subcategories`
--

CREATE TABLE `service_subcategories` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_subcategories`
--

INSERT INTO `service_subcategories` (`id`, `category_id`, `name`, `description`, `created_at`) VALUES
(1, 1, 'Engagement Makeup', 'Elegant engagement makeup for men and women.', '2026-02-07 08:16:54'),
(2, 1, 'Nikkah Makeup', 'Traditional Nikkah ceremony makeup.', '2026-02-07 08:16:54'),
(3, 1, 'Mehndi Makeup', 'Colorful Mehndi ceremony makeup.', '2026-02-07 08:16:54'),
(4, 1, 'Mayun Makeup', 'Mayun ceremony makeup services.', '2026-02-07 08:16:54'),
(5, 1, 'Party Makeup', 'Glamorous makeup for parties and events.', '2026-02-07 08:16:54'),
(6, 1, 'Soft Makeup', 'Natural and soft makeup look.', '2026-02-07 08:16:54'),
(7, 1, 'Glam Makeup', 'Full glam makeup for special occasions.', '2026-02-07 08:16:54'),
(8, 1, 'Bridal Makeup', 'Complete bridal makeup package.', '2026-02-07 08:16:54'),
(9, 2, 'Blowdry', 'Professional hair blowdry styling.', '2026-02-07 08:16:54'),
(10, 2, 'Hairstyle', 'Trendy and stylish hairdos for any occasion.', '2026-02-07 08:16:54'),
(11, 2, 'Hair Cut', 'Professional haircut service.', '2026-02-07 08:16:54'),
(12, 2, 'Bridal Hairstyle', 'Elegant bridal hair styling.', '2026-02-07 08:16:54'),
(13, 2, 'Hair Dye Application Only', 'Hair coloring/dye application service.', '2026-02-07 08:16:54'),
(14, 3, 'Cleanser', 'Facial cleansing treatment.', '2026-02-07 08:16:54'),
(15, 3, 'Face Polisher', 'Polishing treatment for smooth skin.', '2026-02-07 08:16:54'),
(16, 3, 'Dermaclear Facial', 'Deep cleansing Dermaclear facial treatment.', '2026-02-07 08:16:54'),
(17, 3, 'Dermaclear Facial with Polisher', 'Dermaclear facial with polishing treatment.', '2026-02-07 08:16:54'),
(18, 3, 'Janssen Whitening Facial', 'Janssen brand whitening facial.', '2026-02-07 08:16:54'),
(19, 3, 'Janssen Whitening Facial with Polisher', 'Whitening facial combined with polisher.', '2026-02-07 08:16:54'),
(20, 3, 'HydraFacial', 'Premium hydrating HydraFacial treatment.', '2026-02-07 08:16:54'),
(21, 4, 'Classic Manicure', 'Basic manicure service for hands.', '2026-02-07 08:16:55'),
(22, 4, 'Classic Pedicure', 'Basic pedicure service for feet.', '2026-02-07 08:16:55'),
(23, 4, 'Classic Mani Pedi', 'Combined classic manicure and pedicure service.', '2026-02-07 08:16:55'),
(24, 4, 'Signature Manicure', 'Special signature manicure treatment.', '2026-02-07 08:16:55'),
(25, 4, 'Signature Pedicure', 'Special signature pedicure treatment.', '2026-02-07 08:16:55'),
(26, 4, 'Signature Mani Pedi', 'Combined signature manicure and pedicure service.', '2026-02-07 08:16:55');

-- --------------------------------------------------------

--
-- Table structure for table `stories`
--

CREATE TABLE `stories` (
  `story_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stories`
--

INSERT INTO `stories` (`story_id`, `title`, `content`, `image_url`, `created_at`) VALUES
(4, 'Luxury Skin Care Tips', 'Discover the best practices for glowing skin using luxury skincare treatments.', 'uploads/1774591620_b2.jpeg', '2026-03-27 06:08:03'),
(5, 'Hair Spa Secrets', 'Learn how hair spa treatments can rejuvenate your hair and scalp.', 'uploads/1774591620_b2.jpeg', '2026-03-27 06:08:03'),
(6, 'Facial Treatments Guide', 'A comprehensive guide to facials for different skin types.', 'uploads/1774591620_b2.jpeg', '2026-03-27 06:08:03'),
(7, 'Nail Art Trends 2026', 'Top nail art designs and trends for this year.', 'uploads/1774591620_b2.jpeg', '2026-03-27 06:08:03'),
(8, 'Makeup Tips for Everyday', 'Essential makeup techniques for a natural everyday look.', 'uploads/1774591620_b2.jpeg', '2026-03-27 06:08:03'),
(9, 'Body Massage Benefits', 'Relax and rejuvenate with the most effective body massages.', 'uploads/1774591620_b2.jpeg', '2026-03-27 06:08:03'),
(10, 'Anti-Aging Skincare', 'Best anti-aging treatments to maintain youthful skin.', 'uploads/1774591620_b2.jpeg', '2026-03-27 06:08:03'),
(11, 'Bridal Makeup Essentials', 'Everything a bride needs to look perfect on her big day.', 'uploads/1774591620_b2.jpeg', '2026-03-27 06:08:03'),
(12, 'Hair Coloring Techniques', 'Explore popular hair coloring techniques and styles.', 'uploads/1774591620_b2.jpeg', '2026-03-27 06:08:03'),
(13, 'Deep Cleansing Facial', 'Step-by-step guide to achieving a deep cleansing facial.', 'uploads/1774591620_b2.jpeg', '2026-03-27 06:08:03'),
(14, 'Eyebrow Shaping Tips', 'Perfect your eyebrow shape for a polished look.', 'uploads/1774591620_b2.jpeg', '2026-03-27 06:08:03'),
(15, 'Detox Body Treatments', 'How detox treatments help refresh your body and mind.', 'uploads/1774591620_b2.jpeg', '2026-03-27 06:08:03'),
(16, 'Brilliant Manicure Ideas', 'Creative manicure ideas to elevate your nail style.', 'uploads/1774591620_b2.jpeg', '2026-03-27 06:08:03'),
(17, 'Facial Masks at Home', 'DIY facial masks for glowing skin in the comfort of your home.', 'uploads/1774591620_b2.jpeg', '2026-03-27 06:08:03'),
(18, 'Spa Etiquette Tips', 'Important tips to follow during spa visits.', 'uploads/1774591620_b2.jpeg', '2026-03-27 06:08:03'),
(19, 'Hair Care Routine', 'Daily and weekly hair care routines for healthy hair.', 'uploads/1774591620_b2.jpeg', '2026-03-27 06:08:03'),
(20, 'Makeup for Parties', 'Glamorous makeup looks perfect for parties and events.', 'uploads/1774591620_b2.jpeg', '2026-03-27 06:08:03'),
(21, 'Foot Massage Techniques', 'Effective foot massage techniques for relaxation.', 'uploads/1774591620_b2.jpeg', '2026-03-27 06:08:03'),
(22, 'Skincare for Summer', 'Protect your skin and keep it fresh during summer.', 'uploads/1774591620_b2.jpeg', '2026-03-27 06:08:03'),
(23, 'Nighttime Beauty Routine', 'Step-by-step nighttime beauty routine for better skin.', 'uploads/1774591620_b2.jpeg', '2026-03-27 06:08:03');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dob` date DEFAULT NULL,
  `cnic` varchar(15) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `username`, `email`, `password`, `dob`, `cnic`, `contact_number`, `address`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'NASIR ABBAS', 'nasir12', 'nasiryt.827@gmail.com', '$2y$10$TiWF92C/55jAOb09ZLNyguws4aER61jeytMmHZecEmm1iR1Q41DXS', '2026-02-07', '3240254008217', '03176526827', 'Street jeff xxxx\r\nAp04', 1, '2026-02-07 07:48:15', '2026-02-07 07:48:15'),
(2, 'Client One', 'Client12', 'client12@gmail.com', '$2y$10$5LcYl6zbbJz1bNJ9qqdGd.GaPljIiW4/pxhSdEANtV/xaTgI8SR4W', '2026-02-23', '3240284436385', '03266029022', 'XYZ', 1, '2026-02-23 16:13:45', '2026-02-23 16:13:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `appointment_services`
--
ALTER TABLE `appointment_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointment_id` (`appointment_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`faq_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `subcategory_id` (`subcategory_id`);

--
-- Indexes for table `service_categories`
--
ALTER TABLE `service_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_subcategories`
--
ALTER TABLE `service_subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `stories`
--
ALTER TABLE `stories`
  ADD PRIMARY KEY (`story_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `appointment_services`
--
ALTER TABLE `appointment_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `faq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `service_categories`
--
ALTER TABLE `service_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `service_subcategories`
--
ALTER TABLE `service_subcategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `stories`
--
ALTER TABLE `stories`
  MODIFY `story_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `appointment_services`
--
ALTER TABLE `appointment_services`
  ADD CONSTRAINT `appointment_services_ibfk_1` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointment_services_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`);

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `service_categories` (`id`),
  ADD CONSTRAINT `services_ibfk_2` FOREIGN KEY (`subcategory_id`) REFERENCES `service_subcategories` (`id`);

--
-- Constraints for table `service_subcategories`
--
ALTER TABLE `service_subcategories`
  ADD CONSTRAINT `service_subcategories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `service_categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 02, 2023 at 12:22 PM
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
-- Database: `attendance_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `attendance_time` time NOT NULL DEFAULT '22:08:06',
  `attendance_date` date NOT NULL DEFAULT '2023-05-27',
  `attendance_type` smallint(4) NOT NULL DEFAULT 1,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `employee_id`, `attendance_time`, `attendance_date`, `attendance_type`, `status`, `created_at`, `updated_at`) VALUES
(100, 1000, '10:27:16', '2023-06-01', 255, 1, '2023-06-01 11:29:40', '2023-06-01 11:29:40'),
(101, 1001, '10:27:32', '2023-06-01', 1, 1, '2023-06-01 11:29:40', '2023-06-01 11:29:40'),
(102, 1001, '10:27:40', '2023-06-01', 0, 1, '2023-06-01 11:29:40', '2023-06-01 11:29:40'),
(103, 1000, '10:27:48', '2023-06-01', 0, 1, '2023-06-01 11:29:40', '2023-06-01 11:29:40'),
(104, 1002, '10:27:57', '2023-06-01', 0, 1, '2023-06-01 11:29:40', '2023-06-01 11:29:40'),
(105, 1002, '10:28:04', '2023-06-01', 1, 1, '2023-06-01 11:29:40', '2023-06-01 11:29:40'),
(106, 1003, '10:28:10', '2023-06-01', 0, 1, '2023-06-01 11:29:40', '2023-06-01 11:29:40'),
(107, 1003, '10:28:19', '2023-06-01', 1, 1, '2023-06-01 11:29:40', '2023-06-01 11:29:40'),
(108, 1004, '10:28:25', '2023-06-01', 0, 1, '2023-06-01 11:29:40', '2023-06-01 11:29:40'),
(109, 1004, '10:28:32', '2023-06-01', 1, 1, '2023-06-01 11:29:40', '2023-06-01 11:29:40'),
(110, 1005, '10:28:55', '2023-06-01', 1, 1, '2023-06-01 11:29:40', '2023-06-01 11:29:40'),
(111, 1005, '10:29:10', '2023-06-01', 0, 1, '2023-06-01 11:29:40', '2023-06-01 11:29:40'),
(112, 1005, '06:29:10', '2023-06-02', 0, 1, '2023-06-01 11:29:40', '2023-06-01 11:29:40');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `organization_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `organization_id`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Anatomy', 1, 1, 1, '2023-05-25 16:22:46', '2023-05-25 16:23:12'),
(2, 'Medicine', 1, 1, 1, '2023-05-29 18:26:17', '2023-05-29 18:26:17'),
(3, 'Administration', 2, 1, 1, '2023-06-01 03:48:15', '2023-06-01 03:48:49'),
(4, 'Accounts', 2, 1, 1, '2023-06-01 03:48:58', '2023-06-01 03:48:58'),
(5, 'Information Technology', 4, 1, 1, '2023-06-01 04:14:01', '2023-06-01 04:14:01'),
(6, 'Accounts', 4, 1, 1, '2023-06-01 04:14:26', '2023-06-01 04:14:26');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `employment_id` varchar(191) DEFAULT NULL,
  `organization_id` bigint(20) UNSIGNED DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `schedule_id` bigint(20) UNSIGNED DEFAULT NULL,
  `mobile` varchar(191) DEFAULT NULL,
  `joining_date` varchar(191) DEFAULT NULL,
  `designation` varchar(191) DEFAULT NULL,
  `optional` varchar(191) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `employment_id`, `organization_id`, `department_id`, `schedule_id`, `mobile`, `joining_date`, `designation`, `optional`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1000, 'Alamgir Sarker', 'E24234324', 4, 5, 2, '756675656', NULL, 'System Engineer', NULL, 1, 1, '2023-06-01 04:21:05', '2023-06-01 04:21:05'),
(1001, 'Prodip Munshi', 'E323567263', 4, 5, 2, '01736834294', NULL, 'Hardware Engineer', NULL, 1, 1, '2023-06-01 04:21:57', '2023-06-01 04:21:57'),
(1002, 'Suman Sutradhar', 'E353266524', 4, 5, 3, '7656735', NULL, 'Technician', NULL, 1, 1, '2023-06-01 04:22:30', '2023-06-01 04:22:30'),
(1003, 'Amrito Kumar', 'E5765456', 4, 6, 2, '5624563625', NULL, 'Office Assistant', NULL, 1, 1, '2023-06-01 04:23:12', '2023-06-01 04:23:12'),
(1004, 'Ibrahim Hussain', 'E465464546', 4, 6, 2, '6725376253', NULL, 'Junior Accountant', NULL, 1, 1, '2023-06-01 04:23:53', '2023-06-01 04:23:53'),
(1005, 'Masud Rana', 'E24435234', 4, 6, 2, '234242423', NULL, 'Office Assistant', NULL, 1, 1, '2023-06-01 04:27:30', '2023-06-01 04:27:30');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_04_16_171524_create_permission_tables', 2),
(6, '2023_04_20_011054_add_status_to_users_table', 3),
(7, '2023_04_20_152834_add_type_to_permissions_table', 4),
(8, '2023_04_21_154840_create_companies_table', 5),
(9, '2023_04_21_155015_create_generics_table', 5),
(11, '2023_04_21_155120_create_doses_table', 5),
(12, '2023_04_21_155143_create_instructions_table', 5),
(13, '2023_04_21_155204_create_durations_table', 5),
(14, '2023_04_21_155106_create_brands_table', 6),
(15, '2023_04_22_114820_create_component_types_table', 7),
(17, '2023_04_22_121816_create_user_clinical_component_table', 7),
(18, '2023_04_22_114846_create_clinical_components_table', 8),
(19, '2023_04_23_022009_add_doctors_info_to_users_table', 9),
(20, '2023_04_24_063147_create_patients_table', 10),
(21, '2023_04_24_063155_create_appointments_table', 10),
(22, '2023_04_24_152113_add_reg_no_to_patients_table', 11),
(23, '2023_04_24_152232_add_consultation_no_to_appointments_table', 11),
(24, '2023_04_24_160718_add_timestamp_to_patients_table', 12),
(25, '2023_04_29_184849_add_on_examination_to_appointments_table', 13),
(26, '2023_04_30_151849_create_media_libraries_table', 14),
(27, '2023_05_01_083008_create_medications_table', 15),
(28, '2023_05_01_155816_create_medicine_templates_table', 16),
(29, '2023_05_01_155905_create_templated_medicines_table', 16),
(30, '2023_05_03_203001_create_favourite_medications_table', 17),
(32, '2023_05_07_064603_create_personal_settings_table', 18),
(35, '2023_05_15_170819_add_gynae_and_obs_columns_to_appointments_table', 19),
(36, '2023_05_18_182111_add_appointment_fee_to_appointments', 20),
(37, '2023_05_18_183027_add_appointment_fee_to_personal_settings', 21),
(38, '2023_05_19_010151_add_appointment_fee_to_users', 22),
(39, '2023_05_20_084702_create_component_templates_table', 23),
(40, '2023_05_24_230709_create_organizations_table', 24),
(41, '2023_05_24_230750_create_departments_table', 24),
(42, '2023_05_24_230824_create_schedules_table', 24),
(43, '2023_05_24_230919_create_employees_table', 24),
(44, '2023_05_25_212815_add_organization_id_to_users_table', 25),
(45, '2023_05_27_194515_create_attedances_table', 26);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`id`, `name`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Khwaja Yunus Ali Medical College', 1, 1, '2023-05-25 14:12:04', '2023-06-01 16:01:39'),
(2, 'Khwaja Yunus Ali Nursing College', 1, 1, '2023-06-01 03:37:22', '2023-06-01 03:37:22'),
(3, 'Khwaja Yunus Ali Laboratory School & College', 1, 1, '2023-06-01 03:38:00', '2023-06-01 03:38:00'),
(4, 'Khwaja Yunus Ali Medical College & Hospital', 1, 1, '2023-06-01 04:12:54', '2023-06-01 04:12:54');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('munshiprodip@gmail.com', '$2y$10$WQb6hih/VU7WfJzPzNPoSufUVeul/XuwLMD9JbQGKSR82ESySOFsq', '2023-04-16 11:03:35');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(125) NOT NULL,
  `type` varchar(191) NOT NULL,
  `guard_name` varchar(125) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `type`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Read User', 'User Management', 'web', '2023-04-20 09:31:44', '2023-04-20 10:21:20'),
(2, 'Write User', 'User Management', 'web', '2023-04-20 09:36:13', '2023-04-20 10:21:32'),
(3, 'Modify User', 'User Management', 'web', '2023-04-20 09:36:53', '2023-04-20 10:21:13'),
(4, 'Delete User', 'User Management', 'web', '2023-04-20 09:37:14', '2023-04-20 10:20:58'),
(5, 'Read Role', 'Role Management', 'web', '2023-04-21 04:46:45', '2023-04-21 04:46:45'),
(6, 'Write Role', 'Role Management', 'web', '2023-04-21 04:47:00', '2023-05-11 08:23:51'),
(7, 'Modify Role', 'Role Management', 'web', '2023-04-21 04:47:23', '2023-05-11 08:23:35'),
(8, 'Delete Role', 'Role Management', 'web', '2023-04-21 04:47:41', '2023-05-11 08:24:07'),
(12, 'Read Permission', 'Permission Management', 'web', '2023-05-11 08:03:33', '2023-05-11 08:03:33'),
(13, 'Write Permission', 'Permission Management', 'web', '2023-05-11 08:04:14', '2023-05-11 08:04:14'),
(14, 'Modify Permission', 'Permission Management', 'web', '2023-05-11 08:04:36', '2023-05-11 08:04:36'),
(15, 'Delete Permission', 'Permission Management', 'web', '2023-05-11 08:04:59', '2023-05-11 08:04:59');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(125) NOT NULL,
  `guard_name` varchar(125) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', '2023-04-19 07:05:32', '2023-04-19 07:05:32'),
(8, 'User', 'web', '2023-05-25 15:24:40', '2023-05-25 15:24:40');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 8),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1);

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `organization_id` bigint(20) UNSIGNED DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `saturday` tinyint(4) NOT NULL DEFAULT 0,
  `sunday` tinyint(4) NOT NULL DEFAULT 0,
  `monday` tinyint(4) NOT NULL DEFAULT 0,
  `tuesday` tinyint(4) NOT NULL DEFAULT 0,
  `wednesday` tinyint(4) NOT NULL DEFAULT 0,
  `thursday` tinyint(4) NOT NULL DEFAULT 0,
  `friday` tinyint(4) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `name`, `organization_id`, `start_time`, `end_time`, `saturday`, `sunday`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Test', 1, '08:00:00', '17:00:00', 0, 0, 0, 0, 0, 0, 0, 1, 1, '2023-05-25 17:43:28', '2023-05-25 17:43:28'),
(2, 'General', 4, '08:30:00', '17:30:00', 0, 0, 0, 0, 0, 0, 0, 1, 1, '2023-06-01 04:16:11', '2023-06-01 04:16:11'),
(3, 'Morning', 4, '07:00:00', '16:00:00', 0, 0, 0, 0, 0, 0, 0, 1, 1, '2023-06-01 04:20:20', '2023-06-01 04:20:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `nid` varchar(191) DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `dob` varchar(191) DEFAULT NULL,
  `avater` varchar(191) DEFAULT NULL,
  `gender` varchar(191) DEFAULT NULL,
  `religion` varchar(191) DEFAULT NULL,
  `nationality` varchar(191) DEFAULT NULL,
  `bloodgroup` varchar(191) DEFAULT NULL,
  `present_address` varchar(191) DEFAULT NULL,
  `permanent_address` varchar(191) DEFAULT NULL,
  `organization_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `status`, `nid`, `phone`, `dob`, `avater`, `gender`, `religion`, `nationality`, `bloodgroup`, `present_address`, `permanent_address`, `organization_id`) VALUES
(1, 'Prodip Munshi', 'munshiprodip@gmail.com', NULL, '$2y$10$BFgBm9s9sWvtoLVXtO5SY.F6sDEc.BHooK.woXD65SpZ70No7seaO', NULL, '2023-04-15 08:17:16', '2023-06-01 16:09:16', 1, '19930610279000277', '01736834294', '1993-04-07', '1683479581_1.jpg', 'Male', 'Hindu', 'Bangladeshi', 'A(+ve)', 'Khwaja Yunus Ali Medical College & Hospital, Enayetpur, Sirajganj.', 'Bara Bashail, Agailjhara, Barisal.', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attedances_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departments_organization_id_foreign` (`organization_id`),
  ADD KEY `departments_created_by_foreign` (`created_by`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employees_organization_id_foreign` (`organization_id`),
  ADD KEY `employees_department_id_foreign` (`department_id`),
  ADD KEY `employees_schedule_id_foreign` (`schedule_id`),
  ADD KEY `employees_created_by_foreign` (`created_by`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organizations_created_by_foreign` (`created_by`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedules_organization_id_foreign` (`organization_id`),
  ADD KEY `schedules_created_by_foreign` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_nid_unique` (`nid`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD KEY `users_organization_id_foreign` (`organization_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1006;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attedances_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `departments_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employees_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employees_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employees_schedule_id_foreign` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `organizations`
--
ALTER TABLE `organizations`
  ADD CONSTRAINT `organizations_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `schedules_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

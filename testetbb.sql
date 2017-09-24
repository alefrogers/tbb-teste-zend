-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 24-Set-2017 às 23:01
-- Versão do servidor: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testetbb`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbb_investments_simulations`
--

CREATE TABLE `tbb_investments_simulations` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_type` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbb_investments_simulations_applications`
--

CREATE TABLE `tbb_investments_simulations_applications` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_simulation` int(10) UNSIGNED NOT NULL,
  `val_application` double NOT NULL,
  `date_application` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbb_investments_type`
--

CREATE TABLE `tbb_investments_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profitability` double(5,3) NOT NULL,
  `rate` double(5,3) NOT NULL,
  `application_days` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbb_migrations`
--

CREATE TABLE `tbb_migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `tbb_migrations`
--

INSERT INTO `tbb_migrations` (`id`, `migration`, `batch`) VALUES
(1, '2017_09_16_131308_TypesInvestments', 1),
(2, '2017_09_17_140156_simulations', 1),
(3, '2017_09_17_140901_applications', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbb_investments_simulations`
--
ALTER TABLE `tbb_investments_simulations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `investments_simulations_id_type_foreign` (`id_type`);

--
-- Indexes for table `tbb_investments_simulations_applications`
--
ALTER TABLE `tbb_investments_simulations_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_simulation` (`id_simulation`);

--
-- Indexes for table `tbb_investments_type`
--
ALTER TABLE `tbb_investments_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbb_migrations`
--
ALTER TABLE `tbb_migrations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbb_investments_simulations`
--
ALTER TABLE `tbb_investments_simulations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbb_investments_simulations_applications`
--
ALTER TABLE `tbb_investments_simulations_applications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbb_investments_type`
--
ALTER TABLE `tbb_investments_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbb_migrations`
--
ALTER TABLE `tbb_migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

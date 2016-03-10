-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2016 at 08:57 PM
-- Server version: 5.5.34
-- PHP Version: 5.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `datawarehouse`
--

-- --------------------------------------------------------

--
-- Table structure for table `hris_payroll`
--

CREATE TABLE IF NOT EXISTS `hris_payroll` (
  `id` int(11) NOT NULL,
  `basic_salary` decimal(10,0) NOT NULL,
  `tax` decimal(10,0) NOT NULL,
  `civil_status` varchar(255) NOT NULL,
  `dependent_number` int(11) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hris_payroll`
--

INSERT INTO `hris_payroll` (`id`, `basic_salary`, `tax`, `civil_status`, `dependent_number`, `date`) VALUES
(11717002, '30000', '4500', 'Single', 0, '2016-03-15'),
(117170001, '30000', '4500', 'Single', 0, '2016-03-15'),
(117170002, '45000', '4500', 'Married', 2, '2015-03-30'),
(117170003, '60000', '9000', 'Single', 0, '2014-04-15'),
(117170004, '15000', '2250', 'Single', 0, '2014-04-15');

-- --------------------------------------------------------

--
-- Table structure for table `hris_payroll_bonus`
--

CREATE TABLE IF NOT EXISTS `hris_payroll_bonus` (
  `id` int(11) NOT NULL,
  `bonus_amount` decimal(10,0) NOT NULL,
  `payroll_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hris_payroll_bonus`
--

INSERT INTO `hris_payroll_bonus` (`id`, `bonus_amount`, `payroll_id`) VALUES
(147470001, '10', '117170001'),
(147470002, '35', '11717002'),
(147470001, '10', '117170001'),
(147470002, '35', '11717002'),
(147470001, '10', '117170001'),
(147470002, '35', '11717002');

-- --------------------------------------------------------

--
-- Table structure for table `hris_payroll_deduction`
--

CREATE TABLE IF NOT EXISTS `hris_payroll_deduction` (
  `id` int(11) NOT NULL,
  `deduction_amount_total` decimal(10,0) NOT NULL,
  `payroll_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hris_payroll_deduction`
--

INSERT INTO `hris_payroll_deduction` (`id`, `deduction_amount_total`, `payroll_id`) VALUES
(148480001, '1300', 117170001),
(148480002, '1300', 11717002);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

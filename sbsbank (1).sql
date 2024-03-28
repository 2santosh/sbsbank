-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2024 at 06:26 AM
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
-- Database: `sbsbank`
--

-- --------------------------------------------------------

--
-- Table structure for table `ib_acc_types`
--

CREATE TABLE `ib_acc_types` (
  `acctype_id` int(20) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` longtext NOT NULL,
  `rate` varchar(200) NOT NULL,
  `code` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ib_acc_types`
--

INSERT INTO `ib_acc_types` (`acctype_id`, `name`, `description`, `rate`, `code`) VALUES
(1, 'Savings', '<p>Savings accounts&nbsp;are typically the first official bank account anybody opens. Children may open an account with a parent to begin a pattern of saving. Teenagers open accounts to stash cash earned&nbsp;from a first job&nbsp;or household chores.</p><p>Savings accounts are an excellent place to park&nbsp;emergency cash. Opening a savings account also marks the beginning of your relationship with a financial institution. For example, when joining a credit union, your &ldquo;share&rdquo; or savings account establishes your membership.</p>', '20', 'ACC-CAT-4EZFO'),
(2, ' Retirement', '<p>Retirement accounts&nbsp;offer&nbsp;tax advantages. In very general terms, you get to&nbsp;avoid paying income tax on interest&nbsp;you earn from a savings account or CD each year. But you may have to pay taxes on those earnings at a later date. Still, keeping your money sheltered from taxes may help you over the long term. Most banks offer IRAs (both&nbsp;Traditional IRAs&nbsp;and&nbsp;Roth IRAs), and they may also provide&nbsp;retirement accounts for small businesses</p>', '10', 'ACC-CAT-1QYDV'),
(4, 'Recurring deposits', '<p><strong>Recurring deposit account or RD account</strong> is opened by those who want to save certain amount of money regularly for a certain period of time and earn a higher interest rate.&nbsp;In RD&nbsp;account a&nbsp;fixed amount is deposited&nbsp;every month for a specified period and the total amount is repaid with interest at the end of the particular fixed period.&nbsp;</p><p>The period of deposit is minimum six months and maximum ten years.&nbsp;The interest rates vary&nbsp;for different plans based on the amount one saves and the period of time and also on banks. No withdrawals are allowed from the RD account. However, the bank may allow to close the account before the maturity period.</p><p>These accounts can be opened in single or joint names. Banks are also providing the Nomination facility to the RD account holders.&nbsp;</p>', '15', 'ACC-CAT-VBQLE'),
(5, 'Fixed Deposit Account', '<p>In <strong>Fixed Deposit Account</strong> (also known as <strong>FD Account</strong>), a particular sum of money is deposited in a bank for specific&nbsp;period of time. It&rsquo;s one time deposit and one time take away (withdraw) account.&nbsp;The money deposited in this account can not be withdrawn before the expiry of period.&nbsp;</p><p>However, in case of need,&nbsp; the depositor can ask for closing the fixed deposit prematurely by paying a penalty. The penalty amount varies with banks.</p><p>A high interest rate is paid on fixed deposits. The rate of interest paid for fixed deposit vary according to amount, period and also from bank to bank.</p>', '40', 'ACC-CAT-A86GO'),
(9, 'child', 'child</p>', '15', 'ACC-CAT-2NSDY');

-- --------------------------------------------------------

--
-- Table structure for table `ib_admin`
--

CREATE TABLE `ib_admin` (
  `admin_id` int(20) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `number` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `profile_pic` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ib_admin`
--

INSERT INTO `ib_admin` (`admin_id`, `name`, `email`, `number`, `password`, `profile_pic`) VALUES
(1, 'System Administrator', 'admin@gmail.com', 'iBank-ADM-0516', '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', 'admin-icn.png');

-- --------------------------------------------------------

--
-- Table structure for table `ib_bankaccounts`
--

CREATE TABLE `ib_bankaccounts` (
  `account_id` int(20) NOT NULL,
  `acc_name` varchar(200) NOT NULL,
  `account_number` varchar(200) NOT NULL,
  `acc_type` varchar(200) NOT NULL,
  `acc_rates` varchar(200) NOT NULL,
  `acc_status` varchar(200) NOT NULL,
  `acc_amount` varchar(200) NOT NULL,
  `client_id` varchar(200) NOT NULL,
  `client_name` varchar(200) NOT NULL,
  `client_national_id` varchar(200) NOT NULL,
  `client_phone` varchar(200) NOT NULL,
  `client_number` varchar(200) NOT NULL,
  `client_email` varchar(200) NOT NULL,
  `client_adr` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ib_bankaccounts`
--

INSERT INTO `ib_bankaccounts` (`account_id`, `acc_name`, `account_number`, `acc_type`, `acc_rates`, `acc_status`, `acc_amount`, `client_id`, `client_name`, `client_national_id`, `client_phone`, `client_number`, `client_email`, `client_adr`, `created_at`) VALUES
(1, 'Fixed', '254761893', 'Fixed Deposit Account ', '40', 'Active', '100', '3', 'Sangita Dhodhary', '1234567891', '9760381452', 'iBank-CLIENT-5721', 'sangita@gmail.com', 'ktm', '2024-03-26 18:53:40.060397'),
(2, 'Recurring', '529034678', 'Recurring deposits ', '15', 'Active', '10', '4', 'Sangit Tamang', '1234567892', '9760381457', 'iBank-CLIENT-8452', 'sangit@gmail.com', 'ktm', '2024-03-26 19:08:04.047896'),
(3, 'Retirment', '329046517', 'Recurring deposits ', '15', 'Active', '2311', '2', 'Sandhya Tamang', '1234567890', '9760381451', 'iBank-CLIENT-1647', 'sandhya@gmail.com', 'ktm', '2024-03-26 19:09:26.490201'),
(6, 'kt', '931028546', ' Retirement ', '10', 'Active', '0', '11', 'karma tamang', '4567812369', '9812453651', 'iBank-CLIENT-5293', 'tamang@gmail.com', 'ktm', '2024-03-26 04:02:54.499634'),
(7, 'ram', '578109436', 'Fixed Deposit Account ', '40', 'Active', '9700', '12', 'raman', '1545326124', '9763635241', 'iBank-CLIENT-2681', 'raman@gmail.com', 'ktm', '2024-03-26 19:17:06.200002'),
(8, 'sd', '182504763', 'Fixed Deposit Account ', '40', 'Active', '910', '9', 'clienttest2', '6541287365', '9745632541', 'iBank-CLIENT-4618', 'clienttest2@gmail.com', 'Madhyapur thimi', '2024-03-26 18:49:30.360013'),
(9, 'rabi', '362189704', 'Savings ', '20', 'Active', '1020', '16', 'rabi', '7485575748', '9896959400', 'iBank-CLIENT-7041', 'rabi@gmail.com', 'ktm', '2024-03-26 19:23:15.791728'),
(12, 'hira', '508721936', 'Fixed Deposit Account ', '40', 'Active', '0', '18', 'hira', '3625362541', '9785225863', 'iBank-CLIENT-9036', 'hira@gmail.com', 'ktm', '2024-03-26 11:41:27.955183');

-- --------------------------------------------------------

--
-- Table structure for table `ib_clients`
--

CREATE TABLE `ib_clients` (
  `client_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `national_id` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `profile_pic` varchar(200) NOT NULL,
  `client_number` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ib_clients`
--

INSERT INTO `ib_clients` (`client_id`, `name`, `national_id`, `phone`, `address`, `email`, `password`, `profile_pic`, `client_number`) VALUES
(2, 'Sandhya Tamang', '1234567890', '9760381451', 'ktm', 'sandhya@gmail.com', '9edd4b9abe263967cd607866ce74b0682f781082', '_516e2734-c99f-45e8-8c11-f54b750a1508.jpeg', 'iBank-CLIENT-1647'),
(3, 'Sangita Dhodhary', '1234567891', '9760381452', 'ktm', 'sangita@gmail.com', '9edd4b9abe263967cd607866ce74b0682f781082', 'OIP.jpeg', 'iBank-CLIENT-5721'),
(4, 'Sangit Tamang', '1234567892', '9760381457', 'ktm', 'sangit@gmail.com', '9edd4b9abe263967cd607866ce74b0682f781082', '_15038413-aa69-4f50-ba64-73ad73107b7d.jpeg', 'iBank-CLIENT-8452'),
(5, 'Sandhas Dhodary', '1234567899', '9760381454', 'ktm', 'sandhas@gmail.com', '9edd4b9abe263967cd607866ce74b0682f781082', '_57e265a4-a2cd-4b7b-89e0-a3254d0b3358.jpeg', 'iBank-CLIENT-1736'),
(8, 'clienttest1', '9865321402', '9810253105', 'ktm', 'clienttest1@gmail.com', '79cb85b08a765c3e8e9abcadcf284af97e498401', '', 'iBank-CLIENT-4520'),
(9, 'clienttest2', '6541287365', '9745632541', 'Madhyapur thimi', 'clienttest2@gmail.com', '6e13cf9afe69c9d43ed3ab17a8fe222bf658eec4', '', 'iBank-CLIENT-4618'),
(11, 'karma tamang', '4567812369', '9812453651', 'ktm', 'tamang@gmail.com', '771b95fee6aea577253893d3fdb812996aee776a', '', 'iBank-CLIENT-5293'),
(12, 'raman', '1545326124', '9763635241', 'ktm', 'raman@gmail.com', '9edd4b9abe263967cd607866ce74b0682f781082', '', 'iBank-CLIENT-2681'),
(13, 'supreme jr.', '9865741245', '9815624361', 'ktm', 'supreme@gmail.com', '9edd4b9abe263967cd607866ce74b0682f781082', '', 'iBank-CLIENT-3957'),
(15, 'ronish pra', '8956413221', '9765652513', 'BKT', 'ronish@gmail.com', '9edd4b9abe263967cd607866ce74b0682f781082', '', 'iBank-CLIENT-1028'),
(16, 'rabi', '7485575748', '9896959400', 'ktm', 'rabi@gmail.com', '9edd4b9abe263967cd607866ce74b0682f781082', '', 'iBank-CLIENT-7041'),
(18, 'hira', '3625362541', '9785225863', 'ktm', 'hira@gmail.com', '9edd4b9abe263967cd607866ce74b0682f781082', '_57e265a4-a2cd-4b7b-89e0-a3254d0b3358.jpeg', 'iBank-CLIENT-9036'),
(19, 'gary', '9865654123', '9865324102', 'BKT', 'gary@gmail.com', '9edd4b9abe263967cd607866ce74b0682f781082', '_15038413-aa69-4f50-ba64-73ad73107b7d.jpeg', 'iBank-CLIENT-0487'),
(20, 'light', '1234567891', '9765656532', 'ktm', 'light@gmail.com', '9edd4b9abe263967cd607866ce74b0682f781082', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `ib_loanpayments`
--

CREATE TABLE `ib_loanpayments` (
  `payment_id` int(11) NOT NULL,
  `loan_id` int(11) DEFAULT NULL,
  `name` varchar(150) NOT NULL,
  `loan_amount` decimal(10,2) DEFAULT NULL,
  `loan_type` enum('personal','business','education','mortgage','other') NOT NULL,
  `tr_code` varchar(150) DEFAULT NULL,
  `tr_type` varchar(150) DEFAULT NULL,
  `tr_status` varchar(150) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `borrower_national_id` bigint(20) NOT NULL,
  `payment_amt` decimal(10,2) NOT NULL,
  `interest_rate` decimal(5,2) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `due_amount` decimal(10,2) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ib_notifications`
--

CREATE TABLE `ib_notifications` (
  `notification_id` int(20) NOT NULL,
  `notification_details` text NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ib_notifications`
--

INSERT INTO `ib_notifications` (`notification_id`, `notification_details`, `created_at`) VALUES
(2, 'Sangita Dhodhary has deposited $1000 to bank account 254761893', '2024-03-13 14:27:11.464169'),
(3, 'Sangita Dhodhary has deposited $1000 to bank account 254761893', '2024-03-13 14:29:52.849676'),
(4, 'Sangita Dhodhary has deposited $1000 to bank account 254761893', '2024-03-13 14:34:45.042984'),
(5, 'Sangita Dhodhary has withdrawn $100 from bank account 254761893', '2024-03-13 14:43:31.936911'),
(6, 'Sangita Dhodhary has withdrawn $1000 from bank account 254761893', '2024-03-13 14:43:43.737873'),
(7, 'Sangita Dhodhary has withdrawn $2100 from bank account 254761893', '2024-03-13 14:43:52.265206'),
(8, 'Sangita Dhodhary has withdrawn $4200 from bank account 254761893', '2024-03-13 14:44:07.832668'),
(9, 'Sangita Dhodhary has withdrawn $8400 from bank account 254761893', '2024-03-13 14:44:13.312763'),
(10, 'Sangita Dhodhary Has Withdrawn $ 120 From Bank Account 254761893', '2024-03-13 15:28:52.263378'),
(11, 'Sangita Dhodhary Has Withdrawn $ 10980 From Bank Account 254761893', '2024-03-13 15:29:46.614900'),
(12, 'Sangita Dhodhary Has Withdrawn $ 100 From Bank Account 254761893', '2024-03-13 15:38:09.925620'),
(13, 'Sangita Dhodhary Has Withdrawn $ 10980 From Bank Account 254761893', '2024-03-13 15:38:38.878899'),
(14, 'Sangita Dhodhary Has Withdrawn Ksh 100 From Bank Account 254761893', '2024-03-13 15:49:02.402172'),
(15, 'Sangita Dhodhary has withdrawn Ksh 100 from bank account 254761893', '2024-03-13 15:52:46.587354'),
(16, 'Sangita Dhodhary has withdrawn Ksh 10880 from bank account 254761893', '2024-03-13 15:53:16.077694'),
(17, 'Sangita Dhodhary has withdrawn Ksh 5 from bank account 254761893', '2024-03-13 15:59:54.106134'),
(18, 'Sangita Dhodhary has withdrawn Ksh 0 from bank account 254761893', '2024-03-13 16:00:17.683047'),
(19, 'Sangita Dhodhary Has Transferred $ 10 From Bank Account 254761893 To Bank Account 529034678', '2024-03-13 16:09:06.808404'),
(20, 'Sangita Dhodhary Has Transferred $10 From Bank Account 254761893 To Bank Account 529034678', '2024-03-13 16:14:20.240885'),
(21, 'Sangita Dhodhary Has Transferred $100 From Bank Account 254761893 To Bank Account 254761893', '2024-03-13 16:14:30.368693'),
(22, 'Sangita Dhodhary Has Transferred $10 From Bank Account 254761893 To Bank Account 254761893', '2024-03-13 16:14:42.456231'),
(23, 'rabi Has Deposited $ 1000 To Bank Account 362189704', '2024-03-26 11:37:11.313437'),
(24, 'Sangita Dhodhary has withdrawn Ksh 0 from bank account 254761893', '2024-03-26 16:53:02.892898'),
(25, 'Sangita Dhodhary Has Deposited $ 100 To Bank Account 254761893', '2024-03-26 16:55:38.355989'),
(26, 'hira Has Deposited $ 1000 To Bank Account 508721936', '2024-03-26 16:55:51.829241'),
(27, 'hira Has Deposited $ 1000 To Bank Account 508721936', '2024-03-26 16:56:59.326123'),
(28, 'hira Has Deposited $ 105 To Bank Account 508721936', '2024-03-26 16:57:04.967957'),
(29, 'hira Has Deposited $ 105 To Bank Account 508721936', '2024-03-26 16:58:27.002014'),
(30, 'hira Has Deposited $ 1000 To Bank Account 508721936', '2024-03-26 16:58:33.550781'),
(31, 'alish Has Deposited $ 1000 To Bank Account 214603985', '2024-03-26 17:00:37.250376'),
(32, 'Sangita Dhodhary Has Deposited $ 1000 To Bank Account 254761893', '2024-03-26 17:35:49.199933'),
(33, 'Sangita Dhodhary Has Deposited $ -100 To Bank Account 254761893', '2024-03-26 17:35:54.535977'),
(34, 'Sangita Dhodhary Has Deposited $ -100 To Bank Account 254761893', '2024-03-26 17:36:06.062222'),
(35, 'Sangit Tamang Has Deposited $ 1000 To Bank Account 529034678', '2024-03-26 17:36:17.139375'),
(36, 'Sandhya Tamang Has Deposited $ 1000 To Bank Account 329046517', '2024-03-26 17:36:29.150564'),
(37, 'karma tamang Has Deposited $ 1000 To Bank Account 931028546', '2024-03-26 17:36:41.447166'),
(38, 'raman Has Deposited $ 1000 To Bank Account 578109436', '2024-03-26 17:36:53.149651'),
(39, 'clienttest2 Has Deposited $ 1000 To Bank Account 182504763', '2024-03-26 17:37:04.379349'),
(40, 'rabi Has Deposited $ 1000 To Bank Account 362189704', '2024-03-26 17:37:14.179450'),
(41, 'hira Has Deposited $ 1000 To Bank Account 508721936', '2024-03-26 17:37:23.703415'),
(42, 'hira Has Deposited $ 1000 To Bank Account 508721936', '2024-03-26 17:39:00.580458'),
(43, 'hira Has Deposited $ 1000 To Bank Account 508721936', '2024-03-26 17:43:01.676800'),
(44, 'Sangita Dhodhary has deposited 100 to bank account 254761893', '2024-03-26 17:45:46.743262'),
(45, 'rabi has deposited 10 to bank account 362189704', '2024-03-26 17:50:25.641374'),
(46, 'rabi has deposited 1000 to bank account 362189704', '2024-03-26 17:50:30.489009'),
(47, 'hira Has Deposited $ 1000 To Bank Account 508721936', '2024-03-26 17:50:55.593723'),
(48, 'hira Has Withdrawn $ 10 From Bank Account 508721936', '2024-03-26 17:51:11.402311'),
(49, 'hira Has Withdrawn $ 7220 From Bank Account 508721936', '2024-03-26 17:51:36.007969'),
(50, 'hira Has Withdrawn $ 200 From Bank Account 508721936', '2024-03-26 17:51:41.752987'),
(51, 'hira Has Withdrawn $ 7000 From Bank Account 508721936', '2024-03-26 17:51:47.593670'),
(52, 'hira Has Deposited $ 1000 To Bank Account 508721936', '2024-03-26 17:53:38.460000'),
(53, 'hira Has Withdrawn $ 1000 From Bank Account 508721936', '2024-03-26 17:54:08.268204'),
(54, 'hira Has Withdrawn $ 23640 From Bank Account 508721936', '2024-03-26 17:54:20.250144'),
(55, 'hira Has Withdrawn $ 10 From Bank Account 508721936', '2024-03-26 17:54:24.147402'),
(56, 'hira Has Withdrawn $ 10000 From Bank Account 508721936', '2024-03-26 17:54:29.735168'),
(57, 'hira Has Withdrawn $ 57290 From Bank Account 508721936', '2024-03-26 17:54:55.014361'),
(58, 'hira Has Withdrawn $ 250 From Bank Account 508721936', '2024-03-26 17:55:01.599198'),
(59, 'hira Has Withdrawn $ 114830 From Bank Account 508721936', '2024-03-26 17:55:23.563609'),
(60, 'hira Has Withdrawn $ 1000 From Bank Account 508721936', '2024-03-26 17:55:31.277142'),
(61, 'hira Has Deposited $ 1000000 To Bank Account 508721936', '2024-03-26 18:08:14.635135'),
(62, 'hira Has Deposited $ 10 To Bank Account 508721936', '2024-03-26 18:08:25.164681'),
(63, 'raman Has Deposited $ 100 To Bank Account 578109436', '2024-03-26 18:11:35.121896'),
(64, 'raman Has Deposited $ 1000000 To Bank Account 578109436', '2024-03-26 18:14:09.852745'),
(65, 'raman Has Deposited $ 10000000000000000 To Bank Account 578109436', '2024-03-26 18:14:15.522479'),
(66, 'raman Has Deposited $ 100 To Bank Account 578109436', '2024-03-26 18:15:06.741313'),
(67, 'raman has deposited 100 to bank account 578109436', '2024-03-26 18:15:35.121273'),
(68, 'raman has deposited 10000 to bank account 578109436', '2024-03-26 18:15:40.053824'),
(69, 'raman has deposited 10000000 to bank account 578109436', '2024-03-26 18:15:44.679783'),
(70, 'raman Has Deposited $ 10000000 To Bank Account 578109436', '2024-03-26 18:16:14.833634'),
(71, 'raman Has Deposited $ 10000000 To Bank Account 578109436', '2024-03-26 18:16:58.515838'),
(72, 'raman Has Deposited $ 1100000 To Bank Account 578109436', '2024-03-26 18:17:03.844622'),
(73, 'raman Has Deposited $ 1000000000000000 To Bank Account 578109436', '2024-03-26 18:17:08.731736'),
(74, 'raman Has Deposited $ 1000000000000000 To Bank Account 578109436', '2024-03-26 18:17:42.813618'),
(75, 'raman Has Deposited $ 10000000000 To Bank Account 578109436', '2024-03-26 18:17:47.120772'),
(76, 'raman Has Deposited $ 10000000000 To Bank Account 578109436', '2024-03-26 18:18:31.993260'),
(77, 'raman Has Deposited $ 10000000000000 To Bank Account 578109436', '2024-03-26 18:18:37.067021'),
(78, 'raman Has Deposited $ -100 To Bank Account 578109436', '2024-03-26 18:18:43.835161'),
(79, 'raman Has Deposited $ -100 To Bank Account 578109436', '2024-03-26 18:19:19.525879'),
(80, 'raman Has Deposited $ -10 To Bank Account 578109436', '2024-03-26 18:19:27.100655'),
(81, 'raman Has Deposited $ -10 To Bank Account 578109436', '2024-03-26 18:19:57.261144'),
(82, 'raman Has Deposited $ -10 To Bank Account 578109436', '2024-03-26 18:22:37.114800'),
(83, 'raman Has Deposited $ 10 To Bank Account 578109436', '2024-03-26 18:22:44.382442'),
(84, 'Sandhya Tamang has deposited $1000 to bank account 329046517', '2024-03-26 18:30:18.967167'),
(85, 'Sandhya Tamang has deposited $1000 to bank account 329046517', '2024-03-26 18:30:29.654433'),
(86, 'Sandhya Tamang has deposited $101 to bank account 329046517', '2024-03-26 18:30:37.351140'),
(87, 'rabi has deposited $100 to bank account 362189704', '2024-03-26 18:42:09.967168'),
(88, 'rabi has withdrawn Ksh 10 from bank account 362189704', '2024-03-26 18:42:53.353135'),
(89, 'rabi has withdrawn Ksh 50 from bank account 362189704', '2024-03-26 18:43:01.225140'),
(90, 'rabi has deposited $1000 to bank account 362189704', '2024-03-26 18:44:38.653367'),
(91, 'clienttest2 has deposited $1000 to bank account 182504763', '2024-03-26 18:48:29.286262'),
(92, 'clienttest2 has withdrawn Ksh 100 from bank account 182504763', '2024-03-26 18:49:25.133702'),
(93, 'clienttest2 has withdrawn Ksh -10 from bank account 182504763', '2024-03-26 18:49:30.364956'),
(94, 'Sangita Dhodhary Has Deposited $ 10 To Bank Account 254761893', '2024-03-26 18:52:17.699147'),
(95, 'Sangita Dhodhary has deposited $100 to bank account 254761893', '2024-03-26 18:53:40.058657'),
(96, 'Sandhya Tamang has deposited $100 to bank account 329046517', '2024-03-26 18:59:53.825136'),
(97, 'rabi Has Transferred $10 From Bank Account 362189704 To Bank Account 529034678', '2024-03-26 19:08:04.050898'),
(98, 'rabi Has Transferred $-100 From Bank Account 362189704 To Bank Account 578109436', '2024-03-26 19:08:15.143438'),
(99, 'rabi Has Transferred $100 From Bank Account 362189704 To Bank Account 362189704', '2024-03-26 19:08:25.425885'),
(100, 'rabi Has Transferred $10 From Bank Account 362189704 To Bank Account 329046517', '2024-03-26 19:08:43.098647'),
(101, 'rabi Has Transferred $1000 From Bank Account 362189704 To Bank Account 362189704', '2024-03-26 19:09:01.161612'),
(102, 'rabi Has Transferred $100 From Bank Account 362189704 To Bank Account 329046517', '2024-03-26 19:09:26.496196'),
(103, 'raman has deposited $10000 to bank account 578109436', '2024-03-26 19:11:27.226391'),
(104, 'raman has withdrawn Ksh 100 from bank account 578109436', '2024-03-26 19:11:38.950993'),
(105, 'raman has withdrawn Ksh -10 from bank account 578109436', '2024-03-26 19:11:43.794761'),
(106, 'raman has withdrawn Ksh 60 from bank account 578109436', '2024-03-26 19:11:51.500617'),
(107, 'raman has withdrawn Ksh 60 from bank account 578109436', '2024-03-26 19:17:00.763743'),
(108, 'raman has withdrawn Ksh -10 from bank account 578109436', '2024-03-26 19:17:06.203802'),
(109, 'rabi Has Transferred $100 From Bank Account 362189704 To Bank Account 362189704', '2024-03-26 19:23:15.793166');

-- --------------------------------------------------------

--
-- Table structure for table `ib_password_resets`
--

CREATE TABLE `ib_password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `reset_token` varchar(255) NOT NULL,
  `status` enum('sucess','approve','pending') DEFAULT 'pending',
  `position` enum('admin','manager','cad','loan','cash','client') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user` enum('csd','loan','cash','manager','client') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ib_staff`
--

CREATE TABLE `ib_staff` (
  `staff_id` int(20) NOT NULL,
  `name` varchar(200) NOT NULL,
  `staff_number` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `sex` varchar(200) NOT NULL,
  `profile_pic` varchar(200) NOT NULL,
  `staff_type` varchar(100) NOT NULL,
  `staff_position` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ib_staff`
--

INSERT INTO `ib_staff` (`staff_id`, `name`, `staff_number`, `phone`, `email`, `password`, `sex`, `profile_pic`, `staff_type`, `staff_position`) VALUES
(1, 'Sonima Tamange', 'iBank-STAFF-0649', '9860381454', 'csd@gmail.com', '9edd4b9abe263967cd607866ce74b0682f781082', 'Select Gender', 'OIP.jpeg', '', 'CSD'),
(2, 'Sonim Tamange', 'iBank-STAFF-5862', '9860381451', 'loan@gmail.com', '9edd4b9abe263967cd607866ce74b0682f781082', 'Male', '', '', 'Cash'),
(3, 'Sobit Lama', 'iBank-STAFF-4271', '9860381452', 'loan@gmail.com', '9edd4b9abe263967cd607866ce74b0682f781082', 'Male', '_a269f9c7-0392-46da-9f78-6e96833cdda9.jpeg', '', 'Loan'),
(4, 'Sobita Lama', 'iBank-STAFF-1367', '9860381456', 'manager@gmail.com', '9edd4b9abe263967cd607866ce74b0682f781082', 'Female', 'OIP (1).jpeg', '', 'Manager'),
(5, 'Prinsh Khadka', 'iBank-STAFF-9107', '9801234562', 'prinsh@gmail.com', '9edd4b9abe263967cd607866ce74b0682f781082', 'Select Gender', '_b5f09223-01d5-4110-83f5-e09a2ce208af.jpg', '', 'Manager'),
(7, 'loantest1', 'iBank-STAFF-3594', '9841052001', 'loantest1@gmail.com', '9edd4b9abe263967cd607866ce74b0682f781082', 'Male', '', '', 'Loan'),
(8, 'csd1', 'iBank-STAFF-7058', '9701234560', 'csd1@gmail.com', '771b95fee6aea577253893d3fdb812996aee776a', 'Male', '', '', 'CSD'),
(9, 'kira', 'iBank-STAFF-1289', '9865324164', 'manager1@gmail.com', '9edd4b9abe263967cd607866ce74b0682f781082', 'Female', '_b5f09223-01d5-4110-83f5-e09a2ce208af.jpg', '', 'Manager');

-- --------------------------------------------------------

--
-- Table structure for table `ib_systemsettings`
--

CREATE TABLE `ib_systemsettings` (
  `id` int(20) NOT NULL,
  `sys_name` longtext NOT NULL,
  `sys_tagline` longtext NOT NULL,
  `sys_logo` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ib_systemsettings`
--

INSERT INTO `ib_systemsettings` (`id`, `sys_name`, `sys_tagline`, `sys_logo`) VALUES
(1, 'SBS Banking', 'Financial success at every service we offer.', 'sbsbank.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `ib_transactions`
--

CREATE TABLE `ib_transactions` (
  `tr_id` int(20) NOT NULL,
  `tr_code` varchar(200) NOT NULL,
  `account_id` varchar(200) NOT NULL,
  `acc_name` varchar(200) NOT NULL,
  `account_number` varchar(200) NOT NULL,
  `acc_type` varchar(200) NOT NULL,
  `acc_amount` varchar(200) NOT NULL,
  `tr_type` varchar(200) NOT NULL,
  `tr_status` varchar(200) NOT NULL,
  `client_id` varchar(200) NOT NULL,
  `client_name` varchar(200) NOT NULL,
  `client_national_id` varchar(200) NOT NULL,
  `transaction_amt` varchar(200) NOT NULL,
  `client_phone` varchar(200) NOT NULL,
  `receiving_acc_no` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `receiving_acc_name` varchar(200) NOT NULL,
  `receiving_acc_holder` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ib_transactions`
--

INSERT INTO `ib_transactions` (`tr_id`, `tr_code`, `account_id`, `acc_name`, `account_number`, `acc_type`, `acc_amount`, `tr_type`, `tr_status`, `client_id`, `client_name`, `client_national_id`, `transaction_amt`, `client_phone`, `receiving_acc_no`, `created_at`, `receiving_acc_name`, `receiving_acc_holder`) VALUES
(4, 'HFwdkIG9TxzOv2mySDrs', '1', 'Fixed', '254761893', 'Fixed Deposit Account ', '100', 'Deposit', 'Success ', '3', 'Sangita Dhodhary', '1234567891', '1000', '9760381452', '', '2024-03-26 18:53:40.062513', '', ''),
(6, 'SCcKHfR6iXp5wWutIYTA', '1', 'Fixed', '254761893', 'Fixed Deposit Account ', '100', 'Withdrawal', 'Success ', '3', 'Sangita Dhodhary', '1234567891', '1000', '9760381452', '', '2024-03-26 18:53:40.062513', '', ''),
(7, 'UemkbXFdPJTVgZaMofyr', '1', 'Fixed', '254761893', 'Fixed Deposit Account ', '100', 'Withdrawal', 'Success ', '3', 'Sangita Dhodhary', '1234567891', '2100', '9760381452', '', '2024-03-26 18:53:40.062513', '', ''),
(8, 'obxZU9wB5ENq4cG6lgzt', '1', 'Fixed', '254761893', 'Fixed Deposit Account ', '100', 'Withdrawal', 'Success ', '3', 'Sangita Dhodhary', '1234567891', '4200', '9760381452', '', '2024-03-26 18:53:40.062513', '', ''),
(9, 'PnhlFUvfeAET1YcabzyR', '1', 'Fixed', '254761893', 'Fixed Deposit Account ', '100', 'Withdrawal', 'Success ', '3', 'Sangita Dhodhary', '1234567891', '8400', '9760381452', '', '2024-03-26 18:53:40.062513', '', ''),
(10, 'PnhlFUvfeAET1YcabzyR', '1', 'Fixed', '254761893', 'Fixed Deposit Account ', '100', 'Withdrawal', 'Success ', '3', 'Sangita Dhodhary', '1234567891', '8400', '9760381452', '', '2024-03-26 18:53:40.062513', '', ''),
(11, 'QhVWFvkcpgStdOrKLE8z', '1', 'Fixed', '254761893', 'Fixed Deposit Account ', '100', 'Withdrawal', 'Success ', '3', 'Sangita Dhodhary', '1234567891', '100', '9760381452', '', '2024-03-26 18:53:40.062513', '', ''),
(12, 'J189AWyfEgTtwNOXFvmd', '1', 'Fixed', '254761893', 'Fixed Deposit Account ', '100', 'Withdrawal', 'Success ', '3', 'Sangita Dhodhary', '1234567891', '10', '9760381452', '', '2024-03-26 18:53:40.062513', '', ''),
(13, 'lpYb613ygDAQuBNhCJnr', '1', 'Fixed', '254761893', 'Fixed Deposit Account ', '100', 'Withdrawal', 'Success ', '3', 'Sangita Dhodhary', '1234567891', '100', '9760381452', '', '2024-03-26 18:53:40.062513', '', ''),
(15, 'y9GkLgcHRKrQ2mSZxjzB', '1', 'Fixed', '254761893', 'Fixed Deposit Account ', '100', 'Withdrawal', 'Success ', '3', 'Sangita Dhodhary', '1234567891', '5490', '9760381452', '', '2024-03-26 18:53:40.062513', '', ''),
(16, 'y9GkLgcHRKrQ2mSZxjzB', '1', 'Fixed', '254761893', 'Fixed Deposit Account ', '100', 'Withdrawal', 'Success ', '3', 'Sangita Dhodhary', '1234567891', '5490', '9760381452', '', '2024-03-26 18:53:40.062513', '', ''),
(17, 'y9GkLgcHRKrQ2mSZxjzB', '1', 'Fixed', '254761893', 'Fixed Deposit Account ', '100', 'Withdrawal', 'Success ', '3', 'Sangita Dhodhary', '1234567891', '5490', '9760381452', '', '2024-03-26 18:53:40.062513', '', ''),
(18, '0FXzjZEUBcOSvykNa2LM', '1', 'Fixed', '254761893', 'Fixed Deposit Account ', '100', 'Withdrawal', 'Success ', '3', 'Sangita Dhodhary', '1234567891', '120', '9760381452', '', '2024-03-26 18:53:40.062513', '', ''),
(19, 'RpJHh7zbtnTfGPvcw6kK', '1', 'Fixed', '254761893', 'Fixed Deposit Account ', '100', 'Withdrawal', 'Success ', '3', 'Sangita Dhodhary', '1234567891', '10980', '9760381452', '', '2024-03-26 18:53:40.062513', '', ''),
(20, '9pCb20YwcqDzyjv4JWN3', '1', 'Fixed', '254761893', 'Fixed Deposit Account ', '100', 'Withdrawal', 'Success ', '3', 'Sangita Dhodhary', '1234567891', '100', '9760381452', '', '2024-03-26 18:53:40.062513', '', ''),
(21, 'QAFLlCarYfRiwWqg7uo8', '1', 'Fixed', '254761893', 'Fixed Deposit Account ', '100', 'Withdrawal', 'Success ', '3', 'Sangita Dhodhary', '1234567891', '10980', '9760381452', '', '2024-03-26 18:53:40.062513', '', ''),
(22, 'qSk67FgiZ5z02QOvVaWX', '1', 'Fixed', '254761893', 'Fixed Deposit Account ', '100', 'Withdrawal', 'Success ', '3', 'Sangita Dhodhary', '1234567891', '100', '9760381452', '', '2024-03-26 18:53:40.062513', '', ''),
(23, 'qSk67FgiZ5z02QOvVaWX', '1', 'Fixed', '254761893', 'Fixed Deposit Account ', '100', 'Withdrawal', 'Success ', '3', 'Sangita Dhodhary', '1234567891', '100', '9760381452', '', '2024-03-26 18:53:40.062513', '', ''),
(24, '9CwPFpG5Q0XEzuITOBUe', '1', 'Fixed', '254761893', 'Fixed Deposit Account ', '100', 'Withdrawal', 'Success ', '3', 'Sangita Dhodhary', '1234567891', '10880', '9760381452', '', '2024-03-26 18:53:40.062513', '', ''),
(25, 'Wdowzs5kgcZQqxMSPLj1', '1', 'Fixed', '254761893', 'Fixed Deposit Account ', '100', 'Withdrawal', 'Success ', '3', 'Sangita Dhodhary', '1234567891', '5', '9760381452', '', '2024-03-26 18:53:40.062513', '', ''),
(26, 'JvdVbicRCHSq974we1fA', '1', 'Fixed', '254761893', 'Fixed Deposit Account ', '100', 'Withdrawal', 'Success ', '3', 'Sangita Dhodhary', '1234567891', '0', '9760381452', '', '2024-03-26 18:53:40.062513', '', ''),
(27, 'wxgRUpeVLsHht5QibmN7', '1', 'Fixed', '254761893', 'Fixed Deposit Account ', '110', 'Transfer', 'Success ', '3', 'Sangita Dhodhary', '1234567891', '10', '9760381452', '529034678', '2024-03-26 19:08:04.049928', 'Recurring', 'Sangit Tamang'),
(28, 'wxgRUpeVLsHht5QibmN7', '1', 'Fixed', '254761893', 'Fixed Deposit Account ', '110', 'Transfer', 'Success ', '3', 'Sangita Dhodhary', '1234567891', '10', '9760381452', '529034678', '2024-03-26 19:08:04.049928', 'Recurring', 'Sangit Tamang'),
(29, 'TkgJjnRi0cSFfxsVhZyA', '1', 'Fixed', '254761893', 'Fixed Deposit Account ', '100', 'Transfer', 'Success ', '3', 'Sangita Dhodhary', '1234567891', '100', '9760381452', '254761893', '2024-03-26 18:53:40.062513', 'Fixed', 'Sangita Dhodhary'),
(30, '0Ue6X7V2bpKcNoBlHPwt', '1', 'Fixed', '254761893', 'Fixed Deposit Account ', '100', 'Transfer', 'Success ', '3', 'Sangita Dhodhary', '1234567891', '10', '9760381452', '254761893', '2024-03-26 18:53:40.062513', 'Fixed', 'Sangita Dhodhary'),
(31, 'qPUOdZ75hwVs8ryiSN1z', '9', 'rabi', '362189704', 'Savings ', '-220', 'Deposit', 'Success ', '16', 'rabi', '7485575748', '1000', '9896959400', '', '2024-03-26 19:23:15.791971', '', ''),
(32, 'X4zpMtd180PTKeQOhYWx', '1', 'Fixed', '254761893', 'Fixed Deposit Account ', '100', 'Withdrawal', 'Success ', '3', 'Sangita Dhodhary', '1234567891', '0', '9760381452', '', '2024-03-26 18:53:40.062513', '', ''),
(33, 'Glhjz7uWXyQqKRFVr9x4', '1', 'Fixed', '254761893', 'Fixed Deposit Account ', '100', 'Deposit', 'Success ', '3', 'Sangita Dhodhary', '1234567891', '100', '9760381452', '', '2024-03-26 18:53:40.062513', '', ''),
(34, 'loHhf2BzWjqtNXn8ZwOL', '12', 'hira', '508721936', 'Fixed Deposit Account ', '', 'Deposit', 'Success ', '18', 'hira', '3625362541', '1000', '9785225863', '', '2024-03-26 16:55:51.826946', '', ''),
(35, 'loHhf2BzWjqtNXn8ZwOL', '12', 'hira', '508721936', 'Fixed Deposit Account ', '', 'Deposit', 'Success ', '18', 'hira', '3625362541', '1000', '9785225863', '', '2024-03-26 16:56:59.321694', '', ''),
(36, 'I6ZkGvFqWDluz215sagn', '12', 'hira', '508721936', 'Fixed Deposit Account ', '', 'Deposit', 'Success ', '18', 'hira', '3625362541', '105', '9785225863', '', '2024-03-26 16:57:04.953548', '', ''),
(37, 'I6ZkGvFqWDluz215sagn', '12', 'hira', '508721936', 'Fixed Deposit Account ', '', 'Deposit', 'Success ', '18', 'hira', '3625362541', '105', '9785225863', '', '2024-03-26 16:58:26.999206', '', ''),
(38, 'nkV8lrESOMCzaK1LcFXJ', '12', 'hira', '508721936', 'Fixed Deposit Account ', '', 'Deposit', 'Success ', '18', 'hira', '3625362541', '1000', '9785225863', '', '2024-03-26 16:58:33.548137', '', ''),
(40, 'dM3TyZRvrYbuqcADO09o', '1', 'Fixed', '254761893', 'Fixed Deposit Account ', '100', 'Deposit', 'Success ', '3', 'Sangita Dhodhary', '1234567891', '1000', '9760381452', '', '2024-03-26 18:53:40.062513', '', ''),
(41, 'WQE6PepjwcGi9TNyXf4o', '1', 'Fixed', '254761893', 'Fixed Deposit Account ', '100', 'Deposit', 'Success ', '3', 'Sangita Dhodhary', '1234567891', '-100', '9760381452', '', '2024-03-26 18:53:40.062513', '', ''),
(42, 'WQE6PepjwcGi9TNyXf4o', '1', 'Fixed', '254761893', 'Fixed Deposit Account ', '100', 'Deposit', 'Success ', '3', 'Sangita Dhodhary', '1234567891', '-100', '9760381452', '', '2024-03-26 18:53:40.062513', '', ''),
(43, 'rmdLyAX481V5uoHMaOJP', '2', 'Recurring', '529034678', 'Recurring deposits ', '', 'Deposit', 'Success ', '4', 'Sangit Tamang', '1234567892', '1000', '9760381457', '', '2024-03-26 17:36:17.136659', '', ''),
(44, 'i6kOTY4vVqMhgxpjKDSN', '3', 'Retirment', '329046517', 'Recurring deposits ', '100', 'Deposit', 'Success ', '2', 'Sandhya Tamang', '1234567890', '1000', '9760381451', '', '2024-03-26 18:59:53.828798', '', ''),
(45, 'YbGFflgpUJvzoEjWTVNe', '6', 'kt', '931028546', ' Retirement ', '', 'Deposit', 'Success ', '11', 'karma tamang', '4567812369', '1000', '9812453651', '', '2024-03-26 17:36:41.443856', '', ''),
(46, 'pz89BQn3DHRgrjSmyGhT', '7', 'ram', '578109436', 'Fixed Deposit Account ', '10000', 'Deposit', 'Success ', '12', 'raman', '1545326124', '1000', '9763635241', '', '2024-03-26 19:11:27.228891', '', ''),
(47, 'z9dhxX2wQKAsvYTRPVy6', '8', 'sd', '182504763', 'Fixed Deposit Account ', '1000', 'Deposit', 'Success ', '9', 'clienttest2', '6541287365', '1000', '9745632541', '', '2024-03-26 18:48:29.289073', '', ''),
(48, 'Qm0953LyMPOhKlXZgY4T', '9', 'rabi', '362189704', 'Savings ', '-220', 'Deposit', 'Success ', '16', 'rabi', '7485575748', '1000', '9896959400', '', '2024-03-26 19:23:15.791971', '', ''),
(49, 'wH1Ymt4jh9VfpRWcuJ6a', '12', 'hira', '508721936', 'Fixed Deposit Account ', '', 'Deposit', 'Success ', '18', 'hira', '3625362541', '1000', '9785225863', '', '2024-03-26 17:37:23.699235', '', ''),
(50, '6kQgqWw3elNS0pUZMtsA', '12', 'hira', '508721936', 'Fixed Deposit Account ', '', 'Deposit', 'Success ', '18', 'hira', '3625362541', '1000', '9785225863', '', '2024-03-26 17:39:00.578203', '', ''),
(51, 'xKZTRbunEafkGQj9hm7U', '12', 'hira', '508721936', 'Fixed Deposit Account ', '', 'Deposit', 'Success ', '18', 'hira', '3625362541', '1000', '9785225863', '', '2024-03-26 17:43:01.673136', '', ''),
(52, 'l4FKfTZULgNSWqV2w3eD', '1', 'Fixed', '254761893', 'Fixed Deposit Account ', '100', 'Deposit', 'Success ', '3', 'Sangita Dhodhary', '1234567891', '100', '9760381452', '', '2024-03-26 18:53:40.062513', '', ''),
(53, 'jKfbeWJ5FIm3iXx46RPp', '9', 'rabi', '362189704', '0', '-220', 'Deposit', 'Success ', '16', 'rabi', '7485575748', '10', '9896959400', '', '2024-03-26 19:23:15.791971', '', ''),
(54, '8z1ekKdriTcCpao0m642', '9', 'rabi', '362189704', '0', '-220', 'Deposit', 'Success ', '16', 'rabi', '7485575748', '1000', '9896959400', '', '2024-03-26 19:23:15.791971', '', ''),
(55, 'CqY0PciXLsMS3RV8KWZ4', '12', 'hira', '508721936', 'Fixed Deposit Account ', '', 'Deposit', 'Success ', '18', 'hira', '3625362541', '1000', '9785225863', '', '2024-03-26 17:50:55.590843', '', ''),
(56, '2ULxlNpAnGuhioIzrJeK', '12', 'hira', '508721936', 'Fixed Deposit Account ', '', 'Withdrawal', 'Success ', '18', 'hira', '3625362541', '10', '9785225863', '', '2024-03-26 17:51:11.400296', '', ''),
(57, 'BjAEMbnG5gtVTpf2CxDw', '12', 'hira', '508721936', 'Fixed Deposit Account ', '', 'Withdrawal', 'Success ', '18', 'hira', '3625362541', '7220', '9785225863', '', '2024-03-26 17:51:36.004146', '', ''),
(58, 'TFRkS06owC89D2BN1dKr', '12', 'hira', '508721936', 'Fixed Deposit Account ', '', 'Withdrawal', 'Success ', '18', 'hira', '3625362541', '200', '9785225863', '', '2024-03-26 17:51:41.749249', '', ''),
(59, 'DtwEiCq7kX9ymRhjo1JB', '12', 'hira', '508721936', 'Fixed Deposit Account ', '', 'Withdrawal', 'Success ', '18', 'hira', '3625362541', '7000', '9785225863', '', '2024-03-26 17:51:47.590868', '', ''),
(60, 'eKdFNqXULg31DRu76rA9', '12', 'hira', '508721936', 'Fixed Deposit Account ', '', 'Deposit', 'Success ', '18', 'hira', '3625362541', '1000', '9785225863', '', '2024-03-26 17:53:38.457246', '', ''),
(61, '3cmiqo8zK1Y7PTAvCRIg', '12', 'hira', '508721936', 'Fixed Deposit Account ', '', 'Withdrawal', 'Success ', '18', 'hira', '3625362541', '1000', '9785225863', '', '2024-03-26 17:54:08.265536', '', ''),
(62, 'ZFys1tLekWKimJfQCT8x', '12', 'hira', '508721936', 'Fixed Deposit Account ', '', 'Withdrawal', 'Success ', '18', 'hira', '3625362541', '23640', '9785225863', '', '2024-03-26 17:54:20.246882', '', ''),
(63, 'sHXSKWyEZkUv70r4h5bz', '12', 'hira', '508721936', 'Fixed Deposit Account ', '', 'Withdrawal', 'Success ', '18', 'hira', '3625362541', '10', '9785225863', '', '2024-03-26 17:54:24.144048', '', ''),
(64, 'juEqVbUHIWYR7Gg6DJBo', '12', 'hira', '508721936', 'Fixed Deposit Account ', '', 'Withdrawal', 'Success ', '18', 'hira', '3625362541', '10000', '9785225863', '', '2024-03-26 17:54:29.732688', '', ''),
(65, 'DXbw7a95KPdk3L1unMBc', '12', 'hira', '508721936', 'Fixed Deposit Account ', '', 'Withdrawal', 'Success ', '18', 'hira', '3625362541', '57290', '9785225863', '', '2024-03-26 17:54:55.012596', '', ''),
(66, 'lwruhiIEPS98c57xtdUg', '12', 'hira', '508721936', 'Fixed Deposit Account ', '', 'Withdrawal', 'Success ', '18', 'hira', '3625362541', '250', '9785225863', '', '2024-03-26 17:55:01.597667', '', ''),
(67, 'zGQByxsWDY8lonEi6gAP', '12', 'hira', '508721936', 'Fixed Deposit Account ', '', 'Withdrawal', 'Success ', '18', 'hira', '3625362541', '114830', '9785225863', '', '2024-03-26 17:55:23.561257', '', ''),
(68, 'Q4Rhidkm5H2gcxVCEnzs', '12', 'hira', '508721936', 'Fixed Deposit Account ', '', 'Withdrawal', 'Success ', '18', 'hira', '3625362541', '1000', '9785225863', '', '2024-03-26 17:55:31.275627', '', ''),
(69, 'fYxWtsevJa8QoGbjSNmD', '12', 'hira', '508721936', 'Fixed Deposit Account ', '', 'Deposit', 'Success ', '18', 'hira', '3625362541', '1000000', '9785225863', '', '2024-03-26 18:08:14.632838', '', ''),
(70, 'MEIF3sN2tuAJq1X98ZYr', '12', 'hira', '508721936', 'Fixed Deposit Account ', '', 'Deposit', 'Success ', '18', 'hira', '3625362541', '10', '9785225863', '', '2024-03-26 18:08:25.162661', '', ''),
(71, 'ObQRHSkVdtWx5qMIZLzy', '7', 'ram', '578109436', 'Fixed Deposit Account ', '10000', 'Deposit', 'Success ', '12', 'raman', '1545326124', '100', '9763635241', '', '2024-03-26 19:11:27.228891', '', ''),
(72, 'X5Ebnm0zc7TovrJRwk1Q', '7', 'ram', '578109436', 'Fixed Deposit Account ', '10000', 'Deposit', 'Success ', '12', 'raman', '1545326124', '1000000', '9763635241', '', '2024-03-26 19:11:27.228891', '', ''),
(73, 'U7IpMv3m82tTJQofOS1G', '7', 'ram', '578109436', 'Fixed Deposit Account ', '10000', 'Deposit', 'Success ', '12', 'raman', '1545326124', '10000000000000000', '9763635241', '', '2024-03-26 19:11:27.228891', '', ''),
(74, 'ObQRHSkVdtWx5qMIZLzy', '7', 'ram', '578109436', 'Fixed Deposit Account ', '10000', 'Deposit', 'Success ', '12', 'raman', '1545326124', '100', '9763635241', '', '2024-03-26 19:11:27.228891', '', ''),
(75, 'ObQRHSkVdtWx5qMIZLzy', '7', 'ram', '578109436', '0', '10000', 'Deposit', 'Success ', '12', 'raman', '1545326124', '100', '9763635241', '', '2024-03-26 19:11:27.228891', '', ''),
(76, 'vhKAQCEFj524qU8SprN3', '7', 'ram', '578109436', '0', '10000', 'Deposit', 'Success ', '12', 'raman', '1545326124', '10000', '9763635241', '', '2024-03-26 18:15:40.051509', '', ''),
(77, '8hvj1Piyk0UG9fNgOmML', '7', 'ram', '578109436', '0', '10000', 'Deposit', 'Success ', '12', 'raman', '1545326124', '10000000', '9763635241', '', '2024-03-26 19:11:27.228891', '', ''),
(78, '8hvj1Piyk0UG9fNgOmML', '7', 'ram', '578109436', 'Fixed Deposit Account ', '10000', 'Deposit', 'Success ', '12', 'raman', '1545326124', '10000000', '9763635241', '', '2024-03-26 19:11:27.228891', '', ''),
(79, '8hvj1Piyk0UG9fNgOmML', '7', 'ram', '578109436', 'Fixed Deposit Account ', '10000', 'Deposit', 'Success ', '12', 'raman', '1545326124', '10000000', '9763635241', '', '2024-03-26 19:11:27.228891', '', ''),
(80, 'mG7Qx1yhoRPuZeJn5fvl', '7', 'ram', '578109436', 'Fixed Deposit Account ', '10000', 'Deposit', 'Success ', '12', 'raman', '1545326124', '1100000', '9763635241', '', '2024-03-26 19:11:27.228891', '', ''),
(81, 'gBRZxcQ2w1NJaVyUXtbL', '7', 'ram', '578109436', 'Fixed Deposit Account ', '10000', 'Deposit', 'Success ', '12', 'raman', '1545326124', '1000000000000000', '9763635241', '', '2024-03-26 19:11:27.228891', '', ''),
(82, 'gBRZxcQ2w1NJaVyUXtbL', '7', 'ram', '578109436', 'Fixed Deposit Account ', '10000', 'Deposit', 'Success ', '12', 'raman', '1545326124', '1000000000000000', '9763635241', '', '2024-03-26 19:11:27.228891', '', ''),
(83, 'dCHpgB6Mb4fuqkRayQTL', '7', 'ram', '578109436', 'Fixed Deposit Account ', '10000', 'Deposit', 'Success ', '12', 'raman', '1545326124', '10000000000', '9763635241', '', '2024-03-26 19:11:27.228891', '', ''),
(84, 'dCHpgB6Mb4fuqkRayQTL', '7', 'ram', '578109436', 'Fixed Deposit Account ', '10000', 'Deposit', 'Success ', '12', 'raman', '1545326124', '10000000000', '9763635241', '', '2024-03-26 19:11:27.228891', '', ''),
(85, 'dpnIAVO7ouURP1SwBqL6', '7', 'ram', '578109436', 'Fixed Deposit Account ', '10000', 'Deposit', 'Success ', '12', 'raman', '1545326124', '10000000000000', '9763635241', '', '2024-03-26 19:11:27.228891', '', ''),
(86, 'egEHt6yuSZT5D7o43bws', '7', 'ram', '578109436', 'Fixed Deposit Account ', '10000', 'Deposit', 'Success ', '12', 'raman', '1545326124', '-100', '9763635241', '', '2024-03-26 19:11:27.228891', '', ''),
(87, 'egEHt6yuSZT5D7o43bws', '7', 'ram', '578109436', 'Fixed Deposit Account ', '10000', 'Deposit', 'Success ', '12', 'raman', '1545326124', '-100', '9763635241', '', '2024-03-26 19:11:27.228891', '', ''),
(88, 'WuF6iMoYakZvKwPIQBT7', '7', 'ram', '578109436', 'Fixed Deposit Account ', '10000', 'Deposit', 'Success ', '12', 'raman', '1545326124', '-10', '9763635241', '', '2024-03-26 19:11:27.228891', '', ''),
(89, 'WuF6iMoYakZvKwPIQBT7', '7', 'ram', '578109436', 'Fixed Deposit Account ', '10000', 'Deposit', 'Success ', '12', 'raman', '1545326124', '-10', '9763635241', '', '2024-03-26 19:11:27.228891', '', ''),
(90, 'SjpGszhBr1oFMbnaDN9U', '7', 'ram', '578109436', 'Fixed Deposit Account ', '10000', 'Deposit', 'Success ', '12', 'raman', '1545326124', '-10', '9763635241', '', '2024-03-26 19:11:27.228891', '', ''),
(91, 'M6vI7YGgVLpxnuk2ZE4F', '7', 'ram', '578109436', 'Fixed Deposit Account ', '10000', 'Deposit', 'Success ', '12', 'raman', '1545326124', '10', '9763635241', '', '2024-03-26 19:11:27.228891', '', ''),
(92, 'BHNUeFOXuwsIoi0txLdl', '3', 'Retirment', '329046517', 'Recurring deposits ', '100', 'Deposit', 'Success ', '2', 'Sandhya Tamang', '1234567890', '1000', '9760381451', '', '2024-03-26 18:59:53.828798', '', ''),
(93, '1Y5NAxZnEpJX0BCT8GSy', '3', 'Retirment', '329046517', 'Recurring deposits ', '100', 'Deposit', 'Success ', '2', 'Sandhya Tamang', '1234567890', '1000', '9760381451', '', '2024-03-26 18:59:53.828798', '', ''),
(94, 'Yl4gDfsw16m5zOjoat3T', '3', 'Retirment', '329046517', 'Recurring deposits ', '100', 'Deposit', 'Success ', '2', 'Sandhya Tamang', '1234567890', '101', '9760381451', '', '2024-03-26 18:59:53.828798', '', ''),
(95, 'wemZj9szRfP2BbaOS8t1', '9', 'rabi', '362189704', 'Savings ', '-220', 'Deposit', 'Success ', '16', 'rabi', '7485575748', '100', '9896959400', '', '2024-03-26 19:23:15.791971', '', ''),
(96, 'uj3GsXB8U94tOZqidASQ', '9', 'rabi', '362189704', 'Savings ', '-220', 'Withdrawal', 'Success ', '16', 'rabi', '7485575748', '10', '9896959400', '', '2024-03-26 19:23:15.791971', '', ''),
(97, 'xPpdN2wBoE8CLQlvzquW', '9', 'rabi', '362189704', 'Savings ', '-220', 'Withdrawal', 'Success ', '16', 'rabi', '7485575748', '50', '9896959400', '', '2024-03-26 19:23:15.791971', '', ''),
(98, 'nh7QzKamZ8fOjoJl2iwr', '9', 'rabi', '362189704', 'Savings ', '-220', 'Deposit', 'Success ', '16', 'rabi', '7485575748', '1000', '9896959400', '', '2024-03-26 19:23:15.791971', '', ''),
(99, 'l7CKMtvmQDJoX238hbE5', '8', 'sd', '182504763', 'Fixed Deposit Account ', '1000', 'Deposit', 'Success ', '9', 'clienttest2', '6541287365', '1000', '9745632541', '', '2024-03-26 18:48:29.283772', '', ''),
(100, 'bpGYfFtcIh2MsSd64ylO', '8', 'sd', '182504763', 'Fixed Deposit Account ', '900', 'Withdrawal', 'Success ', '9', 'clienttest2', '6541287365', '100', '9745632541', '', '2024-03-26 18:49:25.132097', '', ''),
(101, 'JxiPZ9r7ueh0gzLsH4n3', '8', 'sd', '182504763', 'Fixed Deposit Account ', '910', 'Withdrawal', 'Success ', '9', 'clienttest2', '6541287365', '-10', '9745632541', '', '2024-03-26 18:49:30.362358', '', ''),
(102, 'OMbwvkfmiuDXZWetI7lQ', '1', 'Fixed', '254761893', 'Fixed Deposit Account ', '100', 'Deposit', 'Success ', '3', 'Sangita Dhodhary', '1234567891', '10', '9760381452', '', '2024-03-26 18:53:40.062513', '', ''),
(103, 'skyRItOPYu6bXLV9TmZU', '1', 'Fixed', '254761893', 'Fixed Deposit Account ', '100', 'Deposit', 'Success ', '3', 'Sangita Dhodhary', '1234567891', '100', '9760381452', '', '2024-03-26 18:53:40.056966', '', ''),
(104, 'xGc5EqtiLnw1vMSmb7lk', '3', 'Retirment', '329046517', 'Recurring deposits ', '100', 'Deposit', 'Success ', '2', 'Sandhya Tamang', '1234567890', '100', '9760381451', '', '2024-03-26 18:59:53.823445', '', ''),
(105, 'yPd57eWRCUSNm3Lf9oVT', '9', 'rabi', '362189704', 'Savings ', '-1210', 'Transfer', 'Success ', '16', 'rabi', '7485575748', '10', '9896959400', '529034678', '2024-03-26 19:23:15.791971', 'Recurring', 'Sangit Tamang'),
(106, '8ni5ZJcKlhLNA4pTYrQ7', '9', 'rabi', '362189704', 'Savings ', '-1310', 'Transfer', 'Success ', '16', 'rabi', '7485575748', '-100', '9896959400', '578109436', '2024-03-26 19:23:15.791971', 'ram', 'raman'),
(107, 'pmbZJ82FE6fquP7TYenv', '9', 'rabi', '362189704', 'Savings ', '-110', 'Transfer', 'Success ', '16', 'rabi', '7485575748', '100', '9896959400', '362189704', '2024-03-26 19:23:15.792215', 'rabi', 'rabi'),
(108, '7mXD8u32W1eEBFPOMyLN', '9', 'rabi', '362189704', 'Savings ', '-1100', 'Transfer', 'Success ', '16', 'rabi', '7485575748', '10', '9896959400', '329046517', '2024-03-26 19:23:15.791971', 'Retirment', 'Sandhya Tamang'),
(109, 'oWLRCeBUKxEmskO9VufJ', '9', 'rabi', '362189704', 'Savings ', '-100', 'Transfer', 'Success ', '16', 'rabi', '7485575748', '1000', '9896959400', '362189704', '2024-03-26 19:23:15.792215', 'rabi', 'rabi'),
(110, 'n35JfXV9ozIL6KFaCRM8', '9', 'rabi', '362189704', 'Savings ', '-100', 'Transfer', 'Success ', '16', 'rabi', '7485575748', '100', '9896959400', '329046517', '2024-03-26 19:23:15.791971', 'Retirment', 'Sandhya Tamang'),
(111, 'HjapCixZDIh3cNsRkWB8', '7', 'ram', '578109436', 'Fixed Deposit Account ', '10000', 'Deposit', 'Success ', '12', 'raman', '1545326124', '10000', '9763635241', '', '2024-03-26 19:11:27.224407', '', ''),
(112, 'DAKlT7ng1d09NjmSrVGB', '7', 'ram', '578109436', 'Fixed Deposit Account ', '9800', 'Withdrawal', 'Success ', '12', 'raman', '1545326124', '100', '9763635241', '', '2024-03-26 19:11:38.949319', '', ''),
(113, 'Uk6PXrAv4iuGgFCJ9wQI', '7', 'ram', '578109436', 'Fixed Deposit Account ', '9810', 'Withdrawal', 'Success ', '12', 'raman', '1545326124', '-10', '9763635241', '', '2024-03-26 19:11:43.793163', '', ''),
(114, 'SUCeV2JWrbopAk8h9NXL', '7', 'ram', '578109436', 'Fixed Deposit Account ', '9750', 'Withdrawal', 'Success ', '12', 'raman', '1545326124', '60', '9763635241', '', '2024-03-26 19:11:51.498825', '', ''),
(115, 'SUCeV2JWrbopAk8h9NXL', '7', 'ram', '578109436', 'Fixed Deposit Account ', '9690', 'Withdrawal', 'Success ', '12', 'raman', '1545326124', '60', '9763635241', '', '2024-03-26 19:17:00.760843', '', ''),
(116, 'F5iycPSYQbz0lxuW2rOq', '7', 'ram', '578109436', 'Fixed Deposit Account ', '9700', 'Withdrawal', 'Success ', '12', 'raman', '1545326124', '-10', '9763635241', '', '2024-03-26 19:17:06.201950', '', ''),
(117, 'OEpPAQrLeBguhTV8kGDX', '9', 'rabi', '362189704', 'Savings ', '', 'Transfer', 'Success ', '16', 'rabi', '7485575748', '100', '9896959400', '362189704', '2024-03-26 19:23:15.792646', 'rabi', 'rabi');

-- --------------------------------------------------------

--
-- Table structure for table `loanpayments`
--

CREATE TABLE `loanpayments` (
  `payment_id` int(11) NOT NULL,
  `loan_id` int(11) DEFAULT NULL,
  `name` varchar(150) NOT NULL,
  `loan_amount` decimal(10,2) DEFAULT NULL,
  `loan_type` enum('personal','business','education','mortgage','other') NOT NULL,
  `tr_code` varchar(150) DEFAULT NULL,
  `tr_type` varchar(150) DEFAULT NULL,
  `tr_status` varchar(150) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `borrower_national_id` bigint(20) NOT NULL,
  `payment_amt` decimal(10,2) NOT NULL,
  `interest_rate` decimal(5,2) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `due_amount` decimal(10,2) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loanpayments`
--

INSERT INTO `loanpayments` (`payment_id`, `loan_id`, `name`, `loan_amount`, `loan_type`, `tr_code`, `tr_type`, `tr_status`, `client_id`, `borrower_national_id`, `payment_amt`, `interest_rate`, `start_date`, `end_date`, `due_amount`, `payment_date`, `payment_amount`) VALUES
(0, 5, 'Sangit Tamang', 100.00, 'personal', '1M6XY5IQBR', NULL, NULL, 4, 10, 1.00, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 5, 'Sangit Tamang', 99.00, 'personal', 'STWQ312VOJ', NULL, NULL, 4, 10000, 100.00, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 5, 'Sangit Tamang', -1.00, 'personal', 'VLQ25EBMAT', NULL, NULL, 4, 123, 10.00, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 5, 'Sangit Tamang', -11.00, 'personal', '9YG34WFCR5', NULL, NULL, 4, 1450, 20.00, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 5, 'Sangit Tamang', -31.00, 'personal', 'BN5AUMJZF8', NULL, NULL, 4, 12354, 31.00, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 4, 'Sangit Tamang', 100.00, 'personal', 'R14ESTL8G9', NULL, NULL, 4, 123, 50.00, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `loan_id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `loan_amount` decimal(10,2) DEFAULT NULL,
  `interest_rate` decimal(5,2) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('pending','rejected','approved','complete') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `loan_document` varchar(255) DEFAULT NULL,
  `loan_type` enum('personal','business','education','mortgage','other') DEFAULT 'personal',
  `deposit_document` varchar(255) DEFAULT NULL,
  `due_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`loan_id`, `client_id`, `name`, `loan_amount`, `interest_rate`, `start_date`, `end_date`, `status`, `created_at`, `loan_document`, `loan_type`, `deposit_document`, `due_date`) VALUES
(1, 3, 'Sangita Dhodhary', 100.00, 8.50, '2024-03-11', '2024-03-31', 'approved', '2024-03-10 16:58:07', '_a269f9c7-0392-46da-9f78-6e96833cdda9.jpeg', '', '_a269f9c7-0392-46da-9f78-6e96833cdda9.jpeg', '0000-00-00'),
(2, 5, 'Sandhas Dhodary', 100.00, 6.25, '2024-03-11', '2024-04-05', 'approved', '2024-03-10 17:49:07', '_516e2734-c99f-45e8-8c11-f54b750a1508.jpeg', '', 'OIP.jpeg', '0000-00-00'),
(3, 4, 'Sangit Tamang', 100.00, NULL, '2024-03-12', '2024-03-26', 'approved', '2024-03-12 05:27:02', '_b5f09223-01d5-4110-83f5-e09a2ce208af.jpg', NULL, 'OIP (1).jpeg', '0000-00-00'),
(4, 4, 'Sangit Tamang', 50.00, NULL, '2024-03-12', '2024-03-20', 'approved', '2024-03-12 05:32:15', '_516e2734-c99f-45e8-8c11-f54b750a1508.jpeg', NULL, '_b5f09223-01d5-4110-83f5-e09a2ce208af.jpg', '0000-00-00'),
(5, 4, 'Sangit Tamang', -62.00, NULL, '2024-03-20', '2024-03-30', 'approved', '2024-03-12 05:32:45', 'OIP.jpeg', NULL, 'Gemini_Generated_Image.jpeg', '0000-00-00'),
(6, 11, 'karma tamang', 1000.00, NULL, '2024-03-27', '2024-04-06', 'pending', '2024-03-26 14:56:34', '_b5f09223-01d5-4110-83f5-e09a2ce208af.jpg', '', '_a269f9c7-0392-46da-9f78-6e96833cdda9.jpeg', '0000-00-00'),
(7, 14, 'sujan thapa', 1000.00, NULL, '2024-03-27', '2024-04-06', 'pending', '2024-03-26 14:59:49', '_57e265a4-a2cd-4b7b-89e0-a3254d0b3358.jpeg', '', '_a269f9c7-0392-46da-9f78-6e96833cdda9.jpeg', '0000-00-00'),
(8, 16, 'rabi', 100.00, NULL, '2024-03-27', '2024-04-06', 'pending', '2024-03-26 15:04:38', '_15038413-aa69-4f50-ba64-73ad73107b7d.jpeg', '', '_516e2734-c99f-45e8-8c11-f54b750a1508.jpeg', '0000-00-00'),
(9, 12, 'raman', 1000.00, NULL, '2024-03-27', '2024-04-06', 'approved', '2024-03-26 15:12:37', '_a269f9c7-0392-46da-9f78-6e96833cdda9.jpeg', '', '_a269f9c7-0392-46da-9f78-6e96833cdda9.jpeg', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `login_data`
--

CREATE TABLE `login_data` (
  `id` int(11) NOT NULL,
  `login_id` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `datetime` datetime NOT NULL,
  `role` enum('Admin','Manager','CSD','Loan','Cash','client') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_data`
--

INSERT INTO `login_data` (`id`, `login_id`, `name`, `datetime`, `role`) VALUES
(0, '1', 'admin@gmail.com', '2024-03-13 15:25:22', 'Admin'),
(0, '1', 'Sonima Tamange', '2024-03-13 17:50:38', 'client'),
(0, '1', 'admin@gmail.com', '2024-03-13 17:51:12', 'Admin'),
(0, '4', 'Sobita Lama', '2024-03-13 17:52:08', 'client'),
(0, '4', 'Sobita Lama', '2024-03-13 17:56:04', 'client'),
(0, '1', 'Sonima Tamange', '2024-03-13 18:08:03', 'client'),
(0, '1', 'admin@gmail.com', '2024-03-18 04:57:46', 'Admin'),
(0, '1', 'admin@gmail.com', '2024-03-21 08:47:24', 'Admin'),
(0, '6', 'test1', '2024-03-21 08:50:34', 'client'),
(0, '6', 'test1', '2024-03-21 08:51:18', 'client'),
(0, '1', 'admin@gmail.com', '2024-03-26 04:42:36', 'Admin'),
(0, '8', 'csd1', '2024-03-26 05:00:41', 'client'),
(0, '8', 'csd1', '2024-03-26 05:01:09', 'client'),
(0, '11', 'karma tamang', '2024-03-26 05:05:05', 'client'),
(0, '12', 'raman', '2024-03-26 05:05:36', 'client'),
(0, '12', 'raman', '2024-03-26 05:14:52', 'client'),
(0, '12', 'raman', '2024-03-26 05:15:15', 'client'),
(0, '12', 'raman', '2024-03-26 05:19:58', 'client'),
(0, '1', 'admin@gmail.com', '2024-03-26 05:22:01', 'Admin'),
(0, '12', 'raman', '2024-03-26 05:24:00', 'client'),
(0, '1', 'admin@gmail.com', '2024-03-26 05:25:39', 'Admin'),
(0, '11', 'karma tamang', '2024-03-26 05:26:26', 'client'),
(0, '11', 'karma tamang', '2024-03-26 05:27:59', 'client'),
(0, '1', 'admin@gmail.com', '2024-03-26 05:31:09', 'Admin'),
(0, '6', 'test1', '2024-03-26 05:35:01', 'client'),
(0, '8', 'csd1', '2024-03-26 05:35:36', 'client'),
(0, '6', 'test1', '2024-03-26 05:36:01', 'client'),
(0, '8', 'csd1', '2024-03-26 05:40:53', 'client'),
(0, '4', 'Sobita Lama', '2024-03-26 05:43:49', 'client'),
(0, '1', 'admin@gmail.com', '2024-03-26 05:49:54', 'Admin'),
(0, '3', 'Sobit Lama', '2024-03-26 06:02:14', 'client'),
(0, '4', 'Sobita Lama', '2024-03-26 06:02:27', 'client'),
(0, '3', 'Sobit Lama', '2024-03-26 06:05:04', 'client'),
(0, '1', 'admin@gmail.com', '2024-03-26 11:14:44', 'Admin'),
(0, '13', 'supreme jr.', '2024-03-26 11:23:14', 'client'),
(0, '1', 'Sonima Tamange', '2024-03-26 11:26:44', 'client'),
(0, '1', 'Sonima Tamange', '2024-03-26 12:30:11', 'client'),
(0, '2', 'Sandhya Tamang', '2024-03-26 12:35:17', 'client'),
(0, '4', 'Sobita Lama', '2024-03-26 12:36:56', 'client'),
(0, '17', 'alish', '2024-03-26 12:39:03', 'client'),
(0, '1', 'Sonima Tamange', '2024-03-26 12:40:11', 'client'),
(0, '18', 'hira', '2024-03-26 12:42:00', 'client'),
(0, '3', 'Sobit Lama', '2024-03-26 16:20:21', 'client'),
(0, '3', 'Sobit Lama', '2024-03-26 16:47:41', 'client'),
(0, '18', 'hira', '2024-03-26 17:03:47', 'client'),
(0, '4', 'Sobita Lama', '2024-03-26 17:55:29', 'client'),
(0, '17', 'alish', '2024-03-26 18:03:45', 'client'),
(0, '3', 'Sobit Lama', '2024-03-26 18:17:15', 'client'),
(0, '4', 'Sobita Lama', '2024-03-26 19:02:31', 'client'),
(0, '18', 'hira', '2024-03-26 19:05:44', 'client'),
(0, '4', 'Sobita Lama', '2024-03-26 19:06:57', 'client'),
(0, '1', 'admin@gmail.com', '2024-03-26 19:26:52', 'Admin'),
(0, '2', 'Sonim Tamange', '2024-03-26 19:51:48', 'client'),
(0, '1', 'admin@gmail.com', '2024-03-27 01:56:01', 'Admin'),
(0, '12', 'raman', '2024-03-27 02:25:25', 'client'),
(0, '3', 'Sobit Lama', '2024-03-27 02:35:12', 'client'),
(0, '2', 'Sonim Tamange', '2024-03-27 02:38:16', 'client'),
(0, '7', 'loantest1', '2024-03-27 02:54:00', 'client'),
(0, '1', 'Sonima Tamange', '2024-03-27 02:56:32', 'client'),
(0, '20', 'light', '2024-03-27 03:20:54', 'client'),
(0, '1', 'admin@gmail.com', '2024-03-27 05:47:08', 'Admin'),
(0, '12', 'raman', '2024-03-27 05:51:01', 'client'),
(0, '1', 'Sonima Tamange', '2024-03-27 05:52:07', 'client'),
(0, '4', 'Sobita Lama', '2024-03-27 05:52:24', 'client'),
(0, '16', 'rabi', '2024-03-27 05:53:58', 'client');

-- --------------------------------------------------------

--
-- Table structure for table `rateloans`
--

CREATE TABLE `rateloans` (
  `loan_id` int(11) NOT NULL,
  `loan_type` varchar(255) DEFAULT NULL,
  `interest_rate` decimal(5,2) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `loan_amount` decimal(10,2) DEFAULT NULL,
  `loan_document` varchar(255) DEFAULT NULL,
  `deposit_document` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rateloans`
--

INSERT INTO `rateloans` (`loan_id`, `loan_type`, `interest_rate`, `start_date`, `end_date`, `loan_amount`, `loan_document`, `deposit_document`) VALUES
(1, 'Personal Loan', 8.50, '2024-03-10', '2025-03-10', 10000.00, 'personal_loan_doc.pdf', 'deposit_doc_1.pdf'),
(2, 'Mortgage Loan', 3.75, '2024-02-15', '2044-02-15', 250000.00, 'mortgage_loan_doc.pdf', 'deposit_doc_2.pdf'),
(3, 'Auto Loan', 6.25, '2024-01-20', '2027-01-20', 20000.00, 'auto_loan_doc.pdf', 'deposit_doc_3.pdf'),
(4, 'Student Loan', 4.50, '2023-09-01', '2033-09-01', 50000.00, 'student_loan_doc.pdf', 'deposit_doc_4.pdf'),
(5, 'Business Loan', 7.00, '2024-05-01', '2026-05-01', 75000.00, 'business_loan_doc.pdf', 'deposit_doc_5.pdf');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ib_acc_types`
--
ALTER TABLE `ib_acc_types`
  ADD PRIMARY KEY (`acctype_id`);

--
-- Indexes for table `ib_admin`
--
ALTER TABLE `ib_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `ib_bankaccounts`
--
ALTER TABLE `ib_bankaccounts`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `ib_clients`
--
ALTER TABLE `ib_clients`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `ib_notifications`
--
ALTER TABLE `ib_notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `ib_staff`
--
ALTER TABLE `ib_staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `ib_systemsettings`
--
ALTER TABLE `ib_systemsettings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ib_transactions`
--
ALTER TABLE `ib_transactions`
  ADD PRIMARY KEY (`tr_id`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`loan_id`);

--
-- Indexes for table `rateloans`
--
ALTER TABLE `rateloans`
  ADD PRIMARY KEY (`loan_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ib_acc_types`
--
ALTER TABLE `ib_acc_types`
  MODIFY `acctype_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ib_admin`
--
ALTER TABLE `ib_admin`
  MODIFY `admin_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ib_bankaccounts`
--
ALTER TABLE `ib_bankaccounts`
  MODIFY `account_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `ib_clients`
--
ALTER TABLE `ib_clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `ib_notifications`
--
ALTER TABLE `ib_notifications`
  MODIFY `notification_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `ib_staff`
--
ALTER TABLE `ib_staff`
  MODIFY `staff_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ib_systemsettings`
--
ALTER TABLE `ib_systemsettings`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ib_transactions`
--
ALTER TABLE `ib_transactions`
  MODIFY `tr_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `loan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `rateloans`
--
ALTER TABLE `rateloans`
  MODIFY `loan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

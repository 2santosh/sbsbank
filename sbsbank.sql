
INSERT INTO `ib_acc_types` (`acctype_id`, `name`, `description`, `rate`, `code`) VALUES
(1, 'Savings', '<p>Savings accounts&nbsp;are typically the first official bank account anybody opens. Children may open an account with a parent to begin a pattern of saving. Teenagers open accounts to stash cash earned&nbsp;from a first job&nbsp;or household chores.</p><p>Savings accounts are an excellent place to park&nbsp;emergency cash. Opening a savings account also marks the beginning of your relationship with a financial institution. For example, when joining a credit union, your &ldquo;share&rdquo; or savings account establishes your membership.</p>', '20', 'ACC-CAT-4EZFO'),
(2, ' Retirement', '<p>Retirement accounts&nbsp;offer&nbsp;tax advantages. In very general terms, you get to&nbsp;avoid paying income tax on interest&nbsp;you earn from a savings account or CD each year. But you may have to pay taxes on those earnings at a later date. Still, keeping your money sheltered from taxes may help you over the long term. Most banks offer IRAs (both&nbsp;Traditional IRAs&nbsp;and&nbsp;Roth IRAs), and they may also provide&nbsp;retirement accounts for small businesses</p>', '10', 'ACC-CAT-1QYDV'),
(4, 'Recurring deposits', '<p><strong>Recurring deposit account or RD account</strong> is opened by those who want to save certain amount of money regularly for a certain period of time and earn a higher interest rate.&nbsp;In RD&nbsp;account a&nbsp;fixed amount is deposited&nbsp;every month for a specified period and the total amount is repaid with interest at the end of the particular fixed period.&nbsp;</p><p>The period of deposit is minimum six months and maximum ten years.&nbsp;The interest rates vary&nbsp;for different plans based on the amount one saves and the period of time and also on banks. No withdrawals are allowed from the RD account. However, the bank may allow to close the account before the maturity period.</p><p>These accounts can be opened in single or joint names. Banks are also providing the Nomination facility to the RD account holders.&nbsp;</p>', '15', 'ACC-CAT-VBQLE'),
(5, 'Fixed Deposit Account', '<p>In <strong>Fixed Deposit Account</strong> (also known as <strong>FD Account</strong>), a particular sum of money is deposited in a bank for specific&nbsp;period of time. It&rsquo;s one time deposit and one time take away (withdraw) account.&nbsp;The money deposited in this account can not be withdrawn before the expiry of period.&nbsp;</p><p>However, in case of need,&nbsp; the depositor can ask for closing the fixed deposit prematurely by paying a penalty. The penalty amount varies with banks.</p><p>A high interest rate is paid on fixed deposits. The rate of interest paid for fixed deposit vary according to amount, period and also from bank to bank.</p>', '40', 'ACC-CAT-A86GO'),
(9, 'child', 'child</p>', '15', 'ACC-CAT-2NSDY');





INSERT INTO `ib_admin` (`admin_id`, `name`, `email`, `number`, `password`, `profile_pic`) VALUES
(1, 'System Administrator', 'admin@gmail.com', 'iBank-ADM-0516', '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', 'admin-icn.png');


INSERT INTO `ib_bankaccounts` (`account_id`, `acc_name`, `account_number`, `acc_type`, `acc_rates`, `acc_status`, `acc_amount`, `client_id`, `client_name`, `client_national_id`, `client_phone`, `client_number`, `client_email`, `client_adr`, `created_at`) VALUES
(1, 'Fixed', '254761893', 'Fixed Deposit Account ', '40', 'Active', '100', '3', 'Sangita Dhodhary', '1234567891', '9760381452', 'iBank-CLIENT-5721', 'sangita@gmail.com', 'ktm', '2024-03-26 18:53:40.060397'),
(2, 'Recurring', '529034678', 'Recurring deposits ', '15', 'Active', '10', '4', 'Sangit Tamang', '1234567892', '9760381457', 'iBank-CLIENT-8452', 'sangit@gmail.com', 'ktm', '2024-03-26 19:08:04.047896'),
(3, 'Retirment', '329046517', 'Recurring deposits ', '15', 'Active', '2311', '2', 'Sandhya Tamang', '1234567890', '9760381451', 'iBank-CLIENT-1647', 'sandhya@gmail.com', 'ktm', '2024-03-26 19:09:26.490201'),
(6, 'kt', '931028546', ' Retirement ', '10', 'Active', '0', '11', 'karma tamang', '4567812369', '9812453651', 'iBank-CLIENT-5293', 'tamang@gmail.com', 'ktm', '2024-03-26 04:02:54.499634'),
(7, 'ram', '578109436', 'Fixed Deposit Account ', '40', 'Active', '9700', '12', 'raman', '1545326124', '9763635241', 'iBank-CLIENT-2681', 'raman@gmail.com', 'ktm', '2024-03-26 19:17:06.200002'),
(8, 'sd', '182504763', 'Fixed Deposit Account ', '40', 'Active', '910', '9', 'clienttest2', '6541287365', '9745632541', 'iBank-CLIENT-4618', 'clienttest2@gmail.com', 'Madhyapur thimi', '2024-03-26 18:49:30.360013'),
(9, 'rabi', '362189704', 'Savings ', '20', 'Active', '1020', '16', 'rabi', '7485575748', '9896959400', 'iBank-CLIENT-7041', 'rabi@gmail.com', 'ktm', '2024-03-26 19:23:15.791728'),
(12, 'hira', '508721936', 'Fixed Deposit Account ', '40', 'Active', '0', '18', 'hira', '3625362541', '9785225863', 'iBank-CLIENT-9036', 'hira@gmail.com', 'ktm', '2024-03-26 11:41:27.955183');



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






INSERT INTO `ib_staff` (`staff_id`, `name`, `staff_number`, `phone`, `email`, `password`, `sex`, `profile_pic`, `staff_type`, `staff_position`) VALUES
(1, 'Sonima Tamange', 'iBank-STAFF-0649', '9860381454', 'csd@gmail.com', '9edd4b9abe263967cd607866ce74b0682f781082', 'Select Gender', 'OIP.jpeg', '', 'CSD'),
(2, 'Sonim Tamange', 'iBank-STAFF-5862', '9860381451', 'cashn@gmail.com', '9edd4b9abe263967cd607866ce74b0682f781082', 'Male', '', '', 'Cash'),
(3, 'Sobit Lama', 'iBank-STAFF-4271', '9860381452', 'loan@gmail.com', '9edd4b9abe263967cd607866ce74b0682f781082', 'Male', '_a269f9c7-0392-46da-9f78-6e96833cdda9.jpeg', '', 'Loan'),
(4, 'Sobita Lama', 'iBank-STAFF-1367', '9860381456', 'manager@gmail.com', '9edd4b9abe263967cd607866ce74b0682f781082', 'Female', 'OIP (1).jpeg', '', 'Manager'),
(5, 'Prinsh Khadka', 'iBank-STAFF-9107', '9801234562', 'prinsh@gmail.com', '9edd4b9abe263967cd607866ce74b0682f781082', 'Select Gender', '_b5f09223-01d5-4110-83f5-e09a2ce208af.jpg', '', 'Manager'),
(7, 'loantest1', 'iBank-STAFF-3594', '9841052001', 'loantest1@gmail.com', '9edd4b9abe263967cd607866ce74b0682f781082', 'Male', '', '', 'Loan'),
(8, 'csd1', 'iBank-STAFF-7058', '9701234560', 'csd1@gmail.com', '771b95fee6aea577253893d3fdb812996aee776a', 'Male', '', '', 'CSD'),
(9, 'kira', 'iBank-STAFF-1289', '9865324164', 'manager1@gmail.com', '9edd4b9abe263967cd607866ce74b0682f781082', 'Female', '_b5f09223-01d5-4110-83f5-e09a2ce208af.jpg', '', 'Manager');


INSERT INTO `ib_systemsettings` (`id`, `sys_name`, `sys_tagline`, `sys_logo`) VALUES
(1, 'SBS Banking', 'Financial success at every service we offer.', 'sbsbank.jpg');




INSERT INTO `loanpayments` (`payment_id`, `loan_id`, `name`, `loan_amount`, `loan_type`, `tr_code`, `tr_type`, `tr_status`, `client_id`, `borrower_national_id`, `payment_amt`, `interest_rate`, `start_date`, `end_date`, `due_amount`, `payment_date`, `payment_amount`) VALUES
(0, 5, 'Sangit Tamang', 100.00, 'personal', '1M6XY5IQBR', NULL, NULL, 4, 10, 1.00, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 5, 'Sangit Tamang', 99.00, 'personal', 'STWQ312VOJ', NULL, NULL, 4, 10000, 100.00, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 5, 'Sangit Tamang', -1.00, 'personal', 'VLQ25EBMAT', NULL, NULL, 4, 123, 10.00, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 5, 'Sangit Tamang', -11.00, 'personal', '9YG34WFCR5', NULL, NULL, 4, 1450, 20.00, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 5, 'Sangit Tamang', -31.00, 'personal', 'BN5AUMJZF8', NULL, NULL, 4, 12354, 31.00, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 4, 'Sangit Tamang', 100.00, 'personal', 'R14ESTL8G9', NULL, NULL, 4, 123, 50.00, NULL, NULL, NULL, NULL, NULL, NULL);


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

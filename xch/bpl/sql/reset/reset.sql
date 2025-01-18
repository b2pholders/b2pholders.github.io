--
-- Table structure for table `network_activity`
--

DROP TABLE IF EXISTS `network_activity`;

CREATE TABLE IF NOT EXISTS `network_activity` (
    `activity_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `sponsor_id` int(11) NOT NULL,
    `activity` text COLLATE utf8mb4_unicode_ci NOT NULL,
    `activity_date` int(11) NOT NULL,
    `upline_id` int(11) NOT NULL DEFAULT '1',
    PRIMARY KEY (`activity_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_admin`
--

DROP TABLE IF EXISTS `network_admin`;

CREATE TABLE IF NOT EXISTS `network_admin` (
    `id` int(11) NOT NULL,
    `username` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `password` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `admintype` enum('Mega', 'Ultra', 'Super') COLLATE utf8mb4_unicode_ci DEFAULT 'Super',
    PRIMARY KEY (`id`),
    UNIQUE KEY `tbl_network_admin_id_uindex` (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `network_admin`
--

INSERT INTO
    `network_admin` (
        `id`,
        `username`,
        `password`,
        `admintype`
    )
VALUES (
        1,
        'superadmin',
        '63a9f0ea7bb98050796b649e85481845',
        'Super'
    );

-- --------------------------------------------------------

--
-- Table structure for table `network_balance`
--

DROP TABLE IF EXISTS `network_balance`;

CREATE TABLE IF NOT EXISTS `network_balance` (
    `balance_id` int(11) NOT NULL,
    `transaction_id` int(11) NOT NULL,
    `value` double NOT NULL,
    `balance` double NOT NULL,
    `date` int(11) NOT NULL,
    PRIMARY KEY (`balance_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_binary`
--

DROP TABLE IF EXISTS `network_binary`;

CREATE TABLE IF NOT EXISTS `network_binary` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL DEFAULT '0',
    `upline_id` int(11) NOT NULL DEFAULT '0',
    `position` enum('Head', 'Left', 'Right') COLLATE utf8mb4_unicode_ci DEFAULT 'Left',
    `downline_left_id` int(11) NOT NULL DEFAULT '0',
    `downline_right_id` int(11) NOT NULL DEFAULT '0',
    `ctr_left` double NOT NULL DEFAULT '0',
    `ctr_right` double NOT NULL DEFAULT '0',
    `pairs` double NOT NULL DEFAULT '0',
    `pairs_today` double NOT NULL DEFAULT '0',
    `pairs_today_total` double NOT NULL DEFAULT '0',
    `pairs_5th` double NOT NULL DEFAULT '0',
    `income_cycle` double NOT NULL DEFAULT '0',
    `income_giftcheck` double NOT NULL DEFAULT '0',
    `income_flushout` double NOT NULL DEFAULT '0',
    `capping_cycle` double NOT NULL DEFAULT '0',
    `reactivate_count` int(11) NOT NULL DEFAULT '0',
    `nth_pair_cycle` double NOT NULL DEFAULT '0',
    `status` enum(
        'inactive',
        'active',
        'reactivated',
        'graduate'
    ) COLLATE utf8mb4_unicode_ci DEFAULT 'inactive',
    `direct_cycle` int(11) NOT NULL DEFAULT '0',
    `status_cycle` int(11) NOT NULL DEFAULT '0',
    `date_last_flushout` int(11) NOT NULL DEFAULT '0',
    `freeze_flushout` double NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `network_binary`
--

INSERT INTO
    `network_binary` (
        `user_id`,
        `position`,
        `status`,
        `status_cycle`,
        `date_last_flushout`
    )
VALUES (
        1,
        'Head',
        'active',
        1,
        UNIX_TIMESTAMP()
    );

-- --------------------------------------------------------

--
-- Table structure for table `network_points`
--

DROP TABLE IF EXISTS `network_points`;

CREATE TABLE IF NOT EXISTS `network_points` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL DEFAULT '0',
    `points` double NOT NULL DEFAULT '0',
    `points_spent` double NOT NULL DEFAULT '0',
    `points_waiting` double NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `network_points`
--

INSERT INTO `network_points` (`user_id`) VALUES (1);

-- --------------------------------------------------------

--
-- Table structure for table `network_binary_entry`
--

DROP TABLE IF EXISTS `network_binary_entry`;

CREATE TABLE IF NOT EXISTS `network_binary_entry` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `amount` double NOT NULL DEFAULT '0',
    `date` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_codes`
--

DROP TABLE IF EXISTS `network_codes`;

CREATE TABLE IF NOT EXISTS `network_codes` (
    `code_id` int(11) NOT NULL AUTO_INCREMENT,
    `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
    `user_id` int(11) NOT NULL,
    `type` enum(
        'chairman',
        'executive',
        'regular',
        'associate',
        'basic',
        'chairman_cd',
        'executive_cd',
        'regular_cd',
        'associate_cd',
        'basic_cd',
        'starter'
    ) COLLATE utf8mb4_unicode_ci NOT NULL,
    `owner_id` int(11) NOT NULL,
    PRIMARY KEY (`code_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_commission_deduct`
--

DROP TABLE IF EXISTS `network_commission_deduct`;

CREATE TABLE IF NOT EXISTS `network_commission_deduct` (
    `id` int(11) NOT NULL,
    `balance` double NOT NULL DEFAULT '0'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_compound`
--

DROP TABLE IF EXISTS `network_compound`;

CREATE TABLE IF NOT EXISTS `network_compound` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL DEFAULT '0',
    `time_last` int(11) NOT NULL DEFAULT '0',
    `value_last` double NOT NULL DEFAULT '0',
    `day` int(11) NOT NULL DEFAULT '0',
    `processing` int(11) NOT NULL DEFAULT '0',
    `maturity` int(11) NOT NULL DEFAULT '0',
    `time_mature` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `network_compound`
--

INSERT INTO
    `network_compound` (
        `user_id`,
        `time_last`,
        `value_last`,
        `day`,
        `processing`,
        `maturity`,
        `time_mature`
    )
VALUES (1, 0, 0, 0, 0, 90, 0);

-- --------------------------------------------------------

--
-- Table structure for table `network_ecash_add`
--

DROP TABLE IF EXISTS `network_ecash_add`;

CREATE TABLE IF NOT EXISTS `network_ecash_add` (
    `add_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `amount` double NOT NULL,
    `date` int(11) NOT NULL,
    PRIMARY KEY (`add_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_point_add`
--

DROP TABLE IF EXISTS `network_point_add`;

CREATE TABLE IF NOT EXISTS `network_point_add` (
    `add_id` int NOT NULL AUTO_INCREMENT,
    `user_id` int NOT NULL,
    `amount` double NOT NULL,
    `date` int NOT NULL,
    PRIMARY KEY (`add_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_efund_add`
--

DROP TABLE IF EXISTS `network_efund_add`;

CREATE TABLE IF NOT EXISTS `network_efund_add` (
    `add_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `amount` double NOT NULL,
    `date` int(11) NOT NULL,
    PRIMARY KEY (`add_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_efund_request`
--

DROP TABLE IF EXISTS `network_efund_request`;

CREATE TABLE IF NOT EXISTS `network_efund_request` (
    `request_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `amount` double NOT NULL,
    `price` double NOT NULL,
    `method` varchar(32) NOT NULL,
    `date_requested` int(11) NOT NULL,
    `date_confirmed` int(11) NOT NULL,
    PRIMARY KEY (`request_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_subscribe_request`
--

DROP TABLE IF EXISTS `network_subscribe_request`;

CREATE TABLE IF NOT EXISTS `network_subscribe_request` (
    `request_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `amount` double NOT NULL,
    `price` double NOT NULL,
    `method` varchar(32) NOT NULL,
    `date_requested` int(11) NOT NULL,
    `date_confirmed` int(11) NOT NULL,
    PRIMARY KEY (`request_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_share_fund_request`
--

DROP TABLE IF EXISTS `network_share_fund_request`;

CREATE TABLE IF NOT EXISTS `network_share_fund_request` (
    `request_id` int NOT NULL AUTO_INCREMENT,
    `user_id` int NOT NULL,
    `amount` double NOT NULL,
    `price` double NOT NULL,
    `method` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
    `date_requested` int NOT NULL,
    `date_confirmed` int NOT NULL,
    PRIMARY KEY (`request_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_loan_request`
--

DROP TABLE IF EXISTS `network_loan_request`;

CREATE TABLE IF NOT EXISTS `network_loan_request` (
    `request_id` int NOT NULL AUTO_INCREMENT,
    `user_id` int NOT NULL,
    `amount` double NOT NULL,
    `price` double NOT NULL,
    `method` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
    `date_requested` int NOT NULL,
    `date_confirmed` int NOT NULL,
    PRIMARY KEY (`request_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_efund_requests`
--

DROP TABLE IF EXISTS `network_efund_requests`;

CREATE TABLE IF NOT EXISTS `network_efund_requests` (
    `request_id` int(11) NOT NULL AUTO_INCREMENT,
    `transaction_id` int(11) NOT NULL,
    `amount` double NOT NULL,
    `price` double NOT NULL,
    `method` varchar(32) NOT NULL,
    `request_date` int(11) NOT NULL,
    `request_total` double NOT NULL,
    PRIMARY KEY (`request_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_subscribe_requests`
--

DROP TABLE IF EXISTS `network_subscribe_requests`;

CREATE TABLE IF NOT EXISTS `network_subscribe_requests` (
    `request_id` int(11) NOT NULL AUTO_INCREMENT,
    `transaction_id` int(11) NOT NULL,
    `amount` double NOT NULL,
    `price` double NOT NULL,
    `method` varchar(32) NOT NULL,
    `request_date` int(11) NOT NULL,
    `request_total` double NOT NULL,
    PRIMARY KEY (`request_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_share_fund_requests`
--

DROP TABLE IF EXISTS `network_share_fund_requests`;

CREATE TABLE IF NOT EXISTS `network_share_fund_requests` (
    `request_id` int NOT NULL AUTO_INCREMENT,
    `transaction_id` int NOT NULL,
    `amount` double NOT NULL,
    `price` double NOT NULL,
    `method` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
    `request_date` int NOT NULL,
    `request_total` double NOT NULL,
    PRIMARY KEY (`request_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_loan_requests`
--

DROP TABLE IF EXISTS `network_loan_requests`;

CREATE TABLE IF NOT EXISTS `network_loan_requests` (
    `request_id` int NOT NULL AUTO_INCREMENT,
    `transaction_id` int NOT NULL,
    `amount` double NOT NULL,
    `price` double NOT NULL,
    `method` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
    `request_date` int NOT NULL,
    `request_total` double NOT NULL,
    PRIMARY KEY (`request_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_elite_maintain`
--

DROP TABLE IF EXISTS `network_elite_maintain`;

CREATE TABLE IF NOT EXISTS `network_elite_maintain` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL DEFAULT '0',
    `maintain_elite` double NOT NULL DEFAULT '0',
    `maintain_elite_now` double NOT NULL DEFAULT '0',
    `maintain_elite_last` double NOT NULL DEFAULT '0',
    `period_elite_maintain` double NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_fast_track`
--

DROP TABLE IF EXISTS `network_fast_track`;

CREATE TABLE IF NOT EXISTS `network_fast_track` (
    `fast_track_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `time_last` int(11) NOT NULL,
    `value_last` double NOT NULL,
    `day` int(11) NOT NULL,
    `principal` double NOT NULL,
    `date_entry` int(11) NOT NULL,
    `processing` int(11) NOT NULL,
    `time_mature` int(11) NOT NULL DEFAULT '0',
    `date_last_cron` int(11) NOT NULL DEFAULT '0',
    `flushout_global` double NOT NULL DEFAULT '0',
    PRIMARY KEY (`fast_track_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_fixed_daily`
--

DROP TABLE IF EXISTS `network_fixed_daily`;

CREATE TABLE IF NOT EXISTS `network_fixed_daily` (
    `fixed_daily_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL DEFAULT '0',
    `time_last` int(11) NOT NULL DEFAULT '0',
    `value_last` double NOT NULL DEFAULT '0',
    `day` int(11) NOT NULL DEFAULT '0',
    `processing` int(11) NOT NULL DEFAULT '0',
    `time_mature` int(11) NOT NULL DEFAULT '0',
    `date_last_cron` int(11) NOT NULL DEFAULT '0',
    `flushout_global` double NOT NULL DEFAULT '0',
    PRIMARY KEY (`fixed_daily_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `network_fixed_daily`
--

INSERT INTO
    `network_fixed_daily` (
        `user_id`,
        `time_last`,
        `value_last`,
        `day`,
        `processing`,
        `time_mature`
    )
VALUES (1, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `network_fixed_daily_token`
--

DROP TABLE IF EXISTS `network_fixed_daily_token`;

CREATE TABLE IF NOT EXISTS `network_fixed_daily_token` (
  `fixed_daily_token_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL DEFAULT '0',
  `time_last` int NOT NULL DEFAULT '0',
  `value_last` double NOT NULL DEFAULT '0',
  `day` int NOT NULL DEFAULT '0',
  `processing` int NOT NULL DEFAULT '0',
  `time_mature` int NOT NULL DEFAULT '0',
  `date_last_cron` int NOT NULL DEFAULT '0',
  `flushout_global` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`fixed_daily_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `network_fixed_daily_token`
--

INSERT INTO
    `network_fixed_daily_token` (
        `user_id`,
        `time_last`,
        `value_last`,
        `day`,
        `processing`,
        `time_mature`
    )
VALUES (1, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `network_fmc`
--

DROP TABLE IF EXISTS `network_fmc`;

CREATE TABLE IF NOT EXISTS `network_fmc` (
    `balance` double NOT NULL,
    `sales_fmc` double NOT NULL,
    `purchase_fmc` double NOT NULL,
    `price_btc` double NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `network_fmc`
--

INSERT INTO
    `network_fmc` (
        `balance`,
        `sales_fmc`,
        `purchase_fmc`,
        `price_btc`
    )
VALUES (16000000000, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `network_fmc_trade`
--

DROP TABLE IF EXISTS `network_fmc_trade`;

CREATE TABLE IF NOT EXISTS `network_fmc_trade` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `order_type` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `price` double NOT NULL,
    `amount` double NOT NULL,
    `time_post` int(11) NOT NULL DEFAULT '0',
    `time_complete` int(11) NOT NULL DEFAULT '0',
    `complete_by` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_harvest`
--

DROP TABLE IF EXISTS `network_harvest`;

CREATE TABLE IF NOT EXISTS `network_harvest` (
    `user_id` int(11) NOT NULL,
    `bonus_harvest_associate` double NOT NULL DEFAULT '0',
    `bonus_harvest_associate_now` double NOT NULL DEFAULT '0',
    `bonus_harvest_associate_last` double NOT NULL DEFAULT '0',
    `bonus_harvest_basic` double NOT NULL DEFAULT '0',
    `bonus_harvest_basic_now` double NOT NULL DEFAULT '0',
    `bonus_harvest_basic_last` double NOT NULL DEFAULT '0',
    PRIMARY KEY (`user_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `network_harvest`
--

INSERT INTO `network_harvest` (`user_id`) VALUES (1);

-- --------------------------------------------------------

--
-- Table structure for table `network_harvest_regular`
--

DROP TABLE IF EXISTS `network_harvest_executive`;

CREATE TABLE IF NOT EXISTS `network_harvest_executive` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `harvest_upline_id` int(11) NOT NULL DEFAULT '0',
    `has_mature` int(11) NOT NULL DEFAULT '0',
    `is_active` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_harvest_regular`
--

DROP TABLE IF EXISTS `network_harvest_regular`;

CREATE TABLE IF NOT EXISTS `network_harvest_regular` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `harvest_upline_id` int(11) NOT NULL DEFAULT '0',
    `has_mature` int(11) NOT NULL DEFAULT '0',
    `is_active` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_harvest_associate`
--

DROP TABLE IF EXISTS `network_harvest_associate`;

CREATE TABLE IF NOT EXISTS `network_harvest_associate` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `harvest_upline_id` int(11) NOT NULL DEFAULT '0',
    `has_mature` int(11) NOT NULL DEFAULT '0',
    `is_active` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `network_harvest_associate`
--

INSERT INTO
    `network_harvest_associate` (
        `user_id`,
        `has_mature`,
        `is_active`
    )
VALUES (1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `network_harvest_basic`
--

DROP TABLE IF EXISTS `network_harvest_basic`;

CREATE TABLE IF NOT EXISTS `network_harvest_basic` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `harvest_upline_id` int(11) NOT NULL DEFAULT '0',
    `has_mature` int(11) NOT NULL DEFAULT '0',
    `is_active` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `network_harvest_basic`
--

INSERT INTO
    `network_harvest_basic` (
        `user_id`,
        `has_mature`,
        `is_active`
    )
VALUES (1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `network_incentive`
--

DROP TABLE IF EXISTS `network_incentive`;

CREATE TABLE IF NOT EXISTS `network_incentive` (
    `incentive_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `item_id` int(11) NOT NULL,
    `date` int(11) NOT NULL,
    `price` double NOT NULL,
    `quantity` int(11) NOT NULL,
    `status` enum(
        'Awaiting Delivery',
        'Delivered'
    ) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Awaiting Delivery',
    `total_purchases` double NOT NULL,
    PRIMARY KEY (`incentive_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_income`
--

DROP TABLE IF EXISTS `network_income`;

CREATE TABLE IF NOT EXISTS `network_income` (
    `income_id` int(11) NOT NULL AUTO_INCREMENT,
    `transaction_id` int(11) NOT NULL,
    `amount` double NOT NULL,
    `income_total` double NOT NULL,
    `income_date` int(11) NOT NULL,
    PRIMARY KEY (`income_id`),
    UNIQUE KEY `balance_id` (`income_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_indirect`
--

DROP TABLE IF EXISTS `network_indirect`;

CREATE TABLE IF NOT EXISTS `network_indirect` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `bonus_indirect` double NOT NULL DEFAULT '0',
    `bonus_indirect_now` double NOT NULL DEFAULT '0',
    `bonus_indirect_last` double NOT NULL DEFAULT '0',
    `bonus_indirect_points` double NOT NULL DEFAULT '0',
    `bonus_indirect_points_now` double NOT NULL DEFAULT '0',
    `bonus_indirect_points_last` double NOT NULL DEFAULT '0',
    `bonus_indirect_fmc` double NOT NULL DEFAULT '0',
    `bonus_indirect_fmc_now` double NOT NULL DEFAULT '0',
    `bonus_indirect_fmc_last` double NOT NULL DEFAULT '0',
    `income_today` double NOT NULL DEFAULT '0',
    `flushout_local` double NOT NULL DEFAULT '0',
    `flushout_global` double NOT NULL DEFAULT '0',
    `date_last_flushout` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `network_indirect`
--

INSERT INTO `network_indirect` (`id`, `user_id`) VALUES (1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `network_echelon`
--

DROP TABLE IF EXISTS `network_echelon`;

CREATE TABLE IF NOT EXISTS `network_echelon` (
    `id` int NOT NULL AUTO_INCREMENT,
    `user_id` int NOT NULL,
    `bonus_echelon` double NOT NULL DEFAULT '0',
    `bonus_echelon_now` double NOT NULL DEFAULT '0',
    `bonus_echelon_last` double NOT NULL DEFAULT '0',
    `bonus_echelon_points` double NOT NULL DEFAULT '0',
    `bonus_echelon_points_now` double NOT NULL DEFAULT '0',
    `bonus_echelon_points_last` double NOT NULL DEFAULT '0',
    `bonus_echelon_fmc` double NOT NULL DEFAULT '0',
    `bonus_echelon_fmc_now` double NOT NULL DEFAULT '0',
    `bonus_echelon_fmc_last` double NOT NULL DEFAULT '0',
    `income_today` double NOT NULL DEFAULT '0',
    `flushout_local` double NOT NULL DEFAULT '0',
    `flushout_global` double NOT NULL DEFAULT '0',
    `date_last_flushout` int NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `network_echelon`
--

INSERT INTO `network_echelon` (`id`, `user_id`) VALUES (1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `network_items_incentive`
--

-- DROP TABLE IF EXISTS `network_items_incentive`;
-- CREATE TABLE IF NOT EXISTS `network_items_incentive`
-- (
--     `item_id`     int(11)                                 NOT NULL AUTO_INCREMENT,
--     `item_name`   varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
--     `description` text COLLATE utf8mb4_unicode_ci         NOT NULL,
--     `price`       double                                  NOT NULL,
--     `quantity`    int(11)                                 NOT NULL,
--     `picture`     varchar(30) COLLATE utf8mb4_unicode_ci  NOT NULL,
--     PRIMARY KEY (`item_id`)
-- ) ENGINE = InnoDB
--   DEFAULT CHARSET = utf8mb4
--   COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_items_repeat`
--

-- DROP TABLE IF EXISTS `network_items_repeat`;
-- CREATE TABLE IF NOT EXISTS `network_items_repeat`
-- (
--     `item_id`       int(11)                                 NOT NULL AUTO_INCREMENT,
--     `item_name`     varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
--     `description`   text COLLATE utf8mb4_unicode_ci         NOT NULL,
--     `picture`       varchar(20) COLLATE utf8mb4_unicode_ci  NOT NULL,
--     `price`         double                                  NOT NULL,
-- 	`price_retail`  double                                  NOT NULL,
--     `quantity`      int(11)                                 NOT NULL,
--     `binary_points` double                                  NOT NULL,
--     `reward_points` double                                  NOT NULL,
--     PRIMARY KEY (`item_id`)
-- ) ENGINE = InnoDB
--   DEFAULT CHARSET = utf8mb4
--   COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_leadership`
--

DROP TABLE IF EXISTS `network_leadership`;

CREATE TABLE IF NOT EXISTS `network_leadership` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `bonus_leadership` double NOT NULL DEFAULT '0',
    `bonus_leadership_now` double NOT NULL DEFAULT '0',
    `bonus_leadership_last` double NOT NULL DEFAULT '0',
    `income_today` double NOT NULL DEFAULT '0',
    `date_last_flushout` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `network_leadership`
--

INSERT INTO `network_leadership` (`user_id`) VALUES (1);

-- --------------------------------------------------------

--
-- Table structure for table `network_leadership_passive`
--

DROP TABLE IF EXISTS `network_leadership_passive`;

CREATE TABLE IF NOT EXISTS `network_leadership_passive` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `bonus_leadership_passive` double NOT NULL DEFAULT '0',
    `bonus_leadership_passive_now` double NOT NULL DEFAULT '0',
    `bonus_leadership_passive_last` double NOT NULL DEFAULT '0',
    `income_today` double NOT NULL DEFAULT '0',
    `flushout_local` double NOT NULL DEFAULT '0',
    `flushout_global` double NOT NULL DEFAULT '0',
    `date_last_flushout` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `network_leadership_passive`
--

INSERT INTO `network_leadership_passive` (`user_id`) VALUES (1);

-- --------------------------------------------------------

--
-- Table structure for table `network_matrix`
--

DROP TABLE IF EXISTS `network_matrix`;

CREATE TABLE IF NOT EXISTS `network_matrix` (
    `user_id` int(11) NOT NULL,
    `bonus_matrix_executive` double NOT NULL DEFAULT '0',
    `bonus_matrix_executive_now` double NOT NULL DEFAULT '0',
    `bonus_matrix_executive_last` double NOT NULL DEFAULT '0',
    `bonus_matrix_regular` double NOT NULL DEFAULT '0',
    `bonus_matrix_regular_now` double NOT NULL DEFAULT '0',
    `bonus_matrix_regular_last` double NOT NULL DEFAULT '0',
    `bonus_matrix_associate` double NOT NULL DEFAULT '0',
    `bonus_matrix_associate_now` double NOT NULL DEFAULT '0',
    `bonus_matrix_associate_last` double NOT NULL DEFAULT '0',
    `bonus_matrix_basic` double NOT NULL DEFAULT '0',
    `bonus_matrix_basic_now` double NOT NULL DEFAULT '0',
    `bonus_matrix_basic_last` double NOT NULL DEFAULT '0',
    PRIMARY KEY (`user_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `network_matrix`
--

INSERT INTO `network_matrix` (`user_id`) VALUES (1);

-- --------------------------------------------------------

--
-- Table structure for table `network_matrix_associate`
--

DROP TABLE IF EXISTS `network_matrix_associate`;

CREATE TABLE IF NOT EXISTS `network_matrix_associate` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `matrix_upline_id` int(11) NOT NULL DEFAULT '0',
    `has_mature` int(11) NOT NULL DEFAULT '0',
    `is_active` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `network_matrix_associate`
--

INSERT INTO
    `network_matrix_associate` (`user_id`, `is_active`)
VALUES (1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `network_matrix_basic`
--

DROP TABLE IF EXISTS `network_matrix_basic`;

CREATE TABLE IF NOT EXISTS `network_matrix_basic` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `matrix_upline_id` int(11) NOT NULL DEFAULT '0',
    `has_mature` int(11) NOT NULL DEFAULT '0',
    `is_active` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `network_matrix_basic`
--

INSERT INTO
    `network_matrix_basic` (`user_id`, `is_active`)
VALUES (1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `network_matrix_executive`
--

DROP TABLE IF EXISTS `network_matrix_executive`;

CREATE TABLE IF NOT EXISTS `network_matrix_executive` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `matrix_upline_id` int(11) NOT NULL DEFAULT '0',
    `has_mature` int(11) NOT NULL DEFAULT '0',
    `is_active` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `network_matrix_executive`
--

INSERT INTO
    `network_matrix_executive` (`user_id`, `is_active`)
VALUES (1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `network_matrix_regular`
--

DROP TABLE IF EXISTS `network_matrix_regular`;

CREATE TABLE IF NOT EXISTS `network_matrix_regular` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `matrix_upline_id` int(11) NOT NULL DEFAULT '0',
    `has_mature` int(11) NOT NULL DEFAULT '0',
    `is_active` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `network_matrix_regular`
--

INSERT INTO
    `network_matrix_regular` (`user_id`, `is_active`)
VALUES (1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `network_payouts`
--

DROP TABLE IF EXISTS `network_payouts`;

CREATE TABLE IF NOT EXISTS `network_payouts` (
    `payout_id` int(11) NOT NULL AUTO_INCREMENT,
    `transaction_id` int(11) NOT NULL,
    `amount` double NOT NULL,
    `payout_date` int(11) NOT NULL,
    `payout_total` double NOT NULL,
    `amount_tax` double NOT NULL,
    `total_tax` double NOT NULL,
    PRIMARY KEY (`payout_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_power`
--

DROP TABLE IF EXISTS `network_power`;

CREATE TABLE IF NOT EXISTS `network_power` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `bonus_power_executive` double NOT NULL DEFAULT '0',
    `bonus_power_executive_now` double NOT NULL DEFAULT '0',
    `bonus_power_executive_last` double NOT NULL DEFAULT '0',
    `bonus_power_regular` double NOT NULL DEFAULT '0',
    `bonus_power_regular_now` double NOT NULL DEFAULT '0',
    `bonus_power_regular_last` double NOT NULL DEFAULT '0',
    `bonus_power_associate` double NOT NULL DEFAULT '0',
    `bonus_power_associate_now` double NOT NULL DEFAULT '0',
    `bonus_power_associate_last` double NOT NULL DEFAULT '0',
    `bonus_power_basic` double NOT NULL DEFAULT '0',
    `bonus_power_basic_now` double NOT NULL DEFAULT '0',
    `bonus_power_basic_last` double NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `network_power`
--

INSERT INTO `network_power` (`id`) VALUES (1);

-- --------------------------------------------------------

--
-- Table structure for table `network_power_associate`
--

DROP TABLE IF EXISTS `network_power_associate`;

CREATE TABLE IF NOT EXISTS `network_power_associate` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `power_upline_id` int(11) NOT NULL DEFAULT '0',
    `has_mature` int(11) NOT NULL DEFAULT '0',
    `is_active` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_power_basic`
--

DROP TABLE IF EXISTS `network_power_basic`;

CREATE TABLE IF NOT EXISTS `network_power_basic` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `power_upline_id` int(11) NOT NULL DEFAULT '0',
    `has_mature` int(11) NOT NULL DEFAULT '0',
    `is_active` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `network_power_basic`
--

INSERT INTO
    `network_power_basic` (`user_id`, `is_active`)
VALUES (1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `network_power_executive`
--

DROP TABLE IF EXISTS `network_power_executive`;

CREATE TABLE IF NOT EXISTS `network_power_executive` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `power_upline_id` int(11) NOT NULL DEFAULT '0',
    `has_mature` int(11) NOT NULL DEFAULT '0',
    `is_active` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_power_regular`
--

DROP TABLE IF EXISTS `network_power_regular`;

CREATE TABLE IF NOT EXISTS `network_power_regular` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `power_upline_id` int(11) NOT NULL DEFAULT '0',
    `has_mature` int(11) NOT NULL DEFAULT '0',
    `is_active` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_ranking_maintain`
--

DROP TABLE IF EXISTS `network_ranking_maintain`;

CREATE TABLE IF NOT EXISTS `network_ranking_maintain` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL DEFAULT '0',
    `maintain_ranking` double NOT NULL DEFAULT '0',
    `maintain_ranking_now` double NOT NULL DEFAULT '0',
    `maintain_ranking_last` double NOT NULL DEFAULT '0',
    `period_ranking_maintain` double NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_repeat`
--

DROP TABLE IF EXISTS `network_repeat`;

CREATE TABLE IF NOT EXISTS `network_repeat` (
    `repeat_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `item_id` int(11) NOT NULL,
    `date` int(11) NOT NULL,
    `reward_points` double NOT NULL,
    `unilevel_points` double NOT NULL,
    `binary_points` double NOT NULL,
    `price` double NOT NULL,
    `quantity` int(11) NOT NULL,
    `position` enum('Left', 'Right') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Left',
    `total_purchases` double NOT NULL,
    `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
    `method` enum('efund', 'token') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'efund',
    `status` enum(
        'Awaiting Delivery',
        'Delivered'
    ) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Awaiting Delivery',
    PRIMARY KEY (`repeat_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_session`
--

DROP TABLE IF EXISTS `network_session`;

CREATE TABLE IF NOT EXISTS `network_session` (
    `user_id` int(11) NOT NULL COMMENT 'user id',
    `session_id` varchar(32) NOT NULL COMMENT 'md5(key)',
    PRIMARY KEY (`user_id`),
    UNIQUE KEY `session_id` (`session_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_share`
--

DROP TABLE IF EXISTS `network_share`;

CREATE TABLE IF NOT EXISTS `network_share` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `bonus_share_chairman` double NOT NULL DEFAULT '0',
    `bonus_share_chairman_now` double NOT NULL DEFAULT '0',
    `bonus_share_chairman_last` double NOT NULL DEFAULT '0',
    `bonus_share_director` double NOT NULL DEFAULT '0',
    `bonus_share_director_now` double NOT NULL DEFAULT '0',
    `bonus_share_director_last` double NOT NULL DEFAULT '0',
    `bonus_share_executive` double NOT NULL DEFAULT '0',
    `bonus_share_executive_now` double NOT NULL DEFAULT '0',
    `bonus_share_executive_last` double NOT NULL DEFAULT '0',
    `bonus_share_regular` double NOT NULL DEFAULT '0',
    `bonus_share_regular_now` double NOT NULL DEFAULT '0',
    `bonus_share_regular_last` double NOT NULL DEFAULT '0',
    `bonus_share_associate` double NOT NULL DEFAULT '0',
    `bonus_share_associate_now` double NOT NULL DEFAULT '0',
    `bonus_share_associate_last` double NOT NULL DEFAULT '0',
    `bonus_share_basic` double NOT NULL DEFAULT '0',
    `bonus_share_basic_now` double NOT NULL DEFAULT '0',
    `bonus_share_basic_last` double NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `network_share`
--

INSERT INTO `network_share` (`id`) VALUES (1);

-- --------------------------------------------------------

--
-- Table structure for table `network_share_associate`
--

DROP TABLE IF EXISTS `network_share_associate`;

CREATE TABLE IF NOT EXISTS `network_share_associate` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `share_upline_id` int(11) NOT NULL DEFAULT '0',
    `has_mature` int(11) NOT NULL DEFAULT '0',
    `is_active` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_share_basic`
--

DROP TABLE IF EXISTS `network_share_basic`;

CREATE TABLE IF NOT EXISTS `network_share_basic` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `share_upline_id` int(11) NOT NULL DEFAULT '0',
    `has_mature` int(11) NOT NULL DEFAULT '0',
    `is_active` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `network_share_basic`
--

INSERT INTO
    `network_share_basic` (`user_id`, `is_active`)
VALUES (1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `network_share_chairman`
--

DROP TABLE IF EXISTS `network_share_chairman`;

CREATE TABLE IF NOT EXISTS `network_share_chairman` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `share_upline_id` int(11) NOT NULL DEFAULT '0',
    `has_mature` int(11) NOT NULL DEFAULT '0',
    `is_active` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_share_director`
--

DROP TABLE IF EXISTS `network_share_director`;

CREATE TABLE IF NOT EXISTS `network_share_director` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `share_upline_id` int(11) NOT NULL DEFAULT '0',
    `has_mature` int(11) NOT NULL DEFAULT '0',
    `is_active` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_share_executive`
--

DROP TABLE IF EXISTS `network_share_executive`;

CREATE TABLE IF NOT EXISTS `network_share_executive` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `share_upline_id` int(11) NOT NULL DEFAULT '0',
    `has_mature` int(11) NOT NULL DEFAULT '0',
    `is_active` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_share_regular`
--

DROP TABLE IF EXISTS `network_share_regular`;

CREATE TABLE IF NOT EXISTS `network_share_regular` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `share_upline_id` int(11) NOT NULL DEFAULT '0',
    `has_mature` int(11) NOT NULL DEFAULT '0',
    `is_active` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_token_add`
--

DROP TABLE IF EXISTS `network_token_add`;

CREATE TABLE IF NOT EXISTS `network_token_add` (
    `add_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `amount` double NOT NULL,
    `date` int(11) NOT NULL,
    PRIMARY KEY (`add_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_token_conversions`
--

DROP TABLE IF EXISTS `network_token_conversions`;

CREATE TABLE IF NOT EXISTS `network_token_conversions` (
  `conversion_id` int NOT NULL AUTO_INCREMENT,
  `transaction_id` int NOT NULL DEFAULT '0',
  `amount` double NOT NULL DEFAULT '0',
  `price` double NOT NULL DEFAULT '0',
  `method` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `conversion_date` int NOT NULL DEFAULT '0',
  `conversion_total` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`conversion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_token_convert`
--

DROP TABLE IF EXISTS `network_token_convert`;

CREATE TABLE IF NOT EXISTS `network_token_convert` (
  `convert_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL DEFAULT '0',
  `amount` double NOT NULL DEFAULT '0',
  `price` double NOT NULL DEFAULT '0',
  `cut` double NOT NULL DEFAULT '0',
  `mode` enum('sop','fdp','fdtp','ftk') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'fdtp',
  `method` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `date_posted` int NOT NULL DEFAULT '0',
  `date_approved` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`convert_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_top_up`
--

DROP TABLE IF EXISTS `network_top_up`;

CREATE TABLE IF NOT EXISTS `network_top_up` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `time_last` int(11) NOT NULL,
    `value_last` double NOT NULL,
    `day` int(11) NOT NULL,
    `principal` double NOT NULL,
    `date_entry` int(11) NOT NULL,
    `processing` int(11) NOT NULL,
    `maturity` int(11) NOT NULL,
    `time_mature` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_transactions`
--

DROP TABLE IF EXISTS `network_transactions`;

CREATE TABLE IF NOT EXISTS `network_transactions` (
    `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `transaction` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
    `details` text COLLATE utf8mb4_unicode_ci NOT NULL,
    `value` double NOT NULL,
    `balance` double NOT NULL,
    `transaction_date` int(11) NOT NULL,
    PRIMARY KEY (`transaction_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_transfer`
--

DROP TABLE IF EXISTS `network_transfer_points`;

CREATE TABLE IF NOT EXISTS `network_transfer_points` (
    `transfer_id` int NOT NULL AUTO_INCREMENT,
    `transfer_from` int NOT NULL,
    `transfer_to` int NOT NULL,
    `type` enum('transfer', 'deposit') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'transfer',
    `date` int NOT NULL,
    `amount` double NOT NULL,
    PRIMARY KEY (`transfer_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_transfer`
--

DROP TABLE IF EXISTS `network_transfer`;

CREATE TABLE IF NOT EXISTS `network_transfer` (
    `transfer_id` int(11) NOT NULL AUTO_INCREMENT,
    `transfer_from` int(11) NOT NULL,
    `transfer_to` int(11) NOT NULL,
    `type` enum('transfer', 'deposit') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'transfer',
    `date` int(11) NOT NULL,
    `amount` double NOT NULL,
    PRIMARY KEY (`transfer_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_savings_transfer`
--

DROP TABLE IF EXISTS `network_savings_transfer`;

CREATE TABLE IF NOT EXISTS `network_savings_transfer` (
    `transfer_id` int(11) NOT NULL AUTO_INCREMENT,
    `transfer_from` int(11) NOT NULL,
    `transfer_to` int(11) NOT NULL,
    `type` enum('transfer', 'deposit') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'transfer',
    `date` int(11) NOT NULL,
    `amount` double NOT NULL,
    PRIMARY KEY (`transfer_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_loans_transfer`
--

DROP TABLE IF EXISTS `network_loans_transfer`;

CREATE TABLE IF NOT EXISTS `network_loans_transfer` (
    `transfer_id` int(11) NOT NULL AUTO_INCREMENT,
    `transfer_from` int(11) NOT NULL,
    `transfer_to` int(11) NOT NULL,
    `type` enum('transfer', 'deposit') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'transfer',
    `date` int(11) NOT NULL,
    `amount` double NOT NULL,
    PRIMARY KEY (`transfer_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_transfer_fmc`
--

DROP TABLE IF EXISTS `network_transfer_fmc`;

CREATE TABLE IF NOT EXISTS `network_transfer_fmc` (
    `transfer_id` int(11) NOT NULL AUTO_INCREMENT,
    `transfer_from` int(11) NOT NULL,
    `transfer_to` int(11) NOT NULL,
    `type` enum('transfer', 'deposit') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'transfer',
    `date` int(11) NOT NULL,
    `amount` double NOT NULL,
    PRIMARY KEY (`transfer_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_unilevel`
--

DROP TABLE IF EXISTS `network_unilevel`;

CREATE TABLE IF NOT EXISTS `network_unilevel` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL DEFAULT '0',
    `bonus_unilevel` double NOT NULL DEFAULT '0',
    `bonus_unilevel_now` double NOT NULL DEFAULT '0',
    `bonus_unilevel_last` double NOT NULL DEFAULT '0',
    `period_unilevel` double NOT NULL DEFAULT '0',
    `income_today` double NOT NULL DEFAULT '0',
    `date_last_flushout` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `network_unilevel`
--

INSERT INTO `network_unilevel` (`user_id`) VALUES (1);

-- --------------------------------------------------------

--
-- Table structure for table `network_users`
--

DROP TABLE IF EXISTS `network_users`;

CREATE TABLE IF NOT EXISTS `network_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sponsor_id` int NOT NULL DEFAULT '0',
  `has_maintain` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `elite` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `balance` double NOT NULL DEFAULT '0',
  `income_cycle_global` double NOT NULL DEFAULT '0',
  `income_flushout` double NOT NULL DEFAULT '0',
  `fifth_pair_token_balance` double NOT NULL DEFAULT '0' COMMENT 'loyalty token',
  `username` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `fullname` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `block` tinyint NOT NULL DEFAULT '0',
  `usertype` enum('Member','Admin','manager') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Member',
  `picture` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `date_registered` int NOT NULL DEFAULT '0',
  `date_activated` int NOT NULL DEFAULT '0',
  `email` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` json DEFAULT NULL,
  `beneficiary` json DEFAULT NULL,
  `points` double NOT NULL DEFAULT '0',
  `account_type` enum('chairman','executive','regular','associate','basic','starter') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'starter',
  `rank` enum('affiliate','supervisor','manager','director') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'affiliate',
  `rank_reward` double NOT NULL DEFAULT '0',
  `elite_reward` double NOT NULL DEFAULT '0',
  `bank` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method` json DEFAULT NULL,
  `income_referral` double NOT NULL DEFAULT '0',
  `income_referral_flushout` double NOT NULL DEFAULT '0',
  `bonus_echelon` double NOT NULL DEFAULT '0',
  `payout_total` double NOT NULL DEFAULT '0',
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payout_giftcheck` double NOT NULL DEFAULT '0',
  `payout_transfer` double NOT NULL DEFAULT '0',
  `unilevel` double NOT NULL DEFAULT '0',
  `balance_fmc` double NOT NULL DEFAULT '0',
  `p2p_wallet` json DEFAULT NULL,
  `bonus_leadership` double NOT NULL DEFAULT '0',
  `bonus_leadership_passive` double NOT NULL DEFAULT '0',
  `bonus_indirect_referral` double NOT NULL DEFAULT '0',
  `bonus_indirect_referral_points` double NOT NULL DEFAULT '0',
  `bonus_indirect_referral_fmc` double NOT NULL DEFAULT '0',
  `bonus_matrix` double NOT NULL DEFAULT '0',
  `bonus_power` double NOT NULL DEFAULT '0',
  `bonus_share` double NOT NULL DEFAULT '0',
  `bonus_harvest` double NOT NULL DEFAULT '0',
  `top_up_principal` double NOT NULL DEFAULT '0',
  `top_up_interest` double NOT NULL DEFAULT '0',
  `fast_track_principal` double NOT NULL DEFAULT '0',
  `fast_track_interest` double NOT NULL DEFAULT '0',
  `fixed_daily_interest` double NOT NULL DEFAULT '0',
  `fixed_daily_token_interest` double NOT NULL COMMENT 'Non-efund',
  `compound_daily_interest` double NOT NULL DEFAULT '0',
  `donation` double NOT NULL DEFAULT '0',
  `fixed_daily_token_donation` double NOT NULL DEFAULT '0' COMMENT 'Non-efund',
  `merchant_type` enum('chairman','executive','regular','associate','basic','starter') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'starter',
  `bonus_merchant` double NOT NULL DEFAULT '0',
  `coin_transfer` double NOT NULL DEFAULT '0',
  `bonus_leadership_passive_balance` double NOT NULL DEFAULT '0',
  `top_up_balance` double NOT NULL DEFAULT '0',
  `fast_track_balance` double NOT NULL DEFAULT '0',
  `fixed_daily_balance` double NOT NULL DEFAULT '0',
  `fixed_daily_deposit_today` double NOT NULL DEFAULT '0',
  `fixed_daily_token_balance` double NOT NULL DEFAULT '0' COMMENT 'Non-efund',
  `fixed_daily_token_deposit_today` double NOT NULL DEFAULT '0' COMMENT 'Non-efund',
  `compound_daily_balance` double NOT NULL DEFAULT '0',
  `upline_support` double NOT NULL DEFAULT '0',
  `passup_bonus` double NOT NULL DEFAULT '0',
  `passup_binary_bonus` double NOT NULL DEFAULT '0',
  `stockist_bonus` double NOT NULL DEFAULT '0',
  `franchise_bonus` double NOT NULL DEFAULT '0',
  `endowment_bonus` double NOT NULL DEFAULT '0',
  `converted_today` double NOT NULL DEFAULT '0',
  `converted_token_today` double NOT NULL DEFAULT '0',
  `requested_today` double NOT NULL DEFAULT '0',
  `status_global` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `savings` double NOT NULL DEFAULT '0',
  `share_fund` double NOT NULL DEFAULT '0',
  `loans` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `network_users`
--

INSERT INTO
    `network_users` (
        `username`,
        `fullname`,
        `password`,
        `usertype`,
        `date_registered`,
        `date_activated`,
        `email`,
        `account_type`,
        `rank`,
        `bank`,
        `address`,
        `balance_fmc`,
        `payout_transfer`,
        `merchant_type`
    )
VALUES (
        'admin',
        'Bitcash',
        '63a9f0ea7bb98050796b649e85481845',
        'Admin',
        UNIX_TIMESTAMP(),
        UNIX_TIMESTAMP(),
        'admin@bit-cash.online',
        'executive',
        'director',
        '',
        '',
        20978512206.617814,
        1000000,
        'executive'
    );

-- --------------------------------------------------------

--
-- Table structure for table `network_withdrawals`
--

DROP TABLE IF EXISTS `network_withdrawals`;

CREATE TABLE IF NOT EXISTS `network_withdrawals` (
    `withdrawal_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `amount` double NOT NULL,
    `amount_final` double NOT NULL,
    `deductions_total` double NOT NULL,
    `date_requested` int(11) NOT NULL,
    `date_completed` int(11) NOT NULL,
    `method` enum('Check', 'Bank Deposit') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Check',
    PRIMARY KEY (`withdrawal_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_endowment`
--

DROP TABLE IF EXISTS `network_endowment`;

CREATE TABLE `network_endowment` (
    `endowment_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL DEFAULT '0',
    `time_last` int(11) NOT NULL DEFAULT '0',
    `value_last` double NOT NULL DEFAULT '0',
    `day` int(11) NOT NULL DEFAULT '0',
    `date_entry` int(11) NOT NULL DEFAULT '0',
    `maturity` int(11) NOT NULL DEFAULT '0',
    `time_mature` int(11) NOT NULL DEFAULT '0',
    `pocket` double NOT NULL DEFAULT '0',
    PRIMARY KEY (`endowment_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_p2p_sell_tokens`
--

DROP TABLE IF EXISTS `network_p2p_sell_tokens`;

CREATE TABLE IF NOT EXISTS `network_p2p_sell_tokens` (
    `sell_id` int(11) NOT NULL AUTO_INCREMENT,
    `purchase_id` int(11) NOT NULL DEFAULT '0',
    `seller_id` int(11) NOT NULL DEFAULT '0',
    `amount_remaining` double NOT NULL DEFAULT '0',
    `amount_minimum` double NOT NULL DEFAULT '0',
    `amount_sold` double NOT NULL DEFAULT '0',
    `type` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `method` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `price` double NOT NULL DEFAULT '0',
    `total_sell` double NOT NULL DEFAULT '0',
    `date_posted` int(11) NOT NULL DEFAULT '0',
    `date_updated` int(11) NOT NULL DEFAULT '0',
    `date_confirmed` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`sell_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_p2p_token_sale`
--

DROP TABLE IF EXISTS `network_p2p_token_sale`;

CREATE TABLE IF NOT EXISTS `network_p2p_token_sale` (
    `request_id` int(11) NOT NULL AUTO_INCREMENT,
    `sale_id` int(11) NOT NULL DEFAULT '0',
    `buyer_id` int(11) NOT NULL DEFAULT '0',
    `amount_pending` double NOT NULL DEFAULT '0',
    `amount_minimum` double NOT NULL DEFAULT '0',
    `amount` double NOT NULL DEFAULT '0',
    `type_buy` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `method_buy` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `price_buy` double NOT NULL DEFAULT '0',
    `total` double NOT NULL DEFAULT '0',
    `date_requested` int(11) NOT NULL DEFAULT '0',
    `date_updated` int(11) NOT NULL DEFAULT '0',
    `date_confirmed` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`request_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_p2p_token_sale`
--

DROP TABLE IF EXISTS `network_p2p_transactions`;

CREATE TABLE IF NOT EXISTS `network_p2p_transactions` (
    `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
    `seller_id` int(11) NOT NULL DEFAULT '0',
    `buyer_id` int(11) NOT NULL DEFAULT '0',
    `amount` double NOT NULL DEFAULT '0',
    `type` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `method` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `price` double NOT NULL DEFAULT '0',
    `final` double NOT NULL DEFAULT '0',
    `date_open` int(11) NOT NULL DEFAULT '0',
    `date_close` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`transaction_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_efund_convert`
--

DROP TABLE IF EXISTS `network_efund_convert`;

CREATE TABLE IF NOT EXISTS `network_efund_convert` (
    `convert_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL DEFAULT '0',
    `amount` double NOT NULL DEFAULT '0',
    `price` double NOT NULL DEFAULT '0',
    `cut` double NOT NULL DEFAULT '0',
    `mode` enum('sop', 'fdp', 'ftk') COLLATE utf8mb4_unicode_ci DEFAULT 'sop',
    `method` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `date_posted` int(11) NOT NULL DEFAULT '0',
    `date_approved` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`convert_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_efund_conversions`
--

DROP TABLE IF EXISTS `network_efund_conversions`;

CREATE TABLE IF NOT EXISTS `network_efund_conversions` (
    `conversion_id` int(11) NOT NULL AUTO_INCREMENT,
    `transaction_id` int(11) NOT NULL DEFAULT '0',
    `amount` double NOT NULL DEFAULT '0',
    `price` double NOT NULL DEFAULT '0',
    `method` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `conversion_date` int(11) NOT NULL DEFAULT '0',
    `conversion_total` double NOT NULL DEFAULT '0',
    PRIMARY KEY (`conversion_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_p2p_sell_items`
--

DROP TABLE IF EXISTS `network_p2p_sell_items`;

CREATE TABLE IF NOT EXISTS `network_p2p_sell_items` (
    `sell_id` int(11) NOT NULL AUTO_INCREMENT,
    `purchase_id` int(11) NOT NULL DEFAULT '0',
    `item_id` int(11) NOT NULL DEFAULT '0',
    `amount_min` double NOT NULL DEFAULT '0',
    `method` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `total` double NOT NULL DEFAULT '0',
    `date_posted` int(11) NOT NULL DEFAULT '0',
    `date_updated` int(11) NOT NULL DEFAULT '0',
    `date_confirmed` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`sell_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_p2p_item_sale`
--

DROP TABLE IF EXISTS `network_p2p_item_sale`;

CREATE TABLE IF NOT EXISTS `network_p2p_item_sale` (
    `request_id` int(11) NOT NULL AUTO_INCREMENT,
    `sale_id` int(11) NOT NULL DEFAULT '0',
    `buyer_id` int(11) NOT NULL DEFAULT '0',
    `item_id` int(11) NOT NULL DEFAULT '0',
    `amount_min` double NOT NULL DEFAULT '0',
    `method` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `total` double NOT NULL DEFAULT '0',
    `date_requested` int(11) NOT NULL DEFAULT '0',
    `date_updated` int(11) NOT NULL DEFAULT '0',
    `date_confirmed` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`request_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_p2p_items`
--

DROP TABLE IF EXISTS network_items_p2p;

CREATE TABLE IF NOT EXISTS `network_p2p_items` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL DEFAULT '0',
    `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
    `category` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `picture` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `price` double NOT NULL DEFAULT '0',
    `quantity` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_p2p_commerce_logs`
--

DROP TABLE IF EXISTS network_p2p_item_transactions;

CREATE TABLE IF NOT EXISTS `network_p2p_item_transactions` (
    `trx_id` int(11) NOT NULL AUTO_INCREMENT,
    `seller_id` int(11) NOT NULL DEFAULT '0',
    `buyer_id` int(11) NOT NULL DEFAULT '0',
    `item_id` int(11) NOT NULL DEFAULT '0',
    `amount` double NOT NULL DEFAULT '0',
    `method` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `final` double NOT NULL DEFAULT '0',
    `date_open` int(11) NOT NULL DEFAULT '0',
    `date_close` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`trx_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_p2p_commerce_logs`
--

DROP TABLE IF EXISTS network_passup_binary;

CREATE TABLE IF NOT EXISTS `network_passup_binary` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `bonus_passup_binary` double NOT NULL DEFAULT '0',
  `bonus_passup_binary_now` double NOT NULL DEFAULT '0',
  `bonus_passup_binary_last` double NOT NULL DEFAULT '0',
  `bonus_passup_binary_points` double NOT NULL DEFAULT '0',
  `bonus_passup_binary_points_now` double NOT NULL DEFAULT '0',
  `bonus_passup_binary_points_last` double NOT NULL DEFAULT '0',
  `bonus_passup_binary_fmc` double NOT NULL DEFAULT '0',
  `bonus_passup_binary_fmc_now` double NOT NULL DEFAULT '0',
  `bonus_passup_binary_fmc_last` double NOT NULL DEFAULT '0',
  `income_today` double NOT NULL DEFAULT '0',
  `flushout_local` double NOT NULL DEFAULT '0',
  `flushout_global` double NOT NULL DEFAULT '0',
  `date_last_flushout` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `network_passup_binary`
--

INSERT INTO `network_passup_binary` (`user_id`) VALUES (1);
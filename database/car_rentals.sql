-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: june 3, 2024 at 08:08 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

SET AUTOCOMMIT = 0;

START TRANSACTION;

SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!40101 SET NAMES utf8mb4 */
;

--
-- Database: `car_rental`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
    `id` int(11) NOT NULL,
    `booking_id` varchar(50) NOT NULL,
    `car` int(11) NOT NULL,
    `customer` int(11) NOT NULL,
    `start_date` datetime NOT NULL,
    `end_date` datetime NOT NULL,
    `total_price` varchar(20) NOT NULL,
    `booking_status` varchar(20) NOT NULL DEFAULT 'Pending',
    `txnid` varchar(50) NOT NULL,
    `payment_id` varchar(50) DEFAULT NULL,
    `payment_mode` varchar(20) DEFAULT NULL,
    `payment_status` varchar(50) NOT NULL,
    `payment_date` varchar(50) NOT NULL,
    `booking_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

--
-- Dumping data for table `booking`
--

INSERT INTO
    `booking` (
        `id`,
        `booking_id`,
        `car`,
        `customer`,
        `start_date`,
        `end_date`,
        `total_price`,
        `booking_status`,
        `txnid`,
        `payment_id`,
        `payment_mode`,
        `payment_status`,
        `payment_date`,
        `booking_date`
    )
VALUES (
        1,
        'BK663dd0a646ba2',
        1,
        1,
        '2024-05-10 13:14:00',
        '2024-05-11 13:14:00',
        '2930.00',
        'Booked',
        'Txn40566793',
        NULL,
        'online',
        'success',
        '2024-05-10 13:15:42',
        '2024-05-10 07:45:42'
    );

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
    `id` int(11) NOT NULL,
    `brand_name` varchar(50) NOT NULL,
    `image` varchar(150) NOT NULL,
    `status` varchar(15) NOT NULL DEFAULT 'Enable',
    `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

--
-- Dumping data for table `brands`
--

INSERT INTO
    `brands` (
        `id`,
        `brand_name`,
        `image`,
        `status`,
        `created_at`
    )
VALUES (
        1,
        'Maruti Suzuki',
        '../admin/uploaded-files/brands/3ea7d8fc9f276b6ca818fc58f173f5af.png',
        'Enable',
        '2024-05-09 09:40:55'
    ),
    (
        2,
        'BMW',
        '../admin/uploaded-files/brands/180b8f96e6ed97b42a06e6167db119fb.png',
        'Enable',
        '2024-05-09 09:41:10'
    ),
    (
        4,
        'Toyota',
        '../admin/uploaded-files/brands/b721dc7c8acba9b4d27281f47efa6400.png',
        'Enable',
        '2024-05-09 09:41:46'
    ),
    (
        5,
        'Ford',
        '../admin/uploaded-files/brands/48819963f71d8b66c520fde2ad962054.png',
        'Enable',
        '2024-05-09 09:41:57'
    ),
    (
        6,
        'Mahindra',
        '../admin/uploaded-files/brands/3d2f6cae754ff62004849119d5221829.png',
        'Enable',
        '2024-05-09 09:42:18'
    ),
    (
        7,
        'Hyundai',
        '../admin/uploaded-files/brands/309349b705f3f97467cb352e1fe7653d.png',
        'Enable',
        '2024-05-09 10:25:24'
    );

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
    `id` int(11) NOT NULL,
    `car_name` varchar(150) NOT NULL,
    `brand` int(11) NOT NULL,
    `car_body_type` varchar(50) DEFAULT NULL,
    `transmission` varchar(50) NOT NULL,
    `fuel_type` varchar(20) NOT NULL,
    `model` varchar(20) NOT NULL,
    `seating_capacity` varchar(20) NOT NULL,
    `km_driven` varchar(20) NOT NULL,
    `price_per_day` varchar(20) NOT NULL,
    `reg_no` varchar(20) NOT NULL,
    `ac` int(11) NOT NULL,
    `sun_roof` int(11) NOT NULL,
    `air_bags` int(11) NOT NULL,
    `central_lock` int(11) NOT NULL,
    `description` text DEFAULT NULL,
    `status` varchar(20) NOT NULL DEFAULT 'Active',
    `image1` varchar(250) DEFAULT NULL,
    `image2` varchar(250) DEFAULT NULL,
    `image3` varchar(250) DEFAULT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

--
-- Dumping data for table `cars`
--

INSERT INTO
    `cars` (
        `id`,
        `car_name`,
        `brand`,
        `car_body_type`,
        `transmission`,
        `fuel_type`,
        `model`,
        `seating_capacity`,
        `km_driven`,
        `price_per_day`,
        `reg_no`,
        `ac`,
        `sun_roof`,
        `air_bags`,
        `central_lock`,
        `description`,
        `status`,
        `image1`,
        `image2`,
        `image3`,
        `created_at`
    )
VALUES
    -- --------------------------------------------------------
--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
    `id` int(11) NOT NULL,
    `name` varchar(150) NOT NULL,
    `email` varchar(50) NOT NULL,
    `phone` varchar(20) NOT NULL,
    `password` varchar(256) NOT NULL,
    `is_verified` varchar(20) NOT NULL DEFAULT 'Pending',
    `address` text DEFAULT NULL,
    `driving_license_no` varchar(50) DEFAULT NULL,
    `driving_license_image1` varchar(255) DEFAULT NULL,
    `driving_license_image2` varchar(255) DEFAULT NULL,
    `address_proof_no` varchar(50) DEFAULT NULL,
    `address_proof_image` varchar(255) DEFAULT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO
    `customers` (
        `id`,
        `name`,
        `email`,
        `phone`,
        `password`,
        `is_verified`,
        `address`,
        `driving_license_no`,
        `driving_license_image1`,
        `driving_license_image2`,
        `address_proof_no`,
        `address_proof_image`,
        `created_at`
    )
VALUES (
        1,
        'exc',
        'example@email.com',
        '1234567899',
        '$2y$10$rTqECsXCXlWqlXxZ/BSPQe21AADa6Y7WOdcukdn8GEugDzBYArr42',
        'Verified',
        'demo address',
        'wertyy321',
        '../admin/uploaded-files/customer-doc/DL/6370fff4078415b6e05c0afbd2e20947.png',
        '../admin/uploaded-files/customer-doc/DL/ee93817ba801290f240b694387041714.jpg',
        'rew21',
        '../admin/uploaded-files/customer-doc/address-proof/ee93817ba801290f240b694387041714.png',
        '2024-05-09 10:48:37'
    );

-- --------------------------------------------------------

--
-- Table structure for table `disabled_dates`
--

CREATE TABLE `disabled_dates` (
    `id` int(11) NOT NULL,
    `date` varchar(15) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

--
-- Dumping data for table `disabled_dates`
--

INSERT INTO `disabled_dates` (`id`, `date`) VALUES (1, '2020-02-07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
    `id` int(11) NOT NULL,
    `name` varchar(150) NOT NULL,
    `username` varchar(150) NOT NULL,
    `password` varchar(256) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = latin1;

--
-- Dumping data for table `users`
--

INSERT INTO
    `users` (
        `id`,
        `name`,
        `username`,
        `password`,
        `created_at`
    )
VALUES (
        1,
        'kudrat ali',
        'admin',
        '$2y$10$xpw2USQePEUGvIcMFMl/UeI2Icc7ESP55YDwq0Rz2VSYm4E9DY46G',
        '2020-02-05 18:08:30'
    );

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking` ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands` ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars` ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers` ADD PRIMARY KEY (`id`);

--
-- Indexes for table `disabled_dates`
--
ALTER TABLE `disabled_dates` ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users` ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 2;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 8;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 13;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 2;

--
-- AUTO_INCREMENT for table `disabled_dates`
--
ALTER TABLE `disabled_dates`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 2;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;
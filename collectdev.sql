-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2019 at 03:13 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `collectdev`
--

-- --------------------------------------------------------

--
-- Table structure for table `configurations`
--

CREATE TABLE `configurations` (
  `ID` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `ssid` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `sensor_id` int(11) NOT NULL,
  `sensor_condition` varchar(15) NOT NULL,
  `sensor_value` varchar(20) NOT NULL,
  `actuator_id` int(11) NOT NULL,
  `actuator_value_if` varchar(20) NOT NULL,
  `actuator_value_else` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `configurations`
--

INSERT INTO `configurations` (`ID`, `title`, `ssid`, `pass`, `user_id`, `sensor_id`, `sensor_condition`, `sensor_value`, `actuator_id`, `actuator_value_if`, `actuator_value_else`) VALUES
(21, 'First', 'Internet', '24021964', 1, 2, 'different', '5000', 3, 'ON', 'OFF'),
(22, 'Second', 'Miruna', 'breniuc2312', 1, 5, 'greater', '15', 3, 'ON', 'OFF'),
(23, 'Third', 'Miruna', 'breniuc2312', 1, 2, 'less', '30', 7, 'STOP', 'OK');

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `ID` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `value_title` varchar(20) DEFAULT NULL,
  `value_one` varchar(10) DEFAULT NULL,
  `value_or_to` varchar(2) DEFAULT NULL,
  `value_two` varchar(10) DEFAULT NULL,
  `library_code` varchar(255) DEFAULT NULL,
  `variable_code` varchar(255) DEFAULT NULL,
  `setup_code` varchar(255) DEFAULT NULL,
  `loop_code` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description_text` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`ID`, `name`, `type`, `value_title`, `value_one`, `value_or_to`, `value_two`, `library_code`, `variable_code`, `setup_code`, `loop_code`, `url`, `image`, `description_text`) VALUES
(1, 'ESP8266-01 Wifi Module', 'Wifi', NULL, NULL, NULL, NULL, '1_libraryCode.txt', '1_variableCode.txt', '1_setupCode.txt', '1_loopCode.txt', 'https://components101.com/wireless/esp8266-pinout-configuration-features-datasheet', '0b51cf13119cc80edce1a678184d1813.png', '1_descriptionText.txt'),
(2, 'TTP223 (Capacitive)', 'Sensor', 'Touch count', '0', 'to', '5000', NULL, '2_variableCode.txt', '2_setupCode.txt', '2_loopCode.txt', 'https://www.instructables.com/id/Tutorial-for-TTP223-Touch-Sensor-Module-Capacitive/', 'cb5d918d2ceb19fbfc50b4b8b1c442cf.png', '2_descriptionText.txt'),
(3, '2 Pin Led', 'Actuator', 'Turn', 'ON', 'or', 'OFF', NULL, '3_variableCode.txt', '3_setupCode.txt', '3_loopCode.txt', 'https://www.arduino.cc/en/Tutorial-0007/BlinkingLED', '7bc5bc05a9f7793588d648e3c643bf9f.png', '3_descriptionText.txt'),
(4, 'Arduino Uno R3 Board SMD', 'Arduino', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'https://ardushop.ro/ro/home/29-placa-de-dezvoltare-uno-r3.html', '502d2612a776bbae66f76296e8acbe72.png', NULL),
(5, 'HC-SR501 (Motion)', 'Sensor', NULL, NULL, NULL, NULL, NULL, '5_variableCode.txt', '5_setupCode.txt', '5_loopCode.txt', 'http://henrysbench.capnfatz.com/henrys-bench/arduino-sensors-and-input/arduino-hc-sr501-motion-sensor-tutorial/', '67031e93b7d50e8dd6d68ee3be1fb790.png', '5_descriptionText.txt'),
(6, 'HC-SR04 (Ultrasonic)', 'Sensor', NULL, NULL, NULL, NULL, NULL, '6_variableCode.txt', '6_setupCode.txt', '6_loopCode.txt', 'https://howtomechatronics.com/tutorials/arduino/ultrasonic-sensor-hc-sr04/', '996d39d64defcbc8ab29f644cbf6ef6f.png', '6_descriptionText.txt'),
(7, 'SSD1306 I2C (Display)', 'Actuator', NULL, NULL, NULL, NULL, '7_libraryCode.txt', '7_variableCode.txt', '7_setupCode.txt', '7_loopCode.txt', 'https://startingelectronics.org/tutorials/arduino/modules/OLED-128x64-I2C-display/', '353a500f51e52ff1f6076be5049ab601.png', '7_descriptionText.txt'),
(8, 'Tower Pro SG90 (Servo)', 'Actuator', 'Turn', 'ON', 'or', 'OFF', '8_libraryCode.txt', '8_variableCode.txt', '8_setupCode.txt', '8_loopCode.txt', 'https://www.intorobotics.com/tutorial-how-to-control-the-tower-pro-sg90-servo-with-arduino-uno/', 'e3073845378ccc985c2b5b992dd2a7aa.png', NULL),
(9, 'ARDUINO MEGA 2560 REV3', 'Arduino', '', '', '', '', NULL, NULL, NULL, NULL, 'https://store.arduino.cc/mega-2560-r3', 'db4ccf00816dd74a96b68126d266300d.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `email`, `password`, `first_name`, `last_name`, `admin`) VALUES
(1, 'maziluflorin84@gmail.com', '37464cef12ab0b987567e6dcefaf1aa4', 'Florin', 'Mazilu', 1),
(2, 'florin.mazilu@info.uaic.ro', '37464cef12ab0b987567e6dcefaf1aa4', 'Florin', 'Mazilu', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `configurations`
--
ALTER TABLE `configurations`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `configurations`
--
ALTER TABLE `configurations`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 01 2025 г., 11:31
-- Версия сервера: 9.1.0
-- Версия PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `hostel`
--

-- --------------------------------------------------------

--
-- Структура таблицы `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `NAME` text,
  `START` datetime DEFAULT NULL,
  `END` datetime DEFAULT NULL,
  `room_id` int DEFAULT NULL,
  `STATUS` varchar(30) DEFAULT NULL,
  `paid` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `reservations`
--

INSERT INTO `reservations` (`id`, `NAME`, `START`, `END`, `room_id`, `STATUS`, `paid`) VALUES
(1, 'Mr. Gray', '2025-06-02 14:00:00', '2025-06-10 12:00:00', 3, 'Confirmed', 50),
(2, 'Mrs. García', '2025-06-01 15:00:00', '2025-06-10 11:00:00', 1, 'Arrived', 0),
(3, 'Mr. Jones', '2025-06-04 13:00:00', '2025-06-07 10:00:00', 2, 'CheckedOut', 100),
(4, 'Ms. Smith', '2025-06-19 16:00:00', '2025-06-22 12:00:00', 4, 'New', 50),
(5, 'Dr. Brown', '2025-06-22 12:00:00', '2025-06-26 12:00:00', 5, 'Cancelled', 0),
(6, 'Miss Wilson', '2024-05-06 14:00:00', '2024-05-09 11:00:00', 2, 'Arrived', 0),
(7, 'Mr. Davis', '2024-05-07 10:00:00', '2024-05-11 10:00:00', 1, 'CheckedOut', 100),
(8, 'Mrs. Taylor', '2024-05-08 15:00:00', '2024-05-12 09:00:00', 3, 'New', 0),
(9, 'Mr. Anderson', '2024-05-09 13:00:00', '2024-05-14 11:00:00', 4, 'Arrived', 50),
(10, 'Ms. Martinez', '2024-05-10 12:00:00', '2024-05-15 12:00:00', 5, 'CheckedOut', 50),
(16, 'Микита', '2025-06-04 17:30:00', '2025-06-10 00:00:00', 7, 'New', 0),
(17, 'Іван', '2025-06-11 00:00:00', '2025-06-17 00:00:00', 8, 'New', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `rooms`
--

DROP TABLE IF EXISTS `rooms`;
CREATE TABLE IF NOT EXISTS `rooms` (
  `id` int NOT NULL AUTO_INCREMENT,
  `NAME` text,
  `capacity` int DEFAULT NULL,
  `STATUS` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `rooms`
--

INSERT INTO `rooms` (`id`, `NAME`, `capacity`, `STATUS`) VALUES
(1, 'Номер 1', 2, 'готово'),
(2, 'Номер 2', 1, 'прибирається'),
(3, 'Номер 3', 3, 'брудна'),
(4, 'Номер 4', 2, 'готово'),
(5, 'Номер 5', 4, 'готово'),
(6, 'Номер 6', 2, 'прибирається'),
(7, 'Номер 7', 1, 'брудна'),
(8, 'Номер 8', 2, 'готово'),
(9, 'Номер 9', 3, 'готово'),
(10, 'Номер \n10', 2, 'прибирається');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

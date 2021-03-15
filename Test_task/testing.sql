-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Мар 15 2021 г., 19:21
-- Версия сервера: 10.4.11-MariaDB
-- Версия PHP: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `testing`
--

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(128) NOT NULL,
  `article` int(128) NOT NULL,
  `name` varchar(128) NOT NULL,
  `price` double NOT NULL,
  `category` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `article`, `name`, `price`, `category`) VALUES
(1, 1021, 'Продукт №3', 480, 'Категория №4'),
(2, 1002, 'Продукт №2', 200, 'Категория №1'),
(3, 1003, 'Продукт №3', 150, 'Категория №4'),
(4, 1004, 'Продукт №4', 300, 'Категория №2'),
(5, 1005, 'Продукт №5', 400, 'Категория №4'),
(6, 1006, 'Продукт №6', 180, 'Категория №2'),
(7, 1007, 'Продукт №7', 250, 'Категория №3'),
(8, 1008, 'Продукт №8', 50, 'Категория №3'),
(9, 1009, 'Продукт №9', 70, 'Категория №2'),
(10, 1010, 'Продукт №10', 800, 'Категория №1'),
(11, 1011, 'Продукт №11', 480, 'Категория №4'),
(12, 1012, 'Продукт №12', 480, 'Категория №4'),
(25, 1020, 'Продукт №3', 480, 'Категория №4');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

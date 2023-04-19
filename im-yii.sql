-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 31 2019 г., 12:50
-- Версия сервера: 5.7.16
-- Версия PHP: 5.6.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `im-yii`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cart`
--

CREATE TABLE `cart` (
  `id` int(4) NOT NULL,
  `id_user` int(4) NOT NULL,
  `mass_prod` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(4) NOT NULL,
  `aleas` varchar(30) NOT NULL,
  `name` varchar(100) NOT NULL,
  `img` varchar(150) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `aleas`, `name`, `img`, `description`) VALUES
(1, '', 'Снаряжение', 'prod1.jpg', 'В выборе туристического рюкзака необходимо полагаться не только на его внешний вид, но и важные характеристики, такие как его объем, вес, крепления и многие другие. Для разных целей существуют отдельные подгруппы рюкзаков.'),
(2, '', 'Обувь', 'prod2.jpg', 'Описание категории обувь');

-- --------------------------------------------------------

--
-- Структура таблицы `characteristics`
--

CREATE TABLE `characteristics` (
  `id` int(4) NOT NULL,
  `id_prod` int(4) NOT NULL,
  `name` varchar(100) NOT NULL,
  `text` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(4) NOT NULL,
  `category` int(4) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` varchar(10) NOT NULL,
  `price_old` varchar(10) NOT NULL,
  `img` varchar(150) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `category`, `name`, `price`, `price_old`, `img`, `description`) VALUES
(1, 1, 'Шлем 1', '3500', '4000', 'prod4.jpg', 'В выборе туристического рюкзака необходимо полагаться не только на его внешний вид, но и важные характеристики, такие как его объем, вес, крепления и многие другие. Для разных целей существуют отдельные подгруппы рюкзаков.'),
(2, 1, 'Шлем 2', '3000', '', 'prod3.jpg', 'В выборе туристического рюкзака необходимо полагаться не только на его внешний вид, но и важные характеристики, такие как его объем, вес, крепления и многие другие. Для разных целей существуют отдельные подгруппы рюкзаков.'),
(3, 1, 'Рюкзак туристический', '5000', '', 'prod1.jpg', 'В выборе туристического рюкзака необходимо полагаться не только на его внешний вид, но и важные характеристики, такие как его объем, вес, крепления и многие другие. Для разных целей существуют отдельные подгруппы рюкзаков.'),
(4, 2, 'Обувь для скалолазания', '3000', '3100', 'prod2.jpg', 'В выборе туристического рюкзака необходимо полагаться не только на его внешний вид, но и важные характеристики, такие как его объем, вес, крепления и многие другие. Для разных целей существуют отдельные подгруппы рюкзаков.'),
(5, 1, 'Рюкзак туристический 1', '5000', '', 'prod1.jpg', 'В выборе туристического рюкзака необходимо полагаться не только на его внешний вид, но и важные характеристики, такие как его объем, вес, крепления и многие другие. Для разных целей существуют отдельные подгруппы рюкзаков.'),
(6, 1, 'Рюкзак туристический 2', '5000', '', 'prod1.jpg', 'В выборе туристического рюкзака необходимо полагаться не только на его внешний вид, но и важные характеристики, такие как его объем, вес, крепления и многие другие. Для разных целей существуют отдельные подгруппы рюкзаков.'),
(7, 1, 'Рюкзак туристический 3', '5000', '', 'prod1.jpg', 'В выборе туристического рюкзака необходимо полагаться не только на его внешний вид, но и важные характеристики, такие как его объем, вес, крепления и многие другие. Для разных целей существуют отдельные подгруппы рюкзаков.'),
(8, 1, 'Рюкзак туристический 4', '5000', '', 'prod1.jpg', 'В выборе туристического рюкзака необходимо полагаться не только на его внешний вид, но и важные характеристики, такие как его объем, вес, крепления и многие другие. Для разных целей существуют отдельные подгруппы рюкзаков.'),
(9, 1, 'Шлем 3', '3500', '4000', 'prod4.jpg', 'В выборе туристического рюкзака необходимо полагаться не только на его внешний вид, но и важные характеристики, такие как его объем, вес, крепления и многие другие. Для разных целей существуют отдельные подгруппы рюкзаков.'),
(10, 1, 'Шлем 4', '3000', '', 'prod3.jpg', 'В выборе туристического рюкзака необходимо полагаться не только на его внешний вид, но и важные характеристики, такие как его объем, вес, крепления и многие другие. Для разных целей существуют отдельные подгруппы рюкзаков.'),
(11, 1, 'Рюкзак туристический 5', '5000', '', 'prod1.jpg', 'В выборе туристического рюкзака необходимо полагаться не только на его внешний вид, но и важные характеристики, такие как его объем, вес, крепления и многие другие. Для разных целей существуют отдельные подгруппы рюкзаков.'),
(12, 1, 'Рюкзак туристический 6', '5000', '', 'prod1.jpg', 'В выборе туристического рюкзака необходимо полагаться не только на его внешний вид, но и важные характеристики, такие как его объем, вес, крепления и многие другие. Для разных целей существуют отдельные подгруппы рюкзаков.'),
(13, 1, 'Шлем 5', '3500', '4000', 'prod4.jpg', 'В выборе туристического рюкзака необходимо полагаться не только на его внешний вид, но и важные характеристики, такие как его объем, вес, крепления и многие другие. Для разных целей существуют отдельные подгруппы рюкзаков.'),
(14, 1, 'Шлем 6', '3000', '', 'prod3.jpg', 'В выборе туристического рюкзака необходимо полагаться не только на его внешний вид, но и важные характеристики, такие как его объем, вес, крепления и многие другие. Для разных целей существуют отдельные подгруппы рюкзаков.');

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `id` int(4) NOT NULL,
  `id_prod` int(4) NOT NULL,
  `id_user` int(4) NOT NULL,
  `text` text NOT NULL,
  `rating` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(5) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `user_surname` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `region` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `wish_list`
--

CREATE TABLE `wish_list` (
  `id` int(4) NOT NULL,
  `id_user` int(4) NOT NULL,
  `mass_prod` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `characteristics`
--
ALTER TABLE `characteristics`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `wish_list`
--
ALTER TABLE `wish_list`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `characteristics`
--
ALTER TABLE `characteristics`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `wish_list`
--
ALTER TABLE `wish_list`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

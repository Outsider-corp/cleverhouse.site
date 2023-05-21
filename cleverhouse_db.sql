-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3307
-- Время создания: Май 22 2023 г., 00:27
-- Версия сервера: 8.0.30
-- Версия PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- База данных: `cleverhouse_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `spec_cart`
--

CREATE TABLE `spec_cart` (
  `id_spec_cart` int NOT NULL,
  `id_cart` int NOT NULL,
  `id_product` int NOT NULL,
  `count` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `spec_cart`
--
ALTER TABLE `spec_cart`
  ADD PRIMARY KEY (`id_spec_cart`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `spec_cart`
--
ALTER TABLE `spec_cart`
  MODIFY `id_spec_cart` int NOT NULL AUTO_INCREMENT;
COMMIT;

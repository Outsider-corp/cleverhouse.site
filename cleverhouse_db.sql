-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3307
-- Время создания: Май 28 2023 г., 01:13
-- Версия сервера: 8.0.30
-- Версия PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cleverhouse_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cart`
--

CREATE TABLE `cart` (
  `id_cart` int NOT NULL,
  `id_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name_category` varchar(30) NOT NULL,
  `img_category` varchar(30) DEFAULT NULL,
  `description_category` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name_category`, `img_category`, `description_category`) VALUES
(1, 'Свет', 'Категория_свет.png', 'Умные лампы предназначены для использования в качестве источника освещения внутри помещений и на улице. Устройства снабжены функцией дистанционного контроля через сеть интернет посредством мобильного приложения.'),
(2, 'Розетки', 'Категория_розетка.png', 'Умные розетки – это современные устройства, которые позволяют управлять бытовой техникой и электроникой с помощью смартфона или голосовых команд. Установив умную розетку, вы получаете возможность удаленно включать и выключать устройства, а также устанавливать режимы работы и таймеры. Благодаря функции мониторинга, вы также можете следить за потреблением электроэнергии каждым прибором и управлять ими с максимальной эффективностью. Умные розетки – это не только удобно, но и экономично. Они помогут вам снизить расходы на электроэнергию и сделать жизнь проще и удобнее.'),
(3, 'Датчики', 'Категория_датчик.jpg', 'Умные датчики – это компактные устройства, которые позволяют автоматизировать управление бытовыми устройствами и создать умный дом. Установив умные датчики, вы можете контролировать температуру, влажность, освещение и другие параметры комнаты. Они могут использоваться для создания системы безопасности дома, управления системой полива и даже для ухода за растениями. Умные датчики помогут сделать ваш дом удобным и автоматизированным в соответствии с вашими потребностями. Наши умные датчики высокого качества, доступны по выгодным ценам и произведены проверенными производителями.'),
(4, 'Умные пылесосы', 'Категория_пылесос.jpg', 'Умные пылесосы – это современные устройства, которые позволяют вам автоматически убирать свой дом, не прилагая больших усилий. Они оснащены интеллектуальными системами управления, мощными моторами и инновационными насадками, которые позволяют эффективно убирать любые поверхности и углы квартиры. Умные пылесосы могут быть управляемы через голосовые команды, с помощью смартфона или планшета, что делает их использование более удобным и комфортным для вас.'),
(5, 'Кондиционеры', 'Категория_кондиционер.jpg', 'Умные кондиционеры – это современные устройства для создания комфортной обстановки в вашем доме. Они имеют интеллектуальную систему управления, которая позволяет настраивать и контролировать температуру в помещении с помощью смартфона или планшета. Умные кондиционеры отличаются высокой эффективностью и экономичностью, а также могут быть интегрированы в систему умного дома. Благодаря функции контроля за погодными условиями, умные кондиционеры могут автоматически регулировать температуру и увлажнение воздуха в вашем доме.');

-- --------------------------------------------------------

--
-- Структура таблицы `characteristics`
--

CREATE TABLE `characteristics` (
  `id_сharacteristic` int NOT NULL,
  `name_сharacteristic` varchar(30) NOT NULL,
  `description_сharacteristic` varchar(30) NOT NULL,
  `id_product` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `characteristics`
--

INSERT INTO `characteristics` (`id_сharacteristic`, `name_сharacteristic`, `description_сharacteristic`, `id_product`) VALUES
(1, 'Яркость', '5000K', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id_order` int NOT NULL,
  `id_user` int NOT NULL,
  `date_order` date NOT NULL,
  `id_cart` int NOT NULL,
  `type_payment` varchar(30) NOT NULL,
  `type_delivery` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `address` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `region` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name_product` varchar(30) NOT NULL,
  `price` int NOT NULL,
  `price_old` int DEFAULT NULL,
  `description` text,
  `count` int NOT NULL DEFAULT '0',
  `code` varchar(30) NOT NULL,
  `id_category` int NOT NULL,
  `img_product` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name_product`, `price`, `price_old`, `description`, `count`, `code`, `id_category`, `img_product`) VALUES
(1, 'Лампа светодиодная HIPER RGB', 846, 1054, 'Умная лампочка c разноцветной подсветкой HIPER IoT A60 Умная лампочка, поддерживает удаленное управление через приложение HIPER IoT, предназначена для использования в уже установленных люстрах и светильниках, наделяя их дополнительными функционалом. К особенностям данной модели можно отнести: • Самый распространенный формат LED-ламп A60. Лампа может быть установлена в самый популярный патрон Е27. \r\n• Поддержка сценариев умного дома. Лампа может включаться и выключаться, как по таймеру, так и в рамках сценариев. \r\n• Изменяемая температура света. Настроить комфортный теплый свет или контрастный холодный, все возможно в приложении от HIPER.\r\n• Настраиваемый цвет. Вы можете построить наиболее подходящий вам цвет света лампы. \r\n• Дистанционное управление. Благодаря поддержки технологии умного дома, возможно голосовое управление. \r\n• Диммируемость лампы. Можно регулировать яркость света придавая дополнительный уют вашему дому.', 400, '779440556', 1, 'Лампа светодиодная HIPER RGB.png'),
(2, 'Лампа NLL-A60-10-WiFi', 679, NULL, 'Возможность дистанционного включения/выключения.\r\nВозможность организации световых сценариев.\r\nRGB+ — возможность выбирать температуру света от 2700 до 6500 К, а также любой оттенок цветного свечения.\r\nДиммирование – плавная регулировка яркости свечения.\r\nRa индекс цветопередачи˃80\r\nОтсутствие пульсаций светового потока', 155, '5544896', 1, 'Лампа NLL-A60-10-WiFi.png'),
(3, 'Сетевой фильтр Rubetek RE-3310', 3800, 3955, 'Сетевой фильтр предназначен для удалённого управления питанием подключенных электроприборов суммарной мощностью до 2,5 кВт. Устройство содержит 3 стандартные электрические розетки, каждая из которых управляется независимо, а также 4 usb-разъема, благодаря которым вам больше не придется думать о переходниках для зарядки мобильных устройств.\r\nНастройте сценарии, и сетевой фильтр возьмет работу электроприборов под свой контроль. Включайте и выключайте розетки удаленно, контролируя каждую из них отдельно или сетевой фильтр в целом. Приложение позволяет настраивать персональные таймеры и сценарии взаимодействия устройств независимо для каждой розетки.\r\nСетевой фильтр работает с голосовыми помощниками: Алисой, Марусей, Siri, Google Assistant. Дайте голосовому помощнику команду выключить электроприбор и умный сетевой фильтр обесточит его.', 47, '121112', 2, 'Сетевой фильтр Rubetek RE-3310.png'),
(4, 'Умная розетка HIPER IoT P01', 999, 1051, 'Умная розетка HIPER IoT P01', 108, '4', 2, 'Умная розетка HIPER IoT P01.png'),
(5, 'Датчик температуры и влажности', 1958, 2023, 'Датчик Aqara Temperature and Humidity Sensor - незаменимый интеллектуальный помощник в доме, где следят за оптимальным температурным режимом и влажностью. Работая через многофункциональный шлюз, датчик, обнаружив, что влажность воздуха недостаточна, включит умные розетку и увлажнитель.\r\nДатчик сможет помочь и при высокой температуре воздуха, и автоматически включит кондиционер.\r\nОбнаружив, что показатели температуры, влажности и атмосферного давления не соответствуют норме, датчик отправит предупреждение на ваш телефон. Через приложение вы сможете узнать настоящую и историческую информацию о температуре, влажности и атмосферном давлении в вашем доме в любое время и в любом месте.', 0, '5', 3, 'Датчик температуры и влажности.png'),
(6, 'Детектор газа Aqara', 3199, 5200, 'Зафиксирует утечку газа, включит\r\nсигнализацию и отправит push-\r\nуведомление на смартфон. Подключается\r\nк сети 220 В и является ретранслятором\r\nZigbee 3.0.\r\nВ датчик встроена мощная сирена на 85 дБ, которая включается при обнаружении\r\nутечки. Также включается мигающий красный светодиод.\r\nАвтоматически добавляется в «Охранную систему»* в Aqara Home. При\r\nобнаружении утечки включит сирену на всех хабах.\r\nНа смартфон отправляется push-уведомление.', 6, '6', 3, 'Детектор газа Aqara.png'),
(7, 'Робот-пылесос Polaris', 18630, 20540, 'Робот-пылесос Polaris PVCR 3200 IQ Home Aqua с wi-fi управлением предназначен для сухой и влажной уборки. В приложении Polaris IQ Home вы из любой точки мира сможете включать прибор и следить за его состоянием, регулировать мощность всасывания и интенсивность подачи воды, отслеживать износ аксессуаров, установить защиту от детей (от несанкционированного запуска) и запланировать уборку на неделю вперед. Для любителей голосовых помощников настроена работа с Алисой и Марусей. Мотор 40 Вт обеспечивает высокую мощность всасывания для безукоризненной уборки. С помощью вращающихся боковых и центральной щетки пылесос собирает даже самый мелкий мусор, а благодаря системе продуманного построения маршрута GyroInside робот не пропустит ни одного участка в вашем доме. Емкость аккумулятора 3200 мАч обеспечивает до 150 минут уборки без подзарядки. Уровень шума не превышает 63 дБ. Оценить интерфейс и функционал прибора можно в деморежиме в приложении Polaris IQ Home.', 11, '7', 4, 'Робот-пылесос Polaris.png'),
(8, 'Робот-пылесос iCLEBO O5', 41900, 60222, 'iCLEBO O5 WiFi - самый технологичный и мощный робот-пылесос южнокорейского производителя. Является эволюционным продолжением модели Omega. Удобное управление и доступ к дополнительным функциям через приложение на смартфоне, увеличенная емкость аккумуляторной батареи, новый режим пониженного шума Silent Mode, высокопроизводительный бесколлекторный турбодвигатель и изящный дизайн. Идеально подходит для уборки любого типа мусора на разных поверхностях, включая шерсть домашних животных.', 0, '8', 4, 'Робот-пылесос iCLEBO O5.png'),
(9, 'Кондиционер Electrolux EACS', 34990, 43790, 'Electrolux EACS/I-07HAT/N3 — настенный кондиционер из серии Atrium DC Inverter, который обладает оптимальным набором функций, необходимых для создания комфортного микроклимата. В стандартной комплектации этой системы присутствуют самые востребованные опции, необходимые для удобной и эффективной эксплуатации: детектор утечки фреона, память настроек и возможность работы при отрицательных температурах.', 8, '9', 5, 'Кондиционер Electrolux EACS.png'),
(10, 'Кондиционер Ballu BSDI-18HN1', 72900, 80046, 'Новая серия инверторных сплит-систем LAGOON DC Inverter обладает всеми качествами, необходимыми для создания идеального климата. Расширенная линейка представлена приборами мощностью от 7к до 24к BTU. Кондиционер охлаждает или обогревает воздух при температуре за окном до -15°С. Удобной функцией является память положения жалюзи: при новом включении поток воздуха подается в уже заданном направлении. Прибор оснащен ионизатором воздуха, который устраняет неприятные запахи и бактерии!', 6, '10', 5, 'Кондиционер Ballu BSDI-18HN1.png'),
(12, 'Светодиодная лента Rubetek', 3490, NULL, 'Хорошая яркая светодиодная лента! Работает с Алисой!!!!!!', 0, '12', 1, 'Светодиодная лента Rubetek.png');

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `id_review` int NOT NULL,
  `rating` int DEFAULT NULL,
  `text_review` text NOT NULL,
  `id_user` int NOT NULL,
  `id_product` int NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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

-- --------------------------------------------------------

--
-- Структура таблицы `spec_wishlist`
--

CREATE TABLE `spec_wishlist` (
  `id_spec_wishlist` int NOT NULL,
  `id_wishlist` int NOT NULL,
  `id_product` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `name_user` varchar(30) NOT NULL,
  `telephone_user` varchar(20) NOT NULL,
  `email_user` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `region_user` varchar(30) DEFAULT NULL,
  `city_user` varchar(30) DEFAULT NULL,
  `login_user` varchar(18) NOT NULL,
  `password_user` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id_user`, `name_user`, `telephone_user`, `email_user`, `region_user`, `city_user`, `login_user`, `password_user`) VALUES
(1, 'Admin', '', 'admin@admin.ru', '', '', 'admin', '$2y$13$RZsp0wVDuafpBCJcQ0pFwODgfuw82UyS8bYL.yoFRecViXZSg.kFq'),
(2, 'Out', '89157118659', 'romikfe@mail.ru', '', 'Санкт-Петербург', 'outsider', '$2y$13$7luiw.r.Kx2xqTwKV.DmRuJ5O3CO0Xi7T0UHKOm1PokyRi3rPEKQu');

-- --------------------------------------------------------

--
-- Структура таблицы `wishlist`
--

CREATE TABLE `wishlist` (
  `id_wishlist` int NOT NULL,
  `id_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id_cart`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `characteristics`
--
ALTER TABLE `characteristics`
  ADD PRIMARY KEY (`id_сharacteristic`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_order`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id_review`);

--
-- Индексы таблицы `spec_cart`
--
ALTER TABLE `spec_cart`
  ADD PRIMARY KEY (`id_spec_cart`);

--
-- Индексы таблицы `spec_wishlist`
--
ALTER TABLE `spec_wishlist`
  ADD PRIMARY KEY (`id_spec_wishlist`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- Индексы таблицы `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id_wishlist`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cart`
--
ALTER TABLE `cart`
  MODIFY `id_cart` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `characteristics`
--
ALTER TABLE `characteristics`
  MODIFY `id_сharacteristic` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id_review` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `spec_cart`
--
ALTER TABLE `spec_cart`
  MODIFY `id_spec_cart` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `spec_wishlist`
--
ALTER TABLE `spec_wishlist`
  MODIFY `id_spec_wishlist` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id_wishlist` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

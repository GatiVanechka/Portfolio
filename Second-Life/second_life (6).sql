-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 20 2025 г., 10:02
-- Версия сервера: 10.8.4-MariaDB
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `second_life`
--

-- --------------------------------------------------------

--
-- Структура таблицы `animals`
--

CREATE TABLE `animals` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('cat','dog','other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `breed` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `animals`
--

INSERT INTO `animals` (`id`, `name`, `type`, `breed`, `age`, `gender`, `description`, `image`, `created_at`, `status`) VALUES
(6, 'Эра', 'dog', 'Дворняжка', 10, 'female', 'Эра снова в приюте. Это второй возврат собаки в приют...\r\n\r\nК новым людям относится осторожно и напряженно, но привязывается очень быстро и дарит волонтёрам всю любовь, которая только может поместиться в десятимесячном щенке!\r\nЭра не терпит грубого отношения и знает, как за себя постоять. Кто-то, а эта черно-белая красотка точно не даст себя в обиду. Эти навыки выработались у неё на улице. Мы забрали замёрзшую и голодную собаку с парковки торгового центра, чтобы определить на передержку. Мы очень надеялись, что объявится прежний владелец и заберет свою девочку обратно домой. Но, к сожалению, никто нам не позвонил и не написал.\r\nВ этих умных глазах целый мир. При общении с Эрой заметно, как она тянется общаться. У хвостика есть большой потенциал для обучения. Она нуждается в большом количестве упражнений интеллектуальной направленности, дрессировке, долгих прогулках. В случае отсутствия умственной стимуляции питомцу станет скучно. А это значит, что собака начнет самостоятельно искать для себя развлечения, которые могут не понравиться её хозяину. Поэтому воспитанием собаки нужно заниматься буквально с первого дня появления дома!\r\n\r\nВ предыдущей семье щенка обучили, как нужно вести себя дома. Приучена к выгулу, хорошо ходит на поводке.\r\n\r\nПристраиваем Эру в семью, где нет маленьких детей. В обратном случае требуется работа с кинологом, так как Эра не умеет общаться детьми. Однако, Эра быстро обучается и поведение можно будет скорректировать.\r\n\r\nЩенку 10 месяцев. Она обработана от паразитов, готовится к первой вакцинации. Отдается по договору с обязательной стерилизацией в будущем, это будет бесплатно.', 'images/animals/animal_6820c0640bd4a.png', '2025-05-11 15:21:08', 'adopted'),
(9, 'Фил', 'cat', 'Беспородный', 7, 'male', 'Спокойный, ласковый кот. Прежние хозяева не смогли его забрать при переезде. Очень любит сидеть на коленях, мурлыкать и тихие вечера. Не переносит шум, зато идеален для тех, кто ценит уют. Фил демонстрирует главный талант — искусство выглядеть милым. Ищет дом, где его будут любить таким, какой он есть.', 'images/animals/6822e2f60f49b_Фил (5).jpg', '2025-05-13 06:13:10', 'available'),
(10, 'Ляля', 'dog', 'Дворняжка', 8, 'female', 'Ляля — добрая и преданная девочка с непростой судьбой. Её нашли на улице истощённой, но, несмотря на пережитое, она не потеряла веру в людей. Ляля обожает ласку, долгие прогулки в парке и с удовольствием составит компанию в любом деле. Идеальна для семьи, где её будут любить и беречь.', 'images/animals/6822e38823c58_Ляля (1).jpg', '2025-05-13 06:15:17', 'available'),
(11, 'Жора', 'other', 'Красноухая черепаха', 17, 'male', 'Наш мудрый джентльмен с панцирем. Жора прибыл к нам после того, как его прежний хозяин-студент переехал в другой город. Несмотря на возраст, он бодр и обожает свежий салат. Идеальный питомец для тех, кто ценит спокойствие и долгие годы дружбы.', 'images/animals/6822e45caafe9_photo_2024-10-03_22-46-54.jpg', '2025-05-13 06:19:08', 'available'),
(12, 'Лукас', 'cat', 'Сиамская', 3, 'male', 'Наш харизматичный пират! Лукас потерял глаз в уличной драке, но не потерял любовь к жизни. Этот сиамец — воплощение обаяния: игривый, разговорчивый и невероятно преданный. Обожает сидеть на плече, как попугай, и «помогать» вам работать за компьютер. Идеальный компаньон для тех, кто ценит характер и нестандартную красоту.', 'images/animals/6822e783b1f66_photo_2023-11-05_12-05-03.jpg', '2025-05-13 06:32:35', 'available'),
(13, 'Мила', 'cat', 'Беспородная', 6, 'female', 'Нежная и тактичная особа, которая видит в вас своего человека с первого взгляда. Мила попала к нам из-за аллергии у прежних хозяев — но её любовь к людям только крепнет. Обожает негромкие разговоры, вечерние поглаживания и наблюдать за птицами из окна. Ищет тихий дом, где её мурчание станет вашей ежедневной терапией.', 'images/animals/6822e81c37194_Снимок экрана 2025-05-13 093340.png', '2025-05-13 06:35:08', 'available'),
(14, 'Мотя', 'dog', 'Дворняжка', 7, 'female', 'Мотя — собака с необычным именем и яркой индивидуальностью! Эта девочка попала в приют после того, как её прежние хозяева не справились с её темпераментом. Но за её внешней озорной натурой скрывается преданное сердце и острый ум. Мотя обожает долгие прогулки, игры с мячом и... неожиданно хорошо поддается дрессировке (если найти к нему подход!).', 'images/animals/6822e89892366_изображение_2025-05-13_093631091.png', '2025-05-13 06:37:12', 'available'),
(15, 'Беляш', 'dog', 'Дворняжка', 1, 'male', 'Наш маленький «хамелеон»! Сын Моти родился снежно-белым, но к месяцу сменил «окрас» на угольно-чёрный — видимо, в папу пошёл характером! Гиперактивный, любопытный и безумно обаятельный пёсик. Обожает гоняться за собственным хвостом, рыть ямы во дворе (простите, он считает это садоводством) и засыпать у вас на коленях после бурного дня.\r\n\r\nИщет терпеливых хозяев, готовых направить его энергию в мирное русло — из него выйдет отличный партнёр для пробежек или весёлых игр во фрисби. Да, он пока немного хулиган, но зато какой сообразительный! (И да, мы до сих пор храним его белоснежные щенячьи фото — вот же метаморфозы!).', 'images/animals/6822e911eb88f_photo_2023-11-04_16-20-48.jpg', '2025-05-13 06:39:13', 'available'),
(16, 'Вилли', 'dog', 'Джек-рассел-терьер', 9, 'male', 'Весёлый джек-рассел с отличными манерами! Любит бегать за мячиком и греться на коленях. В приюте временно — пока его хозяйка переехала в другу страну. Ищет передержку или семью для душевных прогулок!', 'images/animals/682508c051b21_photo_2025-05-13_09-46-21.jpg', '2025-05-14 21:18:56', 'available');

-- --------------------------------------------------------

--
-- Структура таблицы `animal_views`
--

CREATE TABLE `animal_views` (
  `id` int(11) NOT NULL,
  `animal_id` int(11) NOT NULL,
  `views` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `animal_views`
--

INSERT INTO `animal_views` (`id`, `animal_id`, `views`) VALUES
(40, 6, 1),
(41, 6, 1),
(42, 6, 1),
(43, 6, 1),
(44, 6, 1),
(45, 6, 1),
(46, 6, 1),
(47, 6, 1),
(48, 6, 1),
(49, 6, 1),
(50, 6, 1),
(51, 6, 1),
(52, 6, 1),
(53, 6, 1),
(54, 6, 1),
(55, 6, 1),
(56, 6, 1),
(57, 6, 1),
(58, 6, 1),
(59, 6, 1),
(60, 6, 1),
(61, 9, 1),
(62, 6, 1),
(63, 14, 1),
(64, 16, 1),
(65, 16, 1),
(66, 16, 1),
(67, 10, 1),
(68, 16, 1),
(69, 16, 1),
(70, 16, 1),
(71, 9, 1),
(72, 14, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `documentation`
--

CREATE TABLE `documentation` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uploaded_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `documentation`
--

INSERT INTO `documentation` (`id`, `title`, `file_path`, `uploaded_at`) VALUES
(1, 'Документ', 'uploads/docs/doc_68209b5853e88.jpg', '2025-05-11 12:43:04');

-- --------------------------------------------------------

--
-- Структура таблицы `donations`
--

CREATE TABLE `donations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `anonymous` tinyint(1) DEFAULT 0,
  `donation_date` timestamp NULL DEFAULT current_timestamp(),
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `payment_data` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `donations`
--

INSERT INTO `donations` (`id`, `user_id`, `amount`, `anonymous`, `donation_date`, `message`, `payment_id`, `status`, `payment_data`) VALUES
(1, 1, '500.00', 0, '2025-05-06 08:01:05', '', NULL, 'pending', NULL),
(2, 1, '1000000.00', 1, '2025-05-06 08:03:40', 'Собаке', NULL, 'pending', NULL),
(3, 1, '500.00', 1, '2025-05-06 09:50:49', '', NULL, 'pending', NULL),
(10, 1, '500.00', 0, '2025-05-11 12:44:55', 'окак', 'donate_68209bc7960b02.54610651', 'pending', NULL),
(11, 1, '500.00', 0, '2025-05-11 14:29:40', 'крамбл куки', 'donate_6820b454710dc4.42154408', 'pending', NULL),
(12, 1, '100.00', 0, '2025-05-11 14:30:45', 'крамбл куки', 'donate_6820b495d88f36.57329645', 'pending', NULL),
(13, 1, '500100.00', 1, '2025-05-11 14:40:28', 'Кокос', 'donate_6820b6dc7a07c8.63690280', 'pending', NULL),
(14, 1, '100.00', 1, '2025-05-11 14:40:53', 'Кокос', 'donate_6820b6f5376100.88283721', 'completed', NULL),
(15, 1, '500.00', 1, '2025-05-12 05:47:03', '', 'donate_68218b577991d8.67794913', 'pending', NULL),
(16, 1, '5100.00', 0, '2025-05-12 05:55:58', '', 'donate_68218d6ea36544.69353687', 'pending', NULL),
(17, 5, '500.00', 0, '2025-05-12 07:13:11', '', 'donate_68219f871fad39.48754442', 'pending', NULL),
(19, 1, '500.00', 0, '2025-05-16 07:39:16', '1233', 'donate_6826eba4b0d355.91844572', 'pending', NULL),
(20, 6, '500.00', 0, '2025-05-16 07:57:17', '', 'donate_6826efdd7de9a8.64517461', 'pending', NULL),
(21, 6, '500.00', 0, '2025-05-16 07:57:19', '', 'donate_6826efdf9cab01.25854905', 'pending', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `financial_reports`
--

CREATE TABLE `financial_reports` (
  `id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uploaded_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `financial_reports`
--

INSERT INTO `financial_reports` (`id`, `year`, `image_path`, `uploaded_at`) VALUES
(1, 2025, 'uploads/reports/report_2025_6820971b2189b.jpg', '2025-05-11 12:24:59'),
(2, 2023, 'uploads/reports/report_2023_68209ba9b1b15.jpg', '2025-05-11 12:44:25');

-- --------------------------------------------------------

--
-- Структура таблицы `meetings`
--

CREATE TABLE `meetings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `animal_id` int(11) NOT NULL,
  `meeting_date` datetime NOT NULL,
  `purpose` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','confirmed','rejected','adopted') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `meetings`
--

INSERT INTO `meetings` (`id`, `user_id`, `animal_id`, `meeting_date`, `purpose`, `user_name`, `user_phone`, `status`, `created_at`) VALUES
(4, 4, 6, '2025-05-23 10:03:00', 'Надо', 'Самохвалов Иван Вадимович', '123', 'adopted', '2025-05-11 22:50:51'),
(5, 5, 6, '2025-05-14 11:18:00', 'Люблю её', 'GatiBanechka', '+79302702837', 'pending', '2025-05-12 07:14:27'),
(6, 1, 16, '2025-05-16 10:03:00', 'Воспитаю под себя', 'Иван', '+7(930)-270-28-37', 'confirmed', '2025-05-14 21:53:01');

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `image_path`, `created_at`) VALUES
(7, 'Всем привет из дома передаёт Энта!', 'Вот, что пишут её владельцы:\r\n\"В августе 2022 года забрали у вас Энту, которая стала Асей (так было в еë вет.паспорте, решили оставить это имя)🐾 О такой тактильной и любвеобильной кошке мы даже мечтать не могли, ведь изначально увидели еë робкой и пугливой🥺 Она всегда провожает нас грустным мяуканьем и радостно встречает, падая на спину и крутясь, очень любит проситься на ручки и обниматься🤍 Дел на день у неë всегда достаточно: проверить, проснулись ли мы по будильнику, уничтожить очередную коробку, следить за городом из окна, охранять обувь, работать вместе за компьютером✍🏻 Она - наш член семьи, самый любимый и удивительный хвостик🥰 Спасибо вам!\"', 'uploads/news/news_682516c1984fa.png', '2025-05-14 22:18:41'),
(8, 'Дейл передаёт фото-привет из дома!', 'У котика все замечательно, его очень любят 🥰', 'uploads/news/news_682517c72b629.png', '2025-05-14 22:23:03'),
(9, '‼️СОБАКУ ВЫКИНУЛИ У ВОРОТ ПРИЮТА‼️', 'Сегодня мы возили собаку на приём к ветеринару. Свежих переломов, к счастью, нет. Но общее состояние Лавочки тяжёлое.😞\r\nИсключили ЧМТ, позвоночник цел, но очень много возрастных проблем: остеоартриты, остеоартрозы, разрыв передней крестообразной связки (билатерально) с развитием остеоартрита в коленных суставах.\r\nЕсть старый перелом — он сросся, но криво. Также обнаружены пневматизированный кишечник и увеличенный лимфоузел в грудной клетке.\r\nСобака очень старенькая, есть ожирение.\r\n\r\n☝️Завтра у Лавочки запланированы УЗИ, анализы крови и ПЦР.\r\n\r\nСобаке больно вставать, и при каждом прикосновении к лапам Лавочка начинает поскуливать. Кто знает, что с ней произошло и как с ней обращались…\r\n\r\nНа данный момент назначены обезболивающие препараты, которые допустимы в её случае, и антибиотик. Далее назначения будут скорректированы по результатам анализов и дальнейшей диагностики.\r\n\r\nМы оставили Лавочку на стационаре под присмотром врачей, чтобы ей оказали необходимую помощь и сняли боль.\r\n\r\n‼️Нам требуется финансовая помощь, чтобы оплатить стационар и лечение, а также закупить все необходимые препараты и еду для Лавочки.\r\n\r\nСобаке требуются:\r\n— Нефопам\r\n— Анальгин 500 мг\r\n— Синуксол 500 мг\r\n— Габапентин 300 мг\r\nА также:\r\n— впитывающие пелёнки\r\n— мясные консервы для собак 🙏🏻 🙏🏻', 'uploads/news/news_682518423af9f.png', '2025-05-14 22:25:06');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `role` enum('user','admin') COLLATE utf8mb4_unicode_ci DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `role`) VALUES
(1, 'Иван', 'reckek45@mail.ru', '$2y$10$9t/Sn5aLLSH86EqyVHxai.t7FJPWTNVCbSZ8rvj.fBpo8KjqDpHZ2', '2025-05-05 23:04:41', 'admin'),
(2, 'Лютый', '123@mail.ru', '$2y$10$rELIP1jh8HhO.j9NQQ/ptu6AIND.Z3Y1f4rlobD1Vt2JIZ2p0TekO', '2025-05-10 16:21:51', 'user'),
(4, 'Самохвалов Иван Вадимович', 'soveliy@mail.ru', '$2y$10$EQeSn9tW7Udnf4NWDgmuqOmACO44s4q09GLxM41wg0UjOjiVCMMQ2', '2025-05-11 22:50:30', 'user'),
(5, 'GatiBanechka', 'gatiamlety@inbox.ru', '$2y$10$4h6Y6401N2RrMjn9nbXTc.2s6djsQBx7chhP.ii70DchRERZ6Xhru', '2025-05-12 07:12:47', 'user'),
(6, 'Дима', 'dima@mail.ru', '$2y$10$sY5JMClJ/0MkRxZIakYm3.iRIovExDJ.wKbQay1QQWsCtOv6JGCpq', '2025-05-16 07:56:40', 'user'),
(7, 'Ваня', 'gmail@gmail.ru', '$2y$10$FJ1MubbS.GkY1hWcQnhOvOfYIYaQ5Iqz2OZ2Z9s6rmVzZ52NXCQo2', '2025-06-11 08:29:31', 'user'),
(8, 'ыыы', 'sadfvc@mail.com', '$2y$10$Z6YZ42v8mdqCOX3RScpf.e9ZJwQbDbv0eg2x7SjMMG58H307GTooK', '2025-06-11 09:21:41', 'user');

-- --------------------------------------------------------

--
-- Структура таблицы `user_logs`
--

CREATE TABLE `user_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user_logs`
--

INSERT INTO `user_logs` (`id`, `user_id`, `action`, `details`, `ip_address`, `user_agent`, `created_at`) VALUES
(1, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-07 12:52:12'),
(2, NULL, 'ANIMAL_VIEW', 'Viewed animal ID: 2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-07 12:52:13'),
(3, NULL, 'ANIMAL_VIEW', 'Viewed animal ID: 2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-07 12:52:20'),
(4, NULL, 'ANIMAL_VIEW', 'Viewed animal ID: 3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-07 12:52:29'),
(5, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-07 12:52:49'),
(6, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 10:05:19'),
(7, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 10:06:08'),
(8, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 10:06:10'),
(9, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 10:12:36'),
(10, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 13:07:14'),
(11, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 13:10:40'),
(12, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 13:11:21'),
(13, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 13:17:04'),
(14, 1, 'ANIMAL_ADDED', 'Added animal: 123', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 13:17:12'),
(15, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 13:17:12'),
(16, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 13:17:18'),
(17, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 13:17:21'),
(18, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 4', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 13:17:50'),
(19, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 13:17:54'),
(20, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 14:17:55'),
(21, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 14:17:57'),
(22, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 14:21:01'),
(23, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 14:21:12'),
(24, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 14:21:14'),
(25, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 14:23:00'),
(26, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 14:23:13'),
(27, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 14:28:08'),
(28, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 14:28:18'),
(29, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 14:28:19'),
(30, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 14:28:22'),
(31, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 14:46:34'),
(32, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 14:46:46'),
(33, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 14:46:48'),
(34, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 14:46:49'),
(35, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 14:47:13'),
(36, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 14:47:36'),
(37, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 14:47:44'),
(38, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 14:50:49'),
(39, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 14:51:26'),
(40, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 14:51:43'),
(41, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 14:54:08'),
(42, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 14:54:31'),
(43, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 4', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 15:09:52'),
(44, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 15:10:08'),
(45, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 15:13:02'),
(46, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 15:13:06'),
(47, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 15:15:29'),
(48, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 15:23:26'),
(49, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 15:37:40'),
(50, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 15:41:53'),
(51, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 15:46:33'),
(52, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 15:46:35'),
(53, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 15:46:36'),
(54, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 15:51:08'),
(55, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 15:51:09'),
(56, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 15:53:58'),
(57, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 15:53:59'),
(58, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 15:55:47'),
(59, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 15:55:48'),
(60, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 15:56:12'),
(61, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 15:56:13'),
(62, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 15:56:14'),
(63, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 15:56:15'),
(64, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 15:56:31'),
(65, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 15:56:31'),
(66, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 15:59:43'),
(67, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 15:59:44'),
(68, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 15:59:45'),
(69, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 16:05:22'),
(70, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 16:05:23'),
(71, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 16:05:37'),
(72, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 16:05:37'),
(73, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 16:08:28'),
(74, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 16:08:29'),
(75, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 16:08:29'),
(76, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 16:09:10'),
(77, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 16:11:10'),
(78, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 16:11:11'),
(79, NULL, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 16:30:57'),
(80, NULL, 'ANIMAL_VIEW', 'Viewed animal ID: 5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 16:31:00'),
(81, NULL, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-10 16:31:13'),
(82, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 12:24:37'),
(83, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 12:24:59'),
(84, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 12:42:54'),
(85, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 12:43:04'),
(86, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 12:43:32'),
(87, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 12:44:00'),
(88, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 12:44:19'),
(89, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 12:44:25'),
(90, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 12:45:44'),
(91, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 12:45:46'),
(92, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 12:46:31'),
(93, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 12:46:38'),
(94, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 12:46:42'),
(95, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 13:22:51'),
(96, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 13:22:55'),
(97, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 13:22:56'),
(98, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 13:23:16'),
(99, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 13:37:30'),
(100, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 13:38:08'),
(101, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 13:38:18'),
(102, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 13:38:32'),
(103, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 13:59:00'),
(104, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 13:59:18'),
(105, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 14:07:58'),
(106, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 14:07:59'),
(107, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 14:09:31'),
(108, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 14:48:29'),
(109, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 14:48:48'),
(110, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 14:48:49'),
(111, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 14:48:50'),
(112, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 15:03:14'),
(113, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 15:03:14'),
(114, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 15:04:03'),
(115, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 15:04:03'),
(116, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 15:08:10'),
(117, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 15:08:11'),
(118, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 15:16:45'),
(119, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 15:16:45'),
(120, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 15:18:03'),
(121, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 15:18:04'),
(122, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 15:18:14'),
(123, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 15:18:16'),
(124, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 15:18:28'),
(125, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 15:18:29'),
(126, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 15:18:43'),
(127, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 15:19:07'),
(128, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 15:21:08'),
(129, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 15:21:10'),
(130, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 15:21:25'),
(131, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 15:21:55'),
(132, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 15:26:36'),
(133, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 15:26:37'),
(134, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 15:26:46'),
(135, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 15:26:47'),
(136, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 15:30:36'),
(137, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 15:30:37'),
(138, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 15:30:43'),
(139, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 15:31:21'),
(140, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 15:31:22'),
(141, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 15:41:12'),
(142, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 15:41:52'),
(143, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 15:42:26'),
(144, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 15:42:28'),
(145, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 15:42:30'),
(146, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 15:44:45'),
(147, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 16:10:48'),
(148, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 16:10:56'),
(149, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 16:11:12'),
(150, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 17:38:31'),
(151, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 17:38:39'),
(152, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 17:38:47'),
(153, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 17:42:49'),
(154, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 17:42:58'),
(155, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 17:43:13'),
(156, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:28:56'),
(157, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:29:05'),
(158, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:31:58'),
(159, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:32:11'),
(160, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:32:23'),
(161, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:32:29'),
(162, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:32:37'),
(163, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:32:41'),
(164, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:32:46'),
(165, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:32:48'),
(166, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:32:53'),
(167, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:32:55'),
(168, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:33:46'),
(169, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:36:53'),
(170, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:37:02'),
(171, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:37:08'),
(172, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:37:16'),
(173, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:39:04'),
(174, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:40:11'),
(175, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:41:35'),
(176, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:41:44'),
(177, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:41:58'),
(178, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:42:07'),
(179, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:42:19'),
(180, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:42:22'),
(181, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:42:27'),
(182, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:42:29'),
(183, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:42:32'),
(184, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:49:46'),
(185, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:50:15'),
(186, 4, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:50:36'),
(187, 4, 'ANIMAL_VIEW', 'Viewed animal ID: 6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:50:37'),
(188, 4, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:50:51'),
(189, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:50:57'),
(190, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:52:11'),
(191, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:53:36'),
(192, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-11 22:54:10'),
(193, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 04:48:23'),
(194, 1, 'DONATION_CONFIRMED', 'Confirmed donation ID: 14', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 04:48:32'),
(195, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 04:48:32'),
(196, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 04:50:37'),
(197, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 04:52:01'),
(198, 1, 'USER_DELETED', 'Удален пользователь ID: 3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 04:52:07'),
(199, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 04:52:07'),
(200, 1, 'USER_UPDATED', 'Обновлен пользователь ID: 2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 04:52:21'),
(201, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 04:52:24'),
(202, 1, 'USER_UPDATED', 'Обновлен пользователь ID: 1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 04:52:41'),
(203, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 04:52:48'),
(204, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 04:53:19'),
(205, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 04:53:55'),
(206, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 04:54:53'),
(207, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 05:59:08'),
(208, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 05:59:13'),
(209, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 05:59:14'),
(210, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 06:02:25'),
(211, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 06:02:35'),
(212, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 06:02:58'),
(213, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 06:03:14'),
(214, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 06:33:02'),
(215, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 06:33:08'),
(216, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 06:33:30'),
(217, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 06:34:16'),
(218, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 06:34:35');
INSERT INTO `user_logs` (`id`, `user_id`, `action`, `details`, `ip_address`, `user_agent`, `created_at`) VALUES
(219, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 06:34:52'),
(220, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 06:35:04'),
(221, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 06:35:26'),
(222, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 06:35:33'),
(223, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 06:36:26'),
(224, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 06:36:34'),
(225, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 06:36:42'),
(226, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 06:37:22'),
(227, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 06:37:53'),
(228, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 06:38:14'),
(229, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 06:38:34'),
(230, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 06:38:52'),
(231, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 06:41:55'),
(232, 5, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 07:13:40'),
(233, 5, 'ANIMAL_VIEW', 'Viewed animal ID: 6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 07:13:44'),
(234, 5, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 07:14:27'),
(235, 5, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 07:22:45'),
(236, 5, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 07:23:56'),
(237, 5, 'ANIMAL_VIEW', 'Viewed animal ID: 6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 07:24:07'),
(238, 5, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 07:30:03'),
(239, 5, 'ANIMAL_VIEW', 'Viewed animal ID: 6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 07:30:06'),
(240, 5, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 07:30:31'),
(241, 5, 'ANIMAL_VIEW', 'Viewed animal ID: 6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 07:30:32'),
(242, 5, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 07:31:37'),
(243, 5, 'ANIMAL_VIEW', 'Viewed animal ID: 6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 07:31:38'),
(244, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 07:33:59'),
(245, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 07:34:19'),
(246, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 07:34:52'),
(247, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 07:36:53'),
(248, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 07:48:48'),
(249, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 07:49:00'),
(250, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 07:53:52'),
(251, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 07:54:17'),
(252, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 07:54:35'),
(253, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 07:54:46'),
(254, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 07:54:47'),
(255, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 07:55:19'),
(256, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 07:55:33'),
(257, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 07:55:38'),
(258, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 07:55:43'),
(259, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 07:58:52'),
(260, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 07:59:00'),
(261, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 08:08:54'),
(262, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 08:08:58'),
(263, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 08:09:31'),
(264, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 08:10:17'),
(265, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 09:15:26'),
(266, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 09:20:49'),
(267, 1, 'DONATION_CONFIRMED', 'Confirmed donation ID: 18', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 09:20:56'),
(268, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 09:20:56'),
(269, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 09:22:08'),
(270, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 09:25:40'),
(271, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 09:25:43'),
(272, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 09:26:05'),
(273, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 09:26:14'),
(274, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 09:27:28'),
(275, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:01:21'),
(276, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:02:16'),
(277, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:02:38'),
(278, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:02:57'),
(279, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:03:13'),
(280, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:23:32'),
(281, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:23:51'),
(282, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:27:35'),
(283, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:27:39'),
(284, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:31:19'),
(285, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:34:50'),
(286, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:34:57'),
(287, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:34:58'),
(288, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:35:50'),
(289, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:37:41'),
(290, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:38:32'),
(291, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:38:37'),
(292, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:38:39'),
(293, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:38:41'),
(294, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:38:55'),
(295, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:39:00'),
(296, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:39:17'),
(297, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:39:25'),
(298, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:39:29'),
(299, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:39:32'),
(300, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:40:49'),
(301, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:40:49'),
(302, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:40:50'),
(303, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:41:39'),
(304, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:41:55'),
(305, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:42:02'),
(306, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:42:17'),
(307, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:42:25'),
(308, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:42:33'),
(309, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:42:54'),
(310, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:44:25'),
(311, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:44:31'),
(312, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:45:23'),
(313, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:45:32'),
(314, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:45:40'),
(315, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:45:48'),
(316, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:45:54'),
(317, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 12:45:58'),
(318, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 13:15:25'),
(319, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 13:15:26'),
(320, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 13:17:16'),
(321, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 13:17:39'),
(322, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 14:55:33'),
(323, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 14:55:45'),
(324, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 15:25:11'),
(325, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 15:28:43'),
(326, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 15:54:57'),
(327, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 15:55:12'),
(328, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 15:55:14'),
(329, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 15:55:20'),
(330, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 15:55:28'),
(331, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 16:00:15'),
(332, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 16:27:31'),
(333, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 16:30:45'),
(334, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 16:31:30'),
(335, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 16:31:46'),
(336, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 16:32:01'),
(337, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 16:32:50'),
(338, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 16:32:53'),
(339, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 16:32:58'),
(340, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 16:40:35'),
(341, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 16:51:19'),
(342, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 17:01:54'),
(343, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 17:02:07'),
(344, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 17:39:54'),
(345, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 17:40:10'),
(346, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 17:45:38'),
(347, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 17:46:55'),
(348, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 17:46:55'),
(349, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 17:47:33'),
(350, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 17:47:34'),
(351, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 17:47:35'),
(352, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 17:47:49'),
(353, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 17:48:09'),
(354, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 17:49:11'),
(355, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 17:51:38'),
(356, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 17:53:58'),
(357, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-12 17:54:52'),
(358, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-13 06:05:40'),
(359, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-13 06:08:11'),
(360, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-13 06:13:11'),
(361, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-13 06:13:14'),
(362, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 9', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-13 06:13:29'),
(363, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-13 06:13:41'),
(364, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-13 06:13:48'),
(365, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-13 06:15:19'),
(366, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-13 06:15:37'),
(367, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-13 06:15:39'),
(368, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-13 06:16:43'),
(369, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-13 06:19:10'),
(370, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-13 06:19:18'),
(371, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-13 06:29:33'),
(372, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-13 06:32:36'),
(373, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-13 06:32:42'),
(374, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-13 06:35:09'),
(375, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-13 06:35:12'),
(376, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-13 06:37:13'),
(377, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-13 06:37:50'),
(378, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-13 06:39:14'),
(379, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-13 06:39:17'),
(380, NULL, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-13 17:00:55'),
(381, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-13 17:37:46'),
(382, NULL, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 20:12:15'),
(383, NULL, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 20:17:42'),
(384, NULL, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 20:48:58'),
(385, NULL, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 20:49:15'),
(386, NULL, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 20:53:49'),
(387, NULL, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 20:57:44'),
(388, NULL, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 20:57:56'),
(389, NULL, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 20:58:05'),
(390, NULL, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 20:58:12'),
(391, NULL, 'ANIMAL_VIEW', 'Viewed animal ID: 6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 20:58:18'),
(392, NULL, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 20:59:43'),
(393, NULL, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 21:00:08'),
(394, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 21:11:15'),
(395, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 21:12:25'),
(396, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 21:13:09'),
(397, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 21:14:08'),
(398, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 21:14:17'),
(399, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 21:14:22'),
(400, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 21:14:40'),
(401, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 21:14:44'),
(402, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 21:14:53'),
(403, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 21:15:06'),
(404, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 14', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 21:15:08'),
(405, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 21:15:16'),
(406, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 21:15:28'),
(407, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 21:18:57'),
(408, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 21:18:59'),
(409, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 16', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 21:19:08'),
(410, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 16', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 21:19:13'),
(411, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 21:20:28'),
(412, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 21:21:30'),
(413, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 21:21:44'),
(414, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 21:21:45'),
(415, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 21:24:43'),
(416, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 21:52:25'),
(417, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 16', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 21:52:30'),
(418, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 21:53:01'),
(419, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 21:55:37'),
(420, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 21:59:43'),
(421, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 22:10:19'),
(422, 1, 'MEETING_STATUS_CHANGE', 'Meeting ID: 4, New status: confirmed', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 22:10:25'),
(423, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 22:10:25'),
(424, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 22:14:47'),
(425, 1, 'ANIMAL_ADOPTED', 'Animal ID: 6, Meeting ID: 4', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 22:14:51'),
(426, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 22:14:51'),
(427, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 22:15:16'),
(428, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 22:15:36'),
(429, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 22:16:57'),
(430, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 22:17:13'),
(431, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 22:17:35'),
(432, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 22:17:41'),
(433, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 22:17:45'),
(434, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 22:18:41'),
(435, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 22:22:24'),
(436, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 22:23:03');
INSERT INTO `user_logs` (`id`, `user_id`, `action`, `details`, `ip_address`, `user_agent`, `created_at`) VALUES
(437, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 22:23:17'),
(438, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 22:25:06'),
(439, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 22:25:57'),
(440, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 22:26:14'),
(441, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 22:26:20'),
(442, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 22:26:31'),
(443, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 22:26:38'),
(444, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 22:30:13'),
(445, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-14 23:34:34'),
(446, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 10', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-15 13:33:19'),
(447, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-15 13:33:57'),
(448, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-15 23:35:39'),
(449, NULL, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-16 00:08:41'),
(450, NULL, 'ANIMAL_VIEW', 'Viewed animal ID: 16', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-16 00:08:42'),
(451, NULL, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-16 00:09:05'),
(452, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-16 00:09:11'),
(453, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-16 07:38:11'),
(454, 1, 'ANIMAL_VIEW', 'Viewed animal ID: 16', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-16 07:38:13'),
(455, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-16 07:38:44'),
(456, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-16 07:53:10'),
(457, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-16 07:53:59'),
(458, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0 (Edition Yx GX)', '2025-05-16 07:55:27'),
(459, 6, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 OPR/119.0.0.0 (Edition Yx GX)', '2025-06-09 13:25:12'),
(460, 6, 'ANIMAL_VIEW', 'Viewed animal ID: 16', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 OPR/119.0.0.0 (Edition Yx GX)', '2025-06-09 15:08:05'),
(461, NULL, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 OPR/119.0.0.0 (Edition Yx GX)', '2025-06-10 11:02:15'),
(462, NULL, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 OPR/119.0.0.0 (Edition Yx GX)', '2025-06-11 07:00:45'),
(463, NULL, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 OPR/119.0.0.0 (Edition Yx GX)', '2025-06-11 07:00:52'),
(464, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 OPR/119.0.0.0 (Edition Yx GX)', '2025-06-11 08:28:27'),
(465, 7, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 OPR/119.0.0.0 (Edition Yx GX)', '2025-06-11 08:30:05'),
(466, NULL, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 OPR/119.0.0.0 (Edition Yx GX)', '2025-06-11 09:19:01'),
(467, NULL, 'ANIMAL_VIEW', 'Viewed animal ID: 9', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 OPR/119.0.0.0 (Edition Yx GX)', '2025-06-11 09:19:10'),
(468, NULL, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 OPR/119.0.0.0 (Edition Yx GX)', '2025-06-11 09:20:31'),
(469, NULL, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 OPR/119.0.0.0 (Edition Yx GX)', '2025-06-11 09:20:47'),
(470, 8, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 OPR/119.0.0.0 (Edition Yx GX)', '2025-06-11 09:22:32'),
(471, 8, 'ANIMAL_VIEW', 'Viewed animal ID: 14', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 OPR/119.0.0.0 (Edition Yx GX)', '2025-06-11 09:22:34'),
(472, 8, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 OPR/119.0.0.0 (Edition Yx GX)', '2025-06-11 09:22:48'),
(473, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 OPR/119.0.0.0 (Edition Yx GX)', '2025-06-11 09:23:15'),
(474, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 OPR/119.0.0.0 (Edition Yx GX)', '2025-06-11 09:24:25'),
(475, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 OPR/119.0.0.0 (Edition Yx GX)', '2025-06-11 09:24:51'),
(476, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 OPR/119.0.0.0 (Edition Yx GX)', '2025-06-11 09:25:00'),
(477, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 OPR/119.0.0.0 (Edition Yx GX)', '2025-06-20 01:49:28'),
(478, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 OPR/119.0.0.0 (Edition Yx GX)', '2025-06-20 01:49:51'),
(479, 1, 'ADMIN_ACCESS', 'Accessed admin panel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 OPR/119.0.0.0 (Edition Yx GX)', '2025-06-20 06:58:59'),
(480, 1, 'PAGE_VISIT', 'Visited meetings page', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 OPR/119.0.0.0 (Edition Yx GX)', '2025-06-20 07:01:24');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `animal_views`
--
ALTER TABLE `animal_views`
  ADD PRIMARY KEY (`id`),
  ADD KEY `animal_id` (`animal_id`);

--
-- Индексы таблицы `documentation`
--
ALTER TABLE `documentation`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `financial_reports`
--
ALTER TABLE `financial_reports`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `animal_id` (`animal_id`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Индексы таблицы `user_logs`
--
ALTER TABLE `user_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `animals`
--
ALTER TABLE `animals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `animal_views`
--
ALTER TABLE `animal_views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT для таблицы `documentation`
--
ALTER TABLE `documentation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `financial_reports`
--
ALTER TABLE `financial_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `meetings`
--
ALTER TABLE `meetings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `user_logs`
--
ALTER TABLE `user_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=481;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `animal_views`
--
ALTER TABLE `animal_views`
  ADD CONSTRAINT `animal_views_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `animals` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `donations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `meetings`
--
ALTER TABLE `meetings`
  ADD CONSTRAINT `meetings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `meetings_ibfk_2` FOREIGN KEY (`animal_id`) REFERENCES `animals` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_logs`
--
ALTER TABLE `user_logs`
  ADD CONSTRAINT `user_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

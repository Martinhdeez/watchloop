-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 09-02-2025 a las 13:17:01
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `watchloop_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chat_users`
--

CREATE TABLE `chat_users` (
  `id` int(11) NOT NULL,
  `user1_id` int(11) NOT NULL,
  `user2_id` int(11) NOT NULL,
  `watch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `chat_users`
--

INSERT INTO `chat_users` (`id`, `user1_id`, `user2_id`, `watch_id`) VALUES
(1, 1, 5, 33),
(3, 1, 4, 32),
(5, 1, 2, 31),
(6, 4, 1, 28),
(7, 1, 5, 34),
(8, 1, 5, 36),
(9, 5, 4, 32),
(10, 6, 5, 34),
(11, 5, 1, 28);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `watch_id` int(11) DEFAULT NULL,
  `favorite_user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `watch_id`, `favorite_user_id`, `created_at`) VALUES
(1, 1, 34, NULL, '2025-02-08 15:59:28'),
(2, 1, 32, NULL, '2025-02-08 16:00:05'),
(3, 5, 32, NULL, '2025-02-08 16:00:30'),
(4, 6, 34, NULL, '2025-02-08 18:35:32'),
(5, 5, 28, NULL, '2025-02-08 19:10:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `chat_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `messages`
--

INSERT INTO `messages` (`id`, `chat_id`, `sender_id`, `receiver_id`, `message`, `timestamp`) VALUES
(7, 3, 1, 4, 'hola', '2025-02-07 12:27:15'),
(8, 3, 1, 4, 'hola', '2025-02-07 12:28:07'),
(9, 3, 1, 4, 'funciona?', '2025-02-07 12:28:20'),
(10, 0, 1, 5, 'holaaa', '2025-02-07 13:14:31'),
(11, 0, 1, 4, 'que tal gaupetona?', '2025-02-07 13:14:42'),
(12, 0, 5, 1, 'hola?', '2025-02-07 13:16:05'),
(13, 1, 1, 5, 'hello', '2025-02-07 17:42:00'),
(14, 1, 1, 5, 'how is the cost of this watch', '2025-02-07 17:42:19'),
(15, 1, 1, 5, '??', '2025-02-07 17:42:23'),
(16, 1, 5, 1, 'hello', '2025-02-07 17:43:11'),
(17, 1, 5, 1, '500euros', '2025-02-07 17:43:16'),
(18, 3, 4, 1, 'si funciona perfecto', '2025-02-07 17:47:24'),
(19, 6, 4, 1, 'holaa, me haces una rebajita??', '2025-02-07 18:28:30'),
(20, 6, 1, 4, 'No', '2025-02-07 18:31:27'),
(21, 5, 1, 2, 'hello', '2025-02-07 18:31:43'),
(22, 5, 1, 2, 'its a good watch?', '2025-02-07 18:31:53'),
(23, 3, 1, 4, 'a', '2025-02-07 18:31:58'),
(24, 3, 1, 4, 'a', '2025-02-07 18:32:01'),
(25, 3, 1, 4, 'a', '2025-02-07 18:32:02'),
(26, 3, 1, 4, 'a', '2025-02-07 18:32:04'),
(27, 3, 1, 4, 'a', '2025-02-07 18:32:07'),
(28, 3, 1, 4, 'a', '2025-02-07 18:32:09'),
(29, 3, 1, 4, 'a', '2025-02-07 18:32:12'),
(30, 3, 1, 4, 'h', '2025-02-07 20:47:33'),
(31, 7, 1, 5, 'hello', '2025-02-07 21:03:53'),
(32, 8, 1, 5, 'buenas', '2025-02-07 21:23:51'),
(33, 8, 1, 5, 'me interesa', '2025-02-07 21:23:55'),
(34, 7, 1, 5, 'esta libre?', '2025-02-08 13:14:23'),
(35, 7, 5, 1, 'hola ', '2025-02-08 13:14:44'),
(36, 7, 5, 1, 'si', '2025-02-08 13:14:46'),
(37, 10, 6, 5, 'queloque', '2025-02-08 18:38:55'),
(38, 10, 5, 6, 'q loque mi loco', '2025-02-08 18:39:26'),
(39, 10, 6, 5, 'queloque', '2025-02-08 18:39:31'),
(40, 10, 6, 5, 'queloque', '2025-02-08 18:39:36'),
(41, 10, 6, 5, 'queloque', '2025-02-08 18:39:37'),
(42, 10, 5, 6, 'q loque mi loco', '2025-02-08 18:39:40'),
(43, 10, 5, 6, 'q loque mi loco', '2025-02-08 18:39:43'),
(44, 11, 5, 1, 'hola buenas, me intera', '2025-02-08 19:10:27'),
(45, 11, 1, 5, 'holaa', '2025-02-08 19:10:39'),
(46, 11, 1, 5, 'holaa', '2025-02-08 19:10:43'),
(47, 11, 1, 5, 'holaa', '2025-02-08 19:10:45'),
(48, 11, 1, 5, 'holaa', '2025-02-08 19:10:46'),
(49, 1, 1, 5, 'hola', '2025-02-09 12:11:17'),
(50, 1, 1, 5, 'probando', '2025-02-09 12:14:16'),
(51, 1, 1, 5, 'probando', '2025-02-09 12:14:29'),
(52, 1, 1, 5, 'probando', '2025-02-09 12:14:32'),
(53, 1, 1, 5, 'hola?', '2025-02-09 12:14:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `location` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `username`, `email`, `password`, `location`, `created_at`, `updated_at`) VALUES
(1, 'martin', 'hernandez', 'm', 'martin@gmail.com', '$2y$10$gzm3N4t4pSv0nUglN2hbFOEjN.KUPL0mH/8DDJmUs9Mv/oKE3ad8.', 'Pontevedra', '2025-01-25 19:48:52', '2025-02-07 10:37:16'),
(2, 'user', 'h', 'user', 'user@gmail.com', '$2y$10$bG0AD3/oLNy3VpS9DbBazucObznXjToO0O8/UXFyDuJQqwQ8f0cI6', '', '2025-01-26 11:39:33', '2025-01-26 12:39:33'),
(3, 'yety', 'piquin', 'yety', 'yety@gmail.com', '$2y$10$TU3DF7UqA7mdrkizBoPv9eCWfjLrxfOiveiX9DJ7iPezlt964SShG', '', '2025-01-26 16:32:05', '2025-01-26 17:33:07'),
(4, 'ariana', 'a', 'aari', 'yrjj@gmail.com', '$2y$10$gzm3N4t4pSv0nUglN2hbFOEjN.KUPL0mH/8DDJmUs9Mv/oKE3ad8.', '', '2025-01-29 22:41:51', '2025-02-07 13:30:33'),
(5, 'new', 'user', 'newuser', 'newuser@gmail.com', '$2y$10$v0uqosOgLZy0p314fLcNzOJKbSNdWuH7ZE5fy3FTx58JW6qCOxZjq', 'Pontevedra', '2025-02-06 20:23:53', '2025-02-06 21:23:53'),
(6, 'Lucas', 'Ortins', 'cortins', 'lucasochandomonte@gmail.com', '$2y$10$PIPFBDX8oRePQffk5EBxGelhiErqaAHHcl9S1WSsbYYzdHOV5NoPG', 'Pontevedra', '2025-02-08 18:34:50', '2025-02-08 19:34:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `watches`
--

CREATE TABLE `watches` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` varchar(10000) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `wcondition` enum('BRANDNEW','NEW','LIKENEW','USED','WORNOUT','NOTOPERATIONAL') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `watches`
--

INSERT INTO `watches` (`id`, `user_id`, `name`, `description`, `brand`, `price`, `wcondition`, `created_at`, `updated_at`) VALUES
(25, 1, ' TISSOT PRX powermatic 80', 'Reloj en muy buen estado y está como nuevo', 'TISSOT', 450, 'LIKENEW', '2025-01-27 12:15:42', '2025-02-07 20:55:51'),
(26, 1, 'Rolex DateJust', 'Relog en perfectas condiciones, como nuevo', 'ROLEX', 5000, 'NEW', '2025-01-27 14:51:54', '2025-02-07 20:55:56'),
(28, 1, 'PATEK Philippe Nautilus 5 ', 'Lujurioso e impresionante reloj', 'PATEK', 20000, 'LIKENEW', '2025-01-27 14:56:25', '2025-02-07 20:56:01'),
(31, 2, 'TISSOT PRS 516', 'Fantastico TIssot PRS 516 , reloj que viene de los campeonatos de rally', 'TISSOT', 300, 'BRANDNEW', '2025-01-29 19:11:19', '2025-02-07 20:56:05'),
(32, 4, 'TISSOT PRS 16', '', 'TISSOT', 450, 'NEW', '2025-01-29 22:42:43', '2025-02-07 20:56:09'),
(33, 5, 'HAMILTON date Date', 'Espectacular reloj ,muy bien conservado, va muy fino', 'HAMILTON', 500, 'LIKENEW', '2025-02-06 20:26:14', '2025-02-07 20:56:13'),
(34, 5, 'HAMILTON KHALI', '', 'HAMILTON', 400, 'USED', '2025-02-06 23:08:46', '2025-02-07 20:56:18'),
(36, 5, 'TISSOT PR 100', '', 'TISSOT', 300, 'BRANDNEW', '2025-02-06 23:09:47', '2025-02-07 20:56:22'),
(37, 4, 'LOTUS multifuncion', '', 'LOTUS', 300, 'NEW', '2025-02-07 18:13:50', '2025-02-07 20:56:25'),
(38, 4, 'LOTUS cronograph', 'novedoso reloj con cronometro', 'LOTUS', 200, 'NEW', '2025-02-07 18:15:45', '2025-02-07 20:56:29'),
(39, 4, 'HAMILTON kakhi ', '', 'HAMILTON', 300, 'BRANDNEW', '2025-02-07 18:20:30', '2025-02-07 20:56:34'),
(40, 6, 'Lotus Dorado', 'Es la ostia', 'Lotus', 100, 'LIKENEW', '2025-02-08 18:38:10', '2025-02-08 18:38:10');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `chat_users`
--
ALTER TABLE `chat_users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`watch_id`),
  ADD UNIQUE KEY `user_id_2` (`user_id`,`favorite_user_id`),
  ADD KEY `watch_id` (`watch_id`),
  ADD KEY `favorite_user_id` (`favorite_user_id`);

--
-- Indices de la tabla `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `watches`
--
ALTER TABLE `watches`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `chat_users`
--
ALTER TABLE `chat_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `watches`
--
ALTER TABLE `watches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `chat_users`
--
ALTER TABLE `chat_users`
  ADD CONSTRAINT `chat_users_ibfk_2` FOREIGN KEY (`user1_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`watch_id`) REFERENCES `watches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_3` FOREIGN KEY (`favorite_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

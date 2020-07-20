-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Czas generowania: 20 Lip 2020, 09:07
-- Wersja serwera: 8.0.18
-- Wersja PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `devmode`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `priority_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT NULL,
  `photo1_filename` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_comment_user_id` int(11) DEFAULT NULL,
  `last_comment_date` datetime DEFAULT NULL,
  `last_comment_text` longtext COLLATE utf8mb4_unicode_ci,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5387574AA76ED395` (`user_id`),
  KEY `IDX_5387574A6BF700BD` (`status_id`),
  KEY `IDX_5387574A497B19F9` (`priority_id`),
  KEY `IDX_5387574ABEA6F1B5` (`last_comment_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `events`
--

INSERT INTO `events` (`id`, `user_id`, `status_id`, `priority_id`, `title`, `description`, `date_created`, `deleted`, `photo1_filename`, `last_comment_user_id`, `last_comment_date`, `last_comment_text`, `phone`) VALUES
(1, 3, 2, 5, 'Kafelki odpadają', 'Wejście wygląda tragicznie', '2020-03-04 00:00:00', 0, NULL, 3, '2020-03-09 14:40:37', 'Czekamy na dostawę kafelek', NULL),
(2, 10, 1, 1, 'Gniazdo zepsute', 'Nie ma prądu', '2020-03-03 12:53:38', 0, NULL, 12, '2020-03-09 14:38:01', 'Nie ma też prądu w salach 1,2,3', NULL),
(3, 3, 3, 4, 'Brama się nie domyka', 'Nie mogę zamknąć bramy', '2020-03-04 13:44:45', 0, NULL, 3, '2020-03-09 14:39:55', 'Ochrona zamyka bramę na kłódkę', NULL),
(5, 10, 1, 3, 'Dach cieknie', 'Leje się woda z dachu', '2020-03-06 12:31:33', 0, NULL, 14, '2020-07-20 08:32:25', 'Hahaha', NULL),
(6, 3, 1, 1, 'Naprawa kranu', 'tak kolejna', '2020-03-06 14:59:49', 0, NULL, 3, '2020-07-20 07:18:28', 'Test', NULL),
(7, 12, 1, 5, 'Tynk odpada ze ścian', 'W poczekalni', '2020-03-06 17:35:01', 1, NULL, 1, '2020-03-09 14:43:25', 'Zgłoszenie bezpodstawne, kasuje - admin', NULL),
(8, 10, 1, 4, 'Uszkodzone drzwi', 'drzwi się nie otwierają', '2020-03-08 12:00:34', 0, NULL, 3, '2020-03-08 12:01:32', 'czekam na zawiasy', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `event_comments`
--

DROP TABLE IF EXISTS `event_comments`;
CREATE TABLE IF NOT EXISTS `event_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `deleted` tinyint(1) DEFAULT NULL,
  `photo1_filename` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_19727FFAA76ED395` (`user_id`),
  KEY `IDX_19727FFA71F7E88B` (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `event_comments`
--

INSERT INTO `event_comments` (`id`, `user_id`, `event_id`, `description`, `date_created`, `deleted`, `photo1_filename`) VALUES
(9, 3, 8, 'czekam na zawiasy', '2020-03-08 12:01:32', 0, NULL),
(14, 3, 1, 'Czekamy na dostawę kafelek', '2020-03-09 14:40:37', 0, NULL),
(15, 1, 7, 'Zgłoszenie bezpodstawne, kasuje - admin', '2020-03-09 14:43:25', 0, NULL),
(16, 3, 6, 'Test', '2020-07-20 07:18:28', 0, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `event_priorities`
--

DROP TABLE IF EXISTS `event_priorities`;
CREATE TABLE IF NOT EXISTS `event_priorities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` int(11) NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `event_priorities`
--

INSERT INTO `event_priorities` (`id`, `name`, `weight`, `color`) VALUES
(1, 'Mała', 1, 'lightgreen'),
(2, 'Normalna', 2, 'green'),
(3, 'Wysoka', 3, 'lightblue'),
(4, 'Ważna', 4, 'yellow'),
(5, 'Krytyczna', 5, 'red');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `event_status`
--

DROP TABLE IF EXISTS `event_status`;
CREATE TABLE IF NOT EXISTS `event_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `event_status`
--

INSERT INTO `event_status` (`id`, `name`, `color`) VALUES
(1, 'Wprowadzone', 'white'),
(2, 'Zgłoszone', 'lightgreen'),
(3, 'Zatwierdzone', 'green');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `logs`
--

DROP TABLE IF EXISTS `logs`;
CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `action_name` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action_value` int(11) NOT NULL,
  `action_info` longtext COLLATE utf8mb4_unicode_ci,
  `date_created` datetime NOT NULL,
  `action_title` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F08FC65CA76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE IF NOT EXISTS `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar_filename` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_login` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT NULL,
  `emails` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1483A5E9F85E0677` (`username`),
  KEY `IDX_1483A5E99D419299` (`user_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `username`, `roles`, `password`, `user_type_id`, `name`, `address`, `avatar_filename`, `date_created`, `date_login`, `deleted`, `emails`, `phone`) VALUES
(1, 'superadmin', '[\"ROLE_SUPERADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$aDhndnF5ckJSNlhMVWZteQ$ARnINYBL0PIR/odFPafJzAohYu/tlRLcXTGPStQVMqc', 4, 'superadmin', NULL, NULL, NULL, '2020-03-15 11:20:12', 0, 'superadmin@gmail.com', NULL),
(2, 'admin', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$U0k5MURRV1pKaC50b1dyOQ$+fZ4ie2xT/4rVYz4mCWMYXhQH9FUmZ81h04u7tlzexQ', 1, 'Marcin P', NULL, NULL, NULL, '2020-07-20 07:16:51', 0, 'admin@gmail.com', '888'),
(3, 'cons', '[\"ROLE_CONSERVATOR\"]', '$argon2id$v=19$m=65536,t=4,p=1$S0VheDd2ZURhamxELllEYQ$xVizyOo5WrL4k3WoOiKvgIobRGJFppQnwOgJqxn/oBU', 3, 'Joanna K', NULL, NULL, NULL, '2020-07-20 07:18:12', 0, NULL, NULL),
(5, 'cons2', '[\"ROLE_CONSERVATOR\"]', '$argon2id$v=19$m=65536,t=4,p=1$S0VheDd2ZURhamxELllEYQ$xVizyOo5WrL4k3WoOiKvgIobRGJFppQnwOgJqxn/oBU', 3, 'Józek', NULL, NULL, NULL, '2020-07-16 10:10:14', 0, NULL, NULL),
(10, 'cons3', '[\"ROLE_CONSERVATOR\"]', '$argon2id$v=19$m=65536,t=4,p=1$aUg3a281blBiOURSUE8xdA$QV8xSK7OymyyIB3kCKStYItiRFp2ZoIKXYeegGuH1s4', 3, 'Andru D', NULL, NULL, '2020-03-05 10:21:50', '2020-07-17 12:36:04', 0, NULL, NULL),
(12, 'cons4', '[\"ROLE_CONSERVATOR\"]', '$argon2id$v=19$m=65536,t=4,p=1$RGxMUG1iWUVvSi56UXpnSQ$HuAC5ItoTighxD2eBD6bN2xVET2PyMVWUi2mDJm/b7E', 3, 'Czesiek', NULL, NULL, '2020-03-05 13:44:35', NULL, 1, NULL, NULL),
(13, 'cons5', '[\"ROLE_CONSERVATOR\"]', '$argon2id$v=19$m=65536,t=4,p=1$by56NTU1LjFKcmo5ellIUQ$OsAHMkQzbMThybSFoXOQ0BFO0c0xHKrsiIh1XYlOr6Q', 3, 'Pani Hania', '', NULL, '2020-03-06 17:35:42', NULL, 0, NULL, NULL),
(14, 'thanos', '[\"ROLE_SUPERADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$Ynl3UjN6S1UwQUtrcWUwOQ$ApQDzOqKsn8gjZzud7QzwGADFdd9OaTbAmljiPeIfNQ', 4, 'Thanos', 'Galaxy', NULL, '2020-03-15 12:17:29', '2020-07-20 08:17:57', 0, 'thanos@gmail.com', '777');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_types`
--

DROP TABLE IF EXISTS `user_types`;
CREATE TABLE IF NOT EXISTS `user_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `user_types`
--

INSERT INTO `user_types` (`id`, `name`, `roles`) VALUES
(1, 'admin', '\"[ROLE_ADMIN]\"'),
(3, 'konserwator', '\"[ROLE_CONSERVATOR]\"'),
(4, 'superadmin', '\"[ROLE_SUPERADMIN]\"');

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `FK_5387574A497B19F9` FOREIGN KEY (`priority_id`) REFERENCES `event_priorities` (`id`),
  ADD CONSTRAINT `FK_5387574A6BF700BD` FOREIGN KEY (`status_id`) REFERENCES `event_status` (`id`),
  ADD CONSTRAINT `FK_5387574AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_5387574ABEA6F1B5` FOREIGN KEY (`last_comment_user_id`) REFERENCES `users` (`id`);

--
-- Ograniczenia dla tabeli `event_comments`
--
ALTER TABLE `event_comments`
  ADD CONSTRAINT `FK_19727FFA71F7E88B` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`),
  ADD CONSTRAINT `FK_19727FFAA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ograniczenia dla tabeli `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `FK_F08FC65CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ograniczenia dla tabeli `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_1483A5E99D419299` FOREIGN KEY (`user_type_id`) REFERENCES `user_types` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

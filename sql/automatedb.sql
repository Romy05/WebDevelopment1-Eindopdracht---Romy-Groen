-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Gegenereerd op: 01 apr 2025 om 07:28
-- Serverversie: 11.7.2-MariaDB-ubu2404
-- PHP-versie: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `automatedb`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `license_plate` varchar(255) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `appointments`
--

INSERT INTO `appointments` (`id`, `user_id`, `license_plate`, `date`) VALUES
(1, 53, 'aa-12-bb', '2025-04-02 00:00:00'),
(2, 53, 'aa-12-bb', '2025-04-11 00:00:00'),
(3, 53, 'aa-12-bb', '2025-04-02 00:00:00'),
(4, 53, 'AA-12-BB', '2025-04-11 00:00:00'),
(5, 53, 'aa-12-bb', '2025-04-02 00:00:00'),
(6, 53, 'aa-12-bb', '2025-04-11 00:00:00'),
(7, 53, 'aa-12-bb', '2025-04-08 00:00:00'),
(8, 53, 'aa-12-bb', '2025-04-02 00:00:00'),
(9, 53, 'aa', '2025-04-24 00:00:00'),
(10, 53, 'b', '2025-04-01 00:00:00');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `appointment_services`
--

CREATE TABLE `appointment_services` (
  `id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `appointment_services`
--

INSERT INTO `appointment_services` (`id`, `appointment_id`, `service_id`) VALUES
(1, 1, 4),
(2, 1, 9),
(3, 1, 10),
(4, 2, 10),
(5, 3, 9),
(6, 4, 10),
(7, 5, 4),
(8, 6, 6),
(9, 7, 6),
(10, 8, 4),
(11, 8, 9),
(12, 9, 10),
(13, 10, 4),
(14, 10, 6),
(15, 10, 9);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `duration_minutes` int(11) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `duration_minutes`, `price`) VALUES
(4, 'Aircoservice', 'patat', 45, 30.5),
(6, 'Wheel change', NULL, 60, 29.5),
(9, 'Oil change', 'Change of oil', 75, 60),
(10, 'Clutch replacement', '', 480, 1212);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `hashed_password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `type_of_user` varchar(255) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `hashed_password`, `email`, `type_of_user`, `first_name`, `last_name`, `phone_number`, `address`, `city`, `zip`) VALUES
(52, '$2y$12$6bu3KvB58Xbn6O3dbOEtP.6GFqosef6H5T/Gxj7HBOvI/ifBie9Ri', 'femkekat@mail.com', 'employee', 'Femke', 'Kat', '0612345678', 'Mainstreet 44', 'Amsterdam', '1234AB'),
(53, '$2y$12$H6v5lqiMgy.mXWY2C2sXwuHzLuAeKoD/lQq/oxi5VminOHgVq2o/e', 'freek@mail.com', 'customer', 'Freek', 'achternaam', 'd', 'Mainstreet 44', 'zaandam', '1234AB'),
(54, '$2y$12$OdyXD8Evy0hwPvQTt3GYye3GD6pTZhbrydC8XpPpWNlLSxXjD/q.m', 'kevin@mail.com', 'employee', 'Kevin', NULL, NULL, 'Mainstreet 44', 'zaandam', '1234AB');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexen voor tabel `appointment_services`
--
ALTER TABLE `appointment_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointment_id` (`appointment_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexen voor tabel `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT voor een tabel `appointment_services`
--
ALTER TABLE `appointment_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT voor een tabel `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Beperkingen voor tabel `appointment_services`
--
ALTER TABLE `appointment_services`
  ADD CONSTRAINT `appointment_services_ibfk_1` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `appointment_services_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

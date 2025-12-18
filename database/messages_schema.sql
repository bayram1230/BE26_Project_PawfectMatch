-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Erstellungszeit: 17. Dez 2025 um 19:15
-- Server-Version: 10.4.32-MariaDB
-- PHP-Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `petadoption2`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `adoptionhistory`
--

CREATE TABLE `adoptionhistory` (
  `ID` int(11) NOT NULL,
  `RequestID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `AnimalID` int(11) NOT NULL,
  `Email` varchar(150) DEFAULT NULL,
  `RequestDate` datetime NOT NULL DEFAULT current_timestamp(),
  `AdoptionDate` datetime DEFAULT NULL,
  `Status` enum('Pending','Approved','Rejected','Completed') DEFAULT 'Pending',
  `user_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `adoptionhistory`
--

INSERT INTO `adoptionhistory` (`ID`, `RequestID`, `Username`, `AnimalID`, `Email`, `RequestDate`, `AdoptionDate`, `Status`, `user_id`) VALUES
(1, 1, 'john_doe', 1, 'john@example.com', '2025-12-11 00:46:43', NULL, 'Pending', 2),
(2, 1, 'john_doe', 1, 'john@example.com', '2025-12-11 00:46:43', NULL, 'Pending', 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `adoptionrequest`
--

CREATE TABLE `adoptionrequest` (
  `ID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `AnimalID` int(11) NOT NULL,
  `SurveyAnswer` text DEFAULT NULL,
  `RequestDate` datetime NOT NULL DEFAULT current_timestamp(),
  `user_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `adoptionrequest`
--

INSERT INTO `adoptionrequest` (`ID`, `Username`, `AnimalID`, `SurveyAnswer`, `RequestDate`, `user_id`) VALUES
(1, 'john_doe', 1, 'Living situation: I live in an apartment with a balcony.\r\nExperience with animals: I had dogs growing up.\r\nDaily routine & time availability: I work from home, plenty of time.\r\nHousehold & allergies: No allergies.\r\nReason for adoption: I want a loyal companion.\r\nFinancial readiness: Stable income.\r\nHome environment: Quiet neighborhood.\r\nAnimal preferences: Friendly dog.\r\nAdditional notes: I love outdoor activities.', '2025-12-11 00:46:43', 2),
(2, 'john_doe', 1, 'Living situation: I live in an apartment with a balcony.\r\nExperience with animals: I had dogs growing up.\r\nDaily routine & time availability: I work from home, plenty of time.\r\nHousehold & allergies: No allergies.\r\nReason for adoption: I want a loyal companion.\r\nFinancial readiness: Stable income.\r\nHome environment: Quiet neighborhood.\r\nAnimal preferences: Friendly dog.\r\nAdditional notes: I love outdoor activities.', '2025-12-11 00:46:43', 2);

--
-- Trigger `adoptionrequest`
--
DELIMITER $$
CREATE TRIGGER `add_request_survey_template` BEFORE INSERT ON `adoptionrequest` FOR EACH ROW BEGIN
    IF NEW.SurveyAnswer IS NULL OR NEW.SurveyAnswer = '' THEN
        SET NEW.SurveyAnswer =
'Living situation:\nExperience with animals:\nDaily routine & time availability:\nHousehold & allergies:\nReason for adoption:\nFinancial readiness:\nHome environment:\nAnimal preferences:\nAdditional notes:';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `copy_survey_answer` BEFORE INSERT ON `adoptionrequest` FOR EACH ROW BEGIN
    SET NEW.SurveyAnswer = (
        SELECT SurveyAnswer
        FROM Users
        WHERE id = NEW.user_id
        LIMIT 1
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `animal`
--

CREATE TABLE `animal` (
  `ID` int(11) NOT NULL,
  `Type` enum('Dog','Cat','Other') NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Breed` varchar(100) DEFAULT NULL,
  `Sex` enum('Male','Female','Unknown') DEFAULT NULL,
  `Age` int(11) DEFAULT NULL,
  `Color` varchar(50) DEFAULT NULL,
  `Size` varchar(50) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `ImageUrl` varchar(255) NOT NULL DEFAULT 'default-animals.png',
  `adoption_requirements` text DEFAULT NULL,
  `shelter_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `animal`
--

INSERT INTO `animal` (`ID`, `Type`, `Name`, `Breed`, `Sex`, `Age`, `Color`, `Size`, `Description`, `ImageUrl`, `adoption_requirements`, `shelter_id`) VALUES
(1, 'Dog', 'Buddy', 'Mixed Breed', 'Male', 3, 'Brown', 'Medium', 'This wonderful animal is looking for a loving home.\nWith a gentle personality and a big heart, they are ready to bring joy to any family.\nIf you\'re searching for a loyal companion who loves attention, this pet may be the perfect match.\nGive them the chance they deserve — adopt today and welcome a new friend into your life!', 'default-animals.png', 'Must be 18+ years old.\r\nNo other pets in the household.\r\nPrevious dog experience required.\r\n', 3),
(2, 'Dog', 'foxy', 'Labrador', 'Male', 2, 'brown', 'big', 'A Labrador Retriever is an intelligent, friendly, and outgoing dog known for its loyal and affectionate nature. Energetic and eager to please, Labradors make excellent family companions and thrive in active environments. Originally bred as working dogs, they excel in retrieving, training, and various canine activities. With their gentle temperament and strong bond with humans, Labradors are versatile, reliable, and loving pets that enjoy both exercise and companionship.', 'https://cdn.pixabay.com/photo/2014/11/28/08/23/dog-548611_1280.jpg', '', 3),
(4, 'Dog', 'Browndoggie', 'labrador', 'Male', 5, 'gold', 'biggie', 'A Labrador Retriever is an intelligent, friendly, and outgoing dog known for its loyal and affectionate nature. Energetic and eager to please, Labradors make excellent family companions and thrive in active environments. Originally bred as working dogs, they excel in retrieving, training, and various canine activities. With their gentle temperament and strong bond with humans, Labradors are versatile, reliable, and loving pets that enjoy both exercise and companionship.', 'https://cdn.pixabay.com/photo/2014/11/28/08/23/dog-548611_1280.jpg', '', 3),
(5, 'Dog', 'Roxy', 'goldie', 'Male', 0, '5', 'big', 'asfcad>FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF', 'https://cdn.pixabay.com/photo/2014/11/28/08/23/dog-548611_1280.jpg', 'must be +18', 3),
(6, 'Dog', 'Bello', 'Labrador Retriever', 'Male', 5, 'Yellow', 'Large', 'Friendly and energetic dog that loves outdoor activities, long walks, and spending time with people.', 'https://images.pexels.com/photos/3039080/pexels-photo-3039080.jpeg', NULL, NULL),
(7, 'Dog', 'Luna', 'Border Collie', 'Female', 4, 'Black and White', 'Medium', 'Highly intelligent and energetic dog that loves learning new things, needs daily exercise, and enjoys close interaction with people.', 'https://images.pexels.com/photos/1805164/pexels-photo-1805164.jpeg', NULL, NULL),
(8, 'Cat', 'Mimi', 'European Shorthair', 'Female', 3, 'Gray', 'Small', 'Calm and affectionate cat that enjoys quiet places, gentle attention, and relaxing close to humans.', 'https://images.pexels.com/photos/20577970/pexels-photo-20577970.jpeg', NULL, NULL),
(9, 'Cat', 'Oscar', 'Maine Coon', 'Male', 6, 'Red', 'Large', 'Large and gentle cat known for its friendly behavior, social nature, and long, soft fur.', 'https://images.pexels.com/photos/27378198/pexels-photo-27378198.jpeg', NULL, NULL),
(10, 'Other', 'Spike', 'Green Iguana', 'Unknown', 7, 'Green', 'Medium', 'Calm lizard that requires a warm habitat, proper lighting, and consistent daily care.', 'https://images.pexels.com/photos/35204335/pexels-photo-35204335.jpeg', NULL, NULL),
(11, 'Other', 'Hoppel', 'Dwarf Rabbit', 'Female', 2, 'White', 'Small', 'Friendly rabbit that enjoys gentle handling, a calm environment, and regular daily interaction.', 'https://images.pexels.com/photos/21751559/pexels-photo-21751559.jpeg', NULL, NULL),
(12, 'Other', 'Chirpy', 'Budgerigar', 'Unknown', 1, 'Blue', 'Small', 'Active and social bird that enjoys interaction, flying space, and daily mental stimulation.', 'https://images.pexels.com/photos/8838179/pexels-photo-8838179.jpeg', NULL, NULL),
(13, 'Other', 'Shelly', 'Greek Tortoise', 'Unknown', 15, 'Brown', 'Medium', 'Slow and peaceful animal that needs a warm environment and a stable daily routine.', 'https://images.pexels.com/photos/5643640/pexels-photo-5643640.jpeg', NULL, NULL),
(14, 'Other', 'Nemo', 'Goldfish', 'Unknown', 1, 'Orange', 'Small', 'Quiet aquarium fish that thrives in clean water and a calm surrounding environment.', 'https://images.pexels.com/photos/8434694/pexels-photo-8434694.jpeg', NULL, NULL),
(15, 'Dog', 'Buddy', 'Mixed Breed', 'Male', 3, 'Brown', 'Medium', 'This wonderful animal is looking for a loving home.\nWith a gentle personality and a big heart, they are ready to bring joy to any family.\nIf you\'re searching for a loyal companion who loves attention, this pet may be the perfect match.\nGive them the chance they deserve — adopt today and welcome a new friend into your life!', 'default-animals.png', NULL, NULL),
(16, 'Dog', 'foxy', 'Labrador', 'Male', 2, 'brown', 'big', 'A Labrador Retriever is an intelligent, friendly, and outgoing dog known for its loyal and affectionate nature. Energetic and eager to please, Labradors make excellent family companions and thrive in active environments. Originally bred as working dogs, they excel in retrieving, training, and various canine activities. With their gentle temperament and strong bond with humans, Labradors are versatile, reliable, and loving pets that enjoy both exercise and companionship.', 'https://cdn.pixabay.com/photo/2014/11/28/08/23/dog-548611_1280.jpg', NULL, NULL),
(17, 'Dog', 'Browndoggie', 'labrador', 'Male', 5, 'gold', 'biggie', 'A Labrador Retriever is an intelligent, friendly, and outgoing dog known for its loyal and affectionate nature. Energetic and eager to please, Labradors make excellent family companions and thrive in active environments. Originally bred as working dogs, they excel in retrieving, training, and various canine activities. With their gentle temperament and strong bond with humans, Labradors are versatile, reliable, and loving pets that enjoy both exercise and companionship.', 'https://cdn.pixabay.com/photo/2014/11/28/08/23/dog-548611_1280.jpg', NULL, NULL),
(18, 'Dog', 'Roxy', 'goldie', 'Male', 0, '5', 'big', 'asfcad>FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF', 'https://cdn.pixabay.com/photo/2014/11/28/08/23/dog-548611_1280.jpg', NULL, NULL),
(19, 'Dog', 'Bello', 'Labrador Retriever', 'Male', 5, 'Yellow', 'Large', 'Friendly and energetic dog that loves outdoor activities, long walks, and spending time with people.', 'https://images.pexels.com/photos/3039080/pexels-photo-3039080.jpeg', NULL, NULL),
(20, 'Dog', 'Luna', 'Border Collie', 'Female', 4, 'Black and White', 'Medium', 'Highly intelligent and energetic dog that loves learning new things, needs daily exercise, and enjoys close interaction with people.', 'https://images.pexels.com/photos/1805164/pexels-photo-1805164.jpeg', NULL, NULL),
(21, 'Cat', 'Mimi', 'European Shorthair', 'Female', 3, 'Gray', 'Small', 'Calm and affectionate cat that enjoys quiet places, gentle attention, and relaxing close to humans.', 'https://images.pexels.com/photos/20577970/pexels-photo-20577970.jpeg', NULL, NULL),
(22, 'Cat', 'Oscar', 'Maine Coon', 'Male', 6, 'Red', 'Large', 'Large and gentle cat known for its friendly behavior, social nature, and long, soft fur.', 'https://images.pexels.com/photos/27378198/pexels-photo-27378198.jpeg', NULL, NULL),
(23, 'Other', 'Spike', 'Green Iguana', 'Unknown', 7, 'Green', 'Medium', 'Calm lizard that requires a warm habitat, proper lighting, and consistent daily care.', 'https://images.pexels.com/photos/35204335/pexels-photo-35204335.jpeg', NULL, NULL),
(24, 'Other', 'Hoppel', 'Dwarf Rabbit', 'Female', 2, 'White', 'Small', 'Friendly rabbit that enjoys gentle handling, a calm environment, and regular daily interaction.', 'https://images.pexels.com/photos/21751559/pexels-photo-21751559.jpeg', NULL, NULL),
(25, 'Other', 'Chirpy', 'Budgerigar', 'Unknown', 1, 'Blue', 'Small', 'Active and social bird that enjoys interaction, flying space, and daily mental stimulation.', 'https://images.pexels.com/photos/8838179/pexels-photo-8838179.jpeg', NULL, NULL),
(26, 'Other', 'Shelly', 'Greek Tortoise', 'Unknown', 15, 'Brown', 'Medium', 'Slow and peaceful animal that needs a warm environment and a stable daily routine.', 'https://images.pexels.com/photos/5643640/pexels-photo-5643640.jpeg', NULL, NULL),
(27, 'Other', 'Nemo', 'Goldfish', 'Unknown', 1, 'Orange', 'Small', 'Quiet aquarium fish that thrives in clean water and a calm surrounding environment.', 'https://images.pexels.com/photos/8434694/pexels-photo-8434694.jpeg', NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `conversations`
--

CREATE TABLE `conversations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shelter_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `conversations`
--

INSERT INTO `conversations` (`id`, `user_id`, `shelter_id`, `created_at`) VALUES
(1, 1, 2, '2025-12-17 17:05:59');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `sender_role` enum('user','shelter') NOT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Email` varchar(150) NOT NULL,
  `SurveyAnswer` text DEFAULT NULL,
  `Role` enum('admin','user','shelter') NOT NULL,
  `Img` varchar(255) NOT NULL DEFAULT 'default-user.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `Username`, `Password`, `Name`, `Email`, `SurveyAnswer`, `Role`, `Img`) VALUES
(1, 'admin01', '240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9', 'Admin Master', 'admin@example.com', 'Living situation:\r\nExperience with animals:\r\nDaily routine & time availability:\r\nHousehold & allergies:\r\nReason for adoption:\r\nFinancial readiness:\r\nHome environment:\r\nAnimal preferences:\r\nAdditional notes:', 'admin', 'default-users.png'),
(2, 'john_doe', 'e606e38b0d8c19b24cf0ee3808183162ea7cd63ff7912dbb22b5e803286b4446', 'John Doe', 'john@example.com', 'Living situation: I live in an apartment with a balcony.\r\nExperience with animals: I had dogs growing up.\r\nDaily routine & time availability: I work from home, plenty of time.\r\nHousehold & allergies: No allergies.\r\nReason for adoption: I want a loyal companion.\r\nFinancial readiness: Stable income.\r\nHome environment: Quiet neighborhood.\r\nAnimal preferences: Friendly dog.\r\nAdditional notes: I love outdoor activities.', 'user', 'default-users.png'),
(3, 'shelter01', '529995b0c74fc987933b37cfb0a677865cbf5bd1fbf2010cafddfb4c8ec463be', 'Shelter Master', 'shelter@hotmail.com', 'Living situation:\nExperience with animals:\nDaily routine & time availability:\nHousehold & allergies:\nReason for adoption:\nFinancial readiness:\nHome environment:\nAnimal preferences:\nAdditional notes:', 'shelter', 'default-users.png');

--
-- Trigger `users`
--
DELIMITER $$
CREATE TRIGGER `add_survey_template` BEFORE INSERT ON `users` FOR EACH ROW BEGIN
    IF NEW.SurveyAnswer IS NULL OR NEW.SurveyAnswer = '' THEN
        SET NEW.SurveyAnswer =
'Living situation:\nExperience with animals:\nDaily routine & time availability:\nHousehold & allergies:\nReason for adoption:\nFinancial readiness:\nHome environment:\nAnimal preferences:\nAdditional notes:';
    END IF;
END
$$
DELIMITER ;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `adoptionhistory`
--
ALTER TABLE `adoptionhistory`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `RequestID` (`RequestID`),
  ADD KEY `Username` (`Username`),
  ADD KEY `AnimalID` (`AnimalID`),
  ADD KEY `fk_adoptionhistory_user` (`user_id`);

--
-- Indizes für die Tabelle `adoptionrequest`
--
ALTER TABLE `adoptionrequest`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Username` (`Username`),
  ADD KEY `AnimalID` (`AnimalID`),
  ADD KEY `fk_adoptionrequest_user` (`user_id`);

--
-- Indizes für die Tabelle `animal`
--
ALTER TABLE `animal`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_animal_shelter` (`shelter_id`);

--
-- Indizes für die Tabelle `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_user_shelter` (`user_id`,`shelter_id`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_shelter` (`shelter_id`);

--
-- Indizes für die Tabelle `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_convo` (`conversation_id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `adoptionhistory`
--
ALTER TABLE `adoptionhistory`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `adoptionrequest`
--
ALTER TABLE `adoptionrequest`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `animal`
--
ALTER TABLE `animal`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT für Tabelle `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `adoptionhistory`
--
ALTER TABLE `adoptionhistory`
  ADD CONSTRAINT `adoptionhistory_ibfk_1` FOREIGN KEY (`RequestID`) REFERENCES `adoptionrequest` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `adoptionhistory_ibfk_3` FOREIGN KEY (`AnimalID`) REFERENCES `animal` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_adoptionhistory_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `adoptionrequest`
--
ALTER TABLE `adoptionrequest`
  ADD CONSTRAINT `adoptionrequest_ibfk_2` FOREIGN KEY (`AnimalID`) REFERENCES `animal` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_adoptionrequest_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `animal`
--
ALTER TABLE `animal`
  ADD CONSTRAINT `fk_animal_shelter` FOREIGN KEY (`shelter_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `fk_messages_convo` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 26 sep. 2025 à 17:02
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `football`
--

-- --------------------------------------------------------

--
-- Structure de la table `matchs`
--

CREATE TABLE `matchs` (
  `id` int(11) NOT NULL,
  `team_score` int(11) NOT NULL,
  `opponent_score` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `team_id` int(11) NOT NULL,
  `city` varchar(255) NOT NULL,
  `opposing_club_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `opposing_club`
--

CREATE TABLE `opposing_club` (
  `id` int(11) NOT NULL,
  `adress` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `player`
--

CREATE TABLE `player` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `birthdate` datetime NOT NULL,
  `picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `player`
--

INSERT INTO `player` (`id`, `firstname`, `lastname`, `birthdate`, `picture`) VALUES
(13, 'Lionel', 'Messi', '1987-06-24 00:00:00', 'messi.jpg'),
(14, 'Cristiano', 'Ronaldo', '1985-02-05 00:00:00', 'ronaldo.jpg'),
(15, 'Kylian', 'Mbappé', '1998-12-20 00:00:00', 'mbappe.jpg'),
(16, 'Erling', 'Haaland', '2000-07-21 00:00:00', 'haaland.jpg'),
(17, 'Kevin', 'De Bruyne', '1991-06-28 00:00:00', 'debruyne.jpg'),
(18, 'Neymar', 'Jr', '1992-02-05 00:00:00', 'neymar.jpg'),
(19, 'Sergio', 'Ramos', '1986-03-30 00:00:00', 'ramos.jpg'),
(20, 'Virgil', 'van Dijk', '1991-07-08 00:00:00', 'vandijk.jpg'),
(21, 'Luka', 'Modric', '1985-09-09 00:00:00', 'modric.jpg'),
(22, 'Mohamed', 'Salah', '1992-06-15 00:00:00', 'salah.jpg'),
(23, 'Harry', 'Kane', '1993-07-28 00:00:00', 'kane.jpg'),
(24, 'Paul', 'Pogba', '1993-03-15 00:00:00', 'pogba.jpg'),
(25, 'Robert', 'Lewandowski', '1988-08-21 00:00:00', 'lewandowski.jpg'),
(26, 'Karim', 'Benzema', '1987-12-19 00:00:00', 'benzema.jpg'),
(27, 'Thomas', 'Muller', '1989-09-13 00:00:00', 'muller.jpg'),
(28, 'Raheem', 'Sterling', '1994-12-08 00:00:00', 'sterling.jpg'),
(29, 'Sadio', 'Mané', '1992-04-10 00:00:00', 'mane.jpg'),
(30, 'Bruno', 'Fernandes', '1994-09-08 00:00:00', 'fernandes.jpg'),
(31, 'Toni', 'Kroos', '1990-01-04 00:00:00', 'kroos.jpg'),
(32, 'Joshua', 'Kimmich', '1995-02-08 00:00:00', 'kimmich.jpg'),
(33, 'Trent', 'Alexander-Arnold', '1998-10-07 00:00:00', 'alexander-arnold.jpg'),
(34, 'Alisson', 'Becker', '1992-10-02 00:00:00', 'alisson.jpg'),
(35, 'Ederson', 'Moraes', '1993-08-17 00:00:00', 'ederson.jpg'),
(36, 'Jan', 'Oblak', '1993-01-07 00:00:00', 'oblak.jpg'),
(37, 'Marc-André', 'ter Stegen', '1992-04-30 00:00:00', 'terstegen.jpg'),
(38, 'Raúl', 'García', '1986-07-11 00:00:00', 'raulgarcia.jpg'),
(39, 'Gareth', 'Bale', '1989-07-16 00:00:00', 'bale.jpg'),
(40, 'Jadon', 'Sancho', '2000-03-25 00:00:00', 'sancho.jpg'),
(41, 'Phil', 'Foden', '2000-05-28 00:00:00', 'foden.jpg'),
(42, 'Vinicius', 'Jr', '2000-07-12 00:00:00', 'vinicius.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `player_has_team`
--

CREATE TABLE `player_has_team` (
  `player_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `staff_member`
--

CREATE TABLE `staff_member` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `team`
--

INSERT INTO `team` (`id`, `name`) VALUES
(1, 'Real Madrid'),
(2, 'FC Barcelone'),
(3, 'Manchester United'),
(4, 'Paris Saint-Germain'),
(5, 'Bayern Munich'),
(6, 'Juventus'),
(7, 'Liverpool'),
(8, 'Chelsea'),
(9, 'AC Milan'),
(10, 'Ajax Amsterdam'),
(11, 'Tottenham Hotspur'),
(12, 'Manchester City'),
(13, 'Borussia Dortmund'),
(14, 'Atlético Madrid'),
(15, 'Real Sociedad'),
(16, 'Sevilla FC');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `matchs`
--
ALTER TABLE `matchs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_opposing_club_id` (`opposing_club_id`),
  ADD KEY `fk_match_team_id` (`team_id`);

--
-- Index pour la table `opposing_club`
--
ALTER TABLE `opposing_club`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `player_has_team`
--
ALTER TABLE `player_has_team`
  ADD KEY `fk_player_id_in_player_has_team` (`player_id`),
  ADD KEY `fk_team_id` (`team_id`);

--
-- Index pour la table `staff_member`
--
ALTER TABLE `staff_member`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `matchs`
--
ALTER TABLE `matchs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `opposing_club`
--
ALTER TABLE `opposing_club`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `player`
--
ALTER TABLE `player`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT pour la table `staff_member`
--
ALTER TABLE `staff_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `matchs`
--
ALTER TABLE `matchs`
  ADD CONSTRAINT `fk_match_team_id` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`),
  ADD CONSTRAINT `fk_opposing_club_id` FOREIGN KEY (`opposing_club_id`) REFERENCES `opposing_club` (`id`);

--
-- Contraintes pour la table `player_has_team`
--
ALTER TABLE `player_has_team`
  ADD CONSTRAINT `fk_player_id` FOREIGN KEY (`player_id`) REFERENCES `player` (`id`),
  ADD CONSTRAINT `fk_team_id` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- Insertion des clubs adverses
INSERT INTO `opposing_club` (`adress`, `city`) VALUES
('Stadio San Siro, Via Piccolomini 5', 'Milan'),
('Emirates Stadium, Hornsey Road', 'Londres'),
('Signal Iduna Park, Strobelallee 50', 'Dortmund'),
('Allianz Stadium, Corso Gaetano Scirea 50', 'Turin'),
('Wanda Metropolitano, Av. de Luis Aragonés', 'Madrid'),
('Old Trafford, Sir Matt Busby Way', 'Manchester'),
('Parc des Princes, Avenue du Parc des Princes', 'Paris'),
('Anfield Road, Anfield', 'Liverpool');

-- Insertion de quelques matchs
INSERT INTO `matchs` (`team_score`, `opponent_score`, `date`, `team_id`, `city`, `opposing_club_id`) VALUES
(3, 1, '2025-03-12 20:45:00', 1, 'Madrid', 1), -- Real Madrid vs AC Milan
(2, 2, '2025-04-05 21:00:00', 2, 'Barcelone', 2), -- Barça vs Arsenal
(1, 3, '2025-02-15 18:00:00', 5, 'Munich', 3), -- Bayern vs Dortmund
(4, 0, '2025-01-28 20:30:00', 4, 'Paris', 4), -- PSG vs Juventus
(2, 1, '2025-05-07 21:00:00', 7, 'Liverpool', 5), -- Liverpool vs Atlético Madrid
(0, 2, '2025-03-21 20:00:00', 3, 'Manchester', 6), -- Man Utd vs Old Trafford (symbolique)
(3, 3, '2025-04-30 19:00:00', 12, 'Manchester', 7), -- Man City vs PSG
(5, 1, '2025-06-10 21:30:00', 9, 'Milan', 8); -- AC Milan vs Liverpool

-- Insertion des associations joueurs/équipes
INSERT INTO `player_has_team` (`player_id`, `team_id`, `role`) VALUES
(13, 2, 'Attaquant'), -- Messi → Barça
(14, 3, 'Attaquant'), -- Ronaldo → Man United
(15, 4, 'Attaquant'), -- Mbappé → PSG
(16, 5, 'Attaquant'), -- Haaland → Bayern
(17, 12, 'Milieu'), -- De Bruyne → Man City
(18, 4, 'Ailier'), -- Neymar → PSG
(19, 1, 'Défenseur'), -- Ramos → Real Madrid
(20, 7, 'Défenseur'), -- Van Dijk → Liverpool
(21, 1, 'Milieu'), -- Modric → Real Madrid
(22, 7, 'Attaquant'), -- Salah → Liverpool
(23, 11, 'Attaquant'), -- Kane → Tottenham
(24, 6, 'Milieu'), -- Pogba → Juventus
(25, 5, 'Attaquant'), -- Lewandowski → Bayern
(26, 1, 'Attaquant'), -- Benzema → Real Madrid
(27, 5, 'Milieu offensif'), -- Muller → Bayern
(28, 8, 'Ailier'), -- Sterling → Chelsea
(29, 7, 'Ailier'), -- Mané → Liverpool
(30, 3, 'Milieu'), -- Bruno Fernandes → Man United
(31, 1, 'Milieu'), -- Kroos → Real Madrid
(32, 5, 'Milieu défensif'), -- Kimmich → Bayern
(33, 7, 'Défenseur droit'), -- Alexander-Arnold → Liverpool
(34, 7, 'Gardien'), -- Alisson → Liverpool
(35, 12, 'Gardien'), -- Ederson → Man City
(36, 14, 'Gardien'), -- Oblak → Atlético
(37, 2, 'Gardien'), -- Ter Stegen → Barça
(38, 15, 'Milieu'), -- Raúl García → Real Sociedad
(39, 14, 'Ailier droit'), -- Bale → Atlético
(40, 13, 'Ailier'), -- Sancho → Dortmund
(41, 12, 'Milieu offensif'), -- Foden → Man City
(42, 1, 'Ailier gauche'); -- Vinicius → Real Madrid

-- Insertion des membres du staff
INSERT INTO `staff_member` (`first_name`, `last_name`, `picture`, `role`) VALUES
('Carlo', 'Ancelotti', 'ancelotti.jpg', 'Entraîneur principal'),
('Pep', 'Guardiola', 'guardiola.jpg', 'Entraîneur principal'),
('Jürgen', 'Klopp', 'klopp.jpg', 'Entraîneur principal'),
('Xavi', 'Hernandez', 'xavi.jpg', 'Entraîneur principal'),
('Erik', 'ten Hag', 'tenhag.jpg', 'Entraîneur principal'),
('Thomas', 'Tuchel', 'tuchel.jpg', 'Entraîneur principal'),
('Mauricio', 'Pochettino', 'pochettino.jpg', 'Entraîneur principal'),
('Massimiliano', 'Allegri', 'allegri.jpg', 'Entraîneur principal'),
('Didier', 'Deschamps', 'deschamps.jpg', 'Sélectionneur'),
('Zinedine', 'Zidane', 'zidane.jpg', 'Adjoint technique'),
('Antonio', 'Conte', 'conte.jpg', 'Entraîneur adjoint'),
('José', 'Mourinho', 'mourinho.jpg', 'Consultant tactique'),
('Hansi', 'Flick', 'flick.jpg', 'Entraîneur principal'),
('Luis', 'Enrique', 'enrique.jpg', 'Sélectionneur'),
('Julian', 'Nagelsmann', 'nagelsmann.jpg', 'Entraîneur principal');

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
  `fisrtname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `birthdate` datetime NOT NULL,
  `picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `player`
--

INSERT INTO `player` (`id`, `fisrtname`, `lastname`, `birthdate`, `picture`) VALUES
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

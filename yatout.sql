-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 22 avr. 2022 à 16:24
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `yatout`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` text NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_avatar` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment`, `post_id`, `user_avatar`, `user_name`, `created_at`) VALUES
(1, 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Repudiandae autem similique vero doloremque dignissimos nostrum, iste cupiditate quisquam perspiciatis enim delectus ratione, veritatis officia illum. Rem tempore eius quia velit.', 2, 'BXXQBkcbQd51dLlaXX1QllUkgYg5kElCc3f2LYQm.PNG', 'Y\'ATOUT OFFICIEL', '2022-04-22 17:17:12'),
(2, 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Repudiandae autem similique vero doloremque dignissimos nostrum, iste cupiditate quisquam perspiciatis enim delectus ratione, veritatis officia illum. Rem tempore eius quia velit.', 2, 'CFaA4mFbc40lCg0R3AU0Y03Qha4jiYgYQR3BRk0i.jpg', 'michel de la 13eme rue henry', '2022-04-22 17:17:47'),
(3, 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Repudiandae autem similique vero doloremque dignissimos nostrum, iste cupiditate quisquam perspiciatis enim delectus ratione, veritatis officia illum. Rem tempore eius quia velit.Lorem ipsum dolor, sit amet consectetur adipisicing elit. Repudiandae autem similique vero doloremque dignissimos nostrum, iste cupiditate quisquam perspiciatis enim delectus ratione, veritatis officia illum. Rem tempore eius quia velit.', 1, 'CFaA4mFbc40lCg0R3AU0Y03Qha4jiYgYQR3BRk0i.jpg', 'michel de la 13eme rue henry', '2022-04-22 17:17:56');

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `user_receive_id` int(11) NOT NULL,
  `user_avatar` varchar(255) NOT NULL,
  `notice` text NOT NULL,
  `lu` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `notifications`
--

INSERT INTO `notifications` (`id`, `post_id`, `user_receive_id`, `user_avatar`, `notice`, `lu`, `created_at`) VALUES
(1, 2, 1, 'CFaA4mFbc40lCg0R3AU0Y03Qha4jiYgYQR3BRk0i.jpg', 'michel de la 13eme rue henry a commentÃ© votre annonce: \n << Lorem ipsum dolor, sit amet consectetur adipisicing elit. Repudiandae autem similique vero doloremque dignissimos nostrum, iste cupiditate quisquam perspiciatis enim delectus ratione, veritatis officia illum. Rem tempore eius quia velit. >>', 0, '2022-04-22 17:17:47'),
(2, 1, 1, 'CFaA4mFbc40lCg0R3AU0Y03Qha4jiYgYQR3BRk0i.jpg', 'michel de la 13eme rue henry a commentÃ© votre annonce: \n << Lorem ipsum dolor, sit amet consectetur adipisicing elit. Repudiandae autem similique vero doloremque dignissimos nostrum, iste cupiditate quisquam perspiciatis enim delectus ratione, veritatis officia illum. Rem tempore eius quia velit.Lorem ipsum dolor, sit amet consectetur adipisicing elit. Repudiandae autem similique vero doloremque dignissimos nostrum, iste cupiditate quisquam perspiciatis enim delectus ratione, veritatis officia illum. Rem tempore eius quia velit. >>', 0, '2022-04-22 17:17:56');

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `image` varchar(255) NOT NULL,
  `image_2` varchar(255) NOT NULL,
  `image_3` varchar(255) NOT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`post_id`, `title`, `category`, `price`, `location`, `details`, `user_id`, `image`, `image_2`, `image_3`) VALUES
(1, 'Appartement Ã  louer a abobo', 'Immobilier', '3000000', 'cocody', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Porro voluptates odio sit doloribus optio unde harum, laboriosam, eligendi, consectetur aliquam voluptate nesciunt. Illum, sit veritatis harum officiis voluptatum expedita magni.Lorem ipsum dolor sit amet consectetur adipisicing elit. Porro voluptates odio sit doloribus optio unde harum, laboriosam, eligendi, consectetur aliquam voluptate nesciunt. Illum, sit veritatis harum officiis voluptatum expedita magni.', 1, 'XBk2BDjdCbbBhbDdAFmUXdjdXhhX1LcEDUU0LfAQ.jpg', 'llcme4kmfkAfDDe4BlLBeAjURC4c3dbXld0lkA4j.jpg', 'LLdeaEBXE3Yei2bekQikfdeCD1m3mbaBhkDlhEhg.jpg'),
(2, 'voiture pegeot', 'VÃ©hicules', '33000000', 'cocody', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Repudiandae autem similique vero doloremque dignissimos nostrum, iste cupiditate quisquam perspiciatis enim delectus ratione, veritatis officia illum. Rem tempore eius quia velit.Lorem ipsum dolor, sit amet consectetur adipisicing elit. Repudiandae autem similique vero doloremque dignissimos nostrum, iste cupiditate quisquam perspiciatis enim delectus ratione, veritatis officia illum. Rem tempore eius quia velit.Lorem ipsum dolor, sit amet consectetur adipisicing elit. Repudiandae autem similique vero doloremque dignissimos nostrum, iste cupiditate quisquam perspiciatis enim delectus ratione, veritatis officia illum. Rem tempore eius quia velit.', 1, 'BRF1iDCgjh4ieRDl1RRCQXC0mQdBUkiLgUfeaXX2.jpg', 'default.png', 'default.png');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `apt` int(11) NOT NULL DEFAULT '0',
  `role` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `name`, `contact`, `pass`, `avatar`, `apt`, `role`) VALUES
(1, 'Y\'ATOUT OFFICIEL', '0708511227', '$2y$10$S5NCg4Z.0Nvt.HqED1Bi0ebMTcaIyB5U5cX62tDZFcIPppnShYNGi', 'BXXQBkcbQd51dLlaXX1QllUkgYg5kElCc3f2LYQm.PNG', 1, 1),
(2, 'michel de la 13eme rue henry', '0708511225', '$2y$10$Pip0DGO9MFVrthtP6.vLGObm5K/Gidu3sIf3gEKDIy3ajJKRh6HuC', 'CFaA4mFbc40lCg0R3AU0Y03Qha4jiYgYQR3BRk0i.jpg', 0, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

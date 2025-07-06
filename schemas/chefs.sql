-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 06, 2025 at 01:41 PM
-- Server version: 8.0.42-cll-lve
-- PHP Version: 8.3.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ouzdo4b_michelinportoflio`
--

-- --------------------------------------------------------

--
-- Table structure for table `chefs`
--

CREATE TABLE `chefs` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` enum('Executive Chef','Head Chef','Sous Chef','Chef de Partie','Commis Chef','Kitchen Porter') NOT NULL,
  `specialty` varchar(400) DEFAULT NULL,
  `biography` text,
  `experience_years` int DEFAULT NULL,
  `guilty_pleasure` text,
  `image_path` varchar(255) DEFAULT NULL
) ;

--
-- Dumping data for table `chefs`
--

INSERT INTO `chefs` (`id`, `name`, `role`, `specialty`, `biography`, `experience_years`, `guilty_pleasure`, `image_path`) VALUES
(41, 'Jean Lefevre', 'Executive Chef', 'Sauce Chef', 'Jean has led Michelin kitchens for almost 2 decades, renowed for his amazing dishes and incredibly refined sauces. A purist and a perfectionist.', 18, '“Instant ramen, with poached egg, scallions and a dash of truffle oil.”', 'images/chefs/41.jpg'),
(42, 'Maria Papadopoulos', 'Sous Chef', 'Fish Chef', 'Maria grew up on the Greek island of Paros, and is known for bringing great knowledge of seafood and ocean flavors.', 11, '“I can never say no to a classic gyros! I could eat that any day!”', 'images/chefs/42.jpg'),
(43, 'Luca Rossi', 'Chef de Partie', 'Pasta Chef', 'Trained in Rome and Milan, Luca elevates handmade pasta with modern plating and simple Italian flavors.', 8, '“Cannoli with an espresso. High in calories, I know, but it warms my heart every time I enjoy them.”', 'images/chefs/43.jpg'),
(44, 'Isabelle Dupont', 'Chef de Partie', 'Pastry Chef', 'Coming from the home country of clasic pastries, Isabelle perfected her knowledge of refined desserts, French pastries, and lucious sauces.', 10, '“I do confess that I love brownies. No offence to the croissants I used to eat when I was working as a pastry chef in Paris, but I do love a good and intense dark-chocolate brownie.”', 'images/chefs/44.jpg'),
(45, 'Takeshi Morimoto', 'Head Chef', 'Cold Station Chef', 'Trained in Kyoto and Osaka, Takeshi sees cuisine as art. With a handcrafted Japanese knife always in reach, he transforms even the humblest ingredient into a visual and textural masterpiece. His plating style draws from centuries of kaiseki tradition — refined, minimalist, and balanced. For Takeshi, flavor begins with the eyes.', 14, '“An ice-cold melon soda with Pocky sticks. “When I want to feel like a kid again.”', 'images/chefs/45.jpg'),
(46, 'Amara Singh', 'Chef de Partie', 'Vegetable Chef', 'Amara has an amazing intuition for seasonal produce. She can walk through a morning market and design a tasting menu on the spot — pairing artichokes with saffron, or charred fennel with plum jus. Her plates are vibrant, surprising, and deeply rooted in nature’s calendar.', 7, '“Chili lime mango poppadoms at a movie night.”', 'images/chefs/46.jpg'),
(47, 'Omar Al-Farid', 'Sous Chef', 'Roast Chef', 'Omar’s roots trace back to open-air hunting trips with his grandfather, where he learned to field-dress game and cook over wood embers before he could tie a neckerchief. He brings that primal knowledge into the Michelin kitchen — dry-aging wild meats, pairing them with spiced reductions, and building dishes that feel ancient yet refined.', 11, '“Liver pâté on warm toast with loads much butter. It tastes like winter mornings in the mountains.”', 'images/chefs/47.jpg'),
(48, 'Yuki Tanaka', 'Commis Chef', 'Multi-Disciplinary', 'A rising star, Yuki rotates between stations and thrives under pressure. Recently promoted from kitchen porter.', 2, '“Low-sugar, green-tea infused bubble tea with peach & passionfruit boba and lychee jelly.”', 'images/chefs/48.jpg'),
(49, 'Claire Fontaine', 'Chef de Partie', 'Cold Station Chef', 'Claire’s dishes are miniature artworks — thoughtful, composed, and bursting with color. Trained as a visual artist before stepping into the kitchen, she instinctively knows how to layer textures and place herbs, edible petals, and chilled foams that delight the eye before the tongue.', 6, '“Salted caramel popcorn while watching Breaking Bad.”', 'images/chefs/49.jpg'),
(50, 'Marcus Barlow', 'Head Chef', 'Butchery', 'Raised on a working farm in Belgium, Marcus learned early that respect for the animal starts with how it’s broken down. His knife work is quiet and deliberate. Whether it’s wild fowl, trout, or dry-aged ribeye, he approaches butchery like calligraphy: precise, elegant, and expressive.', 13, '“Thick slices of warm sourdough with duck fat and sea salt — rustic and perfect.”', 'images/chefs/50.jpg'),
(51, 'Jean Phillipe', 'Head Chef', 'Sides & Pastries', 'Born and raised in France, Chef Étienne Moreau began his culinary journey at the age of 14, working in professional kitchens across Lyon, Paris, Nantes, and Bordeaux. Starting as a waiter, his deep passion for food quickly set him apart. With a refined palate and a sharp eye for detail, Étienne is renowned for his mastery in pairing sides and textures—especially with game meats and rich sauces. His background in artisanal bakeries has also shaped his exceptional pastry skills. Today, he brings his decades of experience and French flair to our kitchen as a head chef.', 15, '“I will not lie, but I do love making nachos at home with Sweet Chilli Doritos. I have tried other tortilla chips before, but I love the sweetness and the spiciness of those chips along with my toppings.”', 'images/chefs/51.jpg'),
(52, 'Soline LeClaire', 'Commis Chef', 'Desserts', 'Soline worked in many hotels from Paris as a pastry chef and perfected her techniques of making macarons since she was 18. No matter the day, she can always bring a tray full of macarons without too much struggle. She is the only person from the team that finds making macarons easy, and we praise her talent.', 4, '“Coffee ice cream with crushed amaretto biscuits on top.”', 'images/chefs/52.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chefs`
--
ALTER TABLE `chefs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chefs`
--
ALTER TABLE `chefs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

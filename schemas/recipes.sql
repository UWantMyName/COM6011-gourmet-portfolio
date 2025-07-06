-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 06, 2025 at 01:42 PM
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
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `chef_id` int NOT NULL,
  `cuisine` varchar(100) DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  `ingredients` text,
  `description` text,
  `image_path` varchar(255) DEFAULT NULL,
  `prep_time_minutes` int DEFAULT NULL,
  `cook_time_minutes` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `title`, `chef_id`, `cuisine`, `date_created`, `ingredients`, `description`, `image_path`, `prep_time_minutes`, `cook_time_minutes`) VALUES
(31, 'Red Snapper with Charred Eggplant and Coral Tuile', 45, 'Japanese', '2024-07-01', 'Red snapper, eggplant, beetroot, edible flowers, microgreens, umami sauce', 'A delicate fillet of red snapper, gently pan-seared and served over charred eggplant. Garnished with edible flowers and coral tuile.', '686a7ad0c91b3-red_snapper.jpg', 20, 25),
(32, 'Braised Short Rib with Miso Carrot Purée and Forest Greens', 45, 'Asian', '2024-07-02', 'Beef short rib, miso, carrot, bok choy, fiddlehead ferns', 'Slow-braised short rib glazed in a savory reduction with silky miso-carrot purée and woodland greens.', '686a7acba3699-short_rib.jpg', 30, 180),
(33, 'Tomato Confit with Burrata Snow and Paprika Crisp', 44, 'French', '2024-07-03', 'Tomatoes, burrata, paprika, parsnip, micro herbs', 'Slow-roasted tomato confit topped with burrata espuma and a paprika-dusted crisp. Finished with citrus zest and herbs.', '686a7abe93bbc-tomato_confit.jpg', 25, 40),
(34, 'Island Plantain & Avocado Ribbon Salad', 47, 'Caribbean', '2024-07-03', 'Plantains, avocado, onion, bell pepper, tamarind, chili', 'Sweet grilled plantains, avocado mousse, and tropical vinaigrette served cold.', '686a7ac539efc-plantain_salad.jpg', 20, 0),
(35, 'Foie Gras Duo with Brioche Fingers and Strawberry Gastrique', 41, 'French', '2024-07-04', 'Foie gras, hazelnuts, brioche, rhubarb, strawberry', 'A duo of foie gras — one smooth, one crunchy — served with brioche and strawberry gastrique.', '686a7ab1a900e-foie_gras_duo.jpg', 30, 15),
(36, 'Spring Meadow Trio: Cabbage-Wrapped Lamb, Parsnip Rose & Corn Bloom', 46, 'Seasonal', '2024-07-04', 'Lamb, parsnip, corn, polenta, wildflowers, veal sausage', 'A whimsical trio: cabbage-wrapped lamb, parsnip rose, and corn bloom with wildflowers.', '686a7ab952cd1-spring_meadow.jpg', 45, 60),
(37, 'Chili Garlic Prawn Nests', 48, 'Asian', '2024-07-05', 'Tiger prawns, noodles, garlic, soy, chili, sesame oil', 'Soy-glazed noodle nests topped with prawns and chili sauce.', '686a7aa13a691-prawn_nests.jpg', 25, 15),
(38, 'Seabass al Limone with Warm Herb Gremolata', 42, 'Greek–Italian', '2024-07-05', 'Seabass, parsley, garlic, lemon zest, mushrooms, cauliflower', 'Pan-seared seabass with lemon gremolata and coastal vegetables.', '686a7ae432c51-seabass_limone.jpg', 20, 20),
(39, 'Braised Veal Medallion with Pearl Onions and Velouté', 49, 'French', '2024-07-06', 'Veal, pearl onions, potatoes, parsley, herb butter', 'Braised veal on creamy velouté with glazed pearl onions.', '686a7a7d0e26e-veal_medallion.jpg', 30, 90),
(40, 'Caramelized Pear Tart with Chestnut Cream and Honey Jus', 49, 'Dessert', '2024-07-06', 'Pear, chestnut, honey, tart dough, sorbet, endive', 'Poached pear tart with chestnut cream, sorbet, and honey-spice jus.', '686a7a86a6328-pear_tart.jpg', 40, 25),
(41, 'Seared Scallops with Pine Nut Succotash and Citrus Vinaigrette', 42, 'Modern European', '2024-07-06', 'Scallops, corn, beans, asparagus, pine nuts, citrus', 'Perfectly seared scallops on sweet pine nut succotash and citrus vinaigrette.', '686a7a911f866-scallops_succotash.jpg', 25, 10),
(42, 'Venison & Heirloom Tomato Tartare with Yellow Pepper Emulsion', 50, 'Modern European', '2024-07-07', 'Venison, heirloom tomatoes, peppers, mustard, onion, microgreens', 'Venison tartare with roasted tomato, pickled onion petals, and yellow pepper emulsion.', '686a7a600eb2c-venison_tartare.jpg', 30, 0),
(43, 'Beef Tartare with Aged Cheese, Pickled Shallot & Split Herb Oil', 43, 'French', '2024-07-07', 'Beef, shallot, cheese, tomato pearls, parsley oil', 'Hand-cut beef tartare topped with cheese and herb oil, finished with pickled shallot.', '686a7a76a7e53-beef_tartare.jpg', 25, 0),
(44, 'Crispy Tuna Tataki with Charred Vegetables and Yuzu Emulsion', 45, 'Japanese', '2024-07-08', 'Tuna, zucchini, carrot, red onion, yuzu, soy reduction', 'Crusted tuna tataki over charred vegetables and bright yuzu emulsion.', '686a7a6449da9-tuna_tataki.jpg', 25, 10),
(45, 'Twisted Green Bean Tower with Chili-Ginger Beef', 48, 'Asian', '2024-07-08', 'Green beans, carrot, beef, chili, ginger, scallions', 'A sculpted green bean tower topped with sticky chili-ginger beef.', '686a7a61e6e98-green_bean_tower.jpg', 30, 20),
(46, 'Crispy Salmon with Beluga Lentils and Charred Cauliflower', 44, 'French', '2025-07-01', 'Salmon, lentils, cauliflower, creme fraiche, olive oil, radicchio', 'A skin-on Atlantic salmon fillet, pan-seared to a golden crisp and served over a bed of earthy beluga lentils, roasted cauliflower, and charred radicchio. The plate is finished with a swirl of lemon crème fraîche and a drizzle of cold-pressed olive oil, adding brightness to this rich and hearty seafood plate.', 'img_686a815a5fea7.jpg', 10, 20),
(49, 'Vanilla Ice Cream Tart with Crunchy Dark Chocolate Truffles and Salty Caramel Sauce', 52, 'Dessert', '2025-07-07', 'Dark chocolate, vanilla ice cream, caramel sauce, salt, sugar, chocolate truffles, wallnuts', 'A crisp dark chocolate tart shell filled with silky vanilla bean ice cream, crowned by a dome of glossy salted caramel glaze. Encircled with crunchy dark chocolate truffles, the dessert is finished with a delicate square of embossed chocolate for a final touch of finesse. A rich yet balanced indulgence where sweetness, salt, and texture harmonize perfectly.', 'img_686a87be9d7a3.jpg', 60, 35);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chef_id` (`chef_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `recipes_ibfk_1` FOREIGN KEY (`chef_id`) REFERENCES `chefs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

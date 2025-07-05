CREATE TABLE chefs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    role ENUM(
        'Executive Chef',
        'Head Chef',
        'Sous Chef',
        'Chef de Partie',
        'Commis Chef',
        'Kitchen Porter'
    ) NOT NULL,
    specialty VARCHAR(400) NOT NULL,
    biography TEXT,
    experience_years INT CHECK (experience_years >= 0),
    guilty_pleasure TEXT
);

CREATE TABLE recipes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    chef_id INT NOT NULL,
    cuisine VARCHAR(100),
    date_created DATE,
    ingredients TEXT,
    description TEXT,
    image_path VARCHAR(255),
    prep_time_minutes INT,
    cook_time_minutes INT,
    FOREIGN KEY (chef_id) REFERENCES chefs(id)
);

INSERT INTO chefs (name, role, specialty, biography, experience_years, guilty_pleasure)
VALUES
-- 1
('Jean Lefevre', 'Executive Chef', 'Sauce Chef',
 'Jean has led Michelin kitchens for almost 2 decades, renowed for his amazing dishes and incredibly refined sauces. A purist and a perfectionist.',
 18,
 '“Instant ramen, with poached egg, scallions and a dash of truffle oil.”'),

-- 2
('Maria Papadopoulos', 'Sous Chef', 'Fish Chef',
 'Maria grew up on the Greek island of Paros, and is known for bringing great knowledge of seafood and ocean flavors.',
 12,
 '“I can never say no to a classic gyros! I could eat that any day!”'),

-- 3
('Luca Rossi', 'Chef de Partie', 'Pasta Chef',
 'Trained in Rome and Milan, Luca elevates handmade pasta with modern plating and simple Italian flavors.',
 8,
 '“Cannoli with an espresso. High in calories, I know, but it warms my heart every time I enjoy them.”'),

-- 4
('Isabelle Dupont', 'Chef de Partie', 'Pastry Chef',
 'Coming from the home country of clasic pastries, Isabelle perfected her knowledge of refined desserts, French pastries, and lucious sauces.',
 10,
 '“I do confess that I love brownies. No offence to the croissants I used to eat when I was working as a pastry chef in Paris, but I do love a good and intense dark-chocolate brownie.”'),

-- 5
('Takeshi Morimoto', 'Head Chef', 'Cold Station Chef',
 'Trained in Kyoto and Osaka, Takeshi sees cuisine as art. With a handcrafted Japanese knife always in reach, he transforms even the humblest ingredient into a visual and textural masterpiece. His plating style draws from centuries of kaiseki tradition — refined, minimalist, and balanced. For Takeshi, flavor begins with the eyes.',
 14,
 '“An ice-cold melon soda with Pocky sticks. “When I want to feel like a kid again.”'),

-- 6
('Amara Singh', 'Chef de Partie', 'Vegetable Chef',
 'Amara has an amazing intuition for seasonal produce. She can walk through a morning market and design a tasting menu on the spot — pairing artichokes with saffron, or charred fennel with plum jus. Her plates are vibrant, surprising, and deeply rooted in nature’s calendar.',
 7,
 '“Chili lime mango poppadoms at a movie night.”'),

-- 7
('Omar Al-Farid', 'Sous Chef', 'Roast Chef',
 'Omar’s roots trace back to open-air hunting trips with his grandfather, where he learned to field-dress game and cook over wood embers before he could tie a neckerchief. He brings that primal knowledge into the Michelin kitchen — dry-aging wild meats, pairing them with spiced reductions, and building dishes that feel ancient yet refined.',
 11,
 '“Liver pâté on warm toast with loads much butter. It tastes like winter mornings in the mountains.”'),

-- 8
('Yuki Tanaka', 'Commis Chef', 'Multi-Disciplinary',
 'A rising star, Yuki rotates between stations and thrives under pressure. Recently promoted from kitchen porter.',
 2,
 '“Low-sugar, green-tea infused bubble tea with peach & passionfruit boba and lychee jelly.”'),

-- 9
('Claire Fontaine', 'Chef de Partie', 'Cold Station Chef',
 'Claire’s dishes are miniature artworks — thoughtful, composed, and bursting with color. Trained as a visual artist before stepping into the kitchen, she instinctively knows how to layer textures and place herbs, edible petals, and chilled foams that delight the eye before the tongue.',
 6,
 '“Salted caramel popcorn while watching Breaking Bad.”'),

-- 10
('Marcus Barlow', 'Head Chef', 'Butchery',
 'Raised on a working farm in Belgium, Marcus learned early that respect for the animal starts with how it’s broken down. His knife work is quiet and deliberate. Whether it’s wild fowl, trout, or dry-aged ribeye, he approaches butchery like calligraphy: precise, elegant, and expressive.',
 13,
 '“Thick slices of warm sourdough with duck fat and sea salt — rustic and perfect.”');

INSERT INTO recipes (title, chef_id, cuisine, date_created, ingredients, description, image_path, prep_time_minutes, cook_time_minutes)
VALUES
('Red Snapper with Charred Eggplant and Coral Tuile', 45, 'Japanese', '2024-07-01',
'Red snapper, eggplant, beetroot, edible flowers, microgreens, umami sauce',
'A delicate fillet of red snapper, gently pan-seared and served over charred eggplant. Garnished with edible flowers and coral tuile.',
'images/red_snapper.jpg', 20, 25),

('Braised Short Rib with Miso Carrot Purée and Forest Greens', 45, 'Asian Fusion', '2024-07-02',
'Beef short rib, miso, carrot, bok choy, fiddlehead ferns',
'Slow-braised short rib glazed in a savory reduction with silky miso-carrot purée and woodland greens.',
'images/short_rib.jpg', 30, 180),

('Tomato Confit with Burrata Snow and Paprika Crisp', 44, 'French', '2024-07-03',
'Tomatoes, burrata, paprika, parsnip, micro herbs',
'Slow-roasted tomato confit topped with burrata espuma and a paprika-dusted crisp. Finished with citrus zest and herbs.',
'images/tomato_confit.jpg', 25, 40),

('Island Plantain & Avocado Ribbon Salad', 47, 'Caribbean', '2024-07-03',
'Plantains, avocado, onion, bell pepper, tamarind, chili',
'Sweet grilled plantains, avocado mousse, and tropical vinaigrette served cold.',
'images/plantain_salad.jpg', 20, 0),

('Foie Gras Duo with Brioche Fingers and Strawberry Gastrique', 41, 'French', '2024-07-04',
'Foie gras, hazelnuts, brioche, rhubarb, strawberry',
'A duo of foie gras — one smooth, one crunchy — served with brioche and strawberry gastrique.',
'images/foie_gras_duo.jpg', 30, 15),

('Spring Meadow Trio: Cabbage-Wrapped Lamb, Parsnip Rose & Corn Bloom', 46, 'Seasonal', '2024-07-04',
'Lamb, parsnip, corn, polenta, wildflowers, veal sausage',
'A whimsical trio: cabbage-wrapped lamb, parsnip rose, and corn bloom with wildflowers.',
'images/spring_meadow.jpg', 45, 60),

('Chili Garlic Prawn Nests', 48, 'Asian Fusion', '2024-07-05',
'Tiger prawns, noodles, garlic, soy, chili, sesame oil',
'Soy-glazed noodle nests topped with prawns and chili sauce.',
'images/prawn_nests.jpg', 25, 15),

('Seabass al Limone with Warm Herb Gremolata', 42, 'Greek–Italian', '2024-07-05',
'Seabass, parsley, garlic, lemon zest, mushrooms, cauliflower',
'Pan-seared seabass with lemon gremolata and coastal vegetables.',
'images/seabass_limone.jpg', 20, 20),

('Braised Veal Medallion with Pearl Onions and Velouté', 49, 'French', '2024-07-06',
'Veal, pearl onions, potatoes, parsley, herb butter',
'Braised veal on creamy velouté with glazed pearl onions.',
'images/veal_medallion.jpg', 30, 90),

('Caramelized Pear Tart with Chestnut Cream and Honey Jus', 49, 'French', '2024-07-06',
'Pear, chestnut, honey, tart dough, sorbet, endive',
'Poached pear tart with chestnut cream, sorbet, and honey-spice jus.',
'images/pear_tart.jpg', 40, 25),

('Seared Scallops with Pine Nut Succotash and Citrus Vinaigrette', 42, 'Modern European', '2024-07-06',
'Scallops, corn, beans, asparagus, pine nuts, citrus',
'Perfectly seared scallops on sweet pine nut succotash and citrus vinaigrette.',
'images/scallops_succotash.jpg', 25, 10),

('Venison & Heirloom Tomato Tartare with Yellow Pepper Emulsion', 50, 'Game', '2024-07-07',
'Venison, heirloom tomatoes, peppers, mustard, onion, microgreens',
'Venison tartare with roasted tomato, pickled onion petals, and yellow pepper emulsion.',
'images/venison_tartare.jpg', 30, 0),

('Beef Tartare with Aged Cheese, Pickled Shallot & Split Herb Oil', 43, 'French', '2024-07-07',
'Beef, shallot, cheese, tomato pearls, parsley oil',
'Hand-cut beef tartare topped with cheese and herb oil, finished with pickled shallot.',
'images/beef_tartare.jpg', 25, 0),

('Crispy Tuna Tataki with Charred Vegetables and Yuzu Emulsion', 45, 'Japanese', '2024-07-08',
'Tuna, zucchini, carrot, red onion, yuzu, soy reduction',
'Crusted tuna tataki over charred vegetables and bright yuzu emulsion.',
'images/tuna_tataki.jpg', 25, 10),

('Twisted Green Bean Tower with Chili-Ginger Beef', 48, 'Asian', '2024-07-08',
'Green beans, carrot, beef, chili, ginger, scallions',
'A sculpted green bean tower topped with sticky chili-ginger beef.',
'images/green_bean_tower.jpg', 30, 15);
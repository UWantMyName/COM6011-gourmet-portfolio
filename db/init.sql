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
    specialty ENUM(
        'Grill Chef',
        'Pastry Chef',
        'Sauce Chef',
        'Fish Chef',
        'Roast Chef',
        'Cold Station Chef',
        'Vegetable Chef',
        'Butchery',
        'Plating',
        'Multi-Disciplinary'
    ) NOT NULL,
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
('Isabelle Dupont', 'Pastry Chef', 'Pastry Chef',
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
 '“Thick slices of warm sourdough with duck fat and sea salt — rustic and perfect.”'),

-- Create the 'chefs' table
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
    guilty_pleasure TEXT,
    image_path VARCHAR(255)
);

-- Create the 'recipes' table
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

-- Sample inserts into 'chefs'
INSERT INTO chefs (name, role, specialty, biography, experience_years, guilty_pleasure, image_path) VALUES
('Jean Lefevre', 'Executive Chef', 'Sauce Chef', 'Jean has led Michelin kitchens for almost 2 decades...', 18, 'Instant ramen with poached egg and truffle oil', 'images/chefs/41.jpg'),
('Maria Papadopoulos', 'Sous Chef', 'Fish Chef', 'Maria grew up on the Greek island of Paros...', 11, 'Classic gyros', 'images/chefs/42.jpg'),
('Luca Rossi', 'Chef de Partie', 'Pasta Chef', 'Trained in Rome and Milan...', 8, 'Cannoli with espresso', 'images/chefs/43.jpg');

-- Sample inserts into 'recipes'
INSERT INTO recipes (title, chef_id, cuisine, date_created, ingredients, description, image_path, prep_time_minutes, cook_time_minutes) VALUES
('Red Snapper with Charred Eggplant and Coral Tuile', 45, 'Japanese', '2024-07-01',
 'Red snapper, eggplant, beetroot, edible flowers, microgreens, umami sauce',
 'A delicate fillet of red snapper, gently pan-seared and served over charred eggplant...',
 'images/red_snapper.jpg', 20, 25),

('Foie Gras Duo with Brioche Fingers and Strawberry Gastrique', 41, 'French', '2024-07-04',
 'Foie gras, hazelnuts, brioche, rhubarb, strawberry',
 'A duo of foie gras — one smooth, one crunchy — served with brioche and strawberry gastrique.',
 'images/foie_gras_duo.jpg', 30, 15),

('Crispy Salmon with Beluga Lentils and Charred Cauliflower', 44, 'French', '2025-07-01',
 'Salmon, lentils, cauliflower, crème fraîche, olive oil, radicchio',
 'A skin-on Atlantic salmon fillet, pan-seared to a golden crisp and served over lentils and charred radicchio...',
 'images/salmon_lentils.jpg', 10, 20);

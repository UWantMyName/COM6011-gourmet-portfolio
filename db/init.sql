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
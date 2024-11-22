CREATE TABLE users(
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    fName VARCHAR(50) NOT NULL,
    lName VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE food_items (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    item_name VARCHAR(100) NOT NULL,
    expiration_date DATE NOT NULL,
    quantity INT NOT NULL,
    added_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE notifications (
    notification_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    item_id INT,
    message VARCHAR(255) NOT NULL,
    sent_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    seen BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (item_id) REFERENCES food_items(item_id) ON DELETE CASCADE
);

CREATE TABLE recipes (
    recipe_id INT AUTO_INCREMENT PRIMARY KEY,
    recipe_name VARCHAR(100) NOT NULL,
    instructions TEXT NOT NULL,
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE recipe_ingredients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recipe_id INT,
    ingredient_name VARCHAR(100) NOT NULL,
    FOREIGN KEY (recipe_id) REFERENCES recipes(recipe_id) ON DELETE CASCADE
);

CREATE TABLE feedback (
    feedback_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    feedback_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE daily_tips (
    tip_id INT AUTO_INCREMENT PRIMARY KEY,
    tip_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE recipe_recommendations (
    recommendation_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    recipe_id INT,
    recommended_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (recipe_id) REFERENCES recipes(recipe_id) ON DELETE CASCADE
);


INSERT INTO users (fName, lName, email, password) VALUES
('Kwame', 'Nkrumah', 'kwame@gmail.com', 'kwame1542wes'),
('Akosua', 'Agyapadie', 'akosua@gmail.com', 'ahhdrhb345'),
('Kojo', 'Bonsu', 'kojo@gmail.com', 'ajhdbhrbuj777'),
('Yaw', 'Adjei', 'yaw@gmail.com', 'hsbujsjb333'),
('Abena', 'Osei', 'abena@gmail.com', 'amaseee233'),
('Kofi', 'Mensah', 'kofi@gmail.com', 'adssesee'),
('Esi', 'Asante', 'esi@gmail.com', 'amnanbdjnf-jh'),
('Nana', 'Yaw', 'nana@gmail.com', 'ajndiif0kkgn'),
('Mabel', 'Tetteh', 'mabel@gmail.com', 'ahbjfnfng');


INSERT INTO food_items (user_id, item_name, expiration_date, quantity) VALUES 
(1, 'Rice', '2024-11-10', 2),
(1, 'Tomatoes', '2024-11-05', 5),
(2, 'Chicken', '2024-11-12', 1),
(2, 'Bananas', '2024-11-08', 6),
(3, 'Beans', '2024-11-15', 1),
(3, 'Eggs', '2024-11-06', 12),
(4, 'Pineapple', '2024-11-04', 1),
(5, 'Yam', '2024-11-20', 3),
(6, 'Cabbage', '2024-11-07', 2),
(7, 'Peppers', '2024-11-11', 4);


INSERT INTO recipes (recipe_name, instructions) VALUES 
('Jollof Rice', 'Cook rice in a pot with tomatoes, onions, and spices.'),
('Kelewele', 'Fry ripe plantains seasoned with ginger and spices.'),
('Chili Stew', 'Cook chicken in a spicy tomato sauce.'),
('Banku and Tilapia', 'Grill tilapia and serve with banku and pepper sauce.'),
('Fried Rice', 'Stir-fry rice with vegetables and chicken.'),
('Groundnut Soup', 'Make a soup from groundnuts and serve with rice balls.'),
('Omo Tuo', 'Prepare rice balls served with groundnut soup.'),
('Egg Stew', 'Cook eggs in a spicy tomato sauce.'),
('Palava Sauce', 'Cook vegetables and serve with boiled plantains.'),
('Light Soup', 'Make a soup from fish and spices, served with fufu.');


INSERT INTO recipe_ingredients (recipe_id, ingredient_name) VALUES
(1, 'Rice'),
(1, 'Tomatoes'),
(1, 'Onions'),
(1, 'Vegetable Oil'),
(1, 'Garlic'),
(2, 'Ripe Plantains'),
(2, 'Ginger'),
(2, 'Chili Powder'),
(2, 'Pepper'),
(3, 'Chicken'),
(3, 'Tomatoes'),
(3, 'Onions'),
(3, 'Garlic'),
(4, 'Tilapia'),
(4, 'Cornmeal'),
(4, 'Water'),
(4, 'Cassava Flour'),
(5, 'Rice'),
(5, 'Vegetables'),
(5, 'Chicken'),
(6, 'Groundnuts'),
(6, 'Rice Balls'),
(7, 'Rice'),
(7, 'Groundnuts'),
(8, 'Eggs'),
(8, 'Tomatoes'),
(8, 'Chili Powder'),
(9, 'Spinach'),
(9, 'Plantains'),
(9, 'Tomatoes'),
(10, 'Fish'),
(10, 'Pepper'),
(10, 'Tomatoes');


INSERT INTO daily_tips (tip_text) VALUES 
('Check your fridge weekly to prevent spoilage.'),
('Store tomatoes at room temperature for better flavor.'),
('Keep vegetables in the crisper drawer of your fridge.'),
('Use a first-in, first-out system for your groceries. This is your "queue" to eat that food..'),
('Freeze excess food to extend its shelf life.'),
('Plan your meals around what needs to be consumed soon.'),
('Use clear containers to see your food items easily.'),
('Keep an inventory list of what’s in your fridge.'),
('Buy only what you need to reduce waste.'),
('Learn to cook with leftovers for a delicious meal.');


INSERT INTO feedback (user_id, feedback_text) VALUES 
(1, 'Great app! It helped me reduce food waste significantly.'),
(2, 'I love the recipe suggestions; they are very helpful.'),
(3, 'The reminder feature is fantastic; I never forget my food.'),
(4, 'I would like to see more tips on food storage.'),
(5, 'The interface is user-friendly, keep it up!'),
(6, 'I find the expiration notifications very useful.'),
(7, 'More local recipes would be great for users.'),
(8, 'I appreciate the daily tips; they are very practical.'),
(9, 'Can we add a feature to track leftovers?');


INSERT INTO notifications (user_id, item_id, message) VALUES 
(1, 2, 'Your tomatoes will expire in 3 days!'),
(2, 1, 'Remember to use your chicken soon!'),
(3, 6, 'You have eggs that will expire tomorrow!'),
(4, 7, 'Your pineapple is about to go bad!'),
(5, 6, 'Your cabbage will expire in 2 days.'),
(6, 5, 'You have beans that need to be cooked!'),
(7, 7, 'Check your peppers; they will expire soon!'),
(8, 8, 'Use your yam within the week!'),
(9, 4, 'You have ripe bananas; consider making Kelewele!');



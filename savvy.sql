CREATE TABLE users(
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    fName VARCHAR(50) NOT NULL,
    lName VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



-- Create the 'food_items' table
CREATE TABLE food_items (
    item_id INT AUTO_INCREMENT PRIMARY KEY,          -- Food item ID
    user_id INT,                                     -- User ID (foreign key)
    item_name VARCHAR(100) NOT NULL,                  -- Food item name
    expiration_date DATE NOT NULL,                    -- Expiration date
    quantity INT NOT NULL,                            -- Quantity of the item
    added_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,     -- Date item was added
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE  -- Foreign key to users table
);

-- Create the 'notifications' table for food expiration reminders
CREATE TABLE notifications (
    notification_id INT AUTO_INCREMENT PRIMARY KEY,  -- Notification ID
    user_id INT,                                     -- User ID (foreign key)
    item_id INT,                                     -- Item ID (foreign key)
    message VARCHAR(255) NOT NULL,                    -- Notification message
    sent_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,      -- Date and time the notification was sent
    seen BOOLEAN DEFAULT FALSE,                       -- Whether the notification has been read
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,  -- Link to users table
    FOREIGN KEY (item_id) REFERENCES food_items(item_id) ON DELETE CASCADE  -- Link to food_items table
);

-- Create the 'recipes' table
CREATE TABLE recipes (
    recipe_id INT AUTO_INCREMENT PRIMARY KEY,        -- Recipe ID
    recipe_name VARCHAR(100) NOT NULL,                -- Recipe name
    instructions TEXT NOT NULL,                       -- Cooking instructions
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP    -- Date recipe was created
);

-- Create the 'recipe_ingredients' table for recipe ingredients
CREATE TABLE recipe_ingredients (
    id INT AUTO_INCREMENT PRIMARY KEY,               -- Ingredient ID
    recipe_id INT,                                    -- Recipe ID (foreign key)
    ingredient_name VARCHAR(100) NOT NULL,            -- Ingredient name
    FOREIGN KEY (recipe_id) REFERENCES recipes(recipe_id) ON DELETE CASCADE  -- Link to recipes table
);

-- Create the 'feedback' table for user feedback
CREATE TABLE feedback (
    feedback_id INT AUTO_INCREMENT PRIMARY KEY,      -- Feedback ID
    user_id INT,                                     -- User ID (foreign key)
    feedback_text TEXT NOT NULL,                     -- Feedback content
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Timestamp of feedback submission
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE  -- Link to users table
);

-- Create the 'daily_tips' table for food storage tips
CREATE TABLE daily_tips (
    tip_id INT AUTO_INCREMENT PRIMARY KEY,           -- Tip ID
    tip_text TEXT NOT NULL,                          -- Tip content
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP   -- Timestamp for when the tip was added
);

-- Create the 'recipe_recommendations' table for recommending recipes to users
CREATE TABLE recipe_recommendations (
    recommendation_id INT AUTO_INCREMENT PRIMARY KEY, -- Recommendation ID
    user_id INT,                                      -- User ID (foreign key)
    recipe_id INT,                                    -- Recipe ID (foreign key)
    recommended_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp for the recommendation
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,  -- Link to users table
    FOREIGN KEY (recipe_id) REFERENCES recipes(recipe_id) ON DELETE CASCADE  -- Link to recipes table
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

-- Insert sample data into 'food_items'
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

-- Insert sample data into 'recipes'
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

-- Insert sample data into 'recipe_ingredients'
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

-- Insert sample data into 'daily_tips'
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

-- Insert sample data into 'feedback'
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

-- Insert sample data into 'notifications'
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



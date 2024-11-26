CREATE TABLE team_project_users(
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    fName VARCHAR(50) NOT NULL,
    lName VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create the 'food_items' table
CREATE TABLE team_project_food_items (
    item_id INT AUTO_INCREMENT PRIMARY KEY,          -- Food item ID
    user_id INT,                                     -- User ID (foreign key)
    item_name VARCHAR(100) NOT NULL,                  -- Food item name
    expiration_date DATE NOT NULL,                    -- Expiration date
    quantity INT NOT NULL,                            -- Quantity of the item
    added_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,     -- Date item was added
    FOREIGN KEY (user_id) REFERENCES team_project_users(user_id) ON DELETE CASCADE  -- Foreign key to users table
);

-- Create the 'notifications' table for food expiration reminders
CREATE TABLE team_project_notifications (
    notification_id INT AUTO_INCREMENT PRIMARY KEY,  -- Notification ID
    user_id INT,                                     -- User ID (foreign key)
    item_id INT,                                     -- Item ID (foreign key)
    message VARCHAR(255) NOT NULL,                    -- Notification message
    sent_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,      -- Date and time the notification was sent
    seen BOOLEAN DEFAULT FALSE,                       -- Whether the notification has been read
    FOREIGN KEY (user_id) REFERENCES team_project_users(user_id) ON DELETE CASCADE,  -- Link to users table
    FOREIGN KEY (item_id) REFERENCES team_project_food_items(item_id) ON DELETE CASCADE  -- Link to food_items table
);

-- Create the 'recipes' table
CREATE TABLE team_project_recipes (
    recipe_id INT AUTO_INCREMENT PRIMARY KEY,        -- Recipe ID
    recipe_name VARCHAR(100) NOT NULL,                -- Recipe name
    instructions TEXT NOT NULL,                       -- Cooking instructions
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP    -- Date recipe was created
);

-- Create the 'feedback' table for user feedback
CREATE TABLE team_project_feedback (
    feedback_id INT AUTO_INCREMENT PRIMARY KEY,      -- Feedback ID
    user_id INT,                                     -- User ID (foreign key)
    feedback_text TEXT NOT NULL,                     -- Feedback content
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Timestamp of feedback submission
    FOREIGN KEY (user_id) REFERENCES team_project_users(user_id) ON DELETE CASCADE  -- Link to users table
);

-- Create the 'daily_tips' table for food storage tips
CREATE TABLE team_project_daily_tips (
    tip_id INT AUTO_INCREMENT PRIMARY KEY,           -- Tip ID
    tip_text TEXT NOT NULL,                          -- Tip content
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP   -- Timestamp for when the tip was added
);

-- Create the 'recipe_recommendations' table for recommending recipes to users
CREATE TABLE team_project_recipe_recommendations (
    recommendation_id INT AUTO_INCREMENT PRIMARY KEY, -- Recommendation ID
    user_id INT,                                      -- User ID (foreign key)
    recipe_id INT,                                    -- Recipe ID (foreign key)
    recommended_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp for the recommendation
    FOREIGN KEY (user_id) REFERENCES team_project_users(user_id) ON DELETE CASCADE,  -- Link to users table
    FOREIGN KEY (recipe_id) REFERENCES team_project_recipes(recipe_id) ON DELETE CASCADE  -- Link to recipes table
);

CREATE TABLE team_project_tasks (
    task_id INT AUTO_INCREMENT PRIMARY KEY,          -- Task ID
    user_id INT NOT NULL,                            -- User ID (foreign key)
    task_name VARCHAR(255) NOT NULL,                  -- Task name (e.g., food to consume)
    task_description TEXT,                           -- Task description (optional)
    is_completed TINYINT(1) DEFAULT 0,                -- Task completion status (0 = not completed, 1 = completed)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,   -- Task creation timestamp
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, -- Last update timestamp
    due_date DATETIME,                               -- Optional due date for tasks
    FOREIGN KEY (user_id) REFERENCES team_project_users(user_id) ON DELETE CASCADE  -- Link to users table
);

CREATE TABLE team_project_password_reset_tokens (
    user_id INT NOT NULL,
    token VARCHAR(64) NOT NULL,
    expires_at DATETIME NOT NULL,
    PRIMARY KEY (user_id),
    FOREIGN KEY (user_id) REFERENCES team_project_users(user_id) ON DELETE CASCADE
);

INSERT INTO team_project_users (fName, lName, email, password) VALUES
('Kwame', 'Nkrumah', 'kwame@gmail.com', 'kwame1542wes'),
('Akosua', 'Agyapadie', 'akosua@gmail.com', 'ahhdrhb345'),
('Kojo', 'Bonsu', 'kojo@gmail.com', 'ajhdbhrbuj777'),
('Yaw', 'Adjei', 'yaw@gmail.com', 'hsbujsjb333');

-- Insert sample data into 'daily_tips'
INSERT INTO team_project_daily_tips (tip_text) VALUES 
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
INSERT INTO team_project_feedback (user_id, feedback_text) VALUES 
(1, 'Great app! It helped me reduce food waste significantly.'),
(2, 'I love the recipe suggestions; they are very helpful.'),
(3, 'The reminder feature is fantastic; I never forget my food.'),
(4, 'I would like to see more tips on food storage.');




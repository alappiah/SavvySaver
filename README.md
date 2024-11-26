<a name="readme-top"></a>

<!-- PROJECT SHIELDS -->
![Contributors](https://img.shields.io/github/contributors/alappiah/SavvySaver.svg?style=for-the-badge)
![Forks](https://img.shields.io/github/forks/alappiah/SavvySaver.svg?style=for-the-badge)
![Stars](https://img.shields.io/github/stars/alappiah/SavvySaver.svg?style=for-the-badge)
![Issues](https://img.shields.io/github/issues/alappiah/SavvySaver.svg?style=for-the-badge)

<br />
<div align="center">
  <h3 align="center">Savvy Saver</h3>
  <p align="center">
    A food management application designed to help you save money and reduce waste.
    <br />
    <a href="https://github.com/alappiah/SavvySaver"><strong>Explore the docs »</strong></a>
    <br />
    <br />
    <a href="https://github.com/alappiah/SavvySaver/issues">Report Bug</a>
    ·
    <a href="https://github.com/alappiah/SavvySaver/issues">Request Feature</a>
  </p>
</div>

---

## Table of Contents

1. [About The Project](#about-the-project)
2. [Built With](#built-with)
3. [Getting Started](#getting-started)
4. [Usage](#usage)
5. [Project Structure](#project-structure)
6. [Contributors](#contributing)
7. [Contact](#contact)

---

## About The Project

**Savvy Saver** is a web-based application built to simplify food inventory management. By tracking expiration dates, providing daily tips, and recommending recipes, the app helps users minimize waste and save money.  

Key features include:  
- Food Inventory Management  
- Expiration Notifications  
- Recipe Suggestions  
- Personalized Dashboards and Insights  
- Daily Tips for smarter food usage  

<p align="right">(<a href="#readme-top">back to top</a>)</p>

---

## Built With

### Frontend
- **HTML** for page structure  
- **CSS** for styling  
- **JavaScript** for interactivity and notifications  
- **Font Awesome** for UI icons  

### Backend
- **PHP** for server-side logic  
- **MySQLi** for database interaction  

### Database
- **MySQL** for storing user data, inventory, and notifications  

<p align="right">(<a href="#readme-top">back to top</a>)</p>

---

## Getting Started

### Prerequisites

Ensure you have the following installed:  
- PHP (7.4 or later)  
- MySQL server  
- A local development server such as XAMPP, WAMP, or MAMP  

### Installation

1. Clone the repo:  
   ```bash
   git clone https://github.com/alappiah/SavvySaver.git
   cd SavvySaver
   ```

2. Import the database:  
   - Import the `savvy_saver.sql` file located in the `database/` folder into your MySQL server.

3. Configure the database connection:  
   - Open `config/db_connect.php` and update the following fields:
     ```php
     $host = 'localhost';
     $dbname = 'savvy_saver';
     $username = 'your_username';
     $password = 'your_password';
     ```

4. Start the application:  
   - Launch your local server and access the application at:  
     ```
     http://localhost/SavvySaver
     ```

<p align="right">(<a href="#readme-top">back to top</a>)</p>

---

## Usage

1. **Add Food Items**: Start by adding items to your inventory, including name, quantity, and expiration date.  
2. **Receive Notifications**: Get alerts for items close to their expiration.  
3. **Explore Recipes**: Use recommendations to creatively use food before it expires.  
4. **Check Your Dashboard**: View insights, tips, and personalized statistics.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

---

## Project Structure

```plaintext
SavvySaver/
├── assets/           # Static resources (CSS, JS, images)
│   ├── css/          # Stylesheets
│   ├── js/           # JavaScript for dynamic features
│   └── img/          # Images and icons
├── config/           # Configuration files
│   └── db_connect.php # Database connection logic
├── database/         # SQL scripts for database setup
│   └── savvy_saver.sql # Initialize database
├── includes/         # Reusable components
│   ├── header.php    # Header for all pages
│   ├── footer.php    # Footer for all pages
│   └── auth.php      # Authentication logic
├── views/            # Application views (PHP templates)
│   ├── dashboard.php # User dashboard
│   ├── inventory.php # Inventory management
│   ├── recipes.php   # Recipe suggestions
│   └── profile.php   # User profile
├── index.php         # Homepage
└── README.md         # Documentation
```

<p align="right">(<a href="#readme-top">back to top</a>)</p>

---

## Contributors

We’d like to thank the following contributors for their valuable input and effort in building **Savvy Saver**:  

| **Contributor** | **Contribution Description** |  
|------------------|-------------------------------|  
| **[Thomas Parker](https://github.com/ThomasParkerr)** |
 -  Implemented the frontend and backend for the Dashboard and all its sub-pages, including **Recipe Recommendations**, **Daily Tips**, **Notifications**, **Food Inventory**, **Recipes**, and **Tasks**.
 - Designed and implemented the backend for the homepage. Developed functionalities for adding food items, recipes, and tasks,
 - Designed logic for marking tasks as completed.
 - Added a feature to display a snippet of notifications without navigating to the dashboard.


**[Alvin Appiah](https://github.com/alappiah)** 
- Designed the frontend layout for the **Login** and **Signup** pages.
- Implemented the **Email Notification** feature. 
- Developed backend logic for **User Feedback**, **Profile Updates**, and **Password Changes**.

**[Elizabeth Avevor](https://github.com/Afful-yayra156)** 
- Created the project **Storyboard** 
- Assisted in developing the website's pages. 
- Updated the frontend for three pages, including the **Settings Page**
- Improved the **Login** and **Signup** pages. |  

**[Joel Ackam](https://github.com/contributor-profile)**
- Created the project **Storyboard** 
- Helped in developing the website's pages. |  

## Contact

Your Name - [your-email@example.com](mailto:your-email@example.com)  

Project Link: [https://github.com/alappiah/SavvySaver](https://github.com/alappiah/SavvySaver)  

<p align="right">(<a href="#readme-top">back to top</a>)</p>

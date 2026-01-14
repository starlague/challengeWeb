# Site_Social

![Version](https://img.shields.io/badge/version-1.0.0-blue) ![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)

## 🪧 About
**Site_Social** is a simple online social network that allows users to share posts, interact via likes and comments, and customize their profile.  
This project was developed as part of a school project called the **“Challenge Web”**, where the goal was to create a functional and interactive website.  
The aim is to provide an intuitive and user-friendly platform to post and discover content.

## ✨ Features
- 📝 **User registration & login**: create and secure your account  
- 👤 **Profile management**: edit bio and personal info  
- 📰 **Posts**: create and publish posts easily  
- ❤️ **Likes**: like posts from other users  
- 💬 **Comments**: comment on posts and interact with the community  
- 🌐 **Responsive interface**: works on modern browsers

## 📦 Prerequisites
Before installing and running the project, make sure you have:  
- **PHP >= 7.4**: server-side language for backend. [PHP Documentation](https://www.php.net/docs.php)  
- **MySQL or MariaDB**: database to store users, posts, and comments. [MySQL Documentation](https://dev.mysql.com/doc/)  
- **Local server**: XAMPP, WAMP, MAMP, or equivalent to run PHP and MySQL  
- **Modern browser**: Chrome, Firefox, Edge, or equivalent  

## 🚀 Installation
1. **Clone the repository:**  
   ```bash
   git clone https://github.com/starlague/challengeWeb.git

   cd site_social
2. **Configure the database:**

- Create a MySQL database, e.g., site_social_db

- Import the database.sql file to create the initial tables, or create them manually

- Edit config.php with your database credentials

3. **Run the local server:**

- Place project files in your server’s web folder (e.g., htdocs for XAMPP)

- Open the site in your browser at: http://localhost/site_social

## 🛠️ Usage
**User Management**

- Sign up, login, logout

- Edit profile information and bio

**Posts & Interactions**

- Create, like, and comment on posts

- View posts from all users

**Example Commands for Local Setup**

1. **Open site in browser**
    ```bash
    http://localhost/site_social
2. **Check database tables**
    ```bash
    mysql -u root -p
    USE site_social_db;
    SHOW TABLES;
3. **Reset database (optional)**
    ```bash
    mysql -u root -p site_social_db < database.sql
4. **Start PHP built-in server (alternative)**
    ```bash
    php -S localhost:8000
## 🤝 Contributing
**How to Contribute**

1. **Fork the repository**

2. **Create a branch:**
    ```bash
    git checkout -b my-feature
3. **Make changes and commit:**
    ```bash
    git add .
    git commit -m "Description of changes"
4. **Push branch:**
    ```bash
    git push origin my-feature
5. **Open a Pull Request on the main repository**
**Best Practices**

- Follow the project structure and coding style

- Test your changes before submitting a PR

- Provide clear commit messages and PR descriptions

## 🏗️ Built With

- HTML, CSS, JavaScript: front-end interface

- PHP: server-side logic and sessions

- MySQL: relational database

- XAMPP/WAMP/MAMP: local server environment

## 📚 Documentation

- PHP Documentation

- MySQL Documentation

## 📝 License

This project is licensed under the **MIT License**.

    
    Copyright (c) Nils Adermann, Jordi Boggiano


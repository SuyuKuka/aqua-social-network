# Aqua

## About
Aqua Social Network is a full-stack web application developed as a first-year university (L1) project. Built entirely from scratch using native PHP and MySQL without any frameworks.

The platform offers a complete social networking experience where users can create secure accounts, customize their profiles, follow other members, and engage with diverse content through a personalized newsfeed, likes, and comments.

*Note: As this was originally a localized academic project, the application's user interface, database schema, and source code comments are primarily in French.*

## Tech Stack
- **Frontend:** HTML5, CSS3    
- **Backend:** Native PHP  
- **Database:** MySQL

## Key Features
- **User Authentication:** Login and registration system with password hashing (MD5).
- **Personalized Newsfeed:** A dynamic home page displaying posts exclusively from accounts the user is subscribed to.
- **Profile & Follow System:** Detailed user profiles showing follower/following counts, personal posts, and the ability to subscribe to other users.
- **Content Publishing:** Users can create and share posts containing various media types (text, images, videos).
- **Social Interactions:** Users can engage with content by leaving **comments** or/and **liking** posts.
- **Account Management:** Users can fully customize their profile by updating their avatar, username, email, and password.
- **Search Engine:** Built-in search functionality to find specific users by their ID or username.
- **Admin Moderation:** Dedicated administrator accounts with elevated privileges to delete any user's posts or comments.

## Getting Started

### Prerequisites
- [XAMPP](https://www.apachefriends.org/index.html) (includes Apache, MySQL, PHP and phpMyAdmin)
- Git

### Installation

1. **Start the local server:**
   Open the XAMPP Control Panel and start both the **Apache** and **MySQL** modules.

2. **Clone the repository:**
   Navigate to your XAMPP web directory (usually `C:\xampp\htdocs` on Windows) and clone the project:

```bash
cd C:\xampp\htdocs
git clone https://github.com/SuyuKuka/aqua-social-network.git aqua    
```

3. **Database Setup:**
   * Open your web browser and go to `http://localhost/phpmyadmin/index.php`.
   * Click on the **Import** tab.
   * Choose the `$preset.sql` file provided in this repository and click **Import**.

4. **Configuration (Optional):**
   The project is pre-configured for a default XAMPP setup (`Host: localhost`, `User: root`, `Password: [empty]`, `Database: aqua_db`). 
   If your local MySQL requires a password, update the `conn_start()` function in `fonction.php`.

5. **Launch the application:**
   Open your web browser and navigate to the login page:
   `http://localhost/aqua/login.php`

## Configuration

Pre-configured test accounts are provided in the database to allow quick testing without manual registration:

**Test Admin Account:**
- **Email:** `admin@gmail.com`
- **Password:** `(Pre-configured in database)`

**Test User Account:**
- **Email:** `notme@gmail.com`
- **Password:** `(Pre-configured in database)`

**Test User Account:**
- **Email:** `carapuce@gmail.com`
- **Password:** `(Pre-configured in database)`

**Test User Account:**
- **Email:** `haru@gmail.com`
- **Password:** `(Pre-configured in database)`

**Test User Account:**
- **Email:** `magimagi@gmail.com`
- **Password:** `(Pre-configured in database)`

## Team

This project was developed collaboratively as a 2-person team:

- **CHEN Michel**Full-stack development 
  [![GitHub](https://img.shields.io/badge/GitHub-Profile-181717?logo=github)](https://github.com/SuyuKuka)
  [![LinkedIn](https://img.shields.io/badge/LinkedIn-Profile-0A66C2?logo=linkedin)](https://linkedin.com/in/chen-michel)

- **HUYNH Minh Van Claude**Full-stack development 
  [![GitHub](https://img.shields.io/badge/GitHub-Profile-181717?logo=github)](https://github.com/huynh-claude)

## License

Aqua is licensed under the AGPL 3.0 License — see [LICENSE](LICENSE) for details.

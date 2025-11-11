```markdown
# 🏏 Cricket Player Management System

A comprehensive web-based application for managing cricket players, teams, and performance statistics. Built with PHP, MySQL, and modern CSS.

## 🌟 Features

- **Player Management** - Add, edit, delete, and view player profiles
- **Team Management** - Create teams and assign players (CSK, RCB, MI included)
- **Player Comparison** - Compare two players side-by-side with statistics
- **Advanced Search** - Filter players by name, country, role, runs, and wickets
- **Performance Dashboard** - Real-time statistics and top performers
- **Responsive Design** - Works on all devices

## 🚀 Quick Start

### Prerequisites
- PHP 7.4+
- MySQL 5.7+
- Web server (Apache/Nginx)

### Installation

1. **Import Database**
   ```sql
   CREATE DATABASE cricket_db;
   USE cricket_db;
   -- Import the SQL schema
   ```

2. **Configure Database**
   Edit `db_connect.php` with your credentials:
   ```php
   $servername = "localhost";
   $username = "root";
   $password = "";
   $database = "cricket_db";
   ```

3. **Access Application**
   Navigate to `http://localhost/cricket-management/`

## 📁 Files Structure

- `index.php` - Main dashboard with statistics
- `all_players.php` - Complete player list
- `add_player.php` - Add new players
- `edit.php` - Edit player details  
- `compare_players.php` - Player comparison tool
- `search_players.php` - Advanced search
- `teams.php` - Team management
- `style.css` - Modern responsive styling

## 🗃️ Database Tables

- `players` - Player profiles and statistics
- `teams` - Team information
- `player_teams` - Player-team relationships

## 🎮 Usage

1. **Add Players**: Fill in name, country, role, matches, runs, wickets
2. **Manage Teams**: Create teams and assign players
3. **Compare Players**: Select two players for side-by-side comparison
4. **Search**: Use filters to find specific players
5. **View Stats**: Dashboard shows top performers and totals

## 📊 Sample Data Included

- **Chennai Super Kings (CSK)**: MS Dhoni, Ravindra Jadeja, etc.
- **Royal Challengers Bangalore (RCB)**: Virat Kohli, Glenn Maxwell, etc.  
- **Mumbai Indians (MI)**: Rohit Sharma, Jasprit Bumrah, etc.

## 🔧 Technologies

- **Backend**: PHP, MySQL
- **Frontend**: HTML5, CSS3, JavaScript
- **Styling**: CSS Grid, Flexbox, Gradients
- **Features**: Responsive design, form validation, real-time calculations

---

**Start managing your cricket team like a pro!** 🏆
```

# Event Management System

## 📌 Overview
The **Event Management System** is a PHP and MySQL-based application that allows users to create, manage, and register for events. The system includes features like user authentication, event CRUD operations, attendee management, and CSV export functionality.

## 🚀 Features
- **User Authentication** (Admin & User roles)
- **Create, Edit, Delete, and View Events**
- **Attendee Registration** (Prevents exceeding capacity)
- **Event Dashboard** (Sortable, Paginated, and Filterable)
- **CSV Export for Attendees (Admin Only)**

## 📂 Installation

### 1️⃣ Clone the Repository
```sh
git clone https://github.com/msicse/event-management.git
cd event-management
```

### 2️⃣ Set Up Database
- Create a new database in MySQL:
```sql
CREATE DATABASE event_management;
```
- Import `event_management.sql` into the database via phpMyAdmin or MySQL CLI:
```sh
mysql -u root -p event_management < event_management.sql
```

### 3️⃣ Configure Database Connection
Update **`db_connection.php`** with your database credentials:
```php
$host = 'localhost';
$dbname = 'event_management';
$username = 'root';
$password = '';
```

### 4️⃣ Start the Server
- **For XAMPP/WAMP Users:** Start Apache & MySQL services.
- **Access the application:**
```sh
http://localhost/event-management/
```

## 🔑 Default Admin Credentials
- **Email:** `admin@test.com`
- **Password:** `123456`

## 🔑 Default User Credentials
- **Email:** `user@test.com`
- **Password:** `123456`

## 🛠 Technologies Used
- **PHP** (Core Backend Development)
- **MySQL** (Database)
- **Bootstrap** (Frontend Styling)
- **jQuery** (Interactive UI)
- **PDO** (Secure Database Connection)

# bus-ticket

A lightweight **bus ticket reservation system** built with PHP. It provides a simple interface for passengers to browse routes, book seats, and make payments, while giving administrators full control over routes, bookings, and sales reports.

---

## Overview

The application consists of two main portals:

| Portal | Description |
|--------|-------------|
| **Admin** | Manage routes, view bookings, generate sales reports, and handle user authentication. |
| **User** | Register, log in, browse available bus routes, book seats, and pay via EasyPaisa. |

All data is stored in a MySQL database (`bus_db.sql`). The project follows a clear folder structure separating configuration, admin pages, and public pages.

---

## Features

- **Admin Dashboard** – Centralized navigation (`admin_navbar.php`) with pages for routes, bookings, and sales reports.  
- **Route Management** – Add, edit, and delete bus routes (`admin/route.php`, `admin/edit_route.php`).  
- **Booking System** – Users can select a route, choose seats, and confirm bookings (`user_bookings.php`).  
- **Payment Integration** – EasyPaisa payment gateway (`easy_paisa_payment.php`, `easy_payment.php`).  
- **User Authentication** – Secure login/logout for both admins and passengers (`admin_login.php`, `login.php`, `register.php`).  
- **Reporting** – Daily/weekly sales reports with exportable data (`admin/sales_report.php`).  
- **Responsive UI** – Simple, clean layout using Bootstrap (included via CDN).  

---

## Tech Stack

| Component | Technology |
|-----------|------------|
| Backend | PHP 7.4+ |
| Database | MySQL |
| Front‑end | HTML5, CSS3, Bootstrap 5 |
| Payment Gateway | EasyPaisa (API key placeholder: `YOUR_OWN_API_KEY`) |
| Server | Apache / Nginx (any LAMP/LEMP stack) |

---

## Installation

1. **Clone the repository**  

   ```bash
   git clone https://github.com/your-username/bus-ticket.git
   cd bus-ticket
   ```

2. **Create the database**  

   ```sql
   -- In MySQL client or phpMyAdmin
   SOURCE Database/bus_db.sql;
   ```

3. **Configure database connection**  

   Edit `config.php` (and `admin/config.php` if you keep a separate admin config) and replace the placeholders with your credentials:

   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'bus_db');
   define('DB_USER', 'your_db_user');
   define('DB_PASS', 'your_db_password');
   ```

4. **Set up the web server**  

   - Place the project in your web root (e.g., `/var/www/html/bus-ticket`).  
   - Ensure the server has write permissions for any upload or log directories (none required for the core app).  
   - Enable PHP processing and restart Apache/Nginx.

5. **Optional – Configure EasyPaisa**  

   Replace the placeholder in `easy_paisa_payment.php` with your actual API key:

   ```php
   $apiKey = 'YOUR_OWN_API_KEY';
   ```

6. **Visit the site**  

   - Admin portal: `http://your-domain/bus-ticket/admin/admin_login.php`  
   - User portal: `http://your-domain/bus-ticket/index.php`

---

## Usage

### Admin

1. **Log in** using the credentials created in the `admin` table (default admin
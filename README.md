# Inventory Management System

A comprehensive, robust, and secure Inventory Management System built with **Laravel 10**, designed to streamline your business operations. This application provides real-time tracking, customer management, invoicing, and detailed sales reporting, entirely powered by an AJAX-driven frontend and a solid backend architecture.

## 🚀 Features

### User Authentication & Security
- **Secure Authentication:** JWT-based token authentication using a custom middleware.
- **Role & Access Control:** Protected routes to ensure data privacy.
- **OTP Verification:** Enhanced security with One-Time Password verification and password reset functionality.
- **Profile Management:** View and update user profiles.

### Core Inventory Management
- **Dashboard:** At-a-glance summary of total sales, products, customers, and overall business metrics.
- **Product Management:** Complete CRUD operations for products.
- **Category Matrix:** Organize products seamlessly using categories.
- **Customer Directory:** Track customer details efficiently.

### Sales & Invoicing
- **Point of Sale (POS):** Intuitive interface to select customers and add products to an invoice.
- **PDF Generation:** Instantly generate professional PDF invoices and reports using DOMPDF.
- **Sales Reporting:** Filter sales by date range to generate analytical PDF reports.

## 🛠️ Tech Stack

**Backend**
- PHP 8.1+
- Laravel 10.x
- MySQL Database
- Firebase PHP-JWT (Token generation and verification)
- Barryvdh Laravel DOMPDF (PDF generation)

**Frontend**
- Laravel Blade Templates (Component-based architecture)
- Axios (AJAX Requests for seamless API interactions)
- Vite (Asset bundling)
- HTML & CSS with Bootstrap/Tailwind (Based on project styling conventions)

## 📁 Project Architecture

- **`app/Http/Controllers`**: Contains the core logic for Users, Products, Categories, Customers, Invoices, and Reports.
- **`app/Http/Middleware/TokenVerificationMiddleware`**: Custom JWT token verification layer for secure routes.
- **`resources/views`**: Component-oriented Blade views separated into layouts, pages, components, and reports.
- **`routes/web.php`**: Defines the application endpoints (both page views and AJAX-powered API routes).
- **`database/migrations`**: Defines schema tables for users, products, categories, customers, and invoices.

## 📦 Installation Guide

Follow these steps to run the project on your local machine.

### Prerequisites
Make sure you have the following installed on your system:
- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL

### Step-by-Step Installation

1. **Clone the Repository**
   ```bash
   git clone <your-repo-url>
   cd inventory-management-system
   ```

2. **Install PHP Dependencies**
   ```bash
   composer install
   ```

3. **Install NPM Packages**
   ```bash
   npm install
   ```

4. **Environment Configuration**
   Copy the example `.env` file and set up your database credentials:
   ```bash
   cp .env.example .env
   ```
   Open the `.env` file and configure your database settings:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

6. **Run Database Migrations**
   ```bash
   php artisan migrate
   ```

7. **Compile Frontend Assets**
   ```bash
   npm run build
   # or for development: npm run dev
   ```

8. **Start the Local Development Server**
   ```bash
   php artisan serve
   ```

Now, open your browser and access the application at `http://127.0.0.1:8000`.


## 📜 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

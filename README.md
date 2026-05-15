# ABS - Attendance & Employee Management System

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-13.x-red?style=for-the-badge&logo=laravel" alt="Laravel Version">
  <img src="https://img.shields.io/badge/PHP-8.3-blue?style=for-the-badge&logo=php" alt="PHP Version">
  <img src="https://img.shields.io/badge/Tailwind-CSS-3.x?style=for-the-badge&logo=tailwind-css" alt="Tailwind Version">
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="License">
</p>

## Overview

**ABS (Attendance & Employee Management System)** is a comprehensive, production-ready web application for managing employee attendance, leaves, payroll, and reimbursements. Built with Laravel 13, Tailwind CSS, and Alpine.js.

## Features

### 👨‍💼 Employee Panel
- **Smart Attendance** - Check-in/check-out with GPS location tracking
- **Leave Management** - Request leaves with date range and reason
- **Reimbursements** - Submit expense claims with approval workflow
- **Payroll View** - View salary slips and payment history
- **Announcements** - Stay updated with company announcements

### 👥 HR Panel
- **Attendance Monitoring** - View all employee attendance records
- **Leave Approval** - Approve or reject leave requests
- **Reimbursement Approval** - Process employee expense claims
- **Payroll Management** - View and manage payroll records

### ⚙️ Admin Panel
- **User Management** - Create, edit, and manage employee accounts
- **Department Management** - Organize employees by department
- **Role & Permission System** - Granular access control
- **Shift Management** - Configure work schedules and shifts
- **Location Management** - Manage office locations for attendance
- **Holiday Calendar** - Set company holidays
- **Salary Rules** - Configure salary calculation rules
- **Overtime Rules** - Define overtime policies
- **System Settings** - Configure application settings
- **Reports & Analytics** - Dashboard with key metrics

## Technology Stack

- **Backend:** Laravel 13.x (PHP 8.3)
- **Frontend:** Tailwind CSS 3.x, Alpine.js
- **Database:** MySQL
- **Authentication:** Laravel Breeze
- **Icons:** Font Awesome 6.x

## Installation

### Prerequisites
- PHP 8.3+
- Composer
- Node.js 18+
- MySQL 8.0+

### Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd abs
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install NPM dependencies**
   ```bash
   npm install
   ```

4. **Configure environment**
   ```bash
   cp .env.example .env
   # Edit .env with your database credentials
   ```

5. **Generate application key**
   ```bash
   php artisan key:generate
   ```

6. **Run migrations**
   ```bash
   php artisan migrate
   ```

7. **Build frontend assets**
   ```bash
   npm run build
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   ```

## Default Roles

| Role | Description |
|------|-------------|
| Admin | Full system access |
| HR | HR management and approvals |
| Employee | Standard user access |

## Default Admin Credentials

After running migrations, create an admin user through the registration page or database seeder.

## Project Structure

```
abs/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/       # Admin panel controllers
│   │   ├── HR/          # HR panel controllers
│   │   ├── Employee/    # Employee panel controllers
│   │   └── Auth/        # Authentication controllers
│   ├── Models/          # Eloquent models
│   └── Providers/       # Service providers
├── resources/views/
│   ├── admin/           # Admin panel views
│   ├── hr/              # HR panel views
│   ├── employee/        # Employee panel views
│   └── layouts/         # Shared layouts
├── routes/
│   ├── web.php          # Main routes
│   └── auth.php         # Authentication routes
└── database/
    ├── migrations/      # Database migrations
    └── seeders/         # Database seeders
```

## Security Features

- Role-based access control (RBAC)
- Password hashing with bcrypt
- CSRF protection
- XSS protection
- SQL injection prevention
- Account status management (active/inactive)

## Production Deployment

1. Set `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false` in `.env`
3. Run `php artisan config:cache`
4. Run `php artisan view:cache`
5. Configure web server (Apache/Nginx)

## Screenshots

The system includes:
- Professional landing page with features
- Three distinct dashboard panels (Admin, HR, Employee)
- Clean, modern UI with gradient styling
- Responsive design for mobile and tablet

## License

This project is licensed under the MIT License.

## Support

For issues and feature requests, please create an issue on GitHub.

---

<p align="center">Built with ❤️ using Laravel</p>
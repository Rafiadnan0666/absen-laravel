# ABS - Attendance & Employee Management System

<p align="center">
  <img src="adminscreen.png" alt="Admin Dashboard" width="600"/>
  <img src="hrscreen.png" alt="HR Panel" width="600"/>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-13.x-red?style=for-the-badge&logo=laravel" alt="Laravel Version">
  <img src="https://img.shields.io/badge/PHP-8.3-blue?style=for-the-badge&logo=php" alt="PHP Version">
  <img src="https://img.shields.io/badge/Tailwind-CSS-3.x?style=for-the-badge&logo=tailwind-css" alt="Tailwind Version">
  <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql" alt="MySQL">
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="License">
</p>

## Overview

**ABS (Attendance & Employee Management System)** is a comprehensive web application for managing employee attendance, leaves, payroll, and reimbursements. Built with Laravel 13, Tailwind CSS, Alpine.js, and Leaflet for GPS location tracking.

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 13.x (PHP 8.3) |
| Frontend | Tailwind CSS 3.x, Alpine.js 3.x |
| Database | MySQL 8.0+ |
| Maps | Leaflet.js (OpenStreetMap) |
| Auth | Laravel Breeze + Fortify |
| Icons | Font Awesome 7.0.1 |

## Architecture

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
│   ├── admin/           # Admin panel views (Blade)
│   ├── hr/              # HR panel views
│   ├── employee/        # Employee panel views
│   └── layouts/         # Shared layouts
├── routes/
│   ├── web.php          # Main routes
│   └── auth.php         # Authentication routes
├── database/
│   ├── migrations/      # 28 migration files
│   └── seeders/         # Database seeders
├── tests/               # PHPUnit tests
└── public/
    ├── assets/          # CSS, JS, images
    └── build/           # Compiled assets
```

**Architecture pattern:** MVC with Blade templates, resource controllers, and service-based authorization (role-based access via middleware).

## Features

### Employee Panel
- **Smart Attendance** - Check-in/check-out with GPS location tracking via Leaflet maps
- **Leave Management** - Request leaves with date range and reason
- **Reimbursements** - Submit expense claims with approval workflow
- **Payroll View** - View salary slips and payment history
- **Announcements** - Stay updated with company announcements

### HR Panel
- **Attendance Monitoring** - View all employee attendance records
- **Leave Approval** - Approve or reject leave requests
- **Reimbursement Approval** - Process employee expense claims
- **Payroll Management** - View and manage payroll records

### Admin Panel
- **User Management** - Create, edit, and manage employee accounts
- **Department Management** - Organize employees by department
- **Role & Permission System** - Granular access control (Admin, HR, Employee)
- **Shift Management** - Configure work schedules and shifts
- **Location Management** - Manage office locations for attendance
- **Holiday Calendar** - Set company holidays
- **Salary Rules** - Configure salary calculation rules
- **Overtime Rules** - Define overtime policies
- **System Settings** - Configure application settings
- **Dashboard Analytics** - Key metrics and reports

## Setup Instructions

### Prerequisites
- PHP 8.3+
- Composer 2.x
- Node.js 18+
- MySQL 8.0+

### Installation

```bash
git clone https://github.com/Rafiadnan0666/absen-laravel.git
cd absen-laravel

# Install dependencies
composer install
npm install

# Configure environment
cp .env.example .env
php artisan key:generate

# Database - edit .env with your MySQL credentials
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=abs_laravel
# DB_USERNAME=root
# DB_PASSWORD=

# Run migrations
php artisan migrate

# Build frontend
npm run build

# Start server
php artisan serve
```

Visit `http://localhost:8000`

## Screenshots

| Admin Dashboard | HR Panel |
|----------------|----------|
| ![Admin Screen](adminscreen.png) | ![HR Screen](hrscreen.png) |

| Attendance | Departments |
|-----------|-------------|
| ![Attendance](attendance.png) | ![Departments](departments.png) |

| Employee Screen | Records |
|----------------|---------|
| ![Employee](employeescreen.png) | ![Records](records.png) |

## Default Roles

| Role | Access Level |
|------|-------------|
| Admin | Full system access |
| HR | HR management and approvals |
| Employee | Standard user access |

## Known Limitations

- **No JWT/OAuth** - Session-based auth only; no API token authentication
- **No pagination** - List endpoints return all records (no pagination)
- **No rate limiting** - No request throttling on public routes
- **GPS tolerance** - Location check-in uses fixed radius; no configurable tolerance
- **Single-file config** - Some business logic is in controllers rather than services
- **No email queue** - Mail sent synchronously; no background processing
- **Neo-brutalism design** - Heavy CSS shadows may not render consistently on all devices
- **No 2FA** - No two-factor authentication implemented
- **Payroll confirmation** - Payroll status changes are manual; no automated confirmation workflow

## CI/CD

GitHub Actions runs daily at 06:00 UTC and on every push to `main`:
- Install dependencies (`composer install`, `npm install`)
- Setup MySQL database
- Run migrations
- Run PHPUnit tests
- Report PASS / FAIL

See `.github/workflows/test.yml` for the pipeline configuration.

## License

MIT License.

## Support

For issues and feature requests, please create an issue on GitHub.
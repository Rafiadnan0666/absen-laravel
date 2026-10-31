# ABS - Attendance & Employee Management System

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-13.x-red?style=for-the-badge&logo=laravel" alt="Laravel Version">
  <img src="https://img.shields.io/badge/PHP-8.3-blue?style=for-the-badge&logo=php" alt="PHP Version">
  <img src="https://img.shields.io/badge/Tailwind-CSS-3.x?style=for-the-badge&logo=tailwind-css" alt="Tailwind Version">
  <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql" alt="MySQL">
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="License">
</p>

## Overview

**ABS (Attendance & Employee Management System)** is a comprehensive, production-ready web application for managing employee attendance, leaves, payroll, and reimbursements. Built with Laravel 13, Tailwind CSS, Alpine.js, and Leaflet for GPS location tracking.

## Table of Contents

- [Features](#features)
- [Quick Start](#quick-start)
- [Setup Workflow](#setup-workflow)
- [Admin Panel Setup Guide](#admin-panel-setup-guide)
- [Technology Stack](#technology-stack)
- [Database Schema (ERD)](#database-schema-erd)
- [Installation](#installation)
- [Default Roles](#default-roles)
- [Project Structure](#project-structure)
- [Security Features](#security-features)
- [Production Deployment](#production-deployment)
- [Known Limitations](#known-limitations)
- [License](#license)

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
- **Location Management** - Manage office locations with GPS coordinates (Leaflet map picker)
- **Holiday Calendar** - Set company holidays
- **Salary Rules** - Configure salary calculation rules
- **Overtime Rules** - Define overtime policies
- **System Settings** - Configure application settings
- **Dashboard Analytics** - Key metrics and reports

## Quick Start

```bash
# Clone and setup
git clone https://github.com/Rafiadnan0666/absen-laravel.git
cd absen-laravel

# Install dependencies
composer install
npm install

# Configure environment
cp .env.example .env
# Edit .env with your database credentials

# Setup
php artisan key:generate
php artisan migrate
php artisan db:seed

# Build assets
npm run build

# Run server
php artisan serve

# Visit http://localhost:8000
# Login: admin@example.com / password
```

## Setup Workflow

### Initial System Configuration (Admin Only)

Follow this order to properly configure the system:

#### 1. **Create Departments** (Admin → Departments)
   - Create organizational departments (e.g., IT, HR, Finance)
   - Example: "IT Department", "Human Resources"
   - Employees will be assigned to these departments

#### 2. **Create Job Titles** (Admin → Job Titles)
   - Define job positions (e.g., Developer, Manager, Analyst)
   - Example: "Senior Developer", "HR Manager"
   - Used for employee profile and organizational structure

#### 3. **Create Shifts** (Admin → Shifts)
   - Define work schedules (e.g., Morning 08:00-17:00, Night 20:00-05:00)
   - Set break times if needed
   - Example:
     - Morning Shift: 08:00 - 17:00 (1 hour lunch)
     - Evening Shift: 14:00 - 23:00

#### 4. **Create Office Locations** (Admin → Locations)
   - Add office/check-in locations with GPS coordinates
   - **NEW: Use interactive Leaflet map picker**
     - Click on map to select coordinates
     - Search for address using Nominatim geocoder
     - Adjust radius (geo-fence area in meters)
   - Example: "Head Office Jakarta" at -6.2088, 106.8456 (Radius: 100m)
   - Employees must check-in within this radius

#### 5. **Create Salary Rules** (Admin → Salary Rules)
   - Define pay types and overtime rates
   - Required fields:
     - **Tipe Gaji**: hourly, daily, or monthly
     - **Rate Lembur**: Overtime multiplier (e.g., 1.5x for 1.5x pay)
     - **Penalti Telat Per Menit**: Late penalty per minute (e.g., Rp 10,000/minute)
     - **Penalti Tidak Hadir**: Absent penalty (e.g., Rp 500,000)
   - Example for Monthly:
     - Rate Lembur: 1.5
     - Penalti Telat: 10000
     - Penalti Tidak Hadir: 500000

#### 6. **Create Overtime Rules** (Admin → Overtime Rules)
   - Define overtime eligibility and calculation
   - Required fields:
     - **Minimal Jam**: Minimum hours to trigger overtime (e.g., 8.5)
     - **Multiplier**: Overtime pay multiplier (e.g., 1.5 for 1.5x)
   - Example: "Any work > 8.5 hours = 1.5x pay"

#### 7. **Create Holidays** (Admin → Holidays)
   - Add national/company holidays
   - Example: "Idul Fitri", "Christmas", "New Year"
   - These are excluded from attendance calculations

#### 8. **Create Employees** (Admin → Users)
   - Add employee accounts with required fields:
     - **Nama Lengkap**: Full name
     - **Email**: Unique login email
     - **Job Title**: Select from created job titles
     - **Department**: Select from created departments
     - **Tipe Gaji**: salary type (hourly, daily, monthly)
     - **Jumlah Gaji**: Base salary amount
     - **Tanggal Masuk**: Join date
     - **No HP**: Phone number
     - **Alamat**: Address
   - Assign to **Employee** role
   - System auto-generates password (send to employee securely)

#### 9. **Create HR Users** (Admin → Users, same as step 8)
   - Create HR staff accounts
   - Assign to **HR** role
   - HR can approve leaves and reimbursements

#### 10. **Assign Shifts to Employees** (Admin → User Shifts)
   - Link employees to their work shifts
   - Example: Developer assigned to Morning Shift (08:00-17:00)
   - Can assign multiple shifts for rotation schedules

### Employee Operations

#### Attendance Workflow
1. **Check-in** (Employee Panel)
   - Click "Check In" button
   - System gets GPS location automatically (requires location permission)
   - Verify location is within allowed office location radius
   - Check-in time and location recorded

2. **Check-out** (Employee Panel)
   - Same as check-in
   - System calculates:
     - Work hours (check-out time - check-in time)
     - Lateness minutes (if after shift start)
     - Overtime hours (if > shift hours)

#### Leave Request Workflow
1. **Request Leave** (Employee → Leaves)
   - Fill form:
     - Leave type: Sick, Annual, Unpaid
     - Start date, end date
     - Reason
   - Status: Pending (awaits HR approval)

2. **HR Approves/Rejects** (HR → Leaves)
   - Review pending leave requests
   - Approve: Employee gets leave days (deducted from quota)
   - Reject: Employee retains quota

#### Reimbursement Request Workflow
1. **Submit Reimbursement** (Employee → Reimbursements)
   - Fill form:
     - Category (e.g., Transportation, Meals, Office)
     - Amount in Rupiah
     - Description
   - Status: Pending

2. **HR Approves/Rejects** (HR → Reimbursements)
   - Review pending claims
   - Approve: Amount added to next payroll
   - Reject: Declined without payment

### Payroll Processing

#### Prerequisites
- ✅ All salary rules configured
- ✅ All employees have salary type and amount set
- ✅ Attendance records exist for the period
- ✅ Overtime rules configured

#### Payroll Calculation Steps
1. **System Auto-Calculates:**
   - **Gaji Pokok** (Base): Employee's fixed salary
   - **Total Lembur** (Overtime): Calculated from attendance + overtime rules
     - Formula: (Overtime Hours × Hourly Rate × Multiplier)
   - **Total Potongan** (Deductions):
     - Late penalties: Menit Telat × Penalti per menit
     - Absent penalties: Days absent × Penalti tidak hadir
   - **Bonus**: Manually added by HR/Admin
   - **Total Gaji** (Net): Pokok + Lembur + Bonus - Potongan

2. **Create Payroll** (Admin → Payrolls)
   - Define period (start date - end date)
   - System pulls all attendance for that period
   - Creates payroll details breakdown:
     - Base salary detail
     - Overtime detail (per employee)
     - Penalty details (late, absent)
     - Bonus detail
   - Status: Pending

3. **Approve Payroll** (Admin → Payrolls)
   - Review payroll calculations
   - Change status to Paid
   - System locks payroll from further edits

4. **View Payroll** (Employee → Payroll)
   - Employee sees their payslip
   - Shows breakdown of all components
   - Can download/print

## Admin Panel Setup Guide

### Dashboard
- **Real-time metrics**: Total users, departments, attendances, leaves, payrolls
- **Charts**: Weekly/monthly attendance trends, department distribution
- **Recent records**: Latest attendance, leaves, reimbursements

### Users Management
- **List/Filter**: Search by name, department, status (active/inactive)
- **Create**: Add new employees with full details
- **Edit**: Update employee information
- **Delete**: Deactivate accounts (soft delete recommended)

### Departments
- **List**: View all departments
- **Create**: Add new department with name
- **Edit**: Update department details
- **Dashboard**: See employees per department

### Shifts
- **List**: View all configured shifts
- **Create**: Add work shift with:
  - Shift name (Morning, Evening, Night)
  - Start time, end time
  - Break duration
- **Edit**: Modify shift times

### Locations
- **List**: View all office locations
- **Create**: Add location with:
  - Name
  - **Interactive Map**: Click map or search address to set coordinates
  - Radius in meters (geo-fence)
- **Edit**: Modify location and radius using map

### Attendance
- **View**: All attendance records
- **Filter**: By date, department, status, employee
- **Edit**: Modify attendance if errors occurred
- **Export**: Download attendance report as CSV

### Leaves
- **View**: All leave requests
- **Filter**: By date, type, status
- **Approve/Reject**: Bulk actions available
- **Edit**: Update leave records

### Payrolls
- **View**: All payroll periods
- **Create**: New payroll period (start-end dates)
- **Calculate**: System auto-calculates based on attendance
- **Approve**: Change status to Paid
- **Details**: View payroll component breakdown

### Salary Rules
- **Configure**: Pay types (hourly, daily, monthly)
- **Set**: Overtime rates, late penalties, absent penalties
- **Edit**: Modify rules as needed

### Overtime Rules
- **Set**: Minimum hours for overtime eligibility
- **Set**: Overtime pay multiplier

### Holidays
- **Add**: National/company holidays
- **Exclude**: These days don't count as absent

## Technology Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 13.x (PHP 8.3) |
| Frontend | Tailwind CSS 3.x, Alpine.js 3.x |
| Maps | Leaflet.js (OpenStreetMap) with Nominatim Geocoder |
| Database | MySQL 8.0+ |
| Authentication | Laravel Breeze + Sanctum |
| Icons | Font Awesome 7.0.1 |
| Build | Vite 5.x |
| Charts | Chart.js 4.x |

## Database Schema (ERD)

See [ERD.md](ERD.md) for the complete Entity Relationship Diagram with Mermaid visualization.

### Key Tables
- **users** - Core user table with profile, employment, and auth info
- **departments** - Organizational departments
- **job_titles** - Job positions/titles
- **roles** - User roles (Admin, HR, Employee)
- **attendances** - Daily attendance records
- **attendance_logs** - Detailed check-in/out logs with GPS
- **leaves** - Leave requests and approvals
- **payrolls** - Payroll periods and totals
- **payroll_details** - Payroll component breakdown
- **reimbursements** - Expense claims
- **locations** - Office locations for GPS check-in
- **shifts** - Work shift definitions
- **salary_rules** - Salary calculation rules
- **overtime_rules** - Overtime calculation rules
- **holidays** - Company holidays

## Installation

### Prerequisites
- PHP 8.3+
- Composer 2.x
- Node.js 18+
- MySQL 8.0+

### Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/Rafiadnan0666/absen-laravel.git
   cd absen-laravel
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
   ```
   
   Edit `.env` with your database credentials:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=abs
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

5. **Generate application key**
   ```bash
   php artisan key:generate
   ```

6. **Run migrations**
   ```bash
   php artisan migrate
   ```

7. **(Optional) Seed database with sample data**
   ```bash
   php artisan db:seed
   ```

8. **Build frontend assets**
   ```bash
   npm run build
   ```

9. **Start the development server**
   ```bash
   php artisan serve
   ```

10. **Access the application**
    - Visit: `http://localhost:8000`
    - Admin Login: `admin@example.com` / `password`
    - HR Login: `hr@example.com` / `password`
    - Employee Login: `employee@example.com` / `password`

## Default Roles

| Role | Access Level | Can Do |
|------|-------------|--------|
| Admin | Full system access | Manage all config, users, attendance, payroll, reports |
| HR | HR operations | Approve leaves, reimbursements, view payroll, manage attendance |
| Employee | Standard user | Check-in/out, request leave, submit reimbursement, view payroll |

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
│   ├── components/      # Reusable Blade components
│   └── layouts/         # Shared layouts
├── routes/
│   ├── web.php          # Main routes
│   └── auth.php         # Authentication routes
├── database/
│   ├── migrations/      # Database migrations (24 files)
│   └── seeders/         # Database seeders
├── tests/               # PHPUnit tests (12 test files, 66+ passing)
└── public/
    ├── assets/          # CSS, JS, images
    └── build/           # Compiled assets (Vite)
```

**Pattern:** MVC with Blade templates, resource controllers, and service-based authorization (role-based access via middleware).

## Security Features

- Role-based access control (RBAC)
- Password hashing with bcrypt
- CSRF protection
- XSS protection via Blade escaping
- SQL injection prevention via Eloquent ORM
- Account status management (active/inactive)
- Session-based authentication
- Location-based attendance verification
- Audit logging for sensitive operations

## Production Deployment

1. **Configure environment**
   ```bash
   # In .env file
   APP_ENV=production
   APP_DEBUG=false
   DB_PASSWORD=strong_password_here
   ```

2. **Optimize Laravel**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan optimize
   ```

3. **Configure web server**
   
   For Apache, ensure `.htaccess` is configured properly. For Nginx, configure your server block to point to the `public` directory.

4. **Set proper permissions**
   ```bash
   chmod -R 775 storage bootstrap/cache
   chown -R www-data:www-data storage bootstrap/cache
   ```

5. **Setup HTTPS**
   ```bash
   # Using Let's Encrypt with Certbot
   sudo certbot certonly --webroot -w /var/www/html -d yourdomain.com
   ```

## Known Limitations

| Limitation | Impact | Workaround |
|------------|--------|------------|
| **No JWT/OAuth** | Session-based auth only; no API token authentication | Add API token middleware for mobile apps |
| **No pagination** | List endpoints return all records | Add pagination to controllers |
| **No rate limiting** | No request throttling on public routes | Add rate limiter middleware |
| **GPS tolerance** | Location check-in uses fixed radius | Make tolerance configurable per location |
| **Single-file config** | Some business logic in controllers | Extract to service classes |
| **No email queue** | Mail sent synchronously | Configure queue worker with Redis |
| **Neo-brutalism design** | Heavy CSS shadows may not render consistently | Test on target devices/browsers |
| **No 2FA** | No two-factor authentication | Add 2FA package (Fortify supports this) |
| **Payroll confirmation** | Manual status changes only | Add automated workflow trigger |

## Test Suite

Run tests to verify system integrity:

```bash
# All tests
php artisan test

# Specific test file
php artisan test tests/Feature/PayrollCalculationTest.php

# With coverage
php artisan test --coverage
```

**Current Status:** 66 passing, 8 failing (pre-existing Breeze tests for email verification)

## License

MIT License - See LICENSE file for details

## Support

For issues and feature requests, please create an issue on GitHub.

---

**Last Updated:** November 1, 2026
**Version:** 1.0.0
**Branches:** `main` (standard UI), `interface/neurobrutalism` (neo-brutalism design)

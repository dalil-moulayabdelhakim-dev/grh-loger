# Shift & Transaction Management System

A Laravel-based management system for tracking employee shifts and financial transactions with role-based access control and automated verification workflows.

## Overview

This application provides a comprehensive platform for managing:
- **Shifts**: Track employee work shifts with date, time, and verification status
- **Transactions**: Record financial transactions with amounts, types, dates, and verification status
- **Users**: Manage user accounts with role-based access (e.g., employees, managers, approvers)

The system includes automated email notifications for shift requests, approvals, rejections, and transaction verification events.

## Features

### Core Functionality
- User authentication and authorization with role-based access control
- Complete shift management (create, read, update, delete)
- Transaction tracking with multiple transaction types
- Verification workflow for shifts and transactions
- Dashboard views tailored to user roles

### Notifications
- Shift creation notifications
- Shift approval/rejection emails
- Transaction verification notifications
- Multi-record verification confirmation emails
- Record deletion notifications
- GRH (Human Resources) verification emails

### Frontend
- Responsive UI built with Tailwind CSS
- Modern JavaScript with Vite bundler
- Component-based Vue/Blade architecture

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js 18+ (for frontend bundling)
- SQLite/MySQL/PostgreSQL (configured in `.env`)
- Laravel 11.x

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd handler
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install frontend dependencies**
   ```bash
   npm install
   ```

4. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database** in `.env`:
   ```
   DB_CONNECTION=sqlite
   DB_DATABASE=database/database.sqlite
   ```

6. **Run migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```

7. **Build frontend assets**
   ```bash
   npm run build
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   npm run dev
   ```

## Database Schema

### Users Table
- `id`: Primary key
- `name`: User name
- `email`: User email (unique)
- `password`: Hashed password
- `role`: User role (employee, manager, approver, admin)
- `timestamps`: Created and updated timestamps

### Shifts Table
- `id`: Primary key
- `user_id`: Foreign key to users
- `date`: Shift date
- `time`: Shift time
- `verified`: Boolean flag (0 = pending, 1 = verified)
- `timestamps`: Created and updated timestamps

### Transactions Table
- `id`: Primary key
- `user_id`: Foreign key to users
- `amount`: Transaction amount (decimal)
- `type`: Transaction type (e.g., income, expense, transfer)
- `date`: Transaction date
- `time`: Transaction time
- `verified`: Boolean flag (0 = pending, 1 = verified)
- `timestamps`: Created and updated timestamps

## Models & Relationships

### User
```php
User::hasMany(Shift::class)
User::hasMany(Transaction::class)
```

### Shift
```php
Shift::belongsTo(User::class)
```

### Transaction
```php
Transaction::belongsTo(User::class)
```

## Authentication & Authorization

- Login page for user authentication
- Role-based access control via middleware
- Password reset functionality
- Profile management per user
- Session-based authentication

## Controllers

- **DashboardController**: Main dashboard and overview
- **ManagerController**: Manager-level operations and approvals
- **ProfileController**: User profile management
- **Auth Controllers**: Authentication logic under `Auth/` directory

## Testing

The project uses Pest testing framework:

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test tests/Feature
php artisan test tests/Unit
```

Test files are organized in:
- `tests/Feature/`: Feature tests for user workflows
- `tests/Unit/`: Unit tests for models and business logic

## Configuration

Key configuration files:
- `config/app.php`: Application settings
- `config/database.php`: Database configuration
- `config/auth.php`: Authentication configuration
- `config/mail.php`: Email configuration
- `config/queue.php`: Job queue configuration

## Frontend Build

- **CSS**: Tailwind CSS with PostCSS (see `tailwind.config.js`)
- **JavaScript**: Vite bundler (see `vite.config.js`)
- **Assets**: Built to `public/build/`

Build commands:
```bash
npm run dev        # Development build with watch mode
npm run build      # Production build
```

## File Structure

```
app/
  ├── Console/Commands/     # Artisan commands
  ├── Http/
  │   ├── Controllers/      # Application controllers
  │   ├── Middleware/       # HTTP middleware
  │   └── Requests/         # Form request validation
  ├── Mail/                 # Mailable classes
  └── Models/               # Eloquent models

database/
  ├── migrations/           # Database migrations
  ├── seeders/             # Database seeders
  └── factories/           # Model factories (testing)

resources/
  ├── css/                 # Stylesheets
  ├── js/                  # JavaScript
  └── views/               # Blade templates

routes/
  ├── web.php             # Web routes
  ├── auth.php            # Auth routes
  └── console.php         # Console/command routes

tests/
  ├── Feature/            # Feature tests
  ├── Unit/               # Unit tests
  └── TestCase.php        # Test base class
```

## Environment Variables

Key `.env` variables to configure:

```
APP_NAME=Shift & Transaction Manager
APP_DEBUG=false
APP_KEY=
APP_URL=http://localhost

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_ADDRESS=

QUEUE_CONNECTION=database
```

## Common Tasks

### Create a New Migration
```bash
php artisan make:migration create_table_name
```

### Create a New Model
```bash
php artisan make:model ModelName -m
```

### Generate Test Files
```bash
php artisan make:test Feature/FeatureNameTest
```

### Send Test Email
```bash
php artisan tinker
Mail::raw('Test', fn($mail) => $mail->to('user@example.com'));
```

## Support

For issues and questions:
1. Check existing documentation
2. Review test files for usage examples
3. Consult Laravel documentation: https://laravel.com/docs

## License

This project is open-source software licensed under the MIT license.

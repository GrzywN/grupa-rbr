# Todo List Application

Modern task management application built with Laravel 11, featuring email notifications and task sharing.

![Application Demo](demo.gif)

## Features

### Core Functionality
- Full CRUD operations for tasks
- Priority-based task organization (low/medium/high)
- Status tracking (to-do/in progress/done)
- Email notifications for upcoming deadlines
- Multi-user support with authentication
- Task filtering by priority, status and deadline (WIP)

### Advanced Features
- Complete task edit history
- Shareable task links with expiring tokens
- Google Calendar integration (WIP)
- Docker support for easy deployment

## Tech Stack

### Backend
- Laravel 11 with PHP 8.2+
- MySQL Database
- Laravel Sanctum for API authentication
- Laravel Breeze for authentication scaffolding
- Inertia.js for server-side routing
- Soft Deletes with cascading support

### Frontend
- Vue.js 3.5 with TypeScript
- Inertia.js for server-side routing and authentication
- Axios for API requests
- PrimeVue 4.2 for UI components
- Tailwind CSS for styling
- Vite for asset bundling
- VeeValidate with Yup for form validation
- Vue Query for data fetching
- Luxon for date handling
- Phosphor Icons

### Development Tools
- Docker with Laravel Sail
- PHPStan for static analysis
- Laravel Pint for PHP styling
- ESLint & Prettier for JS/TS/Vue formatting
- Husky for Git hooks
- Rector for automated refactoring
- Laravel IDE Helper for better IDE support
- Ziggy for type-safe route handling
- Makefile for common development tasks

## Requirements

- PHP 8.2+
- Composer
- Node.js 18.20.5+
- Docker (optional)
- MySQL

## Quick Start

### Requirements

- Docker

### Using Docker

0. Make sure you have docker installed and ports are available
```bash
docker -v
systemctl restart docker
```

1. Clone and build
```bash
git clone https://github.com/GrzywN/grupa-rbr.git
cd grupa-rbr
make build
```

2. Start development environment
```bash
make up
```

The application will be available at `http://localhost`.
PHPMyAdmin will be available at `http://localhost:8050`.
Mailpit will be available at `http://localhost:8025`.

### Manual Installation

1. Clone the project

```bash
git clone https://github.com/GrzywN/grupa-rbr.git
```

2. Go to the project directory

```bash
cd grupa-rbr
```

3. Copy environmental config

```bash
cp .env.example .env
```

4. Change docker context to default (for linux users)

```bash
docker context use default
```

5. Install laravel dependencies

```bash
docker run --rm \
  -u "$(id -u):$(id -g)" \
  -v "$(pwd):/var/www/html" \
  -w /var/www/html \
  laravelsail/php83-composer:latest \
  composer install --ignore-platform-reqs
```

Start the server

```bash
./vendor/bin/sail up -d
```

Generate application key

```bash
./vendor/bin/sail artisan key:generate
```

Clear cached configuration

```bash
./vendor/bin/sail artisan optimize:clear
```

Link storage

```bash
./vendor/bin/sail artisan storage:link
```

Run migrations and seeders

```bash
./vendor/bin/sail artisan migrate:fresh --seed
```

Run tests to ensure everything is working fine 🎉

```bash
./vendor/bin/sail artisan test
```

To stop the server simply run

```bash
./vendor/bin/sail stop
```

## Development Commands

```bash
# Code Quality
make lint          # Run PHP and JS/TS linting
make analyse       # Run static analysis
make format        # Format code
make refactor      # Run automated refactoring
make test          # Run all tests

# Documentation
make doc           # Generate IDE helper files

# Pre-commit checks
make pre-commit    # Run all checks before committing
```

## Configuration

### Email Settings

Update `.env` with your email configuration:
```
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
```

## Testing

Run the test suite:
```bash
./vendor/bin/sail artisan test
```

## Task Scheduling

To enable email notifications, add this to your crontab:
```bash
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

## License

This project is open-sourced software licensed under the MIT license.

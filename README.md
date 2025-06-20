# 🧾 Laravel Expense Module

![Laravel Version](https://img.shields.io/badge/Laravel-10.x-%23FF2D20)
![PHP Version](https://img.shields.io/badge/PHP-8.1+-%23777BB4)
![Tests](https://img.shields.io/badge/Tests-Passing-brightgreen)

A complete expense management system for Laravel applications with API endpoints, real-time notifications, and robust reporting.

## ✨ Features

- **REST API** - Full CRUD operations
- **Multi-channel Notifications** - Database & email
- **Soft Deletes** - Archive instead of delete
- **Validation** - Dedicated request classes
- **Testing** - 90%+ test coverage
- **Documentation** - Auto-generated OpenAPI specs

## 🛠️ Installation

### Requirements
- PHP 8.1+
- Laravel 10.x
- Database (MySQL/PostgreSQL/SQLite)

```bash
php artisan migrate

# 4. Configure .env
EXPENSE_NOTIFICATIONS_ENABLED=true
EXPENSE_DB_NOTIFICATIONS=true
EXPENSE_EMAIL_NOTIFICATIONS=false

## Time spent
6 Hours
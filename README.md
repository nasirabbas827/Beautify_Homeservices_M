# Beautify

Beautify_Homeservices_M is a home beauty-service booking application.

![PHP](https://img.shields.io/badge/PHP-2563EB?style=flat-square) ![MySQL](https://img.shields.io/badge/MySQL-0F172A?style=flat-square)

## Overview

The data model covers `admin`, `appointments`, `appointment_services`, `faqs`, `services`, `service_categories`, `service_subcategories`, `stories`, `users`.

## Application areas

| Area | Pages in the repository |
| --- | --- |
| Root Pages | [`about_us.php`](about_us.php), [`adminlogin.php`](adminlogin.php), [`book_now.php`](book_now.php), [`contact.php`](contact.php), [`dashboard.php`](dashboard.php) |
| Admin | [`admin/admin_add_category.php`](admin/admin_add_category.php), [`admin/admin_add_faq.php`](admin/admin_add_faq.php), [`admin/admin_add_service.php`](admin/admin_add_service.php), [`admin/admin_add_story.php`](admin/admin_add_story.php), [`admin/admin_add_subcategory.php`](admin/admin_add_subcategory.php) |

## Getting started

### 1. Get the project

```bash
git clone https://github.com/nasirabbas827/Beautify_Homeservices_M.git
cd Beautify_Homeservices_M
```

### 2. Configure PHP and the database

1. Use a local PHP server with MySQL or MariaDB, such as XAMPP.
2. Import [`Database/beautifym_db.sql`](Database/beautifym_db.sql) into your local database server.
3. Set your local database connection details in [`admin/config.php`](admin/config.php), [`config.php`](config.php).
4. Keep the existing asset and upload directory paths intact.

### 3. Start the application

With the database running, start a local development server from the repository root:

```bash
php -S 127.0.0.1:8000
```

Open http://127.0.0.1:8000/index.php. If using Apache/XAMPP instead, place the project in its document root and open the matching localhost folder.

## Repository guide

| Path | Purpose |
| --- | --- |
| [`CSS`](CSS) | Stylesheets |
| [`Database`](Database) | Database scripts |
| [`config.php`](config.php) | Application/database configuration |
| [`images`](images) | Image assets |
| [`index.php`](index.php) | Web entry page |

## Development notes

These setup instructions are based on the repository source. The application has not been executed as part of this documentation update; verify dependencies and configuration in your local environment.

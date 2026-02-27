# Laravel Invoice Manager

A single-user invoice management system built with Laravel 12. Create clients, generate professional invoices, send them via email, and track payment status — all from a clean, modern dashboard.

## Features

- **Client Management** — Add, edit, and organize your clients
- **Invoice Creation** — Create invoices with line items, taxes, and custom numbering
- **PDF Generation** — Download or email professional PDF invoices (powered by DomPDF)
- **Invoice Lifecycle** — Track statuses: Draft, Sent, Viewed, Paid, Overdue
- **Email Delivery** — Send invoices directly to clients via email
- **Recurring Invoices** — Automatically generate and send invoices on a schedule
- **Public Invoice Links** — Clients can view invoices via signed URLs (no login required)
- **Dashboard** — Overview of your invoicing activity at a glance
- **Business Settings** — Configure your company name, address, invoice prefix, and more

## Tech Stack

- **Backend:** PHP 8.2+, Laravel 12
- **Frontend:** Blade, Tailwind CSS 3, Alpine.js
- **PDF:** barryvdh/laravel-dompdf
- **Auth:** Laravel Breeze (registration disabled — single user)
- **Database:** SQLite (default)
- **Build:** Vite 7

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js & npm
- SQLite (or configure another database)

## Installation

```bash
# Clone the repository
git clone <your-repo-url>
cd laravelstarterinvoice

# Install PHP dependencies
composer install

# Install frontend dependencies
npm install

# Copy environment file and generate app key
cp .env.example .env
php artisan key:generate

# Create the SQLite database and run migrations
touch database/database.sqlite
php artisan migrate

# Build frontend assets
npm run build
```

## Create Your Admin Account

Registration is disabled. Create your account using the artisan command:

```bash
php artisan make:admin
```

You will be prompted for:
1. **Name** — Your display name
2. **Email** — Your login email
3. **Password** — Entered securely (hidden input)
4. **Confirm password** — Must match

After creation, log in at `/login`.

## Usage

### Starting the Development Server

```bash
# Start Laravel
php artisan serve

# In a separate terminal, start Vite for hot-reloading
npm run dev
```

Visit `http://localhost:8000` to access the application.

### Artisan Commands

| Command | Description |
|---|---|
| `php artisan make:admin` | Create a new admin user account |
| `php artisan invoices:send-recurring` | Generate and send recurring invoices for eligible clients |
| `php artisan invoices:mark-overdue` | Mark unpaid invoices past their due date as overdue |

### Scheduling (Production)

Add the Laravel scheduler to your crontab to automate recurring invoices and overdue detection:

```
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

Or run the scheduler in the foreground during development:

```bash
php artisan schedule:work
```

## Project Structure

```
app/
├── Console/Commands/
│   ├── CreateAdminUser.php         # make:admin command
│   ├── SendRecurringInvoices.php   # Recurring invoice automation
│   └── MarkOverdueInvoices.php     # Overdue invoice detection
├── Http/Controllers/
│   ├── DashboardController.php     # Dashboard
│   ├── ClientController.php        # Client CRUD
│   ├── InvoiceController.php       # Invoice CRUD, send, PDF, duplicate
│   ├── InvoicePublicController.php # Public invoice viewing
│   ├── SettingController.php       # Business settings
│   └── ProfileController.php       # User profile
├── Models/
│   ├── User.php
│   ├── Client.php
│   ├── Invoice.php
│   ├── InvoiceItem.php
│   ├── InvoiceActivity.php
│   └── Setting.php
├── Mail/
│   └── InvoiceSent.php             # Invoice email mailable
└── Services/
    └── InvoicePdfGenerator.php     # PDF generation service

routes/
├── web.php                         # Application routes
└── auth.php                        # Authentication routes (no registration)
```

## Key Routes

### Public
| Method | URI | Description |
|---|---|---|
| GET | `/` | Landing page |
| GET | `/login` | Login form |
| GET | `/invoices/{id}/view` | Public invoice view (signed URL) |

### Authenticated
| Method | URI | Description |
|---|---|---|
| GET | `/dashboard` | Dashboard overview |
| GET/POST | `/clients` | Client list / create |
| GET/PUT/DELETE | `/clients/{id}` | View / update / delete client |
| GET/POST | `/invoices` | Invoice list / create |
| GET/PUT/DELETE | `/invoices/{id}` | View / update / delete invoice |
| POST | `/invoices/{id}/send` | Email invoice to client |
| POST | `/invoices/{id}/mark-paid` | Mark invoice as paid |
| POST | `/invoices/{id}/duplicate` | Duplicate an invoice |
| GET | `/invoices/{id}/pdf` | Download invoice PDF |
| GET | `/settings` | Business settings |
| GET | `/profile` | User profile |

## Environment Configuration

Key `.env` variables to configure:

```env
APP_NAME="Your Business Name"
APP_URL=http://localhost:8000

# Mail (for sending invoices)
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_FROM_ADDRESS=your-email
MAIL_FROM_NAME="${APP_NAME}"
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

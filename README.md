# Product Management Assessment

A Laravel 11 based Product CRUD application with RESTful API and Admin Dashboard.

## Requirements

- PHP 8.3
- Docker & Docker Compose (Laravel Sail)
- MySQL

## Setup Instructions

1. **Install Dependencies**:
    ```bash
    composer install
    ```
2. **Setup Environment**:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
3. **Start Docker (Sail)**:
    ```bash
    ./vendor/bin/sail up -d
    ```
4. **Run Migrations & Seeders**:
    ```bash
    ./vendor/bin/sail artisan migrate:fresh --seed
    ```
    _An admin user is created by default: `admin@example.com` / `password`._

## API Endpoints

| Method | Endpoint                    | Description                                       |
| ------ | --------------------------- | ------------------------------------------------- |
| POST   | `/api/login`                | Get bearer token                                  |
| GET    | `/api/products`             | Paginated list (filters: `category_id`, `status`) |
| GET    | `/api/products/{id}`        | Product Details                                   |
| POST   | `/api/products`             | Create Product                                    |
| PUT    | `/api/products/{id}`        | Update Product                                    |
| DELETE | `/api/products/{id}`        | Soft Delete                                       |
| DELETE | `/api/products/bulk-delete` | Bulk Delete (`ids[]` array)                       |
| GET    | `/api/products/export`      | Export to Excel                                   |

## Features & Tech Stack

- **Laravel 11**: Core framework.
- **MySQL 8.0**: Database.
- **Sanctum**: API Authentication.
- **Excel Export**: Using `maatwebsite/excel`.
- **Admin Dashboard**: Built with Blade and Bootstrap 5.
- **Soft Deletes**: Enabled on Products.
- **Relationships**: `Category` hasMany `Product`.

## Testing

Run the feature tests to verify API functionality:

```bash
./vendor/bin/sail artisan test
```
# laravel-product-crud-application

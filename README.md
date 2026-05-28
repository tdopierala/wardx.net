# wardx.net

Tech blog about coding, AI, and new technologies. Built with Laravel, MariaDB, Bootstrap 5, and Docker.

## Tech Stack

- **Backend:** PHP 8.3 / Laravel 10
- **Database:** MariaDB 11
- **Frontend:** Bootstrap 5.3 (CDN), highlight.js, EasyMDE markdown editor
- **Containerization:** Docker Compose (nginx + php-fpm + mariadb)

## Quick Start

### Prerequisites

- Docker & Docker Compose
- Git

### Setup

```bash
# Clone the repository
git clone https://github.com/your-user/wardx.net.git
cd wardx.net

# Copy environment file
cp src/.env.example src/.env

# Start Docker containers
docker compose up -d

# Install PHP dependencies
docker compose exec php composer install

# Generate application key
docker compose exec php php artisan key:generate

# Run database migrations
docker compose exec php php artisan migrate

# Seed admin user
docker compose exec php php artisan db:seed

# Create storage symlink
docker compose exec php php artisan storage:link
```

### Access

- **Blog:** http://localhost:8080
- **Admin Panel:** http://localhost:8080/admin
- **Login:** admin@wardx.net / password

> Change the admin password after first login.

## Local Development (without Docker)

```bash
cd src

# Install dependencies
composer install

# Configure .env (set DB_HOST=127.0.0.1 and your local DB credentials)
cp .env.example .env
php artisan key:generate

# Run migrations and seed
php artisan migrate --seed
php artisan storage:link

# Start dev server
php artisan serve
```

## Project Structure

```
wardx.net/
  docker/                     # Docker configuration
    nginx/default.conf        # Nginx site config
    php/Dockerfile            # PHP-FPM image
    php/php.ini               # PHP settings
    mariadb/init.sql          # DB init script
  docker-compose.yml
  src/                        # Laravel application
    app/
      Http/Controllers/
        Admin/                # Admin CRUD controllers
        Auth/                 # Login controller
        PublicSite/           # Public blog controllers
      Models/                 # Eloquent models
      Services/               # MarkdownService
    database/
      migrations/             # DB schema
      seeders/                # Admin user seeder
    resources/views/
      admin/                  # Admin panel views
      auth/                   # Login view
      layouts/                # Base layouts (public + admin)
      public/                 # Public blog views
    routes/web.php            # All routes
```

## Features

### Public Blog
- Article listing with pagination
- Category and tag filtering
- Syntax-highlighted code blocks (highlight.js)
- Dark/light theme toggle
- RSS feed (`/feed`)
- XML sitemap (`/sitemap.xml`)
- SEO meta tags and Open Graph

### Admin Panel (`/admin`)
- Dashboard with article stats
- Article CRUD with EasyMDE markdown editor
- Image upload for featured images
- Category and tag management
- Draft/published workflow

## Database Schema

| Table | Description |
|-------|-------------|
| `users` | Admin user account |
| `categories` | Article categories |
| `tags` | Article tags |
| `articles` | Blog articles (markdown + rendered HTML) |
| `article_tag` | Many-to-many pivot |

## Configuration

Key `.env` variables for Docker:

```env
DB_HOST=mariadb
DB_DATABASE=wardx
DB_USERNAME=wardx
DB_PASSWORD=wardx
```

## License

MIT

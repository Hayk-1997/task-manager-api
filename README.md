# Project Name **Task-manager**

## Setting up the Project

1. Inside in Laradock folder` copy the `.env.example` file and rename it to `.env`:
   ```bash
   cp .env.example .env
   ```

2. Start the required Docker services:
   ```bash
   docker-compose up -d nginx mysql workspace mailhog
   ```

---

### 2. Environment Configuration (Laravel)

1. Navigate back to the root directory of your project.

2. Copy the Laravel `.env.example` file and rename it to `.env`:
   ```bash
   cp .env.example .env
   ```

3. Update the necessary environment variables in the `.env` file to match your Docker configuration (e.g., database
   credentials).

---

### 3. Workspace Access

To execute commands inside the Docker container for the workspace:

```bash
docker-compose exec --user=laradock workspace bash
```

Once inside the container, proceed with Laravel commands below.

---

### 4. Laravel Commands

Run the following commands to set up your Laravel application:

1. Migrate the database:
   ```bash
   php artisan migrate
   ```

2. Seed the database with default data:
   ```bash
   php artisan db:seed
   ```

3. Start the Laravel queue listener:
   ```bash
   php artisan queue:listen
   ```
---

## Admin Panel Credentials

Use the following credentials to access the admin panel for testing:

- **Email:** `admin@example.com`
- **Password:** `password`

Make sure to update these defaults after setup.

---

## Common Docker Commands

- Start services:
  ```bash
  docker-compose up -d nginx mysql workspace mailhog
  ```

- Stop all services:
  ```bash
  docker-compose down
  ```

- Access workspace:
  ```bash
  docker-compose exec --user=laradock workspace bash
  ```

---

## Troubleshooting Guide

### Common Issues

1. **Service not starting:** Ensure Docker is installed and running on your system.
2. **Database connection error:** Check your Laravel `.env` file and ensure database credentials match those in Laradock
   settings.
3. **Mailhog not accessible:** Confirm Mailhog is included in the running `docker-compose` services.

*(Add more solutions as needed)*

---

## Development Tools and Commands

- Laravel artisan tool:
  ```bash
  php artisan <command>
  ```

- Run migrations:
  ```bash
  php artisan migrate
  ```

- Run seeders:
  ```bash
  php artisan db:seed
  ```

- Queue management:
  ```bash
  php artisan queue:listen
  ```

---

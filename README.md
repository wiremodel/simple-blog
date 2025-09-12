## Refreshing Relation Manager tab badges after updating records in Filament

![Refreshing Relation Manager tab badges after updating records in Filament](./screenshots/refreshing-badges-after-updating-a-relation-manager.png)

Filament makes it easy to organize [Relation Managers](https://filamentphp.com/docs/4.x/resources/managing-relationships#relation-managers---interactive-tables-underneath-your-resource-forms) into tabs, complete with badges showing the record count.
But there's a catch: if you update records inside a [Relation Manager](https://filamentphp.com/docs/4.x/resources/managing-relationships#relation-managers---interactive-tables-underneath-your-resource-forms), those badges won't refresh automatically.

This article shows you how to fix that using [Livewire events](https://livewire.laravel.com/docs/events).

---

## Getting Started

Follow the steps below to clone and install this project locally.

### Clone the repository
```bash
git clone https://github.com/wiremodel/simple-blog.git
cd simple-blog
git checkout v4/refresh-badges
```

### Install PHP dependencies
```bash
composer install
```

### Install JavaScript dependencies
```bash
npm install
```

### Environment setup
- Copy the example environment file and generate the app key:
```bash
cp .env.example .env
php artisan key:generate
```

### Storage link (for public files like images)
```bash
php artisan storage:link
```

### Run migrations and seeders
This will create the tables and populate demo data (users, categories, posts, and 3 comments per post):
```bash
php artisan migrate --seed
```

If you need to reset everything and re-seed:
```bash
php artisan migrate:fresh --seed
```

### Build front-end assets
For local development (watches for changes):
```bash
npm run dev
```

### Serve the application
Using Laravel's built-in server:
```bash
php artisan serve
```
Visit http://127.0.0.1:8000 in your browser.

### Demo user

```text
test@example.com
```

```text
password
```

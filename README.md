## Relation Managers into form tabs using Livewire

![Relation Managers into form tabs using Livewire](./screenshots/rm-into-form-tabs.png)

In Filament, [Relation Managers](https://filamentphp.com/docs/4.x/resources/managing-relationships#relation-managers---interactive-tables-underneath-your-resource-forms) are typically used to manage related models on [Resource pages](https://filamentphp.com/docs/4.x/resources/overview). But there's a lesser-known trick: you can insert these [Relation Managers](https://filamentphp.com/docs/4.x/resources/managing-relationships#relation-managers---interactive-tables-underneath-your-resource-forms) directly into [form tabs](https://filamentphp.com/docs/4.x/schemas/tabs) using [Livewire](https://livewire.laravel.com/).

---

## Getting Started

Follow the steps below to clone and install this project locally.

### Clone the repository
```bash
git clone https://github.com/wiremodel/simple-blog.git
cd simple-blog
git checkout v4/relation-manager-form-tabs
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

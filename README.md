## Adding extra content to a field

![Adding extra content to a field](./screenshots/adding-extra-content-to-a-field.png)

Filament v4 provides many slots in [form fields](https://filamentphp.com/docs/4.x/forms/overview#form-fields) where you can insert additional content. These slots accept `text`, `schema components` and `actions`.

In this example, we'll add a live character counter to an excerpt textarea field. The counter will update dynamically with `JavaScript` and change color based on the remaining characters.

---

## Getting Started

Follow the steps below to clone and install this project locally.

### Clone the repository
```bash
git clone https://github.com/wiremodel/simple-blog.git
cd simple-blog
git checkout v4/js-content
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

## Filament Simple Blog
A simple blog example built with Laravel and Filament.

### Installation
Clone the repo locally and use the `relation-manager-form-tabs` branch.

Install PHP dependencies:

```bash
composer install
```

Setup configuration:

```bash
cp .env.example .env
```

_Configure the variables in the `.env` file according to your local environment._

### Database
Run database migrations:

```bash
php artisan migrate --seed
```

### Storage

Storage link:

```bash
php artisan storage:link
```

### Frontend
```bash
npm install && npm run dev
```

### Usage

After the project has been built, start Laravel's local development server using the Laravel's Artisan CLI serve command:
```bash
php artisan serve
```
The application will be accessible on

```bash
http://localhost:8000/admin
```

or access the project url configured according to your local environment

```bash
http://simple-blog.test/admin
```
### Admin Credentials
- Email: test@example.com
- Password: password

### Tests

You may run the following command in your terminal:

```bash
./vendor/bin/pest
```

### Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

### License
[MIT](https://choosealicense.com/licenses/mit/)

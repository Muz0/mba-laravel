# Laravel 10 CMS Application

A complete Content Management System built with Laravel 10, featuring an admin panel, API endpoints, and media management.

## Features

- **Admin Panel**: Complete CRUD operations for posts and media
- **Authentication**: Secure admin login with bcrypt password hashing
- **Media Management**: Upload and manage images and videos
- **API Endpoints**: RESTful API with JSON responses
- **File Uploads**: Support for images (JPG, PNG, GIF, WebP) and videos (MP4, WebM)
- **Responsive Design**: Modern UI with Tailwind CSS
- **Database**: MySQL with migrations and seeders

## Installation

1. **Clone and Install Dependencies**
   ```bash
   composer install
   ```

2. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database Configuration**
   
   Update your `.env` file with your MySQL credentials:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laravel_cms
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

   For shared hosting, you might need to update these values:
   ```
   DB_HOST=localhost
   DB_DATABASE=your_cpanel_database_name
   DB_USERNAME=your_cpanel_database_user
   DB_PASSWORD=your_database_password
   ```

4. **Run Migrations and Seeders**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Create Storage Symlink**
   ```bash
   php artisan storage:link
   ```

6. **Create Uploads Directory**
   ```bash
   mkdir public/uploads
   chmod 755 public/uploads
   ```

7. **Install Sanctum (for API authentication)**
   ```bash
   php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
   ```

## Usage

### Admin Panel Access

- **URL**: `/admin`
- **Default Credentials**:
  - Username: `admin`
  - Password: `password`

### API Endpoints

- `GET /api/v1/posts` - List all posts with pagination
- `GET /api/v1/posts/{id}` - Get single post with media
- `GET /api/v1/media` - List all media files

### File Upload Settings

The application supports:
- **Images**: jpg, jpeg, png, gif, webp (max 2MB for cover images)
- **Videos**: mp4, webm (max 20MB for media files)
- **Storage**: Files are stored in `/public/uploads`

## Database Structure

### Users Table
- `id` - Primary key
- `username` - Unique username
- `password_hash` - Bcrypt hashed password
- `role` - User role (admin)

### Posts Table
- `id` - Primary key
- `title` - Post title
- `slug` - URL-friendly slug (auto-generated)
- `content` - Post content
- `cover_image` - Cover image filename
- `author_id` - Foreign key to users table

### Media Table
- `id` - Primary key
- `filename` - File name
- `filepath` - File path
- `type` - Media type (image/video)
- `uploaded_at` - Upload timestamp
- `post_id` - Optional foreign key to posts table

## Development

### Running the Application

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

### Creating New Admin Users

You can create new admin users using the Laravel tinker:

```bash
php artisan tinker
```

```php
App\Models\User::create([
    'username' => 'newadmin',
    'password_hash' => 'newpassword',
    'role' => 'admin'
]);
```

### API Authentication with Sanctum

To use authenticated API routes, first generate a token:

```php
$user = App\Models\User::find(1);
$token = $user->createToken('api-token')->plainTextToken;
```

Then use the token in your API requests:
```
Authorization: Bearer {your-token}
```

## Deployment

### Shared Hosting Deployment

1. Upload all files except the `public` folder to your domain's root directory
2. Upload the contents of the `public` folder to your `public_html` directory
3. Update the `index.php` in `public_html` to point to the correct paths:
   ```php
   require_once __DIR__.'/../vendor/autoload.php';
   $app = require_once __DIR__.'/../bootstrap/app.php';
   ```
4. Set proper file permissions:
   ```bash
   chmod -R 755 storage bootstrap/cache
   ```
5. Update your `.env` file with production database credentials

### Production Optimizations

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

## Security Features

- CSRF protection on all forms
- SQL injection prevention through Eloquent ORM
- XSS protection via Blade templating
- File upload validation
- Admin-only access middleware
- Password hashing with bcrypt

## Support

If you encounter any issues:

1. Check that all dependencies are installed
2. Verify database connection settings
3. Ensure proper file permissions on storage directories
4. Check Laravel logs in `storage/logs/laravel.log`

## License

This project is open-sourced software licensed under the MIT license.
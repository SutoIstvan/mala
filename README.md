
## Mala.hu
- Laravel v11
- Bootstrap 5.3
- PHP v8.3
- MySQL v8.1

##  How To Deploy

- `git clone https://github.com/SutoIstvan/mala.git`
- `rename .env.example to .env`
- `chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache`
- `chmod -R 775 /var/www/storage /var/www/bootstrap/cache`
- `composer install`
- `php artisan key:generate`

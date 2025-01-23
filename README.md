<p align="center"><a href="https://laravel.com" target="_blank"><img src="public/assets/img/logo.png" width="200" alt="Laravel Logo"></a></p>

## Paks informatikai BT - Docker
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

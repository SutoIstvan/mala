<p align="center"><a href="https://mala.hu" target="_blank"><svg width="80" height="20" viewBox="0 0 402 97" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M95 0.0999756H0V95.1H89.5715L56.7989 59.6058L44.0391 78.6558L27 14.7778L85.4463 46.6089L63.7001 54.2648L95 88.1638V0.0999756Z" fill="#343f52"></path>
                <path d="M239.256 39.5854C246.154 31.939 256.221 29.2488 266.768 31.9979C281.835 35.9249 289.824 53.0969 281.532 68.8273M281.532 68.8273C279.179 73.2915 275.514 77.6395 270.328 81.5358C239.022 105.055 217.69 74.1701 240.279 61.3384C253.738 53.6934 270.616 57.5661 281.532 68.8273ZM281.532 68.8273C287.822 75.3169 292.133 84.2601 292.669 94.8668" stroke="#343f52" stroke-width="13"></path>
                <path d="M306.072 95.2V0H320.08V95.2H306.072Z" fill="#343f52"></path>
                <path d="M342.093 39.5861C348.991 31.9395 359.057 29.249 369.605 31.9978C384.671 35.9243 392.661 53.0961 384.369 68.8267M384.369 68.8267C382.016 73.2909 378.352 77.6391 373.166 81.5355C341.861 105.056 320.528 74.1715 343.117 61.3391C356.575 53.6937 373.453 57.5659 384.369 68.8267ZM384.369 68.8267C390.66 75.3161 394.971 84.2592 395.507 94.8658" stroke="#343f52" stroke-width="13"></path>
                <path d="M119 95.2V0H146.608L167.416 85.408H169.592L190.4 0H218.008V95.2H203.728V10.336H201.552L180.88 95.2H156.128L135.456 10.336H133.28V95.2H119Z" fill="#343f52"></path>
              </svg></a></p>

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

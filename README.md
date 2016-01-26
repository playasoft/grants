# weightlifter
A laravel app to create weighted questionaire systems


## Dependencies

1. A webserver that supports PHP (```nginx``` and ```php-fpm``` recommended)
2. ```mysql```
3. ```node.js``` and ```npm``` installed on your system
4. ```gulp``` installed globally (```npm install -g gulp```) or locally if you know what you're doing
5. ```composer```, the PHP package manager


## Installing

1. Git clone this repo
2. Set **laravel/public/** as your webserver's document root
3. Run ```composer install``` within the **laravel** folder
4. Run ```npm install``` within the **laravel** folder
5. Run ```php artisan migrate``` within the **laravel** folder


## Setup / Configuration

1. In the **laravel** folder, copy **.env.example** and rename it to **.env**
2. Configure your database settings in the **.env** file
3. Run ```gulp``` within the **laravel** folder


Great! Now the project is all set up. In the future, we may want to include compiled scripts and styles when we're ready for a release. This would remove the need for installing node.js, npm, and gulp.

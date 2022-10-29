<p align="center"><img src="resources/img/logo.png"></p>

A simple web crawler. 

## Technology Stack and Tools
 
 - Laravel 
 - Vue JS
 - MySQL
 - CSS Bootsrap
 - Axios HTTP Client
 - XML

## Set up Instruction
  - Clone the repo
  - CD into cloned directory and run  `touch .env` to create a new .env file
  - Copy all contents in .env.example into newly created .env file
  - Install composer  §composer install`
  - Install npm modules  `npm install`
  - Generate a new for development purposes.
        <p> `php artisan key:generate`  to  </p>
  - Open PHPMyAdmin or whichever tool you use and create a new mysql database
  - Open .env and add db credentials
  - Clear config cache with `php artisan cache:clear`
  - Run migrations with `php artisan migrate`

## Web crawling
 - Crawl news content with  `php artisan web:crawl` 
 
<p align="center"><img src="resources/images/snapshot.jpeg"></p>
<p align="center"><img src="resources/images/snapshot.gif"></p>
 
## License

This software is open-sourced software and licensed under the [MIT license](https://opensource.org/licenses/MIT).

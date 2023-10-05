## Products App

## Main configurations you need for running this app
- For windows:
  - Xampp or lamp server
  - PHP 8.0 or greater
  - MySQL 8.0 or greater
  - Laravel 8.75
- For Linux:
  - PHP 8.0 or greater
  - Apache2
  - MySQL 8.0 or greater
  - Laravel 8.75

## Laravel setup

Here's how do the basic setup for any laravel app:
- You copy the .env.example file into .env if it doesn't already exist
- You need to create a database and enter the database name and hosting information under DB_DATABASE, DB_USERNAME, DB_PASSWORD, DB_PORT and DB_HOST fields in .env file
- php artisan migrate --seed
- php artisan serve
#### Next thing is how to get to run the api endpoints:

- Access the login route with "/login" with fields like: email: user@users.com, password: password in order to get the access token
- Copy the token into the header of your postman or other application that you might use in the format: "Authorization": "Bearer {paste the token here}"
- Access the route you wish

### Here is an example how we can access the routes:
1 - being the id of the product we are accessing/updating/deleting
  #### TYPE OF REQUEST ......  ROUTE
- GET ......................... /products/1
- PUT........................... /products/1 with fields: name: 'some name': description': 'some description', price: 10
- DELETE ................... /products/1 
- POST ....................... /products with fields: name: 'new name', description: 'new description': price: 20

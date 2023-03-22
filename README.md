# QR Tool

Qr Tool is a web application built in Laravel 9. Main function of the application are the following:
* Generate qr code
* Scan qr code using a scanner(tested scanner from Honeywell)
* Print qr code in pdf form
* Download qr code as image

# Tech used:
* PHP8.1(Larvel 9)
* TailwindCSS
* Livewire
* Javascript
* MySQL


# Installation & Configuration

This guide will help you set up a Laravel project with PHP 8.1 on your local machine.

Before you begin, ensure that you have the following software installed on your machine:
* PHP 8.1
* Composer
* Git
* Node.js
* NPM

## Clone the Project
To clone the project, open a terminal window and navigate to the directory where you want to save the project. Then run the following command:

```bash
git clone <project-url>
```

## Install Dependencies
Once you have cloned the project, navigate to the project root directory and run the following command to install the project dependencies:

```bash
composer install
```

## Create Environment File
Next, create a new .env file by copying the .env.example file:

```bash
cp .env.example .env
```

Then generate a new application key:

```bash
php artisan key:generate
```

## Configure the Database
Edit the .env file and set the database connection details:

```makefile
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<database-name>
DB_USERNAME=<database-username>
DB_PASSWORD=<database-password>
```

## Migrate the Database
To migrate the database, run the following command:

```bash
php artisan migrate
```

## Start the Development Server
To start the development server, run the following command:

```bash
php artisan serve
```

## Compile Assets
To compile the project assets, run the following command:

```bash
npm install
npm run dev
```

## Contributing

Pull requests are welcome. For major changes, please open an issue first
to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License

[MIT](https://choosealicense.com/licenses/mit/)

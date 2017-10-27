Sample CRM Project

This project is a sample CRM that contains ability to add, edit, and delete Clients, Products, Merchant Accounts (MIDs), and Order information.

Installation

Simply download the project, open a terminal and run composer install.  Create a localhost database called crm with a user 'root' with no password.  You can customize this in your .env file as well.  Once an empty database is created and connected to the application, return to the terminal and type 'php artisan migrate:fresh --seed'.  This will create all database tables required and fill them with some basic demo information.

Running Unit Tests

Some basic unit tests are included.  From the terminal, type phpunit from the root folder of the application.  All tests will be run and results will be displayed.  If your locally installed version of phpunit cannot be run with php 7 or other installed components, please use the projects version of php located in the vendor folder by typing 'php vendor/phpunit/phpunit/phpunit' from the root of the application in the terminal.
Sample CRM Project

This project is a sample CRM that contains ability to add, edit, and delete Clients, Products, Merchant Accounts (MIDs), and Order information.

Installation

Simply download the project, open a terminal and run composer install.  Create a localhost database called crm with a user 'root' with no password.  You can customize this in your .env file as well.  Once an empty database is created and connected to the application, return to the terminal and type 'php artisan migrate:fresh --seed'.  This will create all database tables required and fill them with some basic demo information.
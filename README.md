Sample CRM Project

This project is a sample CRM that contains ability to add, edit, and delete Clients, Products, Merchant Accounts (MIDs), and Order information.

Installation

Simply download the project, open a terminal and run composer install.  Create a localhost database called crm with a user 'root' with no password.  You can customize this in your .env file as well.  Once an empty database is created and connected to the application, return to the terminal and type 'php artisan migrate:fresh --seed'.  This will create all database tables required and fill them with some basic demo information.

Running Unit Tests

Some basic unit tests are included.  From the terminal, type phpunit from the root folder of the application.  All tests will be run and results will be displayed.  If your locally installed version of phpunit cannot be run with php 7 or other installed components, please use the projects version of php located in the vendor folder by typing 'php vendor/phpunit/phpunit/phpunit' from the root of the application in the terminal.

Signing In

Using the default included user, you can sign in with 'test@test.com' as the email and 'test1234' as the password.  The system uses the built in laravel 5.5 oauth2 authentication.  You can logout by clicking the drop down at the top right once inside the application and clicking 'Logout'.

Uploading Records

Each page will allow you to upload large records via a CSV mapping utility that allows you to map each column to an individual datatabes table column for the associated record.  To prevent this task from becoming tedious, you can save formats as you create them and load them later so that if you get CSV data from certain sources in certain formats, once the format has been created, you do not have to map that particular format of CSV again.

You may also add records one at a time by clicking the Add Record button above the datatables on each record page.  When adding products, they must be added one at a time because those records require file content to be provided (cover letters, order pages, and terms and conditions) and this must be provided through our bootstrap WYSIWYG HTML Editor.

HTML Editor

In order to provide order page screenshots or other information related to the products for the purpose of internal information and external information exports and faxing, when adding products you must attach that content via the built in bootstrap WYSIWYG HTML Editor.  This is a simple editor that allows adjusting and formating of text, adding hyperlinks, and uploading screenshots.

Changing Date Ranges

On the dashboard and order pages, you may change the date range via the bootstrap date range picker inputs at the top of each section.  Results will be returned only within the range provided.

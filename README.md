# task-management-system- Setup Instructions

This is a Laravel 11+ application developed using PHP 8.3 for managing tasks via RESTful APIs. Follow the steps below to set up the project on your local machine.

## Prerequisites

PHP 8.3+
Composer
MySQL

## Setup Steps

1. Clone the repository 

2. Install dependencies
 
   composer install

3. Configure the .env file
  
  Update your database credentials and other necessary environment variables:
  
  DB_DATABASE=your_db_name
  DB_USERNAME=your_username
  DB_PASSWORD=your_password

  Update the mail credentials

   MAIL_MAILER=smtp
   MAIL_ENCRYPTION=tls
   MAIL_HOST=sandbox.smtp.mailtrap.io
   MAIL_PORT=587
   MAIL_USERNAME=Your Usenname
   MAIL_PASSWORD=Your Password

4. Run the databse migration

   php artisan migrate

5. Start the Laravel development server

   php artisan serve

6. Run the que worker (for email and jobs)
 
   php artisan queue:work

7. Schedule task expiry 

  Add the following cron entry to your system to run the Laravel Scheduler every minute

  * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1

  To run locally

  php artisan schedule:work


##  Testing the API

  You can test the API using tools like Postman, Insomnia, or Thunder Client.

  Default API Endpoints
   POST /api/register — Register

   POST /api/login — Login

   POST /api/tasks — Create Task (auth required)

   PUT /api/tasks/{id}/assign — Assign Task

   PUT /api/tasks/{id}/complete — Complete Task

   GET /api/tasks — List Tasks (filters supported)

   All protected routes(Create and assign tasks) require a Bearer token in the Authorization header after login.

   Task status updates to expired automatically if the due date has passed.







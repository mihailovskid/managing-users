## Darko Mihailovski FS13 - Laravel Manage Users

## Installation
To test this application it is necessary to install the application by typing the command:

`composer install`

In the .env file you need to enter your information from the database

```
- DB_CONNECTION=
- DB_HOST=
- DB_PORT=
- DB_DATABASE=
- DB_USERNAME=
- DB_PASSWORD=
```


Run the next command to create the database tables:

`php artisan migrate`

To fill the database run the next command:

`php artisan db:seed`

To login to the application:
```
Email: admin@live.com
Password: admin123
```
## Mailtrap

To test Mailtrap, you need to log in at this link
- https://mailtrap.io/

then in the .env file you need to enter your configuration from Mailtral

```- MAIL_MAILER=
- MAIL_HOST=
- MAIL_PORT=
- MAIL_USERNAME=
- MAIL_PASSWORD=
- MAIL_ENCRYPTION=
- MAIL_FROM_ADDRESS=
- MAIL_FROM_NAME=
```

When the administrator creates a user who is not active, the email address receives an email with a link with which he can activate his account and log in.

link to install Mailtrap
- https://mailtrap.io/blog/send-email-in-laravel/

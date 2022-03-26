## Practical Test

As mention before I'm not Full stack guy. so I'm not done UI part. 

I'm not used docker because of issue in my personal PC.

Follow these interactions to check my work

To install composer

- ``composer install``

To run this project

- ``php artisan serve``

To install passport

- ``php artisan passport:install``

Then You can check API [Documentation](http://127.0.0.1:8000/api/documentation) page

- First register user 
- Then login using that user
- Then copy user token
- In documentation, you can see ``Authorize`` Button
- Click it and add token like this format ``Bearer --token--``
- then you can check customer CRUD

To run test

- ``php artisan test``

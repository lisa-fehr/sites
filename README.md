My resume site. Features a package that will allow you to create a pixel image then send it to twitter and my microcontroller oled screen. It is my first attempt at a package in Laravel 5.4.

*Notes:*

Package needs thujohn/twitter:
https://github.com/thujohn/twitter

Use this macro in a custom layout:
```php
{!! Form::warfehr_oled_form() !!}
```
Package needs an /image folder in public to store images.

*Tests:*
```
vendor/bin/phpunit packages/warfehr/omega_oled_msg/tests/Feature/FeatureTest.php 
```

*Pending Goals:*
- set up a queue for the image and twitter handlers
- require thujohn/twitter in warfehr package vs main laravel project
- move Validation to its own file
- try vendor:publish for the package config file
- set up HTML::link or similar
- store images somewhere else
- error handling on event handlers
- bigger oled screen
- make a published package

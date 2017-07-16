My resume site. Features a package that will allow you to create a pixel image then send it to twitter and my microcontroller oled screen. It is my first attempt at a package in Laravel 5.4.

*Notes:*

Package uses thujohn/twitter. Use the instructions here to set it up:
https://github.com/thujohn/twitter

Modify the config file in packages/warfehr/omega_oled_msg with your oled size and twitter handle.

Use this macro in a custom layout if you use the package separately:
```php
{!! Form::warfehr_oled_form() !!}
```
Package needs an /image folder in public to store images generated with the oled form.

*Tests:*
```
vendor/bin/phpunit packages/warfehr/omega_oled_msg/tests 
```

*Pending Goals:*
- set up a queue for the image and twitter handlers (currently in branch: queue_code)
- try vendor:publish for the package config file
- set up HTML::link or similar
- store images somewhere else
- bigger oled screen
- make a published package

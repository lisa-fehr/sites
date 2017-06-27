My resume site. Features a package that will allow you to create a pixel image then send it to twitter and my microcontroller oled screen. It is my first attempt at a package in Laravel 5.4.

Package needs thujohn/twitter:
https://github.com/thujohn/twitter

Tests:

vendor/bin/phpunit packages/warfehr/omega_oled_msg/tests/Feature/FeatureTest.php 

Goals:
- set up a queue for the image and twitter handlers
- require thujohn/twitter in warfehr package vs main laravel project
- move Validation to its own file
- try vendor:publish for the package config file
- set up HTML::link or similar 
- bigger oled screen
- make a published package

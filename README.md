# Get weather information about given location using artisan cli

This is a console project that gets current weather information of any city over the world and displays it in the console or sends it to given email/telegram chat.

## Requirements
* Laravel 10+
* php 8.0+

## Installation

1. `composer install`
2. `php artisan key:generate`
3. copy necessary environment values from `.env.example` to `.env` file
4. Run `php artisan queue:work` artisan command (The queue works with sending current weather data to an email and a telegram)

## Usage

The main command is: `weather`
The command receives three arguments: 
* `provider` - weather provider api name
* `city` - the name of the city you want to know about the weather
* `--channel` option - place where you want to display. Default value is `console`.
  * `console`
  * `email:[email_address]`
  * `telegram:[chat_id]`

## Usage examples

* `php artisan weather weather-api Tashkent`
* `php artisan weather visual-crossing Tashkent --option=email:anyemail@gmail.com`
* `php artisan weather weather-api London --option=telegram:any_chat_id`

Don't forget to run queue worker before using the command

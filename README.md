# Laravel 5 package for EVATR - Validating VAT IDs

[![Latest Stable Version](https://poser.pugx.org/codedge/laravel-bzst-evatr/v/stable?format=flat-square)](https://packagist.org/packages/codedge/laravel-bzst-evatr)
[![Build Status](https://travis-ci.org/codedge/laravel-bzst-evatr.svg?branch=master)](https://travis-ci.org/codedge/laravel-bzst-evatr)
[![StyleCI](https://styleci.io/repos/61383981/shield)](https://styleci.io/repos/61383981)
[![License](https://poser.pugx.org/codedge/laravel-bzst-evatr/license?format=flat-square)](https://packagist.org/packages/codedge/laravel-bzst-evatr)

This library is a wrapper for the XmlRPC interface to validate European VAT IDs.  
See https://evatr.bff-online.de/eVatR/xmlrpc/ (German version).

With this library you can check an European VAT ID if it is valid. Additionally you can pass in and address of
this European VAT ID and do an address check.

The library supports the _simple_ and the _qualified_ request.

* Simple request: 
  * Checks if a certain foreign VAT ID is valid at the time the request is made.
* Qualified request:
  * Additionally checks if the address (company name, street, city and zip code) connected to the VAT ID matches with registered data in the foreign country. 

All error messages are available in English or German - of course you can modify those as you like.

## Install with Composer
To install the library using [Composer](https://getcomposer.org/):
```sh
$ composer require codedge/laravel-bzst-evatr
```

This adds the _codedge/laravel-bzst-evatr_ package to your `composer.json` and downloads the project.

Next run:
`php artisan vendor:publish` 
to publish the translation files of the library to `resources/lang/vendor/evatr/<locale>/messages.php`. 

Don't forget to add the _Service Provider_ to your `config/app.php` `[1]` and optionally the _facade_ `[2]`:
```php
// config/app.php

return [

    //...
    
    'providers' => [
        // ...
        
        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        Codedge\Evatr\EvatrServiceProvider::class, // [1]
    ],
    
    // ...
    
    'aliases' => [
        'App' => Illuminate\Support\Facades\App::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        
        // ...
        
        'View' => Illuminate\Support\Facades\View::class,
        'Evatr' => Codedge\Evatr\Facades\Evatr::class, // [2]

]
```

## Usage
If using the facade, just do:
```php

// app/Http/routes.php

Route::get('/', function () {

    Evatr::setOwnUstId('123');      // Or use an alias: Evatr::setUstId1('123');
    Evatr::setForeignUstId('123');  // Or use an alias: Evatr::setUstId2('123');
    
    Evatr::query(); // Fires the XmlRpc call

    echo 'Error code: ' . Evatr::getResponse()->getErrorCode();
    echo 'Error message: ' . Evatr::getResponse()->getErrorMessage();

    echo 'Date: ' . Evatr::getResponse()->getDate();
    echo 'Time: ' . Evatr::getResponse()->getTime();

});
```

Alternatively you can use the dependency injection of the singleton instance like so:
```php

// app/Http/routes.php

Route::get('/', function (Codedge\Evatr\Evatr $evatr) {

    $evatr->setOwnUstId('123')
          ->setForeignUstId('123')
          ->query(); // Fires the XmlRpc call

    echo 'Error code: ' . $evatr->getResponse()->getErrorCode();     // Get the interface error code
    echo 'Error message: ' . $evatr->getResponse()->getErrorMessage();  // Get the interface error message
    
    echo 'Date: ' . $evatr->getResponse()->getDate();
    echo 'Time: ' . $evatr->getResponse()->getTime();

});
```

All date and time methods return a [Carbon](http://carbon.nesbot.com/) instance for better and further handling.  

### Request - Available methods and fields

Depending if you want to send a _simple_ or _qualified_ request please see what parameters need to be set:

| Field name     | Description                   | Simple request | Qualified request | Method name                   |
| -------------- | ----------------------------- | :------------: | :---------------: | ----------------------------- |
| Own VAT ID     | Your German VAT ID            |        x       |          x        | setOwnUstId, _alias_: setUstId1 |
| Foreign VAT ID | The requested VAT ID          |        x       |          x        | setForeignUstId, _alias_: setUstId2 |
| Company name   | Name of the requested company |                |          x        | setCompanyName |
| City           | City of the requested company |                |          x        | setCityName    |
| Zip code       | Zip code of the req. company  |                |        optional   | setZipCode     |
| Street         | Street of the req. company    |                |        optional   | setStreet      |
| Print conf.    | Official confirmation msg     |                |        optional   | setPrintConfirmation |

### Response - Available methods and fields
Additionally to the response field the response returns the following fields:

| Field name    | Description                                                    | Method name      |
| ------------- | -------------------------------------------------------------- | ---------------- |
| Error Code    | [See avail. error codes](resources/lang/en/messages.php)       | getErrorCode     |
| Error Message | [See avail. error messages](resources/lang/en/messages.php)    | getErrorMessage  |
| Date          | Date of the request                                            | getDate          |
| Time          | Time of the request                                            | getTime          |
| Valid from    | Start date of validity of the foreign VAT ID. Only filled with error code 203 and 204. | getValidFrom |
| Valid until   | End date of validity of the foreign VAT ID. Only filled with error code 204. | getValidUntil |
| Erg_Name   | Result for the requested company name     | getResponseCompany |
| Erg_City   | Result for the requested company city     | getResponseCity    |
| Erg_Street | Result for the requested company street   | getResponseStreet  |
| Erg_PLZ    | Result for the requested company zip code | getResponseZipCode |

Each of these result fields can have one of the following results:

| Result  | Description                        |
| :-----: | ---------------------------------- |
| A       | Matches the requested value        |
| B       | Does not match the requested value |
| C       | Not requested                      |
| D       | Not provided by EU member state    |
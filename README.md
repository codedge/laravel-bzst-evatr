# Laravel 5 package for EVATR - Validating VAT IDs
This library is a wrapper for the XmlRPC interface to validate European VAT IDs.
See https://evatr.bff-online.de/eVatR/xmlrpc/ (German version).

With this library you can check an European VAT ID if it is valid. Additionally you can pass in and address of
this European VAT ID and do an address check.

## Install with Composer
To install the library using [Composer](https://getcomposer.org/):
```sh
$cd <YOUR LARAVEL PROJECT ROOT>
$ composer require codedge/laravel-bzst-evatr:"dev-master"
```

This adds the _codedge/laravel-bzst-evatr_ package to your `composer.json` and downloads the project.

Next run:
`php artisan vendor:publish` 
to publish the translation files of the library to `resources/lang/vendor/<locale>/messages.php`. 

## Usage
If using the facade, just do:
```php

// app/Http/routes.php

Route::get('/', function () {

    Evatr::setOwnUstId('123');
    Evatr::setForeignUstId('123');
    Evatr::query(); // Fires the XmlRpc call

    echo Evatr::getResponse()->getErrorCode();
    echo Evatr::getResponse()->getErrorMessage();

});
```

Alternatively you can use the dependency injection of the singleton instance like so:
```php

// app/Http/routes.php

Route::get('/', function (Codedge\Evatr\Evatr $evatr) {

    $evatr->setOwnUstId('123')
          ->setForeignUstId('123')
          ->query(); // Fires the XmlRpc call

    echo $evatr->getResponse()->getErrorCode();
    echo $evatr->getResponse()->getErrorMessage();

});
```

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
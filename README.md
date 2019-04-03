# OpenLRW - PHP Api Client

> The easier way to implement OpenLRW into your PHP applications (the documentation is not finished)

This API Client was inspired by the Laravel Framework, it allows you to do HTTP requests to the OpenLRW API but also to manipulate objects from these requests.

<p align="center">
<img src="https://scrutinizer-ci.com/g/Apereo-Learning-Analytics-Initiative/OpenLRW-php-api-client/badges/quality-score.png?b=master" title="Scrutinizer Code Quality">
<img src="https://poser.pugx.org/openlrw/api-client/v/stable" alt="stable version">
<img src="https://poser.pugx.org/openlrw/api-client/downloads" alt="downloads counter">
</p>

## Requirements
 - PHP >= 5.6
 
 
## Install
`$ composer require openlrw/api-client`


## Usage

### Initialize the client
```php
use OpenLRW\OpenLRW;

$client = new OpenLRW(URL, KEY, PASSWORD);
```

### Using OneRoster Model
> Example with the User collection

#### Get an entity
```php
$user = User::find('foo-bar');
echo $user->sourcedId; // return 'foo-bar'
```

#### Delete
```php
$user = User::find('foo-bar');
$user->delete(); // User deleted

// Or

User::destroy('foo-bar);

```


### Helpers
#### Check if the server is up
```php
$isServerUp = OpenLRW::isUp();
```


## Execute tests

> Since it is an API Client, you will have to edit the credentials in order to log onto the API

```bash
\vendor\bin\phpunit.bat --bootstrap vendor\autoload.php  tests\ApiClientTest.php
```

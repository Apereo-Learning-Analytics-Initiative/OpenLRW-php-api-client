# OpenLRW - PHP Api Client

> The easiest way to implement OpenLRW into your PHP applications (the documentation is not finished)

Client aimed to request the OpenLRW API in an easy way but also to manipulate objects from these requests.

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

#### Check if the server is up
```php
$isServerUp = OpenLRW::isUp();
```


### Generate a JSON Web Token
```php
OpenLRW::generateJwt();
```

### OneRoster objects
> All the OneRoster models are not yet implemented, send an issue to let us know if you need a new collection

#### Example of the basic functions with the User Collection
> All the OneRoster models have those functions

```php
// Get and edit a user
$user = User::find('foobar');
$user->status = 'active';
$user->save();


// Create a new user
$user = new User();
$user->sourcedId = 'foo';
$user->name = 'bar';
$user->status 'inactive';
$user->save();

// Delete a user
$user->delete(); /** or */ User::destroy('foo-bar');

// Get all the users
$users = Users::all(); 
```

### Some examples of the specific functions per class
> Check the classes to know all those specific functions

```php
/** Klass model */
$enrollments = Klass::enrollments($classId); // array
$events = Klass::events($classId); // array
// ...

/** Risk */
$latestRisk = Risk::latestByClassAndUser($classId, $userId); // Risk::class
// ...

```

### Generic usage

```php
$user = OneRoster::httpGet('users/test2u'); // return an array

$jsonInArray = ['...'];
$response = OneRoster::httpPost('users', $jsonInArray);
```

### Helpers

## Execute tests

> Since it is an API Client, you will have to edit the credentials in order to log onto the API

```bash
\vendor\bin\phpunit.bat --bootstrap vendor\autoload.php  tests\ApiClientTest.php
```

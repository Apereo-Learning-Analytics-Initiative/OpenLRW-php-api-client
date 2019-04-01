# OpenLRW - PHP Api Client

> The easier way to implement OpenLRW into your PHP applications

<p align="center">
<img src="https://scrutinizer-ci.com/g/Apereo-Learning-Analytics-Initiative/OpenLRW-php-api-client/badges/quality-score.png?b=master" title="Scrutinizer Code Quality">
<img src="https://poser.pugx.org/openlrw/api-client/v/stable" alt="stable version">
<img src="https://poser.pugx.org/openlrw/api-client/downloads" alt="downloads counter">
</p>

## Requirements

## Install
`$ composer require openlrw/api-client`


## Usage

#### Initialize the client
```php
use OpenLRW\OpenLRW;

$client = new OpenLRW(URL, KEY, PASSWORD);
```

#### Check if the server is up
```php

$isUp = OpeLRW::isUp();
// or
$isUp = $client::isUp();
```


## Execute tests

> Since it is an API Client, you will have to edit the credentials in order to log onto the API

```bash
\vendor\bin\phpunit.bat --bootstrap vendor\autoload.php  tests\ApiClientTest.php
```